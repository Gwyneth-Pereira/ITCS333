<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	
	<title>Unauthorized</title>
	<?php include 'head.php'; ?>
</head>
<body>
	<?php include 'header.php'; ?>
	
	<div class="container py-5 mt-5">
		<div class="row">
			<div class="col-4 text-right">
				<img src="images/unicorn.png" style="width: 60%;">
			</div>
			<div class="col-8 text-center mt-md-5">
				<h2 class="h2 text-dark text-uppercase font-weight-bold">Unicorns don't exist...</h2>
				<h2 class="h1 text-danger text-uppercase font-weight-bold">neither does this page.</h2>
				<p class="h5 font-weight-bold">(404 ERROR)</p>
				<br><br>
				<div class="text-center px-3 px-md-5 mx-3 mx-md-5">
					<p class="h5">We're not sure what happened to the unicorns, but we have some guesses as to what happened to this page.</p>
					<p class="h6 my-4 text-warning font-weight-bold">This page is under construction...<br>We have big plans for this page, so come back often.</p>
					<p class="h4"><a href="login.php" class="text-danger"><u>Please Login From Here</u></a></p>
				</div>
			</div>
		</div>
	</div>

	<?php include 'scripts.php'; ?>
</body>
</html>