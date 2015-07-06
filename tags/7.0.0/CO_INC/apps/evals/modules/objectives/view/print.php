<table width="100%" class="title grey">
	<tr>
        <td class="tcell-left"><?php echo $lang["EVAL_OBJECTIVE_TITLE"];?></td>
        <td><strong><?php echo($objective->title);?></strong></td>
	</tr>
</table>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["EVAL_OBJECTIVE_DATE"];?></td>
		<td><?php echo($objective->item_date)?></td>
    </tr>
</table>
<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left"><?php echo $lang["EVAL_OBJECTIVE_TIME_START"];?></td>
        <td><?php echo($objective->start);?></td>
	</tr>
</table>
<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left"><?php echo $lang["EVAL_OBJECTIVE_TIME_END"];?></td>
        <td><?php echo($objective->end);?></td>
	</tr>
</table>
<table width="100%" class="standard">
    <tr>
	  <td class="tcell-left"><?php echo $lang["EVAL_OBJECTIVE_PLACE"];?></td>
        <td><?php echo($objective->location);?></td>
	</tr>
</table>
<?php if(!empty($objective->participants_print) || !empty($objective->participants_ct)) { ?>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["EVAL_OBJECTIVE_ATTENDEES"];?></td>
		<td><?php echo($objective->participants_print)?><br /><?php echo($objective->participants_ct);?></td>
    </tr>
</table>
<?php } ?>
<?php if(!empty($objective->management_print) || !empty($objective->management_ct)) { ?>
<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left"><?php echo $lang["EVAL_OBJECTIVE_MANAGEMENT"];?></td>
        <td><?php echo($objective->management_print);?><br /><?php echo($objective->management_ct);?></td>
	</tr>
</table>
<?php } ?>
<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left"><?php echo $lang["GLOBAL_STATUS"];?></td>
        <td><?php echo($objective->status_text);?> <?php echo($objective->status_text_time);?> <?php echo($objective->status_date)?></td>
	</tr>
</table>
&nbsp;<br />
&nbsp;
<!-- Tab 1 -->
<table width="100%" class="standard-grey-paddingBottom">
	<tr>
	  <td class="tcell-left">Kommunikation</td>
        <td><strong>Kompetenzeinschätzung <?php echo $objective->tab1result;?>%</strong></td>
	</tr>
</table>
<!--<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left"><?php echo $lang["EVAL_OBJECTIVE_DESCRIPTION"];?></td>
        <td><?php echo(nl2br(strip_tags($objective->protocol)));?></td>
	</tr>
</table>-->
<p>&nbsp;</p>
<?php for($i=1; $i < 18; $i++) { ?>
<table width="100%" class="standard">
	<tr>
	  <td><?php echo $lang["EVAL_OBJECTIVE_TAB1_QUESTION_".$i];?></td>
      <?php 
	  	$num = $objective->{"tab1q".$i."_selected"};
	  	$class = '';
	  	if($num < 4) { $class = 'neg'; }
		if($num > 3 && $num < 7) { $class = 'med'; }
		if($num > 6 ) { $class = 'pos'; }
		if($num == "") { $class = 'none'; }
	  ?>
        <td width="30"><?php echo '<div class="' . $class . '">' . $num . '</div>';?></td>
	</tr>
</table>
<?php echo(nl2br(strip_tags($objective->{"tab1q".$i."_text"})));?>
<p>&nbsp;</p>
<p>&nbsp;</p>
<?php } ?>

<table width="100%" class="standard-grey-paddingBottom">
	<tr>
	  <td class="tcell-left">Projektmanagement</td>
        <td><strong>Kompetenzeinschätzung <?php echo $objective->tab2result;?>%</strong></td>
	</tr>
