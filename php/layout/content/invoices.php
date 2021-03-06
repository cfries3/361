<?php
require_once './../databaseFunctionsOO.php';


printOptions();
printScript();


function printOptions(){
	echo "<div class='opt'><br>
			select an associated project
			<select id=\"proj\">";
	
	$db = connect_db();
	
	$query = "SELECT pid, title, uid From project ORDER BY title";
	
	$result = $db->query($query);
	
	printf("<option value='-1'> All </option>");
	while ($row = $result->fetch_array(MYSQLI_ASSOC)){
		if($_SESSION['type'] != 'client' || $row['uid'] === $_SESSION['userid']){
			printf("<option value='%s'> %s </option>", $row['pid'], $row['title']);
		}
	}
	
	echo '</select>

			<br>
				select a sorting option
				<select id="sort">
				<option value="name"> name </option>
				<option value="idate"> date </option>
				<option value="paid"> paid/unpaid </option>
			</select>
			
			<br>

			<button id="submit_btn" onclick="displayContent()">  Submit </button>';
	if($_SESSION['type'] != 'client' || $row['uid'] === $_SESSION['userid']){
		echo '<button class="floatRight new_invoice" onclick="displayForm()"> new invoice </button>';
	}
	echo '	<br> <br>
			<div id="hLine2" class="dividerLine floatLeft"></div>
			
			</div>';
}

function printScript(){
	echo '
			<script>
    function displayContent(){
		$("#Message").html("<p></p>");
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
			$("#Message").html("<p></p>");
  	  $.post("./../invoicesFunc.php",
  			  {
  			    display: "true"
  			  },
  			  function(data,status){
  				$("#Results").html(data);
				addDatePick($("input[name=date]"));
  			  });
  	}

	function deleteInvoiceConf(iid){
		var answer = confirm("Are you sure you want to delete this invoice?");
		if(answer){
			deleteInvoice(iid);
		}
			
	}		
			
	function deleteInvoice(iid){
	$("#Message").html("<p></p>");
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
		$("#Message").html("<p></p>");
  	  $.post("./../invoicesFunc.php",
  			  {
  			    edit: iid
  			  },
  			  function(data,status){
			   var id = "#i" + iid;
				$(id).html(data);
				addDatePick($("input[name=date]"));
  			  });
		
  	}
			
	function validateEdit(iid){

		var id = "#i" + iid;
		if(checkFormat()){
			$.post("./../invoicesFunc.php",
  			  {
  			    edit_val: iid,
				date: $(id + " input[name=date]").val(),
				name: $(id + " input[name=name]").val(),
				description: $(id + " textarea[name=description]").val(),
				paid: $(id + " input:radio[name=paid]:checked").val(),
				pid: $(id + " select").val(),
				iid: $(id + " input[name=iid]").val()
  			  },
  			  function(data,status){
				displayContent();
  			  });	
		}
	}
	
	function validateNew(){
		if(checkFormat()){
			$.post("./../invoicesFunc.php",
  			  {
  			    new_val: "true",
				date: $("input[name=date]").val(),
				name: $("input[name=name]").val(),
				description: $("textarea[name=description]").val(),
				paid: $("input:radio[name=paid]:checked").val(),
				pid: $("#sel").val()
  			  },
  			  function(data,status){
				window.alert(data);
				displayContent();
  			  });
		}	
	}
			
	function toggle(el){
    	var child = $(el).find("textarea.desc");
    	if ($(child).css("display") != "none") {
    	  $(child).css("display", "none");
    	}else{
    	  $(child).css("display", "block");
    	}
  	}
			
	
	function checkFormat(){
			var date = $("input[name=date]").val();
			var regexp = new RegExp("[0-9]{4}-(1[0-2]|0[1-9])-(3[0-1]|2[0-9]|1[0-9]|0[1-9])");
			var notEmp = new RegExp("[a-z]|[0-9]", "i");
			if( !regexp.test(date)){
				$("#Message").html("<p>***** Please use the following format for the date input field: yyyy-mm-dd *****</p>");
				return false;
			}
			if( !notEmp.test($("input[name=name]").val())){
				$("#Message").html("<p>***** Please enter a value in the NAME field *****</p>");
				return false;
			}
			if( !notEmp.test($("textarea[name=description]").val()) ){
				$("#Message").html("<p>***** Please enter a value in the DESCRIPTION field *****</p>");
				return false;
			}
			$("#Message").html("<p></p>");
			return true;
	}
 
</script>

			<div id="Message"></div>
<br>
<div id="Results"></div>
';
}

?>

