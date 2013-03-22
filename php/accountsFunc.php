<?php
require_once './databaseFunctionsOO.php';

if(isset($_POST['delete'])){
	delete_account();
}elseif (isset($_POST['edit'])){
	display_form();
}elseif (isset($_POST['edit_val'])){
	update_db();
}elseif (isset($_POST['display'])){
	display_empty_form();
}elseif (isset($_POST['new_val'])){
	create_new();
}



function delete_account(){
	$db = connect_db();
	
	$aid = $_POST['aid'];
	$query = "DELETE FROM account WHERE aid='$aid'";
	
	
	if($db->query($query)){
		printf("success");
	}
	else{
		printf("error");
	}
}

function display_form(){
	$aid = $_POST['edit'];
	
	$db = connect_db();
	
	$query = "SELECT * From account WHERE aid='$aid'";
	
	$result = $db->query($query);
	if($result->num_rows < 1)
	{
		printf("error accessing data");
		die();
	}
	$accData = $result->fetch_array(MYSQLI_ASSOC);
	
	$name = $accData['name'];
	$designation = $accData['designation'];
	
	
	printf('
	Name <input type="text" maxlength="30" name="name" value="%s"></input><br>
	<input type="radio" name="designation" value="income"  >income
	<input type="radio" name="designation" value="expense" checked="checked">expense<br>
	<input type="hidden" name="aid" value="%s">
	<button onclick="edit_submit(%s)"> validate </button> <button onclick="cancel_edit()"> cancel </button>', $name, $aid, $aid);
}

function update_db(){
	$name = $_POST['name'];
	$design = $_POST['designation'];
	$aid = $_POST['aid'];
	
	$db = connect_db();
	
	$query = "UPDATE account SET name = '$name', designation = '$design' WHERE aid='$aid'";
	
	if($db->query($query)){
		printf("success");
	}
	else{
		printf("error");
	}
}

function display_empty_form(){
	printf('
	Name <input type="text" maxlength="30" name="name" ></input><br>
	<input type="radio" name="designation" value="income"  >income
	<input type="radio" name="designation" value="expense"">expense<br>
	<button onclick="new_submit()"> validate </button> <button onclick="location.reload()"> cancel </button>');
}

function create_new(){
	$name = $_POST['name'];
	$design = $_POST['designation'];
	
	$db = connect_db();
	
	$query = "INSERT account (name, designation) VALUES ('$name', '$design');";
	
	if($db->query($query)){
		printf("success");
	}
	else{
		printf("error");
	}
	
}

?>