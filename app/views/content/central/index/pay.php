	
<div class="confirm">
	<img class="center" src="/img/shopbag.png" />
	<?php 
	if ($ordineUtente['stato'] == 1) {
	?>
	<h1>Complimenti! <br />Hai effettuato il tuo ordine con successo!</h1>
<p class="text-center">
	<strong>Riceverai a breve la tua ricevuta per e-mail.</strong></p><p class="text-center">

Ti ricordiamo il punto di raccolta del tuo gruppo<br /> Via Piave, 104 Fabbrico (RE) alle ore 14.30 del 11 Ottobre 2013.

Il tuo ordine:
	</p>
	<?php 
	}
	else {?>
	<h1>Riepilogo del tuo ordine</h1>
	<?php }?>
	<div class="lista">
	
	<?php
	if (isset($listaSpesa) && !empty($listaSpesa) ) { ?>
		<ul>
			<li class="item row-fluid">
				<div class="span16" style="margin-bottom:10px;">
					<span style ="margin-left:5px"  class="span8">Nome prodotto</span>
 					<span class="quantita span3">unit&agrave</span>
					<span class="partial span4 text-right"> €</span>
 				</div>
 			</li>
			<?php 
			foreach ($listaSpesa as $prodotto) { ?>
				<li class="item row-fluid">
					<div class="alert alert-success span16">
						<span  style ="margin-left:5px" class="span8"><?php echo $prodotto['nome_prodotto']?></span>
						<span class="quantita span3"><?php echo $prodotto['quantita'].' '.$prodotto['unita']?></span>
						<span class="partial span4 text-right"><?php echo ($prodotto['quantita'] * $prodotto['prezzo_iva'])?>€</span>
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
		
		<?php 
		if ($ordineUtente['stato'] == 0) {
		?>
		<a href="/"> <button class="btn btn-error  center">Indietro</button> </a>

		<button class="btn btn-success pull-right center paga" data-id_ordine_admin="<?php echo $idOrdineAdmin?>"><i class="icon-white icon-ok"></i> Paga alla consegna</button>
		<button class="btn btn-primary pull-right disabled center" style="margin-right:5px;">Paypal</button>
	<?php 
		}
	} 
	else { ?>
		<a href="/">
			<button class="btn btn-error  center">Indietro</button>
		</a>
	<?php } ?>

</div>