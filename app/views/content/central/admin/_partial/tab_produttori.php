<table class="table table-bordered" data-select="<?php echo $label ?>">
	<tbody>
		<tr>
			<td>Produttore</td>
			<td>Citt&agrave;</td>
			<td>Via</td>
			<td>Civico</td>
			<td>CAP</td>
			<td>Provincia</td>
			<td>PIVA</td>
			<td>Descrizione Produttore</td>
		</tr>
<?php 
		foreach ($produttori as $produttore) {
			echo "<tr data-id='".$produttore['id_produttore']."'>
					<td data-field='nome_produttore'><input class='target' type='text' value=".htmlentities($produttore['nome_produttore'])."></td>
					<td data-field='citta'><input class='target' type='text' value=".htmlentities($produttore['citta'])."></td>
					<td data-field='via'><input class='target' type='text' value=".htmlentities($produttore['via'])."></td>
					<td data-field='cap'><input class='target' type='number' value=".htmlentities($produttore['cap'])."></td>
					<td data-field='civico'><input class='target' type='number' value=".htmlentities($produttore['civico'])."></td>
					<td data-field='provincia'><input class='target' type='text' value=".htmlentities($produttore['provincia'])."></td>
					<td data-field='piva'><input class='target' type='text' value=".htmlentities($produttore['piva'])."></td>
					<td data-field='descrizione_produttore'><textarea class='target' rows='4' cols='50'>".$produttore['descrizione_produttore']."</textarea></td>
				</tr>";
		}	
?>
	</tbody>
</table>

