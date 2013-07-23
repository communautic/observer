function initPatientsContentScrollbar() {
	patientsInnerLayout.initContent('center');
}

/* patients Object */
function patientsApplication(name) {
	this.name = name;
	

	this.init = function() {
		this.$app = $('#patients');
		this.$appContent = $('#patients-right');
		this.$first = $('#patients1');
		this.$second = $('#patients2');
		this.$third = $('#patients3');
		this.$thirdDiv = $('#patients3 div.thirdLevel');
		this.$layoutWest = $('#patients div.ui-layout-west');
	}
	
	
	this.formProcess = function(formData, form, poformOptions) {
		var title = $("#patients input.title").fieldValue();
		if(title == "") {
			$.prompt(ALERT_NO_TITLE, {submit: setTitleFocus});
			return false;
		} else {
			formData[formData.length] = { "name": "title", "value": title };
		}
	
		formData[formData.length] = processListApps('folder');
		formData[formData.length] = processListApps('management');
		formData[formData.length] = processCustomTextApps('management_ct');
		formData[formData.length] = processListAppsInsurance('insurance');
		formData[formData.length] = processStringApps('insuranceadd');
		formData[formData.length] = processDocListApps('documents');
	}

	
	this.formResponse = function(data) {
		switch(data.action) {
			case "edit":
				$("#patients2 span[rel='"+data.id+"'] .text").html($("#patients .title").val());
				$("#patientDurationStart").html($("#patients-right input[name='startdate']").val());
			break;
		}
	}


	this.poformOptions = { beforeSubmit: this.formProcess, dataType: 'json', success: this.formResponse };


	this.statusOnClose = function(dp) {
		var id = $("#patients").data("second");
		var status = $("#patients .statusTabs li span.active").attr('rel');
		var date = $("#patients .statusTabs input").val();
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/patients&request=updateStatus&id=" + id + "&date=" + date + "&status=" + status, cache: false, success: function(data){
				switch(data.status) {
					case "0":
						$("#patients2 .active-link .module-item-status").addClass("module-item-active-trial").removeClass("module-item-active-circle");
						$("#patientDurationEnd").html($("#patients-right input[name='status_date']").val());
					break;
					case "1":
						$("#patients2 .active-link .module-item-status").addClass("module-item-active-circle").removeClass("module-item-active-trial");
						$("#patientDurationEnd").html($("#patients-right input[name='status_date']").val());
					break;
					default:
						$("#patients2 .active-link .module-item-status").removeClass("module-item-active-trial").removeClass("module-item-active-circle");
				}																															 			}
		});
	}


	this.actionClose = function() {
		patientsLayout.toggle('west');
	}


	this.getNavModulesNumItems = function(id) {
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: 'path=apps/patients&request=getNavModulesNumItems&id=' + id, success: function(data){
				$.each( data, function(k, v){
   					$('#'+k).html(v);
 				});
			}
		});
	}

	
	this.actionNew = function() {
		var module = this;
		var cid = $('#patients input[name="id"]').val()
		module.checkIn(cid);
		var id = $('#patients').data('first');
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: 'path=apps/patients&request=newPatient&id=' + id, cache: false, success: function(data){
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/patients&request=getPatientList&id="+id, success: function(list){
				$("#patients2 ul").html(list.html);
				var index = $("#patients2 .module-click").index($("#patients2 .module-click[rel='"+data.id+"']"));
				setModuleActive($("#patients2"),index);
				$('#patients').data({ "second" : data.id });				
				$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/patients&request=getPatientDetails&id="+data.id, success: function(text){
					$("#patients-right").html(text.html);
					initPatientsContentScrollbar();
					$('#patients-right .focusTitle').trigger('click');
					}
				});
				patientsActions(0);
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
		var id = $('#patients').data('first');
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: 'path=apps/patients&request=newPatient&id=' + id + '&cid=' + cid, cache: false, success: function(data){
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/patients&request=getPatientList&id="+id, success: function(list){
				$("#patients2 ul").html(list.html);
				var index = $("#patients2 .module-click").index($("#patients2 .module-click[rel='"+data.id+"']"));
				setModuleActive($("#patients2"),index);
				$('#patients').data({ "second" : data.id });				
				$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/patients&request=getPatientDetails&id="+data.id, success: function(text){
					$("#patients-right").html(text.html);
					initPatientsContentScrollbar();
					module.getNavModulesNumItems(data.id);
					//$('#patients-right .focusTitle').trigger('click');
					$.ajax({ type: "GET", url: "/", data: "path=apps/contacts&request=saveLastUsedContacts&id="+cid});
					}
				});
				patientsActions(0);
				}
			});
			}
		});
	}



	this.actionDuplicate = function() {
		var module = this;
		var cid = $('#patients input[name="id"]').val()
		module.checkIn(cid);
		var pid = $("#patients").data("second");
		var oid = $("#patients").data("first");
		$.ajax({ type: "GET", url: "/", data: 'path=apps/patients&request=createDuplicate&id=' + pid, cache: false, success: function(id){
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/patients&request=getPatientList&id="+oid, success: function(data){
				$("#patients2 ul").html(data.html);
					patientsActions(0);
					var idx = $("#patients2 .module-click").index($("#patients2 .module-click[rel='"+id+"']"));
					setModuleActive($("#patients2"),idx)
					$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/patients&request=getPatientDetails&id="+id, success: function(text){
						$("#patients").data("second",id);							
						$("#"+patients.name+"-right").html(text.html);
							initPatientsContentScrollbar();
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
					var id = $("#patients").data("second");
					var fid = $("#patients").data("first");
					$.ajax({ type: "GET", url: "/", data: "path=apps/patients&request=binPatient&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/patients&request=getPatientList&id="+fid, success: function(list){
								$("#patients2 ul").html(list.html);
								if(list.html == "<li></li>") {
									patientsActions(3);
								} else {
									patientsActions(0);
									setModuleActive($("#patients2"),0);
								}
								var id = $("#patients2 .module-click:eq(0)").attr("rel");
								if(typeof id == 'undefined') {
									$("#patients").data("second", 0);
								} else {
									$("#patients").data("second", id);
								}
								$("#patients2 .module-click:eq(0)").addClass('active-link');
								$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/patients&request=getPatientDetails&fid="+fid+"&id="+id, success: function(text){
									$("#patients-right").html(text.html);
									initPatientsContentScrollbar();
									module.getNavModulesNumItems(id);
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
		$('#PatientsTabsContent > div:visible').hide();
		$('#'+what).show();
		$('.elastic').elastic(); // need to init again
		initPatientsContentScrollbar();
	}
	
	this.checkIn = function(id) {
		$.ajax({ type: "GET", url: "/", async: false, data: 'path=apps/patients&request=checkinPatient&id='+id, success: function(data){
				if(!data) {
					prompt("something wrong");
				}
			}
		});
	}


	this.actionRefresh = function() {
		var oid = $('#patients').data('first');
		var pid = $('#patients').data('second');
		$("#patients2 .active-link").trigger("click");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/patients&request=getPatientList&id="+oid, success: function(data){
			$("#patients2 ul").html(data.html);
			var idx = $("#patients2 .module-click").index($("#patients2 .module-click[rel='"+pid+"']"));
			$("#patients2 .module-click:eq("+idx+")").addClass('active-link');
			}
		});
	}


	this.actionHandbook = function() {
		var id = $("#patients").data("second");
		var url ='/?path=apps/patients&request=printPatientHandbook&id='+id;
		$("#documentloader").attr('src', url);	
	}


	this.actionPrint = function() {
		var id = $("#patients").data("second");
		var url ='/?path=apps/patients&request=printPatientDetails&id='+id;
		$("#documentloader").attr('src', url);
	}


	this.actionSend = function() {
		var id = $("#patients").data("second");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/patients&request=getPatientSend&id="+id, success: function(data){
			$("#modalDialogForward").html(data.html).dialog('open');
			if(data.error == 1) {
				$.prompt('<div style="text-align: center">' + ALERT_REMOVE_RECIPIENT + data.error_message + '<br /></div>');
				return false;
			}
			}
		});
	}


	this.actionSendtoResponse = function() {
		var id = $("#patients").data("second");
		$.ajax({ type: "GET", url: "/", data: "path=apps/patients&request=getSendtoDetails&id="+id, success: function(html){
			$("#patient_sendto").html(html);
			//$("#modalDialogForward").dialog('close');
			}
		});
	}


	this.sortclick = function (obj,sortcur,sortnew) {
		var module = this;
		var cid = $('#patients input[name="id"]').val()
		module.checkIn(cid);
		var fid = $("#patients .module-click:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/patients&request=getPatientList&id="+fid+"&sort="+sortnew, success: function(data){
			$("#patients2 ul").html(data.html);
			obj.attr("rel",sortnew);
			obj.removeClass("sort"+sortcur).addClass("sort"+sortnew);
			var id = $("#patients2 .module-click:eq(0)").attr("rel");
			$('#patients').data('second',id);
			if(id == undefined) {
				return false;
			}
			setModuleActive($("#patients2"),'0');
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/patients&request=getPatientDetails&id="+id, success: function(text){
				$("#"+patients.name+"-right").html(text.html);
				initPatientsContentScrollbar()
				}
			});
			}
		});
	}


	this.sortdrag = function (order) {
		var fid = $("#patients .module-click:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", data: "path=apps/patients&request=setPatientOrder&"+order+"&id="+fid, success: function(html){
			$("#patients2 .sort").attr("rel", "3");
			$("#patients2 .sort").removeClass("sort1").removeClass("sort2").addClass("sort3");
			}
		});
	}
	
	
	this.actionDialog = function(offset,request,field,append,title,sql) {
		switch(request) {
			case "getPatientDialog":
				$.ajax({ type: "GET", url: "/", data: 'path=apps/patients&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
					$("#modalDialog").html(html);
					$("#modalDialog").dialog('option', 'position', offset);
					$("#modalDialog").dialog('option', 'title', title);
					$("#modalDialog").dialog('open');
					}
				});
			break;
			case "getPatientDialogInsuranceAdd":
				$.ajax({ type: "GET", url: "/", data: 'path=apps/patients&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
					$("#modalDialog").html(html);
					$("#modalDialog").dialog('option', 'position', offset);
					$("#modalDialog").dialog('option', 'title', title);
					$("#modalDialog").dialog('open');
					}
				});
			break;
			case "getContactsImportDialog":
				$.ajax({ type: "GET", url: "/", data: 'path=apps/patients&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
					$("#modalDialog").html(html);
					$("#modalDialog").dialog('option', 'position', offset);
					$("#modalDialog").dialog('option', 'title', title);
					$("#modalDialog").dialog('open');
					}
				});
			break;
			case "getPatientCatDialog":
				$.ajax({ type: "GET", url: "/", data: 'path=apps/patients&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
					$("#modalDialog").html(html);
					$("#modalDialog").dialog('option', 'position', offset);
					$("#modalDialog").dialog('option', 'title', title);
					$("#modalDialog").dialog('open');
					}
				});
			break;
			case "getDocumentsDialog":
				var id = $("#patients").data("second");
				$.ajax({ type: "GET", url: "/", data: 'path=apps/patients/modules/documents&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql+'&id='+ id, success: function(html){
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


	this.insertStatusDate = function(rel,text) {
		var html = '<div class="listmember" field="patientsstatus" uid="'+rel+'" style="float: left">' + text + '</div>';
		$("#patientsstatus").html(html);
		$("#modalDialog").dialog("close");
		$("#patientsstatus").nextAll('img').trigger('click');
	}
	
	
	/*this.insertPatientFromDialog = function(field,gid,title) {
		var html = '<a class="listmember" uid="' + gid + '" field="'+field+'">' + title + '</a>';
		$("#"+field).html(html);
		$("#modalDialog").dialog('close');
		var obj = getCurrentModule();
		$('#patients .coform').ajaxSubmit(obj.poformOptions);
	}*/
	
	
	this.insertFromDialog = function(field,gid,title) {
		var html = '<span class="listmember-outer"><a class="listmemberInsurance" uid="' + gid + '" field="'+field+'">' + title + '</a></div>';
		$("#"+field).html(html);
		$("#modalDialog").dialog('close');
		var obj = getCurrentModule();
		$('#patients .coform').ajaxSubmit(obj.poformOptions);
	}
	
	this.actionHelp = function() {
		var url = "/?path=apps/patients&request=getPatientsHelp";
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
			submit: function(e,v,m,f){		
				if(v){
					$.ajax({ type: "GET", url: "/", data: "path=apps/patients&request=deletePatient&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#patient_'+id).slideUp();
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/patients&request=restorePatient&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#patient_'+id).slideUp();
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
		var pid = $('#patients').data('second');
		switch(action) {
			case 'new':
				$.ajax({ type: "GET", url: "/", data: "path=apps/patients&request=newCheckpoint&id=" + pid + "&date=" + date, cache: false });
			break;
			case 'update':
				$.ajax({ type: "GET", url: "/", data: "path=apps/patients&request=updateCheckpoint&id=" + pid + "&date=" + date, cache: false });			
			break;
			case 'delete':
				$.ajax({ type: "GET", url: "/", data: "path=apps/patients&request=deleteCheckpoint&id=" + pid, cache: false });
			break;
		}
	}
	
	
	this.saveCheckpointText = function() {
		var pid = $('#patients').data('second');
		var text = $('#patientsCheckpoint textarea').val();
		$.ajax({ type: "POST", url: "/", data: "path=apps/patients&request=updateCheckpointText&id=" + pid + "&text=" + text, cache: false });
	}

}

var patients = new patientsApplication('patients');
//patients.resetModuleHeights = patientsresetModuleHeights;
patients.modules_height = patients_num_modules*module_title_height;
patients.GuestHiddenModules = new Array("access");

// register folder object
function patientsFolders(name) {
	this.name = name;
	
	
	this.formProcess = function(formData, form, poformOptions) {
		var title = $("#patients input.title").fieldValue();
		if(title == "") {
			$.prompt(ALERT_NO_TITLE, {submit: setTitleFocus});
			return false;
		} else {
			formData[formData.length] = { "name": "title", "value": title };
		}
	}
	
	
	this.formResponse = function(data) {
		switch(data.action) {
			case "edit":
				$("#patients1 span[rel='"+data.id+"'] .text").html($("#patients .title").val());
			break;
		}
	}


	this.poformOptions = { beforeSubmit: this.formProcess, dataType: 'json', success: this.formResponse };

	
	this.actionNew = function() {
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/patients&request=newFolder", cache: false, success: function(data){
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/patients&request=getFolderList", success: function(list){
				$("#patients1 ul").html(list.html);
				$("#patients1 li").show();
				var index = $("#patients1 .module-click").index($("#patients1 .module-click[rel='"+data.id+"']"));
				setModuleActive($("#patients1"),index);
				$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/patients&request=getFolderDetails&id="+data.id, success: function(text){
					$("#patients").data("first",data.id);					
					$("#"+patients.name+"-right").html(text.html);
					initPatientsContentScrollbar();
					$('#patients-right .focusTitle').trigger('click');
					}
				});
				patientsActions(9);
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
			submit: function(e,v,m,f){		
				if(v){
					var id = $("#patients").data("first");
					$.ajax({ type: "GET", url: "/", data: "path=apps/patients&request=binFolder&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/patients&request=getFolderList", success: function(data){
								$("#patients1 ul").html(data.html);
								if(data.html == "<li></li>") {
									patientsActions(3);
								} else {
									patientsActions(9);
								}
								var id = $("#patients1 .module-click:eq(0)").attr("rel");
								if(typeof id == 'undefined') {
									$("#patients").data("first",0);
								} else {
									$("#patients").data("first",id);
								}
								$("#patients1 .module-click:eq(0)").addClass('active-link');
								$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/patients&request=getFolderDetails&id="+id, success: function(text){
									$("#"+patients.name+"-right").html(text.html);
									initPatientsContentScrollbar();
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
		var id = $("#patients").data("first");
		$("#patients1 .active-link").trigger("click");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/patients&request=getFolderList", success: function(data){
			$("#patients1 ul").html(data.html);
			if(data.access == "guest") {
				patientsActions();
			} else {
				if(data.html == "<li></li>") {
					patientsActions(3);
				} else {
					patientsActions(9);
				}
			}
			var idx = $("#patients1 .module-click").index($("#patients1 .module-click[rel='"+id+"']"));
			$("#patients1 .module-click:eq("+idx+")").addClass('active-link');
			}
		});
	}
	

	this.actionPrint = function() {
		var id = $("#patients").data("first");
		var url ='/?path=apps/patients&request=printFolderDetails&id='+id;
		$("#documentloader").attr('src', url);
	}


	this.actionSend = function() {
		var id = $("#patients").data("first");
		$.ajax({ type: "GET", url: "/", data: "path=apps/patients&request=getFolderSend&id="+id, success: function(html){
			$("#modalDialogForward").html(html).dialog('open');
			}
		});
	}


	this.actionSendtoResponse = function() {
			//$("#modalDialogForward").dialog('close');
	}

	
	this.sortclick = function (obj,sortcur,sortnew) {
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/patients&request=getFolderList&sort="+sortnew, success: function(data){
			$("#patients1 ul").html(data.html);
			obj.attr("rel",sortnew);
		  	obj.removeClass("sort"+sortcur).addClass("sort"+sortnew);
			var id = $("#patients1 .module-click:eq(0)").attr("rel");
			$('#patients').data('first',id);			
			$("#patients1 .module-click:eq(0)").addClass('active-link');
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/patients&request=getFolderDetails&id="+id, success: function(text){
				$("#patients-right").html(text.html);
				initPatientsContentScrollbar()
				}
			});
			}
		});
	}


	this.sortdrag = function (order) {
		$.ajax({ type: "GET", url: "/", data: "path=apps/patients&request=setFolderOrder&"+order, success: function(html){
			$("#patients1 .sort").attr("rel", "3");
			$("#patients1 .sort").removeClass("sort1").removeClass("sort2").addClass("sort3");
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


	this.actionHelp = function() {
		var url = "/?path=apps/patients&request=getPatientsFoldersHelp";
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
			submit: function(e,v,m,f){		
				if(v){
					$.ajax({ type: "GET", url: "/", data: "path=apps/patients&request=deleteFolder&id=" + id, cache: false, success: function(data){
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
			submit: function(e,v,m,f){		
				if(v){
					$.ajax({ type: "GET", url: "/", data: "path=apps/patients&request=restoreFolder&id=" + id, cache: false, success: function(data){
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

var patients_folder = new patientsFolders('patients_folder');


function patientsActions(status) {
	/*	0= new	1= print	2= send		3= duplicate	4= handbook		5=refresh 	6 = delete*/
	var obj = getCurrentModule();
	switch(status) {
		case 0: 
			if(obj.name == 'patients') {
				actions = ['1','2','3','5','6','7','8']; 
			} else {
				actions = ['0','2','3','4','5','6','7','8']; 
			}
		break;
		case 1: actions = ['0','5','6','7']; break;
		case 3: 
			if(obj.name == 'patients') {
				actions = ['1','6','7']; 
			} else {
				actions = ['0','5','6','7']; 
			}
		break;
		case 4: 	actions = ['0','1','2','6','7','8']; break;
		case 5: 	actions = ['2','3','6','7']; break;
		case 6: 	actions = ['5','7','8']; break;   			// handbook refresh
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
	$('#patientsActions > li span').each( function(index) {
		if(index in oc(actions)) {
			$(this).removeClass('noactive');
		} else {
			$(this).addClass('noactive');
		}
	})
}

var patientsLayout, patientsInnerLayout;


$(document).ready(function() {
	
	patients.init();
	
	if($('#patients').length > 0) {
		patientsLayout = $('#patients').layout({
				west__onresize:				function() { resetModuleHeightsnavThree('patients'); }
			,	resizeWhileDragging:		true
			,	spacing_open:				0
			,	spacing_closed:				0
			,	closable: 					false
			,	resizable: 					false
			,	slidable:					false
			, 	west__size:					325
			,	west__closable: 			true
			,	center__onresize: "patientsInnerLayout.resizeAll"
			
		});
		
		patientsInnerLayout = $('#patients div.ui-layout-center').layout({
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

		loadModuleStartnavThree('patients');
	}


	$("#patients1-outer").on('click', 'h3', function(e, passed_id) {
		e.preventDefault();
		navThreeTitleFirst('patients',$(this),passed_id)
		prevent_dblclick(e)
	}).disableSelection();


	$("#patients2-outer").on('click', 'h3', function(e, passed_id) {
		e.preventDefault();
		navThreeTitleSecond('patients',$(this),passed_id)
		prevent_dblclick(e)
	}).disableSelection();


	$("#patients3").on('click', 'h3', function(e, passed_id) {
		e.preventDefault();
		navThreeTitleThird('patients',$(this),passed_id)
		prevent_dblclick(e)
	}).disableSelection();


	$('#patients1').on('click', 'span.module-click',function(e) {
		e.preventDefault();
		navItemFirst('patients',$(this))
		prevent_dblclick(e)
	});


	$('#patients2').on('click', 'span.module-click',function(e) {
		e.preventDefault();
		navItemSecond('patients',$(this))
		prevent_dblclick(e)
	});


	$('#patients3').on('click', 'span.module-click',function(e) {
		e.preventDefault();
		navItemThird('patients',$(this))
		prevent_dblclick(e)
	});


	$(document).on('click', 'a.insertPatientFolderfromDialog', function(e) {
		e.preventDefault();
		var field = $(this).attr("field");
		var gid = $(this).attr("gid");
		var title = $(this).attr("title");
		var obj = getCurrentModule();
		obj.insertFromDialog(field,gid,title);
	});
	
	
// INTERLINKS FROM Content
	
	// load a patient
	$(document).on('click', '.loadPatient', function(e) {	
		e.preventDefault();
		var obj = getCurrentModule();
		if(confirmNavigation()) {
			formChanged = false;
			$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		}
		var id = $(this).attr("rel");
		$("#patients2-outer > h3").trigger('click', [id]);
	});
	
	$(document).on('click', 'a.listmemberInsurance', function(e) {
		e.preventDefault();
		var ele = $(this);
		var uid = $(this).attr('uid');
		var field = $(this).attr('field');
		var edit = $(this).attr('edit');
		$.ajax({ type: "GET", url: "/", data: "path=apps/patients&request=getInsuranceContext&id="+uid+"&field="+field+"&edit="+edit, success: function(html){
			ele.parent().append(html);
			ele.next().slideDown();
			}
		});
	});


// autocomplete patients search
	$('.patients-search').livequery(function() {
		var id = $("#patients").data("second");
		$(this).autocomplete({
			appendTo: '#tabs-1',
			source: "?path=apps/patients&request=getPatientsSearch&exclude="+id,
			//minLength: 2,
			select: function(event, ui) {
				var obj = getCurrentModule();
				obj.addParentLink(ui.item.id);
			},
			close: function(event, ui) {
				$(this).val("");
			}
		});
	});
	
	$(document).on('click', '.addPatientLink', function(e) {
		e.preventDefault();
		var id = $(this).attr("rel");
		var obj = getCurrentModule();
		obj.addParentLink(id);
	});

});