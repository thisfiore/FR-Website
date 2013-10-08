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
	
	public function selectListaSpesa ($idUtente) {
	
		// 		Filtro per data ordine admin
	
		$select = $this->select()
						->from ('lista_spesa', '*')
						->join ('ordine_utente', 'ordine_utente.id_ordine = lista_spesa.id_ordine',  array('stato', 'id_ordine_admin', 'id_ordine') )
						->where ('ordine_utente.id_utente = ', $idUtente);
	
		$prodotti = $this->fetchAll($select);
		return $prodotti;
	}

	public function selectListaSpesaPrezzo ($idOrdine) {
		$select = $this->select()
						->from ('lista_spesa', '*')
						->join ('prodotti', 'prodotti.id_prodotto = lista_spesa.id_prodotto', array('nome_prodotto, prezzo'))
						->where('lista_spesa.id_ordine = ', $idOrdine);
		
		$prodotti = $this->fetchRow($select);
		return $prodotti;
	}
	
	
	public function deleteCellaListaSpesa ($idProdotto, $idOrdine) {
		$delete = $this->delete('lista_spesa',
				array ( 'id_ordine = ' => $idOrdine,
						'id_prodotto = ' =>  $idProdotto)
		);
		return $delete;
	}
	
}					