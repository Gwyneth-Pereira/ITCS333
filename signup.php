<?php
session_start();
require('connection.php');
extract($_POST);
try{
	// simple validation, BUT REGEX IS REQUIRED!!
	// if (trim($name)=='' ||  trim($email)=='' ||  trim($username)=='' || trim($password)=='' || trim($cpassword)=='' || trim($DOB)==''){
	//     echo '<p>You Are Missing Information Please <a href="register.php">Try Again</a></p>';
	// }

	if (trim($name)=='' ||  trim($email)=='' ||  trim($username)=='' || trim($password)=='' || trim($cpassword)=='' || trim($DOB)=='') {
		echo '<p>You Are Missing Information Please <a href="register.php">Try Again</a></p>';
	}
	else if ($password!=$cpassword)
		echo "Passwords don't match";
	else {
		$hashed = sha1($password); // this is better function than md5 and password_hash (more secure)
		// $dob="$y-$m-$d"; // maybe this is needed to be inserted in the database
		$sql = $db->prepare("INSERT INTO users VALUES(NULL, :username, :hashed, :name, :email);");

		$sql->bindParam(':username', $username);
		$sql->bindParam(':hashed', $hashed);
		$sql->bindParam(':name', $name);
		$sql->bindParam(':email', $email);
		// $sql->bindParam(':DOB', $DOB);

		$result = $sql->execute();
		$db = null;

		if ($result==1) {
			$_SESSION['active'] = true;
			$_SESSION['username'] = $username;
			header('location: index.php');
		}
		else
			echo '<p>Something wrong happened... Please <a href="register.php">Try Again</a></p>';

	}
}
catch(PDOException $ex) {
	die("Error Message ".$ex->getMessage());
}
?>