<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<?php include 'head.php'; ?>
</head>
<body>
	<?php include 'header.php'; ?>
	<div>
		<h1>You are not authorized to be here</h1>
		<h1><a href="login.php">Please Login First From Here</a></h1>
	</div>
	
	<?php include 'scripts.php'; ?>
</body>
</html>