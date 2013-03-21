<?php
include 'CheckConnected.php';

?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Add Account</title>
</head>
<body>

<form action="addAccountScript.php" method="post">

Name <input type="text" maxlength="30" name="name"></input><br>
<input type="radio" name="designation" value="income">income
<input type="radio" name="designation" value="expense">expense<br>
<input type="submit"> 
</form>
</body>
</html>