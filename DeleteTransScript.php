<?php
include 'CheckConnected.php';

$db = new mysqli("localhost", "root", "", "mysql");
if ($db->connect_error) {
	die('Connect Error (' . $db->connect_errno . ') '. $db->connect_error);
}
$acc = $_POST['acc'];
$date=$_POST['date'];

$query = "SELECT xid, name From comp361_transaction WHERE date='$date' AND aid='$acc'";

$result = $db->query($query);

if($result->num_rows < 1)
{
	printf("Sorry no result found matching this date and account");
	die();
}

printf("<form action='DeleteTransDel.php' method='post'>");
while ($row = $result->fetch_array(MYSQLI_ASSOC)){
	printf("<input type='radio' name='xid' value='%s'> %s </option><br>", $row['xid'], $row['name']);
}
printf("<input type='submit'>");
printf("</form>");
?>