<?php
session_start();
require 'connection.php'; 
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>My Project</title>
    <?php include 'head.php'; ?>
</head>
<body>
    <?php include 'header.php'; ?>


    <form method="POST" action="signup.php">
        <p>Name: <input name='name'/></p>
        <p>Username: <input name='username'/></p>
        <p>Password: <input type='password' name='password'/></p>
        <p>Confirm Password: <input type='password' name='cpassword'/></p>
        <p>Date of Birth: <input type="date" name="DOB"></p>
    </form>

    <?php include 'scripts.php'; ?>
</body>
</html>