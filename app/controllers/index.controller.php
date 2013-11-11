<?php

// require_once ROOT.DS."../mandrill".DS."src".DS."Mandrill.php";
class IndexController extends Controller {
	
	public function __construct() {
		parent::__construct();
		$this->loadFile($this->method, $this->self);
	}
	
	public function postIndex() {
		
		if (isset($_POST['custom']) && !empty($_POST['custom'])) {
			$ordine['id_ordine_admin'] = $_POST['custom'];
			$ordine['stato'] = 1;
			$ordine['id_utente'] = $_COOKIE['id_utente'];
			$ordine['pagamento'] = 'paypal';
			
			$this->loadModules('ordine');
			$ordineModel = new Ordine();
			$update = $ordineModel->updateOrdineUtente($ordine);
			
			if (isset($update) && !empty($update)) {
				$ordineUtente = $ordineModel->selectOrdineUtente($ordine['id_ordine_admin'], $_COOKIE['id_utente']);
				
// 				$this->boxPrint($ordineUtente);
// 				die;
				
				$idOrdineUtente['id_ordine'] = $ordineUtente['id_ordine'];
				$insert = $ordineModel->insertRicevuta($idOrdineUtente);
				
				if (isset($insert) && !empty($insert)) {
					$idOrdine['id_ordine'] = $this->sendMail($ordine['id_ordine_admin'], $insert);
						
					header("location: /");
				}
				else {
					$response = array( 	'status' => 'ERR', 
										'message' => 'errore insert notifica');
					$this->view->renderJson($response);
				}
			}
			else {
				$response = array( 	'status' => 'ERR', 
									'message' => 'errore update ordine utente');
				$this->view->renderJson($response);
			}
			
		}
		else {
			
		}
		
	}
	
