<?php
if(is_array($phonecalls)) {
foreach ($phonecalls as $phonecall) {
	echo('<li><a href="#" rel="'.$phonecall->id.'" class="module-click"><span class="module-access-status"></span><span class="text">' . $phonecall->phonecall_date . ' - ' .$phonecall->title.'</span><span class="module-item-status'.$phonecall->itemstatus.'"></span></a></li>');

}
} else {
	echo('<li></li>');
}
?>