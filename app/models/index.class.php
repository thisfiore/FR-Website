<?php
/**
 * @author 70 Division
 *
 */

class Index extends DB {

	protected $_tablename = 'action';
	
	function __construct() {
		parent::__construct();
	}
	
	
	public function login ($username, $password) {
		$select = $this->select()
						->from ('utenti', '*')
						->where('password = ', $password)
						->where('username = ', $username);
	
		$login = $this->fetchRow($select);
		return $login;
	}
	
	public function selectUtente ($idUtente) {
		$select = $this->select()
						->from ('utenti', '*')
						->join ('gruppi', 'gruppi.id_gruppo = utenti.id_gruppo')
						->where('id_utente = ', $idUtente);
	
		$utente = $this->fetchRow($select);
		return $utente;
	}
	
	
	public function selectUtenteSingolo ($idUtente) {
		$select = $this->select()
						->from ('utenti', array('id_utente', 'id_gruppo', 'nome', 'cognome', 'citta', 'via', 'civico') )
						->where('id_utente = ', $idUtente);
	
		$utente = $this->fetchRow($select);
		return $utente;
	}
	
	
	public function selectGruppi () {
		$select = $this->select()
						->from ('gruppi', '*' );
	
		$gruppo = $this->fetchAll($select);
		return $gruppo;
	}
	
	
	public function updateUtente ($utente) {
		$update = $this->update(
				$utente,
				'utenti',
				array( 	'id_utente = ' => $utente['id_utente'] )
		);
		return $update;
		
	}
	
	
}