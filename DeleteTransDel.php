<?php
$xid = $_POST['xid'];

$db = new mysqli("localhost", "root", "", "mysql");
if ($db->connect_error) {
	die('Connect Error (' . $db->connect_errno . ') '. $db->connect_error);
}

$query = "DELETE FROM comp361_transaction WHERE xid='$xid'";

printf("%s", $query);

if($db->query($query)){
	printf("success");
}
else{
	printf("error");
}
?>