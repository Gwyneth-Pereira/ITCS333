<?php
session_start();
extract($_REQUEST);
date_default_timezone_set("Asia/Bahrain");
if (!isset($_SESSION['active'])) {
    header('location: notAuthorized.php');
    exit;
}
$currentUser= $_SESSION['username'];
?>
<!DOCTYPE html>
<html>
<head>

	<title>Private Chat</title>
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" type="text/css" rel="stylesheet">
	<link rel="stylesheet" href="css/chat.css"/>
	<?php include 'head.php'; ?>
</head>
<body>
<?php 
	include 'header.php';
	
	try 
	{	
		require("connection.php");
		$db->beginTransaction();
		
		if(isset($submitmsg))
		{
			$smt=$db->prepare("INSERT INTO chats Values (NULL,:auction,:name, :msg, NOW())");
			$smt->bindParam(':auction',$auctionid);
			$smt->bindParam(':name',$currentUser);
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
	<div class="container">
		<h3 class="text-center">Private Chat</h3>
		<p class="welcome">Welcome, <b> <?php echo $_SESSION['username']; ?></b></p>
		<p class="logout"><a id="exit" href="myAuctions.php">Exit Chat</a></p> 
		
	<div class="messaging">
		<div class="inbox_msg">
				<div class="mesgs">
					<div class="msg_history">
	
<?php
	while($r=$row->fetch())
			{
				
				$date=date_create($r['time']);
				$t= date_format($date,"D,d-n-y,g:i a");
				
				if( $r['username']== $currentUser)
				{
					echo "<div class='outgoing_msg'>";
					echo "<div class='sent_msg'>";
					echo "<p >".$r['message']."</p>";                                    
					echo "<span class='time_date'>".$t."</span>";
					echo "</div>";
					echo "</div>";
				}
				else 
				{
					echo "<div class='incoming_msg'>";
					echo "<p><b>".$r['username']." </b></p>";
					echo "<div class='incoming_msg_img'><img src='images/users/default-avatar.png' style='max-height: 2.8rem;'></div>";
					echo "<div class='received_msg'>";
					echo "<div class='received_withd_msg'>";
					echo "<p >".$r['message']."</p>";                                      
					echo "<span style='font-size:10px' class='time_date'>".$t."</span>";        
					echo "</div>";
					echo "</div>";
					echo "</div>";
				}
			}
			echo "<div id='newmsg'>";//for autoscrolling
			echo "</div>";
	?>
						<script>
								document.getElementById('newmsg').scrollIntoView();//for autoscrolling
						</script>
					</div>
		

					<form id="myForm" method="POST" >
						<div class="type_msg">
							<div class="input_msg_write">
								<input type="text" name="usermsg" id="usermsg" class="write_msg" placeholder="Type a message" />
								<button id= "btn" class="msg_send_btn" name="submitmsg" onclick="sending(this.form)" type="submit"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
							</div>
						</div> 
					</form>
				</div>
		</div>	
<script>
	function sending(){ form.submit(); }
</script> 	
</div>
</div>
	
	<?php include 'scripts.php'; ?>
</body>
</html>