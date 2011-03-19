<?php

class Group {
	public $id;
	public $title;
	
	public function __construct($array) {  
	  foreach($array as $key => $value) {
		  $this->$key = $value;
	  }
    } 
}

?>