$(document).ready(function(){
	$.easing.def = "easeOutBounce";
	$('li.clickable a').click(function(e) {
		var dropdown = $(this).parent().next();
		dropdown.slideToggle('slow');
		e.preventDefault();
	});
});


function redirect () {
	location.href = 'CheckingOut.php';
}


