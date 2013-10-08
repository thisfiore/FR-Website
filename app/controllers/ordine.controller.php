<?php
class OrdineController extends Controller {
	
	public function __construct() {
		parent::__construct();
		$this->loadFile($this->method, $this->self);
	}
	
	public function postDeleteCellaLista () {
		
		$idProdotto = $_POST['id_prodotto'];
		$idOrdine = $_POST['id_ordine'];
		
		$this->loadModules('ordine');
		$ordineModels = new Ordine();
		
		$delete = $ordineModels->deleteCellaListaSpesa($idProdotto, $idOrdine);
		
		if (isset($delete) && !empty($delete)) {
				$prodotto = $ordineModels->selectListaSpesaPrezzo($idOrdine);
				$prezzo = 0;
				
				if ($prodotto) {
					foreach ($prodotto as $item) {
						$prezzo = $prezzo + ($item['prezzo'] * $item['quantita']);
					}
				}
				
				$response = array ( 'status' => 'OK',
									'data' => $prezzo  );
		}
		else {
			$response = array ( 'status' => 'ERROR' );
		}
		
		$this->view->renderJson($response);
	}
	
	
	public function postCambioQuantita () {
		$idProdotto = $_POST['id_prodotto'];
		$idOrdine = $_POST['id_ordine'];
		$quantita = $_POST['quantita'];
		
		$this->loadModules('ordine');
		$ordineModels = new Ordine();
		
		$update = $ordineModels->updateElementoListaSpesa($idProdotto, $idOrdine, $quantita);
		
		if ($update == 1) {
			$response = array ( 'status' => 'OK',
								'data' => $quantita );
		}
		else {
			$response = array ( 'status' => 'ERR' );
		}
		
		$this->view->renderJson($response);
	}
	
}