<?php 
$form_path = "login";
$form_result_path = "";
if(isset($_GET['path'])) {
	$form_path =  htmlentities($_GET['path']) . "/login";
	$form_result_path =  "?path=" . htmlentities($_GET['path']);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
<title><?php echo $lang["APPLICATION_NAME"];?></title>
<link rel="icon" type="image/x-icon" href="<?php echo CO_FILES;?>/img/favicon.ico" sizes="64x64" />
<link href="<?php echo CO_FILES;?>/css/login/styles.css" rel="stylesheet" type="text/css" media="screen,projection" />
<!--[if IE 8]>
<link href="<?php echo CO_FILES;?>/css/login/ie8.css" rel="stylesheet" type="text/css" media="screen,projection" />
<![endif]-->
<!--[if lt IE 8]>
<link href="<?php echo CO_FILES;?>/css/login/ie.css" rel="stylesheet" type="text/css" media="screen,projection" />
<![endif]-->
<script src="<?php echo $protocol;?>ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo CO_FILES;?>/js/libraries/jquery.form.js"></script>
<script type="text/javascript">

$(document).ready(function() {
						   
	$(".opac").css("opacity", "0.5");
	
	document.com_form.user.focus();
	
	$(".com-input").focus(function () {
        $("#loginFailed").fadeOut();
    });
	
	$('#com-form').ajaxForm({
        success: function(data) {
			if (data == 1) {
				document.location.href='<?php echo CO_PATH_URL . $form_result_path;?>';
			} else {
				$("#loginFailed").fadeIn();
			}
        }
    });
	
	/*$(".System-hover").hover(
		function () {
			$("#System").fadeIn();
		}, 
		function () {
			$("#System").fadeOut();
		}
	);*/

});
</script>
</head>
<body>
<div id="header-tile"></div>
<div id="header-logos"><table width="941" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="782" valign="top"><a href="http://www.communautic.com" target="_blank"><img src="<?php echo CO_FILES;?>/img/login/cn_logo.gif" alt="communautic" width="221" height="39" border="0" /></a></td>
    <td valign="top"><a href="http://www.communautic.com" target="_blank"><img src="<?php echo CO_FILES;?>/img/login/<?php echo $lang["APPLICATION_LOGO_LOGIN"];?>" alt="<?php echo $lang["APPLICATION_NAME_ALT"];?>" width="206" height="22" border="0" style="margin-top: 22px" /></a></td>
  </tr>
</table></div>
<div id="top-green-bar" class="opac">&nbsp;</div>
<div id="bot-green-bar" class="opac">&nbsp;</div>
<div id="grey-bar" class="opac">&nbsp;</div>
<div id="login-outer"><form id="com-form" name="com_form" method="post" action="/?path=<?php echo $form_path; ?>">
<input type="hidden" name="sublogin" value="1" /><div class="bar-outer"><table width="493" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="121" valign="top" class="login-text"><?php echo($lang["LOGIN_USERNAME"]);?></td>
    <td width="320" valign="top"><input type="text" name="user" class="com-input" /></td>
    <td width="52" valign="top"><div id="loginFailed" class="popup"><div class="popup-inner"><?php echo($lang["LOGIN_LOGIN_FAILED"]);?></div></div><div id="System" class="popup">
      <div class="popup-inner"><?php echo($lang["LOGIN_REQUIREMENTS_DETAILS"]);?></div></div></td>
  </tr>
  </table></div>
  <div class="bar-outer"><table width="493" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="121" valign="top" class="login-text"><?php echo($lang["LOGIN_PASSWORD"]);?></td>
    <td valign="top"><input type="password" name="pass" class="com-input" /></td>
    <td valign="top" class="right"><input type="submit" name="button" id="button" value="<?php echo($lang["LOGIN_LOGIN"]);?>" /></td>
  </tr>
  </table></div>
  <div style="height: 106px"><table width="493" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td width="235" valign="top" class="login-text"><?php echo($lang["LOGIN_REMEMBER"]);?></td>
        <td width="30" class="login-text"><input type="checkbox" name="remember" value="yes" /></td>
        <td valign="top" class="login-text right"><!--<a href="#" class="System-hover"><?php echo($lang["LOGIN_REQUIREMENTS"]);?></a>-->&nbsp;</td>
      </tr>
    </table></div>
    <table width="493" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
    <td colspan="3" valign="top" class="login-copyright"><?php echo($lang["LOGIN_COPYRIGHT"]);?></td>
    </tr>
</table></form>
</div>
<script type="text/javascript"> 
var $buoop = {vs:{i:8,f:4,o:11,s:5,n:9}} 
$buoop.ol = window.onload; 
window.onload=function(){ 
 try {if ($buoop.ol) $buoop.ol();}catch (e) {} 
 var e = document.createElement("script"); 
 e.setAttribute("type", "text/javascript"); 
 //e.setAttribute("src", "http://browser-update.org/update.js"); 
 e.setAttribute("src", "<?php echo CO_FILES;?>/js/libraries/browser-update.js"); 
 document.body.appendChild(e); 
} 
</script> 
</body>
</html>
