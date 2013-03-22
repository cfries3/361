<?php
	include './../layout/pageClass.php';
	
	$sample = new Page("Invoice", array("Invoice.css"), array(""));
	
	$sample->display(1, 0);
?>