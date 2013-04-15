<?php 
	require_once './../databaseFunctions.php';
	
	
	echo "<div id=\"content\" class=\"floatLeft\">";
	printAnnouncements();
	printProjects();
	echo "</div>";
	
	
	
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
			echo "<a style=\"color:#34302D; font-weight:normal;\" href=\"announce.php#$str_aID\">$str_aTitle</a><br />"; //LINK TO ANNOUNCEMENTS PAGE ANCHORED TO ANNOUNCEMENT CLICKED ON!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
		}
		
		echo "</p>" .
			 "</div>";
		return;
	}
	
	
	
	function printProjects() {
		echo "<ul id=\"pList\" class=\"container\">";
		$pResult = queryMysql("SELECT * FROM project");
		$i_numPRows = mysql_num_rows($pResult);
		
		for ($i = 0; $i < $i_numPRows; ++$i) {
			$str_pRow = mysql_fetch_row($pResult);
			$str_pName = $str_pRow[1];
		
			$str_checkmark = checkComplete($str_pRow[3]);
			
			if ($_SESSION['type'] != 'client' || $str_pRow[5] === $_SESSION['userid']){
				echo <<<_END
				<li class="pMenu">
					<ul>
						<li class="clickable"><a href="#">$str_pName</a><img class="floatRight" src="$str_checkmark" /></li>
						<li class="dropdown project">
							<ul>
_END;
				printTasks($str_pRow[0]);
				echo <<<_END
							</ul>
						</li>
					</ul>
				</li>
_END;
			}
		}
		echo "</ul>";
		return;
	}
	
	
	
	function printTasks($str_pid) {
		$str_tQuery = "SELECT * FROM task WHERE (pid=$str_pid)"; //!!!!!!!!Find some way to sort them by order!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
		$tResult = queryMysql($str_tQuery);
		$i_numTRows = mysql_num_rows($tResult);
		
		for ($j = 0; $j < $i_numTRows; ++$j) {
			$str_tRow = mysql_fetch_row($tResult);
			$i_taskID = $str_tRow[0];
			$str_tName = $str_tRow[1];
			$str_describe = $str_tRow[2];
		
			$str_checkmark = checkComplete($str_tRow[3]);
				
			echo <<<_END
				<li class="clickable"><a href="#">$str_tName</a><img class="floatRight" src="$str_checkmark" /></li>
					<li class="dropdown task">
						<div>
							<p>$str_describe</p>
							<form action="./../timePunch.php" method="POST">
								<input type="hidden" name="taskID" value="$i_taskID" />
_END;
			if ($_SESSION['type'] === "admin"){
				echo <<<_END
								<button class="checkOut floatRight" type="submit" name="view_t" value="1">View punches</button>
_END;
														
			}
			echo <<<_END
								<button class="checkOut floatRight" type="submit" name="out" value="1">Check out</button>
								<button class="checkIn floatRight" type="submit" name="in" value="1">Check In</button><br /><br />
							</form>
						</div>
					</li>
_END;
		}
		return;
	}
	

?>