<?php
session_start();
if (!isset($_SESSION['active'])) {
	# code...
}
require('connection.php');
require('controlled.php');

extract($_REQUEST);
if (isset($signout)) {
	$_SESSION['active'] = false;
	unset($_SESSION['active']);
	unset($_SESSION['username']);
	session_destroy();
	header('location: index.php');
	exit;
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>My Project</title>
	<?php include 'head.php'; ?>
</head>
<body>
	<section id="search-hero">
		<div class="mt-5 text-center">
			<h1 class="text-white text-uppercase display-2 mx-auto " style="letter-spacing: 40px;">Auctify</h1>
			<!-- <h1 class="text-white text-uppercase h1 w-75 mx-auto my-5">Where you experience a whole new story</h1> -->
			<h1 class="text-white text-uppercase h1 w-75 mx-auto my-5">Let the Auctions begin.</h1>
			<!-- <h1 class="text-white text-uppercase h1 w-75 mx-auto my-5">It's All about Bidding</h1> -->
			
			<div class="text-left">
				<?php 
				include('search.html');
				?>
			</div>
		</div>
	</section>

	<nav class="navbar sticky-top navbar-expand-md navbar-dark bg-black px-5 mb-5" style="height: 10vh;">

		<a class="navbar-brand" href="index.php">Auctify</a>
		
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" 
		aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		
		<div class="collapse navbar-collapse" id="navbarText">
			<ul class="navbar-nav navbar-right ml-auto mr-5 align-items-center">
				<li class="nav-item">
					<a class="nav-link" href="index.php#browse">Buy</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="createAuction.php">Sell</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="myAuctions.php">My Auctions</a>
				</li>
				<?php
				if (isset($_SESSION['active'])) {
					?>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Welcome <?php echo $_SESSION['username']; ?>						</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdown">
							<a class="dropdown-item" href="profile.php">My Profile</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="index.php?signout=true">Sign Out</a>
						</div>
					</li>
					<?php
				} elseif (!isset($_SESSION['active'])) {
					echo '<li class="nav-item">';
						echo '<a id="register" class="nav-link" href="register.php">Login/Register</a>';
					echo '</li>';
				} ?>
			</ul>	
		</div>
	</nav>

	<section id="browse">
		<?php include 'browseAuctions.php'; ?>
	</section>
	
	<?php include 'scripts.php'; ?>
</body>
</html>