<?php
	include './../layout/pageClass.php';
	
	$sample = new Page("Finance", array("Invoice.css", "datepicker.css"), array("datepicker.js"));
	
	$sample->display(2, 1);
?>