<?php
session_start();
extract($_REQUEST);
require('connection.php');

try {
    // $db->beginTransaction();
    if (isset($infoupdate)) {
        echo $username;
        echo $name;
        echo $email;
        $sql = $db->prepare("UPDATE users SET username=?, name=?, email=? WHERE username=?");
        $sql->execute(array($username, $name, $email, $_SESSION['username']));
        if($sql->rowCount()==1)
            header('location: profile.php?result=success');
        else 
            header('location: profile.php?result=error');

        $_SESSION['username'] = $username;
    }
    elseif (isset($passwordchange)) {
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
        else {
            header('location: profile.php?result=error');
            exit;
        }        
    }
    $db = null;    
} catch (PDOException $ex) {
    $error = $ex->getMessage();
    // echo $error;
    header("location: profile.php?result=$error");
    exit;
}
?>