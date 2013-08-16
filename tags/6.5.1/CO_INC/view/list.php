<b>Einzelkontakte</b>
<input class="contacts-search" title="<?php echo($field);?>"/><br /><br />
<b>Gruppen</b>
<ul><?php
foreach ($list as $item) {
	//echo('<li id="groupItem_'.$item->id.'"><a href="#" rel="'.$item->id.'">'.$item->name.'</a></li>'); ?>
	<div><a href="#" class="insertfromDialog tooltip" title="<?php echo($item->name);?>" field="<?php echo($field);?>" append="<?php echo($append);?>" uid="<?php echo($item->id);?>"><?php echo($item->name);?></a></div>
    <?php
}
?>
</ul>