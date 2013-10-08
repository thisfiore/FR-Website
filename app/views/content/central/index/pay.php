	


<div class="confirm">
	<img class="center" src="/img/shopbag.png" />
	<h1>Riepilogo del tuo ordine</h1>
	<div class="lista">
			<ul>
						<li class="item<?php echo $cella_lista['id_prodotto']?> row-fluid"
							data-id_ordine="<?php echo $cella_lista['id_ordine']?>" 
							data-id_prodotto="<?php echo $cella_lista['id_prodotto']?>"
							data-check=1>

							<div class="span16" style="margin-bottom:10px;">
									<span  style ="margin-left:5px" class="span8">Nome prodotto</span>
								
									
										<span class="quantita span3">2</span>
									<span class="partial span4 text-right">
										5 €
									</span>
							</div>
						</li>
						<!-- REPEAT THIS -->
						<li class="item<?php echo $cella_lista['id_prodotto']?> row-fluid"
							data-id_ordine="<?php echo $cella_lista['id_ordine']?>" 
							data-id_prodotto="<?php echo $cella_lista['id_prodotto']?>"
							data-check=1>

							<div class="alert alert-success span16">
									<span style ="margin-left:5px"  class="span8">Nome prodotto</span>
								
									
										<span class="quantita span3">2 kg</span>
									<span class="partial span4 text-right">
										5 €
									</span>
							</div>
						</li>
						<!-- / REPEAT THIS -->
				
		</ul>
		<div class="subtotal" data-totale="<?php echo $prezzo_finale?>">
				<span class="text-left">Totale</span>
				<span class="pull-right">100 €</span>
			</div>
<button class="btn btn-error  center">Indietro</button>
<button class="btn btn-success pull-right center"><i class="icon-white icon-ok"></i> Paga alla consegna</button>
<button class="btn btn-primary pull-right disabled center" style="margin-right:5px;">Paypal</button>

</div>