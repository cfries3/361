<?php
	include './../layout/pageClass.php';
	
	$sample = new Page("Announcements", array("list.css"), array(""));
	
	$sample->display(1, 0);
?>