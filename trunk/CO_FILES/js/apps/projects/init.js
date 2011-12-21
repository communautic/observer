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


	this.actionClose = function() {
		projectsLayout.toggle('west');
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
		location.href = url;	
	}


	this.actionPrint = function() {
		var id = $("#projects").data("second");
		var url ='/?path=apps/projects&request=printProjectDetails&id='+id;
		location.href = url;
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
		location.href = url;
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
		case 0: actions = ['0','1','2','3','4','5','6','7']; break;
		case 1: actions = ['0','5','6','7']; break;
		case 3: 	actions = ['0','5','6']; break;   					// just new
		case 4: 	actions = ['0','1','2','4','5','6']; break;   		// new, print, send, handbook, refresh
		case 5: 	actions = ['1','2','5','6']; break;   			// print, send, refresh
		case 6: 	actions = ['4','5','6']; break;   			// handbook refresh
		case 7: 	actions = ['0','1','2','5','6']; break;   			// new, print, send, refresh
		case 8: 	actions = ['1','2','4','5','6']; break;   			// print, send, handbook, refresh
		case 9:		actions = ['0','1','2','5','6','7']; break;
		default: 	actions = ['5','6'];  								// none
	}
	$('#projectsActions > li span').each( function(index) {
		if(index in oc(actions)) {
			$(this).removeClass('noactive');
		} else {
			$(this).addClass('noactive');
		}
	})
}




// 71 = 98
// 98 = 125
// 121 = 150

// 98 = 98

function projectsloadModuleStart() {
	var h = $("#projects div.ui-layout-west").height();
	$("#projects .ui-layout-west .radius-helper").height(h);
	$("#projects .secondLevelOuter").css('top',h-27);
	$("#projects .thirdLevelOuter").css('top',150);
	$('#projects1').data('status','open');
	$('#projects2').data('status','closed');
	$('#projects3').data('status','closed');
	$("#projects1").height(h-98);
	$("#projects1 .module-inner").height(h-98);
	$("#projects1 .module-actions").show();
	$("#projects2 .module-actions").hide();
	$("#projects2 li").show();
	$("#projects2").height(h-125-projects_num_modules*27).removeClass("module-active");
	$("#projects2 .module-inner").height(h-125-projects_num_modules*27);
	$("#projects3 .module-actions").hide();
	$("#projects3").height(h-150);
	$("#projects3 .projects3-content").height(h-(projects.modules_height+152));
	$("#projects3 div.thirdLevel").height(h-(projects.modules_height+150-27));
	$("#projects-current").val("folder");
	$("#projects3 div.thirdLevel").each(function(i) { 
		var position = $(this).position();
		var t = position.top+h-150;
		$(this).animate({top: t})
	})
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
		$("#projects1 li").show();
		$("#projects1 .sort").attr("rel", data.sort).addClass("sort"+data.sort);
		projectsInnerLayout.initContent('center');
		var id = $("#projects1 .module-click:eq(0)").attr("rel");
		$('#projects').data({ "current" : "folders" , "first" : id , "second" : 0 , "third" : 0});
		$("#projects1 .module-click:eq(0)").addClass('active-link');
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects&request=getFolderDetails&id="+id, success: function(text){
			$("#"+projects.name+"-right").html(text.html);
			projectsInnerLayout.initContent('center');
			}
		});
	}
	});
}


