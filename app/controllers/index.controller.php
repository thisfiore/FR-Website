<?php

require_once ROOT.DS."../mandrill".DS."src".DS."Mandrill.php";
class IndexController extends Controller {
	
	public function __construct() {
		parent::__construct();
		$this->loadFile($this->method, $this->self);
	}
	
	public function getIndex() {
		
		if ( isset($this->idLoggedUser) || isset($_COOKIE['id_utente']) ) {
			$this->idLoggedUser = $_COOKIE['id_utente'];
			
			$this->getHome($this->idLoggedUser);
			die;
		}
		else {
			$loginScript = array(
					"login" => array(
							"type" => "text/javascript",
							"src" => "login.js")
					);
			$this->view->addScripts($loginScript);
			
			$this->view->load(null, 'login', null, null);
			$this->view->render();
		}
	}
	
	
	public function getPay ($idOrdineAdmin) {
		// check user is logged in
		if (!isset($_COOKIE['id_utente'])) {
			return header("Location: /index");
		} 
		$this->loadModules('ordine');
		$ordineModels = new Ordine();
		
		$this->loadModules('index');
		$indexModel = new Index();
		$utente = $indexModel->selectUtente($_COOKIE['id_utente']);
		
		$ordineUtente = $ordineModels->selectOrdineUtente($idOrdineAdmin, $_COOKIE['id_utente']);
		
		if (!isset($ordineUtente) || empty($ordineUtente)) {
			header('Location: /');
		}
		
		$listaSpesa = $this->_getListaSpesa($idOrdineAdmin);
		$prezzo_finale = 0;
		
		if (isset($listaSpesa) && !empty($listaSpesa)) {
			$this->loadModules('prodotti');
			$prodottiModels = new Prodotti();
		
			foreach ($listaSpesa as $key => $prodotto) {
				$item = $prodottiModels->selectProdottoMinimal($prodotto['id_prodotto']);
				$listaSpesa[$key]['nome_prodotto'] = $item['nome_prodotto'];
				$listaSpesa[$key]['prezzo_iva'] = $item['prezzo_iva'];
				$listaSpesa[$key]['unita'] = $item['unita'];
				
				$prezzo_finale = $prezzo_finale + ($prodotto['quantita'] * $item['prezzo_iva']);
			}
		}

// 		$this->boxPrint($listaSpesa);
// 		$this->boxPrint($prezzo_finale);
// 		die;
		
		$this->view->load('header', 'pay', null, null);
		$this->view->render( array(
									'utente' => $utente,
									'listaSpesa' => $listaSpesa,
									'prezzoFinale' => $prezzo_finale,
									'idOrdineAdmin' => $idOrdineAdmin,
									'ordineUtente' => $ordineUtente ) );
	}
	
	public function postLogin () {
		$username = isset($_POST['username']) ? $_POST['username'] : null;
		$password = isset($_POST['password']) ? $_POST['password'] : null;
// 		$password = md5($password);
		
		if ($username == null || $password == null) {
			$response = array( 'status' => 'ERR' ); 
			$this->view->renderJson($response);
		}
		
		$this->loadModules('index');
		$indexModels = new Index();
		$log = $indexModels->login($username, $password);
		
// 		CREAZIONE COOKIE O QUALSIASI ALTRA COSA
		if (isset($log) && !empty($log)) {
		
			setcookie( 'id_utente', $log['id_utente'], time() + 5184000, "/" );
			$this->idLoggedUser = $log['id_utente'];
			
			$response = array('status' => 'OK' );
			$this->view->renderJson($response);
		}
		else {
			$response = array( 'status' => 'ERR' );
			$this->view->renderJson($response);
		}
	}
	
// 	public function getPay () { 
// 		$this->view->load(null, 'pay', null, null);
// 		$this->view->render();
// 	}

