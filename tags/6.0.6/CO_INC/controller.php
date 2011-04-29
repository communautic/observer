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
		$this->applications = $system->json_decode($row);
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
		global $lang;
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
		$html = $header . '<script type="text/php">' . $headerpdf  . '</script>' . $text . $footer;
		require_once(CO_INC . "/classes/dompdf/dompdf_config.inc.php");
		$dompdf = new DOMPDF();
		$dompdf->load_html($html);
		$dompdf->render();
		$options['Attachment'] = 1;
		$options['Accept-Ranges'] = 0;
		$options['compress'] = 1;
		$dompdf->stream($title.".pdf", $options);
	}


	function savePDF($title,$text,$path) {
		global $lang;
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
		require_once(CO_INC . "/classes/dompdf/dompdf_config.inc.php");
		$dompdf = new DOMPDF();
		$dompdf->load_html($html);
		$dompdf->render();
		$pdf = $dompdf->output();
		file_put_contents( $path, $pdf);
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


	function sendEmail($to,$cc,$from,$fromName,$subject,$body,$attachment = "",$attachment_array = "",$vcards_array = "") {
		global $contactsmodel;
		
		try {
  			$mail = new PHPMailerLite(true); //New instance, with exceptions enabled
			$mail->CharSet = "UTF-8";
			//$body = file_get_contents('contents.html');
			//$body = preg_replace('/\\\\/','', $body); //Strip backslashes
			$footer = "<br />sent with company.observer";
  
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
			
			$mail->Subject  = $subject;
			
			$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
			$mail->WordWrap   = 80;
			
			$mail->MsgHTML(stripslashes($body . $footer));
			if($attachment != "") {
				$mail->AddAttachment($attachment);
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

	
	function writeSendtoLog($what,$whatid,$who) {
		$this->model->writeSendtoLog($what,$whatid,$who);
	}
	
	function getSendtoDetails($what,$id) {
		$html = "";
		$sendto = $this->model->getSendtoDetails($what,$id);
		foreach($sendto as $value) { 
			$html .= '<div class="tcell-right-para">' . $value->who . ', ' . $value->date . '</div>';
		 }
		return $html;
	}
	
}

$controller = new Controller();
?>