<?php
session_start();
extract($_REQUEST);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Complete Transaction</title>
    <?php include 'head.php'; ?>
    
	<script>
        var nameFlag=numberFlag=emailFlag=addressFlag=false;

        function checkName(name){
            var nameExp=/^[a-zA-Z]{3,}(?:\s[a-zA-Z]{3,})+$/;
            if (name.length==0){
            m="";
            nameFlag=false;
            }
            else if (!nameExp.test(name)){
                m="Please enter your first and last name seperated by a space";
                c="red";
                nameFlag=false;
            }
            else{
                m="Valid Name";
                c="green";
                nameFlag=true;
            }
            document.getElementById('nmsg').style.color=c;
            document.getElementById('nmsg').innerHTML=m;
        }

        function checkNumber(number){
            var numExp=/^((\+|00)973)?\s?\d{8}$/;
            if (number.length==0){
                m="";
                numberFlag=false;
            }
            else if (!numExp.test(number)){
                m="Invalid Number";
                c="red";
                numberFlag=false;
            }
            else{
                m="Valid Number";
                c="green";
                numberFlag=true;
            }
            document.getElementById('nummsg').style.color=c;
            document.getElementById('nummsg').innerHTML=m;
        }

        function checkEmail(email){
            var emailExp=/^[a-zA-Z0-9._-]+@[a-zA-Z0-9]+\.[a-zA-Z]{2,5}$/;
            if (email.length==0){
            m="";
            emailFlag=false;
            }
            else if (!emailExp.test(email)){
                m="Invalid Email: must be in the format ****@****.***";
                c="red";
                emailFlag=false;
            }
            else{
                m="Valid Email";
                c="green";
                emailFlag=true;
            }
            document.getElementById('emsg').style.color=c;
            document.getElementById('emsg').innerHTML=m;
        }
        
        function checkAddress(address){
            var addressExp=/^(.|\s)*[a-zA-Z]{3,200}(.|\s)*$/;
            if (address.length==0){
            m="";
            addressFlag=false;
            }
            else if (!addressExp.test(address)){
                m="Invalid Address";
                c="red";
                addressFlag=false;
            }
            else{
                m="Valid Address";
                c="green";
                addressFlag=true;
            }
            document.getElementById('amsg').style.color=c;
            document.getElementById('amsg').innerHTML=m;
        }

        function checkUserInputs(){
            document.forms[0].JSEnabled.value="TRUE";
            return (nameFlag && numberFlag && emailFlag && addressFlag);
        }
    </script>

    <?php
    if(isset($submit)){
        $namepattern="/^[a-zA-Z]{3,}(?:\s[a-zA-Z]{3,})+$/";
        $numberpattern="/^((\+|00)973)?\s?\d{8}$/";
        $emailpattern="/^[a-zA-Z0-9._-]+@[a-zA-Z0-9]+\.[a-zA-Z]{2,5}$/";
        $addresspattern="/^(.|\s)*[a-zA-Z]{3,200}(.|\s)*$/";
        if ($JSEnabled=="FALSE"){
            if (trim($name)=='' || trim($number)=='' || trim($email)=='' || trim($address)==''){
                header('location:completeTransaction.php?error=missing');
                exit;
            }
            elseif(!preg_match($namepattern,$name)){
                header('location:completeTransaction.php?error=wrongname');
                exit;
            }
            elseif(!preg_match($numberpattern,$number)){
                header('location:completeTransaction.php?error=wrongnumber');
                exit;
            }
            elseif(!preg_match($emailpattern,$email)){
                header('location:completeTransaction.php?error=wrongemail');
                exit;
            }
            elseif(!preg_match($addresspattern,$address)){
                header('location:completeTransaction.php?error=wrongaddress');
                exit;
            }
        }
        
        try{
            require('connection.php');
            
            $db->beginTransaction();
            
            $sql=$db->prepare("INSERT INTO transactions VALUES(NULL, ?, ?, ?, ?, ?)");
            $sql->execute(array($name, $auctionid, $number, $email, $address));
            
            
            $sql=$db->prepare("UPDATE auctions SET status=? WHERE id=?");
            $sql->execute(array('successful', $auctionid));
            
            $db->commit();
        }
        catch (PDOException $ex){
            $db->rollBack();
            echo $ex->getMessage();
            exit;
        }
        
        header('location: myAuctions.php');
        exit;    
    }
    ?>
</head>
<body>
    <?php include 'header.php'; ?>

    <?php
    if(isset($auctionid)){
        $msg="";
        if(isset($error)&& $error=='missing'){
            $msg="Missing Information";
        }
        elseif(isset($error)&& $error=='wrongname'){
            $msg="Please enter your first and last name seperated by a space";
        }
        elseif(isset($error)&& $error=='wrongnumber'){
            $msg="Invalid Number";
        }
        elseif(isset($error)&& $error=='wrongemail'){
            $msg="Invalid Email: must be in the format ****@****.***";
        }
        elseif(isset($error)&& $error=='wrongaddress'){
            $msg="Invalid Address";
        }
        ?>
        <form method="POST" class="form-group w-25 mx-auto text-center" onSubmit="return checkUserInputs();">
            <h1 class="font-weight-bold mb-4">Complete Transaction</h1>
            <!-- <p>Full Name:</p> -->
            <p><input class="form-control" required type="text" name="name" placeholder="Full Name" onkeyup="checkName(this.value)"/><span id='nmsg'></span></p>
            <!-- <p>Contact Number:</p> -->
            <p><input class="form-control" required type="text" name="number" placeholder="Contact Number"onkeyup="checkNumber(this.value)"/><span id='nummsg'></span></p>
            <!-- <p>Email:</p> -->
            <p><input class="form-control" required type="email" name="email" placeholder="Email" onkeyup="checkEmail(this.value)"/><span id='emsg'></span></p>
            <!-- <p>Address:</p> -->
            <p><textarea class="form-control" required name="address" cols="30" rows="10" placeholder="Delivery Address" onkeyup="checkAddress(this.value)"></textarea><span id='amsg'></span></p>
            <!-- <p>Hidden Auction ID:</p> -->
            <p><input  type="hidden" name="auctionid" value="<?php echo $auctionid;?>"/></p>
            <input type='hidden' name='JSEnabled' value='FALSE'/>
            <h3 class='text-danger mb-4 mt-4'><?php echo $msg;?></h3>
            <p><input class="btn btn-danger" type="submit" name="submit" value="Complete"></p>
        </form>
        <?php    
    }
?>
    <?php include 'scripts.php'; ?>
</body>
</html>