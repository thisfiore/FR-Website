<?php
echo "<tr data-id='".$prodotto['id_prodotto']."'>
		<th data-field='id_produttore'>
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
		</th>
		<th data-field='nome_prodotto'><input class='target' type='text'></th>
		<th data-field='desc'><textarea class='target' rows='4' cols='50'></textarea></th>
		<th data-field='unita'><input class='target' type='text'></th>
		<th data-field='quantita'><input class='target' type='number'></th>
		<th data-field='prezzo'><input class='target' type='number'></th>
		<th data-field='iva'><input class='target' type='number'></th>
		<th data-field='stato'><input class='target' type='number'></th>
		<th data-field='image'><input class='target' type='text'></th>
		<th data-field='tipologia'><input class='target' type='text'></th>
		<th data-field='bio'><input class='target' type='number'></th>
		<th data-field='proprio'><input class='target' type='number'></th>
		<th data-field='prenotazione'><input class='target' type='number'></th>
		<th data-field='data_consegna_pren'><input class='target' type='date'></th>
	</tr>";
?>