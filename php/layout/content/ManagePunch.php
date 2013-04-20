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
				addDatePick($("input[name=time_ind]"));
				addDatePick($("input[name=time_outd]"));
  			  });
		
		}
		
		function validate_new_p(){
			if(checkFormatNew()){
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
		
		}
		
		function delete_punch(){
		
			$("#Message").html("<p></p>");
			$.post("./../punchManFunc.php",
  			  {
  			    del_p: "del"
  			  },
  			  function(data,status){
  				$("#Results").html(data);
				addDatePick($("input[name=time_in]"));
				addDatePick($("input[name=time_out]"));
  			  });
		
		}
		
		function validate_del_p(){
			if(checkFormatDel()){
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
		}
		
		function conf_del_p(){
			if (checkFormatRadio()){
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
			}
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
				addDatePick($("input[name=time_in]"));
				addDatePick($("input[name=time_out]"));
  			  });
		}
		
		function validate_edit_p(){
		
			if(checkFormatDel()){
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
		}
		
		function conf_edit_p(){
			if (checkFormatRadio()){
			$.post("./../punchManFunc.php",
  				  {
  				    edit_p_conf2: "edit",
					punch_id: $("input:radio[name=punch_id]:checked").val()
  				  },
  				  function(data,status){
  					$("#Results").html(data);
					addDatePick($("input[name=time_in]"));
					addDatePick($("input[name=time_out]"));
  				  });
			}
		}
		
		function conf2_edit_p(id){
			if(checkFormatDel()){
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
		}
		
		function checkFormatNew(){
			var date1 = $("input[name=time_ind]").val();
			var date2 = $("input[name=time_outd]").val();
			var regexpDate = new RegExp("[0-9]{4}-(1[0-2]|0[1-9])-(3[0-1]|2[0-9]|1[0-9]|0[1-9])");
			var regexpTime = new RegExp("([0-1][0-9]|2[0-4]):[0-5][0-9]:[0-5][0-9]");
			if( !regexpDate.test(date1)){
				$("#Message").html("<p>***** Please use the following format for the TIME IN DATE input field: yyyy-mm-dd *****</p>");
				return false;
			}
			if( !regexpDate.test(date2)){
				$("#Message").html("<p>***** Please use the following format for the TIME OUT DATE input field: yyyy-mm-dd *****</p>");
				return false;
			}
			var time1 = $("input[name=time_inh]").val();
			var time2 = $("input[name=time_outh]").val();
			if( !regexpTime.test(time1)){
				$("#Message").html("<p>***** Please use the following format for the TIME IN HOUR input field: hh:mm:ss *****</p>");
				return false;
			}
			if( !regexpTime.test(time2)){
				$("#Message").html("<p>***** Please use the following format for the TIME OUT HOUR input field: hh:mm:ss *****</p>");
				return false;
			}
			$("#Message").html("<p></p>");
			return true;
	}
		
		function checkFormatDel(){
			var date1 = $("input[name=time_in]").val();
			var date2 = $("input[name=time_out]").val();
			var regexpDate = new RegExp("[0-9]{4}-(1[0-2]|0[1-9])-(3[0-1]|2[0-9]|1[0-9]|0[1-9])");
			if( !regexpDate.test(date1)){
				$("#Message").html("<p>***** Please use the following format for the TIME IN input field: yyyy-mm-dd *****</p>");
				return false;
			}
			if( !regexpDate.test(date2)){
				$("#Message").html("<p>***** Please use the following format for the TIME OUT input field: yyyy-mm-dd *****</p>");
				return false;
			}
			$("#Message").html("<p></p>");
			return true;
		}
		
		function checkFormatRadio(){
		
			if ($("input[name=punch_id]:checked").length == 0) {
    			$("#Message").html("<p>***** Please select a radio button *****</p>");
				return false;
			}
			$("#Message").html("<p></p>");
			return true;
		
		}


</script>
<div id="Message"></div>
<div id="Results"></div>');