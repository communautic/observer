<?php
if(is_array($documents)) {
foreach ($documents as $document) {
	echo('<li id="documentItem_'.$document->id.'"><span rel="'.$document->id.'" class="module-click"><span class="module-access-status'.$document->accessstatus.'"></span>' . $document->edited_date . ' - <span class="text">' .$document->title.'</span></span></li>');
}
} else {
	echo('<li></li>');
}
?>
