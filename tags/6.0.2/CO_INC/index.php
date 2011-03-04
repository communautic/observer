<?php
include_once(CO_INC . "/classes/session.php");
if(!$session->logged_in){
include(CO_INC . "/login/login.php");
exit();
}
include_once(CO_INC . "/model.php");
include_once(CO_INC . "/controller.php");
$num_apps = 0;
foreach($controller->applications as $app => $display) {
	include_once(CO_INC . "/apps/".$app."/config.php");
	include_once(CO_INC . "/apps/".$app."/lang/" . $session->userlang . ".php");
	include_once(CO_INC . "/apps/".$app."/model.php");
	include_once(CO_INC . "/apps/".$app."/controller.php");
	$num_apps++;
}
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $lang["APPLICATION_NAME"];?></title>
<link href="<?php echo CO_FILES;?>/css/reset.css" rel="stylesheet" type="text/css" media="screen,projection" />
<link href="<?php echo CO_FILES;?>/css/styles.css" rel="stylesheet" type="text/css" media="screen,projection" />
<link href="<?php echo CO_FILES;?>/css/content.css" rel="stylesheet" type="text/css" media="screen,projection" />
<!--<link href="<?php echo CO_FILES;?>/css/jScrollPane.css" rel="stylesheet" type="text/css" />-->
<link href="<?php echo CO_FILES;?>/css/jquery.jscrollpane.css" rel="stylesheet" type="text/css" />
<link href="<?php echo CO_FILES;?>/css/jquery-ui-1.8.5.custom.css" rel="stylesheet" type="text/css" media="screen,projection" />
<link href="<?php echo CO_FILES;?>/css/jNice.css" rel="stylesheet" type="text/css" media="screen,projection" />
<link href="<?php echo CO_FILES;?>/css/impromptu.css" rel="stylesheet" type="text/css" media="screen,projection" />
<link href="<?php echo CO_FILES;?>/css/fileuploader.css" rel="stylesheet" type="text/css" media="screen,projection" />
<!-- include app specific css -->
<?php
foreach($controller->applications as $app => $display) {
	echo '<link href="' . CO_FILES . '/css/apps/' . $app . '.css" rel="stylesheet" type="text/css" />';
}
?>
<script type="text/javascript">
var num_apps = <?php echo($num_apps);?>;
var co_files = '<?php echo CO_FILES;?>';
</script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript" src="tiny_mce/jquery.tinymce.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo CO_FILES;?>/js/libraries/datejs/date.js"></script>
<script type="text/javascript" src="<?php echo CO_FILES;?>/js/libraries/datejs/de-AT.js"></script>
<script type="text/javascript" src="<?php echo CO_FILES;?>/js/libraries/datejs/time.js"></script>
<?php if($session->userlang != 'en') { ?>
<script type="text/javascript" src="<?php echo CO_FILES;?>/js/libraries/ui.datepicker-<?php echo($session->userlang); ?>.js"></script>
<?php } ?>
<script type="text/javascript" src="<?php echo CO_FILES;?>/js/libraries/jquery.livequery-1.1.1.min.js"></script>
<script type="text/javascript" src="<?php echo CO_FILES;?>/js/libraries/jquery.quicksearch.js"></script>
<script type="text/javascript" src="<?php echo CO_FILES;?>/js/libraries/jquery.form-2.43.js"></script>
<script type="text/javascript" src="<?php echo CO_FILES;?>/js/libraries/jquery.layout-1.3.0.js"></script>
<!-- new scrollpane-->
<script type="text/javascript" src="<?php echo CO_FILES;?>/js/libraries/jquery.mousewheel.js"></script>
<script type="text/javascript" src="<?php echo CO_FILES;?>/js/libraries/mwheelIntent.js"></script>
<script type="text/javascript" src="<?php echo CO_FILES;?>/js/libraries/jquery.jscrollpane.min.js"></script> 
<!-- ns -->
<!--<script type="text/javascript" src="js/jScrollPane.js"></script>-->
<script type="text/javascript" src="<?php echo CO_FILES;?>/js/libraries/jquery.jNice.js"></script>
<script type="text/javascript" src="<?php echo CO_FILES;?>/js/libraries/jquery-impromptu.3.1.min.js"></script>
<script type="text/javascript" src="<?php echo CO_FILES;?>/js/libraries/jquery.tooltip.min.js"></script>
<script type="text/javascript" src="<?php echo CO_FILES;?>/js/libraries/jquery.resize-1.1.js"></script>
<script type="text/javascript" src="<?php echo CO_FILES;?>/js/libraries/fileuploader.js"></script>
<script type="text/javascript" src="<?php echo CO_FILES;?>/js/lang/<?php echo($session->userlang); ?>.js"></script>
<script type="text/javascript" src="<?php echo CO_FILES;?>/js/init.js"></script>
<script type="text/javascript">
<?php // set app init display vars
foreach($controller->applications as $app => $display) {
echo "var " . $app . "_display = " . $display . ";\n";
echo "var " . $app . "_num_modules = " . ${$app}->num_modules . ";\n";
}
?>
</script>
<?php // include app specific js
foreach($controller->applications as $app => $display) {
	echo '<script type="text/javascript" src="' . CO_FILES . '/js/apps/' . $app . '/init.js"></script>';
	//echo '<script type="text/javascript" src="' . CO_FILES . '/js/apps/' . $app . '/interface.js"></script>';
	foreach(${$app}->modules as $module => $value) {
		echo '<script type="text/javascript" src="' . CO_FILES . '/js/apps/' . $app . '/' . $module . '.js"></script>';
	}
}
?>
</head>
<body>
<div id="intro"><div id="intro-content"><p><img src="<?php echo CO_FILES;?>/img/ajax-loader.gif" alt="Loading" width="32" height="32" /></p></div></div>
<div id="container">
<div id="container-inner">
<?php
foreach($controller->applications as $app => $display) {
	include(CO_INC . "/apps/".$app . "/view.php");
}?>
</div>
<?php
include(CO_INC . "/view/footer.php");
?>
</div>
<div id="tooltip-simple"></div>
<div id="modalDialog"></div>
<div id="modalDialogTime"></div>
<div id="modalDialogForward" title="Weiterleitung">
    <table border="0" cellspacing="0" cellpadding="0" class="table-title">
      <tr>
        <td class="tcell-left text11"><a href="Subject" class="content-nav"><span>Subject</span></a></td>
        <td><input type="text" id="forward-subject" name="forwardSubject" class="title textarea-title" value="Subject" /></td>
      </tr>
    </table>
    <table border="0" cellpadding="0" cellspacing="0" class="table-content">
        <tr>
            <td class="tcell-left text11"><a href="#" class="content-nav showDialog" request="getContactsDialog" field="to" title="" append="1"><span>To</span></a></td>
            <td class="tcell-right"><div id="to" class="itemlist-field"></div></td>
        </tr>
    </table>
    <div class="content-spacer"></div>
    <table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-protocol">
      <tr>
        <td class="tcell-left text11"><a href="#" class="content-nav activateToolbar"><span>To:</span></a></td>
        <td class="tcell-right"><textarea></textarea></td>
      </tr>
      <tr>
        <td class="tcell-left text11"><a href="#" class="content-nav activateToolbar"><span>To:</span></a></td>
        <td class="tcell-right"><a href="#" class="actionForwardSend">Senden</a></td>
      </tr>
    </table>
</div>
<iframe id="documentloader" name="documentloader" src="about:blank" style="position: absolute; top: -1000px; left: -1000px;" /></iframe>
</body>
</html>