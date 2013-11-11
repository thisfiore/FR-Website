<?php 

// echo "<pre>";
// print_r($cassetta);
// echo "</pre>";
// die;

?>

<div class="container-fluid" style="margin-top: 80px; padding: 0 100px; min-width: 366px;">
<?php 
if (isset($adminProduttori) && !empty($adminProduttori)) {
	foreach ($adminProduttori as $produttore) {
?>
	<div style="background-color:#333; color: #FFF; padding:10px; ">
<?php 	echo $produttore['nome_produttore']."<br>";
		echo $produttore['citta']."<br>";
		echo $produttore['via'].' '.$produttore['civico'].' - '.$produttore['cap'].' '.$produttore['provincia']."<br>";
		echo $produttore['piva']."<br>"; ?>
	</div>
	
<br><br>

<?php 
		if (isset($produttore['gruppi']) && !empty($produttore['gruppi'])) {
			foreach ($produttore['gruppi'] as $gruppo) {
?> 
	<div style="background-color:#666; color:#FFF; padding:10px; "><?php echo $gruppo['nome_gruppo']; ?></div>
	<div class="table-responsive" style="">		
		<table class="table table-bordered row-fluid"> <!--  table-bordered-->
			<tr bgcolor="#FF7373" style="color:#FFF;">
				<td>Nome</td>
				<td>Quantit&agrave;</td>
				<td>Prezzo IVA</td>
				<td>Totale</td>
			</tr>
	
<?php 	 	foreach ($gruppo['prodotto'] as $prodotto) {
						
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
				<td style="background:#333; color:#FFF;"><?php echo $gruppo['totale_gruppo']." euro" ?></td>
			</tr>
			
		</table>
	</div>
<br>
<br>
<?php 		}	
		}
	} 
}
else { 
// 	non  lo sooo!
}


if (isset($cassetta) && !empty($cassetta)) {

// 	CASSETTA VERDURA
	if (isset($cassetta['verdura']) && !empty($cassetta['verdura'])) {
		echo "<div style='background-color:#666; color:#FFF; padding:10px;'>CASSETTA VERDURA</div>";
		echo "<table class='table table-bordered row-fluid'>";
		$i = 0; 
		
		foreach ($cassetta['verdura'] as $cassVerdura) {
			
			if ($i == 0) { 
				echo '<tr bgcolor="#FF7373" style="color:#FFF;">';
				echo '<td></td>';
				$i = 1;
				
				foreach ($cassVerdura['cassetta'] as $verdura) { 
					echo "<td>".$verdura['nome_prodotto']."</td>";
				} 
				echo "</tr>";
			}
			
			echo "<tr style='background:rgba(255,255,255,0.6);'>";
			echo "<td>".$cassVerdura['nome'].' '.$cassVerdura['cognome']."</td>";
			
 			foreach ($cassVerdura['cassetta'] as $verdura) {
				echo "<td>".$verdura['stato'].'/'.$verdura['pref']."</td>";
			}
			
			echo "</tr>";
		}
		echo "</table>";
	}

// 	CASSETTA FRUTTA
	if (isset($cassetta['frutta']) && !empty($cassetta['frutta'])) {
		echo "<div style='background-color:#666; color:#FFF; padding:10px;'>CASSETTA FRUTTA</div>";
		echo "<table class='table table-bordered row-fluid'>";
		$i = 0;
	
		foreach ($cassetta['frutta'] as $cassVerdura) {
				
			if ($i == 0) {
				echo '<tr bgcolor="#FF7373" style="color:#FFF;">';
				echo '<td></td>';
				$i = 1;
	
				foreach ($cassVerdura['cassetta'] as $verdura) {
					echo "<td>".$verdura['nome_prodotto']."</td>";
				}
				echo "</tr>";
			}
				
			echo "<tr style='background:rgba(255,255,255,0.6);'>";
			echo "<td>".$cassVerdura['nome'].' '.$cassVerdura['cognome']."</td>";
				
			foreach ($cassVerdura['cassetta'] as $verdura) {
				echo "<td>".$verdura['stato'].'/'.$verdura['pref']."</td>";
			}
				
			echo "</tr>";
		}
		echo "</table>";
	}
} ?>

</div>