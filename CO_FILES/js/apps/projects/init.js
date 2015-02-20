function initProjectsContentScrollbar() {
	projectsInnerLayout.initContent('center');
}

/* projects Object */
function projectsApplication(name) {
	this.name = name;
	this.isRefresh = false;
	
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
			$.prompt(ALERT_NO_TITLE, {submit: setTitleFocus});
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
	}

	
	this.formResponse = function(data) {
		switch(data.action) {
			case "edit":
				$("#projects2 span[rel='"+data.id+"'] .text").html($("#projects .title").val());
				$("#projectDurationStart").html($("input[name='startdate']").val());
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


	this.statusOnClose = function(dp) {
		var id = $("#projects").data("second");
		var status = $("#projects .statusTabs li span.active").attr('rel');
		var date = $("#projects .statusTabs input").val();
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects&request=updateStatus&id=" + id + "&date=" + date + "&status=" + status, cache: false, success: function(data){
				switch(data.status) {
					case "2":
						$("#projects2 span[rel='"+data.id+"'] .module-item-status").addClass("module-item-active").removeClass("module-item-active-stopped");
					break;
					case "3":
						$("#projects2 span[rel='"+data.id+"'] .module-item-status").addClass("module-item-active-stopped").removeClass("module-item-active");
					break;
					default:
						$("#projects2 span[rel='"+data.id+"'] .module-item-status").removeClass("module-item-active").removeClass("module-item-active-stopped");
				}																																				 			}
		});
	}
	
	this.toggleCosts = function(ele,status) {
		var id = $("#projects").data("second");
		switch(status) {
			case "0":
				var statusnew = 1;
				ele.addClass('active');
				$('#pcurrencyOuter').slideDown();
			break;
			case "1":
				var statusnew = 0;
				ele.removeClass('active');
				$('#pcurrencyOuter').slideUp();
			break;
		}
		setTimeout(function() {
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects&request=toggleCosts&id=" + id + "&statusnew=" + statusnew, cache: false, success: function(data){
				ele.attr('rel',statusnew);
				var obj = getCurrentModule();
				obj.actionRefresh();
				
				}
		});
		},400)
	}
	
	
	this.toggleCurrency = function(ele,cur) {
		var id = $("#projects").data("second");
		$('#projects .appSettingsPopup .toggleCurrency').each(function() {
			if($(this).attr('rel') == cur)	{
				$(this).addClass('active');
			} else {
				$(this).removeClass('active');
			}
		})
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects&request=toggleCurrency&id=" + id + "&cur=" + cur, cache: false, success: function(data){
				var obj = getCurrentModule();
				obj.actionRefresh();
				}
		});
	}


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
					module.getNavModulesNumItems(data.id);
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
							module.getNavModulesNumItems(id);
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
			submit: function(e,v,m,f){		
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
								if(typeof id == 'undefined') {
									$("#projects").data("second", 0);
								} else {
									$("#projects").data("second", id);
								}
								$("#projects2 .module-click:eq(0)").addClass('active-link');
								$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects&request=getProjectDetails&fid="+fid+"&id="+id, success: function(text){
									$("#projects-right").html(text.html);
									initProjectsContentScrollbar();
									module.getNavModulesNumItems(id);
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
		if(!iOS()) {
			$("#documentloader").attr('src', url);
		} else {
			window.open(url);
		}	
	}


	this.actionPrint = function() {
		var id = $("#projects").data("second");
		var url ='/?path=apps/projects&request=printProjectDetails&id='+id;
		if(!iOS()) {
			$("#documentloader").attr('src', url);
		} else {
			window.open(url);
		}
	}


	this.actionSend = function() {
		var id = $("#projects").data("second");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects&request=getProjectSend&id="+id, success: function(data){
			$("#modalDialogForward").html(data.html).dialog('open');
			if(data.error == 1) {
				$.prompt('<div style="text-align: center">' + ALERT_REMOVE_RECIPIENT + data.error_message + '<br /></div>');
				return false;
			}
			}
		});
	}


	this.actionSendtoResponse = function() {
		//$("#modalDialogForward").dialog('close');
		var id = $("#projects").data("second");
		$.ajax({ type: "GET", url: "/", data: "path=apps/projects&request=getSendtoDetails&id="+id, success: function(html){
			$("#project_sendto").html(html);
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
	
	
	this.actionArchive = function() {
		var module = this;
		var cid = $('#projects input[name="id"]').val()
		module.checkIn(cid);
		var txt = ALERT_ARCHIVE;
		var langbuttons = {};
		langbuttons[ALERT_YES] = true;
		langbuttons[ALERT_NO] = false;
		$.prompt(txt,{ 
			buttons:langbuttons,
			submit: function(e,v,m,f){		
				if(v){
					var id = $("#projects").data("second");
					var fid = $("#projects").data("first");
					$.ajax({ type: "GET", url: "/", data: "path=apps/projects&request=movetoArchive&id=" + id + "&fid=" + fid, cache: false, success: function(data){
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
								if(typeof id == 'undefined') {
									$("#projects").data("second", 0);
								} else {
									$("#projects").data("second", id);
								}
								$("#projects2 .module-click:eq(0)").addClass('active-link');
								$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects&request=getProjectDetails&fid="+fid+"&id="+id, success: function(text){
									$("#projects-right").html(text.html);
									initProjectsContentScrollbar();
									module.getNavModulesNumItems(id);
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
	
	this.actionHelp = function() {
		var url = "/?path=apps/projects&request=getProjectsHelp";
		if(!iOS()) {
			$("#documentloader").attr('src', url);
		} else {
			window.open(url);
		}
	}


	// Recycle Bin
	this.binDelete = function(id) {
		var txt = ALERT_DELETE_REALLY;
		var langbuttons = {};
		langbuttons[ALERT_YES] = true;
		langbuttons[ALERT_NO] = false;
		$.prompt(txt,{ 
			buttons:langbuttons,
			submit: function(e,v,m,f){		
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
			submit: function(e,v,m,f){		
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

	this.markNoticeDelete = function(id) {
		$.ajax({ type: "GET", url: "/", data: "path=apps/projects&request=markNoticeDelete&id=" + id, cache: false});
	}

	this.datepickerOnClose = function(dp) {
		// move entire project with kickoff
		if(dp.name == 'startdate' && $("#projectDurationEnd").html() != "" && dp.value != $("input[id='moveproject_start']").val()) {
			var txt = ALERT_PROJECT_MOVE_ALL;
			var langbuttons = {};
			langbuttons[ALERT_YES] = true;
			langbuttons[ALERT_NO] = false;
			$.prompt(txt,{ 
				buttons:langbuttons,
				submit: function(e,v,m,f){		
					if(v){
						var date1 = Date.parse($("#projects input[name='startdate']").val());
						var date2 = Date.parse($("#projects input[id='moveproject_start']").val());
						var span = new TimeSpan(date1 - date2);
						var days = span.getDays();
						var obj = getCurrentModule();
						$("#projects input[name='request']").val("moveProject").after('<input type="hidden" value="' + days + '" name="movedays"/>');
						$('#projects .coform').ajaxSubmit(obj.poformOptions);
					} else {
						var obj = getCurrentModule();
						$('#projects .coform').ajaxSubmit(obj.poformOptions);
					}	
				}
			});
		// startdate move
		} else if (dp.name.match(/task_startdate/)){
			var reg = /[0-9]+/.exec(dp.name);
			if($("#projects input[name='task_startdate["+reg+"]']").hasClass('ms')) {				
				var s = $("#projects input[name='task_startdate["+reg+"]']").val();
				var sm = $("#projects input[name='task_movedate_start["+reg+"]']").val();
				$("#projects input[name='task_movedate_start["+reg+"]']").val(dp.value)
				$("#projects input[name='task_enddate["+reg+"]']").val(dp.value)
				$("#projects input[name='task_movedate["+reg+"]']").val(dp.value)
				if(s != sm) {
					var obj = getCurrentModule();
					$('#projects .coform').ajaxSubmit(obj.poformOptions);
					$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/phases&request=getTaskDependencyExists&id="+reg, success: function(data){																																																																				
						if(data == "true" && $('.jqibox').length == 0) {
							var txt = ALERT_PHASE_TASKS_MOVE_START;
							var langbuttons = {};
							langbuttons[ALERT_YES] = true;
							langbuttons[ALERT_NO] = false;
							$.prompt(txt,{ 
								buttons:langbuttons,
								submit: function(e,v,m,f){
									if(v){
										var date1 = Date.parse(s);
										var date2 = Date.parse(sm);
										var span = new TimeSpan(date1 - date2);
										var days = span.getDays();
										$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/phases&request=moveDependendTasks&id="+reg+"&days="+days, success: function(data){
											
											$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/phases&request=checkDependency&id="+reg+"&date="+dp.value, success: function(data){
												var obj = getCurrentModule();
												obj.actionRefresh();	
												}
											});
											}
										});
									} else {
										// check for depts that fall before start and delete dep
										$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/phases&request=checkDependency&id="+reg+"&date="+dp.value, success: function(data){
											var obj = getCurrentModule();
											obj.actionRefresh();						
											}
										});
									}
								}
							});
						} else {
							$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/phases&request=checkDependency&id="+reg+"&date="+dp.value, success: function(data){
								var obj = getCurrentModule();
								obj.actionRefresh();	
								}
							});
						}
						}
					});
				}
			} else {
				var s = $("#projects input[name='task_startdate["+reg+"]']").val();
				var sm = $("#projects input[name='task_movedate_start["+reg+"]']").val();
				var en = $("#projects input[name='task_enddate["+reg+"]']").val();
				var em = $("#projects input[name='task_movedate["+reg+"]']").val();
				if(s != sm) {
					var obj = getCurrentModule();
					$('#projects .coform').ajaxSubmit(obj.poformOptions);
					var txt = ALERT_PHASE_TASKS_MOVE_START;
					var langbuttons = {};
					langbuttons[ALERT_YES] = true;
					langbuttons[ALERT_NO] = false;
					$.prompt(txt,{ 
						buttons:langbuttons,
						submit: function(e,v,m,f){		
							if(v){
								var date1 = Date.parse(s);
								var date2 = Date.parse(sm);
								var span = new TimeSpan(date1 - date2);
								var days = span.getDays();
								$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/phases&request=moveTaskEnd&id="+reg+"&days="+days, success: function(data){ 																																									
									$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/phases&request=checkDependency&id="+reg+"&date="+dp.value, success: function(data){
										var obj = getCurrentModule();
										obj.actionRefresh();	
										}
									});
									}
								});
							} else {
								$("#projects input[name='task_movedate_start["+reg+"]']").val(s);
								var obj = getCurrentModule();
								if(Date.parse(en) < Date.parse(dp.value)) {
									$("#projects input[name='task_enddate["+reg+"]']").val(dp.value)
									$("#projects input[name='task_movedate["+reg+"]']").val(dp.value)
									$('#projects .coform').ajaxSubmit(obj.poformOptions);
								}
								// check for depts that fall before start and delete dep
								$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/phases&request=checkDependency&id="+reg+"&date="+dp.value, success: function(data){
									obj.actionRefresh();							
									}
								});
							}
						}
					});
				}
			}
		// tasks dependencies
		} else if (dp.name.match(/task_enddate/)){
			var obj = getCurrentModule();
			$('#projects .coform').ajaxSubmit(obj.poformOptions);
			var reg = /[0-9]+/.exec(dp.name);
			var s = $("#projects input[name='task_enddate["+reg+"]']").val();
			var en = $("#projects input[name='task_movedate["+reg+"]']").val();
			if(s != en) {
				$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/phases&request=getTaskDependencyExists&id="+reg, success: function(data){																																																																				
					if(data == "true" && $('.jqibox').length == 0) {
						var txt = ALERT_PHASE_TASKS_MOVE_ALL;
						var langbuttons = {};
						langbuttons[ALERT_YES] = true;
						langbuttons[ALERT_NO] = false;
						$.prompt(txt,{ 
							buttons:langbuttons,
							submit: function(e,v,m,f){		
								if(v){
									var date1 = Date.parse(s);
									var date2 = Date.parse(en);
									var span = new TimeSpan(date1 - date2);
									var days = span.getDays();
									if(days != 0) {
										$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/phases&request=moveDependendTasks&id="+reg+"&days="+days, success: function(data){
										obj.actionRefresh();
											}
										});
									}
								} else {
									$("#projects input[name='task_movedate["+reg+"]']").val(s);
								}
							}
						});
					 }
					}
				});
			}
		}
		else {
			var obj = getCurrentModule();
			$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		}
	}


	this.manageCheckpoint = function(action,date) {
		var pid = $('#projects').data('second');
		switch(action) {
			case 'new':
				$.ajax({ type: "GET", url: "/", data: "path=apps/projects&request=newCheckpoint&id=" + pid + "&date=" + date, cache: false });
			break;
			case 'update':
				$.ajax({ type: "GET", url: "/", data: "path=apps/projects&request=updateCheckpoint&id=" + pid + "&date=" + date, cache: false });			
			break;
			case 'delete':
				$.ajax({ type: "GET", url: "/", data: "path=apps/projects&request=deleteCheckpoint&id=" + pid, cache: false });
			break;
		}
	}

}

