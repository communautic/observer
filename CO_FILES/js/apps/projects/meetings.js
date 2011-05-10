/* meetings Object */
var meetings = new Module('meetings');
meetings.path = 'apps/projects/modules/meetings/';
meetings.getDetails = getDetailsMeeting;
meetings.sortclick = sortClickMeeting;
meetings.sortdrag = sortDragMeeting;
meetings.actionDialog = dialogMeeting;
//meetings.addTask = addTaskMeeting;
meetings.deleteTask = deleteTask;
meetings.actionNew = newMeeting;
meetings.actionPrint = printMeeting;
meetings.actionSend = sendMeeting;
meetings.actionSendtoResponse = sendMeetingResponse;
meetings.actionDuplicate = duplicateMeeting;
meetings.actionBin = binMeeting;
meetings.poformOptions = { beforeSubmit: meetingFormProcess, dataType:  'json', success: meetingFormResponse };
meetings.toggleIntern = meetingToggleIntern;


function getDetailsMeeting(moduleidx,liindex,list) {
	var id = $("#projects3 ul:eq("+moduleidx+") .module-click:eq("+liindex+")").attr("rel");
	$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects/modules/meetings&request=getDetails&id="+id, success: function(data){
		$("#projects-right").html(data.html);
		if(list == 0) {
			switch (data.access) {
				case "sysadmin": case "admin":
					projectsActions(0);
				break;
				case "guest":
					projectsActions(5);
				break;
			}
		} else {
			switch (data.access) {
				case "sysadmin": case "admin" :
					if(list == "<li></li>") {
						projectsActions(3);
					} else {
						projectsActions(0);
						$('#projects3').find('input.filter').quicksearch('#projects3 li');
					}
				break;
				case "guest":
					if(list == "<li></li>") {
						projectsActions();
					} else {
						projectsActions(5);
						$('#projects3').find('input.filter').quicksearch('#projects3 li');
					}
				break;
			}
			
		}
		initContentScrollbar();
		}
	});
}


function meetingFormProcess(formData, form, poformOptions) {
	var title = $("#projects .title").fieldValue();
	if(title == "") {
		$.prompt(ALERT_NO_TITLE, {callback: setTitleFocus});
		return false;
	} else {
		formData[formData.length] = { "name": "title", "value": title };
	}
	
	$("#meetingtasks > div").each(function() {
		var id = $(this).attr('id');
		var reg = /[0-9]+/.exec(id);
		var yo = "task_text_"+reg;
		var name = "task_text["+reg+"]";
		if($('#task_'+reg+' :input[name="task_text_'+reg+'"]').length > 0) {
			//var text = $('#'+yo).tinymce().getContent();
			var text = $('#'+yo).val();
			for (var i=0; i < formData.length; i++) { 
				if (formData[i].name == yo) { 
					formData[i].name = name;
					formData[i].value = text;
				} 
			}
		} else {
			var text = $('#'+yo).html();
			formData[formData.length] = { "name": name, "value": text };
		}
	});
	
	formData[formData.length] = processList('participants');
	formData[formData.length] = processCustomText('participants_ct');
	formData[formData.length] = processList('management');
	formData[formData.length] = processCustomText('management_ct');
	formData[formData.length] = processList('location');
	formData[formData.length] = processCustomText('location_ct');
	formData[formData.length] = processString('meetingstart');
	formData[formData.length] = processString('meetingend');
	formData[formData.length] = processList('meeting_relates_to');
	formData[formData.length] = processDocList('documents');
	formData[formData.length] = processList('meeting_access');
	formData[formData.length] = processList('meeting_status');
}


