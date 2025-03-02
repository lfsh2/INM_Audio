<?php

namespace App\Controllers;

use App\Models\PostModel;
use App\Models\CommentModel;
use CodeIgniter\Controller;

class Community extends Controller
{
    public function index()
    {
        $postModel = new PostModel();
        $commentModel = new CommentModel();

        $posts = $postModel->orderBy('id', 'DESC')->findAll();
        
        foreach ($posts as &$post) {
            $post['comments'] = $commentModel->getCommentsByPostId($post['id']);
        }

        $data = [
            'posts' => $posts
        ];
        
        return view('community', $data);
    }

    public function post_content()
    {
        $postModel = new PostModel();
        $file = $this->request->getFile('post_image');

        $imageName = null;
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $imageName = $file->getRandomName();
            $file->move(FCPATH . 'uploads', $imageName); 
        }

        $postModel->save([
            'user_name' => $this->request->getPost('user_name'),
            'post_text' => $this->request->getPost('post_text'),
            'image_url' => $imageName, 
        ]);

        return redirect()->to('/community'); 
    }

    public function post_comment()
    {
        $commentModel = new CommentModel();

        $commentModel->save([
            'post_id' => $this->request->getPost('post_id'),
            'user_name' => $this->request->getPost('user_name'),
            'comment_text' => $this->request->getPost('comment_text'),
        ]);

        return redirect()->to('/community'); 
    }
}
