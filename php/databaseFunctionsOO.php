<?php
$db_host = 'localhost';
$db_name = 'mysql';
$db_user = 'root';
$db_pass = ''; //database

function connect_db(){
	$db = new mysqli("localhost", "superuser", "superuser", "b_portal");
	if ($db->connect_error) {
		die('Connect Error (' . $db->connect_errno . ') '. $db->connect_error);
	}
	return $db;
}