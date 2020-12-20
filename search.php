<?php 
extract($_REQUEST);


if(isset($searchfield)){
$searchfield=trim($searchfield);

$regexsearchpattern="/^(.|\s)*[a-zA-Z]{1,100}(.|\s)*$/";
if (preg_match($regexsearchpattern, $searchfield)) {
	try{
		$searchTerms=explode(" ", $searchfield);

		require('connection.php');
$prods=null;
$auctions=null;
		$sql="SELECT * FROM products WHERE name LIKE ?";
		$stmt=$db->prepare($sql);
		if($stmt->execute(array("%".$searchfield."%")))
		{
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		 	$prods[]=$row;
		}				
		}

	if($prods!=null){
		$sql="SELECT * FROM auctions WHERE product=?";
		$stmt=$db->prepare($sql);
		foreach ($prods as $pID) {
			if($stmt->execute(array($pID['id']))){
				while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		 		$auctions[]=$row;
				}

			}
		}

		//displaying search results:
		for ($i=0; $i <sizeof($prods) ; $i++) {
			echo '<a href=viewAuction.php?pid='.$prods[$i]['id']."&auctionid=".$auctions[$i]['id'].">";
			echo "<li><u>".$prods[$i]['name']."</u></li>";
			echo "<li>Details: ".$prods[$i]['details']."</li>";
			//echo "<li>Status:".$auctions[$i]['status']."</li>";
			echo '</a>';
		}


	}//if product is found

if ($prods==null) {
	echo "No such product exists\n";
	echo "<a href='index.php#browse'>Browse all Products</a>";
}
	}//try

	catch(PDOExecption $e){
		die ("ERROR:".$e->getMessage());
	}


}
else 
	echo "invalid search";


}//if isset searchfield
?>