<?php 

require_once 'databaseFunctions.php';
include_once './checkLoggedIn.php';


if (isset($_POST['new_a'])) {
	newAnnouncement();
} else if (isset($_POST['new_db_a'])) {
	new_dbAnnouncement();
} else if (isset($_POST['delete_a'])) {
	deleteAnnounce();
} else if (isset($_POST['delete_a_conf'])) {
	deleteAnnounce_conf();
} else if (isset($_POST['display_a'])) {
	displayA();
}



	function newAnnouncement() {
		echo <<<_END
			<table>
				<tr>
					<td>Title</td>
					<td><input type="text" maxlength="100" name="title"></input></td>
				</tr>
				<tr>
					<td>Description</td>
					<td><textarea maxlength="1000" rows="10" cols="50" style="resize: none" name="description" ></textarea></td>
				</tr>
			</table>
			<input type="hidden" name="status" value="0"></input>
			<button onclick="new_db_a()"> Submit </button>
_END;
	}


	function new_dbAnnouncement() {
		
		$str_title = $_POST['title'];
		$str_description = $_POST['description'];
		$i_uid = $_SESSION['userid'];
		
		queryMysql("INSERT INTO announcement (title, description, uid) VALUES ('$str_title', '$str_description', $i_uid)");
		echo "Done";
	}
	
	
	function deleteAnnounce(){

		$result = queryMysql("SELECT announce_id, title, description FROM announcement ORDER BY adate");
		$i_numRows = mysql_num_rows($result);
		if($i_numRows < 1){
			echo "<div style='text-align:center'>Sorry there are currently no announcements to display";
			die();
		}
		echo "<div style='text-align:center; font-weight:bold;'>Which announcement do you wish to delete?</div>";
		for ($j = 0; $j < $i_numRows; ++$j) {
			$str_row = mysql_fetch_row($result);
			$i_aid = $str_row[0];
			$str_title = $str_row[1];
			$str_desc = $str_row[2];
			
			echo <<<_END
				<br /><br />
				<b>$str_title</b><br />
				   $str_desc<br />
				<button onclick="delete_a_conf($i_aid)">Delete</button>
_END;
		}
	}
	
	
	function deleteAnnounce_conf(){

		$aid = $_POST['delete_a_conf'];
		
		if (queryMysql("DELETE FROM announcement WHERE announce_id='$aid'")) {
			echo "success";
		}
		else {
			echo "error";
		}
	}
	
	
	function displayA() {
		$result = queryMysql("SELECT title, description, adate, uid FROM announcement ORDER BY adate");
		$i_numRows = mysql_num_rows($result);
		if($i_numRows < 1){
			echo "<div style='text-align:center; font-weight:bold;'>Sorry there are currently no announcements to display";
			die();
		}
		for ($j = 0; $j < $i_numRows; ++$j) {
			$str_row = mysql_fetch_row($result);
			$str_title = $str_row[0];
			$str_desc = $str_row[1];
			$str_date = date('Y-m-d g:i', strtotime($str_row[2]));
			$i_uid = $str_row[3];
			
			$result2 = queryMysql("SELECT fname, lname FROM employee WHERE uid=$i_uid");
			$str_row2 = mysql_fetch_row($result2);
			$str_name = $str_row2[0] . " " . $str_row2[1];
			
			echo <<<_END
				<br /><br />
				<b>$str_title</b><br />
				   $str_desc<br />
				   Submitted by $str_name at $str_date<br />
_END;
		}
	}
	
?>