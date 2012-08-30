function initProjectsContentScrollbar() {
	projectsInnerLayout.initContent('center');
}

/* projects Object */
function projectsApplication(name) {
	this.name = name;
	
	this.init = function() {
		this.$app = $('#projects');
		this.$appContent = $('#projects-right');
		this.$first = $('#projects1');
		this.$second = $('#projects2');
		this.$third = $('#projects3');
		this.$thirdDiv = $('#projects3 div.thirdLevel');
		this.$layoutWest = $('#projects div.ui-layout-west');
	}


	this.formProcess = function(formData, form, poformOptions) {
		var title = $("#projects input.title").fieldValue();
		if(title == "") {
			$.prompt(ALERT_NO_TITLE, {callback: setTitleFocus});
			return false;
		} else {
			formData[formData.length] = { "name": "title", "value": title };
		}
		formData[formData.length] = processListApps('folder');
		formData[formData.length] = processListApps('ordered_by');
		formData[formData.length] = processCustomTextApps('ordered_by_ct');
		formData[formData.length] = processListApps('management');
		formData[formData.length] = processCustomTextApps('management_ct');
		formData[formData.length] = processListApps('team');
		formData[formData.length] = processCustomTextApps('team_ct');
		formData[formData.length] = processListApps('status');
	}

	
	this.formResponse = function(data) {
		switch(data.action) {
			case "edit":
				$("#projects2 span[rel='"+data.id+"'] .text").html($("#projects .title").val());
				$("#durationStart").html($("input[name='startdate']").val());
				switch(data.status) {
					case "2":
						$("#projects2 span[rel='"+data.id+"'] .module-item-status").addClass("module-item-active").removeClass("module-item-active-stopped");
					break;
					case "3":
						$("#projects2 span[rel='"+data.id+"'] .module-item-status").addClass("module-item-active-stopped").removeClass("module-item-active");
					break;
					default:
						$("#projects2 span[rel='"+data.id+"'] .module-item-status").removeClass("module-item-active").removeClass("module-item-active-stopped");
				}
			break;
			case "reload":
				$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects&request=getProjectDetails&id="+data.id, success: function(text){
					$("#projects-right").html(text.html);
						initProjectsContentScrollbar();
					}
				});
			break;
		}
	}


	this.poformOptions = { beforeSubmit: this.formProcess, dataType: 'json', success: this.formResponse };


	this.actionClose = function() {
		projectsLayout.toggle('west');
	}


	this.getNavModulesNumItems = function(id) {
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: 'path=apps/projects&request=getNavModulesNumItems&id=' + id, success: function(data){
				$.each( data, function(k, v){
   					$('#'+k).html(v);
 				});
			}
		});
	}


	this.actionNew = function() {
		var module = this;
		var cid = $('#projects input[name="id"]').val()
		module.checkIn(cid);
		var id = $('#projects').data('first');
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: 'path=apps/projects&request=newProject&id=' + id, cache: false, success: function(data){
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects&request=getProjectList&id="+id, success: function(list){
				$("#projects2 ul").html(list.html);
				var index = $("#projects2 .module-click").index($("#projects2 .module-click[rel='"+data.id+"']"));
				setModuleActive($("#projects2"),index);
				$('#projects').data({ "second" : data.id });
				$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects&request=getProjectDetails&id="+data.id, success: function(text){
					$("#projects-right").html(text.html);
					initProjectsContentScrollbar();
					$('#projects-right .focusTitle').trigger('click');
					}
				});
				projectsActions(0);
				}
			});
			}
		});
	}


	this.actionDuplicate = function() {
		var module = this;
		var cid = $('#projects input[name="id"]').val()
		module.checkIn(cid);
		var pid = $("#projects").data("second");
		var oid = $("#projects").data("first");
		$.ajax({ type: "GET", url: "/", data: 'path=apps/projects&request=createDuplicate&id=' + pid, cache: false, success: function(id){
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects&request=getProjectList&id="+oid, success: function(data){
				$("#projects2 ul").html(data.html);
					projectsActions(0);
					var idx = $("#projects2 .module-click").index($("#projects2 .module-click[rel='"+id+"']"));
					setModuleActive($("#projects2"),idx)
					$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects&request=getProjectDetails&id="+id, success: function(text){
							$("#projects").data("second",id);
							$("#"+projects.name+"-right").html(text.html);
							initProjectsContentScrollbar();
						}
					});
				}
			});
			}
		});
	}


	this.actionBin = function() {
		var module = this;
		var cid = $('#projects input[name="id"]').val()
		module.checkIn(cid);
		var txt = ALERT_DELETE;
		var langbuttons = {};
		langbuttons[ALERT_YES] = true;
		langbuttons[ALERT_NO] = false;
		$.prompt(txt,{ 
			buttons:langbuttons,
			callback: function(v,m,f){		
				if(v){
					var id = $("#projects").data("second");
					var fid = $("#projects").data("first");
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
								$("#projects").data("second", id);
								$("#projects2 .module-click:eq(0)").addClass('active-link');
								$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects&request=getProjectDetails&fid="+fid+"&id="+id, success: function(text){
									$("#projects-right").html(text.html);
									initProjectsContentScrollbar();
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


	this.checkIn = function(id) {
		$.ajax({ type: "GET", url: "/", async: false, data: 'path=apps/projects&request=checkinProject&id='+id, success: function(data){
				if(!data) {
					prompt("something wrong");
				}
			}
		});
	}


	this.actionRefresh = function() {
		var oid = $('#projects').data('first');
		var pid = $('#projects').data('second');
		$("#projects2 .active-link").trigger("click");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects&request=getProjectList&id="+oid, success: function(data){
			$("#projects2 ul").html(data.html);
			var idx = $("#projects2 .module-click").index($("#projects2 .module-click[rel='"+pid+"']"));
			$("#projects2 .module-click:eq("+idx+")").addClass('active-link');
			}
		});
	}
	
	this.actionHandbook = function() {
		var id = $("#projects").data("second");
		var url ='/?path=apps/projects&request=printProjectHandbook&id='+id;
		$("#documentloader").attr('src', url);	
	}


	this.actionPrint = function() {
		var id = $("#projects").data("second");
		var url ='/?path=apps/projects&request=printProjectDetails&id='+id;
		$("#documentloader").attr('src', url);
	}


	this.actionSend = function() {
		var id = $("#projects").data("second");
		$.ajax({ type: "GET", url: "/", data: "path=apps/projects&request=getProjectSend&id="+id, success: function(html){
			$("#modalDialogForward").html(html).dialog('open');
			}
		});
	}


	this.actionSendtoResponse = function() {
		var id = $("#projects").data("second");
		$.ajax({ type: "GET", url: "/", data: "path=apps/projects&request=getSendtoDetails&id="+id, success: function(html){
			$("#project_sendto").html(html);
			$("#modalDialogForward").dialog('close');
			}
		});
	}


	this.sortclick = function (obj,sortcur,sortnew) {
		var module = this;
		var cid = $('#projects input[name="id"]').val()
		module.checkIn(cid);
		var fid = $("#projects .module-click:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects&request=getProjectList&id="+fid+"&sort="+sortnew, success: function(data){
			$("#projects2 ul").html(data.html);
			obj.attr("rel",sortnew);
			obj.removeClass("sort"+sortcur).addClass("sort"+sortnew);
			var id = $("#projects2 .module-click:eq(0)").attr("rel");
			$('#projects').data('second',id);
			if(id == undefined) {
				return false;
			}
			setModuleActive($("#projects2"),'0');
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects&request=getProjectDetails&id="+id, success: function(text){
				$("#"+projects.name+"-right").html(text.html);
				initProjectsContentScrollbar()
				}
			});
			}
		});
	}


	this.sortdrag = function (order) {
		var fid = $("#projects .module-click:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", data: "path=apps/projects&request=setProjectOrder&"+order+"&id="+fid, success: function(html){
			$("#projects2 .sort").attr("rel", "3");
			$("#projects2 .sort").removeClass("sort1").removeClass("sort2").addClass("sort3");
			}
		});
	}
	
	
	this.actionDialog = function(offset,request,field,append,title,sql) {
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


	this.insertStatusDate = function(rel,text) {
		var html = '<div class="listmember" field="projectsstatus" uid="'+rel+'" style="float: left">' + text + '</div>';
		$("#projectsstatus").html(html);
		$("#modalDialog").dialog("close");
		$("#projectsstatus").nextAll('img').trigger('click');
	}
	
	
	this.insertFolderFromDialog = function(field,gid,title) {
		var html = '<a class="listmember" uid="' + gid + '" field="'+field+'">' + title + '</a>';
		$("#"+field).html(html);
		$("#modalDialog").dialog('close');
		var obj = getCurrentModule();
		$('#projects .coform').ajaxSubmit(obj.poformOptions);
	}
	
	this.actionHelp = function() {
		var url = "/?path=apps/projects&request=getProjectsHelp";
		$("#documentloader").attr('src', url);
	}


	// Recycle Bin
	this.binDelete = function(id) {
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
	}


	this.binRestore = function(id) {
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
	}


	this.markNoticeRead = function(pid) {
		$.ajax({ type: "GET", url: "/", data: "path=apps/projects&request=markNoticeRead&pid=" + pid, cache: false});
	}


}

