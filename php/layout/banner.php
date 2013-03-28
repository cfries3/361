<?php 

	//!!!!!TEMPORARY
	$str_usrType = $_SESSION['type'] = "employee";
	
	echo <<<_END
		<div id="banner">
			<p class="floatLeft">You are logged in as $str_usrType </p>
			<p class="floatRight menuLink"><a href="./../logoutScript.php">Logout</a></p>
		</div>
_END;
?>
