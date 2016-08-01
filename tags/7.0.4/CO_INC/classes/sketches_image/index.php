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

		//$filename = $pathinfo['filename'];
        //$filename = md5(uniqid());
		$filename = strtotime("now");
		/*$replace_characters = array(
			'&' => '_und_',
			'Ä' => 'Ae',
			'Ö' => 'Oe',
			'ä' => 'ae',
			'è' => 'e',
			'é' => 'e',
			'ö' => 'oe',
			'ü' => 'ue',
			'Ü' => 'Ue',
			'ß' => 'ss',
			' ' => '_',
			);
		$filename = strtr($filename, $replace_characters);
		$filename = $filename . '_' . $tempname;*/
        $ext = strtolower($pathinfo['extension']);

        if($this->allowedExtensions && !in_array(strtolower($ext), $this->allowedExtensions)){
            $these = implode(', ', $this->allowedExtensions);
            return array('error' => 'File has an invalid extension, it should be one of '. $these . '.');
        }
        
        /*if(!$replaceOldFile){
            /// don't overwrite previous files that were uploaded
            while (file_exists($uploadDirectory . $filename . '.' . $ext)) {
                $filename .= rand(10, 99);
            }
        }*/
        $did = $_GET['did'];
		$forig = $uploadDirectory . $filename . '.' . $ext;
		$ffinal = $uploadDirectory . $filename . '_' . $did . '.' . $ext;
		$fsave = $filename . '_' . $did . '.' . $ext;
        if ($this->file->save($forig)) {
			$img_size = getimagesize($forig);
			$x_size = $img_size[0];
			$y_size = $img_size[1];
			//echo $x_size . " " . $y_size;
			
			$w = number_format(800, 0, ',', '');
			$h = number_format(($y_size/$x_size)*800,0,',','');
			//exec(sprintf("convert %s -resize %dx%d -quality %d %s", $forig, $w, $h, '100', $ffinal));
			$dest = imagecreatetruecolor($w, $h);
			imageantialias($dest, TRUE);
			switch($ext) {
				case 'jpeg':
					$src = imagecreatefromjpeg($forig);
				break;
				case 'jpg':
					$src = imagecreatefromjpeg($forig);
				break;
				case 'png':
					$src = imagecreatefrompng($forig);
				break;
				case 'gif':
					$src = imagecreatefromgif($forig);
				break;
			}
			imagecopyresampled($dest, $src, 0, 0, 0, 0, $w, $h, $x_size , $y_size );
			
			switch($ext) {
				case 'jpeg':
					imagejpeg($dest, $ffinal, 80);
				break;
				case 'jpg':
					imagejpeg($dest, $ffinal, 80);
				break;
				case 'png':
					imagepng($dest, $ffinal, 8);
				break;
				case 'gif':
					imagegif($dest, $ffinal, 80);
				break;
			}
			
			unlink($forig);
			
			/*$q = "SELECT avatar FROM co_users_avatars WHERE uid='$did' and bin = '0'";
			$result = mysql_query($q, $this->_db->connection);
			if(mysql_num_rows($result) > 0) {
				$fold = mysql_result($result,0);
				if($fold != "") {
					unlink($uploadDirectory . $fold);	
				}
				$q = "DELETE FROM co_users_avatars WHERE uid='$did' and bin = '0'";
				$result = mysql_query($q, $this->_db->connection);
			}
			
			$now = gmdate("Y-m-d H:i:s");
			$q = "INSERT INTO co_users_avatars set avatar='$fsave', uid='$did'";
			$result = mysql_query($q, $this->_db->connection);
			$id = mysql_insert_id();*/

return array("success"=>true,"id"=>"$did","filename"=>"$fsave");
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
$result = $uploader->handleUpload(CO_PATH_BASE.'/data/sketches/');
// to pass data through iframe you will need to encode all html tags
echo htmlspecialchars($system->json_encode($result), ENT_NOQUOTES);
?>