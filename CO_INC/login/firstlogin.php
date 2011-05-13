<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $lang["APPLICATION_NAME"];?></title>
<link href="<?php echo CO_FILES;?>/img/favicon.ico" rel="shortcut icon" type="image/x-icon" />
<link href="<?php echo CO_FILES;?>/css/login/styles.css" rel="stylesheet" type="text/css" media="screen,projection" />
<!--[if IE 8]>
<link href="<?php echo CO_FILES;?>/css/login/ie8.css" rel="stylesheet" type="text/css" media="screen,projection" />
<![endif]-->
<!--[if lt IE 8]>
<link href="<?php echo CO_FILES;?>/css/login/ie.css" rel="stylesheet" type="text/css" media="screen,projection" />
<![endif]-->
<link rel="stylesheet" href="<?php echo CO_FILES;?>/css/login/validationEngine.jquery.css" type="text/css"/>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.0/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo CO_FILES;?>/js/libraries/jquery.form.js"></script>
<script src="<?php echo CO_FILES;?>/js/lang/validation/jquery.validationEngine-<?php echo $session->userlang;?>.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo CO_FILES;?>/js/libraries/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>

<script type="text/javascript">

$(document).ready(function() {		   
	$(".opac").css("opacity", "0.5");
	document.com_form.username.focus();
	
	$('#com-form').validationEngine(); 
	
	$(".com-input").focus(function () {
        $("#loginFailed").fadeOut();
    });
	$('#com-form').ajaxForm({
        success: function(data) {
			if (data == 1) {
				document.location.href='<?php echo CO_PATH_URL;?>';
			} else {
				$("#loginFailed").fadeIn();
			}
        }
    });

});
</script>
</head>
<body>
<div id="header-tile"></div>
<div id="header-logos"><table width="941" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="782" valign="top"><a href="http://www.communautic.com" target="_blank"><img src="<?php echo CO_FILES;?>/img/login/cn_logo.gif" alt="communautic" width="221" height="39" border="0" /></a></td>
    <td valign="top"><a href="http://www.communautic.com" target="_blank"><img src="<?php echo CO_FILES;?>/img/login/co_logo.png" alt="project observer" width="206" height="22" border="0" style="margin-top: 22px" /></a></td>
  </tr>
</table></div>
<div id="top-grey-bar" class="opac">&nbsp;</div>
<div id="fl-top-green-bar" class="opac">&nbsp;</div>
<div id="fl-mid-green-bar" class="opac">&nbsp;</div>
<div id="fl-bot-green-bar" class="opac">&nbsp;</div>
<div id="fl-bot-grey-bar" class="opac">&nbsp;</div>
<div id="login-outer"><form id="com-form" name="com_form" method="post" action="/?path=login">
<input type="hidden" name="changelogin" value="1" />
<div class="fl-bar-outer-top"><table width="445" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><p style="text-align: justify"><?php echo $lang["LOGIN_SET_LOGIN"];?></p></td>
  </tr>
  </table></div>
<div class="fl-bar-outer"><table width="445" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="175" valign="top" class="login-text"><?php echo($lang["LOGIN_USERNAME"]);?></td>
    <td valign="top"><input name="username" type="text" class="validate[required,minSize[6],custom[onlyLetterNumber],ajax[ajaxUsernameCallPhp]] com-input" id="username" value="" />
        <br /></td>
  </tr>
  <tr>
      <td height="25" valign="top" class="login-text">&nbsp;</td>
      <td valign="middle">(min. 6 Zeichen, a-z, A-Z, 0-9)</td>
  </tr>
  </table>
</div>
  <div class="fl-bar-outer"><table width="445" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="175" valign="top" class="login-text"><?php echo($lang["LOGIN_PASSWORD"]);?></td>
    <td valign="top"><input id="password" type="password" name="password" class="validate[required,minSize[6]custom[onlyLetterNumberSpecial]] com-input" value="" /></td>
  </tr>
    <tr>
      <td height="25" valign="top" class="login-text">&nbsp;</td>
      <td valign="middle">(min. 6 Zeichen, a-z, A-Z, 0-9, @?!)</td>
  </tr>
  </table></div>
  <div style="height: 40px;"><table width="445" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
    <td width="175" valign="top" class="login-text"><?php echo($lang["LOGIN_PASSWORD_REPEAT"]);?></td>
    <td valign="top"><input type="password" id="password2" name="password2" value="" class="validate[required,equals[password]] com-input" /></td>
  </tr>
    </table></div>
    <table width="445" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
    <td colspan="3" valign="top" class="login-copyright"><input type="submit" name="button" id="button" value="<?php echo($lang["LOGIN_CONFIRM"]);?>" /></td>
    </tr>
</table></form>
</div>
</body>
</html>
