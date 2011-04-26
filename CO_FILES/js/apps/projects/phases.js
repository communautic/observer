/* phases Object */
var phases = new Module('phases');
phases.path = 'apps/projects/modules/phases/';
phases.getDetails = getDetailsPhase;
phases.sortclick = sortClickPhase;
phases.sortdrag = sortDragPhase;
phases.actionDialog = dialogPhase;
//phases.addTask = addTaskPhase;
phases.deleteTask = deleteTask;
phases.actionNew = newPhase;
phases.actionPrint = printPhase;
phases.actionSend = sendPhase;
phases.actionSendtoResponse = sendPhaseResponse;
phases.actionDuplicate = duplicatePhase;
phases.actionBin = binPhase;
phases.poformOptions = { beforeSubmit: phaseFormProcess, dataType:  'json', success: phaseFormResponse };
phases.toggleIntern = phaseToggleIntern;


function getDetailsPhase(moduleidx,liindex) {
	var phaseid = $("#projects3 ul:eq("+moduleidx+") .module-click:eq("+liindex+")").attr("rel");
	var num = $("#projects3 ul:eq("+moduleidx+") .phase_num:eq("+liindex+")").html();
	$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/phases&request=getDetails&id="+phaseid+"&num="+num, success: function(html){
		$("#"+projects.name+"-right").html(html);
		initContentScrollbar();
		//initScrollbar( '.projects3-content:visible .scrolling-content' );
		}
	});
}


function phaseFormProcess(formData, form, poformOptions) {
	var title = $("#projects .title").fieldValue();
	if(title == "") {
		$.prompt(ALERT_NO_TITLE, {callback: setTitleFocus});
		return false;
	} else {
		formData[formData.length] = { "name": "title", "value": title };
	}
	/*if($('#protocol_ifr').length > 0) {
		var protocol = $('#protocol').tinymce().getContent();
		for (var i=0; i < formData.length; i++) { 
			if (formData[i].name == 'protocol') { 
				formData[i].value = protocol;
			} 
		} 
	} else {
		var protocol = $('#protocol').html();
		for (var i=0; i < formData.length; i++) { 
			if (formData[i].name == 'protocol') { 
				formData[i].value = protocol;
			} 
		} 
	}*/

	$('.task_team_list').each(function() {
		var id = $(this).attr("id");
		var reg = /[0-9]+/.exec(id);
		formData[formData.length] = processListArray(reg);
	});

	$('.task_team_list_ct').each(function() {
		var id = $(this).attr("id");
		var reg = /[0-9]+/.exec(id);
		formData[formData.length] = processCustomTextArray(reg);
	});

	formData[formData.length] = processList('dependency');
	formData[formData.length] = processList('team');
	formData[formData.length] = processCustomText('team_ct');
	formData[formData.length] = processDocList('documents');
	formData[formData.length] = processList('phase_access');
	formData[formData.length] = processList('phase_status');
}


function phaseFormResponse(data) {
	switch(data.action) {
		case "edit":
			$("#projects3 span[rel='"+data.id+"'] .text").html($("#projects .title").val());
			$("#phasestartdate").html(data.startdate);
			$("#phaseenddate").html(data.enddate);
			
			//update Project Enddate
			var pid = $('#projects2 .module-click:visible').attr("rel");
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects&request=getDates&id="+pid, success: function(project){
					$("#projectenddate").html(project.enddate);
				}
			});
			
			var num  = $("#projects3 .active-link .phase_num").html();
			switch(data.access) {
				case "0":
					$("#projects3 .active-link .module-access-status").removeClass("module-access-active");
				break;
				case "1":
					$("#projects3 .active-link .module-access-status").addClass("module-access-active");
				break;
			}
				
			switch(data.status) {
				case "2":
					$("#projects3 .active-link .module-item-status").addClass("module-item-active");
				break;
				default:
					$("#projects3 .active-link .module-item-status").removeClass("module-item-active");
			}
		break;
	}
}


function newPhase() {
	var id = $('#projects2 .module-click:visible').attr("rel");
	var num  = parseInt($(".projects3-content:visible .module-click").size()+1);
	$.ajax({ type: "GET", url: "/", dataType: 'json', data: 'path=apps/projects/modules/phases&request=createNew&id=' + id + '&num=' + num, cache: false, success: function(data){
		var pid = $("#projects2 .module-click:visible").attr("rel");
			$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/projects/modules/phases&request=getList&id="+pid, success: function(ldata){
				$(".projects3-content:visible ul").html(ldata.html);
				var liindex = $(".projects3-content:visible .module-click").index($(".projects3-content:visible .module-click[rel='"+data.id+"']"));
				$(".projects3-content:visible .module-click:eq("+liindex+")").addClass('active-link');
				var moduleidx = $(".projects3-content").index($(".projects3-content:visible"));
				getDetailsPhase(moduleidx,liindex);
				projectsActions(0);
				$('#projects3 input.filter').quicksearch('#projects3 li');
				//update Project Enddate
				$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects&request=getDates&id="+pid, success: function(project){
						$("#projectenddate").html(project.enddate);
					}
				});
				}
			});
		}
	});
}

