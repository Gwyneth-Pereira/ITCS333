<?php
	// Connection Instance
	$db = new PDO('mysql: host=localhost; dbname=db; charset=utf8', 'root', '');
	// For error handling
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>