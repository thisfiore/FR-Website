$(document).ready(function(e) {
	
	var time = 100;

	$('.prodotti ul li')
	.on('mouseenter', function() {
		$(this).find('.image span').fadeIn(time);
		$(this).find('.desc').show(time);
	})
	.on('mouseleave', function() {
		$(this).find('.image span').fadeOut(time);
		$(this).find('.desc').hide(time);
	});
	
});