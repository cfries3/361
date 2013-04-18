<?php
require_once './databaseFunctionsOO.php';

if(isset($_POST['new_p'])){
	new_project();
}elseif (isset($_POST['new_p_sub'])){
	new_project_sub();
}elseif(isset($_POST['new_t'])){
	new_task();
}elseif (isset($_POST['new_t_sub'])){
	new_task_sub();
}elseif (isset($_POST['delete_p'])){
	delete_project();
}elseif (isset($_POST['delete_p_conf'])){
	delete_project_conf();
}elseif (isset($_POST['delete_t'])){
	delete_task();
}elseif (isset($_POST['delete_t_conf'])){
	delete_task_conf();
}elseif (isset($_POST['proj'])){
	display_task();
}elseif (isset($_POST['edit_p'])){
	edit_project();
}elseif (isset($_POST['edit_p_choice'])){
	edit_project_choice();
}elseif (isset($_POST['edit_p_sub'])){
	edit_project_sub();
}elseif (isset($_POST['edit_t'])){
	edit_task();
}elseif (isset($_POST['edit_t_choice'])){
	edit_task_choice();
}elseif (isset($_POST['edit_t_choice2'])){
	edit_task_choice2();
}elseif (isset($_POST['edit_t_sub'])){
	edit_task_sub();
}


