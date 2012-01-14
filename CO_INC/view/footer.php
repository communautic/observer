<div id="menu">
<div id="menu-user"><?php echo($users->getUserFullname($session->uid));?>, <?php echo($date->formatDate(date("d.m.Y"), "d.m.Y"));?></div>
<div id="logout-outer">
    <div id="logout"><span class="logout" title="<?php echo $lang["LOGIN_LOGOUT"];?>"><div id="logout-icon"></div></span></div>
</div>
<div id="appnav-outer">
<div id="navSlider" style="position: relative; height: 36px; ">
<ul id="appnav">
<?php
foreach($userapps as $key => $app) {
	$activeapp = "";
	if($key == 0) {
		$activeapp = " active-app";
	}
		echo '<li><span rel="'.$app.'" class="toggleObservers' . $activeapp . ' app_'.$app.'" >' . ${$app.'_name'} . '</span></li>';
}
?>
</ul>
</div>
</div>
</div>
<div id="menu-opac"></div>