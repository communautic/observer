function initProjectsContentScrollbar() {
	projectsInnerLayout.initContent('center');
}

/* projects Object */
function projectsApplication(name) {
	this.name = name;
	
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
						$("#projects2 .active-link .module-item-status").addClass("module-item-active").removeClass("module-item-active-stopped");
					break;
					case "3":
						$("#projects2 .active-link .module-item-status").addClass("module-item-active-stopped").removeClass("module-item-active");
					break;
					default:
						$("#projects2 .active-link .module-item-status").removeClass("module-item-active").removeClass("module-item-active-stopped");
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


	this.actionNew = function() {
		var module = this;
		var cid = $('#projects input[name="id"]').val()
		module.checkIn(cid);
		var id = $('#'+projects.name+' .module-click:visible').attr("rel");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: 'path=apps/projects&request=newProject&id=' + id, cache: false, success: function(data){
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects&request=getProjectList&id="+id, success: function(list){
				$("#projects2 ul").html(list.html);
				var index = $("#projects2 .module-click").index($("#projects2 .module-click[rel='"+data.id+"']"));
				setModuleActive($("#projects2"),index);
				$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects&request=getProjectDetails&id="+data.id, success: function(text){
					$("#projects-right").html(text.html);
					initProjectsContentScrollbar();
					$('#projects2 input.filter').quicksearch('#projects2 li');
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
							initProjectsContentScrollbar();
							$('#projects2 input.filter').quicksearch('#projects2 li');
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
									initProjectsContentScrollbar();
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


	this.checkIn = function(id) {
		$.ajax({ type: "GET", url: "/", async: false, data: 'path=apps/projects&request=checkinProject&id='+id, success: function(data){
				if(!data) {
					prompt("something wrong");
				}
			}
		});
	}


	this.actionRefresh = function() {
		var pid = $("#projects2 .active-link").attr("rel");
		var oid = $("#projects1 .module-click:visible").attr("rel");
		$("#projects2 .active-link:visible").trigger("click");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects&request=getProjectList&id="+oid, success: function(data){
			$("#projects2 ul").html(data.html);
			var idx = $("#projects2 .module-click").index($("#projects2 .module-click[rel='"+pid+"']"));
			$("#projects2 .module-click:eq("+idx+")").addClass('active-link');
			$('#projects2 input.filter').quicksearch('#projects3 li');
			}
		});
	}
	
	this.actionHandbook = function() {
		var obj = getCurrentModule();
		if(obj.name == 'projects') {
			var id = $("#projects2 .active-link").attr("rel");
		} else {
			var id = $('#projects2 .module-click:visible').attr("rel");
		}
		var url ='/?path=apps/projects&request=printProjectHandbook&id='+id;
		location.href = url;	
	}


	this.actionPrint = function() {
		var id = $("#projects2 .active-link").attr("rel");
		var url ='/?path=apps/projects&request=printProjectDetails&id='+id;
		location.href = url;
	}


	this.actionSend = function() {
		var id = $("#projects2 .active-link").attr("rel");
		$.ajax({ type: "GET", url: "/", data: "path=apps/projects&request=getProjectSend&id="+id, success: function(html){
			$("#modalDialogForward").html(html).dialog('open');
			}
		});
	}


	this.actionSendtoResponse = function() {
		var id = $("#projects2 .active-link").attr("rel");
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
			$('#projects2').find('input.filter').quicksearch('#projects2 li');
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


}

