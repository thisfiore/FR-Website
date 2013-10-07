
	<!-- LISTA DI PRODOTTI AQUISTABILI -->
	<div class="prodotti">
		<ul>
			
			<?php 
			if (isset($prodotti) && !empty($prodotti)) {
				foreach ($prodotti as $prodotto) { ?>
					<li>
						<div data-attr-id="<?php echo $prodotto['id_prodotto']?>">
							<img src="../../public/img/apples.jpg" />
							<h2><?php echo $prodotto['nome_prodotto']?></h2>
							<h3><?php echo $prodotto['nome_produttore']?></h3>
							<p><?php echo $prodotto['desc']?></p>
							<div class="info">
		                        <span><?php echo $prodotto['prezzo']?></span>
		                        <p>Prezzo<br>Euro</p>
		                    </div>
						</div>
					</li>
			<?php	}
			}
			?>
			
<!-- 			<li> -->
<!-- 				<div data-attr-id="1"> -->
<!-- 					<img src="../../public/img/apples.jpg" /> -->
<!-- 					<h2>Mele Rosse Golden</h2> -->
<!-- 					<h3>Fattoria Artuso</h3> -->
<!-- 					<p>Descrizione Descrizione</p> -->
<!-- 					<div class="info"> -->
<!--                         <span>0.1</span> -->
<!--                         <p>Prezzo<br>Euro</p> -->
<!--                     </div> -->
<!-- 				</div> -->
<!-- 			</li> -->

<!-- 			<li> -->
<!-- 				<div data-attr-id="1"> -->
<!-- 					<img src="../../public/img/apples.jpg" /> -->
<!-- 					<h2>Mele Rosse Golden</h2> -->
<!-- 					<h3>Fattoria Artuso</h3> -->
<!-- 					<p>Descrizione Descrizione</p> -->
<!-- 					<div class="info"> -->
<!--                         <span>1</span> -->
<!--                         <p>Prezzo<br>Euro</p> -->
<!--                     </div> -->
<!-- 				</div> -->
<!-- 			</li><li> -->
<!-- 				<div data-attr-id="1"> -->
<!-- 					<img src="../../public/img/apples.jpg" /> -->
<!-- 					<h2>Mele Rosse Golden</h2> -->
<!-- 					<h3>Fattoria Artuso</h3> -->
<!-- 					<p>Descrizione Descrizione</p> -->
<!-- 					<div class="info"> -->
<!--                         <span>1</span> -->
<!--                         <p>Prezzo<br>Euro</p> -->
<!--                     </div> -->
<!-- 				</div> -->
<!-- 			</li><li> -->
<!-- 				<div data-attr-id="1"> -->
<!-- 					<img src="../../public/img/apples.jpg" /> -->
<!-- 					<h2>Mele Rosse Golden</h2> -->
<!-- 					<h3>Fattoria Artuso</h3> -->
<!-- 					<p>Descrizione Descrizione</p> -->
<!-- 					<div class="info"> -->
<!--                         <span>1</span> -->
<!--                         <p>Prezzo<br>Euro</p> -->
<!--                     </div> -->
<!-- 				</div> -->
<!-- 			</li><li> -->
<!-- 				<div data-attr-id="1"> -->
<!-- 					<img src="../../public/img/apples.jpg" /> -->
<!-- 					<h2>Mele Rosse Golden</h2> -->
<!-- 					<h3>Fattoria Artuso</h3> -->
<!-- 					<p>Descrizione Descrizione</p> -->
<!-- 					<div class="info"> -->
<!--                         <span>1</span> -->
<!--                         <p>Prezzo<br>Euro</p> -->
<!--                     </div> -->
<!-- 				</div> -->
<!-- 			</li> -->

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
