<?php
include_once("session.php");

// init error handler
$errorvar = 0;
// check if this page is called through ajax
//if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest')) {
//	$errorvar = 1;
//}
// check if user is loged in
if(!$session->logged_in){
	$errorvar = 1;
}
if($errorvar == 1) {?>
    <head>
        <script language="JavaScript1.1">
        <!--
            window.location.href="<?php echo(CO_PATH_URL);?>";
        //-->
        </script>
    </head>
<?php exit;
}
?>