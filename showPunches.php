<?php 
include 'CheckConnected.php';

?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>show punches</title>
</head>
<body>

<?php
$tid = $_POST['tid'];

$db = new mysqli("localhost", "root", "", "mysql");
if ($db->connect_error) {
	die('Connect Error (' . $db->connect_errno . ') '. $db->connect_error);
}

$query = "SELECT *
FROM comp361_punchentity
WHERE tid = '$tid'
ORDER BY punch_id";

$punches = $db->query($query);

if($punches->num_rows < 1){
	
	printf("No data found for this task");
}
printf("<table cellspacing='10'> <tr> <th> time in </th> <th> time out </th> <th> modified </th> <th> auto log out </th> <th> comment </th> <th> Employee </th></tr>");
while ($row = $punches->fetch_array(MYSQLI_ASSOC)){
	$uid = $row['uid'];
	$query = "SELECT fname, lname, uid
	FROM comp361_employee
	WHERE uid = '$uid'";
	
	$employee = $db->query($query);
	
	$empInfo = $employee->fetch_array(MYSQLI_ASSOC);
	
	$status = "false";
	if ($row['status_flag'] == 1){
		$status = "true";
	}
	
	$autoLogOut = "false";
	if ($row['auto_flag'] == 1){
		$autoLogOut = "true";
	}
	

	printf("<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s %s</td><tr>", $row['time_in'], $row['time_out'], $status, $autoLogOut, $row['comment'], $empInfo['fname'], $empInfo['lname']);
	
	
}

printf("</table>");


?>

</body>
</html>



