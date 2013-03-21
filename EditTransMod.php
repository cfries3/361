<?php
include 'CheckConnected.php';

$xid = $_POST['account'];

$db = new mysqli("localhost", "root", "", "mysql");
if ($db->connect_error) {
	die('Connect Error (' . $db->connect_errno . ') '. $db->connect_error);
}

$query = "SELECT * From comp361_transaction WHERE xid='$xid'";

$result = $db->query($query);
if($result->num_rows < 1) 
{
	printf("error accessing data");
	die();
}
$transData = $result->fetch_array(MYSQLI_ASSOC);

$name = $transData['name'];
$description = $transData['description'];
$amount = $transData['amount'];
$designation = $transData['designation'];
$aid = $transData['aid'];

?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Add Transaction</title>
</head>
<body>

<form action="EditTransUpdate.php" method="post">

Name <input type="text" maxlength="30" name="name" value="<?php printf('%s',$name);?>"></input><br>
Description <textarea maxlength="1000" rows="5" cols="20" name="description" > <?php printf('%s',$description);?> </textarea><br>
Amount <input type="number" step="0.01" name="amount" value="<?php printf('%s',$amount);?>"></input><br>
<input type="radio" name="designation" value="income" <?php if($designation == "income"){ printf("checked='checked'");}?> >income
<input type="radio" name="designation" value="expense" <?php if($designation == "expense"){ printf("checked='checked'");}?>>expense<br>
<select name="account">
<?php

$db = new mysqli("localhost", "root", "", "mysql");
if ($db->connect_error) {
	die('Connect Error (' . $db->connect_errno . ') '. $db->connect_error);
}


$query = "SELECT name, aid From comp361_account ORDER BY name";

$result = $db->query($query);

while ($row = $result->fetch_array(MYSQLI_ASSOC)){
	if(!($row['aid'] == $aid)){
		printf("<option value='%s'> %s </option>", $row['aid'], $row['name']);
	}
	else{
		printf("<option value='%s' selected> %s </option>", $row['aid'], $row['name']);
	}
}

?>
</select><br>
<input type="hidden" name="xid" value="<?php printf("%s", $xid);?>">
<input type="submit"> 
</form>
</body>
</html>