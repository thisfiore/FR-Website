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
	
	
	
});