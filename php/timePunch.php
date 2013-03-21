<?php 

require_once 'databaseFunctions.php';

	$i_tid = get_POST('taskID');
	if (isset($_POST['out'])) {
		punchOut($i_tid, 1);//SAME HERE!!!!!!!!!
	}
	if (isset($_POST['in'])) {
		punchIn($i_tid, 1); //GET USER ID FROM SESSION VAR!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
	}


	function autoCheckOut() {
		//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
	}

	function punchIn($i_taskID, $i_uid) {
		/*automatically log the user out of any open tasks*/
		queryMysql("UPDATE punch SET time_out=CURRENT_TIMESTAMP WHERE uid=$i_uid AND time_out IS NULL");
		/*primary key is auto increment*/
		queryMysql("INSERT INTO punch (time_in, uid, tid) VALUES (CURRENT_TIMESTAMP, $i_uid, $i_taskID)");
		echo <<<_END
			<script>
				alert("You have been checked in");
				window.location="./pages/ProjectList.php";
			</script>";
_END;
	}

	
	function punchOut($i_tid, $i_uid) {
		$result = queryMysql("SELECT t.tid FROM punch AS p INNER JOIN task AS t ON p.tid=t.tid WHERE p.uid=$i_uid AND p.time_out IS NULL");
		$i_taskID = mysql_result($result, 0, 0);
		if ($i_tid != $i_taskID) {
			echo <<<_END
			<script>
				alert("You are not checked into this task");
				window.location="./pages/ProjectList.php";
			</script>";
_END;
		}
		echo "<script>window.location='./pages/checkingOut.php'</script>";
	}
?>