/* feedbacks Object */
function trainingsFeedbacks(name) {
	this.name = name;

	this.formProcess = function(formData, form, poformOptions) {}
	this.formResponse = function(data) {}
	this.poformOptions = { beforeSubmit: this.formProcess, dataType: 'json', success: this.formResponse };

	this.getDetails = function(moduleidx,liindex,list) {
		var id = $("#trainings3 ul:eq("+moduleidx+") .module-click:eq("+liindex+")").attr("rel");
		$('#trainings').data({ "third" : id});
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/trainings/modules/feedbacks&request=getDetails&id="+id, success: function(data){
			$("#trainings-right").html(data.html);
			
			if(list == 0) {
				switch (data.access) {
					case "sysadmin": case "admin":
						trainingsActions(0);
					break;
					case "guest":
						trainingsActions(5);
					break;
				}
			} else {
				switch (data.access) {
					case "sysadmin": case "admin" :
						if(list == "<li></li>") {
							trainingsActions(3);
						} else {
							trainingsActions(0);
						}
					break;
					case "guest":
						if(list == "<li></li>") {
							trainingsActions();
						} else {
							trainingsActions(5);
						}
					break;
				}
				
			}
			initTrainingsContentScrollbar();
			}
		});	
	}


	this.checkIn = function(id) {
		return true;
	}
	
	
	this.actionRefresh = function() {
		var id = $("#trainings").data("third");
		var pid = $("#trainings").data("second");
		$("#trainings3 ul[rel=feedbacks] .active-link").trigger("click");
		$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/trainings/modules/feedbacks&request=getList&id="+pid, success: function(data){																																																																				
			$("#trainings3 ul[rel=feedbacks]").html(data.html);
			$('#trainings_feedbacks_items').html(data.items);
			var liindex = $("#trainings3 ul[rel=feedbacks] .module-click").index($("#trainings3 ul[rel=feedbacks] .module-click[rel='"+id+"']"));
			$("#trainings3 ul[rel=feedbacks] .module-click:eq("+liindex+")").addClass('active-link');
			}
		});
	}


	this.actionPrint = function() {
		var id = $("#trainings").data("third");
		var url ='/?path=apps/trainings/modules/feedbacks&request=printDetails&id='+id;
		$("#documentloader").attr('src', url);
	}


	this.actionSend = function() {
		var id = $("#trainings").data("third");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/trainings/modules/feedbacks&request=getSend&id="+id, success: function(data){
			$("#modalDialogForward").html(data.html).dialog('open');
			if(data.error == 1) {
				$.prompt('<div style="text-align: center">' + ALERT_REMOVE_RECIPIENT + data.error_message + '<br /></div>');
				return false;
			}
			}
		});
	}

	this.actionSendtoResponse = function() {
		var id = $("#trainings").data("third");
		$.ajax({ type: "GET", url: "/", data: "path=apps/trainings/modules/feedbacks&request=getSendtoDetails&id="+id, success: function(html){
			$("#trainingsfeedback_sendto").html(html);
			//$("#modalDialogForward").dialog('close');
			}
		});
	}

	this.actionDialog = function(offset,request,field,append,title,sql) {
		switch(request) {
			case "getAccessDialog":
				$.ajax({ type: "GET", url: "/", data: 'path=apps/trainings&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
					$("#modalDialog").html(html);
					//$("#modalDialog").dialog('option', 'height', 50);
					$("#modalDialog").dialog('option', 'position', offset);
					$("#modalDialog").dialog('option', 'title', title);
					$("#modalDialog").dialog('open');
					}
				});
			break;
			case "getFeedbackStatusDialog":
				$.ajax({ type: "GET", url: "/", data: 'path=apps/trainings/modules/feedbacks&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
					$("#modalDialog").html(html);
					$("#modalDialog").dialog('option', 'position', offset);
					$("#modalDialog").dialog('option', 'title', title);
					$("#modalDialog").dialog('open');
					}
				});
			break;
			case "getFeedbackCatDialog":
				$.ajax({ type: "GET", url: "/", data: 'path=apps/trainings/modules/feedbacks&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
					$("#modalDialog").html(html);
					$("#modalDialog").dialog('option', 'position', offset);
					$("#modalDialog").dialog('option', 'title', title);
					$("#modalDialog").dialog('open');
					}
				});
			break;
			case "getDocumentsDialog":
				var id = $("#trainings").data("second");
				$.ajax({ type: "GET", url: "/", data: 'path=apps/trainings/modules/documents&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql+'&id=' + id, success: function(html){
					$("#modalDialog").html(html);
					$("#modalDialog").dialog('option', 'position', offset);
					$("#modalDialog").dialog('option', 'title', title);
					$("#modalDialog").dialog('open');
					}
				});
			break;
			default:
			$.ajax({ type: "GET", url: "/", data: 'path=apps/trainings&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
				$("#modalDialog").html(html);
				$("#modalDialog").dialog('option', 'position', offset);
				$("#modalDialog").dialog('option', 'title', title);
				$("#modalDialog").dialog('open');
				if($("#" + field + "_ct .ct-content").length > 0) {
					var ct = $("#" + field + "_ct .ct-content").html();
					ct = ct.replace(CUSTOM_NOTE + " ","");
					$("#custom-text").val(ct);
				}
				}
			});
		}
	}

	this.actionHelp = function() {
		var url = "/?path=apps/trainings/modules/feedbacks&request=getHelp";
		$("#documentloader").attr('src', url);
	}
		
}

var trainings_feedbacks = new trainingsFeedbacks('trainings_feedbacks');

$(document).ready(function() {				   
	$(document).on('click', '.feedback-outer.active span',function(e) {
		e.preventDefault();
		var q = $(this).attr('rel');
		var val = $(this).attr('v');
		$(this).siblings().removeClass('active');
		$(this).addClass('active');
		
		// update question %
		$('#'+q+'_result').html(val*20);
		
		var total = 0;
		$('#trainings .feedback-outer span').each( function() {
			if($(this).hasClass('active'))	{
				total = total + parseInt($(this).attr('v'));
			}
		})
		var res = Math.round(100/25*total);
		$('#total_result').html(res);
		var id = $('#trainings').data('third');
		$.ajax({ type: "GET", url: "/", data: "path=apps/trainings/modules/feedbacks&request=updateQuestion&id=" + id + "&field=feedback_" + q + "&val=" + val, cache: false });
		
	});
	
});	