<?php 

?>	
<div class="confirm">
	<img class="center" src="/img/shopbag.png" />
	<?php 
	if ($ordineUtente['stato'] == 1) {
	?>
	<h1>Complimenti! <br />Hai effettuato il tuo ordine con successo!</h1>
<p class="text-center">
	<strong>Riceverai a breve la tua ricevuta per e-mail.</strong></p><p class="text-center">

Ti ricordiamo il punto di raccolta del tuo gruppo<br /> <?php echo $utente['indirizzo']; ?> alle ore <?php echo $utente['ora_consegna']; ?> del <?php echo $ordineAdmin['data_consegna']; ?>.

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
						<span class="partial span4 text-right"><?php echo $prodotto['totale_prodotto']?>€</span>
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
		
		<?php 
		if ($server == "foodrepublic.dev") { ?>
		<form method="post" name="paypal_form" action="https://www.sandbox.paypal.com/cgi-bin/webscr">
			<input type="hidden" name="business" value="ricca.prog-facilitator@gmail.com" />
		<?php  
		}
		else {
		?>	
		<form class="pull-right" method="post" name="paypal_form" action="https://www.paypal.com/cgi-bin/webscr">
			<input type="hidden" name="business" value="info@food-republic.it" />
		<?php } ?>	
			
			     
			<!-- informazioni sulla transazione -->
			<input type="hidden" name="cmd" value="_xclick" />
			<input type="hidden" name="return" value="<?php echo "http://".$_SERVER['HTTP_HOST']; ?>/" />
			<input type="hidden" name="rm" value="2" />
			<input type="hidden" name="currency_code" value="EUR" />
			<input type="hidden" name="lc" value="IT" />
			<input type="hidden" name="cbt" value="Continua" />
			     
			<!-- informazioni sul pagamento -->
			<input type="hidden" name="shipping" value="0.00" />
			<input type="hidden" name="cs" value="1" />
			  
			<?php 
			if ($server == "foodrepublic.dev") { ?> 
			<!-- informazioni sul prodotto -->
			<input type="hidden" name="item_name" value="Test sandbox" />
			<input type="hidden" name="amount" value="0.01" />  
			<?php  
			}
			else {
			?>
			<!-- informazioni sul prodotto -->
			<input type="hidden" name="item_name" value="Carrello Spesa FoodRepublic" />
			<input type="hidden" name="amount" value="<?php echo $prezzoFinale?>" />
			<?php } ?>
			
			 
<!-- 		questo campo conterr� le info che torneranno al sito e viene usato per passare l'id utente o altre info     -->
			<input type="hidden" name="custom" value="<?php echo $idOrdineAdmin?>" />
			
			<button class="btn btn-success pull-right center paga" data-id_ordine_admin="<?php echo $idOrdineAdmin?>">Paga alla consegna</button>
			<!-- pulsante pagamento -->
			<button name="submit" data-button="buynow" data-name="My product" class="btn btn-primary pull-right center" style="margin-right:5px;">Paypal</button>
		</form>	
	<?php 
		}
	} 
	else { ?>
		<a href="/">
			<button class="btn btn-error  center">Indietro</button>
		</a>
	<?php } ?>

</div>