<?php
extract($_REQUEST);

if(isset($submit)){
    try{
        require('connection.php');
        
        $db->beginTransaction();
        
        $sql=$db->prepare("INSERT INTO transactions VALUES(NULL, ?, ?, ?, ?, ?)");
        $sql->execute(array($name, $auctionid, $number, $email, $address));
        
        
        $sql=$db->prepare("UPDATE auctions SET status=? WHERE id=?");
        $sql->execute(array('successful', $auctionid));
        
        $db->commit();
    }
    catch (PDOException $e){
        $db->rollBack();
        echo $ex->getMessage();
    }
    
    header('location: myAuctions.php');
    exit;    
}

if(isset($auctionid)){
?>
    <form method="POST" class="form-group w-25 mx-auto text-center">
        <h1 class="font-weight-bold mb-4">Complete Transaction</h1>
        <!-- <p>Full Name:</p> -->
        <p><input class="form-control" type="text" name="name" placeholder="Full Name"/></p>
        <!-- <p>Contact Number:</p> -->
        <p><input class="form-control" type="text" name="number" placeholder="Contact Number"/></p>
        <!-- <p>Email:</p> -->
        <p><input class="form-control" type="email" name="email" placeholder="Email"/></p>
        <!-- <p>Address:</p> -->
        <textarea name="address" cols="30" rows="10" placeholder="Delivery Address"></textarea>
        <!-- <p>Hidden Auction ID:</p> -->
        <p><input  type="hidden" name="auctionid" value="$auctionid"/></p>
        <p><input class="btn btn-danger" type="submit" name="submit" value="Complete"></p>
    </form>
<?php    
}
?>
