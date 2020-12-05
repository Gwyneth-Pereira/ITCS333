<?php 
session_start();
extract($_POST);
require('connection.php');

?>
<!DOCTYPE html>
<html>
<head>
	<title>Login Page</title>
</head>
<body>
<?php 
if (!isset($_SESSION['Logged'])) {
 ?>
	<form method="POST">
		<p>Username: <input type="text" name="username"></p>
		<p>Password: <input type="password" name="password"></p>
		<p><input type="submit" name="submit" value="Login"></p>
	</form>
<?php
} 
elseif (isset($_SESSION['Logged'])) {
?>	
	<h1 style='color: red;'>You are logged in as <?php echo $_SESSION['Logged']; ?></h1>

	<button><a href="displayStudentGrades.php">Display Student Grades</a></button>
	<button><a href="uploadStudentPictures.php">Upload Student Pictures</a></button>
<?php 	
	exit;
}
elseif(isset($submit)) {
		try{
			$hashed = md5($password);
			$sql = "SELECT * FROM users WHERE UID='$username' AND password='$hashed'";
			$rs = $db->query($sql);

			// if ($rs->rowCount()==1)
			// {
				if($user=$rs->fetch())
				{
					$_SESSION['Logged'] = $user['UID'];
		        	$_SESSION['type'] = $user['type'];
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
elseif (isset($signout)) {
	unset($_SESSION['Logged']);
	unset($_SESSION['type']);
	session_destroy();
	header('location: login.php');
}
?>
</body>
</html>