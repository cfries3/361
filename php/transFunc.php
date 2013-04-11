<?php

require_once './databaseFunctionsOO.php';

if(isset($_POST['acc'])){
	display_trans();
}elseif (isset($_POST['delete'])){
	delete_trans();
}elseif (isset($_POST['edit'])){
	edit_trans();
}elseif (isset($_POST['edit_val'])){
	edit_trans_validated();
}elseif (isset($_POST['display'])){
	display_form();
}elseif (isset($_POST['new_val'])){
	new_entry();
}


function display_trans(){
	$db = connect_db();
	
	$acc = $_POST['acc'];
	$sort = $_POST['sort'];
	
	if ($acc == -1){
		$query = "SELECT * From transaction ORDER BY $sort";
	}else{
		$query = "SELECT * From transaction WHERE pid='$acc' ORDER BY $sort";
	}
	
	$result = $db->query($query);
	
	printf("<div class='inv'>");
	if($result->num_rows < 1)
	{
		printf("Sorry no result found");
		die();
	}
	
	
	while ($row = $result->fetch_array(MYSQLI_ASSOC)){
		printf("<div id='x%s' class='element' > <div onclick='toggle(this.parentNode)' style='cursor:pointer' class='title'> %s </div> 
        <textarea rows='10' cols='50' class='desc' readonly>%s</textarea>", $row['xid'], $row['name'], $row['description']);
		
		printf(" date : %s <br>", $row['tdate']);
		
		$aid = $row['aid'];
		$query_p = "SELECT name From account WHERE aid='$aid'";
		$result_p = $db->query($query_p);
		if($result_p->num_rows == 1)
		{
			$row_p = $result_p->fetch_array(MYSQL_ASSOC);
			$name = $row_p['name'];
			printf("Associated account: %s <br>", $name);
		}
		printf("Amount: %s$<br>", $row['amount']);
		printf("Designation: %s<br>", $row['designation']);
		
		printf("<button onclick='deleteTransConf(%s)'> delete transaction </button>", $row['xid']);
		printf("<button onclick='editTrans(%s)'> edit transaction </button> </div>", $row['xid']);
	}
	printf("</div>");
}


function delete_trans(){
	$db = connect_db();
	
	$xid = $_POST['delete'];
	$query = "DELETE FROM transaction WHERE xid='$xid'";
	
	
	if($db->query($query)){
		printf("success");
	}
	else{
		printf("error");
	}
}

function edit_trans(){
	$db = connect_db();
	
	$xid = $_POST['edit'];
	
	$query = "SELECT * FROM transaction WHERE xid='$xid'";
	
	$result = $db->query($query);
	if($result->num_rows < 1)
	{
		printf("error accessing data");
		die();
	}
	$transData = $result->fetch_array(MYSQLI_ASSOC);
	
	
	$name = $transData['name'];
	$description = $transData['description'];
	$amount = $transData['amount'];
	$designation = $transData['designation'];
	$aid = $transData['aid'];
	
	printf('Name <input type="text" maxlength="30" name="name" value="%s"></input><br>
Description <textarea maxlength="1000" rows="10" cols="50" style="resize: none" name="description" >%s</textarea><br>
Amount <input type="number" step="0.01" name="amount" value="%s"></input><br>
<input type="radio" name="designation" value="income" checked="checked">income
<input type="radio" name="designation" value="expense">expense<br>
<select name="account">', $name, $description, $amount);
	
$db = connect_db();


$query = "SELECT name, aid From account ORDER BY name";

$result = $db->query($query);

while ($row = $result->fetch_array(MYSQLI_ASSOC)){
	if(!($row['aid'] == $aid)){
		printf("<option value='%s'> %s </option>", $row['aid'], $row['name']);
	}
	else{
		printf("<option value='%s' selected> %s </option>", $row['aid'], $row['name']);
	}
}

printf('</select><br>
<input type="hidden" name="xid" value="%s">
<button onclick="validateEdit(%s)"> validate </button> <button onclick="displayContent()"> cancel </button>', $xid, $xid);
	
}

function edit_trans_validated(){
	$db = connect_db();
	
	$name = $_POST['name'];
	$Desc = $_POST['description'];
	$amount = $_POST['amount'];
	$design = $_POST['designation'];
	$acc = $_POST['aid'];
	$xid = $_POST['xid'];

	$query = "UPDATE transaction SET name = '$name', description = '$Desc', amount = '$amount', designation = '$design', aid = '$acc' WHERE xid='$xid'";

	printf("%s", $query);
	
	if($db->query($query)){
		printf("success");
	}
	else{
		printf("error");
	}
	
}

function display_form(){
	$db = connect_db();
	
	printf('Name <input type="text" maxlength="30" name="name"></input><br>
Description <textarea maxlength="1000" rows="10" cols="50" style="resize: none" name="description"></textarea><br>
Amount <input type="number" step="0.01" name="amount"></input><br>
Designation <input type="radio" name="designation" value="income">income
<input type="radio" name="designation" value="expense">expense<br> ');


$query = "SELECT name, aid From account ORDER BY name";

$result = $db->query($query);

printf("Associated account: <select id='sel' name='account'>");
while ($row = $result->fetch_array(MYSQLI_ASSOC)){
	printf("<option value='%s'> %s </option>", $row['aid'], $row['name']);
}
printf("</select><br>");
printf('<button onclick="validateNew()"> validate </button>');

}

function new_entry(){
$db = connect_db();
	
$name = $_POST['name'];
$Desc = $_POST['description'];
$amount = $_POST['amount'];
$design = $_POST['designation'];
$acc = $_POST['aid'];
$date = date('Y-m-d');

$query = "INSERT INTO transaction (name, description, amount, designation, aid, tdate) VALUES ('$name', '$Desc', $amount, '$design', '$acc', '$date');";

if($db->query($query)){
	printf("success");
}
else{
	printf("error");
}
}
?>