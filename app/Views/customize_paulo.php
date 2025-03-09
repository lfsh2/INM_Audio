<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- @ICON -->
	<link rel="shortcut icon" href="<?= base_url('assets/img/logo.png') ?>" type="image/x-icon">
	<!-- CSS LINKS -->
	<link rel="stylesheet" href="<?= base_url('assets/css/customize.css') ?>">
	<link rel="stylesheet" href=" <?= base_url('assets/css/navbar.css') ?>">
    <link rel="stylesheet" href=" <?= base_url('assets/css/footer.css') ?>">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
	<link rel="stylesheet" href="<?= base_url('react-app/assets/index-DQWRZbZt.css') ?>">
	<title>INM Costumization</title>
</head>

<body class="body-container">
	<!-- Header -->
	<?php echo view("includes/header.php"); ?>

	<!-- React App Container -->
	<div id="root">
	</div>

	<!-- Footer -->
		<?php echo view("includes/footer.php"); ?>
	<!-- Load React App -->
	<script src="<?= base_url('react-app/assets/index-C_v6LAyl.js') ?>" type="module"></script>
	
</body>

</html>