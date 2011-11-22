<?php

class ClientsOrders extends Clients {
	var $module;

	function __construct($name) {
			$this->module = $name;
			$this->form_url = "apps/clients/modules/$name/";
			$this->model = new ClientsOrdersModel();
			$this->binDisplay = true;
	}


	function getList($id,$sort) {
		global $system, $lang;
		$arr = $this->model->getList($id,$sort);
		$orders = $arr["orders"];
		ob_start();
			include('view/list.php');
			$data["html"] = ob_get_contents();
		ob_end_clean();
		$data["sort"] = $arr["sort"];
		$data["perm"] = $arr["perm"];
		$data["title"] = $lang["CLIENT_ORDER_ACTION_NEW"];
		return $system->json_encode($data);
	}


	function getDetails($id) {
		global $lang;
		if($arr = $this->model->getDetails($id)) {
			$order = $arr["order"];
			$order_details = $arr["order_details"];
			$sendto = $arr["sendto"];
			ob_start();
				include 'view/edit.php';
				$data["html"] = ob_get_contents();
			ob_end_clean();
			$data["access"] = $arr["access"];
			return json_encode($data);
		} else {
			ob_start();
				include CO_INC .'/view/default.php';
				$data["html"] = ob_get_contents();
			ob_end_clean();
			return json_encode($data);
		}
	}


