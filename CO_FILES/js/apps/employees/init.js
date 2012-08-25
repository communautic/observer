function initEmployeesContentScrollbar() {
	employeesInnerLayout.initContent('center');
}

/* employees Object */
function employeesApplication(name) {
	this.name = name;
	

	this.init = function() {
		this.$app = $('#employees');
		this.$appContent = $('#employees-right');
		this.$first = $('#employees1');
		this.$second = $('#employees2');
		this.$third = $('#employees3');
		this.$thirdDiv = $('#employees3 div.thirdLevel');
		this.$layoutWest = $('#employees div.ui-layout-west');
	}
	
	
	this.formProcess = function(formData, form, poformOptions) {
		var title = $("#employees input.title").fieldValue();
		if(title == "") {
			$.prompt(ALERT_NO_TITLE, {callback: setTitleFocus});
			return false;
		} else {
			formData[formData.length] = { "name": "title", "value": title };
		}
	
		formData[formData.length] = processListApps('folder');
		formData[formData.length] = processListApps('kind');
		formData[formData.length] = processListApps('area');
		formData[formData.length] = processListApps('department');
		formData[formData.length] = processListApps('education');
		//formData[formData.length] = processListApps('status');
	}

	
	this.formResponse = function(data) {
		switch(data.action) {
			case "edit":
				$("#employees2 span[rel='"+data.id+"'] .text").html($("#employees .title").val());
				$("#employeeDurationStart").html($("#employees-right input[name='startdate']").val());
			break;
		}
	}


	this.poformOptions = { async: false, beforeSubmit: this.formProcess, dataType: 'json', success: this.formResponse };


	this.statusOnClose = function(dp) {
		var id = $("#employees").data("second");
		var status = $("#employees .statusTabs li span.active").attr('rel');
		var date = $("#employees .statusTabs input").val();
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/employees&request=updateStatus&id=" + id + "&date=" + date + "&status=" + status, cache: false, success: function(data){
				switch(data.status) {
					case "0":
						$("#employees2 .active-link .module-item-status").addClass("module-item-active-trial").removeClass("module-item-active-maternity").removeClass("module-item-active-leave");
						$("#employeeDurationEnd").html($("#employees-right input[name='status_date']").val());
					break;
					case "2":
						$("#employees2 .active-link .module-item-status").addClass("module-item-active-maternity").removeClass("module-item-active-trial").removeClass("module-item-active-leave");
						$("#employeeDurationEnd").html($("#employees-right input[name='status_date']").val());
					break;
					case "3":
						$("#employees2 .active-link .module-item-status").addClass("module-item-active-leave").removeClass("module-item-active-trial").addClass("module-item-active-maternity");
						$("#employeeDurationEnd").html($("#employees-right input[name='status_date']").val());
					break;
					default:
						$("#employees2 .active-link .module-item-status").removeClass("module-item-active-trial").removeClass("module-item-active-maternity").removeClass("module-item-active-leave");
				}																															 			}
		});
	}


	this.actionClose = function() {
		employeesLayout.toggle('west');
	}


	this.getNavModulesNumItems = function(id) {
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: 'path=apps/employees&request=getNavModulesNumItems&id=' + id, success: function(data){
				$.each( data, function(k, v){
   					$('#'+k).html(v);
 				});
			}
		});
	}

	
	this.actionNew = function() {
		var module = this;
		var cid = $('#employees input[name="id"]').val()
		module.checkIn(cid);
		var id = $('#employees').data('first');
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: 'path=apps/employees&request=newEmployee&id=' + id, cache: false, success: function(data){
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/employees&request=getEmployeeList&id="+id, success: function(list){
				$("#employees2 ul").html(list.html);
				var index = $("#employees2 .module-click").index($("#employees2 .module-click[rel='"+data.id+"']"));
				setModuleActive($("#employees2"),index);
				$('#employees').data({ "second" : data.id });				
				$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/employees&request=getEmployeeDetails&id="+data.id, success: function(text){
					$("#employees-right").html(text.html);
					initEmployeesContentScrollbar();
					$('#employees-right .focusTitle').trigger('click');
					}
				});
				employeesActions(0);
				}
			});
			}
		});
	}
	
	
	this.actionContact = function(offset) {
		var module = this;
		this.actionDialog(offset,'getContactsImportDialog','status',1);
	}
	
	this.importContact = function(cid) {
		var module = this;
		$("#modalDialog").dialog('close');
		var id = $('#employees').data('first');
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: 'path=apps/employees&request=newEmployee&id=' + id + '&cid=' + cid, cache: false, success: function(data){
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/employees&request=getEmployeeList&id="+id, success: function(list){
				$("#employees2 ul").html(list.html);
				var index = $("#employees2 .module-click").index($("#employees2 .module-click[rel='"+data.id+"']"));
				setModuleActive($("#employees2"),index);
				$('#employees').data({ "second" : data.id });				
				$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/employees&request=getEmployeeDetails&id="+data.id, success: function(text){
					$("#employees-right").html(text.html);
					initEmployeesContentScrollbar();
					//$('#employees-right .focusTitle').trigger('click');
					$.ajax({ type: "GET", url: "/", data: "path=apps/contacts&request=saveLastUsedContacts&id="+cid});
					}
				});
				employeesActions(0);
				}
			});
			}
		});
	}



	this.actionDuplicate = function() {
		var module = this;
		var cid = $('#employees input[name="id"]').val()
		module.checkIn(cid);
		var pid = $("#employees").data("second");
		var oid = $("#employees").data("first");
		$.ajax({ type: "GET", url: "/", data: 'path=apps/employees&request=createDuplicate&id=' + pid, cache: false, success: function(id){
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/employees&request=getEmployeeList&id="+oid, success: function(data){
				$("#employees2 ul").html(data.html);
					employeesActions(0);
					var idx = $("#employees2 .module-click").index($("#employees2 .module-click[rel='"+id+"']"));
					setModuleActive($("#employees2"),idx)
					$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/employees&request=getEmployeeDetails&id="+id, success: function(text){
						$("#employees").data("second",id);							
						$("#"+employees.name+"-right").html(text.html);
							initEmployeesContentScrollbar();
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
					var id = $("#employees").data("second");
					var fid = $("#employees").data("first");
					$.ajax({ type: "GET", url: "/", data: "path=apps/employees&request=binEmployee&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/employees&request=getEmployeeList&id="+fid, success: function(list){
								$("#employees2 ul").html(list.html);
								if(list.html == "<li></li>") {
									employeesActions(3);
								} else {
									employeesActions(0);
									setModuleActive($("#employees2"),0);
								}
								var id = $("#employees2 .module-click:eq(0)").attr("rel");
								$("#employees").data("second", id);								
								$("#employees2 .module-click:eq(0)").addClass('active-link');
								$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/employees&request=getEmployeeDetails&fid="+fid+"&id="+id, success: function(text){
									$("#employees-right").html(text.html);
									initEmployeesContentScrollbar();
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

	this.actionLoadTab = function(what) {
		//var what = $(this).attr('rel');
		$('#EmployeesTabsContent > div:visible').hide();
		$('#'+what).show();
		initEmployeesContentScrollbar();
	}
	
	this.checkIn = function(id) {
		$.ajax({ type: "GET", url: "/", async: false, data: 'path=apps/employees&request=checkinEmployee&id='+id, success: function(data){
				if(!data) {
					prompt("something wrong");
				}
			}
		});
	}


	this.actionRefresh = function() {
		var oid = $('#employees').data('first');
		var pid = $('#employees').data('second');
		$("#employees2 .active-link").trigger("click");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/employees&request=getEmployeeList&id="+oid, success: function(data){
			$("#employees2 ul").html(data.html);
			var idx = $("#employees2 .module-click").index($("#employees2 .module-click[rel='"+pid+"']"));
			$("#employees2 .module-click:eq("+idx+")").addClass('active-link');
			}
		});
	}

	this.actionPrint = function() {
		var id = $("#employees").data("second");
		var url ='/?path=apps/employees&request=printEmployeeDetails&id='+id;
		$("#documentloader").attr('src', url);
	}


	this.actionSend = function() {
		var id = $("#employees").data("second");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/employees&request=getEmployeeSend&id="+id, success: function(data){
			$("#modalDialogForward").html(data.html).dialog('open');
			if(data.error == 1) {
				$.prompt('<div style="text-align: center">' + ALERT_REMOVE_RECIPIENT + data.error_message + '<br /></div>');
				return false;
			}
			}
		});
	}


	this.actionSendtoResponse = function() {
		var id = $("#employees").data("second");
		$.ajax({ type: "GET", url: "/", data: "path=apps/employees&request=getSendtoDetails&id="+id, success: function(html){
			$("#employee_sendto").html(html);
			//$("#modalDialogForward").dialog('close');
			}
		});
	}


	this.sortclick = function (obj,sortcur,sortnew) {
		var module = this;
		var cid = $('#employees input[name="id"]').val()
		module.checkIn(cid);
		var fid = $("#employees .module-click:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/employees&request=getEmployeeList&id="+fid+"&sort="+sortnew, success: function(data){
			$("#employees2 ul").html(data.html);
			obj.attr("rel",sortnew);
			obj.removeClass("sort"+sortcur).addClass("sort"+sortnew);
			var id = $("#employees2 .module-click:eq(0)").attr("rel");
			$('#employees').data('second',id);
			if(id == undefined) {
				return false;
			}
			setModuleActive($("#employees2"),'0');
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/employees&request=getEmployeeDetails&id="+id, success: function(text){
				$("#"+employees.name+"-right").html(text.html);
				initEmployeesContentScrollbar()
				}
			});
			}
		});
	}


	this.sortdrag = function (order) {
		var fid = $("#employees .module-click:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", data: "path=apps/employees&request=setEmployeeOrder&"+order+"&id="+fid, success: function(html){
			$("#employees2 .sort").attr("rel", "3");
			$("#employees2 .sort").removeClass("sort1").removeClass("sort2").addClass("sort3");
			}
		});
	}
	
	
	this.actionDialog = function(offset,request,field,append,title,sql) {
		switch(request) {
			case "getEmployeeDialog":
				$.ajax({ type: "GET", url: "/", data: 'path=apps/employees&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
					$("#modalDialog").html(html);
					$("#modalDialog").dialog('option', 'position', offset);
					$("#modalDialog").dialog('option', 'title', title);
					$("#modalDialog").dialog('open');
					}
				});
			break;
			case "getContactsImportDialog":
				$.ajax({ type: "GET", url: "/", data: 'path=apps/employees&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
					$("#modalDialog").html(html);
					$("#modalDialog").dialog('option', 'position', offset);
					$("#modalDialog").dialog('option', 'title', title);
					$("#modalDialog").dialog('open');
					}
				});
			break;
			case "getEmployeeCatDialog":
				$.ajax({ type: "GET", url: "/", data: 'path=apps/employees&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
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


	this.insertStatusDate = function(rel,text) {
		var html = '<div class="listmember" field="employeesstatus" uid="'+rel+'" style="float: left">' + text + '</div>';
		$("#employeesstatus").html(html);
		$("#modalDialog").dialog("close");
		$("#employeesstatus").nextAll('img').trigger('click');
	}
	
	
	/*this.insertEmployeeFromDialog = function(field,gid,title) {
		var html = '<a class="listmember" uid="' + gid + '" field="'+field+'">' + title + '</a>';
		$("#"+field).html(html);
		$("#modalDialog").dialog('close');
		var obj = getCurrentModule();
		$('#employees .coform').ajaxSubmit(obj.poformOptions);
	}*/
	
	
	this.insertFromDialog = function(field,gid,title) {
		var html = '<a class="listmember" uid="' + gid + '" field="'+field+'">' + title + '</a>';
		$("#"+field).html(html);
		$("#modalDialog").dialog('close');
		var obj = getCurrentModule();
		$('#employees .coform').ajaxSubmit(obj.poformOptions);
	}
	
	this.actionHelp = function() {
		var url = "/?path=apps/employees&request=getEmployeesHelp";
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/employees&request=deleteEmployee&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#employee_'+id).slideUp();
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/employees&request=restoreEmployee&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#employee_'+id).slideUp();
						}
					}
					});
				} 
			}
		});
	}


	this.datepickerOnClose = function(dp) {
		var obj = getCurrentModule();
		$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
	}


	this.manageCheckpoint = function(action,date) {
		var pid = $('#employees').data('second');
		switch(action) {
			case 'new':
				$.ajax({ type: "GET", url: "/", data: "path=apps/employees&request=newCheckpoint&id=" + pid + "&date=" + date, cache: false });
			break;
			case 'update':
				$.ajax({ type: "GET", url: "/", data: "path=apps/employees&request=updateCheckpoint&id=" + pid + "&date=" + date, cache: false });			
			break;
			case 'delete':
				$.ajax({ type: "GET", url: "/", data: "path=apps/employees&request=deleteCheckpoint&id=" + pid, cache: false });
			break;
		}
	}
	
	
	this.saveCheckpointText = function() {
		var pid = $('#employees').data('second');
		var text = $('#employeesCheckpoint textarea').val();
		$.ajax({ type: "POST", url: "/", data: "path=apps/employees&request=updateCheckpointText&id=" + pid + "&text=" + text, cache: false });
	}

}

