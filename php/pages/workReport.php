<?php
	include './../layout/pageClass.php';
	
	$sample = new Page("Work Report", array("formBased.css", "datepicker.css"), array("datepicker.js", "tinyscrollbar.js"));
	
	$sample->display(2, 2);
?>