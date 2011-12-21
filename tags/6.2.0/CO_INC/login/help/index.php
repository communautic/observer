<?php
$file = $lang["LOGIN_HELP"] = 'manual_login.pdf';
$fullPath = CO_INC_PATH . "/" . CO_INC . "/lang/help/" . $file;
		
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

?>