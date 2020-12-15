<?php
session_start();
if (!isset($_SESSION['active'])) {
	header('location: notAuthorized.php');
	exit;
}
// require('connection.php');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Create New Auction</title>
	<?php include 'head.php'; ?>
</head>
<body>
	<?php include 'header.php'; ?>

	<form method="POST" class="form-group w-25 mx-auto text-center">
        <h1 class="font-weight-bold mb-4">Create Auction</h1>
        
		<p class="h5 text-left font-weight-bold mt-4">Product name:</p>
        <p><input class="form-control" type="text" name="name" placeholder="Product Name" required/></p>
        
		<p class="h5 text-left font-weight-bold mt-4">Cateogry:</p>
        <p>
        	<select class="form-control" type='text' name='category' placeholder="Category">
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
        <p class="h5 text-left font-weight-bold mt-4">Product Details:</p>
        <p><textarea class="form-control" rows="5" cols="20" maxlength="200" type='details' name='details' placeholder="Product Details"></textarea></p>
        
		<p class="h5 text-left font-weight-bold mt-4">Start Price:</p>
        <div class="input-group mb-3">
			<div class="input-group-prepend">
    			<span class="input-group-text">$</span>
  			</div>
			<input class="form-control" type="number" step="any" name="price" placeholder="Price" required/>
		</div>
        
		<p class="h5 text-left font-weight-bold mt-4">End Time/Date:</p>
        <p><input class="form-control" type="datetime-local" id="end" name="end" step="1" value="<?php echo date('Y-m-d H:i:s'); ?>" min="<?php echo date('Y-m-d').'T'.date('H:i:s'); ?>"
         max="<?php echo (date('Y')+1).date('-m-d').'T'.date('H:i:s'); ?>" required></p>
        
        <p><input class="btn btn-danger" type="submit" name="submit" value="Create Auction"></p>
    </form>

	<?php include 'scripts.php'; ?>

<?php
extract($_POST);

if (isset($submit)) {
	try {
		require('connection.php');
		
		$db->beginTransaction();
		
		$sql = $db->prepare("INSERT INTO products VALUES(NULL, ?, ?, ?, NULL)");
		$sql->execute(array($name, $details, $category));
		
		$productid = $db->lastInsertId();
		
		$sql = $db->prepare("INSERT INTO auctions VALUES(NULL, ?, ?, NOW(), ?, ?, ?)");
		$sql->execute(array($_SESSION['username'], $productid, $end, $price, 'active'));
		
		$db->commit();
		// $db=null;
	} catch (PDOException $ex) {
		$db->rollBack();
		echo $ex->getMessage();
		exit;
	}

	header('location: uploadPictures.php?productid=$productid');
}
?>
</body>
</html>