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

						<div data-attr-id="<?php echo $prodotto['id_prodotto']?>">
							<div class="image" style="background:url('/img/apples.jpg');">
								<span>+</span>
							</div>
						
							<h2><?php echo $prodotto['nome_prodotto']?></h2>
							<h3><img src="/img/producer-icon.png" width="18" /> <?php echo $prodotto['nome_produttore']?></h3>
							
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
	<div class="side-bar">
		<!-- <div class="gruppo text-center">
			<h4>Gruppo Power</h4>
			<div class="people">
				<img class="user-img" style="background:url('/img/users/albi.jpg');" />
				<img class="user-img" style="background:url('/img/users/albi.jpg');" />
				<img class="user-img" style="background:url('/img/users/albi.jpg');" />
				<img class="user-img" style="background:url('/img/users/albi.jpg');" />
				<img class="user-img" style="background:url('/img/users/albi.jpg');" />
				<img class="user-img" style="background:url('/img/users/albi.jpg');" />
			</div>
			<div><i class="icon-white icon-map-marker"></i> Trentino Alto Adige</div>
			<br>
		</div> -->

		<div class="lista">
			<img class="center" src="/img/shopbag.png" />
			<h4 class="text-center">La tua lista della spesa</h4>
			<br>
			<ul>
				<?php 
				if (isset($lista_spesa) && !empty($lista_spesa)) {
					foreach ($lista_spesa as $cella_lista) { ?>

						<li class="item<?php echo $cella_lista['id_prodotto']?> row-fluid"
							data-id_ordine="<?php echo $cella_lista['id_ordine']?>" 
							data-id_prodotto="<?php echo $cella_lista['id_prodotto']?>">

							<div class="alert alert-success span16">
							<button type="button" class="close" data-dismiss="alert">&times;</button>
							<span class="span8"><?php echo $cella_lista['prodotto']['nome_prodotto']?></span>
								
									<div class="quantity span3" data-quantita="<?php echo $cella_lista['quantita']?>">
										<span class="meno">-</span>
										<span class="quantita"><?php echo $cella_lista['quantita']?></span>
										<span class="piu">+</span>
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
			

			<div class="subtotal" data-totale="<?php echo $prezzo_finale?>">
				<span class="text-left">Totale</span>
				<span class="pull-right"><?php echo $prezzo_finale?> €</span>
			</div>
			<button class="btn btn-success btn-large pull-right"><i class="icon-white icon-ok"></i> Ordina</button>

		</div>
	</div>
