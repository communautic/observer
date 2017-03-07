<?php
if(is_array($procs)) {
	foreach ($procs as $proc) { 
	?>
    <div class="loadArchive listOuter"  rel="<?php echo($proc->id);?>">
    <div class="bold co-link listTitle"><?php echo($proc->title);?></div>
    <div class="text11 listText"><div><?php echo $lang["PROC_FOLDER_CREATED_ON"];?> <?php echo($proc->created_date);?> &nbsp; | &nbsp; </div><div><?php echo $lang["PROC_FOLDER_INITIATOR"];?> <?php echo($proc->created_user);?> &nbsp; </div></div>
    </div>
    <?php 
	}
}
?>