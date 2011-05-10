/* projects Object */
var projects = new Application('projects');
projects.path = 'apps/projects/';
projects.resetModuleHeights = projectsresetModuleHeights;
projects.usesLayout = true;
projects.displayname = "Projekte";
projects.modules_height = projects_num_modules*module_title_height;
projects.sortclick = sortClickProject;
projects.sortdrag = sortDragProject;
projects.actionDialog = dialogProject;
projects.actionNew = newProject;
projects.actionPrint = printProject;
projects.actionSend = sendProject;
projects.actionSendtoResponse = sendProjectResponse;
projects.actionDuplicate = duplicateProject;
projects.actionHandbook = printProjectHandbook;
projects.actionBin = binProject;
projects.GuestHiddenModules = new Array("controlling","access");
//projects.actionMoveProject = moveProject;
projects.poformOptions = { beforeSubmit: projectFormProcess, dataType:  'json', success: projectFormResponse };
//projects.sendformOptions = { beforeSubmit: projectSendProcess, dataType:  'json', success: projectSendResponse };

// register folder object
var folder = new Module('folder');
folder.path = 'apps/projects/';
folder.sortclick = sortClickFolder;
folder.sortdrag = sortDragFolder;
folder.actionNew = newFolder;
folder.actionPrint = printFolder;
folder.actionBin = binFolder;
folder.poformOptions = { beforeSubmit: folderFormProcess, dataType:  'json', success: folderFormResponse };

/* Functions 
- projectFormProcess
- folderFormProcess
- projectFormResponse
- folderFormResponse
- newProject
- newFolder
- binPhase
*/

function projectFormProcess(formData, form, poformOptions) {
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
	formData[formData.length] = processList('projectfolder');
	formData[formData.length] = processList('ordered_by');
	formData[formData.length] = processCustomText('ordered_by_ct');
	formData[formData.length] = processList('management');
	formData[formData.length] = processCustomText('management_ct');
	formData[formData.length] = processList('team');
	formData[formData.length] = processCustomText('team_ct');
	formData[formData.length] = processList('status');
}


function folderFormProcess(formData, form, poformOptions) {
	var title = $("#projects .title").fieldValue();
	if(title == "") {
		$.prompt(ALERT_NO_TITLE, {callback: setTitleFocus});
		return false;
	} else {
		formData[formData.length] = { "name": "title", "value": title };
	}
}


function projectFormResponse(data) {
	switch(data.action) {
		case "edit":
			$("#projects2 span[rel='"+data.id+"'] .text").html($("#projects .title").val());
			$("#durationStart").html($("input[name='startdate']").val());
			
			switch(data.status) {
				case "2":
					$("#projects2 .active-link .module-item-status").addClass("module-item-active");
				break;
				default:
					$("#projects2 .active-link .module-item-status").removeClass("module-item-active");
			}
			
		break;
		case "reload":
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects&request=getProjectDetails&id="+data.id, success: function(text){
					$("#projects-right").html(text.html);
						initContentScrollbar();
					}
				});
		break;
	}
}


function printProject() {
	var id = $("#projects2 .active-link").attr("rel");
	var url ='/?path=apps/projects&request=printProjectDetails&id='+id;
	location.href = url;
}


function printProjectHandbook() {
	var obj = getCurrentModule();
	if(obj.name == 'projects') {
		var id = $("#projects2 .active-link").attr("rel");
	} else {
		var id = $('#projects2 .module-click:visible').attr("rel");
	}
	var url ='/?path=apps/projects&request=printProjectHandbook&id='+id;
	location.href = url;
}


function sendProject() {
	var id = $("#projects2 .active-link").attr("rel");
	$.ajax({ type: "GET", url: "/", data: "path=apps/projects&request=getProjectSend&id="+id, success: function(html){
		$("#modalDialogForward").html(html).dialog('open');
		}
	});
}

function sendProjectResponse() {
	var id = $("#projects2 .active-link").attr("rel");
	$.ajax({ type: "GET", url: "/", data: "path=apps/projects&request=getSendtoDetails&id="+id, success: function(html){
		$("#project_sendto").html(html);
		$("#modalDialogForward").dialog('close');
		}
	});
}


function printFolder() {
	var id = $("#projects1 .active-link").attr("rel");
	var url ='/?path=apps/projects&request=printFolderDetails&id='+id;
	location.href = url;
}


