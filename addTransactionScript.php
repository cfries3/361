<?php
include 'CheckConnected.php';

$name = $_POST['name'];
$Desc = $_POST['description'];
$amount = $_POST['amount'];
$design = $_POST['designation'];
$acc = $_POST['account'];
$date = date('Y-m-d');

$db = new mysqli("localhost", "root", "", "mysql");
if ($db->connect_error) {
	die('Connect Error (' . $db->connect_errno . ') '. $db->connect_error);
}

$query = "INSERT INTO comp361_transaction (name, description, amount, designation, aid, date) VALUES ('$name', '$Desc', '$amount', '$design', '$acc', '$date');";

printf("%s", $query);

if($db->query($query)){
	printf("success");
}
else{
	printf("error");
}

?>