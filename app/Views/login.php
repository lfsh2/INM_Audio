<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?= base_url('assets/img/logo.png') ?>" type="image/x-icon">
    <title>Log In</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/loginStyle.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>        .password-container {
            position: relative;
            width: 100%;
        }
        .toggle-password {
            position: absolute;
            right: 12px;
            top: 30%;
            transform: translateY(-50%);
            cursor: pointer;
            border: none;
            background: none;
            color: #777;
            z-index: 1;
            font-size: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
            padding: 0 8px;
        }
        .toggle-password:hover {
            color: #555;
        }
        .toggle-password:focus {
            outline: none;
        }
        .password-input {
            width: 100%;
            padding-right: 40px;
            box-sizing: border-box;
        }
    </style>
</head>
<body>
    <div class="container login">
        <div class="image-section">
            <img src="<?= base_url('assets/img/sbg.png') ?>" alt="Image">
        </div>
        <div class="form-section">
            <a href="<?= base_url('/') ?>" class="exit">&times</a>
            <h2>Log In</h2>
            <?php if(session()->getFlashdata('noAccount')) : ?>
                <span style="color: darkred; margin-button:10px;"><?= session()->getFlashdata('noAccount')?></span>
            <?php endif;?>
            <form action="<?= base_url('/account/login') ?>" method="post">
            <?= csrf_field() ?> 

                <label for="username">Username or Email</label>
                <input type="text" id="username" name="username" placeholder="Enter Your Username or Email">

                <label for="pass">Password</label>
                <div class="password-container">
                    <input type="password" id="pass" name="pass" class="password-input" placeholder="Enter your Password">
                    <i class="fas fa-eye toggle-password" onclick="togglePassword()"></i>
                </div>
                
                <?php if (session()->getFlashdata('error')): ?><p class="error" style="color: red; text-align: center;"><?= session()->getFlashdata('error') ?></p><?php endif; ?>
                <?php if(session()->getFlashdata('accountTerminated')):?><p class="error" style="color: red; text-align: center;"><?= session()->getFlashdata('accountTerminated') ?></p><?php endif;?>
                &nbsp;
                <div class="remembers">
                    <input type="checkbox" name="remember" id="remember" value="1">
                    <label for="remember">Remember me</label>
                </div>

                <div class="forgotp">
                     <a href="<?= base_url('/account/forgotPass') ?>" class="forgot-password">Forgot Password?</a>
                     <a href="<?= base_url('/signup') ?>" class="forgot-password">Create account</a>
                </div>

                <button type="submit">Log In</button>
            </form>
        </div>
    </div>
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('pass');
            const toggleIcon = document.querySelector('.toggle-password');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>