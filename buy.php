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
  background-color: #000;
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

	<div class="container">
		<h1>This is the home page</h1>
	</div>



    <?php	if (isset($_SESSION['active'])) 
{
	$id=$_SESSION['id'];
	
    $pid=$_GET['pid'];
  //  echo "<h1 style='color:red'>".$pid."</h1>";
	try{
        require('connection.php');
        $user= $db->query("SELECT * from users WHERE id='$id' ");
         foreach($user as $n)
         {
             $username=$n[1];
         }   

	$mysql=("SELECT * FROM products Where id='$pid'");
		$prodecut=$db->query($mysql);
foreach($prodecut as $a){
    $name=$a[2];
    $detiles=$a[3];
    $picture=$a[5];
}
$thesql=("SELECT * FROM auctions Where product='$pid'");
$price=$db->query($thesql);
foreach($price as $v){
$aid=$v[0];
    $tpotalprice=$v[5];
$theauction=$v[1];

}
	$db=null;
			}		catch (PDOException $e)
		{
			die($e->getMessage());
        }
        echo "<form method='post'>";
     

?>
<h2 style="text-align:center">Product Card</h2>

<div class="card">
  <img src="images/<?php echo $picture; ?>" alt="Denim Jeans" style="width:100%">
  <h1><?php echo $name; ?></h1>
  <p class="price"><?php echo $tpotalprice; ?></p>
  <p><?php echo $detiles;?></p>
  <p><button>Add to Cart</button></p>
  <p><input style="color:green" type="text" name='dis' /></p> 
  <p ><button style="color:green"><input type="submit" value='add' name='sub'/></button></p> 
<?php
echo "</form >";
    
}   
?>
<?php
extract($_POST);
if(isset($sub)){
	try{
		require('connection.php');

		$mysql=("INSERT INTO bidders VALUES(null,?,?,?,?,?)");
        $stmt=$db->prepare($mysql);
        $stmt->bindParam(1, $aid);
        $stmt->bindValue(2,$username );
        $stmt->bindValue(3, $id);
        $stmt->bindValue(4, $dis);
        $stmt->bindParam(5,$picture);
        $stmt->execute();

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