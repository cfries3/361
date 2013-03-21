<?php
include 'CheckConnected.php';

$name = $_POST['name'];
$design = $_POST['designation'];

$db = new mysqli("localhost", "root", "", "mysql");
if ($db->connect_error) {
	die('Connect Error (' . $db->connect_errno . ') '. $db->connect_error);
}

$query = "INSERT INTO comp361_account (name, designation) VALUES ('$name', '$design');";

printf("%s", $query);

if($db->query($query)){
	printf("success");
}
else{
	printf("error");
}

?>