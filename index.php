<?php
session_start();
if (!isset($_SESSION['active'])) {
	# code...
	
}
require('connection.php');

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>My Project</title>
	<?php include 'head.php'; ?>
</head>
<body>
	<?php include 'header.php'; ?>

	<div class="container">
		<h1>This is the home page</h1>
	</div>
<?php	if (isset($_SESSION['active'])) 
{
	$id=$_SESSION['id'];
	
	
	try{
		require('connection.php');
	$mysql=("SELECT * FROM products ");
		$prodecut=$db->query($mysql);


	$db=null;
			}		catch (PDOException $e)
		{
			die($e->getMessage());
		}
echo "<form method='get'>";
	
	

		echo "<table align = 'center' border = '2'>";
		$counterRow = 0; 
		echo "<tr>";
		foreach($prodecut as $a)
		{	
			$idproduct=$a[0];
			$picture=$a[5];
				
			
			
				if($counterRow != 3)
					$counterRow+=1;
				else{
					echo "</tr><tr>";
						$counterRow=1;
					}
				
			
			 echo "<td><a href='buy.php?pid= $idproduct '><img src='images/$picture' width='200' height='100' />click </a></td>";
	
		}
		echo "</table>";

echo "</form>";


	?>
	

			
			

<?php
}

?>
	<?php include 'scripts.php'; ?>
</body>
</html>