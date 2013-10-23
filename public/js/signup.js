$(document).ready(function(e) {
	
//	Elimino il bordo rosso dai campi che sto modificando che mi avevano dato un errore
	$('.tck').keyup(function() {

		$(this).parent('.control-group').removeClass('error');
		$(this).next('span').hide(50);
		
		if ($(this).attr('type') == 'password' ) {
			$("#pswd1").css("border", "");
			$("#pswd2").css("border", "");
		}
		else {
			$(this).css("border", "");
		}
	});
	
	
	
	$('#submit').click(function(event) {
		event.preventDefault();
		
		$('form.signup').ajaxForm({
			url : '/index/signup/',
			type : 'POST',
			dataType : 'json',
			beforeSubmit : function() {
				var check = true;
				
//				Controllo se i campi obbligatori sono inseriti
				$('.tck').each(function(index) {
					if($(this).val() == '') { 
						$(this).parent('.control-group').addClass('error');
						$(this).next('span').show(200).text('Ti sei dimenticato qualcosa qui sopra');
						check = false;	
					}
				});
				
//				Controllo se l'utente ha inserito una mail valida
				var email = $("#email").val();
				var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
				if (!filter.test(email)) {
					$("#email").parent('.control-group').addClass('error');
					$("#email").next('span').show(200).text('Inserisci un indirizzo email valido');
					check = false;
				}
				
//				Controllo se la password è stata inserita 2 volte correttamente e che sia lunga almeno 6 caratteri
				var pswd1 = $("#pswd1").val();
				var pswd2 = $("#pswd2").val();
				if (pswd1 != pswd2) {
					$("#pswd1").parent('.control-group').addClass('error');
					$("#pswd2").parent('.control-group').addClass('error');
					$("#pswd2").next('span').show(200).text('Le password devono essere uguali');
					check = false;
				}
				if (pswd1.length < 6) {
					$("#pswd1").parent('.control-group').addClass('error');
					$("#pswd1").next('span').show(200).text('La password deve essere lunga almeno 6 caratteri');
					check = false;
				}
				if (pswd2.length < 6) {
					$("#pswd2").parent('.control-group').addClass('error');
					$("#pswd2").next('span').show(200).text('La password deve essere lunga almeno 6 caratteri');
					check = false;
				}
				

				var mail_inviter = $("#mail_inviter").val();
				$.ajax({
					url : '/index/emailInvito/',
					type : 'GET',
					dataType : 'json',
					async: false,
					data : {
						mail_inviter : mail_inviter,
						email : email,
					},
					success : function(response) {
						
						console.log(response);
						
						if (response.status == 'USER') {
							$("#email").parent('.control-group').addClass('error');
							$("#email").next('span').show(200).text(response.message);
							check = false;
//							validateResult(check);
						}
						else if (response.status == 'ERR') {
							$("#mail_inviter").parent('.control-group').addClass('error');
							$("#mail_inviter").next('span').show(200).text(response.message);
							check = false;
//							validateResult(check);
						}
						
					}
				});
				
				console.log(check);
				
//				Se ci sono stati errori blocco tutto
				if (check == false) {
					return false;
				}
				
			},
			success : function(response) {
				console.log(response);
				if (response.status == 'OK') {
					window.location.href = '/index/';
				}
				else {
					alert('Impossibile iscriversi!');
				}
			}
		}).submit();
	});
	
});
