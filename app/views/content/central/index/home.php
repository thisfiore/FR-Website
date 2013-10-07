
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

			<li>
				<div class="alert alert-success">
				  <button type="button" class="close" data-dismiss="alert">&times;</button>
				  <span>Mele Rosse Golden</span>
				  <div>
					  <div class="quantity pull-left">
						<span>-</span>
						<span>2</span>
						<span>+</span>
					  </div>
					  <span class="partial text-right">
						1,24 €
					  </span>
				  </div>
				</div>
			</li>

		</ul>
		<div class="subtotal">16,56 €</div>
		<button class="btn btn-success btn-large pull-right"><i class="icon-white icon-ok"></i></button>
	</div>