	public function getHome() {
		
		$this->loadModules('prodotti');
		$prodottiModels = new Prodotti();
		
		$prodotti = $prodottiModels->selectAllProducts();
		
// 		$this->boxPrint($prodotti);
// 		die;
		$prezzo_finale = 0;
		$ordine_admin = $this->_getOrdineAdmin();
		
		if (!isset($ordine_admin) || empty($ordine_admin)) {
			echo "<h1>Sito in fase di perfezionamento</h1>";
			die;
		}

		$lista_spesa = array();
		
		$this->loadModules('ordine');
		$ordineModels = new Ordine();
		
		$ordineUtente = $ordineModels->selectOrdineUtente($ordine_admin['id_ordine_admin'], $_COOKIE['id_utente']);
		
		if (isset($ordineUtente) && !empty($ordineUtente) && $ordineUtente['stato'] == 1) {
			$this->getPay($ordine_admin['id_ordine_admin']);
			die;
		}
		else {

			if ($ordine_admin['stato'] == 1) {
				$lista_spesa = $this->_getListaSpesa($ordine_admin['id_ordine_admin']);
				
				if (isset($lista_spesa) && !empty($lista_spesa)) {
					foreach ($lista_spesa as $key => $prodotto) {
						$item = $prodottiModels->selectProdottoMinimal($prodotto['id_prodotto']);
						$lista_spesa[$key]['prodotto'] = $item;
						$lista_spesa[$key]['unita'] = $item['unita'];
						
						$prezzo_finale = $prezzo_finale + ($prodotto['quantita'] * $item['prezzo_iva']);
					}
				}
			}
			
			$this->loadModules('index');
			$indexModels = new Index();
			
			$utente = $indexModels->selectUtente($_COOKIE['id_utente']);
			
			$this->view->load('header', 'home', null, null);
			$this->view->render(array ( 	'prodotti' => $prodotti,
											'lista_spesa' => $lista_spesa,
											'prezzo_finale' => $prezzo_finale,
											'ordine_admin' => $ordine_admin,
											'utente' => $utente) );
		}
	}
	
	
	
	
	
	public function _getOrdineAdmin () {
		$this->loadModules('ordine');
		$ordineModels = new Ordine();
		
		$ordine_admin = $ordineModels->selectLastOrdineAdmin();
		return $ordine_admin;
	}
	
	
	public function _getListaSpesa ($idOrdineAdmin) {
		$this->loadModules('ordine');
		$ordineModels = new Ordine();
	
		$lista_spesa = $ordineModels->selectListaSpesa($_COOKIE['id_utente'], $idOrdineAdmin);
		return $lista_spesa;
	}
	
	public function postAddProdottoLista () {
		$idProdotto = $_POST['id_prodotto'];
		
		$this->loadModules('ordine');
		$ordineModel = new Ordine();
		
		$ordineAdmin = $this->_getOrdineAdmin();
		
		$ordine = $ordineModel->selectOrdineUtente($ordineAdmin['id_ordine_admin'], $_COOKIE['id_utente']);
	
		
		if (!isset($ordine) || empty($ordine)) {
			$ordineUtente['id_utente'] = $_COOKIE['id_utente'];
			$ordineUtente['stato'] = 0;
			$ordineUtente['pagamento'] = 0;
			$ordineUtente['id_ordine_admin'] = $ordineAdmin['id_ordine_admin'];
			$ordineUtente['data'] = date('Y-m-d');
			
			$insert = $ordineModel->insertOrdineUtente($ordineUtente);
			
			if (!isset($insert) || empty($insert)) {
				$response = array( 	'status' => 'ERR',
									'message' => 'error insert ordine' );
				$this->view->renderJson($response);
			}
			else {
				$idOrdine = $insert;
			}
		}
		else {
			$idOrdine = $ordine['id_ordine'];
		}
		
		$this->loadModules('prodotti');
		$prodottiModel = new Prodotti();
		
		$prodotto['id_ordine'] = $idOrdine;
		$prodotto['id_prodotto'] = $idProdotto;
		$prodotto['quantita'] = 1;
		
		$insert = $prodottiModel->insertProdottoLista($prodotto);
		
		if (!isset($insert) || empty($insert)) {
			$response = array( 'status' => 'ERR',
								'message' => 'error insert prodotto in lista spesa' );
			$this->view->renderJson($response);
		}
		else {
			$array = $prodottiModel->selectProdottoMinimal($idProdotto);
			$cella_lista['id_prodotto'] = $idProdotto;
			$cella_lista['id_ordine'] = $idOrdine;
			$cella_lista['unita'] = $array['unita'];
			$cella_lista['quantita'] = 1;
			$cella_lista['prodotto']['prezzo_iva'] = $array['prezzo_iva'];
			$cella_lista['prodotto']['nome_prodotto'] = $array['nome_prodotto'];
			
			$this->view->setHead(null);
			$this->view->load(null, '_partial/cella_lista', null, null);
			$this->view->render(  array ( 'cella_lista' => $cella_lista ) );
		}
	}
	
	
	public function getPagamento () {
		// check user is logged in
		if (!isset($_COOKIE['id_utente'])) {
			return header("Location: /index");
		}
		$idOrdineAdmin = $_GET['id_ordine_admin'];
		
		$this->loadModules('ordine');
		$ordineModel = new Ordine();
		
		$ordine['stato'] = 1;
		$ordine['id_utente'] = $_COOKIE['id_utente'];
		$ordine['id_ordine_admin'] = $idOrdineAdmin;
		
		$update = $ordineModel->updateOrdineUtente($ordine);
		
		if (isset($update) && !empty($update)) {
			
			$ordineUtente = $ordineModel->selectOrdineUtente($idOrdineAdmin, $_COOKIE['id_utente']);
			$ordineUtenteMaster['id_ordine'] = $ordineUtente['id_ordine'];
			
			$insert = $ordineModel->insertRicevuta($ordineUtenteMaster);
			
			$idOrdine['id_ordine'] = $this->sendMail($idOrdineAdmin, $insert);

			$response = array('status' => 'OK' );
			$this->view->renderJson($response);
		}
		else {
			$response = array( 'status' => 'ERR' );
			$this->view->renderJson($response);
		}
	}
	
