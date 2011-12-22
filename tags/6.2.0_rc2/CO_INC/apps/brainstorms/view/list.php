<?php
if(is_array($brainstorms)) {
	foreach ($brainstorms as $brainstorm) {
		echo('<li id="brainstormItem_'.$brainstorm->id.'"><span rel="'.$brainstorm->id.'" class="module-click"><span class="text">'.$brainstorm->title.'</span><span class="icon-guest'.$brainstorm->iconguest.'"></span><span class="icon-checked-out '.$brainstorm->checked_out_status.'"></span></span></li>');
	}
} else {
	echo('<li></li>');
}
?>