<?php 
// print_r($admin);
// die;
?>
<div class="row-fluid header">
	<div class="span7">
		<img width="50" src="/img/fr-small-logo.png" />
		<span class="fr">Food Republic</span>
	</div>
	<div class="span3">
		<a href="/index/">
			<button class="btn btn-large btn-warning" type="submit" >FoodRepublic</button>
		</a>
	</div>
	<div class="span6 user text-right">
		<strong><?php echo $utente['nome'].' '.$utente['cognome'] ?></strong><br />
		<div><?php echo $utente['nome_gruppo'] ?> <i class="icon-white icon-map-marker"></i><?php echo $utente['indirizzo'] ?></div>
		<a class="logout" href="#" target="_self">Logout</a>
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

<!-- MODAL CREA ORDINE ADMIN -->
<div id="modal-admin" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="prodLabel" aria-hidden="true">  

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	<h4 id="prodLabel">Crea un nuovo ordine</h4>
</div>

<div class="modal-body">
<p>Come giorno di apertura viene considerato oggi!</p>

<div class="control-group">
	<input type="number" class="input-block-level tck big" id="markup" name="markup" placeholder="Inserisci il MARKUP dell'ordine"/>
	<span class="help-inline hide"></span>
</div>

<div class="control-group">
	<input type="date" class="input-block-level tck big" id="data" name="data" placeholder="Inserisci la di chiusura ordine"/>
	<span class="help-inline hide"></span>
</div>

</div>

<div class="modal-footer">
	<button class="btn btn-large" data-dismiss="modal" aria-hidden="true">Chiudi</button>
	<button class="btn btn-large btn-success submit" aria-hidden="true">Apri Ordine</button>
</div>

</div>

<!-- CONTENT PAGE ADMIN -->
<div class="content" style="padding-top:90px">
