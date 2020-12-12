<?php 
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


			$db=null;
		}

		catch(PDOExecption $e){
		die("There is an Error: ".$e->getMessage());
			}
	}
}


}//if set make bid
?>

<!DOCTYPE html>
<html>
<body>
<form method="post">
<label for="bid">Your Bid: </label><input type="text" name="userbid">
<input type='hidden' name='pid' value='pid'>	
<input type="submit" name="makebid" value="Make Bid">
</form>
</body>
</html>