<?php

class CassettaController extends Controller {
	
	public function __construct() {
		parent::__construct();
		$this->loadFile($this->method, $this->self);
	}

	public function postUpdateCassetta() {
		
		$cassetta['id_prodotto'] = $_POST['id_prodotto'];
		$cassetta['id_ordine_utente'] = $_POST['id_ordine_utente'];
		$cassetta['id_cassetta'] = $_POST['id_cassetta'];
		
		if (isset($_POST['check']) && $_POST['check'] == 1) {
			$this->formattaTabellaCassetta($cassetta);
		}
		
		$this->loadModules('ordine');
		$ordineModels = new Ordine();
		
		if (isset($_POST['pref']) && $_POST['pref'] >= 0) {
			$cassetta['pref'] = $_POST['pref'];
			$element = 'pref';
		}
		if (isset($_POST['stato']) && $_POST['stato'] >= 0) {
			$cassetta['stato'] = $_POST['stato'];
			$element = 'stato';
		}
		
		$update = $ordineModels->updateCassetta($cassetta);
		
		if (isset($update) && !empty($update)) {
			$response = array( 	'status' => 'OK',
								'element' => $element );
			$this->view->renderJson($response);
		}
		else {
			$response = array( 	'status' => 'ERR',
								'message' => 'errore update cassetta');
			$this->view->renderJson($response);
		}
		
	}
	
	
	public function formattaTabellaCassetta($cassetta) {
		$this->loadModules('ordine');
		$ordineModels = new Ordine();
		
		$cassetta['stato'] = 1;
		$cassetta['pref'] = 0;
		unset ($cassetta['id_prodotto']);
		
// 		$this->boxPrint($cassetta);
// 		die;
		
		$update = $ordineModels->updateFormatCassetta($cassetta);
		
		if (isset($update) && !empty($update)) {
			$response = array( 	'status' => 'OK');
			$this->view->renderJson($response);
		}
		else {
			$response = array( 	'status' => 'ERR',
					'message' => 'errore update cassetta');
			$this->view->renderJson($response);
		}
	}
	
	
	
	
	
	
}
?>