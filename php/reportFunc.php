<?php
require_once './databaseFunctionsOO.php';

if(isset($_POST['type'])){
	type();
}elseif (isset($_POST['ieaid'])){
	ie_rep();
}elseif (isset($_POST['acc_aid'])){
	acc_aid();
}elseif (isset($_POST['sum_aid'])){
	sum_aid();
}

function type(){
	$type = $_POST['type'];
	
	if ($type === "i/e"){
		$db = connect_db();
		
		$query = "SELECT name, aid From account ORDER BY name";
		
		$result = $db->query($query);
		
		printf("Select an account <select id='acc' name='acc'>
		<option value='all' > All Accounts </option>");
		
		while ($row = $result->fetch_array(MYSQLI_ASSOC)){
		printf("<option value='%s' > %s </option>", $row['aid'], $row['name']);
		}
		
		printf("</select><br>");
printf(' <button id="submit_btn" onclick="displayReport()">  Submit </button>
		<button class="floatRight" onclick="printFriendly()"> Print </button> <br> <br>');
	}else if($type === "acc"){
		$db = connect_db();
		
		$query = "SELECT name, aid From account ORDER BY name";
		
		$result = $db->query($query);
		
		printf("Select an account <select id='acc' name='acc'>");
		
		while ($row = $result->fetch_array(MYSQLI_ASSOC)){
			printf("<option value='%s' > %s </option>", $row['aid'], $row['name']);
		}
		
		printf("</select><br>
				From <input type='text' maxlength='30' name='from'></input><br>
				To &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<input type='text' maxlength='30' name='to'></input><br>");
		printf(' <button id="submit_btn" onclick="displayReport2()">  Submit </button>
		<button class="floatRight" onclick="printFriendly()"> Print </button> <br> <br>');
	}
}

function ie_rep(){
$db = connect_db();

$aid = $_POST['ieaid'];

if ($aid == "all"){
	$query = "SELECT name, tdate, amount, designation, aid FROM transaction ORDER BY designation, aid, tdate";
	
	$result = $db->query($query);
	
	printf("<div id='toPrint'>");
	printf("<table cellspacing='10'> <tr> <th colspan='4'> Expense </th> </tr>");
	printf("<tr> <th> name </th> <th> date </th> <th> associate account </th> <th> amount </th> </tr>");
	$total_expense = 0;
	$total_income = 0;
	$acc = -1;
	$acc_name = "";
	while ($row = $result->fetch_array(MYSQLI_ASSOC)){
		if($row['designation'] != "expense"){ break; }
		$curr_aid = $row['aid'];
	if($acc != $curr_aid){
			$query_acc = "SELECT name FROM account WHERE aid='$curr_aid'";
			$result_acc = $db->query($query_acc);
			$row_acc = $result_acc->fetch_array(MYSQLI_ASSOC);
			$acc_name = $row_acc['name'];
		}
		printf("<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td>", $row['name'], $row['tdate'], $acc_name, $row['amount']);
		$total_expense += $row['amount'];
	}
	printf("<tr><td colspan='3'> total:</td><td>%s</td>", $total_expense);
	printf("</table>");
	printf("<table cellspacing='10'> <tr> <th colspan='3'> Income </th> </tr>");
	printf("<tr> <th> name </th> <th> date </th> <th> associate account </th> <th> amount </th> </tr>");
	do{
		$curr_aid = $row['aid'];
		if($acc != $curr_aid){
			$query_acc = "SELECT name FROM account WHERE aid='$curr_aid'";
			$result_acc = $db->query($query_acc);
			$row_acc = $result_acc->fetch_array(MYSQLI_ASSOC);
			$acc_name = $row_acc['name'];
		}
		printf("<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td>", $row['name'], $row['tdate'], $acc_name, $row['amount']);
		$total_income += $row['amount'];
	
	}while ($row = $result->fetch_array(MYSQLI_ASSOC));
	printf("<tr><td colspan='3'> total:</td><td>%s</td>", $total_income);
	printf("</table>");
	
	printf("The net income is : %s", $total_income - $total_expense);
	printf("</div>");
}
else{
	$query = "SELECT name, tdate, amount, designation FROM transaction WHERE aid='$aid' ORDER BY designation, tdate";

	$result = $db->query($query);
	
	printf("<div id='toPrint'>");
	printf("<table cellspacing='10'> <tr> <th colspan='3'> Expense </th> </tr>");
	printf("<tr> <th> name </th> <th> date </th> <th> amount </th> </tr>");
	$total_expense = 0;
	$total_income = 0;
	while ($row = $result->fetch_array(MYSQLI_ASSOC)){
		if($row['designation'] != "expense"){ break; }
		printf("<tr><td>%s</td><td>%s</td><td>%s</td>", $row['name'], $row['tdate'], $row['amount']);
		$total_expense += $row['amount'];
	}
	printf("<tr><td colspan='2'> total:</td><td>%s</td>", $total_expense);
	printf("</table>");
	printf("<table cellspacing='10'> <tr> <th colspan='3'> Income </th> </tr>");
	printf("<tr> <th> name </th> <th> date </th> <th> amount </th> </tr>");
	do{
		printf("<tr><td>%s</td><td>%s</td><td>%s</td>", $row['name'], $row['tdate'], $row['amount']);
		$total_income += $row['amount'];
		
	}while ($row = $result->fetch_array(MYSQLI_ASSOC));
	printf("<tr><td colspan='2'> total:</td><td>%s</td>", $total_income);
	printf("</table><br><br>");
	
	printf("The net income is : %s", $total_income - $total_expense);
	printf("</div>");
}

}

function acc_aid(){
	
	$db = connect_db();
	
	$aid = $db->real_escape_string($_POST['acc_aid']);
	$from = $db->real_escape_string($_POST['from']);
	$to = $db->real_escape_string($_POST['to']);
	
	$query = "	SELECT name, tdate, amount, designation
	FROM  transaction
	WHERE (
	tdate >= STR_TO_DATE(  '$from',  '%Y-%m-%d' )
	)
	AND (
	tdate <= STR_TO_DATE(  '$to',  '%Y-%m-%d' )
	)
	AND (
	aid = $aid
	)";
	
	$result = $db->query($query);
	
	printf("<div id='toPrint'>");
	printf("<table cellspacing='10'> <tr> <th colspan='3'> Expense </th> </tr>");
	printf("<tr> <th> name </th> <th> date </th> <th> amount </th> </tr>");
	$total_expense = 0;
	$total_income = 0;
	while ($row = $result->fetch_array(MYSQLI_ASSOC)){
		if($row['designation'] != "expense"){ break; }
		printf("<tr><td>%s</td><td>%s</td><td>%s</td>", $row['name'], $row['tdate'], $row['amount']);
		$total_expense += $row['amount'];
	}
	printf("<tr><td colspan='2'> total:</td><td>%s</td>", $total_expense);
	printf("</table>");
	printf("<table cellspacing='10'> <tr> <th colspan='3'> Income </th> </tr>");
	printf("<tr> <th> name </th> <th> date </th> <th> amount </th> </tr>");
	do{
		printf("<tr><td>%s</td><td>%s</td><td>%s</td>", $row['name'], $row['tdate'], $row['amount']);
		$total_income += $row['amount'];
	
	}while ($row = $result->fetch_array(MYSQLI_ASSOC));
	printf("<tr><td colspan='2'> total:</td><td>%s</td>", $total_income);
	printf("</table><br><br>");
	
	printf("The net income is : %s", $total_income - $total_expense);
	printf("</div>");
	
	
}

function sum_aid(){
	$db = connect_db();
	
	
	//Asset
	
	$query = "	SELECT transaction.amount, transaction.designation, transaction.aid, account.name
				FROM transaction 
				INNER JOIN account ON transaction.aid = account.aid 
				WHERE account.designation='asset' ORDER BY account.name";
	
	$result = $db->query($query);
	
	printf("<div id='toPrint'>");
			printf("<table cellspacing='10'> <tr> <th colspan=''> Liabilities </th> </tr>");
			printf("<tr> <th> name </th>  <th> total amount </th> </tr>");
			$total = 0;
			$sub_total = 0;
			$curr_name;
			$i = 0;
			while ($row = $result->fetch_array(MYSQLI_ASSOC)){
				if($i == 0){
					$curr_name = $row['name'];
					$i++;
				}
				if($row['name'] != $curr_name){
					printf("<tr><td>%s</td><td>%s</td></tr>", $curr_name, $sub_total);
					$total += $sub_total;
					$sub_total = 0;
					$curr_name = $row['name'];
				}
				if($row['designation'] === 'expense'){
					$sub_total += $row['amount'];
				}else{
					$sub_total -= $row['amount'];
				}
			}
			
			printf("<tr><td>%s</td><td>%s</td></tr>", $curr_name, $sub_total);
			$total += $sub_total;
			printf("<tr><td>Total</td><td>%s</td></tr>", $total);
			printf("</table>");
			


			//liability
			
			$query = "	SELECT transaction.amount, transaction.designation, transaction.aid, account.name
				FROM transaction
				INNER JOIN account ON transaction.aid = account.aid
				WHERE account.designation='liability' ORDER BY account.name";
			
			$result = $db->query($query);
			
			printf("<div id='toPrint'>");
			printf("<table cellspacing='10'> <tr> <th colspan=''> Assets </th> </tr>");
			printf("<tr> <th> name </th>  <th> total amount </th> </tr>");
			$total = 0;
			$sub_total = 0;
			$curr_name;
			$i = 0;
			while ($row = $result->fetch_array(MYSQLI_ASSOC)){
				if($i == 0){
					$curr_name = $row['name'];
					$i++;
				}
				if($row['name'] != $curr_name){
					printf("<tr><td>%s</td><td>%s</td></tr>", $curr_name, $sub_total);
					$total += $sub_total;
					$sub_total = 0;
					$curr_name = $row['name'];
				}
				if($row['designation'] === 'expense'){
					$sub_total += $row['amount'];
				}else{
					$sub_total -= $row['amount'];
				}
			}
			
			printf("<tr><td>%s</td><td>%s</td></tr>", $curr_name, $sub_total);
			$total += $sub_total;
			printf("<tr><td>Total</td><td>%s</td></tr>", $total);
			printf("</table>");
			
			
			//Equity
			
			$query = "	SELECT transaction.amount, transaction.designation, transaction.aid, account.name
				FROM transaction
				INNER JOIN account ON transaction.aid = account.aid
				WHERE account.designation='equity' ORDER BY account.name";
				
			$result = $db->query($query);
			
			printf("<div id='toPrint'>");
			printf("<table cellspacing='10'> <tr> <th colspan=''> Equities </th> </tr>");
			printf("<tr> <th> name </th>  <th> total amount </th> </tr>");
			$total = 0;
			$sub_total = 0;
			$curr_name;
			$i = 0;
			while ($row = $result->fetch_array(MYSQLI_ASSOC)){
				if($i == 0){
					$curr_name = $row['name'];
					$i++;
				}
				if($row['name'] != $curr_name){
					printf("<tr><td>%s</td><td>%s</td></tr>", $curr_name, $sub_total);
					$total += $sub_total;
					$sub_total = 0;
					$curr_name = $row['name'];
				}
				if($row['designation'] === 'expense'){
					$sub_total += $row['amount'];
				}else{
					$sub_total -= $row['amount'];
				}
			}
			
			printf("<tr><td>%s</td><td>%s</td></tr>", $curr_name, $sub_total);
			$total += $sub_total;
			printf("<tr><td>Total</td><td>%s</td></tr>", $total);
			printf("</table>");
	
			printf("</div>");
}

?>