<?php

namespace App\Controllers;

use App\Models\Comments_Model;
use CodeIgniter\Controller;

class Community extends Controller
{
    public function index()
    {
        $commentsModel = new Comments_Model();

        // Fetch products with their comments
        $commentsPerProduct = $commentsModel->getProducts();

        return view('community_view', ['commentsPerProduct' => $commentsPerProduct]);
    }

    public function reviewProduct($productId)
    {
        if ($this->request->getMethod() === 'post') {
            $commentsModel = new Comments_Model();
            $userId = session()->get('user_id'); // Assuming user is logged in

            $existingReview = $commentsModel->getReviewByUserAndProduct($userId, $productId);

            if ($existingReview) {
                return redirect()->to('/community')->with('error', 'You have already reviewed this product.');
            }

            $commentsModel->save([
                'product_id' => $productId,
                'user_id' => $userId,
                'rating' => $this->request->getPost('rating-value'),
                'comment_text' => $this->request->getPost('review')
            ]);

            return redirect()->to('/community')->with('success', 'Review added successfully.');
        }
    }

    public function reviewDelete($productId)
    {
        $commentsModel = new Comments_Model();
        $userId = session()->get('user_id');

        $commentsModel->deleteReview($userId, $productId);
        
        return redirect()->to('/community')->with('success', 'Review deleted successfully.');
    }
}
