<?php
extract($_REQUEST);

try {
	require('connection.php');
	
	$sql = $db->prepare("SELECT * FROM ratings WHERE auctionid=?");
	$sql->execute($auctionid);
	if ($sql->rowCount()==0) {
		if ($rater=='buyer') {
			$sql = $db->prepare("INSERT INTO ratings VALUES(?, ?, NULL)");
			$sql->execute($auctionid, $rate);
		}
		elseif ($rater=='seller') {
			$sql = $db->prepare("INSERT INTO ratings VALUES(?, NULL, ?)");
			$sql->execute($auctionid, $rate);
		}	
	}
	else {
		if ($rater=='buyer') {
			$sql = $db->prepare("UPDATE ratings SET buyerRating=? WHERE auctionid=?");
			$sql->execute($rate, $auctionid);
		}
		elseif ($rater=='seller') {
			$sql = $db->prepare("UPDATE ratings SET sellerRating=? WHERE auctionid=?");
			$sql->execute($rate, $auctionid);
		}	
		
	}

	$db=null;
} catch (PDOException $ex) {
	echo $ex->getMessage();
	exit;
}

header('loaction: myAuctions.php');
?>