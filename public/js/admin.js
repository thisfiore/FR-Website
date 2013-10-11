$(document).ready(function(e) {
	
	
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
	
	$('.selectpicker').change(function(event){
		
		$( "select option:selected" ).each(function() {
			id_ordine_admin = $( this ).val();
			$('button.selector').data('id_ordine_admin', id_ordine_admin);
		});
//		var id_ordine_admin = $(this).children().val();
		
		console.log(id_ordine_admin);
		
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
	
	
	
});