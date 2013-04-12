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
	printf('<table>
			<tr>
				<td>title</td>
				<td><input type="text" maxlength="30" name="title"></input></td>
			</tr>
			<tr>
				<td>description</td>
				<td><textarea maxlength="1000" rows="10" cols="50" style="resize: none" name="description" ></textarea></td>
			</tr>
			</table>
			<input type="hidden" name="status" value="0"></input>
			<button onclick="new_proj_sub()"> submit </button>');
	
}

function new_project_sub(){
	$db = connect_db();
	
	$title = $_POST['title'];
	$description = $_POST['description'];
	$status = $_POST['status'];
	
	$query = "INSERT INTO  project (title, description, status) VALUES ('$title', '$description', $status)";
	
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
	printf("Which project do you wish to delete <select name='pid'>");
	while ($row_p = $result_p->fetch_array(MYSQLI_ASSOC)){
		printf("<option value='%s'> %s </option>", $row_p['pid'], $row_p['title']);
	}
	printf("</select><button onclick='delete_proj_conf()'>Submit</button>");
	
}

function delete_project_conf(){
	$db = connect_db();
	
	$pid = $_POST['delete_p_conf'];
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
				<td>title</td>
				<td><input type="text" maxlength="30" name="title"></input></td>
			</tr>
			<tr>
				<td>description</td>
				<td><textarea maxlength="1000" rows="10" cols="50" style="resize: none" name="description" ></textarea></td>
			</tr>
			<tr>
				<td>hourly rate</td>
				<td><input type="number" step="0.01" name="hrate"></input></td>
			</tr>
			<tr>
				<td> associated project</td>');
	
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

	$title = $_POST['title'];
	$description = $_POST['description'];
	$status = $_POST['status'];
	$hrate =  $_POST['hrate'];
	$pid =  $_POST['pid'];

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
	printf("Select a project <select onchange='displayTask()' name='pid'><br>");
	while ($row_p = $result_p->fetch_array(MYSQLI_ASSOC)){
		printf("<option value='%s'> %s </option>", $row_p['pid'], $row_p['title']);
	}
	printf("</select><button onclick='displayTask()'>Submit</button><br>");
	
}

function delete_task_conf(){
	$db = connect_db();
	
	$tid = $_POST['delete_t_conf'];
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
	printf("What task do you wish to delete <select name='tid'><br>");
	while ($row_p = $result_p->fetch_array(MYSQLI_ASSOC)){
		printf("<option value='%s'> %s </option>", $row_p['tid'], $row_p['title']);
	}
	printf("</select><br><button onclick='delete_task_conf()'>Submit</button>");
	
}

function edit_project(){
	
	$db = connect_db();
	
	$query_p = "SELECT pid, title From project ORDER BY title";
	
	$result_p = $db->query($query_p);
	printf("Select a project to edit <select name='pid'>");
	while ($row_p = $result_p->fetch_array(MYSQLI_ASSOC)){
		printf("<option value='%s'> %s </option>", $row_p['pid'], $row_p['title']);
	}
	printf("</select><button onclick='edit_proj_choice()'>Submit</button>");
	
}

function edit_project_choice(){
	
	$pid = $_POST['edit_p_choice'];
	
	$db = connect_db();
	
	$query_p = "SELECT * From project WHERE pid='$pid'";
	
	$result_p = $db->query($query_p);
	
	$row_p = $result_p->fetch_array(MYSQLI_ASSOC);
	
	printf('<table>
	<tr>
	<td>title</td>
	<td><input type="text" maxlength="30" name="title" value="%s"></input></td>
	</tr>
	<tr>
	<td>description</td>
	<td><textarea maxlength="1000" rows="10" cols="50" style="resize: none" name="description" >%s</textarea></td>
	</tr>
	</table>
	<button onclick="edit_proj_sub(%d)"> submit </button>', $row_p['title'], $row_p['description'], $pid);
}

function edit_project_sub(){
	
	$db = connect_db();
	
	$title = $_POST['title'];
	$Desc = $_POST['description'];
	$pid = $_POST['pid'];

	$query = "UPDATE project SET title = '$title', description = '$Desc' WHERE pid='$pid'";

	
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
	printf("Select the project related to the task to edit <select name='pid'>");
	while ($row_p = $result_p->fetch_array(MYSQLI_ASSOC)){
		printf("<option value='%s'> %s </option>", $row_p['pid'], $row_p['title']);
	}
	printf("</select><button onclick='edit_task_choice()'>Submit</button>");

}

function edit_task_choice(){
	$proj = $_POST['edit_t_choice'];
	
	$db = connect_db();
	
	$query_p = "SELECT tid, title From task WHERE pid='$proj' ORDER BY title";
	
	$result_p = $db->query($query_p);
	printf("What task do you wish to edit <select name='tid'><br>");
	while ($row_p = $result_p->fetch_array(MYSQLI_ASSOC)){
		printf("<option value='%s'> %s </option>", $row_p['tid'], $row_p['title']);
	}
	printf("</select><br><button onclick='edit_task_choice2()'>Submit</button>");
}

function edit_task_choice2(){

	$tid = $_POST['edit_t_choice2'];

	$db = connect_db();

	$query = "SELECT * From task WHERE tid='$tid'";

	$result = $db->query($query);

	$row = $result->fetch_array(MYSQLI_ASSOC);

	printf('<table>
			<tr>
				<td>title</td>
				<td><input type="text" maxlength="30" name="title" value="%s"></input></td>
			</tr>
			<tr>
				<td>description</td>
				<td><textarea maxlength="1000" rows="10" cols="50" style="resize: none" name="description" >%s</textarea></td>
			</tr>
			<tr>
				<td>hourly rate</td>
				<td><input type="number" step="0.01" name="hrate" value="%d"></input></td>
			</tr>
			<tr>
				<td> associated project</td>', $row['title'], $row['description'], $row['hrate']);
	
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

	$title = $_POST['title'];
	$description = $_POST['description'];
	$tid = $_POST['tid'];
	$hrate =  $_POST['hrate'];
	$pid =  $_POST['pid'];

	$query = "UPDATE task SET title = '$title', description = '$description', hrate=$hrate, pid='$pid' WHERE tid='$tid'";

	printf("%s", $query);
	
	if($db->query($query)){
		printf("success");
	}
	else{
		printf("error");
	}

}






?>