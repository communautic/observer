<?php

class EmployeesDocumentsModel extends EmployeesModel {
	
	public function __construct() {  
		parent::__construct();
		$this->_contactsmodel = new ContactsModel();
	}

	
	function getList($id,$sort) {
		global $session;
	  if($sort == 0) {
		  $sortstatus = $this->getSortStatus("employees-documents-sort-status",$id);
		  if(!$sortstatus) {
				$order = "order by title";
				$sortcur = '1';
		  } else {
			  switch($sortstatus) {
				  case "1":
				  		$order = "order by title";
						$sortcur = '1';
				  break;
				  case "2":
				  		$order = "order by title DESC";
							$sortcur = '2';
				  break;
				  case "3":
				  		$sortorder = $this->getSortOrder("employees-documents-sort-order",$id);
				  		if(!$sortorder) {
								$order = "order by title";
								$sortcur = '1';
						  } else {
								$order = "order by field(id,$sortorder)";
								$sortcur = '3';
						  }
				  break;	
			  }
		  }
	  } else {
		  switch($sort) {
				  case "1":
				  		$order = "order by title";
						$sortcur = '1';
				  break;
				  case "2":
				  		$order = "order by title DESC";
						$sortcur = '2';
				  break;
				  case "3":
				  		$sortorder = $this->getSortOrder("employees-documents-sort-order",$id);
				  		if(!$sortorder) {
						  	$order = "order by title";
								$sortcur = '1';
						  } else {
								$order = "order by field(id,$sortorder)";
								$sortcur = '3';
						  }
				  break;	
			  }
		}
	  
		$perm = $this->getEmployeeAccess($id);
		$sql ="";
		if( $perm ==  "guest") {
			$sql = " and access = '1' ";
		}
	  
		$q = "select id,title,access,edited_date from " . CO_TBL_EMPLOYEES_DOCUMENTS_FOLDERS . " where pid = '$id' and bin != '1' " . $sql . $order;
		$this->setSortStatus("employees-documents-sort-status",$sortcur,$id);
		$result = mysql_query($q, $this->_db->connection);
		$items = mysql_num_rows($result);
		
		$documents = "";
		while ($row = mysql_fetch_array($result)) {
			foreach($row as $key => $val) {
				$array[$key] = $val;
			}
			
			// dates
			$array["edited_date"] = $this->_date->formatDate($array["edited_date"],CO_DATE_FORMAT);
			
			// access
			$accessstatus = "";
			if($perm !=  "guest") {
				if($array["access"] == 1) {
					$accessstatus = " module-access-active";
				}
			}
			$array["accessstatus"] = $accessstatus;
			
			$documents[] = new Lists($array);
	  }
		
	  $arr = array("documents" => $documents, "items" => $items, "sort" => $sortcur, "perm" => $perm);
	  return $arr;
	}


	function getNavNumItems($id) {
		$perm = $this->getEmployeeAccess($id);
		$sql ="";
		if( $perm ==  "guest") {
			$sql = " and access = '1' ";
		}
		$q = "select count(*) as items from " . CO_TBL_EMPLOYEES_DOCUMENTS_FOLDERS . " where pid = '$id' and bin != '1' " . $sql;
		$result = mysql_query($q, $this->_db->connection);
		$row = mysql_fetch_array($result);
		$items = $row['items'];
		return $items;
	}

   	function formatBytes($bytes, $precision = 2) {
		$units = array('B', 'KB', 'MB', 'GB', 'TB');
	  
		$bytes = max($bytes, 0);
		$pow = floor(($bytes ? log($bytes) : 0) / log(1024));
		$pow = min($pow, count($units) - 1);
	  
		$bytes /= pow(1024, $pow);
	  
		return round($bytes, $precision) . ' ' . $units[$pow];
	}


	function getDetails($id) {
		global $session, $contactsmodel, $lang;
		$q = "SELECT * FROM " . CO_TBL_EMPLOYEES_DOCUMENTS_FOLDERS . " where id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) < 1) {
			return false;
		}
		$row = mysql_fetch_array($result);
		foreach($row as $key => $val) {
				$array[$key] = $val;
			}
		
		//$array["filesize"] = $this->formatBytes($array["filesize"]);

