<?php

//include_once("lang/" . $session->userlang . ".php");

class Patients extends Controller {

	// get all available apps
	function __construct($name) {
			global $session;
			//parent::__construct();
			$this->application = $name;
			$this->form_url = "apps/$name/";
			$this->model = new PatientsModel();
			$this->modules = $this->getModules($this->application);
			$this->num_modules = sizeof((array)$this->modules);
			$this->binDisplay = true;
			$this->archiveDisplay = false;
			$this->contactsDisplay = true; // list access status on contact page
			
			if (!$session->isSysadmin()) {
				$this->canView = $this->model->getViewPerms($session->uid);
				$this->canEdit = $this->model->getEditPerms($session->uid);
				$this->canAccess = array_merge($this->canView,$this->canEdit);
			}
	}


	function getFolderList($sort) {
		global $system, $lang;
		$arr = $this->model->getFolderList($sort);
		$folders = $arr["folders"];
		ob_start();
			include('view/folders_list.php');
			$data["html"] = ob_get_contents();
		ob_end_clean();
		$data["sort"] = $arr["sort"];
		$data["access"] = $arr["access"];
		$data["title"] = $lang["PATIENT_FOLDER_ACTION_NEW"];
		return $system->json_encode($data);
	}


	function getFolderDetails($id) {
		global $lang, $system;
		if($arr = $this->model->getFolderDetails($id)) {
			$folder = $arr["folder"];
			$patients = $arr["patients"];
			ob_start();
			include 'view/folder_edit.php';
			$data["html"] = ob_get_contents();
			ob_end_clean();
			$data["access"] = $arr["access"];
			return $system->json_encode($data);
		} else {
			ob_start();
			include CO_INC .'/view/default.php';
			$data["html"] = ob_get_contents();
			ob_end_clean();
			return $system->json_encode($data);
		}
	}
	
	
	function getFolderDetailsList($id) {
		global $lang, $system;
		if($arr = $this->model->getFolderDetails($id)) {
			$folder = $arr["folder"];
			$patients = $arr["patients"];
			ob_start();
			include 'view/folder_edit_list.php';
			$data["html"] = ob_get_contents();
			ob_end_clean();
			$data["access"] = $arr["access"];
			return $system->json_encode($data);
		} else {
			ob_start();
			include CO_INC .'/view/default.php';
			$data["html"] = ob_get_contents();
			ob_end_clean();
			return $system->json_encode($data);
		}
	}
	
	
	function getFolderDetailsInvoices($id,$view) {
		global $date, $lang, $system;
		if($arr = $this->model->getFolderDetailsInvoices($id,$view)) {
		$invoices = $arr["invoices"];
		ob_start();
			include('view/folder_edit_invoices.php');
			$data["html"] = ob_get_contents();
		ob_end_clean();
		$data["access"] = $arr["access"];
		return $system->json_encode($data);
		} else {
			ob_start();
			include CO_INC .'/view/default.php';
			$data["html"] = ob_get_contents();
			ob_end_clean();
			return $system->json_encode($data);
		}
	}
	
	function getFolderDetailsRevenue($id) {
		global $date, $lang, $system;
		$start = new DateTime("first day of last month");
		$end = new DateTime("last day of last month");
		$start_date = $start->format('d.m.Y');
		$end_date = $end->format('d.m.Y');
		ob_start();
			include('view/folder_edit_revenue.php');
			$data["html"] = ob_get_contents();
		ob_end_clean();
		return json_encode($data);
	}
	
	function getFolderDetailsRevenueResults($id,$who,$patient,$start,$end,$filters,$details,$detailsCount,$stats,$statsCount) {
		global $date, $lang, $system;
		$arr = $this->model->getFolderDetailsRevenueResults($id,$who,$patient,$start,$end,$filters,$details,$detailsCount,$stats,$statsCount);
		$calctotal = $arr["calctotal"];
		$calcvattotal = $arr["calcvattotal"];
		$calcvattotalsum = $arr["calcvattotalsum"];
		$calcvatnetto = $arr["calcvatnetto"];
		$calctotalmin = $arr["calctotalmin"];
		
		$invoices = $arr["invoices"];
		$chartGender = $arr["chartGender"];
		$chartAge = $arr["chartAge"];
		ob_start();
			include('view/folder_edit_revenue_results.php');
			$data["html"] = ob_get_contents();
		ob_end_clean();
		$data["access"] = $arr["access"];
		return json_encode($data);
	}
	
