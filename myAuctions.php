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
try {
    require('connection.php');
} 
catch (PDOException $ex) {
    echo $ex->getMessage();
    exit;
}

if (isset($update)) {
    if ($update=='failed') {
        $sql = $db->prepare("UPDATE auctions SET status=? WHERE id=?");
        $sql->execute(array($update, $auctionid));
    }
    elseif ($update=='completed') {
        $sql = $db->prepare("UPDATE auctions SET status=? WHERE id=?");
        $sql->execute(array($update, $auctionid));
    }
}

require('controlled.php');

try {
    require('connection.php');
    $username = $_SESSION['username'];

    $sql = $db->prepare("SELECT auctions.*, products.name FROM auctions, products WHERE auctions.owner=? AND products.id=auctions.product");
    $sql->execute(array($username));
    $myAuctions = $sql->fetchAll();
    $auctionsCount = $sql->rowCount();
    
    $sql = $db->prepare("SELECT auctions.*, products.name FROM auctions, products WHERE auctions.bidder=? AND auctions.status=? AND products.id=auctions.product");
    $sql->execute(array($username, 'active'));
    $myBids = $sql->fetchAll();
    $activeCount = $sql->rowCount();
    
    $sql = $db->prepare("SELECT auctions.*, products.name FROM auctions, products WHERE auctions.bidder=? AND auctions.status=? AND products.id=auctions.product");
    $sql->execute(array($username, 'pending'));
    $myPending = $sql->fetchAll();
    $pendingCount = $sql->rowCount();

    $sql = $db->prepare("SELECT auctions.*, products.name FROM auctions, products WHERE auctions.bidder=? AND auctions.status=? AND products.id=auctions.product");
    $sql->execute(array($username, 'completed'));
    $history = $sql->fetchAll();
    $historyCount = $sql->rowCount();
    
    $db=null;
} catch (PDOException $ex) {
    echo $ex->getMessage();
    exit;
}

function displayAuctions($myAuctions){
    global $auctionsCount;
    if ($auctionsCount == 0) {
        echo '<div style="height: 25vh;">';
        echo '<li class="list-group-item">';
            echo '<h3 class="text-center">You Do Not Own Any Auctions Currently</h3>';
        echo '</li>';
        echo '</div>';
    } else {
        foreach ($myAuctions as $auction) {
            ?>
            <li class="row list-group-item list-group-item-action">
                <div class="col-6">
                </div>
                <div class="col-6">
                    <p class="font-weight-bold">
                        Product: <?php echo $auction['name'];?>
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
                    <em><?php echo $auction['startprice'];?></em> BD
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
                <div class="col-6">
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
                <div class="col-6">
                    <p class="mb-1 font-weight-bold">Actions:</p>
                    <?php      
                        $auctionid = $auction['id'];

                        if ($status == 'active') {
                            echo "<a href='viewAuction.php?auctionid=$auctionid' class='btn btn-sm btn-primary'>View Auction</a>";
                        } elseif ($status == 'pending') {
                            echo "<a href='myAuctions.php?update=failed&auctionid=$auctionid' class='btn btn-sm btn-danger m-1'>Mark as Failed</a>";
                            echo "<a href='viewAuction.php?auctionid=$auctionid' class='btn btn-sm btn-primary m-1'>View Auction</a>";
                        } elseif ($status == 'noparticipation') {
                            echo "<a href='myAuctions.php?update=failed&auctionid=$auctionid' class='btn btn-sm btn-danger m-1'>Mark as Failed</a>";
                            echo "<a href='republish.php?auctionid=$auctionid' class='btn btn-sm btn-outline-primary m-1'>Republish</a>";
                        } elseif ($status == 'successful') {
                            echo "<a href='myAuctions.php?update=completed&auctionid=$auctionid' class='btn btn-sm btn-success m-1'>Mark as Complete</a>";
                            echo "<a href='viewAuction.php?auctionid=$auctionid' class='btn btn-sm btn-primary m-1'>View Auction</a>";
                        } elseif ($status == 'failed') {
                            echo "<a href='republish.php?auctionid=$auctionid' class='btn btn-sm btn-outline-primary'>Republish</a>";
                        } elseif ($status == 'completed') {
                            echo "<a href='chat.php?auctionid=$auctionid' class='btn btn-sm btn-outline-secondary m-1'>Chat</a>";
                            ?>
                            <div class="rate m-1">
                                <input type="radio" id="star5" name="rate" class="star" value="5" onclick="submit()"/>
                                <label for="star5" title="text">5 stars</label>
                                <input type="radio" id="star4" name="rate" class="star" value="4" onclick="submit()"/>
                                <label for="star4" title="text">4 stars</label>
                                <input type="radio" id="star3" name="rate" class="star" value="3" onclick="submit()"/>
                                <label for="star3" title="text">3 stars</label>
                                <input type="radio" id="star2" name="rate" class="star" value="2" onclick="submit()"/>
                                <label for="star2" title="text">2 stars</label>
                                <input type="radio" id="star1" name="rate" class="star" value="1" onclick="submit()"/>
                                <label for="star1" title="text">1 star</label>
                            </div>
                        <?php
                        }                    
                    ?>
                
                </div>
            </li>
            <?php
        }
    }
}

