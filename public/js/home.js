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
		var unita = $(this).parent().siblings('.unita').data('unita');
		var totalePartial = $(this).parent().siblings('.partial').data('partial');
		
		if (unita == 'kg') {
			if (label == 'piu')  { 
				quantita = parseFloat(quantita) + parseFloat(0.5);
			}
			else if (label == 'meno') {
				if (quantita == 0.5) {
					return false;
				}
				quantita = parseFloat(quantita) - parseFloat(0.5);
			}
			else {
				return false;
			}
		}
		else {
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
									
					if (unita == 'kg') {
						if (label == 'piu') {
							totale = parseFloat(totale) + parseFloat(response.data/2);
							totalePartial = parseFloat(totalePartial) + parseFloat(response.data/2);
						}
						else {
							totale = totale - (response.data/2);
							totalePartial = totalePartial - (response.data/2);
						}
					}
					else {
						if (label == 'piu') {
							totale = parseFloat(totale) + parseFloat(response.data);
							totalePartial = parseFloat(totalePartial) + parseFloat(response.data);
						}
						else {
							totale = totale - response.data;
							totalePartial = totalePartial - response.data;
						}
					}
					
					
					totalePartial = totalePartial.toFixed(2);
					that.parent().siblings('.partial').data('partial', totalePartial);
					that.parent().siblings('span.partial').html(totalePartial+' €');
					
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
		
		if ( $(event.target).is('a') ) { return false; }

		if (check == 1) {
			return false;
		}

		var totale = $('div.subtotal').data('totale');
		var prezzo = $(this).children().data('prezzo');
		var iva = $(this).children().data('iva');
		
		$.ajax({
			url : '/index/addProdottoLista/',
			type : 'POST',
			dataType : 'html',
			data : {
				id_prodotto : id_prodotto,
			},
			success : function(responseHtml) {
				
				totale = parseFloat(totale) + parseFloat(prezzo);
				totale = totale.toFixed(2);
				
				$('div.lista ul').prepend(responseHtml);
				
				$('div.subtotal').data('totale', totale);
				$('div.subtotal span.pull-right').html(totale+' €');
			}
		});
	});
	
	//Open the page of the producer with the modal
	$('div.prodotti').on('click', 'ul li div h3 a', function(event) {
		var id_produttore = $(this).data('id_produttore');
		$(id_produttore).modal('toggle');
	});
	
	$('.lista').on('click', 'button.paga', function(event) {
		if ($(this).hasClass('unclick')) {
			return false;
		}
		
		var that = $(this);
		var id_ordine_admin = $(this).data('id_ordine_admin');
		
		$.ajax({
			url : '/index/pagamento/',
			type : 'GET',
			dataType : 'json',
			data : {
				id_ordine_admin : id_ordine_admin,
			},
			beforeSend: function() {
				that.addClass('unclick');
			},
			success : function(response) {
				console.log(response.status);
				if (response.status == 'OK') {
					location.reload();
				}
			}
		});
		
	});
	
	// TODO POST logout
	$('div.header').on('click', 'a.logout', function(event) {
		var that = $(this);
		
		$.ajax({
			url : '/index/logout/',
			type : 'GET',
			dataType : 'json',
			success : function(response) {
				that.removeClass('unclick');
				location.reload();
			}
		});
	});
});