		$array["created_date"] = $this->_date->formatDate($array["created_date"],CO_DATETIME_FORMAT);
		$array["edited_date"] = $this->_date->formatDate($array["edited_date"],CO_DATETIME_FORMAT);
		$array["created_user"] = $this->_users->getUserFullname($array["created_user"]);
		$array["edited_user"] = $this->_users->getUserFullname($array["edited_user"]);
		$array["current_user"] = $session->uid;
		//$array["num"] = $num;
		
		switch($array["access"]) {
			case "0":
				$array["access_text"] = $lang["GLOBAL_ACCESS_INTERNAL"];
				$array["access_footer"] = "";
			break;
			case "1":
				$array["access_text"] = $lang["GLOBAL_ACCESS_PUBLIC"];
				$array["access_user"] = $this->_users->getUserFullname($array["access_user"]);
				$array["access_date"] = $this->_date->formatDate($array["access_date"],CO_DATETIME_FORMAT);
				$array["access_footer"] = $lang["GLOBAL_ACCESS_FOOTER"] . " " . $array["access_user"] . ", " .$array["access_date"];
			break;
		}
		
		// get user perms
		//$array["edit"] = "1";
		
		$perms = $this->getEmployeeAccess($array["pid"]);
		$array["canedit"] = false;
		$array["perms"] = $perms;
		if($perms == "sysadmin" || $perms == "admin") {
			$array["canedit"] = true;
		}
		
		$document = new Lists($array);
		
		// now get all actual documents
		$doc = array();
		$qt = "SELECT * FROM " . CO_TBL_EMPLOYEES_DOCUMENTS . " where did = '$id' and bin='0' ORDER BY created_date DESC";
		$resultt = mysql_query($qt, $this->_db->connection);
		while($rowt = mysql_fetch_array($resultt)) {
			foreach($rowt as $key => $val) {
				$docs[$key] = $val;
			}
			if(empty($docs["tempname"])) {
				$docs["tempname"] = $docs["filename"];
			}
			
			$docs["filesize"] = $this->formatBytes($docs["filesize"]);
			$doc[] = new Lists($docs);
		}
		
		$sendto = $this->getSendtoDetails("employees_documents",$id);
		
