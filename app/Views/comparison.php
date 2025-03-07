<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gear Library</title>

    <link rel="shortcut icon" href="<?= base_url('assets/img/logo.png') ?>" type="image/x-icon">
    <link rel="stylesheet" href="<?= base_url('assets/css/comparison.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/navbar.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/footer.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>
    <?php echo view("includes/header.php"); ?>

    <div class="comparison-table">
        <div class="title">
            <h1>Comparison Table</h1>
        </div>

        <div class="earphone-container">
    <div class="left earphone">
        <?php if (!empty($leftGear)) : ?>
            <div class="img-block">
                <img src="<?= esc($leftGear['image_url']) ?>" alt="<?= esc($leftGear['product_name']) ?>">
                <p><?= esc($leftGear['product_name']) ?></p>
            </div>
            <div class="info-block">
                <label for="driver">Driver</label>
                <p><?= esc($leftGear['driver_type']) ?></p>
                <label for="cable">Cable Type</label>
                <p><?= esc($leftGear['cable_type']) ?></p>
                <label for="frequency">Frequency Response</label>
                <p><?= esc($leftGear['frequency_range']) ?></p>
            </div>
        <?php else : ?>
            <p>No product selected for comparison.</p>
        <?php endif; ?>
    </div>

    <div class="right earphone">
        <div class="img-block">
            <img src="" alt="">
            <p>Name</p>
        </div>
        <div class="info-block">
            <label for="driver">Driver</label>
            <p>-</p>
            <label for="cable">Cable Type</label>
            <p>-</p>
            <label for="frequency">Frequency Response</label>
            <p>-</p>
        </div>
    </div>
</div>

    </div>
</body>
</html>
