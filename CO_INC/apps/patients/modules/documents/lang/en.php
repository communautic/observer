<?php
$patients_documents_name = "Files";

$lang["PATIENT_DOCUMENT_TITLE"] = 'File';
$lang["PATIENT_DOCUMENT_DOCUMENTS"] = 'Files';
$lang["PATIENT_DOCUMENT_NEW"] = 'New File';
$lang["PATIENT_DOCUMENT_ACTION_NEW"] = 'new File';
$lang["PATIENT_DOCUMENT_DESCRIPTION"] = 'Description';
$lang["PATIENT_DOCUMENT_UPLOAD"] = 'File / Upload';
$lang["PATIENT_DOCUMENT_FILENAME"] = 'Filename/Format';
$lang["PATIENT_DOCUMENT_FILESIZE"] = 'Filesize';
$lang["PATIENT_DOCUMENT_FILES"] = 'Files';

$lang["PATIENT_DOCUMENT_HELP"] = 'manual_patients_files.pdf';

$lang["PATIENT_PRINT_DOCUMENT"] = 'document.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/patients/documents/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>