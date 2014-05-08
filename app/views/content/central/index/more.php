	
	
	<!-- <div id="debug"></div> -->


	<!-- LOGIN FORM -->
	<div id="login" class="wrapperform alt">
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
		</form>
		
		<div class="spacerz"></div>
	</div>


	<!-- SIGN UP FORM -->
	<div id="signup" class="wrapperform alt">
		<h3 class="text-center form-title"><button class="btn-mod back"><i class="icon-chevron-left"></i></button>Registrati</h3>
		<form method="POST" class="signup-form" accept-charset="UTF-8">
			<div class="control-group">
				<input type="email" class="input-block-level tck2 big" id="email" name="username" placeholder="Inserisci la tua mail">
				<span class="help-inline hide"></span>
			</div>
			<div class="control-group">
				<input type="password" class="input-block-level tck2 big" id="pswd1" name="password" placeholder="Scegli una password">
				<span class="help-inline hide"></span>
			</div>
			<div class="control-group">
				<input type="password" class="input-block-level tck2 big" id="pswd2" placeholder="Ridigita la tua password">
				<span class="help-inline hide"></span>
			</div>
			<div class="control-group">
				<input type="text" class="input-block-level tck2 big" name="nome" placeholder="Inserisci il tuo nome">
				<span class="help-inline hide"></span>
			</div>
			<div class="control-group">
				<input type="text" class="input-block-level tck2 big" name="cognome" placeholder="Inserisci il tuo cognome">
				<span class="help-inline hide"></span>
			</div>
			<div class="control-group">
				<input type="text" class="input-block-level big" name="cf" placeholder="Inserisci il tuo codice fiscale">
				<span class="help-inline hide"></span>
			</div>
			<div class="control-group">
				<input type="text" class="input-block-level big" name="citta" placeholder="Inserisci la tua citt&agrave;">
				<span class="help-inline hide"></span>
			</div>
			<div class="control-group">
				<input type="text" class="input-block-level big" name="via" placeholder="Inserisci la tua via">
				<span class="help-inline hide"></span>
			</div>
			<div class="control-group">
				<input type="text" class="input-block-level big" name="civico" placeholder="Inserisci il tuo n° civico">
				<span class="help-inline hide"></span>
			</div>
			<div class="control-group">
				<input type="email" class="input-block-level tck2 big" id="mail_inviter" name="mail_inviter" placeholder="Immetti la mail dell'utente che ti ha invitato">
				<span class="help-inline hide"></span>
			</div>
		</form>
		
		<div class="spacerz"></div>
	</div>



	<!-- HEADER -->
	<div class="row-fluid header">
		<div class="span7">
			<a href="/">
				<img width="50" src="/img/fr-small-logo.png" />
				<span class="fr">Food Republic</span>
			</a>
		</div>
		<div class="user pull-right">
			<button class="pull-left signup alt" data-check="0">Registrati</button>
			<button class="pull-right login alt" data-check="0">Entra</button>
		</div>
	</div>


	<div class="more-content">
		<h1 id="chisiamo">Chi siamo</h1>
		<p>
			L’idea di Food Republic è nata da Barbara, Fabio e Maria, tre sognatori con la testa tra le nuvole ma con i piedi...e la pancia...ben ancorati a terra!
		</p>
		<p>
			Dopo anni di lavoro all’estero nella cooperazione allo sviluppo, abbiamo maturato la convinzione che i cambiamenti più significativi partono dal basso, dai comportamenti del singolo, ogni giorno e che questi contribuiscono a plasmare il mondo in cui viviamo.	
		</p>
		<div class="divider"></div>
		<h1 id="cose">Cos'è</h1>
		<p>
			Food Republic è un mercato virtuale in cui la domanda di prodotti alimentari genuini si incontra con l’offerta dei piccoli produttori locali, in una logica di filiera corta. 
		</p>
		<div class="divider"></div>
		<div id="lefoodcommunities" class="foodcoom"></div>
		<h1>Le food communities</h1>
		<p>
			Con Food Republic, vogliamo promuovere lo sviluppo delle Food Communities, ovvero di comunità che mettono il cibo al centro della propria vita, dove non sei l’ultimo anello passivo di una catena alimentare, ma ti puoi alleare con i Produttori del tuo territorio, diventando così un Co-produttore. La Food Community già attiva è tra le provincie di Treviso e Vicenza.
		</p>
		<div class="divider"></div>
		<div id="igruppi" class="groups"></div>
		<h1>I gruppi</h1>
		<p>
			Per acquistare su Food Republic ti devi organizzare in Gruppo in modo da semplificare la gestione logistica e ridurre al minimo la strada percorsa dal cibo.
		</p>
		<p>
			Puoi formare il Gruppo in qualsiasi luogo in cui ti incontri abitualmente con altre persone che hanno interessi simili ai tuoi, ma anche nel negozio di alimentari sotto casa o nel tuo ristorante di fiducia. Se ti piacerebbe provare a creare un gruppo contattaci: <a href="mailto:lucia@food-republic.it">lucia@food-republic.it</a>, ti aiuteremo a coinvolgere i tuoi amici! Se invece preferisci ricevere la spesa a casa tua, lo può fare pagando delle piccole spese di spedizione.
		</p>
		<p>
			I furgoni di Food Republic consegnano in giornata i prodotti appena ritirati, gli ordini avvengono on-line ed il pagamento viene effettuato con carta di credito o con altri sistemi elettronici.
		</p>
		<div class="divider"></div>
		<div id="iprodotti" class="prods"></div>
		<h1>I prodotti di Food Republic</h1>
		<p>
			Tutti i prodotti sono bio, certificati o auto-certificati dai produttori più piccoli che non possono sostenere i costi della certificazione. Nel caso in cui all'interno della Food Comunity non siano reperibili alcuni prodotti bio, vengono selezionati produttori non bio, che sono comunque tenuti a fornire dettagli sulle proprie tecniche di produzione, con la massima trasparenza ed onestà. Con la loro azione, i Co-produttori diventano di fatto alleati dei Produttori e membri attivi delle loro comunità.
		</p>
		<div class="divider"></div>
		<h1 id="abitudini">Perchè cambiare abitudini?</h1>
		<p>
			Diventando Co-produttore, puoi aiutare i Produttori locali a sopravvivere in un mercato reso sempre più difficile dalle “offerte speciali” e dalla disponibilità di cibo di poca qualità a basso prezzo, sviluppando il tuo territorio e facendo circolare importanti risorse – monetarie e non – nella tua Food Community. Puoi anche diminuire le emissioni di gas serra, minimizzando l’impatto ambientale dei trasporti.	
		</p>
		<p>
			Puoi risparmiare il tempo che solitamente dedichi a fare la spesa al supermercato o dai produttori locali avendo accesso a cibo sano ad un giusto prezzo!
		</p>
		<br><br>
	</div>
	

	<div class="info-footer">
		<ul>
			<li><a class="scroll" href="#chisiamo">Chi siamo</a></li>
			<li><a class="scroll" href="#cose">Cos'è?</a></li>
			<li><a class="scroll" href="#lefoodcommunities">Le food communities</a></li>
			<li><a class="scroll" href="#igruppi">I gruppi</a></li>
			<li><a class="scroll" href="#iprodotti">I prodotti di Food Republic</a></li>
			<li><a class="scroll" href="#abitudini">Perchè cambiare abitudini?</a></li>
		</ul>
	</div>
			
