<?php
require_once './../databaseFunctionsOO.php';


printList();
printScript();


function printList(){
	
	$db = connect_db();
	
	$query = "SELECT * From account ORDER BY name";
	
	$result = $db->query($query);
	
	printf("<div id='top' class='inv'>");
	printf("<button onclick='create_acc()'> create account </button>");
	while ($row = $result->fetch_array(MYSQLI_ASSOC)){
		printf("<div id='a%s' class='element'> <div class='title'> %s </div> <div class='sub-title'>Designation: </div> %s <br>", $row['aid'], $row['name'], $row['designation']);
		printf("<button onclick='delete_acc(%s)'> delete account </button> <button onclick='edit_acc(%s)'> edit account </button></div>", $row['aid'],$row['aid']);
	}
	printf("</div>");
	
	
}

function printScript(){
	echo '
			<script>
   	function delete_conf(id){
  	  $.post("./../accountsFunc.php",
  			  {
				delete:"true",
  			    aid: id
  			  },
  			  function(data,status){
  				window.alert(data);
				location.reload();
  			  });
  	}
		
	function delete_acc(id){
		var answer = confirm("Are you sure you want to delete this account?");
		if(answer){
			delete_conf(id);
		}
			
	}
			
	function edit_acc(id){
		var id2 = "#a" + id;
  	  $.post("./../accountsFunc.php",
  			  {
  			    edit: id
  			  },
  			  function(data,status){
				$(id2).html(data);
			
  			  });
  	}
			
	function cancel_edit(){
			location.reload();
	}
			
	function edit_submit(aid){
			
		var id = "#a" + aid;
		$.post("./../accountsFunc.php",
  			  {
  			    edit_val: aid,
				name: $(id + " input[name=name]").val(),
				designation: $(id + " input:radio[name=designation]:checked").val(),
				aid: $(id + " input[name=aid]").val()
  			  },
  			  function(data,status){
				window.alert(data);
				location.reload();
  			  });		
			
	}

	function create_acc(){
			
		$.post("./../accountsFunc.php",
  			  {
  			    display: "true"
  			  },
  			  function(data,status){
			    
  				$("#top").html(data);
  			  });
			
	}
			
	function new_submit(){
			
			$.post("./../accountsFunc.php",
  			  {
  			    new_val: "true",
				name: $("input[name=name]").val(),
				designation: $("input:radio[name=designation]:checked").val()
  			  },
  			  function(data,status){
				window.alert(data);
				location.reload();
  			  });	
			
	}		
			
 
</script>
';
}

?>