function meetingFormResponse(data) {
	switch(data.action) {
		case "edit":
			$("#projects3 span[rel='"+data.id+"'] .text").html($("#projects .meeting_date").val() + ' - ' +$("#projects .title").val());
				switch(data.access) {
					case "0":
						$("#projects3 .active-link .module-access-status").removeClass("module-access-active");
					break;
					case "1":
						$("#projects3 .active-link .module-access-status").addClass("module-access-active");
					break;
				}
				
				switch(data.status) {
					case "1":
						$("#projects3 .active-link .module-item-status").addClass("module-item-active");
					break;
					default:
						$("#projects3 .active-link .module-item-status").removeClass("module-item-active");
				}
		break;
		case "reload":
			var id = $("#projects2 .module-click:visible").attr("rel");
			$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/projects/modules/meetings&request=getList&id="+id, success: function(list){
				$(".projects3-content:visible ul").html(list.html);
				var moduleidx = $(".projects3-content").index($(".projects3-content:visible"));
				var liindex = $(".projects3-content:visible .module-click").index($(".projects3-content:visible .module-click[rel='"+data.id+"']"));
				getDetailsMeeting(moduleidx,liindex);
				$("#projects3 .projects3-content:visible .module-click:eq("+liindex+")").addClass('active-link');
				}
			});
		break;
	}
}


function newMeeting() {
	var id = $('#projects2 .module-click:visible').attr("rel");
	$.ajax({ type: "GET", url: "/", dataType: 'json', data: 'path=apps/projects/modules/meetings&request=createNew&id=' + id, cache: false, success: function(data){
			$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/projects/modules/meetings&request=getList&id="+id, success: function(list){
				$(".projects3-content:visible ul").html(list.html);
				var liindex = $(".projects3-content:visible .module-click").index($(".projects3-content:visible .module-click[rel='"+data.id+"']"));
				$(".projects3-content:visible .module-click:eq("+liindex+")").addClass('active-link');
				var moduleidx = $(".projects3-content").index($(".projects3-content:visible"));
				getDetailsMeeting(moduleidx,liindex);
				$('#projects3 input.filter').quicksearch('#projects3 li');
				}
			});
		}
	});
}


function printMeeting() {
	var id = $("#projects3 .active-link:visible").attr("rel");
	var url ='/?path=apps/projects/modules/meetings&request=printDetails&id='+id;
	location.href = url;
}


function sendMeeting() {
	var id = $("#projects3 .active-link:visible").attr("rel");
	$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/meetings&request=getSend&id="+id, success: function(html){
		$("#modalDialogForward").html(html).dialog('open');
		}
	});
}

function sendMeetingResponse() {
	var id = $("#projects3 .active-link:visible").attr("rel");
	$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/meetings&request=getSendtoDetails&id="+id, success: function(html){
		$("#meeting_sendto").html(html);
		$("#modalDialogForward").dialog('close');
		}
	});
}


function duplicateMeeting() {
	var id = $("#projects3 .active-link:visible").attr("rel");
	var pid = $("#projects2 .module-click:visible").attr("rel");
	$.ajax({ type: "GET", url: "/", data: 'path=apps/projects/modules/meetings&request=createDuplicate&id=' + id, cache: false, success: function(mid){
		$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/projects/modules/meetings&request=getList&id="+pid, success: function(data){																																																																				
			$(".projects3-content:visible ul").html(data.html);
			var moduleidx = $(".projects3-content").index($(".projects3-content:visible"));
			var liindex = $(".projects3-content:visible .module-click").index($(".projects3-content:visible .module-click[rel='"+mid+"']"));
			//var list = 0;
			getDetailsMeeting(moduleidx,liindex);
			$(".projects3-content:visible .module-click:eq("+liindex+")").addClass('active-link');
			//projectsActions(0);
			$('#projects3 input.filter').quicksearch('#projects3 li');
			}
		});
		}
	});
}


function binMeeting() {
	var txt = ALERT_DELETE;
	var langbuttons = {};
	langbuttons[ALERT_YES] = true;
	langbuttons[ALERT_NO] = false;
	$.prompt(txt,{ 
		buttons:langbuttons,
		callback: function(v,m,f){		
			if(v){
				var id = $("#projects3 .active-link:visible").attr("rel");
				var pid = $("#projects2 .module-click:visible").attr("rel");
				$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/meetings&request=binMeeting&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects/modules/meetings&request=getList&id="+pid, success: function(data){
								$(".projects3-content:visible ul").html(data.html);
								if(data.html == "<li></li>") {
									projectsActions(3);
								} else {
									projectsActions(0);
									$('#projects3 input.filter').quicksearch('#projects3 li');
								}
								var moduleidx = $(".projects3-content").index($(".projects3-content:visible"));
								var liindex = 0;
								getDetailsMeeting(moduleidx,liindex);
								$("#projects3 .projects3-content:visible .module-click:eq("+liindex+")").addClass('active-link');
							}
							});
						}
					}
				});
			} 
		}
	});
}


