<?php 
include 'C:\xampp\htdocs\webs\BusinnessPortalTests\CheckConnected.php';

?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>LoginPage</title>
<script type="text/javascript">

function changedisplay(proj){
	element = proj.getElementsByClassName("task");
	if (element[0].style.display=="block"){
		for ( var i = 0; i < element.length; i++){
			element[i].style.display="none";
		}
	}
	else{
		for ( var i = 0; i < element.length; i++){
			element[i].style.display="block";
		}
	}
	
}

</script>
<style type="text/css">
.project{
 font-size:20px;
 cursor:pointer;
 width:100px;
 height: 25px;
}
.task{
 font-size:15px;
 margin-left:20px;
 display:none;
 width:1000px;
 height: 25px;
 margin-bottom: 10px;
}
</style>
</head>
<body>

<?php
	include 'User.php';
	include 'AdminUser.php';
	include 'EmployeeUser.php';

	$User;
	if ($_SESSION["type"] == "administrator"){
		$User = new AdminUser();
	}
	elseif ($_SESSION["type"] == "employee"){
		$User = new EmployeeUser();
	}
	else{
		echo("There is a bug!!!");
	}

	$db = new mysqli("localhost", "root", "", "mysql");
	if ($db->connect_error) {
		die('Connect Error (' . $db->connect_errno . ') '. $db->connect_error);
	}
	
	$query = "SELECT title, pid From comp361_project ORDER BY pid";
	$TaskQuery = "SELECT title, pid, description, tid From comp361_task ORDER BY pid";
	
		
	$result = $db->query($query);
	$tasks = $db->query($TaskQuery);
	
	while ($row = $result->fetch_array(MYSQLI_NUM)){
		printf("<div class='projectContainer'>");
		printf("<p class='project' onclick = 'changedisplay(this.parentNode)'> %s : </p>", $row[0]);
		do {
			if(isset($TaskRow)){
			printf("<div class = 'task' ");
			printf("<p> %s : %s ",$TaskRow[0], $TaskRow[2]);
			$User->displayButtons( $TaskRow[3]);
			printf("</p> </div>");
			
			}
		}
		while (($TaskRow = $tasks->fetch_array(MYSQLI_NUM)) && ($TaskRow[1] == $row[1]));
		printf("</div>");
	}

?>

<p> <a href = "http://localhost/webs/BusinnessPortalTests/addTransaction.php"> add a transaction</a> </p>
<p> <a href = "http://localhost/webs/BusinnessPortalTests/EditTransaction.php"> edit a transaction</a> </p>
<p> <a href = "http://localhost/webs/BusinnessPortalTests/DeleteTransaction.php"> delete a transaction</a> </p>
<p> <a href = "http://localhost/webs/BusinnessPortalTests/addAccount.php"> add an account</a> </p>
<p> <a href = "http://localhost/webs/BusinnessPortalTests/editAccount.php"> edit an account</a> </p>
<p> <a href = "http://localhost/webs/BusinnessPortalTests/DeleteAccount.php"> delete an account</a> </p>
<p> <a href = "http://localhost/webs/BusinnessPortalTests/GenerateReport.php"> generate a report</a> </p>
<p> <a href = "http://localhost/webs/BusinnessPortalTests/Invoice/InvoicesList.php"> Invoices</a> </p>
</body>
</html>