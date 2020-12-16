<?php
session_start();
require('controlled.php');
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
        <div class="row">
            <?php 
            try {
                require('connection.php');
                $auctions = $db->prepare("SELECT * FROM auctions WHERE status='active'"); // maybe better to add WHERE status=active
                $auctions->execute();
                $i = 0;
                foreach ($auctions as $auction){
                    $i++;
                    $auctionid = $auction['id'];
                    $productid = $auction['product'];
                    $products = $db->prepare("SELECT * FROM products WHERE id=?");
                    $products->execute(array($productid));
                    
                    $sql = $db->prepare("SELECT picture FROM pictures WHERE product=?");
                    $sql->execute(array($productid));
                    $pictures = $sql->fetchAll();

                    // display name and a few lines of details of product
                    while ($product=$products->fetch()){   
                        $name = $product['name'];
                        $details = $product['details'];
                        // echo "<p>Auction #</p>";
                        echo '<div class="col-12 col-lg-3 mx-4">';
                        echo "<div class='card' style='width: 19em;'>";
                        if (!$pictures) {
                            echo "<img src='images/products/default-image.png' class='card-img-top' style='height: 300px;'>"; 
                        } else {
                            // include picture/Carousel of pictures
                            echo '<div id="carousel'.$i.'" class="carousel slide" data-ride="carousel">';
                            echo '<div class="carousel-inner card-img-top" style="height: 300px;">';
                            $first = true;
                            foreach ($pictures as $holder) {
                                $picture = $holder['picture'];
                                if ($first) {
                                    echo '<div class="carousel-item active">';
                                    $first = false;
                                } else {
                                    echo '<div class="carousel-item">';
                                }
                                echo "<img src='$picture' class='d-block w-100' style='min-height: 100%;'>"; 
                                echo '</div>';
                            }
                            echo '</div>';
                            echo '</div>';
                            echo '<a class="carousel-control-prev" href="#carousel'.$i.'" role="button" data-slide="prev">';
                                echo '<span class="carousel-control-prev-icon" aria-hidden="true"></span>';
                                echo '<span class="sr-only">Previous</span>';
                            echo '</a>';
                            echo '<a class="carousel-control-next" href="#carousel'.$i.'" role="button" data-slide="next">';
                                echo '<span class="carousel-control-next-icon" aria-hidden="true"></span>';
                                echo '<span class="sr-only">Next</span>';
                            echo '</a>';
                        }
                        
                        echo "<div class='card-body'>";
                        echo "<h5 class='card-title'>$name</h5>";
                        echo "<p class='card-text'>$details</p>";
                        // view picture, owner, start price, highest bid, all details, start/end date+time, AND BID BUTTON
                        echo "<a href='viewAuction.php?auctionid=$auctionid' class='btn btn-primary'>View Details</a>"; 
                        echo "</div>";
                        echo "</div>";
                        echo '</div>';
                        }
                }
                $db =null;
            } catch (PDOException $ex) {
                echo $ex->getMessage();
            }
            ?>
        </div>
    </div>
    

	<?php include 'scripts.php'; ?>
</body>
</html>