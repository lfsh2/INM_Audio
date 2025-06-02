<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'order_id';

    protected $allowedFields = [
        'user_id', 'product_id', 'order_status', 'quantity', 'price', 
        'payment_method', 'delivery_date', 'date_completed',
        'date_returned', 'date_cancelled', 'created_at','shipping_name', 'shipping_phone', 'shipping_address',
        'is_custom_iem', 'custom_details'
    ];

    protected $useTimestamps = false;  


    public function getUserOrdersWithProducts($userId)
    {
        $db = \Config\Database::connect();
        
        // Get regular product orders
        $regularOrdersBuilder = $db->table('orders');
        $regularOrdersBuilder->select('orders.*, products.product_name, products.image_url');
        $regularOrdersBuilder->join('products', 'products.product_id = orders.product_id', 'left');
        $regularOrdersBuilder->where('orders.user_id', $userId);
        $regularOrdersBuilder->where('orders.is_custom_iem', 0); // Only regular product orders
        $regularOrdersBuilder->orderBy('orders.created_at', 'DESC');
        $regularOrders = $regularOrdersBuilder->get()->getResultArray();
        
        // Get custom IEM orders
        $customIEMOrdersBuilder = $db->table('orders');
        $customIEMOrdersBuilder->select('orders.*, iem_customizations.design_name as product_name, "Custom IEM" as series, iem_customizations.category');
        $customIEMOrdersBuilder->join('iem_customizations', 'iem_customizations.id = orders.product_id', 'left');
        $customIEMOrdersBuilder->where('orders.user_id', $userId);
        $customIEMOrdersBuilder->where('orders.is_custom_iem', 1); // Only custom IEM orders
        $customIEMOrdersBuilder->orderBy('orders.created_at', 'DESC');
        $customIEMOrders = $customIEMOrdersBuilder->get()->getResultArray();
        
        // Merge and sort by created_at date
        $allOrders = array_merge($regularOrders, $customIEMOrders);
        usort($allOrders, function($a, $b) {
            return strtotime($b['created_at']) - strtotime($a['created_at']);
        });
        
        return $allOrders;
    }
    
    public function getUserCustomIEMOrders($userId)
    {
        $db = \Config\Database::connect();
        
        $builder = $db->table('orders');
        $builder->select('orders.*, iem_customizations.design_name, iem_customizations.category');
        $builder->join('iem_customizations', 'iem_customizations.id = orders.product_id', 'left');
        $builder->where('orders.user_id', $userId);
        $builder->where('orders.is_custom_iem', 1); // Only custom IEM orders
        $builder->orderBy('orders.created_at', 'DESC');
        
        return $builder->get()->getResultArray();
    }
    
    public function getUserOrdersByStatus($userId, $status)
    {
        $db = \Config\Database::connect();
        
        // Get regular product orders with this status
        $regularOrdersBuilder = $db->table('orders');
        $regularOrdersBuilder->select('orders.*, products.product_name, products.image_url');
        $regularOrdersBuilder->join('products', 'products.product_id = orders.product_id', 'left');
        $regularOrdersBuilder->where('orders.user_id', $userId);
        $regularOrdersBuilder->where('orders.order_status', $status);
        $regularOrdersBuilder->where('orders.is_custom_iem', 0); // Only regular product orders
        $regularOrdersBuilder->orderBy('orders.created_at', 'DESC');
        $regularOrders = $regularOrdersBuilder->get()->getResultArray();
        
        // Get custom IEM orders with this status
        $customIEMOrdersBuilder = $db->table('orders');
        $customIEMOrdersBuilder->select('orders.*, iem_customizations.design_name as product_name, "Custom IEM" as series, iem_customizations.category');
        $customIEMOrdersBuilder->join('iem_customizations', 'iem_customizations.id = orders.product_id', 'left');
        $customIEMOrdersBuilder->where('orders.user_id', $userId);
        $customIEMOrdersBuilder->where('orders.order_status', $status);
        $customIEMOrdersBuilder->where('orders.is_custom_iem', 1); // Only custom IEM orders
        $customIEMOrdersBuilder->orderBy('orders.created_at', 'DESC');
        $customIEMOrders = $customIEMOrdersBuilder->get()->getResultArray();
        
        // Merge and sort by created_at date
        $allOrders = array_merge($regularOrders, $customIEMOrders);
        usort($allOrders, function($a, $b) {
            return strtotime($b['created_at']) - strtotime($a['created_at']);
        });
        
        return $allOrders;
    }
   
    public function getTotalOrders()
    {
        return $this->countAll();
    }
    
    public function getTotalCustomIEMOrders()
    {
        return $this->where('is_custom_iem', 1)->countAllResults();
    }

    public function getTotalConfirmed()
    {
        return $this->where('order_status', 'delivered')->countAllResults();
    }

    
    public function getTotalCancelled()
    {
        return $this->where('order_status', 'cancelled')->countAllResults();
    }

    public function getTotalComplete()
    {
        return $this->where('order_status', 'completed')->countAllResults();
    }

    public function getTotalRevenue() {
        return $this->select('SUM(quantity * price) AS totalRevenue')
                    ->whereIn('order_status', ['delivered', 'complete'])
                    ->get()
                    ->getRow()
                    ->totalRevenue ?? 0;
    }
    
    public function getTotalCustomIEMRevenue() {
        return $this->select('SUM(quantity * price) AS totalRevenue')
                    ->whereIn('order_status', ['delivered', 'complete'])
                    ->where('is_custom_iem', 1)
                    ->get()
                    ->getRow()
                    ->totalRevenue ?? 0;
    }
    

    public function getRecentOrders($limit = 5)
    {
        $db = \Config\Database::connect();
        
        // Get regular product orders
        $regularOrdersBuilder = $db->table('orders');
        $regularOrdersBuilder->select('orders.*, products.product_name');
        $regularOrdersBuilder->join('products', 'products.product_id = orders.product_id', 'left');
        $regularOrdersBuilder->where('orders.is_custom_iem', 0);
        $regularOrdersBuilder->orderBy('orders.created_at', 'DESC');
        $regularOrdersBuilder->limit($limit);
        $regularOrders = $regularOrdersBuilder->get()->getResultArray();
        
        // Get custom IEM orders
        $customIEMOrdersBuilder = $db->table('orders');
        $customIEMOrdersBuilder->select('orders.*, iem_customizations.design_name as product_name, "Custom IEM" as product_type, iem_customizations.category');
        $customIEMOrdersBuilder->join('iem_customizations', 'iem_customizations.id = orders.product_id', 'left');
        $customIEMOrdersBuilder->where('orders.is_custom_iem', 1);
        $customIEMOrdersBuilder->orderBy('orders.created_at', 'DESC');
        $customIEMOrdersBuilder->limit($limit);
        $customIEMOrders = $customIEMOrdersBuilder->get()->getResultArray();
        
        // Merge and sort by created_at date
        $allOrders = array_merge($regularOrders, $customIEMOrders);
        usort($allOrders, function($a, $b) {
            return strtotime($b['created_at']) - strtotime($a['created_at']);
        });
        
        // Return only the first $limit orders
        return array_slice($allOrders, 0, $limit);
    }
    public function getOrdersByMonth($month) {
        return $this->where('MONTH(created_at)', $month)
                    ->countAllResults();
    }
    
    public function getCustomIEMOrdersByMonth($month) {
        return $this->where('MONTH(created_at)', $month)
                    ->where('is_custom_iem', 1)
                    ->countAllResults();
    }
    
    
    public function getRevenueByMonth($month) {
        return $this->selectSum('price', 'total_price')
                    ->where('MONTH(created_at)', $month)
                    ->whereIn('order_status', ['delivered', 'complete'])
                    ->get()->getRow()->total_price ?? 0;
    }
    
    public function getCustomIEMRevenueByMonth($month) {
        return $this->selectSum('price', 'total_price')
                    ->where('MONTH(created_at)', $month)
                    ->where('is_custom_iem', 1)
                    ->whereIn('order_status', ['delivered', 'complete'])
                    ->get()->getRow()->total_price ?? 0;
    }
      public function getConfirmedOrders()
      {
          $db = \Config\Database::connect();
          
          // Get regular product orders to ship
          $regularOrdersBuilder = $db->table('orders');
          $regularOrdersBuilder->select('orders.*, products.product_name');
          $regularOrdersBuilder->join('products', 'products.product_id = orders.product_id', 'left');
          $regularOrdersBuilder->where('orders.order_status', 'to ship');
          $regularOrdersBuilder->where('orders.is_custom_iem', 0);
          $regularOrders = $regularOrdersBuilder->get()->getResultArray();
          
          // Get custom IEM orders to ship
          $customIEMOrdersBuilder = $db->table('orders');
          $customIEMOrdersBuilder->select('orders.*, iem_customizations.design_name as product_name, "Custom IEM" as product_type, iem_customizations.category');
          $customIEMOrdersBuilder->join('iem_customizations', 'iem_customizations.id = orders.product_id', 'left');
          $customIEMOrdersBuilder->where('orders.order_status', 'to ship');
          $customIEMOrdersBuilder->where('orders.is_custom_iem', 1);
          $customIEMOrders = $customIEMOrdersBuilder->get()->getResultArray();
          
          // Merge and sort by created_at date
          $allOrders = array_merge($regularOrders, $customIEMOrders);
          usort($allOrders, function($a, $b) {
              return strtotime($b['created_at']) - strtotime($a['created_at']);
          });
          
          return $allOrders;
      }
  
      public function getAllOrders()
      {
          $db = \Config\Database::connect();
          
          // Get regular product orders
          $regularOrdersBuilder = $db->table('orders');
          $regularOrdersBuilder->select('orders.*, products.product_name');
          $regularOrdersBuilder->join('products', 'products.product_id = orders.product_id', 'left');
          $regularOrdersBuilder->where('orders.is_custom_iem', 0);
          $regularOrders = $regularOrdersBuilder->get()->getResultArray();
          
          // Get custom IEM orders
          $customIEMOrdersBuilder = $db->table('orders');
          $customIEMOrdersBuilder->select('orders.*, iem_customizations.design_name as product_name, "Custom IEM" as product_type, iem_customizations.category');
          $customIEMOrdersBuilder->join('iem_customizations', 'iem_customizations.id = orders.product_id', 'left');
          $customIEMOrdersBuilder->where('orders.is_custom_iem', 1);
          $customIEMOrders = $customIEMOrdersBuilder->get()->getResultArray();
          
          // Merge and sort by created_at date
          $allOrders = array_merge($regularOrders, $customIEMOrders);
          usort($allOrders, function($a, $b) {
              return strtotime($b['created_at']) - strtotime($a['created_at']);
          });
          
          return $allOrders;
      }
  
      public function getCompletedOrders()
      {
          $db = \Config\Database::connect();
          
          // Get regular product completed orders
          $regularOrdersBuilder = $db->table('orders');
          $regularOrdersBuilder->select('orders.*, products.product_name');
          $regularOrdersBuilder->join('products', 'products.product_id = orders.product_id', 'left');
          $regularOrdersBuilder->where('orders.order_status', 'complete');
          $regularOrdersBuilder->where('orders.is_custom_iem', 0);
          $regularOrders = $regularOrdersBuilder->get()->getResultArray();
          
          // Get custom IEM completed orders
          $customIEMOrdersBuilder = $db->table('orders');
          $customIEMOrdersBuilder->select('orders.*, iem_customizations.design_name as product_name, "Custom IEM" as product_type, iem_customizations.category');
          $customIEMOrdersBuilder->join('iem_customizations', 'iem_customizations.id = orders.product_id', 'left');
          $customIEMOrdersBuilder->where('orders.order_status', 'complete');
          $customIEMOrdersBuilder->where('orders.is_custom_iem', 1);
          $customIEMOrders = $customIEMOrdersBuilder->get()->getResultArray();
          
          // Merge and sort by date_completed
          $allOrders = array_merge($regularOrders, $customIEMOrders);
          usort($allOrders, function($a, $b) {
              $dateA = isset($a['date_completed']) ? strtotime($a['date_completed']) : 0;
              $dateB = isset($b['date_completed']) ? strtotime($b['date_completed']) : 0;
              return $dateB - $dateA;
          });
          
          return $allOrders;
      }
  
      public function getCancelledOrders()
      {
          $db = \Config\Database::connect();
          
          // Get regular product cancelled orders
          $regularOrdersBuilder = $db->table('orders');
          $regularOrdersBuilder->select('orders.*, products.product_name');
          $regularOrdersBuilder->join('products', 'products.product_id = orders.product_id', 'left');
          $regularOrdersBuilder->where('orders.order_status', 'cancelled');
          $regularOrdersBuilder->where('orders.is_custom_iem', 0);
          $regularOrders = $regularOrdersBuilder->get()->getResultArray();
          
          // Get custom IEM cancelled orders
          $customIEMOrdersBuilder = $db->table('orders');
          $customIEMOrdersBuilder->select('orders.*, iem_customizations.design_name as product_name, "Custom IEM" as product_type, iem_customizations.category');
          $customIEMOrdersBuilder->join('iem_customizations', 'iem_customizations.id = orders.product_id', 'left');
          $customIEMOrdersBuilder->where('orders.order_status', 'cancelled');
          $customIEMOrdersBuilder->where('orders.is_custom_iem', 1);
          $customIEMOrders = $customIEMOrdersBuilder->get()->getResultArray();
          
          // Merge and sort by date_cancelled
          $allOrders = array_merge($regularOrders, $customIEMOrders);
          usort($allOrders, function($a, $b) {
              $dateA = isset($a['date_cancelled']) ? strtotime($a['date_cancelled']) : 0;
              $dateB = isset($b['date_cancelled']) ? strtotime($b['date_cancelled']) : 0;
              return $dateB - $dateA;
          });
          
          return $allOrders;
      }
  
      public function getOrderById($orderId)
      {
          return $this->where('order_id', $orderId)->first();
      }
  }

