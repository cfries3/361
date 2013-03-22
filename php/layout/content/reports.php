<?php
	include './../layout/formClass.php';
	
	echo "<div id=\"content\" class=\"floatLeft\">";
	$obj_form = new Form("reports.php");
	
	$obj_form->populateList("project");
	$obj_form->populateList("task"); //NEED TO DO A CALL FOR ONLY TASKS ASSOCIATED WITH THE PROJECT
	$obj_form->dateRange();
	$obj_form->closeFormat();
	echo "</div>";

?>