<?php 

require_once 'databaseFunctions.php';
include_once './checkLoggedIn.php';

	$i_uid = $_SESSION['userid'];
	//Post coming from checkout page, no tid check required
	if (isset($_POST['checkout'])) {
		punchOut(0, $i_uid);
	} else {
		$i_tid = $_POST['taskID'];
	}
	
	//Post coming from project list, user can select incorrect task
	if (isset($_POST['out'])) {
		punchOut($i_tid, $i_uid);
	//checking in
	} else if (isset($_POST['in'])) {
		punchIn($i_tid, $i_uid); 
	//view punch
	} else if (isset($_POST['view_t'])) {
		viewPunch($i_tid);
	}



	function punchIn($i_taskID, $i_uid) {
		/*automatically log the user out of any open tasks*/
		queryMysql("UPDATE punch SET time_out=CURRENT_TIMESTAMP WHERE uid=$i_uid AND time_out IS NULL");
		/*primary key is auto increment*/
		queryMysql("INSERT INTO punch (time_in, uid, tid) VALUES (CURRENT_TIMESTAMP, $i_uid, $i_taskID)");
		echo "You have been checked in";
	}

	
	function punchOut($i_tid, $i_uid) {
		$result = queryMysql("SELECT t.tid, p.punch_id FROM punch AS p INNER JOIN task AS t ON p.tid=t.tid WHERE p.uid=$i_uid AND p.time_out IS NULL");
		$i_taskID = mysql_result($result, 0, 0);
		$i_punchID = mysql_result($result, 0, 1);
		//check if correct task
		if ($i_tid != 0 && $i_tid != $i_taskID) {
			echo "You are not checked into this task";
			return;
		}		
		updatePunch($i_taskID, $i_punchID);
		if ($i_tid == 0) {
			printPunch($i_punchID);
		} else {
			echo "You have been checked out";
		}
	}
	
	
	//If data entered in form, send database updates
	function updatePunch($i_taskID, $i_punchID) {
			if (isset($_POST['tStatus']) && $_POST['tStatus'] == 'on') {
				$i_status = 1;
				queryMysql("UPDATE task SET status=1 WHERE tid=$i_taskID");
			} else {
				$i_status = 0;
				queryMysql("UPDATE task SET status=0 WHERE tid=$i_taskID");
			}
				
			if (isset($_POST['comment'])) {
				$str_comment = get_post('comment');
				queryMysql("UPDATE punch SET time_out=CURRENT_TIMESTAMP, status_flag=$i_status, comment=\"$str_comment\" WHERE punch_id=$i_punchID");
			} else {
				queryMysql("UPDATE punch SET time_out=CURRENT_TIMESTAMP, status_flag=$i_status WHERE punch_id=$i_punchID");
			}
		}
	
	
	
	//Print successful checkout
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
	
	
	
	function viewPunch($i_tid){
		echo <<<_END
			<form name="form" action="./pages/viewPunches.php" method="post">
			<input type="hidden" name="tid" value="$i_tid"></input>
			</form>
			<script>
				document.form.submit();
			</script>
_END;
		
	}
?>