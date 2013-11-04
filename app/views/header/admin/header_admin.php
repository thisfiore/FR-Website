<div class="row-fluid header">
	<div class="span8">
		<img width="50" src="/img/fr-small-logo.png" />
		<span class="fr">Food Republic</span>
	</div>
	<div class="span8 user text-right">
		<strong><?php echo $utente['nome'].' '.$utente['cognome'] ?></strong><br />
		<div><?php echo $utente['nome_gruppo'] ?> <i class="icon-white icon-map-marker"></i><?php echo $utente['indirizzo'] ?></div>
		<a class="logout" href="#" target="_self">Logout</a>
		<!-- 		<img class="user-img" style="background:url('/img/users/albi.jpg');" /> -->	
	</div>
	<div class="span16" style="margin: 10px 0px 10px 19px; padding-right: 37px;">
		<div class="pull-left" style="padding-left: 0px;">
			<button class="btn selector btn-primary" data-switch='adminProduttori' data-id_ordine_admin = "<?php echo $idOrdineAdmin?>">Admin Produttori</button>
			<button class="btn selector" data-switch='adminGruppi' data-id_ordine_admin = "<?php echo $idOrdineAdmin?>">Admin Gruppi</button>
			<select class="selectpicker" data-style="btn-success" style="margin: 0;">
			<?php foreach ($allIdOrdineAdmin as $tuttiOrdiniAdmin) { ?>
			    <option value="<?php echo $tuttiOrdiniAdmin['id_ordine_admin'] ?>"><?php echo '#'.$tuttiOrdiniAdmin['id_ordine_admin'].' '.$tuttiOrdiniAdmin['data'] ?></option>
			<?php } ?>
			</select>
		</div>
		<div class="pull-right ordineadmin">
		<?php 
		if ($admin['stato'] == 1) { ?>
			<button class="btn order-admin btn-danger" data-value='0'">Chiudi ordine</button>
		<?php 
		}
		else { ?>
			<button class="btn order-admin btn-success" data-value='1'">Apri nuovo ordine</button>
		<?php } ?>
		</div>
	</div>
</div>
<div class="content" style="padding-top:90px">