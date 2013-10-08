
	<!-- LISTA DI PRODOTTI AQUISTABILI -->
	<div class="prodotti">
		<ul>
			
			<?php 
			if (isset($prodotti) && !empty($prodotti)) {
				foreach ($prodotti as $prodotto) { ?>
					<li>
						<div data-attr-id="<?php echo $prodotto['id_prodotto']?>">
							<div class="image" style="background:url('../../public/img/apples.jpg');">
								<span>+</span>
							</div>
						
							<h2><?php echo $prodotto['nome_prodotto']?></h2>
							<h3><?php echo $prodotto['nome_produttore']?></h3>
							
							<div class="info">
		                        <span><?php echo $prodotto['prezzo']?></span>
		                        <p>Prezzo<br>Euro</p>
		                    </div>
		                    <p class="desc"><?php echo $prodotto['desc']?></p>
						</div>
					</li>
			<?php	}
			}
			?>
			

		</ul>
	</div>

	<!-- SIDE LISTA -->
	<div class="gruppo">
		
	</div>
	<div class="lista">
		<img class="pagination-centered" src="" />
		<ul>
			<?php 
			if (isset($lista_spesa) && !empty($lista_spesa)) {
				foreach ($lista_spesa as $cella_lista) { ?>
					<li class="row-fluid">
						<div class="alert alert-success span16">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<span class="span8"><?php echo $cella_lista['prodotto']['nome_prodotto']?></span>
							
								<div class="quantity span3">
									<span>-</span>
									<span><?php echo $cella_lista['quantita']?></span>
									<span>+</span>
								</div>
								<span class="partial span3 text-right">
									<?php echo $cella_lista['prodotto']['prezzo']?> €
								</span>
							
						</div>
					</li>
			<?php }
			}
			?>
		</ul>
		
		<div class="subtotal">
			<span class="text-left">Totale</span>
			<span class="pull-right"><?php echo $prezzo_finale?> €</span>
		</div>
		<button class="btn btn-success btn-large pull-right"><i class="icon-white icon-ok"></i> Acquista</button>
	</div>