	public function getIndex() {
		
		if ( isset($this->idLoggedUser) || isset($_COOKIE['id_utente']) ) {
			$this->idLoggedUser = $_COOKIE['id_utente'];
			
			$this->getHome($this->idLoggedUser);
			die;
		}
		else {
			$browser = $_SERVER['HTTP_USER_AGENT'];
			
// 			$this->boxPrint(strpos($browser, 'Mozilla'));
// 			die;
			
			$loginScript = array(
					"login" => array(
							"type" => "text/javascript",
							"src" => "login.js")
					);
			$this->view->addScripts($loginScript);
			
			$this->view->load(null, 'login', null, null);
			$this->view->render( array('browser' => $browser) );
		}
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
	
	
	public function postSignup () {
		$utente = $_POST;
		$utente['nome'] = ucfirst($utente['nome']);
		$utente['cognome'] = ucfirst($utente['cognome']);
		$utente['cf'] = strtoupper($utente['cf']);
		
		$this->loadModules('index');
		$indexModels = new Index();
		$utenteAdmin = $indexModels->selectUtenteMail($utente['mail_inviter']);
		
		unset($utente['mail_inviter']);
		$utente['id_gruppo'] = $utenteAdmin['id_gruppo'];
		
		$id_utente = $indexModels->insertUtente($utente);
		
		setcookie( 'id_utente', $id_utente, time() + 5184000, "/" );
		$this->idLoggedUser = $id_utente;
		
		// 		CREAZIONE COOKIE O QUALSIASI ALTRA COSA
		if (isset($id_utente) && !empty($id_utente)) {
	
			setcookie( 'id_utente', $id_utente, time() + 5184000, "/" );
			$this->idLoggedUser = $id_utente;
				
			$response = array('status' => 'OK' );
			$this->view->renderJson($response);
		}
		else {
			$response = array( 'status' => 'ERR' );
			$this->view->renderJson($response);
		}
	}
	
	public function getEmailInvito () {
		$email_inviter = $_GET['mail_inviter'];
		$username = $_GET['email'];
		
		$this->loadModules('index');
		$indexModels = new Index();
		
// 		Cerco se la mail  giˆ stata inserita
		$utente = $indexModels->selectUtenteMail($username);
		if (isset($utente) && !empty($utente)) {
			$response = array(	'status' => 'USER',
								'message' => 'Email gia\' utilizzata' );
			$this->view->renderJson($response);
		}
		
		$utenteAdmin = $indexModels->selectUtenteMail($email_inviter);
		if (isset($utenteAdmin) && !empty($utenteAdmin)) {
			$response = array(	'status' => 'OK',
								'message' => 'Email corretta' );
			$this->view->renderJson($response);
		}
		else {
			$response = array(	'status' => 'ERR',
								'message' => 'Email di invito non trovata' );
			$this->view->renderJson($response);
		}
		
	}
	
	
	public function getSignup () { 
		$signupScript = array(
				"login" => array(
						"type" => "text/javascript",
						"src" => "signup.js")
		);
		$this->view->addScripts($signupScript);
		
		$this->view->load(null, 'signup', null, null);
		$this->view->render();
	}

	
	public function getHome() {
		
		$this->loadModules('prodotti');
		$prodottiModels = new Prodotti();
		$this->loadModules('index');
		$indexModels = new Index();
		
		$utente = $indexModels->selectUtente($_COOKIE['id_utente']);
		$prodotti = $prodottiModels->selectAllProducts();
		$produttori = $prodottiModels->selectAllProduttori();
		
// 		$this->boxPrint($utente);
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
		
		if ($ordine_admin['stato'] == 0) {
			if (isset($ordineUtente) && !empty($ordineUtente) && $ordineUtente['stato'] == 1) {
				$this->getPay($ordine_admin['id_ordine_admin']);
				die;
			}
			else {
				$this->view->load('header', 'no_order_admin', null, null);
				$this->view->render( array ('utente' => $utente));
				die;
			}
		}
		
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
						$lista_spesa[$key]['prodotto']['totale_prodotto'] = number_format(($item['prezzo_iva'] * $prodotto['quantita']), 2, '.', '');
						$lista_spesa[$key]['unita'] = $item['unita'];
						$lista_spesa[$key]['tipologia'] = $item['tipologia'];
						
						$prezzo_finale = $prezzo_finale + ($prodotto['quantita'] * $item['prezzo_iva']);
					}
				}
			}
			
			$this->view->load('header', 'home', null, null);
			$this->view->render(array ( 	'prodotti' => $prodotti,
											'produttori' => $produttori,
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
		
		if ($idProdotto == 28 || $idProdotto == 19) {
			$cassettaDefault = ($idProdotto == 28) ? $prodottiModel->selectCassettaDefaultFrutta() : $prodottiModel->selectCassettaDefaultVerdura();
		
			$cassa['id_cassetta'] = $idProdotto;
			$cassa['id_ordine_utente'] = $idOrdine;
			$cassa['pref'] = 0;
			$cassa['stato'] = 1;
			
			foreach ($cassettaDefault as $eleCassetta) {
				$cassa['id_prodotto'] = $eleCassetta['id_prodotto'];
				$insert = $prodottiModel->insertElementoCassetta($cassa);
			}
		}
		
		$insert = $prodottiModel->insertProdottoLista($prodotto);
		
		if (!isset($insert) || empty($insert)) {
			$response = array( 	'status' => 'ERR',
								'message' => 'error insert prodotto in lista spesa' );
			$this->view->renderJson($response);
		}
		else {
			$array = array(33, 34, 35, 36, 36, 37, 38, 39, 40, 41, 42, 43, 44);
			if (in_array($idProdotto, $array)) {

				$elemento = $prodottiModel->selectProdottoMinimal($idProdotto);
				if ($elemento['stato'] == 1) {
					$sopressa['id_prodotto'] = $idProdotto;
					$sopressa['stato'] = 0;
					$sopressa['user_update'] = $_COOKIE['id_utente'];
					
					$update = $prodottiModel->updateProdotto($sopressa);
						
					if (isset($update) && !empty($update)) {
					}
					else {
						// 					$response = array( 'status' => 'ERR',
						// 										'message' => 'error update soppressa' );
						// 					$this->view->renderJson($response);
					}
				}
			}
			
			$array = $prodottiModel->selectProdottoMinimal($idProdotto);
			$cella_lista['id_prodotto'] = $idProdotto;
			$cella_lista['id_ordine'] = $idOrdine;
			$cella_lista['unita'] = $array['unita'];
			$cella_lista['prodotto']['prezzo_iva'] = $array['prezzo_iva'];
			$cella_lista['prodotto']['nome_prodotto'] = $array['nome_prodotto'];
			$cella_lista['tipologia'] = $array['tipologia'];
			
			if ( $array['unita'] == "kg") {
				$cella_lista['quantita'] = 0.5;
				$cella_lista['prodotto']['totale_prodotto'] = ($array['prezzo_iva']/2);
				$prodotto['quantita'] = 0.5;
				$update = $ordineModel->updateElementoListaSpesa($prodotto);
			}
			else {
				$cella_lista['quantita'] = 1;
				$cella_lista['prodotto']['totale_prodotto'] = $array['prezzo_iva'];
				$prodotto['quantita'] = 1;
				$update = $ordineModel->updateElementoListaSpesa($prodotto);
			}
			
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
		$ordine['pagamento'] = 'consegna';
		
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
				$listaSpesa[$key]['tipologia'] = $item['tipologia'];
				
				if ($item['tipologia'] == "cassetta") {
					$listaSpesa[$key]['cassetta'] = $prodottiModels->selectCassettaPay($prodotto['id_prodotto'], $listaSpesa[$key]['id_ordine']);
					
					foreach ($listaSpesa[$key]['cassetta'] as $index => $prodottoCassetta) {
						$listaSpesa[$key]['cassetta'][$index] = array_merge($listaSpesa[$key]['cassetta'][$index], $prodottiModels->selectProdottoCassetta($prodottoCassetta['id_prodotto']));
					}
				}
				$listaSpesa[$key]['totale_prodotto'] = number_format(($prodotto['quantita'] * $item['prezzo_iva']), 2, '.', '');
	
				$prezzo_finale = $prezzo_finale + ($prodotto['quantita'] * $item['prezzo_iva']);
			}
		}
	
		$server = $_SERVER['HTTP_HOST'];
		
		$prezzo_finale = number_format($prezzo_finale, 2, '.', '');
		
		$ordineAdmin = $ordineModels->selectLastOrdineAdmin();
		$array = explode("-", $ordineAdmin['data_consegna']);
		$ordineAdmin['data_consegna'] = $array[2].'/'.$array[1].'/'.$array[0];
		
// 		$this->boxPrint($listaSpesa);
// 		die;
		
		$this->view->load('header', 'pay', null, null);
		$this->view->render( array(	'utente' => $utente,
									'listaSpesa' => $listaSpesa,
									'prezzoFinale' => $prezzo_finale,
									'idOrdineAdmin' => $idOrdineAdmin,
									'ordineUtente' => $ordineUtente,
									'ordineAdmin' => $ordineAdmin,
									'server' => $server ) );
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
		
		$ordineAdmin = $ordineModel->selectLastOrdineAdmin();
		$array = explode("-", $ordineAdmin['data_consegna']);
		$ordineAdmin['data_consegna'] = $array[2].'/'.$array[1].'/'.$array[0];
		
		$utente = $indexModel->selectUtente($_COOKIE['id_utente']);
		$listaSpesa = $this->_getListaSpesa($idOrdineAdmin);
		$plain_text = '';
// 		$plain_text = '<table>';
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
				
				$plain_text .= $item['nome_prodotto'].' | '.$item['unita'].' | '.$item['prezzo_iva'].' | '.$prodotto['quantita'].' | '.($prodotto['quantita']*$item['prezzo_iva'])." euro \n";
// 				$plain_text .= 	'<tr>'.
// 									'<td>'.$item['nome_prodotto'].'</td>'.
// 									'<td>'.$item['unita'].'</td>'.
// 									'<td>'.$item['prezzo_iva'].'</td>'.
// 									'<td>'.$prodotto['quantita'].'</td>'.
// 									'<td>'.($prodotto['quantita']*$item['prezzo_iva']).' euro </td>'.
// 								'</tr>';
				
				$prezzo_finale = $prezzo_finale + ($prodotto['quantita'] * $item['prezzo_iva']);
			}
		}
		
