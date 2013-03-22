<?php // databaseFunctions.php
//comment getpost

$db_host = 'localhost';
$db_name = 'mysql';
$db_user = 'root';
$db_pass = ''; //database

mysql_connect($db_host, $db_user, $db_pass) or die(mysql_fatal_error());
mysql_select_db($db_name) or die(mysql_fatal_error());



/* sanitizeString is a function that is intended to sanitize input gathered 
 * from forms in order to prevent mysql injection and cross site scripting
 * $str_input is the string retrieved from a form*/
function sanitizeString($str_input) {
	$str_input = strip_tags($str_input);
	$str_input = htmlentities($str_input);
	$str_input = stripslashes($str_input);	
	return mysql_real_escape_string($str_input);
}


/* mysql_fatal_error is a function that is intended to provide a customizable
 * error message for any database communication error
 * $str_msg is the customizable section to be displayed before the mysql error
 *  code*/
function mysql_fatal_error() {
	$str_msg2 = mysql_error();
	echo <<< _END
	We are sorry, but it is not possible to complete the requested task. The 
	error we received was:
	<p>$str_msg2</p>
	Please click the back button on your browser and try again. If you are 
	still having problems, please <a href="mailto:!!!!!"> email the 
	administrator</a>. Thank you.
_END;
}


/*  queryMysql is a function that is intended to provide the query submission to
 *  the database with an error message if required.
*  $str_query is the query to be submitted
*  There must already be a present connection to the database*/
function queryMysql($str_query) {
	sanitizeString($str_query);
	$result = mysql_query($str_query) or die(mysql_error());
	return $result;
}


function get_post($str_var) {
	return mysql_real_escape_string($_POST[$str_var]);
}

?>