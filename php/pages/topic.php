<?php
	include './../layout/pageClass.php';
	
	$sample = new Page("Discussion", array("nestedList.css"), array("http://code.jquery.com/jquery-1.9.1.js", "http://code.jquery.com/ui/1.10.2/jquery-ui.js", "accordion.js"));
	
	$sample->display(1, 3);
?>