var projects = new projectsApplication('projects');
projects.resetModuleHeights = projectsresetModuleHeights;
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
					$("#"+projects.name+"-right").html(text.html);
					initProjectsContentScrollbar();
					$('#projects1 input.filter').quicksearch('#projects1 li');
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
					var id = $("#projects1 .active-link").attr("rel");
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
								$("#projects1 .module-click:eq(0)").addClass('active-link');
								$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects&request=getFolderDetails&id="+id, success: function(text){
									$("#"+projects.name+"-right").html(text.html);
									initProjectsContentScrollbar();
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


	this.checkIn = function(id) {
		return true;
	}


	this.actionRefresh = function() {
		var id = $("#projects1 .active-link").attr("rel");
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
			$('#projects1 input.filter').quicksearch('#projects1 li');
			}
		});
	}


	this.actionPrint = function() {
		var id = $("#projects1 .active-link").attr("rel");
		var url ='/?path=apps/projects&request=printFolderDetails&id='+id;
		location.href = url;
	}


	this.actionSend = function() {
		var id = $("#projects1 .active-link").attr("rel");
		$.ajax({ type: "GET", url: "/", data: "path=apps/projects&request=getFolderSend&id="+id, success: function(html){
			$("#modalDialogForward").html(html).dialog('open');
			}
		});
	}


	this.actionSendtoResponse = function() {
		//var id = $("#projects1 .active-link").attr("rel");
		//$.ajax({ type: "GET", url: "/", data: "path=apps/projects&request=getSendtoDetails&id="+id, success: function(html){
			//$("#project_sendto").html(html);
			$("#modalDialogForward").dialog('close');
			//}
		//});
	}

	
	this.sortclick = function (obj,sortcur,sortnew) {
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects&request=getFolderList&sort="+sortnew, success: function(data){
			$("#projects1 ul").html(data.html);
			obj.attr("rel",sortnew);
		  	obj.removeClass("sort"+sortcur).addClass("sort"+sortnew);
			$('#projects1 input.filter').quicksearch('#projects1 li');
			var id = $("#projects1 .module-click:eq(0)").attr("rel");
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
		//case 0: 	actions = ['0','1','2','3','4']; break; // all actions
		case 0: actions = ['0','1','2','3','4','5','6']; break;
		//case 1: 	actions = ['0','1','2','4']; break; 	// no duplicate
		case 1: actions = ['0','5','6']; break;
		//case 2: 	actions = ['1']; break;   					// just save
		case 3: 	actions = ['0']; break;   					// just new
		case 4: 	actions = ['0','1','2','4','5']; break;   		// new, print, send, handbook, refresh
		case 5: 	actions = ['1','2','5']; break;   			// print, send, refresh
		case 6: 	actions = ['4','5']; break;   			// handbook refresh
		case 7: 	actions = ['0','1','2','5']; break;   			// new, print, send, refresh
		case 8: 	actions = ['1','2','4','5']; break;   			// print, send, handbook, refresh
		case 9:		actions = ['0','1','2','5','6']; break;
		default: 	actions = ['5'];  								// none
	}
	$('#projectsActions > li span').each( function(index) {
		if(index in oc(actions)) {
			$(this).removeClass('noactive');
		} else {
			$(this).addClass('noactive');
		}
	})
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
		$("#projectsActions .actionNew").attr("title",data.title);
		
		if(data.access == "guest") {
			projectsActions();
		} else {
			if(data.html == "<li></li>") {
				projectsActions(3);
			} else {
				projectsActions(9);
			}
		}
		
		$("#projects1").css("overflow", "auto").animate({height: h-71}, function() {
			$("#projects1 li").show();
			$("#projects1 .sort").attr("rel", data.sort).addClass("sort"+data.sort);
			projectsInnerLayout.initContent('center');
			//initScrollbar( '#projects .scrolling-content' );
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
		$("#projects2").css("overflow", "auto").animate({height: h-(projects.modules_height+96)}, function() {
			$(this).find('.west-ui-content	').height(h-(projects.modules_height+96));																							   
		});
	}
	$("#projects3").css("height", h-121);
	$("#projects3 .projects3-content").css("height", h-(projects.modules_height+121));
	//initScrollbar( '#projects .scrolling-content' );
}

