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
		
		if (isset($prodotti) && !empty($prodotti)) {
			foreach ($prodotti as $key => $prodotto) {
				$prodotti[$key]['prezzo_iva'] = round($prodotto['prezzo'] * (1+$prodotto['iva']/100) * (1.15) , 2) ;
			}
		}
		
		return $prodotti;
	}
	
	
	public function selectProdottoMinimal ($idProdotto) {
		$select = $this->select()
						->from ('prodotti', ' nome_prodotto, prezzo, unita, iva')
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
	
	
	public function insertProdottoLista ($prodotto) {
		$insert = $this->insert($prodotto, 'lista_spesa');
		return $insert;
	}
	
	
}