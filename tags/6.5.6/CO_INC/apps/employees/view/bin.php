<div class="table-title-outer">
<table border="0" cellspacing="0" cellpadding="0" class="table-title grey">
  <tr>
    <td class="tcell-left text11"><span class="content-nav"><?php echo $lang["BIN_TITLE"];?></span></td>
    <td></td>
  </tr>
</table>
</div>
<div class="ui-layout-content"><div class="scroll-pane">

<?php if(is_array($arr["folders"])) { ?>
    <table border="0" cellpadding="0" cellspacing="0" class="table-content">
        <tr>
            <td class="tcell-left-inactive text11"><?php echo $lang["EMPLOYEE_FOLDER"];?></td>
        <td class="tcell-right">&nbsp;</td>
        </tr>
    </table>
<?php foreach ($arr["folders"] as $folder) { ?>
    <table border="0" cellspacing="0" cellpadding="0" class="table-content tbl-inactive" id="folder_<?php echo($folder->id);?>" rel="<?php echo($folder->id);?>">
	<tr>
		<td class="tcell-left text11"><span><?php echo $lang["EMPLOYEE_FOLDER"];?></span></td>
		<td class="tcell-right"><?php echo($folder->title);?></td>
        <td width="25"><a href="employees_folder" class="binRestore" rel="<?php echo $folder->id;?>"><span class="icon-restore"></span></a></td>
        <td width="25"><a href="employees_folder" class="binDelete" rel="<?php echo $folder->id;?>"><span class="icon-delete"></span></a></td>
	</tr>
    <tr>
		<td class="tcell-left text11"><span><?php echo $lang["DELETED_BY_ON"];?></span></td>
		<td class="tcell-right"><?php echo($folder->binuser . ", " .$folder->bintime)?></td>
        <td></td>
        <td></td>
	</tr>
</table>
    <?php 
	}
}
?>


<?php if(is_array($arr["pros"])) { ?>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["EMPLOYEE_EMPLOYEES"];?></td>
    <td class="tcell-right">&nbsp;</td>
    </tr>
</table>
<?php foreach ($arr["pros"] as $employee) { ?>
    <table border="0" cellspacing="0" cellpadding="0" class="table-content tbl-inactive" id="employee_<?php echo($employee->id);?>" rel="<?php echo($employee->id);?>">
	<tr>
		<td class="tcell-left text11"><span><?php echo $lang["EMPLOYEE_TITLE"];?></span></td>
		<td class="tcell-right"><?php echo($employee->title);?></td>
        <td width="25"><a href="employees" class="binRestore" rel="<?php echo $employee->id;?>"><span class="icon-restore"></span></a></td>
        <td width="25"><a href="employees" class="binDelete" rel="<?php echo $employee->id;?>"><span class="icon-delete"></span></a></td>
	</tr>
    <tr>
		<td class="tcell-left text11"><span><?php echo $lang["DELETED_BY_ON"];?></span></td>
		<td class="tcell-right"><?php echo($employee->binuser . ", " .$employee->bintime)?></td>
        <td></td>
        <td></td>
	</tr>
</table>
    <?php 
	}
}
?>

<?php
	foreach($employees->modules as $module => $value) {
		if(CONSTANT('employees_'.$module.'_bin') == 1) {
			include(CO_INC . "/apps/employees/modules/".$module."/view/bin.php");
		}
	}
?>

</div>
</div>
<div>
<table border="0" cellspacing="0" cellpadding="0" class="table-footer">
  <tr>
    <td class="left"><?php echo($lang["GLOBAL_FOOTER_STATUS"] . " " . $bin["datetime"]);?></td>
    <td class="middle"></td>
    <td class="right"></td>
  </tr>
</table>
</div>