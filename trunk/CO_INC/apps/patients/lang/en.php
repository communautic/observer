<?php
// App name
$patients_name = "Patients";
$lang["patients_name"] = 'Patients';

// Left
$lang["PATIENT_FOLDER"] = 'Folder';
$lang["PATIENT_FOLDER_NEW"] = 'New Folder';
$lang["PATIENT_FOLDER_ACTION_NEW"] = 'create new folder';
$lang["PATIENT_PATIENTS"] = 'Patient';
$lang["PATIENT_NEW"] = 'New patient';
$lang["PATIENT_ACTION_NEW"] = 'create new patient';

// Patient Right
$lang["PATIENT_TITLE"] = 'Patient';

$lang["PATIENT_STATUS_PLANNED"] = 'entered';
$lang["PATIENT_STATUS_PLANNED_TIME"] = '';
$lang["PATIENT_STATUS_FINISHED"] = 'in care';
$lang["PATIENT_STATUS_FINISHED_TIME"] = '';
$lang["PATIENT_STATUS_STOPPED"] = 'in evidence';
$lang["PATIENT_STATUS_STOPPED_TIME"] = '';

$lang["PATIENT_MANAGEMENT"] = 'Physio';
$lang["PATIENT_CONTACT_DETAILS"] = 'Contact Details';

$lang["PATIENT_CONTACT_POSITION"] = 'Position';
$lang["PATIENT_CONTACT_PHONE"] = 'Phone';
$lang["PATIENT_CONTACT_EMAIL"] = 'E-mail';
$lang["PATIENT_INSURANCE"] = 'Insurance';
$lang["PATIENT_INSURANCE_NUMBER"] = 'NI number';
$lang["PATIENT_DESCRIPTION"] = 'History';
$lang["PATIENT_DOB"] = 'D.O.B';
$lang["PATIENT_COO"] = 'Nationality';

$lang["PATIENT_HANDBOOK"] = 'Patient File';

$lang["PATIENT_HELP"] = 'manual_patienten_patienten.pdf';
$lang["PATIENT_FOLDER_HELP"] = 'manual_patienten_ordner.pdf';

// Print images
$lang["PRINT_PATIENT_MANUAL"] = 'patientfile.png';
$lang["PRINT_PATIENT"] = 'patient.png';
$lang["PRINT_PATIENT_FOLDER"] = 'folder.png';


// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/patients/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>