function folderFormResponse(data) {
	switch(data.action) {
		case "edit":
			$("#projects1 span[rel='"+data.id+"'] .text").html($("#projects .title").val());
		break;
	}
}


function newProject() {
	var id = $('#'+projects.name+' .module-click:visible').attr("rel");
	$.ajax({ type: "GET", url: "/", dataType:  'json', data: 'path=apps/projects&request=newProject&id=' + id, cache: false, success: function(data){
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects&request=getProjectList&id="+id, success: function(list){
				$("#projects2 ul").html(list.html);
				var index = $("#projects2 .module-click").index($("#projects2 .module-click[rel='"+data.id+"']"));
				setModuleActive($("#projects2"),index);
				$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects&request=getProjectDetails&id="+data.id, success: function(text){
					$("#projects-right").html(text.html);
					initContentScrollbar();
					$('#projects2 input.filter').quicksearch('#projects2 li');
					}
				});
				projectsActions(0);
				}
			});
		}
	});
}


function newFolder() {
	$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects&request=newFolder", cache: false, success: function(data){
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects&request=getFolderList", success: function(list){
				$("#projects1 ul").html(list.html);
				$("#projects1 li").show();
				var index = $("#projects1 .module-click").index($("#projects1 .module-click[rel='"+data.id+"']"));
				setModuleActive($("#projects1"),index);
				$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects&request=getFolderDetails&id="+data.id, success: function(text){
					$("#"+projects.name+"-right").html(text.html);
					initContentScrollbar();
					$('#projects1 input.filter').quicksearch('#projects1 li');
					}
				});
				projectsActions(1);
				}
			});
		}
	});
}


function duplicateProject() {
	var pid = $("#projects2 .active-link").attr("rel");
	var oid = $("#projects1 .module-click:visible").attr("rel");
	$.ajax({ type: "GET", url: "/", data: 'path=apps/projects&request=createDuplicate&id=' + pid, cache: false, success: function(id){
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects&request=getProjectList&id="+oid, success: function(data){
				$("#projects2 ul").html(data.html);
					projectsActions(0);
					$('#projects2 input.filter').quicksearch('#projects2 li');
					var idx = $("#projects2 .module-click").index($("#projects2 .module-click[rel='"+id+"']"));
					setModuleActive($("#projects2"),idx)
					$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects&request=getProjectDetails&id="+id, success: function(text){
							$("#"+projects.name+"-right").html(text.html);
							initContentScrollbar();
							$('#projects2 input.filter').quicksearch('#projects2 li');
						}
			   		});
			}
		});
		}
	});
}


