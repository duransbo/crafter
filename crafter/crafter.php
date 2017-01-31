<?php

	define('ROOT',str_replace("\\", "/", dirname(dirname(__FILE__))).'/');

	define('CSS', 'assets/css/');
	define('CONTROLLER', 'crafter/');

	class Crafter {

		private $styles = array();
		private $scripts = array();



		public function addCss($path, $category = 0) {

			$path .= '.css';

			if (file_exists(ROOT.$path)) {
				$this->styles['n'][$category][] = $path;
			}

		}



		public function addJs($path, $category = 0) {

			if (strpos($path, JS) === 0) {
				$path .= '.js';
			} else {
				$path .= '/index.js';
			}

			if (file_exists(ROOT.$path)) {
				$this->scripts['n'][$category][] = $path;
			}

		}



		public function css() {
			krsort($this->styles['n']);
			foreach ($this->styles['n'] as $category => $value) {
				$uri = '';
				foreach ($this->styles['n'][$category] as $key => $value) {
					$uri .= '&'.$key.'='.$this->styles['n'][$category][$key];
				}
				echo "\t\t".'<link rel="stylesheet" href="'.CONTROLLER.'crafter-css.php?'.$uri.'">'."\n";
			}
		}



		public function js() {
			krsort($this->scripts['n']);
			foreach ($this->scripts['n'] as $category => $value) {
				$uri = '';
				foreach ($this->scripts['n'][$category] as $key => $value) {
					$uri .= '&'.$key.'='.$this->scripts['n'][$category][$key];
				}
				echo "\t\t".'<script src="'.CONTROLLER.'js.php?'.$uri.'"></script>'."\n";
			}
		}

	}

	$crafter = new Crafter();

?>