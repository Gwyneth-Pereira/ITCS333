<?php
session_start();

require('controlled.php');

extract($_REQUEST);

require('connection.php');
$username = $user;
$sql = $db->prepare("SELECT * FROM auctions, ratings WHERE ratings.auctionid = auctions.id AND owner=?");
$sql->execute(array($username));
$holder = $sql->fetchAll();

if (isset($holder['buyerRating'])) {
	$sellerRating = $holder['buyerRating'];
	
} else {
	$sellerRating = 'Not Rated Yet';
}

$sql = $db->prepare("SELECT * FROM auctions, ratings WHERE ratings.auctionid = auctions.id AND bidder=?");
$sql->execute(array($username));
$holder = $sql->fetchAll();

if (isset($holder['sellerRating'])) {
	$buyerRating = $holder['sellerRating'];
	
} else {
	$buyerRating = 'Not Rated Yet';
}

$sql = $db->prepare("SELECT * FROM users WHERE username=?");
if ($sql->execute(array($username))){
	while ($info = $sql->fetch(PDO::FETCH_ASSOC)) {   
		$name = $info['name'];
		$username = $info['username'];
		$email = $info['email'];
		if (isset($info['picture'])) {
			$picture = $info['picture'];
			$image = "images/users/$picture";
		} else {
			$image = "images/users/default-avatar.png";
		}

	}
}
	
$sql = $db->prepare("SELECT auctions.*, products.name FROM auctions, products WHERE auctions.owner=? AND products.id=auctions.product");
$sql->execute(array($username));
$myAuctions = $sql->fetchAll();
$auctionsCount = $sql->rowCount();
	
function displayAuctions($myAuctions){
    global $auctionsCount;
    if ($auctionsCount == 0) {
        echo '<div style="height: 25vh;">';
        echo '<li class="list-group-item">';
            echo '<h3 class="text-center">User Does Not Own Any Auctions Currently</h3>';
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
                        $bid = $auction['bid'];
                        $bidder = $auction['bidder'];
                        echo "$bid by <a href='viewUser.php?user=$bidder'>$bidder</a>";
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
						echo "<a href='viewAuction.php?auctionid=$auctionid' class='btn btn-sm btn-primary'>View Auction</a>";
					}                    
                    ?>
                
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
	<title><?php echo $user; ?></title>
	<?php include 'head.php'; ?>
</head>
<body>
	<?php include 'header.php'; ?>

	<div class="container">
		
		<h1 class="display-4 text-left mb-5">My Profile</h1>
		
		<div class="row">
			<div class="col-4 pr-5 border-right">
				<div id="picture" class="text-center mb-5">
					<div class="rounded-circle mb-3">
						<img src="<?php echo $image; ?>" style="max-height: 13rem;">
					</div>
				</div>
				
				<div id="rating">
					<p class="h6 mb-4">
						Buyer Rating: 
						<span class="h5">
							<?php echo $buyerRating; ?>
						</span>
					</p>					
					
					<p class="h6">
						Seller Rating:
						<span class="h5">
							<?php echo $sellerRating; ?>
						</span>
					</p>
				</div>
			</div>
			
			<div class="col-8 pl-5">
				<div id="info">
					<p class="h2 mb-4"><?php echo $name ?></p>
					<p class="h5 mb-2">Username: <?php echo $username ?></p>
					<p class="h5 mb-5">Email: <?php echo $email ?></p>
				</div>
				
				<div id="settings" class="mt-5">
					<h3>Auctions</h3>
					<hr>
					<form method='POST'>
						<input type='submit' name='infoupdate' class="btn btn-lg btn-outline-dark" value='Edit Information'/>
						<input type='submit' name='passwordchange' class="btn btn-lg btn-outline-danger" value='Change Password'/>
					</form>
				</div>
			</div>
		</div>
	</div>

	<?php include 'scripts.php'; ?>
</body>
</html>