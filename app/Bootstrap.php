<?php

class Bootstrap {
	public $connessione;
	public $isLanding;
	public $error = null;
	
// __construct  la funzione che parto con la chiamata del file

	public function __construct($documentRoot) {
		define("DOCUMENT_ROOT", $documentRoot);
		date_default_timezone_set('Europe/Rome');
		$this->setPath();
		$this->setPublicPath();
		$this->conn = spl_autoload_register(array($this, 'conn'));
		$this->framework = spl_autoload_register(array($this, 'framework'));
	}
	
// 	definisco le path principali
	public function setPath() {
		$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
		define("PROTOCOL", $protocol);
		define("HOSTNAME", $_SERVER['HTTP_HOST']);
		define("REAL_PATH", realpath(dirname(__FILE__)));
		$documentRoot = $_SERVER['DOCUMENT_ROOT'];
		// change document root to => html/var/document/root
		if (substr($documentRoot, -1) == '/') {
			$documentRoot = substr($documentRoot, 0, -1);
		}
		
		//define("DOCUMENT_ROOT", $documentRoot);
		define("DS", "/");
		
		define("ROOT", realpath(DOCUMENT_ROOT."/../app/"));
		define("APPLICATION_PATH", realpath(dirname(__FILE__).'/../'));
		
		define("PUBLIC_PATH", DOCUMENT_ROOT);
		define("ERROR_404_PATH",  DOCUMENT_ROOT.'/404.php');
		define("LANDING_PATH",  APPLICATION_PATH.'/app/landing');
		define("PM_PATH",  APPLICATION_PATH.'/app/pm');
		
		define("CONFIG_PATH", APPLICATION_PATH.DS.'lib');
		
		define("LIBRARY_PATH", APPLICATION_PATH.DS.'lib');
		define("LOG_PATH", APPLICATION_PATH.DS.'log');

//		Path public folder
		define("SCRIPT_PATH", '/js');
		define("CSS_PATH", '/css');
		define("IMG_PATH", '/img');
		
// 		echo ROOT;
// 		echo dirname(DOCUMENT_ROOT.DS);
// 		echo realpath(dirname(DOCUMENT_ROOT.DS));
// 		die;
		
	}
	
	private function setEnv() {
		require LIBRARY_PATH.DS."environment.php";
		$environment = new Environment();
		$environment->setEnv();
	
	}
	
	private function setConfig() {
		require_once LIBRARY_PATH.DS."config.php";
	
	}
	
	private function loadFramework() {
		require_once LIBRARY_PATH.DS."controller.php";
		require_once LIBRARY_PATH.DS."model.php";
		require_once LIBRARY_PATH.DS."view.php";
	}
	
	
	
	protected function setPublicPath() {
		$this->publicPath = array(SCRIPT_PATH, CSS_PATH, IMG_PATH);
	}

	protected function framework() {
		require_once LIBRARY_PATH.DS."view.class.php";
		require_once LIBRARY_PATH.DS."controller.class.php";
	}
	
// funzioni di configurazione
	public function conn() {
		require_once CONFIG_PATH.DS."config.php";
		require_once CONFIG_PATH.DS."environment.class.php";
		require_once CONFIG_PATH.DS."model.php";
	}
	
	public function getUrl() {
		$self = $_SERVER['REQUEST_URI'];
		
		$ds = $self[strlen($self)-1];
		
		$array_self = explode("/",$self);
		$array_self = array_filter($array_self);
		
		$i = count($array_self);

		// impostazione URL corretto
		if ($ds != "/") {
			if ($i < 3) {
				header("location:".PROTOCOL.HOSTNAME.$self."/");
			}
		} else {
			if ($i > 3) {
				header("location:".PROTOCOL.HOSTNAME.$self);
			}
		}
		
		return $array_self;
	}
	
	public function setController($self = null) {
		define("CONTROLLER", isset($self) ? $self : "index");
	}
	
	
	public function workspace($self) {
		$workspace = array ( "pm");
		
		if (in_array ($self, $workspace)) {	
			$this->isLanding = false;
		} else {
			$this->isLanding = true;
		}
		
		return $self;
	}
	
	
	public function findController($self) {
		$controller = array ( "index", "ordine", "admin", "info", "shop", "cassetta" );
		
		if (in_array ($self, $controller)) {
			return $self;
		} else {
			$indice = "indice".strpos($self, "?");
			
			if ($indice == "indice0") {
				$self = "index";
				return $self;
			}
			else {
// 				$this->error = "Controller error!";
				$self = '404';
				return $self;
			}
		}
	}
	
	
	protected function pathIsPublic() {
		$url = $this->getUrl();
		if (isset($url[1]) && array_search('/'.$url[1], $this->publicPath)) {
			return true;
		} else {
			return false;
		}
	}
	
	
	public function checkFolder($controller = null) {
		
		if ($controller == null) {
			if ($controller == '404') {
				$path = ERROR_404_PATH;
			}
			else {
				$path = ROOT.DS."controllers/index.controller.php";
			}
		} 
		else if ($controller == '404') {
			$path = ERROR_404_PATH;
		}
		else {
			$path = ROOT.DS."controllers/".$controller.".controller.php";
		}
		
		return $path;
	}
	
	
	
	public function find404($path) {
		if (strpos($path,'404')) {
			return true;
		}
		
		return false;
	}

	
	
	public function checkController($controller) {
		
		$controllerName = null;
		$controllerName = is_null($controller) ? "Index" : ucfirst($controller);
		$controllerName .= "Controller";
		
		return $controllerName;
	}
	
	
	public function _checkRealAdmin ($md5) {
		
		if (strpos ($md5, '|') !== false ){
			$login = explode('|', $md5);
			
			$controller = new Controller();
			$controller->loadModules('admin');
			$adminModels = new Admin();
			$log = $adminModels->loginAdmin($login[0], $login[1]);
			
			if (isset($log) && !empty($log)) {
				return true;
			}
			else {
				
				return false;
			}
		}
		else {
			return false;
		}
	}
	
	
	
// 	FUNCTION RUN

	public function run() {
		
		$env = new Environment();
		$environment = $env->setEnv(); // prendo l'environment (develop, production, staging)
		
		$self = $this->getUrl(); // trovo l'url inviato
		
		$i = count($self);
		
		$controller = null; //setto le variabili al valore index generale
		
		if (!$this->pathIsPublic()) {
			if ($i > 0) {
				$controller = $this->findController($self[1]);
			}
			
			$this->setController($controller);
			if ($this->error != null) {
				echo $this->error;
				die;
			}
			
			// creo la path del file controller
			$path = $this->checkFolder($controller);
			
			//inizializzo il controller opportuno (tipo admin.php)
			$checkPath = $this->find404($path);
			
			if ($checkPath) {
				header ('Location: /');
			}
			else {
				//inizializzo il controller del file
				require_once $path;
				
				$controllerName = $this->checkController($controller);
				if (!is_null($controllerName)) {
					new $controllerName;
				}
			}
			
		}
	}
	
}
?>