function displayBiddings($myBids){
    global $activeCount;
    if ($activeCount == 0) {
        echo '<div style="height: 25vh;">';
        echo '<li class="list-group-item">';
        echo '<h3 class="text-center">You Do Not have Any Biddings Currently</h3>';
        echo '</li>';
        echo '</div>';
    } else {
        echo '<div id="activeCarousel" class="carousel slide" data-ride="carousel">';
        echo '<div class="carousel-inner" style="height: 45vh;">';
        $first = true;
        foreach ($myBids as $bidding) {
            if ($first) {
                echo '<div class="carousel-item active">';
                $first = false;
            } else {
                echo '<div class="carousel-item">';
            }
            ?>  <div class="row">

                <div class="col-6">
                    <p class="font-weight-bold">
                        Product: <?php echo $bidding['name'];?>
                    </p>
                </div>
                <div class="col-6">
                    <p class="font-weight-bold">
                        Owner: <?php echo $bidding['owner'];?>
                    </p>
                </div>
                <div class="col-6">
                    <p class="mb-1 font-weight-bold">
                        Started On:<br>
                    </p>
                    <?php echo $bidding['start'];?>
                </div>
                <div class="col-6">
                    <p class="mb-1 font-weight-bold">
                        Ends On:<br>
                    </p>
                    <?php echo $bidding['end'];?>
                </div>
                <div class="col-6">
                    <p class="mb-1 font-weight-bold">Price Started at: </p>
                    <em><?php echo $bidding['startprice'];?></em> BD
                </div>
                <div class="col-6">
                    <p class="mb-1 font-weight-bold">Current Highest Bid: </p>
                    <?php 
                    if(isset($bidding['bid'])){
                        echo $bidding['bid'];?> by <?php echo $bidding['bidder'];
                    } 
                    else {
                        echo "No Bids Yet!";
                    }
                    ?>
                </div>
                <div class="col-6">
                    <p class="mb-1 font-weight-bold">Auction Status: </p>
                    <?php 
                        echo "<p class='text-success'><u>Active</u></p>";
                        ?>
                </div>
                <div class="col-6">
                    <p class="mb-1 font-weight-bold">Actions:</p>
                    <?php
                        $auctionid = $bidding['id'];
                        echo "<a href='viewAuction.php?auctionid=$auctionid' class='btn btn-sm btn-primary m-1'>View Auction</a>";             
                        echo "<a href='bid.php?auctionid=$auctionid' class='btn btn-sm btn-success m-1'>Bid Higher</a>";             
                        ?>
                </div>
            </div>
            <?php
            echo '</div>';
        }
        echo '</div>';
        echo '</div>';
        // echo '<a class="carousel-control-prev" href="#activeCarousel" role="button" data-slide="prev">';
        // echo '<span class="carousel-control-prev-icon  btn btn-outline-dark bg-dark" aria-hidden="true"></span>';
        // echo '<span class="sr-only">Previous</span>';
        // echo '</a>';
        echo '<a class="carousel-control-next" href="#activeCarousel" role="button" data-slide="next">';
        echo '<span class="carousel-control-next-icon  btn btn-outline-dark bg-dark" aria-hidden="true"></span>';
        echo '<span class="sr-only">Next</span>';
        echo '</a>';
    }
}
function displayPending($myPending){
    global $pendingCount;
    if ($pendingCount == 0) {
        echo '<div style="height: 25vh;">';
        echo '<li class="list-group-item list-group-item-action">';
        echo '<h3 class="text-center">You Did Not Win Any Bids</h3>';
        echo '</li>';
        echo '</div>';
    } 
    else {
        foreach ($myPending as $bidding) {
            ?>
        <li class="row list-group-item">
            <div class="col-6">
                <p class="font-weight-bold">
                    Product: <?php echo $bidding['name'];?>
                </p>
            </div>
            <div class="col-6">
                <p class="font-weight-bold">
                    Owner: <?php echo $bidding['owner'];?>
                </p>
            </div>
            <div class="col-6">
                <p class="mb-1 font-weight-bold">
                    Started On:<br>
                </p>
                <?php echo $bidding['start'];?>
            </div>
            <div class="col-6">
                <p class="mb-1 font-weight-bold">
                    Ends On:<br>
                </p>
                <?php echo $bidding['end'];?>
            </div>
            <div class="col-6">
                <p class="mb-1 font-weight-bold">Price Started at: </p>
                <em><?php echo $bidding['startprice'];?></em> BD
            </div>
            <div class="col-6">
                <p class="mb-1 font-weight-bold">Current Highest Bid: </p>
                <?php 
                if(isset($bidding['bid'])){
                    echo $bidding['bid'];?> by <?php echo $bidding['bidder'];
                } 
                else {
                    echo "No Bids Yet!";
                }
                ?>
            </div>
            <div class="col-6">
                <p class="mb-1 font-weight-bold">Auction Status: </p>
                <?php 
                    echo "<p class='text-warning'><u>Waiting for Purchase</u></p>";
                ?>
            </div>
            <div class="col-6">
                <p class="mb-1 font-weight-bold">Actions:</p>
                <?php
                    $auctionid = $bidding['id'];
                    echo "<a href='completeTransaction.php?auctionid=$auctionid' class='btn btn-sm btn-success m-1'>Complete Buying</a>";             
                    // echo "<a href='myAuctions.php?update=failed&auctionid=$auctionid' class='btn btn-sm btn-danger m-1'>Forfiet</a>";
                    ?>
            </div>
        </li>
        <?php
        }
    }
}

