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
						->join ('produttori', 'prodotti.id_produttore = produttori.id_produttore', array('nome_produttore', 'citta'));
	
		$prodotti = $this->fetchAll($select);
		return $prodotti;
	}
	
	public function selectListaSpesa ($idUtente) {
		
// 		Filtro per data ordine admin

		$select = $this->select()
						->from ('lista_spesa', '*')
						->join ('ordine_utente', 'ordine_utente.id_ordine = lista_spesa.id_ordine',  array('stato', 'id_ordine_admin') )
						->where ('ordine_utente.id_utente = ', $idUtente);
	
		$prodotti = $this->fetchAll($select);
		return $prodotti;
	}
	
	public function selectProdottoMinimal ($idProdotto) {
		$select = $this->select()
						->from ('prodotti', 'nome_prodotto, prezzo')
						->where ('id_prodotto = ', $idProdotto);
	
		$prodotti = $this->fetchRow($select);
		return $prodotti;
	}
	
	
}