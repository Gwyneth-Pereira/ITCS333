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

    <?php
    $msg="";
    if(isset($_GET['error'])&& $_GET['error']=='missing'){
        $msg="Missing Information";
    }
    elseif(isset($_GET['error'])&& $_GET['error']=='wrongname'){
        $msg="Name must contain a minimum of 3 and a maximum of 30 letters, with no spaces or numbers";
    }
    elseif(isset($_GET['error'])&& $_GET['error']=='wrongemail'){
        $msg="Email must be in the format: ****@****.***";
    }
    elseif(isset($_GET['error'])&& $_GET['error']=='wrongusername'){
        $msg="Username must contain a minimum of 4 and a maximum of 30 letters, with no special characters";
    }
    elseif(isset($_GET['error'])&& $_GET['error']=='wrongpassword'){
        $msg="Password must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters";
    }
    elseif(isset($_GET['error'])&& $_GET['error']=='mismatch'){
        $msg="Passwords do not match";
    }
    elseif(isset($_GET['error'])&& $_GET['error']=='userexist'){
        $msg="Username already exists";
    }
    elseif(isset($_GET['error'])&& $_GET['error']=='emailexist'){
        $msg="Email already exists";
    }
    ?>

    <form method="POST" action="signup.php" class="form-group w-25 mx-auto text-center" data-aos="fade-down" data-aos-delay="100">
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