<?php
session_start();
require('connection.php');
extract($_POST);

$namepattern="/^[a-zA-Z]{3,}(?:\s[a-zA-Z]{3,})+$/";
$emailpattern="/^[a-zA-Z0-9._-]+@[a-zA-Z0-9]+\.[a-zA-Z]{2,5}$/";
$usernamepattern="/^[a-zA-Z0-9_.-]{4,30}$/";
$passwordpattern="/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/";

try{
	//check if email and username already exist
	
	if ($JSEnabled=="FALSE"){ // PHP VALIDATION
		if (trim($name)=='' || trim($email)=='' || trim($username)=='' || trim($password)=='' || trim($cpassword)==''){
			header('location:register.php?error=missing');
			exit;
		}
		else if (!preg_match($namepattern,$name)){
			header('location:register.php?error=wrongname');
			exit;	
		}
		else if (!preg_match($emailpattern,$email)){
			header('location:register.php?error=wrongemail');
			exit;
		}
		else if (!preg_match($usernamepattern,$username)){
			header('location:register.php?error=wrongusername');
			exit;
		}
		else if (!preg_match($passwordpattern,$password)){
			header('location:register.php?error=wrongpassword');
			exit;
		}
		else if ($password!=$cpassword){
			header('location:register.php?error=mismatch');
			exit;
	  }
	}
	else{

		$usersql="SELECT * FROM users WHERE username='$username'";
		$emailsql="SELECT * FROM users WHERE email='$email'";
		$user=$db->query($usersql);
		$email=$db->query($emailsql);

		if($user->rowCount() > 0){ //username exists
			header('location:register.php?error=userexist');
			exit;
		}

		elseif($email->rowCount() > 0){ //email exists
			header('location:register.php?error=emailexist');
			exit;
		}
		
		else{
			$hashed = sha1($password); // this is better function than md5 and password_hash (more secure)
			$sql = $db->prepare("INSERT INTO users VALUES(NULL, :username, :hashed, :name, :email, NULL);");

			$sql->bindParam(':username', $username);
			$sql->bindParam(':hashed', $hashed);
			$sql->bindParam(':name', $name);
			$sql->bindParam(':email', $email);
			

			$result = $sql->execute();
			$db = null;

			if ($result==1){
				$_SESSION['active'] = true;
				$_SESSION['username'] = $username;
				header('location: index.php');
			}
			else{
				echo '<p>Something wrong happened... Please <a href="register.php">Try Again</a></p>';
			}
		}

	}
}
catch(PDOException $ex) {
	die("Error Message ".$ex->getMessage());
}
?>