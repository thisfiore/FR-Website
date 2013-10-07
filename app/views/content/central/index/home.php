
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
	<div class="lista">
		<ul>
			<?php require '_partial/cella_lista.php';?>
			

		</ul>
		<div class="subtotal">16,56 €</div>
		<button class="btn btn-success btn-large pull-right"><i class="icon-white icon-ok"></i></button>
	</div>
