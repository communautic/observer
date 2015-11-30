<?php
$i = 0;
foreach($projects->modules as $module  => $value) {
	?>
	<div id="archives_<?php echo($module);?>" class="thirdLevel" style="top: <?php echo($i*27);?>px">
		<div class="module-actions module-actions-modules"><!--<div class="sort-outer"><span class="sort" rel="1"></span></div>--></div>
		<h3 rel="<?php echo($module);?>"><?php echo(${'projects_'.$module.'_name'});?></h3>
		<div class="numItems" id="<?php echo('projects_'.$module.'_items');?>"></div>
		<div class="archives3-content"><div class="scrolling-content">
		<ul class="" rel="<?php echo($module);?>"><li></li></ul>
		</div>
		</div>
	</div>
<?php 
$i++;
} ?>