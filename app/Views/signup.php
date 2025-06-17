<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?= base_url('assets/img/logo.png') ?>" type="image/x-icon">
    <title>Sign Up</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/signupStyle.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .password-container {
            position: relative;
            width: 100%;
        }
        .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
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
        .password-input {
            width: 100%;
            padding-right: 40px;
            box-sizing: border-box;
        }
        .error-message {
            color: red;
            font-size: 12px;
            margin-top: 5px;
            display: none;
        }
        .input-block input.invalid {
            border-color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-section">
            <a href="<?= base_url('/') ?>" class="exit">&times</a>
            <h2>Sign Up</h2>
            <form action="<?= base_url("/account/signup") ?>" method="post">
                <?php $success =  session()->getFlashdata('successRegister'); if(isset($success)) {echo "<span class='success' style='color: green; text-align: center;'>" . $success . "</span>" ;} ?>
                <?= csrf_field() ?> 
                  <div class="input-group">
                    <div class="input-block">
                        <label for="fname">First Name</label>
                        <input type="text" id="fname" name="fname" placeholder="Enter Your First Name" maxlength="15" pattern="[A-Za-z]+" oninput="validateName(this)" required>
                        <span class="error-message">Only letters allowed (max 15 characters)</span>
                    </div>
                    <div class="input-block">
                        <label for="lname">Last Name</label>
                        <input type="text" id="lname" name="lname" placeholder="Enter Your Last Name" maxlength="15" pattern="[A-Za-z]+" oninput="validateName(this)" required>
                        <span class="error-message">Only letters allowed (max 15 characters)</span>
                    </div>
                </div>
                <div class="input-group">
                    <div class="input-block">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="Enter Your Email">
                    </div>
                    <div class="input-block">                        <label for="pnum">Phone Number</label>
                        <input type="tel" id="pnum" name="pnum" placeholder="Enter Your Phone Number" maxlength="11" pattern="[0-9]{11}" oninput="validatePhone(this)" required>
                        <span class="error-message">Please enter exactly 11 digits</span>
                    </div>
                </div>
               <div class="input-block">
                   <label for="user">User Name</label>
                   <input type="text" id="user" name="user" placeholder="Enter User Name">
               </div>
                <div class="input-block">
                    <label for="pass">Password</label>
                    <div class="password-container">
                        <input type="password" id="pass" name="pass" class="password-input" placeholder="Create a Password">
                        <button type="button" class="toggle-password" onclick="togglePasswordVisibility('pass', this)">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
               </div>
                <div class="input-block">
                    <label for="cpass">Confirm Password</label>
                    <div class="password-container">
                        <input type="password" id="cpass" name="cpass" class="password-input" placeholder="Confirm Password">
                        <button type="button" class="toggle-password" onclick="togglePasswordVisibility('cpass', this)">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
               </div>

                <?php $error = session()->getFlashdata('userError');?><?php if($error) { echo "<span class='error' style='color: red; text-align: center;'>" . $error . "</span>"; }?>

                <button type="submit">Sign Up</button>

                <small>Already have an Account? <a href="<?= base_url('/login') ?>">Log in</a></small>
<!-- 
                <div class="social-icons">
                    <small><a href="#"><img src="facebook-icon.png" alt="Facebook"></a></small>
                    <small><a href="#"><img src="instagram-icon.png" alt="Instagram"></a></small>              
                </div> -->
            </form>
        </div>
        <div class="image-section">
            <img src="<?= base_url('assets/img/sbg.png') ?>" alt="Image">
        </div>
    </div>
    <script>
        function validateName(input) {
            const letters = /^[A-Za-z]+$/;
            const errorMessage = input.nextElementSibling;
            
            if (!input.value.match(letters) && input.value !== '') {
                input.classList.add('invalid');
                errorMessage.style.display = 'block';
                input.value = input.value.replace(/[^A-Za-z]/g, '');
            } else {
                input.classList.remove('invalid');
                errorMessage.style.display = 'none';
            }
        }

        function validatePhone(input) {
            const numbers = /^[0-9]+$/;
            const errorMessage = input.nextElementSibling;
            
            if (!input.value.match(numbers) && input.value !== '') {
                input.classList.add('invalid');
                errorMessage.style.display = 'block';
                input.value = input.value.replace(/[^0-9]/g, '');
            } else if (input.value.length !== 11 && input.value !== '') {
                input.classList.add('invalid');
                errorMessage.style.display = 'block';
            } else {
                input.classList.remove('invalid');
                errorMessage.style.display = 'none';
            }
        }

        function togglePasswordVisibility(inputId, toggleButton) {
            const input = document.getElementById(inputId);
            const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
            input.setAttribute('type', type);
            toggleButton.querySelector('i').classList.toggle('fa-eye-slash');
        }
    </script>
</body>
</html>