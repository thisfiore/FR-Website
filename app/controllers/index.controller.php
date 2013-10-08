<?php
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
		
		$this->loadModules('ordine');
		$ordineModels = new Ordine();
		
		$ordineUtente = $ordineModels->selectOrdineUtente($idOrdineAdmin);
		
		if ($_COOKIE['id_utente'] != $ordineUtente['id_utente']) {
			header('Location: /');
		}
		
		$listaSpesa = $this->_getListaSpesa($idOrdineAdmin);
		
		if (isset($listaSpesa) && !empty($listaSpesa)) {
			$this->loadModules('prodotti');
			$prodottiModels = new Prodotti();
		
			$prezzo_finale = 0;
			
			foreach ($listaSpesa as $key => $prodotto) {
				$item = $prodottiModels->selectProdottoMinimal($prodotto['id_prodotto']);
				$listaSpesa[$key]['nome_prodotto'] = $item['nome_prodotto'];
				$listaSpesa[$key]['prezzo'] = $item['prezzo'];
				
				$prezzo_finale = $prezzo_finale + ($prodotto['quantita'] * $item['prezzo']);
			}
		}

// 		$this->boxPrint($listaSpesa);
// 		$this->boxPrint($prezzo_finale);
// 		die;
		
		$this->view->load(null, 'pay', null, null);
		$this->view->render( array('listaSpesa' => $listaSpesa,
									'prezzoFinale' => $prezzo_finale) );
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
	
	
	public function getHome() {
		
		$this->loadModules('prodotti');
		$prodottiModels = new Prodotti();
		
		$prodotti = $prodottiModels->selectAllProducts();
		$prezzo_finale = 0;
		$ordine_admin = $this->_getOrdineAdmin();
		
		if (!isset($ordine_admin) || empty($ordine_admin)) {
			echo "<h1>Sito in fase di perfezionamento</h1>";
			die;
		}

		$lista_spesa = array();
		
		if ($ordine_admin['stato'] == 1) {
			$lista_spesa = $this->_getListaSpesa($ordine_admin['id_ordine_admin']);
			
			if (isset($lista_spesa) && !empty($lista_spesa)) {
				foreach ($lista_spesa as $key => $prodotto) {
					$item = $prodottiModels->selectProdottoMinimal($prodotto['id_prodotto']);
					$lista_spesa[$key]['prodotto'] = $item;
			
					$prezzo_finale = $prezzo_finale + ($prodotto['quantita'] * $item['prezzo']);
				}
			}
		}
		
		$this->view->load('header', 'home', null, null);
		$this->view->render(array ( 	'prodotti' => $prodotti,
										'lista_spesa' => $lista_spesa,
										'prezzo_finale' => $prezzo_finale,
										'ordine_admin' => $ordine_admin) );
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
		
		$ordine = $ordineModel->selectOrdineUtente($ordineAdmin['id_ordine_admin']);
		
// 		$this->boxPrint($ordine);
// 		die;
		
		if (!isset($ordine) || empty($ordine)) {
			$ordineUtente['id_utente'] = $_COOKIE['id_utente'];
			$ordineUtente['stato'] = 0;
			$ordineUtente['pagamento'] = 0;
			$ordineUtente['id_ordine_admin'] = $ordineAdmin['id_ordine_admin'];
			$ordineUtente['data'] = date('Y-m-d');
			
			$insert = $ordineModel->insertOrdineUtente($ordineUtente);
			
			if (!isset($insert) || empty($insert)) {
				$response = array( 'status' => 'ERR',
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
			$cella_lista['quantita'] = 1;
			$cella_lista['prodotto']['prezzo'] = $array['prezzo'];
			$cella_lista['prodotto']['nome_prodotto'] = $array['nome_prodotto'];
			
			$this->view->setHead(null);
			$this->view->load(null, '_partial/cella_lista', null, null);
			$this->view->render(  array ( 'cella_lista' => $cella_lista ) );
		}
	}
	
}