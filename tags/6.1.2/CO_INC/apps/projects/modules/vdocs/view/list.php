<?php
if(is_array($vdocs)) {
foreach ($vdocs as $vdoc) {
	echo('<li id="vdocItem_'.$vdoc->id.'"><span rel="'.$vdoc->id.'" class="module-click"><span class="module-access-status'.$vdoc->accessstatus.'"></span><span class="text">' .$vdoc->title.'</span></span></li>');
}
} else {
	echo('<li></li>');
}
?>