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


    <form method="POST" action="signup.php" class="form-group w-25 mx-auto text-center">
        <h1 class="font-weight-bold mb-4">Sign Up</h1>
        <!-- <p>Name:</p> -->
        <p><input class="form-control" type='text' name='name' placeholder="Full Name"/></p>
        <!-- <p>Email:</p> -->
        <p><input class="form-control" type='email' name='email' placeholder="Email"/></p>
        <!-- <p>Username:</p> -->
        <p><input class="form-control" type='text' name='username' placeholder="Username"/></p>
        <!-- <p>Password:</p> -->
        <p><input class="form-control" minlength="8" type='password' name='password' placeholder="Password"/></p>
        <!-- <p>Confirm Password:</p> -->
        <p><input class="form-control" minlength="8" type='password' name='cpassword' placeholder="Confirm Password"/></p>
        <p><input class="btn btn-danger" type="submit" name="submit" value="Sign Up"></p>
    </form>

    <?php include 'scripts.php'; ?>
</body>
</html>