function sortClickMeeting(obj,sortcur,sortnew) {
	var fid = $("#projects2 .module-click:visible").attr("rel");
	$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects/modules/meetings&request=getList&id="+fid+"&sort="+sortnew, success: function(data){
		$(".projects3-content:visible ul").html(data.html);
		obj.attr("rel",sortnew);
		obj.removeClass("sort"+sortcur).addClass("sort"+sortnew);
		var id = $(".projects3-content:visible .module-click:eq(0)").attr("rel");
		if(id == undefined) {
			return false;
		}
		var moduleidx = $(".projects3-content").index($(".projects3-content:visible"));
		var liindex = 0;
		getDetailsMeeting(moduleidx,liindex);
		$("#projects3 .projects3-content:visible .module-click:eq("+liindex+")").addClass('active-link');
	}
	});
}


function sortDragMeeting(order) {
	var fid = $("#projects2 .module-click:visible").attr("rel");
	$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/meetings&request=setOrder&"+order+"&id="+fid, success: function(html){
		$("#projects3 .sort:visible").attr("rel", "3");
		$("#projects3 .sort:visible").removeClass("sort1").removeClass("sort2").addClass("sort3");
		}
	});
}


function meetingToggleIntern(id,status,obj) {
	$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/meetings&request=toggleIntern&id=" + id + "&status=" + status, cache: false, success: function(data){
		if(data == "true") {
			obj.toggleClass("module-item-active")
		}
		}
	});
}


function dialogMeeting(offset,request,field,append,title,sql) {
	switch(request) {
		case "getAccessDialog":
			$.ajax({ type: "GET", url: "/", data: 'path=apps/projects&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
				$("#modalDialog").html(html);
				//$("#modalDialog").dialog('option', 'height', 50);
				$("#modalDialog").dialog('option', 'position', offset);
				$("#modalDialog").dialog('option', 'title', title);
				$("#modalDialog").dialog('open');
				}
			});
		break;
		case "getMeetingStatusDialog":
			$.ajax({ type: "GET", url: "/", data: 'path=apps/projects/modules/meetings&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
				$("#modalDialog").html(html);
				$("#modalDialog").dialog('option', 'position', offset);
				$("#modalDialog").dialog('option', 'title', title);
				$("#modalDialog").dialog('open');
				}
			});
		break;
		case "getDocumentsDialog":
			var id = $("#projects2 .module-click:visible").attr("rel");
			$.ajax({ type: "GET", url: "/", data: 'path=apps/projects/modules/documents&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql+'&id=' + id, success: function(html){
				$("#modalDialog").html(html);
				$("#modalDialog").dialog('option', 'position', offset);
				$("#modalDialog").dialog('option', 'title', title);
				$("#modalDialog").dialog('open');
				}
			});
		break;
		default:
		$.ajax({ type: "GET", url: "/", data: 'path=apps/projects&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
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


function deleteTask(id) {
	
	var txt = ALERT_DELETE;
	var langbuttons = {};
	langbuttons[ALERT_YES] = true;
	langbuttons[ALERT_NO] = false;
	$.prompt(txt,{ 
		buttons:langbuttons,
		callback: function(v,m,f){		
			if(v){
			$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/meetings&request=deleteTask&id=" + id, success: function(data){
				if(data){
					$("#task_"+id).slideUp(function(){ $(this).remove(); });
					
				} 
				}
			});
			} 
		}
	});
}


