<?php
	include './../layout/pageClass.php';
	
	$sample = new Page("Work Report", array("formBased.css", "http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css"), array("datepicker.js", "http://code.jquery.com/ui/1.10.2/jquery-ui.js", "http://code.jquery.com/jquery-1.9.1.js"));
	
	$sample->display(2, 3);
?>