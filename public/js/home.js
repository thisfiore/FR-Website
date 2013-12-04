$(document).ready(function(e) {
	
	$('#polli').modal('show');

	$('.showmore').on('click', function() {
		$(this).parent().next('.hide').toggle(100);
		$(this).text(function(i, text){
			return text === "Scopri" ? "Chiudi" : "Scopri";
		});
	});

	$('.like').on('click', function() {
		if ( $(this).hasClass('liked') ) {} else {
			var nLike = $(this).find('span').text();
			nLike ++;
			$(this).find('span')
				.animate({
					fontSize: '500px'
				}, 100)
				.animate({
					fontSize: '28px'
				}, 100);
			$(this).find('span').text(nLike);
			$(this).addClass('liked');
			
			var id_prodotto = $(this).data('id_prodotto');
			
			$.ajax({
				url : '/index/likeProdotto/',
				type : 'POST',
				dataType : 'json',
				data : {
					id_prodotto : id_prodotto,
				},
				success : function(response) {
					if (response.status == 'ERR') {
						console.log ('LIKE prodotto non aggiornato');
					}
				}
			});
			
		}
	});
	
	
	$('.actionLista').on('click', function() {
		var id_prodotto = $(this).parent().siblings('.social').children('.like').data('id_prodotto');
		var news = 1;
		
		$.ajax({
			url : '/index/addProdottoLista/',
			type : 'POST',
			dataType : 'json',
			data : {
				id_prodotto : id_prodotto,
				news : news,
			},
			success : function(response) {
			}
		});
	});
	

	$('.cassa').on('click', function() {
		$(this).find('ul').toggle(100);
		$(this).find('.interaction').toggleClass('active');
	});

	var time = 100;

	$('.prodotti ul li').popover();

	$('.prodotti ul li')
	.on('mouseenter', function() {
		if ($(this).hasClass('end')) { return false; }
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
		$('div.prodotto'+id_prodotto).parents('li').removeClass('end');
		
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
		var id_prodotto = $(this).parents('li').data('id_prodotto');
		var id_ordine = $(this).parents('li').data('id_ordine');
		
		var arr = [33, 34, 35, 36, 36, 37, 38, 39, 40, 41, 42, 43, 44];
		if (jQuery.inArray( id_prodotto, arr) > -1){
			return false;
		}
		
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
	
//	Add Prodotto Lista
	$('div.prodotti').on('click', 'ul li', function(event) {
		var id_prodotto = $(this).children('div.prodotto').data('id_prodotto');
		var check = $("div.lista").find(".item"+id_prodotto).data('check');
		
		if ( $(event.target).is('a') ) { return false; }

		if (check == 1 || $(this).hasClass('end')) {
			return false;
		}

		var arr = [33, 34, 35, 36, 36, 37, 38, 39, 40, 41, 42, 43, 44];
		if (jQuery.inArray( id_prodotto, arr) > -1){
			$('div.prodotto'+id_prodotto).parent('li').addClass('end');
		}
		
		var totale = $('div.subtotal').data('totale');
		var prezzo = $(this).children('div.prodotto').data('prezzo');
		var iva = $(this).children('div.prodotto').data('iva');
		var unita = $(this).children('div.prodotto').data('unita');
		
		$.ajax({
			url : '/index/addProdottoLista/',
			type : 'POST',
			dataType : 'html',
			data : {
				id_prodotto : id_prodotto,
			},
			success : function(responseHtml) {
				
				if (unita == 'kg') {
					totale = parseFloat(totale) + parseFloat(prezzo*0.5);
					totale = totale.toFixed(2);
				}
				else {
					totale = parseFloat(totale) + parseFloat(prezzo);
					totale = totale.toFixed(2);
				}
				
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
	
	
	//Chiude l'ordine con il pagamento alla consegna
	$('.lista').on('click', 'button.paga', function(event) {
		
//		if ($(this).hasClass('unclick') || !check) {
//			return false;
//		}
		
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
	
	//Abilita il bottone conferma termini solo se entrambi i radio sono checkati
	$('#termini').on('click', 'input', function(event) {
		var classe = $(this).attr('class');
		if (classe == "radioCondizioni") {
			$('#termini input.radioCondizioni').removeClass('checked');
			$(this).addClass('checked');
		}
		else {
			$('#termini input.radioTermini').removeClass('checked');
			$(this).addClass('checked');
		}
		
		if ($(this).hasClass('radioCondizioni') || $(this).hasClass('radioTermini')) {
			
			var term = Number($('#termini input.radioCondizioni.checked').data('value'));
			var cond = Number($('#termini input.radioTermini.checked').data('value'));
			var tot = (term+cond);
			
			if ( tot == 2) {
				$('#termini button.btn-success').removeClass('disabled');
			}
			else {
				if ($('#termini button.btn-success').hasClass('disabled')) {
				}
				else {
					$('#termini button.btn-success').addClass('disabled');
				}
			}
		}
	});
	
	//Invio conferma termini e servizi
	$('#termini').on('click', 'button.btn-success', function(event) {
		if ($(this).hasClass('disabled') || $(this).data('term') == 1) {
			return false;
		}
		
		if ($('#termini').hasClass('fromhome')) {
			var id_ordine_admin = $('#termini').data('id_ordine_admin');
		}
		else {
			var id_ordine_admin = 0;
		}
		
		$.ajax({
			url : '/index/acceptTerm/',
			type : 'POST',
			data : {
				id_ordine_admin : id_ordine_admin,
			},
			dataType : 'json',
			success : function(response) {
				if (response.status = "OK") {
					window.location.href = response.redirect;
				}
				else {
					console.log('errore update term');
				}
			}
		});
	});
	
	//Chiude la lista della spesa e passa alla schermata di pagamento
	$('div.lista').on('click', 'button.btn-success', function(event) {
		var id_ordine_admin = $(this).data('id_ordine_admin');
	
		var check = $('.lista ul li').data('id_ordine');
		if (!check) {
			return false;
		}
		
		$.ajax({
			url : '/index/checkOrdine/',
			type : 'POST',
			data : {
				id_ordine_admin : id_ordine_admin,
			},
			dataType : 'json',
			success : function(response) {
				if (response.status == "OK") {
					window.location.href = '/index/pay/'+id_ordine_admin;
				}
				else if (response.status == "ERR"){
					$('#termini').addClass('fromhome');
					$('#termini').modal('show');
				}
				else if (response.status == "NOLISTA") {
					
					$('div.errormsg span').text(response.message);
					$('div.errormsg').removeClass('hide');
					
					$('li.item'+response.id).children().removeClass('alert-success');
					$('li.item'+response.id).children().addClass('alert-error');
					
					setTimeout(function() {
						$('div.errormsg').addClass('hide');
				    }, 15000);
				}
			}
		});
	});
	
	
	//Apertura modal cassetta
	$('div.lista').on('click', 'li.cassetta', function(event) {
		
		if ($(event.target).is('div button.close')) {
			return false;   
		}
		
		var id_ordine_utente = $(this).data('id_ordine');
		var id_prodotto = $(this).data('id_prodotto');
		
		$.ajax({
			url : '/index/modalCassetta/',
			type : 'GET',
			data : {
				id_ordine_utente : id_ordine_utente,
				id_prodotto : id_prodotto
			},
			dataType : 'html',
			success : function(responseHtml) {
				$('#modal-cassetta').empty().append(responseHtml);
				$('#modal-cassetta').modal('show');
			}
		});
	});

	//Articolo nella cassetta viene rimosso
	$('#modal-cassetta').on('click', 'button.remove-article', function(event) {
		var elementi = $("li.prodotto").length;
		var disabled = $("button.remove-article.active").length;
		 
//		Controllo che rimanga almeno un elemento
		var control = elementi - disabled;
		if (control == 1 && !$(this).hasClass('active')) {
			return false;
		}
		
//		Grafica opacizzazione e attiva/disattiva
		$(this).parent().prev().toggleClass('disabled');
		$(this).toggleClass('active');
		
		var resto = $(this).parents('ul').data('resto');
		var id_prodotto = $(this).parents('li').data("id_prodotto");
		var id_ordine_utente = $(this).parents('ul').data("id_ordine_utente");
		var id_cassetta = $(this).parents('ul').data("id_cassetta");
		var stato = null;
		var check = 0;
		
		if ($(this).hasClass('active')) {
			$(this).parents('ul').data('resto', (resto+1) );
			stato = 0;
		
			$('.preference-article').each(function( index ) {
//				Tutti i bottoni rossi no active
				if ($(this).hasClass('hide') && !$(this).siblings('.remove-article').hasClass('active')) {
					if ($(this).hasClass('hide')) {
						$(this).removeClass('hide');
					}
				}
//				Bottone clikkato
				else if ($(this).siblings('.remove-article').hasClass('active')) {
					if (!$(this).hasClass('hide')) {
						$(this).addClass('hide');
					}
				}
			});
		}
		else {
			$(this).parents('ul').data('resto', (resto-1) );
			stato = 1;
		
			if (resto == 1){ 
				$('.preference-article').each(function( index ) {
					if (!$(this).hasClass('hide')) {
						$(this).addClass('hide');
					}
					
					$(this).removeClass('active');
					
					$(this).siblings('.remove-article').removeClass('active');
					$(this).siblings('.remove-article').removeClass('hide');
				});
				check = 1;
			} else {

				$('.preference-article').each(function( index ) {
					if (!$(this).siblings('.remove-article').hasClass('active') && !$(this).hasClass('active')) {
						$(this).removeClass('hide');	
					}
				});
				
			}
		}
		
		$.ajax({
			url : '/cassetta/updateCassetta/',
			type : 'POST',
			data : {
				id_ordine_utente : id_ordine_utente,
				id_cassetta : id_cassetta,
				id_prodotto : id_prodotto,
				stato : stato,
				check :check,
			},
			dataType : 'json',
			success : function(response) {
//				Da fare qualcosa al success???
			}
		});
	});

	
	//Esprimi preferenza
	$('#modal-cassetta').on('click', 'button.preference-article', function(event) {
		$(this).toggleClass('active');
		
		var resto = $(this).parents('ul').data('resto');
		var id_prodotto = $(this).parents('li').data("id_prodotto");
		var id_ordine_utente = $(this).parents('ul').data("id_ordine_utente");
		var id_cassetta = $(this).parents('ul').data("id_cassetta");
		var pref = null;
		
		if ($(this).hasClass('active')) {
//			$(this).parents('ul').data('resto', (resto-1) );
			
			$(this).siblings('.remove-article').removeClass('active');
			$(this).siblings('.remove-article').addClass('hide');
			
			pref = 1;
		}
		else {
//			$(this).parents('ul').data('resto', (resto+1) );
			
			$(this).siblings('.remove-article').removeClass('hide');
			
			pref = 0;
		}
		
		$.ajax({
			url : '/cassetta/updateCassetta/',
			type : 'POST',
			data : {
				id_ordine_utente : id_ordine_utente,
				id_cassetta : id_cassetta,
				id_prodotto : id_prodotto,
				pref : pref,
			},
			dataType : 'json',
			success : function(response) {
				console.log(response);
			}
		});
	});
	
	$('body').on('click', '.tohome', function(event) {
		$(window.location).attr('href', '/index/index/1');
	});
	
	
});