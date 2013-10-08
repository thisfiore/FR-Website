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
// 		$delete = 1;
		
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
	
}