var employees = new employeesApplication('employees');
//employees.resetModuleHeights = employeesresetModuleHeights;
employees.modules_height = employees_num_modules*module_title_height;
employees.GuestHiddenModules = new Array("access");

// register folder object
function employeesFolders(name) {
	this.name = name;
	
	
	this.formProcess = function(formData, form, poformOptions) {
		var title = $("#employees input.title").fieldValue();
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
				$("#employees1 span[rel='"+data.id+"'] .text").html($("#employees .title").val());
			break;
		}
	}


	this.poformOptions = { async: false, beforeSubmit: this.formProcess, dataType: 'json', success: this.formResponse };

	
	this.actionNew = function() {
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/employees&request=newFolder", cache: false, success: function(data){
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/employees&request=getFolderList", success: function(list){
				$("#employees1 ul").html(list.html);
				$("#employees1 li").show();
				var index = $("#employees1 .module-click").index($("#employees1 .module-click[rel='"+data.id+"']"));
				setModuleActive($("#employees1"),index);
				$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/employees&request=getFolderDetails&id="+data.id, success: function(text){
					$("#employees").data("first",data.id);					
					$("#"+employees.name+"-right").html(text.html);
					initEmployeesContentScrollbar();
					$('#employees-right .focusTitle').trigger('click');
					}
				});
				employeesActions(9);
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
					var id = $("#employees").data("first");
					$.ajax({ type: "GET", url: "/", data: "path=apps/employees&request=binFolder&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/employees&request=getFolderList", success: function(data){
								$("#employees1 ul").html(data.html);
								if(data.html == "<li></li>") {
									employeesActions(3);
								} else {
									employeesActions(9);
								}
								var id = $("#employees1 .module-click:eq(0)").attr("rel");
								$("#employees").data("first",id);								
								$("#employees1 .module-click:eq(0)").addClass('active-link');
								$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/employees&request=getFolderDetails&id="+id, success: function(text){
									$("#"+employees.name+"-right").html(text.html);
									initEmployeesContentScrollbar();
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
		var id = $("#employees").data("first");
		$("#employees1 .active-link").trigger("click");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/employees&request=getFolderList", success: function(data){
			$("#employees1 ul").html(data.html);
			if(data.access == "guest") {
				employeesActions();
			} else {
				if(data.html == "<li></li>") {
					employeesActions(3);
				} else {
					employeesActions(9);
				}
			}
			var idx = $("#employees1 .module-click").index($("#employees1 .module-click[rel='"+id+"']"));
			$("#employees1 .module-click:eq("+idx+")").addClass('active-link');
			}
		});
	}
	

	this.actionPrint = function() {
		var id = $("#employees").data("first");
		var url ='/?path=apps/employees&request=printFolderDetails&id='+id;
		$("#documentloader").attr('src', url);
	}


	this.actionSend = function() {
		var id = $("#employees").data("first");
		$.ajax({ type: "GET", url: "/", data: "path=apps/employees&request=getFolderSend&id="+id, success: function(html){
			$("#modalDialogForward").html(html).dialog('open');
			}
		});
	}


	this.actionSendtoResponse = function() {
			//$("#modalDialogForward").dialog('close');
	}

	
	this.sortclick = function (obj,sortcur,sortnew) {
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/employees&request=getFolderList&sort="+sortnew, success: function(data){
			$("#employees1 ul").html(data.html);
			obj.attr("rel",sortnew);
		  	obj.removeClass("sort"+sortcur).addClass("sort"+sortnew);
			var id = $("#employees1 .module-click:eq(0)").attr("rel");
			$('#employees').data('first',id);			
			$("#employees1 .module-click:eq(0)").addClass('active-link');
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/employees&request=getFolderDetails&id="+id, success: function(text){
				$("#employees-right").html(text.html);
				initEmployeesContentScrollbar()
				}
			});
			}
		});
	}


	this.sortdrag = function (order) {
		$.ajax({ type: "GET", url: "/", data: "path=apps/employees&request=setFolderOrder&"+order, success: function(html){
			$("#employees1 .sort").attr("rel", "3");
			$("#employees1 .sort").removeClass("sort1").removeClass("sort2").addClass("sort3");
			}
		});
	}
	
	
	this.insertItem = function(field,append,id,text) {
		var html = '<span class="listmember-outer"><a class="listmember" uid="' + id + '" field="'+field+'">' + text + '</a>';
		$("#"+field).html(html);
		$("#modalDialog").dialog('close');
		/*var obj = getCurrentModule();
		$('#projects .coform').ajaxSubmit(obj.poformOptions);*/
	}
	
	this.actionDialog = function(offset,request,field,append,title,sql) {
		switch(request) {
			case "getMenuesDialog":
				$.ajax({ type: "GET", url: "/", data: 'path=apps/publishers/modules/menues&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
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


	this.actionHelp = function() {
		var url = "/?path=apps/employees&request=getEmployeesFoldersHelp";
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/employees&request=deleteFolder&id=" + id, cache: false, success: function(data){
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/employees&request=restoreFolder&id=" + id, cache: false, success: function(data){
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

var employees_folder = new employeesFolders('employees_folder');


function employeesActions(status) {
	/*	0= new	1= print	2= send		3= duplicate	4= handbook		5=refresh 	6 = delete*/
	//console.log(status);
	var obj = getCurrentModule();
	switch(status) {
		//case 0: actions = ['0','1','2','3','5','6']; break;
		case 0: 
			if(obj.name == 'employees') {
				actions = ['1','2','3','4','5','6','7','8']; 
			} else {
				actions = ['0','2','3','4','6','7','8']; 
			}
		break;
		case 1: actions = ['0','5','6','7']; break;
		case 3: 
			if(obj.name == 'employees') {
				actions = ['1','6','7']; 
			} else {
				actions = ['0','6','7']; 
			}
		break;
		case 4: 	actions = ['0','1','2','6','7','8']; break;
		case 5: 	actions = ['2','3','6','7']; break;
		case 6: 	actions = ['7','8']; break;   			// handbook refresh
		case 7: 	actions = ['0','1','2','7','8']; break;
		case 8: 	actions = ['1','2','6','7','8']; break;
		case 9: 	actions = ['0','2','3','6','7','8']; break; // default folder if not empty
		
		// vdocs
		// 0 == 10
		//case 10: actions = ['0','1','2','3','5','6','7','8']; break;
		// 5 == 11
		case 11: 	actions = ['1','2','6','7','8']; break;   			// print, send, refresh
		
		// rosters
		case 12: actions = ['0','1','2','3','4','6','7','8']; break;
		
		
		default: 	actions = ['6','7'];  								// none
	}
	$('#employeesActions > li span').each( function(index) {
		if(index in oc(actions)) {
			$(this).removeClass('noactive');
		} else {
			$(this).addClass('noactive');
		}
	})
}

var employeesLayout, employeesInnerLayout;


$(document).ready(function() {
	
	employees.init();
	
	if($('#employees').length > 0) {
		employeesLayout = $('#employees').layout({
				west__onresize:				function() { resetModuleHeightsnavThree('employees'); }
			,	resizeWhileDragging:		true
			,	spacing_open:				0
			,	spacing_closed:				0
			,	closable: 					false
			,	resizable: 					false
			,	slidable:					false
			, 	west__size:					325
			,	west__closable: 			true
			,	center__onresize: "employeesInnerLayout.resizeAll"
			
		});
		
		employeesInnerLayout = $('#employees div.ui-layout-center').layout({
				center__onresize:				function() {  }
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

		loadModuleStartnavThree('employees');
	}


	$("#employees1-outer").on('click', 'h3', function(e, passed_id) {
		e.preventDefault();
		navThreeTitleFirst('employees',$(this),passed_id)
		prevent_dblclick(e)
	}).disableSelection();


	$("#employees2-outer").on('click', 'h3', function(e, passed_id) {
		e.preventDefault();
		navThreeTitleSecond('employees',$(this),passed_id)
		prevent_dblclick(e)
	}).disableSelection();


	$("#employees3").on('click', 'h3', function(e, passed_id) {
		e.preventDefault();
		navThreeTitleThird('employees',$(this),passed_id)
		prevent_dblclick(e)
	}).disableSelection();


	$('#employees1').on('click', 'span.module-click',function(e) {
		e.preventDefault();
		navItemFirst('employees',$(this))
		prevent_dblclick(e)
	});


	$('#employees2').on('click', 'span.module-click',function(e) {
		e.preventDefault();
		navItemSecond('employees',$(this))
		prevent_dblclick(e)
	});


	$('#employees3').on('click', 'span.module-click',function(e) {
		e.preventDefault();
		navItemThird('employees',$(this))
		prevent_dblclick(e)
	});


	$(document).on('click', 'a.insertEmployeeFolderfromDialog', function(e) {
		e.preventDefault();
		var field = $(this).attr("field");
		var gid = $(this).attr("gid");
		var title = $(this).attr("title");
		var obj = getCurrentModule();
		obj.insertFromDialog(field,gid,title);
	});
	
	$(document).on('click', 'a.insertFromDialog', function(e) {
		e.preventDefault();
		var field = $(this).attr("field");
		var gid = $(this).attr("gid");
		var title = $(this).attr("title");
		var obj = getCurrentModule();
		obj.insertFromDialog(field,gid,title);
	});
	
	
// INTERLINKS FROM Content
	
	// load a employee
	$(document).on('click', '.loadEmployee', function(e) {	
		e.preventDefault();
		var obj = getCurrentModule();
		if(confirmNavigation()) {
			formChanged = false;
			$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		}
		var id = $(this).attr("rel");
		$("#employees2-outer > h3").trigger('click', [id]);
	});
	
	
	$('#employees .globalSearch').livequery(function() {
		$(this).autocomplete({
			appendTo: '#employees',
			position: {my: "left top", at: "left bottom", collision: "none",offset: "-104 0"},
			source: "?path=apps/employees&request=getGlobalSearch",
			//minLength: 2,
			select: function(event, ui) {
				var obj = getCurrentModule();
				var cid = $('#'+getCurrentApp()+' input[name="id"]').val()
				obj.checkIn(cid);
				var href = ui.item.id.split(",");
				externalLoadThreeLevels(href[0],href[1],href[2],href[3],href[4]);
			},
			close: function(event, ui) {
				$(this).val("");
			}
		});
	});


});