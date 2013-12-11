<table class="table table-bordered" data-select="<?php echo $label ?>">
	<tbody>
		<tr>
			<th>Produttore</th>
			<th>Nome Prodotto</th>
			<th>Descrizione</th>
			<th>Unit&agrave;</th>
			<th>Quantit&agrave;</th>
			<th>Prezzo</th>
			<th>IVA</th>
			<th>Stato</th>
			<th>Immagine</th>
			<th>Tipologia</th>
			<th>Bio</th>
			<th>Proprio</th>
			<th>Prenotazione</th>
			<th>Data Consegna</th>
		</tr>
<?php 
		foreach ($prodotti as $prodotto) {
			echo "<tr data-id='".$prodotto['id_prodotto']."'>
					<td data-field='id_produttore'>
						<select class='target'>";
			foreach ($produttori as $produttore) {
				if ($prodotto['id_produttore'] == $produttore['id_produttore']) {
					echo "<option selected='selected' value='".$produttore['id_produttore']."'>".$produttore['nome_produttore']."</option>";
				}
				else {
					echo "<option value='".$produttore['id_produttore']."'>".$produttore['nome_produttore']."</option>";
				}
			}
				echo "</select>
					</td>
					<td data-field='nome_prodotto'><input class='target' type='text' size='' value=".$prodotto['nome_prodotto']."></td>
					<td data-field='desc'><textarea class='target' rows='4' cols='50'>".$prodotto['desc']."</textarea></td>
					<td data-field='unita'><input class='target' type='text' value=".htmlentities($prodotto['unita'])."></td>
					<td data-field='quantita'><input class='target' type='number' value=".htmlentities($prodotto['quantita'])."></td>
					<td data-field='prezzo'><input class='target' type='number' value=".htmlentities($prodotto['prezzo'])."></td>
					<td data-field='iva'><input class='target' type='number' value=".htmlentities($prodotto['iva'])."></td>
					<td data-field='stato'><input class='target' type='checkbox' value='' ";

							if ($prodotto['stato'] == 1) { echo "checked"; }
				
						echo "></td>
					<td data-field='image'><input class='target' type='text' value=".$prodotto['image']."></td>
					<td data-field='tipologia'><input class='target' type='text' value=".$prodotto['tipologia']."></td>
					<td data-field='bio'><input class='target' type='checkbox' value='' ";

						if ($prodotto['bio'] == 1) { echo "checked"; }
				
						echo "></td>
					<td data-field='proprio'><input class='target' type='checkbox' value='' ";

						if ($prodotto['proprio'] == 1) { echo "checked"; }
				
						echo "></td>
					<td data-field='prenotazione'><input class='target' type='checkbox' value='' ";

						if ($prodotto['prenotazione'] == 1) { echo "checked"; }
				
				echo "></td>
					<td data-field='data_consegna_pren'><input class='target' type='date' value=".$prodotto['data_consegna_pren']."></td>
				</tr>";
		}	
?>
	</tbody>
</table>
