<?php
	include './../layout/formClass.php';
	
	echo "<div id=\"content\" class=\"floatLeft\">";
	
	if (isset($_POST['project'])) {
		printReport();
	} else {
		$obj_form = new Form("workReport.php");
	
		$obj_form->populateList("task", NULL);
		$obj_form->dateRange();
		$obj_form->closeFormat("Get Report");
	}
	echo "</div>";

	
	
	function printReport() {
		$i_tid = get_post('task');
		$time_start = get_post('from');
		$time_end = get_post('to');
		//session variable use
		$result = queryMysql("SELECT * FROM punch AS pu, task AS ta WHERE pu.uid=1 AND pu.time_in>=$time_start AND pu.time_out<=$time_end AND pu.tid=$i_tid");
		$i_numrows = mysql_num_rows($result);
		
		echo <<<_END
			<table>
				<tr>
					<th>Task</th>
					<th>Time In</th>
					<th>Time Out</th>
					<th>Completed</th>
					<th>Auto Logout</th>
					<th>Comment</th>
				<tr>
_END;
		
		for ($i = 0; $i < $i_numrows; ++$i) {
			$str_row = mysql_fetch_row($result);
			$time_in = date('F j, g:i', strtotime($str_row[1]));
			$time_out = date('F j, g:i', strtotime($str_row[2]));
			if ($str_row[3] == 1) {
				$str_done = "Yes";
			} else {
				$str_done = "No";
			}
			if ($str_row[4] == 1) {
				$str_auto = "Yes";
			}
				$str_auto = "No";
			$str_comment = $str_row[5];
			$i_tid = $str_row[7];
			
			$tResult = queryMysql("SELECT title FROM task WHERE tid=$i_tid");
			$str_tTitle = mysql_result($tResult, 0, 0);
			echo <<<_END
				<tr>
					<td>$str_tTitle</td>
					<td>$time_in</td>
					<td>$time_out</td>
					<td>$str_done</td>
					<td>$str_auto</td>
					<td>$str_comment</td>
				</tr>
_END;
		}
		echo "</table>";
	}
?>