function printPhase() {
	var id = $("#projects3 .active-link:visible").attr("rel");
	var num = $("#projects3 .active-link:visible").find(".phase_num").html();
	var url ='/?path=apps/projects/modules/phases&request=printDetails&id='+id+"&num="+num;
	location.href = url;
}


function sendPhase() {
	var id = $("#projects3 .active-link:visible").attr("rel");
	var num = $("#projects3 .active-link:visible").find(".phase_num").html();
	$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/phases&request=getSend&id="+id+"&num="+num, success: function(html){
		$("#modalDialogForward").html(html).dialog('open');
		}
	});
}

function sendPhaseResponse() {
	var id = $("#projects3 .active-link:visible").attr("rel");
	$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/phases&request=getSendtoDetails&id="+id, success: function(html){
		$("#phase_sendto").html(html);
		$("#modalDialogForward").dialog('close');
		}
	});
}

function duplicatePhase() {
	var id = $("#projects3 .active-link:visible").attr("rel");
	var pid = $("#projects2 .module-click:visible").attr("rel");
	$.ajax({ type: "GET", url: "/", data: 'path=apps/projects/modules/phases&request=createDuplicate&id=' + id, cache: false, success: function(phaseid){
		$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/projects/modules/phases&request=getList&id="+pid, success: function(data){																																																																				
			$(".projects3-content:visible ul").html(data.html);
			var moduleidx = $(".projects3-content").index($(".projects3-content:visible"));
			var liindex = $(".projects3-content:visible .module-click").index($(".projects3-content:visible .module-click[rel='"+phaseid+"']"));
			getDetailsPhase(moduleidx,liindex);
			$(".projects3-content:visible .module-click:eq("+liindex+")").addClass('active-link');
			projectsActions(0);
			$('#projects3 input.filter').quicksearch('#projects3 li');
			}
		});
		}
	});
}


function binPhase() {
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
				$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/phases&request=binPhase&id=" + id, cache: false, success: function(data){
					if(data == "true") {
						$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/projects/modules/phases&request=getList&id="+pid, success: function(data){
							$(".projects3-content:visible ul").html(data.html);
							if(data.html == "<li></li>") {
								projectsActions(3);
							} else {
								projectsActions(0);
								$('#projects3 input.filter').quicksearch('#projects3 li');
							}
							var moduleidx = $(".projects3-content").index($(".projects3-content:visible"));
							var liindex = 0;
							getDetailsPhase(moduleidx,liindex);
							$("#projects3 .projects3-content:visible .module-click:eq("+liindex+")").addClass('active-link');
							//projectsActions(0);
							//update Project Enddate
							$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects&request=getDates&id="+pid, success: function(project){
									$("#projectenddate").html(project.enddate);
								}
							});
							}
						});
					}
					}
				});
			} 
		}
	});
}


function sortClickPhase(obj,sortcur,sortnew) {
	var fid = $("#projects2 .module-click:visible").attr("rel");
	$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/projects/modules/phases&request=getList&id="+fid+"&sort="+sortnew, success: function(data){
		  $(".projects3-content:visible ul").html(data.html);
		  obj.attr("rel",sortnew);
		  obj.removeClass("sort"+sortcur).addClass("sort"+sortnew);
		  var id = $(".projects3-content:visible .module-click:eq(0)").attr("rel");
			if(id == undefined) {
				return false;
			}
			var moduleidx = $(".projects3-content").index($(".projects3-content:visible"));
			var liindex = 0;
			getDetailsPhase(moduleidx,liindex);
			$("#projects3 .projects3-content:visible .module-click:eq("+liindex+")").addClass('active-link');
	}
	});
}


function sortDragPhase(order) {
	var fid = $("#projects2 .module-click:visible").attr("rel");
	$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/phases&request=setOrder&"+order+"&id="+fid, success: function(html){
		$("#projects3 .sort:visible").attr("rel", "3");
		$("#projects3 .sort:visible").removeClass("sort1").removeClass("sort2").addClass("sort3");
		}
	});
}


function phaseToggleIntern(id,status,obj) {
	$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/phases&request=toggleIntern&id=" + id + "&status=" + status, cache: false, success: function(data){
		if(data == "true") {
			obj.toggleClass("module-item-active")
		}
		}
	});
}


function dialogPhase(offset,request,field,append,title,sql) {
	switch(request) {
		case "getPhaseTaskDialog":
			$.ajax({ type: "GET", url: "/", data: 'path=apps/projects/modules/phases&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
				$("#modalDialog").html(html);
				$("#modalDialog").dialog('option', 'position', offset);
				$("#modalDialog").dialog('option', 'title', title);
				$("#modalDialog").dialog('open');
				}
			});
		break;
		case "getPhaseStatusDialog":
			$.ajax({ type: "GET", url: "/", data: 'path=apps/projects/modules/phases&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
				$("#modalDialog").html(html);
				$("#modalDialog").dialog('option', 'position', offset);
				$("#modalDialog").dialog('option', 'title', title);
				$("#modalDialog").dialog('open');
				}
			});
		break;
		case "getTasksDialog":
			$.ajax({ type: "GET", url: "/", data: 'path=apps/projects/modules/phases&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
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
				$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/phases&request=deleteTask&id=" + id, success: function(data){
					if(data){
						$("#task_"+id).slideUp(function(){ 
							$(this).remove();
							var pst = $(".task_start:first").val();
							var pen = $(".task_start:last").val();
							$("#phasestartdate").html(pst);
							$("#phaseenddate").html(pen);
						});
					} 
					}
				});
			} 
		}
	});
}


