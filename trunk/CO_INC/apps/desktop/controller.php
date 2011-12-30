<?php

class Desktop extends Controller {
	
	// get all available apps
	function __construct($name) {
			$this->application = $name;
			$this->form_url = "apps/$name/";
			$this->model = new DesktopModel();
			$this->modules = array();
			$this->num_modules = 0;
			$this->binDisplay = false;
	}
	
	public static function saveImage($chart_url,$path,$file_name){
			if(!file_exists($path.$file_name) || (md5_file($path.$file_name) != md5_file($chart_url)))
			{
				file_put_contents($path.$file_name,file_get_contents($chart_url));
			}
			return $file_name;
	}
	
	public function getChart() {
		$local_image_path = CO_PATH_BASE . '/data/charts/';
		$image_name = 'some_chart_image.png';
		$chart_url = 'http://chart.apis.google.com/chart?chf=bg,s,3F3F3F&chxs=0,FFFFFF,11.5&chxt=x&chs=321x170&cht=p3&chco=FF9900|3399CC|E0E0E0&chd=s:jfh&chdlp=b&chma=20,20,15';
		$image = self::saveImage($chart_url ,$local_image_path,$image_name);
	}
	
	public function getColumnWidgets($id) {
		global $lang, $system, $userapps;
		// check if user has settings
		//echo $this->model->existDesktopSetting('desktop-widgets');
		//if($this->model->existDesktopSetting('desktop-widgets') == false) {
			switch($id) {
				case 1:
					if(!$this->model->existUserSetting('desktop-widgets',$id)) {
						$widgets = explode(",", DEFAULT_WIDGETS_1);
					} else {
						$widgets = $this->model->getColumnWidgets($id);
					}
				break;
				case 2:
					if(!$this->model->existUserSetting('desktop-widgets',$id)) {
						$widgets = explode(",", DEFAULT_WIDGETS_2);
					} else {
						$widgets = $this->model->getColumnWidgets($id);
					}
				break;
				case 3:
					if(!$this->model->existUserSetting('desktop-widgets',$id)) {
						$widgets = explode(",", DEFAULT_WIDGETS_3);
					} else {
						$widgets = $this->model->getColumnWidgets($id);
					}
					
				break;
				case 4:
					if(!$this->model->existUserSetting('desktop-widgets',$id)) {
						$widgets = explode(",", DEFAULT_WIDGETS_4);
					} else {
						$widgets = $this->model->getColumnWidgets($id);
					}
				break;
			}
		
		if(is_array($widgets)) {
			foreach ($widgets as $widget) {
				${$widget.'_status'}  = $this->model->getUserSetting('desktop-widget-' . $widget);
			}
		}
			
		ob_start();
		include 'view/widget.php';
		$html = ob_get_contents();
		ob_end_clean();
		echo $html;
	}
	
	
	function updateColum($col,$widgets) {
		$retval = $this->model->updateColum($col,$widgets);
		if($retval){
			 return true;
		  } else{
			 return "error";
		  }
	}
	

	function setWidgetStatus($object,$status) {
		$retval = $this->model->setWidgetStatus($object,$status);
		if($retval){
			 return true;
		  } else{
			 return "error";
		  }
	}
	
	
	function getPostIts() {
		global $lang, $system;
		if($arr = $this->model->getPostIts()) {
			$posts = $arr["notes"];
			ob_start();
				include 'view/postits.php';
				$html = ob_get_contents();
			ob_end_clean();
			echo $html;
		}
	}


	function newPostit($z) {
		$retval = $this->model->newPostit($z);
		if($retval){
			 return 'true';
		  } else{
			 return "error";
		  }
	}
	
	function updatePostitPosition($id,$x,$y,$z) {
		$retval = $this->model->updatePostitPosition($id,$x,$y,$z);
		if($retval){
			 return 'true';
		  } else{
			 return "error";
		  }
	}


	function updatePostitSize($id,$w,$h) {
		$retval = $this->model->updatePostitSize($id,$w,$h);
		if($retval){
			 return 'true';
		  } else{
			 return "error";
		  }
	}
	
	
	function savePostit($id,$text) {
		global $lang;
		if($date = $this->model->savePostit($id,$text)){
			 $data["text"] = nl2br(stripslashes($text));
			 $data["date"] = $date;
			 $data["days"] = $lang["GLOBAL_TODAY"];
			 return json_encode($data);
		  } else{
			 return "error";
		  }
	}
	
	function forwardPostit($id,$users) {
		$retval = $this->model->forwardPostit($id,$users);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}
	
	
	function deletePostit($id) {
		$retval = $this->model->deletePostit($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}

	function getDesktopHelp() {
		global $lang;
		$data["file"] = $lang["DESKTOP_HELP"];
		$data["app"] = "desktop";
		$data["module"] = "";
		$this->openHelpPDF($data);
	}
	

}
$desktop = new Desktop("desktop");
?>