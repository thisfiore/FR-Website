
<!-- LISTA DI PRODOTTI AQUISTABILI -->
	<div class="prodotti">

<?php  if (isset($riservati) && !empty($riservati)) { ?>
		<h1>Prodotti speciali della settimana:</h1>
		<ul>
		
			<?php	foreach ($riservati as $riservato) { ?>
			<li class="openpolli no_list" data-placement="bottom" data-trigger="hover" data-content="" data-original-title="" title="">
						 
						<div 
							data-id_prodotto="<?php echo $riservato['id_prodotto']?>" 
							data-prezzo="<?php echo $riservato['prezzo_iva']?>" 
							data-iva="<?php echo $riservato['iva']?>" 
							data-unita="<?php echo $riservato['unita']?>" 
							data-data_consegna="<?php echo $riservato['data_consegna_pren']?>"
							class="prodotto prodotto<?php echo $riservato['id_prodotto']?>">
							
							<div class="image" style="background:url('/img/products/<?php echo $riservato['image']?>');">
								<span style="display: none;">+</span>
							</div>
						
							<h2><?php echo $riservato['nome_prodotto']?></h2>
							<h3><img src="/img/producer-icon-alt.png" width="18"> <a data-id_produttore="#produttore1">Cooperativa Sociale Agricola Campoverde</a></h3>
							
							<div class="info">
		                        <span><?php echo $riservato['prezzo_iva']?></span>
		                        <p>Prezzo €/<?php echo $riservato['unita']?></p>
		                    </div>
		                    <p class="desc"></p>
						</div>
					</li>
					
		<?php }
			}
		?>
		</ul>

		<h1>Dai produttori vicini a te:</h1>
		<ul>
			
			<?php 
			if (isset($prodotti) && !empty($prodotti)) {
				foreach ($prodotti as $prodotto) { ?>
					<li
					
						data-placement="bottom"
						data-trigger="hover"
						data-content="<?php echo $prodotto['desc']?>">
						 
						<?php if ($prodotto['proprio'] == 1 && $prodotto['bio'] == 1) { ?>
 						<div class="ribbon-wrapper-green alt"><div class="ribbon-green alt">BIO<br>Prod. Propria</div></div>
						<?php } elseif ($prodotto['proprio']) { ?>
						<div class="ribbon-wrapper-green"><div class="ribbon-green">Prod. Propria</div></div>
						<?php } elseif ($prodotto['bio']) { ?>
						<div class="ribbon-wrapper-green"><div class="ribbon-green">BIO</div></div>
						<?php } ?>

						<div 
							data-id_prodotto="<?php echo $prodotto['id_prodotto']?>"
							data-prezzo="<?php echo $prodotto['prezzo_iva']?>" 
							data-iva="<?php echo $prodotto['iva']?>"
							data-unita="<?php echo $prodotto['unita']?>"
							class="prodotto prodotto<?php echo $prodotto['id_prodotto']?>">
							
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
	    	<h4 id="prodLabel"><?php echo $produttore['nome_produttore']?></h4>
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
						<li class="item<?php echo $cella_lista['id_prodotto']?> row-fluid <?php echo $cella_lista['tipologia']?>"
							data-id_ordine="<?php echo $cella_lista['id_ordine']?>" 
							data-id_prodotto="<?php echo $cella_lista['id_prodotto']?>"
							data-check=1>
							
							<div class="alert <?php if ($cella_lista['prenotazione'] == 1) {echo "alert-warning";} else {echo "alert-success";} ?>  span16">
									<button type="button" class="close" data-dismiss="alert">&times;</button>
									<span class="span5"><?php echo $cella_lista['prodotto']['nome_prodotto']?></span>
									
									<?php 
									if ($cella_lista['tipologia'] != 'cassetta' ) { ?>
									<div class="unita span2" data-unita="<?php echo $cella_lista['unita']?>"><?php echo $cella_lista['unita']?></div>
									<div class="quantity span3" data-quantita="<?php echo $cella_lista['quantita']?>">
										<span class="meno">-</span>
										<span class="quantita"><?php echo $cella_lista['quantita']?></span>
										<span class="piu">+</span>
									</div>
									<?php }
									else { ?>
									<div class="quantity span5">
									Modifica la cassetta
									</div>
									<?php } ?>
									
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
			
			<button data-id_ordine_admin="<?php echo $ordine_admin['id_ordine_admin']?>" class="btn btn-success btn-large pull-right ordina"><i class="icon-white icon-ok"></i> Ordina</button>
			
			<div class="alert alert-error errormsg hide">
			  <button type="button" class="close" data-dismiss="alert">&times;</button>
			  <strong>Ops!</strong><br>
			  <span></span>
			</div>

		</div>

		<div class="reservations">
			<h4 class="text-center">Prodotti Prenotati</h4>
			<div class="row-fluid">
				<div class="span16" style="margin-bottom:10px; padding:0 13px 0 5px;">
					<span class="span12">Prodotto</span>
					<span class="partial span4 text-right"> €</span>
	 			</div>
			</div>
			<ul>
				<?php 
				if (isset($prenotazioni) && !empty($prenotazioni)) { 
					foreach ($prenotazioni as $prenotazione) { ?>
					
				<li class="item<?php echo $prenotazione['id_prodotto'] ?> openpolli row-fluid">
					<div class="alert alert-warning  span16">
						<button type="button" class="close" data-dismiss="alert"></button>
						<span class="span4"><?php echo $prenotazione['nome_prodotto'] ?></span>
							
						<div class="unita span4" data-unita="<?php echo $prenotazione['unita'] ?>"><?php echo $prenotazione['unita'] ?></div>
						<div class="quantity span3 text-center" data-quantita="<?php echo $prenotazione['quantita'] ?>">
						<!-- <span class="meno">-</span> -->
						<span class="quantita"><?php echo $prenotazione['quantita'] ?></span>
						<!-- <span class="piu">+</span> -->
						</div>
						
						<span class="partial span4 text-right" data-partial="<?php echo $prenotazione['totale'] ?>"><?php echo $prenotazione['totale'] ?></span>
								<br><br>
						<span class="span16" style="margin-top:10px;">Consegna in data <?php echo $prenotazione['data_consegna'] ?></span>
					</div>
				</li>
				
				<?php 
					}	
				}?>
			</ul>
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
	
	<div id="termini" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="prodLabel" aria-hidden="true" data-id_ordine_admin="<?php echo $ordine_admin['id_ordine_admin']?>">
		  <div class="modal-header">
		    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		    <h4 id="prodLabel">Termini e condizioni del servizio</h4>
		  </div>
		  <div class="modal-body">
			<p>
			    Dichiaro di avere interamente letto, compreso e accettato ogni <a href="/info/termini" target="_blank">condizione d'uso del servizio</a>. La conferma mediante selezione dell'opzione "Accetto" costituisce accettazione di una proposta contrattuale vincolante.
			</p>
		    	
		    <form action="">
		    	<fieldset>
		              <ul>
		                <li>
		                  <label>
		                    <input type="radio" class="radioTermini" name="optionsRadios" data-value="1">
		                    <span>Accetto</span>
		                  </label>
		                </li>
		                <li>
		                  <label>
		                    <input type="radio" class="radioTermini checked" checked="" name="optionsRadios" data-value="0">
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
		                    <input type="radio" class="radioCondizioni" name="optionsRadios" data-value="1">
		                    <span>Accetto</span>
		                  </label>
		                </li>
		                <li>
		                  <label>
		                    <input type="radio" class="radioCondizioni checked" checked="" name="optionsRadios" data-value="0">
		                    <span>Non Accetto</span>
		                  </label>
		                </li>
		              </ul>
		    	</fieldset>
			</form>
			
		  </div>
		  <div class="modal-footer">
		    <button class="btn btn-large" data-dismiss="modal" aria-hidden="true">Chiudi</button>
		    <button class="btn btn-large btn-success disabled" type="submit" data-term="<?php echo $utente['term']?>">Procedi</button>
		  </div>
	</div>


	<!-- MODAL POLLI -->
	<div id="modal-polli" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="prodLabel" aria-hidden="true">  
	</div>
	
<!-- 	MODAL CASSETTA -->
	<div id="modal-cassetta" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true">
	</div>
