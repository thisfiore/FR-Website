<?php

class Environment 
{	
	
	private $_debug;
	private $_err_rep;
	private $_trace_level;
	private $_config;
	public $_img_url;
	private $_autoload;
	
	/*
	 * Return the debug mode
	 * @return Bool
	 */
	
	public function getDebug() {
		return $this->_debug;
	}
	
	/*
	 * Return the trace level 
	 * @retun int
	 */
	public  function getTraceLevel() {
		return $this->_trace_level;
	}
	
	/*
	 * Return the configuration array depending on the mode
	 * you choose
	 * @return array
	 */
	
	public function getConfig() {
		return $this->_config;
	}
	
	/*
	 * Return the hostname for loading images
	 * @return string
	 */
	
	public function getImagesUrl() {
		return $this->_img_url;
	}
	
	/**
	 * Initialize the Environment
	 * @param constant mode
	 */
	
	public function __construct() {
		
		// set the active mode
		$this->_mode = $this->getEnv();
		$this->setConfig();
		$this->setErrRep();
		
	}
	
	/**
	 * Sets the configuration for the choosen environment
	 * @param constant $mode 
	 */
	
	public function setConfig() {
		switch ($this->_mode) {
			case 'DEVELOPMENT' :
				$this->_debug = TRUE;
				$this->_err_rep = E_ALL;
				$this->_display_errs = 1;
				$this->_img_url = 'http://drinkout.dev';
				$this->error_log = 'error.log';
				
				break;
					
			case 'STAGING' : 
				$this->_debug = TRUE;
				$this->_trace_level = 1;
				$this->_err_rep = E_ALL;
				$this->_display_errs = 0;
				$this->_img_url = PROTOCOL.HOSTNAME;
				break;
				
			case 'PRODUCTION': 
				$this->_config = array_merge_recursive($this->main(), $this->_production());
				$this->_debug = FALSE;
				$this->_trace_level = 0;
				$this->_err_rep = E_ALL;
				$this->_display_errs = 1;
				$this->_img_url = '';
				break;
				
			default :
				$this->_config = $this->main();
				$this->_debug = FALSE;
				$this->_trace_level = 0;
				$this->_err_rep = E_WARNING;
				$this->_img_url = '';
				break;
		}
	}
	
	/**
	 * Main configuration 
	 * This is the general configuration that uses all environments
	 * 
	 */
	
	private function main() {
		return array(
					'basePath' => realpath(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'),
					'name' => 'Admin 70 Division',
					'params' => array(
								'adminEmail' => 'ricca.prog@gmail.com',
								'environment' => $this->_mode
							)
				);
	}
	
	
	
	/*
	 * Production Configuration
	 * - Remote DB
	 */
	private function _production() {
		return array(
				'components' => array(
								'db' => array(
										'host' => '82.196.3.200',
										'user' => 'socialgifting',
										'pass' => 'alllpcanoliaanaoianaaauieebauuno',
										'db' => 'foodrepublic',
										)
						)
				);
	}
	
	/*
	 * Set the application environment
	 * @return string
	 */
	
	public function setEnv() {

		switch ($_SERVER['HTTP_HOST']) {
			case 'foodrepublic.dev' :
				defined("APPLICATION_ENV") || define("APPLICATION_ENV", 'DEVELOPMENT');
				break;
			case 'foodrepublic.70division.com' :
				defined("APPLICATION_ENV") || define("APPLICATION_ENV", 'PRODUCTION');
				break;
			default :
				defined("APPLICATION_ENV") || define("APPLICATION_ENV", 'PRODUCTION');
				break;
		}
		
		return APPLICATION_ENV;
	}
	
	
	/*
	 * Get the application environment
	 * @return string
	 * 
	 */
	
	public function getEnv() {
		if (defined("APPLICATION_ENV")) {
			return strtoupper(APPLICATION_ENV);
		} else {
			return $this->setEnv();
		}
	}
	
	
	public function setErrRep($level = null) {
		$level = is_null($level) ? $this->_err_rep : $level;

		error_reporting($level);
		ini_set('display_errors', $this->_display_errs);
		ini_set('log_errors', 1);
	}
	
	
	
	
}