function new_project(){
	$db = connect_db();
	
	$query = "SELECT employee.fname, employee.lname, employee.uid
				FROM employee
				INNER JOIN user ON user.uid = employee.uid
				WHERE user.type =  'admin'";
	
	$result = $db->query($query);
	
	printf('<table>
			<tr>
				<td>TITLE</td>
				<td><input type="text" maxlength="30" name="title"></input></td>
			</tr>
			<tr>
				<td>DESCRIPTION</td>
				<td><textarea maxlength="1000" rows="10" cols="50" style="resize: none" name="description" ></textarea></td>
			</tr>
			<tr>
				<td>CONTACT PERSON</td>
				<td><select name="contact">');
	while ($row = $result->fetch_array(MYSQLI_ASSOC)){
		printf("<option value='%s'>%s %s</option>", $row['uid'], $row['fname'], $row['lname']);
	}
	printf('</select></td></tr></table>
			<input type="hidden" name="status" value="0"></input>
			<button onclick="new_proj_sub()"> submit </button>');
	
}

function new_project_sub(){
	$db = connect_db();
	
	$title = $db->real_escape_string($_POST['title']);
	$description = $db->real_escape_string( $_POST['description']);
	$contact = $db->real_escape_string( $_POST['contact']);
	$status = $db->real_escape_string($_POST['status']);
	
	$query = "INSERT INTO  project (title, description, status, contact) VALUES ('$title', '$description', $status, '$contact')";
	
	if($db->query($query)){
		printf("success");
	}
	else{
		printf("error");
	}
}

function delete_project(){
	
	$db = connect_db();
	
	$query_p = "SELECT pid, title From project ORDER BY title";
	
	$result_p = $db->query($query_p);
	
	if($result_p->num_rows < 1){
		printf("<div style='text-align:center'>Sorry there is currently no project to display");
		die();
	}
	printf("<div style='text-align:center'>Which project do you wish to delete <select name='pid'>");
	while ($row_p = $result_p->fetch_array(MYSQLI_ASSOC)){
		printf("<option value='%s'> %s </option>", $row_p['pid'], $row_p['title']);
	}
	printf("</select><br><button onclick='delete_proj_conf()'>Submit</button></div>");
	
}

function delete_project_conf(){
	$db = connect_db();
	
	$pid = $db->real_escape_string($_POST['delete_p_conf']);
	
	$query = "DELETE FROM project WHERE pid='$pid'";
	
	
	if($db->query($query)){
		printf("success");
	}
	else{
		printf("error");
	}
}

function new_task(){
	printf('<table>
			<tr>
				<td>TITLE</td>
				<td><input type="text" maxlength="30" name="title"></input></td>
			</tr>
			<tr>
				<td>DESCRIPTION</td>
				<td><textarea maxlength="1000" rows="10" cols="50" style="resize: none" name="description" ></textarea></td>
			</tr>
			<tr>
				<td>HOURLY RATE</td>
				<td><input type="number" step="0.01" name="hrate"></input></td>
			</tr>
			<tr>
				<td> ASSOCIATED PROJECT</td>');
	
	$db = connect_db();
	
	$query_p = "SELECT pid, title From project ORDER BY title";
	
	$result_p = $db->query($query_p);
	printf("<td><select name='pid'>");
	while ($row_p = $result_p->fetch_array(MYSQLI_ASSOC)){
			printf("<option value='%s'> %s </option>", $row_p['pid'], $row_p['title']);
	}
	printf("</select></td></tr>");
	
			printf('</table>
			<input type="hidden" name="status" value="0"></input>
			<button onclick="new_task_sub()"> submit </button>');

}

function new_task_sub(){
	$db = connect_db();

	$title = $db->real_escape_string($_POST['title']);
	$description = $db->real_escape_string($_POST['description']);
	$status = $db->real_escape_string($db->real_escape_string($_POST['status']));
	$hrate =  $db->real_escape_string($_POST['hrate']);
	$pid =  $db->real_escape_string($_POST['pid']);

	$query = "INSERT INTO  task (title, description, status, hrate, pid) VALUES ('$title', '$description', $status, $hrate, '$pid')";

	
	if($db->query($query)){
		printf("success");
	}
	else{
		printf("error");
	}
}

function delete_task(){
	
	$db = connect_db();
	
	$query_p = "SELECT pid, title From project ORDER BY title";
	
	$result_p = $db->query($query_p);
	printf("<div style='text-align:center'>Select a project <select onchange='displayTask()' name='pid'><br>");
	while ($row_p = $result_p->fetch_array(MYSQLI_ASSOC)){
		printf("<option value='%s'> %s </option>", $row_p['pid'], $row_p['title']);
	}
	printf("</select><br><button onclick='displayTask()'>Submit</button><br></div>");
	
}

function delete_task_conf(){
	$db = connect_db();
	
	$tid = $db->real_escape_string($_POST['delete_t_conf']);
	$query = "DELETE FROM task WHERE tid='$tid'";
	
	
	if($db->query($query)){
		printf("success");
	}
	else{
		printf("error");
	}
}

function display_task(){
	
	$proj = $_POST['proj'];
	
	$db = connect_db();
	
	$query_p = "SELECT tid, title From task WHERE pid='$proj' ORDER BY title";
	
	$result_p = $db->query($query_p);
	if($result_p->num_rows < 1){
		printf("<div style='text-align:center'>Sorry there is currently no task associated to this project");
		die();
	}
	printf("<div style='text-align:center'>What task do you wish to delete <select name='tid'><br>");
	while ($row_p = $result_p->fetch_array(MYSQLI_ASSOC)){
		printf("<option value='%s'> %s </option>", $row_p['tid'], $row_p['title']);
	}
	printf("</select><br><button onclick='delete_task_conf()'>Submit</button></div>");
	
}

function edit_project(){
	
	$db = connect_db();
	
	$query_p = "SELECT pid, title From project ORDER BY title";
	
	$result_p = $db->query($query_p);
	if($result_p->num_rows < 1){
		printf("<div style='text-align:center'>Sorry there is currently no project to display");
		die();
	}
	printf("<div style='text-align:center'>Select a project to edit <select name='pid'>");
	while ($row_p = $result_p->fetch_array(MYSQLI_ASSOC)){
		printf("<option value='%s'> %s </option>", $row_p['pid'], $row_p['title']);
	}
	printf("</select><br><button onclick='edit_proj_choice()'>Submit</button></div>");
	
}

function edit_project_choice(){
	
	$db = connect_db();
	
	$pid = $db->real_escape_string($_POST['edit_p_choice']);
	
	$query_p = "SELECT * From project WHERE pid='$pid'";
	
	$result_p = $db->query($query_p);
	
	$row_p = $result_p->fetch_array(MYSQLI_ASSOC);
	
	$query = "SELECT employee.fname, employee.lname, employee.uid
				FROM employee
				INNER JOIN user ON user.uid = employee.uid
				WHERE user.type =  'admin'";
	
	$result = $db->query($query);
	
	printf('<table>
	<tr>
		<td>TITLE</td>
		<td><input type="text" maxlength="30" name="title" value="%s"></input></td>
	</tr>
	<tr>
		<td>DESCRITION</td>
		<td><textarea maxlength="1000" rows="10" cols="50" style="resize: none" name="description" >%s</textarea></td>
	</tr>
	<tr>
		<td>CONTACT PERSON</td>
		<td><select name="contact">', $row_p['title'], $row_p['description']);
	while ($row = $result->fetch_array(MYSQLI_ASSOC)){
		if ($row_p['contact'] == $row['uid']){
			printf("<option value='%s' selected>%s %s</option>", $row['uid'], $row['fname'], $row['lname']);
		}else{
			printf("<option value='%s'>%s %s</option>", $row['uid'], $row['fname'], $row['lname']);
		}
	}
	printf('</selec></td></tr></table>
		<button onclick="edit_proj_sub(%d)"> submit </button>', $pid);
}

function edit_project_sub(){
	
	$db = connect_db();
	
	$title = $db->real_escape_string($_POST['title']);
	$Desc = $db->real_escape_string($_POST['description']);
	$pid = $db->real_escape_string($_POST['pid']);
	$contact = $db->real_escape_string($_POST['contact']);

	$query = "UPDATE project SET title = '$title', description = '$Desc', contact = '$contact' WHERE pid='$pid'";

	
	if($db->query($query)){
		printf("success");
	}
	else{
		printf("error");
	}
	
}

function edit_task(){

	$db = connect_db();

	$query_p = "SELECT pid, title From project ORDER BY title";

	$result_p = $db->query($query_p);
	if($result_p->num_rows < 1){
		printf("<div style='text-align:center'>Sorry there is currently no project to dislay");
		die();
	}
	printf("<div style='text-align:center'>Select the project related to the task to edit <select name='pid'>");
	while ($row_p = $result_p->fetch_array(MYSQLI_ASSOC)){
		printf("<option value='%s'> %s </option>", $row_p['pid'], $row_p['title']);
	}
	printf("</select><br><button onclick='edit_task_choice()'>Submit</button></div>");

}

function edit_task_choice(){
	
	$db = connect_db();
	
	$proj = $db->real_escape_string($_POST['edit_t_choice']);
	
	$query_p = "SELECT tid, title From task WHERE pid='$proj' ORDER BY title";
	
	$result_p = $db->query($query_p);
	
	if($result_p->num_rows < 1){
		printf("<div style='text-align:center'>Sorry there is currently no task associated to this project");
		die();
	}
	
	printf("<div style='text-align:center'>What task do you wish to edit <select name='tid'><br>");
	while ($row_p = $result_p->fetch_array(MYSQLI_ASSOC)){
		printf("<option value='%s'> %s </option>", $row_p['tid'], $row_p['title']);
	}
	printf("</select><br><button onclick='edit_task_choice2()'>Submit</button></div>");
}

function edit_task_choice2(){

	$db = connect_db();

	$tid = $db->real_escape_string($_POST['edit_t_choice2']);

	$query = "SELECT * From task WHERE tid='$tid'";

	$result = $db->query($query);

	$row = $result->fetch_array(MYSQLI_ASSOC);

	printf('<table>
			<tr>
				<td>TITLE</td>
				<td><input type="text" maxlength="30" name="title" value="%s"></input></td>
			</tr>
			<tr>
				<td>DESCRIPTION</td>
				<td><textarea maxlength="1000" rows="10" cols="50" style="resize: none" name="description" >%s</textarea></td>
			</tr>
			<tr>
				<td>HOURLY RATE</td>
				<td><input type="number" step="0.01" name="hrate" value="%.2f"></input></td>
			</tr>
			<tr>
				<td>ASSOCIATED PROJECT</td>', $row['title'], $row['description'], $row['hrate']);
	
	$db = connect_db();
	
	$query_p = "SELECT pid, title From project ORDER BY title";
	
	$result_p = $db->query($query_p);
	printf("<td><select name='pid'>");
	while ($row_p = $result_p->fetch_array(MYSQLI_ASSOC)){
		if($row_p['pid'] == $row['pid']){
			printf("<option value='%s' selected> %s </option>", $row_p['pid'], $row_p['title']);
		}else{
			printf("<option value='%s'> %s </option>", $row_p['pid'], $row_p['title']);
		}
	}
	printf("</select></td></tr>");
	
			printf('</table>
			<button onclick="edit_task_sub(%s)"> submit </button>', $row['tid']);
}

function edit_task_sub(){

	$db = connect_db();

	$title = $db->real_escape_string($_POST['title']);
	$description = $db->real_escape_string($_POST['description']);
	$tid = $db->real_escape_string($_POST['tid']);
	$hrate =  $db->real_escape_string($_POST['hrate']);
	$pid =  $db->real_escape_string($_POST['pid']);

	$query = "UPDATE task SET title = '$title', description = '$description', hrate=$hrate, pid='$pid' WHERE tid='$tid'";

	
	if($db->query($query)){
		printf("success");
	}
	else{
		printf("error");
	}

}






?>