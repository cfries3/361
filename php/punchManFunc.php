<?php
require_once './databaseFunctionsOO.php';

if(isset($_POST['new_p'])){
	new_punch();
}elseif (isset($_POST['new_p_conf'])){
	new_punch_conf();
}elseif (isset($_POST['del_p'])){
	del_punch();
}elseif (isset($_POST['del_p_conf'])){
	del_punch_conf();
}elseif (isset($_POST['del_p_sub'])){
	del_punch_sub();
}elseif (isset($_POST['edit_p'])){
	edit_punch();
}elseif (isset($_POST['edit_p_conf'])){
	edit_punch_conf();
}elseif (isset($_POST['edit_p_conf2'])){
	edit_punch_conf2();
}elseif (isset($_POST['edit_p_sub'])){
	edit_punch_sub();
}

function new_punch(){
	$db = connect_db();
	
	$query = "SELECT * FROM employee ORDER BY fname";
	
	$result = $db->query($query);
	
	printf('<table>
				<tr>
					<td>EMPLOYEE</td>
					<td><select name="uid">');
	
	while ($row = $result->fetch_array(MYSQLI_ASSOC)){
		printf("<option value='%s'>%s %s</option>", $row['uid'], $row['fname'], $row['lname']);
	}
	printf('
					</select></td>
				</tr>
				<tr>
					<td>TASK</td>
					<td><select name="tid">
					');
	
	$query = "SELECT tid, title FROM task ORDER BY title";
	
	$result = $db->query($query);

	while ($row = $result->fetch_array(MYSQLI_ASSOC)){
		printf("<option value='%s'>%s</option>", $row['tid'], $row['title']);
	}
	printf('
					</select></td>
				</tr>
				<tr>
					<td>TIME IN</td>
					<td><input type="text" maxlength="30" name="time_ind" ></input> <input type="text" maxlength="30" name="time_inh" ></input></td>
				</tr>
				<tr>
					<td>TIME OUT</td>
					<td><input type="text" maxlength="30" name="time_outd" > <input type="text" maxlength="30" name="time_outh" ></input></td>
				</tr>
				<tr>
					<td><button onclick="validate_new_p()"> validate </button></td>
				</tr>
			</table>
					');
	
}

function new_punch_conf(){
	$db = connect_db();
	
	$time_ind = $db->real_escape_string($_POST['time_ind']);
	$time_outd = $db->real_escape_string( $_POST['time_outd']);
	$time_inh = $db->real_escape_string($_POST['time_inh']);
	$time_outh = $db->real_escape_string( $_POST['time_outh']);
	$uid = $db->real_escape_string( $_POST['uid']);
	$tid = $db->real_escape_string( $_POST['tid']);
	
	$time_in = $time_ind . " " . $time_inh;
	$time_out = $time_outd . " " . $time_outh;
	
	$query = "INSERT INTO  punch (time_in, time_out, tid, uid, status_flag) VALUES ('$time_in', '$time_out', '$tid', '$uid', '1')";
	
	
	if($db->query($query)){
		printf("success");
	}
	else{
		printf("error");
	}
}

function del_punch(){
	
	printf('<table>
				<tr>
					<td>DATE RANGE</td>
					<td> FROM <input type="text" maxlength="30" name="time_in" ></input> TO <input type="text" maxlength="30" name="time_out" ></input></td>
				</tr>
				<tr>
					<td>EMPLOYEE</td>
					<td><select name="uid">');
	
	$db = connect_db();
	
	$query = "SELECT * FROM employee ORDER BY fname";
	
	$result = $db->query($query);
	
	while ($row = $result->fetch_array(MYSQLI_ASSOC)){
		printf("<option value='%s'>%s %s</option>", $row['uid'], $row['fname'], $row['lname']);
	}
	printf('
					</select></td>
				</tr>
				<tr>
					<td>TASK</td>
					<td><select name="tid">
					');
	
	$query = "SELECT tid, title FROM task ORDER BY title";
	
	$result = $db->query($query);

	while ($row = $result->fetch_array(MYSQLI_ASSOC)){
		printf("<option value='%s'>%s</option>", $row['tid'], $row['title']);
	}
	printf('
					</select></td>
				</tr>
				<tr>
					<td><button onclick="validate_del_p()"> validate </button></td>
				</tr>
			</table>
					');
	
}

function del_punch_conf(){
	
	$db = connect_db();
	
	$time_in = $db->real_escape_string($_POST['time_in']);
	$time_out = $db->real_escape_string( $_POST['time_out']);
	$uid = $db->real_escape_string( $_POST['uid']);
	$tid = $db->real_escape_string( $_POST['tid']);
	
	$query = "	SELECT * 
				FROM  `punch` 
				WHERE (
					time_in >= STR_TO_DATE(  '$time_in',  '%Y-%m-%d' )
				)
				AND (
					time_out <= STR_TO_DATE(  '$time_out',  '%Y-%m-%d' )
				)
				AND (
					uid = $uid
				)
				AND (
					tid = $tid
				)";
	
	$result = $db->query($query);
	
	if($result->num_rows < 1){
		
		printf("Sorry no result found");
		die();
	}
	
	printf('
			<table>
				<tr>
					<th></th>
					<th> time in </th>
					<th> time out </th>
				</tr>');
	
	while ($row = $result->fetch_array(MYSQLI_ASSOC)){
		printf('
				<tr>
					<td><input type="radio" name="punch_id" value="%s"></td>
					<td> %s </td>
					<td> %s </td>
				</tr>
				
				', $row['punch_id'], $row['time_in'], $row['time_out']);
	}
	
	printf('	<tr>
				<td><button onclick="conf_del_p()"> Delete </button></td>
				</tr>
			</table>');
	
}

function del_punch_sub(){
	$db = connect_db();
	
	$punch_id = $db->real_escape_string($_POST['punch_id']);
	
	$query = "DELETE FROM punch WHERE punch_id='$punch_id'";
		
	if($db->query($query)){
		printf("success");
	}
	else{
		printf("error");
	}
}


function edit_punch(){
	
	printf('<table>
				<tr>
					<td>DATE RANGE</td>
					<td> FROM <input type="text" maxlength="30" name="time_in" ></input> TO <input type="text" maxlength="30" name="time_out" ></input></td>
				</tr>
				<tr>
					<td>EMPLOYEE</td>
					<td><select name="uid">');
	
	$db = connect_db();
	
	$query = "SELECT * FROM employee ORDER BY fname";
	
	$result = $db->query($query);
	
	while ($row = $result->fetch_array(MYSQLI_ASSOC)){
		printf("<option value='%s'>%s %s</option>", $row['uid'], $row['fname'], $row['lname']);
	}
	printf('
					</select></td>
				</tr>
				<tr>
					<td>TASK</td>
					<td><select name="tid">
					');
	
	$query = "SELECT tid, title FROM task ORDER BY title";
	
	$result = $db->query($query);
	
	while ($row = $result->fetch_array(MYSQLI_ASSOC)){
		printf("<option value='%s'>%s</option>", $row['tid'], $row['title']);
	}
	printf('
					</select></td>
				</tr>
				<tr>
					<td><button onclick="validate_edit_p()"> validate </button></td>
				</tr>
			</table>
					');
	
}


function edit_punch_conf(){
	$db = connect_db();
	
	$time_in = $db->real_escape_string($_POST['time_in']);
	$time_out = $db->real_escape_string( $_POST['time_out']);
	$uid = $db->real_escape_string( $_POST['uid']);
	$tid = $db->real_escape_string( $_POST['tid']);
	
	$query = "	SELECT *
	FROM  `punch`
	WHERE (
	time_in >= STR_TO_DATE(  '$time_in',  '%Y-%m-%d' )
	)
	AND (
	time_out <= STR_TO_DATE(  '$time_out',  '%Y-%m-%d' )
	)
	AND (
			uid = $uid
	)
			AND (
			tid = $tid
	)";
	
			$result = $db->query($query);
	
			if($result->num_rows < 1){
	
			printf("Sorry no result found");
			die();
	}
	
		printf('
		<table>
				<tr>
				<th></th>
				<th> time in </th>
					<th> time out </th>
				</tr>');
	
	while ($row = $result->fetch_array(MYSQLI_ASSOC)){
						printf('
								<tr>
								<td><input type="radio" name="punch_id" value="%s"></td>
					<td> %s </td>
					<td> %s </td>
				</tr>
	
				', $row['punch_id'], $row['time_in'], $row['time_out']);
						}
	
	printf('	<tr>
		<td><button onclick="conf_edit_p()"> Edit </button></td>
				</tr>
			</table>');
}

function edit_punch_conf2(){
	
	$db = connect_db();
	
	$punch_id = $db->real_escape_string($_POST['punch_id']);
	
	$query = "SELECT * FROM punch WHERE punch_id='$punch_id'";
	
	$result = $db->query($query);
	
	$row = $result->fetch_array(MYSQLI_ASSOC);
	
	printf('<table>
				<tr>
					<td>TIME IN</td>
					<td><input type="text" maxlength="30" name="time_in" value="%s"></input></td>
				</tr>
				<tr>
					<td>TIME OUT</td>
					<td><input type="text" maxlength="30" name="time_out" value="%s"></input></td>
				</tr>
				<tr>
					<td>TASK</td>
					<td><select name="tid">
			', $row['time_in'], $row['time_out']);
	
	$query = "SELECT tid, title FROM task ORDER BY title";
	
	$result = $db->query($query);
	
	while ($row = $result->fetch_array(MYSQLI_ASSOC)){
		printf("<option value='%s'>%s</option>", $row['tid'], $row['title']);
	}
	
	printf('
					</select></td>
				</tr>
				<tr>
					<td><button onclick="conf2_edit_p(%s)"> validate </button></td>
				</tr>
			</table>
					', $punch_id);
	
}

function edit_punch_sub(){
	
	$db = connect_db();
	
	$time_in = $db->real_escape_string($_POST['time_in']);
	$time_out = $db->real_escape_string( $_POST['time_out']);
	$tid = $db->real_escape_string( $_POST['tid']);
	$punch_id = $db->real_escape_string( $_POST['punch_id']);
	
	$query = "UPDATE punch SET time_in = '$time_in', time_out = '$time_out', tid = '$tid', status_flag = 1 WHERE punch_id = '$punch_id'";
	
	if($db->query($query)){
		printf("success");
	}
	else{
		printf("error");
	}
}



