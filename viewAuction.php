<?php
session_start();

// No need here to check logging in... because guests can browse... but not bid... logging verifying should be in bid.php
// if (!isset($_SESSION['active'])) { 
// 	header('location: notAuthorized.php');
// 	exit;
// }

extract($_REQUEST);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>View Auction</title>
	<?php include 'head.php'; ?>
</head>
<body>
	<?php include 'header.php'; ?>

<?php  
try{
	//product ID has to be extracted 
	require('connection.php');
	$sql = $db->prepare("SELECT * FROM auctions WHERE product=?");
	$sql->execute(array($productid));
	$auctions = $sql->fetch(PDO::FETCH_ASSOC);
	
	$sql = $db->prepare("SELECT * FROM products WHERE id=?"); //might change with what attribute submitted
	$sql->execute(array($productid));
	$products = $sql->fetch(PDO::FETCH_ASSOC);
	
	// Retrieving highest bid and bidder
	$sql = $db->prepare("SELECT * FROM bidders WHERE auction=?");
	$sql->execute(array($auctionid));
	$highestBid = 0;
	while ($holder = $sql->fetch()) {
		if ($highestBid < $holder['bid']) {
			$highestBid = $holder['bid'];
			$highestBidder = $holder['bidder'];
		}
	}

	echo "<h1>Auction Details:</h1>";

	//picturefile in folder
	//echo "<img src=picturefile/".$products['picture'].">";
	echo "<h3>Product:</h3>";
	echo $products['name'];
	echo "<h3>Category:</h3>";
	echo $products['category'];
	echo "<h3>Product Details:</h3>";
	echo $products['details'];
	echo "<h3>Owner:</h3>";
	echo $auctions['owner'];
	echo "<h3>Starting Bid:</h3>";
	echo $auctions['startprice'];
	echo "<h3>Current Highest Bid:</h3>";
	echo "$highestBid by $highestBidder";
	echo "<h3>Start date:</h3>";
	echo $auctions['start'];
	echo "<h3>End date:</h3>";
	echo $auctions['end'];
	// echo "<h3>Time Left:</h3>";
	// //Assign timezone????
	// $hours=gmdate("G", $auctions['end'] - time());
	// $minutes=gmdate("i", $auctions['end'] - time());
	// echo $hours." hours and ".$minutes." minutes left";
	echo "<p><a href='bid.php?auctionid=$auctionid&productid=$productid'>Bid on Auction</a></p>"; // THIS WILL CHANGE WITH JS

	$db=null;
} catch(PDOExecption $e){
	die ("ERROR:".$e->getMessage());
}
?>

	<?php include 'scripts.php'; ?>
</body>
</html>