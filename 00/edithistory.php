<?php
session_start();
if (!isset($_SESSION['active'])) {
	# code...
	
}
require('connection.php');
extract($_POST);
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

<?php
    if (isset($_SESSION['active'])) 
{
	$id=$_SESSION['id'];
	
	
	try{
        require('connection.php');




/// need ((((((edit))))) or DELECT it no back agine in history
echo "<form method='post'>";
echo "<p align='center'><input type='submit' value='Delect' name='Delect'/></p>";
echo "</form>";
if(isset($Delect))
{   
    $hid= $_GET['hid'];
    $his=("DELETE FROM history WHERE hid='$hid'");
    $deltehis=$db->prepare($his);
    $deltehis->execute();
    header("location:Accept.php");
    //afther delect back 
}






        $db=null;
    }		catch (PDOException $e)
{
    die($e->getMessage());
}
}
?>








<?php include 'scripts.php'; ?>
</body>
</html>