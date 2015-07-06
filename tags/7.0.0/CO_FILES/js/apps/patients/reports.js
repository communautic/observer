/* reports Object */
function patientsReports(name) {
	this.name = name;


	this.formProcess = function(formData, form, poformOptions) {
		var title = $("#patients input.title").fieldValue();
		if(title == "") {
			setTimeout(function() {
				title = $("#patients input.title").fieldValue();
				if(title == "") {
					$.prompt(ALERT_NO_TITLE, {submit: setTitleFocus});
				}
			}, 5000)
			return false;
		} else {
			formData[formData.length] = { "name": "title", "value": title };
		}
		var tid = $("#patients input.tid").fieldValue();
		if(tid > 0) {
			formData[formData.length] = processDocListApps('documents');
			formData[formData.length] = processListApps('report_access');
		}
	 }
	 
	 
	 this.formResponse = function(data) {
		 switch(data.action) {
			case "edit": case "editTitle":
				$("#patients3 ul[rel=reports] span[rel="+data.id+"] .text").html($("#patients .item_date").val() + ' - ' +$("#patients .title").val());
					switch(data.access) {
						case "0":
							$("#patients3 ul[rel=reports] span[rel="+data.id+"] .module-access-status").removeClass("module-access-active");
						break;
						case "1":
							$("#patients3 ul[rel=reports] span[rel="+data.id+"] .module-access-status").addClass("module-access-active");
						break;
					}
			break;
		}
	}
	
	
	this.poformOptions = { beforeSubmit: this.formProcess, dataType: 'json', success: this.formResponse };


	this.getDetails = function(moduleidx,liindex,list) {
		var id = $("#patients3 ul:eq("+moduleidx+") .module-click:eq("+liindex+")").attr("rel");
		$('#patients').data({ "third" : id});
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/patients/modules/reports&request=getDetails&id="+id, success: function(data){
			$("#patients-right").html(data.html);
			
			if($('#checkedOut').length > 0) {
					$("#patients3 ul[rel=reports] .active-link .icon-checked-out").addClass('icon-checked-out-active');
				} else {
					$("#patients3 ul[rel=reports] .active-link .icon-checked-out").removeClass('icon-checked-out-active');
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
		$.ajax({ type: "GET", url: "/", dataType: 'json', data: 'path=apps/patients/modules/reports&request=createNew&id=' + id, cache: false, success: function(data){
			$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/patients/modules/reports&request=getList&id="+id, success: function(list){
				$("#patients3 ul[rel=reports]").html(list.html);
				$('#patients_reports_items').html(list.items);
				var liindex = $("#patients3 ul[rel=reports] .module-click").index($("#patients3 ul[rel=reports] .module-click[rel='"+data.id+"']"));
				$("#patients3 ul[rel=reports] .module-click:eq("+liindex+")").addClass('active-link');
				var moduleidx = $("#patients3 ul").index($("#patients3 ul[rel=reports]"));
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
		$.ajax({ type: "GET", url: "/", data: 'path=apps/patients/modules/reports&request=createDuplicate&id=' + id, cache: false, success: function(mid){
			$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/patients/modules/reports&request=getList&id="+pid, success: function(data){																																																																				
				$("#patients3 ul[rel=reports]").html(data.html);
				$('#patients_reports_items').html(data.items);
				var moduleidx = $("#patients3 ul").index($("#patients3 ul[rel=reports]"));
				var liindex = $("#patients3 ul[rel=reports] .module-click").index($("#patients3 ul[rel=reports] .module-click[rel='"+mid+"']"));
				module.getDetails(moduleidx,liindex);
				$("#patients3 ul[rel=reports] .module-click:eq("+liindex+")").addClass('active-link');
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
			submit: function(e,v,m,f){		
				if(v){
					var id = $("#patients").data("third");
					var pid = $("#patients").data("second");
					$.ajax({ type: "GET", url: "/", data: "path=apps/patients/modules/reports&request=binReport&id=" + id, cache: false, success: function(data){
							if(data == "true") {
								$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/patients/modules/reports&request=getList&id="+pid, success: function(data){
									$("#patients3 ul[rel=reports]").html(data.html);
									$('#patients_reports_items').html(data.items);
									if(data.html == "<li></li>") {
										patientsActions(3);
									} else {
										patientsActions(0);
									}
									var moduleidx = $("#patients3 ul").index($("#patients3 ul[rel=reports]"));
									var liindex = 0;
									module.getDetails(moduleidx,liindex);
									$("#patients3 ul[rel=reports] .module-click:eq("+liindex+")").addClass('active-link');
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
		$.ajax({ type: "GET", url: "/", async: false, data: 'path=apps/patients/modules/reports&request=checkinReport&id='+id, success: function(data){
			if(!data) {
				prompt("something wrong");
			}
			}
		});
	}
	
	
	this.actionRefresh = function() {
		var id = $("#patients").data("third");
		var pid = $("#patients").data("second");
		$("#patients3 ul[rel=reports] .active-link").trigger("click");
		$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/patients/modules/reports&request=getList&id="+pid, success: function(data){																																																																				
			$("#patients3 ul[rel=reports]").html(data.html);
			$('#patients_reports_items').html(data.items);
			var liindex = $("#patients3 ul[rel=reports] .module-click").index($("#patients3 ul[rel=reports] .module-click[rel='"+id+"']"));
			$("#patients3 ul[rel=reports] .module-click:eq("+liindex+")").addClass('active-link');
			}
		});
	}


	this.actionPrint = function() {
		var id = $("#patients").data("third");
		var url ='/?path=apps/patients/modules/reports&request=printDetails&id='+id;
		if(!iOS()) {
			$("#documentloader").attr('src', url);
		} else {
			window.open(url);
		}
	}


	this.actionSend = function() {
		var id = $("#patients").data("third");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/patients/modules/reports&request=getSend&id="+id, success: function(data){
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
		$.ajax({ type: "GET", url: "/", data: "path=apps/patients/modules/reports&request=getSendtoDetails&id="+id, success: function(html){
			$("#patientsreport_sendto").html(html);
			//$("#modalDialogForward").dialog('close');
			}
		});
	}
	
	
	this.sortclick = function (obj,sortcur,sortnew) {
		var module = this;
		var cid = $('#patients input[name="id"]').val()
		module.checkIn(cid);
		
		var fid = $("#patients2 .module-click:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/patients/modules/reports&request=getList&id="+fid+"&sort="+sortnew, success: function(data){
			$("#patients3 ul[rel=reports]").html(data.html);
			$('#patients_reports_items').html(data.items);
			obj.attr("rel",sortnew);
			obj.removeClass("sort"+sortcur).addClass("sort"+sortnew);
			var id = $("#patients3 ul[rel=reports] .module-click:eq(0)").attr("rel");
			$('#patients').data('third',id);
			if(id == undefined) {
				return false;
			}
			var moduleidx = $("#patients3 ul").index($("#patients3 ul[rel=reports]"));
			module.getDetails(moduleidx,0);
			$("#patients3 ul[rel=reports] .module-click:eq(0)").addClass('active-link');
		}
		});
	}


	this.sortdrag = function (order) {
		var fid = $("#patients").data("second");
		$.ajax({ type: "GET", url: "/", data: "path=apps/patients/modules/reports&request=setOrder&"+order+"&id="+fid, success: function(html){
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
			case "getReportStatusDialog":
				$.ajax({ type: "GET", url: "/", data: 'path=apps/patients/modules/reports&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
					$("#modalDialog").html(html);
					$("#modalDialog").dialog('option', 'position', offset);
					$("#modalDialog").dialog('option', 'title', title);
					$("#modalDialog").dialog('open');
					}
				});
			break;
			case "getReportsTreatmentsDialog":
				$.ajax({ type: "GET", url: "/", data: 'path=apps/patients/modules/reports&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
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


	this.insertStatus = function(rel,text) {
		var module = this;
		var html = '<div class="listmember" field="patientsreport_status" uid="'+rel+'" style="float: left">' + text + '</div>';
		$("#patientsreport_status").html(html);
		$("#modalDialog").dialog("close");
		$("#patientsreport_status").next().val("");
		$('#patients .coform').ajaxSubmit(module.poformOptions);
	}
	
	
	this.insertFromDialog = function(field,gid,title) {
		var module = this;
		$("#modalDialog").dialog('close');
		var pid = $('#patients-right-report-id').val();
		$.ajax({ type: "GET", url: "/", data: 'path=apps/patients/modules/reports&request=setTreatmentID&pid='+pid+'&tid='+gid, success: function(){
				var moduleidx = $("#patients3 ul").index($("#patients3 ul[rel=reports]"));
				var liindex = $("#patients3 ul[rel=reports] .module-click").index($("#patients3 ul[rel=reports] .module-click[rel='"+pid+"']"));
				module.getDetails(moduleidx,liindex);
				$("#patients3 ul[rel=reports] .module-click:eq("+liindex+")").addClass('active-link');
			}
		});
	}
	
	
	this.actionHelp = function() {
		var url = "/?path=apps/patients/modules/reports&request=getHelp";
		if(!iOS()) {
			$("#documentloader").attr('src', url);
		} else {
			window.open(url);
		}
	}
	
	
	// Recycle Bin
	this.binDelete = function(id) {
		var txt = ALERT_DELETE_REALLY;
		var langbuttons = {};
		langbuttons[ALERT_YES] = true;
		langbuttons[ALERT_NO] = false;
		$.prompt(txt,{ 
			buttons:langbuttons,
			submit: function(e,v,m,f){		
				if(v){
					$.ajax({ type: "GET", url: "/", data: "path=apps/patients/modules/reports&request=deleteReport&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#report_'+id).slideUp();
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
			submit: function(e,v,m,f){		
				if(v){
					$.ajax({ type: "GET", url: "/", data: "path=apps/patients/modules/reports&request=restoreReport&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#report_'+id).slideUp();
						}
					}
					});
				} 
			}
		});
	}


}


var patients_reports = new patientsReports('patients_reports');