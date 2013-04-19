<?php
	include './../layout/pageClass.php';

	$sample = new Page("Punch management", array("NavBar.css", "datepicker.css", "jquery.timepicker.css"), array("datepicker.js", "jquery-timepicker-master/jquery.timepicker.js"));

	$sample->display(3, 2);
?>