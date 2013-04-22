<?php
printf('<div class="menu2"><ul class="man">
<li class="man"><div class="man" onclick="new_user()">New User</div></li>
<li class="man"><div class="man" onclick="delete_user()">Delete User</div></li>
<li class="man"><div class="man" onclick="edit_user()">Edit User</div></li>
</ul></div><br><br>');

printf('
<script>

		function new_user(){
		
			$("#Message").html("<p></p>");
			$.post("./../userManFunc.php",
  			  {
  			    new_u: "new"
  			  },
  			  function(data,status){
  				$("#Results").html(data);
  			  });
		
		}
		
		function new_user_type(){
		
			$("#Message").html("<p></p>");
			$.post("./../userManFunc.php",
  			  {
  			    new_u_type: "new_type",
				type: $("select[name=type]").val()
  			  },
  			  function(data,status){
  				$("#Results").html(data);
  			  });
		
		}
		
		function new_user_sub(){
			$("#Message").html("<p></p>");
			if(checkFormatNew()){
				if($("input[name=type]").val() == "client"){
				$.post("./../userManFunc.php",
  				  {
  				    new_u_conf: "new_type_conf",
					type: $("input[name=type]").val(),
					cname: $("input[name=cname]").val(),
					username: $("input[name=username]").val(),
					password: $("input[name=password]").val(),
					phone: $("input[name=phone]").val(),
					email: $("input[name=email]").val()
  				  },
  				  function(data,status){
  					window.alert(data);
					location.reload();
  				  });
				}else{
			
					$.post("./../userManFunc.php",
  				  {
  				    new_u_conf: "new_type_conf",
					type: $("input[name=type]").val(),
					fname: $("input[name=fname]").val(),
					lname: $("input[name=lname]").val(),
					username: $("input[name=username]").val(),
					password: $("input[name=password]").val(),
					phone: $("input[name=phone]").val(),
					email: $("input[name=email]").val()
  				  },
  				  function(data,status){
  					window.alert(data);
					location.reload();
  				  });
				}
			}
		
		}
		
		function delete_user(){
		
			$("#Message").html("<p></p>");
			$.post("./../userManFunc.php",
  			  {
  			    del_u: "del"
  			  },
  			  function(data,status){
  				$("#Results").html(data);
  			  });
		
		}
		
		function del_conf(){
		
			$("#Message").html("<p></p>");
			var answer = confirm("Are you sure you want to delete this user? Doing so will result in deleting all the information associated with this user and cannot be undone.");
			if(answer){
			$.post("./../userManFunc.php",
  			  {
  			    del_conf: "del",
				uid: $("select[name=uid]").val()
  			  },
  			  function(data,status){
  				window.alert(data);
				location.reload();
  			  });
			}
		
		}
		
		function edit_user(){
		
			$("#Message").html("<p></p>");
			$.post("./../userManFunc.php",
  			  {
  			    edit_u: "edit"
  			  },
  			  function(data,status){
  				$("#Results").html(data);
  			  });
		
		}
		
		function edit_conf(){
		
			$("#Message").html("<p></p>");
			$.post("./../userManFunc.php",
  			  {
  			    edit_conf: "del",
				uid: $("select[name=uid]").val()
  			  },
  			  function(data,status){
  				$("#Results").html(data);
  			  });
		
		}
		
		function edit_user_sub(){
		
			$("#Message").html("<p></p>");
			if(checkFormatNew()){
			if($("input[name=type]").val() == "client"){
			$.post("./../userManFunc.php",
  			  {
  			    edit_u_sub: "edit_u_sub",
				uid: $("input[name=uid]").val(),
				type: $("input[name=type]").val(),
				cname: $("input[name=cname]").val(),
				username: $("input[name=username]").val(),
				phone: $("input[name=phone]").val(),
				email: $("input[name=email]").val()
  			  },
  			  function(data,status){
  				window.alert(data);
				location.reload();
  			  });
			}else{
		
				$.post("./../userManFunc.php",
  			  {
  			    edit_u_sub: "edit_u_sub",
				type: $("input[name=type]").val(),
				uid: $("input[name=uid]").val(),
				fname: $("input[name=fname]").val(),
				lname: $("input[name=lname]").val(),
				username: $("input[name=username]").val(),
				phone: $("input[name=phone]").val(),
				email: $("input[name=email]").val()
  			  },
  			  function(data,status){
  				window.alert(data);
				location.reload();
  			  });
			}
			}
		
		}
		
		function change_pwd(){
		
			$("#Message").html("<p></p>");
			$.post("./../userManFunc.php",
  			  {
  			    change_pwd: "pwd",
				uid: $("input[name=uid]").val()
  			  },
  			  function(data,status){
  				$("#Results").html(data);
  			  });
		
		}
		
		function change_pwd_sub(){
		
			$("#Message").html("<p></p>");
			if(checkFormatPassword()){
			$.post("./../userManFunc.php",
  			  {
  			    change_pwd_sub: "pwd",
				uid: $("input[name=uid]").val(),
				old_pwd: $("input[name=old_password]").val(),
				new_pwd: $("input[name=new_password]").val()
  			  },
  			  function(data,status){
  				window.alert(data);
				location.reload();
  			  });
			}
		
		}
		
		function checkEmpty(el){
		
			var notEmp = new RegExp("[a-z]|[0-9]", "i");
			if( notEmp.test(el)){
				return false;
			}
			else{
				return true;
			}
		
		}
		
		
		
		function checkFormatNew(){
			if( checkEmpty($("input[name=cname]").val())){
				$("#Message").html("<p>***** Please enter a value in the NAME field *****</p>");
				return false;
			}
			if( checkEmpty($("input[name=lname]").val())){
				$("#Message").html("<p>***** Please enter a value in the LAST NAME field *****</p>");
				return false;
			}
			if( checkEmpty($("input[name=fname]").val())){
				$("#Message").html("<p>***** Please enter a value in the FIRST NAME field *****</p>");
				return false;
			}
			if( checkEmpty($("input[name=username]").val())){
				$("#Message").html("<p>***** Please enter a value in the USERNAME field *****</p>");
				return false;
			}
			if( checkEmpty($("input[name=phone]").val())){
				$("#Message").html("<p>***** Please enter a value in the PHONE field *****</p>");
				return false;
			}
			if( checkEmpty($("input[name=email]").val())){
				$("#Message").html("<p>***** Please enter a value in the E_MAIL field *****</p>");
				return false;
			}
			if( $("input[name=password]").val() != $("input[name=password2]").val()){
				$("#Message").html("<p>***** The two passwords are not the same *****</p>");
				return false;
			}
			$("#Message").html("<p></p>");
			return true;
		
		
		}
		
		function checkFormatNew(){
			if( checkEmpty($("input[name=cname]").val())){
				$("#Message").html("<p>***** Please enter a value in the NAME field *****</p>");
				return false;
			}
			if( checkEmpty($("input[name=lname]").val())){
				$("#Message").html("<p>***** Please enter a value in the LAST NAME field *****</p>");
				return false;
			}
			if( checkEmpty($("input[name=fname]").val())){
				$("#Message").html("<p>***** Please enter a value in the FIRST NAME field *****</p>");
				return false;
			}
			if( checkEmpty($("input[name=username]").val())){
				$("#Message").html("<p>***** Please enter a value in the USERNAME field *****</p>");
				return false;
			}
			if( checkEmpty($("input[name=phone]").val())){
				$("#Message").html("<p>***** Please enter a value in the PHONE field *****</p>");
				return false;
			}
			if( checkEmpty($("input[name=email]").val())){
				$("#Message").html("<p>***** Please enter a value in the E_MAIL field *****</p>");
				return false;
			}
			if( !checkFormatPassword()){
				return false;
			}
			$("#Message").html("<p></p>");
			return true;
		
		
		}
		
		function checkFormatPassword(){
			if( $("input[name=password]").val() != $("input[name=password2]").val()){
				$("#Message").html("<p>***** The two passwords are not the same *****</p>");
				return false;
			}
			$("#Message").html("<p></p>");
			return true;
		
		}
		


</script>
<div id="Message"></div>
<div id="Results"></div>');