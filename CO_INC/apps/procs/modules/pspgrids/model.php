<?php

class ProcsPspgridsModel extends ProcsModel {
	
	public function __construct() {  
     	parent::__construct();
		//$this->_phases = new ProcsPhasesModel();
		$this->_contactsmodel = new ContactsModel();
	}


	function getList($id,$sort) {
		global $session;
	  if($sort == 0) {
		  $sortstatus = $this->getSortStatus("procs-pspgrids-sort-status",$id);
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
				  		$sortorder = $this->getSortOrder("procs-pspgrids-sort-order",$id);
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
				  		$sortorder = $this->getSortOrder("procs-pspgrids-sort-order",$id);
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
	  
	  
		$perm = $this->getProcAccess($id);
		$sql ="";
		if( $perm ==  "guest") {
			$sql = " and access = '1' ";
		}
		
		$q = "select id,title,access,checked_out,checked_out_user from " . CO_TBL_PROCS_PSPGRIDS . " where pid = '$id' and bin != '1' " . $sql . $order;
		$this->setSortStatus("procs-pspgrids-sort-status",$sortcur,$id);
		$result = mysql_query($q, $this->_db->connection);
		$items = mysql_num_rows($result);
		
		$pspgrids = "";
		while ($row = mysql_fetch_array($result)) {

		foreach($row as $key => $val) {
				$array[$key] = $val;
			}
					
			$checked_out_status = "";
			if($perm !=  "guest" && $array["checked_out"] == 1 && $array["checked_out_user"] != $session->uid) {
				if($session->checkUserActive($array["checked_out_user"])) {
					$checked_out_status = "icon-checked-out-active";
				} else {
					$this->checkinPspgridOverride($id);
				}
			}
			
			// access
			$accessstatus = "";
			if($perm !=  "guest") {
				if($array["access"] == 1) {
					$accessstatus = " module-access-active";
				}
			}
			$array["accessstatus"] = $accessstatus;
			
			$array["checked_out_status"] = $checked_out_status;
			
			
			$pspgrids[] = new Lists($array);
	  }
		
	  $arr = array("pspgrids" => $pspgrids, "items" => $items, "sort" => $sortcur, "perm" => $perm);
	  return $arr;
	}
	
	function checkoutPspgrid($id) {
		global $session;
		
		$q = "UPDATE " . CO_TBL_PROCS_PSPGRIDS . " set checked_out = '1', checked_out_user = '$session->uid' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
			return true;
		}
	}
	
	
	function getNavNumItems($id) {
		$perm = $this->getProcAccess($id);
		$sql ="";
		if( $perm ==  "guest") {
			$sql = " and access = '1' ";
		}
		$q = "select count(*) as items from " . CO_TBL_PROCS_PSPGRIDS . " where pid = '$id' and bin != '1' " . $sql;
		$result = mysql_query($q, $this->_db->connection);
		$row = mysql_fetch_array($result);
		$items = $row['items'];
		/*if($items == 0) {
			$items = "";
		}*/
		return $items;
	}
	
	function checkinPspgrid($id) {
		global $session;
		
		$q = "SELECT checked_out_user FROM " . CO_TBL_PROCS_PSPGRIDS . " where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		$user = mysql_result($result,0);

		if($user == $session->uid) {
			$q = "UPDATE " . CO_TBL_PROCS_PSPGRIDS . " set checked_out = '0', checked_out_user = '0' where id='$id'";
			$result = mysql_query($q, $this->_db->connection);
		}
		if ($result) {
			return true;
		}
	}
	
	function checkinPspgridOverride($id) {
		global $session;
		$q = "UPDATE " . CO_TBL_PROCS_PSPGRIDS . " set checked_out = '0', checked_out_user = '0' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
	}
	

	function getDetails($id) {
		global $session, $contactsmodel, $lang;
		
		$q = "SELECT * FROM " . CO_TBL_PROCS_PSPGRIDS . " where id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) < 1) {
			return false;
		}
		$row = mysql_fetch_array($result);
		foreach($row as $key => $val) {
			$array[$key] = $val;
		}
			
		$array["perms"] = $this->getProcAccess($array["pid"]);
		$array["canedit"] = false;
		$array["showCheckout"] = false;
		$array["checked_out_user_text"] = $this->_contactsmodel->getUserListPlain($array['checked_out_user']);