	function createFolderDetailsRevenueExcel($id,$who,$patient,$start,$end,$filters,$details,$detailsCount,$stats,$statsCount) {
		global $system, $lang;
		$arr = $this->model->getFolderDetailsRevenueResults($id,$who,$patient,$start,$end,$filters,$details,$detailsCount,$stats,$statsCount);
		//print_r($arr);
		if($arr2 = $this->model->getFolderDetails($id)) {
			$folder = $arr2["folder"];
			//$title = $lang["PATIENT_FOLDER_TAB_REVENUE"];
		}
		
		$calctotal = $arr["calctotal"];
		$calcvattotal = $arr["calcvattotal"];
		$calcvattotalsum = $arr["calcvattotalsum"];
		$calcvatnetto = $arr["calcvatnetto"];
		$calctotalmin = $arr["calctotalmin"];
		$invoices = $arr["invoices"];
		$manager = $arr["manager"];
		
		$chartGender = $arr["chartGender"];
		$chartAge = $arr["chartAge"];

		require_once(CO_INC . "/classes/phpExcel/PHPExcel.php");
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator("company observer")
									 ->setTitle("company observer Export");
		
		$Sheet = $objPHPExcel->getActiveSheet();
		
		$styleArray = array(
    'font'  => array(
        //'bold'  => true,
        //'color' => array('rgb' => 'FF0000'),
        //'size'  => 15,
        'name'  => 'Areal'
    ));

//$phpExcel->getActiveSheet()->getCell('A1')->setValue('Some text');
//$Sheet ->getStyle('A1:1')->applyFromArray($styleArray);

$objPHPExcel->getDefaultStyle()->getFont()
    ->setName('Arial')
    ->setSize(8);
		
		// row 1 Title
		$Sheet->mergeCells('A1:B1');
		$Sheet->setCellValue('A1', $folder->title);
		$Sheet->getStyle('A1:A1')->getFont()->setBold(true);
		
		//row 3 
		if($manager != "") { 
			$betreuuung = $manager;
		} else { 
				$betreuuung = 'Alle';
		}
		$Sheet->setCellValue('B3', 'Betreuung');
		$Sheet->getStyle('B3:B3')->getFont()->setBold(true);
		$Sheet->setCellValue('C3', $betreuuung);
		
		$Sheet->setCellValue('B4', 'Zeitraum');
		$Sheet->getStyle('B4:B4')->getFont()->setBold(true);
		$Sheet->mergeCells('C4:D4');
		$Sheet->setCellValue('C4', $start . ' - ' . $end);

		$Sheet->setCellValue('B6', 'Umsatzsumme');
		$Sheet->getStyle('B6:B6')->getFont()->setBold(true);
		$Sheet->setCellValue('C6',CO_DEFAULT_CURRENCY . ' ' . $calctotal);
		
		$Sheet
					->getStyle('A6:Z6')
					->getFill()
					->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
					->getStartColor()
					->setRGB('e5e5e5');
		
		if(is_array($invoices)) {
			$steuerstring = '';
			$yup = 3;
			foreach($calcvattotal as $key => $val) {
				$steuerstring = CO_DEFAULT_CURRENCY . ' ' . number_format($val,2,',','.') . ' inkl. ' . $key . '% MwSt.';
				$Sheet->setCellValueByColumnAndRow($yup, 6,$steuerstring);
				$yup++;
			} 
			//$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D6', $steuerstring);
		}
		/*$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A1', 'Rechnung')
				->setCellValue('B1', '')
				->setCellValue('C1', 'Rn. Datum')
				->setCellValue('D1', 'Umsatz');*/
				
		
				
		$row = 7;
		
		$i = 0;
		$vatcheck = 0;
		$totalinv = sizeof($invoices);
	
		if(is_array($invoices)) {
			foreach($invoices as $invoice) {
				$col = 0;
				
				
				
				if($i == 0 || $vatcheck != $invoice->vat) {
					$vatcheck_old = $vatcheck;
					$vatcheck = $invoice->vat;
					
					if($i != 0) {
						
						//$Sheet->setCellValueByColumnAndRow(1, $row, 'Summen');
						//$Sheet->setCellValueByColumnAndRow(2, $row, number_format($calcvatnetto[$vatcheck_old],2,',','.'));
						/*$Sheet
					->getStyle('A1:E1')
					->getFill()
					->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
					->getStartColor()
					->setARGB('FF808080');*/
		
						$Sheet->setCellValueByColumnAndRow(1, $row, "exkl.");
						$Sheet->setCellValueByColumnAndRow(2, $row, $calcvatnetto[$vatcheck_old]);
						$sum_letter = 'B'.$row;
						$sum_range = "{$sum_letter}:{$sum_letter}";
						$Sheet
						->getStyle($sum_range)
						->getAlignment()
						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT); 
						$row++;
						
						$Sheet->setCellValueByColumnAndRow(1, $row, "$vatcheck_old% MwSt.");
						$Sheet->setCellValueByColumnAndRow(2, $row, $calcvattotalsum[$vatcheck_old]);
						$sum_letter = 'B'.$row;
						$sum_range = "{$sum_letter}:{$sum_letter}";
						$Sheet
						->getStyle($sum_range)
						->getAlignment()
						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT); 
						$row++;
						
						$Sheet->setCellValueByColumnAndRow(1, $row, "Gesamt inkl. $vatcheck_old% MwSt.");
						$Sheet->setCellValueByColumnAndRow(2, $row, $calcvattotal[$vatcheck_old]);
						$sum_letter = 'B'.$row;
						$sum_range = "{$sum_letter}:{$sum_letter}";
						$Sheet
						->getStyle($sum_range)
						->getAlignment()
						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT); 
						$row++;
					}
					$row++;
					$row++;
					$Sheet->setCellValueByColumnAndRow(1, $row, 'Einzelergebnisse ' . $invoice->vat . '% MwSt.');
					$row++;
					
					$rowCol = 0;
					$Sheet->setCellValueByColumnAndRow($rowCol++, $row, 'ID');
					$Sheet->setCellValueByColumnAndRow($rowCol++, $row, 'Rechnungstitel');
					$Sheet->setCellValueByColumnAndRow($rowCol++, $row, 'Summe');
					$Sheet->setCellValueByColumnAndRow($rowCol++, $row, 'Zahlungsart');
					$Sheet->setCellValueByColumnAndRow($rowCol++, $row, 'Einzahlung am');
					$Sheet->setCellValueByColumnAndRow($rowCol++, $row, 'ausständig seit');
					if($invoice->show_patient) {
						$Sheet->setCellValueByColumnAndRow($rowCol++, $row, 'Patient');
					}
					if($invoice->show_dob) {
						$Sheet->setCellValueByColumnAndRow($rowCol++, $row, 'Geburtsdatum');
					}
					if($invoice->show_alter) {
						$Sheet->setCellValueByColumnAndRow($rowCol++, $row, 'Alter');
					}
					if($invoice->show_gender) {
						$Sheet->setCellValueByColumnAndRow($rowCol++, $row, 'Geschlecht');
					}
					if($invoice->show_agegroup) {
						$Sheet->setCellValueByColumnAndRow($rowCol++, $row, 'bis 25');
						$Sheet->setCellValueByColumnAndRow($rowCol++, $row, 'bis 60');
						$Sheet->setCellValueByColumnAndRow($rowCol++, $row, 'ab 61');
					}
					if($invoice->show_betreuung) {
						$Sheet->setCellValueByColumnAndRow($rowCol++, $row, 'Betreuung');
					}
					if($invoice->show_dauer) {
						$Sheet->setCellValueByColumnAndRow($rowCol++, $row, 'Dauer von');
						$Sheet->setCellValueByColumnAndRow($rowCol++, $row, 'bis');
					}
					if($invoice->show_ort) {
						$Sheet->setCellValueByColumnAndRow($rowCol++, $row, 'Ort');
					}
					if($invoice->show_arbeitszeit) {
						$Sheet->setCellValueByColumnAndRow($rowCol++, $row, 'Arbeitszeit');
					}
					if($invoice->show_rechnungsdatum) {
						$Sheet->setCellValueByColumnAndRow($rowCol++, $row, 'Rechnungsdatum');
					}
					if($invoice->show_rechnungsnummer) {
						$Sheet->setCellValueByColumnAndRow($rowCol++, $row, 'Rechnungsnummer');
					}

					$first_letter = 'A'.$row;
					$last_letter = 'z'.$row;
					$header_range = "{$first_letter}:{$last_letter}";
					$Sheet->getStyle($header_range)->getFont()->setBold(true);
					
					$row++;
				}
				
