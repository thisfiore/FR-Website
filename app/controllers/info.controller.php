<?php 

class InfoController extends Controller {
	
	public function __construct() {
		parent::__construct();
		$this->loadFile($this->method, $this->self);
	}
	
	public function getIntro() {

		$pdfScript = array(
				"pdf" => array(
						"type" => "text/javascript",
						"src" => "pdf.js")
		);
		$this->view->addScripts($pdfScript);
		
		$this->view->load('header_pdfintro', 'intro', null, null);
		$this->view->render();
	}
	
	
	public function getTermini() {
		
		if (!isset($_COOKIE['id_utente']) || empty($_COOKIE['id_utente'])) {
			return header("Location: /index");
		}
		
		$this->loadModules('index');
		$indexModels = new Index();
		
		$utente = $indexModels->selectUtente($_COOKIE['id_utente']);
		
		$this->view->load('header', 'termini', null, null);
		$this->view->render( array( 'utente' => $utente) );
	}
	
}	
?>