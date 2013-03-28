<?php 
//check for automatic punch out after 8 hours (create trigger + updating project status)
//why are fonts different
require_once './../databaseFunctions.php';

	echo "<div id=\"content\" class=\"floatLeft\">";
	$i_punchID = printTaskInfo(1); //change to logged in uid!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
	if ($i_punchID!=0) {
		checkPost($i_punchID);
		checkOutForm();
		printPunch($i_punchID);
	}
	echo "</div>";

	
	
	function printTaskInfo($i_uid) {
		//Find Current Task
		$result = queryMysql("SELECT t.title, p.time_in, p.punch_id FROM punch AS p INNER JOIN task AS t ON p.tid=t.tid WHERE p.uid=$i_uid AND p.time_out IS NULL");
		$i_numRows = mysql_num_rows($result);
		
		//If not checked in, display message and redirect to the project list
		if ($i_numRows == 0) {
			echo <<<_END
				<p class="forms">You are not currently punched into a task.</p>
				<script type="text/JavaScript">
					setTimeout("location.href = 'projectList.php';",1500);
				</script>
_END;
			return 0;
		} else if (isset($_POST['form'])) {
			echo "<p class=\"forms\"><b>Checking out of task</b></p>";
			return 0;
		}
		
		//otherwise display current task
		$str_row = mysql_fetch_row($result);
		echo <<<_END
			<p class="forms">You are currently checked into the task:<br />
			<b>$str_row[0]</b></p>
_END;
		return $str_row[2];
	}
	
	
	//If data entered in form, send database updates
	function checkPost($i_punchID) {
		if (isset($_POST['form'])) {
			if (isset($_POST['status'])) {
				$i_status = 1;
				$result = queryMysql("SELECT tid FROM punch WHERE punch_id=$i_punchID");
				$i_taskID = mysql_result($result, 0, 0);
				queryMysql("UPDATE task SET status=1 WHERE tid=$i_taskID");
			} else {
				$i_status = 0;
			}
			
			if (isset($_POST['comment'])) {
				$str_comment = get_post('comment');
				queryMysql("UPDATE punch SET time_out=CURRENT_TIMESTAMP, status_flag=$i_status, comment=\"$str_comment\" WHERE punch_id=$i_punchID");
			} else {
				queryMysql("UPDATE punch SET time_out=CURRENT_TIMESTAMP, status_flag=$i_status WHERE punch_id=$i_punchID");
			}
		}	
	}
	
	
	function checkOutForm() {
		echo <<<_END
			<form class="forms" action="checkingOut.php" method="POST">
				<input type="hidden" name="form" value="1" />
				<table>
					<tr>
						<td colspan="2" class="twoCol col2" id="split">-----------------------------------</td>
					</tr>
					<tr>
						<td class="col1">Is the task complete?</td>
						<td><input type="checkbox" name="status" value="1" />
										 <label for="status">Yes</label></td>
					</tr>
					<tr>
						<td class="col1">Are there any comments to report?</td>
						<td><textarea cols="30" rows="5" name="comment"></textarea></td>
					</tr>
					<tr>
						<td colspan="2" class="twoCol"><input type="submit" name="Check Out" value"Check Out" /></td>
					</tr>
					<tr>
						<td colspan="2" class="twoCol col2" id="split">-----------------------------------</td>
					</tr>
				</table>
			</form>
_END;
	}
	
	
	function printPunch($i_punchID) {
		$str_out = NULL;
		
		$pResult = queryMysql("SELECT * FROM punch WHERE punch_id=$i_punchID");
		$str_pRow = mysql_fetch_row($pResult);
		
		$str_in = date('F j, g:i', strtotime($str_pRow[1]));
		if ($str_pRow[2]!=NULL) {
			$str_out = date('F j, g:i', strtotime($str_pRow[2]));
		}
		
		if ($str_pRow[3] == 1) {
			$str_status = "Complete";
		} else {
			$str_status = "Incomplete";
		}
		
		echo <<<_END
			<p class="forms"><b>Checked in at:</b> $str_in<br />
			<b>Checked out at:</b> $str_out<br />
			<b>Task Status:</b> $str_status<br />
			<b>Submitted Comment:</b> $str_pRow[5]<br /></p>
_END;
		
	}
?>