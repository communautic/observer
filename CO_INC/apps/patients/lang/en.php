<?php
// App name
$patients_name = "Patients";
$lang["patients_name"] = 'Patients';

// Left
$lang["PATIENT_FOLDER"] = 'Folder';
$lang["PATIENT_FOLDER_NEW"] = 'New Folder';
$lang["PATIENT_FOLDER_ACTION_NEW"] = 'create new folder';
$lang["PATIENT_PATIENTS"] = 'Patients';
$lang["PATIENT_NEW"] = 'New patient';
$lang["PATIENT_ACTION_NEW"] = 'create new patient';

// Patient Right
$lang["PATIENT_FOLDER_TAB_LIST"] = 'Patients';
$lang["PATIENT_FOLDER_TAB_INVOICES"] = 'Invoices';
$lang["PATIENT_FOLDER_TAB_INVOICES_DATE"] = 'Date';
$lang["PATIENT_FOLDER_TAB_INVOICES_PATIENT"] = 'Patient';
$lang["PATIENT_FOLDER_TAB_INVOICES_NUMBER"] = 'Number';
$lang["PATIENT_FOLDER_TAB_INVOICES_STATUS"] = 'Status';
$lang["PATIENT_FOLDER_TAB_REVENUE"] = 'Revenue';
$lang["PATIENT_FOLDER_TAB_FILTER"] = 'Filter';
$lang["PATIENT_FOLDER_TAB_THERAPIST"] = 'Therapist';
$lang["PATIENT_FOLDER_TAB_CALCULATE"] = 'calculate';
$lang["PATIENT_FOLDER_TAB_INVOICES"] = 'Invoices';
$lang["PATIENT_FOLDER_TAB_REVENUE"] = 'Revenue';

$lang["PATIENT_TITLE"] = 'Patient';

$lang["PATIENT_STATUS_PLANNED"] = 'entered';
$lang["PATIENT_STATUS_PLANNED_TIME"] = '';
$lang["PATIENT_STATUS_FINISHED"] = 'in care';
$lang["PATIENT_STATUS_FINISHED_TIME"] = '';
$lang["PATIENT_STATUS_STOPPED"] = 'in evidence';
$lang["PATIENT_STATUS_STOPPED_TIME"] = '';

$lang["PATIENT_MANAGEMENT"] = 'Therapist';
$lang["PATIENT_CONTACT_DETAILS"] = 'Contact Details';

$lang["PATIENT_CONTACT_POSITION"] = 'Position';
$lang["PATIENT_CONTACT_PHONE"] = 'Phone';
$lang["PATIENT_CONTACT_EMAIL"] = 'E-mail';
$lang["PATIENT_INSURANCE"] = 'Insurance';
$lang["PATIENT_INSURANCE_NUMBER"] = 'Patient NI number';
$lang["PATIENT_INSURER"] = 'Insurer';
$lang["PATIENT_INSURANCE_INSURER_NUMBER"] = 'Insurer NI number';

$lang["PATIENT_INSURANCE_ADDITIONAL"] = 'Additional Insurance';
$lang["PATIENT_DESCRIPTION"] = 'History';
$lang["PATIENT_CODE"] = 'Patient code';
$lang["PATIENT_CODE_PO"] = 'Referentennummer';
$lang["PATIENT_CODE_TO"] = 'Patientencode';
$lang["PATIENT_DOB"] = 'D.O.B';
$lang["PATIENT_COO"] = 'Profession';

$lang["PATIENT_HANDBOOK"] = 'Patient File';

$lang["PATIENT_HELP"] = 'manual_patients_patients.pdf';
$lang["PATIENT_FOLDER_HELP"] = 'manual_patients_folders.pdf';

// Print images
$lang["PRINT_PATIENT_MANUAL"] = 'patientfile.png';
$lang["PRINT_PATIENT"] = 'patient.png';
$lang["PRINT_PATIENT_FOLDER"] = 'folder.png';

// Dektop Widget
$lang["PATIENT_WIDGET_NO_ACTIVITY"]		=	'Currently there are no notices';
$lang["PATIENT_WIDGET_TITLE"] 	=	'Payment reminder';
$lang["PATIENT_WIDGET_ALERT"] 	= 	'Invoice "%1$s" for patient "%2$s" is <span class="yellow">overdue</span>';
$lang["PATIENT_WIDGET_TITLE_INVOICE"] 	=	'Invoice';
$lang["PATIENT_WIDGET_REMINDER_INVOICE"] 	= 	'Invoice "%1$s" for patient "%2$s" was <span class="yellow">created</span>';
$lang["PATIENT_WIDGET_TITLE_WAITINGLIST"] 	=	'Waitinglist';
$lang["PATIENT_WIDGET_REMINDER_WAITINGLIST"] 	= 	'Patient "%1$s" is still on the <span class="yellow">waiting list</span> for a treatment';

$lang["EVENTTYPE"][1] = 'Treatment';


// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/patients/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>