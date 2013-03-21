<?php
include 'CheckConnected.php';

$name = $_POST['name'];
$Desc = $_POST['description'];
$amount = $_POST['amount'];
$design = $_POST['designation'];
$acc = $_POST['account'];
$xid = $_POST['xid'];

$db = new mysqli("localhost", "root", "", "mysql");
if ($db->connect_error) {
	die('Connect Error (' . $db->connect_errno . ') '. $db->connect_error);
}

$query = "UPDATE comp361_transaction SET name = '$name', description = '$Desc', amount = '$amount', designation = '$design', aid = '$acc' WHERE xid='$xid'";

printf("%s", $query);

if($db->query($query)){
	printf("success");
}
else{
	printf("error");
}

?>