<?php

	header('Content-Type: text/css');

	define('ROOT',str_replace("\\", "/", dirname(dirname(__FILE__))).'/');



	class Mixin {

		private $return;
		private $default;

		public function __construct($return, $default = array()) {
			$this->return = $return;
			$this->default = $default;
		}

		public function __invoke($var) {
			$return = $this->return;
			foreach ($var as $key => $value) {
				$return = str_replace('$' . ($key + 1), $value, $return);
			}
			foreach ($this->default as $key => $value) {
				$return = str_replace('$' . $key, $value, $return);
			}
			return $return;
		}

	}



	class Extend {

		private $return;
		private $elements = array();
		private static $extends = array();

		public function __construct($return) {
			$this->return = $return;
			array_push(self::$extends, $this);
		}

		public function __invoke($element) {
			array_push($this->elements, $element);
			return $element;
		}

		public static function writeExtends() {
			foreach (self::$extends as $extend) {
				foreach ($extend->elements as $key => $value){
					echo ($key == 0) ? $value : ', ' . $value;
				}
				echo ' { ' . $extend->return . ' }' . "\n\n";
			}
		}

	}



	class CssCrafter {

		private static $instance = 0;

		private function __construct() { }
		private function __clone() { }
		private function __wakeup() { }

		public function render($files) {
			if (self::$instance === 0) {
            self::$instance = 1;
            foreach ($files as $file) {
					if (file_exists(ROOT.$file)) {
						require(ROOT.$file);
					} else {
						echo '//404';
					}
					echo "\n\n\n\n";
				}
				Extend::writeExtends();
			} else {
				echo "VAI TOMA NO CU";
			}
		}

	}


	CssCrafter::render($_GET);

?>