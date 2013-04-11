<?php
	include './../layout/pageClass.php';
	
	$sample = new Page("Finance", array("Invoice.css"), array(""));
	
	$sample->display(1, 0);
?>