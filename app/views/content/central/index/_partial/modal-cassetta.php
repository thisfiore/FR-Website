<?php 
// echo "<pre>";
// print_r($cassetta);
// echo "</pre>";
// die;
?>
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	<h4 id="prodLabel">Modifica Cassetta</h4>
</div>

<div class="modal-body cassetta">
<ul data-id_cassetta="<?php echo $cassetta['id_cassetta']?>" data-id_ordine_utente="<?php echo $cassetta['id_ordine_utente']?>">
	<?php foreach ($cassetta['prodotti'] as $prodotto) { ?>
		<li class="prodotto" data-id_prodotto="<?php echo $prodotto['id_prodotto']?>">
		<div class="image" style="background:url('/img/products/<?php echo $prodotto['image']?>');">
			<button class="btn btn-danger remove-article"><i class="icon-white icon-ban-circle"></i></button>
			<button class="btn btn-success hide preference-article"><i class="icon-white icon-plus-sign"></i></button>
		</div>
		
		</li>
	<?php } ?>
	<?php foreach ($cassetta['prodotti'] as $prodotto) { ?>
		<li class="prodotto" data-id_prodotto="<?php echo $prodotto['id_prodotto']?>">
		<div class="image" style="background:url('/img/products/<?php echo $prodotto['image']?>');">
			<button class="btn btn-danger remove-article"><i class="icon-white icon-ban-circle"></i></button>
			<button class="btn btn-success hide preference-article"><i class="icon-white icon-plus-sign"></i></button>
		</div>
		
		</li>
	<?php } ?>
</ul>
<p>Puoi decidere di rimuovere uno o più articoli per personalizzare la tua cassetta. Ti basterà cliccare su <button class="btn btn-danger"><i class="icon-white icon-ban-circle"></i></button></p>
<p>Nel caso tu decida di rimuovere uno o più articoli potrai dirci cosa ti piacerebbe ricevere in più per non far cambiare il prezzo totale della cassetta. Clicca su <button class="btn btn-success"><i class="icon-white icon-plus-sign"></i></button></p>
</div>

<div class="modal-footer">
	<button class="btn btn-large" data-dismiss="modal" aria-hidden="true">Chiudi</button>
	<button class="btn btn-large btn-success" type="submit">Procedi</button>
</div>


