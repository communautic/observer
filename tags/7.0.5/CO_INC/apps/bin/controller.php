<?php

class Bin extends Controller {
	
	function __construct($name) {
			$this->application = $name;
			$this->form_url = "apps/$name/";
			//$this->model = new ProjectsModel();
			$this->modules = array();
			$this->num_modules = 0;
			$this->binDisplay = false;
			$this->archiveDisplay = false;
			$this->contactsDisplay = false; // list access status on contact page
	}
	
	function getHelp() {
		global $lang;
		$data["file"] = $lang["BIN_HELP"];
		$data["app"] = "bin";
		$data["module"] = "";
		$this->openHelpPDF($data);
	}

}
$bin = new Bin("bin");
?>