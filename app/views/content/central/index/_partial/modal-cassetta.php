<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	<h4 id="prodLabel">Modifica Cassetta</h4>
</div>

<div class="modal-body cassetta">
<ul>
	<?php foreach ($cassetta['prodotti'] as $prodotto) { ?>
		<li>
		<button class="btn btn-danger remove-article"><i class="icon-white icon-ban-circle"></i></button>
		<div class="image" style="background:url('/img/products/<?php echo $prodotto['image']?>');">
		</div>
		<button class="btn btn-success hide preference-article"><i class="icon-white icon-plus-sign"></i></button>
		</li>
	<?php } ?>
</ul>
<p>Puoi decidere di rimuovere uno o più articoli per personalizzare la tua cassetta. Ti basterà cliccare su <button class="btn btn-danger"><i class="icon-white icon-ban-circle"></i></button></p>
<p>Nel caso tu decida di rimuovere uno o più articoli potrai dirci cosa ti piacerebbe ricevere in più per non far cambiare il prezzo totale della cassetta. Clicca su <button class="btn btn-success"><i class="icon-white icon-plus-sign"></i></button></p>
</div>

<div class="modal-footer">
	<button class="btn btn-large" data-dismiss="modal" aria-hidden="true">Chiudi</button>
	<button class="btn btn-large btn-success" type="submit" data-term="<?php echo $utente['term']?>">Procedi</button>
</div>


<?php 
echo "<pre>";
print_r($cassetta);
echo "</pre>";
?>