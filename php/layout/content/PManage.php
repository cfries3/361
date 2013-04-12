<?php

echo "<div id=\"content2\" class=\"floatLeft\">";
printf('<div class="menu"><ul class="man">
<li class="man"><div class="man" onclick="new_proj()">New Project</div></li>
<li class="man"><div class="man" onclick="delete_proj()">Delete Project</div></li>
<li class="man"><div class="man" onclick="edit_proj()">Edit Project</div></li>
<li class="man"><div class="man" onclick="new_task()">New Task</div></li>
<li class="man"><div class="man" onclick="delete_task()">Delete Task</div></li>
<li class="man"><div class="man" onclick="edit_task()">Edit Task</div></li>
</ul></div><br><br>');

printf('<script>
		
		function new_proj(){
			$.post("./../manageFunc.php",
  			  {
  			    new_p: "new"
  			  },
  			  function(data,status){
  				$("#Results").html(data);
  			  });
		}
		
		function new_proj_sub(){
			$.post("./../manageFunc.php",
  			  {
				new_p_sub: "true",
  			    title: $("input[name=title]").val(),
				description: $("textarea[name=description]").val(),
				status: $("input[name=status]").val()
  			  },
  			  function(data,status){
  				window.alert(data);
				location.reload();
  			  });
		}
		
		function delete_proj(){
			$.post("./../manageFunc.php",
  			  {
				delete_p : "true"
  			  },
  			  function(data,status){
  				$("#Results").html(data);
  			  });
		}
		
		function delete_proj_conf(){
			var answer = confirm("Are you sure you want to delete this project?");
			if(answer){
				$.post("./../manageFunc.php",
  			  {
				delete_p_conf : $("select[name=pid]").val()
  			  },
  			  function(data,status){
  				window.alert(data);
				location.reload();
  			  });
			}
		}
		
		function delete_task(){
			$.post("./../manageFunc.php",
  			  {
				delete_t : "true"
  			  },
  			  function(data,status){
  				$("#Results").html(data);
  			  });
		}
		
		function delete_task_conf(){
			var answer = confirm("Are you sure you want to delete this task?");
			if(answer){
				$.post("./../manageFunc.php",
  			  {
				delete_t_conf : $("select[name=tid]").val()
  			  },
  			  function(data,status){
  				window.alert(data);
				location.reload();
  			  });
			}
		}
		
		function new_task(){
			$.post("./../manageFunc.php",
  			  {
  			    new_t: "new"
  			  },
  			  function(data,status){
  				$("#Results").html(data);
  			  });
		}
		
		function new_task_sub(){
			$.post("./../manageFunc.php",
  			  {
				new_t_sub: "true",
  			    title: $("input[name=title]").val(),
				description: $("textarea[name=description]").val(),
				status: $("input[name=status]").val(),
				hrate: $("input[name=hrate]").val(),
				pid: $("select[name=pid]").val()
  			  },
  			  function(data,status){
  				window.alert(data);
				location.reload();
  			  });
		}
		
		function displayTask(){
		
			$.post("./../manageFunc.php",
  			  {
				proj : $("select[name=pid]").val()
  			  },
  			  function(data,status){
  				$("#Results").html(data);
  			  });
		
		}
		
		function edit_proj(){
			$.post("./../manageFunc.php",
  			  {
				edit_p : "true"
  			  },
  			  function(data,status){
  				$("#Results").html(data);
  			  });
		}
		
		function edit_proj_choice(){
			$.post("./../manageFunc.php",
  			  {
				edit_p_choice : $("select[name=pid]").val()
  			  },
  			  function(data,status){
  				$("#Results").html(data);
  			  });
		
		}
		
		function edit_proj_sub(ppid){
		
			$.post("./../manageFunc.php",
  			  {
				edit_p_sub: "true",
  			    title: $("input[name=title]").val(),
				description: $("textarea[name=description]").val(),
				pid : ppid
  			  },
  			  function(data,status){
  				window.alert(data);
				location.reload();
  			  });
		
		}
		
		function edit_task(){
			$.post("./../manageFunc.php",
  			  {
				edit_t : "true"
  			  },
  			  function(data,status){
  				$("#Results").html(data);
  			  });
		}
		
		function edit_task_choice(){
			$.post("./../manageFunc.php",
  			  {
				edit_t_choice : $("select[name=pid]").val()
  			  },
  			  function(data,status){
  				$("#Results").html(data);
  			  });
		
		}
		
		function edit_task_choice2(){
			$.post("./../manageFunc.php",
  			  {
				edit_t_choice2 : $("select[name=tid]").val()
  			  },
  			  function(data,status){
  				$("#Results").html(data);
  			  });
		
		}
		
		function edit_task_sub(ttid){
		
			$.post("./../manageFunc.php",
  			  {
				edit_t_sub: "true",
				tid: ttid,
				title: $("input[name=title]").val(),
				description: $("textarea[name=description]").val(),
				hrate: $("input[name=hrate]").val(),
				pid: $("select[name=pid]").val()
  			  },
  			  function(data,status){
  				window.alert(data);
				location.reload();
  			  });
		
		}
		
		
		</script><div id="Results"></div>');






echo "</div>";
?>