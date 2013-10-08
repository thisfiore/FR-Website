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
	
	
	$('.lista').on('click', 'button.close', function(event) {
		var id_prodotto = $(this).parent().parent().data('id_prodotto');
		var id_ordine = $(this).parent().parent().data('id_ordine');
		
		$.ajax({
			url : '/ordine/deleteCellaLista/',
			type : 'POST',
			dataType : 'json',
			data : {
				id_prodotto : id_prodotto,
				id_ordine : id_ordine
			},
			success : function(response) {
				
				if (response.status == 'ERR') {
					console.log ('errore delete prodotto dalla lista spesa');
				}
				else {
					
					$('div.subtotal').attr('data-totale', response.data);
					$('div.subtotal').html(response.data+' €');
					
					console.log(totale);
					// prodotto eliminato correttamente
				}
			}
		});
	});
	
	$('.lista').on('click', 'div.quantity span', function(event) {
		var label = $(this).attr("class");
		console.log(label);
		
	});
	
	
	
	
});