var projects = new projectsApplication('projects');
//projects.resetModuleHeights = projectsresetModuleHeights;
projects.modules_height = projects_num_modules*module_title_height;
projects.GuestHiddenModules = new Array("controlling","access");


// register folder object
function projectsFolders(name) {
	this.name = name;


	this.formProcess = function(formData, form, poformOptions) {
		var title = $("#projects input.title").fieldValue();
		if(title == "") {
			$.prompt(ALERT_NO_TITLE, {callback: setTitleFocus});
			return false;
		} else {
			formData[formData.length] = { "name": "title", "value": title };
		}
	}
	
	
	this.formResponse = function(data) {
		switch(data.action) {
			case "edit":
				$("#projects1 span[rel='"+data.id+"'] .text").html($("#projects .title").val());
			break;
		}
	}


	this.poformOptions = { beforeSubmit: this.formProcess, dataType: 'json', success: this.formResponse };

	
	this.actionNew = function() {
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects&request=newFolder", cache: false, success: function(data){
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects&request=getFolderList", success: function(list){
				$("#projects1 ul").html(list.html);
				$("#projects1 li").show();
				var index = $("#projects1 .module-click").index($("#projects1 .module-click[rel='"+data.id+"']"));
				setModuleActive($("#projects1"),index);
				$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects&request=getFolderDetails&id="+data.id, success: function(text){
					$("#projects").data("first",data.id);
					$("#projects-right").html(text.html);
					initProjectsContentScrollbar();
					$('#projects-right .focusTitle').trigger('click');
					}
				});
				projectsActions(9);
				}
			});
			}
		});
	}
	
	
	this.actionBin = function() {
		var txt = ALERT_DELETE;
		var langbuttons = {};
		langbuttons[ALERT_YES] = true;
		langbuttons[ALERT_NO] = false;
		$.prompt(txt,{ 
			buttons:langbuttons,
			callback: function(v,m,f){		
				if(v){
					var id = $("#projects").data("first");
					$.ajax({ type: "GET", url: "/", data: "path=apps/projects&request=binFolder&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects&request=getFolderList", success: function(data){
								$("#projects1 ul").html(data.html);
								if(data.html == "<li></li>") {
									projectsActions(3);
								} else {
									projectsActions(9);
								}
								var id = $("#projects1 .module-click:eq(0)").attr("rel");
								$("#projects").data("first",id);
								$("#projects1 .module-click:eq(0)").addClass('active-link');
								$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects&request=getFolderDetails&id="+id, success: function(text){
									$("#"+projects.name+"-right").html(text.html);
									initProjectsContentScrollbar();
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


	this.checkIn = function(id) {
		return true;
	}


	this.actionRefresh = function() {
		var id = $("#projects").data("first");
		$("#projects1 .active-link").trigger("click");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects&request=getFolderList", success: function(data){
			$("#projects1 ul").html(data.html);
			if(data.access == "guest") {
				projectsActions();
			} else {
				if(data.html == "<li></li>") {
					projectsActions(3);
				} else {
					projectsActions(9);
				}
			}
			var idx = $("#projects1 .module-click").index($("#projects1 .module-click[rel='"+id+"']"));
			$("#projects1 .module-click:eq("+idx+")").addClass('active-link');
			}
		});
	}


	this.actionPrint = function() {
		var id = $("#projects").data("first");
		var url ='/?path=apps/projects&request=printFolderDetails&id='+id;
		$("#documentloader").attr('src', url);
	}


	this.actionSend = function() {
		var id = $("#projects").data("first");
		$.ajax({ type: "GET", url: "/", data: "path=apps/projects&request=getFolderSend&id="+id, success: function(html){
			$("#modalDialogForward").html(html).dialog('open');
			}
		});
	}


	this.actionSendtoResponse = function() {
		$("#modalDialogForward").dialog('close');
	}

	
	this.sortclick = function (obj,sortcur,sortnew) {
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects&request=getFolderList&sort="+sortnew, success: function(data){
			$("#projects1 ul").html(data.html);
			obj.attr("rel",sortnew);
		  	obj.removeClass("sort"+sortcur).addClass("sort"+sortnew);
			var id = $("#projects1 .module-click:eq(0)").attr("rel");
			$('#projects').data('first',id);
			$("#projects1 .module-click:eq(0)").addClass('active-link');
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects&request=getFolderDetails&id="+id, success: function(text){
				$("#projects-right").html(text.html);
				initProjectsContentScrollbar()
				}
			});
			}
		});
	}


	this.sortdrag = function (order) {
		$.ajax({ type: "GET", url: "/", data: "path=apps/projects&request=setFolderOrder&"+order, success: function(html){
			$("#projects1 .sort").attr("rel", "3");
			$("#projects1 .sort").removeClass("sort1").removeClass("sort2").addClass("sort3");
			}
		});
	}
	
	
	this.actionDialog = function(offset,request,field,append,title,sql) {
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


	this.actionHelp = function() {
		var url = "/?path=apps/projects&request=getProjectsFoldersHelp";
		$("#documentloader").attr('src', url);
	}


	// Recycle Bin
	this.binDelete = function(id) {
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
	}
	
	
	this.binRestore = function(id) {
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
	}

	
}

