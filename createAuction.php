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
	<script>
	var nameFlag=detailsFlag=false;

	function checkName(name){
		var nameExp=/^[a-zA-Z]{3,}(?:\s[a-zA-Z]{3,})+$/;
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
	$productpattern="/^[a-zA-Z]{3,}(?:\s[a-zA-Z]{3,})+$/";
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
	<form method="POST" class="form-group w-25 mx-auto text-center" onSubmit="return checkUserInputs();">
		<h1 class="font-weight-bold mb-4">Create Auction</h1>
        
		<p class="h5 text-left font-weight-bold mt-4">Product name:</p>
        <p><input class="form-control" type="text" name="name" placeholder="Product Name" required onkeyup="checkProduct(this.value)"/><span id='pmsg'></p>
        
		<p class="h5 text-left font-weight-bold mt-4">Cateogry:</p>
        <p>
        	<select class="form-control" type='text' name='category' placeholder="Category">
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
        <p><textarea class="form-control" rows="5" cols="20" maxlength="200" type='details' name='details' placeholder="Product Details" onkeyup="checkDetails(this.value)"></textarea><span id='dmsg'></p>
        
		<p class="h5 text-left font-weight-bold mt-4">Start Price:</p>
        <div class="input-group mb-3">
			<div class="input-group-prepend">
				<span class="input-group-text">BD</span>
			</div>
			<input class="form-control" type="number" step="any" name="price" placeholder="Price" required/>
		</div>
        
		<p class="h5 text-left font-weight-bold mt-4">End Time/Date:</p>
        <p><input class="form-control" type="datetime-local" id="end" name="end" step="1" value="<?php echo date('Y-m-d H:i:s'); ?>" min="<?php echo date('Y-m-d').'T'.date('H:i:s'); ?>"
		max="<?php echo (date('Y')+1).date('-m-d').'T'.date('H:i:s'); ?>" required></p>

        <input type='hidden' name='JSEnabled' value='FALSE' />
		<h3 class='text-danger mb-4 mt-4'><?php echo $msg;?></h3>
        <p><input class="btn btn-danger" type="submit" name="submit" value="Create Auction"></p>
    </form>
	
	<?php include 'scripts.php'; ?>
	
</body>
</html>