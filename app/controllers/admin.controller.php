<?php

class AdminController extends Controller {
	
	public function __construct() {
		parent::__construct();
		$this->loadFile($this->method, $this->self);
	}
	
	
	public function getIndex () {
		$availableUser = array('1', '2');
		
		// Check user is logged in and if it's admin
		if ( !isset($_COOKIE['id_utente']) || !in_array($_COOKIE['id_utente'], $availableUser) ) {
			return header("Location: /index");
		}
		
		$this->loadModules('ordine');
		$ordineModels = new Ordine();
		$admin = $ordineModels->selectLastOrdineAdmin();
		$allIdOrdineAdmin = $ordineModels->selectAllOrdineAdmin();
		
		if ( isset($allIdOrdineAdmin) && !empty($allIdOrdineAdmin) ) {
			foreach ($allIdOrdineAdmin as $key => $tuttiOrdiniAdmin) {
				$allIdOrdineAdmin[$key]['data'] = $this->formatData($tuttiOrdiniAdmin['data']);
			}
		}
		else {
			$ordineAdmin['markup'] = 0;
			$ordineAdmin['stato'] = 0;
			$ordineAdmin['data'] = date('Y-m-d');
			$ordineAdmin['data_consegna'] = date('Y-m-d');
			
			$insert = $ordineModels->insertOrdineAdmin($ordineAdmin);
		}
		
		$this->loadModules('index');
		$indexModels = new Index();
		$utente = $indexModels->selectUtente($_COOKIE['id_utente']);
		
		$idOrdineAdmin = (isset($_GET['id_ordine_admin'])) ? $_GET['id_ordine_admin'] : null;
		
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
				
// 				Compilo la cassetta se esiste
				if ($prodotto['unita'] == "Cassetta") {
					if (!isset($cassetta) || empty($cassetta)){
						$cassetta = array();
					}
					
					if (strpos($prodotto['nome_prodotto'],'verdura') !== false) {
						$cassetta['verdura'][] = $this->getCassetta($prodotto, $ordine);
					}
					else {
						$cassetta['frutta'][] = $this->getCassetta($prodotto, $ordine);
					}
				}
				
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
					
// 					if ($prodotto['unita'] == "Cassetta") {
// 						$adminProduttori[$prodotto['id_produttore']]['gruppi'][$ordine['id_gruppo']]['prodotto'][$prodotto['id_prodotto']]['cassetta'] = $prodottiModels->selectCassettaPay($prodotto['id_prodotto'], $ordine['id_ordine']);
						
// 						foreach ($adminProduttori[$prodotto['id_produttore']]['gruppi'][$ordine['id_gruppo']]['prodotto'][$prodotto['id_prodotto']]['cassetta'] as $index => $prodottoCassetta) {
// 							$adminProduttori[$prodotto['id_produttore']]['gruppi'][$ordine['id_gruppo']]['prodotto'][$prodotto['id_prodotto']]['cassetta'][$index] = array_merge($adminProduttori[$prodotto['id_produttore']]['gruppi'][$ordine['id_gruppo']]['prodotto'][$prodotto['id_prodotto']]['cassetta'][$index], $prodottiModels->selectProdottoCassetta($prodottoCassetta['id_prodotto']));
// 						}
// 					}
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
			
// 			$this->boxPrint($cassetta);
// 			die;
			
			if ($this->isAjax()) {
				$this->view->setHead(null);
				$this->view->load(null, 'adminProduttori', null, null);
				$this->view->render( array( 'adminProduttori' => $adminProduttori,
											'allIdOrdineAdmin' => $allIdOrdineAdmin,
											'cassetta' => $cassetta,
											'idOrdineAdmin' => $idOrdineAdmin,
											'utente' => $utente ) );
			}
			else {
				$adminScript = array(
								"projectScript" => array(
													"type" => "text/javascript",
													"src" => "admin.js"),
								"tabsScript" => array(
										"type" => "text/javascript",
										"src" => "jquery.tabs.js"),
				);
					
				$this->view->addScripts($adminScript);
				$this->view->load('header_admin', 'adminProduttori', null, null);
				$this->view->render( array(	'admin' => $admin,	
											'adminProduttori' => $adminProduttori,
											'allIdOrdineAdmin' => $allIdOrdineAdmin,
											'cassetta' => $cassetta,
											'idOrdineAdmin' => $idOrdineAdmin,
											'utente' => $utente ) );
			}

		}
		else {
			if ($this->isAjax()) {
				$this->view->setHead(null);
				$this->view->load(null, 'noOrdini', null, null);
				$this->view->render(array(	'utente' => $utente,
											'admin' => $admin,
											'idOrdineAdmin' => $idOrdineAdmin,
											'allIdOrdineAdmin' => $allIdOrdineAdmin ) );
			}
			else {
				$adminScript = array(
								"projectScript" => array(
													"type" => "text/javascript",
													"src" => "admin.js"),
								"tabsScript" => array(
										"type" => "text/javascript",
										"src" => "jquery.tabs.js"),
				);
					
				$this->view->addScripts($adminScript);
				$this->view->load('header_admin', 'noOrdini', null, null);
				$this->view->render(array(	'utente' => $utente,
											'admin' => $admin,
											'idOrdineAdmin' => $idOrdineAdmin,
											'allIdOrdineAdmin' => $allIdOrdineAdmin ) );
			}
		}
	}
	
	
	public function formatData ($data){
		$array = explode("-", $data);
		$data = $array[2].'/'.$array[1].'/'.$array[0];
		return $data;
	}
	
	public function postAdminGruppi () {
		$availableUser = array('1', '2');
		
		// Check user is logged in and if it's admin
		if ( !isset($_COOKIE['id_utente']) || !in_array($_COOKIE['id_utente'], $availableUser) ) {
			return header("Location: /index");
		}
		
		$idOrdineAdmin = $_POST['id_ordine_admin'];
		
		$this->loadModules('ordine');
		$ordineModels = new Ordine();
		$elencoOrdini = $ordineModels->selectOrdiniUtentiProduttori($idOrdineAdmin);
		
		$adminGruppi = array();
		if (isset($elencoOrdini) && !empty($elencoOrdini)) {
			$this->loadModules('index');
			$indexModels = new Index();
			
			$gruppi = $indexModels->selectGruppi();
			foreach ($gruppi as $gruppo) {
				$adminGruppi[$gruppo['id_gruppo']] = $gruppo;
			}
			
			foreach ($elencoOrdini as $ordine) {
				$utente = $indexModels->selectUtenteSingolo($ordine['id_utente']);
				
				$adminGruppi[$utente['id_gruppo']]['utenti'][$utente['id_utente']] = $utente;
				$adminGruppi[$utente['id_gruppo']]['utenti'][$utente['id_utente']]['pagamento'] = $ordine['pagamento'];
				$prodotti = $ordineModels->selectListaSpesaPrezzo($ordine['id_ordine']);
				
				$totale = 0;
				foreach ($prodotti as $prodotto) {
					$adminGruppi[$utente['id_gruppo']]['utenti'][$utente['id_utente']]['prodotto'][$prodotto['id_prodotto']] = $prodotto;
					$adminGruppi[$utente['id_gruppo']]['utenti'][$utente['id_utente']]['prodotto'][$prodotto['id_prodotto']]['totale'] = ($prodotto['quantita']*$prodotto['prezzo_iva']);
					
					$totale += ($prodotto['quantita']*$prodotto['prezzo_iva']);
				}
				
				$adminGruppi[$utente['id_gruppo']]['utenti'][$utente['id_utente']]['totale_utente'] = $totale;
			}
			
		}	
		
// 		$this->boxPrint($adminGruppi);
// 		die;
		
		$this->view->setHead(null);
		$this->view->load(null, 'adminGruppi', null, null);
		$this->view->render( array( 'adminGruppi' => $adminGruppi) );
	}
	
	
	public function postOpenOrderAdmin() {
		$this->loadModules('ordine');
		$ordineModels = new Ordine();
		
		$stato = $_POST['stato'];
	
		if ($stato == 1) {
			$ordineAdmin['markup'] = $_POST['markup'];
			$ordineAdmin['stato'] = $stato;
			$ordineAdmin['data'] = date('Y-m-d');
			$ordineAdmin['data_consegna'] = $_POST['data_consegna'];
			
// 			$this->boxPrint($ordineAdmin);
// 			die;
		
			$insert = $ordineModels->insertOrdineAdmin($ordineAdmin);
			
			if (isset($insert) && !empty($insert)) {
				$response = array( 'status' => 'OK',);
				$this->view->renderJson($response);
			}
			else {
				$response = array( 	'status' => 'ERR',
									'message' => 'errore insert ordine admin');
				$this->view->renderJson($response);
			}
		}
		else if ($stato == 0) {
			$ordineAdmin = $ordineModels->selectLastOrdineAdmin();
			$ordineAdmin['stato'] = $stato;
			
			$update = $ordineModels->updateOrdineAdmin($ordineAdmin);
			
			if (isset($update) && !empty($update)) {
				$response = array( 'status' => 'OK',);
				$this->view->renderJson($response);
			}
			else {
				$response = array( 	'status' => 'ERR',
									'message' => 'errore update ordine admin');
				$this->view->renderJson($response);
			}
		}
	}
	
	
	public function getCassetta($cassetta, $ordine){
		$this->loadModules('prodotti');
		$prodottiModels = new Prodotti();
		$this->loadModules('index');
		$indexModels = new Index();
		
		$elementiCassetta = $indexModels->selectUtentePerCassetta($ordine['id_utente']);
		$elementiCassetta['cassetta'] = $prodottiModels->selectCassettaPay($cassetta['id_prodotto'], $ordine['id_ordine']);
		
		foreach ($elementiCassetta['cassetta'] as $index => $prodottoCassetta) {
			$elementiCassetta['cassetta'][$index] = array_merge($elementiCassetta['cassetta'][$index], $prodottiModels->selectProdottoCassetta($prodottoCassetta['id_prodotto']));
		}
		
		return $elementiCassetta;
	}
	
	
	public function getTabelleDb() {
		
		$this->loadModules('prodotti');
		$prodottiModels = new Prodotti();
		
		$prodotti = $prodottiModels->selectAllProducts();
		$produttori = $prodottiModels->selectAllProduttori();
		$label = "prodotti";
		
// 		$this->boxPrint($prodotti);
// 		die;
		
		$this->view->setHead(null);
		$this->view->load(null, 'tabelleDb', null, null);
		$this->view->render( array( 'label' => $label,
									'prodotti' => $prodotti,
									'produttori' => $produttori) );
	}
	
	
	public function getTabProdotti() {
		$this->loadModules('prodotti');
		$prodottiModels = new Prodotti();
	
		$prodotti = $prodottiModels->selectAllProducts();
		$produttori = $prodottiModels->selectAllProduttori();
		$label = "prodotti";
	
		// 		$this->boxPrint($prodotti);
		// 		die;
	
		$this->view->setHead(null);
		$this->view->load(null, '/_partial/tab_prodotti', null, null);
		$this->view->render( array( 'label' => $label,
									'prodotti' => $prodotti,
									'produttori' => $produttori) );
	}
	
	
	public function getTabProduttori() {
		$this->loadModules('prodotti');
		$prodottiModels = new Prodotti();
	
		$produttori = $prodottiModels->selectAllProduttori();
		$label = "produttori";
	
		// 		$this->boxPrint($prodotti);
		// 		die;
	
		$this->view->setHead(null);
		$this->view->load(null, '/_partial/tab_produttori', null, null);
		$this->view->render( array( 'label' => $label,
									'produttori' => $produttori) );
	}
	
	
	public function getTabUtenti() {
		$this->loadModules('index');
		$indexModels = new Index();
	
		$utenti = $indexModels->selectUtenti();
		$gruppi = $indexModels->selectGruppi();
		$label = "utenti";
	
// 		$this->boxPrint($prodotti);
// 		die;
	
		$this->view->setHead(null);
		$this->view->load(null, '/_partial/tab_utenti', null, null);
		$this->view->render( array( 'label' => $label,
									'gruppi' => $gruppi,
									'utenti' => $utenti) );
	}
	
	
	public function postUpdateProduttori() {
		$produttore[$_POST['field']] = $_POST['value'];
		$produttore["id_produttore"] = $_POST['id'];
		
		$this->loadModules('prodotti');
		$prodottiModels = new Prodotti();
		
		$update = $prodottiModels->updateProduttore($produttore);

		if (isset($update) && !empty($update)) {
				$response = array( 'status' => 'OK',);
				$this->view->renderJson($response);
		}
		else {
				$response = array( 	'status' => 'ERR',
									'message' => 'errore update Produttori');
				$this->view->renderJson($response);
		}
	}
	
	public function postUpdateProdotti() {
		$prodotto[$_POST['field']] = $_POST['value'];
		$prodotto["id_prodotto"] = $_POST['id'];
		
		$this->loadModules('prodotti');
		$prodottiModels = new Prodotti();
		
		$update = $prodottiModels->updateProdotto($prodotto);
		
		if (isset($update) && !empty($update)) {
				$response = array( 'status' => 'OK',);
				$this->view->renderJson($response);
		}
		else {
				$response = array( 	'status' => 'ERR',
									'message' => 'errore update Prodotto');
				$this->view->renderJson($response);
		}
	}
	
	public function postUpdateUtenti() {
		$utente[$_POST['field']] = $_POST['value'];
		$utente["id_utente"] = $_POST['id'];
		
		$this->loadModules('index');
		$indexModels = new Index();
		
		$update = $indexModels->updateUtente($utente);
		
		if (isset($update) && !empty($update)) {
				$response = array( 'status' => 'OK',);
				$this->view->renderJson($response);
		}
		else {
				$response = array( 	'status' => 'ERR',
									'message' => 'errore update Utente');
				$this->view->renderJson($response);
		}
	}
}