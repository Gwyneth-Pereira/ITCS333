<?php 
session_start();
if (!isset($_SESSION['active'])) {
	header('location: notAuthorized.php');
	exit;
}
extract($_REQUEST);

try {
	require('connection.php');
	
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
} catch (PDOException $ex) {
	echo $ex->getMessage();
	exit;
}

if(isset($bid)){

	if (trim($userbid)=='') {
		echo "Please enter your bid";
	}
	else {
		//$bidpattern   REGEX PATTERN GOES HERE 
		
		// if (preg_match($bidpattern,$userbid)) {
		try{			
			// require('connection.php');
			
			// Approach 1 with updating auction price in auctions table 
			// $sql="SELECT * FROM 'auctions' WHERE product=$pid";
			// $r=$db->query($sql); 
			// $prod=$r->fetch(PDO::FETCH_ASSOC);
			// if($prod['bid']<=$userbid){
			// 	$bidPreparedStatement=$db->prepare("UPDATE 'auctions' SET bid=? WHERE product=?");
			// 	$bidPreparedStatement->bindParam(1,$userbid);
			// 	$bidPreparedStatement->bindParam(2,$pid);
			// 	$bidPreparedStatement->execute();
			// }
			// else 
			// 	echo "Your bid is lower than the existing bid";

			// Approach 2 with keeping track of all bids in bidders table
			// $sql="SELECT * FROM 'auctions' WHERE product=$pid";
			// $r=$db->query($sql); 
			// $prod=$r->fetch();
			if($userbid < $highestBid){
				$sql=$db->prepare("INSERT INTO bidders VALUES(NULL, :auction, :bidder, :bid)");
				$sql->bindParam(':auction',$auctionid);
				$sql->bindParam(':bidder',$bidder;
				$sql->bindParam(':bid',$userbid);
				$sql->execute();
				if ($sql->rowCount() == 1) {
					$message = "";
				}
				else {
					$message = "Sorry something went wrong... Please try again";
				}
			}
			else 
				$error = "Please enter a higher bid than the current highest bid!";

			$db=null;
		} catch(PDOExecption $e){
			die("There is an Error: ".$e->getMessage());
		}
		// } // end of preg_match if-block
	}
} // end of isset(bid) if-block
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
	
	<div>
		<?php if (isset($message)) {
			echo "<h2 class='text-warning'>$message</h2>";
		} ?>
	</div>

	<form method="POST">
		<label for="bid">Current Highest Bid: <?php echo $highestBid; ?></label>
		<div><?php if(isset($error)){ echo "<p class='text-danger'>$error</p>"; } ?></div>
		<label for="bid">Your Bid: </label>
		<!-- pid = product id  -->
		<!-- Approach 2... passing the auction details from the auction selected to here -->
		<input type='hidden' name='bidder' value='<?php echo $_SESSION['username']; ?>'>
		<input type='hidden' name='auctionid' value='<?php echo $auctionid; ?>'>

		<input type="number" name="userbid" min="<?php echo $highestBid; ?>" step="any" required> <!-- step=any for decimals  -->
		<input type="submit" name="bid" value="Bid">
	</form>

<?php include 'scripts.php'; ?>
</body>
</html>