function projectsresetModuleHeights() {
	if(getCurrentApp() != 'projects') {
		$('#projects').css('top',2*$('#container-inner').height());
	}
	// fix for now - move desktop if not active
	if(getCurrentApp() != 'desktop') {
		$('#desktop').css('top',2*$('#container-inner').height());
	}
	var h = $("#projects div.ui-layout-west").height();
	$("#projects .ui-layout-west .radius-helper").height(h);
	$("#projects1").height(h-98);
	$("#projects1 .module-inner").height(h-98);
	$("#projects2").height(h-125-projects_num_modules*27);
	$("#projects2 .module-inner").height(h-125-projects_num_modules*27);
	$("#projects3").height(h-150);
	$("#projects3 .projects3-content").height(h-(projects.modules_height+152));
	$("#projects3 div.thirdLevel").height(h-(projects.modules_height+150-27));
	if($('#projects1').data('status') == 'open') {
		$("#projects2-outer").css('top',h-27);
		$("#projects3 div.thirdLevel").each(function(i) { 
			var t = h-150+i*27;
			$(this).animate({top: t})
		})
	}
	if($('#projects2').data('status') == 'open') {	
		var curmods = $("#projects3 div.thirdLevel:not(.deactivated)").size();
		$("#projects2").height(h-125-curmods*27).removeClass("module-active");
		$("#projects2 .module-inner").height(h-125-curmods*27);
		$("#projects3 .projects3-content").height(h-(curmods*27+152));
		$("#projects3 div.thirdLevel").height(h-(curmods*27+150-27));
		$("#projects3 div.thirdLevel:not(.deactivated)").each(function(i) { 
			var t = h-150-curmods*27+i*27;
			$(this).animate({top: t})
		})
	}
	if($('#projects3').data('status') == 'open') {
		var obj = getCurrentModule();
		var idx = $('#projects3 .thirdLevel:not(.deactivated)').index($('#projects3 .thirdLevel:not(.deactivated)[id='+obj.name+']'));	
		var curmods = $("#projects3 div.thirdLevel:not(.deactivated)").size();
		$("#projects2").height(h-125-curmods*27).removeClass("module-active");
		$("#projects2 .module-inner").height(h-125-curmods*27);
		$("#projects3 .projects3-content").height(h-(curmods*27+152));
		$("#projects3 div.thirdLevel").height(h-(curmods*27+150-27));
		$("#projects3 div.thirdLevel:not(.deactivated)").each(function(i) { 
		if(i > idx) {
			var pos = $(this).position();
				var t = h-150-curmods*27+i*27;
				$(this).animate({top: t})
			}
		})
	}
}


function Projects2ModulesDisplay(access) {
	var h = $("#projects div.ui-layout-west").height();
	if(access == "guest" || access == "guestadmin") {
		var modLen = projects.GuestHiddenModules.length;
		var p_num_modules = projects_num_modules-modLen;
		var p_modules_height = p_num_modules*module_title_height;
		$("#projects3 .projects3-content").height(h-(p_modules_height+152));
		$("#projects3 div.thirdLevel").height(h-(p_modules_height+150-27));
		$("#projects2").height(h-125-p_num_modules*27).removeClass("module-active");
		$("#projects2 .module-inner").height(h-125-p_num_modules*27);
		var a = 0;
		var t = $("#projects2").height();
		$("#projects2").animate({height: t+p_modules_height})
		$("#projects2-outer").animate({top: 96}, function() {
			$("#projects3 div.thirdLevel").each(function(i) { 
				var rel = $(this).find('h3').attr('rel');
				if(projects.GuestHiddenModules.indexOf(rel) >= 0 ) {
					$(this).addClass('deactivated').animate({top: 9999})	
				} else {
					var t = $("#projects3").height()-p_num_modules*27+a*27;
						$(this).animate({top: t})			
					a = a+1;
				}
			})
			$("#projects-top .top-headline").html($("#projects1 .deactivated").find(".text").html());
			$("#projects2").animate({height: t})
		})
	} else {
		$("#projects3 .projects3-content").height(h-(projects.modules_height+152));
		$("#projects3 div.thirdLevel").height(h-(projects.modules_height+150-27));
		$("#projects2 .module-inner").height(h-125-projects_num_modules*27);
		var t = h-125-projects.modules_height;
		$("#projects2").animate({height: t+projects.modules_height})
		$("#projects2-outer").animate({top: 96}, function() {
			$("#projects3 div.thirdLevel").each(function(i) { 
				var t = $("#projects3").height()-projects.modules_height+i*27;
				$(this).animate({top: t})			
			})
			$("#projects-top .top-headline").html($("#projects1 .deactivated").find(".text").html());
			$("#projects2").animate({height: t})
		})
	}
}


