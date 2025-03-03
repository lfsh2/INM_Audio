<?php

namespace App\Controllers;

use App\Models\PostModel;
use App\Models\CommentModel;
use App\Models\User_Account_Model;
use CodeIgniter\Controller;

class Community extends Controller
{
    public function index()
{
    $session = session();

    // Restrict access to logged-in users
    if (!$session->has('isLoggedIn')) {
        return redirect()->to('/login')->with('error', 'You must be logged in to access the community.');
    }

    $postModel = new PostModel();
    $commentModel = new CommentModel();
    $userModel = new User_Account_Model();

    // Fetch all posts
    $posts = $postModel->orderBy('id', 'DESC')->findAll();

    foreach ($posts as &$post) {
        // Fetch comments for each post
        $post['comments'] = $commentModel->getCommentsByPostId($post['id']);

        // Fetch user profile details for each post
        $user = $userModel->getUserById($post['user_id'] ?? null);
        $post['profile_pic'] = !empty($user['profile_pic']) ? $user['profile_pic'] : 'default-user.png';
    }

    $data = [
        'posts' => $posts,
        'user' => $userModel->getUserById($session->get('user_id')) // Get logged-in user info
    ];

    return view('community', $data);
}


    public function post_content()
    {
        $session = session();

        // Restrict posting to logged-in users
        if (!$session->has('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'You must be logged in to post.');
        }

        $postModel = new PostModel();
        $file = $this->request->getFile('post_image');

        $imageName = null;
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $imageName = $file->getRandomName();
            $file->move(FCPATH . 'uploads', $imageName);
        }

        $postModel->save([
            'user_id' => $session->get('user_id'),
            'user_name' => $session->get('username'),
            'post_text' => $this->request->getPost('post_text'),
            'image_url' => $imageName,
        ]);

        return redirect()->to('/community');
    }

    public function post_comment()
    {
        $session = session();

        // Restrict commenting to logged-in users
        if (!$session->has('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'You must be logged in to comment.');
        }

        $commentModel = new CommentModel();

        $commentModel->save([
            'post_id' => $this->request->getPost('post_id'),
            'user_name' => $session->get('username'),
            'comment_text' => $this->request->getPost('comment_text'),
        ]);

        return redirect()->to('/community');
    }
}