				$Sheet->setCellValueByColumnAndRow($col++, $row, $i+1); // ID
				$Sheet->setCellValueByColumnAndRow($col++, $row, $invoice->title); //Titel
				$Sheet->setCellValueByColumnAndRow($col++, $row,$invoice->totalcosts_plain);
				$Sheet->setCellValueByColumnAndRow($col++, $row,$invoice->payment_type);
				/*if($invoice->payment_type == 'Überweisung') {
					$Sheet->setCellValueByColumnAndRow($col++, $row,"$invoice->totalcosts_plain");
					$sum_ueberweisung += $invoice->totalcosts_plain;
					$col++;
				}
				if($invoice->payment_type == 'Barzahlung') {
					$col++;
					$Sheet->setCellValueByColumnAndRow($col++, $row,"$invoice->totalcosts_plain");
				}*/
				if($invoice->status_invoice_class == 'barchart_color_finished') { 
					$Sheet->setCellValueByColumnAndRow($col++, $row, $invoice->status_invoice_date);
				} else {
					$col++;
				}
				if($invoice->status_invoice_class == 'barchart_color_inprogress') { 
					$Sheet->setCellValueByColumnAndRow($col++, $row, $invoice->status_invoice_date);
				} else {
					$col++;
				}
				
				/*$first_letter = 'A'.$row;
					$last_letter = 'z'.$row;
					$header_range = "{$first_letter}:{$last_letter}";
				$sheet->getActiveSheet()->getStyle($header_range)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);*/
				if($invoice->show_patient) {
					$Sheet->setCellValueByColumnAndRow($col++, $row, $invoice->patient);
				}
				if($invoice->show_dob) {
					$Sheet->setCellValueByColumnAndRow($col++, $row, $invoice->dob);
				}
				if($invoice->show_alter) {
					$Sheet->setCellValueByColumnAndRow($col++, $row, $invoice->age);
				}
				if($invoice->show_gender) {
					if($invoice->gender == 1) {
						$Sheet->setCellValueByColumnAndRow($col++, $row, 'm');
					}
					if($invoice->gender == 2) {
						$Sheet->setCellValueByColumnAndRow($col++, $row, 'w');
					}
					if($invoice->gender == 0) {
						$Sheet->setCellValueByColumnAndRow($col++, $row, '');
					}
				}
				if($invoice->show_agegroup) {
					if($invoice->age == 0) {
							$col = $col+3;
						} else 
						if($invoice->age < 25) {
							$Sheet->setCellValueByColumnAndRow($col++, $row, '1');
							$col = $col+2;
						} else 
						if($invoice->age < 60) {
							$col++;
							$Sheet->setCellValueByColumnAndRow($col++, $row, '1');
							$col++;
						} else 
						if($invoice->age >= 60) {
							$col = $col+2;
							$Sheet->setCellValueByColumnAndRow($col++, $row, '1');
						}
				}
				if($invoice->show_betreuung) {
					$Sheet->setCellValueByColumnAndRow($col++, $row, $invoice->management);
				}
				if($invoice->show_dauer) {
					$Sheet->setCellValueByColumnAndRow($col++, $row, $invoice->treatment_start);
					$Sheet->setCellValueByColumnAndRow($col++, $row, $invoice->treatment_end);
				}
				if($invoice->show_ort) {
					$Sheet->setCellValueByColumnAndRow($col++, $row, $invoice->ort_string);
				}
				if($invoice->show_arbeitszeit) {
					$Sheet->setCellValueByColumnAndRow($col++, $row, $invoice->totalmin);
				}
				if($invoice->show_rechnungsdatum) {
					$Sheet->setCellValueByColumnAndRow($col++, $row, $invoice->invoice_date);
				}
				if($invoice->show_rechnungsnummer) {
					$Sheet->setCellValueByColumnAndRow($col++, $row, $invoice->invoice_number);
				}
				
