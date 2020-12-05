<?php
session_start();
require 'connection.php'; 
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>My Profile</title>
    <?php include 'head.php'; ?>
</head>
<body>
    <?php include 'header.php'; ?>

    <?php if (!$_SESSION['active']) {
        header('location: notAuthorized.php');
    } ?>

    <table border='1' align='center' width='300'>
        <tr>
            <th>Name</th>
            <th>Username</th>
            <th>User Type</th>
            <th>DOB</th>
            <th>Password</th>
            <th>Update</th>
            <th>Remove</th>
        </tr>
    <?php
        $username = $_SESSION['username'];
        $sql = $db->prepare("SELECT * FROM users WHERE User=?;");
        $holder = $sql->execute(array($username));
        
        if ($info = $holder->fetch()){
            echo "<tr>";
                echo "<td>$info['Name']</td>";
                echo "<td>$info['Username']</td>";
                echo "<td>Password</td>";
                echo "<td>$info['DOB']</td>";
                echo "<th><input type='submit' name='sb' value='Reset' /></th>";
                echo "<th><input type='submit' name='sb' value='Update' /></th>";
                echo "<th><input type='submit' name='sb' value='Delete' /></th>";
                
                // echo "<input type='hidden' name='uid' value='$row[0]'/>\n";
                // echo "<td><input name='n' value='$row[1]' /></td>";
                // echo "<td><input name='un' value='$row[2]' /></td>";
                // echo "<td><input name='ut' value='$row[5]' /></td>";
                // echo "<td><input name='dob' value='".$row[4]."' />'</td>";
                // echo "<th><input type='submit' name='sb' value='Reset' /></th>";
                // echo "<th><input type='submit' name='sb' value='Update' /></th>";
                // echo "<th><input type='submit' name='sb' value='Delete' /></th>";
            echo "</tr>";
        }
     ?>
    </table>

    <?php include 'scripts.php'; ?>
</body>
</html>