function ProjectsModulesDisplay(access) {
	var h = $("#projects div.ui-layout-west").height();
	if(access == "guest" || access == "guestadmin") {
		var modLen = projects.GuestHiddenModules.length;
		var p_num_modules = projects_num_modules-modLen;
		p_modules_height = p_num_modules*module_title_height;
		$("#projects3 .projects3-content").height(h-(p_modules_height+152));
		$("#projects3 div.thirdLevel").height(h-(p_modules_height+150-27));
		$("#projects2").height(h-125-p_num_modules*27).removeClass("module-active");
		$("#projects2 .module-inner").height(h-125-p_num_modules*27);
		var a = 0;
		
		var t = $("#projects2").height();
		$("#projects2").animate({height: t+projects_num_modules*27}, function() {
			$(this).animate({height: t});
		})
		
		$("#projects3 div.thirdLevel").each(function(i) { 
			var rel = $(this).find('h3').attr('rel');
			if(projects.GuestHiddenModules.indexOf(rel) >= 0 ) {
				$(this).addClass('deactivated').animate({top: 9999})	
			} else {
				var t = $("#projects3").height()-p_num_modules*27+a*27;
				var position = $(this).position();
				var d = position.top+projects_num_modules*27;
				$(this).animate({top: d}, function() {
					$(this).animate({top: t})			
				})
				a = a+1;
			}
		})
	} else {
		$("#projects3 .projects3-content").height(h-(projects.modules_height+152));
		$("#projects3 div.thirdLevel").height(h-(projects.modules_height+150-27));
		$("#projects2 .module-inner").height(h-125-projects_num_modules*27);
		var curmods = $("#projects3 div.thirdLevel:not(.deactivated)").size();
		var t = h-125-projects_num_modules*27;
		$("#projects2").animate({height: t+projects_num_modules*27}, function() {
			$(this).animate({height: t});
		})
		$("#projects3 div.thirdLevel").each(function(i) { 
			$(this).removeClass('deactivated');
			var t = $("#projects3").height()-projects_num_modules*27+i*27;
				var position = $(this).position();
				var d = h-150+i*27;
				$(this).animate({top: d}, function() {
					$(this).animate({top: t})			
				})
		})
	}
}


function ProjectsExternalLoad(what,f,p,ph) { // from Desktop
	if(what == 'projects') {
		$('#projects').data({ "first" : f});
		var index = $('#projects1 .module-click').index($('#projects1 .module-click[rel='+f+']'));
		$.ajax({ type: "GET", url: "/", dataType:  'json', async: false, data: "path=apps/projects&request=getProjectList&id="+f, success: function(data){
			$("#projects2 ul").html(data.html);
			setModuleDeactive($("#projects1"),index);
			$('#projects1').find('li:eq('+index+')').show();
			$("#projects-top .top-headline").html($("#projects1 .deactivated").find(".text").html());
			}
		})
		$('#projects').data({ "second" : p});
		var index = $("#projects2 .module-click").index($("#projects2 .module-click[rel='"+p+"']"));
		setModuleActive($("#projects2"),index);
		$("#projects2-outer").css('top', 96);
		$('#projects3 h3').removeClass("module-bg-active");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects&request=getProjectDetails&fid="+f+"&id="+p, success: function(text){
			$("#projects-current").val(what);
			$('#projects').data({ "current" : what});
			$('#projects').data({ "second" : p});
			$('#projects1').data('status','closed');
			$('#projects2').data('status','open');
			$('#projects3').data('status','closed');
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
			if(text.access != "sysadmin" || text.access != "admin") { 
				var h = $("#projects div.ui-layout-west").height();
				var modLen = projects.GuestHiddenModules.length;
				var p_num_modules = projects_num_modules-modLen;
				p_modules_height = p_num_modules*module_title_height;
				$("#projects3 .projects3-content").height(h-(p_modules_height+152));
				$("#projects3 div.thirdLevel").height(h-(p_modules_height+150-27));
				$("#projects2").height(h-125-p_num_modules*27).removeClass("module-active");
				$("#projects2 .module-inner").height(h-125-p_num_modules*27);
				var a = 0;
				$("#projects3 div.thirdLevel").each(function(i) { 
					var rel = $(this).find('h3').attr('rel');
					if(projects.GuestHiddenModules.indexOf(rel) >= 0 ) {
						$(this).addClass('deactivated').animate({top: 9999})	
					} else {
						var t = $("#projects3").height()-p_num_modules*27+a*27;
						$(this).animate({top: t})			
						a = a+1;
					}
				})
				$('span.app_projects').trigger('click');
			} else {
				$("#projects3 div.thirdLevel:not(.deactivated)").each(function(i) { 
					var t = h-150-projects_num_modules*27+i*27;
					$(this).animate({top: t})
				})
				$('span.app_projects').trigger('click');
			}
			}
		});
	}
	
	if(what == 'phases') {
		$('#projects').data({ "first" : f});
		var index = $('#projects1 .module-click').index($('#projects1 .module-click[rel='+f+']'));
		$.ajax({ type: "GET", url: "/", dataType:  'json', async: false, data: "path=apps/projects&request=getProjectList&id="+f, success: function(data){
			$("#projects2 ul").html(data.html);
				setModuleDeactive($("#projects1"),index);
				$('#projects1').find('li:eq('+index+')').show();
				$("#projects-top .top-headline").html($("#projects1 .deactivated").find(".text").html());
			}
		})
		$('#projects').data({ "second" : p});
			
		var index = $("#projects2 .module-click").index($("#projects2 .module-click[rel='"+p+"']"));
		setModuleDeactive($("#projects2"),index);
		$("#projects2-outer").css('top', 96);
		$('#projects3 h3').removeClass("module-bg-active");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects/modules/"+what+"&request=getList&id="+p, success: function(data){
			$("#projects-current").val(what);
			$('#projects').data({ "current" : what});
			$('#projects').data({ "third" : ph});
			$('#projects1').data('status','closed');
			$('#projects2').data('status','closed');
			$('#projects3').data('status','open');
			$('#projects3 ul[rel='+what+']').html(data.html);
			$("#projectsActions .actionNew").attr("title",data.title);
			switch (data.perm) {
				case "sysadmin": case "admin" :
					if(data.html == "<li></li>") {
						projectsActions(3);
					} else {
						projectsActions(0);
					}
				break;
				case "guest":
					if(data.html == "<li></li>") {
						projectsActions();
					} else {
						projectsActions(5);
					}
				break;
			}
			$("#projects3 div.thirdLevel").each(function(i) { 
				if(i == 0) {
				var t = 0;
				} else {
					var n = $(this).height();
					var t = n+i*module_title_height-27;
				}
				$(this).animate({top: t})
			})		
			$('#projects3 ul[rel='+what+'] .module-click[rel='+ph+']').addClass('active-link');
			var idx = $('#projects3 ul[rel='+what+'] .module-click').index($('#projects3 ul[rel='+what+'] .module-click[rel='+ph+']'));
			projects_phases.getDetails(0,idx,data.html);
			$("#projects3 .module-actions:eq(0)").show();
			$("#projects3 .sort:eq(0)").attr("rel", data.sort).addClass("sort"+data.sort);
			$("#projects-top .top-subheadline").html(', ' + $("#projects2 .module-click:visible").find(".text").html());
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects&request=getDates&id="+p, success: function(data){
				$("#projects-top .top-subheadlineTwo").html(data.startdate + ' - <span id="projectenddate">' + data.enddate + '</span>');
				$('span.app_projects').trigger('click');
				}
			});
			}
		});
	}
}


