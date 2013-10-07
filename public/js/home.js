$(document).ready(function(e) {
	
	var time = 100;

	$('.prodotti ul li')
	.on('mouseenter', function() {
		$(this).find('.image span').fadeIn(time);
	})
	.on('mouseleave', function() {
		$(this).find('.image span').fadeOut(time);
	});
	
});