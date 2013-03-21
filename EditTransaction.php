<?php
include 'CheckConnected.php';

?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Edit Transaction</title>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>

 
</head>
<body>


select an accout
<select id="acc">
    <?php

		$db = new mysqli("localhost", "root", "", "mysql");
		if ($db->connect_error) {
			die('Connect Error (' . $db->connect_errno . ') '. $db->connect_error);
		}


		$query = "SELECT name, aid From comp361_account ORDER BY name";

		$result = $db->query($query);

		while ($row = $result->fetch_array(MYSQLI_ASSOC)){
			printf("<option value='%s'> %s </option>", $row['aid'], $row['name']);
		}

	?>
</select><br>

select a date
<input id="date" type="text" maxlength="10" size="10" name="date" value="<?php echo (date('Y-m-d')); ?>" ><br>

<script>
	$("#acc").prop("selectedIndex", -1);


    function displayContent(){
  	  $.post("EditTransScript.php",
  			  {
  			    acc: $("#acc").val(),
  			    date: $("#date").val()
  			  },
  			  function(data,status){
  				$("#Results").html(data);
  			  });
  			}

    $("#acc").change(displayContent);
    $("#date").change(displayContent);
 
</script>

<div id="Results"></div>