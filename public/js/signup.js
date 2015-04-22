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
	
	//	Elimino il bordo rosso dai campi che sto modificando che mi avevano dato un errore
	$('.tck2').keyup(function() {

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


	//la persona schiaccia esc per farlo terminare
	$(document).keyup(function(e) {
		if (e.keyCode == 27) { 
			if ( formOpened ) { dismissForm(); }
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
				
//				Controllo se la password � stata inserita 2 volte correttamente e che sia lunga almeno 6 caratteri
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

	//quando schiaccio il bottone mi interessa
	// 1. animazione
	// 2. invio form
	$('.interested').click( function(event) {
		var check = $('.interested').data('check');
		if ( check == 0 ) {
			var sliding = $('#interested').css('margin-top');
		
			$(this).animate({
				display: 'block',
				width: '100%'
			}, 400, function() {
				$(this).removeClass('pull-right');
			}).prev().hide(200);

            console.log("HERE");

			$('.wrapper').animate({
				marginTop: '240px'
			}, { duration: 300, queue: false });

            $('.bottom').animate({
                height: '85px'
            }, { duration: 300, queue: false });

			$('#interested').animate({
				top: 0
			}, { duration: 400, queue: false });

            $(".new-site").animate({
                display: 'block',
                width: '100%',
                top: 0
            }, 400, function() {
                $(this).removeClass('pull-right');
            }).prev().hide(200);


			$('.wrapper.interaction').fadeOut(200);
			$('#email').focus();
			$(this).data('check', 1);
			formOpened = true;
		} else {
			event.preventDefault();
				
			$('form.interested-form').ajaxForm({
				url : '/index/umbria/signup',
				type : 'POST',
				dataType : 'json',
				beforeSubmit : function() {

//				Controllo se i campi obbligatori sono inseriti
					var check = true;
					$('.tck2').each(function(index) {
						if($(this).val() == '') { 
							$(this).parent('.control-group').addClass('error');
							$(this).next('span').show(200).text('Ti sei dimenticato qualcosa qui sopra');
							check = false;	
						}
					});

//				Se ci sono stati errori blocco tutto
					if (check == false) {
						return false;
					}
				},
				success : function(response) {
					if (response.status == 'OK') {
                        console.log(response);
						window.location.href = '/index/umbriaLink/' + response.userId;
					}
					else {
						alert('Username o Password incorretti');
					}
				}
			}).submit();
		}
		
	});



	// bottone indietro da login o registrati
	$('.back').click( function() { dismissForm(); });


	function dismissForm() {
        $('.bottom').animate({
            height: '40px'
        }, { duration: 300, queue: false });

		if ( $('.login').data('check') == 1 ) {
			$('.login').data('check', 0);
			
			$('.login').animate({
				display: 'block',
				width: '120px'
			}, 400, function() {

			}).addClass('pull-right').prev().show(200);
			$('.wrapper').animate({
				marginTop: '0px'
			}, { duration: 300, queue: false });

            $('#login').animate({
				top: '-264px'
			}, { duration: 400, queue: false });

			$('.wrapper.interaction').fadeIn(200);
			formOpened = false;
		}

		if ( $('.signup').data('check') == 1 ) {
			$('.signup').data('check', 0);
			
			$('.signup').animate({
				display: 'block',
				width: '120px'
			}, 400, function() {
				$('.signup').addClass('pull-right');
			}).next().show(200);
			$('.wrapper').animate({
				marginTop: '0px'
			}, { duration: 300, queue: false });
            $('#signup').animate({
				top: '-1000px'
			}, { duration: 400, queue: false });

			$('.wrapper.interaction').fadeIn(200);
			formOpened = false;
		}

		if ( $('.interested').data('check') == 1 ) {
			$('.interested').data('check', 0);
			
			$('.interested').animate({
                display: 'block',
                width: '120px'
            }, 400, function() {
                console.log('avoid');
            }).next().show(200);
			$('.wrapper').animate({
				marginTop: '0px'
			}, { duration: 300, queue: false });

            $('#interested').animate({
				top: '-1000px'
			}, { duration: 400, queue: false });

            $('button.new-site').animate({
                display: 'block',
                width: '120px'
            }, 400, function() {
                console.log('avoid');
            }).next().show(200);

			$('.wrapper.interaction').fadeIn(200);
			formOpened = false;
		}
	};

});
