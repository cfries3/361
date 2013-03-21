<?php 
	require_once './../databaseFunctions.php';
	
	
	echo "<div id=\"content\" class=\"floatLeft\">";
	listAnnouncements();
	echo "</div>";
	
	function listAnnouncements() {
		$aResult = queryMysql("SELECT * FROM announcement ORDER BY adate DESC");
		$i_numARows = mysql_num_rows($aResult);
	
		echo "<table>";
	
		for ($i = 0; $i < $i_numARows; ++$i) {
			$str_aRow = mysql_fetch_row($aResult);
			$str_date = date('F j, g:i', strtotime($str_aRow[1]));
			echo <<<_END
				<tr>
					<th>$str_date</th>
					<th><a name="$str_aRow[0]" id="$str_aRow[0]">$str_aRow[2]</a></th>
				</tr>
				<tr>
					<td></td>
					<td>$str_aRow[3]<br /><br /></td>
				</tr>
_END;
		}
		echo "</table>";
	}
	
?>