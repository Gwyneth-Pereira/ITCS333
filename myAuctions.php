<!-- 
    page includes both auctions (button to upload pics) 
    and bids (show whether winning or losing)
 -->

<?php
session_start();
require('controlled.php');
extract($_REQUEST);
if (!isset($_SESSION['active'])) {
	header('location: notAuthorized.php');
}
try {
    require('connection.php');
    $sql = $db->prepare("SELECT * FROM auctions WHERE owner=?");
    $sql->execute(array($_SESSION['username']));
    $myAuctions = $sql->fetchAll();
    $auctionsCount = $sql->rowCount();
    
    $sql = $db->prepare("SELECT * FROM auctions WHERE bidder=?");
    $sql->execute(array($_SESSION['username']));
    $myBids = $sql->fetchAll();
    $bidsCount = $sql->rowCount();

    $db=null;
} catch (PDOException $ex) {
    echo $ex->getMessage();
    exit;
}

function displayAuctions($myAuctions){
    global $auctionsCount;
    if ($auctionsCount == 0) {
        echo '<li class="list-group-item">';
            echo '<h3 class="text-center">You Do Not Own Any Auctions Currently</h3>';
        echo '</li>';
    } else {
        foreach ($myAuctions as $auction) {
            ?>
            <li class="list-group-item">
                <div>
                    Product:
                    <?php echo $auction['product'];?>
                </div>
                <div>
                    Owner:<br>
                    <?php echo $auction['owner'];?>
                </div>
                <div>
                    Started On:<br>
                    <?php echo $auction['start'];?>
                </div>
                <div>
                    Ends On:<br>
                    <?php echo $auction['end'];?>
                </div>
                <div>
                    Price Started at:<br>
                    <?php echo $auction['startprice'];?>
                </div>
                <div>
                    Current Highest Bid:<br>
                    <?php echo $auction['bid'];?>
                    <?php echo $auction['bidder'];?>
                </div>
                <div>
                    Auction Status:<br>
                    <?php 
                        $status = $auction['status'];
                        $auctionid = $auction['id'];
                        
                        if ($status == 'active') {
                            echo "<p class='text-success'>Active</p>";
                        } elseif ($status == 'pending') {
                            echo "<p class='text-secondary'>Pending</p>";
                        } elseif ($status == 'successful') {
                            echo "<p class='text-success'>Completed</p>";
                        }
                        
                        echo "<a href='viewAuction.php?auctionid=$auctionid'>View Auctions Details</a>";
                    ?>
                </div>
            </li>
            <?php
        }
    }
}

function displayHistory(){
    try{
        require('connection.php');
        $user=$_SESSION['username'];
        $sql="SELECT * FROM auctions WHERE bidder='$user' AND status='pending'";
        $rs=$db->query($sql);
    
        if ($rs->rowCount() > 0){
            foreach($rs as $rows){
                $prodsql="SELECT * FROM products WHERE id=$rows[2]";
                $prods=$db->query($prodsql);
                $picsql="SELECT * FROM pictures WHERE product=$rows[2]";
                $pics=$db->query($picsql);
    
                echo $rows['owner'];
    
                if ($rows=$prods->fetch()){
                    echo $rows['name']."</br>";
                    echo $rows['category']."</br>";
                }
                
                $first = true;
                foreach ($pics as $holder){
                    $picture = $holder['picture'];
                    if ($first){
                        echo "<img src='$picture' class='d-block w-100' style='min-height: 100%;'>"; 
                        $first = false;
                    } 
                }
                
            }
        } 
        else {
            echo "No auctions won yet";
        } 
        $db=null;
    }
    catch (PDOException $ex){
        die($ex->getMessage());
    }
}

function displayBiddings($myBids){
    global $bidsCount;
    if ($bidsCount == 0) {
        echo '<li class="list-group-item">';
        echo '<h3 class="text-center">You Do Not have Any Biddings Currently</h3>';
        echo '</li>';
    } else {
        foreach ($myBids as $bidding) {
            ?>
            <li class="list-group-item">
                <div>
                    Product:
                </div>
                <div>
                    Owner:
                </div>

                <?php echo $bidding['owner'];?>
                <?php echo $bidding['product'];?>
                <?php echo $bidding['start'];?>
                <?php echo $bidding['end'];?>
                <?php echo $bidding['startprice'];?>
                <?php echo $bidding['bid'];?>
                <?php echo $bidding['bidder'];?>
                <?php echo $bidding['status'];?>
            </li>
            <?php
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>My Auctions</title>
    <?php include 'head.php'; ?>
    <link rel="stylesheet" type="text/css" href="css/scroller.css">
</head>
<body>
	<?php include 'header.php'; ?>
    <div class="container">
        <div>
            <?php if (isset($message) && $message=='created') {
                echo "<h1 class='text-success'>Auction Successfully Created</h1>";
            } elseif (isset($message) && $message=='bid') {
                echo "<h1 class='text-success'>Successfully Bidded on Auction</h1>";
            } ?>
        </div>

        <div class="row pt-5">
            <!-- My Auctions Section -->
            <div id="my-auctions" class="col-12 col-md-6">

                <div class="panel panel-primary" id="result_panel">
                    <div class="panel-heading mb-4">
                        <h2 class="panel-title font-weight-bold pb-3">My Auctions</h2>
                    </div>
                    <div class="panel-body">
                        <ul class="list-group" style="max-height: 55vh; margin-bottom: 10px; overflow:hidden; overflow-y:scroll; -webkit-overflow-scrolling: touch;">
                            <?php 
                                displayAuctions($myAuctions);
                            ?>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- My Bids Section -->
            <div id="my-bids" class="col-12 col-md-6">
                
                <div class="panel panel-primary" id="result_panel">
                    <div class="panel-heading mb-4">
                        <h2 class="panel-title font-weight-bold pb-3">My Bids</h2>
                    </div>
                    <div class="panel-body">
                        <ul class="list-group" style="max-height: 55vh; margin-bottom: 10px; overflow:hidden; overflow-y:scroll; -webkit-overflow-scrolling: touch;">
                            <?php 
                                displayBiddings($myBids);
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

	<?php include 'scripts.php'; ?>
</body>
</html>