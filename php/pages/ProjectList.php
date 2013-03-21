<?php
	include './../layout/pageClass.php';
	
	$sample = new Page("Project List", "nestedList.css", array("NestedList.js"));
	
	$sample->display(1);
?>