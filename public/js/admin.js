$(document).ready(function(e) {
	
//	Cambio il tipo di admin: produttori o gruppi
	$('.header').on('click', 'button.selector', function(event) {
		var that = $(this);
		var id_ordine_admin = that.data('id_ordine_admin');
		
		if (that.hasClass('btn-primary')) {
			return false;
		}
		else {
			$('button.selector').removeClass('btn-primary');
			that.addClass('btn-primary');
		}
		
		if (that.data('switch') == 'adminGruppi') {
			$.ajax({
				url : '/admin/adminGruppi/',
				type : 'POST',
				dataType : 'html',
				data : {
					id_ordine_admin: id_ordine_admin
				},
				success : function(responseHtml) {
					$('div.content').empty().append(responseHtml);
				}
			});
		}
		else {
			$.ajax({
				url : '/admin/index/',
				type : 'GET',
				dataType : 'html',
				data : {
					id_ordine_admin: id_ordine_admin
				},
				success : function(responseHtml) {
					$('div.content').empty().append(responseHtml);
				}
			});
		}
	});
	
	
//	Cambio l'ordine da visualizzare l'admin
	$('.selectpicker').change(function(event){
		
		$( "select option:selected" ).each(function() {
			id_ordine_admin = $( this ).val();
			$('button.selector').data('id_ordine_admin', id_ordine_admin);
		});
//		var id_ordine_admin = $(this).children().val();
		
		
		if ($('button.btn-primary').data('switch') == 'adminGruppi') {
			$.ajax({
				url : '/admin/adminGruppi/',
				type : 'POST',
				dataType : 'html',
				data : {
					id_ordine_admin : id_ordine_admin
				},
				success : function(responseHtml) {
					$('div.content').empty().append(responseHtml);
				}
			});
		}
		else {
			$.ajax({
				url : '/admin/index/',
				type : 'GET',
				dataType : 'html',
				data : {
					id_ordine_admin : id_ordine_admin
				},
				success : function(responseHtml) {
					$('div.content').empty().append(responseHtml);
				}
			});
		}
	});
	
//	Bottone apri modal e chiudi l'ordine
	$('.header').on('click', 'button.order-admin', function(event) {
		var stato = $(this).data('value');
		
		if (stato == 1) {
			$('#modal-admin').modal('show');
		}
		else {
			$.ajax({
				url : '/admin/openOrderAdmin/',
				type : 'POST',
				dataType : 'json',
				data : {
					stato : stato
				},
				success : function(response) {
					if (response.status == 'OK') {
						window.location.reload();
					}
				}
			});
		}
	});
	
	$('.tck').on('focus', function() {
		$(this).parent('.control-group').removeClass('error');
		$(this).next('span').hide(200);
	});
	
	$('#modal-admin').on('click', 'button.submit', function(event){
		
		if ($('#markup').val() == '') {
			$("#markup").parent('.control-group').addClass('error');
			$("#markup").next('span').text('Inserisci un numero').show(200);
			return false;
		}
		
		if ($('#data').val() == '') {
			$("#data").parent('.control-group').addClass('error');
			$("#data").next('span').text('Inserisci una data').show(200);
			return false;
		}
		
		var stato = 1;
		var markup = $('#markup').val();
		var data_consegna = $('#data').val();
		
		$.ajax({
			url : '/admin/openOrderAdmin/',
			type : 'POST',
			dataType : 'json',
			data : {
				stato : stato,
				data_consegna : data_consegna,
				markup : markup,
			},
			success : function(response) {
				if (response.status == 'OK') {
					$('#modal-admin').modal('hide');
					window.location.reload();
				}
				else {
					alert(response.message);
				}
			}
		});
	});
	
//	Bottone apri parte relativa al DB
	$('.header').on('click', 'button.buttondb', function(event) {
		
		$.ajax({
			url : '/admin/tabelleDb/',
			type : 'GET',
			dataType : 'html',
			data : {
			},
			success : function(responseHtml) {
				$('div.content').empty().append(responseHtml);
			}
		});
		
	});
	
//	Mostra la tabella selezionata
	$('div.content').on('click', 'ul.nav li', function(event) {
		if ($(this).hasClass('active')) {
			console.log('here active');
			return false;
		}
		
		$('ul.nav li').removeClass('active');
		$(this).addClass('active');
		
		var url = '/admin/tab'+$(this).data('select')+'/';
		
		$.ajax({
			url : url,
			type : 'GET',
			dataType : 'html',
			data : {
			},
			success : function(responseHtml) {
				$('div.tabsDb').empty().append(responseHtml);
			}
		});
	});

	
//	Fa l'update di tutti i campi e tabelle in base a capo della tabella e tabella stessa
	$('.content').on('change', '.target', function(event) {
		
		var select = $(this).parents('table').data('select').charAt(0).toUpperCase() + $(this).parents('table').data('select').slice(1);
		var url = '/admin/update'+select+'/';
		var field = $(this).parents('td').data('field');
		var id = $(this).parents('tr').data('id');
		var value = $(this).val();
		
		console.log(value);
		
		if (!value) {
			 var checked = $(this).attr('checked');
			 console.log(checked);
			if (checked == 'checked') {
				value = 0;
				$(this).attr('checked', 'other');
			}
			else {
				value = 1;
				$(this).attr('checked', 'checked');
			}
		}
		
		console.log(value);
		
//		$.ajax({
//			url : url,
//			type : 'POST',
//			dataType : 'json',
//			data : {
//				field : field,
//				value : value,
//				id : id,
//			},
//			success : function(response) {
//				if (response.status == 'OK') {
//					 $('.content').find('.status').html('Saved').fadeIn().delay(800).fadeOut();
//				}
//				else {
//					alert(response.message);
//					window.location.reload();
//				}
//			}
//		});
	});
	
//	Add row in table
	$('div.content').on('click', 'ul.nav li span', function(event) {
		if (!$(this).parents('li').hasClass('active')) {
			
//			$('ul.nav li').removeClass('active');
//			$(this).parents('li').addClass('active');
//			var url = '/admin/tab'+$(this).parents('li').data('select')+'/';
//			$.ajax({
//				url : url,
//				type : 'GET',
//				dataType : 'html',
//				data : {
//				},
//				success : function(responseHtml) {
//					$('div.tabsDb').empty().append(responseHtml);
//				}
//			});
			
			console.log('here no active');
			return false;
		}
		
		var label = $(this).parents('li').data('select');
		
		$.ajax({
			url : '/admin/insertRowDb/',
			type : 'POST',
			dataType : 'html',
			data : {
				label : label,
			},
			success : function(responseHtml) {
				$('table.table > tbody > tr').eq(0).after(responseHtml);
			}
		});
	});
	
});