$(document).ready(function() { 
	
	
	$(".table-task tr").live('mouseover mouseout', function(event) {
	  if (event.type == 'mouseover') {
		$(this).find(".task-drag").show();
		//.animate({opacity: '1', left: '-20px'});
		
	  } else {
		//$(this).children(":first").animate({opacity: '0', left: '0px'});
		$(this).find(".task-drag").hide();
	  }
	});
	
	$(".insertMeetingStatus").live('click', function() {
	 	var rel = $(this).attr("rel");
		var html = '<div class="listmember" field="meeting_status" uid="'+rel+'" style="float: left">' + $(this).html() + '</div>';
		$("#meeting_status").html(html);
		$("#modalDialog").dialog("close");
		$("#meeting_status").next().val("");
		var obj = getCurrentModule();
		$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		return false;
	});
	
	$(".insertMeetingStatusDate").live('click', function() {
	 	var rel = $(this).attr("rel");
		var html = '<div class="listmember" field="meeting_status" uid="'+rel+'" style="float: left">' + $(this).html() + '</div>';
		$("#meeting_status").html(html);
		$("#modalDialog").dialog("close");
		$("#meeting_status").nextAll('img').trigger('click');
		return false;
	});
	
	$(".addMeetingTask").live('click', function() {
		var mid = $(".projects3-content:visible .active-link").attr("rel");
		var num = parseInt($("#projects-right .task_sort").size());
		$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/meetings&request=addTask&mid=" + mid + "&num=" + num + "&sort=" + num, success: function(html){
			$('#meetingtasks').append(html);
			var idx = parseInt($('.cbx').size() -1);
			var element = $('.cbx:eq('+idx+')');
			$.jNice.CheckAddPO(element);
			$('.meetingouter:eq('+idx+')').slideDown(function() {
				$(this).find(":text:eq(0)").focus();
				if(idx == 6) {
				$('#projects-right .addTaskTable').clone().insertAfter('#phasetasks');
				}
				initContentScrollbar();
			});
			}
		});
		return false;
	});
	
	
	// Recycle bin functions


	$(".bin-deleteMeeting").live('click',function(e) {
		var id = $(this).attr("rel");
		var txt = ALERT_DELETE_REALLY;
		var langbuttons = {};
		langbuttons[ALERT_YES] = true;
		langbuttons[ALERT_NO] = false;
		$.prompt(txt,{ 
			buttons:langbuttons,
			callback: function(v,m,f){		
				if(v){
					$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/meetings&request=deleteMeeting&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#meeting_'+id).slideUp();
						}
					}
					});
				} 
			}
		});
		return false;
	});
	
	$(".bin-restoreMeeting").live('click',function(e) {
		var id = $(this).attr("rel");
		var txt = ALERT_RESTORE;
		var langbuttons = {};
		langbuttons[ALERT_YES] = true;
		langbuttons[ALERT_NO] = false;
		$.prompt(txt,{ 
			buttons:langbuttons,
			callback: function(v,m,f){		
				if(v){
					$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/meetings&request=restoreMeeting&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#meeting_'+id).slideUp();
						}
					}
					});
				} 
			}
		});
		return false;
	});

	
	$(".bin-deleteMeetingTask").live('click',function(e) {
		var id = $(this).attr("rel");
		var txt = ALERT_DELETE_REALLY;
		var langbuttons = {};
		langbuttons[ALERT_YES] = true;
		langbuttons[ALERT_NO] = false;
		$.prompt(txt,{ 
			buttons:langbuttons,
			callback: function(v,m,f){		
				if(v){
					$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/meetings&request=deleteMeetingTask&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#meeting_task_'+id).slideUp();
						}
					}
					});
				} 
			}
		});
		return false;
	});
	
	$(".bin-restoreMeetingTask").live('click',function(e) {
		var id = $(this).attr("rel");
		var txt = ALERT_RESTORE;
		var langbuttons = {};
		langbuttons[ALERT_YES] = true;
		langbuttons[ALERT_NO] = false;
		$.prompt(txt,{ 
			buttons:langbuttons,
			callback: function(v,m,f){		
				if(v){
					$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/meetings&request=restoreMeetingTask&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#meeting_task_'+id).slideUp();
						}
					}
					});
				} 
			}
		});
		return false;
	});
	
});