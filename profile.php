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

	<div class="container">
		
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
						require('connection.php');
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
				<div class="row">
				<div class="col-12">
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
				</div>
				<?php
				} // end of if infoupdate
				elseif (isset($passwordchange)) { 
					?>
				<div class="row">
				<div class="col-12">
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
				</div>
				<?php
				} // end of if passwordchange
				else {
					try{
						require('connection.php');
						$username = $_SESSION['username'];
						$sql = $db->prepare("SELECT * FROM auctions, ratings WHERE ratings.auctionid = auctions.id AND owner=?");
						$sql->execute(array($username));
						$holder = $sql->fetchAll();
						
						if (isset($holder['buyerRating'])) {
							$sellerRating = $holder['buyerRating'];
							
						} else {
							$sellerRating = 'Not Rated Yet';
						}
						
						$sql = $db->prepare("SELECT * FROM auctions, ratings WHERE ratings.auctionid = auctions.id AND bidder=?");
						$sql->execute(array($username));
						$holder = $sql->fetchAll();

						if (isset($holder['sellerRating'])) {
							$buyerRating = $holder['sellerRating'];
							
						} else {
							$buyerRating = 'Not Rated Yet';
						}

						$sql = $db->prepare("SELECT * FROM users WHERE username=?");
						if ($sql->execute(array($username))){
							while ($info = $sql->fetch(PDO::FETCH_ASSOC)) {   
								$name = $info['name'];
								$username = $info['username'];
								$email = $info['email'];
								if (isset($info['picture'])) {
									$picture = $info['picture'];
									$image = "images/users/$picture";
								} else {
									$image = "images/users/default-avatar.png";
								}

							}
						}
						?>
						<h1 class="display-4 text-left mb-5">My Profile</h1>
						<div class="row">
						<div class="col-4 pr-5 border-right">
							<div id="picture" class="text-center mb-5">
								<div class="rounded-circle mb-3">
									<img src="<?php echo $image; ?>" style="max-height: 13rem;">
								</div>
								<a href="" class="h6 text-center mx-auto text-secondary">Edit Profile Picture</a>
							</div>
							
							<div id="rating">
								<p class="h6 mb-4">
									Buyer Rating: 
									<span class="h5">
										<?php echo $buyerRating; ?>
									</span>
								</p>
								
								
								<p class="h6">
									Seller Rating:
									<span class="h5">
										<?php echo $sellerRating; ?>
									</span>
								</p>


							</div>
						</div>
						
						<div class="col-8 pl-5">
							<div id="info">
								<p class="h2 mb-4"><?php echo $name ?></p>
								<p class="h5 mb-2">Username: <?php echo $username ?></p>
								<p class="h5 mb-5">Email: <?php echo $email ?></p>

								<a href="myAuctions.php" class="h5 text-danger"><u>Go to My Auctions</u></a>
							</div>
							
							<div id="settings" class="mt-5">
								<h3>Account Settings</h3>
								<hr>
								<form method='POST'>
									<input type='submit' name='infoupdate' class="btn btn-lg btn-outline-dark" value='Edit Information'/>
									<input type='submit' name='passwordchange' class="btn btn-lg btn-outline-danger" value='Change Password'/>
								</form>
							</div>
						</div>
						<?php
					}
					catch(PDOExecption $e){
						die ("ERROR:".$e->getMessage());
					}
				}
				?>
		</div>
	</div>

    <?php include 'scripts.php'; ?>
</body>
</html>