var projects_folder = new projectsFolders('projects_folder');


function projectsActions(status) {
	/*	0= new	1= print	2= send		3= duplicate	4= handbook		5=refresh 	6 = delete*/
	switch(status) {
		case 0: actions = ['0','1','2','3','5','6','7','8']; break;
		case 1: actions = ['0','6','7','8']; break;
		case 3: 	actions = ['0','6','7']; break;   					// just new
		case 4: 	actions = ['0','1','2','5','6','7']; break;   		// new, print, send, handbook, refresh
		case 5: 	actions = ['1','2','6','7']; break;   			// print, send, refresh
		case 6: 	actions = ['5','6','7']; break;   			// handbook refresh
		case 7: 	actions = ['0','1','2','6','7']; break;   			// new, print, send, refresh
		case 8: 	actions = ['1','2','5','6','7']; break;   			// print, send, handbook, refresh
		case 9:		actions = ['0','1','2','6','7','8']; break;
		// vdocs
		// 0 == 10
		case 10: actions = ['0','1','2','3','4','5','6','7','8']; break;
		// 5 == 11
		case 11: 	actions = ['1','2','4','6','7']; break;   			// print, send, refresh
		default: 	actions = ['6','7'];  								// none
	}
	$('#projectsActions > li span').each( function(index) {
		if(index in oc(actions)) {
			$(this).removeClass('noactive');
		} else {
			$(this).addClass('noactive');
		}
	})
}



