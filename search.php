<?php



//THIS HAS TO BE ADDED TO ANOTHER PAGE


Extract($_POST);
if(isset($submitSearch)){

$regexSearchPattern=TRUE; //SEARCH PATTERN GOES HERE
if(preg_match($regexSearchPattern, $searchfield))
{try{

$searchterms = explode(' ', $searchfield);//multiple terms in the field


//Basic:
$sql="SELECT * FROM 'products' WHERE 'name' LIKE ";
$i=0;
foreach ($searchterms as $term) {
	if ($i=0) { //first term
		$sql.="'%".$term."%'";
		$i++;
	}
	else 
	{
		$sql.=" OR 'name' LIKE '%".$term."%' ";
	}
}

require('connection.php');

	$r=$db->query($sql); 
	$searchResults=$r->fetch(PDO::FETCH_ASSOC);


	if($searchResults==null)
		echo "No such product exists";

else {
	$sql="SELECT * FROM 'auctions' WHERE 'product'=";	
	$i=0;
	foreach ($searchResults as $pr) {
	if ($i=0) { //first term
		$sql.="$pr['id']";
		$i++;
	}
	else 
	{
		$sql.=" OR 'product'='".$pr['id']."' ";
	}
	}

	$r=$db->query($sql); 

foreach ($r as $rs) { //displaying all auctions
	echo "Product: ".$rs['product'];
	echo "Owner: ".$rs['owner'];
	echo "Auction start date: ".$rs['start'];
	echo "Auction end date: ".$rs['end'];
	echo "Starting price: ".$rs['startprice'];
	echo "Current Bid: ".$rs['bid'];
}
}//end of else 
$db=null;






//ADVANCED SEARCH GOES HERE 





}//end of try

catch(PDOExecption $e){
 die ("ERROR:".$e->getMessage());
}

} // end of if regexpattern

else 
	echo "Invalid search";





}//end of if submitted

?>
<html>
<body>

<form method=“post”>
	<label for='Search'>Search: </label><input type='text' name='searchfield'>
	<select name='Categories[]'>
		<option value='All'>All Categories</option>
	</select><br/>  
	<input type='radio' name='search-type' value='All'>All
	<input type='radio' name='search-type' value='Products'>Products
	<input type='radio' name='search-type' value='Owners'>Owners
	<br/> 
	<label for='Sort-By'>Sort By: </label>
	<select name='Sort-by[]'>
		<option value='recent'>Most Recent Bids</option>	
		<option value='highest'>Highest Bids</option>
		<option value='lowest'>Lowest Bids</option>
		<option value='ending'>Ending Soon</option>
	</select><br/>  
<input type='submit' name='submitSearch' value='Search'>
</form>
</body>
</html>