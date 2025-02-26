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
                <div class="img-block">
                    <img src="" alt="">
                    <p>Name</p>
                </div>

                <div class="info-block">
                    <p>asdfghjkl</p>
                    <p>asdfghjkl</p>
                    <p>asdfghjkl</p>
                    <p>asdfghjkl</p>
                </div>
            </div>

            <div class="right earphone">
                <div class="img-block">
                    <img src="" alt="">
                    <p>Name</p>
                </div>

                <div class="info-block">
                    <p>asdfghjkl</p>
                    <p>asdfghjkl</p>
                    <p>asdfghjkl</p>
                    <p>asdfghjkl</p>
                </div>
            </div>
        </div>
        
        <div class="frequency-container">
            <div class="title">
                <h2>Frequency Response Comparison</h2>
            </div>

            <div class="frequency-block">
                <div class="left frequency">
                    <div class="img-block">
                        <img src="" alt="">
                    </div>
                </div>

                <div class="right frequency">
                    <div class="img-block">
                        <img src="" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>