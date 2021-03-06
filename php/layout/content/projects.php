<?php 
	require_once './../databaseFunctions.php';
	
	
	if (strcmp($_SESSION['type'], "client") == 0) {
		printProjects($_SESSION['userid']);
	} else {
		printAnnouncements();
		printProjects(0);
		printScript();
	}

	
	
	
	function checkComplete($i_status) {
		if ($i_status == 0) {
			$str_checkmark = "./../../images/greyCheck.png";
		} else {
			$str_checkmark = "./../../images/greenCheck.png";
		}
		return $str_checkmark;
	}
	
	
	
	function printAnnouncements() {
		echo <<<_END
			<div class="announcements">
				<h3>Announcements</h3>
				<p>
_END;
		$aResult = queryMysql("SELECT a.title, a.announce_id, a.adate FROM announcement a ORDER BY adate DESC");
		$i_numARows = mysql_num_rows($aResult);
		
		for ($h = 0; $h < $i_numARows && $h < 3; ++$h) {
			$str_aTitle = mysql_result($aResult, $h, 'title');
			$str_aID = mysql_result($aResult, $h, 'announce_id');
			echo "<a style=\"color:#34302D; font-weight:normal;\" href=\"announce.php#$str_aID\">$str_aTitle</a><br />"; 
		}
		
		echo "</p>" .
			 "</div>";
		return;
	}
	
	
	
	function printProjects($i_id) {
		echo "<ul id=\"pList\" class=\"container\">";
		if ($i_id == 0) {
			$pResult = queryMysql("SELECT * FROM project");
		} else {
			//!!!!!!!!!!!!!!!!!!!!!!Might have to change database
			$pResult = queryMysql("SELECT * FROM project WHERE uid=$i_id");
		}
		$i_numPRows = mysql_num_rows($pResult);
		
		for ($i = 0; $i < $i_numPRows; ++$i) {
			$str_pRow = mysql_fetch_row($pResult);
			$str_pName = $str_pRow[1];
		
			$str_checkmark = checkComplete($str_pRow[3]);
		
			echo <<<_END
			<li class="pMenu">
				<ul>
					<li class="clickable"><a href="#">$str_pName</a><img class="floatRight" src="$str_checkmark" /></li>
					<li class="dropdown project">
						<ul>
_END;
			printTasks($str_pRow[0], $i_id);
			echo <<<_END
						</ul>
					</li>
				</ul>
			</li>
_END;
		}
		echo "</ul>";
		return;
	}
	
	
	
	function printTasks($str_pid, $i_id) {
		$str_tQuery = "SELECT * FROM task WHERE (pid=$str_pid)"; 
		$tResult = queryMysql($str_tQuery);
		$i_numTRows = mysql_num_rows($tResult);
		
		for ($j = 0; $j < $i_numTRows; ++$j) {
			$str_tRow = mysql_fetch_row($tResult);
			$i_taskID = $str_tRow[0];
			$str_tName = $str_tRow[1];
			$str_describe = $str_tRow[2];
		
			$str_checkmark = checkComplete($str_tRow[3]);
			
			if ($i_id == 0) {
				echo <<<_END
					<li class="clickable"><a href="#">$str_tName</a><img class="floatRight" src="$str_checkmark" /></li>
						<li class="dropdown task">
							<div id="$i_taskID">
								<p>$str_describe</p>
								<button class="checkOut floatRight" onclick="checkOut($i_taskID)">Check Out</button>
								<button class="checkIn floatRight" onclick="checkIn($i_taskID)">Check In</button><br /><br />
							</div>
						</li>
_END;
			} else {
				echo <<<_END
					<li class="clickable"><a href="#">$str_tName</a><img class="floatRight" src="$str_checkmark" /></li>
						<li class="dropdown task">
						</li>
_END;
			}
		}
		return;
	}
	

	
	function printScript() {
		echo <<<_END
			<script>
				function checkOut(tid) {
					$.post("./../timePunch.php",
  						{
							taskID: tid,
						    out: "True"
  			  			},
  			  				function(data,status){
  								window.alert(data);
								window.location.reload();
  			  				});
				}
										
				function checkIn(tid) {
					 $.post("./../timePunch.php",
  						{
							taskID: tid,
						    in: "True"
  			  			},
  			  				function(data,status){
  								window.alert(data);
  			  				});
				}				
				</script>
_END;
	}
?>