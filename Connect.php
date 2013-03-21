<?php 

function validateUser($id, $type)
{
	session_start();
	session_regenerate_id (); //this is a security measure
	$_SESSION['valid'] = 1;
	$_SESSION['userid'] = $id;
	$_SESSION['type'] = $type;
	$_SESSION['start_time'] = time();
}

$username = $_POST['Username'];
$password = $_POST['Password'];

$db = new mysqli("localhost", "root", "", "mysql");
if ($db->connect_error) {
	die('Connect Error (' . $db->connect_errno . ') '. $db->connect_error);
}

$username = mysql_real_escape_string($username);
$query = "SELECT password, uid, type
FROM comp361_user
WHERE username = '$username';";
$result = $db->query($query);
if($result->num_rows < 1) //no such user exists
{
	header('Location: http://localhost/webs/BusinnessPortalTests/LoginPage.html');
	die();
}
$userData = $result->fetch_array(MYSQLI_ASSOC);
if($password != $userData['password']) //incorrect password
{
	header('Location: http://localhost/webs/BusinnessPortalTests/LoginPage.html');
	die();
}
else
{
	validateUser($userData['uid'], $userData['type']); //sets the session data for this user
}
header('Location: http://localhost/webs/BusinnessPortalTests/WelcomePage.php')
?>