		if($array["perms"] == "sysadmin" || $array["perms"] == "admin") {
			//if($array["checked_out"] == 1 && $session->checkUserActive($array["checked_out_user"])) {
			if($array["checked_out"] == 1) {
				if($array["checked_out_user"] == $session->uid) {
					$array["canedit"] = true;
				} else if(!$session->checkUserActive($array["checked_out_user"])) {
					$array["canedit"] = $this->checkoutPspgrid($id);
					$array["canedit"] = true;
				} else {
					$array["canedit"] = false;
					$array["showCheckout"] = true;
		$array["checked_out_user_phone1"] = $this->_contactsmodel->getContactFieldFromID($array['checked_out_user'],"phone1");
		$array["checked_out_user_email"] = $this->_contactsmodel->getContactFieldFromID($array['checked_out_user'],"email");

				}
			} else {
				$array["canedit"] = $this->checkoutPspgrid($id);
			}
		}
		$array["owner_print"] = $contactsmodel->getUserListPlain($array['owner']);
		$array["owner_convert"] = $array['owner'];
		$array["owner"] = $contactsmodel->getUserList($array['owner'],'procpspgridowner', "", $array["canedit"]);
		$array["owner_ct_convert"] = $array['owner_ct'];
		$array["owner_ct"] = empty($array["owner_ct"]) ? "" : $lang["TEXT_NOTE"] . " " . $array['owner_ct'];
		$array["management_print"] = $contactsmodel->getUserListPlain($array['management']);
		$array["management_convert"] = $array['management'];
		$array["management"] = $contactsmodel->getUserList($array['management'],'procpspgridmanagement', "", $array["canedit"]);
		$array["management_ct_convert"] = $array['management_ct'];
		$array["management_ct"] = empty($array["management_ct"]) ? "" : $lang["TEXT_NOTE"] . " " . $array['management_ct'];
		$array["team_print"] = $contactsmodel->getUserListPlain($array['team']);
		if($option = 'prepareSendTo') {
			$array["sendtoTeam"] = $contactsmodel->checkUserListEmail($array["team"],'projectsteam', "", $array["canedit"]);
			$array["sendtoTeamNoEmail"] = $contactsmodel->checkUserListEmail($array["team"],'projectsteam', "", $array["canedit"], 0);
			$array["sendtoError"] = false;
		}
		$array["team_convert"] = $array['team'];
		$array["team"] = $contactsmodel->getUserList($array['team'],'procpspgridteam', "", $array["canedit"]);
		$array["team_ct_convert"] = $array['team_ct'];
		$array["team_ct"] = empty($array["team_ct"]) ? "" : $lang["TEXT_NOTE"] . " " . $array['team_ct'];
				
		$array["created_date"] = $this->_date->formatDate($array["created_date"],CO_DATETIME_FORMAT);
		$array["edited_date"] = $this->_date->formatDate($array["edited_date"],CO_DATETIME_FORMAT);
		$array["created_user"] = $this->_users->getUserFullname($array["created_user"]);
		$array["edited_user"] = $this->_users->getUserFullname($array["edited_user"]);
		$array["current_user"] = $session->uid;
		$array["today"] = $this->_date->formatDate("now",CO_DATETIME_FORMAT);
		
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
		
