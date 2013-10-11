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
						->join ('prodotti', 'prodotti.id_prodotto = lista_spesa.id_prodotto', array('nome_prodotto, prezzo, iva, unita'))
						->where('lista_spesa.id_ordine = ', $idOrdine);
		
		$prodotti = $this->fetchAll($select);
		
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
	
	
	public function selectGruppoPerProduttori ($idGruppo) {
		$select = $this->select()
						->from ('gruppi', 'nome_gruppo')
						->where('id_gruppo = ', $idGruppo);
	
		$gruppo = $this->fetchRow($select);
		return $gruppo;
	}
	
	
	public function selectOrdiniUtentiProduttori ($idOrdineAdmin) {
		$select = $this->select()
						->from ('ordine_utente', '*')
						->join ('lista_spesa', 'lista_spesa.id_ordine = ordine_utente.id_ordine', array('id_prodotto', 'quantita'))
						->join ('utenti', 'utenti.id_utente = ordine_utente.id_utente', array('id_gruppo'))
						->where('ordine_utente.id_ordine_admin = ', $idOrdineAdmin)
						->where('ordine_utente.stato = 1');
	
		$ordine = $this->fetchAll($select);
		return $ordine;
	}
	
	
	public function selectProduttori () {
		$select = $this->select()
						->from ('produttori', '*');
	
		$produttori = $this->fetchAll($select);
		return $produttori;
	}
	
	public function selectAllOrdineAdmin () {
		$select = $this->select()
						->from ('ordine_admin', '*')
						->order('data', 'DESC');
	
		$ordine_admin = $this->fetchAll($select);
		return $ordine_admin;
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