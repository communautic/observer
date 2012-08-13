/* phonecalls Object */
function employeesPhonecalls(name) {
	this.name = name;


	this.formProcess = function(formData, form, poformOptions) {
		var title = $("#employees input.title").fieldValue();
		if(title == "") {
			$.prompt(ALERT_NO_TITLE, {callback: setTitleFocus});
			return false;
		} else {
			formData[formData.length] = { "name": "title", "value": title };
		}
		
		formData[formData.length] = processListApps('management');
		formData[formData.length] = processCustomTextApps('management_ct');
		formData[formData.length] = processStringApps('phonecallstart');
		formData[formData.length] = processStringApps('phonecallend');
		formData[formData.length] = processDocListApps('documents');
		formData[formData.length] = processListApps('phonecall_access');
		formData[formData.length] = processListApps('phonecall_status');
	 }
	 
	 
	 this.formResponse = function(data) {
		 switch(data.action) {
			case "edit":
				$("#employees3 ul[rel=phonecalls] span[rel="+data.id+"] .text").html($("#employees .item_date").val() + ' - ' +$("#employees .title").val());
					switch(data.access) {
						case "0":
							$("#employees3 ul[rel=phonecalls] span[rel="+data.id+"] .module-access-status").removeClass("module-access-active");
						break;
						case "1":
							$("#employees3 ul[rel=phonecalls] span[rel="+data.id+"] .module-access-status").addClass("module-access-active");
						break;
					}
			break;
		}
	}
	
	
	this.poformOptions = { async: false, beforeSubmit: this.formProcess, dataType: 'json', success: this.formResponse };


	this.getDetails = function(moduleidx,liindex,list) {
		var id = $("#employees3 ul:eq("+moduleidx+") .module-click:eq("+liindex+")").attr("rel");
		$('#employees').data({ "third" : id});
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/employees/modules/phonecalls&request=getDetails&id="+id, success: function(data){
			$("#employees-right").html(data.html);
			
			if($('#checkedOut').length > 0) {
					$("#employees3 ul[rel=phonecalls] .active-link .icon-checked-out").addClass('icon-checked-out-active');
				} else {
					$("#employees3 ul[rel=phonecalls] .active-link .icon-checked-out").removeClass('icon-checked-out-active');
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
		$.ajax({ type: "GET", url: "/", dataType: 'json', data: 'path=apps/employees/modules/phonecalls&request=createNew&id=' + id, cache: false, success: function(data){
			$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/employees/modules/phonecalls&request=getList&id="+id, success: function(list){
				$("#employees3 ul[rel=phonecalls]").html(list.html);
				$('#employees_phonecalls_items').html(list.items);
				var liindex = $("#employees3 ul[rel=phonecalls] .module-click").index($("#employees3 ul[rel=phonecalls] .module-click[rel='"+data.id+"']"));
				$("#employees3 ul[rel=phonecalls] .module-click:eq("+liindex+")").addClass('active-link');
				var moduleidx = $("#employees3 ul").index($("#employees3 ul[rel=phonecalls]"));
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
		$.ajax({ type: "GET", url: "/", data: 'path=apps/employees/modules/phonecalls&request=createDuplicate&id=' + id, cache: false, success: function(mid){
			$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/employees/modules/phonecalls&request=getList&id="+pid, success: function(data){																																																																				
				$("#employees3 ul[rel=phonecalls]").html(data.html);
				$('#employees_phonecalls_items').html(data.items);
				var moduleidx = $("#employees3 ul").index($("#employees3 ul[rel=phonecalls]"));
				var liindex = $("#employees3 ul[rel=phonecalls] .module-click").index($("#employees3 ul[rel=phonecalls] .module-click[rel='"+mid+"']"));
				module.getDetails(moduleidx,liindex);
				$("#employees3 ul[rel=phonecalls] .module-click:eq("+liindex+")").addClass('active-link');
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/employees/modules/phonecalls&request=binPhonecall&id=" + id, cache: false, success: function(data){
							if(data == "true") {
								$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/employees/modules/phonecalls&request=getList&id="+pid, success: function(data){
									$("#employees3 ul[rel=phonecalls]").html(data.html);
									$('#employees_phonecalls_items').html(data.items);
									if(data.html == "<li></li>") {
										employeesActions(3);
									} else {
										employeesActions(0);
									}
									var moduleidx = $("#employees3 ul").index($("#employees3 ul[rel=phonecalls]"));
									var liindex = 0;
									module.getDetails(moduleidx,liindex);
									$("#employees3 ul[rel=phonecalls] .module-click:eq("+liindex+")").addClass('active-link');
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
		$.ajax({ type: "GET", url: "/", async: false, data: 'path=apps/employees/modules/phonecalls&request=checkinPhonecall&id='+id, success: function(data){
			if(!data) {
				prompt("something wrong");
			}
			}
		});
	}
	
	
	this.actionRefresh = function() {
		var id = $("#employees").data("third");
		var pid = $("#employees").data("second");
		$("#employees3 ul[rel=phonecalls] .active-link").trigger("click");
		$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/employees/modules/phonecalls&request=getList&id="+pid, success: function(data){																																																																				
			$("#employees3 ul[rel=phonecalls]").html(data.html);
			$('#employees_phonecalls_items').html(data.items);
			var liindex = $("#employees3 ul[rel=phonecalls] .module-click").index($("#employees3 ul[rel=phonecalls] .module-click[rel='"+id+"']"));
			$("#employees3 ul[rel=phonecalls] .module-click:eq("+liindex+")").addClass('active-link');
			}
		});
	}


	this.actionPrint = function() {
		var id = $("#employees").data("third");
		var url ='/?path=apps/employees/modules/phonecalls&request=printDetails&id='+id;
		$("#documentloader").attr('src', url);
	}


	this.actionSend = function() {
		var id = $("#employees").data("third");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/employees/modules/phonecalls&request=getSend&id="+id, success: function(data){
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
		$.ajax({ type: "GET", url: "/", data: "path=apps/employees/modules/phonecalls&request=getSendtoDetails&id="+id, success: function(html){
			$("#employeesphonecall_sendto").html(html);
			$("#modalDialogForward").dialog('close');
			}
		});
	}
	
	
	this.sortclick = function (obj,sortcur,sortnew) {
		var module = this;
		var cid = $('#employees input[name="id"]').val()
		module.checkIn(cid);
		
		var fid = $("#employees2 .module-click:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/employees/modules/phonecalls&request=getList&id="+fid+"&sort="+sortnew, success: function(data){
			$("#employees3 ul[rel=phonecalls]").html(data.html);
			$('#employees_phonecalls_items').html(data.items);
			obj.attr("rel",sortnew);
			obj.removeClass("sort"+sortcur).addClass("sort"+sortnew);
			var id = $("#employees3 ul[rel=phonecalls] .module-click:eq(0)").attr("rel");
			$('#employees').data('third',id);
			if(id == undefined) {
				return false;
			}
			var moduleidx = $("#employees3 ul").index($("#employees3 ul[rel=phonecalls]"));
			module.getDetails(moduleidx,0);
			$("#employees3 ul[rel=phonecalls] .module-click:eq(0)").addClass('active-link');
		}
		});
	}


	this.sortdrag = function (order) {
		var fid = $("#employees").data("second");
		$.ajax({ type: "GET", url: "/", data: "path=apps/employees/modules/phonecalls&request=setOrder&"+order+"&id="+fid, success: function(html){
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
			case "getPhonecallStatusDialog":
				$.ajax({ type: "GET", url: "/", data: 'path=apps/employees/modules/phonecalls&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
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
		var html = '<div class="listmember" field="employeesphonecall_status" uid="'+rel+'" style="float: left">' + text + '</div>';
		$("#employeesphonecall_status").html(html);
		$("#modalDialog").dialog("close");
		$("#employeesphonecall_status").next().val("");
		$('#employees .coform').ajaxSubmit(module.poformOptions);
	}
	
	
	this.actionHelp = function() {
		var url = "/?path=apps/employees/modules/phonecalls&request=getHelp";
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/employees/modules/phonecalls&request=deletePhonecall&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#phonecall_'+id).slideUp();
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/employees/modules/phonecalls&request=restorePhonecall&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#phonecall_'+id).slideUp();
						}
					}
					});
				} 
			}
		});
	}


}


var employees_phonecalls = new employeesPhonecalls('employees_phonecalls');