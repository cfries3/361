<?php
require_once './../databaseFunctionsOO.php';

echo "<div id=\"content\" class=\"floatLeft\">";
printOptions();
printScript();
echo "</div>";

function printOptions(){
	echo "<div class='opt'><br>
			select an associated project
			<select id=\"proj\">";
	
	$db = connect_db();
	
	$query = "SELECT pid, title From project ORDER BY title";
	
	$result = $db->query($query);
	
	printf("<option value='-1'> All </option>");
	while ($row = $result->fetch_array(MYSQLI_ASSOC)){
		printf("<option value='%s'> %s </option>", $row['pid'], $row['title']);
	}
	
	echo '</select>

			<br>
				select a sorting option
				<select id="sort">
				<option value="name"> name </option>
				<option value="date"> date </option>
				<option value="amount"> amount </option>
				<option value="paid"> paid/unpaid </option>
			</select>
			
			<br>

			<button id="submit_btn" onclick="displayContent()">  Submit </button> 
			<button class="floatRight new_invoice" onclick="displayForm()"> new invoice </button>
			<br> <br>
			<div id="hLine2" class="dividerLine floatLeft"></div>
			
			</div>';
}

function printScript(){
	echo '
			<script>
    function displayContent(){
  	  $.post("./../invoicesFunc.php",
  			  {
  			    proj: $("#proj").val(),
  			    sort: $("#sort").val()
  			  },
  			  function(data,status){
  				$("#Results").html(data);
  			  });
  	}
			
	function displayForm(){
  	  $.post("./../invoicesFunc.php",
  			  {
  			    display: "true"
  			  },
  			  function(data,status){
			    
  				$("#Results").html(data);
  			  });
  	}

	function deleteInvoiceConf(iid){
		var answer = confirm("Are you sure you want to delete this invoice?");
		if(answer){
			deleteInvoice(iid);
		}
			
	}		
			
	function deleteInvoice(iid){
  	  $.post("./../invoicesFunc.php",
  			  {
  			    delete: iid
  			  },
  			  function(data,status){
  				window.alert(data);
				displayContent();
  			  });
  	}
			
	function editInvoice(iid){
  	  $.post("./../invoicesFunc.php",
  			  {
  			    edit: iid
  			  },
  			  function(data,status){
			   var id = "#i" + iid;
				$(id).html(data);
			
  			  });
  	}
			
	function validateEdit(iid){

		var id = "#i" + iid;
		$.post("./../invoicesFunc.php",
  			  {
  			    edit_val: iid,
				date: $(id + " input[name=date]").val(),
				name: $(id + " input[name=name]").val(),
				description: $(id + " textarea[name=description]").val(),
				amount: $(id + " input[name=amount]").val(),
				paid: $(id + " input:radio[name=paid]:checked").val(),
				iid: $(id + " input[name=iid]").val()
  			  },
  			  function(data,status){
				window.alert(data);
				displayContent();
  			  });	
	}
	
	function validateNew(){

		$.post("./../invoicesFunc.php",
  			  {
  			    new_val: "true",
				date: $("input[name=date]").val(),
				name: $("input[name=name]").val(),
				description: $("textarea[name=description]").val(),
				amount: $("input[name=amount]").val(),
				paid: $("input:radio[name=paid]:checked").val()
  			  },
  			  function(data,status){
				window.alert(data);
				displayContent();
  			  });	
	}
			
 
</script>

<br>
<div id="Results"></div>';
}

?>
