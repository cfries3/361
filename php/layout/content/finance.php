<?php

require_once './../databaseFunctionsOO.php';

$db = connect_db();

$query = "SELECT name, aid From account ORDER BY name";

$result = $db->query($query);



printf("<div class='opt'> <br>
			Select an account <select id='acc' name='acc'>
	<option value='all' > All Accounts </option>");

while ($row = $result->fetch_array(MYSQLI_ASSOC)){
	printf("<option value='%s' > %s </option>", $row['aid'], $row['name']);
}

printf("</select><br>");
printf(' <button id="submit_btn" onclick="displayReport()">  Submit </button>  
		<button class="floatRight" onclick="printFriendly()"> Print </button> <br> <br>
		<div id="hLine2" class="dividerLine floatLeft"> 
		</div></div>');

printf('<script> 
		
		function displayReport(){
			$.post("./../reportFunc.php",
  			  {
  			    aid: $("#acc").val()
  			  },
  			  function(data,status){
  				$("#Results").html(data);
  			  });
		}
		
		function printFriendly(){
			w=window.open();
			w.document.write($("#toPrint").html());
			w.print();
			w.close();
			
		}
		
		
		</script>');

printf('<br>
<div id="Results"></div>');


?>