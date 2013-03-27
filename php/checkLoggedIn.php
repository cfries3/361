<?php

session_start();

function isLoggedIn()
{
	if(isset($_SESSION['valid']) && $_SESSION['valid'])
		return true;
	return false;
}

function checkTimeOut(){
	$current_time = time();
	$timeout_lapse = 15 * 60;
	$time_lapse = $current_time - $_SESSION['start_time'];
	if ($time_lapse > $timeout_lapse){
		
		session_destroy();
		header('Location: ./login.php');
		
	}
	$_SESSION["start_time"] = time();
	
}

if (!isLoggedIn()){

	header('Location: ./login.php');

}

checkTimeOut();

?>