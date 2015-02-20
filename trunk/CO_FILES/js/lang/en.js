var FILE_BROWSE = "File / Upload";
var FILE_DROP_AREA = "Drop files here to upload";
var FILE_DROP_AREA_IMAGE = "Drop image here to upload";
var CUSTOM_NOTE = "";

// Alerts
var ALERT_YES = "Yes";
var ALERT_NO = "No";
var ALERT_BUTTON_LOGIN = "Login";
var ALERT_BUTTON_LOGOUT = "Logout";
var ALERT_MESSAGE_SESSION_RENEW = 'The platform was accessed with your login details<br />from somewhere else.<br /><br />'+
							      'You can loggout or re-enter your password below.<br /><br />Ihr Passwort: ';
var ALERT_MESSAGE_SESSION_COOKIE = 'Access to the system expired due to the deletion of your "browser cookies".<br /><br />'+
							      'Please log in again with your access codes. If this problem persists contact your computer administrator.';
var ALERT_MESSAGE_INTERNET = 'Your internet connection appears to be down or the server you are trying to connect to is not responding.<br /><br />Once the connection can be reestablished this warning message will disappear automatically. If this problem persists please contact your IT administrator.';
var ALERT_LOGOUT = "Do you really want to logout?";
var ALERT_NO_TITLE = "Please enter a title";
var ALERT_CHANGES_NOT_SAVED = "Your changes have not yet been saved!\nWould you like to save them now?";
var ALERT_DELETE = "Do you really want to delete this data?";
var ALERT_DELETE_REALLY = "Do you really want to irreversible delete this data?";
var ALERT_DELETE_BIN = "Do you really want to irreversible empty the recycle bin?";
var ALERT_RESTORE = "Would you like to restore this data?";
var ALERT_PROJECT_MOVE_ALL = "Would you like to change all start dates in relation to this new date?";
var ALERT_PHASE_TASKS_MOVE_START = "Would you like to adjust all following dates?";
var ALERT_PHASE_TASKS_MOVE_ALL = "Would you like to change all dates of dependent stages?";
//Status Alerts
var ALERT_STATUS_PROJECT_ACTIVATE = 'Would you like to set this project to „in progress”?';
var ALERT_STATUS_PHASE_ACTIVATE = 'Would you like to set this phase to „in progress”?';
var ALERT_STATUS_PHASE_COMPLETE = 'Would you like to set this phase to „completed”?';
var ALERT_STATUS_PPROJECT_COMPLETE = 'Would you like to set this project to „completed”?';
// Status Alerts patients
var ALERT_STATUS_PATIENT_ACTIVATE = 'Would you like to set this patient to<br />„in care”?';
var ALERT_STATUS_TREATMENT_ACTIVATE = 'Would you like to set this treatment with todays date to<br />„in Treatment”?';
var ALERT_STATUS_TREATMENT_COMPLETE = 'Would you like to set this treatment with todays date to<br />„completed”?';
var ALERT_STATUS_PATIENT_COMPLETE = 'Would you like to set this patient with todays date to<br />„in evidence”?';

var ALERT_NO_FILE = "Please select a file to upload.";

var ALERT_NO_VALID_EMAIL = "Please enter a valid email address.";
var ALERT_NO_EMAIL = "Please enter an Email address for this contact.";
var ALERT_REMOVE_RECIPIENT = "Contacts without an email address were removed from the recipient list:<br /><br />";

var ALERT_SENDTO_EMAIL = 'has no Email address';
var ALERT_ACCESS_CONTACT_NOACCESSCODES = 'has no Access Codes. Would you like to send them now?';
var ALERT_ACCESS_GROUP_NOACCESSCODES = 'has no Access Codes.';
var ALERT_ACCESS_GROUP_NOACCESSCODES_SEND = 'send';
var ALERT_ACCESS_IS_SYSADMIN = 'is a Systhem Manager and therefore already an Administrator';
var ALERT_ACCESS_IS_GUEST = 'is already Guest';
var ALERT_ACCESS_IS_ADMIN = 'is already Administrator';

var ALERT_CHOOSE_FOLDER = 'Please choose a folder for this new project';
var ALERT_FORUM_RESPONSE_EMPTY = 'Please write your answer';

var ALERT_UPLOAD_SIZE = "{file} is too large, maximum file size is {sizeLimit}.";
var ALERT_UPLOAD_TYPE = "{file} has invalid extension. Only {extensions} are allowed.";
var UPLOAD_FROM = "from";
var UPLOAD_CANCEL = "Cancel";

var ALERT_CLIENT_ACCESS = 'Möchten Sie die Bestellberechtigung jetzt vergeben?';
var ALERT_CLIENT_ACCESS_REMOVE = 'Möchten Sie die Bestellberechtigung jetzt entziehen?';
var ALERT_PUBLISHERS_ARCHIVE_OTHERS = 'Möchten Sie alle anderen publizierten Daten archivieren?';

var DATEPICKER_CLEAR = 'Clear';

var ALERT_SUCCESS_COPY_MEETING = 'The meeting was successfully copied to: <br />';
var ALERT_SUCCESS_PROJECT_EXPORT = 'The project was successfully exported to: <br />';

var ALERT_TRAINING_MOVE_ALL = "Wollen Sie alle Trainingstermine an das neue Startdatum anpassen?";

var ALERT_CALENDAR_DEACTIVATE = "Do you really want to de-activate this calendar?";
var ALERT_CALENDAR_DATA = "Please check the following entries:<br />";
var ALERT_CALENDAR_MISSING_TITLE = "Title";
var ALERT_CALENDAR_MISSING_TREATMENT = "Treatment";
var ALERT_CALENDAR_MISSING_LOCATION = "Location";
var ALERT_CALENDAR_ROOM_BUSY = "This locatiuon is buys.<br />Please choose a different location.";

var ALERT_ARCHIVE = "Would you really want to archive the data?";

// calendar settings
var defaultView="agendaWeek";
var eventSources=[];
var dayNames=["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
var dayNamesShort=["Sun.","Mon.","Tue.","Wed.","Thu.","Fri.","Sat."];
var monthNames=["January","February","March","April","May","June","July","August","September","October","November","December"];
var monthNamesShort=["Jan.","Feb.","Mar.","Apr.","May.","Jun.","Jul.","Aug.","Sep.","Oct.","Nov.","Dec."];
var agendatime="HH:mm{ -HH:mm}";
var defaulttime="HH:mm";
var allDayText="All day";
var firstDay=1;
var buttonTextToday='Today';
var buttonTextMonth='Month';
var buttonTextWeek='Week';
var buttonTextDay='Day';
var holidayCalendar='22';
var weekNumberTitle = 'wk ';