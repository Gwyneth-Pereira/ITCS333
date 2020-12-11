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

<style>
.card {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  max-width: 300px;
  margin: auto;
  text-align: center;
  font-family: arial;
}

.price {
  color: grey;
  font-size: 22px;
}

.card button {
  border: none;
  outline: 0;
  padding: 12px;
  color: white;
  background-color: green;
  text-align: center;
  cursor: pointer;
  width: 100%;
  font-size: 18px;
}

.card button:hover {
  opacity: 0.7;
}
</style>



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
    
        $s1=("SELECT * FROM history Where bid='$id'");
        $quer=$db->query($s1);

//need check to get price of product afther Aceept or reject ????? check pleses;
// i try to do it but diffuclt
$thesql=("SELECT * FROM auctions,history Where auctions.id=history.aid");
$price=$db->query($thesql);
foreach($price as $n)
{
    $tpotalprice=$n[5];
}
    	$db=null;
			}		catch (PDOException $e)
		{
			die($e->getMessage());
		}
    
    
    
        foreach($quer as $v)
        {
            $hid=$v[0];
            $owner=$v[3];
        $picture=$v[5];
        
    ?>
<form method="post">
    <div class="card">
        <img src="images/<?php echo $picture; ?>" alt="Denim Jeans" style="width:100%">
        <h1><?php echo $owner; ?></h1>
        <p class="price"><?php echo $tpotalprice; ?></p>

        <p ><button ><input type="submit" value='Accept' name='add'/></button></p> 
    </div>
</form>
<a href="edithistory.php?hid=<?php echo $hid; ?>" style='color:red'>Delect</a></p> 

<?php
        }


}

if(isset($add))
{
    ////??
}


?>








	<?php include 'scripts.php'; ?>
</body>
</html>
