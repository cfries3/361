<?php 
	//update locations for links
	//!!!!!TEMPORARY
	$str_usrType = $_SESSION['type'] = "admin";

	switch ($str_usrType) {
		case "employee":
			displayEmployee();
			break;
		case "admin":
			displayAdmin();
			break;
		case "sysadmin":
			displaySysadmin();
			break;
		case "client":
			displayClient();
			break;
	}
	
	
	function displayEmployee() {
		echo <<<_END
			<div id="sideNav" class="floatLeft">
				<h3>Menu</h3>
				<ul class="menuLink">
					<li><a href="./../pages/ProjectList.php">Projects</a>
						<ul>
							<li><a href="./../pages/ProjectList.php">Project List</a></li>
							<li><a href="./../pages/checkingOut.php">Check Out</a></li>
						</ul>
					</li>
					<li><a href="./../pages/discussionBoard.php">Discussion Board</a></li>
					<li><a href="./../pages/WorkReport.html">Work Report</a></li>
				</ul>
			</div>		
_END;
	}
	
	
	function displayAdmin() {
		echo <<<_END
			<div id="sideNav" class="floatLeft">
				<h3>Menu</h3>
				<ul class="menuLink">
					<li><a href="./../pages/ProjectList.php">Projects</a>
						<ul>
							<li><a href="./../pages/ProjectList.php">Project List</a></li>
							<li><a href="pages/checkingOut.php">Check Out</a></li>
							<li><a href="pages/ManageProjects.html">Manage Projects</a></li>
						</ul>
					</li>
					<li><a href="./../pages/discussionBoard.php">Discussion Board</a></li>
					<li><a href="pages/announce.php">Announcements</a></li>
					<li><a href="pages/Accounting.html">Accounting</a>
						<ul>
							<li><a href="./../pages/invoice.php">Invoices</a></li>
							<li><a href="pages/Transactions.html">Transactions</a></li>
							<li><a href="./../pages/account.php">Accounts</a></li>
							<li><a href="pages/FinancialReports.html">Financial Reports</a></li>
						</ul>
					</li>
					<li><a href="pages/WorkReport.html">Work Report</a></li>
				</ul>
			</div>
_END;
	}
	
	
	function displaySysadmin() {
		echo <<<_END
			<div id="sideNav" class="floatLeft">
				<h3>Menu</h3>
				<ul class="menuLink">
					<li><a href="./../pages/ProjectList.php">Projects</a>
						<ul>
							<li><a href="./../pages/ProjectList.php">Project List</a></li>
							<li><a href="pages/checkingOut.php">Check Out</a></li>
						</ul>
					</li>
					<li><a href="./../pages/discussionBoard.php">Discussion Board</a></li>
					<li><a href="pages/WorkReport.html">Work Report</a></li>
					<li><a href="pages/ManageUsers.html">Manage Users</a></li>
					<li><a href="pages/ManagePunches.html">Manages Punches</a></li>
				</ul>
			</div>	
_END;
	}
	
	
	function displayClient() {
		echo <<<_END
			<div id="sideNav" class="floatLeft">
				<h3>Menu</h3>
				<ul class="menuLink">
					<li><a href="./../pages/ProjectList.php">Projects</a>
						<ul>
							<li><a href="./../pages/ProjectList.php">Project List</a></li>
							<li><a href="pages/ContactAdmin.html">Contact Admin</a></li>
						</ul>
					</li>
					<li><a href="pages/Accounting.html">Accounting</a>
						<ul>
							<li><a href="pages/Invoices.html">Invoices</a></li>
						</ul>
					</li>
				</ul>
			</div>
_END;
	}
	
?>




			
