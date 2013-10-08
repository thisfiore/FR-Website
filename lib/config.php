<?php

class Config  {
	
		private static $foodrepublic = array(
						'components' => array(
								),
						'scripts' => array(
								"jquery" => array(
										"type" => "text/javascript",
										"src" => "jquery-1.9.1.min.js"),
								"jquery-ui" => array(
										"type" => "text/javascript",
										"src" => "jquery-ui.min.js"),
								"jquery-form" => array(
										"type" => "text/javascript",
										"src" => "jquery.form.js"),
								"jquery-cookie" => array(
										"type" => "text/javascript",
										"src" => "jquery.cookie.js"),
								"bootstrap.min" => array(
										"type" => "text/javascript",
										"src" => "bootstrap.min.js"),
								"home" => array(
										"type" => "text/javascript",
										"src" => "home.js"),
						),
						'styles' => array(
								"bootstrap" => array(
										"type" => "text/css",
										"rel" => "stylesheet",
										"href" => "bootstrap.css"),
								"main" => array(
										"type" => "text/css",
										"rel" => "stylesheet",
										"href" => "main.css"),
								
						)
				);
		
	
		private static $production = array( 
						'components' => array(
								'db' => array(
										'host' => '82.196.3.200',
										'user' => 'socialgifting',
										'pass' => 'alllpcanoliaanaoianaaauieebauuno',
										'db' => 'foodrepublic',
// 										'port' => '3306'
								
								),
						)
				);

		private static $development = array(
				'components' => array(
						'db' => array(
								'host' => '127.0.0.1',
								'user' => 'root',
								'pass' => 'settanta',
								'db' => 'foodrepublic',
								'port' => '3306'
						)
		
				)
		);
		
		public static function getConfig($environment = null) {
			
			if (is_null($environment)) {
				$envClass = new Environment();
				$environment = $envClass->getEnv();
			}
			$env = strtolower($environment);
			
			switch ($env) {
				case 'development':
					return array_merge_recursive(self::$foodrepublic, self::$development);
					break;
			
				case 'production':
					return array_merge_recursive(self::$foodrepublic, self::$production);
					break;			
			}
		}

}

	
?>