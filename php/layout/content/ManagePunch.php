<?php

printf('<div class="menu2"><ul class="man">
<li class="man"><div class="man" onclick="new_punch()">New Punch</div></li>
<li class="man"><div class="man" onclick="delete_punch()">Delete Punch</div></li>
<li class="man"><div class="man" onclick="edit_punch()">Edit Punch</div></li>
</ul></div><br><br>');

printf('<script>

		function new_punch(){
		
			$("#Message").html("<p></p>");
			$.post("./../punchManFunc.php",
  			  {
  			    new_p: "new"
  			  },
  			  function(data,status){
  				$("#Results").html(data);
  			  });
		
		}
		
		function validate_new_p(){
		
			$.post("./../punchManFunc.php",
  			  {
  			    new_p_conf: "new",
				time_ind: $("input[name=time_ind]").val(),
				time_outd: $("input[name=time_outd]").val(),
				time_inh: $("input[name=time_inh]").val(),
				time_outh: $("input[name=time_outh]").val(),
				tid: $("select[name=tid]").val(),
				uid: $("select[name=uid]").val()
  			  },
  			  function(data,status){
  				window.alert(data);
				location.reload();
  			  });
		
		}
		
		function delete_punch(){
		
			$("#Message").html("<p></p>");
			$.post("./../punchManFunc.php",
  			  {
  			    del_p: "del"
  			  },
  			  function(data,status){
  				$("#Results").html(data);
  			  });
		
		}
		
		function validate_del_p(){
		
			$.post("./../punchManFunc.php",
  			  {
  			    del_p_conf: "del",
				time_in: $("input[name=time_in]").val(),
				time_out: $("input[name=time_out]").val(),
				tid: $("select[name=tid]").val(),
				uid: $("select[name=uid]").val()
  			  },
  			  function(data,status){
  				$("#Results").html(data);
  			  });
		
		}
		
		function conf_del_p(){
			var answer = confirm("Are you sure you want to delete this punch?");
			if(answer){
				$.post("./../punchManFunc.php",
  				  {
  				    del_p_sub: "del",
					punch_id: $("input:radio[name=punch_id]:checked").val()
  				  },
  				  function(data,status){
  					window.alert(data);
					location.reload();
  				  });
			}else{
				location.reload();
			}
		
		}
		
		function edit_punch(){
		
			$("#Message").html("<p></p>");
			$.post("./../punchManFunc.php",
  			  {
  			    edit_p: "edit"
  			  },
  			  function(data,status){
  				$("#Results").html(data);
  			  });
		}
		
		function validate_edit_p(){
		
			$.post("./../punchManFunc.php",
  			  {
  			    edit_p_conf: "edit",
				time_in: $("input[name=time_in]").val(),
				time_out: $("input[name=time_out]").val(),
				tid: $("select[name=tid]").val(),
				uid: $("select[name=uid]").val()
  			  },
  			  function(data,status){
  				$("#Results").html(data);
  			  });
		
		}
		
		function conf_edit_p(){
		
			$.post("./../punchManFunc.php",
  				  {
  				    edit_p_conf2: "edit",
					punch_id: $("input:radio[name=punch_id]:checked").val()
  				  },
  				  function(data,status){
  					$("#Results").html(data);
  				  });
		}
		
		function conf2_edit_p(id){
		
			$.post("./../punchManFunc.php",
  				  {
  				    edit_p_sub: "edit",
					time_in: $("input[name=time_in]").val(),
					time_out: $("input[name=time_out]").val(),
					tid: $("select[name=tid]").val(),
					punch_id: id
  				  },
  				  function(data,status){
  					window.alert(data);
					location.reload();
  				  });
		}


</script>
<div id="Message"></div>
<div id="Results"></div>');