<?php
// session_start();
require 'connection.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Register Page</title>
    <?php include 'head.php'; ?>
</head>
<body>
    <?php include 'header.php'; ?>


    <form method="POST" action="signup.php">
        <p>Name:</p>
        <p><input type='text' name='name'/></p>
        <p>Email:</p>
        <p><input type='email' name='email'/></p>
        <p>Username:</p>
        <p><input type='text' name='username'/></p>
        <p>Password:</p>
        <p><input type='password' name='password'/></p>
        <p>Confirm Password:</p>
        <p><input type='password' name='cpassword'/></p>
        <p>Date of Birth:</p>
        <p><input type="date" name="DOB"></p>
    </form>

    <?php include 'scripts.php'; ?>
</body>
</html>