<?php
session_start();
if (!isset($_SESSION['active'])) {
	header('location: notAuthorized.php');
	exit;
}
extract($_REQUEST);
?>
<!DOCTYPE html>
<html>
<body>
<?php  



try{

	//product ID has to be extracted 
	require('connection.php');
	$sql= "SELECT * FROM 'auctions' WHERE product=$pid";
		$r=$db->query($sql); 
		$au=$r->fetch(PDO::FETCH_ASSOC);
	$sql= "SELECT * FROM 'products' WHERE id=$pid"; //might change with what attribute submitted 
		$r=$db->query($sql); 
		$pr=$r->fetch(PDO::FETCH_ASSOC);

	echo "<h1>Auction Details:</h1>";

	//picturefile in folder
	//echo "<img src=picturefile/".$product['picture'].">";
	echo "<h3>Product:</h3>";
	echo $pr['name'];
	echo "<h3>Category:</h3>";
	echo $pr['Category'];
	echo "<h3>Product Details:</h3>";
	echo $pr['details'];
	echo "<h3>Starting Bid:</h3>";
	echo $au['startprice'];
	echo "<h3>Highest Bid:</h3>";
	echo $au['bid'];
	echo "<h3>Start date:</h3>";
	echo $au['start'];
	echo "<h3>End date:</h3>";
	echo $au['end'];
	echo "<h3>Time Left:</h3>";
	//Assign timezone????
	$hours=gmdate("G", $au['end'] - time());
	$minutes=gmdate("i", $au['end'] - time());
	echo $hours." hours and ".$minutes." minutes left";
	echo "<h3>Owner:</h3>";
	echo $au['owner'];
	echo "<a href='makeabid.php'>Make a bid</a>"; //THIS WILL CHANGE WITH JS

	$db=null;
} catch(PDOExecption $e){
	die ("ERROR:".$e->getMessage());
}
?>

</body>
</html>
