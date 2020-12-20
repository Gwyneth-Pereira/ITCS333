<?php
session_start();
if (!isset($_SESSION['active'])) {
	header('location: notAuthorized.php');
	exit;
}
extract($_REQUEST);
?>
<!DOCTYPE html>
<html>
<head>
	<style>
		img{	
			position: absolute;
			right: 0px;
			top: 0px;
			z-index: -1;	
			-webkit-mask-image:-webkit-gradient(linear, left top, left bottom, from(rgba(0,0,0,1)), to(rgba(0,0,0,0)));
			mask-image: linear-gradient(to bottom, rgba(0,0,0,1), rgba(0,0,0,0));
		}
	</style>
	<script>
	var nameFlag=detailsFlag=false;

	function checkProduct(name){
		var nameExp=/^[a-zA-Z0-9\s]{3,50}$/;
		if (name.length==0){
		m="";
		nameFlag=false;
		}
		else if (!nameExp.test(name)){
			m="Product name must be a minimum of 3 characters";
			c="red";
			nameFlag=false;
		}
		else{
			m="Valid Name";
			c="green";
			nameFlag=true;
		}
		document.getElementById('pmsg').style.color=c;
		document.getElementById('pmsg').innerHTML=m;
	}

	function checkDetails(details){
		var detailsExp=/^(.|\s)*[a-zA-Z]{3,200}(.|\s)*$/;
		if (details.length==0){
		m="";
		detailsFlag=false;
		}
		else if (!detailsExp.test(details)){
			m="Description must be a minimum of 3 and maximum of 200 characters, with at least 3 letters";
			c="red";
			detailsFlag=false;
		}
		else{
			m="Valid description";
			c="green";
			detailsFlag=true;
		}
		document.getElementById('dmsg').style.color=c;
		document.getElementById('dmsg').innerHTML=m;
	}

	function checkUserInputs(){
		document.forms[0].JSEnabled.value="TRUE";
		return (nameFlag && detailsFlag);
	}
	</script>
</head>	
</html>

<?php
if (isset($submit)){
	$productpattern="/^[a-zA-Z0-9\s]{3,50}$/";
	$detailspattern="/^(.|\s)*[a-zA-Z]{3,200}(.|\s)*$/";
	if ($JSEnabled=="FALSE"){
		if (trim($name)=='' || trim($details)=='' || trim($price)==''){
			header('location:createAuction.php?error=missing');
			exit;
		}
		elseif(!preg_match($productpattern,$name)){
			header('location:createAuction.php?error=wrongname');
			exit;
		}
		elseif(!preg_match($detailspattern,$details)){
			header('location:createAuction.php?error=wrongdetails');
			exit;
		}
	}

	try {
		require('connection.php');
		
		$db->beginTransaction();
		
		$sql = $db->prepare("INSERT INTO products VALUES(NULL, ?, ?, ?)");
		$sql->execute(array($name, $details, $category));
		
		$productid = $db->lastInsertId();
		
		$sql = $db->prepare("INSERT INTO auctions VALUES(NULL, ?, ?, NOW(), ?, ?, NULL, NULL, ?)");
		$sql->execute(array($_SESSION['username'], $productid, $end, $price, 'active'));
		
		$db->commit();
		// $db=null;
	} catch (PDOException $ex) {
		$db->rollBack();
		echo $ex->getMessage();
		exit;
	}

	header("location: uploadPictures.php?productid=$productid");
	exit;
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Create New Auction</title>
	<?php include 'head.php'; ?>
</head>
<body>
	<img src="images/problem-solving.jpg" width="750" height="900" style="float: right;">
	<?php include 'header.php'; ?>
	<?php
	$msg="";
	if(isset($error)&& $error=='missing'){
		$msg="Missing Information";
	}
	elseif(isset($error)&& $error=='wrongname'){
		$msg="Product name must be a minimum of 3 characters";
	}
	elseif(isset($error)&& $error=='wrongdetails'){
        $msg="Description must be a minimum of 3 and maximum of 200 characters, with at least 3 letters";
    }
	?>
	<div style="float: left; padding-left:8em">
	<h1 class="font-weight-bold mb-4">Create Auction</h1>
	
	<form method="POST" onSubmit="return checkUserInputs();">
		
        
		<p class="h5 text-left font-weight-bold mt-4">Product name:</p>
        <p><input style="width:180%" class="form-control" type="text" name="name" placeholder="Product Name" required onkeyup="checkProduct(this.value)"/><span id='pmsg'></span></p>
        
		<p  class="h5 text-left font-weight-bold mt-4">Cateogry:</p>
        <p>
        	<select style="width:180%" class="form-control" type='text' name='category' placeholder="Category" required>
				<option value="null">Please Select</option>
				<option>Art</option>
				<option>Books</option>
				<option>Clothings</option>
				<option>Electronics</option>
				<option>Health and Beauty</option>
				<option>Pets</option>
				<option>Vehicles</option>
				<option>Video Games</option>
				<option>Other</option>
        	</select>
        </p>
        <p class="h5 text-left font-weight-bold mt-4">Product Details:</p>
        <p><textarea style="width:180%"  class="form-control" required rows="5" cols="20" maxlength="200" type='details' name='details' placeholder="Product Details" onkeyup="checkDetails(this.value)"></textarea><span id='dmsg'></span></p>
        
		<p  class="h5 text-left font-weight-bold mt-4">Start Price:</p>
        <div class="input-group mb-3" style="width:180%">
			<div class="input-group-prepend">
				<span class="input-group-text">BD</span>
			</div>
			<input  class="form-control" type="number" step="any" name="price" placeholder="Price" required/>
		</div>
        
		<p class="h5 text-left font-weight-bold mt-4">End Time/Date:</p>
        <p><input style="width:180%" class="form-control" type="datetime-local" id="end" name="end" step="1" value="<?php echo date('Y-m-d H:i:s'); ?>" min="<?php echo date('Y-m-d').'T'.date('H:i:s'); ?>"
		max="<?php echo (date('Y')+1).date('-m-d').'T'.date('H:i:s'); ?>" required></p>

        <input type='hidden' name='JSEnabled' value='FALSE'/>
		<h3 class='text-danger my-4'><?php echo $msg;?></h3>
        <p><input class="btn btn-danger" type="submit" name="submit" value="Create Auction"></p>
    </form>
	</div>
	<?php include 'scripts.php'; ?>
	
</body>
</html>