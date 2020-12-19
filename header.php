<?php
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
<nav class="navbar navbar-expand-lg navbar-dark bg-black px-5 mb-5">

	<a class="navbar-brand" href="index.php">Auctify</a>
	
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" 
	aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
	
	<div class="collapse navbar-collapse" id="navbarText">
		<ul class="navbar-nav navbar-right ml-auto mr-5 align-items-center">
			<?php echo '<li class="nav-item">';
			include('search.html');
			echo '</li>';?>
			<!-- <li class="nav-item">
				<a id="Home" class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
			</li> -->
			<li class="nav-item">
				<a class="nav-link" href="createAuction.php">Create</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="myAuctions.php">My Auctions</a>
			</li>

			<?php 
			// echo '<li class="nav-item">';
			// 	echo '<a class="nav-link" href="createAuction.php">Create Auction</a>';
			// echo '</li>';
			if (isset($_SESSION['active'])) {
				?>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					My Profile
					</a>
					<div class="dropdown-menu" aria-labelledby="navbarDropdown">
						<a class="dropdown-item" href="profile.php">Settings</a>
						<div class="dropdown-divider"></div>
						<!-- <a class="dropdown-item" href="">Action</a> -->
						<a class="dropdown-item" href="index.php?signout=true">Sign Out</a>
					</div>
				</li>
				<!-- <li class="nav-item dropdown">
					<a id="Profile" class="nav-link dropdown-toggle" href="#Profile" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" 
					aria-haspopup="true" aria-expanded="false">
					Profile
					</a>
					<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
						<a class="dropdown-item" href="profile.php">Settings</a>
						<div class="dropdown-divider"></div>
						<p><input type="submit" name="signout" value="Sign Out" class="dropdown-item"></p>
					</div>
				</li> -->
				<?php
				// echo '<li class="nav-item">';
				// 	echo '<a id="profile" class="nav-link" href="profile.php">Profile</a>';
				// echo '</li>';
			} elseif (!isset($_SESSION['active'])) {
				echo '<li class="nav-item">';
					echo '<a id="login" class="nav-link" href="login.php">Login</a>';
				echo '</li>';
				echo '<li class="nav-item">';
					echo '<a id="register" class="nav-link" href="register.php">Register</a>';
				echo '</li>';
			} ?>
		</ul>	
	</div>
</nav>