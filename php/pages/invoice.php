<?php
	include './../layout/pageClass.php';
	
	$sample = new Page("Invoice", "Invoice.css", array("NestedList.js"));
	
	$sample->display(0);
?>