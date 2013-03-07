<?php
//include_once("../config.php");
include_once(CO_INC . "/classes/ajax_header.inc");

/**
 * Handle file uploads via XMLHttpRequest
 */
 
class qqUploadedFileXhr {
    /**
     * Save the file to the specified path
     * @return boolean TRUE on success
     */
    function save($path) {    
        $input = fopen("php://input", "r");
        $temp = tmpfile();
        $realSize = stream_copy_to_stream($input, $temp);
        fclose($input);
        
        if ($realSize != $this->getSize()){            
            return false;
        }
        
        $target = fopen($path, "w");        
        fseek($temp, 0, SEEK_SET);
        stream_copy_to_stream($temp, $target);
        fclose($target);
        
        return true;
    }
    function getName() {
        return $_GET['qqfile'];
    }
    function getSize() {
        if (isset($_SERVER["CONTENT_LENGTH"])){
            return (int)$_SERVER["CONTENT_LENGTH"];            
        } else {
            throw new Exception('Getting content length is not supported.');
        }      
    }   
}

/**
 * Handle file uploads via regular form post (uses the $_FILES array)
 */
class qqUploadedFileForm {  
    /**
     * Save the file to the specified path
     * @return boolean TRUE on success
     */
    function save($path) {
        if(!move_uploaded_file($_FILES['qqfile']['tmp_name'], $path)){
            return false;
        }
        return true;
    }
    function getName() {
        return $_FILES['qqfile']['name'];
    }
    function getSize() {
        return $_FILES['qqfile']['size'];
    }
}


class qqFileUploader {
    private $allowedExtensions = array();
    private $sizeLimit = 10485760;
    private $file;
	private $_db;

    function __construct(array $allowedExtensions = array(), $sizeLimit = 10485760){        
        $allowedExtensions = array_map("strtolower", $allowedExtensions);
            
        $this->allowedExtensions = $allowedExtensions;        
        $this->sizeLimit = $sizeLimit;
        
        $this->checkServerSettings();       

        if (isset($_GET['qqfile'])) {
            $this->file = new qqUploadedFileXhr();
        } elseif (isset($_FILES['qqfile'])) {
            $this->file = new qqUploadedFileForm();
        } else {
            $this->file = false; 
        }
		
		$this->_db = new MySQLDB();
    }
    
    private function checkServerSettings(){        
        $postSize = $this->toBytes(ini_get('post_max_size'));
        $uploadSize = $this->toBytes(ini_get('upload_max_filesize'));        
        
        if ($postSize < $this->sizeLimit || $uploadSize < $this->sizeLimit){
            $size = max(1, $this->sizeLimit / 1024 / 1024) . 'M';             
            die("{'error':'increase post_max_size and upload_max_filesize to $size'}");    
        }        
    }
    
    private function toBytes($str){
        $val = trim($str);
        $last = strtolower($str[strlen($str)-1]);
        switch($last) {
            case 'g': $val *= 1024;
            case 'm': $val *= 1024;
            case 'k': $val *= 1024;        
        }
        return $val;
    }
    
    /**
     * Returns array('success'=>true) or array('error'=>'error message')
     */
    function handleUpload($uploadDirectory, $replaceOldFile = FALSE){
		global $session;
        if (!is_writable($uploadDirectory)){
            return array('error' => "Server error. Upload directory isn't writable.");
        }
        
        if (!$this->file){
            return array('error' => 'No files were uploaded.');
        }
        
        $size = $this->file->getSize();
        
        if ($size == 0) {
            return array('error' => 'File is empty');
        }
        
        if ($size > $this->sizeLimit) {
            return array('error' => 'File is too large');
        }
        
        $pathinfo = pathinfo($this->file->getName());
        $filename = str_replace(" ", "_", $pathinfo['basename']);

		$filename = $pathinfo['filename'];
        //$filename = md5(uniqid());
		//$tempname = strtotime("now");
		
        $ext = $pathinfo['extension'];
		//$tempname = $filename . '.' . $ext;

        if($this->allowedExtensions && !in_array(strtolower($ext), $this->allowedExtensions)){
            $these = implode(', ', $this->allowedExtensions);
            return array('error' => 'File has an invalid extension, it should be one of '. $these . '.');
        }
        
        if(!$replaceOldFile){
            /// don't overwrite previous files that were uploaded
			$pattern = '/(.+)\(([0-9]+)\)$/';
            while (file_exists($uploadDirectory . $filename . '.' . $ext)) {
                if(preg_match( $pattern, $filename, $matches)) {
					$num = $matches[2]+1;
					$filename = $matches[1] . '(' . $num . ')';
					//echo $filename;
				} else {
					$filename .= ' (1)';
				}
            }
        }
        
        if ($this->file->save($uploadDirectory . $filename . '.' . $ext)){
		//if ($this->file->save($uploadDirectory . $tempname)){
				
			$fsave = '' . $filename . '.' . $ext . '';
			$did = $_GET['did'];
			$module = $_GET['module'];
			//$did = $_GET['did'];
			$now = gmdate("Y-m-d H:i:s");
			$q = "INSERT INTO co_" . $module . " set filename='$fsave', filesize='$size', did='$did', created_user = '$session->uid', created_date = '$now', edited_user = '$session->uid', edited_date = '$now'";
			//$q = "UPDATE co_projects_documents set title = '$filename', filename='$filename', tempname='$tempname', filesize='$size', pid='$pid', created_user = '$session->uid', created_date = '$now', edited_user = '$session->uid', edited_date = '$now' where id='$did'";
			$result = mysql_query($q, $this->_db->connection);
			$id = mysql_insert_id();
//mysql_query("INSERT INTO `images` (id, session, ip, file) VALUES('', '$sesid', '$ip', '$fsave' ) ") or die(mysql_error()); 

return array("success"=>true,"id"=>"$id");
        } else {
            return array('error'=> 'Could not save uploaded file.' .
                'The upload was cancelled, or server error encountered');
        }
        
    }    
}

// list of valid extensions, ex. array("jpeg", "xml", "bmp")
$allowedExtensions = array();
// max file size in bytes
$sizeLimit = 50 * 1024 * 1024;

$uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
$result = $uploader->handleUpload(CO_PATH_BASE.'/data/documents/');
// to pass data through iframe you will need to encode all html tags
echo htmlspecialchars($system->json_encode($result), ENT_NOQUOTES);
?>