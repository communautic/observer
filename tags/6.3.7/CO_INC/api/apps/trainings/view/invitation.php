<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $lang["APPLICATION_NAME"];?></title>
<link rel="icon" type="image/x-icon" href="<?php echo CO_FILES;?>/img/favicon.ico" sizes="64x64" />
<link href="<?php echo CO_FILES;?>/css/reset.css" rel="stylesheet" type="text/css" media="screen,projection" />
<link href="<?php echo CO_PATH_URL;?>/data/templates/css/orders.css" rel="stylesheet" type="text/css" media="screen,projection" />
<script src="<?php echo $protocol;?>ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo CO_FILES;?>/js/libraries/jquery.form.js"></script>
<script type="text/javascript">

$(document).ready(function() {
	
	$('#com-orderform').ajaxForm({
        success: function(data) {
			if (data == 1) {
				$('#com-orderform').html("Einladung erfolgreich gespeichert. Sie können das Browser-Fenster jetzt schließen.");
			} else {
				$("#loginFailed").fadeIn();
			}
        }
    });

});
</script>
</head>
<body>
Einladung
    
<?php
while($row = mysql_fetch_array($result)) {
	$memberid = $row['id'];
}



?>
<form id="com-orderform" name="com_form" method="post" action="/?path=api/apps/trainings">
<input type="hidden" name="request" value="acceptinvitation" />
<input type="hidden" name="key" value="<?php echo $key;?>" />
<input type="hidden" name="id" value="<?php echo $memberid;?>" />
<p>&nbsp;</p>
<input type="submit" name="button" id="button" value="bestätigen" />
</form>
</body>
</html>
