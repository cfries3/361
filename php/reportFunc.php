<?php
require_once './databaseFunctionsOO.php';

$db = connect_db();

$aid = $_POST['aid'];

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
	printf("</table>");
	
	printf("The net income is : %s", $total_income - $total_expense);
	printf("</div>");
}

?>