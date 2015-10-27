<table width="100%" class="standard">
	<tr>
		<td>
    <?php 
		$content = str_replace('<!-- pagebreak -->','<div style="page-break-after:always;">&nbsp;</div>',$vdoc->content);
		echo nl2br($content);
		?>
    </td>
    </tr>
</table>