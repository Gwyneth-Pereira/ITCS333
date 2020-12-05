<?php 
session_start();
extract($_GET);
require('connection.php');

?>
<!DOCTYPE html>
<html>
<head>
	<title>Login Page</title>
</head>
<body>
<?php 
if(!isset($_SESSION['active'])) {
?>
	<form method="GET">
		<p>Username:</p>
		<p><input type="text" name="username"></p>
		<p>Password:</p>
		<p><input type="password" name="password"></p>
		<p><input type="submit" name="submit" value="Login"></p>
	</form>
<?php
} 
elseif(isset($_SESSION['active']) && $_SESSION['active']){	
	$username = $_SESSION['username'];
	echo "<h1 class='text-primary'>Hello $username, Welcome to the Auction System</h1>";
}
elseif(isset($submit)){
	try{
        $hashed = password_hash($password, PASSWORD_DEFAULT); // this is better function than md5 (more secure)
		$sql = $db->prepare("SELECT * FROM users WHERE username=? AND password=?;");
		$holder = $sql->execute(array($username, $hashed));

		// if ($rs->rowCount()==1)
		// {
		if($user=$holder->fetch())
		{
			$_SESSION['active'] = true;
        	$_SESSION['username'] = $username;
			header('location: login.php');
		}
		else {
			echo "<h1 style='color: red;'>SORRY INCORRECT</h1>";
			die("Sorry Username or Password is incorrect!");
		}
		// }				
	}
	catch (PDOException $e)
	{
		die($e->getMessage());
	}
	// }
	exit;
} // END OF IF isset(submit)


// elseif (isset($signout)) {
// 	$_SESSION['active'] = false;
// 	unset($_SESSION['username']);
// 	session_destroy();
// 	header('location: index.php');
// }
?>
</body>
</html>