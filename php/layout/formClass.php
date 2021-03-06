<?php 
	
	require_once './../databaseFunctions.php';

	class Form {
	
		protected $str_action;
		
		public function Form($str_setAction) {
			$this->str_action = $str_setAction;
			$this->printFormat();
		}
		
		
		protected function printFormat() {
			echo <<<_END
				<form action="$this->str_action" method="POST">
					<table class="forms">
						<colgroup>
							<col class="col1" />
							<col class="col2" />
						</colgroup>
_END;
		}
		
		
		
		public function populateList($str_table, $str_query) {
			if ($str_query == NULL) {
				$result = queryMysql("Select * FROM $str_table");
			} else {
				$result = queryMysql($str_query);
			}
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
			return;
		}
		
		
		
		public function textField($str_name, $i_size) {
			echo <<<_END
				<tr>
					<td><label for="$str_name">$str_name</label></td>
					<td><input type="text" name="$str_name" size="$i_size" /></td>
				</tr>
_END;
			return;
		}
		
		
		public function hiddenField($str_name, $str_value) {
			echo <<<_END
				<tr>
					<td><input type="hidden" name="$str_name" value="$str_value" /></td>
				</tr>
_END;
			return;
		}
		
		
		public function textareaField($str_name, $i_cols, $i_rows) {
			echo <<<_END
				<tr>
					<td><label for="$str_name">$str_name</label></td>
					<td><textarea cols="$i_cols" rows="$i_rows" name="$str_name"></textarea></td>
				</tr>
_END;
			return;
		}
	
		
		
		public function dateRange() {
			echo <<<_END
				<tr>
					<td><label for="from">Select a date range</label></td>
					<td><input type="text" id="from" name="from" /><br />to<br />
						<input type="text" id="to" name="to" /></td>
				</tr>
_END;
			return;
		}

		
		
		
		public function closeFormat($str_submit) {
			echo <<<_END
						<tr>
							<td colspan="2" class="twoCol"><input type="submit" value="$str_submit" /></td>
						</tr>
					</table>
				</form>		
_END;
			return;
		}
	}
			
?>