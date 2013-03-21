<?php
	include './../layout/pageClass.php';
	
	$sample = new Page("Discussion", "nestedList.css", array("NestedList.js"));
	
	$sample->display(1);
?>