<!DOCTYPE html>
<html lang="en">
<head>
    <title>All Gears</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/library.css') ?>">
</head>
<body>

<?php echo view("includes/header.php"); ?>

<div class="library">
    <h2>All Gears</h2>
    <div class="bg">
        <div class="card-container">
            <?php if (!empty($gears)) : ?>
                <?php foreach ($gears as $gear) : ?>
                    <div class="library-card">
                        <img src="<?= esc($gear['image_url']) ?>" alt="<?= esc($gear['product_name']) ?>">
                        <div class="info">
                            <h3><?= esc($gear['product_name']) ?></h3>
                            <p><?= esc($gear['description']) ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <h3 style="color: red;">No gears available.</h3>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php echo view("includes/footer.php"); ?>
</body>
</html>
