<?php 

	switch($_SESSION['type']) {
		case "employee":
				$str_usrType = "an employee";
				break;
		case "admin":
				$str_usrType = "an administrator";
				break;
		case "client":
				$str_usrType = "a client";
				break;
		case "sysadmin":
				$str_usrType = "a sytem administrator";
				break;
	}
	echo <<<_END
		<div id="banner">
			<p class="floatLeft">You are logged in as $str_usrType </p>
			<p class="floatRight menuLink"><a href="./../logoutScript.php">Logout</a></p>
		</div>
_END;
?>
