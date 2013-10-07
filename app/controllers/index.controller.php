<?php
class IndexController extends Controller {
	
	public function __construct() {
		parent::__construct();
		$this->loadFile($this->method, $this->self);
	}
	
	public function getIndex() {
		
		if ( isset($this->idLoggedUser) || isset($_COOKIE['id_utente']) ) {
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
		
		
		$lista_spesa = $prodottiModels->selectListaSpesa($_COOKIE['id_utente']);
		
		if (isset($lista_spesa) && !empty($lista_spesa)) {
			foreach ($lista_spesa as $key => $prodotto) {
				$lista_spesa[$key] = $prodottiModels->selectProdottoMinimal($prodotto['id_prodotto']);
			}
		}
		
		
		$this->view->load(null, 'home', null, null);
		$this->view->render(array ( 	'prodotti' => $prodotti,
										'lista_spesa' => $lista_spesa ) );
	}
	
}