<?php
session_start();
if (!isset($_SESSION['active'])) {
	# code...
}
require('connection.php');
require('controlled.php');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>My Project</title>
	<?php include 'head.php'; ?>
</head>
<body>
	<?php include 'header.php'; ?>

	<div class="container">
		<h1>This is the home page</h1>
	</div>
	<?php include 'scripts.php'; ?>
</body>
</html>