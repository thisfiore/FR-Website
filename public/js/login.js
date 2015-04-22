$(document).ready(function(e) {

	// video in html5 code
	var min_w = 300; // minimum video width allowed
	var vid_w_orig;  // original video dimensions
	var vid_h_orig;

	jQuery(function() { // runs after DOM has loaded

	    vid_w_orig = parseInt(jQuery('video').attr('width'));
	    vid_h_orig = parseInt(jQuery('video').attr('height'));
	    $('#debug').append("<p>DOM loaded</p>");

	    jQuery(window).resize(function () { resizeToCover(); });
	    jQuery(window).trigger('resize');
	});

	function resizeToCover() {

	    // set the video viewport to the window size
	    jQuery('#video-viewport').width(jQuery(window).width());
	    jQuery('#video-viewport').height(jQuery(window).height());

	    // use largest scale factor of horizontal/vertical
	    var scale_h = jQuery(window).width() / vid_w_orig;
	    var scale_v = jQuery(window).height() / vid_h_orig;
	    var scale = scale_h > scale_v ? scale_h : scale_v;

	    // don't allow scaled width < minimum video width
	    if (scale * vid_w_orig < min_w) {scale = min_w / vid_w_orig;};

	    // now scale the video
	    jQuery('video').width(scale * vid_w_orig);
	    jQuery('video').height(scale * vid_h_orig);
	    // and center it by scrolling the video viewport
	    jQuery('#video-viewport').scrollLeft((jQuery('video').width() - jQuery(window).width()) / 2);
	    jQuery('#video-viewport').scrollTop((jQuery('video').height() - jQuery(window).height()) / 2);

	    // debug output
	    // jQuery('#debug').html("<p>win_w: " + jQuery(window).width() + "</p>");
	    // jQuery('#debug').append("<p>win_h: " + jQuery(window).height() + "</p>");
	    // jQuery('#debug').append("<p>viewport_w: " + jQuery('#video-viewport').width() + "</p>");
	    // jQuery('#debug').append("<p>viewport_h: " + jQuery('#video-viewport').height() + "</p>");
	    // jQuery('#debug').append("<p>video_w: " + jQuery('video').width() + "</p>");
	    // jQuery('#debug').append("<p>video_h: " + jQuery('video').height() + "</p>");
	    // jQuery('#debug').append("<p>vid_w_orig: " + vid_w_orig + "</p>");
	    // jQuery('#debug').append("<p>vid_h_orig: " + vid_h_orig + "</p>");
	    // jQuery('#debug').append("<p>scale: " + scale + "</p>");
	};


	//click sul link guarda video
	$('.startvideo').click( function() { startVideo(); });

	//click sullo stop del video
	$('.video-control').click( function() { closeVideo(); } );
	//il video temrmina
	$("video").bind("ended", function() { closeVideo(); } );
	
	var formOpened = false,
		videoPlaying = false;

	//la persona schiaccia esc per farlo terminare
	$(document).keyup(function(e) {
		if (e.keyCode == 27) { 
			if ( videoPlaying ) { closeVideo(); }
			if ( formOpened ) { dismissForm(); }
		}
	});

	function startVideo() {
		$('.wrapper.interaction').fadeOut(200);
		$('.info-footer').fadeOut(200);
		$('.video-control').fadeIn(200);
		$('.wrapper').animate({
				top: '-900px'
			}, 400);
		$('#video-viewport').animate({
				opacity: '1',
				top: '0'
			}, 500);
		$('#video-viewport').children().get(0).play();
		videoPlaying = true;
	};

	function closeVideo() {
		$('.wrapper.interaction').fadeIn(200);
		$('.info-footer').fadeIn(200);
		$('.video-control').fadeOut(200);
		$('.wrapper').animate({
				top: '0'
			}, 400);
		$('#video-viewport').animate({
				opacity: '0',
				top: '-100%'
			}, 500);
		$('#video-viewport').children().get(0).currentTime = 0;
		$('#video-viewport').children().get(0).pause();
		videoPlaying = true;
	};


	$('.prev').hide();

	// Azione slide, click su freccine bianche
	$('.interaction span').click( function() {
		var activeSlide = $('.pointers ul').find('li.active').data('slide');
		var numberSlides = $('.pointers ul li').size();

		$('.prev').show();

		if ( $(this).hasClass('next') ) {
			if ( activeSlide == numberSlides - 1 ) { $('.next').hide(); }
			if ( activeSlide == numberSlides ) { return false; }
			var color = $('.pointers ul li.active').removeClass('active').next().addClass('active').data('color');
			var subColor = $('.pointers ul li.active').data('sub-color');
			$('.pointers ul li:not(.active)').css('background', subColor);
			
			$('.content').css({left: '-'+ activeSlide +'00%'});
			$('.wrapper').css('background', color);
		} 
		if ( $(this).hasClass('prev') ) {
			if ( activeSlide == numberSlides - 2 ) { $('.prev').hide(); }
			if ( $('.next').is(":hidden") ) { $('.next').show(); }
			if ( activeSlide == 1 ) { return false; }
			activeSlide = activeSlide - 2;
			var color = $('.pointers ul li.active').removeClass('active').prev().addClass('active').data('color');
			var subColor = $('.pointers ul li.active').data('sub-color');
			$('.pointers ul li:not(.active)').css('background', subColor);
			
			$('.content').css({left: '-'+ activeSlide +'00%'});
			$('.wrapper').css('background', color);
		}
	});

	
	// Controllo su tutti i tck
	$('.tck').on('focus', function() {

		$(this).parent('.control-group').removeClass('error');
		$(this).next('span').hide(200);
		
		if ($(this).attr('type') == 'password' ) {
			$("#pswd1").css("border", "");
			$("#pswd2").css("border", "");
		}
		else {
			$(this).css("border", "");
		}
	});

	// Invio form anche con INVIO
	$('.tck').on('keypress', function(event) {
		if (event.which == 13) {
			if ( $(this).closest('form').attr('class') == 'login-form' ) { $( ".login" ).trigger( "click" ); }
			if ( $(this).closest('form').attr('class') == 'signup-form' ) { $( ".signup" ).trigger( "click" ); } 
        }
	});

	// quando schiaccio bottone entra
	// 1. animazione
	// 2. invio form
	$('.login').click( function(event) {
		var check = $(this).data('check');
		if ( check == 0 ) {
			var sliding = $('#login').css('margin-top');
		
			$(this).animate({
				display: 'block',
				width: '100%'
			}, 400, function() {
				$(this).removeClass('pull-right');
			}).prev().hide(200);
			$('.wrapper').animate({
				marginTop: '-251px'
			}, { duration: 300, queue: false });
			$('#login').animate({
				top: 0
			}, { duration: 400, queue: false });

			$('.wrapper.interaction').fadeOut(200);
			$('#username').focus();
			$(this).data('check', 1);
			formOpened = true;
		} else {
			event.preventDefault();
		
			var checkbox = $('#squaredFour').is(":checked");
				
			$('form.login-form').ajaxForm({
				url : '/index/login/',
				type : 'POST',
				dataType : 'json',
				data : {
					checkbox : checkbox,
				},
				beforeSubmit : function() {
					if ($('#username').val() == '') {
						$("#username").parent('.control-group').addClass('error');
						$("#username").next('span').text('Inserisci un indirizzo email valido').show(200);
						return false;
					}
					
					if ($('#password').val() == '') {
						$("#password").parent('.control-group').addClass('error');
						$("#password").next('span').text('La password deve avere un valore').show(200);
						return false;
					}
				},
				success : function(response) {
					if (response.status == 'OK') {
						window.location.href = '/index/';
					}
					else {
						alert('Username o Password incorretti');
					}
				}
			}).submit();
		}
		
	});
	


	// bottone indietro da login o registrati
	//$('.back').click( function() { dismissForm(); });


	function dismissForm() {
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

			$('.wrapper.interaction').fadeIn(200);
			formOpened = false;
		}
	};


	// click su bottone registrati
	// 1. animazione
	// 2.invio form
	$('.signup').click( function(event) {
		var check = $(this).data('check');
		if ( check == 0 ) {
			var sliding = $('#signup').css('margin-top');
		
			$(this).animate({
				display: 'block',
				width: '100%'
			}, 400, function() {
				$(this).removeClass('pull-right');
			}).next().hide(200);
			$('.wrapper').animate({
				marginTop: '475px'
			}, { duration: 300, queue: false });
			$('#signup').animate({
				top: 0
			}, { duration: 400, queue: false });

			$('.wrapper.interaction').fadeOut(200);
			$('#email').focus();
			$(this).data('check', 1);
			formOpened = true;
		} else {
			event.preventDefault();
			
			$('form.signup-form').ajaxForm({
				url : '/index/signup/',
				type : 'POST',
				dataType : 'json',
				beforeSubmit : function() {
					var check = true;
					
	//				Controllo se i campi obbligatori sono inseriti
					$('.tck2').each(function(index) {
						if($(this).val() == '') { 
							$(this).parent('.control-group').addClass('error');
							$(this).next('span').text('Ti sei dimenticato qualcosa qui sopra').show(200);
							check = false;	
						}
					});
					
	//				Controllo se l'utente ha inserito una mail valida
					var email = $("#email").val();
					var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
					if (!filter.test(email)) {
						$("#email").parent('.control-group').addClass('error');
						$("#email").next('span').text('Inserisci un indirizzo email valido').show(200);
						check = false;
					}
					
	//				Controllo se la password  stata inserita 2 volte correttamente e che sia lunga almeno 6 caratteri
					var pswd1 = $("#pswd1").val();
					var pswd2 = $("#pswd2").val();
					if (pswd1 != pswd2) {
						$("#pswd1").parent('.control-group').addClass('error');
						$("#pswd2").parent('.control-group').addClass('error');
						$("#pswd2").next('span').text('Le password devono essere uguali').show(200);
						check = false;
					}
					if (pswd1.length < 6) {
						$("#pswd1").parent('.control-group').addClass('error');
						$("#pswd1").next('span').text('La password deve essere lunga almeno 6 caratteri').show(200);
						check = false;
					}
					if (pswd2.length < 6) {
						$("#pswd2").parent('.control-group').addClass('error');
						$("#pswd2").next('span').text('La password deve essere lunga almeno 6 caratteri').show(200);
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
								$("#email").next('span').text(response.message).show(200);
								check = false;
	//							validateResult(check);
							}
							else if (response.status == 'ERR') {
								$("#mail_inviter").parent('.control-group').addClass('error');
								$("#mail_inviter").next('span').text(response.message).show(200);
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

		}

	});


	
});