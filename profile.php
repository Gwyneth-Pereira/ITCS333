<?php
session_start();
require 'connection.php'; 
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>My Project</title>
    <?php include 'head.php'; ?>
</head>
<body>
    <?php include 'header.php'; ?>



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
    /*
    The form has three actions:
    1. Reset Password: should reset the password to abc123 (you need to hash it before storing it)
    2. Update user details if there is a change in the data. (No Input validation is required)
    3. Remove user record from the db.
    */
      if ($row = $rs->fetch()){
        echo "<form method='post' action='domyrequest.php'>";
        echo "<input type='hidden' name='uid' value='$row[0]' />\n";
        echo "<tr>";
        echo "<td><input name='n'  value='$row[1]' /></td>";
        echo "<td><input name='un' value='$row[2]' /></td>";
        echo "<td><input name='ut' value='$row[5]' /></td>";
        echo "<td><input name='dob' value='".$row[4]."' />'</td>";
        echo "<th><input type='submit' name='sb' value='Reset' /></th>";
        echo "<th><input type='submit' name='sb' value='Update' /></th>";
        echo "<th><input type='submit' name='sb' value='Delete' /></th>";
        echo "</tr>";
        echo "</form>";
      }
     ?>
    </table>

    <?php include 'scripts.php'; ?>
</body>
</html>
