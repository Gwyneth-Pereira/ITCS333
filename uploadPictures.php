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
</head>
<body>
	<?php include 'header.php'; ?>

	<div class="container">
		<h1>Would you like pictures</h1>
	</div>

	<form method="POST" class="form-group w-25 mx-auto text-center" enctype="multipart/form-data">
		<h2>You can upload pictures with from here</h2>
		<p>Picture: <input type="file" name="picture[]" id="picture" accept="image/*" multiple required></p>
		<p><input type="submit" name="upload" value="Upload Picture"/></p>
	</form>
	
	<a href="myAuctions.php?message=created">Skip For Now</a>
	
	<?php include 'scripts.php'; ?>
</body>
</html>

<?php 
require('connection.php');
extract($_REQUEST);

if(isset($upload)) {
	// if (!isset($picture)) {
	// 	echo "Please provide a picture to upload!";
	// 	exit();
	// }
	
	
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
		// header('location: myAuctions.php');
	} catch (PDOException $e) {
		echo $e->getMessage();
		exit;
	}
	// Add the original filename to our target path. Result is "uploads/filename.extension"
	// $destination = $destinationsss.basename($_FILES['picture']['name']);
}
?>