<div class="inner" id="calendarSettings"><table width="100%" border="0" cellspacing="0" cellpadding="0" >
<?php
if(is_array($folders)) {
	$i = 0;
	foreach ($folders as $folder) {
		if($i > 9) { $i = 0; }
		echo '<tr><td valign="middle">'.$folder->lastname . " " . $folder->firstname.'</td><td valign="middle" width="35" align="right"><span class="toggleCalendar coCheckbox" rel="'.$folder->calendarid.'" col="globalColor' . $i . '"></span></td></tr>' ;
		$i++;
	}
} else {
	echo('');
}
?></table>
</div>
