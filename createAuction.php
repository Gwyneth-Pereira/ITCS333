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
	<title>My Project</title>
	<?php include 'head.php'; ?>
</head>
<body>
	<?php include 'header.php'; ?>

	<form action=".php" method="POST" class="form-group w-25 mx-auto text-center">
        <h1 class="font-weight-bold mb-4">Create Auction</h1>
        <p>Product name:</p>
        <p><input class="form-control" type="text" name="name" placeholder="Product Name"/></p>
        <p>Cateogry:</p>
        <p>
        	<select class="form-control" type='text' name='category' placeholder="Category"/>
        	<option>Art</option>
        	<option>Books</option>
        	<option>Clothings</option>
        	<option>Electronics</option>
        	<option>Health and Beauty</option>
        	<option>Pets</option>
        	<option>Vehicles</option>
        	<option>Video Games</option>
        	<option>Other</option>
        	</select>
        </p>
        <p>Product Details:</p>
        <p><textarea class="form-control" rows="5" cols="20" type='details' name='details' placeholder="Product Details"></textarea></p>
        <p>Price:</p>
        <p><input class="form-control" type="text" name="price" placeholder="Price"/></p>
        <p>End Time/Date:</p>
        <p><input type="datetime-local" id="meeting-time" name="meeting-time" value="<?php echo date('Y-m-d H:i:s'); ?>" min="<?php echo date('Y-m-d').'T'.date('H:i:s'); ?>"
         max="<?php echo (date('Y')+1).date('-m-d').'T'.date('H:i:s'); ?>"></p>
        
        <p><input class="btn btn-danger" type="submit" name="submit" value="Create Auction"></p>
    </form>

	<?php include 'scripts.php'; ?>
</body>
</html>