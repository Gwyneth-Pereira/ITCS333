<?php
session_start();

// No need here to check logging in... because guests can browse... but not bid... logging verifying should be in bid.php
// if (!isset($_SESSION['active'])) { 
// 	header('location: notAuthorized.php');
// 	exit;
// }

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Browse Auctions</title>
	<?php include 'head.php'; ?>
</head>
<body>
	<?php include 'header.php'; ?>

	<div class="container">
		<h1>This is the browse page</h1>
	</div>
    <div class="container">
    <?php 
            try {
                require('connection.php');
                $auctions = $db->prepare("SELECT * FROM auctions WHERE status='active'"); // maybe better to add WHERE status=active
                $auctions->execute();
                foreach ($auctions as $auction){
                    $auctionid = $auction['id'];
                    $productid = $auction['product'];
                    $products = $db->prepare("SELECT * FROM products WHERE id=?");
                    $products->execute(array($productid));
                    
                    // name and a few lines of details of product
                    while ($product=$products->fetch()){   
                        $name = $product['name'];
                        $details = $product['details'];
                        echo "<p>Auction #</p>";
                        echo "<div class='card' style='width: 18rem;'>";
                        echo "<img src='...' class='card-img-top' alt='...'>"; // include picture/couresule
                            echo "<div class='card-body'>";
                            echo "<h5 class='card-title'>$name</h5>";
                            echo "<p class='card-text'>$details</p>";
                            // view picture, owner, start price, highest bid, all details, start/end date+time, AND BID BUTTON
                            echo "<a href='viewAuction.php?auctionid=$auctionid&productid=$productid' class='btn btn-primary'>View Details</a>"; 
                            echo "</div>";
                        echo "</div>";
                    }
                }
                $db =null;
            } catch (PDOException $ex) {
                echo $ex->getMessage();
            }
            ?>
    </div>

	<?php include 'scripts.php'; ?>
</body>
</html>