var projects = new projectsApplication('projects');
projects.modules_height = projects_num_modules*module_title_height;
projects.GuestHiddenModules = new Array("controlling","access");


// register folder object
function projectsFolders(name) {
	this.name = name;


	this.formProcess = function(formData, form, poformOptions) {
		var title = $("#projects input.title").fieldValue();
		if(title == "") {
			$.prompt(ALERT_NO_TITLE, {submit: setTitleFocus});
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
			submit: function(e,v,m,f){		
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
								if(typeof id == 'undefined') {
									$("#projects").data("first",0);
								} else {
									$("#projects").data("first",id);
								}
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


	this.actionLoadTab = function(what) {
		var id = $("#projects").data("first");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: 'path=apps/projects&request=get'+what+'&id='+id, success: function(data){
			$('#projectsFoldersTabsContent').empty().html(data.html);
			initProjectsContentScrollbar()
			}
		});
	}


	this.actionLoadSubTab = function(view) {
		var id = $("#projects").data("first");
		var what = $('#projectsFoldersTabs ul.contentTabsList span[class=active]').attr('rel');
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: 'path=apps/projects&request=get'+what+'&view='+view+'&id='+id, success: function(data){
			$('#projectsFoldersTabsContent').empty().html(data.html);
			initProjectsContentScrollbar()
			}
		});
	}


	this.loadBarchartZoom = function(zoom) {
		var id = $("#projects").data("first");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: 'path=apps/projects&request=getFolderDetailsMultiView&id='+id+'&zoom='+zoom, success: function(data){
			$('#projectsFoldersTabsContent').html(data.html);
			initProjectsContentScrollbar()
			}
		});
	}


	this.actionRefresh = function() {
		projects.isRefresh = true;
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
		var what = $('#projectsFoldersTabs ul.contentTabsList span[class=active]').attr('rel');
		if(what == 'FolderDetailsMultiView') {
			var view= $('#projectsFoldersSubTabs ul span[class~=active]').attr('rel');
			what = what + '&view=' + view;
		}
		var url ='/?path=apps/projects&request=print'+what+'&id='+id;
		if(!iOS()) {
			$("#documentloader").attr('src', url);
		} else {
			window.open(url);
		}
	}


	this.actionSend = function() {
		var id = $("#projects").data("first");
		var what = $('#projectsFoldersTabs ul.contentTabsList span[class=active]').attr('rel');
		if(what == 'FolderDetailsMultiView') {
			var view= $('#projectsFoldersSubTabs ul span[class~=active]').attr('rel');
			what = what + '&view=' + view;
		}
		$.ajax({ type: "GET", url: "/", data: 'path=apps/projects&request=getSend'+what+'&id='+id, success: function(html){
			$("#modalDialogForward").html(html).dialog('open');
			}
		});
	}


	this.actionSendtoResponse = function() {
		//$("#modalDialogForward").dialog('close');
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


	this.actionArchive = function() {
		var module = this;
		/*var cid = $('#projects input[name="id"]').val()*/
		//var id = $("#projects").data("first");
		//module.checkIn(cid);
		var txt = ALERT_ARCHIVE;
		var langbuttons = {};
		langbuttons[ALERT_YES] = true;
		langbuttons[ALERT_NO] = false;
		$.prompt(txt,{ 
			buttons:langbuttons,
			submit: function(e,v,m,f){		
				if(v){
					//var id = $("#projects").data("second");
					var fid = $("#projects").data("first");
					//alert(fid);
					$.ajax({ type: "GET", url: "/", data: "path=apps/projects&request=moveFolderToArchive&&fid=" + fid, cache: false, success: function(data){
						if(data == "true") {
									//$("#projects-right").html(text.html);
									//initProjectsContentScrollbar();
									//module.getNavModulesNumItems(id);
									module.actionRefresh();
									}
									}
								});
					
					
					/*$.ajax({ type: "GET", url: "/", data: "path=apps/projects&request=moveFoldertoArchive&&fid=" + fid, cache: false, success: function(data){
						if(data == "true") {
							$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects&request=getFolderDetails&id="+fid, success: function(list){
								$("#projects2 ul").html(list.html);
								if(list.html == "<li></li>") {
									projectsActions(3);
								} else {
									projectsActions(0);
									setModuleActive($("#projects2"),0);
								}
								var id = $("#projects2 .module-click:eq(0)").attr("rel");
								if(typeof id == 'undefined') {
									$("#projects").data("second", 0);
								} else {
									$("#projects").data("second", id);
								}
								$("#projects2 .module-click:eq(0)").addClass('active-link');
								$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects&request=getProjectDetails&fid="+fid+"&id="+id, success: function(text){
									$("#projects-right").html(text.html);
									initProjectsContentScrollbar();
									module.getNavModulesNumItems(id);
									}
								});
							}
							});
						}
					}
					});*/
				} 
			}
		});
	}




	this.actionHelp = function() {
		var url = "/?path=apps/projects&request=getProjectsFoldersHelp";
		if(!iOS()) {
			$("#documentloader").attr('src', url);
		} else {
			window.open(url);
		}
	}


	// Recycle Bin
	this.binDelete = function(id) {
		var txt = ALERT_DELETE_REALLY;
		var langbuttons = {};
		langbuttons[ALERT_YES] = true;
		langbuttons[ALERT_NO] = false;
		$.prompt(txt,{ 
			buttons:langbuttons,
			submit: function(e,v,m,f){		
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
			submit: function(e,v,m,f){		
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
	var obj = getCurrentModule();
	switch(status) {
		case 0: 
			if(obj.name == 'projects') {
				actions = ['0','1','2','3','5','6','7','8','9'];
			} else {
				actions = ['0','1','2','3','5','6','8','9'];
			}
		 break;
		case 1: actions = ['0','6','8','9']; break;
		case 3: 	actions = ['0','6','8']; break;   					// just new
		case 4: 	actions = ['0','1','2','5','6','8']; break;   		// new, print, send, handbook, refresh
		case 5: 	actions = ['1','2','6','8']; break;   			// print, send, refresh
		case 6: 	actions = ['5','6','8']; break;   			// handbook refresh
		case 7: 	actions = ['0','1','2','6','8']; break;   			// new, print, send, refresh
		case 8: 	actions = ['1','2','5','6','8']; break;   			// print, send, handbook, refresh
		case 9:		actions = ['0','1','2','6','7','8','9']; break;
		// vdocs
		// 0 == 10
		case 10: actions = ['0','1','2','3','4','5','6','8','9']; break;
		// 5 == 11
		case 11: 	actions = ['1','2','4','6','8']; break;   			// print, send, refresh
		default: 	actions = ['6','8'];  								// none
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
	}).disableSelection();


	$("#projects2-outer").on('click', 'h3', function(e, passed_id) {
		e.preventDefault();
		navThreeTitleSecond('projects',$(this),passed_id)
		prevent_dblclick(e)
	}).disableSelection();


	$("#projects3").on('click', 'h3', function(e, passed_id) {
		e.preventDefault();
		navThreeTitleThird('projects',$(this),passed_id)
		prevent_dblclick(e)
	}).disableSelection();

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
	
	// load psp
	$(document).on('click', '.loadPSP', function(e) {
		e.stopPropagation();
		var obj = getCurrentModule();
		if(confirmNavigation()) {
			formChanged = false;
			$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		}
		var fid = $("#projects").data("first");
		var id = $(this).attr("rel");
		externalLoadThreeLevels('timelines',fid,id,3,'projects');
	});


	// barchart opacity with jquery
	$(".barchart-phase-bg").livequery( function() {
		$(this).css("opacity","0.3");
	});

	$("#todayBar").livequery( function() {
		$(this).css("opacity","0.4");
	});
  
	
	// timeline gant chart and multiview
	$("#barchartScroll").livequery( function() {
		var scroller = $(this);
		scroller.scroll(function() {
			var $scrollingDiv = $("#barchart-container-left");
			$scrollingDiv.stop().animate({"marginLeft": (scroller.scrollLeft()) + "px"}, "fast" );
			$("#barchartTimeline").stop().animate({"marginTop": (scroller.scrollTop()) + "px"}, "fast" );
			if(scroller.scrollTop() != 0) {
				$("#todayBar").stop().height(scroller.innerHeight()-67);
			}
		});
	});


	$(document).on('click', '.but-scroll-to',function(e) {
		e.preventDefault();
		var t = $(this).attr('t');
		var l = $(this).attr('l');
		$('.scroll-pane').scrollTo(l,t);
	});

	
	// autocomplete projects search
	$('.projects-search').livequery(function() {
		var id = $("#projects").data("second");
		$(this).autocomplete({
			appendTo: '#tabs-1',
			source: "?path=apps/projects&request=getProjectsSearch&exclude="+id,
			//minLength: 2,
			select: function(event, ui) {
				var obj = getCurrentModule();
				obj.addParentLink(ui.item.id);
			},
			close: function(event, ui) {
				$(this).val("");
			}
		});
	});
	
	$(document).on('click', '.addProjectLink', function(e) {
		e.preventDefault();
		var id = $(this).attr("rel");
		var obj = getCurrentModule();
		obj.addParentLink(id);
	});
	
});