<?php 
session_start();
extract($_POST);
require('connection.php');

?>
<!DOCTYPE html>
<html>
<head>
	<title>Login Page</title>
	<?php include 'head.php'; ?>
</head>
<body>
	<?php include 'header.php'; ?>
	<div class="container pt-5">
<?php 
if(isset($login)){
	try{
		$hashed = sha1($password); // password_hash has an issue!... this is better function than md5 (more secure)
		$sql = $db->prepare("SELECT * FROM users WHERE username=? AND password=?;");
		
		if ($sql->execute(array($username, $hashed))){
			if($sql->rowCount()==0){
				header('location: login.php?error=incorrect');
			}
			while($holder = $sql->fetch()){
				$_SESSION['active'] = true;
				$_SESSION['username'] = $username;
				header('location: index.php');
			}
		}
	}
	catch (PDOException $e)
	{
		die($e->getMessage());
	}
	// }
	exit;
} // END OF IF isset(login)
elseif(!isset($_SESSION['active'])) {
	if (isset($_GET['error']) && $_GET['error']=='incorrect'){
		echo "<h1 class='h4 text-danger text-center'>Sorry Incorrect Username or Password</h1>";
	}
	?>
	<form method="POST">
		<!-- <p>Username:</p> -->
		<!-- <p>Password:</p> -->
		<div class="form-group text-center w-50 mx-auto">
			<p><input class="form-control form-control-lg" type="text" name="username" placeholder="Username"></p>
			<p><input class="form-control form-control-lg" type="password" name="password" placeholder="Password"></p>
			<p><input class="btn btn-lg btn-outline-success" type="submit" name="login" value="Login"></p>
		</div>
	</form>
<?php
} 
elseif(isset($_SESSION['active']) && $_SESSION['active']){	
	$username = $_SESSION['username'];
	echo "<h1 class='text-primary'>Hello $username, Welcome to the Auction System</h1>";
	?>
	<form method="POST">
		<h1>Do you want to Sign Out?!</h1>
		<p><input type="submit" name="signout" value="Sign Out"></p>
	</form>
<?php
	if (isset($signout)) {
		$_SESSION['active'] = false;
		unset($_SESSION['active']);
		unset($_SESSION['username']);
		session_destroy();
		header('location: index.php');
	}
}
?>

	</div>

	<?php include 'scripts.php'; ?>
</body>
</html>
