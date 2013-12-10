<?php
echo "<tr data-id='".$produttore['id_produttore']."'>
		<td data-field='nome_produttore'><input class='target' type='text'></td>
		<td data-field='citta'><input class='target' type='text'></td>
		<td data-field='via'><input class='target' type='text'></td>
		<td data-field='cap'><input class='target' type='number'></td>
		<td data-field='civico'><input class='target' type='number'></td>
		<td data-field='provincia'><input class='target' type='text'></td>
		<td data-field='piva'><input class='target' type='text'></td>
		<td data-field='descrizione_produttore'><textarea class='target' rows='4' cols='50'></textarea></td>
	</tr>";
?>