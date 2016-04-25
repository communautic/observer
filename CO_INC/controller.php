<?php
//include_once("model.php");

class Controller extends MySQLDB {
	var $applications = array();
	var $num_applications;
	var $modules = array();
	var $form_url;


	function __construct() {
		global $system,$session;
		$this->_db = new MySQLDB();
		$this->model = new Model();
		$q = "select value from co_config where name='applications'";
		$result = mysql_query($q, $this->_db->connection);
		$row = mysql_result($result,0);
		$this->applications = json_decode($row);
	}


	function getModules($app) {
		global $system;
		$retval = $this->model->getModules($app);
		$modules = json_decode($retval);
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


	function exportWord($title,$text) {
		global $lang;
		ob_start();
			include(CO_INC . "/view/wordheader.php");
			$header = ob_get_contents();
		ob_end_clean();
		
		$footer = "</body></html>";
		$html = $header . $text . $footer;
		header("Content-type: application/vnd.ms-word");
		header("Content-Disposition: attachment; Filename=" . $title . ".doc");
		echo $html;
	}
	
	
	function printPDF($title,$text,$stationary=1,$headerimg='logo_print.png') {
		global $lang;
		$header = "";
		$headerpdf = "";
		$GLOBALS['STATIONARY'] = $stationary;
		$GLOBALS['HEADERIMG'] = $headerimg;
		
		ob_start();
			include(CO_INC . "/view/printheader.php");
			$header = ob_get_contents();
		ob_end_clean();
		
		$pdfheader = CO_PATH_BASE . "/data/templates/pdfheader.php";
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
		$dompdf->set_paper('a4', 'portrait'); // change 'a4' to whatever you want 
		$dompdf->render();
		$options['Attachment'] = 1;
		$options['Accept-Ranges'] = 0;
		$options['compress'] = 1;
		$dompdf->stream($title.".pdf", $options);
	}
	
	function printA4LS($title,$text,$stationary=1,$headerimg='logo_print.png') {
		global $lang;
		$header = "";
		$headerpdf = "";
		$GLOBALS['STATIONARY'] = $stationary;
		$GLOBALS['HEADERIMG'] = $headerimg;
		
		ob_start();
			include(CO_INC . "/view/printheader.php");
			$header = ob_get_contents();
		ob_end_clean();
		
		$pdfheader = CO_PATH_BASE . "/data/templates/pdfheader.php";
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
		$dompdf->set_paper('a4', 'landscape'); // change 'a4' to whatever you want 
		$dompdf->render();
		$options['Attachment'] = 1;
		$options['Accept-Ranges'] = 0;
		$options['compress'] = 1;
		$dompdf->stream($title.".pdf", $options);
	}
	
	function printSketch($title,$text,$stationary=1,$headerimg='logo_print.png') {
		global $lang;
		$header = "";
		$headerpdf = "";
		$GLOBALS['STATIONARY'] = $stationary;
		$GLOBALS['HEADERIMG'] = $headerimg;
		
		ob_start();
			include(CO_INC . "/view/printheader.php");
			$header = ob_get_contents();
		ob_end_clean();
		
		$pdfheader = CO_PATH_BASE . "/data/templates/pdfheader.php";
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
		//$dompdf->set_paper('a3', 'landscape'); // change 'a4' to whatever you want 
		$dompdf->set_paper( array(0,0, 1380 / 96 * 72, 1700 / 96 * 72), "portrait" );
		$dompdf->render();
		$options['Attachment'] = 1;
		$options['Accept-Ranges'] = 0;
		$options['compress'] = 1;
		$dompdf->stream($title.".pdf", $options);
	}
	
	function printInvoice($title,$text,$stationary=1,$headerimg='logo_print.png') {
		global $lang;
		$header = "";
		$headerpdf = "";
		$GLOBALS['STATIONARY'] = $stationary;
		$GLOBALS['HEADERIMG'] = $headerimg;
		
		ob_start();
			include(CO_INC . "/view/printheader.php");
			$header = ob_get_contents();
		ob_end_clean();
		
		$pdfheader = CO_PATH_BASE . "/data/templates/pdf_invoice.php";
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
		$dompdf->set_paper('a4', 'portrait'); // change 'a4' to whatever you want 
		$dompdf->render();
		$options['Attachment'] = 1;
		$options['Accept-Ranges'] = 0;
		$options['compress'] = 1;
		$dompdf->stream($title.".pdf", $options);
	}
	
	function printBeleg($title,$text,$stationary=1,$headerimg='logo_print.png') {
		global $lang;
		//$header = "";
		$headerpdf = "";
		//$GLOBALS['STATIONARY'] = $stationary;
		//$GLOBALS['HEADERIMG'] = $headerimg;
		
		ob_start();
			include(CO_INC . "/view/belegheader.php");
			$header = ob_get_contents();
		ob_end_clean();
		
		$pdfheader = CO_PATH_BASE . "/data/templates/pdf_beleg.php";
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
		//$dompdf->set_paper('a4', 'portrait'); // change 'a4' to whatever you want 
		$dompdf->set_paper(array(0, 0, 227, 453), 'portrait');
		$dompdf->render();
		$options['Attachment'] = 1;
		$options['Accept-Ranges'] = 0;
		$options['compress'] = 1;
		$dompdf->stream($title.".pdf", $options);
	}
	
    
	function normal_chars($string) {
		$string = htmlentities($string, ENT_QUOTES, 'UTF-8');
		$string = preg_replace('~&([a-z]{1,2})(acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', $string);
		$string = preg_replace(array('~[^0-9a-z]~i', '~-+~'), '_', $string);
		return trim($string);
	}

	function savePDF($title,$text,$path,$stationary=1,$headerimg='logo_print.png') {
		global $lang;
		$GLOBALS['STATIONARY'] = $stationary;
		$GLOBALS['HEADERIMG'] = $headerimg;
		
		ob_start();
			include(CO_INC . "/view/printheader.php");
			$header = ob_get_contents();
		ob_end_clean();
		
		$pdfheader = CO_PATH_BASE . "/data/templates/pdfheader.php";
		if(file_exists($pdfheader)) {
			ob_start();
				include_once($pdfheader);
				$headerpdf = ob_get_contents();
			ob_end_clean();
		} else {
			$headerpdf = "";
		}
		
		$footer = "</body></html>";
		$html = $header . '<script type="text/php">' . $headerpdf . '</script>' . $text . $footer;
		require_once(CO_INC . "/classes/dompdf_60_beta2/dompdf_config.inc.php");
		$dompdf = new DOMPDF();
		$dompdf->load_html($html);
		$dompdf->set_paper('a4', 'portrait'); // change 'a4' to whatever you want
		$dompdf->render();
		$pdf = $dompdf->output();
		file_put_contents( $path, $pdf);
	}
	
	function saveInvoice($title,$text,$path,$stationary=1,$headerimg='logo_print.png') {
		global $lang;
		$GLOBALS['STATIONARY'] = $stationary;
		$GLOBALS['HEADERIMG'] = $headerimg;
		
		ob_start();
			include(CO_INC . "/view/printheader.php");
			$header = ob_get_contents();
		ob_end_clean();
		
		$pdfheader = CO_PATH_BASE . "/data/templates/pdf_invoice.php";
		if(file_exists($pdfheader)) {
			ob_start();
				include_once($pdfheader);
				$headerpdf = ob_get_contents();
			ob_end_clean();
		} else {
			$headerpdf = "";
		}
		
		$footer = "</body></html>";
		$html = $header . '<script type="text/php">' . $headerpdf . '</script>' . $text . $footer;
		require_once(CO_INC . "/classes/dompdf_60_beta2/dompdf_config.inc.php");
		$dompdf = new DOMPDF();
		$dompdf->load_html($html);
		$dompdf->set_paper('a4', 'portrait'); // change 'a4' to whatever you want
		$dompdf->render();
		$pdf = $dompdf->output();
		file_put_contents( $path, $pdf);
	}
	
	function saveTimeline($title,$text,$path,$width,$height) {
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
		$dompdf->set_paper( array(0,0, $width / 96 * 72, $height / 96 * 72), "portrait" );
		$dompdf->render();
		$pdf = $dompdf->output();
		file_put_contents( $path, $pdf);
	}
	
	
	function openHelpPDF($data) {
		global $session;
		$file = $data["file"];
		//$app = $data["app"];
		//$module = $data["module"];
		
		//$fullPath = CO_INC_PATH . "/" . CO_INC . "/apps/" . $app . $module . "/lang/help/" . $file;
		$fullPath = CO_FILES . "/help/" . $session->userlang . "/" . $file;
		
		if ($fd = fopen ($fullPath, "rb")) {
			$fsize = filesize($fullPath);
			$path_parts = pathinfo($fullPath); 
			$ext = strtolower($path_parts["extension"]);
			header("Content-type: application/pdf");
			header("Content-Disposition: attachment; filename=\"".$file."\""); 
			header("Content-length: $fsize");
			header("Cache-control: private"); 
			ob_clean();
			flush();
			while(!feof($fd)) {
				$buffer = fread($fd, 2048);
				echo $buffer;
			}
		}
		fclose ($fd);
		exit;
		}


	function printHTML($title,$text) {
		ob_start();
			include(CO_INC . "/view/printheader.php");
			$header = ob_get_contents();
		ob_end_clean();
		$footer = "</body></html>";
		$html = $header . $text . $footer;
		echo($html);
	}


	function sendEmail($to,$cc,$from,$fromName,$subject,$body,$attachment = "",$attachment_array = "",$vcards_array = "",$bodynl2br = 1, $footer_display = 1) {
		global $lang, $contactsmodel;
		
		try {
  			$mail = new PHPMailerLite(true); //New instance, with exceptions enabled
			$mail->CharSet = "UTF-8";
			//$mail->Encoding = 'quoted-printable';
			//$body = file_get_contents('contents.html');
			//$body = preg_replace('/\\\\/','', $body); //Strip backslashes
			if($bodynl2br == 1) {
				$body = nl2br($body);
			}
			if($footer_display == 1) {
				$footer = $lang["GLOBAL_EMAIL_FOOTER"];
			} else {
				$footer = "";
			}
  
			$mail->AddReplyTo($from,$fromName);
			$mail->SetFrom($from,$fromName);
			
			$tos = explode(",", $to);
			foreach ($tos as &$to) {
				$email = $contactsmodel->getContactFieldFromID($to, "email");
				$firstname = $contactsmodel->getContactFieldFromID($to, "firstname");
				$lastname = $contactsmodel->getContactFieldFromID($to, "lastname");
				$mail->AddAddress($email,$firstname . " " . $lastname);
			}
			
			if($cc != "") {
			$ccs = explode(",", $cc);
			foreach ($ccs as &$cc) {
				$email = $contactsmodel->getContactFieldFromID($cc, "email");
				$firstname = $contactsmodel->getContactFieldFromID($cc, "firstname");
				$lastname = $contactsmodel->getContactFieldFromID($cc, "lastname");
				// changed to bcc
				$mail->AddBCC($email,$firstname . " " . $lastname);
			}
			}
			
			$mail->Subject  = stripslashes($subject);
			
			$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
			$mail->WordWrap   = 80;
			
			$mail->MsgHTML(stripslashes($body . $footer));
			if($attachment != "") {
				if(is_array($attachment)) {
					foreach ($attachment as &$att) {
						$mail->AddAttachment($att); 
					}
				} else {
					$mail->AddAttachment($attachment);
				}
			}
			
			if(is_array($attachment_array)) {
				foreach ($attachment_array as &$att) {
					$mail->AddAttachment(CO_PATH_DOCUMENTS . $att["tempname"], $att["filename"]); 
				}
			}
			
			if(is_array($vcards_array)) {
				foreach ($vcards_array as &$att) {
					$mail->AddAttachment($att["path"], $att["filename"]); 
				}
			}
			
			$mail->IsHTML(true); // send as HTML
			
			$mail->Send();
			return true;
		} catch (phpmailerException $e) {
			return $e->errorMessage();
		}
	}

	
	function writeSendtoLog($what,$whatid,$who,$subject,$body) {
		$this->model->writeSendtoLog($what,$whatid,$who,$subject,$body);
	}


	function getSendtoDetails($what,$id) {
		global $lang;
		$html = "";
		$sendto = $this->model->getSendtoDetails($what,$id);
		foreach($sendto as $value) { 
			$html .= '<div class="text11 toggleSendTo co-link">' . $value->who . ', ' . $value->date . '</div>' .
				'<div class="SendToContent">' . $lang["GLOBAL_SUBJECT"] . ': ' . $value->subject . '<br /><br />' . nl2br($value->body) . '<br></div>';
		 }
		return $html;
	}
	
	function isIOS() {
		if(strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone') || strpos($_SERVER['HTTP_USER_AGENT'], 'iPad')){
			return true;
		} else {
			return false;
		}
	}
	
}

$controller = new Controller();
?>