
<!-- LISTA DI PRODOTTI AQUISTABILI -->
	<div class="prodotti">
		<h1>Dai produttori vicini a te:</h1>
		<ul>
			
			<?php 
			if (isset($prodotti) && !empty($prodotti)) {
				foreach ($prodotti as $prodotto) { ?>
					<li 
						data-placement="bottom"
						data-trigger="hover"
						data-content="<?php echo $prodotto['desc']?>">
						 
						<?php if ($prodotto['proprio'] == 1) { ?>
<!-- 						BADGE IN CASO IL PRODOTTO SIA DI PROPRIA PRODUZIONE  -->
<!-- 						<div class="ribbon-wrapper-green"><div class="ribbon-green">BIO</div></div> -->
						<?php } ?>
						
						<?php if ($prodotto['bio'] == 1) { ?>
						<div class="ribbon-wrapper-green"><div class="ribbon-green">BIO</div></div>
						<?php } ?>
						<div 
							data-id_prodotto="<?php echo $prodotto['id_prodotto']?>"
							data-prezzo="<?php echo $prodotto['prezzo_iva']?>" 
							data-iva="<?php echo $prodotto['iva']?>"
							data-unita="<?php echo $prodotto['unita']?>"
							class="prodotto">
							
							<div class="image" style="background:url('/img/products/<?php echo $prodotto['image']?>');">
								<span>+</span>
							</div>
						
							<h2><?php echo $prodotto['nome_prodotto']?></h2>
							<h3><img src="/img/producer-icon.png" width="18" /> <a data-id_produttore="#produttore<?php echo $prodotto['id_produttore']; ?>"><?php echo $prodotto['nome_produttore']?></a></h3>
							
							<div class="info">
		                        <span><?php echo $prodotto['prezzo_iva']?></span>
		                        <p>Prezzo &euro;/<?php echo $prodotto['unita']?></p>
		                    </div>
		                    <p class="desc"><?php echo $prodotto['desc']?></p>
						</div>
					</li>
			<?php	}
			}
			?>
			

		</ul>
	</div>
	
	<?php 
	foreach ($produttori as $produttore) {?>
	<!-- Producers Modal -->
	<div id="produttore<?php echo $produttore['id_produttore']?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="prodLabel" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	    	<h3 id="prodLabel"><?php echo $produttore['nome_produttore']?></h3>
	  	</div>
	  	<div class="modal-body">
	  		<span><?php echo $produttore['via'].' '.$produttore['civico'].', '.$produttore['citta'].', '.$produttore['cap'].' '.$produttore['provincia'] ?></span><br>
	  		<span><a href="mailto:<?php echo $produttore['username_produttore']?>"><?php echo $produttore['username_produttore']?></a></span><br>
	  		<span>P.IVA <?php echo $produttore['piva']?></span><br><br>
	    	<h5>Informazioni:</h5>
	    	<p><?php echo $produttore['descrizione_produttore']?></p>
	  	</div>
<!-- 	  <div class="modal-footer"> -->
<!-- 	    <button class="btn" data-dismiss="modal" aria-hidden="true">Chiudi</button> -->
<!-- 	  </div> -->
	</div>
	<?php } ?>
	
	<!-- SIDE LISTA -->
	<div class="side-bar">

		<div class="lista">
			<img class="center" src="/img/shopbag.png" />
			<h4 class="text-center">La tua lista della spesa</h4>
			<br>
			<ul><?php 
				if (isset($lista_spesa) && !empty($lista_spesa)) {
					foreach ($lista_spesa as $cella_lista) { ?>
						<li class="item<?php echo $cella_lista['id_prodotto']?> row-fluid"
							data-id_ordine="<?php echo $cella_lista['id_ordine']?>" 
							data-id_prodotto="<?php echo $cella_lista['id_prodotto']?>"
							data-check=1>
							
							<div class="alert alert-success span16">
									<button type="button" class="close" data-dismiss="alert">&times;</button>
									<span class="span6"><?php echo $cella_lista['prodotto']['nome_prodotto']?></span>
									<div class="unita span2" data-unita="<?php echo $cella_lista['unita']?>"><?php echo $cella_lista['unita']?></div>
									<div class="quantity span3" data-quantita="<?php echo $cella_lista['quantita']?>">
										<span class="meno">-</span>
										<span class="quantita"><?php echo $cella_lista['quantita']?></span>
										<span class="piu">+</span>
									</div>
									<span class="partial span3 text-right" data-partial="<?php echo $cella_lista['prodotto']['totale_prodotto']?>">
										<?php echo number_format($cella_lista['prodotto']['totale_prodotto'], 2, '.', '');?> &euro;
									</span>
							</div>
						</li>
				<?php }
				}
			?></ul>
			

			<div class="subtotal" data-totale="<?php echo $prezzo_finale?>">
				<span class="text-left">Totale</span>
				<span class="pull-right"><?php echo number_format($prezzo_finale, 2, '.', '');?> &euro;</span>
			</div>
			
			<a href="/index/pay/<?php echo $ordine_admin['id_ordine_admin']?>">
				<button class="btn btn-success btn-large pull-right"><i class="icon-white icon-ok"></i> Ordina</button>
			</a>

		</div>

		<div class="terms">
			<ul>
				<li>
					<a href="#termini" role="button" data-toggle="modal">Termini e Condizioni</a>
				</li><li>
					<a href="/info/intro">Tutorial</a>
				</li>
			</ul>
		</div>
		
	</div>
	
	<div id="termini" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="prodLabel" aria-hidden="true">
		  <div class="modal-header">
		    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		    <h3 id="prodLabel">Termini e condizioni del servizio</h3>
		  </div>
		  <div class="modal-body">
			<p>
			    Dichiaro di avere interamente letto, compreso e accettato ogni <a href="#">condizione d'uso del servizio</a>. La conferma mediante selezione dell'opzione "Accetto" costituisce accettazione di una proposta contrattuale vincolante.
			</p>
		    	
		    <form action="">
		    	<fieldset>
		              <ul>
		                <li>
		                  <label>
		                    <input type="radio" checked="" name="optionsRadios" value="option1">
		                    <span>Accetto</span>
		                  </label>
		                </li>
		                <li>
		                  <label>
		                    <input type="radio" name="optionsRadios" value="option2">
		                    <span>Non Accetto</span>
		                  </label>
		                </li>
		              </ul>
		    	</fieldset>
		    </form>

			<p>
			    Dichiaro di accettare espressamente e specificamente, ai sensi degli artt. 1341 e 1342 del codice civile e della normativa applicabile al consumatore, le seguenti condizioni d'uso: art. 6 (Accettazione degli ordini), art. 8 (Annullamento e modifica dell’ordine), art. 9 (Consegna), art. 10 (Prodotti disponibili e limitazioni all’acquisto), art. 11 (Mancata consegna), art. 13 (Diritto di recesso), art. 14 (Responsabilità), art. 16 (Foro Compente)
			</p>
			
			<form action="">
			    <fieldset>
		              <ul>
		                <li>
		                  <label>
		                    <input type="radio" checked="" name="optionsRadios" value="option1">
		                    <span>Accetto</span>
		                  </label>
		                </li>
		                <li>
		                  <label>
		                    <input type="radio" name="optionsRadios" value="option2">
		                    <span>Non Accetto</span>
		                  </label>
		                </li>
		              </ul>
		    	</fieldset>
			</form>
			
		  </div>
		  <div class="modal-footer">
		    <button class="btn btn-large" data-dismiss="modal" aria-hidden="true">Chiudi</button>
		    <button class="btn btn-large btn-success" type="submit">Procedi</button>
		  </div>
	</div>
	
