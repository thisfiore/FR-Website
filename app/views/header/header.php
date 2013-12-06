<div class="row-fluid header">
<?php 
	if ($utente['id_utente'] == 1 || $utente['id_utente'] == 2) {
		echo "	<div class='span7'>
					<img width='50' src='/img/fr-small-logo.png' />
					<span class='fr'>Food Republic</span>
				</div>
				<div class='span3'>
					<a href='/admin/'>
						<button class='btn btn-large btn-warning' type='submit' >Admin</button>
					</a>
				</div>
				<div class='span6 user text-right'>
 					<strong>".$utente['nome']." ".$utente['cognome']."</strong><br />
					<div>".$utente['nome_gruppo']."<i class='icon-white icon-map-marker'></i>".$utente['indirizzo']."</div>
					<a class='logout' href='#' target='_self'>Logout</a>
				</div>";
		}
		else {
		?>
		<div class='span8'>
			<img width='50' src='/img/fr-small-logo.png' />
			<span class='fr'>Food Republic</span>
		</div>
		<div class='span8 user text-right'>
			<strong><?php echo $utente['nome'].' '.$utente['cognome'] ?></strong><br />
			<div><?php echo $utente['nome_gruppo'] ?> <i class="icon-white icon-map-marker"></i><?php echo $utente['indirizzo'] ?></div>
			<a class="logout" href="#" target="_self">Logout</a>
	<!-- 		<img class="user-img" style="background:url('/img/users/albi.jpg');" /> -->	
		</div>
	<?php }?>
	
</div>
<div class="content">