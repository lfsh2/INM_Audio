<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gear Library Comparison</title>

    <link rel="stylesheet" href="<?= base_url('assets/css/comparison.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/navbar.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/footer.css') ?>">
</head>

<body>
    <?php echo view("includes/header.php"); ?>

    <div class="comparison-table">
        <div class="title">
            <h1>Comparison Table</h1>
        </div>

        <div class="earphone-container">
            <!-- Left Gear -->
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

            <!-- Right Gear -->
            <<div class="right earphone">
                <?php if (!empty($rightGear)) : ?>
                    <div class="img-block">
                        <img src="<?= esc($rightGear['image_url']) ?>" alt="<?= esc($rightGear['product_name']) ?>">
                        <p><?= esc($rightGear['product_name']) ?></p>
                    </div>
                    <div class="info-block">
                        <label for="driver">Driver</label>
                        <p><?= esc($rightGear['driver_type']) ?></p>
                        <label for="cable">Cable Type</label>
                        <p><?= esc($rightGear['cable_type']) ?></p>
                        <label for="frequency">Frequency Response</label>
                        <p><?= esc($rightGear['frequency_range']) ?></p>
                    </div>
                <?php else : ?>
                    <p>No product selected for comparison.</p>
                <?php endif; ?>
        </div>


        <div class="actions">
            <a href="<?= base_url('library/clearComparison') ?>" class="clear-btn">Clear Comparison</a>
        </div>
    </div>
</body>

</html>