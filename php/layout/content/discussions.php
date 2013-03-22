<?php 
	//add in links to posts
	//create topic button
	require_once './../databaseFunctions.php';
	
	
	echo "<div id=\"content\" class=\"floatLeft\">";
	displayTopics();
	echo "</div>";
	
	
	function printTopic($result, $i_numTRows) {
		
		for ($n = 0; $n < $i_numTRows; ++$n) {
			$str_tRow = mysql_fetch_row($result);
			$i_tid = $str_tRow[0];
			$str_tDate = date('F j, g:i', strtotime($str_tRow[1]));
			$str_tTitle = $str_tRow[2];
			$i_uid = $str_tRow[3];
		
			$eResult = queryMysql("SELECT e.fname, e.lname FROM user AS u INNER JOIN employee AS e ON u.uid = e.uid WHERE u.uid=$i_uid");
			$str_fname = mysql_result($eResult, 0, 'fname');
			$str_lname = mysql_result($eResult, 0, 'lname');
				
			$pResult = queryMysql("SELECT COUNT(*) FROM topic AS t INNER JOIN post AS p ON t.topic_id=p.topic_id WHERE t.topic_id=$str_tRow[0]");
			$i_numPost = mysql_result($pResult, 0, 0);
			echo <<<_END
				<tr>
					<td><form class="plain" action="./../pages/topic.php" method="POST">
							<input type="hidden" name="topic_id" value="$i_tid" />
							<input type="hidden" name="creator" value="$str_fname $str_lname" />
							<input type="submit" name="submit" value="$str_tTitle" /><br />
						</form></td>
					<td>$str_fname $str_lname</td>
					<td>$i_numPost</td>
					<td>$str_tDate</td>
				</tr>
_END;
		}		
	}
	
	
	function displayTopics() {
		echo <<<_END
			<button class="floatRight" id="createTopic" type="submit" name="create" value="1">Create Topic</button>

			<table id="topics">
				<colgroup>
					<col class="col1" />
					<col class="col2" />
					<col class="col3" />
					<col class="col4" />
				</colgroup>
				<thead>
					<tr>
						<th>Topic</th>
						<th>Author</th>
						<th>Posts</th>
						<th>Date</th>
					</tr>
				</thead>
				<tbody>
_END;
		$tResult = queryMysql("SELECT * FROM topic");
		$i_numTRows = mysql_num_rows($tResult);
		
		printTopic($tResult, $i_numTRows);
		echo <<<_END
				</tbody>
			</table>
_END;
	}


	
	
	
?>