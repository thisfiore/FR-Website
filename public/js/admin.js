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
	
//	Bottone apri e chiudi l'ordine
	$('.header').on('click', 'button.order-admin', function(event){
		var stato = $(this).data('value');
		
		$.ajax({
			url : '/admin/openOrderAdmin/',
			type : 'GET',
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
	});
	
	
	
});