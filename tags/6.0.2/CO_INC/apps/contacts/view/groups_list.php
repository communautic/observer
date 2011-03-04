<?php
if(is_array($groups)) {
	foreach ($groups as $group) {
		echo('<li id="groupItem_'.$group->id.'"><a href="#" rel="'.$group->id.'" class="module-click"><span class="text">'.$group->title.'</span><span class="num">('.$group->numContacts.')</span></a></li>');
	}
} else {
	echo('<li></li>');
}
?>