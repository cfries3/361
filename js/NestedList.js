$(document).ready(function(){
	$.easing.def = "easeOutBounce";
	$('li.clickable a').click(function(e) {
		var dropdown = $(this).parent().next();
/*		if (dropdown.className.match(/\btask\b/)) {
			$('.dropdown').not(dropdown, '.project').slideUp('slow');
		} else {
			$('.dropdown').not(dropdown).slideUp('slow');
		}*/
		dropdown.slideToggle('slow');
		e.preventDefault();
	});
});

