<?php 

require_once './../databaseFunctions.php';

displayContacts();

	function displayContacts() {
		echo <<<_END
			<table id="topics" class="contact">
				<colgroup>
					<col class="col1" />
					<col class="col2" />
					<col class="col3" />
					<col class="col4" />
				</colgroup>
				<thead>
					<tr>
						<th>Project<br />&nbsp</th>
						<th>Contact<br />&nbsp</th>
						<th>Phone<br />&nbsp</th>
						<th>Email<br />&nbsp</th>
					</tr>
				</thead>
				<tbody>
_END;
		$i_client = $_SESSION['userid'];
	
		//fetch all associated contacts
		$result = queryMysql("SELECT p.title, p.contact, u.email, u.phone FROM project AS p INNER JOIN user AS u ON p.contact=u.uid WHERE p.uid=$i_client");
		$i_numRows = mysql_num_rows($result);
	
		printContact($result, $i_numRows);
		echo <<<_END
					</tbody>
				</table>
_END;
		}
		
		
		function printContact($result, $i_numRows) {
			for ($n = 0; $n < $i_numRows; ++$n) {
				$str_row = mysql_fetch_row($result);
				$str_title = $str_row[0];
				$i_contact = $str_row[1];
				$str_email = $str_row[2];
				$str_phone = $str_row[3];
			
				$eResult = queryMysql("SELECT e.fname, e.lname FROM user AS u INNER JOIN employee AS e ON u.uid = e.uid WHERE u.uid=$i_contact");
				$str_fname = mysql_result($eResult, 0, 'fname');
				$str_lname = mysql_result($eResult, 0, 'lname');
				echo <<<_END
					<tr>
						<td>$str_title<br />&nbsp</td>
						<td>$str_fname $str_lname<br />&nbsp</td>
						<td>$str_phone<br />&nbsp</td>
						<td>$str_email<br />&nbsp</td>
					</tr>
_END;
			}
				
		}




?>