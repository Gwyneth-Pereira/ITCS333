<?php 
//active -> pending -> successful/failed
date_default_timezone_set("Asia/Bahrain");
try{
    require('connection.php');
    $sql="SELECT id, end FROM auctions WHERE status='active'";
    $rs=$db->query($sql);

    foreach($rs as $row){
        $endttime=UNIX_TIMESTAMP($row['end']);
        $current=UNIX_TIMESTAMP(date('Y-m-d H:i:s'));
        $auctionid = $row['id'];
        if($current>$endttime){
            $newsql="UPDATE auctions SET status='pending' WHERE id=$auctionid";
            $update=$db->exec($newsql);
        }
    }
    $db=null;
} 
catch (PDOException $e){
    die($e->getMessage());
}
?>