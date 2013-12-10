<table class="table table-bordered" data-select="<?php echo $label ?>">
	<tbody>
		<tr>
			<th>Gruppo</th>
			<th>Username</th>
			<th>Nome</th>
			<th>Cognome</th>
			<th>Citt&agrave;</th>
			<th>Via</th>
			<th>Civico</th>
			<th>CF</th>
		</tr>
<?php 
		foreach ($utenti as $utente) {
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
				echo "</select>
					</th>
					<th data-field='username'><input class='target' type='text' value=".htmlentities($utente['username'])."></th>
					<th data-field='nome'><input class='target' type='text' value=".htmlentities($utente['nome'])."></th>
					<th data-field='cognome'><input class='target' type='text' value=".htmlentities($utente['cognome'])."></th>
					<th data-field='citta'><input class='target' type='text' value=".htmlentities($utente['citta'])."></th>
					<th data-field='via'><input class='target' type='text' value=".htmlentities($utente['via'])."></th>
					<th data-field='civico'><input class='target' type='number' value=".htmlentities($utente['civico'])."></th>
					<th data-field='cf'><input class='target' type='text' value=".htmlentities($utente['cf'])."></th>
				</tr>";
		}	
?>
	</tbody>
</table>
