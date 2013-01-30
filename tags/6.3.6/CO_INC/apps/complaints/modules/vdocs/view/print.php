<div style="margin-left: -20px;">
<?php 
$content = str_replace('<!-- pagebreak -->','<div style="page-break-after:always;">&nbsp;</div>',$vdoc->content);
echo nl2br($content);
?>
</div>
<div style="page-break-after:always;">&nbsp;</div>