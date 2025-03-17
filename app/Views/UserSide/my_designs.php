<!DOCTYPE html>
<html lang="en">

<head>
    <title>My Designs</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/mydesigns.css') ?>">
</head>

<body>
    <h1>My Designs</h1>

    <?php if (!empty($designs)): ?>
        <div class="design-container">
            <?php foreach ($designs as $design): ?>
                <div class="design-item">
                    <img src="<?= base_url($design['captured_image'] ?? $design['uploaded_image']) ?>" alt="Design Image">
                    <p><strong>Category:</strong> <?= $design['category'] ?></p>
                    <p><strong>Material:</strong> <?= $design['material'] ?></p>
                    <p><strong>Size:</strong> <?= $design['size'] ?></p>
                    <p><strong>Left Color:</strong> <?= $design['left_color'] ?></p>
                    <p><strong>Right Color:</strong> <?= $design['right_color'] ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>You have no saved designs yet.</p>
    <?php endif; ?>
</body>

</html>
