<?php
	include './../layout/pageClass.php';
	
	$sample = new Page("Accounts", array("Invoice.css"), array(""));
	
	$sample->display(1, 0);
?>