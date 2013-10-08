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
	
//	Chiude elemento in lista della spesa
	$('.lista').on('click', 'button.close', function(event) {
		var id_prodotto = $(this).parent().parent().data('id_prodotto');
		var id_ordine = $(this).parent().parent().data('id_ordine');
		
		$('li.item'+id_prodotto).remove();
		
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
					$('div.subtotal').data('totale', response.data);
					$('div.subtotal span.pull-right').html(response.data+' €');
				}
			}
		});
	});
	
	
//	Cambia quantit� dell'elemento selezionato nella lista
	$('.lista').on('click', 'div.quantity span', function(event) {
		var label = $(this).attr("class");
		var quantita = $(this).parent('div').data('quantita');
		var that = $(this);
		var totale = $('div.subtotal').data('totale');
		
		if (label == 'piu')  { 
			quantita = quantita + 1;
		}
		else if (label == 'meno') {
			if (quantita == 1) {
				return false;
			}
			quantita = quantita - 1;
		}
		else {
			return false;
		}
		
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
					console.log ('errore cambio quantita');
				}
				else {
					that.parent('div').data('quantita', quantita);
					that.siblings('.quantita').html(quantita);
										
					if (label == 'piu') {
						totale = parseFloat(totale) + parseFloat(response.data);
					}
					else {
						totale = totale - response.data;
					}
					
					totale = totale.toFixed(2);
					
					$('div.subtotal').data('totale', totale);
					$('div.subtotal span.pull-right').html(totale+' €');
				}
			}
		});
	});
	
	
	$('div.prodotti').on('click', 'ul li', function(event) {
		var id_prodotto = $(this).children().data('id_prodotto');
		var check = $("div.lista").find(".item"+id_prodotto).data('check');
		
		if (check == 1) {
			return false;
		}

		var totale = $('div.subtotal').data('totale');
		var prezzo = $(this).children().data('prezzo');
		
		$.ajax({
			url : '/index/addProdottoLista/',
			type : 'POST',
			dataType : 'html',
			data : {
				id_prodotto : id_prodotto,
			},
			success : function(responseHtml) {
				
				totale = totale + prezzo;
				
				$('div.lista ul').prepend(responseHtml);
				
				$('div.subtotal').data('totale', totale);
				$('div.subtotal span.pull-right').html(totale+' €');
			}
		});
	});
	
	
//	$('.lista').on('click', 'button.ordina', function(event) {
//		var id_ordine_admin = $(this).data('ordine_admin');
//		$.ajax({
//			url : '/index/pay/',
//			type : 'GET',
//			dataType : 'html',
//			data : {
//				id_ordine_admin : id_ordine_admin,
//			},
//			success : function(responseHtml) {
//			}
//		});
//	});
	
	
});