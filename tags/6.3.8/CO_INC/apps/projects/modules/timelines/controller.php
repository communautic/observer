<?php

class ProjectsTimelines extends Projects {
	var $module;
	
	function __construct($name) {
		$this->module = $name;
		$this->form_url = "apps/projects/modules/$name/";
		$this->model = new ProjectsTimelinesModel();
		$this->binDisplay = false;
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
		$data["title"] = "";
		return $system->json_encode($data);
	}
	
	function getDetails($id,$pid,$zoom) {
		global $date,$lang;
		
		switch($id) {
			case "1":
				$arr = $this->model->getBarchartDetails($pid,$zoom);
				$project = $arr["project"];
				ob_start();
					include('view/barchart.php');
					$data["html"] = ob_get_contents();
				ob_end_clean();
				$data["access"] = $arr["access"];
				return json_encode($data);
			break;
			case "2":
				$arr = $this->model->getDetails($pid);
				$project = $arr["project"];
				ob_start();
					include('view/schedule.php');
					$data["html"] = ob_get_contents();
				ob_end_clean();
				$data["access"] = $arr["access"];
				return json_encode($data);
			break;
			case "3":
				$arr = $this->model->getDetails($pid);
				$project = $arr["project"];
				ob_start();
					include('view/psp.php');
					$data["html"] = ob_get_contents();
				ob_end_clean();
				$data["access"] = $arr["access"];
				return json_encode($data);
			break;
			case "4":
				$arr = $this->model->getDetails($pid);
				$project = $arr["project"];
				ob_start();
					include('view/milestones.php');
					$data["html"] = ob_get_contents();
				ob_end_clean();
				$data["access"] = $arr["access"];
				return json_encode($data);
			break;
		}
		
		/*switch($id) {
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
		}*/
	}


	function printDetails($id,$pid,$t) {
		global $session,$date,$lang;
		$title = "";
		$html = "";
		
		switch($id) {
			case "1":
				if($arr = $this->model->getBarchartDetails($pid)) {
					$project = $arr["project"];
					
					$project["page_width"] = $project["css_width"]+245+300;
					$project["page_height"] = $project["css_height"]+200;
					if($project["page_width"] < 896) {
						$project["page_width"] = 896;
					}
					if($project["page_height"] < 595) {
						$project["page_height"] = 595;
					}
					
					ob_start();
					include('view/print_barchart.php');
						$html = ob_get_contents();
					ob_end_clean();
					$title = $project["title"] . " - " . $lang["PROJECT_TIMELINE_PROJECT_PLAN"];
					//$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PRINT_TIMELINE"];
					
					
					$this->printGantt($title,$html,$project["page_width"],$project["page_height"]);
				}
			break;
			case "3":
				if($arr = $this->model->getDetails($pid)) {
					$project = $arr["project"];
					
					$project["page_width"] = $project["css_width"];
					$project["page_height"] = $project["css_height"]+200;
					if($project["page_width"] < 896) {
						$project["page_width"] = 896;
					}
					if($project["page_height"] < 595) {
						$project["page_height"] = 595;
					}
					
					ob_start();
					include('view/print_psp.php');
						$html = ob_get_contents();
					ob_end_clean();
					$title = $project["title"] . " - " . $lang["PROJECT_TIMELINE_PROJECT_STRUCTURE"];
					//$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PRINT_TIMELINE"];
					$this->printPSP($title,$html,$project["page_width"], $project["page_height"]);
				}
			break;
			case "4":
				if($arr = $this->model->getDetails($pid)) {
					$project = $arr["project"];
					ob_start();
					include('view/print_milestones.php');
						$html = ob_get_contents();
					ob_end_clean();
					$title = $project["title"] . " - " . $lang["PROJECT_TIMELINE_DATES_MILESTONES"];
					$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PROJECT_PRINT_MILESTONES"];
				}
			break;
			default:
		
				if($arr = $this->model->getDetails($pid)) {
					$project = $arr["project"];
					ob_start();
						if($id == 3) {
							//include 'view/print_psp.php';
							include 'view/print_schedule.php';
						} else {
							include 'view/print_schedule.php';
						}
						$html = ob_get_contents();
					ob_end_clean();
					$title = $project["title"] . " - " . $lang["PROJECT_TIMELINE_DATES_LIST"];
					$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PROJECT_PRINT_TIMELINE"];
				}
		}
		
		switch($t) {
			case "html":
				$this->printHTML($title,$html);
			break;
			default:
				$this->printPDF($title,$html);
		}
	}
	
	function printGantt($title,$text,$width,$height) {
		global $lang;
		ob_start();
			include(CO_INC . "/view/printheader.php");
			$header = ob_get_contents();
		ob_end_clean();		
		$footer = "</body></html>";
        $html = $header . $text . $footer;
		require_once(CO_INC . "/classes/dompdf_60_beta2/dompdf_config.inc.php");
		$dompdf = new DOMPDF();
		$dompdf->load_html($html);
		/*$dompdf->set_paper('a4', 'portrait');  change 'a4' to whatever you want 
         breite, höhe pixel dividiert durch 96 * 72*/
        $dompdf->set_paper( array(0,0, $width / 96 * 72, $height / 96 * 72), "portrait" );
		$dompdf->render();
		$options['Attachment'] = 1;
		$options['Accept-Ranges'] = 0;
		$options['compress'] = 1;
		$dompdf->stream($title.".pdf", $options);
	}
	