		$arr = array("document" => $document, "doc" => $doc, "sendto" => $sendto, "access" => $perms);
		return $arr;
   }


   function setDetails($id,$title,$protocol,$document_access) {
		global $session;
		
		$now = gmdate("Y-m-d H:i:s");
		
		$access_date = "";
		if($document_access == 1) {
			$access_date = $now;
		}
		
		$q = "UPDATE " . CO_TBL_EMPLOYEES_DOCUMENTS_FOLDERS . " set title = '$title', protocol = '$protocol', access='$document_access', access_date='$access_date', access_user = '$session->uid', edited_user = '$session->uid', edited_date = '$now' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
			return $id;
		}
   }


   function createNew($id) {
		global $session, $lang;
		
		$now = gmdate("Y-m-d H:i:s");
		
		$q = "INSERT INTO " . CO_TBL_EMPLOYEES_DOCUMENTS_FOLDERS . " set title = '" . $lang["EMPLOYEE_DOCUMENT_NEW"] . "', pid='$id', created_user = '$session->uid', created_date = '$now', edited_user = '$session->uid', edited_date = '$now'";
		$result = mysql_query($q, $this->_db->connection);
		$id = mysql_insert_id();
		if ($result) {
			return $id;
		}
   }
	 
	function createDuplicate($id) {
		global $session, $lang;
		
		$now = gmdate("Y-m-d H:i:s");
		
		$q = "INSERT INTO " . CO_TBL_EMPLOYEES_DOCUMENTS_FOLDERS . " (pid,title,created_date,created_user,edited_date,edited_user) SELECT pid,CONCAT(title,' " . $lang["GLOBAL_DUPLICAT"]. "'),'$now','$session->uid','$now','$session->uid' FROM " . CO_TBL_EMPLOYEES_DOCUMENTS_FOLDERS . " where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		$id_new = mysql_insert_id();
		
		// documents
		$q = "SELECT filename,tempname,filesize FROM " . CO_TBL_EMPLOYEES_DOCUMENTS . " where did='$id' and bin='0'";
		$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
			$filename_old = $row['filename'];
			$pathinfo = pathinfo($row['filename']);
			$filename = $pathinfo['filename'];
			$ext = $pathinfo['extension'];
			$tempname = $row['tempname'];
			$filesize = $row['filesize'];

			// copy file
			$pattern = '/(.+)\(([0-9]+)\)$/';
			while (file_exists(CO_PATH_DOCUMENTS . $filename . '.' . $ext)) {
				if(preg_match( $pattern, $filename, $matches)) {
					$num = $matches[2]+1;
					$filename = $matches[1] . '(' . $num . ')';
				} else {
					$filename .= ' (1)';
				}
			}
			
			$fsave = $filename . '.' . $ext;
			
			if(empty($tempname)) {
				copy(CO_PATH_DOCUMENTS . $filename_old, CO_PATH_DOCUMENTS . $fsave);
			} else {
				copy(CO_PATH_DOCUMENTS . $tempname, CO_PATH_DOCUMENTS . $fsave);
			}
			
			$qt = "INSERT INTO " . CO_TBL_EMPLOYEES_DOCUMENTS . " set did='$id_new', filename='$fsave', filesize='$filesize'";
			$resultt = mysql_query($qt, $this->_db->connection);
		}
		
		if ($result) {
				return $id_new;
		}
	 }


   function binDocument($id) {
		global $session;
		$q = "UPDATE " . CO_TBL_EMPLOYEES_DOCUMENTS_FOLDERS . " set bin = '1', bintime = NOW(), binuser= '$session->uid' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }
   
   function restoreDocument($id) {
		$q = "UPDATE " . CO_TBL_EMPLOYEES_DOCUMENTS_FOLDERS . " set bin = '0' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
	}
	
	
	function deleteDocument($id) {
		$q = "SELECT id FROM " . CO_TBL_EMPLOYEES_DOCUMENTS . " where did = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
			$fid = $row["id"];
			$this->deleteFile($fid);
		}
		
		$q = "DELETE FROM co_log_sendto WHERE what='employees_documents' and whatid='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		$q = "DELETE FROM " . CO_TBL_EMPLOYEES_DOCUMENTS_FOLDERS . " where id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
		  	return true;
		}
	}


	function binDocItem($id) {
		global $session;
		$q = "UPDATE " . CO_TBL_EMPLOYEES_DOCUMENTS . " set bin = '1', bintime = NOW(), binuser= '$session->uid' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
	}
	
	/*function getBin($id) {
		$arr = "";
		$qd ="select id, title, bin, bintime, binuser from " . CO_TBL_EMPLOYEES_DOCUMENTS_FOLDERS . " where pid = '$id'";
						$resultd = mysql_query($qd, $this->_db->connection);
						while ($rowd = mysql_fetch_array($resultd)) {
							$did = $rowd["id"];
							if($rowd["bin"] == "1") { // deleted meeting
								foreach($rowd as $key => $val) {
									$documents_folder[$key] = $val;
								}
								$documents_folder["bintime"] = $this->_date->formatDate($documents_folder["bintime"],CO_DATETIME_FORMAT);
								$documents_folder["binuser"] = $this->_users->getUserFullname($documents_folder["binuser"]);
								$documents_folders[] = new Lists($documents_folder);
								$arr["documents_folders"] = $documents_folders;
							} else {
								// files
								$qf ="select id, filename, bin, bintime, binuser from " . CO_TBL_EMPLOYEES_DOCUMENTS . " where did = '$did'";
								$resultf = mysql_query($qf, $this->_db->connection);
								while ($rowf = mysql_fetch_array($resultf)) {
									if($rowf["bin"] == "1") { // deleted phases
										foreach($rowf as $key => $val) {
											$file[$key] = $val;
										}
										$file["bintime"] = $this->_date->formatDate($file["bintime"],CO_DATETIME_FORMAT);
										$file["binuser"] = $this->_users->getUserFullname($file["binuser"]);
										$files[] = new Lists($file);
										$arr["files"] = $files;
									}
								}
							}
						}
						return $arr;
						//echo "ss";
	}*/


	function restoreFile($id) {
		$q = "UPDATE " . CO_TBL_EMPLOYEES_DOCUMENTS . " set bin = '0' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
	}
	
	
	function deleteFile($id) {
		$q = "SELECT filename,tempname FROM " . CO_TBL_EMPLOYEES_DOCUMENTS . " where id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		$row = mysql_fetch_row($result);
		$filename = $row[0];
		$tempname = $row[1];
		
		if(empty($tempname)) {
			$tempname = $filename;
		}
		
		$file = CO_PATH_DOCUMENTS . "/" . $filename; 
		
		if(is_file($file)){
            @unlink($file);
        }
		
		$q = "DELETE FROM " . CO_TBL_EMPLOYEES_DOCUMENTS . " where id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
		  	return true;
		}
	}

	function getDocumentsDialog($request,$field,$append,$title,$sql,$id) {
		global $session;
		
		$documents = "";
		
		$array["field"] = $field;
		$q = "select id, title from " . CO_TBL_EMPLOYEES_DOCUMENTS_FOLDERS . " where pid='$id' and bin = '0' order by title";
		$result = mysql_query($q, $this->_db->connection);
	  	while ($row = mysql_fetch_array($result)) {
			foreach($row as $key => $val) {
				$array[$key] = $val;
			}
			$documents[] = new Lists($array); 
	  }
	  return $documents;
	}


   function getDocListFromIDs($string,$field){
		global $session;
		
		$string = explode(",", $string);
		$total = sizeof($string);
		$users = '';
		
		if($total == 0) { 
			return $users; 
		}
		
		$arr = array();
		
		//$sql = "and access='1'";
		/*if($session->isSysadmin() || $session->isAdmin()) {
			$sql = "";
		}*/
		foreach ($string as &$value) {
			$q = "SELECT id, title FROM " . CO_TBL_EMPLOYEES_DOCUMENTS_FOLDERS . " where id = '$value' and bin='0'";
			$result = mysql_query($q, $this->_db->connection);
			if(mysql_num_rows($result) > 0) {
				while($row = mysql_fetch_assoc($result)) {
					$arr[$row["id"]] = $row["title"];		
				}
			}
		}
		$arr_total = sizeof($arr);
		
		// build string
		$i = 1;
		foreach ($arr as $key => &$value) {
			$users .= '<span class="docitems-outer"><a href="employees_documents" class="showItemContext" uid="' . $key . '" field="' . $field . '">' . $value;		
			if($i < $arr_total) {
				$users .= ', ';
			}
			$users .= '</a></span>';	
			$i++;
		}
		return $users;
	}


	function getDocContext($id,$field){
		$q = "SELECT id,title FROM " . CO_TBL_EMPLOYEES_DOCUMENTS_FOLDERS . " where id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		$row = mysql_fetch_array($result);
		foreach($row as $key => $val) {
			$array[$key] = $val;
		}
		
		$array["field"] = $field;
		
		$document = new Lists($array); 
		
		$doc = array();
		$qt = "SELECT * FROM " . CO_TBL_EMPLOYEES_DOCUMENTS . " where did = '$id' and bin='0' ORDER BY created_date DESC";
		$resultt = mysql_query($qt, $this->_db->connection);
		while($rowt = mysql_fetch_array($resultt)) {
			foreach($rowt as $key => $val) {
				$docs[$key] = $val;
			}

			$docs["filesize"] = $this->formatBytes($docs["filesize"]);
			$doc[] = new Lists($docs);
		}
		
		$arr = array("document" => $document, "doc" => $doc);
		return $arr;
	}


	function downloadDocument($id) {
		$q = "SELECT * FROM " . CO_TBL_EMPLOYEES_DOCUMENTS . " where id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		$row = mysql_fetch_assoc($result);
		$filename = $row["filename"];
		$tempname = $row["tempname"];
		if(empty($tempname)) {
			$tempname = $filename;
		}
		
		$fullPath = CO_PATH_DOCUMENTS.$tempname;
		$filePath = CO_PATH_DOCUMENTS.$filename;
		

		if ($fd = fopen ($fullPath, "rb")) {
			$fsize = filesize($fullPath);
			$path_parts = pathinfo($filePath); 
			$ext = strtolower($path_parts["extension"]); 
			switch ($ext) {
				case "png":
				case "bmp":
				case "gif":
				header("Content-type: image/".$ext.""); 
				header("Content-Disposition: attachment; filename=\"".$filename."\"");
				break;
				case "jpg":
				case "jpeg":
				header("Content-type: image/jpeg"); 
				header("Content-Disposition: attachment; filename=\"".$filename."\"");
				break;
				case "pdf":
				header("Content-type: application/pdf");
				header("Content-Disposition: attachment; filename=\"".$filename."\""); 
				break;
				case "zip":
				header("Content-type: application/zip"); 
				header("Content-Disposition: filename=\"".$filename."\"");
				break;
				default;
				header("Content-type: application/octet-stream");
				header("Content-Disposition: filename=\"".$filename."\"");
			}
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
		}
	}
?>