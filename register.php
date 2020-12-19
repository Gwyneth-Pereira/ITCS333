<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Register Page</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">

</head>
<body>
    
    <?php
    $msg="";
    $signinmsg="";
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
    elseif (isset($_GET['error']) && $_GET['error']=='incorrect'){
        $signinmsg="Incorrect Username or Password";
    }
    ?>

    <div class="container" id="container">
        <div class="form-container sign-up-container">

                <!-- REGISTER FORM -->
            <form method="POST" action="signup.php" onSubmit="return checkUserInputs();">
                <h1 class="mb-5">Create Account</h1>
                <!-- <p>Name:</p> -->
                <input required type='text' name='name' placeholder="Full Name" onkeyup="checkName(this.value)"/><span id='nmsg'></span>
                <!-- <p>Email:</p> -->
                <input  required type='email' name='email' placeholder="Email" onkeyup="checkEmail(this.value)"/><span id='emsg'></span>
                <!-- <p>Username:</p> -->
                <input required type='text' name='username' placeholder="Username" onkeyup="checkUsername(this.value)"/><span id='umsg'></span>
                <!-- <p>Password:</p> -->
                <input  required minlength="8" type='password' name='password' placeholder="Password" onkeyup="checkPassword(this.value)"/><span id='pmsg'></span>
                <!-- <p>Confirm Password:</p> -->
                <input  required minlength="8" type='password' name='cpassword' placeholder="Confirm Password"/>
                <input type='hidden' name='JSEnabled' value='FALSE' />
                <h3 class='text-danger mb-4 mt-4'><?php echo $msg;?></h3>
                <button>SIGN UP</button>
                <!-- <p><input type="submit" name="submit" value="Sign Up"></p> -->
            </form>
        
        </div>
        <div class="form-container sign-in-container">

            <!-- SIGN IN FORM -->
            <form method="POST" action="login.php">
                <h1 class="mb-5">Sign in</h1>
                    <input class="form-control form-control-lg" type="text" name="username" placeholder="Username" required>
                    <input class="form-control form-control-lg" type="password" name="password" placeholder="Password" required>
                    <h3 class='text-danger mb-4 mt-4'><?php echo $signinmsg;?></h3>
                    <button>SIGN IN</button>
                    <!-- <p><input type="submit" name="login" value="Sign in"></p> -->
            </form>

        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Welcome Back!</h1>
                    <p>To keep connected with us please login with your personal info</p>
                    <button class="ghost" id="signIn">Sign In</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>Hello, Friend!</h1>
                    <p>Enter your personal details and start journey with us</p>
                    <button class="ghost" id="signUp">Sign Up</button>
                </div>
            </div>
        </div>
    </div>

    <?php include 'scripts.php'; ?>
    <script type="text/javascript" src="js/jsvalidation.js"></script>
    <script type="text/javascript" src="js/login.js"></script>
</body>
</html>