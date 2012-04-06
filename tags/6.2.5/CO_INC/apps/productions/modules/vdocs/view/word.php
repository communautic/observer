<?php 
$content = str_replace('<!-- pagebreak -->','',$vdoc->content);
$content = str_replace("<p>&nbsp;</p>","<p><br></p>",$content);
$content = str_replace('src="','src="' . CO_PATH_URL . '/',$content);
echo $content;
?>