<?php 

require_once './../databaseFunctions.php';


	$i_punchID = printTaskInfo($_SESSION['userid']); 
	if ($i_punchID != 0) {
		checkOutForm();
	}


	
	
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
	
	
	function checkOutForm() {
		echo <<<_END
				<table>
					<tr>
						<td colspan="2" class="twoCol col2" id="split">-----------------------------------</td>
					</tr>
					<tr>
						<td class="col1">Is the task complete?</td>
						<td><input type="checkbox" name="tStatus" />
							<label for="tStatus">Yes</label></td>
					</tr>
					<tr>
						<td class="col1">Are there any comments to report?</td>
						<td><textarea cols="30" rows="5" name="comment"></textarea></td>
					</tr>
					<tr>
						<td colspan="2" class="twoCol"><button onClick="submit_checkout()">Check Out</button></td>
					</tr>
					<tr>
						<td colspan="2" class="twoCol col2" id="split">-----------------------------------</td>
					</tr>
				</table>
			</form>
		
			<script>
				function submit_checkout(){
		
					$.post("./../timePunch.php",
  					   {
  			    		checkout: "true",
						tStatus: $("input[name=tStatus]:checked").val(),
						comment: $("textarea[name=comment]").val()
			  		   },
			  			function(data,status){
							$('#content').html(data);
			  			 });	
				}		
			</script>
_END;
	}
	

?>