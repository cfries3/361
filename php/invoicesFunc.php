<?php

require_once './databaseFunctionsOO.php';

if(isset($_POST['proj'])){
	display_invoices();
}elseif (isset($_POST['delete'])){
	delete_invoice();
}elseif (isset($_POST['edit'])){
	edit_invoice();
}elseif (isset($_POST['edit_val'])){
	edit_invoice_validated();
}elseif (isset($_POST['display'])){
	display_form();
}elseif (isset($_POST['new_val'])){
	new_entry();
}


function display_invoices(){
	$db = connect_db();
	
	$proj = $_POST['proj'];
	$sort = $_POST['sort'];
	
	if ($proj == -1){
		$query = "SELECT * From invoice ORDER BY $sort";
	}else{
		$query = "SELECT * From invoice WHERE pid='$proj' ORDER BY $sort";
	}
	
	$result = $db->query($query);
	
	printf("<div class='inv'>");
	if($result->num_rows < 1)
	{
		printf("Sorry no result found matching this date and account");
		die();
	}
	
	
	while ($row = $result->fetch_array(MYSQLI_ASSOC)){
		printf("<div id='i%s' class='element'> <div class='title'> %s </div> <div class='desc'> %s ", $row['iid'], $row['name'], $row['description']);
		if($row['paid']){
			printf("<img class='floatRight' src='./../../images/greenCheck.png' />");
		}else{
			printf("<img class='floatRight' src='./../../images/greyCheck.png' />");
		}
		printf("</div> due on : %s <br> amount due : %.2f <br>", $row['date'], $row['amount']);
		
		$pid = $row['pid'];
		$query_p = "SELECT title From project WHERE pid='$pid'";
		$result_p = $db->query($query_p);
		if($result_p->num_rows == 1)
		{
			$row_p = $result_p->fetch_array(MYSQL_ASSOC);
			$title = $row_p['title'];
			printf("Associated project: %s <br>", $title);
		}
		
		printf("<button onclick='deleteInvoiceConf(%s)'> delete invoice </button>", $row['iid']);
		printf("<button onclick='editInvoice(%s)'> edit invoice </button> </div>", $row['iid']);
	}
	printf("</div>");
}


function delete_invoice(){
	$db = connect_db();
	
	$iid = $_POST['delete'];
	$query = "DELETE FROM invoice WHERE iid='$iid'";
	
	
	if($db->query($query)){
		printf("success");
	}
	else{
		printf("error");
	}
}

function edit_invoice(){
	$db = connect_db();
	
	$iid = $_POST['edit'];
	
	$query = "SELECT * FROM invoice WHERE iid='$iid'";
	
	$result = $db->query($query);
	if($result->num_rows < 1)
	{
		printf("error accessing data");
		die();
	}
	$Data = $result->fetch_array(MYSQLI_ASSOC);
	
	
	$date = $Data['date'];
	$name = $Data['name'];
	$description = $Data['description'];
	$amount = $Data['amount'];
	$paid = $Data['paid'];
	$pid = $Data['pid'];
	
	printf('
	Name <input type="text" maxlength="30" name="name" value="%s"></input><br>
	Date <input type="text" maxlength="30" name="date" value="%s"></input><br>
	Description <textarea maxlength="1000" rows="5" cols="20" name="description" > %s </textarea><br>
	Amount <input type="number" step="0.01" name="amount" value="%.2f"></input><br>
	<input type="radio" name="paid" value="1"  >paid
	<input type="radio" name="paid" value="0" checked="checked">unpaid<br>', $name, $date, $description, $amount);
	
	$query_p = "SELECT pid, title From project ORDER BY title";
	
	$result_p = $db->query($query_p);
	printf("Associated project: <select>");
	while ($row_p = $result_p->fetch_array(MYSQLI_ASSOC)){
		if($row_p['pid'] == $pid){
			printf("<option value='%s' selected> %s </option>", $row_p['pid'], $row_p['title']);
		}else{
			printf("<option value='%s'> %s </option>", $row_p['pid'], $row_p['title']);
		}
	}
	printf("</select><br>");
	
	printf('<input type="hidden" name="iid" value="%s"><br>
	<button onclick="validateEdit(%s)"> validate </button> <button onclick="displayContent()"> cancel </button>
	', $iid, $iid);
	
}

function edit_invoice_validated(){
	$db = connect_db();
	
	$date = $_POST['date'];
	$name = $_POST['name'];
	$description = $_POST['description'];
	$amount = $_POST['amount'];
	$paid = $_POST['paid'];
	$pid = $_POST['pid'];
	$iid = $_POST['iid'];
	
	$query = "UPDATE invoice SET name = '$name', description = '$description', amount = $amount, date = '$date', paid = $paid, pid = '$pid' WHERE iid='$iid'";
	
	if($db->query($query)){
		printf("success");
	}
	else{
		printf("error");
	}
	
}

function display_form(){
	$db = connect_db();
	
	printf('
	Name <input type="text" maxlength="30" name="name" ></input><br>
	Date <input type="text" maxlength="30" name="date" ></input><br>
	Description <textarea maxlength="1000" rows="5" cols="20" name="description" ></textarea><br>
	Amount <input type="number" step="0.01" name="amount" ></input><br>
	<input type="radio" name="paid" value="1"  >paid
	<input type="radio" name="paid" value="0" checked="checked">unpaid<br>');
	
	$query_p = "SELECT pid, title From project ORDER BY title";
	
	$result_p = $db->query($query_p);
	printf("Associated project: <select id='sel'>");
	while ($row_p = $result_p->fetch_array(MYSQLI_ASSOC)){
			printf("<option value='%s'> %s </option>", $row_p['pid'], $row_p['title']);
	}
	printf("</select><br>");
	
	printf('<button onclick="validateNew()"> validate </button>');
}

function new_entry(){
	$db = connect_db();
	
	$date = $_POST['date'];
	$name = $_POST['name'];
	$description = $_POST['description'];
	$amount = $_POST['amount'];
	$paid = $_POST['paid'];
	$pid = $_POST['pid'];
	
	$query = "INSERT INTO  invoice (date, name, description, amount, paid, pid) VALUES ('$date', '$name', '$description', '$amount', $paid, '$pid');";
	
	if($db->query($query)){
		printf("success");
	}
	else{
		printf("error");
	}
}
?>