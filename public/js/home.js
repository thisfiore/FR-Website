$(document).ready(function(e) {
	
	var time = 100;

	$('.prodotti ul li').popover();

	$('.prodotti ul li')
	.on('mouseenter', function() {
		$(this).find('.image span').fadeIn(time);	
	})
	.on('mouseleave', function() {
		$(this).find('.image span').fadeOut(time);
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
					$('div.subtotal span.pull-right').html(response.data+' €');
					
					console.log(totale);
					// prodotto eliminato correttamente
				}
			}
		});
	});
	
	
	
	$('.lista').on('click', 'div.quantity span', function(event) {
		var label = $(this).attr("class");
		var quantita = $(this).parent().data('quantita');
		var that = this;
		
		if (label == 'piu')  {
			quantita = quantita + 1;
		}
		else if (label == 'meno') {
			quantita = quantita - 1;
		}
		else {
			return false;
		}
		console.log(label);
		console.log(quantita);
		
		var id_prodotto = $(this).parents('li').data('id_prodotto');
		var id_ordine = $(this).parents('li').data('id_ordine');
		
		$.ajax({
			url : '/ordine/cambioQuantita/',
			type : 'POST',
			dataType : 'json',
			data : {
				id_prodotto : id_prodotto,
				id_ordine : id_ordine,
				quantita : quantita
			},
			success : function(response) {
				
				if (response.status == 'ERR') {
					console.log ('errore delete prodotto dalla lista spesa');
				}
				else {
					$(that).parent().attr('data-quantita', quantita);
					$(that).siblings( ".quantita" ).html(quantita);
					
					// prodotto eliminato correttamente
				}
			}
		});
		
		console.log(label);
	});
	
	
	
	
});