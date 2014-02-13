<?php
if(is_array($invoices)) {
foreach ($invoices as $invoice) {
	echo('<li id="invoiceItem_'.$invoice->id.'"><span rel="'.$invoice->id.'" class="module-click"><span class="text">' .$invoice->title.'</span><span class="module-item-status'.$invoice->itemstatus.'"></span></span></li>');
}
} else {
	echo('<li></li>');
}
?>