<table width="100%" class="title">
	<tr>
        <td class="tcell-left"><?php echo $lang["CLIENT_TITLE"];?></td>
        <td><strong><?php echo($client->title);?></strong></td>
	</tr>
</table>
<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left"><?php echo $lang["CLIENT_FOLDER"];?></td>
        <td><?php echo($client->folder);?></td>
	</tr>
</table>
<?php if(!empty($client->management_print) || !empty($client->management_ct)) { ?>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["CLIENT_MANAGEMENT"];?></td>
		<td><?php echo($client->management_print);?><br /><?php echo($client->management_ct);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($client->team_print) || !empty($client->team_ct)) { ?>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["CLIENT_TEAM"];?></td>
		<td><?php echo($client->team_print);?><br /><?php echo($client->team_ct);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($client->address) || !empty($client->address_ct)) { ?>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["CLIENT_ADDRESS"];?></td>
		<td><?php echo($client->address);?><br /><?php echo($client->address_ct);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($client->billingaddress) || !empty($client->billingaddress_ct)) { ?>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["CLIENT_BILLING_ADDRESS"];?></td>
		<td><?php echo($client->billingaddress);?><br /><?php echo($client->billingaddress_ct);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($client->contract_text)) { ?>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["CLIENT_CONTRACT"];?></td>
		<td><?php echo($client->contract_text);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($client->protocol)) { ?>
&nbsp;
<table width="100%" class="protocol">
	<tr>
        <td class="tcell-left top"><?php echo $lang["CLIENT_DESCRIPTION"];?></td>
        <td><?php echo(nl2br($client->protocol));?></td>
	</tr>
</table>
<?php } ?>
&nbsp;
<?php
if(is_array($order_access)) {
	$i = 1;
	foreach ($order_access as $oa) { 
		$img = '&nbsp;';
	if($oa->access_status == 0) {
		$img = '<img src="' . CO_FILES . '/img/print/done.png" width="12" height="12" vspace="2" hspace="4" /> ';
	}
	?>
    <table width="100%" class="fourCols">
        <tr>
            <td class="fourCols-one"><?php if($i == 1) { echo 'Bestellberechtigung'; }?>&nbsp;</td>
            <td class="fourCols-two"><?php echo $img;?></td>
            <td class="fourCols-three greybg">&nbsp;</td>
            <td class="fourCols-four greybg"><strong><?php echo($oa->access_name);?></strong></td>
        </tr>
         <?php if(!empty($oa->access_company)) { ?>
        <tr>
            <td class="fourCols-one">&nbsp;</td>
            <td class="fourCols-two">&nbsp;</td>
            <td class="fourCols-three">&nbsp;</td>
            <td class="grey smalltext"><?php echo($oa->access_company);?></td>
        </tr>
        <?php } ?>
        <?php if(!empty($oa->access_address)) { ?>
        <tr>
            <td class="fourCols-one">&nbsp;</td>
            <td class="fourCols-two">&nbsp;</td>
            <td class="fourCols-three">&nbsp;</td>
            <td class="grey smalltext"><?php echo($oa->access_address);?></td>
        </tr>
        <?php } ?>
        <?php if(!empty($oa->access_phone)) { ?>
        <tr>
            <td class="fourCols-one">&nbsp;</td>
            <td class="fourCols-two">&nbsp;</td>
            <td class="fourCols-three">&nbsp;</td>
            <td class="grey smalltext"><?php echo($oa->access_phone);?></td>
        </tr>
        <?php } ?>
        <?php if(!empty($oa->access_email)) { ?>
        <tr>
            <td class="fourCols-one">&nbsp;</td>
            <td class="fourCols-two">&nbsp;</td>
            <td class="fourCols-three">&nbsp;</td>
            <td class="grey smalltext"><?php echo($oa->access_email);?></td>
        </tr>
        <?php } ?>
                 <tr>
             <td class="fourCols-one">&nbsp;</td>
            <td class="fourCols-two">&nbsp;</td>
            <td class="fourCols-three">&nbsp;</td>
            <td class="grey smalltext">&nbsp;</td>
        </tr>
     </table>
     
    <?php 
	$i++;
	}
}
?>
<div style="page-break-after:always;">&nbsp;</div>