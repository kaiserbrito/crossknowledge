<?php
class Controller {
	function __construct() {
		$this->view = new View();
	}
	
	public function loadModel($name, $default = true) {
		
		$path = 'models/'.$name.'Model.php';
		
		if (file_exists($path)) {
			require 'models/'.$name.'Model.php';
			
			$modelName = $name . 'Model';
			
			if($default){
				$this->model = new $modelName();
			}else{
				return new $modelName();
			}
		}		
	}
}