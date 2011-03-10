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
meetings.actionDuplicate = duplicateMeeting;
meetings.actionBin = binMeeting;
meetings.poformOptions = { beforeSubmit: meetingFormProcess, dataType:  'json', success: meetingFormResponse };
meetings.toggleIntern = meetingToggleIntern;


function getDetailsMeeting(moduleidx,liindex) {
	var phaseid = $("#projects3 ul:eq("+moduleidx+") .module-click:eq("+liindex+")").attr("rel");
	
	//alert(moduleidx + " " + liindex + " " + phaseid);
	
	$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/meetings&request=getDetails&id="+phaseid, success: function(html){
		$("#"+projects.name+"-right").html(html);
		initContentScrollbar();
		initScrollbar( '.projects3-content:visible .scrolling-content' );
		}
	});
}


function meetingFormProcess(formData, form, poformOptions) {
	// check title
	var title = $("#projects .title").fieldValue();
	if(title == "") {
		$.prompt(ALERT_NO_TITLE, {callback: setTitleFocus});
		return false;
	} else {
		formData[formData.length] = { "name": "title", "value": title };
	}
	/*if($('#protocol').length > 0) {
		var protocol = $('#protocol').tinymce().getContent();
		for (var i=0; i < formData.length; i++) { 
			if (formData[i].name == 'protocol') { 
				formData[i].value = protocol;
			} 
		} 
	}*/
	
	$("#meetingtasks > div").each(function() {
		var id = $(this).attr('id');
		var reg = /[0-9]+/.exec(id);
		var yo = "task_text_"+reg;
		var name = "task_text["+reg+"]";
		if($('#task_'+reg+' :input[name="task_text_'+reg+'"]').length > 0) {
			var text = $('#'+yo).tinymce().getContent();
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
	
	/*$("#meetingtasks").find(':input[name^="task_text_"]').each(function() {
					//alert($(this).attr('name'));
					var id = $(this).attr('name');
					var text = $('#'+id).tinymce().getContent();
					var reg = /[0-9]+/.exec(id);
					var name = "task_text["+reg+"]";
					for (var i=0; i < formData.length; i++) { 
			if (formData[i].name == id) { 
				formData[i].name = name;
				formData[i].value = text;
			} 
		}
	})*/
	
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
			//$("#projects3 a.active-link .text").html($("#projects .meeting_date").val() + ' - ' +$("#projects .title").val());
			$("#projects3 a[rel='"+data.id+"'] .text").html($("#projects .meeting_date").val() + ' - ' +$("#projects .title").val());
				switch(data.access) {
					case "0":
						$("#projects3 a.active-link .module-access-status").removeClass("module-access-active");
					break;
					case "1":
						$("#projects3 a.active-link .module-access-status").addClass("module-access-active");
					break;
				}
				
				switch(data.status) {
					case "1":
						$("#projects3 a.active-link .module-item-status").addClass("module-item-active");
					break;
					default:
						$("#projects3 a.active-link .module-item-status").removeClass("module-item-active");
				}
		break;
		case "reload":
			var id = $("#projects2 .module-click:visible").attr("rel");
			$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/projects/modules/meetings&request=getList&id="+id, success: function(list){
				$(".projects3-content:visible ul").html(list.html);
				var index = $(".projects3-content:visible .module-click").index($(".projects3-content:visible .module-click[rel='"+data.id+"']"));
				$(".projects3-content:visible .module-click:eq("+index+")").addClass('active-link');
				//$(".projects3-content:visible .drag:eq("+index+")").show();
				$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/meetings&request=getDetails&id="+data.id, success: function(html){
					$("#projects-right").html(html);
					initContentScrollbar();
					$("#loading").fadeOut();
					}
				});
				projectsActions(0);
				}
			});
		break;
	}
}


function newMeeting() {
	var id = $('#projects2 .module-click:visible').attr("rel");
	$.ajax({ type: "GET", url: "/", dataType: 'json', data: 'path=apps/projects/modules/meetings&request=createNew&id=' + id, cache: false, success: function(data){
		//var id = $("#projects2 .module-click:visible").attr("rel");
			$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/projects/modules/meetings&request=getList&id="+id, success: function(list){
				$(".projects3-content:visible ul").html(list.html);
				var index = $(".projects3-content:visible .module-click").index($(".projects3-content:visible .module-click[rel='"+data.id+"']"));
				$(".projects3-content:visible .module-click:eq("+index+")").addClass('active-link');
				//$(".projects3-content:visible .drag:eq("+index+")").show();
				var num = index+1;
				$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/meetings&request=getDetails&id="+data.id+"&num="+num, success: function(html){
					$("#projects-right").html(html);
					initContentScrollbar();
					//$("#loading").fadeOut();
					}
				});
				projectsActions(0);
				}
			});
		}
	});
}


function printMeeting() {
	alert("in Entwicklung - siehe Druckenlink unter Projekte");
}


function duplicateMeeting() {
	var id = $("#projects3 .active-link").attr("rel");
	var pid = $("#projects2 .module-click:visible").attr("rel");
	$.ajax({ type: "GET", url: "/", data: 'path=apps/projects/modules/meetings&request=createDuplicate&id=' + id, cache: false, success: function(mid){
		$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/projects/modules/meetings&request=getList&id="+pid, success: function(data){																																																																				
			$(".projects3-content:visible ul").html(data.html);
			var moduleidx = $(".projects3-content").index($(".projects3-content:visible"));
			var liindex = $(".projects3-content:visible .module-click").index($(".projects3-content:visible .module-click[rel='"+mid+"']"));
			getDetailsMeeting(moduleidx,liindex);
			$(".projects3-content:visible .module-click:eq("+liindex+")").addClass('active-link');
			projectsActions(0);
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
				var id = $("#projects3 .active-link").attr("rel");
				var pid = $("#projects2 .module-click:visible").attr("rel");
				$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/meetings&request=binMeeting&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects/modules/meetings&request=getList&id="+pid, success: function(data){
								$(".projects3-content:visible ul").html(data.html);
								if(data.html == "<li></li>") {
									projectsActions(3);
								} else {
									projectsActions(0);
								}
								var moduleidx = $(".projects3-content").index($(".projects3-content:visible"));
								var liindex = 0;
								getDetailsMeeting(moduleidx,liindex);
								$("#projects3 .projects3-content:visible .module-click:eq("+liindex+")").addClass('active-link');
								//projectsActions(0);
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
			
			var num = $(".projects3-content:visible .phase_num:eq(0)").html();
			
		  $.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/meetings&request=getDetails&id="+id+"&num="+num, success: function(html){
			  $("#"+projects.name+"-right").html(html);
			  initScrollbar( '#projects .scrolling-content' );
				initContentScrollbar();
			  }
		  });
	}
	});
}


function sortDragMeeting(order) {
	var fid = $("#projects2 .module-click:visible").attr("rel");
	$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/meetings&request=setOrder&"+order+"&id="+fid, success: function(html){
		$("#projects3 a.sort:visible").attr("rel", "3");
		$("#projects3 a.sort:visible").removeClass("sort1").removeClass("sort2").addClass("sort3");
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
	
	$("a.addMeetingTask").live('click', function() {
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