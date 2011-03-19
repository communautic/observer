<?php

class Contact {
	public function __construct($array) 
    {  
        	
			foreach($array as $key => $value) {
				$this->$key = $value;
			}
    } 
}

?>