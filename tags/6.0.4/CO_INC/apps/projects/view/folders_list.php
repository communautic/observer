<?php
if(is_array($folders)) {
	foreach ($folders as $folder) {
		echo('<li id="folderItem_'.$folder->id.'"><a href="#" rel="'.$folder->id.'" class="module-click"><span class="text">'.$folder->title.'</span><span class="num">('.$folder->numProjects.')</span></a></li>');
	}
} else {
	echo('<li></li>');
}
?>