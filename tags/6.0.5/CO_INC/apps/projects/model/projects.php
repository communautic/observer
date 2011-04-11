<?php

class Project {
	public $id;
	public $title;
	public $team;
	public $management;
	public $protocol;
	public $ordered_on;
	public $ordered_by;
	public $edited_user;
	public $edited_date;
	public $startdate;
	public $enddate;
	public $projectstatus;
	public $planned_date;
	public $inprogress_date;
	public $finished_date;
	public $days;
	public $created_date;
	public $created_user;
	public $projectfolder;
	public $bin;
	public $bintime;
	public $binuser;
	public $intern;
	public $project_partner;
	
	//public function __construct($id, $title, $team, $management, $protocol, $ordered_on, $ordered_by, $edited_user, $edited_date, $startdate, $enddate, $projectstatus, $planned_date, $inprogress_date, $finished_date, $days, $created_date, $created_user, $projectfolder, $bin, $bintime, $binuser, $intern, $project_partner) 
	public function __construct($array) 
    {  
        	
			foreach($array as $key => $value) {
				$this->$key = $value;
			}
			/*$this->id = $id;
			$this->title = $title;
			$this->team = $team;
			$this->management = $management;
			$this->protocol = $protocol;
			$this->ordered_on = $ordered_on;
			$this->ordered_by = $ordered_by;
			$this->edited_user = $edited_user;
			$this->edited_date = $edited_date;
			$this->startdate = $startdate;
			$this->enddate = $enddate;
			$this->projectstatus = $projectstatus;
			$this->planned_date = $planned_date;
			$this->inprogress_date = $inprogress_date;
			$this->finished_date = $finished_date;
			$this->days = $days;
			$this->created_date = $created_date;
			$this->created_user = $created_user;
			$this->projectfolder = $projectfolder;
			$this->bin = $bin;
			$this->bintime = $bintime;
			$this->binuser = $binuser;
			$this->intern = $intern;
			$this->project_partner = $project_partner;*/
    } 
}

?>