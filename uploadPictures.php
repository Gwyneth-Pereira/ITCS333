<?php 
require('connection.php');
extract($_REQUEST);

if(isset($upload)) {

	try {
		
		// Counting number of pictures
		$quantity = count($_FILES['picture']['name']);
		
		// Looping all pictures
		for($i=0; $i < $quantity; $i++){
			
			$extension = pathinfo($_FILES["picture"]["name"][$i], PATHINFO_EXTENSION);
			
			// How to ensure uniquness of filename?
			$filename = "pic".time().uniqid(rand()).".$extension";
			
			$destination = "images/products/".$filename;

			// Insert picture into db
			$sql = $db->prepare("INSERT INTO pictures VALUES(NULL, :product, :filename);");
			$sql->bindParam(':product', $productid);
			$sql->bindParam(':filename', $destination);
			
			if ($sql->execute()){
				// Upload picture into folder
				move_uploaded_file($_FILES['picture']['tmp_name'][$i], $destination);
			}
			else
				echo "There was an error uploading the file, please try again!";
		}
		header('location: myAuctions.php');
		exit;
	} catch (PDOException $ex) {
		echo $ex->getMessage();
		exit;
	}
	// Add the original filename to our target path. Result is "uploads/filename.extension"
	// $destination = $destinationsss.basename($_FILES['picture']['name']);
}
?>
<?php
session_start();
if (!isset($_SESSION['active'])) {
	header('location: notAuthorized.php');
}
// require('connection.php');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Upload Product Pictures</title>
	<?php include 'head.php'; ?>
	<!-- <style>
		footer {
			background-color: #222;
			color: #fff;
			font-size: 14px;
			bottom: 0;
			position: fixed;
			left: 0;
			right: 0;
			text-align: center;
			z-index: 999;
		}
	</style> -->
</head>
<body>
	<?php include 'header.php'; ?>

	<div class="container">
		<h1 class="font-weight-bold mb-5">Upload Product Pictures</h1>
		<form method="POST" class="form-group w-50 mx-auto text-center" enctype="multipart/form-data">
			
			<p ><input style="margin-top:30%" type="file" name="picture[]" id="picture" class="form-control" accept="image/*" multiple required></p>
			<div class="mt-5">
			<input type="submit" class="btn btn-danger" name="upload"  value="Upload Picture"/>
			<a href="myAuctions.php?message=created" class="btn btn-lg text-primary">Skip For Now</a>
			</div>
		</form>
	</div>
	<!-- <footer>
	<p>
		Created with <i class="fa fa-heart"></i> by
		<a target="_blank" href="https://florin-pop.com">Florin Pop</a>
		- Read how I created this and how you can join the challenge
		<a target="_blank" href="https://www.florin-pop.com/blog/2019/03/double-slider-sign-in-up-form/">here</a>.
	</p>
</footer> -->
	
	
	<?php include 'scripts.php'; ?>
</body>
</html>
