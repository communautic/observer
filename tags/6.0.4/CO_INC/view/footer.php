<div id="menu">
<div class="text11" style=" height: 16px; width: 227px; float: left; margin: 6px 0px 0 12px;" />
<?php echo($lang["GLOBAL_USER"]);?> <?php echo($users->getUserFullname($session->uid));?>
</div>
<div class="text11" style=" text-align: right; height: 16px; width: 73px; float: left; margin: 6px 63px 0 0px;" />
<?php echo($date->formatDate(date("d.m.Y"), "d.m.Y"));?>
</div>
<ul id="appnav">
<?php
	foreach($controller->applications as $app => $display) {
		$activeapp = "";
		if($display == 1) {
			$activeapp = " active-app";
		}
		echo '<li><a href="#" rel="'.$app.'" class="toggleObservers' . $activeapp . ' app_'.$app.'" >' . ${$app.'_name'} . '</a></li>';
	}
	?>
</ul>
<div id="logout"/><a href="/?path=login" title="<?php echo $lang["LOGIN_LOGOUT"];?>"><span>&nbsp;</span></a></div>
</div>