// 		CHIUDE TABELLA ELEMENTI RICEVUTA
// 		$plain_text .= '</table>';
		
		$notice_text = "Grazie per avere effettuato un ordine su Food Republic.\nSegue la tua ricevuta e riepilogo della tua spesa.\n\nIl team Food Republic\n\nFood Republic S.r.l.\nVia Fratta, 2\n31020 San Zenone degli Ezzelini, TV\nPart. IVA 04496450265\n\nRicevuta 2013/".$idRicevuta."<br/>".$utente['nome']." ".$utente['cognome']."\n".$utente['cf']."\n".$utente['citta']."\n".$utente['via'].' '.$utente['civico'];
		
		$semi_rand = md5(time());
		$mime_boundary = "==MULTIPART_BOUNDARY_$semi_rand";
		$mime_boundary_header = chr(34) . $mime_boundary . chr(34);
		
// 		DESTINATARIO MAIL
		$to = "".$utente['username'].", artuso.lucia@hotmail.it, ricca.prog@gmail.com"; //<".$utente['username']."> || $utente['nome']." ".$utente['cognome'].
		$from = "FoodRepublic <info@food-republic.it>";
		$subject = "La tua Ricevuta #".$idRicevuta;
		
// 		$this->boxPrint($to);
// 		$this->boxPrint($utente); gianluca@70division.com
// 		die;
		
		$body = "$notice_text\n\n$plain_text\n## TOTALE $prezzo_finale euro\n\nGrazie per aver sostenuto l'agricolura della tua Food Community, acquistando prodotti attraverso Food Republic circa l'80% del denaro da te speso va ai produttori, il resto copre le spese di trasporto e di gestione del sito.\n\nStampa e conserva questa ricevuta che ti da diritto a ritirare I prodotti da te acquistati presso:\n