function ProjectsModulesDisplay(access) {
	var h = $("#projects .ui-layout-west").height();
	if(access == "guest" || access == "guestadmin") {
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
						   
	if($('#projects').length > 0) {
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
				center__onresize:				function() {  }
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
	}

	$("#projects1-outer > h3").click(function(event, passed_id) {
		var obj = getCurrentModule();
		if(confirmNavigation()) {
			formChanged = false;
			$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		}
		var cid = $('#projects input[name="id"]').val()
		obj.checkIn(cid);
		
		if($(this).hasClass("module-bg-active")) {
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
				//initScrollbar( '#projects .scrolling-content' );
				$('#projects1 input.filter').quicksearch('#projects1 li');
				if(passed_id === undefined) {
						var id = $("#projects1 .module-click:eq(0)").attr("rel");
						$("#projects1 .module-click:eq(0)").addClass('active-link');
					} else {
						var id = passed_id;
						$("#projects1 .module-click[rel='"+id+"']").addClass('active-link');
					}
				
				
				//$("#projects1 .drag:eq(0)").show();
				$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects&request=getFolderDetails&id="+id, success: function(text){
					$("#projects-right").html(text.html);
					//projectsInnerLayout.initContent('center');
					initProjectsContentScrollbar();
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
						projectsActions(9);
					}
				}
				$('#projects1 input.filter').quicksearch('#projects1 li');
				$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects&request=getFolderDetails&id="+id, success: function(text){
					$("#projects1 li").show();
					setModuleActive($("#projects1"),index);
					
					$("#projects1").css("overflow", "auto").animate({height: h-46}, function() {
						$("#"+projects.name+"-right").html(text.html);
						//initScrollbar( '#projects .scrolling-content' );
						$("#projects-current").val("folder");
						setModuleDeactive($("#projects2"),'0');
						setModuleDeactive($("#projects3"),'0');
						$("#projects2 li").show();
						$("#projects2").css("height", h-96).removeClass("module-active");
						$("#projects2").prev("h3").removeClass("white");
						$("#projects2 .module-inner").css("height", h-96);
						$("#projects3 h3").removeClass("module-bg-active");
						$("#projects3 .projects3-content:visible").slideUp();
						initProjectsContentScrollbar();
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
		var obj = getCurrentModule();
		if(confirmNavigation()) {
			formChanged = false;
			$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		}
		var cid = $('#projects input[name="id"]').val()
		obj.checkIn(cid);
		
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
					$("#projectsActions .actionNew").attr("title",data.title);
					
					$("#projects2 li").show();
					setModuleActive($("#projects2"),index);
					$("#projects2 .sort").attr("rel", data.sort).addClass("sort"+data.sort);
					$('#projects2 input.filter').quicksearch('#projects2 li');
					$("#projects2").css("overflow", "auto").animate({height: h-(projects.modules_height+96)}, function() {
					$(this).find('.west-ui-content	').height(h-(projects.modules_height+96));
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
											projectsActions(3);
										} else {
											projectsActions(0);
											$('#projects2').find('input.filter').quicksearch('#projects2 li');
										}
									break;
									case "guestadmin":
										if(data.html == "<li></li>") {
											projectsActions(3);
										} else {
											projectsActions(7);
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
						initProjectsContentScrollbar();
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
					$("#projectsActions .actionNew").attr("title",data.title);
					if(passed_id === undefined) {
						var projectid = $("#projects2 .module-click:eq(0)").attr("rel");
					} else {
						var projectid = passed_id;					
					}
				
					if($("#projects1").height() != module_title_height) {
						var idx = $("#projects2 .module-click").index($("#projects2 .module-click[rel='"+projectid+"']"));
						setModuleActive($("#projects2"),idx);
						$("#projects2 .sort").attr("rel", data.sort).addClass("sort"+data.sort);
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
											projectsActions(3);
										} else {
											projectsActions(0);
											$('#projects2').find('input.filter').quicksearch('#projects2 li');
										}
									break;
									case "guestadmin":
										if(data.html == "<li></li>") {
											projectsActions(3);
										} else {
											projectsActions(7);
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
								initProjectsContentScrollbar();
								var h = $("#projects .ui-layout-west").height();
								if(text.access != "sysadmin") { ProjectsModulesDisplay(text.access); }
								$("#projects2").delay(200).animate({height: h-(projects.modules_height+96)}, function() {
									$(this).find('.west-ui-content	').height(h-(projects.modules_height+96));																			  
									});
								}
							});
						});
					} else {
						$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects&request=getProjectDetails&id="+projectid, success: function(text){
							$("#"+projects.name+"-right").html(text.html);
							initProjectsContentScrollbar();
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
			$("#projects1-outer > h3").trigger("click");
			return false;
		}
		var obj = getCurrentModule();
		if(confirmNavigation()) {
			formChanged = false;
			$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		}
		var cid = $('#projects input[name="id"]').val()
		obj.checkIn(cid);
		
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
					projectsActions(9);
				}
			}
		});
		
		return false;
	});


	$("#projects2 .module-click").live('click',function(e) {
		if($(this).hasClass("deactivated")) {
			$("#projects2-outer > h3").trigger("click");
			return false;
		}
		var obj = getCurrentModule();
		if(confirmNavigation()) {
			formChanged = false;
			$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		}
		var cid = $('#projects input[name="id"]').val()
		obj.checkIn(cid);
		
		var fid = $("#projects .module-click:visible").attr("rel");
		var id = $(this).attr("rel");
		var index = $("#projects .module-click").index(this);
		$("#projects .module-click").removeClass("active-link");
		$(this).addClass("active-link");
		$("#projects-top .top-headline").html($("#projects .module-click:visible").find(".text").html());
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects&request=getProjectDetails&fid="+fid+"&id="+id, success: function(text){
			$("#projects-right").html(text.html);
			
			if($('#checkedOut').length > 0) {
				$("#projects2 .active-link .icon-checked-out").addClass('icon-checked-out-active');
			} else {
				$("#projects2 .active-link .icon-checked-out").removeClass('icon-checked-out-active');
			}
			switch (text.access) {
				case "sysadmin":
					projectsActions(0);
				break;
				case "admin":
					projectsActions(0);
				break;
				case "guestadmin":
					projectsActions(7);
				break;
				case "guest":
					projectsActions(5);
				break;
			}

			initProjectsContentScrollbar();
			
			var h = $("#projects .ui-layout-west").height();
			$("#projects2").delay(200).animate({height: h-96}, function() {
				if(text.access != "sysadmin") { ProjectsModulesDisplay(text.access); }
				$(this).animate({height: h-(projects.modules_height+96)}, function() {
				$(this).find('.west-ui-content	').height(h-(projects.modules_height+96));									   
				});			 
			});
			
			}
			
		});
		return false;
	});


	$("#projects3 .module-click").live('click',function() {
		var obj = getCurrentModule();
		if(confirmNavigation()) {
			formChanged = false;
			$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		}
		var cid = $('#projects input[name="id"]').val()
		obj.checkIn(cid);
		
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
		var obj = getCurrentModule();
		if(confirmNavigation()) {
			formChanged = false;
			$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		}
		var cid = $('#projects input[name="id"]').val()
		obj.checkIn(cid);
		
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
							$("#projectsActions .actionNew").attr("title",data.title);
							switch (data.perm) {
				case "sysadmin": case "admin" :
					if(data.html == "<li></li>") {
						projectsActions(3);
					} else {
						projectsActions(0);
						$('#projects3').find('input.filter').quicksearch('#projects3 li');
					}
				break;
				case "guest":
					if(data.html == "<li></li>") {
						projectsActions();
					} else {
						projectsActions(5);
						$('#projects3').find('input.filter').quicksearch('#projects3 li');
					}
				break;
			}
							
							
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
					$("#projectsActions .actionNew").attr("title",data.title);
					switch (data.perm) {
				case "sysadmin": case "admin" :
					if(data.html == "<li></li>") {
						projectsActions(3);
					} else {
						projectsActions(0);
						$('#projects3').find('input.filter').quicksearch('#projects3 li');
					}
				break;
				case "guest":
					if(data.html == "<li></li>") {
						projectsActions();
					} else {
						projectsActions(5);
						$('#projects3').find('input.filter').quicksearch('#projects3 li');
					}
				break;
			}
					
					
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

 
    /*$("#projects .loadModuleStart").click(function() {
		loadModuleStart();
		return false;
	});*/
  
	
	/*$('a.insertAccess').live('click',function() {
		var rel = $(this).attr("rel");
		var field = $(this).attr("field");
		var html = '<div class="listmember" field="'+field+'" uid="'+rel+'">' + $(this).html() + '</div>';
		$("#"+field).html(html);
		$("#modalDialog").dialog("close");
		var obj = getCurrentModule();
		$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		return false;
	});*/
	
	
	
	$('a.insertProjectFolderfromDialog').livequery('click',function(e) {
		e.preventDefault();
		var field = $(this).attr("field");
		var gid = $(this).attr("gid");
		var title = $(this).attr("title");
		var obj = getCurrentModule();
		obj.insertFolderFromDialog(field,gid,title);
	});
	

	/*$('a.insertProjectFolderfromDialog').livequery('click',function() {
		var field = $(this).attr("field");
		var gid = $(this).attr("gid");
		var title = $(this).attr("title");
		var html = '<a class="listmember" uid="' + gid + '" field="'+field+'">' + title + '</a>';
		$("#"+field).html(html);
		$("#modalDialog").dialog('close');
		var obj = getCurrentModule();
		$('#projects .coform').ajaxSubmit(obj.poformOptions);
	});*/
	
	
// INTERLINKS FROM Content
	
	// load a project
	$(".loadProject").live('click', function() {
		
		var obj = getCurrentModule();
		if(confirmNavigation()) {
			formChanged = false;
			$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		}
		
		var id = $(this).attr("rel");
		$("#projects2-outer > h3").trigger('click', [id]);
		return false;
	});

	
	// load a phase
	$(".loadProjectsPhase").live('click', function() {
		
		var obj = getCurrentModule();
		if(confirmNavigation()) {
			formChanged = false;
			$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		}
		var cid = $('#projects input[name="id"]').val()
		obj.checkIn(cid);
		
		var id = $(this).attr("rel");
		$("#projects3 h3[rel='phases']").trigger('click', [id]);
		return false;
	});
	
	$(".loadProjectsPhase2").live('click', function() {
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