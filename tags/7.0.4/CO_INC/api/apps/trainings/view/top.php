<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $lang["APPLICATION_NAME"];?></title>
<meta name="viewport" content="initial-scale=1, maximum-scale=1" />
<link rel="icon" type="image/x-icon" href="<?php echo CO_FILES;?>/img/favicon.ico" sizes="64x64" />
<link href="<?php echo CO_FILES;?>/css/reset.css" rel="stylesheet" type="text/css" media="screen,projection" />
<link href="<?php echo CO_FILES;?>/css/impromptu.css" rel="stylesheet" type="text/css" media="screen,projection" />
<link href="<?php echo CO_PATH_URL;?>/data/templates/trainings/style.css" rel="stylesheet" type="text/css" media="screen,projection" />
<!--[if gte IE 9]>
  <style type="text/css">
    #navigation .active, #header-left, #header-right, .button, .button:hover, .button.disabled {
       filter: none;
    }
  </style>
<![endif]-->
<script src="<?php echo $protocol;?>ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo CO_FILES;?>/js/libraries/jquery.form.js"></script>
<script type="text/javascript" src="<?php echo CO_FILES;?>/js/libraries/jquery-impromptu.min.js"></script>
<script type="text/javascript">
// Application loader - activate once all is finished 
//$(document).ajaxStop(function() {

//});
</script>
<script type="text/javascript">
$(document).ready(function() {
						   
	$("#intro").show().delay(2000).fadeOut("slow", function() { $(this).remove(); }); 
	
	$(document).on('click', '.feedback-outer span',function(e) {
		e.preventDefault();
		var q = $(this).attr('rel');
		var val = $(this).attr('v');
		$('#'+q).val(val);
		$(this).siblings().removeClass('active');
		$(this).addClass('active');
		/*var total = 0;
		if(tab == 'tab1') {
			$('#EmployeesObjectivesFirst .answers-outer span').each( function() {
				 if($(this).hasClass('active'))	{
					 total = total + parseInt($(this).html());
				 }
			})
			var res = Math.round(100/50*total);
		} else {
			$('#EmployeesObjectivesSecond .answers-outer span').each( function() {
			 if($(this).hasClass('active'))	{
				 total = total + parseInt($(this).html());
			 }
		})
			//var res = total;
			var res = Math.round(100/50*total);
		}
		$('#'+tab+'result').html(res);
		// ajax call
		var pid = $('#employees').data('third');
		var field = tab+q;
		$.ajax({ type: "GET", url: "/", data: "path=apps/employees/modules/objectives&request=updateQuestion&id=" + pid + "&field=" + field + "&val=" + val, cache: false });*/
		
	});
	
	$(document).on('click', '#feedbackSubmit',function(e) {
		e.preventDefault();
		var q1 = $('#q1').val();
		var q2 = $('#q2').val();
		var q3 = $('#q3').val();
		var q4 = $('#q4').val();
		var q5 = $('#q5').val();
		if(q1 == '' || q2 == '' || q3 == '' || q4 == '' || q5 == '') {
			$.prompt('Bitte beurteilen Sie alle Fragen.');
		} else {
			$('#feedback').submit();
		}
	});
});
</script>
</head>
<body>
<!-- application loader -->
<div id="intro" style="top:0; left: 0"><div id="intro-content"><img src="<?php echo CO_FILES;?>/img/ajax-loader-lite.gif" alt="loading" width="32" height="32" /></div></div>
<div id="center">
	<div id="header"></div>
<div id="main">