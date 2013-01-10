/* meetings Object */
function employeesMeetings(name) {
	this.name = name;


	this.formProcess = function(formData, form, poformOptions) {
		var title = $("#employees input.title").fieldValue();
		if(title == "") {
			$.prompt(ALERT_NO_TITLE, {callback: setTitleFocus});
			return false;
		} else {
			formData[formData.length] = { "name": "title", "value": title };
		}
		
		$("#employeesmeetingtasks > div").each(function() {
			var id = $(this).attr('id');
			var reg = /[0-9]+/.exec(id);
			var yo = "task_text_"+reg;
			var namen = "task_text["+reg+"]";
			if($('#task_'+reg+' :input[name="task_text_'+reg+'"]').length > 0) {
				//var text = $('#'+yo).tinymce().getContent();
				var text = $('#'+yo).val();
				for (var i=0; i < formData.length; i++) { 
					if (formData[i].name == yo) { 
						formData[i].name = namen;
						formData[i].value = text;
					} 
				}
			} else {
				var text = $('#'+yo).html();
				formData[formData.length] = { "name": name, "value": text };
			}
		});
		
		formData[formData.length] = processListApps('participants');
		formData[formData.length] = processCustomTextApps('participants_ct');
		formData[formData.length] = processListApps('management');
		formData[formData.length] = processCustomTextApps('management_ct');
		formData[formData.length] = processListApps('location');
		formData[formData.length] = processCustomTextApps('location_ct');
		formData[formData.length] = processStringApps('meetingstart');
		formData[formData.length] = processStringApps('meetingend');
		formData[formData.length] = processListApps('meeting_relates_to');
		formData[formData.length] = processDocListApps('documents');
		formData[formData.length] = processListApps('meeting_access');
		//formData[formData.length] = processListApps('meeting_status');
	 }
	 
	 
	 this.formResponse = function(data) {
		$("#employees3 ul[rel=meetings] span[rel="+data.id+"] .text").html($("#employees .item_date").val() + ' - ' +$("#employees .title").val());
		switch(data.access) {
			case "0":
				$("#employees3 ul[rel=meetings] span[rel="+data.id+"] .module-access-status").removeClass("module-access-active");
			break;
			case "1":
				$("#employees3 ul[rel=meetings] span[rel="+data.id+"] .module-access-status").addClass("module-access-active");
			break;
		}
	}
	
	
	this.poformOptions = { async: false, beforeSubmit: this.formProcess, dataType: 'json', success: this.formResponse };


	this.statusOnClose = function(dp) {
		var id = $("#employees").data("third");
		var status = $("#employees .statusTabs li span.active").attr('rel');
		var date = $("#employees .statusTabs input").val();
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/employees/modules/meetings&request=updateStatus&id=" + id + "&date=" + date + "&status=" + status, cache: false, success: function(data){
			switch(data.action) {
				case "edit":
					switch(data.status) {
						case "1":
							$("#employees3 ul[rel=meetings] span[rel="+data.id+"] .module-item-status").addClass("module-item-active").removeClass("module-item-active-stopped");
						break;
						case "2":
							$("#employees3 ul[rel=meetings] span[rel="+data.id+"] .module-item-status").addClass("module-item-active-stopped").removeClass("module-item-active");
						break;
						default:
							$("#employees3 ul[rel=meetings] span[rel="+data.id+"] .module-item-status").removeClass("module-item-active").removeClass("module-item-active-stopped");
					}
				break;
				case "reload":
					var module = getCurrentModule();
					var id = $('#employees').data('second');
					$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/employees/modules/meetings&request=getList&id="+id, success: function(list){
						$('#employees3 ul[rel=meetings]').html(list.html);
						$('#employees_meetings_items').html(list.items);
						var moduleidx = $("#employees3 ul").index($("#employees3 ul[rel=meetings]"));
						var liindex = $("#employees3 ul[rel=meetings] .module-click").index($("#employees3 ul[rel=meetings] .module-click[rel='"+data.id+"']"));
						module.getDetails(moduleidx,liindex);
						$("#employees3 ul[rel=meetings] .module-click:eq("+liindex+")").addClass('active-link');
						}
					});
				break;																																														  				}
			}
		});
	}


	this.getDetails = function(moduleidx,liindex,list) {
		var id = $("#employees3 ul:eq("+moduleidx+") .module-click:eq("+liindex+")").attr("rel");
		$('#employees').data({ "third" : id});
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/employees/modules/meetings&request=getDetails&id="+id, success: function(data){
			$("#employees-right").html(data.html);
			
			if($('#checkedOut').length > 0) {
					$("#employees3 ul[rel=meetings] .active-link .icon-checked-out").addClass('icon-checked-out-active');
				} else {
					$("#employees3 ul[rel=meetings] .active-link .icon-checked-out").removeClass('icon-checked-out-active');
				}
			
			if(list == 0) {
				switch (data.access) {
					case "sysadmin": case "admin":
						employeesActions(0);
					break;
					case "guest":
						employeesActions(5);
					break;
				}
			} else {
				switch (data.access) {
					case "sysadmin": case "admin" :
						if(list == "<li></li>") {
							employeesActions(3);
						} else {
							employeesActions(0);
						}
					break;
					case "guest":
						if(list == "<li></li>") {
							employeesActions();
						} else {
							employeesActions(5);
						}
					break;
				}
				
			}
			initEmployeesContentScrollbar();
			}
		});	
	}


	this.actionNew = function() {
		var module = this;
		var cid = $('#employees input[name="id"]').val()
		module.checkIn(cid);
	
		var id = $('#employees').data('second');
		$.ajax({ type: "GET", url: "/", dataType: 'json', data: 'path=apps/employees/modules/meetings&request=createNew&id=' + id, cache: false, success: function(data){
			$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/employees/modules/meetings&request=getList&id="+id, success: function(list){
				$("#employees3 ul[rel=meetings]").html(list.html);
				$('#employees_meetings_items').html(list.items);
				var liindex = $("#employees3 ul[rel=meetings] .module-click").index($("#employees3 ul[rel=meetings] .module-click[rel='"+data.id+"']"));
				$("#employees3 ul[rel=meetings] .module-click:eq("+liindex+")").addClass('active-link');
				var moduleidx = $("#employees3 ul").index($("#employees3 ul[rel=meetings]"));
				module.getDetails(moduleidx,liindex);
				setTimeout(function() { $('#employees-right .focusTitle').trigger('click'); }, 800);
				}
			});
			}
		});
	}


	this.actionDuplicate = function() {
		var module = this;
		var cid = $('#employees input[name="id"]').val()
		module.checkIn(cid);
		var id = $("#employees").data("third");
		var pid = $("#employees").data("second");
		$.ajax({ type: "GET", url: "/", data: 'path=apps/employees/modules/meetings&request=createDuplicate&id=' + id, cache: false, success: function(mid){
			$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/employees/modules/meetings&request=getList&id="+pid, success: function(data){																																																																				
				$("#employees3 ul[rel=meetings]").html(data.html);
				$('#employees_meetings_items').html(data.items);
				var moduleidx = $("#employees3 ul").index($("#employees3 ul[rel=meetings]"));
				var liindex = $("#employees3 ul[rel=meetings] .module-click").index($("#employees3 ul[rel=meetings] .module-click[rel='"+mid+"']"));
				module.getDetails(moduleidx,liindex);
				$("#employees3 ul[rel=meetings] .module-click:eq("+liindex+")").addClass('active-link');
				}
			});
			}
		});
	}
	
	
	this.actionBin = function() {
		var module = this;
		var cid = $('#employees input[name="id"]').val()
		module.checkIn(cid);
		var txt = ALERT_DELETE;
		var langbuttons = {};
		langbuttons[ALERT_YES] = true;
		langbuttons[ALERT_NO] = false;
		$.prompt(txt,{ 
			buttons:langbuttons,
			callback: function(v,m,f){		
				if(v){
					var id = $("#employees").data("third");
					var pid = $("#employees").data("second");
					$.ajax({ type: "GET", url: "/", data: "path=apps/employees/modules/meetings&request=binMeeting&id=" + id, cache: false, success: function(data){
							if(data == "true") {
								$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/employees/modules/meetings&request=getList&id="+pid, success: function(data){
									$("#employees3 ul[rel=meetings]").html(data.html);
									$('#employees_meetings_items').html(data.items);
									if(data.html == "<li></li>") {
										employeesActions(3);
									} else {
										employeesActions(0);
									}
									var moduleidx = $("#employees3 ul").index($("#employees3 ul[rel=meetings]"));
									var liindex = 0;
									module.getDetails(moduleidx,liindex);
									$("#employees3 ul[rel=meetings] .module-click:eq("+liindex+")").addClass('active-link');
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
		$.ajax({ type: "GET", url: "/", async: false, data: 'path=apps/employees/modules/meetings&request=checkinMeeting&id='+id, success: function(data){
			if(!data) {
				prompt("something wrong");
			}
			}
		});
	}
	
	
	this.actionRefresh = function() {
		var id = $("#employees").data("third");
		var pid = $("#employees").data("second");
		$("#employees3 ul[rel=meetings] .active-link").trigger("click");
		$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/employees/modules/meetings&request=getList&id="+pid, success: function(data){																																																																				
			$("#employees3 ul[rel=meetings]").html(data.html);
			$('#employees_meetings_items').html(data.items);
			var liindex = $("#employees3 ul[rel=meetings] .module-click").index($("#employees3 ul[rel=meetings] .module-click[rel='"+id+"']"));
			$("#employees3 ul[rel=meetings] .module-click:eq("+liindex+")").addClass('active-link');
			}
		});
	}


	this.actionPrint = function() {
		var id = $("#employees").data("third");
		var url ='/?path=apps/employees/modules/meetings&request=printDetails&id='+id;
		$("#documentloader").attr('src', url);
	}


	this.actionSend = function() {
		var id = $("#employees").data("third");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/employees/modules/meetings&request=getSend&id="+id, success: function(data){
			$("#modalDialogForward").html(data.html).dialog('open');
			if(data.error == 1) {
				$.prompt('<div style="text-align: center">' + ALERT_REMOVE_RECIPIENT + data.error_message + '<br /></div>');
				return false;
			}
			}
		});
	}


	this.actionSendtoResponse = function() {
		var id = $("#employees").data("third");
		$.ajax({ type: "GET", url: "/", data: "path=apps/employees/modules/meetings&request=getSendtoDetails&id="+id, success: function(html){
			$("#employeesmeeting_sendto").html(html);
			//$("#modalDialogForward").dialog('close');
			}
		});
	}
	
	
	this.sortclick = function (obj,sortcur,sortnew) {
		var module = this;
		var cid = $('#employees input[name="id"]').val()
		module.checkIn(cid);
		
		var fid = $("#employees2 .module-click:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/employees/modules/meetings&request=getList&id="+fid+"&sort="+sortnew, success: function(data){
			$("#employees3 ul[rel=meetings]").html(data.html);
			$('#employees_meetings_items').html(data.items);
			obj.attr("rel",sortnew);
			obj.removeClass("sort"+sortcur).addClass("sort"+sortnew);
			var id = $("#employees3 ul[rel=meetings] .module-click:eq(0)").attr("rel");
			$('#employees').data('third',id);
			if(id == undefined) {
				return false;
			}
			var moduleidx = $("#employees3 ul").index($("#employees3 ul[rel=meetings]"));
			module.getDetails(moduleidx,0);
			$("#employees3 ul[rel=meetings] .module-click:eq(0)").addClass('active-link');
		}
		});
	}


	this.sortdrag = function (order) {
		var fid = $("#employees").data("second");
		$.ajax({ type: "GET", url: "/", data: "path=apps/employees/modules/meetings&request=setOrder&"+order+"&id="+fid, success: function(html){
			$("#employees3 .sort:visible").attr("rel", "3");
			$("#employees3 .sort:visible").removeClass("sort1").removeClass("sort2").addClass("sort3");
			}
		});
	}


	this.actionDialog = function(offset,request,field,append,title,sql) {
		switch(request) {
			case "getAccessDialog":
				$.ajax({ type: "GET", url: "/", data: 'path=apps/employees&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
					$("#modalDialog").html(html);
					//$("#modalDialog").dialog('option', 'height', 50);
					$("#modalDialog").dialog('option', 'position', offset);
					$("#modalDialog").dialog('option', 'title', title);
					$("#modalDialog").dialog('open');
					}
				});
			break;
			case "getMeetingStatusDialog":
				$.ajax({ type: "GET", url: "/", data: 'path=apps/employees/modules/meetings&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
					$("#modalDialog").html(html);
					$("#modalDialog").dialog('option', 'position', offset);
					$("#modalDialog").dialog('option', 'title', title);
					$("#modalDialog").dialog('open');
					}
				});
			break;
			case "getDocumentsDialog":
				var id = $("#employees").data("second");
				$.ajax({ type: "GET", url: "/", data: 'path=apps/employees/modules/documents&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql+'&id=' + id, success: function(html){
					$("#modalDialog").html(html);
					$("#modalDialog").dialog('option', 'position', offset);
					$("#modalDialog").dialog('option', 'title', title);
					$("#modalDialog").dialog('open');
					}
				});
			break;
			case "getEmployeesDialog":
			var id = $("#employees").data("second");
				$.ajax({ type: "GET", url: "/", data: 'path=apps/employees/modules/meetings&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
					$("#modalDialog").html(html);
					$("#modalDialog").dialog('option', 'position', offset);
					$("#modalDialog").dialog('option', 'title', title);
					$("#modalDialog").dialog('open');
					}
				});
			break;
			default:
			$.ajax({ type: "GET", url: "/", data: 'path=apps/employees&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
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


this.addEmployeeLink = function(id) {
		var pid = $("#employees").data("second");
		var phid = $("#employees").data("third");
		$("#modalDialog").dialog("close");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/employees/modules/meetings&request=copyMeeting&id=" + id + "&pid=" + id + "&phid=" + phid, success: function(data){
			if($("#employeesmeetingscopies").html() != "") {
				$("#employeesmeetingscopies").append("<br />");
			}
			$("#employeesmeetingscopies").append(data.titlelink);
			$.prompt(ALERT_SUCCESS_COPY_MEETING + '"'+data.title+'"');
			}
		});
		$.ajax({ type: "GET", url: "/", data: "path=apps/employees&request=saveLastUsedEmployees&id="+id});
	}


	this.insertStatus = function(rel,text) {
		var module = this;
		var html = '<div class="listmember" field="employeesmeeting_status" uid="'+rel+'" style="float: left">' + text + '</div>';
		$("#employeesmeeting_status").html(html);
		$("#modalDialog").dialog("close");
		$("#employeesmeeting_status").next().val("");
		$('#employees .coform').ajaxSubmit(module.poformOptions);
	}


	this.insertStatusDate = function(rel,text) {
		var html = '<div class="listmember" field="employeesmeeting_status" uid="'+rel+'" style="float: left">' + text + '</div>';
		$("#employeesmeeting_status").html(html);
		$("#modalDialog").dialog("close");
		$("#employeesmeeting_status").nextAll('img').trigger('click');
	}


	this.newItem = function() {
		var mid = $("#employees").data("third");
		var num = parseInt($("#employees-right .task_sort").size());
		$.ajax({ type: "GET", url: "/", data: "path=apps/employees/modules/meetings&request=addTask&mid=" + mid + "&num=" + num + "&sort=" + num, success: function(html){
			$('#employeesmeetingtasks').append(html);
			var idx = parseInt($('#employeesmeetingtasks .cbx').size() -1);
			var element = $('#employeesmeetingtasks .cbx:eq('+idx+')');
			$.jNice.CheckAddPO(element);
			$('#employeesmeetingtasks .meetingouter:eq('+idx+')').slideDown(function() {
				$(this).find(":text:eq(0)").focus();
				if(idx == 6) {
				$('#employees-right .addTaskTable').clone().insertAfter('#phasetasks');
				}
				initEmployeesContentScrollbar();
			});
			}
		});
	}


	this.actionSortItems = function(order) {
		$.ajax({ type: "GET", url: "/", data: "path=apps/employees/modules/meetings&request=sortItems&"+ order, cache: false, success: function(data){
			}
		});
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
				$.ajax({ type: "GET", url: "/", data: "path=apps/employees/modules/meetings&request=deleteTask&id=" + id, success: function(data){
					if(data){
						$("#task_"+id).slideUp(function(){ $(this).remove(); });
					} 
					}
				});
				} 
			}
		});
	}
	
	this.actionHelp = function() {
		var url = "/?path=apps/employees/modules/meetings&request=getHelp";
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/employees/modules/meetings&request=deleteMeeting&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#meeting_'+id).slideUp();
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/employees/modules/meetings&request=restoreMeeting&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#meeting_'+id).slideUp();
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/employees/modules/meetings&request=deleteMeetingTask&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#meeting_task_'+id).slideUp();
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/employees/modules/meetings&request=restoreMeetingTask&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#meeting_task_'+id).slideUp();
						}
					}
					});
				} 
			}
		});
	}


	this.manageCheckpoint = function(action,date) {
		var pid = $('#employees').data('third');
		switch(action) {
			case 'new':
				$.ajax({ type: "GET", url: "/", data: "path=apps/employees/modules/meetings&request=newCheckpoint&id=" + pid + "&date=" + date, cache: false });
			break;
			case 'update':
				$.ajax({ type: "GET", url: "/", data: "path=apps/employees/modules/meetings&request=updateCheckpoint&id=" + pid + "&date=" + date, cache: false });			
			break;
			case 'delete':
				$.ajax({ type: "GET", url: "/", data: "path=apps/employees/modules/meetings&request=deleteCheckpoint&id=" + pid, cache: false });
			break;
		}
	}
	
	this.saveCheckpointText = function() {
		var pid = $('#employees').data('third');
		var text = $('#employees_meetingsCheckpoint textarea').val();
		$.ajax({ type: "POST", url: "/", data: "path=apps/employees/modules/meetings&request=updateCheckpointText&id=" + pid + "&text=" + text, cache: false });
	}

	this.togglePost = function(id,obj) {
		var outer = $('#employeesmeetingtask_'+id);
		outer.slideToggle();
		obj.find('span').toggleClass('active');
	}
	
}

var employees_meetings = new employeesMeetings('employees_meetings');