<?php 
$content = str_replace('<p><!-- pagebreak --></p>','<div style="page-break-after:always;">&nbsp;</div>',$vdoc->content);
echo nl2br($content);
?></td>
<div style="page-break-after:always;">&nbsp;</div>