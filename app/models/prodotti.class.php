<?php
/**
 * @author 70 Division
 *
 */

class Prodotti extends DB {

	protected $_tablename = 'action';
	
	function __construct() {
		parent::__construct();
	}
	
	
	public function selectAllProducts () {
		$select = $this->select()
						->from ('prodotti', '*')
						->join ('produttori', 'prodotti.id_produttore = produttori.id_produttore', array('nome_produttore', 'citta'))
						->where ('prodotti.stato = 1')
						->order('tipologia', 'DESC');
						
		$prodotti = $this->fetchAll($select);
		
		if (isset($prodotti) && !empty($prodotti)) {
			foreach ($prodotti as $key => $prodotto) {
				$ivaMarkup = (1+$prodotto['iva']/100) * (1.15);
				$prodotti[$key]['prezzo_iva'] = round($prodotto['prezzo'] * $ivaMarkup , 2);
// 				round($prodotto['prezzo'] * (1+$prodotto['iva']/100) * (1.15) , 2)
			}
		}
		
		return $prodotti;
	}
	
	
	public function selectAllProduttori () {
		$select = $this->select()
						->from ('produttori', '*');
	
		$produttori = $this->fetchAll($select);
	
		return $produttori;
	}
	
	
	public function selectProdotto ($idProdotto) {
		$select = $this->select()
						->from ('prodotti', '*')
						->where ('id_prodotto = ', $idProdotto);
	
		$prodotti = $this->fetchRow($select);
	
		$prodotti['prezzo_iva'] = round($prodotti['prezzo'] * (1+$prodotti['iva']/100) * (1.15), 2);
	
		return $prodotti;
	}
	
	
	public function selectProdottoCassetta ($idProdotto) {
		$select = $this->select()
						->from ('prodotti', ' nome_prodotto, unita ')
						->where ('id_prodotto = ', $idProdotto);
	
		$prodotti = $this->fetchRow($select);
	
		return $prodotti;
	}
	
	
	public function selectProdottoMinimal ($idProdotto) {
		$select = $this->select()
						->from ('prodotti', ' nome_prodotto, prezzo, unita, iva, stato, user_update, tipologia')
						->where ('id_prodotto = ', $idProdotto);
	
		$prodotti = $this->fetchRow($select);
		
		$prodotti['prezzo_iva'] = round($prodotti['prezzo'] * (1+$prodotti['iva']/100) * (1.15), 2);
		
		return $prodotti;
	}
	
	
	public function selectProdottoAdminProduttori ($idProdotto) {
		$select = $this->select()
						->from ('prodotti', array('id_prodotto', 'id_produttore', 'nome_prodotto', 'unita', 'prezzo', 'iva'))
						->where ('id_prodotto = ', $idProdotto);
	
		$prodotto = $this->fetchRow($select);
	
// 		Prezzo senza markup
		$prodotto['prezzo_iva'] = round($prodotto['prezzo'] * (1+$prodotto['iva']/100), 2);
	
		return $prodotto;
	}
	
	
	public function selectCassetta ($idCassetta, $idOrdineUtente) {
		$select = $this->select()
						->from ('cassetta', '*')
						->where ('id_cassetta = ', $idCassetta)
						->where ('id_ordine_utente = ', $idOrdineUtente);
		
		$prodotti = $this->fetchAll($select);
		return $prodotti;
	}
	
	
	public function selectCassettaPay ($idCassetta, $idOrdineUtente) {
		$select = $this->select()
						->from ('cassetta', ' id_prodotto, pref, stato')
						->where ('id_cassetta = ', $idCassetta)
						->where ('id_ordine_utente = ', $idOrdineUtente);
	
		$prodotti = $this->fetchAll($select);
		return $prodotti;
	}
	
	
	public function selectCassettaDefaultFrutta () {
		$select = $this->select()
						->from ('default_cassetta_frutta', array('id_prodotto'));
		
		$prodotti = $this->fetchAll($select);
		return $prodotti;
	}
	
	public function selectCassettaDefaultVerdura () {
		$select = $this->select()
						->from ('default_cassetta_verdura', array('id_prodotto'));
	
		$prodotti = $this->fetchAll($select);
		return $prodotti;
	}
	
	
	public function insertProdottoLista ($prodotto) {
		$insert = $this->insert($prodotto, 'lista_spesa');
		return $insert;
	}
	
	public function insertElementoCassetta ($prodotto) {
		$insert = $this->insert($prodotto, 'cassetta');
		return $insert;
	}
	
	
	public function updateProdotto ($prodotto) {
		$update = $this->update(
				$prodotto,
				'prodotti',
				array( 	'id_prodotto = ' => $prodotto['id_prodotto'] )
		);
		return $update;
	}
	

	
}