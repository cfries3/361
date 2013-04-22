<?php

require_once './../databaseFunctionsOO.php';

printf("<div class='opt' id='opt'> <br>
		Select a report type <select id='type'>
					<option value='i/e'>Income/exense</option>
					<option value='acc'>Account summary</option>
					<option value='sum'>Summary of accounts totals</option>
				</select><br>
		<button onclick='report_type()'>Submit</button>
		");

printf('
		</div><div id="hLine2" class="dividerLine floatLeft"> 
		</div>');

printf('<script>
		
		function report_type(){
			if($("#type").val() == "sum"){
			$.post("./../reportFunc.php",
  			  {
  			    sum_aid: $("#type").val()
  			  },
  			  function(data,status){
  				$("#Results").html(data);
  			  });
			}
			$.post("./../reportFunc.php",
  			  {
  			    type: $("#type").val()
  			  },
  			  function(data,status){
  				$("#opt").html(data);
				addDatePick($("input[name=from]"));
				addDatePick($("input[name=to]"));
  			  });
		}
		
		function displayReport2(){
			$.post("./../reportFunc.php",
  			  {
  			    acc_aid: $("#acc").val(),
				from: $("input[name=from]").val(),
				to: $("input[name=to]").val()
  			  },
  			  function(data,status){
  				$("#Results").html(data);
  			  });
		}
		
		function displayReport(){
			$.post("./../reportFunc.php",
  			  {
  			    ieaid: $("#acc").val()
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