function binProject() {
	var txt = ALERT_DELETE;
	var langbuttons = {};
	langbuttons[ALERT_YES] = true;
	langbuttons[ALERT_NO] = false;
	$.prompt(txt,{ 
		buttons:langbuttons,
		callback: function(v,m,f){		
			if(v){
				var id = $("#projects2 .active-link").attr("rel");
				var fid = $("#projects .module-click:visible").attr("rel");
				$.ajax({ type: "GET", url: "/", data: "path=apps/projects&request=binProject&id=" + id, cache: false, success: function(data){
					if(data == "true") {
						$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects&request=getProjectList&id="+fid, success: function(list){
							$("#projects2 ul").html(list.html);
							if(list.html == "<li></li>") {
								projectsActions(3);
							} else {
								projectsActions(0);
								setModuleActive($("#projects2"),0);
							}
							var id = $("#projects2 .module-click:eq(0)").attr("rel");
							$("#projects2 .module-click:eq(0)").addClass('active-link');
							$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects&request=getProjectDetails&fid="+fid+"&id="+id, success: function(text){
								$("#projects-right").html(text.html);
								initContentScrollbar();
								$('#projects2 input.filter').quicksearch('#projects2 li');
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


function binFolder() {
	var txt = ALERT_DELETE;
	var langbuttons = {};
	langbuttons[ALERT_YES] = true;
	langbuttons[ALERT_NO] = false;
	$.prompt(txt,{ 
		buttons:langbuttons,
		callback: function(v,m,f){		
			if(v){
				var id = $("#projects1 .active-link").attr("rel");
				$.ajax({ type: "GET", url: "/", data: "path=apps/projects&request=binFolder&id=" + id, cache: false, success: function(data){
					if(data == "true") {
						$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects&request=getFolderList", success: function(data){
							$("#projects1 ul").html(data.html);
							if(data.html == "<li></li>") {
								projectsActions(3);
							} else {
								projectsActions(1);
							}
							var id = $("#projects1 .module-click:eq(0)").attr("rel");
							$("#projects1 .module-click:eq(0)").addClass('active-link');
							$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects&request=getFolderDetails&id="+id, success: function(text){
								$("#"+projects.name+"-right").html(text.html);
								initContentScrollbar();
								$('#projects1 input.filter').quicksearch('#projects1 li');
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


function projectsActions(status) {
	/*	0= new	1= print	2= send		3= duplicate	4= handbook	5 = delete*/
	switch(status) {
		//case 0: 	actions = ['0','1','2','3','4']; break; // all actions
		case 0: actions = ['0','1','2','3','4','5']; break;
		//case 1: 	actions = ['0','1','2','4']; break; 	// no duplicate
		case 1: actions = ['0','5']; break;
		//case 2: 	actions = ['1']; break;   					// just save
		case 3: 	actions = ['0']; break;   					// just new
		case 4: 	actions = ['1','2','4']; break;   		// print, send, handbook
		case 5: 	actions = ['1','2']; break;   			// print, send
		default: 	actions = [];  								// none
	}
	$('#projectsActions > li span').each( function(index) {
		if(index in oc(actions)) {
			$(this).removeClass('noactive');
		} else {
			$(this).addClass('noactive');
		}
	})
}


function sortClickFolder(obj,sortcur,sortnew) {
	$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects&request=getFolderList&sort="+sortnew, success: function(data){
		  $("#projects1 ul").html(data.html);
		  obj.attr("rel",sortnew);
		  obj.removeClass("sort"+sortcur).addClass("sort"+sortnew);
			$('#projects1 input.filter').quicksearch('#projects1 li');
		  var id = $("#projects1 .module-click:eq(0)").attr("rel");
		  $("#projects1 .module-click:eq(0)").addClass('active-link');
		  $.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects&request=getFolderDetails&id="+id, success: function(text){
			  $("#projects-right").html(text.html);
			  initContentScrollbar()
			  }
		  });
	}
	});
}


function sortDragFolder(order) {
	$.ajax({ type: "GET", url: "/", data: "path=apps/projects&request=setFolderOrder&"+order, success: function(html){
		$("#projects1 .sort").attr("rel", "3");
		$("#projects1 .sort").removeClass("sort1").removeClass("sort2").addClass("sort3");
		}
	});
}


function sortClickProject(obj,sortcur,sortnew) {
	var fid = $("#projects .module-click:visible").attr("rel");
	$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects&request=getProjectList&id="+fid+"&sort="+sortnew, success: function(data){
		  $("#projects2 ul").html(data.html);
		  obj.attr("rel",sortnew);
		  obj.removeClass("sort"+sortcur).addClass("sort"+sortnew);
		  var id = $("#projects2 .module-click:eq(0)").attr("rel");
		  if(id == undefined) {
				return false;
			}
		  setModuleActive($("#projects2"),'0');
		  $.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects&request=getProjectDetails&id="+id, success: function(text){
			  $("#"+projects.name+"-right").html(text.html);
			  initContentScrollbar()
			  }
		  });
	}
	});
}


function sortDragProject(order) {
	var fid = $("#projects .module-click:visible").attr("rel");
	$.ajax({ type: "GET", url: "/", data: "path=apps/projects&request=setProjectOrder&"+order+"&id="+fid, success: function(html){
		$("#projects2 .sort").attr("rel", "3");
		$("#projects2 .sort").removeClass("sort1").removeClass("sort2").addClass("sort3");
		}
	});
}


function dialogProject(offset,request,field,append,title,sql) {
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


function projectsloadModuleStart() {
	var h = $("#projects .ui-layout-west").height();
	$("#projects1 .module-inner").css("height", h-71);
	$("#projects1 .module-actions").show();
	$("#projects2 .module-actions").hide();
	$("#projects2 li").show();
	$("#projects2").css("height", h-96).removeClass("module-active");
	$("#projects2 .module-inner").css("height", h-96);
	$("#projects3 .module-actions").hide();
	$("#projects3").css("height", h-121);
	$("#projects3 .projects3-content").css("height", h-(projects.modules_height+121));
	$("#projects-current").val("folder");
	$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects&request=getFolderList", success: function(data){
		$("#projects1 ul").html(data.html);
		
		if(data.access == "guest") {
			projectsActions();
		} else {
			if(data.html == "<li></li>") {
				projectsActions(3);
			} else {
				projectsActions(1);
			}
		}
		
		$("#projects1").css("overflow", "auto").animate({height: h-71}, function() {
			$("#projects1 li").show();
			$("#projects1 .sort").attr("rel", data.sort).addClass("sort"+data.sort);
			projectsInnerLayout.initContent('center');
			initScrollbar( '#projects .scrolling-content' );
			$('#projects1 input.filter').quicksearch('#projects1 li');
			$("#projects3 .projects3-content").hide();
			var id = $("#projects1 .module-click:eq(0)").attr("rel");
			$("#projects1 .module-click:eq(0)").addClass('active-link');
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects&request=getFolderDetails&id="+id, success: function(text){
				$("#"+projects.name+"-right").html(text.html);
				projectsInnerLayout.initContent('center');
				$('#projects1 input.filter').quicksearch('#projects1 li');
				$("#projects3 .projects3-content").hide();
				}
			});
		});
	}
	});
}


function projectsresetModuleHeights() {
	
	var h = $("#projects .ui-layout-west").height();
	if($("#projects1").height() != module_title_height) {
		$("#projects1").css("height", h-71);
		$("#projects1 .module-inner").css("height", h-71);
	}
	if($("#projects2").height() != module_title_height) {
		//$("#projects2").css("height", h-96);
		$("#projects2 .module-inner").css("height", h-96);
		$("#projects2").css("overflow", "auto").animate({height: h-(projects.modules_height+96)});
	}
	$("#projects3").css("height", h-121);
	$("#projects3 .projects3-content").css("height", h-(projects.modules_height+121));
	initScrollbar( '#projects .scrolling-content' );
}

function ProjectsModulesDisplay(access) {
	var h = $("#projects .ui-layout-west").height();
	if(access == "guest") {
		var modLen = projects.GuestHiddenModules.length;
		var m;
		for(var i=0, len=modLen; i<len; ++i) {
			m = $('h3[rel="'+projects.GuestHiddenModules[i]+'"]');
			m.hide();
		}
		projects.modules_height = projects_num_modules*module_title_height - modLen*module_title_height;
		$("#projects3 .projects3-content").css("height", h-(projects.modules_height+121));
	} else {
		var modLen = projects.GuestHiddenModules.length;
		var m;
		for(var i=0, len=modLen; i<len; ++i) {
			m = $('h3[rel="'+projects.GuestHiddenModules[i]+'"]');
			m.show();
		}
		projects.modules_height = projects_num_modules*module_title_height;
		$("#projects3 .projects3-content").css("height", h-(projects.modules_height+121));
	}
}


var projectsLayout, projectsInnerLayout;

$(document).ready(function() { 

	projectsLayout = $('#projects').layout({
			west__onresize:				function() { projectsresetModuleHeights() }
		,	resizeWhileDragging:		true
		,	spacing_open:				0
		,	closable: 				false
		,	resizable: 				false
		,	slidable:				false
		, 	west__size:				325
		,	west__closable: 		true
		,	west__resizable: 		true
		, 	south__size:			10
		,	center__onresize: "projectsInnerLayout.resizeAll"
		
	});
	
	projectsInnerLayout = $('#projects div.ui-layout-center').layout({
			center__onresize:				function() { initScrollbar( '#projects .scrolling-content' ); }
		,	resizeWhileDragging:		false
		,	spacing_open:				0			// cosmetic spacing
		,	closable: 				false
		,	resizable: 				false
		,	slidable:				false
		,	north__paneSelector:	".center-north"
		,	center__paneSelector:	".center-center"
		,	west__paneSelector:	".center-west"
		, 	north__size:			80
		, 	west__size:			50
		 

	});
	
	projectsloadModuleStart();


	$("#projects1-outer > h3").click(function() {
		if(confirmNavigation()) {
			formChanged = false;
			var obj = getCurrentModule();
			$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		}
		
		if($(this).hasClass("module-bg-active")) {
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects&request=getFolderList", success: function(data){
				$("#projects1 ul").html(data.html);
				if(data.access == "guest") {
					projectsActions();
				} else {
					if(data.html == "<li></li>") {
						projectsActions(3);
					} else {
						projectsActions(1);
					}
				}
				initScrollbar( '#projects .scrolling-content' );
				$('#projects1 input.filter').quicksearch('#projects1 li');
				var id = $("#projects1 .module-click:eq(0)").attr("rel");
				$("#projects1 .module-click:eq(0)").addClass('active-link');
				//$("#projects1 .drag:eq(0)").show();
				$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects&request=getFolderDetails&id="+id, success: function(text){
					$("#projects-right").html(text.html);
					//projectsInnerLayout.initContent('center');
					initContentScrollbar();
					var h = $("#projects .ui-layout-west").height();
					$("#projects1").delay(200).animate({height: h-46}, function() {
						$(this).animate({height: h-71});			 
					});
					}
				 });
				}
			});
		} else {
			var h = $("#projects .ui-layout-west").height();
			var id = $("#projects1 .module-click:visible").attr("rel");
			var index = $("#projects1 .module-click").index($("#projects1 .module-click[rel='"+id+"']"));
			
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects&request=getFolderList", success: function(data){
				$("#projects1 ul").html(data.html);
				if(data.access == "guest") {
					projectsActions();
				} else {
					if(data.html == "<li></li>") {
						projectsActions(3);
					} else {
						projectsActions(1);
					}
				}
				$('#projects1 input.filter').quicksearch('#projects1 li');
				$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects&request=getFolderDetails&id="+id, success: function(text){
					$("#projects1 li").show();
					setModuleActive($("#projects1"),index);
					
					$("#projects1").css("overflow", "auto").animate({height: h-46}, function() {
						$("#"+projects.name+"-right").html(text.html);
						initScrollbar( '#projects .scrolling-content' );
						$("#projects-current").val("folder");
						setModuleDeactive($("#projects2"),'0');
						setModuleDeactive($("#projects3"),'0');
						$("#projects2 li").show();
						$("#projects2").css("height", h-96).removeClass("module-active");
						$("#projects2").prev("h3").removeClass("white");
						$("#projects2 .module-inner").css("height", h-96);
						$("#projects3 h3").removeClass("module-bg-active");
						$("#projects3 .projects3-content:visible").slideUp();
						initContentScrollbar();
						$("#projects1").delay(200).animate({height: h-71});
					});
					}
				 });
				}
			});
		}
		$("#projects-top .top-headline").html("");
		$("#projects-top .top-subheadline").html("");
		$("#projects-top .top-subheadlineTwo").html("");
		return false;
	});


	$("#projects2-outer > h3").click(function(event, passed_id) {
		if(confirmNavigation()) {
			formChanged = false;
			var obj = getCurrentModule();
			$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		}
		if($(this).hasClass("module-bg-active")) {
			$("#projects1-outer > h3").trigger("click");
		} else {
			if($("#projects2").height() == module_title_height) {
				var h = $("#projects .ui-layout-west").height();
				var id = $("#projects1 .module-click:visible").attr("rel");
				var projectid = $("#projects2 .module-click:visible").attr("rel");
				var index = $("#projects2 .module-click").index($("#projects2 .module-click[rel='"+projectid+"']"));
				$("#projects3 .module-actions:visible").hide();
				$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects&request=getProjectList&id="+id, success: function(data){
					$("#projects2 ul").html(data.html);
					$("#projects2 li").show();
					setModuleActive($("#projects2"),index);
					$('#projects2 input.filter').quicksearch('#projects2 li');
					$("#projects2").css("overflow", "auto").animate({height: h-(projects.modules_height+96)}, function() {
					$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects&request=getProjectDetails&id="+projectid, success: function(text){
						$("#projects-right").html(text.html);
							
						switch (text.access) {
							case "sysadmin":
								if(data.html == "<li></li>") {
									projectsActions(3);
								} else {
									projectsActions(0);
									$('#projects2').find('input.filter').quicksearch('#projects2 li');
								}
							break;
							case "admin":
								if(data.html == "<li></li>") {
									projectsActions();
								} else {
									projectsActions(4);
									$('#projects2').find('input.filter').quicksearch('#projects2 li');
								}
							break;
							case "guest":
								if(data.html == "<li></li>") {
									projectsActions();
								} else {
									projectsActions(5);
									$('#projects2').find('input.filter').quicksearch('#projects2 li');
								}
							break;
						}
						initContentScrollbar();
						}
					});
					$("#projects3 h3").removeClass("module-bg-active");
					});
					$(".projects3-content").slideUp();
					}
				});
			} else {
				var id = $("#projects1 .active-link").attr("rel");
				if(id == undefined) {
					return false;
				}
				var index = $("#projects1 .module-click").index($("#projects1 .module-click[rel='"+id+"']"));
				$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects&request=getProjectList&id="+id, success: function(data){
					$("#projects2 ul").html(data.html);
					if(passed_id === undefined) {
						var projectid = $("#projects2 .module-click:eq(0)").attr("rel");
					} else {
						var projectid = passed_id;					
					}
				
					if($("#projects1").height() != module_title_height) {
						var idx = $("#projects2 .module-click").index($("#projects2 .module-click[rel='"+projectid+"']"));
						setModuleActive($("#projects2"),idx)
						setModuleDeactive($("#projects1"),index);
						$("#projects1").css("overflow", "hidden").animate({height: module_title_height}, function() {
							$("#projects-top .top-headline").html($("#projects .module-click:visible").find(".text").html());
							$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects&request=getProjectDetails&id="+projectid, success: function(text){
								$("#projects-right").html(text.html);

								switch (text.access) {
									case "sysadmin":
										if(data.html == "<li></li>") {
											projectsActions(3);
										} else {
											projectsActions(0);
											$('#projects2').find('input.filter').quicksearch('#projects2 li');
										}
									break;
									case "admin":
										if(data.html == "<li></li>") {
											projectsActions();
										} else {
											projectsActions(4);
											$('#projects2').find('input.filter').quicksearch('#projects2 li');
										}
									break;
									case "guest":
										if(data.html == "<li></li>") {
											projectsActions();
										} else {
											projectsActions(5);
											$('#projects2').find('input.filter').quicksearch('#projects2 li');
										}
									break;
								}
								initContentScrollbar();
								var h = $("#projects .ui-layout-west").height();
								if(text.access != "sysadmin") { ProjectsModulesDisplay(text.access); }
								$("#projects2").delay(200).animate({height: h-(projects.modules_height+96)});
								}
							});
						});
					} else {
						$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects&request=getProjectDetails&id="+projectid, success: function(text){
							$("#"+projects.name+"-right").html(text.html);
							initContentScrollbar();
							}
						});
					}
					}
				});
			}
		}
		$("#projects-current").val("projects");
		$("#projects-top .top-subheadline").html("");
		$("#projects-top .top-subheadlineTwo").html("");
		return false;
	});


	$("#projects1 .module-click").live('click',function(e) {
		if($(this).hasClass("deactivated")) {
			return false;
		}
		if(confirmNavigation()) {
			formChanged = false;
			var obj = getCurrentModule();
			$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		}
		var id = $(this).attr("rel");
		var index = $("#projects .module-click").index(this);
		$("#projects .module-click").removeClass("active-link");
		$(this).addClass("active-link");

		var h = $("#projects .ui-layout-west").height();
		$("#projects1").delay(200).animate({height: h-46}, function() {
			$(this).animate({height: h-71});
		});
			
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects&request=getFolderDetails&id="+id, success: function(text){
			$("#projects-right").html(text.html);
			projectsInnerLayout.initContent('center');
			if(text.access == "guest") {
					projectsActions();
				} else {
					projectsActions(1);
				}
			}
		});
		
		return false;
	});


	$("#projects2 .module-click").live('click',function() {
		if($(this).hasClass("deactivated")) {
			return false;
		}
		if(confirmNavigation()) {
			formChanged = false;
			var obj = getCurrentModule();
			$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		}
		
		var fid = $("#projects .module-click:visible").attr("rel");
		var id = $(this).attr("rel");
		var index = $("#projects .module-click").index(this);
		$("#projects .module-click").removeClass("active-link");
		$(this).addClass("active-link");
		$("#projects-top .top-headline").html($("#projects .module-click:visible").find(".text").html());
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects&request=getProjectDetails&fid="+fid+"&id="+id, success: function(text){
			$("#projects-right").html(text.html);
			
			switch (text.access) {
				case "sysadmin":
					projectsActions(0);
				break;
				case "admin":
					projectsActions(4);
				break;
				case "guest":
					projectsActions(5);
				break;
			}

			initContentScrollbar();
			
			var h = $("#projects .ui-layout-west").height();
			$("#projects2").delay(200).animate({height: h-96}, function() {
				if(text.access != "sysadmin") { ProjectsModulesDisplay(text.access); }
				$(this).animate({height: h-(projects.modules_height+96)});			 
			});
			
			}
			
		});
		return false;
	});


	$("#projects3 .module-click").live('click',function() {
		if(confirmNavigation()) {
			formChanged = false;
			var obj = getCurrentModule();
			$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		}
		
		var id = $(this).attr("rel");
		var ulidx = $("#projects3 ul").index($(this).parents("ul"));
		var index = $("#projects3 ul:eq("+ulidx+") .module-click").index($("#projects3 ul:eq("+ulidx+") .module-click[rel='"+id+"']"));
		$("#projects3 .module-click").removeClass("active-link");
		$(this).addClass("active-link");
		
		var obj = getCurrentModule();
		var list = 0;
		obj.getDetails(ulidx,index,list);
		 return false;
	});


	$("#projects3 h3").click(function(event, passed_id) {
		if(confirmNavigation()) {
			formChanged = false;
			var obj = getCurrentModule();
			$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		}
		
		var moduleidx = $("#projects3 h3").index(this);
		var module = $(this).attr("rel");
		var h3click = $(this);
		// module open and  active 
		if($(this).hasClass("module-bg-active")) {
			$("#projects2-outer > h3").trigger("click");
		} else {
			// module 3 allready activated
			if($("#projects2").height() == module_title_height) {
				var id = $("#projects2 .module-click:visible").attr("rel");
				$("#projects3 h3").removeClass("module-bg-active");
				
				h3click.addClass("module-bg-active")
					.next('div').slideDown( function() {
						$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects/modules/"+module+"&request=getList&id="+id, success: function(data){
							$("#projects3 ul:eq("+moduleidx+")").html(data.html);
							if(passed_id === undefined) {
								var idx = 0;
							} else {
								var idx = $("#projects3 ul:eq("+moduleidx+") .module-click").index($("#projects3 ul:eq("+moduleidx+") .module-click[rel='"+passed_id+"']"));
							}

							$("#projects3 ul:eq("+moduleidx+") .module-click:eq("+idx+")").addClass('active-link');
							$("#projects3 .module-actions:visible").hide();
							var obj = getCurrentModule();
							obj.getDetails(moduleidx,idx,data.html);
							$(this).prev("h3").removeClass("module-bg-active");	
							$("#projects3 .module-actions:eq("+moduleidx+")").show();
							$("#projects3 .sort:eq("+moduleidx+")").attr("rel", data.sort).addClass("sort"+data.sort);
							}
						});			 
					})
					.siblings('div:visible').slideUp()
				
			} else {
				// load and slide up module 3
				var id = $("#projects2 .active-link").attr("rel");
				if(id == undefined) {
					return false;
				}
				var index = $("#projects2 .module-click").index($("#projects2 .module-click[rel='"+id+"']"));
	
				$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects/modules/"+module+"&request=getList&id="+id, success: function(data){
					$("#projects3 ul:eq("+moduleidx+")").html(data.html);
					
					if(passed_id === undefined) {
						var idx = 0;
					} else {
						var idx = $("#projects3 ul:eq("+moduleidx+") .module-click").index($("#projects3 ul:eq("+moduleidx+") .module-click[rel='"+passed_id+"']"));
					}
					
					$("#projects3 ul:eq("+moduleidx+") .module-click:eq("+idx+")").addClass('active-link');
					$("#projects3 .module-actions:visible").hide();
					setModuleDeactive($("#projects2"),index);
					$("#projects2").css("overflow", "hidden").animate({height: module_title_height}, function() {
						$("#projects-top .top-subheadline").html($("#projects2 .module-click:visible").find(".text").html());
						$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects&request=getDates&id="+id, success: function(data){
							$("#projects-top .top-subheadlineTwo").html(data.startdate + ' - <span id="projectenddate">' + data.enddate + '</span>');
						}
						});
					});
					h3click.addClass("module-bg-active")
						.next('div').slideDown(function() {
							var obj = getCurrentModule();
							obj.getDetails(moduleidx,idx,data.html);
							$("#projects3 .sort:eq("+moduleidx+")").attr("rel", data.sort).addClass("sort"+data.sort);
							$("#projects3 .module-actions:eq("+moduleidx+")").show();
						})
					}
				});
			}
			$("#projects-current").val(module);
		}
		return false;
	});

 
    $("#projects .loadModuleStart").click(function() {
		loadModuleStart();
		return false;
	});
  
	
	$('a.addtask').live('click',function() {
		var module = getCurrentModule();
		module.addTask();
		return false;
	});
	
	$('a.deleteTask').live('click',function() {
		var id = $(this).attr("rel");
		var module = getCurrentModule();
		module.deleteTask(id);
		return false;
	});
	
	$('a.insertAccess').live('click',function() {
		var rel = $(this).attr("rel");
		var field = $(this).attr("field");
		var html = '<div class="listmember" field="'+field+'" uid="'+rel+'">' + $(this).html() + '</div>';
		$("#"+field).html(html);
		$("#modalDialog").dialog("close");
		var obj = getCurrentModule();
		$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		return false;
	});
	
	$(".insertProjectStatus").live('click', function() {
	 	var rel = $(this).attr("rel");
		var html = '<div class="listmember" field="status" uid="'+rel+'" style="float: left">' + $(this).html() + '</div>';
		$("#status").html(html);
		$("#modalDialog").dialog("close");
		$("#status").nextAll('img').trigger('click');
		var obj = getCurrentModule();
		$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		return false;
	});


	$('a.insertProjectFolderfromDialog').livequery('click',function() {
		var field = $(this).attr("field");
		var gid = $(this).attr("gid");
		var title = $(this).attr("title");
		var html = '<a class="listmember" uid="' + gid + '" field="'+field+'">' + title + '</a>';
		$("#"+field).html(html);
		$("#modalDialog").dialog('close');
		var obj = getCurrentModule();
		$('#projects .coform').ajaxSubmit(obj.poformOptions);
	});
	
	