var projectsLayout, projectsInnerLayout;

$(document).ready(function() {
						   
	if($('#projects').length > 0) {
		projectsLayout = $('#projects').layout({
				west__onresize:				function() { projectsresetModuleHeights() }
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
		
		projectsloadModuleStart();
	}


	$("#projects1-outer > h3").on('click', function(e, passed_id) {
		e.preventDefault();
		navThreeTitleFirst('projects',$(this),passed_id)
	});


	$("#projects2-outer > h3").on('click', function(e, passed_id) {
		e.preventDefault();
		navThreeTitleSecond('projects',$(this),passed_id)
	});


	$(document).on('click', '#projects1 .module-click',function(e) {
		e.preventDefault();
		navItemFirst('projects',$(this))
	});


	$(document).on('click', '#projects2 .module-click',function(e) {
		e.preventDefault();
		navItemSecond('projects',$(this))
	});


	$(document).on('click', '#projects3 .module-click',function(e) {
		e.preventDefault();
		navItemThird('projects',$(this))
	});


	$("#projects3 h3").on('click', function(e, passed_id) {
		e.preventDefault();
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
			if($('#projects3').data('status') == 'open') {
				var id = $("#projects").data('second');
				var mod = getCurrentModule();
				var todeactivate = mod.name.replace(/projects_/, "");
				$('#projects3 h3[rel='+todeactivate+']').removeClass("module-bg-active");
				$("#projects3 .module-actions:visible").hide();
				var curmoduleidx = $("#projects3 h3").index($('#projects3 h3[rel='+todeactivate+']'));
				var t = moduleidx*module_title_height;
				h3click.addClass("module-bg-active")
				$("#projects3 div.thirdLevel:not(.deactivated)").each(function(i) { 
					if(i <= moduleidx) {
						var mx = i*module_title_height;
						$(this).animate({top: mx})
					} else {
						if(i <= curmoduleidx) {
							var position = $(this).position();
							var h = position.top+$(this).height()-27;
							$(this).animate({top: h})
						} else {
							var position = $(this).position();
							var h = position.top;
							$(this).animate({top: h})
						}
					}
				})
				
				setTimeout(function() {
					$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects/modules/"+module+"&request=getList&id="+id, success: function(data){
						$("#projects3 ul:eq("+moduleidx+")").html(data.html);
						$("#projectsActions .actionNew").attr("title",data.title);
						switch (data.perm) {
							case "sysadmin": case "admin" :
								if(data.html == "<li></li>") {
									projectsActions(3);
								} else {
									projectsActions(0);
								}
							break;
							case "guest":
								if(data.html == "<li></li>") {
									projectsActions();
								} else {
									projectsActions(5);
								}
							break;
						}
						if(passed_id === undefined) {
							var idx = 0;
						} else {
							var idx = $("#projects3 ul:eq("+moduleidx+") .module-click").index($("#projects3 ul:eq("+moduleidx+") .module-click[rel='"+passed_id+"']"));
						}
						$("#projects3 ul:eq("+moduleidx+") .module-click:eq("+idx+")").addClass('active-link');
						var obj = getCurrentModule();
						obj.getDetails(moduleidx,idx,data.html);
						$(this).prev("h3").removeClass("module-bg-active");	
						$("#projects3 .module-actions:eq("+moduleidx+")").show();
						$("#projects3 .sort:eq("+moduleidx+")").attr("rel", data.sort).addClass("sort"+data.sort);
						}
					});		
				}, 400);
			} else {
				// load and slide up module 3
				var id = $("#projects").data('second');
				$('#projects2').data('status','closed');
				$('#projects3').data('status','open');
				if(id == undefined) {
					return false;
				}
				var index = $("#projects2 .module-click").index($("#projects2 .module-click[rel='"+id+"']"));			
				$("#projects3 .module-actions:visible").hide();
				h3click.addClass("module-bg-active");
				setModuleDeactive($("#projects2"),index);
				$("#projects3 div.thirdLevel").each(function(i) { 
					if(i <= moduleidx) {
						var position = $(this).position();
							var h = i*27;
							$(this).animate({top: h})
						}
					if(i == projects_num_modules-1) {
						setTimeout(function() {
							$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects/modules/"+module+"&request=getList&id="+id, success: function(data){
								$("#projects3 ul:eq("+moduleidx+")").html(data.html);
								$("#projectsActions .actionNew").attr("title",data.title);
								switch (data.perm) {
									case "sysadmin": case "admin" :
										if(data.html == "<li></li>") {
											projectsActions(3);
										} else {
											projectsActions(0);
										}
									break;
									case "guest":
										if(data.html == "<li></li>") {
											projectsActions();
										} else {
											projectsActions(5);
										}
									break;
								}
								if(passed_id === undefined) {
									var idx = 0;
								} else {
									var idx = $("#projects3 ul:eq("+moduleidx+") .module-click").index($("#projects3 ul:eq("+moduleidx+") .module-click[rel='"+passed_id+"']"));
								}
								$("#projects3 ul:eq("+moduleidx+") .module-click:eq("+idx+")").addClass('active-link');
								$("#projects-top .top-subheadline").html(', ' + $("#projects2 .deactivated").find(".text").html());
								$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects&request=getDates&id="+id, success: function(data){
									$("#projects-top .top-subheadlineTwo").html(data.startdate + ' - <span id="projectenddate">' + data.enddate + '</span>');
									}
								});
								var obj = getCurrentModule();
								obj.getDetails(moduleidx,idx,data.html);
								$("#projects3 .sort:eq("+moduleidx+")").attr("rel", data.sort).addClass("sort"+data.sort);
								$("#projects3 .module-actions:eq("+moduleidx+")").show();
								}
							});
						}, 400);
					}
				})
			}
			$("#projects-current").val(module);
			$('#projects').data({ "current" : module});
		}
	});

 
	$('a.insertProjectFolderfromDialog').livequery('click',function(e) {
		e.preventDefault();
		var field = $(this).attr("field");
		var gid = $(this).attr("gid");
		var title = $(this).attr("title");
		var obj = getCurrentModule();
		obj.insertFolderFromDialog(field,gid,title);
	});


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
	
	/*$('#projectsWidgetContent a').live('click', function(e) {
		e.preventDefault();
		ProjectsExternalLoad($(this).attr('rel'));					 
	})*/


});