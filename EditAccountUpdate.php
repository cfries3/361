<?php
include 'CheckConnected.php';

$name = $_POST['name'];
$design = $_POST['designation'];
$aid = $_POST['aid'];

$db = new mysqli("localhost", "root", "", "mysql");
if ($db->connect_error) {
	die('Connect Error (' . $db->connect_errno . ') '. $db->connect_error);
}

$query = "UPDATE comp361_account SET name = '$name', designation = '$design' WHERE aid='$aid'";

printf("%s", $query);

if($db->query($query)){
	printf("success");
}
else{
	printf("error");
}

?>