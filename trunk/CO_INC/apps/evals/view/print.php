<table width="100%" class="title">
	<tr>
        <td class="tcell-left"><?php echo $lang["EVAL_TITLE"];?></td>
        <td><strong><?php echo($eval->title);?></strong></td>
	</tr>
</table>
<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left"><?php echo $lang["EVAL_FOLDER"];?></td>
        <td><?php echo($eval->folder);?></td>
	</tr>
</table>
<?php if(!empty($eval->startdate)) { ?>
<table width="100%" class="standard"> 
   <tr>
		<td class="tcell-left"><?php echo $lang["EVAL_STARTDATE"];?></td>
		<td><?php echo($eval->startdate);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($eval->enddate)) { ?>
<table width="100%" class="standard"> 
   <tr>
		<td class="tcell-left"><?php echo $lang["EVAL_ENDDATE"];?></td>
		<td><?php echo($eval->enddate);?></td>
	</tr>
</table>
<?php } ?>
<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left"><?php echo $lang["GLOBAL_STATUS"];?></td>
        <td><?php echo($eval->status_text);?> <?php echo($eval->status_text_time);?> <?php echo($eval->status_date)?></td>
	</tr>
</table>
&nbsp;
<?php if(!empty($eval->number)) { ?>
<table width="100%" class="standard"> 
   <tr>
		<td class="tcell-left"><?php echo $lang["EVAL_NUMBER"];?></td>
		<td><?php echo($eval->number);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($eval->kind)) { ?>
<table width="100%" class="standard"> 
   <tr>
		<td class="tcell-left"><?php echo $lang["EVAL_KIND"];?></td>
		<td><?php echo($eval->kind);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($eval->area)) { ?>
<table width="100%" class="standard"> 
   <tr>
		<td class="tcell-left"><?php echo $lang["EVAL_AREA"];?></td>
		<td><?php echo($eval->area);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($eval->department)) { ?>
<table width="100%" class="standard"> 
   <tr>
		<td class="tcell-left"><?php echo $lang["EVAL_DEPARTMENT"];?></td>
		<td><?php echo($eval->department);?></td>
	</tr>
</table>
<?php } ?>
&nbsp;
<table width="100%" class="protocol">
	<tr>
        <td class="tcell-left top">Kontaktdaten</td>
        <td><?php echo($eval->ctitle)?> <?php echo($eval->title2)?> <?php echo($eval->title);?><br />
		<?php echo($eval->position . "<br />" . $lang["EVAL_CONTACT_EMAIL"] . " " . $eval->email . " &nbsp; | &nbsp; " . $lang["EVAL_CONTACT_PHONE"] . " " . $eval->phone1);?></td>
	</tr>
</table>
<?php if(!empty($eval->dob)) { ?>
<table width="100%" class="standard"> 
   <tr>
		<td class="tcell-left"><?php echo $lang["EVAL_DOB"];?></td>
		<td><?php echo($eval->dob);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($eval->coo)) { ?>
<table width="100%" class="standard"> 
   <tr>
		<td class="tcell-left"><?php echo $lang["EVAL_COO"];?></td>
		<td><?php echo($eval->coo);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($eval->languages)) { ?>
<table width="100%" class="standard"> 
   <tr>
		<td class="tcell-left"><?php echo $lang["EVAL_LANGUAGES"];?></td>
		<td><?php echo($eval->languages);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($eval->protocol)) { ?>
&nbsp;
<table width="100%" class="protocol">
	<tr>
        <td class="tcell-left top"><?php echo $lang["EVAL_DESCRIPTION"];?></td>
        <td><?php echo(nl2br($eval->protocol));?></td>
	</tr>
</table>
<?php } ?>
&nbsp;
<table width="100%" class="standard"> 
   <tr>
		<td class="tcell-left">Erstanalyse</td>
		<td>&nbsp;</td>
	</tr>
</table>
<?php 
$numOfObjectives = $this->getObjectives($eval->id);
if($numOfObjectives < 1) { ?>
<table width="100%" class="standard-margin grey">
	<tr>
		<td width="33%"><?php $this->getChartPerformance($eval->id,'happiness',1,1,0,0);?></td>
		<td width="33%"><?php $this->getChartPerformance($eval->id,'performance',1,1,0,0);?></td>
		<td><?php $this->getChartPerformance($eval->id,'legal',1,1,0,0);?></td>
	</tr>
</table>
<table width="100%" class="standard-margin grey">
	<tr>
        <td width="33%"><?php $this->getChartPerformance($eval->id,'totals',1,1,0,0);?></td>
        <td width="33%">&nbsp;</td>
		<td width="33%">&nbsp;</td>
	</tr>
</table>
&nbsp;
<?php } else { 
	$i = 0;
	while($i < $numOfObjectives) {?>
		<?php if($i == 0) { ?>
				<table width="100%" class="standard-margin grey">
                    <tr>
                        <td width="33%"><?php $this->getChartPerformance($eval->id,'happiness',1,1,0,$i);?></td>
                        <td width="33%"><?php $this->getChartPerformance($eval->id,'performance',1,1,0,$i);?></td>
                        <td><?php $this->getChartPerformance($eval->id,'legal',1,1,0,$i);?></td>
                    </tr>
                </table>
                <table width="100%" class="standard-margin grey">
                    <tr>
                        <td width="33%"><?php $this->getChartPerformance($eval->id,'totals',1,1,0,$i);?></td>
                        <td width="33%">&nbsp;</td>
                        <td width="33%">&nbsp;</td>
                    </tr>
                </table>
                &nbsp;
			<?php } else { ?>
                <table width="100%" class="standard-margin grey">
                    <tr>
                        <td width="33%"><?php $this->getChartPerformance($eval->id,'happiness',1,1,1,$i);?></td>
                        <td width="33%"><?php $this->getChartPerformance($eval->id,'performance',1,1,1,$i);?></td>
                        <td><?php $this->getChartPerformance($eval->id,'legal',1,1,1,$i);?></td>
                    </tr>
                </table>
                <table width="100%" class="standard-margin grey">
                    <tr>
                        <td width="33%"><?php $this->getChartPerformance($eval->id,'totals',1,1,1,$i);?></td>
                        <td width="33%">&nbsp;</td>
                        <td width="33%">&nbsp;</td>
                    </tr>
                </table>
                &nbsp;
	<?php
			}
	$i++;
	}
}
    ?>