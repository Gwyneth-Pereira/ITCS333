<?php
session_start();
require('controlled.php');
extract($_REQUEST);

// No need here to check logging in... because guests can browse... but not bid... logging verifying should be in bid.php
// if (!isset($_SESSION['active'])) { 
// 	header('location: notAuthorized.php');
// 	exit;
// }

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
	require('connection.php');


	$sql = $db->prepare("SELECT * FROM auctions WHERE id=?");
	$sql->execute(array($auctionid));
	$auctions = $sql->fetch(PDO::FETCH_ASSOC);
	$productid = $auctions['product'];

	$sql = $db->prepare("SELECT * FROM products WHERE id=?");
	$sql->execute(array($pid));
	$products = $sql->fetch(PDO::FETCH_ASSOC);
	
	// Retrieving highest bid and bidder
	
	if ($auction = $auctions) {
		$highestBid = $auctions['bid'];
		$highestBidder = $auctions['bidder'];
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
	if (isset($highestBid)) {
		echo "$highestBid by $highestBidder";
	} else {
		echo "No Bids Yet!";
	}
	
	echo "<h3>Start date:</h3>";
	echo $auctions['start'];
	echo "<h3>End date:</h3>";
	echo $auctions['end'];
	
	// echo "<h3>Time Left:</h3>";
	// //Assign timezone????
	// $hours=gmdate("G", $auctions['end'] - time());
	// $minutes=gmdate("i", $auctions['end'] - time());
	// echo $hours." hours and ".$minutes." minutes left";
if($auctions['status']=="active"&&$auctions['owner']!=$_SESSION['username'])
echo "<p><a href='bid.php?auctionid=$auctionid'>Bid on Auction</a></p>";// THIS WILL CHANGE WITH JS
	elseif ($auctions['status']!="active") 
		echo "You can no longer bid on this auction!";
	
	include('questionbar.php');
	


	$db=null;
} catch(PDOExecption $e){
	die ("ERROR:".$e->getMessage());
}
?>

	<?php include 'scripts.php'; ?>
</body>
</html>