var projectsLayout, projectsInnerLayout;


$(document).ready(function() {
	
	projects.init();
	
	if($('#projects').length > 0) {
		projectsLayout = $('#projects').layout({
				west__onresize:				function() { resetModuleHeightsnavThree('projects'); }
			,	resizeWhileDragging:		true
			,	spacing_open:				0
			,	spacing_closed:				0
			,	closable: 					false
			,	resizable: 					false
			,	slidable:					false
			, 	west__size:					325
			,	west__closable: 			true
			,	center__onresize: 			"projectsInnerLayout.resizeAll"
		});
		
		projectsInnerLayout = $('#projects div.ui-layout-center').layout({
				center__onresize:			function() {  }
			,	resizeWhileDragging:		true
			,	spacing_open:				0
			,	closable: 					false
			,	resizable: 					false
			,	slidable:					false
			,	north__paneSelector:		".center-north"
			,	center__paneSelector:		".center-center"
			,	west__paneSelector:			".center-west"
			, 	north__size:				68
			, 	west__size:					60
		});

		loadModuleStartnavThree('projects');
	}


	$("#projects1-outer").on('click', 'h3', function(e, passed_id) {
		e.preventDefault();
		navThreeTitleFirst('projects',$(this),passed_id)
		prevent_dblclick(e)
	});


	$("#projects2-outer").on('click', 'h3', function(e, passed_id) {
		e.preventDefault();
		navThreeTitleSecond('projects',$(this),passed_id)
		prevent_dblclick(e)
	});


	$("#projects3").on('click', 'h3', function(e, passed_id) {
		e.preventDefault();
		navThreeTitleThird('projects',$(this),passed_id)
		prevent_dblclick(e)
	});

	$('#projects1').on('click', 'span.module-click', function(e) {
		e.preventDefault();
		navItemFirst('projects',$(this))
		prevent_dblclick(e)
	});


	$('#projects2').on('click', 'span.module-click', function(e) {
		e.preventDefault();
		navItemSecond('projects',$(this))
		prevent_dblclick(e)
	});


	$('#projects3').on('click', 'span.module-click', function(e) {
		e.preventDefault();
		navItemThird('projects',$(this))
		prevent_dblclick(e)
	});
	
	
	$(document).on('click', 'a.insertProjectFolderfromDialog',function(e) {
		e.preventDefault();
		var field = $(this).attr("field");
		var gid = $(this).attr("gid");
		var title = $(this).attr("title");
		var obj = getCurrentModule();
		obj.insertFolderFromDialog(field,gid,title);
	});


	// INTERLINKS FROM Content
	
	// load a project
	$(document).on('click', '.loadProject', function(e) {
		e.preventDefault();
		var obj = getCurrentModule();
		if(confirmNavigation()) {
			formChanged = false;
			$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		}
		var id = $(this).attr("rel");
		$("#projects2-outer > h3").trigger('click', [id]);
	});

	// load a phase
	$(document).on('click', '.loadProjectsPhase', function(e) {
		e.preventDefault();
		var obj = getCurrentModule();
		if(confirmNavigation()) {
			formChanged = false;
			$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		}
		
		var id = $(this).attr("rel");
		$("#projects3 h3[rel='phases']").trigger('click', [id]);
	});


	$('span.actionProjectHandbook').on('click',function(e){
		e.preventDefault();
		if($(this).hasClass("noactive")) {
			return false;
		}
		projects.actionHandbook();
	});

	
	// barchart opacity with jquery
	$(".barchart-phase-bg").livequery( function() {
		$(this).css("opacity","0.3");
	});

	$("#todayBar").livequery( function() {
		$(this).css("opacity","0.4");
	});
	// becomes global Tooltip?
	$(".coTooltip").livequery( function() {
		$(this).tooltip({
			track: true,
			delay: 0,
			fade: 200,
			bodyHandler: function() { 
				return $(this).find(".coTooltipHtml").html(); 
			}, 
			showURL: false 
		});
	});


});