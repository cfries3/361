<?php
	include './../layout/pageClass.php';
	
	$sample = new Page("Create Post", array("formBased.css"), array(""));
	
	$sample->display(1, 0);
?>