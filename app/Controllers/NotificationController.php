<?php

namespace App\Controllers;
use CodeIgniter\Controller;

class NotificationController extends Controller {
    public function lowStockNotifications() {
        $db = \Config\Database::connect();
    
        $query = $db->query("
            SELECT product_name, stock_quantity 
            FROM products 
            WHERE stock_quantity <= 5 
            AND category_id != 4
            ORDER BY stock_quantity ASC
        ");
    
        $lowStockItems = $query->getResultArray();
        return $this->response->setJSON($lowStockItems);
    }
    
}
