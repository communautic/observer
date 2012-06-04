/* phases Object */
function productionsPhases(name) {
	this.name = name;
	
	
	this.formProcess = function(formData, form, poformOptions) {
		var title = $("#productions input.title").fieldValue();
		if(title == "") {
			$.prompt(ALERT_NO_TITLE, {callback: setTitleFocus});
			return false;
		} else {
			formData[formData.length] = { "name": "title", "value": title };
		}
	
		$('#productions div.task_team_list').each(function() {
			var id = $(this).attr("id");
			var reg = /[0-9]+/.exec(id);
			formData[formData.length] = processListArray(reg);
		});
	
		$('#productions div.task_team_list_ct').each(function() {
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
				$("#productions3 ul[rel=phases] span[rel="+data.id+"] .text").html($("#productions .title").val());
				$("#productionsphasestartdate").html(data.startdate);
				$("#productionsphaseenddate").html(data.enddate);
				var pid = $('#productions').data("second");

				$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/productions&request=getDates&id="+pid, success: function(production){
						$("#productionenddate").html(production.enddate);
					}
				});
				
				switch(data.access) {
					case "0":
						$("#productions3 ul[rel=phases] span[rel="+data.id+"] .module-access-status").removeClass("module-access-active");
					break;
					case "1":
						$("#productions3 ul[rel=phases] span[rel="+data.id+"] .module-access-status").addClass("module-access-active");
					break;
				}
				switch(data.status) {
					case "2":
						$("#productions3 ul[rel=phases] span[rel="+data.id+"] .module-item-status").addClass("module-item-active");
					break;
					default:
						$("#productions3 ul[rel=phases] span[rel="+data.id+"] .module-item-status").removeClass("module-item-active");
				}
			break;
		}	
	}
	
	
	this.poformOptions = { async: false, beforeSubmit: this.formProcess, dataType: 'json', success: this.formResponse };
	
	
	this.getDetails = function(moduleidx,liindex,list) {
		var phaseid = $("#productions3 ul:eq("+moduleidx+") .module-click:eq("+liindex+")").attr("rel");
		$('#productions').data({ "third" : phaseid});
		var num = $("#productions3 ul:eq("+moduleidx+") .phase_num:eq("+liindex+")").html();
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/productions/modules/phases&request=getDetails&id="+phaseid+"&num="+num, success: function(data){
			$("#productions-right").html(data.html);
			if($('#checkedOut').length > 0) {
					$("#productions3 ul[rel=phases] .active-link .icon-checked-out").addClass('icon-checked-out-active');
				} else {
					$("#productions3 ul[rel=phases] .active-link .icon-checked-out").removeClass('icon-checked-out-active');
				}
			if(list == 0) {
				switch (data.access) {
					case "sysadmin": case "admin":
						productionsActions(0);
					break;
					case "guest":
						productionsActions(5);
					break;
				}
			} else {
				switch (data.access) {
					case "sysadmin": case "admin" :
						if(list == "<li></li>") {
							productionsActions(3);
						} else {
							productionsActions(0);
						}
					break;
					case "guest":
						if(list == "<li></li>") {
							productionsActions();
						} else {
							productionsActions(5);
						}
					break;
				}
				
			}
			initProductionsContentScrollbar();
			}
		});
	}

	
	this.actionNew = function() {
		var module = this;
		var cid = $('#productions input[name="id"]').val()
		module.checkIn(cid);
		var id = $('#productions').data('second');
		var num  = parseInt($("#productions3 ul[rel=phases] li").size()+1);
		$.ajax({ type: "GET", url: "/", dataType: 'json', data: 'path=apps/productions/modules/phases&request=createNew&id=' + id + '&num=' + num, cache: false, success: function(data){
				$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/productions/modules/phases&request=getList&id="+id, success: function(ldata){
					$("#productions3 ul[rel=phases]").html(ldata.html);
					var liindex = $("#productions3 ul[rel=phases] .module-click").index($("#productions3 ul[rel=phases] .module-click[rel='"+data.id+"']"));
					$("#productions3 ul[rel=phases] .module-click:eq("+liindex+")").addClass('active-link');
					var moduleidx = $("#productions3 ul").index($("#productions3 ul[rel=phases]"));
					module.getDetails(moduleidx,liindex);
					setTimeout(function() { $('#productions-right .focusTitle').trigger('click'); }, 800);
					$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/productions&request=getDates&id="+id, success: function(production){
							$("#productionenddate").html(production.enddate);
						}
					});
					}
				});
			}
		});
	}


	this.actionDuplicate = function() {
		var module = this;
		var cid = $('#productions input[name="id"]').val()
		module.checkIn(cid);
		var id = $("#productions").data("third");
		var pid = $("#productions").data("second");
		$.ajax({ type: "GET", url: "/", data: 'path=apps/productions/modules/phases&request=createDuplicate&id=' + id, cache: false, success: function(phaseid){
			$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/productions/modules/phases&request=getList&id="+pid, success: function(data){																																																																				
				$("#productions3 ul[rel=phases]").html(data.html);
				var moduleidx = $("#productions3 ul").index($("#productions3 ul[rel=phases]"));
				var liindex = $("#productions3 ul[rel=phases] .module-click").index($("#productions3 ul[rel=phases] .module-click[rel='"+phaseid+"']"));
				module.getDetails(moduleidx,liindex);
				$("#productions3 ul[rel=phases] .module-click:eq("+liindex+")").addClass('active-link');
				productionsActions(0);
				}
			});
			}
		});
	}


	this.actionBin = function() {
		var module = this;
		var cid = $('#productions input[name="id"]').val()
		module.checkIn(cid);
		var txt = ALERT_DELETE;
		var langbuttons = {};
		langbuttons[ALERT_YES] = true;
		langbuttons[ALERT_NO] = false;
		$.prompt(txt,{ 
			buttons:langbuttons,
			callback: function(v,m,f){		
				if(v){
					var id = $("#productions").data("third");
					var pid = $("#productions").data("second");
					$.ajax({ type: "GET", url: "/", data: "path=apps/productions/modules/phases&request=binPhase&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/productions/modules/phases&request=getList&id="+pid, success: function(data){
								$("#productions3 ul[rel=phases]").html(data.html);
								if(data.html == "<li></li>") {
									productionsActions(3);
								} else {
									productionsActions(0);
								}
								var moduleidx = $("#productions3 ul").index($("#productions3 ul[rel=phases]"));
								var liindex = 0;
								module.getDetails(moduleidx,liindex);
								$("#productions3 ul[rel=phases] .module-click:eq("+liindex+")").addClass('active-link');
								$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/productions&request=getDates&id="+pid, success: function(production){
										$("#productionenddate").html(production.enddate);
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
		$.ajax({ type: "GET", url: "/", async: false, data: 'path=apps/productions/modules/phases&request=checkinPhase&id='+id, success: function(data){
			if(!data) {
				prompt("something wrong");
			}
			}
		});
	}


	this.actionRefresh = function() {
		var id = $("#productions").data("third");
		var pid = $("#productions").data("second");
		$("#productions3 ul[rel=phases] .active-link").trigger("click");
		$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/productions/modules/phases&request=getList&id="+pid, success: function(data){																																																																				
			$("#productions3 ul[rel=phases]").html(data.html);
			var liindex = $("#productions3 ul[rel=phases] .module-click").index($("#productions3 ul[rel=phases] .module-click[rel='"+id+"']"));
			$("#productions3 ul[rel=phases] .module-click:eq("+liindex+")").addClass('active-link');
			}
		});
	}


	this.actionPrint = function() {
		var id = $("#productions").data("third");
		var num = $("#productions3 ul[rel=phases] .active-link").find(".phase_num").html();
		var url ='/?path=apps/productions/modules/phases&request=printDetails&id='+id+"&num="+num;
		$("#documentloader").attr('src', url);
	}


	this.actionSend = function() {
		var id = $("#productions").data("third");
		var num = $("#productions3 ul[rel=phases] .active-link").find(".phase_num").html();
		$.ajax({ type: "GET", url: "/", data: "path=apps/productions/modules/phases&request=getSend&id="+id+"&num="+num, success: function(html){
			$("#modalDialogForward").html(html).dialog('open');
			}
		});
	}


	this.actionSendtoResponse = function() {
		var id = $("#productions").data("third");
		$.ajax({ type: "GET", url: "/", data: "path=apps/productions/modules/phases&request=getSendtoDetails&id="+id, success: function(html){
			$("#productions_phase_sendto").html(html);
			$("#modalDialogForward").dialog('close');
			}
		});
	}


	this.sortclick = function (obj,sortcur,sortnew) {
		var module = this;
		var cid = $('#productions input[name="id"]').val()
		module.checkIn(cid);
		var fid = $("#productions").data("second");
		$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/productions/modules/phases&request=getList&id="+fid+"&sort="+sortnew, success: function(data){
			$("#productions3 ul[rel=phases]").html(data.html);
			obj.attr("rel",sortnew);
			obj.removeClass("sort"+sortcur).addClass("sort"+sortnew);
			var id = $("#productions3 ul[rel=phases] .module-click:eq(0)").attr("rel");
			$('#productions').data('third',id);
			if(id == undefined) {
				return false;
			}
			var moduleidx = $("#productions3 ul").index($("#productions3 ul[rel=phases]"));
			module.getDetails(moduleidx,0);
			$("#productions3 ul[rel=phases] .module-click:eq(0)").addClass('active-link');
			}
		});
	}


	this.sortdrag = function (order) {
		var fid = $("#productions").data("second");
		$.ajax({ type: "GET", url: "/", data: "path=apps/productions/modules/phases&request=setOrder&"+order+"&id="+fid, success: function(html){
			$("#productions3 .sort:visible").attr("rel", "3");
			$("#productions3 .sort:visible").removeClass("sort1").removeClass("sort2").addClass("sort3");
			}
		});	
	}


	this.actionDialog = function(offset,request,field,append,title,sql) {
		switch(request) {
			case "getPhaseTaskDialog":
				$.ajax({ type: "GET", url: "/", data: 'path=apps/productions/modules/phases&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
					$("#modalDialog").html(html);
					$("#modalDialog").dialog('option', 'position', offset);
					$("#modalDialog").dialog('option', 'title', title);
					$("#modalDialog").dialog('open');
					}
				});
			break;
			case "getPhaseStatusDialog":
				$.ajax({ type: "GET", url: "/", data: 'path=apps/productions/modules/phases&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
					$("#modalDialog").html(html);
					$("#modalDialog").dialog('option', 'position', offset);
					$("#modalDialog").dialog('option', 'title', title);
					$("#modalDialog").dialog('open');
					}
				});
			break;
			case "getTasksDialog":
				$.ajax({ type: "GET", url: "/", data: 'path=apps/productions/modules/phases&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
					$("#modalDialog").html(html);
					$("#modalDialog").dialog('option', 'position', offset);
					$("#modalDialog").dialog('option', 'title', title);
					$("#modalDialog").dialog('open');
					}
				});
			break;
			case "getDocumentsDialog":
				var id = $("#productions").data("second");
				$.ajax({ type: "GET", url: "/", data: 'path=apps/productions/modules/documents&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql+'&id=' + id, success: function(html){
					$("#modalDialog").html(html);
					$("#modalDialog").dialog('option', 'position', offset);
					$("#modalDialog").dialog('option', 'title', title);
					$("#modalDialog").dialog('open');
					}
				});
			break;
			default:
			$.ajax({ type: "GET", url: "/", data: 'path=apps/productions&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
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
		var id = $("#"+field).val();
		$.ajax({ type: "GET", url: "/", data: "path=apps/productions/modules/phases&request=getTaskContext&id="+id+"&field="+field, success: function(html){
			ele.parent().append(html);
			ele.next().slideDown();
			}
		});
	}


	this.insertStatusDate = function(rel,text) {
		var module = this;
		var html = '<div class="listmember" field="productionsphase_status" uid="'+rel+'" style="float: left">' + text + '</div>';
		$("#productionsphase_status").html(html);
		$("#modalDialog").dialog("close");
		$("#productionsphase_status").nextAll('img').trigger('click');
	}
	
	
	this.newItemSelection = function(rel) {
		var enddate = $("#productionsphaseenddate").html();
		var pid = $("#productions").data("second");
		var phid = $("#productions").data("third");
		var cat = rel;
		$("#modalDialog").dialog("close");
		$.ajax({ type: "GET", url: "/", data: "path=apps/productions/modules/phases&request=addTask&pid=" + pid + "&phid=" + phid + "&date=" + enddate + "&enddate=" + enddate + "&cat=" + cat, success: function(html){
			$('#productionsphasetasks').append(html);
			var idx = parseInt($('#productions-right .cbx').size() -1);
			var element = $('#productions-right .cbx:eq('+idx+')');
			$.jNice.CheckAddPO(element);
			$('#productions-right div.phaseouter:eq('+idx+')').slideDown(function() {
				$(this).find(":text:eq(0)").focus();
				if(idx == 6) {
				$('#productions-right .addTaskTable').clone().insertAfter('#productionsphasetasks');
				}
				initProductionsContentScrollbar();								   
			});
			}
		});
	}
	
	
	this.insertItem = function(field,append,id,text) {
		$("#"+field).val(id);
		var html = '<span rel="'+field+'" class="dependentTask"><a href="productions_phases" class="showItemContext" uid="'+id+'" field="'+field+'">'+text+'</a></span>';
		$("#"+field+"-text").html(html);
		$("#modalDialog").dialog('close');
		var obj = getCurrentModule();
		$('#productions .coform').ajaxSubmit(obj.poformOptions);
	}


	this.removeItem = function(clicked,field) {
		clicked.parent().fadeOut();
		$("#"+field).val('');
		$("#"+field+"-text").html('');
		var obj = getCurrentModule();
		$('#productions .coform').ajaxSubmit(obj.poformOptions);
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/productions/modules/phases&request=deleteTask&id=" + id, success: function(data){
						if(data){
							$("#task_"+id).slideUp(function(){ 
								$(this).remove();
								var pst = $(".task_start:first").val();
								var pen = $(".task_start:last").val();
								$("#productionsphasestartdate").html(pst);
								$("#productionsphaseenddate").html(pen);
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
		var url = "/?path=apps/productions/modules/phases&request=getHelp";
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/productions/modules/phases&request=deletePhase&id=" + id, cache: false, success: function(data){
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/productions/modules/phases&request=restorePhase&id=" + id, cache: false, success: function(data){
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/productions/modules/phases&request=deletePhaseTask&id=" + id, cache: false, success: function(data){
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/productions/modules/phases&request=restorePhaseTask&id=" + id, cache: false, success: function(data){
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

var productions_phases = new productionsPhases('productions_phases');