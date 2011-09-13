/* phases Object */
function projectsPhases(name) {
	this.name = name;
	
	
	this.formProcess = function(formData, form, poformOptions) {
		var title = $("#projects input.title").fieldValue();
		if(title == "") {
			$.prompt(ALERT_NO_TITLE, {callback: setTitleFocus});
			return false;
		} else {
			formData[formData.length] = { "name": "title", "value": title };
		}
	
		$('#projects div.task_team_list').each(function() {
			var id = $(this).attr("id");
			var reg = /[0-9]+/.exec(id);
			formData[formData.length] = processListArray(reg);
		});
	
		$('#projects div.task_team_list_ct').each(function() {
			var id = $(this).attr("id");
			var reg = /[0-9]+/.exec(id);
			formData[formData.length] = processCustomTextArray(reg);
		});
	
		formData[formData.length] = processListApps('team');
		formData[formData.length] = processCustomTextApps('team_ct');
		formData[formData.length] = processDocListApps('documents');
		formData[formData.length] = processListApps('phase_access');
		formData[formData.length] = processListApps('phase_status');	 
	}
	
	
	this.formResponse = function(data) {
		switch(data.action) {
			case "edit":
				$("#projects3 span[rel='"+data.id+"'] .text").html($("#projects .title").val());
				$("#projectsphasestartdate").html(data.startdate);
				$("#projectsphaseenddate").html(data.enddate);
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
	
	
	this.poformOptions = { beforeSubmit: this.formProcess, dataType: 'json', success: this.formResponse };
	
	
	this.getDetails = function(moduleidx,liindex,list) {
		var phaseid = $("#projects3 ul:eq("+moduleidx+") .module-click:eq("+liindex+")").attr("rel");
		var num = $("#projects3 ul:eq("+moduleidx+") .phase_num:eq("+liindex+")").html();
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects/modules/phases&request=getDetails&id="+phaseid+"&num="+num, success: function(data){
			$("#projects-right").html(data.html);
			if($('#checkedOut').length > 0) {
					$("#projects3 .active-link:visible .icon-checked-out").addClass('icon-checked-out-active');
				} else {
					$("#projects3 .active-link:visible .icon-checked-out").removeClass('icon-checked-out-active');
				}
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
			initProjectsContentScrollbar();
			}
		});
	}

	
	this.actionNew = function() {
		var module = this;
		var cid = $('#projects input[name="id"]').val()
		module.checkIn(cid);
		var id = $('#projects2 .module-click:visible').attr("rel");
		var num  = parseInt($(".projects3-content:visible .module-click").size()+1);
		$.ajax({ type: "GET", url: "/", dataType: 'json', data: 'path=apps/projects/modules/phases&request=createNew&id=' + id + '&num=' + num, cache: false, success: function(data){
			var pid = $("#projects2 .module-click:visible").attr("rel");
				$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/projects/modules/phases&request=getList&id="+pid, success: function(ldata){
					$(".projects3-content:visible ul").html(ldata.html);
					var liindex = $(".projects3-content:visible .module-click").index($(".projects3-content:visible .module-click[rel='"+data.id+"']"));
					$(".projects3-content:visible .module-click:eq("+liindex+")").addClass('active-link');
					var moduleidx = $(".projects3-content").index($(".projects3-content:visible"));
					module.getDetails(moduleidx,liindex);
					$('#projects3 input.filter').quicksearch('#projects3 li');
					setTimeout(function() { $('#projects-right .focusTitle').trigger('click'); }, 800);
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


	this.actionDuplicate = function() {
		var module = this;
		var cid = $('#projects input[name="id"]').val()
		module.checkIn(cid);
		var id = $("#projects3 .active-link:visible").attr("rel");
		var pid = $("#projects2 .module-click:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", data: 'path=apps/projects/modules/phases&request=createDuplicate&id=' + id, cache: false, success: function(phaseid){
			$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/projects/modules/phases&request=getList&id="+pid, success: function(data){																																																																				
				$(".projects3-content:visible ul").html(data.html);
				var moduleidx = $(".projects3-content").index($(".projects3-content:visible"));
				var liindex = $(".projects3-content:visible .module-click").index($(".projects3-content:visible .module-click[rel='"+phaseid+"']"));
				module.getDetails(moduleidx,liindex);
				$(".projects3-content:visible .module-click:eq("+liindex+")").addClass('active-link');
				projectsActions(0);
				$('#projects3 input.filter').quicksearch('#projects3 li');
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
								module.getDetails(moduleidx,liindex);
								$("#projects3 .projects3-content:visible .module-click:eq("+liindex+")").addClass('active-link');
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
	
	
	this.checkIn = function(id) {
		$.ajax({ type: "GET", url: "/", async: false, data: 'path=apps/projects/modules/phases&request=checkinPhase&id='+id, success: function(data){
			if(!data) {
				prompt("something wrong");
			}
			}
		});
	}


	this.actionRefresh = function() {
		var id = $("#projects3 .active-link:visible").attr("rel");
		var pid = $("#projects2 .module-click:visible").attr("rel");
		$("#projects3 .active-link:visible").trigger("click");
		var id = $("#projects3 .active-link:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/projects/modules/phases&request=getList&id="+pid, success: function(data){																																																																				
			$(".projects3-content:visible ul").html(data.html);
			var liindex = $(".projects3-content:visible .module-click").index($(".projects3-content:visible .module-click[rel='"+id+"']"));
			$(".projects3-content:visible .module-click:eq("+liindex+")").addClass('active-link');
			$('#projects3 input.filter').quicksearch('#projects3 li');
			}
		});
	}


	this.actionPrint = function() {
		var id = $("#projects3 .active-link:visible").attr("rel");
		var num = $("#projects3 .active-link:visible").find(".phase_num").html();
		var url ='/?path=apps/projects/modules/phases&request=printDetails&id='+id+"&num="+num;
		location.href = url;
	}


	this.actionSend = function() {
		var id = $("#projects3 .active-link:visible").attr("rel");
		var num = $("#projects3 .active-link:visible").find(".phase_num").html();
		$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/phases&request=getSend&id="+id+"&num="+num, success: function(html){
			$("#modalDialogForward").html(html).dialog('open');
			}
		});
	}


	this.actionSendtoResponse = function() {
		var id = $("#projects3 .active-link:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/phases&request=getSendtoDetails&id="+id, success: function(html){
			$("#projects_phase_sendto").html(html);
			$("#modalDialogForward").dialog('close');
			}
		});
	}


	this.sortclick = function (obj,sortcur,sortnew) {
		var module = this;
		var cid = $('#projects input[name="id"]').val()
		module.checkIn(cid);
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
			module.getDetails(moduleidx,liindex);
			$("#projects3 .projects3-content:visible .module-click:eq("+liindex+")").addClass('active-link');
			}
		});
	}


	this.sortdrag = function (order) {
		var fid = $("#projects2 .module-click:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/phases&request=setOrder&"+order+"&id="+fid, success: function(html){
			$("#projects3 .sort:visible").attr("rel", "3");
			$("#projects3 .sort:visible").removeClass("sort1").removeClass("sort2").addClass("sort3");
			}
		});	
	}


	this.actionDialog = function(offset,request,field,append,title,sql) {
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



	this.insertStatusDate = function(rel,text) {
		var module = this;
		var html = '<div class="listmember" field="projectsphase_status" uid="'+rel+'" style="float: left">' + text + '</div>';
		$("#projectsphase_status").html(html);
		$("#modalDialog").dialog("close");
		$("#projectsphase_status").nextAll('img').trigger('click');
	}
	
	
	this.newItemSelection = function(rel) {
		var enddate = $("#projectsphaseenddate").html();
		var pid = $("#projects2 .module-click:visible").attr("rel");
		var phid = $(".projects3-content:visible .active-link").attr("rel");
		var cat = rel;
		$("#modalDialog").dialog("close");
		$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/phases&request=addTask&pid=" + pid + "&phid=" + phid + "&date=" + enddate + "&enddate=" + enddate + "&cat=" + cat, success: function(html){
			$('#projectsphasetasks').append(html);
			var idx = parseInt($('#projects-right .cbx').size() -1);
			var element = $('#projects-right .cbx:eq('+idx+')');
			$.jNice.CheckAddPO(element);
			$('#projects-right div.phaseouter:eq('+idx+')').slideDown(function() {
				$(this).find(":text:eq(0)").focus();
				if(idx == 6) {
				$('#projects-right .addTaskTable').clone().insertAfter('#projectsphasetasks');
				}
				initProjectsContentScrollbar();								   
			});
			}
		});
	}
	
	
	this.insertItem = function(field,append,id,text) {
		$("#"+field).val(id);
		$("#"+field+"-text").html(text);
		$("#modalDialog").dialog('close');
		var obj = getCurrentModule();
		$('#projects .coform').ajaxSubmit(obj.poformOptions);
	}



	this.binItem = function(id) {
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
								$("#projectsphasestartdate").html(pst);
								$("#projectsphaseenddate").html(pen);
							});
						} 
						}
					});
				} 
			}
		});	
	}


	// dependencies
	this.actionCheckDepTasks = function() {
		return true;
	}
	
	
	this.actionHelp = function() {
		var url = "/?path=apps/projects/modules/phases&request=getHelp";
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/phases&request=deletePhase&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#phase_'+id).slideUp();
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/phases&request=restorePhase&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#phase_'+id).slideUp();
						}
					}
					});
				} 
			}
		});
	}


	this.binDeleteItem = function(id) {
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
	}


	this.binRestoreItem = function(id) {
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
	}


}

var projects_phases = new projectsPhases('projects_phases');