<?php
	include './../layout/pageClass.php';
	
	$sample = new Page("Discussion Board", array("plainList.css"), array(""));
	
	$sample->display(1, 0);
?>