				$row++;
				$i++;
			}
			
			//$Sheet->setCellValueByColumnAndRow(1, $row, 'Summen');
			//$Sheet->setCellValueByColumnAndRow(2, $row, number_format($calcvatnetto[$vatcheck],2,',','.'));
						/*$Sheet
					->getStyle('A1:E1')
					->getFill()
					->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
					->getStartColor()
					->setARGB('FF808080');*/
		
						$Sheet->setCellValueByColumnAndRow(1, $row, "exkl.");
						$Sheet->setCellValueByColumnAndRow(2, $row, $calcvatnetto[$vatcheck]);
						$sum_letter = 'B'.$row;
						$sum_range = "{$sum_letter}:{$sum_letter}";
						$Sheet
						->getStyle($sum_range)
						->getAlignment()
						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT); 
						$row++;
						
						$Sheet->setCellValueByColumnAndRow(1, $row, "$vatcheck% MwSt.");
						$Sheet->setCellValueByColumnAndRow(2, $row, $calcvattotalsum[$vatcheck]);
						$sum_letter = 'B'.$row;
						$sum_range = "{$sum_letter}:{$sum_letter}";
						$Sheet
						->getStyle($sum_range)
						->getAlignment()
						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT); 
						$row++;
						
						$Sheet->setCellValueByColumnAndRow(1, $row, "Gesamt inkl. $vatcheck% MwSt.");
						$Sheet->setCellValueByColumnAndRow(2, $row, $calcvattotal[$vatcheck]);
						$sum_letter = 'B'.$row;
						$sum_range = "{$sum_letter}:{$sum_letter}";
						$Sheet
						->getStyle($sum_range)
						->getAlignment()
						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT); 
						$row++;
		}
		$row++;
		$row++;
		$row++;
		$row++;
		$col = 3;
		$rowStart = $row;
		if($chartGender['show']) { 
			$Sheet->getStyleByColumnAndRow($col, $row)->getFont()->setBold(true);
			$Sheet->setCellValueByColumnAndRow($col, $row++, "Geschlecht");
			
			$Sheet->setCellValueByColumnAndRow($col, $row++, $chartGender['male'] . '% männlich');
			$Sheet->setCellValueByColumnAndRow($col, $row++, $chartGender['female'] . '% weiblich');
			$Sheet->setCellValueByColumnAndRow($col, $row++, $chartGender['notset'] . '% keine Angabe');
			
    	$col++;
		}
		if($chartAge['show']) { 
			$row = $rowStart;
			$Sheet->getStyleByColumnAndRow($col, $row)->getFont()->setBold(true);
			$Sheet->setCellValueByColumnAndRow($col, $row++, "Altersgruppe");
			
			$Sheet->setCellValueByColumnAndRow($col, $row++, $chartAge['ageGroup25'] . '% bis 25');
			$Sheet->setCellValueByColumnAndRow($col, $row++, $chartAge['ageGroup60'] . '% 25 bis 60');
			$Sheet->setCellValueByColumnAndRow($col, $row++, $chartAge['ageGroup60Plus'] . '% ab 61');
			$Sheet->setCellValueByColumnAndRow($col, $row++, $chartAge['ageGroupNotset'] . '% keine Angabe');
			
    	$col++;
		} 

		
		
		foreach(range('A','T') as $columnID) {
    	$Sheet->getColumnDimension($columnID)
        ->setAutoSize(true);
		}

