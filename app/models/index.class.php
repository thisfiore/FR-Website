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
	
}