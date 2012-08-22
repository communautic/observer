<div style="position: relative; float: left; width: 150px; margin: 0px 9px 0 9px">
	<div style="position: relative; height: 23px; background-color:#c3c3c3; padding: 3px 0 0 8px"><?php echo($chart["title"]);?><img src="<?php echo CO_FILES;?>/img/<?php echo($chart["tendency"]);?>" width="17" height="11" style="position:absolute; top: 8px; right: 8px;" /></div>
    <div style="position: absolute; right: 8px;"><?php echo($chart["real"]);?>%</div>
    <div><img src="/data/charts/<?php echo($chart["img_name"]);?>?t=<?php echo(time());?>" alt="<?php echo($chart["title"]);?>" width="150" height="90" title="<?php echo($chart["title"]);?>"/></div>
</div>