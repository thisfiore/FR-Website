<?php 
class View {
	
	public $head;
	public $header;
	public $central;
	public $sidebar;
	public $footer;
	public $scripts;
	public $footerScripts;
	public $footeViewScripts;
	public $defaultScripts;
	public $customScripts;
	public $styles;
	public $defaultStyles;
	public $customStyles;
	public $validFileType = array(
				"css" => CSS_PATH,
				"text/css" => CSS_PATH,
				"javascript" => SCRIPT_PATH,
				"text/javascript" => SCRIPT_PATH,
				"script" => SCRIPT_PATH,
				"jpg" => IMG_PATH,
				"png" => IMG_PATH 
			);
	
	public function __construct() {
		$this->setHead();
		$this->setDefaultScripts();
		$this->setDefaultStyles();
	}
	
	public function setDefaultScripts() {
		$config = new Config();
		$configArray = $config->getConfig();
		if (isset($configArray['scripts']) && !empty($configArray['scripts'])) {
			foreach($configArray["scripts"] as $scriptName => $script) {
				$this->defaultScripts[$scriptName] = $this->parseScript($script);
			}
		}
	}
	
	public function addScripts($scripts = array()) {
		$parsedScripts = array(); 
		foreach($scripts as $scriptName => $script) {
			$parsedScripts[$scriptName] = $this->parseScript($script);
		}
		$this->customScripts = $parsedScripts;
	}
	
	public function addScriptsFooter($scripts = array()) {
		$parsedScripts = array();
		foreach($scripts as $scriptName => $script) {
			$parsedScripts[$scriptName] = $this->parseScript($script);
		}
		
		if (!empty($this->footerScripts)) {
			$this->footerScripts = array_merge($this->footerScripts, $parsedScripts);
		} else {
			$this->footerScripts = $parsedScripts;
		}
	}
	
	public function parseScript($script) {
		$parsedScript = array();
		$parsedScript["type"] = isset($script["style"]) ? $script["style"] : "text/javascript";
		$parsedScript["src"] = $this->checkFilePath($script["src"], $parsedScript["type"]);
		
		return $parsedScript;
	}
	
	public function getScripts() {
		
	}
	
	public function setDefaultStyles() {
		$config = new Config();
		$configArray = $config->getConfig();
		if (isset($configArray['styles']) && !empty($configArray['styles'])) {
			foreach($configArray["styles"] as $styleName => $style) {
				$this->defaultStyles[$styleName] = $this->parseStyles($style);
			}
		}
	}
	
	
	public function addStyles($styles = array()) {
		$parsedStyles = array();
		foreach($styles as $styleName => $style) {
			$parsedStyles[$styleName] = $this->parseStyles($style);
		}
		$this->customStyles = $parsedStyles;
	}
	
	public function parseStyles($style) {
		$parsedStyles = array();
		$parsedStyles["type"] = isset($style["type"]) ? $style["type"] : "text/css";
		$parsedStyles["rel"] = isset($style["rel"]) ? $style["rel"] : "stylesheet";
		$parsedStyles["href"] = $this->checkFilePath($style["href"], $parsedStyles["type"]);
		return $parsedStyles;
	}
	
	public function getStyles() {
		
	}
	
	public function checkFilePath($filePath, $fileType) {

		if (is_null($filePath)) {
			echo 'file path is null.';	
			return false;
		}
		$typeKey = array_key_exists($fileType, $this->validFileType);
		
		if ($typeKey !== false) {
			$typePath = $this->validFileType[$fileType];
		} else {
			echo 'no matched type for the file passed: '.$fileType.'<br>';
			return false;
		}
		
		if (isset($filePath)) {
			if (strpos($filePath, '/') !== false) {
				$path = $filePath;
			} else {
				$path = $typePath.DS.$filePath;
				
			}
		} else {
			$path = null;
		}		
		
	
		return $path;
		
	}
	
	public function setHead($head = 'head.php') {
		if ($head === null) {
			$this->head = null;
		} else { 
			$this->head = APPLICATION_PATH.DS."app".DS."views".DS."head".DS."head.php"; 
		}
			
	}
	
