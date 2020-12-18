<?php 
session_start();
if (!isset($_SESSION['active'])) {
	header('location: notAuthorized.php');
	exit;
}
require('controlled.php');
extract($_REQUEST);
try {
	require('connection.php');
	
	// Retrieving highest bid and bidder
	$sql = $db->prepare("SELECT * FROM auctions WHERE id=?");
	$sql->execute(array($auctionid));
	if ($auction = $sql->fetch()) {
		$highestBid = $auction['bid'];
		$highestBidder = $auction['bidder'];
		$startPrice = $auction['startprice'];
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
		try{
			$bidder = $_SESSION['username'];

			if($userbid > $highestBid){
				// $sql=$db->prepare("UPDATE auctions SET bid=:bid AND bidder=:bidder WHERE id=:auction");
				// $sql->bindParam(':bid', $userbid);
				// $sql->bindParam(':bidder', $bidder);
				// $sql->bindParam(':auction', $auctionid);
				$sql=$db->prepare("UPDATE auctions SET bid=?, bidder=? WHERE id=?");
				$sql->execute(array($userbid, $bidder, $auctionid));
				if ($sql->rowCount() == 1) {
					header('location: myAuctions.php?message=bid');
					exit;
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
	

	<form method="POST">
		<label for="bid">Current Highest Bid: 
		<?php if (isset($highestBid)) {
			echo $highestBid;
		} else {
			$highestBid = $startPrice;
			echo "starting at $highestBid BD";
		}
		?></label>
		<div><?php if(isset($error)){ echo "<p class='text-danger'>$error</p>"; } ?></div>
		<label for="bid">Your Bid: </label>
		<!-- pid = product id  -->
		<!-- Approach 2... passing the auction details from the auction selected to here -->
		<!-- <input type='hidden' name='bidder' value='<?php //echo $_SESSION['username']; ?>'> -->
		<!-- <input type='hidden' name='auctionid' value='<?php //echo $auctionid; ?>'> -->

		<input type="number" name="userbid" min="<?php echo $highestBid; ?>" step="any" required><!-- step=any for decimals  -->
		<input type="submit" name="bid" value="Bid">
		<div>
			<?php if (isset($message)) {
				echo "<h2 class='text-warning'>$message</h2>";
			} ?>
		</div>
	</form>

<?php include 'scripts.php'; ?>
</body>
</html>