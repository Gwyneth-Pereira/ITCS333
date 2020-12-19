<?php
// session_start();
require('controlled.php');
// No need here to check logging in... because guests can browse... but not bid... logging verifying should be in bid.php
// if (!isset($_SESSION['active'])) { 
// 	header('location: notAuthorized.php');
// 	exit;
// }
?>

	<div class="container">
		<h1 class="text-center display-4 my-5 pt-5">Browse Auctions</h1>
	</div>
    <div class="container">
        <div class="row pb-5">
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
                    
                    $owner = $auction['owner'];
                    if (isset($auction['bid'])) {
                        $bid = $auction['bid'];
                    } else {
                        $bid = $auction['startprice'];
                    }
                    
                    // display name and a few lines of details of product
                    while ($product=$products->fetch()){   
                        $name = $product['name'];
                        $details = $product['details'];
                        // echo "<p>Auction #</p>";
                        echo '<div class="col-12 col-lg-3 m-4">';
                        echo "<div class='card' style='width: 19em; height: 32em;'>";
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
                        
                        echo "<div class='card-body' style='height: 280px;'>";
                        echo "<h5 class='card-title font-weight-bold'>$name</h5>";
                        echo "<p class='card-text text-truncate' style='height: 45px;'>Details:<br>$details</p>";
                        echo "<p class='card-text'><span class='font-weight-bold'>Owner:</span> <a href='viewUser.php?user=$owner'>$owner</a><span class='ml-4'>Bid: $bid</span></p>";
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
    

	
<!-- </body>
</html> -->