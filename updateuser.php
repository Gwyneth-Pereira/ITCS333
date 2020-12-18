<?php
session_start();
extract($_REQUEST);
require('connection.php');

$namepattern="/^[a-zA-Z]{3,}(?:\s[a-zA-Z]{3,})+$/";
$emailpattern="/^[a-zA-Z0-9._-]+@[a-zA-Z0-9]+\.[a-zA-Z]{2,5}$/";
$usernamepattern="/^[a-zA-Z0-9_.-]{4,30}$/";
$passwordpattern="/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/";

try{
    // $db->beginTransaction();
    if (isset($infoupdate)){
        if ($JSEnabled=="FALSE"){ // PHP VALIDATION
            if (trim($name)=='' || trim($email)=='' || trim($username)==''){
                header('location:profile.php?error=missing');
                exit;
            }
            else if (!preg_match($namepattern,$name)){
                header('location:profile.php?error=wrongname');
                exit;	
            }
            else if (!preg_match($emailpattern,$email)){
                header('location:profile.php?error=wrongemail');
                exit;
            }
            else if (!preg_match($usernamepattern,$username)){
                header('location:profile.php?error=wrongusername');
                exit;
            }
        }
        echo $username;
        echo $name;
        echo $email;
        $sql = $db->prepare("UPDATE users SET username=?, name=?, email=? WHERE username=?");
        $sql->execute(array($username, $name, $email, $_SESSION['username']));
        if($sql->rowCount()==1){
            header('location: profile.php?result=success');
        }
        else{
            header('location: profile.php?result=error');
        }
        $_SESSION['username'] = $username;
    }
    elseif (isset($passwordchange)){
        if($JSEnabled=="FALSE"){ // PHP VALIDATION
            if(trim($oldpassword)=='' || trim($password)=='' || trim($cpassword)==''){
                header('location:profile.php?error=missing');
                exit;
            }
            if (!preg_match($passwordpattern,$password)){
                header('location:profile.php?error=wrongpassword');
                exit;
            }
        }
        $sql = $db->prepare("SELECT password FROM users WHERE username=?");
        
        if ($sql->execute(array($_SESSION['username']))){
            while($holder = $sql->fetch()){
                $current = $holder['password'];
                $oldpassword = sha1($oldpassword);
                if ($oldpassword == $current) {
                    if ($cpassword==$password) {
                        // All Good... Change Passwords
                        $hashed = sha1($password);
                        $sql = $db->prepare("UPDATE users SET password = :hashed WHERE username = :username;");
                        $sql->bindParam(':hashed', $hashed);
                        $sql->bindParam(':username', $_SESSION['username']);
                        $sql->execute();
                    }
                    else {
                        // confirmed password doesn't match the first new password
                        header('location: profile.php?passwordchange=1&error=mismatch');
                        exit;
                    }
                }
                else {
                    // old password is incorrect
                    header('location: profile.php?passwordchange=1&error=oldincorrect');
                    exit;
                }
            }
        }
        if($sql->rowCount()==1){
            header('location: profile.php?result=success');
            exit;
        }
        else{
            header('location: profile.php?result=error');
            exit;
        }        
    }
    $db = null;    
} catch (PDOException $ex) {
    $error = $ex->getMessage();
    header("location: profile.php?result=$error");
    exit;
}
?>