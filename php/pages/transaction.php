<?php
	include './../layout/pageClass.php';

	$sample = new Page("Transactions", array("Invoice.css"), array(""));

	$sample->display(1, 0);
?>