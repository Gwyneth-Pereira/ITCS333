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

    <script>
        var nameFlag=emailFlag=usernameFlag=passwordFlag=false;

        function checkName(name){
          var nameExp=/^[a-zA-Z]{​​​​​3,}​​​​​(?: [a-zA-Z]+){​​​​​0,1}​​​​​$/;
          if (name.length==0){
            m="";
            nameFlag=false;
          }
          else if (!nameExp.test(name)){
              m="Invalid Name: minimum of 3 and a maximum of 30 letters, with no spaces or numbers";
              c="red";
              nameFlag=false;
            }
          else{
              m="Valid Name";
              c="green";
              nameFlag=true;
            }
          document.getElementById('nmsg').style.color=c;
          document.getElementById('nmsg').innerHTML=m;
        }

        function checkEmail(email){
          var emailExp=/^[a-zA-Z0-9._-]+@[a-zA-Z0-9]+\.[a-zA-Z]{2,5}$/;
          if (email.length==0){
            m="";
            emailFlag=false;
          }
          else if (!emailExp.test(email)){
              m="Invalid Email: must be in the format ****@****.***";
              c="red";
              emailFlag=false;
            }
          else{
              m="Valid Email";
              c="green";
              emailFlag=true;
            }
          document.getElementById('emsg').style.color=c;
          document.getElementById('emsg').innerHTML=m;
        }

        function checkUsername(username){
          var unameExp=/^[a-zA-Z0-9_.-]{4,30}$/;
          if (username.length==0){
            m="";
            usernameFlag=false;
          }
          else if (!unameExp.test(username)){
              m="Invalid Username: must contain a minimum of 4 and a maximum of 30 letters, with no special characters";
              c="red";
              usernameFlag=false;
            }
          else{
              m="Valid Username";
              c="green";
              usernameFlag=true;
            }
          document.getElementById('umsg').style.color=c;
          document.getElementById('umsg').innerHTML=m;
        }

        function checkPassword(password){
          var passwordExp=/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/;
          if (password.length==0){
            m="";
            passwordFlag=false;
          }
          else if (!passwordExp.test(password)){
              m="Invalid Password: must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters";
              c="red";
              passwordFlag=false;
            }
          else{
              m="Valid Password";
              c="green";
              passwordFlag=true;
            }
          document.getElementById('pmsg').style.color=c;
          document.getElementById('pmsg').innerHTML=m;
        }

        function checkUserInputs(){
          document.forms[0].JSEnabled.value="TRUE";
          return (nameFlag && emailFlag && usernameFlag && passwordFlag);
        }

      </script>

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
    ?>

    <form method="POST" action="signup.php" class="form-group w-25 mx-auto text-center" onSubmit="return checkUserInputs();">
        <h1 class="font-weight-bold mb-4">Sign Up</h1>
        <!-- <p>Name:</p> -->
        <p><input class="form-control" type='text' name='name' placeholder="Full Name" onkeyup="checkName(this.value)"/><span id='nmsg'></span></p>
        <!-- <p>Email:</p> -->
        <p><input class="form-control" type='email' name='email' placeholder="Email" onkeyup="checkEmail(this.value)"/><span id='emsg'></span></p>
        <!-- <p>Username:</p> -->
        <p><input class="form-control" type='text' name='username' placeholder="Username" onkeyup="checkUsername(this.value)"/><span id='umsg'></span></p>
        <!-- <p>Password:</p> -->
        <p><input class="form-control" minlength="8" type='password' name='password' placeholder="Password" onkeyup="checkPassword(this.value)"/><span id='pmsg'></span></p>
        <!-- <p>Confirm Password:</p> -->
        <p><input class="form-control" minlength="8" type='password' name='cpassword' placeholder="Confirm Password"/></p>
        <p><input class="btn btn-danger" type="submit" name="submit" value="Sign Up"></p>
    </form>
    <h3 class='text-danger'><?php echo $msg;?></h3>

    <?php include 'scripts.php'; ?>
</body>
</html>