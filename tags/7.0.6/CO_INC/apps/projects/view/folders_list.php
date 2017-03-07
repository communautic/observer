<?php
if(is_array($folders)) {
	foreach ($folders as $folder) {
		if($folder->title == "") {
			$folder->title = $lang["PROJECT_FOLDER_NEW"];
		}
		echo('<li id="folderItem_'.$folder->id.'"><span rel="'.$folder->id.'" class="module-click"><span class="text">'.$folder->title.'</span><span class="num">'.$folder->numProjects.'</span></span></li>');
	}
} else {
	echo('<li></li>');
}
?>