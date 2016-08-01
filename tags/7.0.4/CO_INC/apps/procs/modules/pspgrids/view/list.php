<?php
if(is_array($pspgrids)) {
foreach ($pspgrids as $pspgrid) {
	echo('<li id="pspgridItem_'.$pspgrid->id.'"><span rel="'.$pspgrid->id.'" class="module-click"><span class="module-access-status'.$pspgrid->accessstatus.'"></span><span class="text">' .$pspgrid->title.'</span><span class="icon-checked-out '.$pspgrid->checked_out_status.'"></span></span></li>');
}
} else {
	echo('<li></li>');
}
?>