	function printPSP($title,$text,$width,$height) {
		global $lang;
		ob_start();
			include(CO_INC . "/view/printheader.php");
			$header = ob_get_contents();
		ob_end_clean();
		
		$footer = "</body></html>";
        $html = $header . $text . $footer;
		require_once(CO_INC . "/classes/dompdf_60_beta2/dompdf_config.inc.php");
		$dompdf = new DOMPDF();
		$dompdf->load_html($html);
		//$dompdf->set_paper('a4', 'portrait'); // change 'a4' to whatever you want 
        // breite, höhe pixel dividiert durch 96 * 72
        $dompdf->set_paper( array(0,0, $width / 96 * 72, $height / 96 * 72), "portrait" );
		$dompdf->render();
		$options['Attachment'] = 1;
		$options['Accept-Ranges'] = 0;
		$options['compress'] = 1;
		$dompdf->stream($title.".pdf", $options);
	}


	function getSend($id,$pid) {
		global $projectsmodel, $lang;
		
		switch($id) {
			case "1":
				$title = $lang["PROJECT_TIMELINE_PROJECT_PLAN"];
			break;
			case "3":
				$title = $lang["PROJECT_TIMELINE_PROJECT_STRUCTURE"];
			break;
			case "4":
				$title = $lang["PROJECT_TIMELINE_DATES_MILESTONES"];
			break;
			default:
				$title = $lang["PROJECT_TIMELINE_DATES_LIST"];
		}
		
		$form_url = "apps/projects/modules/timelines/";
		$request = "sendDetails";
		$to = "";
		$cc = "";
		$subject = $projectsmodel->getProjectTitle($pid) . " - " . $title;
		$variable = $pid;
		include CO_INC .'/view/dialog_send.php';
	}


	function sendDetails($id,$variable,$to,$cc,$subject,$body) {
		global $projectsmodel,$session,$users,$date,$lang;
		$title = "";
		$html = "";
		
		switch($id) {
			case "1":

				if($arr = $this->model->getBarchartDetails($variable)) {
					$project = $arr["project"];
					
					$project["page_width"] = $project["css_width"]+245+300;
					$project["page_height"] = $project["css_height"]+200;
					if($project["page_width"] < 896) {
						$project["page_width"] = 896;
					}
					if($project["page_height"] < 595) {
						$project["page_height"] = 595;
					}
					
					ob_start();
					include('view/print_barchart.php');
						$html = ob_get_contents();
					ob_end_clean();
					$title = $project["title"] . " - " . $lang["PROJECT_TIMELINE_PROJECT_PLAN"];
					$attachment = CO_PATH_PDF . "/" . $this->normal_chars($title) . ".pdf";
					$pdf = $this->saveTimeline($title,$html,$attachment,$project["page_width"],$project["page_height"]);
				
					$this->writeSendtoLog("projects_gantt",$variable,$to,$subject,$body);
				}
			break;
			case "3":
				if($arr = $this->model->getDetails($variable)) {
					$project = $arr["project"];
					
					$project["page_width"] = $project["css_width"];
					$project["page_height"] = $project["css_height"]+200;
					if($project["page_width"] < 896) {
						$project["page_width"] = 896;
					}
					if($project["page_height"] < 595) {
						$project["page_height"] = 595;
					}
					
					ob_start();
					include('view/print_psp.php');
						$html = ob_get_contents();
					ob_end_clean();
					$title = $project["title"] . " - " . $lang["PROJECT_TIMELINE_PROJECT_STRUCTURE"];
					$attachment = CO_PATH_PDF . "/" . $this->normal_chars($title) . ".pdf";
					//$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PRINT_TIMELINE"];
					//$this->printPSP($title,$html,$project["page_width"], $project["page_height"]);
					$pdf = $this->saveTimeline($title,$html,$attachment,$project["page_width"],$project["page_height"]);
					$this->writeSendtoLog("projects_psp",$variable,$to,$subject,$body);
				}
			break;
			case "4":
				$arr = $this->model->getDetails($variable);
				$project = $arr["project"];
				ob_start();
					include('view/print_milestones.php');
					$html = ob_get_contents();
				ob_end_clean();
				$title = $project["title"] . " - " . $lang["PROJECT_TIMELINE_DATES_MILESTONES"];
				$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PROJECT_PRINT_MILESTONES"];
				$attachment = CO_PATH_PDF . "/" . $this->normal_chars($title) . ".pdf";
				$pdf = $this->savePDF($title,$html,$attachment);
				$this->writeSendtoLog("projects_milestones",$variable,$to,$subject,$body);
			break;
			default:
				if($arr = $this->model->getDetails($variable)) {
					$project = $arr["project"];
					ob_start();
						include 'view/print_schedule.php';
						$html = ob_get_contents();
					ob_end_clean();
					$title = $project["title"] . " - " . $lang["PROJECT_TIMELINE_DATES_LIST"];
					$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PROJECT_PRINT_TIMELINE"];
					$attachment = CO_PATH_PDF . "/" . $this->normal_chars($title) . ".pdf";
					$pdf = $this->savePDF($title,$html,$attachment);
					$this->writeSendtoLog("projects_timeline",$variable,$to,$subject,$body);
				}
			}
		
		//$to,$from,$fromName,$subject,$body,$attachment
		return $this->sendEmail($to,$cc,$session->email,$session->firstname . " " . $session->lastname,$subject,$body,$attachment);
}


	function getHelp() {
		global $lang;
		$data["file"] =  $lang["PROJECT_TIMELINE_HELP"];
		$data["app"] = "projects";
		$data["module"] = "/modules/timelines";
		$this->openHelpPDF($data);
	}

	
}

$projectsTimelines = new ProjectsTimelines("timelines");
?>