function displayHistory($history){
    global $historyCount;
    if ($historyCount==0){
        echo '<div style="height: 25vh;">';
        echo '<li class="list-group-item">';
        echo '<h3 class="text-center">You Did Not Win Any Bids</h3>';
        echo '</li>';
        echo '</div>';
    }
    else{
        foreach($history as $bidding){
            ?>
            <li class="row list-group-item list-group-item-action">
                <div class="col-6">
                    <p class="font-weight-bold">
                        Product: <?php echo $bidding['name'];?>
                    </p>
                </div>
                <div class="col-6">
                    <p class="font-weight-bold">
                        Owner: <?php echo $bidding['owner'];?>
                    </p>
                </div>
                <div class="col-6">
                    <p class="mb-1 font-weight-bold">
                        Started On:<br>
                    </p>
                    <?php echo $bidding['start'];?>
                </div>
                <div class="col-6">
                    <p class="mb-1 font-weight-bold">
                        Ends On:<br>
                    </p>
                    <?php echo $bidding['end'];?>
                </div>
                <div class="col-6">
                    <p class="mb-1 font-weight-bold">Price Started at: </p>
                    <em><?php echo $bidding['startprice'];?></em> BD
                </div>
                <div class="col-6">
                    <p class="mb-1 font-weight-bold">Current Highest Bid: </p>
                    <?php 
                    if(isset($bidding['bid'])){
                        echo $bidding['bid'];?> by <?php echo $bidding['bidder'];
                    } 
                    else {
                        echo "No Bids Yet!";
                    }
                    ?>
                </div>
                <div class="col-6">
                    <p class="mb-1 font-weight-bold">Auction Status: </p>
                    <?php 
                        echo "<p class='text-success'><u>Completed</u></p>";
                        ?>
                </div>
                <div class="col-6">
                    <p class="mb-1 font-weight-bold">Actions:</p>
                    <?php
                        $auctionid = $bidding['id'];
                        echo "<a href='chat.php?auctionid=$auctionid' class='btn btn-sm btn-outline-secondary m-1'>Chat</a>";
                    ?>
                    <div class="rate m-1">
                        <input type="radio" id="star5" class="star" name="rate" value="5" onclick="submit()"/>
                        <label for="star5" title="text">5 stars</label>
                        <input type="radio" id="star4" class="star" name="rate" value="4" onclick="submit()"/>
                        <label for="star4" title="text">4 stars</label>
                        <input type="radio" id="star3" class="star" name="rate" value="3" onclick="submit()"/>
                        <label for="star3" title="text">3 stars</label>
                        <input type="radio" id="star2" class="star" name="rate" value="2" onclick="submit()"/>
                        <label for="star2" title="text">2 stars</label>
                        <input type="radio" id="star1" class="star" name="rate" value="1" onclick="submit()"/>
                        <label for="star1" title="text">1 star</label>
                    </div>
                </div>
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
    <link rel="stylesheet" type="text/css" href="css/rateStars.css">

</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container-fluid px-5">
        <div>
            <?php if (isset($message) && $message=='created') {
                echo "<h1 class='text-success'>Auction Successfully Created</h1>";
            } elseif (isset($message) && $message=='bid') {
                echo "<h1 class='text-success'>Successfully Bidded on Auction</h1>";
            } ?>
        </div>

        <div class="row pt-0">
            <!-- My Auctions Section -->
            <div id="my-auctions" class="col-12 col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading mb-4">
                        <h2 class="panel-title font-weight-bold pb-0">My Auctions</h2>
                    </div>
                    <div class="panel-body">
                        <ul class="list-group mt-5" style="max-height: 65vh; margin-bottom: 10px; overflow:hidden; overflow-y:scroll; -webkit-overflow-scrolling: touch;">
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
                                <div style="height: 25vh; margin-bottom: 10px;">
                                    <?php 
                                    displayBiddings($myBids);
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <!-- Ended Bids Section -->
                        <div class="panel panel-primary mt-4 pt-2">
                            <div class="panel-heading mb-3">
                                <h2 class="panel-title font-weight-bold">Ended Bids</h2>
                            </div>
                            <div class="panel-body">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item active"><a href="#pending" class="nav-link active" data-toggle="tab">Pending</a></li>
                                    <li class="nav-item"><a href="#history" class="nav-link" data-toggle="tab">History</a></li>
                                </ul>	
                                <div class="tab-content">
                                    <div id="pending" class="tab-pane fade-in active">
                                        <ul class="list-group" style="height: 30vh; margin-bottom: 10px; overflow:hidden; overflow-y:scroll; -webkit-overflow-scrolling: touch;">
                                                <?php 
                                            displayPending($myPending);
                                            ?>
                                        </ul>
                                    </div>
                                    <div id="history" class="tab-pane fade">
                                        <ul class="list-group" style="height: 30vh; margin-bottom: 10px; overflow:hidden; overflow-y:scroll; -webkit-overflow-scrolling: touch;">
                                            <?php 
                                            displayHistory($history);
                                            ?>
                                        </ul>
                                    </div>
                                </div>	
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