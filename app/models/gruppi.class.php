<?php
/**
 * @author 70 Division
 *
 */

class Gruppi extends DB {

	protected $_tablename = 'gruppi';

	function __construct() {
		parent::__construct();
	}
	
	public function selectGruppoWithUsers ($idGruppo) {
		$select = $this->select()
						->from ('gruppi', '*')
						->join('utenti', 'utenti.id_gruppo = gruppi.id_gruppo')
						->where('gruppi.id_gruppo = ', $idGruppo);
		$gruppi = $this->fetchAll($select);
		return $gruppi;
	}
}