	public function getLogout () {
		setcookie('id_utente', '', time()-3600, "/" );
		$response = array('status' => 'OK' );
		$this->view->renderJson($response);
	}
	
	
	public function sendMail ($idOrdineAdmin, $idRicevuta) {
		$this->loadModules('ordine');
		$ordineModel = new Ordine();
		$this->loadModules('index');
		$indexModel = new Index();
		
		$utente = $indexModel->selectUtente($_COOKIE['id_utente']);
		$listaSpesa = $this->_getListaSpesa($idOrdineAdmin);
		$plain_text = '';
		$prezzo_finale = 0;
		
		if (isset($listaSpesa) && !empty($listaSpesa)) {
			$this->loadModules('prodotti');
			$prodottiModels = new Prodotti();
		
			foreach ($listaSpesa as $key => $prodotto) {
				$item = $prodottiModels->selectProdottoMinimal($prodotto['id_prodotto']);
				$listaSpesa[$key]['nome_prodotto'] = $item['nome_prodotto'];
				$listaSpesa[$key]['prezzo_iva'] = $item['prezzo_iva'];
				$listaSpesa[$key]['unita'] = $item['unita'];
				
				$idOrdine = $listaSpesa[$key]['id_ordine'];
				
				$plain_text .= $item['nome_prodotto'].' | '.$item['unita'].' | '.$item['prezzo_iva'].' | '.$prodotto['quantita'].' | '.($prodotto['quantita']*$item['prezzo_iva'])." � \n";
				
				$prezzo_finale = $prezzo_finale + ($prodotto['quantita'] * $item['prezzo_iva']);
			}
		}
		
// 		$this->boxPrint($plain_text);
// 		die;
		
		$notice_text = "Grazie per avere effettuato un ordine su Food Republic.\nSegue la tua ricevuta e riepilogo della tua spesa.\n\nIl team Food Republic\n\nFood Republic S.r.l.\nVia Fratta, 2\n31020 San Zenone degli Ezzelini, TV\nPart. IVA 04496450265\n\nRicevuta 2013/".$idRicevuta." - ".$utente['nome']." ".$utente['cognome'];

// 		$html_text = "<html><body>This is an <b style='color:purple'>HTML</b> text email.\r\nIt is very cool.</body></html>";
		
		$semi_rand = md5(time());
		$mime_boundary = "==MULTIPART_BOUNDARY_$semi_rand";
		$mime_boundary_header = chr(34) . $mime_boundary . chr(34);
		
		$to = $utente['nome']." ".$utente['cognome']." ricca.prog@gmail.com"; //<".$utente['username'].">
		$from = "FoodRepublic <info@food-republic.it>";
		$subject = "La tua Ricevuta #".$idRicevuta;
		
		$body = "$notice_text\n\n$plain_text\n## TOTALE $prezzo_finale\n\nGrazie per aver sostenuto l'agricolura della tua Food Community, acquistando prodotti attraverso Food Republic circa l�80% del denaro da te speso va ai produttori, il resto copre le spese di trasporto e di gestione del sito.\n\nStampa e conserva questa ricevuta che ti da diritto a ritirare I prodotti da te acquistati presso:\n
".$utente['indirizzo'].", il giorno ".$listaSpesa[0]['data']." alle ore ".$utente['ora_consegna'];
				
		if (@mail($to, $subject, $body,
		    "From: " . $from . "\n" .
		    "MIME-Version: 1.0\n" .
		    "Content-Type: multipart/alternative;\n" .
		    "     boundary=" . $mime_boundary_header)) {
		    
		   $checkMail = $idOrdine;
		}
		else {
		    $checkMail = $idOrdine;
		}
		
		   return $checkMail;
	}
}