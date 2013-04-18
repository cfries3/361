<?php

require_once './databaseFunctionsOO.php';
include_once './checkLoggedIn.php';

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
elseif (isset($_POST['iid'])){
	show_inv();
}


function display_invoices(){
	$db = connect_db();
	
	$proj = $_POST['proj'];
	$sort = $_POST['sort'];
	
	$type = $_SESSION['type'];
	$id = $_SESSION['userid'];
	
	if ($proj == -1){
		if($type != 'client'){
			$query = "SELECT * From invoice ORDER BY $sort";
		}else{
			$query = "	SELECT invoice.*, project.uid AS puid 
						From invoice 
							INNER JOIN project 
								ON invoice.pid = project.pid 
						WHERE project.uid='$id' 
						ORDER BY $sort";
		}
		
	}else{
		$query = "SELECT * From invoice WHERE pid='$proj' ORDER BY $sort";
	}
	
	$result = $db->query($query);
	
	printf("<div class='inv'>");
	if($result->num_rows < 1)
	{
		printf("Sorry no result found");
		die();
	}
	
	
	while ($row = $result->fetch_array(MYSQLI_ASSOC)){
		printf("<div id='i%s' class='element' > <div onclick='toggle(this.parentNode)' style='cursor:pointer' class='title'> %s </div> 
        <textarea rows='10' cols='50' class='desc' readonly>%s</textarea>", $row['iid'], $row['name'], $row['description']);
		if($row['paid']){
			printf("<img class='floatRight' src='./../../images/greenCheck.png' />");
		}else{
			printf("<img class='floatRight' src='./../../images/greyCheck.png' />");
		}
		printf(" due on : %s <br>", $row['idate']);
		
		$pid = $row['pid'];
		$query_p = "SELECT title From project WHERE pid='$pid'";
		$result_p = $db->query($query_p);
		if($result_p->num_rows == 1)
		{
			$row_p = $result_p->fetch_array(MYSQL_ASSOC);
			$title = $row_p['title'];
			printf("Associated project: %s <br>", $title);
		}
		
		if($type != 'client'){
			printf("<button onclick='deleteInvoiceConf(%s)'> delete invoice </button>", $row['iid']);
			printf("<button onclick='editInvoice(%s)'> edit invoice </button>", $row['iid']);
		}
		printf("<form action='./../invoicesFunc.php' method='post'> 
					<input type='hidden' name='iid' value='%s'>
					<input type='submit' value='view invoice'> 
				</form> </div>", $row['iid']);
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
	
	
	$date = $Data['idate'];
	$name = $Data['name'];
	$description = $Data['description'];
	$paid = $Data['paid'];
	$pid = $Data['pid'];
	
	printf('
	<table>
		<tr>
			<td>NAME</td>
			<td> <input type="text" maxlength="30" name="name" value="%s"></input></td>
		</tr>
		<tr>
			<td>DATE</td> 
			<td><input type="text" maxlength="30" name="date" value="%s" ></input></td>
		</tr>
		<tr>
			<td>DESCRIPTION</td>
			<td> <textarea maxlength="1000" rows="10" cols="50" style="resize: none" name="description" >%s</textarea></td>
		</tr>
		<tr>
			<td>DESIGNATION</td>
			<td>
				<input type="radio" name="paid" value="1"  >paid
				<input type="radio" name="paid" value="0" checked="checked">unpaid
			</td>
		</tr>', $name, $date, $description);
	
	$query_p = "SELECT pid, title From project ORDER BY title";
	
	$result_p = $db->query($query_p);
	printf("
		<tr>
			<td>PROJECT</td>
			<td> <select>");
	while ($row_p = $result_p->fetch_array(MYSQLI_ASSOC)){
		if($row_p['pid'] == $pid){
			printf("<option value='%s' selected> %s </option>", $row_p['pid'], $row_p['title']);
		}else{
			printf("<option value='%s'> %s </option>", $row_p['pid'], $row_p['title']);
		}
	}
	printf("</select>
			</td>
		</tr>");
	
	printf('<input type="hidden" name="iid" value="%s"><br>
	<tr><td><button onclick="validateEdit(%s)"> validate </button> <button onclick="displayContent()"> cancel </button></td>
		</tr>
		</table>
	', $iid, $iid);
	
}

function edit_invoice_validated(){
	$db = connect_db();
	
	$date = $_POST['date'];
	$name = $_POST['name'];
	$description = $_POST['description'];
	$paid = $_POST['paid'];
	$pid = $_POST['pid'];
	$iid = $_POST['iid'];
	
	$query = "UPDATE invoice SET name = '$name', description = '$description', idate = '$date', paid = $paid, pid = '$pid' WHERE iid='$iid'";
	
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
	<table>
		<tr>
			<td>NAME</td>
			<td> <input type="text" maxlength="30" name="name" ></input></td>
		</tr>
		<tr>
			<td>DATE</td>
			<td> <input type="text" maxlength="30" name="date" ></input></td>
		</tr>
		<tr>
			<td>DESCRIPTION</td> 
			<td><textarea maxlength="1000" rows="10" cols="50" style="resize: none" name="description" ></textarea></td>
		</tr>
		<tr>
			<td>DESIGNATION</td>	
			<td>
				<input type="radio" name="paid" value="1"  >paid
				<input type="radio" name="paid" value="0" checked="checked">unpaid
			</td>
		</tr>');
	
	$query_p = "SELECT pid, title From project ORDER BY title";
	
	$result_p = $db->query($query_p);
	printf("
		<tr>
			<td>PROJECT</td>
			<td> <select id='sel'>");
	while ($row_p = $result_p->fetch_array(MYSQLI_ASSOC)){
			printf("<option value='%s'> %s </option>", $row_p['pid'], $row_p['title']);
	}
	printf("</select>
			</td>
		</tr>");
	
	printf('
		<tr>
			<td><button onclick="validateNew()"> validate </button></td>
		</tr>
	</table>');
}

function new_entry(){
	$db = connect_db();
	
	$date = $_POST['date'];
	$name = $_POST['name'];
	$description = $_POST['description'];
	$paid = $_POST['paid'];
	$pid = $_POST['pid'];
	
	$query = "INSERT INTO  invoice (idate, name, description, paid, pid) VALUES ('$date', '$name', '$description', $paid, '$pid');";
	
	if($db->query($query)){
		printf("success");
	}
	else{
		printf("error");
	}
}

function show_inv(){
	$iid = $_POST['iid'];
	printf("<html> 
				<head> 
					<link rel='stylesheet' type='text/css' href='./../css/Invoice.css' media='screen' />
 				</head> 
				<body>
					<div class='title'> Invoice </div>
					<p> Invoice Nbr. %s</p>
					<div class='hLine'></div>
					<p class='floatLeft'>
						Company Name<br />
						At Company Address<br />
						City<br />
						Postal Code<br />
						Telephone Number<br /></p>
					<div class='hLine'></div>	", $iid);
	$db = connect_db();
	
	$query = "SELECT pid From invoice WHERE iid='$iid' ";
	
	$result = $db->query($query);
	
	$row = $result->fetch_array(MYSQLI_ASSOC);
	$proj = $row['pid'];
	
	$query = "SELECT title, description From project WHERE pid='$proj' ";
	
	$result = $db->query($query);
	
	$row = $result->fetch_array(MYSQLI_ASSOC);
	
	$proj_title = $row['title'];
	$proj_desc = $row['description'];
	
	printf("<br><p class='sub-title'> %s </p>
			<p>
				%s 
			</p><br><br>", $proj_title, $proj_desc);
	printf("<table class='inv_table' >
				<tr>
				<th>Task Name</th>
				<th>Task Description</th>
				<th>Hourly Rate</th>
				<th>Hours worked</th>
				<th>Amount</th>
				</tr>");
	
	$query = "SELECT tid, title, description, hrate From task WHERE pid='$proj' ";
	
	$result = $db->query($query);
	
	$sub_total = 0;
	$i = 0;
	while ($row = $result->fetch_array(MYSQLI_ASSOC)){
		$i++;
		$tid = $row['tid'];
		
		$query2 = "SELECT UNIX_TIMESTAMP(time_out) AS time_out, UNIX_TIMESTAMP(time_in) AS time_in  From punch WHERE tid='$tid' ";
		$result2 = $db->query($query2);
		
		$total = new DateTime('00:00');
		
		while($row2 = $result2->fetch_array(MYSQLI_ASSOC)){
			if (!is_null($row2['time_out']) && !is_null($row2['time_in'])){
				$out = date('Y-m-d H:i:s', $row2['time_out']);
				$in = date('Y-m-d H:i:s', $row2['time_in']);
				
				$out = new DateTime($out);
				$in = new DateTime($in);
				$time = $out->diff($in);
				
				$total->add($time);
				
			}
			
			
		}
		$zero = new DateTime('00:00');
		$total = $total->diff($zero);
		
		$hrate = $row['hrate'];
		$amount = $total->h * $hrate + $total->i / 60 * $hrate + $total->s / 3600 * $hrate;
		
		if($i % 2 == 0){
			printf("<tr id='alt'>");
		}
		else{
			printf("<tr>");
		}
		printf("<td> %s </td>
				<td> %s </td>
				<td> %.2f </td>
				<td> %s </td>
				<td> %.2f </td>
				</tr>", $row['title'], $row['description'], $hrate, $total->format("%H:%I:%S"), $amount);
		$sub_total += $amount;
	}
	printf("
	<tr>
	<td colspan='4' id='no_bord'>SUBTOTAL</td>
	<td> %.2f </td>
	</tr>", $sub_total);
	
	$GST = $sub_total*0.05;
	printf("
	<tr>
	<td colspan='4' id='no_bord'>GST 5%%</td>
	<td> %.2f </td>
	</tr>", $GST);
	
	$QST = $sub_total*0.09975;
	printf("
	<tr>
	<td colspan='4' id='no_bord'>QST 9.9975%%</td>
	<td> %.2f </td>
	</tr>", $QST);
	
	$big_total = $sub_total + $QST + $GST;
	printf("
	<tr>
	<td colspan='4' id='no_bord'>TOTAL</td>
	<td> %.2f </td>
	</tr>", $big_total);
	
	printf("</table>");
	printf("</body>
			</html>");
	
}



?>