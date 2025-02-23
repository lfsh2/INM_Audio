<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('assets/css/library.css') ?>">
    <title><?= esc($category['category']) ?> Items</title>
</head>
<body>

<?php echo view("includes/header.php"); ?>

<div class="library">
    <div class="library-title">
        <h2><?= esc($category['category']) ?> Items</h2>
    </div>

    <div class="card-container">
        <?php if (!empty($gears)) : ?>
            <?php foreach ($gears as $gear) : ?>
                <div class="library-card">
                    <img src="<?= esc($gear['image_url']) ?>" alt="<?= esc($gear['product_name']) ?>" height="150px">
                    <div class="info">
                        <h3><?= esc($gear['product_name']) ?></h3>
                        <p><?= esc($gear['description']) ?></p>
                        <p>Price: $<?= esc($gear['price']) ?></p>
                        <p>Stock: <?= esc($gear['stock_quantity']) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <div class="library-card">
                <h3 style="color: red;">No items available in this category.</h3>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php echo view("includes/footer.php"); ?>

</body>
</html>