	function printDetails($id,$t) {
		global $session, $lang;
		$title = "";
		$html = "";
		if($arr = $this->model->getDetails($id)) {
			$order = $arr["order"];
			$sendto = $arr["sendto"];
			ob_start();
				include 'view/print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $order->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["CLIENT_PRINT_ORDER"];
		switch($t) {
			case "html":
				$this->printHTML($title,$html);
			break;
			default:
				$this->printPDF($title,$html);
		}
	}
	
	function getSend($id) {
		global $lang;
		if($arr = $this->model->getDetails($id)) {
			$order = $arr["order"];			
			$form_url = $this->form_url;
			$request = "sendDetails";
			$to = $order->management;
			$cc = "";
			$subject = $order->title;
			$variable = "";
			
			include CO_INC .'/view/dialog_send.php';
		}
		else {
			include CO_INC .'/view/default.php';
		}
	}
	
	
	function sendDetails($id,$variable,$to,$cc,$subject,$body) {
		global $session, $users, $lang;
		$title = "";
		$html = "";
		if($arr = $this->model->getDetails($id)) {
			$order = $arr["order"];
			$sendto = $arr["sendto"];
			ob_start();
				include 'view/print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $order->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["CLIENT_PRINT_ORDER"];
		$attachment = CO_PATH_PDF . "/" . $this->normal_chars($title) . ".pdf";
		$pdf = $this->savePDF($title,$html,$attachment);
		
		// write sento log
		$this->writeSendtoLog("clients_orders",$id,$to,$subject,$body);
		
		//$to,$from,$fromName,$subject,$body,$attachment
		return $this->sendEmail($to,$cc,$session->email,$session->firstname . " " . $session->lastname,$subject,$body,$attachment);
	}


	function checkinOrder($id) {
		if($id != "undefined") {
			return $this->model->checkinOrder($id);
		} else {
			return true;
		}
	}
	

	function setDetails($id,$title,$protocol,$documents,$order_access,$order_access_orig,$order_status,$order_status_date) {
		if($arr = $this->model->setDetails($id,$title,$protocol,$documents,$order_access,$order_access_orig,$order_status,$order_status_date)){
			return '{ "action": "edit" , "id": "' . $arr["id"] . '", "access": "' . $order_access . '", "status": "' . $order_status . '"}';
		} else{
			return "error";
		}
	}


	function createNew($id) {
		$retval = $this->model->createNew($id);
		if($retval){
			 return '{ "what": "order" , "action": "new", "id": "' . $retval . '" }';
		  } else{
			 return "error";
		  }
	}


	function createDuplicate($id) {
		$retval = $this->model->createDuplicate($id);
		if($retval){
			 return $retval;
		  } else{
			 return "error";
		  }
	}


	function binOrder($id) {
		$retval = $this->model->binOrder($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}

	function restoreOrder($id) {
		$retval = $this->model->restoreOrder($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}
	
	function deleteOrder($id) {
		$retval = $this->model->deleteOrder($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}

	function toggleIntern($id,$status) {
		$retval = $this->model->toggleIntern($id,$status);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}

	
	function getOrderStatusDialog() {
		global $lang;
		include 'view/dialog_status.php';
	}
	
	
	function createExcel($folderid,$menueid) {
		global $system, $lang;
		$arr = $this->model->createExcel($folderid,$menueid);
		$clients = $arr["clients"];
		$date = $arr["date"];

		require_once(CO_INC . "/classes/phpExcel/PHPExcel.php");
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator("company observer")
									 ->setTitle("company observer Export");
		
	
				
			$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('B1', 'Montag')
					->setCellValue('B2', $date)
					->setCellValue('D1', 'Dienstag')
					->setCellValue('F1', 'Mittwoch')
					->setCellValue('H1', 'Donnerstag')
					->setCellValue('J1', 'Freitag')
					->setCellValue('L1', 'Anmerkungen');
				
			
			$row = 3;
			foreach($clients as $client) {
				$col = 0;
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $client->clientname);
				// line 1
				if($client->line_1 == 1 || $client->line_1 == 3) {
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col+1, $row, $client->mon);
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col+2, $row, $client->mon_note);
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col+3, $row, $client->tue);
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col+4, $row, $client->tue_note);
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col+5, $row, $client->wed);
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col+6, $row, $client->wed_note);
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col+7, $row, $client->thu);
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col+8, $row, $client->thu_note);
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col+9, $row, $client->fri);
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col+10, $row, $client->fri_note);
					if($client->line_1 == 3) {
						$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col+11, $row, 'automatische Bestellung');
					}
				} else {
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col+11, $row, 'Keine Bestellungen vorhanden');
				}
				
				//line 2
				if($client->contract > "4") {
						$row++;
						$col = 0;
						if(array_key_exists('mon_2', $client)) {
							$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col+1, $row, $client->mon_2);
						}
						if(array_key_exists('tue_2', $client)) {
							$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col+3, $row, $client->tue_2);
						}
						if(array_key_exists('wed_2', $client)) {
							$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col+5, $row, $client->wed_2);
						}
						if(array_key_exists('thu_2', $client)) {
							$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col+7, $row, $client->thu_2);
						}
						if(array_key_exists('fri_2', $client)) {
							$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col+9, $row, $client->fri_2);
						}

				}
				
				// line 3
				if($client->contract > "6") {
						$row++;
						$col = 0;
						if(array_key_exists('mon_3', $client)) {
							$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col+1, $row, $client->mon_3);
						}
						if(array_key_exists('tue_3', $client)) {
							$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col+3, $row, $client->tue_3);
						}
						if(array_key_exists('wed_3', $client)) {
							$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col+5, $row, $client->wed_3);
						}
						if(array_key_exists('thu_3', $client)) {
							$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col+7, $row, $client->thu_3);
						}
						if(array_key_exists('fri_3', $client)) {
							$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col+9, $row, $client->fri_3);
						}
				}
                $row++;
            }
	
		$objPHPExcel->getActiveSheet()->setTitle('Export');
		$objPHPExcel->setActiveSheetIndex(0);

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="companyobserver.xls"');
		header('Cache-Control: max-age=0');
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		
	}



	function getHelp() {
		global $lang;
		$data["file"] =  $lang["CLIENT_ORDER_HELP"];
		$data["app"] = "clients";
		$data["module"] = "/modules/orders";
		$this->openHelpPDF($data);
	}
	
}

$clientsOrders = new ClientsOrders("orders");
?>