		// build cols and notes
		$cols = array();
		$num_notes = array('0');
		$q = "SELECT * FROM " . CO_TBL_PROCS_PSPGRIDS_COLUMNS . " where pid = '$id' and bin='0' ORDER BY sort";
		$result = mysql_query($q, $this->_db->connection);
		$days = 0;
		$tdays = 0;
		$tcosts = 0;
		while($row = mysql_fetch_object($result)) {
			$colID = $row->id;
			$coldays = $row->days;
			$days += $coldays;
			$titleid = 0;
			$titletext = '';
			$titletextcontent = '';
			$titleteam_convert = '';
			$titleteam = '';
			$titleteamprint = '';
			$titleteam_ct = '';
			$titledays = 0;
			$titlecosts_employees = 0;
			$titlecosts_materials = 0;
			$titlecosts_external = 0;
			$titlecosts_other = 0;
			$titlecosts_total = 0;
			$qn = "SELECT * FROM " . CO_TBL_PROCS_PSPGRIDS_NOTES . " where cid = '$colID' and bin='0' ORDER BY sort";
			$resultn = mysql_query($qn, $this->_db->connection);
			$items = array();
			$n = 0;
			$nchecked = 0;
			$costs = 0;
			$days = 0;
			while($rown = mysql_fetch_object($resultn)) {
				if($rown->istitle == 1) {
					$titleid = $rown->id;
					$titletext = $rown->title;
					$titletextcontent = $rown->text;
					$titleteam_convert =  $rown->team;
					$titleteamprint =  $contactsmodel->getUserListPlain($rown->team);
					$titleteam = $contactsmodel->getUserList($rown->team,'coPopup-team', "", '1');
					$titleteam_ct = $rown->team_ct;
					$titledays = $rown->days;
					$titlecosts_employees = $rown->costs_employees;
					$titlecosts_materials = $rown->costs_materials;
					$titlecosts_external = $rown->costs_external;
					$titlecosts_other = $rown->costs_other;
					$titlecosts_total = $rown->costs_employees + $rown->costs_materials + $rown->costs_external + $rown->costs_other;
				} else {
					$items[] = array(
						"note_id" => $rown->id,
						"milestone" => $rown->isstagegate,
						"title" => $rown->title,
						"text" => $rown->text,
						"status" => $rown->status,
						"team_convert" => $rown->team,
						"teamprint" => $contactsmodel->getUserListPlain($rown->team),
						"team" => $contactsmodel->getUserList($rown->team,'coPopup-team', "", '1'),
						"team_ct" => $rown->team_ct,
						"days" => $rown->days,
						"costs_employees" => $rown->costs_employees,
						"costs_materials" => $rown->costs_materials,
						"costs_external" => $rown->costs_external,
						"costs_other" => $rown->costs_other,
						"itemcosts" => $rown->costs_employees + $rown->costs_materials + $rown->costs_external + $rown->costs_other,
					);
					if($rown->isstagegate == 0) {
						$costs += $rown->costs_employees + $rown->costs_materials + $rown->costs_external + $rown->costs_other;
						$tcosts += $rown->costs_employees + $rown->costs_materials + $rown->costs_external + $rown->costs_other;
						$days += $rown->days;
						$tdays += $rown->days;
					}
					if($rown->status > 0) {
						$nchecked += $rown->status;
					}
					$n++;
				}
			}
			$num_notes[] = $n;
			
			//$colheight=  $n*85+78+70+8+4+25;
			$colheight=  $n*85+85+105;
			if($colheight < 158+8+4) {
				$colheight = 158+8+4;
			}
			$listheight = $n*85;
			/*if($listheight < 85) {
				$listheight = 85;
			}*/
			
			if($n == 0 && $titleid == 0) {
				$colstatus = 'planned';
			}
			if(($n > 0 || $titleid > 0) && $nchecked == 0) {
				$colstatus = 'planned';
			}
			if($nchecked > 0 && $nchecked < $n*2 ) {
				$colstatus = 'progress';
			}
			if($n != 0 && $n*2 == $nchecked) {
				$colstatus = 'finished';
			}
			$cols[]= array(
				"id" => $colID,
				"status" => $colstatus,
				"colheight" => $colheight,
				"listheight" => $listheight,
				"coldays" => $coldays,
				"titleid" => $titleid,
				"titletext" => $titletext,
				"titletextcontent" => $titletextcontent,
				"titleteam_convert" => $titleteam_convert,
				"titleteamprint" => $titleteamprint,
				"titleteam" => $titleteam,
				"titleteam_ct" => $titleteam_ct,
				"titledays" => $titledays,
				"titlecosts_employees" => $titlecosts_employees,
				"titlecosts_materials" => $titlecosts_materials,
				"titlecosts_external" => $titlecosts_external,
				"titlecosts_other" => $titlecosts_other,
				"titlecosts_total" => $titlecosts_total,
				"notes" => $items,
				"days" => $days,
				"costs" => $costs
			);
		}
		
		$array["max_items"] = max($num_notes);
		$array["tdays"] = $tdays;
		$array["tcosts"] = $tcosts;
		
		//$colheight=  max($num_notes)*85+78+70+8;
		$colheight=  max($num_notes)*85+85+105;
		if($colheight < 158+8) {
			$colheight = 158+8;
		}
		$listheight = max($num_notes)*85;
		/*if($listheight < 85) {
			$listheight = 85;
		}*/
		
		// build the console
		$console_items = array();
		$pid = $array["pid"];
		$qc = "SELECT * FROM " . CO_TBL_PROCS_NOTES . " where pid = '$pid' and shape<'10' and bin='0' ORDER BY title ASC";
		$resultc = mysql_query($qc, $this->_db->connection);
		while($rowc = mysql_fetch_object($resultc)) {
				$console_items[] = array(
				"id" => $rowc->id,
				"title" => $rowc->title,
				"text" => $rowc->text
			);
		}
		
		$sendto = $this->getSendtoDetails("procs_pspgrids",$id);
		
		$array["pspgrid_width"] = sizeof($cols)*195;
		$array["pspgrid_days"] = $days;
		
		$pspgrid = new Lists($array);
		
		// get created projects
		$ql = "SELECT * FROM co_procs_pspgrids_log where rid = '$id' ORDER BY created_date DESC";
		$resultl = mysql_query($ql, $this->_db->connection);
		
		$projectsmodel = new ProjectsModel();
		
