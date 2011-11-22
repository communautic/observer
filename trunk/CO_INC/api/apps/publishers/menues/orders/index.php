<?php
// api url http://dev.companyobserver.com/?path=api/apps/publishers/menues/orders

//include_once("config.php");
include(CO_INC . "/api/apps/publishers/menues/orders/session.php");
if(!$session->logged_in){
	include(CO_INC . "/login/login.php");
	exit();
}
if($session->pwd_pick != 1) {
	include(CO_INC . "/login/firstlogin.php");
	exit();
}
/*include(CO_INC . "/classes/database.php");
include(CO_INC . "/classes/users.php");
include(CO_INC . "/classes/system.php");
include(CO_INC . "/classes/date.php");*/

include_once(CO_INC . "/model.php");
include_once(CO_INC . "/controller.php");

foreach($controller->applications as $app => $display) {
	include_once(CO_INC . "/apps/".$app."/config.php");
	include_once(CO_INC . "/apps/".$app."/lang/" . CO_DEFAULT_LANGUAGE . ".php");
	include_once(CO_INC . "/apps/".$app."/model.php");
	include_once(CO_INC . "/apps/".$app."/controller.php");
}


include_once(CO_INC . "/apps/clients/config.php");
include_once(CO_INC . "/apps/clients/lang/" . CO_DEFAULT_LANGUAGE . ".php");
include_once(CO_INC . "/apps/clients/model.php");
include_once(CO_INC . "/apps/clients/controller.php");


include_once(CO_INC . "/apps/publishers/modules/menues/config.php");
include_once(CO_INC . "/apps/publishers/modules/menues/lang/" . CO_DEFAULT_LANGUAGE . ".php");
include_once(CO_INC . "/apps/publishers/modules/menues/model.php");
include_once(CO_INC . "/apps/publishers/modules/menues/controller.php");
//$publishersMenues = new PublishersMenues("menues");

include_once(CO_INC . "/api/apps/publishers/menues/orders/controller.php");
include_once(CO_INC . "/api/apps/publishers/menues/orders/model.php");

$cid = $session->cid;
$error = "";

// select current order
$qc = "SELECT * FROM " . CO_TBL_CLIENTS . " where id = '$cid'";
$resultc = mysql_query($qc);
$client = mysql_fetch_object($resultc);

// select current order
$q = "SELECT id FROM " . CO_TBL_PUBLISHERS_MENUES . " where status = '1' and bin ='0'";
$result = mysql_query($q);
$rows = mysql_num_rows($result);
if($rows < 1) {
	$error = "Derzeit ist keine Bestellung für Sie freigeschalten. Bitte probieren Sie es ein anderes Mal wieder.";
}
while($row = mysql_fetch_array($result)) {
	$id = $row['id'];
}

