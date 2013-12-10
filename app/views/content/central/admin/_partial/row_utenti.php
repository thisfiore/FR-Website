<?php
echo "<tr data-id='".$utente['id_utente']."'>
		<th data-field='id_gruppo'>
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
		</th>
		<th data-field='username'><input class='target' type='text'></th>
		<th data-field='nome'><input class='target' type='text'></th>
		<th data-field='cognome'><input class='target' type='text'></th>
		<th data-field='citta'><input class='target' type='text'></th>
		<th data-field='via'><input class='target' type='text'></th>
		<th data-field='civico'><input class='target' type='number'></th>
		<th data-field='cf'><input class='target' type='text'></th>
	</tr>";

?>