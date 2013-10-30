<?php

class CassettaController extends Controller {
	
	public function __construct() {
		parent::__construct();
		$this->loadFile($this->method, $this->self);
	}

	public function postUpdateCassetta() {
		$this->loadModules('ordine');
		$ordineModels = new Ordine();
		
		$cassetta['id_ordine_utente'] = $_POST['id_ordine_utente'];
		$cassetta['id_cassetta'] = $_POST['id_cassetta'];
		
		if (isset($_POST['pref']) && !empty($_POST['pref'])) {
			$cassetta['pref'] = $_POST['pref'];
			$element = 'pref';
		}
		if (isset($_POST['stato']) && !empty($_POST['stato'])) {
			$cassetta['stato'] = $_POST['stato'];
			$element = 'stato';
		}
		
		$update = $ordineModels->updateCassetta($cassetta);
		
		if (isset($update) && !empty($update)) {
			$response = array( 	'status' => 'ERR',
								'message' => 'errore update cassetta');
			$this->view->renderJson($response);
		}
		else {
			$response = array( 	'status' => 'OK',
								'element' => $element );
			$this->view->renderJson($response);
		}
		
	}
	
	
	
	
	
	
	
	
}
?>