<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout Cancelled</title>
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

        .cancel-container {
            background-color: #ffffff;
            border: 3px solid #d93025;
            border-radius: 15px;
            padding: 40px;
            text-align: center;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            max-width: 400px;
            width: 100%;
            animation: fadeIn 0.5s ease-in-out;
        }

        .cancel-container h1 {
            color: #d93025;
            margin-bottom: 15px;
            font-size: 28px;
        }

        .cancel-container p {
            color: #333;
            margin-bottom: 20px;
            font-size: 16px;
        }

        .btn {
            display: inline-block;
            padding: 12px 30px;
            background-color: #d93025;
            color: #fff;
            text-decoration: none;
            border-radius: 8px;
            transition: background 0.3s ease;
        }

        .btn:hover {
            background-color: #b71c1c;
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
    <div class="cancel-container">
        <h1><i class="fas fa-times-circle"></i> Payment Cancelled</h1>
        <p>Your payment was not successful. Please try again or contact support if the issue persists.</p>
        <a href="<?= base_url('/cart') ?>" class="btn">Return to Cart</a>
    </div>
</body>
</html>
