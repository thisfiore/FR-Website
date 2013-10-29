<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	<h4 id="prodLabel">Modifica Cassetta</h4>
</div>

<div class="modal-body">
<?php 
	foreach ($cassetta as $prodotto) { ?>

	<div class="image" style="background:url('/img/products/<?php echo $prodotto['image']?>');">
		<span>+</span>
	</div>

<?php } ?>
s</div>

<div class="modal-footer">
	<button class="btn btn-large" data-dismiss="modal" aria-hidden="true">Chiudi</button>
	<button class="btn btn-large btn-success" type="submit" data-term="<?php echo $utente['term']?>">Procedi</button>
</div>


<?php 
echo "<pre>";
print_r($cassetta);
echo "</pre>";
?>