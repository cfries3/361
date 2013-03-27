<?php

session_start();

if(isset($_SESSION['valid'])){
	$_SESSION['valid'] = 0;
}

session_destroy ( void );

header('Location: ./pages/login.php');

?>