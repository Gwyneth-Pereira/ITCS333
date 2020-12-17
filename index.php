<?php
session_start();
if (!isset($_SESSION['active'])) {
	# code...
}
require('connection.php');
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


	<h2>Search</h2>
	<form action="">
		<input type="search">
		<input type="submit">
	</form>

	</div>
	<?php include 'scripts.php'; ?>
</body>
</html>