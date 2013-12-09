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
	
	public function selectPrenotazioni ($idUtente) {
		$select = $this->select()
						->from ('prenotazione', '*')
						->where('id_utente = ', $idUtente);
		
		$prenotazioni = $this->fetchAll($select);
		return $prenotazioni;
	}
	
	public function insertOrdineAdmin ($ordineAdmin) {
		$insert = $this->insert($ordineAdmin, 'ordine_admin');
		return $insert;
	}
	
	public function insertOrdineUtente ($ordineUtente) {
			$insert = $this->insert($ordineUtente, 'ordine_utente');
			return $insert;
	}
	
	public function insertRicevuta ($ricevuta) {
		$insert = $this->insert($ricevuta, 'ricevuta');
		return $insert;
	}
	
	public function insertPrenotazione ($prenotazione) {
		$insert = $this->insert($prenotazione, 'prenotazione');
		return $insert;
	}
	
	
	public function updateOrdineAdmin ($ordineAdmin) {
		$update = $this->update(
				$ordineAdmin,
				'ordine_admin',
				array( 	'id_ordine_admin = ' => $ordineAdmin['id_ordine_admin'] )
		);
		return $update;
	}
	
	
	public function updateElementoListaSpesa ($prodotto) {
			$update = $this->update(
					$prodotto,
					'lista_spesa',
					array( 	'id_ordine = ' => $prodotto['id_ordine'],
							'id_prodotto = ' => $prodotto['id_prodotto'] )
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
	
	
	public function updateCassetta ($cassetta) {
		$update = $this->update(
							$cassetta,
							'cassetta',
							array( 	'id_ordine_utente = ' => $cassetta['id_ordine_utente'],
									'id_cassetta = ' => $cassetta['id_cassetta'],
									'id_prodotto = ' => $cassetta['id_prodotto'] )
		);
		return $update;
	}
	
	
	public function updateFormatCassetta ($cassetta) {
		$update = $this->update(
							$cassetta,
							'cassetta',
							array( 	'id_ordine_utente = ' => $cassetta['id_ordine_utente'],
									'id_cassetta = ' => $cassetta['id_cassetta'] )
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
	
	
	public function deleteCassetta ($idProdotto, $idOrdine) {
		$delete = $this->delete('cassetta',
								array ( 'id_ordine_utente = ' => $idOrdine,
										'id_cassetta = ' =>  $idProdotto)
		);
		return $delete;
	}
	
	public function deletePrenotazione ($idProdotto, $idOrdine, $idUtente) {
		$delete = $this->delete('prenotazione',
				array ( 'id_ordine = ' => $idOrdine,
						'id_prodotto = ' => $idProdotto,
						'id_utente = ' =>  $idUtente)
		);
		return $delete;
	}
	
	
}					