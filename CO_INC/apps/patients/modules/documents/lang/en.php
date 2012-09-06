<?php
$patients_documents_name = "Documents";

$lang["PATIENT_DOCUMENT_TITLE"] = 'Document';
$lang["PATIENT_DOCUMENT_DOCUMENTS"] = 'Documents';
$lang["PATIENT_DOCUMENT_NEW"] = 'New Document';
$lang["PATIENT_DOCUMENT_ACTION_NEW"] = 'new Document';
$lang["PATIENT_DOCUMENT_UPLOAD"] = 'File / Upload';
$lang["PATIENT_DOCUMENT_FILENAME"] = 'Filename/Format';
$lang["PATIENT_DOCUMENT_FILESIZE"] = 'Filesize';

$lang["PATIENT_DOCUMENT_HELP"] = 'manual_mitarbeiter_aktenmappen.pdf';

$lang["PATIENT_PRINT_DOCUMENT"] = 'document.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/patients/documents/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>