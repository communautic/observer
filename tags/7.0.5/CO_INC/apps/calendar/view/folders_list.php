<?php
if(is_array($folders)) {
	$i = 0;
	foreach ($folders as $folder) {
		if($i > 9) { $i = 0; }
		echo('<li id="folderItem_'.$folder->id.'"><span rel="'.$folder->id.'" class="module-click" data-id="'.$folder->calendarid.'"><span class="text">'.$folder->lastname . " " . $folder->firstname.' </span><span class="folderListColorBox" col="globalColor' . $i . '"></span></span></li>');
		$i++;
	}
} else {
	echo('<li></li>');
}
?>