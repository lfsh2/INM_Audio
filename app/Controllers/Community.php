<?php

namespace App\Controllers;

use App\Models\PostModel;
use App\Models\CommentModel;
use App\Models\User_Account_Model;
use CodeIgniter\Controller;

class Community extends Controller
{
    private $profanityList = [
        'ass', 'asshole', 'bastard', 'bitch', 'bullshit',
        'crap', 'damn', 'douche', 'douchebag', 'dick', 
        'dickhead', 'fuck', 'fucked', 'fucker', 'fucking',
        'jackass', 'motherfucker', 'piss', 'pissed', 'shit',
        'shitty', 'slut', 'tit', 'tits', 'twat', 'whore',
        
        'cunt', 'faggot', 'fag', 'nigger', 'nigga', 'retard', 
        'retarded', 'tranny', 'spic', 'wetback', 'chink', 'kike',
        'dyke', 'homo', 'queer', 'jap', 'paki',
        
        'a$$', 'a$$hole', 'a$s', 'b!tch', 'b1tch', 'b*tch', 
        'f*ck', 'f**k', 'f*cking', 'sh!t', 'sh*t', 's***', 
        'f***', 'd*ck', 'p*ssy', 'pu$$y', 'fuk', 'fuking',
        
        'putangina', 'puta', 'putang ina', 'putragis', 'punyeta',
        'gago', 'gaga', 'ulol', 'ulul', 'bobo', 'tanga', 'inutil',
        'buwisit', 'lintik', 'leche', 'letse', 'tarantado',
        'hayop', 'hayup', 'siraulo', 'pokpok', 'pok pok',
        'puki', 'pekpek', 'pepe', 'titi', 'tite', 'burat', 'bayag',
        'kantot', 'iyot', 'hindot', 'jakol', 'chupa', 'etits',
        'ratbu', 'yawa', 'bogo', 'bisdak', 'bilat', 'libog', 'kupal',
        'tanginamo', 'kingina', 'kengkoy', 'kainin', 'kakantutin',
        'kantotan', 'demonyo', 'diyablo', 'shet', 'anak ng puta',
        'pakshet', 'pakingshet', 'tang ina', 't@ng1n@',
        'p*tang ina', 'p*t@ng!n@', 'walang hiya',
        'ogag', 'olol', 'bading', 'bakla', 'bayot',
        'unggoy', 'gong', 'gunggong', 'tado', 'timang', 'abnoy',
        'supot', 'suput', 'tamod', 'mani'
    ];

    private function containsProfanity($text) {
        if (empty($text)) {
            return false;
        }
        
        $lowercaseText = strtolower($text);
        
        foreach ($this->profanityList as $word) {
            if (strpos($word, ' ') !== false) {
                if (strpos($lowercaseText, $word) !== false) {
                    log_message('info', 'Profanity detected: "' . $word . '" in text');
                    return true;
                }
                continue;
            }
            
            $pattern = '/\b' . preg_quote($word, '/') . '\b/i';
            if (preg_match($pattern, $lowercaseText)) {
                log_message('info', 'Profanity detected: "' . $word . '" in text');
                return true;
            }
        }
        
        $substitutionPatterns = [
            '/f+\s*u+\s*c+\s*k+/i',     
            '/s+\s*h+\s*i+\s*t+/i',      
            '/b+\s*i+\s*t+\s*c+\s*h+/i', 
            '/p+\s*u+\s*t+\s*a+/i',      
            '/g+\s*a+\s*g+\s*o+/i',      
            '/b+\s*o+\s*b+\s*o+/i'       
        ];
        
        foreach ($substitutionPatterns as $pattern) {
            if (preg_match($pattern, $lowercaseText)) {
                log_message('info', 'Disguised profanity detected via pattern');
                return true;
            }
        }
        
        $combinedWords = ['putangina', 'tangina', 'putanginamo', 'tanginamo'];
        foreach ($combinedWords as $word) {
            if (strpos($lowercaseText, $word) !== false) {
                log_message('info', 'Combined profanity detected: "' . $word . '" in text');
                return true;
            }
        }
        
        return false;
    }

    public function index()
    {
        $session = session();
    
        if (!$session->has('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'You must be logged in to access the community.');
        }
    
        $postModel = new PostModel();
        $commentModel = new CommentModel();
        $userModel = new User_Account_Model();
    
        $posts = $postModel->getApprovedPosts();
    
        foreach ($posts as &$post) {
            $post['comments'] = $commentModel->getCommentsByPostId($post['id']);
    
            $user = $userModel->getUserById($post['user_id'] ?? null);
            $post['profile_pic'] = !empty($user['profile_pic']) ? $user['profile_pic'] : 'default-user.png';
        }
    
        $data = [
            'posts' => $posts,
            'user' => $userModel->getUserById($session->get('user_id')) 
        ];
    
        return view('community', $data);
    }
    
    public function post_content()
    {
        $session = session();
    
        if (!$session->has('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'You must be logged in to post.');
        }
    
        $postText = $this->request->getPost('post_text');
        
        if ($this->containsProfanity($postText)) {
            return redirect()->to('/community')->with('error', 'Your post contains inappropriate language. Please revise and try again.');
        }
    
        $postModel = new PostModel();
        $file = $this->request->getFile('post_image');
    
        $imageName = null;
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $imageName = $file->getRandomName();
            $file->move(FCPATH . 'uploads', $imageName);
        }
    
        $postModel->save([
            'user_name' => $session->get('username'),
            'post_text' => $postText,
            'image_url' => $imageName,
            'status' => 'pending',
        ]);
    
        return redirect()->to('/community')->with('success', 'Your post has been submitted for review. It will appear on the community page once approved.');
    }
    public function post_comment()
    {
        $session = session();

        if (!$session->has('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'You must be logged in to comment.');
        }

        $commentText = $this->request->getPost('comment_text');
        
        if ($this->containsProfanity($commentText)) {
            return redirect()->to('/community')->with('error', 'Your comment contains inappropriate language. Please revise and try again.');
        }

        $commentModel = new CommentModel();

        $commentModel->save([
            'post_id' => $this->request->getPost('post_id'),
            'user_name' => $session->get('username'),
            'comment_text' => $commentText,
        ]);

        return redirect()->to('/community')->with('success', 'Comment added successfully!');
    }
    
    public function testFlash()
    {
        return redirect()->to('/community')->with('error', 'This is a test error message.');
    }
}