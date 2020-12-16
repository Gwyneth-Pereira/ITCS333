<?php 
session_start();
if (!isset($_SESSION['active'])) {
	header('location: notAuthorized.php');
	exit;
}
extract($_REQUEST);
if(isset($makebid))
{
	if (trim($userbid)=='') {
		echo "Please enter your bid";
	}
	else {
	//$bidpattern   REGEX PATTERN GOES HERE 

	if (preg_match($bidpattern,$userbid)) {
		try{

			require('connection.php');
			
			// Approach 1 with updating auction price in auctions table 
			$sql="SELECT * FROM 'auctions' WHERE product=$pid";
			$r=$db->query($sql); 
			$prod=$r->fetch(PDO::FETCH_ASSOC);
			if($prod['bid']<=$userbid){
				$bidPreparedStatement=$db->prepare("UPDATE 'auctions' SET bid=? WHERE product=?");
				$bidPreparedStatement->blindParam(1,$userbid);
				$bidPreparedStatement->blindParam(2,$pid);
				$bidPreparedStatement->execute();
			}
			else 
				echo "Your bid is lower than the existing bid";

			// Approach 2 with keeping track of all bids in bidders table
			// $sql="SELECT * FROM 'auctions' WHERE product=$pid";
			$r=$db->query($sql); 
			$prod=$r->fetch();
			if($prod['bid']<=$userbid){
				$bidPreparedStatement=$db->prepare("INSERT INTO 'bidders' VALUES(NULL, :auction, :bidder, :bid)");
				$bidPreparedStatement->bindParam(':auction',$auctionID);
				$bidPreparedStatement->bindParam(':bidder',$_SESSION['username']);
				$bidPreparedStatement->bindParam(':bid',$bid);
				$bidPreparedStatement->execute();
			}
			else 
				echo "Your bid is lower than the existing bid";

			$db=null;
		} catch(PDOExecption $e){
			die("There is an Error: ".$e->getMessage());
		}
	}
}
}//if set make bid
?>

<!DOCTYPE html>
<html>
<body>
<form method="POST">
<label for="bid">Your Bid: </label><input type="text" name="bid">
<!-- pid = product id  -->
<input type='hidden' name='pid' value='pid'>
<!-- Approach 2... passing the auction id from the auction selected to here with the variable name $auctionID  -->
<input type='hidden' name='auctionID' value='$auctionID'>
<input type="submit" name="makebid" value="Make Bid">
</form>
</body>
</html>
