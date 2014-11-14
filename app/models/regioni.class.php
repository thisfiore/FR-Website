<?php
/**
 * @author 70 Division
 *
 */

class Regioni extends DB {

	protected $_tablename = 'utenti_umbria';

	function __construct() {
		parent::__construct();
	}
	
	public function insertUtenteUmbria ($utente)
    {
        $insert = $this->insert($utente, 'utenti_umbria');
        return $insert;
    }

    public function selectUtenteUmbriaById ($idUtente) {
        $select = $this->select()
            ->from ('utenti_umbria', '*')
            ->where('id = ', $idUtente);

        $utente = $this->fetchRow($select);
        return $utente;
    }

    public function selectUtenteUmbriaByEmail ($email) {
        $select = $this->select()
            ->from ('utenti_umbria', '*')
            ->where('email = ', $email);

        $utente = $this->fetchRow($select);
        return $utente;
    }
}
?>