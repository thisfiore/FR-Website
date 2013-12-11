<?php
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
		<td data-field='nome_prodotto'><input class='target' type='text'></td>
		<td data-field='desc'><textarea class='target' rows='4' cols='50'></textarea></td>
		<td data-field='unita'><input class='target' type='text'></td>
		<td data-field='quantita'><input class='target' type='number'></td>
		<td data-field='prezzo'><input class='target' type='number'></td>
		<td data-field='iva'><input class='target' type='number'></td>
		<td data-field='stato'><input class='target' type='checkbox'></td>
		<td data-field='image'><input class='target' type='text'></td>
		<td data-field='tipologia'><input class='target' type='text'></td>
		<td data-field='bio'><input class='target' type='checkbox'></td>
		<td data-field='proprio'><input class='target' type='checkbox'></td>
		<td data-field='prenotazione'><input class='target' type='checkbox'></td>
		<td data-field='data_consegna_pren'><input class='target' type='date'></td>
	</tr>";
?>