		$projects = array();
		while($rowl = mysql_fetch_array($resultl)) {
			$projects[]= array(
				"fid" => $projectsmodel->getProjectFolderDetails($rowl['fid'],'title'),
				"pid" => $rowl['pid'],
				"created_date" => $this->_date->formatDate($rowl["created_date"],CO_DATETIME_FORMAT),
				"created_user" => $this->_users->getUserFullname($rowl["created_user"])
			);
		}
		
		$arr = array("pspgrid" => $pspgrid, "cols" => $cols, "colheight" => $colheight, "listheight" => $listheight, "console_items" => $console_items, "sendto" => $sendto, "access" => $array["perms"], "projects" => $projects);
		return $arr;
   }


   function setDetails($pid,$id,$title,$owner,$owner_ct,$management,$management_ct,$team,$team_ct,$pspgrid_access,$pspgrid_access_orig) {
		global $session, $contactsmodel, $lang;

		$now = gmdate("Y-m-d H:i:s");
		
		if($pspgrid_access == $pspgrid_access_orig) {
			$accesssql = "";
		} else {
			$pspgrid_access_date = "";
			if($pspgrid_access == 1) {
				$pspgrid_access_date = $now;
			}
			$accesssql = "access='$pspgrid_access', access_date='$pspgrid_access_date', access_user = '$session->uid',";
		}
		
		$owner = $contactsmodel->sortUserIDsByName($owner);
		$management = $contactsmodel->sortUserIDsByName($management);
		$team = $contactsmodel->sortUserIDsByName($team);
		
		$q = "UPDATE " . CO_TBL_PROCS_PSPGRIDS . " set title = '$title', owner = '$owner', owner_ct = '$owner_ct', management = '$management', management_ct = '$management_ct', team = '$team', team_ct = '$team_ct', $accesssql edited_user = '$session->uid', edited_date = '$now' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);

		if ($result) {
		$arr = array("id" => $id, "what" => "edit");
		}

		return $arr;
   }


   function savePspgridColumns($cols) {
		foreach($cols as $key => $val) {
			$q = "UPDATE " . CO_TBL_PROCS_PSPGRIDS_COLUMNS . " set sort = '$key' WHERE id='$val'";
			$result = mysql_query($q, $this->_db->connection);
		}
		return "true";
   }


   function savePspgridColDays($id,$days) {
			$q = "UPDATE " . CO_TBL_PROCS_PSPGRIDS_COLUMNS . " set days = '$days' WHERE id='$id'";
			$result = mysql_query($q, $this->_db->connection);
		return "true";
   }

   function newPspgridColumn($id,$sort) {
		$q = "INSERT INTO " . CO_TBL_PROCS_PSPGRIDS_COLUMNS . " set pid = '$id',sort = '$sort'";
		$result = mysql_query($q, $this->_db->connection);
		$cid = mysql_insert_id();
		
		//$this->savePspgridNewManualTitle($id,$cid);
		//$this->savePspgridNewManualNote($id,$cid);
		
		if ($result) {
			return $cid;
		}
   }
   
   function binPspgridColumn($id) {
		global $session;
		$now = gmdate("Y-m-d H:i:s");
		$q = "UPDATE " . CO_TBL_PROCS_PSPGRIDS_COLUMNS . " set bin = '1', bintime = '$now', binuser= '$session->uid' WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return "true";
		}
   }

   function savePspgridItems($col,$items) {
		$it = "";
		foreach($items as $key => $id) {
			$q = "UPDATE " . CO_TBL_PROCS_PSPGRIDS_NOTES . " set istitle = '0', isstagegate = '0', cid = '$col', sort = '$key' WHERE id='$id'";
			$result = mysql_query($q, $this->_db->connection);
		}
		return "true";
   }
   
   
   function getPspgridNote($id) {
	   global $session, $contactsmodel, $lang;
	   
		$q = "SELECT * FROM " . CO_TBL_PROCS_PSPGRIDS_NOTES . " where id='$id'";		
		$result = mysql_query($q, $this->_db->connection);
		
		while($row = mysql_fetch_array($result)) {
			$n["id"] = $row["id"];
			$n["title"] = $row["title"];
			$n["text"] = nl2br($row["text"]);
			
			//$n["ms"] = $row["ms"];
						// dates
			$n["created_date"] = $this->_date->formatDate($row["created_date"],CO_DATETIME_FORMAT);
			$n["edited_date"] = $this->_date->formatDate($row["edited_date"],CO_DATETIME_FORMAT);
			
			// other functions
			$n["created_user"] = $this->_users->getUserFullname($row["created_user"]);
			$n["edited_user"] = $this->_users->getUserFullname($row["edited_user"]);
		}

		$note = new Lists($n);

		return $note;
	}   

   
   function savePspgridNewNote($pid,$id) {
		global $session, $contactsmodel, $lang;
		$now = gmdate("Y-m-d H:i:s");
		$q = "SELECT title,text FROM " . CO_TBL_PROCS_NOTES . " where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		$row = mysql_fetch_row($result);
		$title = mysql_real_escape_string($row[0]);
		$text = mysql_real_escape_string($row[1]);
		
		$q = "INSERT INTO " . CO_TBL_PROCS_PSPGRIDS_NOTES . " set pid = '$pid', title = '$title', text = '$text', created_user = '$session->uid', created_date = '$now', edited_user = '$session->uid', edited_date = '$now'";		
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			$id = mysql_insert_id();
			return $id;
		}
	}	


   function savePspgridNewNoteTitle($pid,$id,$col) {
		global $session, $contactsmodel, $lang;
		$now = gmdate("Y-m-d H:i:s");
		$q = "SELECT title,text FROM " . CO_TBL_PROCS_NOTES . " where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		$row = mysql_fetch_row($result);
		$title = mysql_real_escape_string($row[0]);
		$text = mysql_real_escape_string($row[1]);
		
		$q = "INSERT INTO " . CO_TBL_PROCS_PSPGRIDS_NOTES . " set pid = '$pid', cid = '$col', istitle = '1', isstagegate = '0', title = '$title', text = '$text', created_user = '$session->uid', created_date = '$now', edited_user = '$session->uid', edited_date = '$now'";		
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			$id = mysql_insert_id();
			return $id;
		}
	}	


   function savePspgridNoteTitle($id,$col) {
		global $session;
		$now = gmdate("Y-m-d H:i:s");
		
		$q = "UPDATE " . CO_TBL_PROCS_PSPGRIDS_NOTES . " set cid = '$col', istitle = '1', isstagegate = '0', edited_user = '$session->uid', edited_date = '$now' WHERE id = '$id'";		
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return $id;
		}
	}




   function savePspgridNewNoteStagegate($pid,$id,$col) {
		global $session, $contactsmodel, $lang;
		$now = gmdate("Y-m-d H:i:s");
		$q = "SELECT title,text FROM " . CO_TBL_PROCS_NOTES . " where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		$row = mysql_fetch_row($result);
		$title = mysql_real_escape_string($row[0]);
		$text = mysql_real_escape_string($row[1]);
		
		$q = "INSERT INTO " . CO_TBL_PROCS_PSPGRIDS_NOTES . " set pid = '$pid', cid = '$col', istitle = '0', isstagegate = '1', title = '$title', text = '$text', created_user = '$session->uid', created_date = '$now', edited_user = '$session->uid', edited_date = '$now'";		
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			$id = mysql_insert_id();
			return $id;
		}
	}	


   function savePspgridNewManualNote($pid,$cid=0) {
		global $session, $lang;
		$now = gmdate("Y-m-d H:i:s");
		$q = "INSERT INTO " . CO_TBL_PROCS_PSPGRIDS_NOTES . " set pid = '$pid', cid = '$cid', title='" . $lang["PROC_PSPGRID_ITEM_NEW"]. "', created_user = '$session->uid', created_date = '$now', edited_user = '$session->uid', edited_date = '$now'";		
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			$id = mysql_insert_id();
			return $id;
		}
	}

   function savePspgridNewManualTitle($pid,$col) {
		global $session, $lang;
		$now = gmdate("Y-m-d H:i:s");
		$q = "INSERT INTO " . CO_TBL_PROCS_PSPGRIDS_NOTES . " set pid = '$pid', cid='$col', istitle = '1', title='" . $lang["PROC_PSPGRID_TITLE_NEW"]. "', created_user = '$session->uid', created_date = '$now', edited_user = '$session->uid', edited_date = '$now'";		
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			$id = mysql_insert_id();
			return $id;
		}
	}

   function savePspgridNote($id,$title,$team,$team_ct,$text,$days,$costs_employees,$costs_materials,$costs_external,$costs_other) {
		global $session;
		$now = gmdate("Y-m-d H:i:s");
		$q = "UPDATE " . CO_TBL_PROCS_PSPGRIDS_NOTES . " set title = '$title', team = '$team', team_ct = '$team_ct', text = '$text', days='$days',  costs_employees='$costs_employees', costs_materials='$costs_materials', costs_external='$costs_external', costs_other='$costs_other', edited_user = '$session->uid', edited_date = '$now' WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}

	}

	function createNew($id) {
		global $session, $lang;
		
		$now = gmdate("Y-m-d H:i:s");
		$time = gmdate("Y-m-d H");
		
		$q = "INSERT INTO " . CO_TBL_PROCS_PSPGRIDS . " set title = '" . $lang["PROC_PSPGRID_NEW"] . "', pid = '$id', created_user = '$session->uid', created_date = '$now', edited_user = '$session->uid', edited_date = '$now'";
		$result = mysql_query($q, $this->_db->connection);
		$id = mysql_insert_id();
		
		//$task = $this->addTask($id,0,0);
		$this->newPspgridColumn($id,0);
		$this->newPspgridColumn($id,1);
		$this->newPspgridColumn($id,2);
		/*$this->newPspgridColumn($id,3);
		$this->newPspgridColumn($id,4);*/
		
		if ($result) {
			return $id;
		}
	}
   

	function createDuplicate($id) {
		global $session, $lang;
		
		$now = gmdate("Y-m-d H:i:s");
		
		// pspgrid
		$q = "INSERT INTO " . CO_TBL_PROCS_PSPGRIDS . " (pid,title,owner,owner_ct,management,management_ct,team,team_ct,created_date,created_user,edited_date,edited_user) SELECT pid,CONCAT(title,' " . $lang["GLOBAL_DUPLICAT"] . "'),owner,owner_ct,management,management_ct,team,team_ct,'$now','$session->uid','$now','$session->uid' FROM " . CO_TBL_PROCS_PSPGRIDS . " where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		$id_new = mysql_insert_id();
		// cols
		
		$q = "SELECT * FROM " . CO_TBL_PROCS_PSPGRIDS_COLUMNS . " WHERE pid = '$id' and bin='0'";
		$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
			$colID = $row["id"];
			$sort = $row['sort'];
			$days = $row['days'];
			$qc = "INSERT INTO " . CO_TBL_PROCS_PSPGRIDS_COLUMNS . " set pid = '$id_new', sort='$sort', days='$days'";
			$resultc = mysql_query($qc, $this->_db->connection);
			$colID_new = mysql_insert_id();
			
			$qn = "SELECT * FROM " . CO_TBL_PROCS_PSPGRIDS_NOTES . " where cid = '$colID' and bin='0'";
			$resultn = mysql_query($qn, $this->_db->connection);
			$num_notes[] = mysql_num_rows($resultn);
			$items = array();
			while($rown = mysql_fetch_array($resultn)) {
				$note_id = $rown["id"];
				$sort = $rown["sort"];
				$istitle = $rown["istitle"];
				$isstagegate = $rown["isstagegate"];
				$title = mysql_real_escape_string($rown["title"]);
				$text = mysql_real_escape_string($rown["text"]);
				$days = $rown["days"];
				$costs_employees = $rown["costs_employees"];
				$costs_materials = $rown["costs_materials"];
				$costs_external = $rown["costs_external"];
				$costs_other = $rown["costs_other"];
				//$ms = $rown["ms"];
				$qnn = "INSERT INTO " . CO_TBL_PROCS_PSPGRIDS_NOTES . " set cid='$colID_new', sort = '$sort', istitle = '$istitle', isstagegate = '$isstagegate', title = '$title', text = '$text', days = '$days', costs_employees ='$costs_employees', costs_materials = '$costs_materials', costs_external = '$costs_external', costs_other  = '$costs_other', created_date='$now',created_user='$session->uid',edited_date='$now',edited_user='$session->uid'";
				$resultnn = mysql_query($qnn, $this->_db->connection);
			}
		}
		if ($result) {
			return $id_new;
		}
	}


   function binPspgrid($id) {
		global $session;
		$q = "UPDATE " . CO_TBL_PROCS_PSPGRIDS . " set bin = '1', bintime = NOW(), binuser= '$session->uid' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }
   
   function restorePspgrid($id) {
		$q = "UPDATE " . CO_TBL_PROCS_PSPGRIDS . " set bin = '0' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }
   
   function deletePspgrid($id) {
		$q = "DELETE FROM " . CO_TBL_PROCS_PSPGRIDS_NOTES . " WHERE pid = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		$q = "DELETE FROM " . CO_TBL_PROCS_PSPGRIDS_COLUMNS . " WHERE pid='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		/*$q = "DELETE FROM co_log_sendto WHERE what='pspgrids' and whatid='$id'";
		$result = mysql_query($q, $this->_db->connection);*/
		
		$q = "DELETE FROM " . CO_TBL_PROCS_PSPGRIDS . " WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }
   
   
   function restorePspgridColumn($id) {
		$q = "UPDATE " . CO_TBL_PROCS_PSPGRIDS_COLUMNS . " set bin = '0' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }
   
   function deletePspgridColumn($id) {
		
		$q = "DELETE FROM " . CO_TBL_PROCS_PSPGRIDS_NOTES . " WHERE cid = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		/*$q = "DELETE FROM co_log_sendto WHERE what='pspgrids' and whatid='$id'";
		$result = mysql_query($q, $this->_db->connection);*/
		
		$q = "DELETE FROM " . CO_TBL_PROCS_PSPGRIDS_COLUMNS . " WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }


   function toggleIntern($id,$status) {
		global $session;
		$q = "UPDATE " . CO_TBL_PROCS_PSPGRIDS . " set intern = '$status' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }


   function addTask($mid,$num,$sort) {
		global $session, $lang;
		
		$q = "INSERT INTO " . CO_TBL_PROCS_PSPGRIDS_TASKS . " set mid='$mid', status = '0', title = '" . $lang["PROC_PSPGRID_TASK_NEW"] . "', sort='$sort'";
		$result = mysql_query($q, $this->_db->connection);
		$id = mysql_insert_id();
		
		$task = array();
		$q = "SELECT * FROM " . CO_TBL_PROCS_PSPGRIDS_TASKS . " where id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
			foreach($row as $key => $val) {
				$tasks[$key] = $val;
			}
			$task[] = new Lists($tasks);
		}
		
		  	return $task;
   }


   function binItem($id) {
		global $session;
		$q = "UPDATE " . CO_TBL_PROCS_PSPGRIDS_NOTES . " set bin = '1', bintime = NOW(), binuser= '$session->uid' WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if($result) {
			return true;
		}
   }
   
   	function setItemStatus($id,$status) {
		$q = "UPDATE " . CO_TBL_PROCS_PSPGRIDS_NOTES . " set status = '$status' WHERE id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		if($result) {
			return true;
		}
	}
	
   	function setItemType($id,$type) {
		$q = "UPDATE " . CO_TBL_PROCS_PSPGRIDS_NOTES . " set isstagegate = '$type' WHERE id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		if($result) {
			return true;
		}
	}
   
   function restorePspgridTask($id) {
		global $session;
		$q = "UPDATE " . CO_TBL_PROCS_PSPGRIDS_NOTES . " set bin = '0' WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if($result) {
			return true;
		}
   }
   
   function deletePspgridTask($id) {
		global $session;
		$q = "DELETE FROM " . CO_TBL_PROCS_PSPGRIDS_NOTES . " WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if($result) {
			return true;
		}
   }
   
   function convertToProject($id,$kickoff,$folder,$protocol) {
		global $session, $contactsmodel, $lang;
		
		// get pspgrid details
		$arr = $this->getDetails($id);
		$pspgrid = $arr["pspgrid"];
		$cols = $arr["cols"];
		$proc_id = $pspgrid->pid;
		
		$now = gmdate("Y-m-d H:i:s");
		$title = mysql_real_escape_string($pspgrid->title);
		// create project
		$q = "INSERT INTO " . CO_TBL_PROJECTS . " set folder = '$folder', title = '$title', setting_costs = '1', ordered_by = '$pspgrid->owner_convert', ordered_by_ct = '$pspgrid->owner_ct_convert', management = '$pspgrid->management_convert', management_ct = '$pspgrid->management_ct_convert', team = '$pspgrid->team_convert', team_ct = '$pspgrid->team_ct_convert', protocol = '$protocol', startdate = '$kickoff', enddate = '$kickoff', status = '0', planned_date = '$now', created_user = '$session->uid', created_date = '$now', edited_user = '$session->uid', edited_date = '$now'";
		$result = mysql_query($q, $this->_db->connection);
		$pid = mysql_insert_id();
		// if admin insert him to access
		// copy all access 
		$qa = "SELECT * FROM co_procs_access where pid='$proc_id'";
		$resulta = mysql_query($qa, $this->_db->connection);
		while($rowa = mysql_fetch_array($resulta)) {
			$admins = $rowa["admins"];
			$guests = $rowa["guests"];
			$qab = "INSERT INTO co_projects_access set pid = '$pid', admins = '$admins', guests = '$guests', created_user = '$session->uid', created_date = '$now', edited_user = '$session->uid', edited_date = '$now'";
			$resultab = mysql_query($qab, $this->_db->connection);
   		}
		
		
		// loop through cols
		$datecalc = $kickoff;
		$dependent = 0;
		foreach($cols as $key => &$value){ 
			//$i = 0;
			$num_notes = sizeof($cols[$key]["notes"]);
			
			// write title
			if($cols[$key]['titletext'] != "") {
				$phasetitle = mysql_real_escape_string($cols[$key]['titletext']);
				$phasetext = mysql_real_escape_string($cols[$key]['titletextcontent']);
				$phaseteam = $cols[$key]['titleteam_convert'];
				$q = "INSERT INTO " . CO_TBL_PROJECTS_PHASES . " set title = '$phasetitle', pid='$pid', team = '$phaseteam', team_ct = '', protocol='$phasetext', access='0', status = '0', planned_date = '$now', created_user = '$session->uid', created_date = '$now', edited_user = '$session->uid', edited_date = '$now'";
				$result = mysql_query($q, $this->_db->connection);
				$phaseid = mysql_insert_id();
				
				if($num_notes == 0) {
					// create ap with same name
					$tasktitle = $phasetitle;
					$taskprotocol = $phasetext;
					$cat = 0;
					$startdate = $this->_date->addDays($datecalc,"1");
					$enddate = $this->_date->addDays($datecalc,"7");
					$datecalc = $enddate;
					$q = "INSERT INTO " . CO_TBL_PROJECTS_PHASES_TASKS . " set pid='$pid', phaseid='$phaseid', cat='$cat', dependent = '$dependent', status = '0', text = '$tasktitle', protocol = '$taskprotocol', startdate = '$startdate', enddate = '$enddate'";
					$result = mysql_query($q, $this->_db->connection);
					$dependent = mysql_insert_id();
				}

			} else {
				// no title set
				if($num_notes > 0) {
					$phasetitle = 'Neue Phase';
					$phasetext = "";
					$q = "INSERT INTO " . CO_TBL_PROJECTS_PHASES . " set title = '$phasetitle', pid='$pid', team = '$pspgrid->team_convert', team_ct = '$pspgrid->team_ct_convert', protocol='$phasetext', access='0', status = '0', planned_date = '$now', created_user = '$session->uid', created_date = '$now', edited_user = '$session->uid', edited_date = '$now'";
					$result = mysql_query($q, $this->_db->connection);
					$phaseid = mysql_insert_id();
					
				}
				
			}
			
			foreach($cols[$key]["notes"] as $tkey => &$tvalue){ 
					// create aps
					$tasktitle = mysql_real_escape_string($cols[$key]["notes"][$tkey]['title']);
					$taskprotocol = mysql_real_escape_string($cols[$key]["notes"][$tkey]['text']);
					$costs_employees = $cols[$key]["notes"][$tkey]['costs_employees'];
					$costs_materials = $cols[$key]["notes"][$tkey]['costs_materials'];
					$costs_external = $cols[$key]["notes"][$tkey]['costs_external'];
					$costs_other = $cols[$key]["notes"][$tkey]['costs_other'];
					$task_team = $cols[$key]["notes"][$tkey]['team_convert'];
					if($cols[$key]["notes"][$tkey]['milestone'] == "1") {
						$cat = 1;
						$startdate = $this->_date->addDays($datecalc,"1");
						$enddate = $this->_date->addDays($datecalc,"1");
					} else {
						$cat = 0;
						$days = $cols[$key]["notes"][$tkey]['days'];
						if($days < 1) {
							$days = 1;
						}
						$startdate = $this->_date->addDays($datecalc,"1");
						$enddate = $this->_date->addDays($datecalc,$days);
					}
					$datecalc = $enddate;
					
					$q = "INSERT INTO " . CO_TBL_PROJECTS_PHASES_TASKS . " set pid='$pid', phaseid='$phaseid', cat='$cat', dependent = '$dependent', status = '0', text = '$tasktitle', protocol = '$taskprotocol', team = '$task_team', costs_employees = '$costs_employees', costs_materials = '$costs_materials', costs_external = '$costs_external', costs_other = '$costs_other', startdate = '$startdate', enddate = '$enddate'";
					$result = mysql_query($q, $this->_db->connection);
					$dependent = mysql_insert_id();
				
				}
		}
		
		$q = "INSERT INTO co_procs_pspgrids_log set rid = '$id', pid = '$pid', fid = '$folder', created_user = '$session->uid', created_date = '$now'";
		$result = mysql_query($q, $this->_db->connection);
		
		$projectsmodel = new ProjectsModel();		
		$return["fid"] = $projectsmodel->getProjectFolderDetails($folder,'title');
		$return["pid"] = $pid;
		$return["created_user"] = $this->_users->getUserFullname($session->uid);
		$return["created_date"] = $this->_date->formatDate($now,CO_DATETIME_FORMAT);
		
		return $return;
		
   }
   
   function getSettings($id) {
		$q = "SELECT setting_currency FROM " . CO_TBL_PROCS_PSPGRIDS . " where id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		$row = mysql_result($result,0);
		return $row;
	}
   
   function toggleCurrency($id,$cur) {
		$q = "UPDATE " . CO_TBL_PROCS_PSPGRIDS . " set setting_currency='$cur' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
			return true;
		}
	}

}
?>