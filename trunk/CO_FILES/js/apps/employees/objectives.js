/* objectives Object */
function employeesObjectives(name) {
	this.name = name;


	this.formProcess = function(formData, form, poformOptions) {
		var title = $("#employees input.title").fieldValue();
		if(title == "") {
			$.prompt(ALERT_NO_TITLE, {callback: setTitleFocus});
			return false;
		} else {
			formData[formData.length] = { "name": "title", "value": title };
		}
		
		$("#employeesobjectivetasks > div").each(function() {
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
		formData[formData.length] = processStringApps('objectivestart');
		formData[formData.length] = processStringApps('objectiveend');
		formData[formData.length] = processListApps('objective_relates_to');
		//formData[formData.length] = processDocListApps('documents');
		formData[formData.length] = processListApps('objective_access');
		//formData[formData.length] = processListApps('objective_status');
	 }
	 
	 
	 this.formResponse = function(data) {
		$("#employees3 ul[rel=objectives] span[rel="+data.id+"] .text").html($("#employees .item_date").val() + ' - ' +$("#employees .title").val());
		switch(data.access) {
			case "0":
				$("#employees3 ul[rel=objectives] span[rel="+data.id+"] .module-access-status").removeClass("module-access-active");
			break;
			case "1":
				$("#employees3 ul[rel=objectives] span[rel="+data.id+"] .module-access-status").addClass("module-access-active");
			break;
		}
	}
	
	
	this.poformOptions = { async: false, beforeSubmit: this.formProcess, dataType: 'json', success: this.formResponse };


	this.statusOnClose = function(dp) {
		var id = $("#employees").data("third");
		var status = $("#employees .statusTabs li span.active").attr('rel');
		var date = $("#employees .statusTabs input").val();
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/employees/modules/objectives&request=updateStatus&id=" + id + "&date=" + date + "&status=" + status, cache: false, success: function(data){
			switch(data.action) {
				case "edit":
					switch(data.status) {
						case "1":
							$("#employees3 ul[rel=objectives] span[rel="+data.id+"] .module-item-status").addClass("module-item-active").removeClass("module-item-active-stopped");
						break;
						case "2":
							$("#employees3 ul[rel=objectives] span[rel="+data.id+"] .module-item-status").addClass("module-item-active-stopped").removeClass("module-item-active");
						break;
						default:
							$("#employees3 ul[rel=objectives] span[rel="+data.id+"] .module-item-status").removeClass("module-item-active").removeClass("module-item-active-stopped");
					}
				break;
				case "reload":
					var module = getCurrentModule();
					var id = $('#employees').data('second');
					$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/employees/modules/objectives&request=getList&id="+id, success: function(list){
						$('#employees3 ul[rel=objectives]').html(list.html);
						$('#employees_objectives_items').html(list.items);
						var moduleidx = $("#employees3 ul").index($("#employees3 ul[rel=objectives]"));
						var liindex = $("#employees3 ul[rel=objectives] .module-click").index($("#employees3 ul[rel=objectives] .module-click[rel='"+data.id+"']"));
						module.getDetails(moduleidx,liindex);
						$("#employees3 ul[rel=objectives] .module-click:eq("+liindex+")").addClass('active-link');
						}
					});
				break;																																														  				}
			}
		});
	}


	this.getDetails = function(moduleidx,liindex,list) {
		var id = $("#employees3 ul:eq("+moduleidx+") .module-click:eq("+liindex+")").attr("rel");
		$('#employees').data({ "third" : id});
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/employees/modules/objectives&request=getDetails&id="+id, success: function(data){
			$("#employees-right").html(data.html);
			
			if($('#checkedOut').length > 0) {
					$("#employees3 ul[rel=objectives] .active-link .icon-checked-out").addClass('icon-checked-out-active');
				} else {
					$("#employees3 ul[rel=objectives] .active-link .icon-checked-out").removeClass('icon-checked-out-active');
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
		$.ajax({ type: "GET", url: "/", dataType: 'json', data: 'path=apps/employees/modules/objectives&request=createNew&id=' + id, cache: false, success: function(data){
			$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/employees/modules/objectives&request=getList&id="+id, success: function(list){
				$("#employees3 ul[rel=objectives]").html(list.html);
				$('#employees_objectives_items').html(list.items);
				var liindex = $("#employees3 ul[rel=objectives] .module-click").index($("#employees3 ul[rel=objectives] .module-click[rel='"+data.id+"']"));
				$("#employees3 ul[rel=objectives] .module-click:eq("+liindex+")").addClass('active-link');
				var moduleidx = $("#employees3 ul").index($("#employees3 ul[rel=objectives]"));
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
		$.ajax({ type: "GET", url: "/", data: 'path=apps/employees/modules/objectives&request=createDuplicate&id=' + id, cache: false, success: function(mid){
			$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/employees/modules/objectives&request=getList&id="+pid, success: function(data){																																																																				
				$("#employees3 ul[rel=objectives]").html(data.html);
				$('#employees_objectives_items').html(data.items);
				var moduleidx = $("#employees3 ul").index($("#employees3 ul[rel=objectives]"));
				var liindex = $("#employees3 ul[rel=objectives] .module-click").index($("#employees3 ul[rel=objectives] .module-click[rel='"+mid+"']"));
				module.getDetails(moduleidx,liindex);
				$("#employees3 ul[rel=objectives] .module-click:eq("+liindex+")").addClass('active-link');
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/employees/modules/objectives&request=binObjective&id=" + id, cache: false, success: function(data){
							if(data == "true") {
								$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/employees/modules/objectives&request=getList&id="+pid, success: function(data){
									$("#employees3 ul[rel=objectives]").html(data.html);
									$('#employees_objectives_items').html(data.items);
									if(data.html == "<li></li>") {
										employeesActions(3);
									} else {
										employeesActions(0);
									}
									var moduleidx = $("#employees3 ul").index($("#employees3 ul[rel=objectives]"));
									var liindex = 0;
									module.getDetails(moduleidx,liindex);
									$("#employees3 ul[rel=objectives] .module-click:eq("+liindex+")").addClass('active-link');
									}
								});
							}
						}
					});
				} 
			}
		});
	}


	this.actionLoadTab = function(what) {
		//var what = $(this).attr('rel');
		$('#EmployeesObjectivesTabsContent > div:visible').hide();
		$('#'+what).show();
		$('.elastic').elastic(); // need to init again
		initEmployeesContentScrollbar();
	}


	this.checkIn = function(id) {
		$.ajax({ type: "GET", url: "/", async: false, data: 'path=apps/employees/modules/objectives&request=checkinObjective&id='+id, success: function(data){
			if(!data) {
				prompt("something wrong");
			}
			}
		});
	}
	
	
	this.actionRefresh = function() {
		var id = $("#employees").data("third");
		var pid = $("#employees").data("second");
		$("#employees3 ul[rel=objectives] .active-link").trigger("click");
		$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/employees/modules/objectives&request=getList&id="+pid, success: function(data){																																																																				
			$("#employees3 ul[rel=objectives]").html(data.html);
			$('#employees_objectives_items').html(data.items);
			var liindex = $("#employees3 ul[rel=objectives] .module-click").index($("#employees3 ul[rel=objectives] .module-click[rel='"+id+"']"));
			$("#employees3 ul[rel=objectives] .module-click:eq("+liindex+")").addClass('active-link');
			}
		});
	}


	this.actionPrint = function() {
		var id = $("#employees").data("third");
		var url ='/?path=apps/employees/modules/objectives&request=printDetails&id='+id;
		$("#documentloader").attr('src', url);
	}


	this.actionSend = function() {
		var id = $("#employees").data("third");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/employees/modules/objectives&request=getSend&id="+id, success: function(data){
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
		$.ajax({ type: "GET", url: "/", data: "path=apps/employees/modules/objectives&request=getSendtoDetails&id="+id, success: function(html){
			$("#employeesobjective_sendto").html(html);
			//$("#modalDialogForward").dialog('close');
			}
		});
	}
	
	
	this.sortclick = function (obj,sortcur,sortnew) {
		var module = this;
		var cid = $('#employees input[name="id"]').val()
		module.checkIn(cid);
		
		var fid = $("#employees2 .module-click:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/employees/modules/objectives&request=getList&id="+fid+"&sort="+sortnew, success: function(data){
			$("#employees3 ul[rel=objectives]").html(data.html);
			$('#employees_objectives_items').html(data.items);
			obj.attr("rel",sortnew);
			obj.removeClass("sort"+sortcur).addClass("sort"+sortnew);
			var id = $("#employees3 ul[rel=objectives] .module-click:eq(0)").attr("rel");
			$('#employees').data('third',id);
			if(id == undefined) {
				return false;
			}
			var moduleidx = $("#employees3 ul").index($("#employees3 ul[rel=objectives]"));
			module.getDetails(moduleidx,0);
			$("#employees3 ul[rel=objectives] .module-click:eq(0)").addClass('active-link');
		}
		});
	}


	this.sortdrag = function (order) {
		var fid = $("#employees").data("second");
		$.ajax({ type: "GET", url: "/", data: "path=apps/employees/modules/objectives&request=setOrder&"+order+"&id="+fid, success: function(html){
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
			case "getObjectiveStatusDialog":
				$.ajax({ type: "GET", url: "/", data: 'path=apps/employees/modules/objectives&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
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


	this.insertStatus = function(rel,text) {
		var module = this;
		var html = '<div class="listmember" field="employeesobjective_status" uid="'+rel+'" style="float: left">' + text + '</div>';
		$("#employeesobjective_status").html(html);
		$("#modalDialog").dialog("close");
		$("#employeesobjective_status").next().val("");
		$('#employees .coform').ajaxSubmit(module.poformOptions);
	}


	this.insertStatusDate = function(rel,text) {
		var html = '<div class="listmember" field="employeesobjective_status" uid="'+rel+'" style="float: left">' + text + '</div>';
		$("#employeesobjective_status").html(html);
		$("#modalDialog").dialog("close");
		$("#employeesobjective_status").nextAll('img').trigger('click');
	}


	this.newItem = function() {
		var module = this;
		var mid = $("#employees").data("third");
		var num = parseInt($("#employees-right .task_sort").size());
		$.ajax({ type: "GET", url: "/", data: "path=apps/employees/modules/objectives&request=addTask&mid=" + mid + "&num=" + num + "&sort=" + num, success: function(html){
			$('#employeesobjectivetasks').append(html);
			var idx = parseInt($('.cbx').size() -1);
			//var element = $('.cbx:eq('+idx+')');
			//$.jNice.CheckAddPO(element);
			$('.objectiveouter:eq('+idx+')').slideDown(function() {
				$(this).find(":text:eq(0)").focus();
				/*if(idx == 6) {
				$('#employees-right .addTaskTable').clone().insertAfter('#phasetasks');
				}*/
				initEmployeesContentScrollbar();
				 module.calculateTasks();
			});
			}
		});
	}


	this.binItem = function(id) {
		var module = this;
		var txt = ALERT_DELETE;
		var langbuttons = {};
		langbuttons[ALERT_YES] = true;
		langbuttons[ALERT_NO] = false;
		$.prompt(txt,{ 
			buttons:langbuttons,
			callback: function(v,m,f){		
				if(v){
				$.ajax({ type: "GET", url: "/", data: "path=apps/employees/modules/objectives&request=deleteTask&id=" + id, success: function(data){
					if(data){
						$("#task_"+id).slideUp(function(){ $(this).remove(); module.calculateTasks(); });
						
					} 
					}
				});
				} 
			}
		});
	}
	
	this.actionHelp = function() {
		var url = "/?path=apps/employees/modules/objectives&request=getHelp";
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/employees/modules/objectives&request=deleteObjective&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#objective_'+id).slideUp();
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/employees/modules/objectives&request=restoreObjective&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#objective_'+id).slideUp();
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/employees/modules/objectives&request=deleteObjectiveTask&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#objective_task_'+id).slideUp();
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/employees/modules/objectives&request=restoreObjectiveTask&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#objective_task_'+id).slideUp();
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
				$.ajax({ type: "GET", url: "/", data: "path=apps/employees/modules/objectives&request=newCheckpoint&id=" + pid + "&date=" + date, cache: false });
			break;
			case 'update':
				$.ajax({ type: "GET", url: "/", data: "path=apps/employees/modules/objectives&request=updateCheckpoint&id=" + pid + "&date=" + date, cache: false });			
			break;
			case 'delete':
				$.ajax({ type: "GET", url: "/", data: "path=apps/employees/modules/objectives&request=deleteCheckpoint&id=" + pid, cache: false });
			break;
		}
	}
	
	this.saveCheckpointText = function() {
		var pid = $('#employees').data('third');
		var text = $('#employees_objectivesCheckpoint textarea').val();
		$.ajax({ type: "POST", url: "/", data: "path=apps/employees/modules/objectives&request=updateCheckpointText&id=" + pid + "&text=" + text, cache: false });
	}
	
	this.calculateTasks = function() {
		var total = 0;
		var num = $('#EmployeesObjectivesThird .answers-outer-dynamic').size()*10;
		$('#EmployeesObjectivesThird .answers-outer-dynamic span').each( function() {
			 if($(this).hasClass('active'))	{
				 total = total + parseInt($(this).html());
			 }
		})
		if(num != 0) {
			var res = Math.round(100/num*total);
		}
		$('#tab3result').html(res);
	}
	
}

var employees_objectives = new employeesObjectives('employees_objectives');

$(document).ready(function() {				   
	$('#employees').on('click', '.answers-outer span',function(e) {
		e.preventDefault();
		var tab = $(this).parent().attr('rel');
		var q = $(this).attr('rel');
		var val = $(this).html();
		$(this).siblings().removeClass('active');
		$(this).addClass('active');
		var total = 0;
		if(tab == 'tab1') {
			$('#EmployeesObjectivesFirst .answers-outer span').each( function() {
			 if($(this).hasClass('active'))	{
				 total = total + parseInt($(this).html());
			 }
		})
			var res = Math.round(100/50*total);
		} else {
			$('#EmployeesObjectivesSecond .answers-outer span').each( function() {
			 if($(this).hasClass('active'))	{
				 total = total + parseInt($(this).html());
			 }
		})
			var res = total;
		}
		$('#'+tab+'result').html(res);
		// ajax call
		var pid = $('#employees').data('third');
		var field = tab+q;
		$.ajax({ type: "GET", url: "/", data: "path=apps/employees/modules/objectives&request=updateQuestion&id=" + pid + "&field=" + field + "&val=" + val, cache: false });
		
	});
	
	
	$('#employees').on('click', '.answers-outer-dynamic span',function(e) {
		e.preventDefault();
		var id = $(this).attr('rel');
		var val = $(this).html();
		$(this).siblings().removeClass('active');
		$(this).addClass('active');
		employees_objectives.calculateTasks();
		// ajax call
		$.ajax({ type: "GET", url: "/", data: "path=apps/employees/modules/objectives&request=updateTaskQuestion&id=" + id + "&val=" + val, cache: false });
		
	});
	
});	