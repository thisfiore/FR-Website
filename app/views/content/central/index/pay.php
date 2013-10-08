
	<!-- SIDE LISTA -->
	<div class="side-bar">
		<div class="gruppo text-center">
			<h4>Gruppo Power</h4>
			<!-- <div class="people">
				<img class="user-img" style="background:url('/img/users/albi.jpg');" />
				<img class="user-img" style="background:url('/img/users/albi.jpg');" />
				<img class="user-img" style="background:url('/img/users/albi.jpg');" />
				<img class="user-img" style="background:url('/img/users/albi.jpg');" />
				<img class="user-img" style="background:url('/img/users/albi.jpg');" />
				<img class="user-img" style="background:url('/img/users/albi.jpg');" />
			</div> -->
			<div><i class="icon-white icon-map-marker"></i> Trentino Alto Adige</div>
			<br>
		</div>

		<div class="lista">
			<img class="center" src="/img/shopbag.png" />
			<h4 class="text-center">La Tua Lista della Spesa</h4>
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
