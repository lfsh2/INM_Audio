<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('assets/css/shopp.css') . '?v=' . time(); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/navbar.css') . '?v=' . time(); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/footer.css') . '?v=' . time(); ?>">
    <link rel="shortcut icon" href="<?= base_url('assets/img/logo.png') ?>" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <title>INM Shop</title>
</head>

<body>
    <?php echo view("includes/header.php"); ?>

    <div class="shop">
        <div class="shop-title">
            <h2>Our Products</h2>
        </div>

        <div class="card-container">
            <div class="category-section">
                <div class="category-title">
                    <h3>Vanilla Series</h3>
                    <p class="series-description">The vanilla series is designed for those craving for a detailed sound. While being balanced and airy overall, these focus more on providing a technical sound signature ensuring your cravings for detail is satisfied.</p>
                </div>
                <div class="category-items">
                    <div class="library-card">
                        <img src="<?= base_url('assets/img/products/inm1.jpg') ?>" alt="INM1">
                        <div class="info">
                            <h3>INM1 (Vanilla Series)</h3>
                            <p class="price">Starting at ₱10,000</p>
                            <p class="description">The INM1 Vanilla is the entry level in the Vanilla Series which also jump started the brand. It was the first model in all of the line-up<br><br>
                            Driver Configuration: 1 Balanced Armature Driver<br>
                            Driver Details: 1x Full-range<br>
                            <p class="turnaround">Our current turnaround time is 8-10 weeks.</p>
                        </div>
                        <div class="button">
                            <div class="customize-block">
                                <a href="<?= base_url('/customize?series=vanilla&model=inm1') ?>" class="customize-btn">Customize Now</a>
                                <a href="#" class="bookmark-link">
                                    <i class="fas fa-bookmark-o"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="library-card">
                        <img src="<?= base_url('assets/img/products/inm2.jpg') ?>" alt="INM2">
                        <div class="info">
                            <h3>INM2 (Vanilla Series)</h3>
                            <p class="price">Starting at ₱14,500</p>
                            <p class="description">The INM2 Vanilla is a fuller sounding INM1 Vanilla with a bit more smoothness in its presentation. An overall smoother, relaxed sound without sacrificing details.<br><br>
                            Driver Configuration: 2 Balanced Armature Driver<br>
                            Driver Details: 2x Full-range<br>
                            <p class="turnaround">Our current turnaround time is 8-10 weeks.</p>
                        </div>
                        <div class="button">
                            <div class="customize-block">
                                <a href="<?= base_url('/customize?series=vanilla&model=inm2') ?>" class="customize-btn">Customize Now</a>
                                <a href="#" class="bookmark-link">
                                    <i class="fas fa-bookmark-o"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="library-card">
                        <img src="<?= base_url('assets/img/products/inm3.jpg') ?>" alt="INM3">
                        <div class="info">
                            <h3>INM3 (Vanilla Series)</h3>
                            <p class="price">Starting at ₱23,800</p>
                            <p class="description">The INM3 Vanilla is seated on top of the Vanilla Series. It sounds thinner than most sets but it delivers a really energetic presentation in the upper frequencies<br><br>
                            Driver Configuration: 3 Balanced Armature Driver<br>
                            Driver Details: 1x Woofer, 2x Mid-High<br>
                            <p class="turnaround">Our current turnaround time is 8-10 weeks.</p>
                        </div>
                        <div class="button">
                            <div class="customize-block">
                                <a href="<?= base_url('/customize?series=vanilla&model=inm3') ?>" class="customize-btn">Customize Now</a>
                                <a href="#" class="bookmark-link">
                                    <i class="fas fa-bookmark-o"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="category-section">
                <div class="category-title">
                    <h3>Stage Series</h3>
                    <p class="series-description">The stage series is designed with musicians, performers, and engineers in mind. The added low-end punch fills in the gaps not present in the vanilla series; providing a more engaging and satisfying experience while still maintaining a neutral sound signature. A true workhorse for the stage and studio.</p>
                </div>
                <div class="category-items">
                    <!-- INM2 Stage -->
                    <div class="library-card">
                        <img src="<?= base_url('assets/img/products/inm4.jpg') ?>" alt="INM1 Stage">
                        <div class="info">
                            <h3>INM1 Stage</h3>
                            <p class="price">Starting at ₱13,000</p>
                            <p class="description">The INM2 Stage is one of the most versatile sets in the lineup. Despite leaning warm and relaxed, it delivers a very detailed sound, which punches above from its price range. It is still fairly neutral with a really good bloom in the lower end of the frequency range.<br><br>
                            Driver Configuration: 2 Balanced Armature Driver<br>
                            Driver Details: 1x Woofer, 1x Mid-High<br>
                            <p class="turnaround">Our current turnaround time is 8-10 weeks.</p>
                        </div>
                        <div class="button">
                            <div class="customize-block">
                                <a href="<?= base_url('/customize?series=stage&model=inm1') ?>" class="customize-btn">Customize Now</a>
                                <a href="#" class="bookmark-link">
                                    <i class="fas fa-bookmark-o"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="library-card">
                        <img src="<?= base_url('assets/img/products/inm3s.png') ?>" alt="INM2 Stage">
                        <div class="info">
                            <h3>INM3 Stage</h3>
                            <p class="price">Starting at ₱19,000</p>
                            <p class="description">The INM3 Stage is the mid-tier IEMs in the Stage Series. A really good all rounder for people who loves a really good low-end response and a sparkly presentation in the upper midrange and upper frequency range.<br><br>
                            Driver Configuration: 3 Balanced Armature Driver<br>
                            Driver Details: 2x Low-Mid, 1x Mid-High<br>
                            <p class="turnaround">Our current turnaround time is 8-10 weeks.</p>
                        </div>
                        <div class="button">
                            <div class="customize-block">
                                <a href="<?= base_url('/customize?series=stage&model=inm3') ?>" class="customize-btn">Customize Now</a>
                                <a href="#" class="bookmark-link">
                                    <i class="fas fa-bookmark-o"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="library-card">
                        <img src="<?= base_url('assets/img/products/inm3-stage.jpg') ?>" alt="INM3 Stage">
                        <div class="info">
                            <h3>INM3 Stage</h3>
                            <p class="price">Starting at ₱26,000</p>
                            <p class="description">The INM4 Stage is the top of the line in the Stage Series. Sounding fuller from the previous sets, its bass punches more but still retains the upper end sparkle. A really good contender for musicians who need an all rounder both on stage and off stage.<br><br>
                            Driver Configuration: 4 Balanced Armature Drivers<br>
                            Driver Details: 1x Woofer, 2x Low-Mid, 1x High<br>
                            <p class="turnaround">Our current turnaround time is 8-10 weeks.</p>
                        </div>
                        <div class="button">
                            <div class="customize-block">
                                <a href="<?= base_url('/customize?series=stage&model=inm4') ?>" class="customize-btn">Customize Now</a>
                                <a href="#" class="bookmark-link">
                                    <i class="fas fa-bookmark-o"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="category-section">
                <div class="category-title">
                    <h3>Prestige Series</h3>
                    <p class="series-description">The prestige series is our newest in the line-up and is designed for those who want the best of the best. These models are tuned to provide the best sound its price can offer; a unique and luxurious experience that is sure to satisfy even the most discerning audiophiles.</p>
                </div>
                <div class="category-items">
                    <div class="library-card prestige">
                        <img src="<?= base_url('assets/img/products/prestige.jpg') ?>" alt="INM Virtuoso">
                        <div class="group">
                            <div class="info">
                                <h3>INM Virtuoso</h3>
                                <p class="price">Starting at ₱55,000</p>
                                <p class="description">The INM8 Prestige was made with one thing in mind: Delivering an absolutely great experience within a reasonable price. INM8 Prestige kick-started the Prestige series, targeting a sound that is unbelievable to achieve with in-ears. INM8 Prestige boasts its really fast and tight low-end, lot of perception of space and air that leads to a great out of the head experience especially from an in-ear monitor.<br>
                                • Proprietary crossover technology<br>
                                • Extended frequency range<br>
                                • Premium materials throughout<br>
                                Driver Configuration: 8 Balanced Armature Drivers<br>
                                Driver Details: 2x Woofer, 2x Low-Mid, 2x High, 1x Ultra-high<br>
                                <p class="turnaround">Our current turnaround time is 8-10 weeks.</p>
                            </div>
                            <div class="button">
                                <div class="customize-block">
                                    <a href="<?= base_url('/customize?series=prestige&model=virtuoso') ?>" class="customize-btn">Customize Now</a>
                                    <a href="#" class="bookmark-link">
                                        <i class="fas fa-bookmark-o"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php echo view("includes/footer.php"); ?>
</body>

</html>
