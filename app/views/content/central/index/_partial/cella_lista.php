<li>
	<div class="alert alert-success">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<span><?php echo $cella_lista['nome_prodotto']?></span>
		<div>
			<div class="quantity pull-left">
				<span>-</span>
				<span><?php echo $cella_lista['quantita']?></span>
				<span>+</span>
			</div>
			<span class="partial text-right">
				<?php echo $cella_lista['prezzo']?> €
			</span>
		</div>
	</div>
</li>