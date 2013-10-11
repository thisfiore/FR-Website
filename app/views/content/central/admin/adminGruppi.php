<div>
<?php 
if (isset($adminGruppi) && !empty($adminGruppi)) {
	foreach ($adminGruppi as $gruppo) {
?>
	<div style="background-color:#333; color: #FFF; padding:10px 0; width:600px;">
<?php 	echo $gruppo['nome_gruppo']."<br>";
		echo $gruppo['indirizzo']."<br>";
		echo $gruppo['ora_consegna']."<br>"; ?>
	</div>
	
<br><br>

<?php 
	foreach ($gruppo['utenti'] as $utente) {
?> 
	<div style="background-color:#666; color:#FFF; padding:10px 0; width:600px;"><?php echo $utente['nome'].' '.$utente['cognome']; ?></div>
	<div class="table-responsive" style="width:600px;">		
		<table class="table table-bordered row-fluid"> <!--  table-bordered-->
			<tr bgcolor="#FF7373" style="color:#FFF;">
				<td>Nome</td>
				<td>Quantit&agrave;</td>
				<td>Prezzo IVA</td>
				<td>Totale</td>
			</tr>
	
	<?php 
			foreach ($utente['prodotto'] as $prodotto) {
					
				echo "<tr style='background:rgba(255,255,255,0.6);'>";
					echo "<td >".$prodotto['nome_prodotto']."</td>";
					echo "<td>".$prodotto['quantita']."</td>";
					echo "<td>".$prodotto['prezzo_iva']." &euro;/".$prodotto['unita']."</td>";
					echo "<td>".$prodotto['totale']." euro</td>";
				echo "</tr>";
		
			} ?>	
			<tr >
				<td></td>
				<td></td>
				<td></td>
				<td style="background:#333; color:#FFF;"><?php echo $utente['totale_utente']." euro" ?></td>
			</tr>
			
		</table>
	</div>
<br>
<br>
<?php 
		}
	} 
}
else { 
?>

<?php } ?>
</div>