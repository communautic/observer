<?php 
$content = str_replace('<!-- pagebreak -->','',$vdoc->content);
$content = str_replace('<p> </p>','<p></p>',$content);
echo nl2br($content);
?>