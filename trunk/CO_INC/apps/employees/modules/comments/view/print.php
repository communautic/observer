<table width="100%" class="title">
	<tr>
        <td class="tcell-left"><?php echo $lang["EMPLOYEE_COMMENT_TITLE"];?></td>
        <td><strong><?php echo($comment->title);?></strong></td>
	</tr>
</table>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["EMPLOYEE_COMMENT_DATE"];?></td>
		<td><?php echo($comment->item_date)?></td>
    </tr>
</table>
<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left"><?php echo $lang["EMPLOYEE_COMMENT_TIME_START"];?></td>
        <td><?php echo($comment->start);?></td>
	</tr>
</table>
<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left"><?php echo $lang["EMPLOYEE_COMMENT_TIME_END"];?></td>
        <td><?php echo($comment->end);?></td>
	</tr>
</table>
<?php if(!empty($comment->management_print) || !empty($comment->management_ct)) { ?>
<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left"><?php echo $lang["EMPLOYEE_COMMENT_MANAGEMENT"];?></td>
        <td><?php echo($comment->management);?><br /><?php echo($comment->management_ct);?></td>
	</tr>
</table>
<?php } ?>
<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left"><?php echo $lang["EMPLOYEE_COMMENT_TYPE"];?></td>
        <td><?php echo($comment->status_text);?> <?php echo($comment->status_date)?></td>
	</tr>
</table>
&nbsp;
<?php if(!empty($comment->protocol)) { ?>
&nbsp;
<table width="100%" class="protocol">
	<tr>
        <td class="tcell-left top"><?php echo $lang["EMPLOYEE_COMMENT_GOALS"];?></td>
        <td><?php echo(nl2br($comment->protocol));?></td>
	</tr>
</table>
<?php } ?>
&nbsp;
<div style="page-break-after:always;">&nbsp;</div>