<?php
session_start();
if (!isset($_SESSION['active'])) {
	header('location: notAuthorized.php');
    exit;
}
extract($_REQUEST);
require('connection.php');
require('controlled.php');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>My Profile</title>
    <?php include 'head.php'; ?>
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
				<form method="POST" action="updateuser.php" class="form-group w-50 mx-auto text-left">
					<h1 class="font-weight-bold mb-4 text-center">Update Account Information</h1>
					<label class="h5 mt-0">Username</label>
					<p><input class="form-control " type='text' name='username' value="<?php echo $username; ?>"/></p>
					<label class="h5 mt-0">Full Name:</label>
					<p><input class="form-control " type='text' name='name' value="<?php echo $name; ?>"/></p>
					<label class="h5 mt-0">Email:</label>
					<p><input class="form-control " type='email' name='email' value="<?php echo $email; ?>"/></p>
					<p class="text-center"><input class="btn btn-outline-dark m-3" type="submit" name="infoupdate" value="Update Account Info">
					<!-- <input class="btn btn-outline-danger m-3" type="submit" name="passwordchange" value="Change Password"></p> -->
				</form>
				<?php
				} // end of if infoupdate
				elseif (isset($passwordchange)) { 
					?>
				<form method="POST" action="updateuser.php" class="form-group w-25 mx-auto text-center">
					<h1 class="font-weight-bold mb-5">Change Password</h1>
					
					<?php 
					if (isset($error) && $error=='oldincorrect')
						echo '<label class="h6 text-danger text-left">Current Password Incorrect!</label>';
					?>	
					<!-- <label class="h5 mt-0">Old Password:</label> -->
					<p><input class="form-control form-control-lg" type='password' name='oldpassword' placeholder="Current Password"/></p>
					<!-- <label class="h5 mt-0">New Password:</label> -->
					<p><input class="form-control form-control-lg" type='password' name='password' placeholder="New Password"/></p>
					<!-- <label class="h5 mt-0">Confirm Password:</label> -->
					<p><input class="form-control form-control-lg" type='password' name='cpassword' placeholder="Confirm Password"/></p>
					<?php 
					if (isset($error) && $error=='mismatch')
						echo '<label class="h6 text-danger text-left mt-0">Confirm Password Does Not Match!</label>';
					?>	
					<p><input class="btn btn-lg btn-outline-dark m-4" type="submit" name="passwordchange" value="Change Password"></p>
				</form>
				<?php
				} // end of if passwordchange
				else {
					echo "<table border='1' align='center' width='300'>";
					echo "<tr>";
					echo "<th>Name</th>";
					echo "<th>Username</th>";
					echo "<th>Email</th>";
					echo "<th colspan='2'>Update</th>";
					echo "</tr>";
					$username = $_SESSION['username'];
					$sql = $db->prepare("SELECT * FROM users WHERE username=?");
					
					if ($sql->execute(array($username))){
						while ($info = $sql->fetch()) {   
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