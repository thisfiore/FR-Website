<li class="item<?php echo $prenotazione['id_prodotto'] ?> openpolli row-fluid">
	<div class="alert alert-warning  span16">
		<button type="button" class="close" data-dismiss="alert"></button>
		<span class="span4"><?php echo $prenotazione['nome_prodotto'] ?></span>
			
		<div class="unita span4" data-unita="<?php echo $prenotazione['unita'] ?>"><?php echo $prenotazione['unita'] ?></div>
		<div class="quantity span3 text-center" data-quantita="<?php echo $prenotazione['quantita'] ?>">
		<!-- <span class="meno">-</span> -->
		<span class="quantita"><?php echo $prenotazione['quantita'] ?></span>
		<!-- <span class="piu">+</span> -->
		</div>
		
		<span class="partial span4 text-right" data-partial="<?php echo $prenotazione['totale'] ?>"><?php echo $prenotazione['totale'] ?></span>
				<br><br>
		<span class="span16" style="margin-top:10px;">Prodotto in consegna il <?php echo $prenotazione['data_consegna'] ?> circa</span>
	</div>
</li>