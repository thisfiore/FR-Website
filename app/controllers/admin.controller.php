<?php

class AdminController extends Controller {
	
	public function __construct() {
		parent::__construct();
		$this->loadFile($this->method, $this->self);
	}
	
	
	public function getIndex ($idOrdineAdmin = null) {
		$availableUser = array('1', '2');
		
		// check user is logged in and if it's admin
		if ( !isset($_COOKIE['id_utente']) || !in_array($_COOKIE['id_utente'], $availableUser) ) {
			return header("Location: /index");
		}
		
		$this->loadModules('ordine');
		$ordineModels = new Ordine();
		
		if ( !isset($idOrdineAdmin) || empty($idOrdineAdmin) ) {
			$ordine_admin = $ordineModels->selectLastOrdineAdmin();
			$idOrdineAdmin = $ordine_admin['id_ordine_admin'];
		}
		
		$elencoOrdini = $ordineModels->selectOrdiniUtentiProduttori($idOrdineAdmin);
		
		if (isset($elencoOrdini) && !empty($elencoOrdini)) {
			$produttori = $ordineModels->selectProduttori();
			$adminProduttori = array();
			
			foreach ($produttori as $produttore) {
				$adminProduttori[$produttore['id_produttore']] = $produttore;
			}
			
			$this->loadModules('prodotti');
			$prodottiModels = new Prodotti();
			
			foreach ($elencoOrdini as $ordine) {
				$prodotto = $prodottiModels->selectProdottoAdminProduttori($ordine['id_prodotto']);
				
				if (!isset($adminProduttori[$prodotto['id_produttore']]['gruppi'][$ordine['id_gruppo']]) || empty($adminProduttori[$prodotto['id_produttore']]['gruppi'][$ordine['id_gruppo']])) {
					$adminProduttori[$prodotto['id_produttore']]['gruppi'][$ordine['id_gruppo']] = $ordineModels->selectGruppoPerProduttori($ordine['id_gruppo']);
					$adminProduttori[$prodotto['id_produttore']]['gruppi'][$ordine['id_gruppo']]['array'] = array();
// 					$adminProduttori[$prodotto['id_produttore']]['gruppi'][$ordine['id_gruppo']]['totale_gruppo'] = 0;
				}

				if (!in_array($prodotto['id_prodotto'], $adminProduttori[$prodotto['id_produttore']]['gruppi'][$ordine['id_gruppo']]['array'])) {
					$adminProduttori[$prodotto['id_produttore']]['gruppi'][$ordine['id_gruppo']]['array'][] = $prodotto['id_prodotto'];
					$adminProduttori[$prodotto['id_produttore']]['gruppi'][$ordine['id_gruppo']]['prodotto'][$prodotto['id_prodotto']] = $prodotto;
					$adminProduttori[$prodotto['id_produttore']]['gruppi'][$ordine['id_gruppo']]['prodotto'][$prodotto['id_prodotto']]['quantita'] = $ordine['quantita'];
					$adminProduttori[$prodotto['id_produttore']]['gruppi'][$ordine['id_gruppo']]['prodotto'][$prodotto['id_prodotto']]['totale'] = $prodotto['prezzo_iva']*$ordine['quantita'];
				}
				else {
					$adminProduttori[$prodotto['id_produttore']]['gruppi'][$ordine['id_gruppo']]['prodotto'][$prodotto['id_prodotto']]['quantita'] += $ordine['quantita'];
					$adminProduttori[$prodotto['id_produttore']]['gruppi'][$ordine['id_gruppo']]['prodotto'][$prodotto['id_prodotto']]['totale'] += ($prodotto['prezzo_iva']*$ordine['quantita']);
				}
				
				if (isset($adminProduttori[$prodotto['id_produttore']]['gruppi'][$ordine['id_gruppo']]['totale_gruppo'])) {
					$adminProduttori[$prodotto['id_produttore']]['gruppi'][$ordine['id_gruppo']]['totale_gruppo'] += ($prodotto['prezzo_iva']*$ordine['quantita']);
				}
				else {
					$adminProduttori[$prodotto['id_produttore']]['gruppi'][$ordine['id_gruppo']]['totale_gruppo'] = ($prodotto['prezzo_iva']*$ordine['quantita']);
				}
				
			}
			
// 			$this->boxPrint($adminProduttori);
// 			die;
			
			$this->view->load(null, 'index', null, null);
			$this->view->render( array( 'adminProduttori' => $adminProduttori) );
		}
		
		
		
		
	}
	
}