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

<?php
    if (isset($_SESSION['active'])) 
{
	$id=$_SESSION['id'];
	
	
	try{
        require('connection.php');
    
  
        $joinquery=("SELECT * FROM  products,bidders,auctions WHERE products.id=bidders.bid 
        And bidders.auction=auctions.id ");
    $hardquery=$db->query($joinquery);
    echo "<form method='post' >";
    echo "<table align='center' border='3'>";
    foreach($hardquery as $v){
        $picture=$v[11];
        $his=$v[10];
        
$id=$v[6];//8
$auctionid=$v[7];//1
$bid=$v[9];//5
      
       $_SESSION['auctionid']=$auctionid;
        $_SESSION['bid']=$bid;
       echo "<tr><td>";
        echo " <img src='images/$picture' alt='Denim Jeans'  width='200' hight='200'> </td>";
        echo "</tr><tr><td><p align='center'><input type='text'  placeholder=' $his' name='ds'/></p>";
        echo "</td><tr><td><p align='center'><input type='submit' name='sub' value='new history'/></p></td></tr>";
        echo "</td><tr><td><p align='center'><input type='submit' name='add' value='Aceept history'/></p></td></tr>";
    }
        echo "</table>";
        echo "</form>";
	$db=null;
			}		catch (PDOException $e)
		{
			die($e->getMessage());
		}
    }

    extract($_POST);
    if(isset($sub)){
      
        try{
            require('connection.php');
            $sql = $db->prepare("UPDATE bidders SET history=? WHERE id=? 
            And auction=?  And  bid=?     ");
            $sql->execute(array($ds,$id,$auctionid,$bid));
    
        $db=null;
            }		catch (PDOException $e)
        {
            die($e->getMessage());
        }
        header("location:messge.php");
    }

    if(isset($add))
    {
        try{
            require('connection.php');
    

            $joinquery=("SELECT * FROM  products,bidders,auctions WHERE products.id=bidders.bid 
            And bidders.auction=auctions.id ");
        $hardquery=$db->query($joinquery);
        foreach($hardquery as $v){
            $picture=$v[11];
            $his=$v[10];
            
    $id=$v[6];//8
    $auctionid=$v[7];//1
    $bid=$v[9];//5

    $owner=$v[13];//name owner
        }



            $mysql=("INSERT INTO history VALUES(null,?,?,?,?,?)");
            $stmt=$db->prepare($mysql);
            $stmt->bindParam(1, $bid);
            $stmt->bindValue(2,$auctionid );
            $stmt->bindValue(3, $owner);
            $stmt->bindValue(4, "Accept");
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