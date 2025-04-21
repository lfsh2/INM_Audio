<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('assets/css/comm.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/navbar.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/footer.css') ?>">
    <link rel="shortcut icon" href="<?= base_url('assets/img/logo.png') ?>" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <title>INM Community</title>
    <script defer src="<?= base_url('assets/js/script.js') ?>"></script>
    <style>
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
        }

        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }

        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }

        .posting-guidelines {
            background-color: #f9f9f9;
            border-left: 4px solid #4285f4;
            padding: 10px 15px;
            margin-bottom: 15px;
            border-radius: 3px;
            font-size: 0.9rem;
            line-height: 1.4;
        }
    </style>
</head>

<body>

    <?php echo view("includes/header.php"); ?>

    <div class="comm-container">
        <div class="comm-title">
            <h2>Community</h2>
        </div>

        <?php if (session()->has('error')): ?>
            <div class="alert alert-danger">
                <?= session('error') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->has('success')): ?>
            <div class="alert alert-success">
                <?= session('success') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->has('isLoggedIn')): ?>
            <div class="post-box">
                <h3>Create a Post</h3>
                
                <div class="posting-guidelines">
                    <p><strong>Community Guidelines:</strong> Please keep your posts respectful and free from profanity. 
                    Posts containing offensive language will be removed. We aim to maintain a friendly and inclusive environment for all members.</p>
                </div>
                
                <form action="<?= base_url('community/post_content') ?>" method="POST" enctype="multipart/form-data">
                    <div class="form-group user-info">
                        <strong><?= esc(session('firstname') . ' ' . session('lastname')) ?></strong>
                    </div>

                    <div class="form-group">
                        <textarea name="post_text" placeholder="What's on your mind? Please keep it respectful." required></textarea>
                    </div>

                    <div class="form-group file-upload">
                        <input type="file" name="post_image" id="file-input" accept="image/*">
                        <label for="file-input">
                            <i class="fa-solid fa-upload"></i> Upload Image
                        </label>
                    </div>

                    <div class="button-container">
                        <button type="submit">Post</button>
                    </div>
                </form>
            </div>
        <?php else: ?>
            <div class="error-message">You must be <a href="<?= base_url('login') ?>">logged in</a> to post.</div>
        <?php endif; ?>

        <div class="community-container">
            <?php if (!empty($posts)) : ?>
                <?php foreach ($posts as $post) : ?>
                    <div class="post-wrapper">
                        <div class="post-item">
                            <div class="post-content">
                                <div class="post-info">
                                    <strong><?= esc($post['user_name']) ?: 'Anonymous' ?></strong>
                                </div>
                                
                                <p class="post-text"><?= esc($post['post_text']) ?></p>
                                
                                <?php if ($post['image_url']): ?>
                                    <div class="post-image-container">
                                        <img src="<?= base_url('uploads/' . $post['image_url']) ?>" class="post-image" alt="Post Image">
                                    </div>
                                <?php endif; ?>
                                
                                <div class="interactions">
                                    <button onclick="likePost(<?= $post['id'] ?>)"><i class="fa-solid fa-thumbs-up"></i> Like</button>
                                </div>
                            </div>

                            <div class="comments-section">
                                
                                <?php if (!empty($post['comments'])): ?>
                                    <div class="comment">
                                        <?php foreach ($post['comments'] as $comment): ?>
                                            <p><strong><?= esc($comment['user_name']) ?: 'Anonymous' ?></strong>
                                            <span><?= esc($comment['comment_text']) ?></span></p>
                                        <?php endforeach; ?>
                                    </div>
                                <?php else: ?>
                                    <p class="no-comments">No comments yet.</p>
                                <?php endif; ?>

                                <?php if (session()->has('isLoggedIn')): ?>
                                    <form action="<?= base_url('community/post_comment') ?>" method="POST">
                                        <input type="hidden" name="post_id" value="<?= esc($post['id']) ?>">
                                        <div class="com">
                                            <textarea name="comment_text" placeholder="Write a comment... Please be respectful." required></textarea>
                                            <button type="submit"><img src="<?= base_url('assets/img/send-logo.svg'); ?>" alt=""></button>
                                        </div>
                                        <div class="posting-guidelines" style="font-size: 0.8rem; padding: 5px 10px; margin-top: 5px;">
                                            <p>Remember: Comments should follow our community guidelines.</p>
                                        </div>
                                    </form>
                                <?php else: ?>
                                    <p class="error-message">You must be <a href="<?= base_url('login') ?>">logged in</a> to comment.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <h5>No posts yet.</h5>
            <?php endif; ?>
        </div>
    </div>

    <script>
        function toggleCommentBox(postId) {
            let commentBox = document.getElementById("comments-" + postId);
            commentBox.style.display = (commentBox.style.display === "none") ? "block" : "none";
        }

        function likePost(postId) {
            alert("Like feature coming soon!");
        }
    </script>

    <?php echo view("includes/footer.php"); ?>

</body>

</html>