<?php
require_once './../databaseFunctionsOO.php';

printOptions();
printScript();


function printOptions(){
	echo "<div class='opt'><br>
			select an account
			<select id=\"acc\">";
	
	$db = connect_db();
	
	$query = "SELECT aid, name From account ORDER BY name";
	
	$result = $db->query($query);
	
	printf("<option value='-1'> All </option>");
	while ($row = $result->fetch_array(MYSQLI_ASSOC)){
		printf("<option value='%s'> %s </option>", $row['aid'], $row['name']);
	}
	
	echo '</select>

			<br>
			select a sorting option
			<select id="sort">
				<option value="name"> name </option>
				<option value="tdate"> date </option>
				<option value="amount"> amount </option>
				<option value="designation"> designation </option>
			</select>
			
			<br>

			<button id="submit_btn" onclick="displayContent()">  Submit </button> 
			<button class="floatRight new_invoice" onclick="displayForm()"> new tansaction </button>
			<br> <br>
			<div id="hLine2" class="dividerLine floatLeft"></div>
			
			</div>';
}

function printScript(){
	echo '
			<script>
    function displayContent(){
  	  $.post("./../transFunc.php",
  			  {
  			    acc: $("#acc").val(),
  			    sort: $("#sort").val()
  			  },
  			  function(data,status){
  				$("#Results").html(data);
  			  });
  	}
			
	function displayForm(){
  	  $.post("./../transFunc.php",
  			  {
  			    display: "true"
  			  },
  			  function(data,status){
  				$("#Results").html(data);
  			  });
  	}

	function deleteTransConf(xid){
		var answer = confirm("Are you sure you want to delete this transaction?");
		if(answer){
			deleteTrans(xid);
		}
			
	}		
			
	function deleteTrans(xid){
  	  $.post("./../transFunc.php",
  			  {
  			    delete: xid
  			  },
  			  function(data,status){
				displayContent();
				window.alert(data);
  			  });
  	}
			
	function editTrans(xid){
  	  $.post("./../transFunc.php",
  			  {
  			    edit: xid
  			  },
  			  function(data,status){
			   var id = "#x" + xid;
				$(id).html(data);
			
  			  });
  	}
			
	function validateEdit(xid){
		var id = "#x" + xid;
		$.post("./../transFunc.php",
  			  {
  			    edit_val: xid,
				name: $(id + " input[name=name]").val(),
				description: $(id + " textarea[name=description]").val(),
				designation: $(id + " input:radio[name=designation]:checked").val(),
				amount: $(id + " input[name=amount]").val(),
				aid: $(id + " select").val(),
				xid: $(id + " input[name=xid]").val()
  			  },
  			  function(data,status){
				window.alert(data);
				displayContent();
  			  });	
	}
	
	function validateNew(){
		$.post("./../transFunc.php",
  			  {
  			    new_val: "true",
				name: $("input[name=name]").val(),
				description: $("textarea[name=description]").val(),
				amount: $("input[name=amount]").val(),
				designation: $("input:radio[name=designation]:checked").val(),
				aid: $("#sel").val()
  			  },
  			  function(data,status){
				displayContent();
				window.alert(data);
  			  });	
	}
			
	function toggle(el){
    var child = $(el).find("textarea.desc");
    if ($(child).css("display") != "none") {
      $(child).css("display", "none");
    }else{
      $(child).css("display", "block");
    }
  }
			
 
</script>

<br>
<div id="Results"></div>';
}

?>