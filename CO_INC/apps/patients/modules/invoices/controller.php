<?php

class PatientsInvoices extends Patients {
	var $module;

	function __construct($name) {
			$this->module = $name;
			$this->form_url = "apps/patients/modules/$name/";
			$this->model = new PatientsInvoicesModel();
			$this->binDisplay = true;
	}


	function getList($id,$sort) {
		global $system, $lang;
		$arr = $this->model->getList($id,$sort);
		$invoices = $arr["invoices"];
		ob_start();
			include('view/list.php');
			$data["html"] = ob_get_contents();
		ob_end_clean();
		$data["items"] = $arr["items"];
		$data["sort"] = $arr["sort"];
		$data["perm"] = $arr["perm"];
		$data["title"] = $lang["PATIENT_INVOICE_ACTION_NEW"];
		return $system->json_encode($data);
	}


	function getDetails($id) {
		global $lang;
		if($arr = $this->model->getDetails($id)) {
			$invoice = $arr["invoice"];
			$access = $arr["access"];
			$task = $arr["task"];
			$sendto = $arr["sendto"];
			ob_start();
				if($invoice->invoice_no > CO_INVOICE_START) {
					include 'view_reg/edit.php';
				} else {
					include 'view/edit.php';
				}
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

	function getPrintOptions() {
		global $lang;
			ob_start();
				include 'view/print_options.php';
				$html = ob_get_contents();
			ob_end_clean();
			return $html;
	}
	
	function getSendToOptions() {
		global $lang;
			ob_start();
				include 'view/sendto_options.php';
				$html = ob_get_contents();
			ob_end_clean();
			return $html;
	}
	
	
	function printDetails($id,$t,$option) {
		global $session, $lang;
		$title = "";
		$html = "";
		switch($option) {
			case 'invoice':
				if($arr = $this->model->getDetails($id)) {
					$invoice = $arr["invoice"];
					$task = $arr["task"];
					$pid = $invoice->pid;
					if($arr = $this->model->getPatientDetails($pid,'nocheckout')) {
						$patient = $arr["patient"];
					}
					ob_start();
						if($invoice->invoice_no > CO_INVOICE_START) {
							$invoice->invoice_number = $invoice->invoice_addon . '/' . $invoice->invoice_year . '/' . $invoice->invoice_no;
							include 'view_reg/print_invoice.php';
						} else {
							include 'view/print_invoice.php';
						}
						//include 'view/print_invoice.php';
						$html = ob_get_contents();
					ob_end_clean();
					//$title = $lang["PATIENT_INVOICE_TITLE"][0] . $invoice->invoice_number . ' ' . $invoice->lastname;
					$title = $invoice->invoice_number . ' ' . $invoice->lastname;
				}
				$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PATIENT_PRINT_INVOICE"];
				
				$dvr = '';
				if($invoice->m_dvr != "") {
					$dvr .= 'DVR-Nummer: ' . $invoice->m_dvr;
				}
				$GLOBALS['DVR'] =  $dvr;
				
				$line_1 = '';
				if($invoice->m_company != "") {
					$line_1 .= $invoice->m_company . ' | ';
				}
				if($invoice->m_plz != "" && $invoice->m_town != "" && $invoice->m_street != "") {
					$line_1 .= $invoice->m_plz . ' ' . $invoice->m_town . ', ' . $invoice->m_street . ' | ';
				}
				if($invoice->m_co_no != "") {
					$line_1 .= 'FN ' . $invoice->m_co_no . ' | ';
				}
				if($invoice->m_legal != "") {
					$line_1 .= 'Gerichtsstand ' . $invoice->m_legal . ' | ';
				}
				if($invoice->m_vat != "") {
					$line_1 .= $invoice->m_vat;
				}
				$GLOBALS['BANKING_LINE_1'] =  $line_1;
				
				$line_2 = '';
				if($invoice->m_bank != "") {
					$line_2 .= $invoice->m_bank . ' | ';
				}
				if($invoice->m_sort_code != "") {
					$line_2 .= 'BLZ ' . $invoice->m_sort_code . ' | ';
				}
				if($invoice->m_account_number != "") {
					$line_2 .= 'Kontonr. ' . $invoice->m_account_number . ' | ';
				}
				if($invoice->m_iban != "") {
					$line_2 .= 'IBAN ' . $invoice->m_iban . ' | ';
				}
				if($invoice->m_bic != "") {
					$line_2 .= 'BIC ' . $invoice->m_bic;
				}
				$GLOBALS['BANKING_LINE_2'] =  $line_2;
				
				switch($t) {
					case "html":
						$this->printHTML($title,$html);
					break;
					default:
						$this->printInvoice($title,$html);
				}
			break;
			case 'beleg':
				if($arr = $this->model->getDetails($id)) {
					$invoice = $arr["invoice"];
					$task = $arr["task"];
					$pid = $invoice->pid;
					if($arr = $this->model->getPatientDetails($pid,'nocheckout')) {
						$patient = $arr["patient"];
					}
					ob_start();
						include 'view/print_beleg.php';
						$html = ob_get_contents();
					ob_end_clean();
					$title = 'B ' . $invoice->beleg_nummer . ' ' . $invoice->lastname;
				}
				$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PATIENT_PRINT_BELEG"];
				
				$dvr = '';
				if($invoice->m_dvr != "") {
					$dvr .= 'DVR-Nummer: ' . $invoice->m_dvr;
				}
				$GLOBALS['DVR'] =  $dvr;
				
				$line_1 = '';
				if($invoice->m_company != "") {
					$line_1 .= $invoice->m_company . ' | ';
				}
				if($invoice->m_plz != "" && $invoice->m_town != "" && $invoice->m_street != "") {
					$line_1 .= $invoice->m_plz . ' ' . $invoice->m_town . ', ' . $invoice->m_street . ' | ';
				}
				if($invoice->m_co_no != "") {
					$line_1 .= 'FN ' . $invoice->m_co_no . ' | ';
				}
				if($invoice->m_legal != "") {
					$line_1 .= 'Gerichtsstand ' . $invoice->m_legal . ' | ';
				}
				if($invoice->m_vat != "") {
					$line_1 .= $invoice->m_vat;
				}
				$GLOBALS['BANKING_LINE_1'] =  $line_1;
				
				$line_2 = '';
				if($invoice->m_bank != "") {
					$line_2 .= $invoice->m_bank . ' | ';
				}
				if($invoice->m_sort_code != "") {
					$line_2 .= 'BLZ ' . $invoice->m_sort_code . ' | ';
				}
				if($invoice->m_account_number != "") {
					$line_2 .= 'Kontonr. ' . $invoice->m_account_number . ' | ';
				}
				if($invoice->m_iban != "") {
					$line_2 .= 'IBAN ' . $invoice->m_iban . ' | ';
				}
				if($invoice->m_bic != "") {
					$line_2 .= 'BIC ' . $invoice->m_bic;
				}
				$GLOBALS['BANKING_LINE_2'] =  $line_2;
				
				switch($t) {
					case "html":
						$this->printHTML($title,$html);
					break;
					default:
						$this->printBeleg($title,$html);
				}
			break;
			case 'invoice_plain':
				if($arr = $this->model->getDetails($id)) {
					$invoice = $arr["invoice"];
					$task = $arr["task"];
					$pid = $invoice->pid;
					if($arr = $this->model->getPatientDetails($pid,'nocheckout')) {
						$patient = $arr["patient"];
					}
					ob_start();
						if($invoice->invoice_no > CO_INVOICE_START) {
							$invoice->invoice_number = $invoice->invoice_addon . '/' . $invoice->invoice_year . '/' . $invoice->invoice_no;
							include 'view_reg/print_invoice_anon.php';
						} else {
							include 'view/print_invoice_anon.php';
						}
						$html = ob_get_contents();
					ob_end_clean();
					$title = $invoice->invoice_number . ' ' . $invoice->lastname;
				}
				$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PATIENT_PRINT_INVOICE"];
				
				$dvr = '';
				if($invoice->m_dvr != "") {
					$dvr .= 'DVR-Nummer: ' . $invoice->m_dvr;
				}
				$GLOBALS['DVR'] =  $dvr;
				
				$line_1 = '';
				if($invoice->m_company != "") {
					$line_1 .= $invoice->m_company . ' | ';
				}
				if($invoice->m_plz != "" && $invoice->m_town != "" && $invoice->m_street != "") {
					$line_1 .= $invoice->m_plz . ' ' . $invoice->m_town . ', ' . $invoice->m_street . ' | ';
				}
				if($invoice->m_co_no != "") {
					$line_1 .= 'FN ' . $invoice->m_co_no . ' | ';
				}
				if($invoice->m_legal != "") {
					$line_1 .= 'Gerichtsstand ' . $invoice->m_legal . ' | ';
				}
				if($invoice->m_vat != "") {
					$line_1 .= $invoice->m_vat;
				}
				$GLOBALS['BANKING_LINE_1'] =  $line_1;
				
				$line_2 = '';
				if($invoice->m_bank != "") {
					$line_2 .= $invoice->m_bank . ' | ';
				}
				if($invoice->m_sort_code != "") {
					$line_2 .= 'BLZ ' . $invoice->m_sort_code . ' | ';
				}
				if($invoice->m_account_number != "") {
					$line_2 .= 'Kontonr. ' . $invoice->m_account_number . ' | ';
				}
				if($invoice->m_iban != "") {
					$line_2 .= 'IBAN ' . $invoice->m_iban . ' | ';
				}
				if($invoice->m_bic != "") {
					$line_2 .= 'BIC ' . $invoice->m_bic;
				}
				$GLOBALS['BANKING_LINE_2'] =  $line_2;
				
				switch($t) {
					case "html":
						$this->printHTML($title,$html);
					break;
					default:
						$this->printInvoice($title,$html);
				}
			break;
			case 'services':
				if($arr = $this->model->getDetails($id)) {
					$invoice = $arr["invoice"];
					$task = $arr["task"];
					$pid = $invoice->pid;
					if($arr = $this->model->getPatientDetails($pid,'nocheckout')) {
						$patient = $arr["patient"];
					}
					if($invoice->invoice_no > CO_INVOICE_START) {
							$invoice->invoice_number = $invoice->invoice_addon . '/' . $invoice->invoice_year . '/' . $invoice->invoice_no;
						} 
					ob_start();
						include 'view/print_services.php';
						$html = ob_get_contents();
					ob_end_clean();
					$title = $lang["PATIENT_INVOICE_SERVICES"][0] . ' ' . $invoice->invoice_number . ' ' . $invoice->lastname;
				}
				$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PATIENT_PRINT_SERVICES"];
				
				$dvr = '';
				if($invoice->m_dvr != "") {
					$dvr .= 'DVR-Nummer: ' . $invoice->m_dvr;
				}
				$GLOBALS['DVR'] =  $dvr;
				
				$line_1 = '';
				if($invoice->m_company != "") {
					$line_1 .= $invoice->m_company . ' | ';
				}
				if($invoice->m_plz != "" && $invoice->m_town != "" && $invoice->m_street != "") {
					$line_1 .= $invoice->m_plz . ' ' . $invoice->m_town . ', ' . $invoice->m_street . ' | ';
				}
				if($invoice->m_co_no != "") {
					$line_1 .= 'FN ' . $invoice->m_co_no . ' | ';
				}
				if($invoice->m_legal != "") {
					$line_1 .= 'Gerichtsstand ' . $invoice->m_legal . ' | ';
				}
				if($invoice->m_vat != "") {
					$line_1 .= $invoice->m_vat;
				}
				$GLOBALS['BANKING_LINE_1'] =  $line_1;
				
				$line_2 = '';
				if($invoice->m_bank != "") {
					$line_2 .= $invoice->m_bank . ' | ';
				}
				if($invoice->m_sort_code != "") {
					$line_2 .= 'BLZ ' . $invoice->m_sort_code . ' | ';
				}
				if($invoice->m_account_number != "") {
					$line_2 .= 'Kontonr. ' . $invoice->m_account_number . ' | ';
				}
				if($invoice->m_iban != "") {
					$line_2 .= 'IBAN ' . $invoice->m_iban . ' | ';
				}
				if($invoice->m_bic != "") {
					$line_2 .= 'BIC ' . $invoice->m_bic;
				}
				$GLOBALS['BANKING_LINE_2'] =  $line_2;
				
				switch($t) {
					case "html":
						$this->printHTML($title,$html);
					break;
					default:
						$this->printInvoice($title,$html);
				}
			break;
			case 'reminder':
				if($arr = $this->model->getDetails($id)) {
					$invoice = $arr["invoice"];
					$task = $arr["task"];
					$pid = $invoice->pid;
					if($arr = $this->model->getPatientDetails($pid,'nocheckout')) {
						$patient = $arr["patient"];
					}
					ob_start();
						if($invoice->invoice_no > CO_INVOICE_START) {
							$invoice->invoice_number = $invoice->invoice_addon . '/' . $invoice->invoice_year . '/' . $invoice->invoice_no;
							include 'view_reg/print_reminder.php';
						} else {
							include 'view/print_reminder.php';
						}
						$html = ob_get_contents();
					ob_end_clean();
					$title = $lang["PATIENT_INVOICE_PAYMENT_REMINDER"][0] . ' ' . $invoice->invoice_number . ' ' . $invoice->lastname;
				}
				$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PATIENT_PRINT_REMINDER"];
				
				$dvr = '';
				if($invoice->m_dvr != "") {
					$dvr .= 'DVR-Nummer: ' . $invoice->m_dvr;
				}
				$GLOBALS['DVR'] =  $dvr;
				
				$line_1 = '';
				if($invoice->m_company != "") {
					$line_1 .= $invoice->m_company . ' | ';
				}
				if($invoice->m_plz != "" && $invoice->m_town != "" && $invoice->m_street != "") {
					$line_1 .= $invoice->m_plz . ' ' . $invoice->m_town . ', ' . $invoice->m_street . ' | ';
				}
				if($invoice->m_co_no != "") {
					$line_1 .= 'FN ' . $invoice->m_co_no . ' | ';
				}
				if($invoice->m_legal != "") {
					$line_1 .= 'Gerichtsstand ' . $invoice->m_legal . ' | ';
				}
				if($invoice->m_vat != "") {
					$line_1 .= $invoice->m_vat;
				}
				$GLOBALS['BANKING_LINE_1'] =  $line_1;
				
				$line_2 = '';
				if($invoice->m_bank != "") {
					$line_2 .= $invoice->m_bank . ' | ';
				}
				if($invoice->m_sort_code != "") {
					$line_2 .= 'BLZ ' . $invoice->m_sort_code . ' | ';
				}
				if($invoice->m_account_number != "") {
					$line_2 .= 'Kontonr. ' . $invoice->m_account_number . ' | ';
				}
				if($invoice->m_iban != "") {
					$line_2 .= 'IBAN ' . $invoice->m_iban . ' | ';
				}
				if($invoice->m_bic != "") {
					$line_2 .= 'BIC ' . $invoice->m_bic;
				}
				$GLOBALS['BANKING_LINE_2'] =  $line_2;
				
				switch($t) {
					case "html":
						$this->printHTML($title,$html);
					break;
					default:
						$this->printInvoice($title,$html);
				}
			break;
			case 'stationary':
				if($arr = $this->model->getDetails($id)) {
					$invoice = $arr["invoice"];
					$pid = $invoice->pid;
					if($arr = $this->model->getPatientDetails($pid,'nocheckout')) {
						$patient = $arr["patient"];
					}
					ob_start();
						include 'view/print_stationary.php';
						$html = ob_get_contents();
					ob_end_clean();
					$title = 'Kuvert ' . $invoice->lastname;
				}
				//$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PATIENT_PRINT_INVOICE"];
				$this->printStationary($title,$html,'595','290');
			break;
			case 'zuschuss':
				if($arr = $this->model->getDetails($id)) {
					$invoice = $arr["invoice"];
					$task = $arr["task"];
					$pid = $invoice->pid;
					if($arr = $this->model->getPatientDetails($pid,'nocheckout')) {
						$patient = $arr["patient"];
					}
					ob_start();
					if($invoice->invoice_no > CO_INVOICE_START) {
							$invoice->invoice_number = $invoice->invoice_addon . '/' . $invoice->invoice_year . '/' . $invoice->invoice_no;
						} 
						include 'view/print_zuschuss.php';
						$html = ob_get_contents();
					ob_end_clean();
					$title = 'K_' . $invoice->invoice_number . ' ' . $invoice->lastname;
				}
				$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PATIENT_PRINT_ZUSCHUSS"];
				
				$GLOBALS['BANKING_LINE_1'] =  '';
				
				$GLOBALS['BANKING_LINE_2'] =  '';
				
				switch($t) {
					case "html":
						$this->printHTML($title,$html);
					break;
					default:
						$this->printInvoice($title,$html);
				}
			break;
		}
	}
	
	
	function printStationary($title,$text,$width,$height,$headerimg='logo_print.png') {
		global $lang;
		$GLOBALS['STATIONARY'] = 1;
		$GLOBALS['HEADERIMG'] = $headerimg;
		ob_start();
			include(CO_INC . "/view/printheader.php");
			$header = ob_get_contents();
		ob_end_clean();	
		
		$pdfheader = CO_PATH_BASE . "/data/templates/pdfheader_logo.php";
		if(file_exists($pdfheader)) {
			ob_start();
				include_once($pdfheader);
				$headerpdf = ob_get_contents();
			ob_end_clean();
		}
		$footer = "</body></html>";
		$html = $header . '<script type="text/php">' . $headerpdf  . '</script>' . $text . $footer;
		require_once(CO_INC . "/classes/dompdf_60_beta2/dompdf_config.inc.php");
		$dompdf = new DOMPDF();
		$dompdf->load_html($html);
		/*$dompdf->set_paper('a4', 'portrait');  change 'a4' to whatever you want 
         breite, h�he pixel dividiert durch 96 * 72*/
        $dompdf->set_paper( array(0,0, $width, $height), "portrait" );
		$dompdf->render();
		$options['Attachment'] = 1;
		$options['Accept-Ranges'] = 0;
		$options['compress'] = 1;
		$dompdf->stream($title.".pdf", $options);
	}

	
	function getSend($id,$option) {
		global $lang;
		if($arr = $this->model->getDetails($id,'prepareSendTo')) {
			$invoice = $arr["invoice"];
			$pid = $invoice->pid;
			if($arr = $this->model->getPatientDetails($pid,'nocheckout')) {
				$patient = $arr["patient"];
			}
			
			$form_url = $this->form_url;
			$request = "sendDetails";
			$to = "";
			$cc = "";
			$subject = $invoice->title;
			$variable = $option;
			
			$data["error"] = 0;
			$data["error_message"] = "";
			ob_start();
				include CO_INC .'/view/dialog_send.php';
				$data["html"] = ob_get_contents();
			ob_end_clean();
			return json_encode($data);
		}
	}


	function sendDetails($id,$variable,$to,$cc,$subject,$body) {
		global $session, $users, $lang;
		$title = "";
		$html = "";
		switch($variable) {
			case 'invoice':
				if($arr = $this->model->getDetails($id)) {
					$invoice = $arr["invoice"];
					$task = $arr["task"];
					$pid = $invoice->pid;
					if($arr = $this->model->getPatientDetails($pid,'nocheckout')) {
						$patient = $arr["patient"];
					}
					ob_start();
						//include 'view/print_invoice.php';
						if($invoice->invoice_no > CO_INVOICE_START) {
							$invoice->invoice_number = $invoice->invoice_addon . '/' . $invoice->invoice_year . '/' . $invoice->invoice_no;
							include 'view_reg/print_invoice.php';
						} else {
							include 'view/print_invoice.php';
						}
						$html = ob_get_contents();
					ob_end_clean();
					$title = $invoice->invoice_number . ' ' . $invoice->lastname;
				}
				$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PATIENT_PRINT_INVOICE"];
				
				$line_1 = '';
				if($invoice->m_company != "") {
					$line_1 .= $invoice->m_company . ' | ';
				}
				if($invoice->m_plz != "" && $invoice->m_town != "" && $invoice->m_street != "") {
					$line_1 .= $invoice->m_plz . ' ' . $invoice->m_town . ', ' . $invoice->m_street . ' | ';
				}
				if($invoice->m_co_no != "") {
					$line_1 .= 'FN ' . $invoice->m_co_no . ' | ';
				}
				if($invoice->m_legal != "") {
					$line_1 .= 'Gerichtsstand ' . $invoice->m_legal . ' | ';
				}
				if($invoice->m_vat != "") {
					$line_1 .= $invoice->m_vat;
				}
				$GLOBALS['BANKING_LINE_1'] =  $line_1;
				
				$line_2 = '';
				if($invoice->m_bank != "") {
					$line_2 .= $invoice->m_bank . ' | ';
				}
				if($invoice->m_sort_code != "") {
					$line_2 .= 'BLZ ' . $invoice->m_sort_code . ' | ';
				}
				if($invoice->m_account_number != "") {
					$line_2 .= 'Kontonr. ' . $invoice->m_account_number . ' | ';
				}
				if($invoice->m_iban != "") {
					$line_2 .= 'IBAN ' . $invoice->m_iban . ' | ';
				}
				if($invoice->m_bic != "") {
					$line_2 .= 'BIC ' . $invoice->m_bic;
				}
				$GLOBALS['BANKING_LINE_2'] =  $line_2;
				
				$attachment = CO_PATH_PDF . "/" . $this->normal_chars($title) . ".pdf";
				$pdf = $this->saveInvoice($title,$html,$attachment);
			break;
			case 'beleg':
				if($arr = $this->model->getDetails($id)) {
					$invoice = $arr["invoice"];
					$task = $arr["task"];
					$pid = $invoice->pid;
					if($arr = $this->model->getPatientDetails($pid,'nocheckout')) {
						$patient = $arr["patient"];
					}
					ob_start();
						include 'view/print_beleg.php';
						$html = ob_get_contents();
					ob_end_clean();
					$title = 'B ' . $invoice->beleg_nummer . ' ' . $invoice->lastname;
				}
				$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PATIENT_PRINT_BELEG"];
				
				$line_1 = '';
				if($invoice->m_company != "") {
					$line_1 .= $invoice->m_company . ' | ';
				}
				if($invoice->m_plz != "" && $invoice->m_town != "" && $invoice->m_street != "") {
					$line_1 .= $invoice->m_plz . ' ' . $invoice->m_town . ', ' . $invoice->m_street . ' | ';
				}
				if($invoice->m_co_no != "") {
					$line_1 .= 'FN ' . $invoice->m_co_no . ' | ';
				}
				if($invoice->m_legal != "") {
					$line_1 .= 'Gerichtsstand ' . $invoice->m_legal . ' | ';
				}
				if($invoice->m_vat != "") {
					$line_1 .= $invoice->m_vat;
				}
				$GLOBALS['BANKING_LINE_1'] =  $line_1;
				
				$line_2 = '';
				if($invoice->m_bank != "") {
					$line_2 .= $invoice->m_bank . ' | ';
				}
				if($invoice->m_sort_code != "") {
					$line_2 .= 'BLZ ' . $invoice->m_sort_code . ' | ';
				}
				if($invoice->m_account_number != "") {
					$line_2 .= 'Kontonr. ' . $invoice->m_account_number . ' | ';
				}
				if($invoice->m_iban != "") {
					$line_2 .= 'IBAN ' . $invoice->m_iban . ' | ';
				}
				if($invoice->m_bic != "") {
					$line_2 .= 'BIC ' . $invoice->m_bic;
				}
				$GLOBALS['BANKING_LINE_2'] =  $line_2;
				
				$attachment = CO_PATH_PDF . "/" . $this->normal_chars($title) . ".pdf";
				$pdf = $this->saveInvoice($title,$html,$attachment);
			break;
			case 'invoice_plain':
				if($arr = $this->model->getDetails($id)) {
					$invoice = $arr["invoice"];
					$task = $arr["task"];
					$pid = $invoice->pid;
					if($arr = $this->model->getPatientDetails($pid,'nocheckout')) {
						$patient = $arr["patient"];
					}
					ob_start();
						if($invoice->invoice_no > CO_INVOICE_START) {
							$invoice->invoice_number = $invoice->invoice_addon . '/' . $invoice->invoice_year . '/' . $invoice->invoice_no;
							include 'view_reg/print_invoice_anon.php';
						} else {
							include 'view/print_invoice_anon.php';
						}
						$html = ob_get_contents();
					ob_end_clean();
					$title = $invoice->invoice_number . ' ' . $invoice->lastname;
				}
				$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PATIENT_PRINT_INVOICE"];
				
				$line_1 = '';
				if($invoice->m_company != "") {
					$line_1 .= $invoice->m_company . ' | ';
				}
				if($invoice->m_plz != "" && $invoice->m_town != "" && $invoice->m_street != "") {
					$line_1 .= $invoice->m_plz . ' ' . $invoice->m_town . ', ' . $invoice->m_street . ' | ';
				}
				if($invoice->m_co_no != "") {
					$line_1 .= 'FN ' . $invoice->m_co_no . ' | ';
				}
				if($invoice->m_legal != "") {
					$line_1 .= 'Gerichtsstand ' . $invoice->m_legal . ' | ';
				}
				if($invoice->m_vat != "") {
					$line_1 .= $invoice->m_vat;
				}
				$GLOBALS['BANKING_LINE_1'] =  $line_1;
				
				$line_2 = '';
				if($invoice->m_bank != "") {
					$line_2 .= $invoice->m_bank . ' | ';
				}
				if($invoice->m_sort_code != "") {
					$line_2 .= 'BLZ ' . $invoice->m_sort_code . ' | ';
				}
				if($invoice->m_account_number != "") {
					$line_2 .= 'Kontonr. ' . $invoice->m_account_number . ' | ';
				}
				if($invoice->m_iban != "") {
					$line_2 .= 'IBAN ' . $invoice->m_iban . ' | ';
				}
				if($invoice->m_bic != "") {
					$line_2 .= 'BIC ' . $invoice->m_bic;
				}
				$GLOBALS['BANKING_LINE_2'] =  $line_2;
				
				$attachment = CO_PATH_PDF . "/" . $this->normal_chars($title) . ".pdf";
				$pdf = $this->saveInvoice($title,$html,$attachment);
			break;
			case 'services':
				if($arr = $this->model->getDetails($id)) {
					$invoice = $arr["invoice"];
					$task = $arr["task"];
					$pid = $invoice->pid;
					if($arr = $this->model->getPatientDetails($pid,'nocheckout')) {
						$patient = $arr["patient"];
					}
					if($invoice->invoice_no > CO_INVOICE_START) {
							$invoice->invoice_number = $invoice->invoice_addon . '/' . $invoice->invoice_year . '/' . $invoice->invoice_no;
						} 
					ob_start();
						include 'view/print_services.php';
						$html = ob_get_contents();
					ob_end_clean();
					$title = $lang["PATIENT_INVOICE_SERVICES"][0] . $invoice->invoice_number . ' ' . $invoice->lastname;
				}
				$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PATIENT_PRINT_SERVICES"];
				
				$line_1 = '';
				if($invoice->m_company != "") {
					$line_1 .= $invoice->m_company . ' | ';
				}
				if($invoice->m_plz != "" && $invoice->m_town != "" && $invoice->m_street != "") {
					$line_1 .= $invoice->m_plz . ' ' . $invoice->m_town . ', ' . $invoice->m_street . ' | ';
				}
				if($invoice->m_co_no != "") {
					$line_1 .= 'FN ' . $invoice->m_co_no . ' | ';
				}
				if($invoice->m_legal != "") {
					$line_1 .= 'Gerichtsstand ' . $invoice->m_legal . ' | ';
				}
				if($invoice->m_vat != "") {
					$line_1 .= $invoice->m_vat;
				}
				$GLOBALS['BANKING_LINE_1'] =  $line_1;
				
				$line_2 = '';
				if($invoice->m_bank != "") {
					$line_2 .= $invoice->m_bank . ' | ';
				}
				if($invoice->m_sort_code != "") {
					$line_2 .= 'BLZ ' . $invoice->m_sort_code . ' | ';
				}
				if($invoice->m_account_number != "") {
					$line_2 .= 'Kontonr. ' . $invoice->m_account_number . ' | ';
				}
				if($invoice->m_iban != "") {
					$line_2 .= 'IBAN ' . $invoice->m_iban . ' | ';
				}
				if($invoice->m_bic != "") {
					$line_2 .= 'BIC ' . $invoice->m_bic;
				}
				$GLOBALS['BANKING_LINE_2'] =  $line_2;
				
				$attachment = CO_PATH_PDF . "/" . $this->normal_chars($title) . ".pdf";
				$pdf = $this->saveInvoice($title,$html,$attachment);
			break;
			case 'reminder':
				if($arr = $this->model->getDetails($id)) {
					$invoice = $arr["invoice"];
					$task = $arr["task"];
					$pid = $invoice->pid;
					if($arr = $this->model->getPatientDetails($pid,'nocheckout')) {
						$patient = $arr["patient"];
					}
					ob_start();
						if($invoice->invoice_no > CO_INVOICE_START) {
							$invoice->invoice_number = $invoice->invoice_addon . '/' . $invoice->invoice_year . '/' . $invoice->invoice_no;
							include 'view_reg/print_reminder.php';
						} else {
							include 'view/print_reminder.php';
						}
						$html = ob_get_contents();
					ob_end_clean();
					$title = $lang["PATIENT_INVOICE_PAYMENT_REMINDER"][0] . ' ' . $invoice->invoice_number . ' ' . $invoice->lastname;
				}
				$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PATIENT_PRINT_REMINDER"];
				
				$line_1 = '';
				if($invoice->m_company != "") {
					$line_1 .= $invoice->m_company . ' | ';
				}
				if($invoice->m_plz != "" && $invoice->m_town != "" && $invoice->m_street != "") {
					$line_1 .= $invoice->m_plz . ' ' . $invoice->m_town . ', ' . $invoice->m_street . ' | ';
				}
				if($invoice->m_co_no != "") {
					$line_1 .= 'FN ' . $invoice->m_co_no . ' | ';
				}
				if($invoice->m_legal != "") {
					$line_1 .= 'Gerichtsstand ' . $invoice->m_legal . ' | ';
				}
				if($invoice->m_vat != "") {
					$line_1 .= $invoice->m_vat;
				}
				$GLOBALS['BANKING_LINE_1'] =  $line_1;
				
				$line_2 = '';
				if($invoice->m_bank != "") {
					$line_2 .= $invoice->m_bank . ' | ';
				}
				if($invoice->m_sort_code != "") {
					$line_2 .= 'BLZ ' . $invoice->m_sort_code . ' | ';
				}
				if($invoice->m_account_number != "") {
					$line_2 .= 'Kontonr. ' . $invoice->m_account_number . ' | ';
				}
				if($invoice->m_iban != "") {
					$line_2 .= 'IBAN ' . $invoice->m_iban . ' | ';
				}
				if($invoice->m_bic != "") {
					$line_2 .= 'BIC ' . $invoice->m_bic;
				}
				$GLOBALS['BANKING_LINE_2'] =  $line_2;
				
				$attachment = CO_PATH_PDF . "/" . $this->normal_chars($title) . ".pdf";
				$pdf = $this->saveInvoice($title,$html,$attachment);
			break;
			case 'stationary':
				if($arr = $this->model->getDetails($id)) {
					$invoice = $arr["invoice"];
					$pid = $invoice->pid;
					if($arr = $this->model->getPatientDetails($pid,'nocheckout')) {
						$patient = $arr["patient"];
					}
					ob_start();
						include 'view/print_stationary.php';
						$html = ob_get_contents();
					ob_end_clean();
					$title = $invoice->title;
				}
				$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PATIENT_PRINT_INVOICE"];
				$attachment = CO_PATH_PDF . "/" . $this->normal_chars($title) . ".pdf";
				$pdf = $this->savePDF($title,$html,$attachment,1,'logo_print_patient.png');
			break;
		}
		
		
		
		// write sento log
		$this->writeSendtoLog("patients_invoices",$id,$to,$subject,$body);
		
		//$to,$from,$fromName,$subject,$body,$attachment
		return $this->sendEmail($to,$cc,$session->email,$session->firstname . " " . $session->lastname,$subject,$body,$attachment);
	}
	

	function setDetails($pid,$id,$invoice_carrier,$invoice_date,$invoice_date_sent,$invoice_address,$payment_type,$invoice_number,$beleg_datum,$beleg_time,$payment_reminder,$protocol_payment_reminder,$protocol,$documents,$invoice_access,$invoice_access_orig) {
		if($retval = $this->model->setDetails($pid,$id,$invoice_carrier,$invoice_date,$invoice_date_sent,$invoice_address,$payment_type,$invoice_number,$beleg_datum,$beleg_time,$payment_reminder,$protocol_payment_reminder,$protocol,$documents,$invoice_access,$invoice_access_orig)){
			return '{ "id": "' . $id . '", "access": "' . $invoice_access . '"}';
		} else{
			return "error";
		}
	}
	
	function updateStatus($id,$date,$status) {
		$arr = $this->model->updateStatus($id,$date,$status);
		return '{"id": "' . $arr["id"] . '", "status": "' . $status . '"}';
	}
	
	function newCheckpoint($id,$date){
		$this->model->newCheckpoint($id,$date);
		return true;
   }

 	function updateCheckpoint($id,$date){
		$this->model->updateCheckpoint($id,$date);
		return true;
   }

 	function deleteCheckpoint($id){
		$this->model->deleteCheckpoint($id);
		return true;
   }
   
	function updateCheckpointText($id,$text){
		$this->model->updateCheckpointText($id,$text);
		return true;
   }

	
	function getHelp() {
		global $lang;
		$data["file"] =  $lang["PATIENT_INVOICE_HELP"];
		$data["app"] = "patients";
		$data["module"] = "/modules/invoices";
		$this->openHelpPDF($data);
	}


	function updateQuestion($id,$field,$val){
		$this->model->updateQuestion($id,$field,$val);
		return true;
   }
   
   function getPaymentTypeDialog($field) {
		global $lang;
		include_once dirname(__FILE__).'/view/dialog_payment.php';
	}


	function setBar($id) {
		global $lang;
		if($arr = $this->model->setBar($id)) {
			return json_encode($arr);
		}
	}
	
	function removeBar($id) {
		global $lang;
		if($arr = $this->model->removeBar($id)) {
			return json_encode($arr);
		}
	}

}

$patientsInvoices = new PatientsInvoices("invoices");
?>