/* meetings Object */
function patientsMeetings(name) {
	this.name = name;


	this.formProcess = function(formData, form, poformOptions) {
		var title = $("#patients input.title").fieldValue();
		if(title == "") {
			$.prompt(ALERT_NO_TITLE, {callback: setTitleFocus});
			return false;
		} else {
			formData[formData.length] = { "name": "title", "value": title };
		}
		
		$("#patientsmeetingtasks > div").each(function() {
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
		$("#patients3 ul[rel=meetings] span[rel="+data.id+"] .text").html($("#patients .item_date").val() + ' - ' +$("#patients .title").val());
		switch(data.access) {
			case "0":
				$("#patients3 ul[rel=meetings] span[rel="+data.id+"] .module-access-status").removeClass("module-access-active");
			break;
			case "1":
				$("#patients3 ul[rel=meetings] span[rel="+data.id+"] .module-access-status").addClass("module-access-active");
			break;
		}
	}
	
	
	this.poformOptions = { async: false, beforeSubmit: this.formProcess, dataType: 'json', success: this.formResponse };


	this.statusOnClose = function(dp) {
		var id = $("#patients").data("third");
		var status = $("#patients .statusTabs li span.active").attr('rel');
		var date = $("#patients .statusTabs input").val();
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/patients/modules/meetings&request=updateStatus&id=" + id + "&date=" + date + "&status=" + status, cache: false, success: function(data){
			switch(data.action) {
				case "edit":
					switch(data.status) {
						case "1":
							$("#patients3 ul[rel=meetings] span[rel="+data.id+"] .module-item-status").addClass("module-item-active").removeClass("module-item-active-stopped");
						break;
						case "2":
							$("#patients3 ul[rel=meetings] span[rel="+data.id+"] .module-item-status").addClass("module-item-active-stopped").removeClass("module-item-active");
						break;
						default:
							$("#patients3 ul[rel=meetings] span[rel="+data.id+"] .module-item-status").removeClass("module-item-active").removeClass("module-item-active-stopped");
					}
				break;
				case "reload":
					var module = getCurrentModule();
					var id = $('#patients').data('second');
					$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/patients/modules/meetings&request=getList&id="+id, success: function(list){
						$('#patients3 ul[rel=meetings]').html(list.html);
						$('#patients_meetings_items').html(list.items);
						var moduleidx = $("#patients3 ul").index($("#patients3 ul[rel=meetings]"));
						var liindex = $("#patients3 ul[rel=meetings] .module-click").index($("#patients3 ul[rel=meetings] .module-click[rel='"+data.id+"']"));
						module.getDetails(moduleidx,liindex);
						$("#patients3 ul[rel=meetings] .module-click:eq("+liindex+")").addClass('active-link');
						}
					});
				break;																																														  				}
			}
		});
	}


	this.getDetails = function(moduleidx,liindex,list) {
		var id = $("#patients3 ul:eq("+moduleidx+") .module-click:eq("+liindex+")").attr("rel");
		$('#patients').data({ "third" : id});
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/patients/modules/meetings&request=getDetails&id="+id, success: function(data){
			$("#patients-right").html(data.html);
			
			if($('#checkedOut').length > 0) {
					$("#patients3 ul[rel=meetings] .active-link .icon-checked-out").addClass('icon-checked-out-active');
				} else {
					$("#patients3 ul[rel=meetings] .active-link .icon-checked-out").removeClass('icon-checked-out-active');
				}
			
			if(list == 0) {
				switch (data.access) {
					case "sysadmin": case "admin":
						patientsActions(0);
					break;
					case "guest":
						patientsActions(5);
					break;
				}
			} else {
				switch (data.access) {
					case "sysadmin": case "admin" :
						if(list == "<li></li>") {
							patientsActions(3);
						} else {
							patientsActions(0);
						}
					break;
					case "guest":
						if(list == "<li></li>") {
							patientsActions();
						} else {
							patientsActions(5);
						}
					break;
				}
				
			}
			initPatientsContentScrollbar();
			}
		});	
	}


	this.actionNew = function() {
		var module = this;
		var cid = $('#patients input[name="id"]').val()
		module.checkIn(cid);
	
		var id = $('#patients').data('second');
		$.ajax({ type: "GET", url: "/", dataType: 'json', data: 'path=apps/patients/modules/meetings&request=createNew&id=' + id, cache: false, success: function(data){
			$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/patients/modules/meetings&request=getList&id="+id, success: function(list){
				$("#patients3 ul[rel=meetings]").html(list.html);
				$('#patients_meetings_items').html(list.items);
				var liindex = $("#patients3 ul[rel=meetings] .module-click").index($("#patients3 ul[rel=meetings] .module-click[rel='"+data.id+"']"));
				$("#patients3 ul[rel=meetings] .module-click:eq("+liindex+")").addClass('active-link');
				var moduleidx = $("#patients3 ul").index($("#patients3 ul[rel=meetings]"));
				module.getDetails(moduleidx,liindex);
				setTimeout(function() { $('#patients-right .focusTitle').trigger('click'); }, 800);
				}
			});
			}
		});
	}


	this.actionDuplicate = function() {
		var module = this;
		var cid = $('#patients input[name="id"]').val()
		module.checkIn(cid);
		var id = $("#patients").data("third");
		var pid = $("#patients").data("second");
		$.ajax({ type: "GET", url: "/", data: 'path=apps/patients/modules/meetings&request=createDuplicate&id=' + id, cache: false, success: function(mid){
			$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/patients/modules/meetings&request=getList&id="+pid, success: function(data){																																																																				
				$("#patients3 ul[rel=meetings]").html(data.html);
				$('#patients_meetings_items').html(data.items);
				var moduleidx = $("#patients3 ul").index($("#patients3 ul[rel=meetings]"));
				var liindex = $("#patients3 ul[rel=meetings] .module-click").index($("#patients3 ul[rel=meetings] .module-click[rel='"+mid+"']"));
				module.getDetails(moduleidx,liindex);
				$("#patients3 ul[rel=meetings] .module-click:eq("+liindex+")").addClass('active-link');
				}
			});
			}
		});
	}
	
	
	this.actionBin = function() {
		var module = this;
		var cid = $('#patients input[name="id"]').val()
		module.checkIn(cid);
		var txt = ALERT_DELETE;
		var langbuttons = {};
		langbuttons[ALERT_YES] = true;
		langbuttons[ALERT_NO] = false;
		$.prompt(txt,{ 
			buttons:langbuttons,
			callback: function(v,m,f){		
				if(v){
					var id = $("#patients").data("third");
					var pid = $("#patients").data("second");
					$.ajax({ type: "GET", url: "/", data: "path=apps/patients/modules/meetings&request=binMeeting&id=" + id, cache: false, success: function(data){
							if(data == "true") {
								$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/patients/modules/meetings&request=getList&id="+pid, success: function(data){
									$("#patients3 ul[rel=meetings]").html(data.html);
									$('#patients_meetings_items').html(data.items);
									if(data.html == "<li></li>") {
										patientsActions(3);
									} else {
										patientsActions(0);
									}
									var moduleidx = $("#patients3 ul").index($("#patients3 ul[rel=meetings]"));
									var liindex = 0;
									module.getDetails(moduleidx,liindex);
									$("#patients3 ul[rel=meetings] .module-click:eq("+liindex+")").addClass('active-link');
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
		$.ajax({ type: "GET", url: "/", async: false, data: 'path=apps/patients/modules/meetings&request=checkinMeeting&id='+id, success: function(data){
			if(!data) {
				prompt("something wrong");
			}
			}
		});
	}
	
	
	this.actionRefresh = function() {
		var id = $("#patients").data("third");
		var pid = $("#patients").data("second");
		$("#patients3 ul[rel=meetings] .active-link").trigger("click");
		$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/patients/modules/meetings&request=getList&id="+pid, success: function(data){																																																																				
			$("#patients3 ul[rel=meetings]").html(data.html);
			$('#patients_meetings_items').html(data.items);
			var liindex = $("#patients3 ul[rel=meetings] .module-click").index($("#patients3 ul[rel=meetings] .module-click[rel='"+id+"']"));
			$("#patients3 ul[rel=meetings] .module-click:eq("+liindex+")").addClass('active-link');
			}
		});
	}


	this.actionPrint = function() {
		var id = $("#patients").data("third");
		var url ='/?path=apps/patients/modules/meetings&request=printDetails&id='+id;
		$("#documentloader").attr('src', url);
	}


	this.actionSend = function() {
		var id = $("#patients").data("third");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/patients/modules/meetings&request=getSend&id="+id, success: function(data){
			$("#modalDialogForward").html(data.html).dialog('open');
			if(data.error == 1) {
				$.prompt('<div style="text-align: center">' + ALERT_REMOVE_RECIPIENT + data.error_message + '<br /></div>');
				return false;
			}
			}
		});
	}


	this.actionSendtoResponse = function() {
		var id = $("#patients").data("third");
		$.ajax({ type: "GET", url: "/", data: "path=apps/patients/modules/meetings&request=getSendtoDetails&id="+id, success: function(html){
			$("#patientsmeeting_sendto").html(html);
			//$("#modalDialogForward").dialog('close');
			}
		});
	}
	
	
	this.sortclick = function (obj,sortcur,sortnew) {
		var module = this;
		var cid = $('#patients input[name="id"]').val()
		module.checkIn(cid);
		
		var fid = $("#patients2 .module-click:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/patients/modules/meetings&request=getList&id="+fid+"&sort="+sortnew, success: function(data){
			$("#patients3 ul[rel=meetings]").html(data.html);
			$('#patients_meetings_items').html(data.items);
			obj.attr("rel",sortnew);
			obj.removeClass("sort"+sortcur).addClass("sort"+sortnew);
			var id = $("#patients3 ul[rel=meetings] .module-click:eq(0)").attr("rel");
			$('#patients').data('third',id);
			if(id == undefined) {
				return false;
			}
			var moduleidx = $("#patients3 ul").index($("#patients3 ul[rel=meetings]"));
			module.getDetails(moduleidx,0);
			$("#patients3 ul[rel=meetings] .module-click:eq(0)").addClass('active-link');
		}
		});
	}


	this.sortdrag = function (order) {
		var fid = $("#patients").data("second");
		$.ajax({ type: "GET", url: "/", data: "path=apps/patients/modules/meetings&request=setOrder&"+order+"&id="+fid, success: function(html){
			$("#patients3 .sort:visible").attr("rel", "3");
			$("#patients3 .sort:visible").removeClass("sort1").removeClass("sort2").addClass("sort3");
			}
		});
	}


	this.actionDialog = function(offset,request,field,append,title,sql) {
		switch(request) {
			case "getAccessDialog":
				$.ajax({ type: "GET", url: "/", data: 'path=apps/patients&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
					$("#modalDialog").html(html);
					//$("#modalDialog").dialog('option', 'height', 50);
					$("#modalDialog").dialog('option', 'position', offset);
					$("#modalDialog").dialog('option', 'title', title);
					$("#modalDialog").dialog('open');
					}
				});
			break;
			case "getMeetingStatusDialog":
				$.ajax({ type: "GET", url: "/", data: 'path=apps/patients/modules/meetings&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
					$("#modalDialog").html(html);
					$("#modalDialog").dialog('option', 'position', offset);
					$("#modalDialog").dialog('option', 'title', title);
					$("#modalDialog").dialog('open');
					}
				});
			break;
			case "getDocumentsDialog":
				var id = $("#patients").data("second");
				$.ajax({ type: "GET", url: "/", data: 'path=apps/patients/modules/documents&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql+'&id=' + id, success: function(html){
					$("#modalDialog").html(html);
					$("#modalDialog").dialog('option', 'position', offset);
					$("#modalDialog").dialog('option', 'title', title);
					$("#modalDialog").dialog('open');
					}
				});
			break;
			case "getPatientsDialog":
			var id = $("#patients").data("second");
				$.ajax({ type: "GET", url: "/", data: 'path=apps/patients/modules/meetings&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
					$("#modalDialog").html(html);
					$("#modalDialog").dialog('option', 'position', offset);
					$("#modalDialog").dialog('option', 'title', title);
					$("#modalDialog").dialog('open');
					}
				});
			break;
			default:
			$.ajax({ type: "GET", url: "/", data: 'path=apps/patients&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
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


this.addPatientLink = function(id) {
		var pid = $("#patients").data("second");
		var phid = $("#patients").data("third");
		$("#modalDialog").dialog("close");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/patients/modules/meetings&request=copyMeeting&id=" + id + "&pid=" + id + "&phid=" + phid, success: function(data){
			if($("#patientsmeetingscopies").html() != "") {
				$("#patientsmeetingscopies").append(", ");
			}
			$("#patientsmeetingscopies").append(data.titlelink);
			$.prompt(ALERT_SUCCESS_COPY_MEETING + '"'+data.title+'"');
			}
		});
		$.ajax({ type: "GET", url: "/", data: "path=apps/patients&request=saveLastUsedPatients&id="+id});
	}

	this.insertStatus = function(rel,text) {
		var module = this;
		var html = '<div class="listmember" field="patientsmeeting_status" uid="'+rel+'" style="float: left">' + text + '</div>';
		$("#patientsmeeting_status").html(html);
		$("#modalDialog").dialog("close");
		$("#patientsmeeting_status").next().val("");
		$('#patients .coform').ajaxSubmit(module.poformOptions);
	}


	this.insertStatusDate = function(rel,text) {
		var html = '<div class="listmember" field="patientsmeeting_status" uid="'+rel+'" style="float: left">' + text + '</div>';
		$("#patientsmeeting_status").html(html);
		$("#modalDialog").dialog("close");
		$("#patientsmeeting_status").nextAll('img').trigger('click');
	}


	this.newItem = function() {
		var mid = $("#patients").data("third");
		var num = parseInt($("#patients-right .task_sort").size());
		$.ajax({ type: "GET", url: "/", data: "path=apps/patients/modules/meetings&request=addTask&mid=" + mid + "&num=" + num + "&sort=" + num, success: function(html){
			$('#patientsmeetingtasks').append(html);
			var idx = parseInt($('.cbx').size() -1);
			var element = $('.cbx:eq('+idx+')');
			$.jNice.CheckAddPO(element);
			$('.meetingouter:eq('+idx+')').slideDown(function() {
				$(this).find(":text:eq(0)").focus();
				if(idx == 6) {
				$('#patients-right .addTaskTable').clone().insertAfter('#phasetasks');
				}
				initPatientsContentScrollbar();
			});
			}
		});
	}


	this.actionSortItems = function(order) {
		$.ajax({ type: "GET", url: "/", data: "path=apps/patients/modules/meetings&request=sortItems&"+ order, cache: false, success: function(data){
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
				$.ajax({ type: "GET", url: "/", data: "path=apps/patients/modules/meetings&request=deleteTask&id=" + id, success: function(data){
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
		var url = "/?path=apps/patients/modules/meetings&request=getHelp";
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/patients/modules/meetings&request=deleteMeeting&id=" + id, cache: false, success: function(data){
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/patients/modules/meetings&request=restoreMeeting&id=" + id, cache: false, success: function(data){
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/patients/modules/meetings&request=deleteMeetingTask&id=" + id, cache: false, success: function(data){
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/patients/modules/meetings&request=restoreMeetingTask&id=" + id, cache: false, success: function(data){
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
		var pid = $('#patients').data('third');
		switch(action) {
			case 'new':
				$.ajax({ type: "GET", url: "/", data: "path=apps/patients/modules/meetings&request=newCheckpoint&id=" + pid + "&date=" + date, cache: false });
			break;
			case 'update':
				$.ajax({ type: "GET", url: "/", data: "path=apps/patients/modules/meetings&request=updateCheckpoint&id=" + pid + "&date=" + date, cache: false });			
			break;
			case 'delete':
				$.ajax({ type: "GET", url: "/", data: "path=apps/patients/modules/meetings&request=deleteCheckpoint&id=" + pid, cache: false });
			break;
		}
	}
	
	this.saveCheckpointText = function() {
		var pid = $('#patients').data('third');
		var text = $('#patients_meetingsCheckpoint textarea').val();
		$.ajax({ type: "POST", url: "/", data: "path=apps/patients/modules/meetings&request=updateCheckpointText&id=" + pid + "&text=" + text, cache: false });
	}
	
}

var patients_meetings = new patientsMeetings('patients_meetings');