if($error == "") {
	
	$arr = $publishersMenues->model->getDetails($id);
	$menue = $arr["menue"];
	
	// check is allready ordered
	$qo = "SELECT * FROM co_clients_orders where pid = '$cid' and oid = '$id' and bin = '0'";
	$resulto = mysql_query($qo);
	$rowso = mysql_num_rows($resulto);
	if($rowso > 0) {
		$error = "Ihre Bestellung für den Zeitraum vom " . $menue->item_date_from . " bis " . $menue->item_date_to . " wurde bereits aufgegeben.";
	}
	
	if($error == "") {
		// get latest figures from client and prefill Orders
						// try to get the latest order
				$qold ="select * from co_clients_orders WHERE pid='$cid' and bin = '0' ORDER BY id DESC LIMIT 0,1";
				$resultold = mysql_query($qold);
				if(mysql_num_rows($resultold) < 1) {
					$mon = 0; $mon_2 = 0; $mon_3 = 0;
					$tue = 0; $tue_2 = 0; $tue_3 = 0;
					$wed = 0; $wed_2 = 0; $wed_3 = 0;
					$thu = 0; $thu_2 = 0; $thu_3 = 0;
					$fri = 0; $fri_2 = 0; $fri_3 = 0;

				} else {
					while ($rowold = mysql_fetch_array($resultold)) {
						$mon = $rowold["mon"]; $mon_2 = $rowold["mon_2"]; $mon_3 = $rowold["mon_3"];
						$tue = $rowold["tue"]; $tue_2 = $rowold["tue_2"]; $tue_3 = $rowold["tue_3"];
						$wed = $rowold["wed"]; $wed_2 = $rowold["wed_2"]; $wed_3 = $rowold["wed_3"];
						$thu = $rowold["thu"]; $thu_2 = $rowold["thu_2"]; $thu_3 = $rowold["thu_3"];
						$fri = $rowold["fri"]; $fri_2 = $rowold["fri_2"]; $fri_3 = $rowold["fri_3"];
					}
					
				}
	}
	
	
	
}
 if(isset($_POST['suborder'])){
         //echo($clients->setFolderDetails($_POST['id'], $system->checkMagicQuotes($_POST['title']), $_POST['clientstatus']));
		 $cid = $_POST["cid"];
		 $oid = $_POST["oid"];
		 $title = "Bestellung " . $menue->item_date_from . " - " . $menue->item_date_to;
		 $mon = $_POST["mon"];
		 $mon_2 = 0;
		 $mon_3 = 0;
		 $mon_note = $system->checkMagicQuotes($_POST["mon_note"]);
		 $tue = $_POST["tue"];
		 $tue_2 = 0;
		 $tue_3 = 0;
		 $tue_note = $system->checkMagicQuotes($_POST["tue_note"]);
		 $wed = $_POST["wed"];
		 $wed_2 = 0;
		 $wed_3 = 0;
		 $wed_note = $system->checkMagicQuotes($_POST["wed_note"]);
		 $thu = $_POST["thu"];
		 $thu_2 = 0;
		 $thu_3 = 0;
		 $thu_note = $system->checkMagicQuotes($_POST["thu_note"]);
		 $fri = $_POST["fri"];
		 $fri_2 = 0;
		 $fri_3 = 0;
		 $fri_note = $system->checkMagicQuotes($_POST["fri_note"]);
		 
		 if(isset($_POST["mon_2"])) {
			 $mon_2 = $_POST["mon_2"];
		 }
		 if(isset($_POST["mon_3"])) {
			 $mon_3 = $_POST["mon_3"];
		 }
		 
		 if(isset($_POST["tue_2"])) {
			 $tue_2 = $_POST["tue_2"];
		 }
		 if(isset($_POST["tue_3"])) {
			 $tue_3 = $_POST["tue_3"];
		 }
		 
		 if(isset($_POST["wed_2"])) {
			 $wed_2 = $_POST["wed_2"];
		 }
		 if(isset($_POST["wed_3"])) {
			 $wed_3 = $_POST["wed_3"];
		 }
		 
		 if(isset($_POST["thu_2"])) {
			 $thu_2 = $_POST["thu_2"];
		 }
		 if(isset($_POST["thu_3"])) {
			 $thu_3 = $_POST["thu_3"];
		 }
		 
		 if(isset($_POST["fri_2"])) {
			 $fri_2 = $_POST["fri_2"];
		 }
		 if(isset($_POST["fri_3"])) {
			 $fri_3 = $_POST["fri_3"];
		 }
		 
		 $now = gmdate("Y-m-d H:i:s");
		 
		 $q = "INSERT INTO co_clients_orders SET pid='$cid', oid='$oid', title='$title', mon='$mon', mon_2='$mon_2', mon_3='$mon_3', mon_note='$mon_note', tue='$tue', tue_2='$tue_2', tue_3='$tue_3', tue_note='$tue_note', wed='$wed', wed_2='$wed_2', wed_3='$wed_3', wed_note='$wed_note', thu='$thu', thu_2='$thu_2', thu_3='$thu_3', thu_note='$thu_note', fri='$fri', fri_2='$fri_2', fri_3='$fri_3', fri_note='$fri_note', created_user = '$session->uid', created_date = '$now', edited_user = '$session->uid', edited_date = '$now'";
		 $result = mysql_query($q);
		 if($result) {
		  
		  $arr = $publishersMenues->model->getDetails($id);
		 $menue = $arr["menue"];
		  $path = CO_PATH_PDF . "/testorder.pdf";
		  
		  //create pdf
		  ob_start();
			include 'view/print.php';
			$html = ob_get_contents();
			ob_end_clean();

		require_once(CO_INC . "/classes/dompdf_60_beta2/dompdf_config.inc.php");
		$dompdf = new DOMPDF();
		$dompdf->load_html($html);
		$dompdf->set_paper('a4', 'landscape'); // change 'a4' to whatever you want
		$dompdf->render();
		$pdf = $dompdf->output();
		file_put_contents( $path, $pdf);
		  
		  
		  // send email
		  
		  	try {
  			$mail = new PHPMailerLite(true); //New instance, with exceptions enabled
			$mail->CharSet = "UTF-8";
			$mail->Encoding = 'quoted-printable';
			
			$body =	'<p style="font-face: Arial, Verdana; font-size: small">Ihre Bestellung ist bei uns eingelangt.</p>' .
								'<p style="font-face: Arial, Verdana; font-size: small">Im Anhang finden Sie die Bestätigung Ihrer Bestellung. Das Dokument liegt im PDF-Format bei. (Acrobat Reader wird benötigt)</p>' .
								'<p style="font-face: Arial, Verdana; font-size: small;">Herzlichen Dank für die Zusammenarbeit, Ihr</p>' .
								'<p style="font-face: Arial, Verdana; font-size: small;">mama-bringts Team</p>';
			
			
			//$body = $message;
			//$footer = $lang["GLOBAL_EMAIL_FOOTER"];
  
			$mail->AddReplyTo("info@mama-bringts.at","mama-brints");
			$mail->SetFrom("info@mama-bringts.at","mama-bringts");
			
			$mail->AddAddress($session->email,$session->firstname . " " . $session->lastname);
			
			$mail->Subject  = stripslashes("mama-bringts Bestellbestätigung");
			
			$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
			$mail->WordWrap   = 80;
			
			$mail->MsgHTML(stripslashes($body));
			
			$mail->AddAttachment($path); 
			
			$mail->IsHTML(true); // send as HTML
			
			$mail->Send();
			echo true;
		} catch (phpmailerException $e) {
			return $e->errorMessage();
		}
		  
		  
		 }
		 
      } else {
		include 'view/edit.php';
	  }
?>