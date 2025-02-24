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

<!-- Include Navbar -->
<?php echo view("includes/header.php"); ?>

<!-- @SECTION - Community Reviews -->
<div class="comm-container">
    <div class="comm-title">
        <h2>IEM Community</h2>
    </div>

    <div class="community-container">
        <?php if (!empty($commentsPerProduct)) : ?>
            <?php foreach ($commentsPerProduct as $cpp) : ?>
                <div class="review-item">
                    <!-- Left Side: Product Image & Name -->
                    <div class="product-info">
                        <img src="<?= esc($cpp['image_url']) ?>" alt="<?= esc($cpp['product_name']) ?>">
                        <h3><?= esc($cpp['product_name']) ?></h3>
                    </div>

                    <!-- Right Side: Comments Section -->
                    <div class="comments-section">
                        <?php if (!empty($cpp['comment_text'])): ?>
                            <div class="comment">
                                <div class="user-profile">
                                    <img src="<?= base_url('assets/img/default-user.png') ?>" alt="User"> <!-- Placeholder for user profile -->
                                    <p><strong><?= esc($cpp['firstname']) . ' ' . esc($cpp['lastname']) ?></strong></p>
                                </div>
                                <p class="rating">
                                    <?= str_repeat('⭐', esc($cpp['rating'])) ?>
                                </p>
                                <p class="comment-text"><?= esc($cpp['comment_text']) ?></p>
                            </div>
                        <?php else: ?>
                            <p style="color: gray; text-align: center;">No comments yet.</p>
                        <?php endif; ?>

                        <!-- Add Comment Input -->
                        <div class="add-comment">
                            <input type="text" placeholder="Add comment">
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <div class="noProducts">
                <h5 style="color: gray; text-align: center; padding: 20px;">NO PRODUCTS AVAILABLE</h5>
            </div>
        <?php endif; ?>
    </div>
</div>
<!-- @END SECTION - Community Reviews -->

<!-- Include Footer -->
<?php echo view("includes/footer.php"); ?>

</body>
</html>
