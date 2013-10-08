	


<div class="confirm">
	<img class="center" src="/img/shopbag.png" />
	<h1>Riepilogo del tuo ordine</h1>
	<div class="lista">
			<ul>
			
			<?php 
			foreach ($listaSpesa as $prodotto) { ?>
			<li class="item<?php echo $prodotto['id_prodotto']?> row-fluid"
							data-id_ordine="<?php echo $prodotto['id_ordine']?>" 
							data-id_prodotto="<?php echo $prodotto['id_prodotto']?>"
							data-check=1>

							<div class="span16" style="margin-bottom:10px;">
									<span  style ="margin-left:5px" class="span8"><?php echo $prodotto['nome_prodotto']?></span>
								
									
										<span class="quantita span3">2</span>
									<span class="partial span4 text-right">
<!-- 										prezzo -->
									 €
									</span>
							</div>
						</li>

			<?php 
			}
			?>

				
		</ul>
		<div class="subtotal" data-totale="<?php echo $prezzoFinale?>">
				<span class="text-left">Totale</span>
				<span class="pull-right"><?php echo $prezzoFinale?> €</span>
			</div>
<button class="btn btn-error  center">Indietro</button>
<button class="btn btn-success pull-right center"><i class="icon-white icon-ok"></i> Paga alla consegna</button>
<button class="btn btn-primary pull-right disabled center" style="margin-right:5px;">Paypal</button>

</div>