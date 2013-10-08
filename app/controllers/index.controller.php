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
	
		$lista_spesa = $ordineModels->selectListaSpesa($this->idLoggedUser, $idOrdineAdmin);
		return $lista_spesa;
	}
	
	public function postAddProdottoLista () {
		$idProdotto = $_POST['id_prodotto'];
		
		$this->loadModules('ordine');
		$ordineModel = new Ordine();
		
		$ordineAdmin = $this->_getOrdineAdmin();
		$ordine = $ordineModel->selectListaSpesa($_COOKIE['id_utente'], $ordineAdmin['id_ordine_admin']);
		
		if (!isset($ordine) || empty($ordine)) {
			$ordineUtente['id_utente'] = $_COOKIE['id_utente'];
			$ordineUtente['stato'] = 0;
			$ordineUtente['pagamento'] = 0;
			$ordineUtente['id_ordine_admin'] = $ordineAdmin['id_ordine_admin'];
			$ordineUtente['data'] = date('Y-m-d');
			
			$insert = $ordineModel->insertOrdineUtente($ordineUtente);
			
			$this->boxPrint($insert);
			die;
		}
		
	}
	
}