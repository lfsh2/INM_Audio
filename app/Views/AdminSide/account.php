<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?= base_url('assets/img/logo.png') ?>" type="image/x-icon">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="<?= base_url('Admin/css/account.css') ?>">
    <link rel="stylesheet" href="<?= base_url('Admin/css/dashboard1.css') ?>">
    <title>Account | Setting</title>
    <style>
        /* SIDE NAV WHEN IN THIS PAGE */
        #account { background-color: #d4ebf844; }
        aside nav ul #account    span { opacity: 1;}
    </style>
</head>
<body>
<!-- 
// * INCLUDE THE SIDE NAVIGATION FILE *
-->
<?php echo view('AdminSide/includes/sideNav1') ?>


<!-- 
// * MAIN CONTENT *
-->
<section id="content">	
    <?php echo view('AdminSide/includes/topNavbar') ?>
    
    <main class="account">
        <div class="head-title">
            <div class="left">
                <h1>Account</h1>
                <ul class="breadcrumb">
                    <!-- <li>
                        <a href="#">Dashboard</a>
                    </li>
                    <li><i class='bx bx-chevron-right' ></i></li>
                    <li>
                        <a class="active" href="#">Home</a>
                    </li> -->
                </ul>
            </div>
            <a href="#" class="btn-download">
                <i class='bx bxs-cloud-download' ></i>
                <span class="text">Download PDF</span>
            </a>
        </div>

        <div class="validation">
            <h3>Manage your account</h2>
            <?php if(session()->getFlashdata('successUpdateProfile')) :?>
                <span style="color: green;">
                    <?= session()->getFlashdata('successUpdateProfile'); ?>
                </span>
            <?php endif;?>
            <?php if(session()->getFlashdata('existingUsername')) :?>
                <span style="color: red;">
                    <?= session()->getFlashdata('existingUsername'); ?>
                </span>
            <?php endif;?>
            <?php if(session()->getFlashdata('existingEmail')) :?>
                <span style="color: red;">
                    <?= session()->getFlashdata('existingEmail'); ?>
                </span>
            <?php endif;?>
            <?php if(session()->getFlashdata('existingBoth')) :?>
                <span style="color: red;">
                    <?= session()->getFlashdata('existingBoth'); ?>
                </span>
            <?php endif;?>
            <?php if(session()->getFlashdata('passwordErr')) :?>
                <span style="color: red;">
                    <?= session()->getFlashdata('passwordErr'); ?>
                </span>
            <?php endif;?>
        </div>

        <div class="container">
            <form action="<?= base_url('/admin/updateAccount') ?>" method="post" enctype="multipart/form-data">
                <div class="profile-pic">
                    <div class="img-block">
                        <?php if($adminAccount && $adminAccount['profile_pic'] != null) : ?>
                            <img src="data:image/jpeg;base64,<?= base64_encode($adminAccount['profile_pic']) ?>" alt="">
                        <?php else: ?>
                            <img src="<?= base_url('Admin/img/icons/account.png') ?>" alt="">
                        <?php endif;?>
                            <input type="file" class="file-inputs" id="profile_pic" name="profile_pic" accept="image/*">
                    </div>

                    <h3><?= $adminAccount['username']?></h3>
                </div>

                <div class="input-container">
                    <div class="input-block">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="Set Email" value="<?= $adminAccount['email']?>">
                    </div>

                    <div class="input-block">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" placeholder="Set username" value="<?= $adminAccount['username']?>">
                    </div>

                    <div class="input-block">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" placeholder="Set username" value="<?= $adminAccount['username']?>">
                    </div>

                    <div class="input-block">
                        <label for="cpass">Current Password</label>
                        <input type="password" id="cpass" name="cpass" placeholder="Enter current password">
                    </div>
                    
                    <div class="input-block">
                        <label for="pass">New Password</label>
                        <input type="password" id="pass" name="pass" placeholder="Set new password">
                    </div>

                    <div class="buttons">
                        <button type="submit" class="save">Save Changes</button>
                        <a href="<?= base_url('/admin/deleteAccount/'. session()->get('admin_id')) ?>">
                            <button onclick="return confirm('Are you sure you want to delete this Account?\nyou will be redirected to homepage')" class="delete">Delete Account</button>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </main>
</section>

<!-- SCRIPTS - for switching tabs -->
<script src="<?= base_url('Admin/js/dashboard1.js') ?>"></script>
</body>
</html>