</table>
<p>&nbsp;</p>
<?php for($i=1; $i < 18; $i++) { ?>
<table width="100%" class="standard">
	<tr>
	  <td><?php echo $lang["EVAL_OBJECTIVE_TAB2_QUESTION_".$i];?></td>
      <?php 
	  	$num = $objective->{"tab2q".$i."_selected"};
	  	$class = '';
	  	if($num < 4) { $class = 'neg'; }
		if($num > 3 && $num < 7) { $class = 'med'; }
		if($num > 6 ) { $class = 'pos'; }
		if($num == "") { $class = 'none'; }
	  ?>
        <td width="30"><?php echo '<div class="' . $class . '">' . $num . '</div>';?></td>
	</tr>
</table>
<?php echo(nl2br(strip_tags($objective->{"tab2q".$i."_text"})));?>
<p>&nbsp;</p>
<p>&nbsp;</p>
<?php } ?>


<table width="100%" class="standard-grey-paddingBottom">
	<tr>
	  <td class="tcell-left">Recht &amp; Wirtschaft</td>
        <td><strong>Kompetenzeinschätzung <?php echo $objective->tab3result;?>%</strong></td>
	</tr>
</table>
<p>&nbsp;</p>
<?php for($i=1; $i < 18; $i++) { ?>
<table width="100%" class="standard">
	<tr>
	  <td><?php echo $lang["EVAL_OBJECTIVE_TAB3_QUESTION_".$i];?></td>
      <?php 
	  	$num = $objective->{"tab3q".$i."_selected"};
	  	$class = '';
	  	if($num < 4) { $class = 'neg'; }
		if($num > 3 && $num < 7) { $class = 'med'; }
		if($num > 6 ) { $class = 'pos'; }
		if($num == "") { $class = 'none'; }
	  ?>
        <td width="30"><?php echo '<div class="' . $class . '">' . $num . '</div>';?></td>
	</tr>
</table>
<?php echo(nl2br(strip_tags($objective->{"tab3q".$i."_text"})));?>
<p>&nbsp;</p>
<p>&nbsp;</p>
<?php } ?>

<table width="100%"  class="standard-grey-paddingBottom">
	<tr>
	  <td class="tcell-left">Pers&ouml;nliche Ziele</td>
        <td><strong>erreichte Zielsetzungen <?php echo $objective->tab4result;?>%</strong></td>
	</tr>
</table>
<?php
$i = 1;
foreach($task as $value) { ?>
<table width="100%" class="standard">
	<tr>
	  <td><?php echo $value->title;?></td>
      <?php 
	  	$num = $value->answer;
	  	$class = '';
	  	if($num < 4) { $class = 'neg'; }
		if($num > 3 && $num < 7) { $class = 'med'; }
		if($num > 6 ) { $class = 'pos'; }
		if($num == "") { $class = 'none'; }
	  ?>
      <td width="30"><?php echo '<div class="' . $class . '">' . $value->answer . '</div>';?></td>
	</tr>
</table>
<?php echo(nl2br($value->text));?>
<p>&nbsp;</p>
<p>&nbsp;</p>
&nbsp;
	<?php 
	$i++;
	}
?>
<p>&nbsp;</p>
<p>&nbsp;</p>
<table width="100%"  class="standard-grey-paddingBottom">
	<tr>
	  <td class="tcell-left">Personalentwicklung</td>
        <td>&nbsp;</td>
	</tr>
</table>
<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left">Notiz</td>
        <td><?php echo(nl2br(strip_tags($objective->protocol2)));?></td>
	</tr>
</table>
<p>&nbsp;</p>
<table width="100%" class="standard">
	<tr>
	  <td colspan="3">
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>Gespr&auml;ch gef&uuml;hrt am: ...............................................</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p></td>
	</tr>
	<tr>
	  <td>...............................................</td>
      <td width="50%">&nbsp;</td>
      <td>...............................................</td>
	</tr>
    <tr>
	  <td align="center">Unterschrift Vorgesetzte/r</td>
      <td>&nbsp;</td>
      <td align="center">Unterschrift Mitarbeiter/in </td>
	</tr>
</table>
<div style="page-break-after:always;">&nbsp;</div>