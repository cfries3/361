<?php
require_once './databaseFunctionsOO.php';


if(isset($_POST['new_u'])){
	new_user();
}elseif (isset($_POST['new_u_type'])){
	new_user_type();
}elseif (isset($_POST['new_u_conf'])){
	new_user_conf();
}elseif (isset($_POST['del_u'])){
	delete_user();
}elseif (isset($_POST['del_conf'])){
	delete_user_conf();
}elseif (isset($_POST['edit_u'])){
	edit_user();
}elseif (isset($_POST['edit_conf'])){
	edit_user_conf();
}elseif (isset($_POST['edit_u_sub'])){
	edit_user_sub();
}elseif (isset($_POST['change_pwd'])){
	change_pwd();
}elseif (isset($_POST['change_pwd_sub'])){
	change_pwd_sub();
}

function new_user(){
	
	printf('<div style="text-align:center;">Select a kind of user
											<select name="type">
												<option value="administrator">administrator</option>
												<option value="client">client</option>
												<option value="employee">employee</option>
												<option value="system administrator">system administrator</option>
											</select><br>
											<button onclick="new_user_type()">submit</button>
			</div>');
	
}

function new_user_type(){
	
	printf('<table>
	<input type="hidden" value="%s" name="type"></input>', $_POST['type']);
	if($_POST['type'] == "client"){
		printf('<tr>
					<td>COMPANY NAME</td>
					<td><input type="text" maxlength="30" name="cname" ></input></td>
				</tr>');
	}else{
		printf('<tr>
					<td>FIRST NAME</td>
					<td><input type="text" maxlength="30" name="fname" ></input></td>
				</tr>
				<tr>
					<td>LAST NAME</td>
					<td><input type="text" maxlength="30" name="lname" ></input></td>
				</tr>');
	}
	printf('
			<tr>
				<td>USERNAME</td>
				<td><input type="text" maxlength="30" name="username" ></input></td>
			</tr>
			<tr>
				<td>PASSWORD</td>
				<td><input type="password" maxlength="30" name="password" ></input></td>
			</tr>
			<tr>
				<td>PASSWORD VALIDATION</td>
				<td><input type="password" maxlength="30" name="password2" ></input></td>
			</tr>
			<tr>
				<td>PHONE</td>
				<td><input type="text" maxlength="12" name="phone" ></input></td>
			</tr>
			<tr>
				<td>E_MAIL</td>
				<td><input type="text" maxlength="30" name="email" ></input></td>
			</tr>
			<tr>
				<td><button onclick="new_user_sub()">submit</button></td>
			</tr>
		</table>');
	
}

function new_user_conf(){
	
	$db = connect_db();
	
	$type = $db->real_escape_string($_POST['type']);
	$phone = $db->real_escape_string($_POST['phone']);
	$email = $db->real_escape_string($_POST['email']);
	$username = $db->real_escape_string($_POST['username']);
	$password = $db->real_escape_string($_POST['password']);
	
	if($type === "administrator"){
		$type = "admin";
	}else if($type === "system administrator"){
		$type = "sysadmin";
	}
	
	$password2 = hash("sha512", $password);
	
	$query = "INSERT INTO user (type, phone, email, username, password) VALUES ('$type', '$phone', '$email', '$username', '$password2')";
	
	
	if(!$db->query($query)){
		printf("There was an error or this username already exists");
		die();
	}
	
	$query = "SELECT uid FROM user WHERE username='$username' ";
	
	$result = $db->query($query);
	
	$row = $result->fetch_array(MYSQLI_ASSOC);
	
	$uid = $row['uid'];
	
	if($type === "client"){
		$cname = $db->real_escape_string($_POST['cname']);
		
		$query = "INSERT INTO client (uid, cname) VALUES ('$uid', '$cname')";
		
		if($db->query($query)){
			printf("success");
		}else{
			printf("error");
		}
		
	}else{
		$fname = $db->real_escape_string($_POST['fname']);
		$lname = $db->real_escape_string($_POST['lname']);
		
		$query = "INSERT INTO employee (uid, fname, lname) VALUES ('$uid', '$fname', '$lname')";
		
		if($db->query($query)){
			printf("success");
		}else{
			printf("error");
		}
	}
}

function delete_user(){
	
	printf("<div style='text-align:center;'>Which user do you wish to delete?
				<select name='uid'>");
	
	$db = connect_db();
	
	$query = "SELECT uid, username FROM user ORDER BY username";
	
	$result = $db->query($query);
	
	while ($row = $result->fetch_array(MYSQLI_ASSOC)){
		printf("<option value='%s'>%s</option>", $row['uid'], $row['username']);
	}
	
	printf('</select><br>
			<button onclick="del_conf()"> validate </button>');
	
}

function delete_user_conf(){
	
	$db = connect_db();
	
	$uid = $db->real_escape_string($_POST['uid']);
		
	$query = "DELETE FROM user WHERE uid='$uid'";
	
	if($db->query($query)){
		printf("success");
	}
	else{
		printf("error");
	}
	
	
}

function edit_user(){
	
	printf("<div style='text-align:center;'>Which user do you wish to edit?
				<select name='uid'>");
	
	$db = connect_db();
	
	$query = "SELECT uid, username FROM user ORDER BY username";
	
	$result = $db->query($query);
	
	while ($row = $result->fetch_array(MYSQLI_ASSOC)){
		printf("<option value='%s'>%s</option>", $row['uid'], $row['username']);
	}
	
	printf('</select><br>
			<button onclick="edit_conf()"> validate </button>');
	
	
}

function edit_user_conf(){
	
	$db = connect_db();
	
	$uid = $db->real_escape_string($_POST['uid']);
	
	$query = "SELECT * FROM user WHERE uid = '$uid'";
	
	$result = $db->query($query);
	
	$row = $result->fetch_array(MYSQLI_ASSOC);
	
	printf('<table>
	<input type="hidden" value="%s" name="type"></input>
	<input type="hidden" value="%s" name="uid"></input>', $row['type'], $uid);
	
	if($row['type'] == "client"){
	
		$query = "SELECT * FROM client WHERE uid = '$uid'";
		
		$result = $db->query($query);
		
		$row2 = $result->fetch_array(MYSQLI_ASSOC);
		
		printf('<tr>
					<td>COMPANY NAME</td>
					<td><input type="text" maxlength="30" name="cname" value="%s"></input></td>
				</tr>', $row2['cname']);
	}else{
		$query = "SELECT * FROM employee WHERE uid = '$uid'";
		
		$result = $db->query($query);
		
		$row2 = $result->fetch_array(MYSQLI_ASSOC);
		
		printf('<tr>
					<td>FIRST NAME</td>
					<td><input type="text" maxlength="30" name="fname" value="%s"></input></td>
				</tr>
				<tr>
					<td>LAST NAME</td>
					<td><input type="text" maxlength="30" name="lname" value="%s"></input></td>
				</tr>', $row2['fname'], $row2['lname']);
	}
	printf('
			<tr>
				<td>USERNAME</td>
				<td><input type="text" maxlength="30" name="username" value="%s"></input></td>
			</tr>
			<tr>
				<td>PHONE</td>
				<td><input type="text" maxlength="12" name="phone" value="%s"></input></td>
			</tr>
			<tr>
				<td>E_MAIL</td>
				<td><input type="text" maxlength="30" name="email" value="%s"></input></td>
			</tr>
			<tr>
				<td><button onclick="edit_user_sub()">submit</button><button onclick="change_pwd()">Change password</button></td>
			</tr>
		</table>', $row['username'], $row['phone'], $row['email']);
	
	
}

function edit_user_sub(){
	
	$db = connect_db();
	
	$type = $db->real_escape_string($_POST['type']);
	$phone = $db->real_escape_string($_POST['phone']);
	$email = $db->real_escape_string($_POST['email']);
	$username = $db->real_escape_string($_POST['username']);
	$uid = $db->real_escape_string($_POST['uid']);
	
	$query = "UPDATE user SET phone='$phone', email='$email', username='$username' WHERE uid='$uid'";
	
	if(!$db->query($query)){
		printf("error");
		die();
	}
	
	if($type === "client"){
		$cname = $db->real_escape_string($_POST['cname']);
		
		$query = "UPDATE client SET cname='$cname' WHERE uid='$uid' ";
		
		if($db->query($query)){
			printf("success");
		}else{
			printf("error");
			die();
		}
	}else{
		$fname = $db->real_escape_string($_POST['fname']);
		$lname = $db->real_escape_string($_POST['lname']);
		
		$query = "UPDATE employee SET fname='$fname', lname='$lname' WHERE uid='$uid' ";
		
		if($db->query($query)){
			printf("success");
		}else{
			printf("error");
			die();
		}
	}
	
}

function change_pwd(){
	
	$uid = $_POST['uid'];
	
	printf('<table>
			<input type="hidden" value="%s" name="uid"></input>
			<tr>
				<td>OLD PASSWORD</td>
				<td><input type="password" maxlength="30" name="old_password" ></input></td>
			</tr>
			<tr>
				<td>NEW PASSWORD</td>
				<td><input type="password" maxlength="30" name="new_password" ></input></td>
			</tr>
			<tr>
				<td>NEW PASSWORD VALIDATION</td>
				<td><input type="password" maxlength="30" name="new_password2" ></input></td>
			</tr>
			<tr>
				<td><button onclick="change_pwd_sub()">submit</button></td>
			</tr>
			</table>
			', $uid);
	
}

function change_pwd_sub(){
	
	$db = connect_db();
	
	$uid = $db->real_escape_string($_POST['uid']);
	$old_pwd = $db->real_escape_string($_POST['old_pwd']);
	$new_pwd = $db->real_escape_string($_POST['new_pwd']);
	
	$query = "SELECT password FROM user WHERE uid='$uid' ";
	
	$result = $db->query($query);
	
	$row = $result->fetch_array(MYSQLI_ASSOC);
	
	if(hash("sha512", $old_pwd) === $row['password']){
		$enc = hash("sha512", $new_pwd);
		
		$query = "UPDATE user SET password='$enc' WHERE uid='$uid' ";
		
		if($db->query($query)){
			printf("success");
		}else{
			printf("error");
			die();
		}
	}else{
		printf("Erroneous password");
		die();
	}
	
	
}


