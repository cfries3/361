<?php 
	require_once './../databaseFunctions.php';
	
	
	echo "<div id=\"content\" class=\"floatLeft\">";
	printPosts();
	echo "</div>";
	
	
	
	function printPosts() {
		echo "<div id=\"accordion\">";
		
		if (!isset($_POST['topic_id'])) {
			echo "<p>The topic could not be retrieved</p>";
			return;
		}
		$i_tid = get_post('topic_id');
		$str_author = get_post('creator');
		$pResult = queryMysql("SELECT * FROM post AS p INNER JOIN topic AS t ON p.topic_id=t.topic_id WHERE t.topic_id=$i_tid ORDER BY p.pdate ASC LIMIT 1");
		
		$str_pRow = mysql_fetch_row($pResult);
		$i_postID = $str_pRow[0];
		$str_pBody = $str_pRow[2];
		$str_tDate = date('F j, g:i', strtotime($str_pRow[6]));
		$str_tTitle = $str_pRow[7];
		
		echo <<<_END
			<h3>
				<table class="post"><a href="#">
					<tr>
						<th class="col1">$str_tTitle</th>
						<th class="col2">$str_author</th>
						<th class="col3">$str_tDate</th>
						<td><button class="floatRight" type="submit" name="reply" value="1">Reply</button></td>
					</tr></a><br />
				</table>
			</h3>
			<div>
				<p>$str_pBody</p>
			</div>
_END;
		printReplies($i_postID, $str_tTitle);
		echo <<<_END
			</div>
_END;
		return;
	}
	
	
	
	function printReplies($i_postID, $str_tTitle) {
		
		while(true) {
			$rResult = queryMysql("SELECT * FROM post AS p INNER JOIN replied_to AS r ON p.post_id=r.reply_id WHERE r.original_id=$i_postID");
			$i_numRRows = mysql_num_rows($rResult);
		
			if ($i_numRRows = 0) {
				break;
			}
		
			$str_rRow = mysql_fetch_row($rResult);
			$i_postID = $str_rRow[0];
			$str_pDate = date('F j, g:i', strtotime($str_rRow[1]));
			$str_pBody = $str_rRow[2];
			$i_uid = $str_rRow[3];

			$eResult = queryMysql("SELECT e.fname, e.lname FROM user AS u INNER JOIN employee AS e ON u.uid=e.uid WHERE u.uid=$i_uid");
			$str_fname = mysql_result($eResult, 0, 'fname');
			$str_lname = mysql_result($eResult, 0, 'lname');
			
			echo <<<_END
				<h3>
					<table class="post">
						<tr><a href="#">
							<td class="col1">RE: $str_tTitle</td>
							<td class="col2">$str_fname $str_lname</td>
							<td class="col3">$str_pDate</td>
						</tr></a>
					</table>
				</h3>
				<div>
					<p>$str_pBody</p>
				</div>
_END;
		}
		return;
	}
	
?>