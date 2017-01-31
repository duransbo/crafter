<?php

	header('Content-Type: text/css');

	define('ROOT',str_replace("\\", "/", dirname(dirname(__FILE__))).'/');



	class Mixin {

		private $return;
		private $default;

		function __construct($return, $default = array()) {
			$this->return = $return;
			$this->default = $default;
		}

		function __invoke($var) {
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

		public $return;
		public $elements = array();

		function __construct($crafter, $return) {
			$this->return = $return;
			array_push($crafter->extends, $this);
		}

		function __invoke($element) {
			array_push($this->elements, $element);
			return $element;
		}

	}



	class CssCrafter {

		public $extends = array();

		public function __construct($files) {
			foreach ($files as $file) {
				if (file_exists(ROOT.$file)) {
					require(ROOT.$file);
				} else {
					echo '//404';
				}
				echo "\n\n\n\n";
			}
		}

		public function writeExtends() {
			foreach ($this->extends as $extend) {
				foreach ($extend->elements as $key => $value){
					echo ($key == 0) ? $value : ', ' . $value;
				}
				echo ' { ' . $extend->return . ' }' . "\n\n";
			}
		}

	}


	$crafter = new CssCrafter($_GET);
	$crafter->writeExtends();

?>