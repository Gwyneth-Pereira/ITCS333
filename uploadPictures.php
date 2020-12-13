<?php
session_start();
if (!isset($_SESSION['active'])) {
	header('location: notAuthorized.php');
}
// require('connection.php');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Upload Product Pictures</title>
	<?php include 'head.php'; ?>
</head>
<body>
	<?php include 'header.php'; ?>

	<div class="container">
		<h1>Would you like pictures</h1>
	</div>

	<form method="POST" class="form-group w-25 mx-auto text-center" enctype="multipart/form-data">
        
    </form>

	<a href="myAuctions.php?message=created">Skip For Now</a>
	
	<?php include 'scripts.php'; ?>
</body>
</html>