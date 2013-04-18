<?php
	include './../layout/formClass.php';
	

	
	if (isset($_POST['task'])) {
		printReport();
	} else {
		$obj_form = new Form("workReport.php");
	
		$obj_form->populateList("task", NULL);
		$obj_form->dateRange();
		$obj_form->closeFormat("Get Report");
	}


	
	
	function printReport() {
		$i_tid = get_post('task');
		$time_start = strtotime(get_post('from'));
		
		$time_end = strtotime(get_post('to'));
		//session variable use!!!!!!!!!!!!!!!!!!!!!
		$result = queryMysql("SELECT * FROM punch WHERE uid=1 AND tid=$i_tid");
		$i_numrows = mysql_num_rows($result);
		
		echo <<<_END
			<table>
				<tr class="leftalign">
					<th class="one">Task</th>
					<th class="two">Checked In</th>
					<th class="three">Checked Out</th>
					<th class="four">Completed</th>
					<th class="five">Auto Logout</th>
					<th class="six">Comment</th>
				<tr>
_END;
		
		for ($i = 0; $i < $i_numrows; ++$i) {
			$str_row = mysql_fetch_row($result);

			$day_in = date('Y-m-d g:i', strtotime($str_row[1]));
			$time_in = strtotime($day_in);
			if ($time_in < $time_start) {
				break;
			}
			
			$day_out = date('Y-m-d g:i', strtotime($str_row[2]));
			$time_out = strtotime($day_in);
			if ($time_out > $time_end) {
				break;
			}
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
					<td>$day_in</td>
					<td>$day_out</td>
					<td>$str_done</td>
					<td>$str_auto</td>
					<td>$str_comment</td>
				</tr>
_END;
		}
		echo "</table>";
	}
?>