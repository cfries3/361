<?php
require_once './../databaseFunctionsOO.php';

$tid = $_POST['tid'];

$db = connect_db();

$query = "SELECT *
FROM punch
WHERE tid = '$tid'
ORDER BY punch_id";

$punches = $db->query($query);

printf("<div id='content' class='floatLeft'>");
if($punches->num_rows < 1){

	printf("No data found for this task");
}else{
printf("<table cellspacing='10'> <tr> <th> time in </th> <th> time out </th> <th> modified </th> <th> auto log out </th> <th> comment </th> <th> Employee </th></tr>");
while ($row = $punches->fetch_array(MYSQLI_ASSOC)){
	$uid = $row['uid'];
	$query = "SELECT fname, lname, uid
	FROM employee
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
}
printf("</div>");
?>