// INTERLINKS FROM Content
	
	// load a project
	$(".loadProject").live('click', function() {
		var id = $(this).attr("rel");
		$("#projects2-outer > h3").trigger('click', [id]);
		return false;
	});

	
	// load a phase
	$(".loadPhase").live('click', function() {
		var id = $(this).attr("rel");
		$("#projects3 h3[rel='phases']").trigger('click', [id]);
		return false;
	});
	
	$(".loadPhase2").live('click', function() {
		var id = $(this).attr("rel");
		$("#projects3 h3[rel='phases']").trigger('click', [id]);
		return false;
	});


	$('span.actionProjectHandbook').click(function(){
		if($(this).hasClass("noactive")) {
			return false;
		}
		projects.actionHandbook();
		return false;
	});


	// Recycle bin functions
	$(".bin-deleteFolder").live('click',function(e) {
		var id = $(this).attr("rel");
		var txt = ALERT_DELETE_REALLY;
		var langbuttons = {};
		langbuttons[ALERT_YES] = true;
		langbuttons[ALERT_NO] = false;
		$.prompt(txt,{ 
			buttons:langbuttons,
			callback: function(v,m,f){		
				if(v){
					$.ajax({ type: "GET", url: "/", data: "path=apps/projects&request=deleteFolder&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#folder_'+id).slideUp();
						}
					}
					});
				} 
			}
		});
	
		return false;
	});
	
	$(".bin-restoreFolder").live('click',function(e) {
		var id = $(this).attr("rel");
		var txt = ALERT_RESTORE;
		var langbuttons = {};
		langbuttons[ALERT_YES] = true;
		langbuttons[ALERT_NO] = false;
		$.prompt(txt,{ 
			buttons:langbuttons,
			callback: function(v,m,f){		
				if(v){
					$.ajax({ type: "GET", url: "/", data: "path=apps/projects&request=restoreFolder&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#folder_'+id).slideUp();
						}
					}
					});
				} 
			}
		});
	
		return false;
	});
	
	
	$(".bin-deleteProject").live('click',function(e) {
		var id = $(this).attr("rel");
		var txt = ALERT_DELETE_REALLY;
		var langbuttons = {};
		langbuttons[ALERT_YES] = true;
		langbuttons[ALERT_NO] = false;
		$.prompt(txt,{ 
			buttons:langbuttons,
			callback: function(v,m,f){		
				if(v){
					$.ajax({ type: "GET", url: "/", data: "path=apps/projects&request=deleteProject&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#project_'+id).slideUp();
						}
					}
					});
				} 
			}
		});
	
		return false;
	});
	
	$(".bin-restoreProject").live('click',function(e) {
		var id = $(this).attr("rel");
		var txt = ALERT_RESTORE;
		var langbuttons = {};
		langbuttons[ALERT_YES] = true;
		langbuttons[ALERT_NO] = false;
		$.prompt(txt,{ 
			buttons:langbuttons,
			callback: function(v,m,f){		
				if(v){
					$.ajax({ type: "GET", url: "/", data: "path=apps/projects&request=restoreProject&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#project_'+id).slideUp();
						}
					}
					});
				} 
			}
		});
	
		return false;
	});


});