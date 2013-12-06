<?php

class GruppiController extends Controller {

	public function __construct() {
		parent::__construct();
		$this->loadFile($this->method, $this->self);
	}
	
	public function getIndex () {
		$this->_getGroupUsers();
	}
	
	public function _getGroupUsers ($idGruppo = 1) {
		$this->loadModules('gruppi');
		$gruppiModel = new Gruppi();
		$gruppo = $gruppiModel->selectGruppoWithUsers($idGruppo);
		
		$this->boxPrint($gruppo);
		die;
	}
	
}
?>