<?php
	include './../layout/pageClass.php';
	
	$sample = new Page("Project List", array("nestedList.css"), array("NestedList.js"));
	
	$sample->display(1, 1);
?>