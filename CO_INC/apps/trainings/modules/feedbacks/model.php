<?php

class TrainingsFeedbacksModel extends TrainingsModel {
	
	public function __construct() {  
     	parent::__construct();
		//$this->_phases = new TrainingsPhasesModel();
		$this->_contactsmodel = new ContactsModel();
	}


	function getList($id,$sort) {
		global $session;
	  if($sort == 0) {
		  $sortstatus = $this->getSortStatus("trainings-feedbacks-sort-status",$id);
		  if(!$sortstatus) {
				$order = "order by item_date DESC";
				$sortcur = '1';
		  } else {
			  switch($sortstatus) {
				  case "1":
				  		$order = "order by item_date DESC";
						$sortcur = '1';
				  break;
				  case "2":
				  		$order = "order by item_date ASC";
							$sortcur = '2';
				  break;
				  case "3":
				  		$sortorder = $this->getSortOrder("trainings-feedbacks-sort-order",$id);
				  		if(!$sortorder) {
								$order = "order by item_date DESC";
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
				  		$order = "order by item_date DESC";
						$sortcur = '1';
				  break;
				  case "2":
				  		$order = "order by item_date ASC";
						$sortcur = '2';
				  break;
				  case "3":
				  		$sortorder = $this->getSortOrder("trainings-feedbacks-sort-order",$id);
				  		if(!$sortorder) {
						  	$order = "order by item_date DESC";
								$sortcur = '1';
						  } else {
								$order = "order by field(id,$sortorder)";
								$sortcur = '3';
						  }
				  break;	
			  }
		}
	  
		$perm = $this->getTrainingAccess($id);
		$sql ="";
		if( $perm ==  "guest") {
			$sql = " and access = '1' ";
		}
		
		$q = "SELECT a.*,CONCAT(b.lastname,', ',b.firstname) as title FROM " . CO_TBL_TRAININGS_MEMBERS . " as a, co_users as b where a.tookpart='1' and a.cid=b.id and a.pid = '$id' and a.bin='0' and b.bin='0' ORDER BY title ASC";
		$this->setSortStatus("trainings-feedbacks-sort-status",$sortcur,$id);
		$result = mysql_query($q, $this->_db->connection);
		$items = mysql_num_rows($result);
		
		$feedbacks = "";
		
		while ($row = mysql_fetch_array($result)) {

		foreach($row as $key => $val) {
				$array[$key] = $val;
			}
			$feedbacks[] = new Lists($array);
	  }
		
	  $arr = array("feedbacks" => $feedbacks, "items" => $items, "sort" => $sortcur, "perm" => $perm);
	  return $arr;
	}


	function getNavNumItems($id) {
		/*$perm = $this->getTrainingAccess($id);
		$sql ="";
		if( $perm ==  "guest") {
			$sql = " and access = '1' ";
		}*/
		$q = "select count(*) as items from " . CO_TBL_TRAININGS_MEMBERS . " where pid = '$id' and tookpart='1' and bin != '1'";
		$result = mysql_query($q, $this->_db->connection);
		$row = mysql_fetch_array($result);
		$items = $row['items'];
		return $items;
	}


	function getDetails($id, $option = "") {
		global $session, $lang;		

		$q = "SELECT a.*,CONCAT(b.lastname,', ',b.firstname) as title FROM " . CO_TBL_TRAININGS_MEMBERS . " as a, co_users as b where a.cid=b.id and a.id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) < 1) {
			return false;
		}
		$row = mysql_fetch_array($result);
		foreach($row as $key => $val) {
			$array[$key] = $val;
		}
		
		$array["perms"] = $this->getTrainingAccess($array["pid"]);
		$array["canedit"] = false;
		if($array["perms"] == "sysadmin" || $array["perms"] == "admin") {
			$array["canedit"] = true;
		}
		
		$array["q1_selected"] = $array["feedback_q1"];
		$array["q2_selected"] = $array["feedback_q2"];
		$array["q3_selected"] = $array["feedback_q3"];
		$array["q4_selected"] = $array["feedback_q4"];
		$array["q5_selected"] = $array["feedback_q5"];
		$total_result = 0;
		$array["q1_result"] = 0;
		$array["q2_result"] = 0;
		$array["q3_result"] = 0;
		$array["q4_result"] = 0;
		$array["q5_result"] = 0;
		if(!empty($array["feedback_q1"])) { $array["q1_result"] = $array["feedback_q1"]*20; $total_result += $array["feedback_q1"]; }
		if(!empty($array["feedback_q2"])) { $array["q2_result"] = $array["feedback_q2"]*20; $total_result += $array["feedback_q2"]; }
		if(!empty($array["feedback_q3"])) { $array["q3_result"] = $array["feedback_q3"]*20; $total_result += $array["feedback_q3"]; }
		if(!empty($array["feedback_q4"])) { $array["q4_result"] = $array["feedback_q4"]*20; $total_result += $array["feedback_q4"]; }
		if(!empty($array["feedback_q5"])) { $array["q5_result"] = $array["feedback_q5"]*20; $total_result += $array["feedback_q5"]; }
		
		$array["total_result"] = round(100/25* $total_result,0);

		//$array["perms"] = $this->getTrainingAccess($array["pid"]);
		$array["current_user"] = $session->uid;
		$array["today"] = $this->_date->formatDate("now",CO_DATETIME_FORMAT);
		
		$sendto = $this->getSendtoDetails("trainings_feedbacks",$id);

		$feedback = new Lists($array);
		
		$arr = array("feedback" => $feedback, "sendto" => $sendto, "access" => $array["perms"]);
		return $arr;
   }


   function setDetails($pid,$id,$protocol) {
		global $session, $lang;

		$now = gmdate("Y-m-d H:i:s");
		
		$q = "UPDATE " . CO_TBL_TRAININGS_MEMBERS . " set feedback_text='$protocol' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
			return $id;
		}
   }


    function updateQuestion($id,$field,$val){
		global $session;
		$now = gmdate("Y-m-d H:i:s");
		$q = "UPDATE " . CO_TBL_TRAININGS_MEMBERS . " set $field = '$val' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		return true;
   }


}
?>