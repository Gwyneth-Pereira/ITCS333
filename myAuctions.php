<!-- 
    page includes both auctions (button to upload pics) 
    and bids (show whether winning or losing)
-->
<?php
session_start();
if (!isset($_SESSION['active'])) {
    header('location: notAuthorized.php');
    exit;
}
extract($_REQUEST);
require('controlled.php');
try {
    require('connection.php');
    $username = $_SESSION['username'];

    $sql = $db->prepare("SELECT auctions.*, products.name FROM auctions, products WHERE auctions.owner=? AND products.id=auctions.product");
    $sql->execute(array($username));
    $myAuctions = $sql->fetchAll();
    $auctionsCount = $sql->rowCount();
    
    $sql = $db->prepare("SELECT * FROM auctions WHERE bidder=? AND status=?");
    $sql->execute(array($username, 'active'));
    $myBids = $sql->fetchAll();
    $bidsCount = $sql->rowCount();

    $sql="SELECT * FROM auctions WHERE bidder='$username' AND status='pending'";
    $rows=$db->query($sql);

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
            <li class="row list-group-item">
                <div class="col-6">
                    <p class="font-weight-bold">
                        Product: <?php echo $auction['name'];?>
                    </p>
                </div>
                <div class="col-6">
                    <p class="font-weight-bold">
                        Owner: <?php echo $auction['owner'];?>
                    </p>
                </div>
                <div class="col-6">
                    <p class="mb-1 font-weight-bold">
                        Started On:<br>
                    </p>
                    <?php echo $auction['start'];?>
                </div>
                <div class="col-6">
                    <p class="mb-1 font-weight-bold">
                        Ends On:<br>
                    </p>
                    <?php echo $auction['end'];?>
                </div>
                <div class="col-6">
                    <p class="mb-1 font-weight-bold">Price Started at: </p>
                    <em><?php echo $auction['startprice'];?></em>
                </div>
                <div class="col-6">
                    <p class="mb-1 font-weight-bold">Current Highest Bid: </p>
                    <?php 
                    if(isset($auction['bid'])){
                        echo $auction['bid'];?> by <?php echo $auction['bidder'];
                    } 
                    else {
                        echo "No Bids Yet!";
                    }
                    ?>
                </div>
                <div class="col-4">
                    <p class="mb-1 font-weight-bold">Auction Status: </p>
                    <?php 
                        $status = $auction['status'];
                        
                        if ($status == 'active') {
                            echo "<p class='text-success'><u>Active</u></p>";
                        } elseif ($status == 'pending') {
                            echo "<p class='text-warning'><u>Pending</u></p>";
                        } elseif ($status == 'noparticipation') {
                            echo "<p class='text-secondary'><u>No Participations</u></p>";
                        } elseif ($status == 'successful') {
                            echo "<p class='text-success'><u>Successful</u></p>";
                        } elseif ($status == 'failed') {
                            echo "<p class='text-danger'><u>Failed</u></p>";
                        } elseif ($status == 'completed') {
                            echo "<p class='text-success'><u>Completed</u></p>";
                        }
                    ?>
                </div>
                <div class="col-8">
                    <p class="mb-1 font-weight-bold">Actions:</p>
                    <?php
                        $auctionid = $auction['id'];

                        if ($status == 'active') {
                            echo "<a href='viewAuction.php?auctionid=$auctionid' class='btn btn-sm btn-primary'>View Auction</a>";
                        } elseif ($status == 'pending') {
                            echo "<a href='myAuctions.php?update=failed' class='btn btn-sm btn-danger mr-3'>Mark as Failed</a>";
                            echo "<a href='viewAuction.php?auctionid=$auctionid' class='btn btn-sm btn-primary'>View Auction</a>";
                        } elseif ($status == 'noparticipation') {
                            echo "<a href='myAuctions.php?update=failed' class='btn btn-sm btn-danger mr-3'>Mark as Failed</a>";
                            echo "<a href='republish.php?auctionid=$auctionid' class='btn btn-sm btn-primary'>Republish</a>";
                        } elseif ($status == 'successful') {
                            echo "<a href='myAuctions.php?update=complete' class='btn btn-sm btn-success mr-3'>Mark as Complete</a>";
                            echo "<a href='viewAuction.php?auctionid=$auctionid' class='btn btn-sm btn-primary'>View Auction</a>";
                        } elseif ($status == 'failed') {
                            echo "<a href='republish.php?auctionid=$auctionid' class='btn btn-sm btn-primary'>Republish</a>";
                        } elseif ($status == 'completed') {
                            echo '<p class="mb-1 font-weight-bold text-dark">No Actions Available</p>';
                        }                    
                    ?>
                
                </div>
            </li>
            <?php
        }
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

function displayHistory(){
    global $rows;
    if ($rows->rowCount() > 0){
        foreach($rows as $row){
            try {
                require('connection.php');
                $prodsql="SELECT * FROM products WHERE id=$row[2]";
                $prods=$db->query($prodsql);
                $picsql="SELECT * FROM pictures WHERE product=$row[2]";
                $pics=$db->query($picsql);
            } catch (PDOException $ex) {
                echo $ex->getMessage();
                exit;
            }

            echo $row['owner'];

            if ($row=$prods->fetch()){
                echo $row['name']."</br>";
                echo $row['category']."</br>";
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

                <div class="panel panel-primary">
                    <div class="panel-heading mb-4">
                        <h2 class="panel-title font-weight-bold pb-0">My Auctions</h2>
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

            <div id="my-bids" class="col-12 col-md-6">
                <div class="row">
                    <div class="col-12">
                        <!-- Ongoing Bids Section -->
                        <div class="panel panel-primary">
                            <div class="panel-heading mb-4">
                                <h2 class="panel-title font-weight-bold pb-0">Ongoing Bids</h2>
                            </div>
                            <div class="panel-body">
                                <ul class="list-group" style="max-height: 25vh; margin-bottom: 10px; overflow:hidden; overflow-y:scroll; -webkit-overflow-scrolling: touch;">
                                    <?php 
                                    displayBiddings($myBids);
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <!-- Ended Bids Section -->
                        <div class="panel panel-primary mt-5">
                            <div class="panel-heading mb-4">
                                <h2 class="panel-title font-weight-bold pb-0">Ended Bids</h2>
                            </div>
                            <div class="panel-body">
                                <ul class="list-group" style="max-height: 25vh; margin-bottom: 10px; overflow:hidden; overflow-y:scroll; -webkit-overflow-scrolling: touch;">
                                    <?php 
                                    displayBiddings($myBids);
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'scripts.php'; ?>
</body>
</html>