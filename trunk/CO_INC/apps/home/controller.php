<?php

class Home extends Controller {
	
	// get all available apps
	function __construct($name) {
			$this->application = $name;
			$this->form_url = "apps/$name/";
			//$this->model = new ProjectsModel();
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

}
$home = new Home("home");
?>