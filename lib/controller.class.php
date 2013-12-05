<?php

class Controller {
	public $file_path;
	public $function;
	public $self;
	public $method;
	public $funz;
	public $view;
	public $model;
	public $idLoggedUser;
	public $idLoggedAdmin;
	public $drinkoutToken;
	public $facebookCookie;
	public $userBrowser;
	
	public function __construct($childrenClassName = null) {
		
// 		$this->checkRequest();
		$this->idLoggedUser = $this->getCookie('id_user');
		
		if ($this->idLoggedUser || $this->isAjax()) {
		}
		else {
			$this->funz = $this->getfunction("index");
// 			die;
		}
		
		header('Content-type: text/html; charset=utf-8');
		
		$this->userBrowser = $this->_getBrowser();
		$this->method = $this->getMethod();
		$this->self = $this->getUrl();
		
		$this->file_path = $this->generatePathFile($this->self);
		
		if ($childrenClassName) {
			$this->setModel($childrenClassName);
		}
		$this->view = new View();
	}
	
// 	public function checkRequest() {
// 		$self = $_SERVER['REQUEST_URI'];
		
// 		if ( $self != '/' ) {
	
// 			if ( $this->isLogged() || $this->isLogin() ) {  
				
// 			} 
// 			else { 
// 				header('Location: /'); 
// 			}
			
// 		}
// 	}
	
	public function isLogin() {
	
		$password = isset($_POST['password']) ? $_POST['password'] : null;
		$username = isset($_POST['username']) ? $_POST['username'] : null;
	
		if ($this->_isPath('index/login') && $password && $username){
			return true;
		}
		return false;
	}
	
	protected function _noAvailableData() {
		$response = array();
		$response['status'] = 'error';
		$response['data'] = 'null';
		$response['error'] = 'No data found with the given parameters.';
		return $response;
	}
	
	
	
	public function setModel($modelName) {
		if (strpos(strtolower($modelName), 'controller')) {
			$modelName = substr($modelName, 0, -10);
		}
		$this->loadModules($modelName);
		$this->model = new $modelName;
	}
	
	public function getCookie($cookieName) {
		if (isset($_COOKIE[$cookieName])) {
			return $_COOKIE[$cookieName];
		}
	}
	
	public function _setCookie($userId) {
		$this->loadModules("user");
		$userModel = new User();
		$user = $userModel->selectUserByID($userId);
		if ($user) {
			$drinkouString = $user['id_user'].$user['date_registration'].$user['mail']."70division";
			$drinkoutToken = md5($drinkouString);
				
			setcookie('drinkoutToken', $drinkoutToken, time() + 5184000, "/" ); //setto cookie di controllo
			setcookie('id_user', $user['id_user'], time() + 5184000, "/"); // aggiorno cookie
			$this->idLoggedUser = $user['id_user'];
			return true;
		}
		throw new Exception('Can\'t set the cookie for the given user id.');
	}
	
	
	
	public function getMethod(){
		$method = strtolower($_SERVER['REQUEST_METHOD']);
		return $method;
	}
	
