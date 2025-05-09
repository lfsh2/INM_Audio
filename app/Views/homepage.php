<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- @ICON -->
    <link rel="shortcut icon" href="<?= base_url('assets/img/logo.png') ?>" type="image/x-icon">
    <!-- @CSS FILES LINKS -->
    <link rel="stylesheet" href=" <?= base_url('assets/css/style.css') ?>">
    <link rel="stylesheet" href=" <?= base_url('assets/css/navbar.css') ?>">
    <link rel="stylesheet" href=" <?= base_url('assets/css/footer.css') ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>INM Audio</title>
</head>

<body>
    <!-- @PHP CODE  -->
    <?php
    # includes the header file that contains navbar
    echo view("includes/header.php");
    ?>
    <!-- @END PHP CODE -->

    <div class="bg">
        <div class="bg2">
            <!-- @PHP CODE  -->
            <?php
            # includes the header.introduction file that contains introduction about the website
            echo view('includes/header_introduction');
            ?>
            <!-- @END PHP CODE -->
        </div>
    </div>

    <!-- @SECTION 2 - about -->
    <div class="about">
        <div class="about-body">
            <div class="about-img">
                <img src="<?= base_url('assets/img/nav.png') ?>" alt="">
            </div>

            <div class="about-question">
                <div class="about-description">
                    <h3>What is</h3>
                    <h2>IEM AUDIOPHILE</h2>
                    <p>IEM (In-Ear Monitors) are a type of earphones designed for high-quality audio performance, often used by musicians, audio engineers, and audiophiles. Unlike regular earphones, IEMs fit snugly in the ear canal, providing a secure seal that enhances sound isolation and reduces external noise. They are capable of delivering detailed, clear, and balanced sound across a wide frequency range, often with multiple drivers in each earphone to handle different frequencies. IEMs are also known for their ability to offer a customized listening experience, with some models offering swappable cables or adjustable tips for improved comfort and fit. Due to their precise sound reproduction and portability, IEMs are especially popular in live sound environments, professional monitoring, and personal audio use.</p>
                </div>

                <a href="<?= base_url(relativePath: '/library') ?>">Gear Library <i class="fa-solid fa-arrow-right"></i></a>
            </div>
        </div>
    </div>
    <!-- @END SECTION ABOUT -->

    <!-- @PRODUCT SECTION - product slider section -->
    <div class="product">
        <div class="product-title">
            <h2>Our Product</h2>
        </div>

        <div class="card">
            <div id="image-track" data-mouse-down-at="0" data-prev-percentage="0">
                <img class="image" data-modal-target="#modal-1" src="<?= base_url('assets/img/inm1.jpg') ?>" draggable="false" />
                <img class="image" data-modal-target="#modal-2" src="<?= base_url('assets/img/inm2.jpg ') ?>" draggable="false" />
                <img class="image" data-modal-target="#modal-3" src="<?= base_url('assets/img/inm3.jpg ') ?>" draggable="false" />
                <img class="image" data-modal-target="#modal-4" src="<?= base_url('assets/img/pearl.jpg') ?>" draggable="false" />
                <img class="image" data-modal-target="#modal-5" src="<?= base_url('assets/img/google-dino.jpg') ?>" draggable="false" />
                <img class="image" data-modal-target="#modal-6" src="<?= base_url('assets/img/qdc.jpg') ?>" draggable="false" />
            </div>

            <div class="details modal" id="modal-1">
                <div class="img-block">
                    <img class="image" src="<?= base_url('assets/img/inm1.jpg') ?>" draggable="false" />
                </div>

                <div class="txt-block">
                    <p class="top">Vanilla Series</p>

                    <h1>INM1 Vanilla</h1>

                    <p>Stylish design with premium quality of sound that is perfect for casual listener, budget audiophiles with neutral tuning and vibrant sound.</p>
                </div>
            </div>

            <div class="details modal" id="modal-2">
                <div class="img-block">
                    <img class="image" src="<?= base_url('assets/img/inm2.jpg ') ?>" draggable="false" />
                </div>

                <div class="txt-block">
                    <p>Vanilla Series</p>

                    <h1>INM1 Vanilla Classic</h1>

                    <p>Designed for live musicians, vocalists, and performers who need a reliable and balanced stage monitoring experience. And also perfect for singers, guitarists, and instrumentalists who need detailed and uncolored sound on stage.
                    </p>
                </div>
            </div>
            <div class="details modal" id="modal-3">
                <div class="img-block">
                    <img class="image" src="<?= base_url('assets/img/inm3.jpg ') ?>" draggable="false" />
                </div>

                <div class="txt-block">
                    <p>Stage Series</p>

                    <h1>INM3 Stage 2 for 3 </h1>

                    <p>Designed for musicians and performers who need precise monitoring with strong low-end support.</p>
                </div>
            </div>
            <div class="details modal" id="modal-4">
                <div class="img-block">
                    <img class="image" src="<?= base_url('assets/img/pearl.jpg') ?>" draggable="false" />
                </div>

                <div class="txt-block">
                    <p>Personalized Stage Series</p>

                    <h1>Pearl of the North</h1>

                    <p>Designed and Costumized specialized for the specific user that preffered more clarity and bit bassy that like make of the pearl sound.</p>
                </div>
            </div>
            <div class="details modal" id="modal-5">
                <div class="img-block">
                    <img class="image" src="<?= base_url('assets/img/google-dino.jpg') ?>" draggable="false" />
                </div>

                <div class="txt-block">
                    <p>Personalized Vanilla Series</p>

                    <h1>Google Dino</h1>

                    <p>Inspired in Google Dino and specialized for daily listening, casual users, and music lovers seeking for an enjoyable, balanced sound</p>
                </div>
            </div>
            <div class="details modal" id="modal-6">
                <div class="img-block">
                    <img class="image" src="<?= base_url('assets/img/qdc.jpg') ?>" draggable="false" />
                </div>

                <div class="txt-block">
                    <p>Personalized Stage Series</p>

                    <h1>QDC Remini</h1>

                    <p>Designed for performers and musicians who need clear, impactful, and engaging audio for live monitoring and studio use and combined with the pearlscent and stars deisgn that makes more attractive looking.</p>
                </div>
            </div>

            <div id="overlay"></div>
        </div>
    </div>
    <!-- @END SECTION 2 - product slider section -->

    <!-- @SECTION 3 - favorite gears in display -->
    <div class="fav-gear">
        <div class="fav-title">
            <h2>Learn more about IEM</h2>
        </div>
        <div class="card-container">
            <div class="card1">
                <img src=" <?= base_url('assets/img/frequency.png') ?>" alt="">
                <div class="card-content">
                    <h1>Understanding Sound: The Frequency Response Graph</h1>
                    <p>The Frequency Response Graph visualizes how an IEM reproduces different sound frequencies, from deep bass to crisp treble <br> This helps users understand the sound signature of a specific IEM model, whether it's bass-heavy, neutral, or treble-focused.</p>
                </div>
            </div>

            <div class="card1">
                <img src=" <?= base_url('assets/img/fav1.png') ?>" alt="">
                <div class="card-content">
                    <h1>Know and Learn about Frequency</h1>
                    <p>● Low Frequencies (20Hz - 250Hz) → Affects bass depth and impact. <br>
                        ● Mid Frequencies (250Hz - 4kHz) → Defines vocal and instrumental clarity. <br>
                        ● High Frequencies (4kHz - 20kHz) → Adds detail and airiness to the sound. 
                    </p>
                </div>
            </div>

            <div class="card1">
                <img src=" <?= base_url('assets/img/iemvs.png') ?>" alt="">
                <div class="card-content">
                    <h1>Difference between IEM and normal Earphone</h1>
                    <p>IEM give more quality of sound and good isolation of every aspect of sound</p> <br>
                    <p>In other hand, normal earphone is for casual listener that fits for their comfort.</p>
                </div>
            </div>

            <div class="card1">
                <img src="<?= base_url('assets/img/fav4.png') ?>" alt="">
                <div class="card-content">
                    <h1>Different types of Drivers of an IEM</h1>
                    <p>●Dynamic Drivers <br>
                        ●Balanced Armaure Drivers <br>
                        ● Electrostatic Drivers <br>
                        ●Bone Conduction Drivers <br>
                        ●Planar Magnetic Drivers <br>
                        ●Hybrid Driver Setup</p>
                </div>
            </div>

        </div>
    </div>
    <!-- @END SECTION 3 -->

    <!-- @PHP CODE FOOTER - this includes footer.php file on every website that has this code -->
    <?php echo view("includes/footer.php"); ?>
    <!-- @PHP CODE END FOOTER  -->

    <!-- OPENS THIS MODAL IF A USER IS LOGGED OUT OR SESSION EXPIRED -->
    <div id="sessionTimeoutModal" class="modal">
        <div class="modal-content">
            <h2>Session Timeout</h2>
            <p><?= session()->getFlashdata('sessionTimeout'); ?></p>
            <button class="close-btn" id="closeModalBtn">Close</button>
        </div>
    </div>

    <!-- @SCRIPTS -->
    <script defer src="<?= base_url('assets/js/script.js') ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        <?php if (session()->getFlashdata('sessionTimeout')): ?>
            document.addEventListener('DOMContentLoaded', function() {
                const modal = document.getElementById('sessionTimeoutModal');
                modal.style.display = 'flex';
            });
        <?php endif; ?>
        document.getElementById('closeModalBtn').addEventListener('click', function() {
            const modal = document.getElementById('sessionTimeoutModal');
            modal.style.display = 'none';
        });
    </script>

    <script>
        const openModalButtons = document.querySelectorAll('[data-modal-target]');
        const closeModalButtons = document.querySelectorAll('[data-close-button]');
        const overlay = document.getElementById('overlay');

        openModalButtons.forEach(button => {
            button.addEventListener('click', () => {
                const modal = document.querySelector(button.getAttribute('data-modal-target'));
                openModal(modal);
            });
        });

        closeModalButtons.forEach(button => {
            button.addEventListener('click', () => {
                const modal = button.closest('.modal');
                closeModal(modal);
            });
        });

        overlay.addEventListener('click', () => {
            const modals = document.querySelectorAll('.modal.active');
            modals.forEach(modal => {
                closeModal(modal);
            });
        });

        function openModal(modal) {
            if (modal == null) return;
            modal.classList.add('active');
            overlay.classList.add('active');
        }

        function closeModal(modal) {
            if (modal == null) return;
            modal.classList.remove('active');
            overlay.classList.remove('active');
        }
    </script>
</body>

</html>