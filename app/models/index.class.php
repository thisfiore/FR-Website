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
	
	
	public function selectUtenti () {
		$select = $this->select()
						->from ('utenti', '*');
	
		$utenti = $this->fetchAll($select);
		return $utenti;
	}
	
	
	public function selectUtenteMail ($mailUtente) {
		$select = $this->select()
						->from ('utenti', ' id_utente, id_gruppo')
						->where('username = ', $mailUtente);
		$utente = $this->fetchRow($select);
		return $utente;
	}
	
	public function selectUtente ($idUtente) {
		$select = $this->select()
						->from ('utenti', '*')
						->join ('gruppi', 'gruppi.id_gruppo = utenti.id_gruppo')
						->where('id_utente = ', $idUtente);
	
		$utente = $this->fetchRow($select);
		return $utente;
	}
	
	public function selectUtentePerCassetta ($idUtente) {
		$select = $this->select()
						->from ('utenti', array('id_utente', 'id_gruppo', 'nome', 'cognome', 'citta', 'via', 'civico') )
						->join ('gruppi', 'gruppi.id_gruppo = utenti.id_gruppo', array('nome_gruppo', 'indirizzo') )
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
	
	public function insertUtente ($utente) {
		$insert = $this->insert($utente, 'utenti');
		return $insert;
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