	public function getUrl() {
		$self = $_SERVER['REQUEST_URI'];
		$self = parse_url($self);
		$self = explode("/", $self['path']);
		$self = array_filter($self);
		
		foreach($self as $urlPortion) {
			$indice = "indice".strpos($urlPortion, "?");
				
			if ($indice == "indice0") {
				$self[2] = "index";
			}
		}
		
		return $self;
	}
	
	
	public function isAjax() {
		if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
			return true;
		}
		return false;
	}
	
	
	public function isLogged() {
		if (!is_null($this->idLoggedUser) || isset($_COOKIE['id_user'])) {
			return true;
		}
		
		return false;
		
	}
	
	public function getPost($varName) {
		if (isset($_POST[$varName])) {
			return $_POST[$varName];
		}
		return null;
	}
	
	
	public function getVar($varName) {
		if (isset($_GET[$varName])) {
			return $_GET[$varName];
		}
		return null;
	}
	
	public function parseRequest() {
		$vars = array();
		if (strpos($_SERVER['REQUEST_URI'], "?")) { 
			list($path, $query) = explode("?", $_SERVER["REQUEST_URI"], 2);
			parse_str($query, $vars);
// 			$this->boxPrint($vars);
			return $vars;
		}
		return null;
	}

	
	public function getfunction($self) {
		
		$afterGet = ucfirst($self);
		$this->funz = "get".$afterGet;
		
		return $this->funz;
	}
	
	public function postfunction($self){
	
		$afterPost = ucfirst($self);
		$this->funz = "post".$afterPost;
	
		return $this->funz;
	}
	
	public function putfunction($name) {
		$name = ucfirst($name);
		$this->funz = "put".$name;
		
		return $this->funz;
	}
	
	
	
	public function loadFile($method, $self) {
		
			switch ($method) {
				
				case 'get';
		//			Require controller function
					$this->funz = isset($self[2]) ? $this->getfunction($self[2]) : $this->getfunction("index");
					
// 					$this->boxPrint($this->funz);
					
					if (isset($self[3])) {
						$function = $this->{$this->funz}($self[3]);
					} else {
						$function = $this->{$this->funz}();
					}
					
					break;
					
				case 'post' :
					
		//			Require controller function
					$this->funz = isset($self[2]) ? $this->postfunction($self[2]) : $this->postfunction("index");
					if (isset($self[3])) {
						$function = $this->{$this->funz}($self[3]);
					} else {
						$function = $this->{$this->funz}();
					}
					
					break;
					
				case 'put' :
					$this->funz = isset($self[2]) ? $this->putfunction($self[2]) : $this->putfunction("index");
					
					if (isset($_SERVER['CONTENT_TYPE']) && $_SERVER['CONTENT_TYPE'] == 'application/json') {
						$put_vars = json_decode(file_get_contents("php://input"), true);
					} else {
						parse_str(file_get_contents("php://input"), $put_vars);
					}
					$function = $this->{$this->funz}($put_vars);
					break;
					
				case 'delete' :
					break;
			}
// 		}
// 		else {
// 			$this->funz = $this->getfunction("index");
// 			$function = $this->{$this->funz}();
// 		}
	}
	
	public function generatePathFile($self) {
		
		$path = "";
		$path .= isset ($self[1]) ? DOCUMENT_ROOT."/../app/views/content/central/" : null ;
		$path .= isset ($self[2]) ? $self[2]."/" : "index/" ;
		$path .= isset ($self[3]) ? $self[3].".php" : "index.php";
		
		return $path;
	}
	
	public static function loadModules($module, $workspace = null) {
		
		if ($workspace == null) {
			$modules = ROOT.DS."models".DS.strtolower($module).".class.php";
		} else {
			$modules = ROOT.DS."models".DS.strtolower($module).".class.php";
		}
	
		require_once $modules;
 		return $modules;
	}
	
	
	public function loadController($controller) {
		$controller = APPLICATION_PATH.DS."app/controllers".DS.strtolower($controller).".controller.php";
		require_once $controller;
		return $controller;
	}
	
	public function getMiracle($self) {
		$ops = "get".ucfirst($self[3]);
		return $ops;
	}
	
	public function notFound() {
		$this->view->load('404');
		$this->view->render();
	}
	
	protected function report($vars, $dieFlag) {
		$drinkout = new Drinkout();
		$drinkout->report($vars, $dieFlag);
	}
	
	protected function _deleteCookie() {
		setcookie('id_fb', '', time() - 3600, '/');
		setcookie('id_user', '', time() - 3600, '/');
		setcookie('drinkoutToken', '', time() - 3600, '/');
		
		if (!isset($_COOKIE['id_fb']) && !isset($_COOKIE['id_user']) && !isset($_COOKIE['drinkoutToken'])) {
			return true;
		}
		
		return false;
	}
	
	protected function _check() {
		if (isset($this->idLoggedUser)) {
			$this->loadController('User');
			$userController = UserController::_getUser($this->idLoggedUser);
			
			$drinkoutString = $userController['id_user'].$userController['date_registration'].$userController['mail']."70division";
			$drinkoutToken = md5($drinkoutString);
			
			if (isset($this->facebookCookie['drinkoutToken']) && $drinkoutToken == $this->facebookCookie['drinkoutToken']) {
				return $drinkoutToken;
			} else {
				$this->idLoggedUser = null;
				return null;
			}
		} else {
			return null;
		}
		
	}
	
	
	public function isChrome(){
		if ($this->userBrowser['name'] == "Google Chrome") {
			return true;
		}
		return false;
	}
	
	public function isSafari(){
		if ($this->userBrowser['name'] == "Apple Safari") {
			return true;
		}
		return false;
	}
	
	public function isMozzilla(){
		if ($this->userBrowser['name'] == "Mozilla Firefox") {
			return true;
		}
		return false;
	}
	
	
	public function isExplorer(){
		if ($this->userBrowser['name'] == "Internet Explorer") {
			return true;
		}
		return false;
	}
	
	public function isOpera(){
		if ($this->userBrowser['name'] == "Opera") {
			return true;
		}
		return false;
	}
	
	protected function _getBrowser() {
		$u_agent = $_SERVER['HTTP_USER_AGENT'];
		$bname = 'Unknown';
		$platform = 'Unknown';
		$version= "";
		$bname = 'Unknow';
		$ub = 'Unknown';
			
			
		//First get the platform?
		if (preg_match('/linux/i', $u_agent)) { $platform = 'linux'; }
		elseif (preg_match('/macintosh|mac os x/i', $u_agent)) { $platform = 'mac'; }
		elseif (preg_match('/windows|win32/i', $u_agent)) { $platform = 'windows'; }
		// Next get the name of the useragent yes seperately and for good reason
		if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)) {
			$bname = 'Internet Explorer';
			$ub = "MSIE";
		} else if (preg_match('/Firefox/i',$u_agent)) {
			$bname = 'Mozilla Firefox';
			$ub = "Firefox";
		} else if (preg_match('/Chrome/i',$u_agent)) {
			$bname = 'Google Chrome';
			$ub = "Chrome";
		} else if (preg_match('/Safari/i',$u_agent)) {
			$bname = 'Apple Safari';
			$ub = "Safari";
		} else if (preg_match('/Opera/i',$u_agent)) {
			$bname = 'Opera';
			$ub = "Opera";
		} else if (preg_match('/Netscape/i',$u_agent)) {
			$bname = 'Netscape';
			$ub = "Netscape";
		} else if (preg_match('/Mozilla/i',$u_agent)) {
			$bname = 'Mozilla';
			$ub = "Mozilla";
		} else if (preg_match('/AppleWebKit/i',$u_agent)) {
			$bname = 'Mozilla';
			$ub = "Mozilla";
		} else if (@preg_match('^/(facebook*)./i', $u_agent)) {
			$bname = 'Facebook';
			$ub = 'Facebook';
		}
	
		//if (!isset($ub)) { echo $u_agent; exit(); }
			
			
		// finally get the correct version number
		$known = array('Version', $ub, 'other');
		$pattern = '#(?<browser>'.join('|', $known).')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
		if (!preg_match_all($pattern, $u_agent, $matches)) {
			// we have no matching number just continue
		}
			
		// see how many we have
		$i = count($matches['browser']);
		if (!empty($matches['version'])) {
			if ($i != 1) {
				//we will have two since we are not using 'other' argument yet
				//see if version is before or after the name
				if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){ $version= $matches['version'][0]; }
				else { $version = $matches['version'][1]; }
			} else { $version = $matches['version'][0]; }
		} else {
			$version = 'Unknown';
		}
			
		// check if we have a number
		if ($version == null || $version == "") { $version = "?"; }
			
		return array(
				'userAgent' => $u_agent,
				'name'      => $bname,
				'version'   => $version,
				'platform'  => $platform,
				'pattern'    => $pattern
		);
	}
	
	protected function _isFile($file) {
		if (strrpos($file, '://') !== false) { // remote file
			if (@fopen($file, 'r')) {
				return true;
			}
			return false;
		} else {
			if (file_exists($file)) {
				return true;
			}
			return false;
		}
	}

	protected function _getVars() {
		foreach ($_GET as $key => $var) {
			$_GET[$key] = str_replace('/', '', $var);
		}
		
		return $_GET;
	}
	
	protected function _isPath($path) {
		$url = $this->getUrl();
		$currentPath = isset($url[1]) ? $url[1].DS : DS;
		$currentPath .= isset($url[2]) ? $url[2].DS : null; 
		$currentPath .= isset($url[3]) ? $url[3] : null;
		
// 		print_r($path);
// 		print_r($currentPath);
// 		die;
		
		$pathToCheck = DS.$path;
		
		if ($currentPath == $pathToCheck) {
			return true;
		}
		
		return false;
	}
	
	
	public function _insertOrUpdateActionNew ($idAction, $idUser) {
		$this->loadModules('action');
		$actionModules = new Action();
		
		$action = $actionModules->selectActionNew($idAction, $idUser);
		
		$actionNew['id_action'] = $idAction;
		$actionNew['id_user'] = $idUser;
		$actionNew['flag'] = 1;
			
		if ( !isset($action) || !empty($action) ) {
			$check = $actionModules->insertActionNew($actionNew);
		}
		else {
			$check = $actionModules->updateActionNew($actionNew);
		}
		
		return $check;
	}
	
	
	public function insertNotifica ($type, $idTarget, $idUser, $tipo_notifica) {
			
		$this->loadModules('notifiche');
		$notificheModules = new Notifiche();
			
		$notifica['type'] = $type;
		$notifica['id_target'] = $idTarget;
		$notifica['id_sender'] = $this->idLoggedUser;
		$notifica['id_user'] = $idUser;
		$notifica['data'] = date('Y-m-d H:i:s');
		$notifica['read'] = 0;
		$notifica['tipo_notifica'] = $tipo_notifica;
	
		$insertNotifica = $notificheModules->insertNotifica($notifica);
			
		return $insertNotifica;
	}
	
	
	public function deleteNotifica ($idTarget, $tipo_notifica) {
		$this->loadModules('notifiche');
		$notificheModules = new Notifiche();
		
		$notifica['id_target'] = $idTarget;
		$notifica['tipo_notifica'] = $tipo_notifica;
		
		$deleteNotifica = $notificheModules->deleteNotifica($notifica);
			
		return $deleteNotifica;
	} 
	
	
	public function updateNotifica ($notifica) {
		$this->loadModules('notifiche');
		$notificheModules = new Notifiche();
		
		$updateNotifica = $notificheModules->updateNotificheOther($notifica);
			
		return $updateNotifica;
	}
	
	
	public function _getActionNew ($action) {
		$this->loadModules('action');
		$actionModel = new Action();
	
		$actionNew = $actionModel->selectActionNew($action['id_action'], $this->idLoggedUser);
	
		if ( isset($actionNew) && !empty($actionNew) ) {
			return $actionNew['flag'];
		}
		else {
			return 0;
		}
	}
	
	
	public function activityFeedLeft ($idProject, $workspace, $type, $idTarget, $idUser = null) {
		$this->loadModules('activity');
		$activityModules = new Activity();
			
		$activity['id_user'] = ( isset($idUser) && !empty($idUser) ) ? $idUser : 0;
		$activity['id_project'] = $idProject;
		$activity['id_sender'] = $this->idLoggedUser;
		$activity['workspace'] = $workspace;
		$activity['id_target'] = $idTarget;
		$activity['data'] = date('Y-m-d H:i:s');
			
		if ($workspace == 'action') {
			$element = $activityModules->selectActivityLeftAction($workspace, $idTarget);
				
			if (isset($element) && !empty($element)) {
				
				if ($type == 2 || $type == 3 || $type == 4) {
				
					$activity['from_type'] = $element['type'];
					$activity['type'] = ($type == $element['type']) ? 0 : $type;
					
				}
// 				else if ($element['type'] == 0) {
					
// 				}
				else {
					$activity['from_type'] = 0;
					$activity['type'] = $type;
				}
				
			}
			else {
				$activity['type'] = $type;
				$activity['from_type'] = 0;
			}
		}
		else {
			$activity['type'] = $type;
			$activity['from_type'] = 0;
		}
			
// 		$this->boxPrint($activity);
// 		die;
		
		$check = $activityModules->insertActivityLeft($activity);
			
		if ( isset($check) && !empty($check) ) {
			return true;
		}
		else {
			return false;
		}
	}
	
	
	public function deleteActivityFeed ($workspace, $idTarget) {
		$this->loadModules('activity');
		$activityModules = new Activity();
		
		$delete = $activityModules->deleteActivityFeedLeft($workspace, $idTarget);
		
		return $delete;
	}
	
	
	public function boxPrint ($var) {
		echo '<pre>';
		print_r($var);
		echo '</pre>';
	}
	
	public function activityFeedRight ($type, $idTarget) {
		$this->loadModules('activity');
		$activityModules = new Activity();
		
		$statOld = $activityModules->selectActivityRightStats(date('Y-m-d'), $type, $idTarget);
		
// 		$this->boxPrint($statOld);
		
		if (isset($statOld) && !empty($statOld)) {
			$stats['tot'] = $statOld['tot']+1;
			$stats['id'] = $statOld['id'];
			
			$check = $activityModules->updateActivityRight($stats);
		}
		else {
			$stats['data'] = date('Y-m-d');
			$stats['type'] = $type;
			$stats['id_target'] = $idTarget;
			$stats['tot'] = 1;
			
			$check = $activityModules->insertActivityRight($stats);
		}
		
		if ( isset($check) && !empty($check) ) {
			return true;
		}
		else {
			return false;
		}
	}
	
	
}
?>