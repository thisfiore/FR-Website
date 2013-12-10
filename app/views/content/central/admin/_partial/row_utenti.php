<?php
echo "<tr data-id='".$utente['id_utente']."'>
		<td data-field='id_gruppo'>
			<select class='target'>";
			foreach ($gruppi as $gruppo) {
				if ($utente['id_gruppo'] == $gruppo['id_gruppo']) {
					echo "<option selected='selected' value='".$gruppo['id_gruppo']."'>".$gruppo['nome_gruppo']."</option>";
				}
				else {
					echo "<option value='".$gruppo['id_gruppo']."'>".$gruppo['nome_gruppo']."</option>";
				}
			}
echo "		</select>
		</td>
		<td data-field='username'><input class='target' type='text'></td>
		<td data-field='nome'><input class='target' type='text'></td>
		<td data-field='cognome'><input class='target' type='text'></td>
		<td data-field='citta'><input class='target' type='text'></td>
		<td data-field='via'><input class='target' type='text'></td>
		<td data-field='civico'><input class='target' type='number'></td>
		<td data-field='cf'><input class='target' type='text'></td>
	</tr>";

?>