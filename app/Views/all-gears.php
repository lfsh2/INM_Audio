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
    <style>
        .category-section {
            margin-bottom: 40px;
        }
        .category-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
            border-bottom: 2px solid #333;
            padding-bottom: 5px;
        }
        .card-container {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            max-width: 800px;
            width: 80%;
            max-height: 600px;
            height: 100%;
            padding: 20px;
            background: white;
            border-radius: 10px;
            text-align: center;
            display: flex;
            justify-content: center;y
        }
        .left-gear {
            width: 50%;
            height: 100%;
            padding-bottom: 10px;
            border: 1px solid black;
            display: flex;
            justify-content: space-between;
            flex-direction: column;

            img{
                width: 100%;
            }

            .gear-info {
                display: flex;
                flex-direction: column;
                gap: 10px;
            }

            #gearTitle {
                width: 100%;
                text-align: center;
            }

            a {
                width: 90%;
                margin: 0 auto;
                padding: 10px;
                background: black;
                color: white;
                border-radius: 5px;
                text-decoration: none;
            }
        }
        .right-gear {
            width: 50%;
            height: 100%;
            display: flex;
            justify-content: space-between;
            flex-direction: column;

            .top {
                position: relative;

                span {
                    font-size: 1rem;
                    position: absolute;
                    top: 50%;
                    right: 10px;
                    transform: translateY(-50%);
                    cursor: pointer;
                }
            }

            .earphones {
                img {
                    width: 100%;
                    max-height: 300px;
                    height: 100%;
                    object-fit: cover;
                }

                .buttons {
                    display: flex;
                    justify-content: space-evenly;

                    button {
                        border: none;
                        background: none;
                        font-size: 1.5rem;
                        cursor: pointer;
                    }
                }
            }

            .audio-player {
                padding: 10px;
                display: flex;
                flex-direction: column;
                gap: 10px;

                .buttons {
                    display: flex;
                    justify-content: center;
                    gap: 10px;

                    button {
                        padding: 5px 10px;
                        background: black;
                        color: white;
                        border-radius: 10px;
                        cursor: pointer;
                    }
                }
            }
        }
        
        /* .close {
            position: absolute;
            top: 10px;
            right: 20px;
            font-size: 25px;
            cursor: pointer;
        }
        .earphones {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 30px;
            margin: 20px 0;
        }
        .earphones img {
            width: 150px;
        }
        .earphones button {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 10px 15px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
        }
        .earphones button:hover {
            background-color: #0056b3;
        }
        .audio-player {
            margin-top: 20px;
        }
        #waveform {
            width: 100%;
            height: 100px;
            background: #f2f2f2;
        }
        .subwoofer {
            width: 120px;
            height: 120px;
            background: radial-gradient(circle, #444 20%, #222 60%, #111 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 20px auto;
            position: relative;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.8);
            transition: transform 0.1s ease-out;
        }
        .subwoofer::before {
            content: "";
            width: 80px;
            height: 80px;
            background: radial-gradient(circle, #666 30%, #333 90%);
            border-radius: 50%;
            position: absolute;
        }
        .subwoofer.boom {
            transform: scale(1.2);
            box-shadow: 0 0 40px rgba(0, 0, 0, 1);
        } */
    </style>
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
            <?php if (!empty($gears_by_category)) : ?>
                <?php foreach ($gears_by_category as $category => $gears) : ?>
                    <div class="category-section">
                        <h3 class="category-title"><?= esc($category) ?></h3>
                        <div class="card-container">
                            <?php foreach ($gears as $gear) : ?>
                                <div class="library-card" onclick="openModal('<?= esc($gear['product_name']) ?>', '<?= esc($gear['description']) ?>', '<?= esc($gear['image_url']) ?>')">
                                    <img class="bgimg" src="<?= esc($gear['image_url']) ?>" alt="<?= esc($gear['product_name']) ?>">
                                    <div class="info">
                                        <h3><?= esc($gear['product_name']) ?></h3>
                                        <p><?= esc($gear['description']) ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p style="color: red;">No Gears Available</p>
            <?php endif; ?>
        </div>
    </div>


    <!-- @FOOTER -->
    <?php echo view("includes/footer.php"); ?>
    <!-- @END FOOTER -->
</body>
</html>
