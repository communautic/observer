<?php
if(is_array($folders)) {
	foreach ($folders as $folder) {
		/*$checked = ' checked="checked"';
		$active = ' active-link';
		if($folder->calactive == 0) {
				$checked = '';
				$active = '';
		}*/
		echo('<li id="folderItem_'.$folder->id.'"><span rel="'.$folder->id.'" class="module-click" data-id="'.$folder->calendarid.'"><span class="text">'.$folder->lastname . " " . $folder->firstname.' </span></span></li>');
	}
} else {
	echo('<li></li>');
}
?>