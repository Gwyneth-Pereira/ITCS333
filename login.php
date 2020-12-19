<?php 
session_start();
extract($_POST);
require('connection.php');

try{
	$hashed = sha1($password); // password_hash has an issue!... this is better function than md5 (more secure)
	$sql = $db->prepare("SELECT * FROM users WHERE username=? AND password=?;");
	
	if ($sql->execute(array($username, $hashed))){
		if($sql->rowCount()==0){
			header('location: register.php?error=incorrect');
			exit;
		}
		while($holder = $sql->fetch()){
			$_SESSION['active'] = true;
			$_SESSION['username'] = $username;
			header('location: index.php');
			exit;
		}
	}
}
catch (PDOException $e)
{
	die($e->getMessage());
}

include 'scripts.php';

?>