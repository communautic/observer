<?php
if(is_array($grids)) {
foreach ($grids as $grid) {
	echo('<li id="gridItem_'.$grid->id.'"><span rel="'.$grid->id.'" class="module-click"><span class="module-access-status'.$grid->accessstatus.'"></span><span class="text">' .$grid->title.'</span><span class="icon-checked-out '.$grid->checked_out_status.'"></span></span></li>');
}
} else {
	echo('<li></li>');
}
?>