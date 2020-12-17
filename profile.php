<?php
session_start();
if (!isset($_SESSION['active'])) {
	header('location: notAuthorized.php');
    exit;
}
extract($_REQUEST);

require('controlled.php');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>My Profile</title>
    <?php include 'head.php'; ?>

	<script>
		var nameFlag=emailFlag=usernameFlag=false;

		function checkName(name){
			var nameExp=/^[a-zA-Z]{3,}(?:\s[a-zA-Z]{3,})+$/;
			if (name.length==0){
			m="";
			nameFlag=false;
			}
			else if (!nameExp.test(name)){
				m="Please enter your first and last name seperated by a space";
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

		function checkUserInputs(){
			document.forms[0].JSEnabled.value="TRUE";
			return (nameFlag && emailFlag && usernameFlag);
		}
	</script>
	<script>
		var passwordFlag=false;
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
			document.forms[1].JSEnabled.value="TRUE";
			return (passwordFlag);
		}
	</script>

</head>
<body>
    <?php include 'header.php'; ?>

    <?php if (!$_SESSION['active']) {
        header('location: notAuthorized.php');
    } ?>
	<div class="container">
		<div class="row">
			<div class="col-12">
				<?php 
				if (isset($result) && $result=='success')
					echo '<h2 class="text-success text-center">Update Successful!</h2>';
				elseif (isset($result) && $result=='error')
					echo '<h2 class="text-danger text-center">Sorry Update Failed!</h2>';
				?>

			<?php
				if (isset($infoupdate)) {
					$username = $_SESSION['username'];
					try {
						$info = $db->query("SELECT * FROM users WHERE username='$username';");
						if ($holder = $info->fetch()) {
							$name = $holder['name'];
							$email = $holder['email'];
						}
						$db = null;
					} catch (PDOException $ex) {
						die($ex->getMessage());
					}
					?>

				<form onSubmit="return checkUserInputs();" method="POST" action="updateuser.php" class="form-group w-50 mx-auto text-left">
					<h1 class="font-weight-bold mb-4 text-center">Update Account Information</h1>
					<label class="h5 mt-0">Username</label>
					<p><input class="form-control " type='text' name='username' value="<?php echo $username; ?>" onkeyup="checkUsername(this.value)"/><span id='umsg'></span></p>
					<label class="h5 mt-0">Full Name:</label>
					<p><input class="form-control " type='text' name='name' value="<?php echo $name; ?>" onkeyup="checkName(this.value)"/><span id='nmsg'></span></p>
					<label class="h5 mt-0">Email:</label>
					<p><input class="form-control " type='email' name='email' value="<?php echo $email; ?>" onkeyup="checkEmail(this.value)"/><span id='emsg'></span></p>
					<input type='hidden' name='JSEnabled' value='FALSE' />
					<?php
					if (isset($error) && $error=='missing'){
						echo '<label class="h6 text-danger text-left">Missing Information</label>';
					}
					elseif (isset($error) && $error=='wrongname'){
						echo '<label class="h6 text-danger text-left">Name must contain a minimum of 3 and a maximum of 30 letters, with no spaces or numbers</label>';
					}
					elseif (isset($error) && $error=='wrongemail'){
						echo '<label class="h6 text-danger text-left">Email must be in the format: ****@****.***</label>';
					}
					elseif (isset($error) && $error=='wrongusername'){
						echo '<label class="h6 text-danger text-left">Username must contain a minimum of 4 and a maximum of 30 letters, with no special characters</label>';
					}
					?>
					<p class="text-center"><input class="btn btn-outline-dark m-3" type="submit" name="infoupdate" value="Update Account Info">
				</form>
				<?php
				} // end of if infoupdate
				elseif (isset($passwordchange)) { 
					?>
				<form onSubmit="return checkUserInputs();" method="POST" action="updateuser.php" class="form-group w-25 mx-auto text-center">
					<h1 class="font-weight-bold mb-5">Change Password</h1>
					<!-- <label class="h5 mt-0">Old Password:</label> -->
					<p><input class="form-control form-control-lg" type='password' name='oldpassword' placeholder="Current Password"/></p>
					<!-- <label class="h5 mt-0">New Password:</label> -->
					<p><input class="form-control form-control-lg" type='password' name='password' placeholder="New Password" onkeyup="checkPassword(this.value)"/><span id='pmsg'></span></p>
					<!-- <label class="h5 mt-0">Confirm Password:</label> -->
					<p><input class="form-control form-control-lg" type='password' name='cpassword' placeholder="Confirm Password"/></p>
					<input type='hidden' name='JSEnabled' value='FALSE' />
					<?php 
					if (isset($error) && $error=='missing'){
						echo '<label class="h6 text-danger text-left">Missing Information</label>';
					}
					elseif (isset($error) && $error=='oldincorrect'){
						echo '<label class="h6 text-danger text-left">Current Password Incorrect!</label>';
					}
					elseif (isset($error) && $error=='mismatch'){
						echo '<label class="h6 text-danger text-left mt-0">Confirm Password Does Not Match!</label>';
					}
					elseif (isset($error) && $error=='wrongpassword'){
						echo '<label class="h6 text-danger text-left">Password must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters</label>';
					}	
					?>	
					<p><input class="btn btn-lg btn-outline-dark m-4" type="submit" name="passwordchange" value="Change Password"></p>
				</form>
				<?php
				} // end of if passwordchange
				else {
					try{
						require('connection.php');
					echo "<table border='1' align='center' width='300'>";
					echo "<tr>";
					echo "<th>Name</th>";
					echo "<th>Username</th>";
					echo "<th>Email</th>";
					echo "<th colspan='2'>Update</th>";
					echo "</tr>";
					$username = $_SESSION['username'];
					$sql = $db->prepare("SELECT * FROM users WHERE username=?");
					if ($sql->execute(array($_SESSION['username']))){
						while ($info = $sql->fetch(PDO::FETCH_ASSOC)) {   
							echo "<tr>";
							echo "<td>".$info['name']."</td>";
							echo "<td>".$info['username']."</td>";
							echo "<td>".$info['email']."</td>";
							echo "<td><form method='POST'><input type='submit' name='infoupdate' value='Change Information'/></form></td>";
							echo "<td><form method='POST'><input type='submit' name='passwordchange' value='Change Password'/></form></td>";
							echo "</tr>";
						}
					}
					echo "</table>";
				}
			catch(PDOExecption $e){
		die ("ERROR:".$e->getMessage());
			}
			}
				?>

			</div>
			<div class="col-6">

			</div>
			<div class="col-6">

			</div>
		</div>
	</div>

    <?php include 'scripts.php'; ?>
</body>
</html>