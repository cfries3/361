<?php

?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>LoginPage</title>
<script type="text/javascript" src="jsSHA-master\jsSHA-master\src\sha.js"></script>
	<link rel="stylesheet" type="text/css" href="./../../css/default.css" />
	<link rel="stylesheet" type="text/css" href="./../../css/formBased.css" />
	
</head>
<body>

	<div id="login">
		<div id="miniBanner">
			<img class="floatLeft" src="./../../images/logo.png" alt="Company Name" />
			<h1>Business Portal</h1>
		</div>
		<form action="./../loginScript.php" method="post">
			<table class="forms formsSM">
				<tr>
					<td class="col1"><label for="Username">Username</label></td>
					<td class="col2"><input type="text" name="Username" class="field"/></td>
				</tr>
				<tr>
					<td class="col1"><label for="password">Password</label></td>
					<td class="col2"><input type="password" name="Password" class="field" /></td>
				</tr>
				<tr>
					<td colspan="2" class="twoCol"><input type="submit" class="button" value="Login"/></td>
				</tr>
			</table>
		</form>
	</div>
	
</body>
</html>