".$utente['indirizzo'].", il giorno ".$ordineAdmin['data_consegna']." alle ore ".$utente['ora_consegna'];
				
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
	
	
	public function postAcceptTerm ($idOrdineAdmin = null) {
		$idOrdineAdmin = $_POST['id_ordine_admin'];
		
		$this->loadModules('index');
		$indexModel = new Index();
		
		$utente['id_utente'] = $_COOKIE['id_utente'];
		$utente['term'] = 1;
		
		$update = $indexModel->updateUtente($utente);

		if (isset($update) && !empty($update)) {
			
			if (isset($idOrdineAdmin) && !empty($idOrdineAdmin) && $idOrdineAdmin > 0) {
				$response = array('status' => 'OK',
									'redirect' => '/index/pay/'.$idOrdineAdmin );
				$this->view->renderJson($response);
			}
			else {
				$response = array('status' => 'OK',
						'redirect' => '/' );
				$this->view->renderJson($response);
			}
		}
		else {
			$response = array('status' => 'ERR' );
			$this->view->renderJson($response);
		}
	}
	
	public function postCheckOrdine() {
		$id_ordine_admin = $_POST['id_ordine_admin'];
		$lista_spesa = $this->_getListaSpesa($id_ordine_admin);
		$flag = 0;
		
 	    $this->loadModules('prodotti');
		$prodottiModel = new Prodotti();
		
		if (isset($lista_spesa) && !empty($lista_spesa)) {
			foreach ($lista_spesa as $key => $prodotto) {
					
				$elemento = $prodottiModel->selectProdottoMinimal($prodotto['id_prodotto']);
				
				if ($elemento['stato'] == 0) {
					if ($elemento['user_update'] != $_COOKIE['id_utente']) {
						$nome_prodotto = $elemento['nome_prodotto'];
						$id_prodotto = $prodotto['id_prodotto'];
						$flag = 1;
						break;
					}
				}
			}
		}
		
		if ($flag == 1) {
			$response = array(	'status' => 'NOLISTA',
								'message' => "Il prodotto ".$nome_prodotto."  giˆ stata acquistata da un altro utente della community pochi secondi fa! La prossima volta sarai pi fortunato. Eliminalo il tuo ordine prima di procedere.",
								'id' => $id_prodotto );
			$this->view->renderJson($response);
		}
		
		$this->loadModules('index');
		$indexModel = new Index();
		
		$utente = $indexModel->selectUtente($_COOKIE['id_utente']);
		
		if ($utente['term'] == 1) {
			$response = array('status' => 'OK' );
			$this->view->renderJson($response);
		}
		else {
			$response = array('status' => 'ERR' );
			$this->view->renderJson($response);
		}
	}
	
	
	public function getModalCassetta () {
		$idProdotto = $_GET['id_prodotto'];
		$idOrdineUtente = $_GET['id_ordine_utente'];
		
		$this->loadModules('prodotti');
		$prodottiModel = new Prodotti();
		
		$cassetta = $prodottiModel->selectCassetta($idProdotto, $idOrdineUtente);
		
		if (isset($cassetta) && !empty($cassetta)) {
			$cas['id_cassetta'] = $cassetta[0]['id_cassetta'];
			$cas['id_ordine_utente'] = $cassetta[0]['id_ordine_utente'];
			
			$nProdotti = count($cassetta);
			$stato = 0;
			$pref = 0;
			
			foreach ($cassetta as $key => $prodotto) {
				$cas['prodotti'][$key] = $prodottiModel->selectProdotto($prodotto['id_prodotto']);
				$cas['prodotti'][$key]['pref'] = $prodotto['pref'];
				$cas['prodotti'][$key]['stato_in'] = $prodotto['stato'];
				
				$stato += $prodotto['stato'];
			}
			
			$resto = $nProdotti - $stato;
			
			$this->view->setHead(null);
			$this->view->load(null, '_partial/modal-cassetta', null, null);
			$this->view->render(  array ( 	'cassetta' => $cas,
											'resto' => $resto ) );
		}
		

	}
	
}