<?php
class View {
	public function render($name, $noInclude = false){
		if ($noInclude == true) {
			require 'views/' . $name . '.php';	
		}
		else {
			require 'views/partials/header.php';
			require 'views/' . $name . '.php';
			require 'views/partials/footer.php';	
		}
	}
}