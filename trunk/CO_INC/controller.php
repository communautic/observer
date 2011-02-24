<?php
//include_once("model.php");

class Controller extends MySQLDB {
	var $applications = array();
	var $num_applications;
	var $modules = array();
	var $form_url;
	//var $modules = array();

	// get all available apps
	function __construct() {
		global $system,$session;
		$this->_db = new MySQLDB();
		$this->model = new Model();
		$q = "select value from co_config where name='applications'";
		$result = mysql_query($q, $this->_db->connection);
		$row = mysql_result($result,0);
		$this->applications = $system->json_decode($row);
		//$this->num_applications = sizeof($this->applications);
	}


	function getModules($app) {
		global $system;
		$retval = $this->model->getModules($app);
		$modules = $system->json_decode($retval);
		return $modules;
	}


	function setSortOrder($module,$items,$item=0) {
		$retval = $this->model->setSortOrder($module,$items,$item);
		if($retval){
			return true;
		 } else{
			 return "error";
		 }
	}


	function printPDF($title,$text) {
		$header = $this->model->getPrintHeader();
		$footer = $this->model->getPrintFooter();
		$html = $header . $text . $footer;
			require_once(CO_INC . "/classes/dompdf/dompdf_config.inc.php");
			$dompdf = new DOMPDF();
			$dompdf->load_html($html);
			$dompdf->render();
			$options['Attachment'] = 1;
			$options['Accept-Ranges'] = 0;
			$options['compress'] = 1;
			$dompdf->stream($title.".pdf", $options);
		
	}
	
	function printHTML($title,$text) {
		$header = $this->model->getPrintHeader();
		$footer = $this->model->getPrintFooter();
		$html = $header . $text . $footer;
		echo($html);
		
	}

}

$controller = new Controller();
?>