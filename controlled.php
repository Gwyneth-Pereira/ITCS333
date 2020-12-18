<?php 
// AUCTION STATUSES: active -> pending/no participation -> successful -> completed/failed
date_default_timezone_set("Asia/Bahrain");
try{
    require('connection.php');
    $sql="SELECT id, end, bidder FROM auctions WHERE status='active'";
    $rs=$db->query($sql);

    foreach($rs as $row){
        $endttime=strtotime($row['end']);
        $current=time();
        $auctionid = $row['id'];
        if($current>$endttime){
            if ($row['bidder']==NULL){
                $newsql="UPDATE auctions SET status='noparticipation' WHERE id=$auctionid";
            } 
            else{
                $newsql="UPDATE auctions SET status='pending' WHERE id=$auctionid";
            }
            $update=$db->exec($newsql);
        }
    }
    $db=null;
} 
catch (PDOException $e){
    die($e->getMessage());
}
?>