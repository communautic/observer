/* meetings Object */
function Meetings(app) {
	this.name = app +'_meetings';
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
		$('#'+ app +'meetingtasks > div').each(function() {
			var id = $(this).attr('id');
			var reg = /[0-9]+/.exec(id);
			var yo = "task_text_"+reg;
			var namen = "task_text["+reg+"]";
			if($('#task_'+reg+' :input[name="task_text_'+reg+'"]').length > 0) {
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
	 }
	 
	 
	 this.formResponse = function(data) {
		 var app = getCurrentApp();
		$("#"+ app +"3 ul[rel=meetings] span[rel="+data.id+"] .text").html($("#"+ app +" .item_date").val() +' - '+$("#"+ app +" .title").val());
		switch(data.access) {
			case "0":
				$("#"+ app +"3 ul[rel=meetings] span[rel="+data.id+"] .module-access-status").removeClass("module-access-active");
			break;
			case "1":
				$("#"+ app +"3 ul[rel=meetings] span[rel="+data.id+"] .module-access-status").addClass("module-access-active");
			break;
		}	
	}


	this.poformOptions = { async: false, beforeSubmit: this.formProcess, dataType: 'json', success: this.formResponse };


	this.statusOnClose = function(dp) {
		var app = getCurrentApp();
		var id = $("#"+ app).data("third");
		var status = $("#"+ app +" .statusTabs li span.active").attr('rel');
		var date = $("#"+ app +" .statusTabs input").val();
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/"+ app +"/modules/meetings&request=updateStatus&id="+ id +"&date="+ date +"&status="+ status, cache: false, success: function(data){
			switch(data.action) {
				case "edit":
					switch(data.status) {
						case "1":
							$("#"+ app +"3 ul[rel=meetings] span[rel="+data.id+"] .module-item-status").addClass("module-item-active").removeClass("module-item-active-stopped");
						break;
						case "2":
							$("#"+ app +"3 ul[rel=meetings] span[rel="+data.id+"] .module-item-status").addClass("module-item-active-stopped").removeClass("module-item-active");
						break;
						default:
							$("#"+ app +"3 ul[rel=meetings] span[rel="+data.id+"] .module-item-status").removeClass("module-item-active").removeClass("module-item-active-stopped");
					}
				break;
				case "reload":
					var module = getCurrentModule();
					var id = $('#'+ app).data('second');
					$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/"+app+"/modules/meetings&request=getList&id="+id, success: function(list){
						$('#'+app+'3 ul[rel=meetings]').html(list.html);
						$('#'+app+'_meetings_items').html(list.items);
						var moduleidx = $("#"+app+"3 ul").index($("#"+app+"3 ul[rel=meetings]"));
						var liindex = $("#"+app+"3 ul[rel=meetings] .module-click").index($("#"+app+"3 ul[rel=meetings] .module-click[rel='"+data.id+"']"));
						module.getDetails(moduleidx,liindex);
						$("#"+app+"3 ul[rel=meetings] .module-click:eq("+liindex+")").addClass('active-link');
						}
					});
				break;																																														  				}
			}
		});
	}


	this.getDetails = function(moduleidx,liindex,list) {
		var module = this;
		var id = $("#"+ module.app +"3 ul:eq("+moduleidx+") .module-click:eq("+liindex+")").attr("rel");
		$('#'+ module.app).data({ "third" : id});
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/"+ module.app +"/modules/meetings&request=getDetails&id="+id, success: function(data){
			$("#"+ module.app +"-right").html(data.html);
			if($('#checkedOut').length > 0) {
					$("#"+ module.app +"3 ul[rel=meetings] .active-link .icon-checked-out").addClass('icon-checked-out-active');
				} else {
					$("#"+ module.app +"3 ul[rel=meetings] .active-link .icon-checked-out").removeClass('icon-checked-out-active');
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
		$.ajax({ type: "GET", url: "/", dataType: 'json', data: 'path=apps/'+ module.app +'/modules/meetings&request=createNew&id='+ id, cache: false, success: function(data){
			$.ajax({ type: "GET", url: "/", dataType: 'json', data: 'path=apps/'+ module.app +'/modules/meetings&request=getList&id='+id, success: function(list){
				$('#'+ module.app +'3 ul[rel=meetings]').html(list.html);
				$('#'+ module.app +'_meetings_items').html(list.items);
				var liindex = $('#'+ module.app +'3 ul[rel=meetings] .module-click').index($("#"+ module.app +"3 ul[rel=meetings] .module-click[rel='"+data.id+"']"));
				$('#'+ module.app +'3 ul[rel=meetings] .module-click:eq('+liindex+')').addClass('active-link');
				var moduleidx = $('#'+ module.app +'3 ul').index($('#'+ module.app +'3 ul[rel=meetings]'));
				module.getDetails(moduleidx,liindex);
				setTimeout(function() { $('#'+ module.app +'-right .focusTitle').trigger('click'); }, 800);
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
		$.ajax({ type: "GET", url: "/", data: 'path=apps/'+ module.app +'/modules/meetings&request=createDuplicate&id='+ id, cache: false, success: function(mid){
			$.ajax({ type: "GET", url: "/", dataType: 'json', data: 'path=apps/'+ module.app +'/modules/meetings&request=getList&id='+pid, success: function(data){																																																																				
				$('#'+ module.app +'3 ul[rel=meetings]').html(data.html);
				$('#'+ module.app +'_meetings_items').html(data.items);
				var moduleidx = $('#'+ module.app +'3 ul').index($('#'+ module.app +'3 ul[rel=meetings]'));
				var liindex = $('#'+ module.app +'3 ul[rel=meetings] .module-click').index($("#"+ module.app +"3 ul[rel=meetings] .module-click[rel='"+mid+"']"));
				module.getDetails(moduleidx,liindex);
				$('#'+ module.app +'3 ul[rel=meetings] .module-click:eq('+liindex+')').addClass('active-link');
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
					$.ajax({ type: "GET", url: "/", data: 'path=apps/'+ module.app +'/modules/meetings&request=binMeeting&id='+ id, cache: false, success: function(data){
							if(data == "true") {
								$.ajax({ type: "GET", url: "/", dataType:  'json', data: 'path=apps/'+ module.app +'/modules/meetings&request=getList&id='+pid, success: function(data){
									$('#'+ module.app +'3 ul[rel=meetings]').html(data.html);
									$('#'+ module.app +'_meetings_items').html(data.items);
									if(data.html == "<li></li>") {
										window[module.app +'Actions'](3);
									} else {
										window[module.app +'Actions'](0);
									}
									var moduleidx = $('#'+ module.app +'3 ul').index($('#'+ module.app +'3 ul[rel=meetings]'));
									var liindex = 0;
									module.getDetails(moduleidx,liindex);
									$('#'+ module.app +'3 ul[rel=meetings] .module-click:eq('+liindex+')').addClass('active-link');
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
		$.ajax({ type: "GET", url: "/", async: false, data: 'path=apps/'+ module.app +'/modules/meetings&request=checkinMeeting&id='+id, success: function(data){
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
		$('#'+ module.app +'3 ul[rel=meetings] .active-link').trigger("click");
		$.ajax({ type: "GET", url: "/", dataType: 'json', data: 'path=apps/'+ module.app +'/modules/meetings&request=getList&id='+pid, success: function(data){																																																																				
			$('#'+ module.app +'3 ul[rel=meetings]').html(data.html);
			$('#'+ module.app +'_meetings_items').html(data.items);
			var liindex = $('#'+ module.app +'3 ul[rel=meetings] .module-click').index($("#"+ module.app +"3 ul[rel=meetings] .module-click[rel='"+id+"']"));
			$('#'+ module.app +'3 ul[rel=meetings] .module-click:eq('+liindex+')').addClass('active-link');
			}
		});
	}


	this.actionPrint = function() {
		var module = this;
		var id = $('#'+ module.app).data("third");
		var url ='/?path=apps/'+ module.app +'/modules/meetings&request=printDetails&id='+id;
		$("#documentloader").attr('src', url);
	}


	this.actionSend = function() {
		var module = this;
		var id = $('#'+ module.app).data("third");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: 'path=apps/'+ module.app +'/modules/meetings&request=getSend&id='+id, success: function(data){
			$("#modalDialogForward").html(data.html).dialog('open');
			if(data.error == 1) {
				$.prompt('<div style="text-align: center">'+ ALERT_REMOVE_RECIPIENT + data.error_message +'<br /></div>');
				return false;
			}
			}
		});
	}


	this.actionSendtoResponse = function() {
		var module = this;
		var id = $('#'+ module.app).data("third");
		$.ajax({ type: "GET", url: "/", data: 'path=apps/'+ module.app +'/modules/meetings&request=getSendtoDetails&id='+id, success: function(html){
			$('#'+ module.app +'meeting_sendto').html(html);
			}
		});
	}


	this.sortclick = function (obj,sortcur,sortnew) {
		var module = this;
		var cid = $('#'+ module.app +' input[name="id"]').val()
		module.checkIn(cid);
		var fid = $('#'+ module.app +'2 .module-click:visible').attr("rel");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: 'path=apps/'+ module.app +'/modules/meetings&request=getList&id='+fid+'&sort='+sortnew, success: function(data){
			$('#'+ module.app +'3 ul[rel=meetings]').html(data.html);
			$('#'+ module.app +'_meetings_items').html(data.items);
			obj.attr("rel",sortnew);
			obj.removeClass("sort"+sortcur).addClass("sort"+sortnew);
			var id = $('#'+ module.app +'3 ul[rel=meetings] .module-click:eq(0)').attr("rel");
			$('#'+ module.app).data('third',id);
			if(id == undefined) {
				return false;
			}
			var moduleidx = $('#'+ module.app +'3 ul').index($('#'+ module.app +'3 ul[rel=meetings]'));
			module.getDetails(moduleidx,0);
			$('#'+ module.app +'3 ul[rel=meetings] .module-click:eq(0)').addClass('active-link');
		}
		});
	}


	this.sortdrag = function (order) {
		var module = this;
		var fid = $('#'+ module.app).data("second");
		$.ajax({ type: "GET", url: "/", data: 'path=apps/'+ module.app +'/modules/meetings&request=setOrder&'+order+'&id='+fid, success: function(html){
			$('#'+ module.app +'3 .sort:visible').attr("rel", "3");
			$('#'+ module.app +'3 .sort:visible').removeClass("sort1").removeClass("sort2").addClass("sort3");
			}
		});
	}


	this.actionDialog = function(offset,request,field,append,title,sql) {
		var module = this;
		switch(request) {
			case "getAccessDialog":
				$.ajax({ type: "GET", url: "/", data: 'path=apps/'+ module.app +'&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
					$("#modalDialog").html(html);
					$("#modalDialog").dialog('option', 'position', offset);
					$("#modalDialog").dialog('option', 'title', title);
					$("#modalDialog").dialog('open');
					}
				});
			break;
			/*case "getMeetingStatusDialog":
				$.ajax({ type: "GET", url: "/", data: 'path=apps/'+ module.app +'/modules/meetings&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
					$("#modalDialog").html(html);
					$("#modalDialog").dialog('option', 'position', offset);
					$("#modalDialog").dialog('option', 'title', title);
					$("#modalDialog").dialog('open');
					}
				});
			break;*/
			case "getDocumentsDialog":
				var id = $('#'+ module.app).data("second");
				$.ajax({ type: "GET", url: "/", data: 'path=apps/'+ module.app +'/modules/documents&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql+'&id='+ id, success: function(html){
					$("#modalDialog").html(html);
					$("#modalDialog").dialog('option', 'position', offset);
					$("#modalDialog").dialog('option', 'title', title);
					$("#modalDialog").dialog('open');
					}
				});
			break;
			case "get"+module.objectnameCaps+"Dialog":
			var id = $('#'+ module.app).data("second");
				$.ajax({ type: "GET", url: "/", data: 'path=apps/'+ module.app +'/modules/meetings&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
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
				if($("#"+ field +"_ct .ct-content").length > 0) {
					var ct = $("#"+ field +"_ct .ct-content").html();
					ct = ct.replace(CUSTOM_NOTE +" ","");
					$("#custom-text").val(ct);
				}
				}
			});
		}
	}


	this.addParentLink = function(id) {
		var module = this;
		var pid = $('#'+ module.app).data("second");
		var phid = $('#'+ module.app).data("third");
		$("#modalDialog").dialog("close");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: 'path=apps/'+ module.app +'/modules/meetings&request=copyMeeting&id='+ id +'&pid='+ id +'&phid='+ phid, success: function(data){
			if($('#'+ module.app +'meetingscopies').html() != "") {
				$('#'+ module.app +'meetingscopies').append("<br />");
			}
			$('#'+ module.app +'meetingscopies').append(data.titlelink);
			$.prompt(ALERT_SUCCESS_COPY_MEETING +'"'+data.title+'"');
			}
		});
		$.ajax({ type: "GET", url: "/", data: 'path=apps/'+ module.app +'&request=saveLastUsed'+ module.objectnameCaps +'&id='+id});
	}


	/*this.insertStatus = function(rel,text) {
		var module = this;
		var html = '<div class="listmember" field="'+ module.app +'meeting_status" uid="'+rel+'" style="float: left">'+ text +'</div>';
		$('#'+ module.app +'meeting_status').html(html);
		$("#modalDialog").dialog("close");
		$('#'+ module.app +'meeting_status').next().val("");
		$('#'+ module.app +' .coform').ajaxSubmit(module.poformOptions);
	}


	this.insertStatusDate = function(rel,text) {
		var module = this;
		var html = '<div class="listmember" field="'+ module.app +'meeting_status" uid="'+rel+'" style="float: left">'+ text +'</div>';
		$('#'+ module.app +'meeting_status').html(html);
		$("#modalDialog").dialog("close");
		$('#'+ module.app +'meeting_status').nextAll('img').trigger('click');
	}*/


	this.newItem = function() {
		var module = this;
		var mid = $('#'+ module.app).data("third");
		var num = parseInt($('#'+ module.app +'-right .task_sort').size());
		$.ajax({ type: "GET", url: "/", data: 'path=apps/'+ module.app +'/modules/meetings&request=addTask&mid='+ mid +'&num='+ num +'&sort='+ num, success: function(html){
			$('#'+ module.app +'meetingtasks').append(html);
			var idx = parseInt($('#'+ module.app +'meetingtasks .cbx').size() -1);
			var element = $('#'+ module.app +'meetingtasks .cbx:eq('+idx+')');
			$.jNice.CheckAddPO(element);
			$('#'+ module.app +'meetingtasks .meetingouter:eq('+idx+')').slideDown(function() {
				$(this).find(":text:eq(0)").focus();
				/*if(idx == 6) {
				$('#'+ module.app +'-right .addTaskTable').clone().insertAfter('#'+ module.app +'meetingtasks');
				}*/
				window['init'+module.objectnameCaps+'ContentScrollbar']();
			});
			}
		});
	}


	this.actionSortItems = function(order) {
		var module = this;
		$.ajax({ type: "GET", url: "/", data: 'path=apps/'+ module.app +'/modules/meetings&request=sortItems&'+ order, cache: false, success: function(data){
			}
		});
	}


	this.togglePost = function(id,obj) {
		var module = this;
		var outer = $('#'+ module.app +'meetingtask_'+id);
		outer.slideToggle();
		obj.find('span').toggleClass('active');
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
				$.ajax({ type: "GET", url: "/", data: 'path=apps/'+ module.app +'/modules/meetings&request=deleteTask&id='+ id, success: function(data){
					if(data){
						$("#task_"+id).slideUp(function(){ $(this).remove(); });
					}
					}
				});
				} 
			}
		});
	}


	this.manageCheckpoint = function(action,date) {
		var module = this;
		var pid = $('#'+ module.app).data('third');
		switch(action) {
			case 'new':
				$.ajax({ type: "GET", url: "/", data: 'path=apps/'+ module.app +'/modules/meetings&request=newCheckpoint&id='+ pid +'&date='+ date, cache: false });
			break;
			case 'update':
				$.ajax({ type: "GET", url: "/", data: 'path=apps/'+ module.app +'/modules/meetings&request=updateCheckpoint&id='+ pid +'&date='+ date, cache: false });			
			break;
			case 'delete':
				$.ajax({ type: "GET", url: "/", data: 'path=apps/'+ module.app +'/modules/meetings&request=deleteCheckpoint&id='+ pid, cache: false });
			break;
		}
	}


	this.saveCheckpointText = function() {
		var module = this;
		var pid = $('#'+ module.app).data('third');
		var text = $('#'+ module.app +'_meetingsCheckpoint textarea').val();
		$.ajax({ type: "POST", url: "/", data: 'path=apps/'+ module.app +'/modules/meetings&request=updateCheckpointText&id='+ pid +'&text='+ text, cache: false });
	}


	this.actionHelp = function() {
		var module = this;
		var url = '/?path=apps/'+ module.app +'/modules/meetings&request=getHelp';
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
					$.ajax({ type: "GET", url: "/", data: 'path=apps/'+ module.app +'/modules/meetings&request=deleteMeeting&id='+ id, cache: false, success: function(data){
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
		var module = this;
		var txt = ALERT_RESTORE;
		var langbuttons = {};
		langbuttons[ALERT_YES] = true;
		langbuttons[ALERT_NO] = false;
		$.prompt(txt,{ 
			buttons:langbuttons,
			submit: function(e,v,m,f){		
				if(v){
					$.ajax({ type: "GET", url: "/", data: 'path=apps/'+ module.app +'/modules/meetings&request=restoreMeeting&id='+ id, cache: false, success: function(data){
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
		var module = this;
		var txt = ALERT_DELETE_REALLY;
		var langbuttons = {};
		langbuttons[ALERT_YES] = true;
		langbuttons[ALERT_NO] = false;
		$.prompt(txt,{ 
			buttons:langbuttons,
			submit: function(e,v,m,f){		
				if(v){
					$.ajax({ type: "GET", url: "/", data: 'path=apps/'+ module.app +'/modules/meetings&request=deleteMeetingTask&id='+ id, cache: false, success: function(data){
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
		var module = this;
		var txt = ALERT_RESTORE;
		var langbuttons = {};
		langbuttons[ALERT_YES] = true;
		langbuttons[ALERT_NO] = false;
		$.prompt(txt,{ 
			buttons:langbuttons,
			submit: function(e,v,m,f){		
				if(v){
					$.ajax({ type: "GET", url: "/", data: 'path=apps/'+ module.app +'/modules/meetings&request=restoreMeetingTask&id='+ id, cache: false, success: function(data){
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