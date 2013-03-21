<?php
include 'CheckConnected.php';

?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Edit Transaction</title>

 
</head>
<body>

<form action="editAccountScript.php" method="post">
select an accout
<select id="acc" name="acc">
    <?php

		$db = new mysqli("localhost", "root", "", "mysql");
		if ($db->connect_error) {
			die('Connect Error (' . $db->connect_errno . ') '. $db->connect_error);
		}


		$query = "SELECT name, aid From comp361_account ORDER BY name";

		$result = $db->query($query);

		while ($row = $result->fetch_array(MYSQLI_ASSOC)){
			printf("<option value='%s' > %s </option>", $row['aid'], $row['name']);
		}

	?>
</select><br>
<input type="submit">
</form>
</body></html>