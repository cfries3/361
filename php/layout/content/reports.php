<?php
	include './../layout/formClass.php';
	

		if (isset($_POST['task'])) {
		printReport();
		printScript();
	} else {
		$obj_form = new Form("workReport.php");
	
		$obj_form->populateList("task", NULL);
		$obj_form->dateRange();
		if (strcmp($_SESSION['type'], "admin") == 0) {
			$obj_form->populateList("employee", NULL);
		}
		$obj_form->closeFormat("Get Report");
		printf("<script>
				addDatePick($('input[name=from]'));
				addDatePick($('input[name=to]'));
				</script>");
	}


	
	
	function printReport() {
		$i_tid = get_post('task');
		$time_start = strtotime(get_post('from'));
		$time_end = strtotime(get_post('to'));
		
		if (isset($_POST['employee'])) {
			$i_uid = get_post('employee');
		} else {
			$i_uid = $_SESSION['userid'];
		}
		$result = queryMysql("SELECT * FROM punch WHERE uid=$i_uid AND tid=$i_tid");
		$i_numrows = mysql_num_rows($result);
		
		echo <<<_END
			<div id="scrollbar1">
    			<div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
    			<div class="viewport">
     				   <div class="overview">
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
		$i_totalHours = 0;
		$i_autoOuts = 0;
		
		for ($i = 0; $i < $i_numrows; ++$i) {
			$str_row = mysql_fetch_row($result);

			//Check to ensure it is within the date boundaries
			$day_in = date('Y-m-d g:i', strtotime($str_row[1]));
			$time_in = strtotime($day_in);
			if ($time_in < $time_start) {
				break;
			}
			
			if ($str_row[2] != NULL) {
				$day_out = date('Y-m-d g:i', strtotime($str_row[2]));
				$time_out = strtotime($day_out);
				if ($time_out > $time_end) {
					break;
				}
				//calculate total hours
				$i_totalHours += ($time_out - $time_in);
			} else {
				$day_out = "Checked In";
			}
			
			//check for bit flags
			if ($str_row[3] == 1) {
				$str_done = "Yes";
			} else {
				$str_done = "No";
			}
			if ($str_row[4] == 1) {
				$str_auto = "Yes";
				++$i_autoOuts;
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
		echo "</table></div></div></div>";
		echo "<h3>Total Hours: " . ($i_totalHours / 3600) . "</h3>" .
			 "<h3>Number of automatic checkouts: " . $i_autoOuts . "</h3>";
	}
	
	
	
	function printScript() {
		echo <<<_END
			<script type="text/javascript">
    			$(document).ready(function(){
        			$('#scrollbar1').tinyscrollbar();
    			});
			</script>
_END;
	}
?>