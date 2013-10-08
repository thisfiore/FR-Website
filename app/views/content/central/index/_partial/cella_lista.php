<li class="item<?php echo $cella_lista['id_prodotto']?> row-fluid"
	data-id_ordine="<?php echo $cella_lista['id_ordine']?>" 
	data-id_prodotto="<?php echo $cella_lista['id_prodotto']?>"
	data-check=1>

	<div class="alert alert-success span16">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<span class="span6"><?php echo $cella_lista['prodotto']['nome_prodotto']?></span>
		<div class="unita span2"><?php echo $cella_lista['unita']?></div>
		<div class="quantity span3" data-quantita="<?php echo $cella_lista['quantita']?>">
			<span class="meno">-</span>
			<span class="quantita"><?php echo $cella_lista['quantita']?></span>
			<span class="piu">+</span>
		</div>
		<span class="partial span3 text-right">
			<?php echo $cella_lista['prodotto']['prezzo_iva']?> €
		</span>
								
	</div>
</li>