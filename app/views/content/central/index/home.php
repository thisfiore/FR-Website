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
						
						<?php if ($prodotto['bio'] == 1) { ?>
						<div class="ribbon-wrapper-green"><div class="ribbon-green">BIO</div></div>
						<?php } ?>
						<div 
							data-id_prodotto="<?php echo $prodotto['id_prodotto']?>"
							data-prezzo="<?php echo $prodotto['prezzo_iva']?>" 
							data-iva="<?php echo $prodotto['iva']?>">
							
							<div class="image" style="background:url('/img/products/<?php echo $prodotto['image']?>');">
								<span>+</span>
							</div>
						
							<h2><?php echo $prodotto['nome_prodotto']?></h2>
							<h3><img src="/img/producer-icon.png" width="18" /> <?php echo $prodotto['nome_produttore']?></h3>
							
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
	</div>
