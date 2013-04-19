<?php 
	require_once './../databaseFunctions.php';
	
	error_reporting(0);
	

	printPosts();

	
	
	
	function printPosts() {

		if (!isset($_POST['topic_id'])) {
			echo "<p>The topic could not be retrieved</p>";
			return;
		}
		$i_tid = get_post('topic_id');
		$str_author = get_post('creator');
		$pResult = queryMysql("SELECT * FROM post AS p, topic AS t WHERE p.topic_id=t.topic_id AND t.topic_id=$i_tid ORDER BY p.pdate ASC LIMIT 1");
		
		$str_pRow = mysql_fetch_row($pResult);
		$i_postID = $str_pRow[0];
		$str_pBody = $str_pRow[2];
		$str_tDate = date('F j, g:i', strtotime($str_pRow[6]));
		$str_tTitle = $str_pRow[7];
		
		echo <<<_END
			<form action="./../pages/reply.php" method="POST">
				<input type="hidden" name="taskID" value="$i_tid" />
				<input type="hidden" name="creator" value="$str_author" />
				<input type="hidden" name="title" value="$str_tTitle" />
				<button class="floatRight forms" id="reply" type="submit" name="reply" value="1">Reply</button>
			</form>
			<div id="accordion">
			<h3>
				<table class="post top"><a href="#">
					<tr>
						<th class="col1">$str_tTitle</th>
						<th class="col2">$str_author</th>
						<th class="col3">$str_tDate</th>
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

			$eResult = queryMysql("SELECT fname, lname FROM employee WHERE uid=$i_uid");
			$str_eRow = mysql_fetch_row($eResult);
			$str_fname = $str_eRow[0];
			$str_lname = $str_eRow[1];
			
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