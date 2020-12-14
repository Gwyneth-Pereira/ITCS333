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
		<h2>You can upload pictures with your ID from here</h2>
		<p>Filename: <input type="file" name="picfile" width="800"/></p>
		<input type="hidden" name="sid" value="<?php echo $sid; ?>">
		<p><input type="submit" name="submit" value="Upload Picture"/></p>
	</form>

	<a href="myAuctions.php?message=created">Skip For Now</a>
	
	<?php include 'scripts.php'; ?>
</body>
</html>

<?php 
require('connection.php');
extract($_POST);

if(isset($submit)) {
	if (!isset($picfile)) {
		echo "Please provide a file to upload!";
		exit();
	}
	// How to ensure uniquness of filename?
	$fdetails = explode(".",$_FILES["picfile"]["name"]);
	$ext = end($fdetails);
	$filename = "pic".time().uniqid(rand()).".$ext";

	$target_path = "images/products/".$filename."#";

	try {
		$sql = $db->prepare("INSERT INTO studentpictures VALUES(NULL, :sid, :filename);");
		$sql->bindParam(':sid', $sid);
		$sql->bindParam(':filename', $filename);
		if ($sql->execute())
			echo "The file ".basename( $_FILES['picfile']['name'])." has been uploaded as: ".$filename;
		else
		    echo "There was an error uploading the file, please try again!";

		if (move_uploaded_file($_FILES['picfile']['tmp_name'], $target_path)) {
		    // echo "The file ".basename( $_FILES['picfile']['name'])." has been uploaded";
		} else{
		    // echo "There was an error uploading the file, please try again!";
		}

	} catch (PDOException $e) {
		echo $e->getMessage();
		exit;
	}
	// Add the original filename to our target path. Result is "uploads/filename.extension"
	// $target_path = $target_pathsss.basename($_FILES['picfile']['name']);
}

// header('location: uploadStudentPictures.php');
?>