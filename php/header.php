<?php 
session_start();
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-black px-5">
	
	<a class="navbar-brand" href="../index.php">Auction System</a>
	
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" 
	aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
	
	<div class="collapse navbar-collapse" id="navbarText">
		<ul class="navbar-nav navbar-right ml-auto mr-5 align-items-center">
			<li class="nav-item">
				<a id="Home" class="nav-link" href="../index.php">Home <span class="sr-only">(current)</span></a>
			</li>
			<!-- <li class="nav-item dropdown">
				<a id="Exercises" class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" 
				aria-haspopup="true" aria-expanded="false">
				  #
				</a>
				<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
					<a class="dropdown-item" href="exercise1.php">Exercise 1</a>
					<a class="dropdown-item" href="matrix.php">Multiplication Table</a>
					<a class="dropdown-item" href="exercise3.php">Online Shopping</a>
					<a class="dropdown-item" href="timecookie.php">Time Cookie</a>
					<a class="dropdown-item" href="shopping.php">Shopping Cart</a>
					<div class="dropdown-divider"></div>
					<a class="dropdown-item" href="project.php">Project</a>
				</div>
			</li> -->
		<?php if (isset($_SESSION['Logged'])) {
					echo '<li class="nav-item">';
						echo '<a id="profile" class="nav-link" href="../account/profile.php">Profile</a>';
					echo '</li>';
			 } elseif (!isset($_SESSION['Logged'])) {
					echo '<li class="nav-item">';
						echo '<a id="login" class="nav-link" href="../account/login.php">Login</a>';
					echo '</li>';
					echo '<li class="nav-item">';
						echo '<a id="register" class="nav-link" href="../account/register.php">Register</a>';
					echo '</li>';
			 } ?>
		</ul>	
	</div>
</nav>