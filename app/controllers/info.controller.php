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
	
}	
?>