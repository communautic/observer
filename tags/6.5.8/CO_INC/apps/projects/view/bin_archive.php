

<?php if(is_array($arr["pros"])) { ?>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["PROJECT_PROJECTS"];?></td>
    <td class="tcell-right">&nbsp;</td>
    </tr>
</table>
<?php foreach ($arr["pros"] as $project) { ?>
    <table border="0" cellspacing="0" cellpadding="0" class="table-content tbl-inactive" id="project_<?php echo($project->id);?>" rel="<?php echo($project->id);?>">
	<tr>
		<td class="tcell-left text11"><span><?php echo $lang["PROJECT_TITLE"];?></span></td>
		<td class="tcell-right"><?php echo($project->title);?></td>
        <td width="25"><a href="projects" class="binRestore" rel="<?php echo $project->id;?>"><span class="icon-restore"></span></a></td>
        <td width="25"><a href="projects" class="binDelete" rel="<?php echo $project->id;?>"><span class="icon-delete"></span></a></td>
	</tr>
    <tr>
		<td class="tcell-left text11"><span><?php echo $lang["DELETED_BY_ON"];?></span></td>
		<td class="tcell-right"><?php echo($project->binuser . ", " .$project->bintime)?></td>
        <td></td>
        <td></td>
	</tr>
</table>
    <?php 
	}
}
?>

