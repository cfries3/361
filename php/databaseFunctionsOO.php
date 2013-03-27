<?php
$db_host = 'localhost';
$db_name = 'b_portal';
$db_user = 'superuser';
$db_pass = 'superuser'; //database

function connect_db(){
	$db_host = 'localhost';
	$db_name = 'b_portal';
	$db_user = 'superuser';
	$db_pass = 'superuser';
	
	$db = new mysqli($db_host, $db_user, $db_pass, $db_name);
	if ($db->connect_error) {
		die('Connect Error (' . $db->connect_errno . ') '. $db->connect_error);
	}
	return $db;
}

?>