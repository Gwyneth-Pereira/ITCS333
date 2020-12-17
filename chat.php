<html>
<head>
<title>Private Communication </title>
<link  rel="stylesheet" href="chatstyle.css" />
<script>

</script>
</head>
<body>
<?php
session_start();
extract($_REQUEST);
date_default_timezone_set("Asia/Bahrain");
if (!isset($_SESSION['active'])) {
    header('location: notAuthorized.php');
    exit;
}
$u1= $_SESSION['username'];
// $t=date("D,d-n-y,h:i:s A");

$auctionid=6;// remove this line @IBRAHIMMMMMMMMMMMMMMM :)
	
	try 
	{	
		require("connection.php");
		$db->beginTransaction();
		
		if(isset($submitmsg)=="Send")
		{
			$smt=$db->prepare("INSERT INTO chats Values (NULL,:auction,:name, :msg, NOW())");
			$smt->bindParam(':auction',$auctionid);
			$smt->bindParam(':name',$u1);
			$smt->bindParam(':msg',$usermsg);
			$smt->execute();
		}
		$row=$db->prepare("SELECT * FROM chats Where auction=:aid");
		$row->bindParam(':aid',$auctionid);
		$row->execute();
		
		$db->commit(); 
	}
	catch (PDOException $ex) 
	{
		$db->rollBack();
		echo "ERROR:".$ex->getMessage();
	}
?>
<div id="wrapper">
    <div id="menu">
        <p class="welcome">Welcome, <b> <?php echo $_SESSION['username']; ?></b></p>
        <p class="logout"><a id="exit" href="myAuctions.php">Exit Chat</a></p>
        <div style="clear:both"></div>
    </div>
	<div id="chatbox">
	<?php
	
	while($r=$row->fetch())
			{
				
				echo "<p ><b>".$r['username']." </b></p>";
				echo "<p style='font-size:20px'>".$r['message']."</p>";
				echo "<p style='font-size:10px'>".$r['time']."</p></br>";
				
			}
			echo "<div id='newmsg'>";
			echo "</div>";
	?>
	</div>
<script>
 document.getElementById('newmsg').scrollIntoView();
</script>
	<form method="POST">
	     <input name="usermsg" id="usermsg" type="text" />
        <input type="submit" name="submitmsg" id="submit" value="Send" />
    </form>	
</div>  
</body>
</html>