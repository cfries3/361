<?php


echo <<<_END
	<div class="menu">
		<ul class="man">
			<li class="man"><div class="man" onclick="new_announce()">New Announcement</div></li>
			<li class="man"><div class="man" onclick="delete_announce()">Delete Announcement</div></li>
			<li class="man"><div class="man" onclick="displayAnnounce()">View Announcements</div></li>
		</ul>
	</div><br /><br />
	<div id="Message"></div>
	<div id="Results"></div>
_END;

echo <<<_END
	<script>
	
		function new_announce() {
			$.post("./../announceFunc.php",
  			  {
  			    new_a: "new"
  			  },
  			  function(data,status){
  				$("#Results").html(data);
  			  });
		}
		
		function new_db_a() {
			$.post("./../announceFunc.php",
  			  {
				new_db_a: "true",
  			    title: $("input[name=title]").val(),
				description: $("textarea[name=description]").val(),
  			  },
  			  function(data,status){
  				window.alert(data);
				location.reload();
  			  });
		}
		
		function delete_announce(){
			$.post("./../announceFunc.php",
  			  {
				delete_a : "true"
  			  },
  			  function(data,status){
  				$("#Results").html(data);
  			  });
		}
		
		function delete_a_conf(i_aid) {
			var answer = confirm("Are you sure you want to delete this announcement?");
			if(answer){
				$.post("./../announceFunc.php",
  			  {
				delete_a_conf : i_aid
  			  },
  			  function(data,status){
				location.reload();
  			  });
			}
		}
		
		
		function displayAnnounce() {
			$.post("./../announceFunc.php",
  			  {
				display_a : "true"
  			  },
  			  function(data,status){
  				$("#Results").html(data);
  			  });
		}
		</script>
_END;
?>