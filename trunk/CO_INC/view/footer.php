<div id="menu"><div class="spinner"><img src="<?php echo CO_FILES;?>/img/waiting.gif" alt="Loading" width="16" height="16" /></div>
<div style=" height: 16px; width: 227px; float: left; margin: 6px 0px 0 12px;" />
Benutzer: <?php echo($users->getUserFullname($session->uid));?>
</div>
<div style=" text-align: right; height: 16px; width: 70px; float: left; margin: 6px 66px 0 0px;" />
<?php echo($date->formatDate(date("d.m.Y"), "d.m.Y"));?>
</div>
<ul>
<?php
	foreach($controller->applications as $app => $display) {
		$activeapp = "";
		if($display == 1) {
			$activeapp = " active-app";
		}
		echo '<li><a href="#" rel="'.$app.'" class="toggleObservers' . $activeapp . ' app_'.$app.'" >' . ${$app.'_name'} . '</a></li>';
	}
	echo '<li><a href="/?path=login">' . LOGIN_LOGOUT . '</a></li>';
	?>
</ul>
</div>