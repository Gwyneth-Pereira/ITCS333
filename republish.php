<?php
session_start();
extract($_REQUEST);

if (!isset($_SESSION['active']) || !isset($auctionid)) {
	header('location: notAuthorized.php');
	exit;
}

try {
    require('connection.php');
    
    $sql = $db->prepare("SELECT * from auctions, products WHERE auctions.id=? AND products.id=auctions.product");
    $sql->execute(array($auctionid));
    
    while ($auction = $sql->fetch()) {
        $productname = $auction['name'];
        $productcategory = $auction['category'];
        $productdetails = $auction['details'];
    }    

    if (isset($submit)){
        
        $sql = $db->prepare("UPDATE auctions SET start=NOW(), end=?, startprice=?, bid=NULL, bidder=NULL, status=? WHERE id=?");
        $sql->execute(array($end, $price, 'active', $auctionid));
        
        header("location: myAuctions.php");
        exit;
    }
    
    $db=null;
} catch (PDOException $ex) {
    echo $ex->getMessage();
    exit;
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Republish Auction</title>
	<?php include 'head.php'; ?>
</head>
<body>
	<?php include 'header.php'; ?>
	
	<form method="POST" class="form-group w-25 mx-auto text-center">
		<h1 class="font-weight-bold mb-4">Republish Auction</h1>
        
		<p class="h5 text-left font-weight-bold mt-4">Product name:</p>
        <p class="h6 font-weight-bold"><?php echo $productname; ?></p>
        
        <p class="h5 text-left font-weight-bold mt-4">Cateogry:</p>
        <p class="h6 font-weight-bold"><?php echo $productcategory; ?></p>
        
        <p class="h5 text-left font-weight-bold mt-4">Product Details:</p>
        <p class="h6 font-weight-bold"><?php echo $productdetails; ?></p>
        
		<p class="h5 text-left font-weight-bold mt-4">New Start Price:</p>
        <div class="input-group mb-3">
			<div class="input-group-prepend">
				<span class="input-group-text">BD</span>
			</div>
			<input class="form-control" type="number" step="any" name="price" placeholder="Price" required/>
		</div>
        
		<p class="h5 text-left font-weight-bold mt-4">End Time/Date:</p>
        <p><input class="form-control" type="datetime-local" id="end" name="end" step="1" value="<?php echo date('Y-m-d H:i:s'); ?>" min="<?php echo date('Y-m-d').'T'.date('H:i:s'); ?>"
		max="<?php echo (date('Y')+1).date('-m-d').'T'.date('H:i:s'); ?>" required></p>
        
        <p><input class="btn btn-outline-success" type="submit" name="submit" value="Republish Auction"></p>
    </form>
	
	<?php include 'scripts.php'; ?>
</body>
</html>