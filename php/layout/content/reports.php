<?php 
	
	require_once './../databaseFunctions.php';

	echo "<div id=\"content\" class=\"floatLeft\">";
	printformat($str_action); //where does the form go?
	
	echo "</div>";

	
	function printFormat($str_action) {
		echo <<<_END
			<form action="$str_action" method="POST">
				<input type="hidden" name="sendtoemail" value="" />
				<table class="forms">
					<colgroup>
						<col class="col1" />
						<col class="col2" />
					</colgroup>
_END;
	}
	
	function populateList($str_table) {
		$result = queryMysql("Select * FROM $str_table");
		$i_numRows = mysql_num_rows($result);
		
		echo <<<_END
				<tr>
					<td><label for="$str_table">Select $str_table</label></td>
					<td>
						<select name="$str_table">
_END;
		if ($i_numRows == 0) {
			echo "<option value=\"NULL\">There are no options</option>";
		}
		
		for ($g = 0; $g < $i_numRows; ++$g) {
			$str_row = mysql_fetch_row($result);
			$i_id = $str_row[0];
			$str_name = $str_row[1];

			echo "<option value=\"$i_id\">$str_name</option>";
		}

		echo <<<_END
					</select>
				</td>
			</tr>
_END;
	}
	
	
	

				<tr>
					<td><label for="startDate">Select a date range</label></td>
					<td><input type="text" id="from" name="startDate" /><br />to<br />
						<input type="text" id="to" name="endDate" /></td>
				</tr>
				<tr>
					<td colspan="2" class="twoCol"><input type="submit" value="Submit" /></td>
				</tr>
			</table>
		</form>
		<form action="" enctype="" method="POST">
			<input type="hidden" name="sendtoemail" value="" />
			<table class="forms">
				<tr>
					<td colspan="2" id="split"class="twoCol">------OR------<br /><br /></td>
				</tr>
				<tr>
					<td><label for="date">Date</label></td>
					<td><input type="text" id="datepicker" name="date" /></td>
				</tr>
				<tr>
					<td><label for="amount">Amount</label></td>
					<td><input type="text" name="amount" size="20" /></td>
				</tr>
				<tr>
					<td><label for="title">Title</label></td>
					<td><input type="text" name="title" size="20" /></td>
				</tr>
				<tr>
					<td><label for="description">Description</label></td>
					<td><textarea cols="15" rows="7" name="description"></textarea></td>
				</tr>
				<tr>
					<td><label for="designation">Designation</label></td>
					<td><input type="text" name="designation" size="20" /></td>
				</tr>
				<tr>
					<td colspan="2" class="twoCol"><input type="submit" value="Add Transaction" /></td>
				</tr>
			</table>

	
	

?>