<?php

	header('Content-Type: text/css');

	define('ROOT',str_replace("\\", "/", dirname(dirname(__FILE__))).'/');



	class CssCrafter {

		private $extends = array();



		public function render($nameFile) {
			if (file_exists(ROOT.$nameFile)) {
				require(ROOT.$nameFile);
			} else {
				echo '//404';
			}
		}

		public function createCss($css){
			echo str_replace(";", ";\n\t", $css);
		}

		public function addExtend($class,$extend){
			$this->extends[$extend][] = $class;
			echo $class;
		}

		public function writeExtends(){
			foreach ($this->extends as $extendName => $extendValue){
				echo "/* EXTEND: ".$extendName." */\n";
				$i = 0;
				foreach ($extendValue as $class){
					if($i != 0){
						echo ",\n";
					}
			    	echo $class;
			    	$i++;
			    }
			    echo "{\n\t";
			    $extendName($this);
			    echo "}";
			}
		}

	}



	$crafter = new CssCrafter();
	foreach ($_GET as $file) {
		$crafter->render($file);
		echo "\n\n\n\n";
	}
	$crafter->writeExtends();

?>