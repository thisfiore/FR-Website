$(document).ready(function(e) {
	
	$('#submit').click(function(event) {
		event.preventDefault();
		
		$('form.login').ajaxForm({
			url : '/index/login/',
			type : 'POST',
			dataType : 'json',
			beforeSubmit : function() {
				if ($('#username').val() == '') {
					$('#username').css({'border':'red 2px solid'});
					return false;
				}
				
				if ($('#password').val() == '') {
					$('#password').css({'border':'red 2px solid'});
					return false;
				}
			},
			success : function(response) {
				console.log(response);
				if (response.status == 'OK') {
					window.location.href = '/index/';
				}
				else {
					alert('Username o Password incorretti');
				}
			}
		}).submit();
	});
	
});