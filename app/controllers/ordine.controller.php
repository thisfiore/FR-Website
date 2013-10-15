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
						$prezzo = $prezzo + ($item['prezzo_iva'] * $item['quantita']);
					}
				}
				
				$prezzo = number_format($prezzo, 2, '.', '');
				
				$response = array ( 'status' => 'OK',
									'data' => $prezzo  );
		}
		else {
			$response = array ( 'status' => 'ERROR' );
		}
		
		$this->view->renderJson($response);
	}
	
	
	public function postCambioQuantita () {
		$prodotto['id_prodotto'] = $_POST['id_prodotto'];
		$prodotto['id_ordine'] = $_POST['id_ordine'];
		$prodotto['quantita'] = $_POST['quantita'];
		
		$this->loadModules('ordine');
		$ordineModel = new Ordine();
		
		$update = $ordineModel->updateElementoListaSpesa($prodotto);
		
		if ($update == 1) {
			$this->loadModules('prodotti');
			$prodottiModels = new Prodotti();
			
			$prodotto = $prodottiModels->selectProdottoMinimal($prodotto['id_prodotto']);
			
			$response = array ( 'status' => 'OK',
								'data' => $prodotto['prezzo_iva'] );
		}
		else {
			$response = array ( 'status' => 'ERR' );
		}
		
		$this->view->renderJson($response);
	}
	
	
	
	
	
}