<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- @ICON -->
    <link rel="shortcut icon" href="<?= base_url('assets/img/logo.png') ?>" type="image/x-icon">
    <!-- @CSS FILES LINKS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/comparison.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/library.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/navbar.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/footer.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <title>All Gears</title>
</head>
<body>
    <!-- @HEADER -->
    <?php echo view("includes/header.php"); ?>
    <!-- @END HEADER -->

    <div class="library">
        <div class="library-title">
            <h2>Gear Library</h2>
        </div>

        <div class="bg">
            <div class="category">
                <p>Vanilla Series</p>
            </div>

            <div class="card-container">
                <?php if (!empty($gears)) : ?>
                    <?php foreach ($gears as $gear) : ?>
                        <div class="library-card">
                            <img class="bgimg" src="<?= esc($gear['image_url']) ?>" alt="<?= esc($gear['product_name']) ?>">
                            <div class="info">
                                <h3><?= esc($gear['product_name']) ?></h3>
                                <p><?= esc($gear['description']) ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                        <!-- <div class="library-card prestige">
                            <img class="bgimg" src="<?= esc($gear['image_url']) ?>" alt="<?= esc($gear['product_name']) ?>">
                            <div class="info">
                                <h3><?= esc($gear['product_name']) ?></h3>
                                <p><?= esc($gear['description']) ?></p>
                            </div>
                        </div> -->
                <?php else : ?>
                    <div class="library-card">
                        <h3 style="color: red;">No Gears Available</h3>
                    </div>
                <?php endif; ?>

                <!-- <div class="comparison-table">
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
                </div> -->
            </div>
        </div>
    </div>

    <!-- @FOOTER -->
    <?php echo view("includes/footer.php"); ?>
    <!-- @END FOOTER -->
</body>
</html>
