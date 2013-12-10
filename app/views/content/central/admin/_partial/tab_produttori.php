<table class="table table-bordered" data-select="<?php echo $label ?>">
	<tbody>
		<tr>
			<th>Produttore</th>
			<th>Citt&agrave;</th>
			<th>Via</th>
			<th>Civico</th>
			<th>CAP</th>
			<th>Provincia</th>
			<th>PIVA</th>
			<th>Descrizione Produttore</th>
		</tr>
<?php 
		foreach ($produttori as $produttore) {
			echo "<tr data-id='".$produttore['id_produttore']."'>
					<th data-field='nome_produttore'><input class='target' type='text' value=".htmlentities($produttore['nome_produttore'])."></th>
					<th data-field='citta'><input class='target' type='text' value=".htmlentities($produttore['citta'])."></th>
					<th data-field='via'><input class='target' type='text' value=".htmlentities($produttore['via'])."></th>
					<th data-field='cap'><input class='target' type='number' value=".htmlentities($produttore['cap'])."></th>
					<th data-field='civico'><input class='target' type='number' value=".htmlentities($produttore['civico'])."></th>
					<th data-field='provincia'><input class='target' type='text' value=".htmlentities($produttore['provincia'])."></th>
					<th data-field='piva'><input class='target' type='text' value=".htmlentities($produttore['piva'])."></th>
					<th data-field='descrizione_produttore'><textarea class='target' rows='4' cols='50'>".$produttore['descrizione_produttore']."</textarea></th>
				</tr>";
		}	
?>
	</tbody>
</table>

