/* meetings Object */
function brainstormsMeetings(name) {
	this.name = name;


	this.formProcess = function(formData, form, poformOptions) {
		var title = $("#brainstorms input.title").fieldValue();
		if(title == "") {
			$.prompt(ALERT_NO_TITLE, {callback: setTitleFocus});
			return false;
		} else {
			formData[formData.length] = { "name": "title", "value": title };
		}
		
		$("#brainstormsmeetingtasks > div").each(function() {
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
		formData[formData.length] = processListApps('meeting_status');
	 }
	 
	 
	 this.formResponse = function(data) {
		 switch(data.action) {
			case "edit":
				$("#brainstorms3 span[rel='"+data.id+"'] .text").html($("#brainstorms .item_date").val() + ' - ' +$("#brainstorms .title").val());
					switch(data.access) {
						case "0":
							$("#brainstorms3 .active-link .module-access-status").removeClass("module-access-active");
						break;
						case "1":
							$("#brainstorms3 .active-link .module-access-status").addClass("module-access-active");
						break;
					}
					switch(data.status) {
						case "1":
							$("#brainstorms3 .active-link .module-item-status").addClass("module-item-active");
						break;
						default:
							$("#brainstorms3 .active-link .module-item-status").removeClass("module-item-active");
					}
			break;
			case "reload":
				var module = getCurrentModule();
				var id = $("#brainstorms2 .module-click:visible").attr("rel");
				$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/brainstorms/modules/meetings&request=getList&id="+id, success: function(list){
					$(".brainstorms3-content:visible ul").html(list.html);
					var moduleidx = $(".brainstorms3-content").index($(".brainstorms3-content:visible"));
					var liindex = $(".brainstorms3-content:visible .module-click").index($(".brainstorms3-content:visible .module-click[rel='"+data.id+"']"));
					module.getDetails(moduleidx,liindex);
					$("#brainstorms3 .brainstorms3-content:visible .module-click:eq("+liindex+")").addClass('active-link');
					}
				});
			break;
		}
	}
	
	
	this.poformOptions = { beforeSubmit: this.formProcess, dataType: 'json', success: this.formResponse };


	this.getDetails = function(moduleidx,liindex,list) {
		var id = $("#brainstorms3 ul:eq("+moduleidx+") .module-click:eq("+liindex+")").attr("rel");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/brainstorms/modules/meetings&request=getDetails&id="+id, success: function(data){
			$("#brainstorms-right").html(data.html);
			
			if($('#checkedOut').length > 0) {
					$("#brainstorms3 .active-link:visible .icon-checked-out").addClass('icon-checked-out-active');
				} else {
					$("#brainstorms3 .active-link:visible .icon-checked-out").removeClass('icon-checked-out-active');
				}
			
			if(list == 0) {
				switch (data.access) {
					case "sysadmin": case "admin":
						brainstormsActions(0);
					break;
					case "guest":
						brainstormsActions(5);
					break;
				}
			} else {
				switch (data.access) {
					case "sysadmin": case "admin" :
						if(list == "<li></li>") {
							brainstormsActions(3);
						} else {
							brainstormsActions(0);
							$('#brainstorms3').find('input.filter').quicksearch('#brainstorms3 li');
						}
					break;
					case "guest":
						if(list == "<li></li>") {
							brainstormsActions();
						} else {
							brainstormsActions(5);
							$('#brainstorms3').find('input.filter').quicksearch('#brainstorms3 li');
						}
					break;
				}
				
			}
			initBrainstormsContentScrollbar();
			}
		});	
	}


	this.actionNew = function() {
		var module = this;
		var cid = $('#brainstorms input[name="id"]').val()
		module.checkIn(cid);
	
		var id = $('#brainstorms2 .module-click:visible').attr("rel");
		$.ajax({ type: "GET", url: "/", dataType: 'json', data: 'path=apps/brainstorms/modules/meetings&request=createNew&id=' + id, cache: false, success: function(data){
			$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/brainstorms/modules/meetings&request=getList&id="+id, success: function(list){
				$(".brainstorms3-content:visible ul").html(list.html);
				var liindex = $(".brainstorms3-content:visible .module-click").index($(".brainstorms3-content:visible .module-click[rel='"+data.id+"']"));
				$(".brainstorms3-content:visible .module-click:eq("+liindex+")").addClass('active-link');
				var moduleidx = $(".brainstorms3-content").index($(".brainstorms3-content:visible"));
				module.getDetails(moduleidx,liindex);
				$('#brainstorms3 input.filter').quicksearch('#brainstorms3 li');
				}
			});
			}
		});
	}


	this.actionDuplicate = function() {
		var module = this;
		var cid = $('#brainstorms input[name="id"]').val()
		module.checkIn(cid);
		var id = $("#brainstorms3 .active-link:visible").attr("rel");
		var pid = $("#brainstorms2 .module-click:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", data: 'path=apps/brainstorms/modules/meetings&request=createDuplicate&id=' + id, cache: false, success: function(mid){
			$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/brainstorms/modules/meetings&request=getList&id="+pid, success: function(data){																																																																				
				$(".brainstorms3-content:visible ul").html(data.html);
				var moduleidx = $(".brainstorms3-content").index($(".brainstorms3-content:visible"));
				var liindex = $(".brainstorms3-content:visible .module-click").index($(".brainstorms3-content:visible .module-click[rel='"+mid+"']"));
				module.getDetails(moduleidx,liindex);
				$(".brainstorms3-content:visible .module-click:eq("+liindex+")").addClass('active-link');
				$('#brainstorms3 input.filter').quicksearch('#brainstorms3 li');
				}
			});
			}
		});
	}
	
	
	this.actionBin = function() {
		var module = this;
		var cid = $('#brainstorms input[name="id"]').val()
		module.checkIn(cid);
		var txt = ALERT_DELETE;
		var langbuttons = {};
		langbuttons[ALERT_YES] = true;
		langbuttons[ALERT_NO] = false;
		$.prompt(txt,{ 
			buttons:langbuttons,
			callback: function(v,m,f){		
				if(v){
					var id = $("#brainstorms3 .active-link:visible").attr("rel");
					var pid = $("#brainstorms2 .module-click:visible").attr("rel");
					$.ajax({ type: "GET", url: "/", data: "path=apps/brainstorms/modules/meetings&request=binMeeting&id=" + id, cache: false, success: function(data){
							if(data == "true") {
								$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/brainstorms/modules/meetings&request=getList&id="+pid, success: function(data){
									$(".brainstorms3-content:visible ul").html(data.html);
									if(data.html == "<li></li>") {
										brainstormsActions(3);
									} else {
										brainstormsActions(0);
										$('#brainstorms3 input.filter').quicksearch('#brainstorms3 li');
									}
									var moduleidx = $(".brainstorms3-content").index($(".brainstorms3-content:visible"));
									var liindex = 0;
									module.getDetails(moduleidx,liindex);
									$("#brainstorms3 .brainstorms3-content:visible .module-click:eq("+liindex+")").addClass('active-link');
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
		$.ajax({ type: "GET", url: "/", async: false, data: 'path=apps/brainstorms/modules/meetings&request=checkinMeeting&id='+id, success: function(data){
			if(!data) {
				prompt("something wrong");
			}
			}
		});
	}
	
	
	this.actionRefresh = function() {
		var id = $("#brainstorms3 .active-link:visible").attr("rel");
		var pid = $("#brainstorms2 .module-click:visible").attr("rel");
		$("#brainstorms3 .active-link:visible").trigger("click");
		var id = $("#brainstorms3 .active-link:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/brainstorms/modules/meetings&request=getList&id="+pid, success: function(data){																																																																				
			$(".brainstorms3-content:visible ul").html(data.html);
			var liindex = $(".brainstorms3-content:visible .module-click").index($(".brainstorms3-content:visible .module-click[rel='"+id+"']"));
			$(".brainstorms3-content:visible .module-click:eq("+liindex+")").addClass('active-link');
			$('#brainstorms3 input.filter').quicksearch('#brainstorms3 li');
			}
		});
	}


	this.actionPrint = function() {
		var id = $("#brainstorms3 .active-link:visible").attr("rel");
		var url ='/?path=apps/brainstorms/modules/meetings&request=printDetails&id='+id;
		location.href = url;
	}


	this.actionSend = function() {
		var id = $("#brainstorms3 .active-link:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", data: "path=apps/brainstorms/modules/meetings&request=getSend&id="+id, success: function(html){
			$("#modalDialogForward").html(html).dialog('open');
			}
		});
	}


	this.actionSendtoResponse = function() {
		var id = $("#brainstorms3 .active-link:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", data: "path=apps/brainstorms/modules/meetings&request=getSendtoDetails&id="+id, success: function(html){
			$("#brainstormsmeeting_sendto").html(html);
			$("#modalDialogForward").dialog('close');
			}
		});
	}
	
	
	this.sortclick = function (obj,sortcur,sortnew) {
		var module = this;
		var cid = $('#brainstorms input[name="id"]').val()
		module.checkIn(cid);
		
		var fid = $("#brainstorms2 .module-click:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/brainstorms/modules/meetings&request=getList&id="+fid+"&sort="+sortnew, success: function(data){
			$(".brainstorms3-content:visible ul").html(data.html);
			obj.attr("rel",sortnew);
			obj.removeClass("sort"+sortcur).addClass("sort"+sortnew);
			var id = $(".brainstorms3-content:visible .module-click:eq(0)").attr("rel");
			if(id == undefined) {
				return false;
			}
			var moduleidx = $(".brainstorms3-content").index($(".brainstorms3-content:visible"));
			var liindex = 0;
			module.getDetails(moduleidx,liindex);
			$("#brainstorms3 .brainstorms3-content:visible .module-click:eq("+liindex+")").addClass('active-link');
		}
		});
	}


	this.sortdrag = function (order) {
		var fid = $("#brainstorms2 .module-click:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", data: "path=apps/brainstorms/modules/meetings&request=setOrder&"+order+"&id="+fid, success: function(html){
			$("#brainstorms3 .sort:visible").attr("rel", "3");
			$("#brainstorms3 .sort:visible").removeClass("sort1").removeClass("sort2").addClass("sort3");
			}
		});
	}


	/*this.toggleIntern = function(id,status,obj) {
		$.ajax({ type: "GET", url: "/", data: "path=apps/brainstorms/modules/meetings&request=toggleIntern&id=" + id + "&status=" + status, cache: false, success: function(data){
			if(data == "true") {
				obj.toggleClass("module-item-active")
			}
			}
		});
	}*/
	
	this.actionDialog = function(offset,request,field,append,title,sql) {
		switch(request) {
			case "getAccessDialog":
				$.ajax({ type: "GET", url: "/", data: 'path=apps/brainstorms&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
					$("#modalDialog").html(html);
					//$("#modalDialog").dialog('option', 'height', 50);
					$("#modalDialog").dialog('option', 'position', offset);
					$("#modalDialog").dialog('option', 'title', title);
					$("#modalDialog").dialog('open');
					}
				});
			break;
			case "getMeetingStatusDialog":
				$.ajax({ type: "GET", url: "/", data: 'path=apps/brainstorms/modules/meetings&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
					$("#modalDialog").html(html);
					$("#modalDialog").dialog('option', 'position', offset);
					$("#modalDialog").dialog('option', 'title', title);
					$("#modalDialog").dialog('open');
					}
				});
			break;
			case "getDocumentsDialog":
				var id = $("#brainstorms2 .module-click:visible").attr("rel");
				$.ajax({ type: "GET", url: "/", data: 'path=apps/brainstorms/modules/documents&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql+'&id=' + id, success: function(html){
					$("#modalDialog").html(html);
					$("#modalDialog").dialog('option', 'position', offset);
					$("#modalDialog").dialog('option', 'title', title);
					$("#modalDialog").dialog('open');
					}
				});
			break;
			default:
			$.ajax({ type: "GET", url: "/", data: 'path=apps/brainstorms&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
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


	this.insertStatus = function(rel,text) {
		var module = this;
		var html = '<div class="listmember" field="brainstormsmeeting_status" uid="'+rel+'" style="float: left">' + text + '</div>';
		$("#brainstormsmeeting_status").html(html);
		$("#modalDialog").dialog("close");
		$("#brainstormsmeeting_status").next().val("");
		$('#brainstorms .coform').ajaxSubmit(module.poformOptions);
	}


	this.insertStatusDate = function(rel,text) {
		var html = '<div class="listmember" field="brainstormsmeeting_status" uid="'+rel+'" style="float: left">' + text + '</div>';
		$("#brainstormsmeeting_status").html(html);
		$("#modalDialog").dialog("close");
		$("#brainstormsmeeting_status").nextAll('img').trigger('click');
	}


	this.newItem = function() {
		var mid = $(".brainstorms3-content:visible .active-link").attr("rel");
		var num = parseInt($("#brainstorms-right .task_sort").size());
		$.ajax({ type: "GET", url: "/", data: "path=apps/brainstorms/modules/meetings&request=addTask&mid=" + mid + "&num=" + num + "&sort=" + num, success: function(html){
			$('#brainstormsmeetingtasks').append(html);
			var idx = parseInt($('.cbx').size() -1);
			var element = $('.cbx:eq('+idx+')');
			$.jNice.CheckAddPO(element);
			$('.meetingouter:eq('+idx+')').slideDown(function() {
				$(this).find(":text:eq(0)").focus();
				if(idx == 6) {
				$('#brainstorms-right .addTaskTable').clone().insertAfter('#phasetasks');
				}
				initBrainstormsContentScrollbar();
			});
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
				$.ajax({ type: "GET", url: "/", data: "path=apps/brainstorms/modules/meetings&request=deleteTask&id=" + id, success: function(data){
					if(data){
						$("#task_"+id).slideUp(function(){ $(this).remove(); });
					} 
					}
				});
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/brainstorms/modules/meetings&request=deleteMeeting&id=" + id, cache: false, success: function(data){
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/brainstorms/modules/meetings&request=restoreMeeting&id=" + id, cache: false, success: function(data){
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/brainstorms/modules/meetings&request=deleteMeetingTask&id=" + id, cache: false, success: function(data){
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/brainstorms/modules/meetings&request=restoreMeetingTask&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#meeting_task_'+id).slideUp();
						}
					}
					});
				} 
			}
		});
	}

}


var brainstorms_meetings = new brainstormsMeetings('brainstorms_meetings');