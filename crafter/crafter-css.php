<?php

	header('Content-Type: text/css');

	define('ROOT',str_replace("\\", "/", dirname(dirname(__FILE__))).'/');



	class Mixin {

		private $return;
		private $default;

		function __construct($return, $default) {
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

		private $return;
		private $elements = array();

		function __construct($return) {
			$this->return = $return;
			return $this;
		}

		function __invoke($element) {
			array_push($this->elements, $element);
			return $element;
		}

		public function getElements() {
			return $this->elements;
		}

		public function getReturn() {
			return $this->return;
		}

	}



	class CssCrafter {

		private $extends = array();

		function __construct($files) {
			foreach ($files as $file) {
				if (file_exists(ROOT.$file)) {
					require(ROOT.$file);
				} else {
					echo '//404';
				}
				echo "\n\n\n\n";
			}
		}

		public function mixin($return, $default = array()) {
			return new Mixin($return, $default);
		}

		public function extend($return) {
			$extend = new Extend($return);
			array_push($this->extends, $extend);
			return $extend;
		}

		public function writeExtends() {
			foreach ($this->extends as $extend) {
				foreach ($extend->getElements() as $key => $value){
					echo ($key == 0) ? $value : ', ' . $value;
				}
				echo ' { ' . $extend->getReturn() . ' }' . "\n\n";
			}
		}

	}


	$crafter = new CssCrafter($_GET);
	$crafter->writeExtends();

?>