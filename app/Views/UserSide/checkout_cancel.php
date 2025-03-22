<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Cancelled ❌</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/styles.css'); ?>">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .container {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            max-width: 400px;
            animation: fadeIn 1s ease-in-out;
        }
        .cancel-icon {
            font-size: 80px;
            color: #dc3545;
            animation: shake 0.5s infinite alternate;
        }
        h2 {
            color: #333;
        }
        p {
            color: #666;
            font-size: 18px;
        }
        .btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            transition: 0.3s;
        }
        .btn-danger {
            background: #dc3545;
            color: white;
        }
        .btn-danger:hover {
            background: #c82333;
        }

        @keyframes shake {
            0% { transform: translateX(-5px); }
            100% { transform: translateX(5px); }
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="cancel-icon">❌</div>
        <h2>Payment Cancelled</h2>
        <p>Your payment has been cancelled. If this was a mistake, please try again.</p>
        <a href="<?= base_url('/') ?>" class="btn btn-danger">Go Back</a>
    </div>
</body>
</html>