$(document).ready(function() { 
	
	$(".insertPhaseStatus").live('click', function() {
	 	var rel = $(this).attr("rel");
		var html = '<div class="listmember" field="phase_status" uid="'+rel+'" style="float: left">' + $(this).html() + '</div>';
		$("#phase_status").html(html);
		$("#modalDialog").dialog("close");
		$("#phase_status").nextAll('img').trigger('click');
		return false;
	});

	$(".insertTaskfromDialog").live('click', function() {
	 	var field = $(this).attr("field");
		var gid = $(this).attr("gid");
		var title = $(this).attr("title");
		//var html = '<a class="listmember" uid="' + gid + '" field="'+field+'">' + title + '</a>';
		$("#"+field).val(gid);
		$("#"+field+"-text").html(title);
		$("#modalDialog").dialog('close');
		var obj = getCurrentModule();
		$('#projects .coform').ajaxSubmit(obj.poformOptions);
		return false;
	});

	$("a.addPhaseTask").live('click', function() {
		var enddate = $("#phaseenddate").html();
		var pid = $("#projects2 .module-click:visible").attr("rel");
		var phid = $(".projects3-content:visible .active-link").attr("rel");
		var cat = $(this).attr("rel");
		$("#modalDialog").dialog("close");
		$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/phases&request=addTask&pid=" + pid + "&phid=" + phid + "&date=" + enddate + "&enddate=" + enddate + "&cat=" + cat, success: function(html){
			$('#phasetasks').append(html);
			var idx = parseInt($('.cbx').size() -1);
			var element = $('.cbx:eq('+idx+')');
			$.jNice.CheckAddPO(element);
			$('.phaseouter:eq('+idx+')').slideDown(function() {
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

	$('a.dependentTask').live('click',function() {
		var ele = $(this);
		var field = $(this).attr("rel");
		var html = '<div class="context"><a href="javascript:;" class="delete-dependentTask" rel="' + field + '">Entfernen</a><br /></div>';
				ele.parent().append(html);
				ele.next().slideDown();
		return false;
	});

	$('a.delete-dependentTask').live('click',function() {
		var field = $(this).attr("rel");
		$("#"+field).val(0);
		$("#"+field+"-text").html("");
		var obj = getCurrentModule();
		$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		return false;
	});


	// Recycle bin functions
	$(".bin-deletePhase").live('click',function(e) {
		var id = $(this).attr("rel");
		var txt = ALERT_DELETE_REALLY;
		var langbuttons = {};
		langbuttons[ALERT_YES] = true;
		langbuttons[ALERT_NO] = false;
		$.prompt(txt,{ 
			buttons:langbuttons,
			callback: function(v,m,f){		
				if(v){
					$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/phases&request=deletePhase&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#phase_'+id).slideUp();
						}
					}
					});
				} 
			}
		});
		return false;
	});


	$(".bin-restorePhase").live('click',function(e) {
		var id = $(this).attr("rel");
		var txt = ALERT_RESTORE;
		var langbuttons = {};
		langbuttons[ALERT_YES] = true;
		langbuttons[ALERT_NO] = false;
		$.prompt(txt,{ 
			buttons:langbuttons,
			callback: function(v,m,f){		
				if(v){
					$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/phases&request=restorePhase&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#phase_'+id).slideUp();
						}
					}
					});
				} 
			}
		});
		return false;
	});


	$(".bin-deletePhaseTask").live('click',function(e) {
		var id = $(this).attr("rel");
		var txt = ALERT_DELETE_REALLY;
		var langbuttons = {};
		langbuttons[ALERT_YES] = true;
		langbuttons[ALERT_NO] = false;
		$.prompt(txt,{ 
			buttons:langbuttons,
			callback: function(v,m,f){		
				if(v){
					$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/phases&request=deletePhaseTask&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#phase_task_'+id).slideUp();
						}
					}
					});
				} 
			}
		});
		return false;
	});


	$(".bin-restorePhaseTask").live('click',function(e) {
		var id = $(this).attr("rel");
		var txt = ALERT_RESTORE;
		var langbuttons = {};
		langbuttons[ALERT_YES] = true;
		langbuttons[ALERT_NO] = false;
		$.prompt(txt,{ 
			buttons:langbuttons,
			callback: function(v,m,f){		
				if(v){
					$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/phases&request=restorePhaseTask&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#phase_task_'+id).slideUp();
						}
					}
					});
				} 
			}
		});
		return false;
	});
	
	
});