$Sheet->getStyle('C1:C'.$row)->getNumberFormat()->setFormatCode('[$€-C07] #.00');
	
		$Sheet->setTitle('Export');
		$objPHPExcel->setActiveSheetIndex(0);

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="umsatzabfrage.xls"');
		header('Cache-Control: max-age=0');
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		
	}
	
	function getFolderDetailsBelege($id) {
		global $date, $lang, $system;
		$start = new DateTime("first day of last month");
		$end = new DateTime("last day of last month");
		$start_date = $start->format('d.m.Y');
		$end_date = $end->format('d.m.Y');
		ob_start();
			include('view/folder_edit_belege.php');
			$data["html"] = ob_get_contents();
		ob_end_clean();
		return json_encode($data);
	}
	
	function getFolderDetailsBelegeResults($id,$who,$start,$end) {
		global $date, $lang, $system;
		$arr = $this->model->getFolderDetailsBelegeResults($id,$who,$start,$end);
		$calctotal = $arr["calctotal"];
		$zahlungen = $arr["zahlungen"];
		$storno = $arr["storno"];
		$invoices = $arr["invoices"];
		ob_start();
			include('view/folder_edit_belege_results.php');
			$data["html"] = ob_get_contents();
		ob_end_clean();
		$data["access"] = $arr["access"];
		return json_encode($data);
	}


	function printFolderDetailsList($id, $t) {
		global $session,$lang;
		$title = "";
		$html = "";
		if($arr = $this->model->getFolderDetails($id)) {
			$folder = $arr["folder"];
			$patients = $arr["patients"];
			ob_start();
				include 'view/folder_print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $folder->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PRINT_PATIENT_FOLDER"];
		switch($t) {
			case "html":
				$this->printHTML($title,$html);
			break;
			default:
				$this->printPDF($title,$html);
		}
	}
	
	
	function printFolderDetailsInvoices($id,$view) {
		global $session,$lang;
		$title = "";
		$html = "";
		if($arr = $this->model->getFolderDetails($id)) {
			$folder = $arr["folder"];
			$title = $folder->title;
		}
		if($arr = $this->model->getFolderDetailsInvoices($id,$view)) {
			  $invoices = $arr["invoices"];
				ob_start();
					include('view/folder_print_invoices.php');
					$html = ob_get_contents();
				ob_end_clean();		
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PRINT_PATIENT_RECHNUNGEN"];
		$this->printPDF($title,$html);
	}


	function printFolderDetailsRevenue($id,$who,$patient,$start,$end,$filters,$details,$detailsCount,$stats,$statsCount) {
		global $date,$session,$lang;
		$title = $lang["PATIENT_FOLDER_TAB_REVENUE"];
		$html = "";
		if($arr = $this->model->getFolderDetails($id)) {
			$folder = $arr["folder"];
			//$title = $lang["PATIENT_FOLDER_TAB_REVENUE"];
		}
		if($arr = $this->model->getFolderDetailsRevenueResults($id,$who,$patient,$start,$end,$filters,$details,$detailsCount,$stats,$statsCount)) {
			$calctotal = $arr["calctotal"];
			$calctotalmin = $arr["calctotalmin"];
			$invoices = $arr["invoices"];
			$manager = $arr["manager"];

		$calcvattotal = $arr["calcvattotal"];
		$calcvattotalsum = $arr["calcvattotalsum"];
		$calcvatnetto = $arr["calcvatnetto"];
		
		$chartGender = $arr["chartGender"];
		$chartAge = $arr["chartAge"];

		
			ob_start();
				include('view/folder_print_revenue.php');
				$html = ob_get_contents();
			ob_end_clean();	
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PRINT_PATIENT_UMSATZ"];
		$this->printPDF($title,$html);
	}
	
	function printFolderDetailsBelege($id,$who,$start,$end) {
		global $date,$session,$lang;
		$title = 'Belegarchiv';
		$html = "";
		if($arr = $this->model->getFolderDetails($id)) {
			$folder = $arr["folder"];
			//$title = $lang["PATIENT_FOLDER_TAB_REVENUE"];
		}
		if($arr = $this->model->getFolderDetailsBelegeResults($id,$who,$start,$end)) {
			$calctotal = $arr["calctotal"];
			$zahlungen = $arr["zahlungen"];
			$storno = $arr["storno"];
			$invoices = $arr["invoices"];
			$manager = $arr["manager"];
			ob_start();
				include('view/folder_print_belege.php');
				$html = ob_get_contents();
			ob_end_clean();	
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PRINT_PATIENT_BELEGE"];
		$this->printPDF($title,$html);
	}


	function getFolderSend($id) {
		global $lang;
		if($arr = $this->model->getFolderDetails($id)) {
			$folder = $arr["folder"];
			$patients = $arr["patients"];	
			$form_url = $this->form_url;
			$request = "sendFolderDetails";
			$to = "";
			$cc = "";
			$subject = $folder->title;
			$variable = "";
			include CO_INC .'/view/dialog_send.php';
		}
		else {
			include CO_INC .'/view/default.php';
		}
	}

	function sendFolderDetails($id,$to,$cc,$subject,$body) {
		global $session,$users, $lang;
		$title = "";
		$html = "";
		if($arr = $this->model->getFolderDetails($id)) {
			$folder = $arr["folder"];
			$patients = $arr["patients"];
			//$sendto = $arr["sendto"];
			ob_start();
				include 'view/folder_print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $folder->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PRINT_PATIENT_FOLDER"];
		$attachment = CO_PATH_PDF . "/" . $this->normal_chars($title) . ".pdf";
		$pdf = $this->savePDF($title,$html,$attachment);
		
		// write sento log
		//$this->writeSendtoLog("patients",$id,$to,$subject,$body);
		
		//$to,$from,$fromName,$subject,$body,$attachment
		return $this->sendEmail($to,$cc,$session->email,$session->firstname . " " . $session->lastname,$subject,$body,$attachment);
	}
	
	
	function getFolderSendInvoices($id,$view) {
		global $lang;
		if($arr = $this->model->getFolderDetailsInvoices($id,$view)) {
			$invoices = $arr["invoices"];
			if($arr = $this->model->getFolderDetails($id)) {
			$folder = $arr["folder"];
		}
			$form_url = $this->form_url;
			$request = "sendFolderDetailsInvoices";
			$to = "";
			$cc = "";
			$subject = $folder->title;
			$variable = $view;
			include CO_INC .'/view/dialog_send.php';
		}
		else {
			include CO_INC .'/view/default.php';
		}
	}

	function sendFolderDetailsInvoices($variable,$id,$to,$cc,$subject,$body) {
		global $session,$users, $lang;
		$title = "";
		$html = "";
		if($arr = $this->model->getFolderDetails($id)) {
			$folder = $arr["folder"];
			$title = $folder->title;
		}
		if($arr = $this->model->getFolderDetailsInvoices($id,$variable)) {
			$invoices = $arr["invoices"];
			ob_start();
				include 'view/folder_print_invoices.php';
				$html = ob_get_contents();
			ob_end_clean();
			//$title = $folder->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PRINT_PATIENT_FOLDER"];
		$attachment = CO_PATH_PDF . "/" . $this->normal_chars($title) . ".pdf";
		$pdf = $this->savePDF($title,$html,$attachment);
		return $this->sendEmail($to,$cc,$session->email,$session->firstname . " " . $session->lastname,$subject,$body,$attachment);
	}


	function getFolderSendRevenue($id,$who,$patient,$start,$end,$filters,$details,$detailsCount,$stats,$statsCount) {
		global $lang;
		if($arr = $this->model->getFolderDetailsRevenueResults($id,$who,$patient,$start,$end,$filters,$details,$detailsCount,$stats,$statsCount)) {
			$calctotal = $arr["calctotal"];
			$calctotalmin = $arr["calctotalmin"];
			$invoices = $arr["invoices"];
			$manager = $arr["manager"];

		$calcvattotal = $arr["calcvattotal"];
		$calcvattotalsum = $arr["calcvattotalsum"];
		$calcvatnetto = $arr["calcvatnetto"];
		
		$chartGender = $arr["chartGender"];
		$chartAge = $arr["chartAge"];
		
			if($arr = $this->model->getFolderDetails($id)) {
			$folder = $arr["folder"];
		}
			$form_url = $this->form_url;
			$request = "sendFolderDetailsRevenue";
			$to = "";
			$cc = "";
			$subject = $folder->title;
			$variable = $who.'-'.$start.'-'.$end.'-'.$patient.'-'.$filters.'-'.$details.'-'.$detailsCount.'-'.$stats.'-'.$statsCount;
			include CO_INC .'/view/dialog_send.php';
		}
		else {
			include CO_INC .'/view/default.php';
		}
	}
	
	function getFolderSendBelege($id,$who,$start,$end) {
		global $lang;
		if($arr = $this->model->getFolderDetailsBelegeResults($id,$who,$start,$end)) {
			$calctotal = $arr["calctotal"];
			$invoices = $arr["invoices"];
			$manager = $arr["manager"];
			if($arr = $this->model->getFolderDetails($id)) {
			$folder = $arr["folder"];
		}
			$form_url = $this->form_url;
			$request = "sendFolderDetailsBelege";
			$to = "";
			$cc = "";
			$subject = $folder->title;
			$variable = $who.'-'.$start.'-'.$end;
			include CO_INC .'/view/dialog_send.php';
		}
		else {
			include CO_INC .'/view/default.php';
		}
	}

	function sendFolderDetailsRevenue($variable,$id,$to,$cc,$subject,$body) {
		global $session,$users, $lang;
		$title = "";
		$html = "";
		if($arr = $this->model->getFolderDetails($id)) {
			$folder = $arr["folder"];
			$title = $folder->title;
		}
		$var = explode("-", $variable);
		$who = $var[0];
		$start = $var[1];
		$end = $var[2];
		$patient = $var[3];
		$filters = $var[4];
		$details = $var[5];
		$detailsCount = $var[6];
		$stats = $var[7];
		$statsCount = $var[8];
		if($arr = $this->model->getFolderDetailsRevenueResults($id,$who,$patient,$start,$end,$filters,$details,$detailsCount,$stats,$statsCount)) {
			$calctotal = $arr["calctotal"];
			$invoices = $arr["invoices"];
			$manager = $arr["manager"];
		$calcvattotal = $arr["calcvattotal"];
		$calcvattotalsum = $arr["calcvattotalsum"];
		$calcvatnetto = $arr["calcvatnetto"];
		$calctotalmin = $arr["calctotalmin"];
		$chartGender = $arr["chartGender"];
		$chartAge = $arr["chartAge"];
			ob_start();
				include 'view/folder_print_revenue.php';
				$html = ob_get_contents();
			ob_end_clean();
			//$title = $folder->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PRINT_PATIENT_UMSATZ"];
		$attachment = CO_PATH_PDF . "/" . $this->normal_chars($title) . ".pdf";
		$pdf = $this->savePDF($title,$html,$attachment);
		return $this->sendEmail($to,$cc,$session->email,$session->firstname . " " . $session->lastname,$subject,$body,$attachment);
	}
	
	function sendFolderDetailsBelege($variable,$id,$to,$cc,$subject,$body) {
		global $session,$users, $lang;
		$title = "";
		$html = "";
		if($arr = $this->model->getFolderDetails($id)) {
			$folder = $arr["folder"];
			$title = $folder->title;
		}
		$var = explode("-", $variable);
		$who = $var[0];
		$start = $var[1];
		$end = $var[2];
		if($arr = $this->model->getFolderDetailsBelegeResults($id,$who,$start,$end)) {
			$calctotal = $arr["calctotal"];
			$invoices = $arr["invoices"];
			$manager = $arr["manager"];
			ob_start();
				include 'view/folder_print_revenue.php';
				$html = ob_get_contents();
			ob_end_clean();
			//$title = $folder->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PRINT_PATIENT_FOLDER"];
		$attachment = CO_PATH_PDF . "/" . $this->normal_chars($title) . ".pdf";
		$pdf = $this->savePDF($title,$html,$attachment);
		return $this->sendEmail($to,$cc,$session->email,$session->firstname . " " . $session->lastname,$subject,$body,$attachment);
	}

	function newFolder() {
		global $session;
		$retval = $this->model->newFolder();
		if($retval){
			// write action log
			//$this->model->writeActionLog($session->uid,"patients","");
			return '{ "action": "new", "id": "' . $retval . '" }';
		} else{
			 return "error";
		}
	}


	function setFolderDetails($id,$title,$patientstatus) {
		$retval = $this->model->setFolderDetails($id,$title,$patientstatus);
		sleep(1);
		if($retval){
			 return '{ "action": "edit", "status": "' . $patientstatus . '", "id": "' . $id . '" }';
		  } else{
			 return "error";
		  }
	}


	function binFolder($id) {
		$retval = $this->model->binFolder($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}


	function restoreFolder($id) {
		$retval = $this->model->restoreFolder($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}


	function deleteFolder($id) {
		$retval = $this->model->deleteFolder($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}


	function getPatientList($id,$sort) {
		global $system, $lang;
		$arr = $this->model->getPatientList($id,$sort);
		$patients = $arr["patients"];
		ob_start();
			include('view/list.php');
			$data["html"] = ob_get_contents();
		ob_end_clean();
		$data["sort"] = $arr["sort"];
		$data["title"] = $lang["PATIENT_ACTION_NEW"];
		return $system->json_encode($data);
	}


	function getPatientDetails($id) {
		global $lang, $system;
		if($arr = $this->model->getPatientDetails($id)) {
			$patient = $arr["patient"];
			$sendto = $arr["sendto"];
			ob_start();
				include 'view/edit.php';
				$data["html"] = ob_get_contents();
			ob_end_clean();
			$data["access"] = $arr["access"];
			return $system->json_encode($data);
		}
		else {
			ob_start();
				include CO_INC .'/view/default.php';
				$data["html"] = ob_get_contents();
			ob_end_clean();
			return $system->json_encode($data);
		}
	}


	function printPatientDetails($id, $t) {
		global $session,$lang;
		$title = "";
		$html = "";
		if($arr = $this->model->getPatientDetails($id)) {
			$patient = $arr["patient"];
			ob_start();
				include 'view/print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $patient->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PRINT_PATIENT"];
		switch($t) {
			case "html":
				$this->printHTML($title,$html);
			break;
			default:
				$this->printPDF($title,$html);
		}
		
	}


	function printPatientHandbook($id, $t) {
		global $session,$lang;
		$title = "";
		$html = "";
		
		if($arr = $this->model->getPatientDetails($id,'nocheckout')) {
			$patient = $arr["patient"];
			//$num = $arr["num"];
			$sendto = $arr["sendto"];
			ob_start();
				include 'view/handbook_cover.php';
				$html .= ob_get_contents();
			ob_end_clean();
			ob_start();
				include 'view/print.php';
				$html .= ob_get_contents();
			ob_end_clean();
			// treatments
			$patientsTreatments = new PatientsTreatments("treatments");
			if($arrts = $patientsTreatments->model->getList($id,"0")) {
				$ts = $arrts["treatments"];
				foreach ($ts as $t) {
					if($arr = $patientsTreatments->model->getDetails($t->id)) {
						$treatment = $arr["treatment"];
						//$t = $arr["t"];
						$task = $arr["task"];
						//$diagnose = $arr["diagnose"];
						$sendto = $arr["sendto"];
						$printcanvas = 0;
						ob_start();
							include 'modules/treatments/view/print.php';
							$html .= ob_get_contents();
						ob_end_clean();
					}
				}
				//$html .= '<div style="page-break-after:always;">&nbsp;</div>';
			}
			
			
			// visualisierungen
			/*$patientsSketches = new PatientsSketches("sketches");
			if($arrrs = $patientsSketches->model->getList($id,"0")) {
				$rs = $arrrs["sketches"];
				foreach ($rs as $r) {
					if($arr = $patientsSketches->model->getDetails($r->id)) {
						$sketch = $arr["sketch"];
						$diagnose = $arr["diagnose"];
						//$r = $arr["r"];
						$sendto = $arr["sendto"];
						ob_start();
							include 'modules/sketches/view/print.php';
							$html .= ob_get_contents();
						ob_end_clean();
					}
				}
			}*/
			
			// reports
			$patientsReports = new PatientsReports("reports");
			if($arrrs = $patientsReports->model->getList($id,"0")) {
				$rs = $arrrs["reports"];
				foreach ($rs as $r) {
					if($arr = $patientsReports->model->getDetails($r->id)) {
						$report = $arr["report"];
						//$r = $arr["r"];
						$sendto = $arr["sendto"];
						ob_start();
							include 'modules/reports/view/print.php';
							$html .= ob_get_contents();
						ob_end_clean();
					}
				}
				//$html .= '<div style="page-break-after:always;">&nbsp;</div>';
			}

			$title = $patient->title . " - " . $lang["PATIENT_HANDBOOK"];
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PRINT_PATIENT_MANUAL"];
		switch($t) {
			case "html":
				$this->printHTML($title,$html);
			break;
			default:
				$this->printPDF($title,$html);
		}
		
	}
	
	function checkinPatient($id) {
		if($id != "undefined") {
			return $this->model->checkinPatient($id);
		} else {
			return true;
		}
	}

	function getPatientSend($id) {
		global $lang;
		if($arr = $this->model->getPatientDetails($id, 'prepareSendTo')) {
			$patient = $arr["patient"];
			$form_url = $this->form_url;
			$request = "sendPatientDetails";
			$to = "";
			$cc = "";
			$subject = $patient->title;
			$variable = "";
			$data["error"] = 0;
			$data["error_message"] = "";
			ob_start();
				include CO_INC .'/view/dialog_send.php';
				$data["html"] = ob_get_contents();
			ob_end_clean();
			return json_encode($data);
		}
	}


	function sendPatientDetails($id,$to,$cc,$subject,$body) {
		global $session,$users, $lang;
		$title = "";
		$html = "";
		if($arr = $this->model->getPatientDetails($id)) {
			$patient = $arr["patient"];
			ob_start();
				include 'view/print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $patient->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PRINT_PATIENT"];
		$attachment = CO_PATH_PDF . "/" . $this->normal_chars($title) . ".pdf";
		$pdf = $this->savePDF($title,$html,$attachment);
		
		// write sento log
		$this->writeSendtoLog("patients",$id,$to,$subject,$body);
		
		//$to,$from,$fromName,$subject,$body,$attachment
		return $this->sendEmail($to,$cc,$session->email,$session->firstname . " " . $session->lastname,$subject,$body,$attachment);
	}


	function newPatient($id,$cid) {
		$retval = $this->model->newPatient($id,$cid);
		if($retval){
			 return '{ "action": "new", "id": "' . $retval . '" }';
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


	function setPatientDetails($id,$folder,$management,$management_ct,$insurer,$insurer_ct,$protocol,$number,$number_insurer,$insurance,$insuranceadd,$code,$dob,$familystatus,$coo,$documents) {
		$retval = $this->model->setPatientDetails($id,$folder,$management,$management_ct,$insurer,$insurer_ct,$protocol,$number,$number_insurer,$insurance,$insuranceadd,$code,$dob,$familystatus,$coo,$documents);
		if($retval){
			 return '{ "action": "edit", "id": "' . $id . '"}';
		  } else{
			 return "error";
		  }
	}
	
	
	function updateStatus($id,$date,$status) {
		$retval = $this->model->updateStatus($id,$date,$status);
		if($retval){
			 return '{ "id": "' . $id . '", "status": "' . $status . '"}';
		 }
	}


	function binPatient($id) {
		$retval = $this->model->binPatient($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}


	function restorePatient($id) {
		$retval = $this->model->restorePatient($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}	


	function deletePatient($id) {
		$retval = $this->model->deletePatient($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}	


	function movePatient($id,$startdate,$movedays) {
		$retval = $this->model->movePatient($id,$startdate,$movedays);
		if($retval){
			 return '{ "action": "reload", "id": "' . $id . '" }';
		  } else{
			 return "error";
		  }
	}


	function getPatientFolderDialog($field,$title) {
		$retval = $this->model->getPatientFolderDialog($field,$title);
		if($retval){
			 return $retval;
		  } else{
			 return "error";
		  }
	}
	
	function getPatientFolderDialogCalendar($field,$title) {
		$retval = $this->model->getPatientFolderDialogCalendar($field,$title);
		if($retval){
			 return $retval;
		  } else{
			 return "error";
		  }
	}


	function getPatientStatusDialog() {
		global $lang;
		include 'view/dialog_status.php';
	}
	
	function getPatientDialog($field,$sql) {
		$retval = $this->model->getPatientDialog($field,$sql);
		if($retval){
			 return $retval;
		  } else{
			 return "error";
		  }
	}
	
	function getPatientDialogInsuranceAdd($field) {
		global $lang;
		include_once dirname(__FILE__).'/view/dialog_insurance.php';
	}
	

	function getPatientMoreDialog($field,$title) {
		$retval = $this->model->getPatientMoreDialog($field,$title);
		if($retval){
			 return $retval;
		  } else{
			 return "error";
		  }
	}

	function getPatientCatDialog($field,$title) {
		$retval = $this->model->getPatientCatDialog($field,$title);
		if($retval){
			 return $retval;
		  } else{
			 return "error";
		  }
	}
	
	function getPatientCatMoreDialog($field,$title) {
		$retval = $this->model->getPatientCatMoreDialog($field,$title);
		if($retval){
			 return $retval;
		  } else{
			 return "error";
		  }
	}
	
	function getCalendarContactsDialog($field,$append) {
		global $lang;
		$contactsmmodel = new ContactsModel();
		$contacts = $contactsmmodel->getLast10Contacts();
		include_once dirname(__FILE__).'/view/dialog_calendar_contacts.php';
	}
	function getCalendarContactsSearch($term) {
		$search = $this->model->getCalendarContactsSearch($term);
		return $search;
	}
	
	function getCalendarPatientsDialog($field,$append) {
		global $lang;
		$patients = $this->model->getLast10Patients();
		include_once dirname(__FILE__).'/view/dialog_calendar_patients.php';
	}
	function getCalendarPatientsSearch($term) {
		$search = $this->model->getCalendarPatientsSearch($term);
		return $search;
	}
	
	function getCalendarFoldersDialog($field,$append) {
		global $lang;
		$treatments = $this->model->getLast10CalTreatments();
		include_once dirname(__FILE__).'/view/dialog_treatments.php';
	}
	
	function getTreatmentsContactsDialog($field,$append) {
		global $lang;
		$treatments = $this->model->getLast10CalTreatments();
		include_once dirname(__FILE__).'/view/dialog_treatments.php';
	}
	
	/*function getTreatmentsPatientsDialog($field,$append) {
		global $lang;
		$treatments = $this->model->getLast10CalTreatments();
		include_once dirname(__FILE__).'/view/dialog_treatments.php';
	}*/
	
	function getTreatmentsDialog($field,$append) {
		global $lang;
		$treatments = $this->model->getLast10CalTreatments();
		include_once dirname(__FILE__).'/view/dialog_treatments.php';
	}
	
	function getCalendarTreatmentsSearch($term) {
		$search = $this->model->getCalendarTreatmentsSearch($term);
		return $search;
	}
	

	function getAccessDialog() {
		global $lang;
		include 'view/dialog_access.php';
	}


	// STATISTICS
	function getChartFolder($id,$what,$print=0,$type=0) {
		global $lang;
		if($chart = $this->model->getChartFolder($id,$what)) {
				if($type == 1) {
					if($print == 1) {
						include 'view/chart_status_print.php';
					} else {
						include 'view/chart_status.php';
					}
				} else {
					if($print == 1) {
						include 'view/chart_print.php';
					} else {
						include 'view/chart.php';
					}
				}
		} else {
			include CO_INC .'/view/default.php';
		}
	}
	
	
	function getChartPerformance($id,$what,$print=0,$type=0) {
		global $lang;
		if($chart = $this->model->getChartPerformance($id,$what)) {
			if($print == 1) {
				include 'view/chart_print.php';
			} else {
				include 'view/chart.php';
			}
		} else {
			include CO_INC .'/view/default.php';
		}
	}

	
	
	function getPatientsHelp() {
		global $lang;
		$data["file"] = $lang["PATIENT_HELP"];
		$data["app"] = "patients";
		$data["module"] = "";
		$this->openHelpPDF($data);
	}
	
	function getPatientsFoldersHelp() {
		global $lang;
		$data["file"] =  $lang["PATIENT_FOLDER_HELP"];
		$data["app"] = "patients";
		$data["module"] = "";
		$this->openHelpPDF($data);
	}

	function getBin() {
		global $lang, $patients;
		if($arr = $this->model->getBin()) {
			$bin = $arr["bin"];
			
			include 'view/bin.php';
		}
		else {
			include CO_INC .'/view/default.php';
		}
	}
	
	function emptyBin() {
		global $lang, $patients;
		if($arr = $this->model->emptyBin()) {
			$bin = $arr["bin"];
			include 'view/bin.php';
		}
		else {
			include CO_INC .'/view/default.php';
		}
	}
	
	// User Access
	function isAdmin(){
	  global $session;
	  /*if($this->model->isPatientOwner($session->uid)) {
	  	return true;
	  }*/
	  $canEdit = $this->model->getEditPerms($session->uid);
	  return !empty($canEdit);
   }
   
   function isGuest(){
	  global $session;
	  $canView = $this->model->getViewPerms($session->uid);
	  return !empty($canView);
   }

	function getNavModulesNumItems($id) {
		$arr = $this->model->getNavModulesNumItems($id);
		return json_encode($arr);
	}
	
	/*function getPatientTitle($id){
		$title = $this->model->getPatientTitle($id);
		return $title;
   }*/
   
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
   
   function getCheckpointDetails($app,$module,$id) {
	   global $projects;
	   $retval = $this->model->getCheckpointDetails($app,$module,$id);
	   if($retval){
			 return $retval;
		  } else{
			 return "error";
		  }
   }   

	function updateCheckpointText($id,$text){
		$this->model->updateCheckpointText($id,$text);
		return true;
   }


	function getPatientsSearch($term,$exclude) {
		$search = $this->model->getPatientsSearch($term,$exclude);
		return $search;
	}
	
	function saveLastUsedPatients($id) {
		$retval = $this->model->saveLastUsedPatients($id);
		if($retval){
		   return "true";
		} else{
		   return "error";
		}
	}


	function getGlobalSearch($term) {
		$search = $this->model->getGlobalSearch($term);
		return $search;
	}
	
	function getInlineSearch($term) {
		$search = $this->model->getInlineSearch($term);
		return $search;
	}
	
	function getInsuranceContext($id,$field,$edit) {
		global $lang;
		$context = $this->model->getInsuranceContext($id,$field);
		include 'view/insurance_context.php';
	}
	
	function getWidgetAlerts() {
		global $lang, $system;
		if($arr = $this->model->getWidgetAlerts()) {
			$alerts = $arr["alerts"];
			$reminders = $arr["reminders"];
			$waitinglist = $arr["waitinglist"];
			ob_start();
			include 'view/widget.php';
			$data["html"] = ob_get_contents();
			ob_end_clean();
			$data["widgetaction"] = $arr["widgetaction"];
			return json_encode($data);
		} else {
			ob_start();
			include CO_INC .'/view/default.php';
			$data["html"] = ob_get_contents();
			ob_end_clean();
			return json_encode($data);
		}
	}
	
	function getPatientInfoForCalendar($id) {
		$arr = $this->model->getPatientInfoForCalendar($id);
		return json_encode($arr);
	}
   
}

$patients = new Patients("patients");
?>