	public function load($header = "header", $central = "central", $sidebar = "sidebar", $footer = "footer") {
		
		// load scripts
		if (is_array($this->customScripts)) {
			$this->scripts = array_merge_recursive($this->defaultScripts, $this->customScripts);
		} else {
			$this->scripts = $this->defaultScripts;
		}

		if ($this->scripts) {
			foreach($this->scripts as $scriptName => $script) {
				if (strpos($script['src'], '//') === false && strpos($script['src'], 'http') === false) {
					if (!file_exists(DOCUMENT_ROOT.$script["src"])) {
						throw new Exception('Can\'t locate: '.$script["src"]);
						unset($this->scripts[$scriptName]);	
					}
				}	
			}
		}
		
		// load styles
		if (is_array($this->customStyles)) {
			$this->styles = array_merge_recursive($this->defaultStyles, $this->customStyles);
		} else {
			$this->styles = $this->defaultStyles;
		}
		
		if ($this->styles) {
			foreach($this->styles as $styleName => $style) {
				if (strpos($style['href'], '//') === false && strpos($style['href'], '//') == false) {
					if (!file_exists(DOCUMENT_ROOT.$style["href"])) {
						unset($this->styles[$styleName]);
					}
				}
			}
		}
		
		if (!is_null($header)) {
			$headerFile = $header != "header" ? CONTROLLER.DS.$header.".php" : "header.php";
			$headerFile = APPLICATION_PATH.DS."app".DS."views".DS."header".DS.$headerFile;
		} else {
			$headerFile = null;
		}
		
		if (!is_null($central)) {
			$centralFile = $central != "central" ? CONTROLLER.DS.$central.".php" : "central.php";
			$centralFile = APPLICATION_PATH.DS."app".DS."views".DS."content".DS."central".DS.$centralFile;
		} else {
			$centralFile = null;
		}
		if (!is_null($sidebar)) {
			$sidebarFile = $sidebar != "sidebar" ? CONTROLLER.DS.$sidebar.".php" : "sidebar.php";
			$sidebarFile = APPLICATION_PATH.DS."app".DS."views".DS."content".DS."sidebar".DS.$sidebarFile;
		} else {
			$sidebarFile = null;
		}
		
		if (!is_null($footer)) {
			$footerFile = $footer != "footer" ? CONTROLLER.DS.$footer.".php" : "footer.php";
			$footerFile = APPLICATION_PATH.DS."app".DS."views".DS."footer".DS.$footerFile;
		} else {
			$footerFile = null;
			$this->footerScripts = null;
		}
		
		$this->header = $headerFile;
		$this->central = $centralFile;
		$this->sidebar = $sidebarFile;
		$this->footer = $footerFile;
	}
	
	
	public function loadMail($template) {
		if (!is_null($template)) {
			$templateFile = $template != "template" ? $template.".php" : "template.php";
			$templateFile = APPLICATION_PATH.DS."views".DS."mail".DS.$templateFile;
		} else {
			$templateFile = null;
		}
		
		$this->mailTemplate = $templateFile;
	}
	
	public function render($vars = array()) {
		
		extract($this->scripts);
		
		isset ($this->footerScripts) ? extract($this->footerScripts) : null;
		
		if ($this->styles) {
			extract($this->styles);
		}
		
		extract($vars);
		ob_start();
		
		$footerScript = APPLICATION_PATH.DS."app".DS."views".DS."footer".DS."script.php";
		
// 		print_r($this->central);
// 		die;
		
		!is_null($this->head) ? require $this->head : null;
		!is_null($this->header) ? require $this->header : null;
		!is_null($this->central) ? require $this->central : null;
		!is_null($this->sidebar) ? require $this->sidebar : null;
		!is_null($this->footerScripts) ? require $footerScript : null;
		!is_null($this->footer) ? require $this->footer : null;
		
		$renderedView = ob_get_clean();
		echo $renderedView;
	}
	
	
	
	public function renderMail($vars = array()) {
		extract($vars);
		ob_start();
		
		!is_null($this->mailTemplate) ? require_once $this->mailTemplate : null;
		$renderMail = ob_get_clean();
		
		return $renderMail;
	}
	
	public function renderJson($content, $code = null) {
		
		if (isset($_GET['type']) && $_GET['type'] == 'html') {
			header('Content-type: text/plain');
		} else {
			header('Content-type: application/json');
		}
		if (is_array($content)) {
			foreach($content as $key => $chunk) {
				//$chunk = htmlentities(utf8_encode($chunk));
				$chunk = str_replace('ˆ', 'a\'', $chunk);
				$chunk = str_replace('', 'e\'', $chunk);
				$chunk = str_replace('“', 'i\'', $chunk);
				$chunk = str_replace('˜', 'o\'', $chunk);
				$content[$key] = str_replace('', 'u\'', $chunk);
			}
		}
		if (strpos(PHP_VERSION, '5.4') !==  false) {
			if (isset($code)) {
				http_response_code($code);
			}
			echo json_encode($content, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);
		} else {
			if (isset($code)) {
				header(' ', true, $code);
			}
			echo json_encode($content);
		}
		die;
	}
	
	
	
	public function renderResponse($content, $code = null) {
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
		header('Access-Control-Max-Age: 1000');
		$response = array();
		if (isset($content) && !empty($content)) {
			$response['status'] = 'success';
			if (isset($content['status']) && $content['status'] == 'success') {
				$response['status'] = $content['status'];
			} else if (isset($content['status']) && $content['status'] == 'error') {
				$response = $content;
			} else {
				$response['data'] = $content;
			}
		} else {
			$response['status'] = 'error';
			$response['data'] = 'null';
			$response['error'] = 'Undefined error.';
		}
		$code = isset($code) ? $code : 200;
		$this->renderJson($response, $code);
	}
	
	
	public function getContent($vars = array()) {
			
		extract($this->scripts);
		
		isset($this->footerScripts) ? extract($this->footerScripts) : null;
		extract($this->styles);
		extract($vars);
		ob_start();
		
		$footerScript = APPLICATION_PATH.DS."views".DS."footer".DS."script.php";
		
		!is_null($this->head) ? require $this->head : null;
		!is_null($this->header) ? require $this->header : null;
		!is_null($this->central) ? require $this->central : null;
		!is_null($this->sidebar) ? require $this->sidebar : null;
		!is_null($this->footerScripts) ? require $footerScript : null;
		!is_null($this->footer) ? require $this->footer : null;
		
		$renderedView = ob_get_clean();
		return $renderedView;
	}
}
?>