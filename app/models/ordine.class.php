<?php
/**
 * @author 70 Division
 *
 */

class Ordine extends DB {

	protected $_tablename = 'action';
	
	function __construct() {
		
		parent::__construct();
	}
	
	
	public function selectLastOrdineAdmin () {
		$select = $this->select()
						->from ('ordine_admin', '*')
						->order ('data', 'DESC');
	
		$prodotti = $this->fetchRow($select);
		return $prodotti;
	}
	
	public function selectListaSpesa ($idUtente, $idOrdineAdmin) {
		$select = $this->select()
						->from ('lista_spesa', '*')
						->join ('ordine_utente', 'ordine_utente.id_ordine = lista_spesa.id_ordine',  array('stato', 'id_ordine_admin', 'id_ordine', 'data') )
						->where ('ordine_utente.id_utente = ', $idUtente)
						->where ('ordine_utente.id_ordine_admin = ', $idOrdineAdmin);
	
		$prodotti = $this->fetchAll($select);
		return $prodotti;
	}
	
	
	public function selectListaSpesaPrezzo ($idOrdine) {
		$select = $this->select()
						->from ('lista_spesa', '*')
						->join ('prodotti', 'prodotti.id_prodotto = lista_spesa.id_prodotto', array('nome_prodotto, prezzo, iva'))
						->where('lista_spesa.id_ordine = ', $idOrdine);
		
		$prodotti = $this->fetchAll($select);
		
// 		print_r($prodotti);
// 		die;
		
		if (isset($prodotti) && !empty($prodotti)) {
			foreach ($prodotti as $key => $prodotto) {
				$prodotti[$key]['prezzo_iva'] = round($prodotto['prezzo'] * (1+$prodotto['iva']/100) * (1.15) , 2) ;
			}
		}
		
		
		return $prodotti;
	}
	
	
	public function selectOrdineUtente ($idOrdineAdmin, $idUtente) {
		$select = $this->select()
						->from ('ordine_utente', '*')
						->where('id_ordine_admin = ', $idOrdineAdmin)
						->where('id_utente = ', $idUtente);
	
		$ordine = $this->fetchRow($select);
		return $ordine;
	}
	
	
	public function insertOrdineUtente ($ordineUtente) {
			$insert = $this->insert($ordineUtente, 'ordine_utente');
			return $insert;
	}
	
	public function insertRicevuta ($ricevuta) {
		$insert = $this->insert($ricevuta, 'ricevuta');
		return $insert;
	}
	
	
	public function updateElementoListaSpesa ($idProdotto, $idOrdine, $quantita) {
			$update = $this->update(
					array ('quantita' => $quantita),
					'lista_spesa',
					array( 	'id_ordine = ' => $idOrdine,
							'id_prodotto = ' => $idProdotto )
			);
			return $update;
	}
	
	
	public function updateOrdineUtente ($ordine) {
		$update = $this->update(
				$ordine,
				'ordine_utente',
				array( 	'id_ordine_admin = ' => $ordine['id_ordine_admin'],
						'id_utente = ' => $ordine['id_utente'] )
		);
		return $update;
	}
	
	
	public function deleteCellaListaSpesa ($idProdotto, $idOrdine) {
		$delete = $this->delete('lista_spesa',
				array ( 'id_ordine = ' => $idOrdine,
						'id_prodotto = ' =>  $idProdotto)
		);
		return $delete;
	}
	
}					