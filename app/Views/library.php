<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- @ICON -->
    <link rel="shortcut icon" href="<?= base_url('assets/img/logo.png') ?>" type="image/x-icon">
    <!-- @CSS FILES LINKS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/library.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/navbar.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/footer.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer"/>

    <title>Gear Library</title>
</head>

<body>

<!-- @HEADER -->
<?php echo view("includes/header.php"); ?>
<!-- @END HEADER -->

<!-- @SECTION - Library Main Content -->
<div class="library">
    <div class="library-title">
        <h2>Gear Library</h2>

        <div class="search">
            <input type="text" placeholder="Search Gear">
            <button><i class="fa-solid fa-search"></i></button>
        </div>
    </div>

    <div class="bg">
        <div class="card-container">
            <?php 
            $categoryImages = [
                'Vanilla Series' => 'vanilla.jpg',
                'Stage Series' => 'stage.jpg',
                'Personalized Series' => 'personalized.jpg',
                'Prestige Series' => 'prestige.jpg',
            ];
            ?>

            <?php if (!empty($categories)) : ?>
                <?php foreach ($categories as $category) : ?>
                    <!-- Get the correct image for each category -->
                    <?php 
                        $image = $categoryImages[$category['category']] ?? 'default.png'; 
                    ?>
                    <!-- Category Cards -->
                    <div class="library-card" title="Click to view all gears in this category">
                        <a href="<?= base_url('library/category/' . $category['category_id']) ?>">
                            <img class="bgimg" src="<?= base_url('assets/img/categories/' . $image); ?>" alt="<?= esc($category['category']) ?> Image">
                            <div class="info">
                                <h3><?= esc($category['category']) ?></h3>
                                <p>Click to view all gears under this category.</p>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <div class="library-card">
                    <h3 style="color: red;">No Categories Available</h3>
                </div>
            <?php endif; ?>

            <div class="library-card see" title="Click to view all gears in this category">
                <a href="<?= base_url('library/all-gears')?>">
                    <img class="bgimg" src="<?= base_url('assets/img/seeall.jpg'); ?>" alt="Category Image">
                    <div class="info">
                        <h3>See All Gears</h3>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- @END SECTION -->

<!-- @FOOTER -->
<?php echo view("includes/footer.php"); ?>
<!-- @END FOOTER -->

<!-- @SCRIPTS -->
<script src="<?= base_url('assets/js/category.js') ?>"></script>
</body>
</html>
