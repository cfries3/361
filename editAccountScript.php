<?php
include 'CheckConnected.php';

$aid = $_POST['acc'];

$db = new mysqli("localhost", "root", "", "mysql");
if ($db->connect_error) {
	die('Connect Error (' . $db->connect_errno . ') '. $db->connect_error);
}

$query = "SELECT * From comp361_account WHERE aid='$aid'";

$result = $db->query($query);
if($result->num_rows < 1) 
{
	printf("error accessing data");
	die();
}
$accData = $result->fetch_array(MYSQLI_ASSOC);

$name = $accData['name'];
$designation = $accData['designation'];

?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Add Transaction</title>
</head>
<body>

<form action="EditAccountUpdate.php" method="post">

Name <input type="text" maxlength="30" name="name" value="<?php printf('%s',$name);?>"></input><br>
<input type="radio" name="designation" value="income" <?php if($designation == "income"){ printf("checked='checked'");}?> >income
<input type="radio" name="designation" value="expense" <?php if($designation == "expense"){ printf("checked='checked'");}?>>expense<br>
<input type="hidden" name="aid" value="<?php printf("%s", $aid);?>">
<input type="submit"> 
</form>
</body>
</html>