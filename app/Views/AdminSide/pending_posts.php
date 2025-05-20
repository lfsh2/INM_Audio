<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('assets/css/comm.css') ?>">    
    <link rel="shortcut icon" href="<?= base_url('assets/img/logo.png') ?>" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="<?= base_url('Admin/css/dashboard1.css') ?>">
    <title>Admin - Pending Posts</title>
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

        .admin-header {
            background-color: #333;
            color: white;
            padding: 15px;
            text-align: center;
            margin-bottom: 20px;
        }

        .admin-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .admin-title {
            font-size: 24px;
            margin-bottom: 20px;
            color: var(--dark);
        }

        .admin-stats {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }

        .stat-box {
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 5px;
            width: 30%;
            text-align: center;
            color: var(--dark);
        }

        .post-actions {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }

        .approve-btn {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 4px;
            cursor: pointer;
        }

        .reject-btn {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 4px;
            cursor: pointer;
        }

        .post-wrapper {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 20px;
            padding: 15px;
        }

        .no-posts {
            background: var(--lights);
            text-align: center;
            padding: 50px;
            border-radius: 5px;
            color: var(--dark);
        }
    </style>
</head>

<body>

<?php echo view('AdminSide/includes/sideNav1') ?>
<section id="content">
		<?php echo view('AdminSide/includes/topNavbar') ?>


    <div class="admin-header">
        <h1>Admin Dashboard - Pending Posts</h1>
    </div>

    <div class="admin-container">
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

        <div class="admin-stats">
            <div class="stat-box">
                <h3>Pending Posts</h3>
                <p><?= count($pendingPosts) ?></p>
            </div>
            <div class="stat-box">
                <h3>Total Posts</h3>
                <p><?= (new \App\Models\PostModel())->countAllResults() ?></p>
            </div>
            <div class="stat-box">
                <h3>Total Users</h3>
                <p><?= (new \App\Models\User_Account_Model())->countAllResults() ?></p>
            </div>
        </div>

        <h2 class="admin-title">Pending Posts for Review</h2>

        <?php if (!empty($pendingPosts)) : ?>
            <?php foreach ($pendingPosts as $post) : ?>
                <div class="post-wrapper">
                    <div class="post-item">
                        <div class="post-content">
                            <div class="post-info">
                                <strong><?= esc($post['user_name']) ?: 'Anonymous' ?></strong>
                                <span class="post-date"><?= date('M d, Y h:i A', strtotime($post['created_at'])) ?></span>
                            </div>
                            
                            <p class="post-text"><?= esc($post['post_text']) ?></p>
                            
                            <?php if ($post['image_url']): ?>
                                <div class="post-image-container">
                                    <img src="<?= base_url('uploads/' . $post['image_url']) ?>" class="post-image" alt="Post Image">
                                </div>
                            <?php endif; ?>
                            
                            <div class="post-actions">
                                <a href="<?= base_url('admin/approve_post/' . $post['id']) ?>" class="approve-btn">
                                    <i class="fa-solid fa-check"></i> Approve
                                </a>
                                <a href="<?= base_url('admin/reject_post/' . $post['id']) ?>" class="reject-btn">
                                    <i class="fa-solid fa-xmark"></i> Reject
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <div class="no-posts">
                <h3>No pending posts to review.</h3>
                <p>All posts have been reviewed!</p>
            </div>
        <?php endif; ?>
    </div>

    <script src="<?= base_url('Admin/js/dashboard1.js') ?>"></script>

</body>

</html>