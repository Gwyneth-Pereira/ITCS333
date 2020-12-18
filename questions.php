<?php
session_start();

 require('controlled.php');
extract($_REQUEST);
$submitteddate=date('Y-m-d H:i:s');

try{ 

	require('connection.php');

	$qpattern="/^(.|\s)*[a-zA-Z]{3,300}(.|\s)*$/";
	$apattern="/^(.|\s)*[a-zA-Z]{3,500}(.|\s)*$/";
 	$sql = $db->prepare("SELECT * FROM auctions WHERE product=:product");
  	$sql->bindparam(':product',$pid);
  	$sql->execute();
		while($ow=$sql->fetch(PDO::FETCH_ASSOC))
		{
		$owner=$ow['owner'];}
	
	if ($_SESSION['username']!=$owner) {
	if(preg_match($qpattern, $userquestion)){
		$sql = $db->prepare("INSERT INTO questions(id,product,question,asker,questiondate,owner) VALUES(NULL, :pid, :question, :asker, :questionDate,:owner)");

		$sql->bindParam(':pid',$pid);
		$sql->bindParam(':question', $userquestion);
		$sql->bindParam(':asker', $_SESSION['username']);
		$sql->bindParam(':questionDate', $submitteddate);
		$sql->bindParam(':owner', $owner);
		$sql->execute();
		if($sql->rowCount()==0) { //checks if value was inserted
		echo '<script type="text/javascript">';
		echo "alert('Your question was invalid')";
		echo '</script>';}
		
		elseif($sql->rowCount()>0){
		echo '<script type="text/javascript">';
		echo "alert('Your question was succesfully sent! Please wait for the owners reply!')";
		echo '</script>';}
		}
		else //regex does not match
			{
		echo '<script type="text/javascript">';
		echo "alert('Your question is invalid')";
		echo '</script>';}
	}		
		
	
			

	elseif ($_SESSION['username']==$owner&&isset($qid)) {
		if(preg_match($apattern,$ownerreply)){
		$sql = $db->prepare("UPDATE questions SET answer=:answer ,answerdate=:answerdate WHERE id = :qid");
		$sql->bindParam(':qid',$qid);
		$sql->bindParam(':answer', $ownerreply);
		$sql->bindParam(':answerdate', $submitteddate);
		$result = $sql->execute();
		if($sql->rowCount()==0) { //checks if value was inserted
		echo '<script type="text/javascript">';
		echo "alert('Your answer was invalid')";
		echo '</script>';}
		

		elseif($sql->rowCount()>0){
		echo "<script type='text/javascript'>"; 
		echo 'alert("Your answer has been submitted successfully");';
		echo "window.location.href = 'viewAuction.php?pid=".$pid."&auctionid=".$auctionid."';";
		echo '</script>';
	}

	}	//end of pregmatch	
		else //regex does not match
			{
		echo '<script type="text/javascript">';
		echo "alert('Your answer is invalid')";
		echo '</script>';}
}//user is owner
	
}//try





catch(PDOException $ex) {
	die("Error Message ".$ex->getMessage());
}










?>