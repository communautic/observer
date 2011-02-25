<?php

class Timelines {
	var $module;
	
	function __construct($name) {
			$this->module = $name;
			$this->form_url = "apps/projects/modules/$name/";
			$this->model = new TimelinesModel();
	}
	
	function getList($id,$sort) {
		global $system;
		$arr = $this->model->getList($id,$sort);
		$timelines = $arr["timelines"];
		ob_start();
			include('view/list.php');
			$data["html"] = ob_get_contents();
		ob_end_clean();
		$data["sort"] = $arr["sort"];
		return $system->json_encode($data);
	}
	
	function getDetails($id,$pid) {
		global $date,$lang;
		switch($id) {
			case "1":
				$data["what"] = $id;
				$project = $this->model->getBarchartDetails($pid);
				include('view/barchart.php');
			break;
			case "2":
				$data["what"] = $id;
				$project = $this->model->getDetails($pid);
				include('view/schedule.php');
			break;
			case "3":
				$data["what"] = $id;
				$project = $this->model->getDetails($pid);
				include('view/psp.php');
			break;
		}
	}
}

$timelines = new Timelines("timelines");
?>