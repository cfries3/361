<?php
include 'CheckConnected.php';

?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Add Transaction</title>
</head>
<body>

<form action="addTransactionScript.php" method="post">

Name <input type="text" maxlength="30" name="name"></input><br>
Description <textarea maxlength="1000" rows="5" cols="20" name="description"></textarea><br>
Amount <input type="number" step="0.01" name="amount"></input><br>
<input type="radio" name="designation" value="income">income
<input type="radio" name="designation" value="expense">expense<br>
<select name="account">
<?php

$db = new mysqli("localhost", "root", "", "mysql");
if ($db->connect_error) {
	die('Connect Error (' . $db->connect_errno . ') '. $db->connect_error);
}


$query = "SELECT name, aid From comp361_account ORDER BY name";

$result = $db->query($query);

while ($row = $result->fetch_array(MYSQLI_ASSOC)){
	printf("<option value='%s'> %s </option>", $row['aid'], $row['name']);
}

?>
</select><br>
<input type="submit"> 
</form>
</body>
</html>