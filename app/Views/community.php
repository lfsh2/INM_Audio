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
</head>

<body>

    <?php echo view("includes/header.php"); ?>

    <div class="comm-container">
        <div class="comm-title">
            <h2>Community</h2>
        </div>

        <?php if (session()->has('isLoggedIn')): ?>
            <div class="post-form">
                <h3>Create a Post</h3>
                <form action="<?= base_url('community/post_content') ?>" method="POST" enctype="multipart/form-data">
                    <div class="form-group user-info">
                       <!-- <img src="<?= base_url('uploads/' . (session('profile_pic') ?? 'default-user.png')) ?>" alt="Profile"> -->
                        <strong><?= esc(session('firstname') . ' ' . session('lastname')) ?></strong>
                    </div>
                    <div class="form-group">
                        <textarea name="post_text" placeholder="What's on your mind?" required></textarea>
                    </div>
                    <div class="form-group">
                        <input type="file" name="post_image" accept="image/*">
                    </div>
                    <button type="submit">Post</button>
                </form>
            </div>
        <?php else: ?>
            <p class="error-message">You must be <a href="<?= base_url('login') ?>">logged in</a> to post.</p>
        <?php endif; ?>

        <div class="community-container">
            <?php if (!empty($posts)) : ?>
                <?php foreach ($posts as $post) : ?>
                    <div class="post-item">
                        <div class="post-info">
                            <!--<img src="<?= base_url('uploads/' . ($post['profile_pic'] ?? 'default-user.png')) ?>" alt="User">-->
                            <strong><?= esc($post['user_name']) ?: 'Anonymous' ?></strong>
                        </div>
                        
                        <p class="post-text"><?= esc($post['post_text']) ?></p>
                        
                        <?php if ($post['image_url']): ?>
                            <div class="post-image-container">
                                <img src="<?= base_url('uploads/' . $post['image_url']) ?>" class="post-image" alt="Post Image">
                            </div>
                        <?php endif; ?>

                        <hr>

                        <div class="interactions">
                            <button onclick="likePost(<?= $post['id'] ?>)"><i class="fa-solid fa-thumbs-up"></i> Like</button>
                            <button onclick="toggleCommentBox(<?= $post['id'] ?>)"><i class="fa-solid fa-comment"></i> Comment</button>
                        </div>

                        <div id="comments-<?= $post['id'] ?>" class="comments-section" style="display: none;">
                            <hr>
                            
                            <?php if (!empty($post['comments'])): ?>
                                <div class="comment">
                                    <?php foreach ($post['comments'] as $comment): ?>
                                        <p><strong><?= esc($comment['user_name']) ?: 'Anonymous' ?> </strong> <span><?= esc($comment['comment_text']) ?></span></p>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <p class="no-comments">No comments yet.</p>
                            <?php endif; ?>

                            <?php if (session()->has('isLoggedIn')): ?>
                                <form action="<?= base_url('community/post_comment') ?>" method="POST">
                                    <hr>
                                    <input type="hidden" name="post_id" value="<?= esc($post['id']) ?>">
                                    <div class="com">
                                        <textarea name="comment_text" placeholder="Write a comment..." required></textarea>
                                        <button type="submit"><img src="<?= base_url('assets/img/send-logo.svg'); ?>" alt=""></button>
                                    </div>
                                </form>
                            <?php else: ?>
                                <p class="error-message">You must be <a href="<?= base_url('login') ?>">logged in</a> to comment.</p>
                            <?php endif; ?>
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
