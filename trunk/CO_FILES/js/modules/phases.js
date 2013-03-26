/* phases Object */
function Phases(app) {
	this.name = app +'_phases';
	this.app = app;
	this.object = window[app];
	this.objectFirst = this.app.substr(0, 1);
	this.objectnameCaps = this.objectFirst.toUpperCase() + this.app.substr(1);

	this.formProcess = function(formData, form, poformOptions) {
		var app = getCurrentApp();
		var title = $('#'+ app +' input.title').fieldValue();
		if(title == "") {
			$.prompt(ALERT_NO_TITLE, {submit: setTitleFocus});
			return false;
		} else {
			formData[formData.length] = { "name": "title", "value": title };
		}
		$('#'+ app +' div.task_team_list').each(function() {
			var id = $(this).attr("id");
			var reg = /[0-9]+/.exec(id);
			formData[formData.length] = processListArray('task_team',reg);
		});
		$('#'+ app +' div.task_team_list_ct').each(function() {
			var id = $(this).attr("id");
			var reg = /[0-9]+/.exec(id);
			formData[formData.length] = processCustomTextArray(reg);
		});
		formData[formData.length] = processListApps('team');
		formData[formData.length] = processCustomTextApps('team_ct');
		formData[formData.length] = processDocListApps('documents');
		formData[formData.length] = processListApps('phase_access');
	}
	
	
	this.formResponse = function(data) {
		var app = getCurrentApp();
		switch(data.action) {
			case "edit":
				$("#"+ app +"3 ul[rel=phases] span[rel="+data.id+"] .text").html($("#"+ app +" .title").val());
				$("#"+ app +"phasestartdate").html(data.startdate);
				$("#"+ app +"phaseenddate").html(data.enddate);
				var pid = $('#'+ app).data("second");
				$.ajax({ type: "GET", url: "/", dataType:  'json', data: 'path=apps/'+ app +'&request=getDates&id='+pid, success: function(val){
						$('#'+ app +'enddate').html(val.enddate);
					}
				});
				switch(data.access) {
					case "0":
						$("#"+ app +"3 ul[rel=phases] span[rel="+data.id+"] .module-access-status").removeClass("module-access-active");
					break;
					case "1":
						$("#"+ app +"3 ul[rel=phases] span[rel="+data.id+"] .module-access-status").addClass("module-access-active");
					break;
				}
			break;
		}	
	}
	
	
	this.poformOptions = { beforeSubmit: this.formProcess, dataType: 'json', success: this.formResponse };
	

	this.statusOnClose = function(dp) {
		var app = getCurrentApp();
		var id = $('#'+ app).data("third");
		var status = $('#'+ app +' .statusTabs li span.active').attr('rel');
		var date = $('#'+ app +' .statusTabs input').val();
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: 'path=apps/'+ app +'/modules/phases&request=updateStatus&id=' + id + '&date=' + date + '&status=' + status, cache: false, success: function(data){
				switch(data.status) {
					case "2":
						$("#"+ app +"3 ul[rel=phases] span[rel="+data.id+"] .module-item-status").addClass("module-item-active");
					break;
					default:
						$("#"+ app +"3 ul[rel=phases] span[rel="+data.id+"] .module-item-status").removeClass("module-item-active");
				}																																 			}
		});
	}


	this.getDetails = function(moduleidx,liindex,list) {
		var module = this;
		var phaseid = $("#"+ module.app +"3 ul:eq("+moduleidx+") .module-click:eq("+liindex+")").attr("rel");
		$('#'+ module.app).data({ "third" : phaseid});
		var num = $("#"+ module.app +"3 ul:eq("+moduleidx+") .phase_num:eq("+liindex+")").html();
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/"+ module.app +"/modules/phases&request=getDetails&id="+phaseid+"&num="+num, success: function(data){
			$("#"+ module.app +"-right").html(data.html);
			if($('#checkedOut').length > 0) {
				$("#"+ module.app +"3 ul[rel=phases] .active-link .icon-checked-out").addClass('icon-checked-out-active');
			} else {
				$("#"+ module.app +"3 ul[rel=phases] .active-link .icon-checked-out").removeClass('icon-checked-out-active');
			}
			if(list == 0) {
				switch (data.access) {
					case "sysadmin": case "admin":
						window[module.app +'Actions'](0);
					break;
					case "guest":
						window[module.app +'Actions'](5);
					break;
				}
			} else {
				switch (data.access) {
					case "sysadmin": case "admin" :
						if(list == "<li></li>") {
							window[module.app +'Actions'](3);
						} else {
							window[module.app +'Actions'](0);
						}
					break;
					case "guest":
						if(list == "<li></li>") {
							window[module.app +'Actions']();
						} else {
							window[module.app +'Actions'](5);
						}
					break;
				}
			}
			window['init'+ module.objectnameCaps +'ContentScrollbar']();
			}
		});
	}


	this.actionNew = function() {
		var module = this;
		var cid = $('#'+ module.app +' input[name="id"]').val()
		module.checkIn(cid);
		var id = $('#'+ module.app).data('second');
		var num  = parseInt($('#'+ module.app +'3 ul[rel=phases] li').size()+1);
		$.ajax({ type: "GET", url: "/", dataType: 'json', data: 'path=apps/'+ module.app +'/modules/phases&request=createNew&id=' + id + '&num=' + num, cache: false, success: function(data){
				$.ajax({ type: "GET", url: "/", dataType: 'json', data: 'path=apps/'+ module.app +'/modules/phases&request=getList&id='+id, success: function(ldata){
					$('#'+ module.app +'3 ul[rel=phases]').html(ldata.html);
					var liindex = $('#'+ module.app +'3 ul[rel=phases] .module-click').index($("#"+ module.app +"3 ul[rel=phases] .module-click[rel='"+data.id+"']"));
					$("#"+ module.app +"3 ul[rel=phases] .module-click:eq("+liindex+")").addClass('active-link');
					var moduleidx = $('#'+ module.app +'3 ul').index($('#'+ module.app +'3 ul[rel=phases]'));
					module.getDetails(moduleidx,liindex);
					setTimeout(function() { $('#'+ module.app +'-right .focusTitle').trigger('click'); }, 800);
					$.ajax({ type: "GET", url: "/", dataType:  'json', data: 'path=apps/'+ module.app +'&request=getDates&id='+id, success: function(val){
							$('#'+ module.app +'enddate').html(val.enddate);
						}
					});
					}
				});
			}
		});
	}


	this.actionDuplicate = function() {
		var module = this;
		var cid = $('#'+ module.app +' input[name="id"]').val()
		module.checkIn(cid);
		var id = $('#'+ module.app).data("third");
		var pid = $('#'+ module.app).data("second");
		$.ajax({ type: "GET", url: "/", data: 'path=apps/'+ module.app +'/modules/phases&request=createDuplicate&id=' + id, cache: false, success: function(phaseid){
			$.ajax({ type: "GET", url: "/", dataType: 'json', data: 'path=apps/'+ module.app +'/modules/phases&request=getList&id='+pid, success: function(data){																																																																				
				$('#'+ module.app +'3 ul[rel=phases]').html(data.html);
				var moduleidx = $('#'+ module.app +'3 ul').index($('#'+ module.app +'3 ul[rel=phases]'));
				var liindex = $('#'+ module.app +'3 ul[rel=phases] .module-click').index($("#"+ module.app +"3 ul[rel=phases] .module-click[rel='"+phaseid+"']"));
				module.getDetails(moduleidx,liindex);
				$("#"+ module.app +"3 ul[rel=phases] .module-click:eq("+liindex+")").addClass('active-link');
				window[module.app +'Actions'](0);
				}
			});
			}
		});
	}


	this.actionBin = function() {
		var module = this;
		var cid = $('#'+ module.app +' input[name="id"]').val()
		module.checkIn(cid);
		var txt = ALERT_DELETE;
		var langbuttons = {};
		langbuttons[ALERT_YES] = true;
		langbuttons[ALERT_NO] = false;
		$.prompt(txt,{ 
			buttons:langbuttons,
			submit: function(e,v,m,f){		
				if(v){
					var id = $('#'+ module.app).data("third");
					var pid = $('#'+ module.app).data("second");
					$.ajax({ type: "GET", url: "/", data: 'path=apps/'+ module.app +'/modules/phases&request=binPhase&id=' + id, cache: false, success: function(data){
						if(data == "true") {
							$.ajax({ type: "GET", url: "/", dataType: 'json', data: 'path=apps/'+ module.app +'/modules/phases&request=getList&id='+pid, success: function(data){
								$('#'+ module.app +'3 ul[rel=phases]').html(data.html);
								if(data.html == "<li></li>") {
									window[module.app +'Actions'](3);
								} else {
									window[module.app +'Actions'](0);
								}
								var moduleidx = $('#'+ module.app +'3 ul').index($('#'+ module.app +'3 ul[rel=phases]'));
								var liindex = 0;
								module.getDetails(moduleidx,liindex);
								$("#"+ module.app +"3 ul[rel=phases] .module-click:eq("+liindex+")").addClass('active-link');
								$.ajax({ type: "GET", url: "/", dataType:  'json', data: 'path=apps/'+ module.app +'&request=getDates&id='+pid, success: function(val){
										$('#'+ module.app +'enddate').html(val.enddate);
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
		var module = this;
		$.ajax({ type: "GET", url: "/", async: false, data: 'path=apps/'+ module.app +'/modules/phases&request=checkinPhase&id='+id, success: function(data){
			if(!data) {
				prompt("something wrong");
			}
			}
		});
	}


	this.actionRefresh = function() {
		var module = this;
		var id = $('#'+ module.app).data("third");
		var pid = $('#'+ module.app).data("second");
		$('#'+ module.app +'3 ul[rel=phases] .active-link').trigger("click");
		$.ajax({ type: "GET", url: "/", dataType: 'json', data: 'path=apps/'+ module.app +'/modules/phases&request=getList&id='+pid, success: function(data){																																																																				
			$('#'+ module.app +'3 ul[rel=phases]').html(data.html);
			var liindex = $('#'+ module.app +'3 ul[rel=phases] .module-click').index($("#"+ module.app +"3 ul[rel=phases] .module-click[rel='"+id+"']"));
			$("#"+ module.app +"3 ul[rel=phases] .module-click:eq("+liindex+")").addClass('active-link');
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: 'path=apps/'+ module.app +'&request=getDates&id='+pid, success: function(val){
						$('#'+ module.app +'enddate').html(val.enddate);
					}
				});
			}
		});
	}


	this.actionPrint = function() {
		var module = this;
		var id = $('#'+ module.app).data("third");
		var num = $('#'+ module.app +'3 ul[rel=phases] .active-link').find(".phase_num").html();
		var url ='/?path=apps/'+ module.app +'/modules/phases&request=printDetails&id='+id+"&num="+num;
		$("#documentloader").attr('src', url);
	}


	this.actionSend = function() {
		var module = this;
		var id = $('#'+ module.app).data("third");
		var num = $('#'+ module.app +'3 ul[rel=phases] .active-link').find(".phase_num").html();
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: 'path=apps/'+ module.app +'/modules/phases&request=getSend&id='+id+'&num='+num, success: function(data){
			$("#modalDialogForward").html(data.html).dialog('open');
			if(data.error == 1) {
				$.prompt('<div style="text-align: center">' + ALERT_REMOVE_RECIPIENT + data.error_message + '<br /></div>');
				return false;
			}
			}
		});
	}


	this.actionSendtoResponse = function() {
		var module = this;
		var id = $('#'+ module.app).data("third");
		$.ajax({ type: "GET", url: "/", data: 'path=apps/'+ module.app +'/modules/phases&request=getSendtoDetails&id='+id, success: function(html){
			$('#'+ module.app +'_phase_sendto').html(html);
			}
		});
	}


	this.sortclick = function (obj,sortcur,sortnew) {
		var module = this;
		var cid = $('#'+ module.app +' input[name="id"]').val()
		module.checkIn(cid);
		var fid = $('#'+ module.app).data("second");
		$.ajax({ type: "GET", url: "/", dataType: 'json', data: 'path=apps/'+ module.app +'/modules/phases&request=getList&id='+fid+'&sort='+sortnew, success: function(data){
			$('#'+ module.app +'3 ul[rel=phases]').html(data.html);
			obj.attr("rel",sortnew);
			obj.removeClass("sort"+sortcur).addClass("sort"+sortnew);
			var id = $('#'+ module.app +'3 ul[rel=phases] .module-click:eq(0)').attr("rel");
			$('#'+ module.app).data('third',id);
			if(id == undefined) {
				return false;
			}
			var moduleidx = $('#'+ module.app +'3 ul').index($('#'+ module.app +'3 ul[rel=phases]'));
			module.getDetails(moduleidx,0);
			$('#'+ module.app +'3 ul[rel=phases] .module-click:eq(0)').addClass('active-link');
			}
		});
	}


	this.sortdrag = function (order) {
		var module = this;
		var fid = $('#'+ module.app).data("second");
		$.ajax({ type: "GET", url: "/", data: 'path=apps/'+ module.app +'/modules/phases&request=setOrder&'+order+'&id='+fid, success: function(html){
			$('#'+ module.app +'3 .sort:visible').attr("rel", "3");
			$('#'+ module.app +'3 .sort:visible').removeClass("sort1").removeClass("sort2").addClass("sort3");
			}
		});	
	}


	this.actionDialog = function(offset,request,field,append,title,sql) {
		var module = this;
		switch(request) {
			case "getPhaseTaskDialog":
				$.ajax({ type: "GET", url: "/", data: 'path=apps/'+ module.app +'/modules/phases&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
					$("#modalDialog").html(html);
					$("#modalDialog").dialog('option', 'position', offset);
					$("#modalDialog").dialog('option', 'title', title);
					$("#modalDialog").dialog('open');
					}
				});
			break;
			case "getProjectLinkDialog":
				$.ajax({ type: "GET", url: "/", data: 'path=apps/'+ module.app +'/modules/phases&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
					$("#modalDialog").html(html);
					$("#modalDialog").dialog('option', 'position', offset);
					$("#modalDialog").dialog('option', 'title', title);
					$("#modalDialog").dialog('open');
					}
				});
			break;
			/*case "getPhaseStatusDialog":
				$.ajax({ type: "GET", url: "/", data: 'path=apps/'+ module.app +'/modules/phases&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
					$("#modalDialog").html(html);
					$("#modalDialog").dialog('option', 'position', offset);
					$("#modalDialog").dialog('option', 'title', title);
					$("#modalDialog").dialog('open');
					}
				});
			break;*/
			case "getTasksDialog":
				$.ajax({ type: "GET", url: "/", data: 'path=apps/'+ module.app +'/modules/phases&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
					$("#modalDialog").html(html);
					$("#modalDialog").dialog('option', 'position', offset);
					$("#modalDialog").dialog('option', 'title', title);
					$("#modalDialog").dialog('open');
					}
				});
			break;
			case "getDocumentsDialog":
				var id = $('#'+ module.app).data("second");
				$.ajax({ type: "GET", url: "/", data: 'path=apps/'+ module.app +'/modules/documents&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql+'&id=' + id, success: function(html){
					$("#modalDialog").html(html);
					$("#modalDialog").dialog('option', 'position', offset);
					$("#modalDialog").dialog('option', 'title', title);
					$("#modalDialog").dialog('open');
					}
				});
			break;
			default:
			$.ajax({ type: "GET", url: "/", data: 'path=apps/'+ module.app +'&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
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

	this.showItemContext = function(ele,uid,field) {
		var module = this;
		var id = $("#"+field).val();
		$.ajax({ type: "GET", url: "/", data: 'path=apps/'+ module.app +'/modules/phases&request=getTaskContext&id='+id+'&field='+field, success: function(html){
			ele.parent().append(html);
			ele.next().slideDown();
			}
		});
	}


	/*this.insertStatusDate = function(rel,text) {
		var module = this;
		var html = '<div class="listmember" field="projectsphase_status" uid="'+rel+'" style="float: left">' + text + '</div>';
		$("#projectsphase_status").html(html);
		$("#modalDialog").dialog("close");
		$("#projectsphase_status").nextAll('img').trigger('click');
	}*/
	
	
	this.newItemSelection = function(rel) {
		var module = this;
		var enddate = $('#'+ module.app +'phaseenddate').html();
		var pid = $('#'+ module.app).data("second");
		var phid = $('#'+ module.app).data("third");
		var cat = rel;
		$("#modalDialog").dialog("close");
		if(cat == 2) {
			this.actionDialog(0,'getProjectLinkDialog','status',1);
		} else {
			$.ajax({ type: "GET", url: "/", data: 'path=apps/'+ module.app +'/modules/phases&request=addTask&pid=' + pid + '&phid=' + phid + '&date=' + enddate + '&enddate=' + enddate + '&cat=' + cat, success: function(html){
				$('#'+ module.app +'phasetasks').append(html);
				var idx = parseInt($('#'+ module.app +'-right .cbx').size() -1);
				var element = $('#'+ module.app +'-right .cbx:eq('+idx+')');
				$.jNice.CheckAddPO(element);
				$('#'+ module.app +'-right div.phaseouter:eq('+idx+')').slideDown(function() {
					$(this).find(":text:eq(0)").focus();
					if(idx == 6) {
					$('#'+ module.app +'-right .addTaskTable').clone().insertAfter('#'+ module.app +'phasetasks');
					}
					window['init'+ module.objectnameCaps +'ContentScrollbar']();
					$.ajax({ type: "GET", url: "/", dataType:  'json', data: 'path=apps/'+ module.app +'&request=getDates&id='+pid, success: function(val){
						$('#'+ module.app +'enddate').html(val.enddate);
						}
					});
				});
				}
			});
		}
	}


	this.addParentLink = function(id) {
		var module = this;
		var pid = $('#'+ module.app).data("second");
		var phid = $('#'+ module.app).data("third");
		$("#modalDialog").dialog("close");
		$.ajax({ type: "GET", url: "/", data: 'path=apps/'+ module.app +'/modules/phases&request=addProjectLink&id=' + id + '&pid=' + pid + '&phid=' + phid, success: function(html){
				$('#'+ module.app +'phasetasks').append(html);
				var idx = parseInt($('#'+ module.app +'-right .cbx').size() -1);
				$('#'+ module.app +'-right div.phaseouter:eq('+idx+')').slideDown(function() {
					$(this).find(":text:eq(0)").focus();
					if(idx == 6) {
					$('#'+ module.app +'-right .addTaskTable').clone().insertAfter('#'+ module.app +'phasetasks');
					}
					window['init'+ module.objectnameCaps +'ContentScrollbar']();							   
				});
				}
			});
		$.ajax({ type: "GET", url: "/", data: 'path=apps/'+ module.app +'&request=saveLastUsedProjects&id='+id});
	}


	this.insertItem = function(field,append,id,text) {
		var module = this;
		$("#"+field).val(id);
		var html = '<span rel="'+field+'" class="dependentTask"><a href="'+ module.app +'_phases" class="showItemContext" uid="'+id+'" field="'+field+'">'+text+'</a></span>';
		$("#"+field+"-text").html(html);
		$("#modalDialog").dialog('close');
		var obj = getCurrentModule();
		$('#'+ module.app +' .coform').ajaxSubmit(obj.poformOptions);
	}


	this.removeItem = function(clicked,field) {
		var module = this;
		clicked.parent().fadeOut();
		$("#"+field).val('');
		$("#"+field+"-text").html('');
		var obj = getCurrentModule();
		$('#'+ module.app +' .coform').ajaxSubmit(obj.poformOptions);
	}


	this.binItem = function(id) {
		var module = this;
		var txt = ALERT_DELETE;
		var langbuttons = {};
		langbuttons[ALERT_YES] = true;
		langbuttons[ALERT_NO] = false;
		$.prompt(txt,{ 
			buttons:langbuttons,
			submit: function(e,v,m,f){		
				if(v){
					$.ajax({ type: "GET", url: "/", data: 'path=apps/'+ module.app +'/modules/phases&request=deleteTask&id=' + id, success: function(data){
						if(data){
							$("#task_"+id).slideUp(function(){ 
								$(this).remove();
								var pst = $(".task_start:first").val();
								var pen = $(".task_start:last").val();
								$('#'+ module.app +'phasestartdate').html(pst);
								$('#'+ module.app +'phaseenddate').html(pen);
								var pid = $('#'+ module.app).data("second");
								$.ajax({ type: "GET", url: "/", dataType:  'json', data: 'path=apps/'+ module.app +'&request=getDates&id='+pid, success: function(val){
									$('#'+ module.app +'enddate').html(val.enddate);
									}
								});
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
		var module = this;
		var url = '/?path=apps/'+ module.app +'/modules/phases&request=getHelp';
		$("#documentloader").attr('src', url);
	}
	
	
	// Recycle Bin
	this.binDelete = function(id) {
		var module = this;
		var txt = ALERT_DELETE_REALLY;
		var langbuttons = {};
		langbuttons[ALERT_YES] = true;
		langbuttons[ALERT_NO] = false;
		$.prompt(txt,{ 
			buttons:langbuttons,
			submit: function(e,v,m,f){		
				if(v){
					$.ajax({ type: "GET", url: "/", data: 'path=apps/'+ module.app +'/modules/phases&request=deletePhase&id=' + id, cache: false, success: function(data){
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
		var module = this;
		var txt = ALERT_RESTORE;
		var langbuttons = {};
		langbuttons[ALERT_YES] = true;
		langbuttons[ALERT_NO] = false;
		$.prompt(txt,{ 
			buttons:langbuttons,
			submit: function(e,v,m,f){		
				if(v){
					$.ajax({ type: "GET", url: "/", data: 'path=apps/'+ module.app +'/modules/phases&request=restorePhase&id=' + id, cache: false, success: function(data){
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
		var module = this;
		var txt = ALERT_DELETE_REALLY;
		var langbuttons = {};
		langbuttons[ALERT_YES] = true;
		langbuttons[ALERT_NO] = false;
		$.prompt(txt,{ 
			buttons:langbuttons,
			submit: function(e,v,m,f){		
				if(v){
					$.ajax({ type: "GET", url: "/", data: 'path=apps/'+ module.app +'/modules/phases&request=deletePhaseTask&id=' + id, cache: false, success: function(data){
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
		var module = this;
		var txt = ALERT_RESTORE;
		var langbuttons = {};
		langbuttons[ALERT_YES] = true;
		langbuttons[ALERT_NO] = false;
		$.prompt(txt,{ 
			buttons:langbuttons,
			submit: function(e,v,m,f){		
				if(v){
					$.ajax({ type: "GET", url: "/", data: 'path=apps/'+ module.app +'/modules/phases&request=restorePhaseTask&id=' + id, cache: false, success: function(data){
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