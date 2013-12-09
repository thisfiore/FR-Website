<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
<h4 id="prodLabel">Prenota i tuoi polli entro questo giovedì!</h4>
<h5>Consegna prevista per la 2a o 3a settimana di gennaio</h5>
</div>
<div class="modal-body">
 
 
<p class="pagination-centered">
	<img src="/img/polli.jpg" style="position:relative;"/>
	<div class="ribbon-wrapper-green alt">
		<div class="ribbon-green alt">scadenza <br><?php echo $prodotto['data_fine_ordine']?></div>
	</div>
</p>
	
<br>
<p>
<?php echo $prodotto['desc']?>
</p>	
<p>
Cari amici, i nostri polli stanno crescendo: ora hanno poco meno di 3 mesi e a <strong>metà gennaio</strong> saranno pronti per la macellazione.<br>
In questo momento si trovano sulla strada per Campo Croce a 700 m di altezza e la loro razione alimentare è molto varia e salutare sia per i polli che per chi li mangerà. Per la prevenzione di malattie, usiamo prodotti naturali della nostra terra. In questo modo alleviamo meno capi, ma evitiamo loro malattie e problemi sanitari, puntando sul loro reale benessere.
</p>
<p>
Il pollo viene confezionato "a busto", cioè totalmente pulito, sviscerato e senza testa, né zampe. Il fatto che sia intero, per noi, è anche garanzia di una migliore qualità delle carni.<br>
I polli avranno un peso di <strong>2 kg circa</strong> e dovranno essere prenotati entro la chiusura di questo ordine, cioè <strong>entro giovedì 12 alle ore 13.30</strong>.
<strong>La consegna avverrà la seconda o terza settimana di gennaio</strong>, a seconda di quando i nostri polli saranno pronti per il macello.
</p>
<p>
La prenotazione non comporta un pagamento immediato ma è una procedura vincolante, quindi non sarete più in grado di cancellarla una volta effettuata.
</p>


<br>
	
<ul>
	<li class="item row-fluid">
		<div class="span16" style="margin-bottom:10px;">
			<span style="margin-left:5px" class="span8">&nbsp;</span>
			<span class="quantita span3"><?php echo $prodotto['unita']?></span>
			<span class="partial span4 text-right"> €</span>
		</div>
	</li>
	<li class="item row-fluid">
		<div class="alert alert-warning span16">
			<span style="margin-left:5px" class="span8"><?php echo $prodotto['nome_prodotto']?></span>
			
			<div class="quantity text-center span3" 
				data-data_consegna_pren='<?php echo $prodotto['data_consegna_pren']?>'
				data-id_prodotto='<?php echo $prodotto['id_prodotto']?>'
				data-quantita='1' 
				data-unita="<?php echo $prodotto['unita']?>"
				data-prezzo='<?php echo $prodotto['prezzo_iva']?>'>
				<span class="meno">-</span>
				<span class="quantita" style="border:none;">1</span>
				<span class="piu">+</span>
			</div>
			<span class="partial span4 text-right" data-partial="<?php echo $prodotto['prezzo_iva']?>"><?php echo $prodotto['prezzo_iva']?>€</span>
		</div>
	</li>
</ul>
	
</div>

<div class="modal-footer modal-prenota">
		    <button class="btn btn-large" data-dismiss="modal" aria-hidden="true">Chiudi</button>
		    <?php 
		    if (!isset($check) || empty($check)) {  ?>
		    	<button class="btn btn-large btn-success prenota" type="submit" data-term="">Prenota Ora</button>
		    <?php 
		    }
		    else { ?>
		    	<button class="btn btn-large btn-warning prenota block" type="submit" data-term="">Prodotto prenotato</button>
		    <?php }?>
		    </div>