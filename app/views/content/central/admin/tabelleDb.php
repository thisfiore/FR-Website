
	<ul class="nav nav-tabs" style="padding-top:90px">
	  <li class="span4 active" data-select="Prodotti"> <a href="#">Prodotti</a> </li>
	  <li class="span4" data-select="Produttori"><a href="#">Produttori</a></li>
	  <li class="span4" data-select="Utenti"><a href="#">Utenti</a></li>
	</ul>
	
	<div class="tabsDb">
	
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
						echo "
								</select>
							</th>
							<th data-field='nome_prodotto'><input class='target' type='text' value=".htmlentities($prodotto['nome_prodotto'])."></th>
							<th data-field='desc'><textarea class='target' rows='4' cols='50'>".$prodotto['desc']."</textarea></th>
							<th data-field='unita'><input class='target' type='text' value=".htmlentities($prodotto['unita'])."></th>
							<th data-field='quantita'><input class='target' type='number' value=".htmlentities($prodotto['quantita'])."></th>
							<th data-field='prezzo'><input class='target' type='number' value=".htmlentities($prodotto['prezzo'])."></th>
							<th data-field='iva'><input class='target' type='number' value=".htmlentities($prodotto['iva'])."></th>
							<th data-field='stato'><input class='target' type='number' value=".htmlentities($prodotto['stato'])."></th>
							<th data-field='image'><input class='target' type='text' value=".$prodotto['image']."></th>
							<th data-field='tipologia'><input class='target' type='text' value=".$prodotto['tipologia']."></th>
							<th data-field='bio'><input class='target' type='number' value=".htmlentities($prodotto['bio'])."></th>
							<th data-field='proprio'><input class='target' type='number' value=".htmlentities($prodotto['proprio'])."></th>
							<th data-field='prenotazione'><input class='target' type='number' value=".htmlentities($prodotto['prenotazione'])."></th>
							<th data-field='data_consegna_pren'><input class='target' type='date' value=".$prodotto['data_consegna_pren']."></th>
						</tr>";
				}	
				?>
			</tbody>
		</table>
		
	</div>
	
	<!-- USE THIS FOR OUTPUT OF STATES -->
    <div class="status hide"></div>