<?php 
require_once './databaseFunctionsOO.php';


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

$db = connect_db();

$username = mysql_real_escape_string($username);
$query = "SELECT password, uid, type FROM user WHERE username = '$username'";

$result = $db->query($query);

if($result->num_rows < 1) //no such user exists
{
	header('Location: ./pages/login.php');
	printf("not working");
	die(); 
}
$userData = $result->fetch_array(MYSQLI_ASSOC);

$enc = hash("sha512", $password);

if($enc != $userData['password']) //incorrect password
{
	header('Location: ./pages/login.php');
	die();
}
else
{
	validateUser($userData['uid'], $userData['type']); //sets the session data for this user
}
header('Location: ./pages/ProjectList.php')
?>
