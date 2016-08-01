<?php
include(CO_INC . "/classes/database.php");
include(CO_INC . "/classes/PasswordHash.php");

/* 1 - authorize */
if(empty($_GET["u"]) || empty($_GET["p"])) {
	echo("Please add your username and password to the string like: &u=yourusername&p=yourpassword");
	exit();
}
$username = $_GET["u"];
// check if user is valid sysadmin
$q = "SELECT * FROM " . CO_TBL_USERS . " WHERE username = '$username' and userlevel = '1'";
$result = $database->query($q);
if(!mysql_num_rows($result) == 1) {
	echo("Sorry, but you don't seem to have permissions to proceed");
	exit();
}

$password = $_GET["p"];
$q = "SELECT id,password FROM ".CO_TBL_USERS." WHERE username = '$username'";
$result = $database->query($q);
      if(!$result || (mysql_numrows($result) < 1)){
         echo("Sorry, but you don't seem to have permissions to proceed");
	exit();
      }
      /* Retrieve password from result, strip slashes */
      $dbarray = mysql_fetch_array($result);
      $dbarray['password'] = stripslashes($dbarray['password']);
      $password = stripslashes($password);

//$password = md5($_GET["p"]);

$hasher = new PasswordHash(8, 0);
if (!$hasher->CheckPassword($password.PASSWORDSALT, $dbarray['password'])) {
		 echo("Sorry, but you don't seem to have permissions to proceed");
		 exit();
		 
}


/*2 - dump mysql */
//mysqldump --opt -Q -uroot -pnik2Emiq DATABASENAME > /PATH/TO/DUMP.SQL

$command = "mysqldump --opt -h" . CO_DB_SERVER . " -u" . CO_DB_USERNAME . " -p" . CO_DB_PASSWORD . " " . CO_DB_DATABASE . " > " . CO_PATH_DATA . "/mysql/db.sql";
exec($command);
/*
3 - save all files
wget -O example.html http://www.electrictoolbox.com/wget-save-different-filename/
Please escape any shell special chars in the download URL, like ? and &, which may be interpreted specially by your shell.

curl -k --user username:password -o backup.xml -O 'https://api.del.icio.us/v1/posts/all'
*/

/* Download */
$date = date("Y-m-d_Hi");
$file = "backup" . $date . ".tar.gz";
$path = CO_PATH_BASE . "/" . $file;

if(exec("tar -czvf " . $file . " data/"))  {
	header("Content-type: application/octet-stream");
	header("Content-Disposition: filename=\"".$file."\"");          
	header( 'Content-Length: '.filesize($path) ); // Required? Not sure...
	header("Cache-control: private"); 
	if ($fd = fopen ($path, "rb")) {
			ob_clean();
			flush();
			while(!feof($fd)) {
				$buffer = fread($fd, 2048);
				echo $buffer;
			}
		
	}
	fclose ($fd);
	//sleep(1);
	unlink($path);
	exit;
}
?>