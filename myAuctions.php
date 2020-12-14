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
// require('connection.php');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Create New Auction</title>
	<?php include 'head.php'; ?>
</head>
<body>
	<?php include 'header.php'; ?>

	<?php if (isset($message) && $message=='created') {
        echo "<h1 class='text-success'>Auction Successfully Created</h1>";
    } elseif (isset($message) && $message=='bid') {
        echo "<h1 class='text-success'>Successfully Bidded on Auction</h1>";
    } ?>

	<?php include 'scripts.php'; ?>
</body>
</html>