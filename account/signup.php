<?php
try{
    require('connection.php');
    //simple validation
    if (trim($name)=='' ||  trim($username)=='' || trim($password)=='' || trim($cpassword)=='' || trim($DOB)=='')
      echo 'Missing Information';
    else if ($password!=$cpassword)
      echo "Passwords don't match";
    else {
      $hashed = password_hash($password, PASSWORD_DEFAULT); //this is better function than md5 (more secure)
      // $dob="$y-$m-$d"; maybe this is needed to be inserted in the database
      $sql="insert into users values(NULL, '$name', '$username', '$hashed','$DOB','customer')";
      $r=$db->exec($sql);
      $db=null;

      if ($r==1)
        die('Successful registeration');
      else {
        echo 'Failed, please try again later';

      }
    }
}
catch(PDOException $ex) { //ex is the error object
    die ("Error Message ".$ex->getMessage());
}
?>