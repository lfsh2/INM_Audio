<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout Successful</title>
    <script>
        // Redirect to index page after 3 seconds
        setTimeout(function() {
            window.location.href = "<?= base_url('/') ?>";
        }, 3000);
    </script>
    <style>
        body {
            display: flex;
            height: 100vh;
            justify-content: center;
            align-items: center;
            background-color: #f9f9f9;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .success-container {
            background-color: #ffffff;
            border: 3px solid #34a853;
            border-radius: 15px;
            padding: 40px;
            text-align: center;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            max-width: 400px;
            width: 100%;
            animation: fadeIn 0.5s ease-in-out;
        }

        .success-container h1 {
            color: #34a853;
            margin-bottom: 15px;
            font-size: 28px;
        }

        .success-container p {
            color: #333;
            margin-bottom: 20px;
            font-size: 16px;
        }

        .btn {
            display: inline-block;
            padding: 12px 30px;
            background-color: #34a853;
            color: #fff;
            text-decoration: none;
            border-radius: 8px;
            transition: background 0.3s ease;
        }

        .btn:hover {
            background-color: #1e7e34;
        }

        .icon {
            font-size: 60px;
            color: #34a853;
            margin-bottom: 15px;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>
    <div class="success-container">
        <div class="icon">
            <i class="fas fa-check-circle"></i>
        </div>
        <h1>Payment Successful!</h1>
        <p>Thank you for your purchase. Your order has been successfully processed.</p>
        <a href="<?= base_url('/shop') ?>" class="btn">Continue Shopping</a>
    </div>
</body>
</html>
