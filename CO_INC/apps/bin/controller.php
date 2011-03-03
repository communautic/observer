<?php

class Bin extends Controller {
	
	// get all available apps
	function __construct($name) {
			$this->application = $name;
			$this->form_url = "apps/$name/";
			//$this->model = new ProjectsModel();
			$this->modules = array();
			$this->num_modules = 0;
			$this->binDisplay = false;
	}
	



}
$bin = new Bin("bin");
?>