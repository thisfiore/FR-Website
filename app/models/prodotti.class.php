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
	
	
	public function selectProdottoMinimal ($idProdotto) {
		$select = $this->select()
						->from ('prodotti', ' nome_prodotto, prezzo, unita')
						->where ('id_prodotto = ', $idProdotto);
	
		$prodotti = $this->fetchRow($select);
		return $prodotti;
	}
	
	
	public function insertProdottoLista ($prodotto) {
		$insert = $this->insert($prodotto, 'lista_spesa');
		return $insert;
	}
	
	
}