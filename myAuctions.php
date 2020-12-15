<!-- 
    page includes both auctions (button to upload pics) 
    and bids (show whether winning or losing)
 -->

<?php
session_start();
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
            echo '<li class="list-group-item">';
                echo '<p class="text-center">'.$auction['id'].'</p>';
            echo '</li>';
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
            echo '<li class="list-group-item">';
                echo '<p class="text-center">'.$bidding['id'].'</p>';
            echo '</li>';
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
                    <div class="panel-heading">
                        <h2 class="panel-title font-weight-bold">My Auctions</h2>
                    </div>
                    <div class="panel-body">
                        <ul class="list-group" style="max-height: 400px; margin-bottom: 10px; overflow:scroll; -webkit-overflow-scrolling: touch;">
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
                    <div class="panel-heading">
                        <h2 class="panel-title font-weight-bold">My Bids</h2>
                    </div>
                    <div class="panel-body">
                        <ul class="list-group" style="max-height: 400px; margin-bottom: 10px; overflow:scroll; -webkit-overflow-scrolling: touch;">
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