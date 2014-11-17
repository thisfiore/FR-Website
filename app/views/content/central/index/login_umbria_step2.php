	
	
	<!-- <div id="debug"></div> -->


	<!-- LOGIN FORM -->
	<div id="login" class="wrapperform">
		<h3 class="text-center form-title"><button class="btn-mod back"><i class="icon-chevron-left"></i></button>Log In</h3>
		<form method="POST" class="login-form" accept-charset="UTF-8">
			<div class="control-group">
				<input type="email" class="input-block-level tck big" id="username" name="username" placeholder="Inserisci la tua mail">
				<span class="help-inline hide"></span>
			</div>
			<div class="control-group">
				<input type="password" class="input-block-level tck big" id="password" name="password" placeholder="Inserisci la tua password"
				<?php if (strpos($browser, 'Mozilla') >= 0) { echo 'style="padding: -20px -10px !important;"'; } ?> value="">
				<span class="help-inline hide"></span>
			</div>
			<div class="squaredFour">
				<input type="checkbox" id="squaredFour" name="check" /> 
<!-- 				value="None" -->
				<label for="squaredFour"></label>
			</div>
			<span>Ricordami</span>
			<span class="pull-right"><a href="#">E se avessi dimenticato la mia password?</a></span>
		</form>
		<div class="spacerz"></div>
	</div>


	<!-- I M INTERESTED FORM -->
	<div id="interested" class="wrapperform">
		<h3 class="text-center form-title"><button class="btn-mod back"><i class="icon-chevron-left"></i></button>Mi Interessa</h3>
		<form method="POST" class="interested-form" accept-charset="UTF-8">
			
			<p><strong>Se ti interessa mangiare prodotti Umbri freschi e genuini, aiutando i produttori locali, lasciaci i tuoi dati e ti contatteremo non appena inizieremo le consegne, tra qualche settimana.</strong></p> 
			<p>Se rispondi alle domande qui sotto, ci aiuti a creare un servizio che risponda meglio alle tue esigenze.</p>

			<div class="control-group">
				<label for="rg-from">Inserisci la tua email:</label>
				<input type="email" class="input-block-level tck2 big" id="email" name="email" placeholder="">
				<span class="help-inline hide"></span>
			</div>
			<div class="control-group">
				<label for="rg-from">Inserisci il tuo nome:</label>
				<input type="text" class="input-block-level tck2 big" name="nome" placeholder="">
				<span class="help-inline hide"></span>
			</div>
			<div class="control-group">
				<label for="rg-from">Inserisci il tuo cognome:</label>
				<input type="text" class="input-block-level tck2 big" name="cognome" placeholder="">
				<span class="help-inline hide"></span>
			</div>
			<div class="control-group">
				<label for="rg-from">Inserisci il tuo numero di telefono:</label>
				<input type="text" class="input-block-level tck2 big" id="phone" name="phone" placeholder="">
				<span class="help-inline hide"></span>
			</div>
			<div class="control-group">
				<label for="rg-from">Inserisci il tuo luogo di lavoro:</label>
				<input type="text" class="input-block-level tck2 big" id="workplace" name="workplace" placeholder="Nome e indirizzo">
				<span class="help-inline hide"></span>
			</div>
			<div class="control-group">
				<label for="rg-from">Inserisci la tua residenza:</label>
				<input type="text" class="input-block-level tck2 big" id="home" name="home" placeholder="">
				<span class="help-inline hide"></span>
			</div>


		</form>
		<div class="spacerz"></div>
	</div>
	
	<!-- ARROWS -->
	<div class="wrapper interaction">
		<span class="prev" style="background-color: #7F7D80; top: 505px; left: 5%; -webkit-box-shadow: 0 1px 6px 1px #7F7D80; box-shadow: 0 1px 6px 1px #7F7D80;"><img src="/img/left-arrow.png"></span>
		<span class="next" style="background-color: #7F7D80; top: 505px; right: 5%; -webkit-box-shadow: 0 1px 6px 1px #7F7D80; box-shadow: 0 1px 6px 1px #7F7D80;"><img src="/img/right-arrow.png"></span>
	</div>

	<!-- SLIDER -->
	<div class="wrapper main">
		<div class="content">
			<div class="slide1">
				<img src="/img/intro1.png">
				<div class="spacerz"></div><div class="spacerz"></div>
				<p class="title">Benvenuto su <strong>Food Republic</strong>!</p>
				<div class="spacerz"></div>
				<p>Vogliamo costruire assieme a te una nuova <em>comunità</em> del <br/>
				   cibo, un mercato virtuale in cui domanda e offerta si <br/>
				   incontrano <em>senza intermediari</em>.</p>
				<!-- ACTIVE THIS TO ENABLE THE LINK FOR FULLFRAME VIDEO -->
				<!-- <p class="startvideo"><i class="icon-film icon-white"></i> Guarda il Video</p> -->
			</div>
			
			<div class="slide2">
				<img src="/img/intro2.png">
				<div class="spacerz"></div><div class="spacerz"></div>
				<p class="title">I prodotti sono <strong>freschissimi</strong>...</p>
				<div class="spacerz"></div>
				<p>Potrai conoscere i produttori <em>vicini a te</em> ed acquistare <br>
  				   direttamente da loro prodotti stagionali e genuini ad un <br>
  				   prezzo <em>equo</em> per te e per loro.</p>
				<div class="spacerz"></div>
			</div>
			<div class="slide3">
				<img src="/img/intro3.png">
				<div class="spacerz"></div><div class="spacerz"></div>
				<p class="title">...e non <strong>inquinano</strong></p>
				<div class="spacerz"></div>
				<p>I camioncini di Food Republic <em>ottimizzano</em> i chilometri <br>
				   percorsi dal cibo effettuando nello stesso giorno <br>
				   i ritiri dai produttori e le consegne ai gruppi d’acquisto.</p>
				<div class="spacerz"></div>
			</div>
			<div class="slide4">
				<p class="title">Guarda il <strong>video</strong> di foodrepublic:</p>
				<div class="spacerz"></div><div class="spacerz"></div>
				<iframe width="480" height="270" src="//www.youtube.com/embed/_dq3uw6G4lI?rel=0" frameborder="0" allowfullscreen></iframe>
			</div>
			<!-- <div class="slide4">
				Prova4
			</div> -->
		</div>
		<div class="bottom text-center">
			<div class="pointers">
				<ul>
					<li class="active" data-slide="1" data-color="#ef6957" data-sub-color="#ed978e">  
					</li><li data-slide="2" data-color="#89cee5" data-sub-color="#bbecf9">
					</li><li data-slide="3" data-color="#a2e288" data-sub-color="#bff9a5">
					</li><li data-slide="4" data-color="#333333" data-sub-color="#575757">
					<!-- </li><li data-slide="4" data-color="#ef6957" data-sub-color="#ed978e"> -->
					</li>
				</ul>
			</div>
			<button class="interested" data-check="0">Mi Interessa</button>
			<!-- <button class="pull-right login" data-check="0">Entra</button> -->
		</div>
	</div>

	<!-- <div class="modded-video">
		<iframe width="480" height="270" src="//www.youtube.com/embed/_dq3uw6G4lI?rel=0" frameborder="0" allowfullscreen></iframe>
	</div> -->

	<div class="info-footer">
		<ul>
			<li><a href="/index/umbria_more">Cos'è?</a></li>
			<li><a href="/index/umbria_more#lefoodcommunities">Le food communities</a></li>
			<li><a href="/index/umbria_more#igruppi">Punti di consegna</a></li>
			<li><a href="/index/umbria_more#iprodotti">I prodotti di Food Republic</a></li>
			<li><a href="/index/umbria_more#abitudini">Perchè cambiare abitudini?</a></li>
			<li><a href="/index/umbria_more#chisiamo">Chi siamo</a></li>
		</ul>
	</div>
	
	<!-- VIDEO -->
	<!-- <div id="video-viewport">
    	<video controls preload width="1280" height="720">
	        <source src="/media/video.mp4"type="video/mp4" />
	        <source src="/media/video.webm"type="video/webm" />
	        <source src="/media/video.ogv"type="video/webm" />
	    </video>
	</div>
	<div class="video-control hide"></div> -->
			
