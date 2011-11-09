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
	

	function setDetails($id,$protocol,$documents,$order_access,$order_access_orig,$order_status,$order_status_date) {
		if($arr = $this->model->setDetails($id,$protocol,$documents,$order_access,$order_access_orig,$order_status,$order_status_date)){
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