function initClientsContentScrollbar() {
	clientsInnerLayout.initContent('center');
}

/* clients Object */
function clientsApplication(name) {
	this.name = name;
	
	this.formProcess = function(formData, form, poformOptions) {
		var title = $("#clients input.title").fieldValue();
		if(title == "") {
			$.prompt(ALERT_NO_TITLE, {callback: setTitleFocus});
			return false;
		} else {
			formData[formData.length] = { "name": "title", "value": title };
		}
	
		formData[formData.length] = processListApps('folder');
		formData[formData.length] = processListApps('management');
		formData[formData.length] = processCustomTextApps('management_ct');
		formData[formData.length] = processListApps('team');
		formData[formData.length] = processCustomTextApps('team_ct');
		formData[formData.length] = processListApps('address');
		formData[formData.length] = processCustomTextApps('address_ct');
		formData[formData.length] = processListApps('billingaddress');
		formData[formData.length] = processCustomTextApps('billingaddress_ct');
		formData[formData.length] = processListApps('contract');
	}

	
	this.formResponse = function(data) {
		switch(data.action) {
			case "edit":
				$("#clients2 span[rel='"+data.id+"'] .text").html($("#clients .title").val());
				$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/clients&request=getClientDetails&id="+data.id, success: function(text){
					$("#clients-right").html(text.html);
						initClientsContentScrollbar();
					}
				});
				//$("#durationStart").html($("input[name='startdate']").val());
				/*switch(data.status) {
					case "2":
						$("#clients2 .active-link .module-item-status").addClass("module-item-active").removeClass("module-item-active-stopped");
					break;
					case "3":
						$("#clients2 .active-link .module-item-status").addClass("module-item-active-stopped").removeClass("module-item-active");
					break;
					default:
						$("#clients2 .active-link .module-item-status").removeClass("module-item-active").removeClass("module-item-active-stopped");
				}*/
			break;
			case "reload":
				$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/clients&request=getClientDetails&id="+data.id, success: function(text){
					$("#clients-right").html(text.html);
						initClientsContentScrollbar();
					}
				});
			break;
		}
	}


	this.poformOptions = { beforeSubmit: this.formProcess, dataType: 'json', success: this.formResponse };


	this.actionNew = function() {
		var module = this;
		var cid = $('#clients input[name="id"]').val()
		module.checkIn(cid);
		var id = $('#'+clients.name+' .module-click:visible').attr("rel");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: 'path=apps/clients&request=newClient&id=' + id, cache: false, success: function(data){
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/clients&request=getClientList&id="+id, success: function(list){
				$("#clients2 ul").html(list.html);
				var index = $("#clients2 .module-click").index($("#clients2 .module-click[rel='"+data.id+"']"));
				setModuleActive($("#clients2"),index);
				$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/clients&request=getClientDetails&id="+data.id, success: function(text){
					$("#clients-right").html(text.html);
					initClientsContentScrollbar();
					$('#clients2 input.filter').quicksearch('#clients2 li');
					$('#clients-right .focusTitle').trigger('click');
					}
				});
				clientsActions(0);
				}
			});
			}
		});
	}


	this.actionDuplicate = function() {
		var module = this;
		var cid = $('#clients input[name="id"]').val()
		module.checkIn(cid);
		var pid = $("#clients2 .active-link").attr("rel");
		var oid = $("#clients1 .module-click:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", data: 'path=apps/clients&request=createDuplicate&id=' + pid, cache: false, success: function(id){
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/clients&request=getClientList&id="+oid, success: function(data){
				$("#clients2 ul").html(data.html);
					clientsActions(0);
					$('#clients2 input.filter').quicksearch('#clients2 li');
					var idx = $("#clients2 .module-click").index($("#clients2 .module-click[rel='"+id+"']"));
					setModuleActive($("#clients2"),idx)
					$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/clients&request=getClientDetails&id="+id, success: function(text){
							$("#"+clients.name+"-right").html(text.html);
							initClientsContentScrollbar();
							$('#clients2 input.filter').quicksearch('#clients2 li');
						}
					});
				}
			});
			}
		});
	}


	this.actionBin = function() {
		var module = this;
		var cid = $('#clients input[name="id"]').val()
		module.checkIn(cid);
		var txt = ALERT_DELETE;
		var langbuttons = {};
		langbuttons[ALERT_YES] = true;
		langbuttons[ALERT_NO] = false;
		$.prompt(txt,{ 
			buttons:langbuttons,
			callback: function(v,m,f){		
				if(v){
					var id = $("#clients2 .active-link").attr("rel");
					var fid = $("#clients .module-click:visible").attr("rel");
					$.ajax({ type: "GET", url: "/", data: "path=apps/clients&request=binClient&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/clients&request=getClientList&id="+fid, success: function(list){
								$("#clients2 ul").html(list.html);
								if(list.html == "<li></li>") {
									clientsActions(3);
								} else {
									clientsActions(0);
									setModuleActive($("#clients2"),0);
								}
								var id = $("#clients2 .module-click:eq(0)").attr("rel");
								$("#clients2 .module-click:eq(0)").addClass('active-link');
								$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/clients&request=getClientDetails&fid="+fid+"&id="+id, success: function(text){
									$("#clients-right").html(text.html);
									initClientsContentScrollbar();
									$('#clients2 input.filter').quicksearch('#clients2 li');
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
		$.ajax({ type: "GET", url: "/", async: false, data: 'path=apps/clients&request=checkinClient&id='+id, success: function(data){
				if(!data) {
					prompt("something wrong");
				}
			}
		});
	}


	this.actionRefresh = function() {
		var pid = $("#clients2 .active-link").attr("rel");
		var oid = $("#clients1 .module-click:visible").attr("rel");
		$("#clients2 .active-link:visible").trigger("click");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/clients&request=getClientList&id="+oid, success: function(data){
			$("#clients2 ul").html(data.html);
			var idx = $("#clients2 .module-click").index($("#clients2 .module-click[rel='"+pid+"']"));
			$("#clients2 .module-click:eq("+idx+")").addClass('active-link');
			$('#clients2 input.filter').quicksearch('#clients3 li');
			}
		});
	}

	this.actionPrint = function() {
		var id = $("#clients2 .active-link").attr("rel");
		var url ='/?path=apps/clients&request=printClientDetails&id='+id;
		location.href = url;
	}


	this.actionSend = function() {
		var id = $("#clients2 .active-link").attr("rel");
		$.ajax({ type: "GET", url: "/", data: "path=apps/clients&request=getClientSend&id="+id, success: function(html){
			$("#modalDialogForward").html(html).dialog('open');
			}
		});
	}


	this.actionSendtoResponse = function() {
		var id = $("#clients2 .active-link").attr("rel");
		$.ajax({ type: "GET", url: "/", data: "path=apps/clients&request=getSendtoDetails&id="+id, success: function(html){
			$("#client_sendto").html(html);
			$("#modalDialogForward").dialog('close');
			}
		});
	}


	this.sortclick = function (obj,sortcur,sortnew) {
		var module = this;
		var cid = $('#clients input[name="id"]').val()
		module.checkIn(cid);
		var fid = $("#clients .module-click:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/clients&request=getClientList&id="+fid+"&sort="+sortnew, success: function(data){
			$("#clients2 ul").html(data.html);
			obj.attr("rel",sortnew);
			obj.removeClass("sort"+sortcur).addClass("sort"+sortnew);
			var id = $("#clients2 .module-click:eq(0)").attr("rel");
			$('#clients2').find('input.filter').quicksearch('#clients2 li');
			if(id == undefined) {
				return false;
			}
			setModuleActive($("#clients2"),'0');
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/clients&request=getClientDetails&id="+id, success: function(text){
				$("#"+clients.name+"-right").html(text.html);
				initClientsContentScrollbar()
				}
			});
			}
		});
	}


	this.sortdrag = function (order) {
		var fid = $("#clients .module-click:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", data: "path=apps/clients&request=setClientOrder&"+order+"&id="+fid, success: function(html){
			$("#clients2 .sort").attr("rel", "3");
			$("#clients2 .sort").removeClass("sort1").removeClass("sort2").addClass("sort3");
			}
		});
	}
	
	
	this.actionDialog = function(offset,request,field,append,title,sql) {
		switch(request) {
			case "getClientContractDialog":
				$.ajax({ type: "GET", url: "/", data: 'path=apps/clients&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
					$("#modalDialog").html(html);
					$("#modalDialog").dialog('option', 'position', offset);
					$("#modalDialog").dialog('option', 'title', title);
					$("#modalDialog").dialog('open');
					}
				});
			break;
			case "getAccessOrdersDialog":
				$.ajax({ type: "GET", url: "/", data: 'path=apps/clients&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
					$("#modalDialog").html(html);
					$("#modalDialog").dialog('option', 'position', offset);
					$("#modalDialog").dialog('option', 'title', title);
					$("#modalDialog").dialog('open');
					}
				});
			break;
			default:
			$.ajax({ type: "GET", url: "/", data: 'path=apps/clients&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
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
		var html = '<div class="listmember" field="clientsstatus" uid="'+rel+'" style="float: left">' + text + '</div>';
		$("#clientsstatus").html(html);
		$("#modalDialog").dialog("close");
		$("#clientsstatus").nextAll('img').trigger('click');
	}
	
	this.insertContract = function(rel,text) {
		var module = this;
		var html = '<div class="listmember" field="clientscontract" uid="'+rel+'" style="float: left">' + text + '</div>';
		$("#clientscontract").html(html);
		$("#modalDialog").dialog("close");
		$('#clients .coform').ajaxSubmit(module.poformOptions);
	}
	
	
	this.insertFolderFromDialog = function(field,gid,title) {
		var html = '<a class="listmember" uid="' + gid + '" field="'+field+'">' + title + '</a>';
		$("#"+field).html(html);
		$("#modalDialog").dialog('close');
		var obj = getCurrentModule();
		$('#clients .coform').ajaxSubmit(obj.poformOptions);
	}
	
	this.actionHelp = function() {
		var url = "/?path=apps/clients&request=getClientsHelp";
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/clients&request=deleteClient&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#client_'+id).slideUp();
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/clients&request=restoreClient&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#client_'+id).slideUp();
						}
					}
					});
				} 
			}
		});
	}


}

var clients = new clientsApplication('clients');
clients.resetModuleHeights = clientsresetModuleHeights;
clients.modules_height = clients_num_modules*module_title_height;
clients.GuestHiddenModules = new Array("access");

// register folder object
function clientsFolders(name) {
	this.name = name;
	
	
	this.formProcess = function(formData, form, poformOptions) {
		var title = $("#clients input.title").fieldValue();
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
				$("#clients1 span[rel='"+data.id+"'] .text").html($("#clients .title").val());
			break;
		}
	}


	this.poformOptions = { beforeSubmit: this.formProcess, dataType: 'json', success: this.formResponse };

	
	this.actionNew = function() {
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/clients&request=newFolder", cache: false, success: function(data){
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/clients&request=getFolderList", success: function(list){
				$("#clients1 ul").html(list.html);
				$("#clients1 li").show();
				var index = $("#clients1 .module-click").index($("#clients1 .module-click[rel='"+data.id+"']"));
				setModuleActive($("#clients1"),index);
				$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/clients&request=getFolderDetails&id="+data.id, success: function(text){
					$("#"+clients.name+"-right").html(text.html);
					initClientsContentScrollbar();
					$('#clients1 input.filter').quicksearch('#clients1 li');
					$('#clients-right .focusTitle').trigger('click');
					}
				});
				clientsActions(9);
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
					var id = $("#clients1 .active-link").attr("rel");
					$.ajax({ type: "GET", url: "/", data: "path=apps/clients&request=binFolder&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/clients&request=getFolderList", success: function(data){
								$("#clients1 ul").html(data.html);
								if(data.html == "<li></li>") {
									clientsActions(3);
								} else {
									clientsActions(9);
								}
								var id = $("#clients1 .module-click:eq(0)").attr("rel");
								$("#clients1 .module-click:eq(0)").addClass('active-link');
								$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/clients&request=getFolderDetails&id="+id, success: function(text){
									$("#"+clients.name+"-right").html(text.html);
									initClientsContentScrollbar();
									$('#clients1 input.filter').quicksearch('#clients1 li');
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
		var id = $("#clients1 .active-link").attr("rel");
		$("#clients1 .active-link").trigger("click");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/clients&request=getFolderList", success: function(data){
			$("#clients1 ul").html(data.html);
			if(data.access == "guest") {
				clientsActions();
			} else {
				if(data.html == "<li></li>") {
					clientsActions(3);
				} else {
					clientsActions(9);
				}
			}
			var idx = $("#clients1 .module-click").index($("#clients1 .module-click[rel='"+id+"']"));
			$("#clients1 .module-click:eq("+idx+")").addClass('active-link');
			$('#clients1 input.filter').quicksearch('#clients1 li');
			}
		});
	}


	this.actionExport = function() {
		var id = $("#clients1 .active-link").attr("rel");
		$.ajax({ type: "GET", url: "/", data: "path=apps/clients&request=getExportWindow&id="+id, success: function(html){
			$("#modalDialogClientsCreateExcel").html(html).dialog('open');
			}
		});
	}


	this.actionDoExport = function() {
		var folderid = $("#clients1 .active-link").attr("rel");
		var menueid = $("#clientsExportMenue .listmember").attr("uid");
		if (menueid === undefined) {
			$('#autoopenExportMenue').trigger('click');
			return false;
		} else {
			$("#modalDialogClientsCreateExcel").dialog('close');
			var url ='/?path=apps/clients/modules/orders&request=createExcel&folderid='+folderid+'&menueid='+menueid;
			location.href = url;
		}
	}
	

	this.actionPrint = function() {
		var id = $("#clients1 .active-link").attr("rel");
		var url ='/?path=apps/clients&request=printFolderDetails&id='+id;
		location.href = url;
	}


	this.actionSend = function() {
		var id = $("#clients1 .active-link").attr("rel");
		$.ajax({ type: "GET", url: "/", data: "path=apps/clients&request=getFolderSend&id="+id, success: function(html){
			$("#modalDialogForward").html(html).dialog('open');
			}
		});
	}


	this.actionSendtoResponse = function() {
		//var id = $("#clients1 .active-link").attr("rel");
		//$.ajax({ type: "GET", url: "/", data: "path=apps/clients&request=getSendtoDetails&id="+id, success: function(html){
			//$("#client_sendto").html(html);
			$("#modalDialogForward").dialog('close');
			//}
		//});
	}

	
	this.sortclick = function (obj,sortcur,sortnew) {
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/clients&request=getFolderList&sort="+sortnew, success: function(data){
			$("#clients1 ul").html(data.html);
			obj.attr("rel",sortnew);
		  	obj.removeClass("sort"+sortcur).addClass("sort"+sortnew);
			$('#clients1 input.filter').quicksearch('#clients1 li');
			var id = $("#clients1 .module-click:eq(0)").attr("rel");
			$("#clients1 .module-click:eq(0)").addClass('active-link');
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/clients&request=getFolderDetails&id="+id, success: function(text){
				$("#clients-right").html(text.html);
				initClientsContentScrollbar()
				}
			});
			}
		});
	}


	this.sortdrag = function (order) {
		$.ajax({ type: "GET", url: "/", data: "path=apps/clients&request=setFolderOrder&"+order, success: function(html){
			$("#clients1 .sort").attr("rel", "3");
			$("#clients1 .sort").removeClass("sort1").removeClass("sort2").addClass("sort3");
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
				$.ajax({ type: "GET", url: "/", data: 'path=apps/clients&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
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
		var url = "/?path=apps/clients&request=getClientsFoldersHelp";
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/clients&request=deleteFolder&id=" + id, cache: false, success: function(data){
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/clients&request=restoreFolder&id=" + id, cache: false, success: function(data){
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

var clients_folder = new clientsFolders('clients_folder');


function clientsActions(status) {
	/*	0= new	1= print	2= send		3= duplicate	4= handbook		5=refresh 	6 = delete*/
	switch(status) {
		//case 0: 	actions = ['0','1','2','3','4']; break; // all actions
		case 0: actions = ['0','1','2','3','5','6','7']; break;
		//case 1: 	actions = ['0','1','2','4']; break; 	// no duplicate
		case 1: actions = ['0','5','6','7']; break;
		//case 2: 	actions = ['1']; break;   					// just save
		case 3: 	actions = ['0','5','6']; break;   					// just new
		case 4: 	actions = ['0','1','2','5','6','7']; break;   		// new, print, send, handbook, refresh
		case 5: 	actions = ['1','2','5','6']; break;   			// print, send, refresh
		case 6: 	actions = ['5','6']; break;   			// handbook refresh
		case 7: 	actions = ['0','1','2','5','6']; break;   			// new, print, send, refresh
		case 8: 	actions = ['1','2','5','6']; break;   			// print, send, handbook, refresh
		case 9:		actions = ['0','1','2','4','5','6','7']; break;
		// orders
		case 10:	actions = ['1','2','5','6','7']; break;   			// print, send, refresh, help, delete
		
		default: 	actions = ['5','6'];  								// none
	}
	$('#clientsActions > li span').each( function(index) {
		if(index in oc(actions)) {
			$(this).removeClass('noactive');
		} else {
			$(this).addClass('noactive');
		}
	})
}


function clientsloadModuleStart() {
	var h = $("#clients .ui-layout-west").height();
	$("#clients1 .module-inner").css("height", h-71);
	$("#clients1 .module-actions").show();
	$("#clients2 .module-actions").hide();
	$("#clients2 li").show();
	$("#clients2").css("height", h-96).removeClass("module-active");
	$("#clients2 .module-inner").css("height", h-96);
	$("#clients3 .module-actions").hide();
	$("#clients3").css("height", h-121);
	$("#clients3 .clients3-content").css("height", h-(clients.modules_height+121));
	$("#clients-current").val("folder");
	$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/clients&request=getFolderList", success: function(data){
		$("#clients1 ul").html(data.html);
		$("#clientsActions .actionNew").attr("title",data.title);
		
		if(data.access == "guest") {
			clientsActions();
		} else {
			if(data.html == "<li></li>") {
				clientsActions(3);
			} else {
				clientsActions(9);
			}
		}
		
		$("#clients1").css("overflow", "auto").animate({height: h-71}, function() {
			$("#clients1 li").show();
			$("#clients1 .sort").attr("rel", data.sort).addClass("sort"+data.sort);
			clientsInnerLayout.initContent('center');
			//initScrollbar( '#clients .scrolling-content' );
			$('#clients1 input.filter').quicksearch('#clients1 li');
			$("#clients3 .clients3-content").hide();
			var id = $("#clients1 .module-click:eq(0)").attr("rel");
			$("#clients1 .module-click:eq(0)").addClass('active-link');
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/clients&request=getFolderDetails&id="+id, success: function(text){
				$("#"+clients.name+"-right").html(text.html);
				clientsInnerLayout.initContent('center');
				$('#clients1 input.filter').quicksearch('#clients1 li');
				$("#clients3 .clients3-content").hide();
				}
			});
		});
	}
	});
}


function clientsresetModuleHeights() {
	
	var h = $("#clients .ui-layout-west").height();
	if($("#clients1").height() != module_title_height) {
		$("#clients1").css("height", h-71);
		$("#clients1 .module-inner").css("height", h-71);
	}
	if($("#clients2").height() != module_title_height) {
		//$("#clients2").css("height", h-96);
		$("#clients2 .module-inner").css("height", h-96);
		$("#clients2").css("overflow", "auto").animate({height: h-(clients.modules_height+96)}, function() {
			$(this).find('.west-ui-content	').height(h-(clients.modules_height+96));																							   
		});
	}
	$("#clients3").css("height", h-121);
	$("#clients3 .clients3-content").css("height", h-(clients.modules_height+121));
	//initScrollbar( '#clients .scrolling-content' );
}

function ClientsModulesDisplay(access) {
	var h = $("#clients .ui-layout-west").height();
	if(access == "guest" || access == "guestadmin") {
		var modLen = clients.GuestHiddenModules.length;
		var m;
		for(var i=0, len=modLen; i<len; ++i) {
			m = $('h3[rel="'+clients.GuestHiddenModules[i]+'"]');
			m.hide();
		}
		clients.modules_height = clients_num_modules*module_title_height - modLen*module_title_height;
		$("#clients3 .clients3-content").css("height", h-(clients.modules_height+121));
	} else {
		var modLen = clients.GuestHiddenModules.length;
		var m;
		for(var i=0, len=modLen; i<len; ++i) {
			m = $('h3[rel="'+clients.GuestHiddenModules[i]+'"]');
			m.show();
		}
		clients.modules_height = clients_num_modules*module_title_height;
		$("#clients3 .clients3-content").css("height", h-(clients.modules_height+121));
	}
}


var clientsLayout, clientsInnerLayout;

$(document).ready(function() {
						   
	if($('#clients').length > 0) {
		clientsLayout = $('#clients').layout({
				west__onresize:				function() { clientsresetModuleHeights() }
			,	resizeWhileDragging:		true
			,	spacing_open:				0
			,	closable: 				false
			,	resizable: 				false
			,	slidable:				false
			, 	west__size:				325
			,	west__closable: 		true
			,	west__resizable: 		true
			, 	south__size:			10
			,	center__onresize: "clientsInnerLayout.resizeAll"
			
		});
		
		clientsInnerLayout = $('#clients div.ui-layout-center').layout({
				center__onresize:				function() {  }
			,	resizeWhileDragging:		false
			,	spacing_open:				0			// cosmetic spacing
			,	closable: 				false
			,	resizable: 				false
			,	slidable:				false
			,	north__paneSelector:	".center-north"
			,	center__paneSelector:	".center-center"
			,	west__paneSelector:	".center-west"
			, 	north__size:			80
			, 	west__size:			50
			 
	
		});
		
		clientsloadModuleStart();
	}

	$("#clients1-outer > h3").click(function(event, passed_id) {
		var obj = getCurrentModule();
		if(confirmNavigation()) {
			formChanged = false;
			$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		}
		var cid = $('#clients input[name="id"]').val()
		obj.checkIn(cid);
		
		if($(this).hasClass("module-bg-active")) {
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/clients&request=getFolderList", success: function(data){
				$("#clients1 ul").html(data.html);
				if(data.access == "guest") {
					clientsActions();
				} else {
					if(data.html == "<li></li>") {
						clientsActions(3);
					} else {
						clientsActions(9);
					}
				}
				//initScrollbar( '#clients .scrolling-content' );
				$('#clients1 input.filter').quicksearch('#clients1 li');
				if(passed_id === undefined) {
						var id = $("#clients1 .module-click:eq(0)").attr("rel");
						$("#clients1 .module-click:eq(0)").addClass('active-link');
					} else {
						var id = passed_id;
						$("#clients1 .module-click[rel='"+id+"']").addClass('active-link');
					}
				
				
				//$("#clients1 .drag:eq(0)").show();
				$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/clients&request=getFolderDetails&id="+id, success: function(text){
					$("#clients-right").html(text.html);
					//clientsInnerLayout.initContent('center');
					initClientsContentScrollbar();
					var h = $("#clients .ui-layout-west").height();
					$("#clients1").delay(200).animate({height: h-46}, function() {
						$(this).animate({height: h-71});			 
					});
					}
				 });
				}
			});
		} else {
			var h = $("#clients .ui-layout-west").height();
			var id = $("#clients1 .module-click:visible").attr("rel");
			var index = $("#clients1 .module-click").index($("#clients1 .module-click[rel='"+id+"']"));
			
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/clients&request=getFolderList", success: function(data){
				$("#clients1 ul").html(data.html);
				if(data.access == "guest") {
					clientsActions();
				} else {
					if(data.html == "<li></li>") {
						clientsActions(3);
					} else {
						clientsActions(9);
					}
				}
				$('#clients1 input.filter').quicksearch('#clients1 li');
				$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/clients&request=getFolderDetails&id="+id, success: function(text){
					$("#clients1 li").show();
					setModuleActive($("#clients1"),index);
					
					$("#clients1").css("overflow", "auto").animate({height: h-46}, function() {
						$("#"+clients.name+"-right").html(text.html);
						//initScrollbar( '#clients .scrolling-content' );
						$("#clients-current").val("folder");
						setModuleDeactive($("#clients2"),'0');
						setModuleDeactive($("#clients3"),'0');
						$("#clients2 li").show();
						$("#clients2").css("height", h-96).removeClass("module-active");
						$("#clients2").prev("h3").removeClass("white");
						$("#clients2 .module-inner").css("height", h-96);
						$("#clients3 h3").removeClass("module-bg-active");
						$("#clients3 .clients3-content:visible").slideUp();
						initClientsContentScrollbar();
						$("#clients1").delay(200).animate({height: h-71});
					});
					}
				 });
				}
			});
		}
		$("#clients-top .top-headline").html("");
		$("#clients-top .top-subheadline").html("");
		$("#clients-top .top-subheadlineTwo").html("");
		return false;
	});


	$("#clients2-outer > h3").click(function(event, passed_id) {
		var obj = getCurrentModule();
		if(confirmNavigation()) {
			formChanged = false;
			$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		}
		var cid = $('#clients input[name="id"]').val()
		obj.checkIn(cid);
		
		if($(this).hasClass("module-bg-active")) {
			$("#clients1-outer > h3").trigger("click");
		} else {
			if($("#clients2").height() == module_title_height) {
				var h = $("#clients .ui-layout-west").height();
				var id = $("#clients1 .module-click:visible").attr("rel");
				var clientid = $("#clients2 .module-click:visible").attr("rel");
				var index = $("#clients2 .module-click").index($("#clients2 .module-click[rel='"+clientid+"']"));
				$("#clients3 .module-actions:visible").hide();
				$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/clients&request=getClientList&id="+id, success: function(data){
					$("#clients2 ul").html(data.html);
					$("#clientsActions .actionNew").attr("title",data.title);
					
					$("#clients2 li").show();
					setModuleActive($("#clients2"),index);
					$("#clients2 .sort").attr("rel", data.sort).addClass("sort"+data.sort);
					$('#clients2 input.filter').quicksearch('#clients2 li');
					$("#clients2").css("overflow", "auto").animate({height: h-(clients.modules_height+96)}, function() {
					$(this).find('.west-ui-content	').height(h-(clients.modules_height+96));
					$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/clients&request=getClientDetails&id="+clientid, success: function(text){
						$("#clients-right").html(text.html);

						switch (text.access) {
									case "sysadmin":
										if(data.html == "<li></li>") {
											clientsActions(3);
										} else {
											clientsActions(0);
											$('#clients2').find('input.filter').quicksearch('#clients2 li');
										}
									break;
									case "admin":
										if(data.html == "<li></li>") {
											clientsActions(3);
										} else {
											clientsActions(0);
											$('#clients2').find('input.filter').quicksearch('#clients2 li');
										}
									break;
									case "guestadmin":
										if(data.html == "<li></li>") {
											clientsActions(3);
										} else {
											clientsActions(7);
											$('#clients2').find('input.filter').quicksearch('#clients2 li');
										}
									break;
									case "guest":
										if(data.html == "<li></li>") {
											clientsActions();
										} else {
											clientsActions(5);
											$('#clients2').find('input.filter').quicksearch('#clients2 li');
										}
									break;
								}
						initClientsContentScrollbar();
						}
					});
					$("#clients3 h3").removeClass("module-bg-active");
					});
					$(".clients3-content").slideUp();
					}
				});
			} else {
				var id = $("#clients1 .active-link").attr("rel");
				if(id == undefined) {
					return false;
				}
				var index = $("#clients1 .module-click").index($("#clients1 .module-click[rel='"+id+"']"));
				$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/clients&request=getClientList&id="+id, success: function(data){
					$("#clients2 ul").html(data.html);
					$("#clientsActions .actionNew").attr("title",data.title);
					if(passed_id === undefined) {
						var clientid = $("#clients2 .module-click:eq(0)").attr("rel");
					} else {
						var clientid = passed_id;					
					}
				
					if($("#clients1").height() != module_title_height) {
						var idx = $("#clients2 .module-click").index($("#clients2 .module-click[rel='"+clientid+"']"));
						setModuleActive($("#clients2"),idx);
						$("#clients2 .sort").attr("rel", data.sort).addClass("sort"+data.sort);
						setModuleDeactive($("#clients1"),index);
						$("#clients1").css("overflow", "hidden").animate({height: module_title_height}, function() {
							$("#clients-top .top-headline").html($("#clients .module-click:visible").find(".text").html());
							$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/clients&request=getClientDetails&id="+clientid, success: function(text){
								$("#clients-right").html(text.html);

								switch (text.access) {
									case "sysadmin":
										if(data.html == "<li></li>") {
											clientsActions(3);
										} else {
											clientsActions(0);
											$('#clients2').find('input.filter').quicksearch('#clients2 li');
										}
									break;
									case "admin":
										if(data.html == "<li></li>") {
											clientsActions(3);
										} else {
											clientsActions(0);
											$('#clients2').find('input.filter').quicksearch('#clients2 li');
										}
									break;
									case "guestadmin":
										if(data.html == "<li></li>") {
											clientsActions(3);
										} else {
											clientsActions(7);
											$('#clients2').find('input.filter').quicksearch('#clients2 li');
										}
									break;
									case "guest":
										if(data.html == "<li></li>") {
											clientsActions();
										} else {
											clientsActions(5);
											$('#clients2').find('input.filter').quicksearch('#clients2 li');
										}
									break;
								}
								initClientsContentScrollbar();
								var h = $("#clients .ui-layout-west").height();
								if(text.access != "sysadmin") { ClientsModulesDisplay(text.access); }
								$("#clients2").delay(200).animate({height: h-(clients.modules_height+96)}, function() {
									$(this).find('.west-ui-content	').height(h-(clients.modules_height+96));																			  
									});
								}
							});
						});
					} else {
						$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/clients&request=getClientDetails&id="+clientid, success: function(text){
							$("#"+clients.name+"-right").html(text.html);
							initClientsContentScrollbar();
							}
						});
					}
					}
				});
			}
		}
		$("#clients-current").val("clients");
		$("#clients-top .top-subheadline").html("");
		$("#clients-top .top-subheadlineTwo").html("");
		return false;
	});


	$("#clients1 .module-click").live('click',function(e) {
		if($(this).hasClass("deactivated")) {
			$("#clients1-outer > h3").trigger("click");
			return false;
		}
		var obj = getCurrentModule();
		if(confirmNavigation()) {
			formChanged = false;
			$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		}
		var cid = $('#clients input[name="id"]').val()
		obj.checkIn(cid);
		
		var id = $(this).attr("rel");
		var index = $("#clients .module-click").index(this);
		$("#clients .module-click").removeClass("active-link");
		$(this).addClass("active-link");

		var h = $("#clients .ui-layout-west").height();
		$("#clients1").delay(200).animate({height: h-46}, function() {
			$(this).animate({height: h-71});
		});
			
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/clients&request=getFolderDetails&id="+id, success: function(text){
			$("#clients-right").html(text.html);
			clientsInnerLayout.initContent('center');
			if(text.access == "guest") {
					clientsActions();
				} else {
					clientsActions(9);
				}
			}
		});
		
		return false;
	});


	$("#clients2 .module-click").live('click',function(e) {
		if($(this).hasClass("deactivated")) {
			$("#clients2-outer > h3").trigger("click");
			return false;
		}
		var obj = getCurrentModule();
		if(confirmNavigation()) {
			formChanged = false;
			$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		}
		var cid = $('#clients input[name="id"]').val()
		obj.checkIn(cid);
		
		var fid = $("#clients .module-click:visible").attr("rel");
		var id = $(this).attr("rel");
		var index = $("#clients .module-click").index(this);
		$("#clients .module-click").removeClass("active-link");
		$(this).addClass("active-link");
		$("#clients-top .top-headline").html($("#clients .module-click:visible").find(".text").html());
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/clients&request=getClientDetails&fid="+fid+"&id="+id, success: function(text){
			$("#clients-right").html(text.html);
			
			if($('#checkedOut').length > 0) {
				$("#clients2 .active-link .icon-checked-out").addClass('icon-checked-out-active');
			} else {
				$("#clients2 .active-link .icon-checked-out").removeClass('icon-checked-out-active');
			}
			switch (text.access) {
				case "sysadmin":
					clientsActions(0);
				break;
				case "admin":
					clientsActions(0);
				break;
				case "guestadmin":
					clientsActions(7);
				break;
				case "guest":
					clientsActions(5);
				break;
			}

			initClientsContentScrollbar();
			
			var h = $("#clients .ui-layout-west").height();
			$("#clients2").delay(200).animate({height: h-96}, function() {
				if(text.access != "sysadmin") { ClientsModulesDisplay(text.access); }
				$(this).animate({height: h-(clients.modules_height+96)}, function() {
				$(this).find('.west-ui-content	').height(h-(clients.modules_height+96));									   
				});			 
			});
			
			}
			
		});
		return false;
	});


	$("#clients3 .module-click").live('click',function() {
		var obj = getCurrentModule();
		if(confirmNavigation()) {
			formChanged = false;
			$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		}
		var cid = $('#clients input[name="id"]').val()
		obj.checkIn(cid);
		
		var id = $(this).attr("rel");
		var ulidx = $("#clients3 ul").index($(this).parents("ul"));
		var index = $("#clients3 ul:eq("+ulidx+") .module-click").index($("#clients3 ul:eq("+ulidx+") .module-click[rel='"+id+"']"));
		$("#clients3 .module-click").removeClass("active-link");
		$(this).addClass("active-link");
		
		var obj = getCurrentModule();
		var list = 0;
		obj.getDetails(ulidx,index,list);
		 return false;
	});


	$("#clients3 h3").click(function(event, passed_id) {
		var obj = getCurrentModule();
		if(confirmNavigation()) {
			formChanged = false;
			$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		}
		var cid = $('#clients input[name="id"]').val()
		obj.checkIn(cid);
		
		var moduleidx = $("#clients3 h3").index(this);
		var module = $(this).attr("rel");
		var h3click = $(this);
		// module open and  active 
		if($(this).hasClass("module-bg-active")) {
			$("#clients2-outer > h3").trigger("click");
		} else {
			// module 3 allready activated
			if($("#clients2").height() == module_title_height) {
				var id = $("#clients2 .module-click:visible").attr("rel");
				$("#clients3 h3").removeClass("module-bg-active");
				
				h3click.addClass("module-bg-active")
					.next('div').slideDown( function() {
						$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/clients/modules/"+module+"&request=getList&id="+id, success: function(data){
							$("#clients3 ul:eq("+moduleidx+")").html(data.html);
							$("#clientsActions .actionNew").attr("title",data.title);
							switch (data.perm) {
				case "sysadmin": case "admin" :
					if(data.html == "<li></li>") {
						clientsActions(3);
					} else {
						clientsActions(0);
						$('#clients3').find('input.filter').quicksearch('#clients3 li');
					}
				break;
				case "guest":
					if(data.html == "<li></li>") {
						clientsActions();
					} else {
						clientsActions(5);
						$('#clients3').find('input.filter').quicksearch('#clients3 li');
					}
				break;
			}
							
							
							if(passed_id === undefined) {
								var idx = 0;
							} else {
								var idx = $("#clients3 ul:eq("+moduleidx+") .module-click").index($("#clients3 ul:eq("+moduleidx+") .module-click[rel='"+passed_id+"']"));
							}

							$("#clients3 ul:eq("+moduleidx+") .module-click:eq("+idx+")").addClass('active-link');
							$("#clients3 .module-actions:visible").hide();
							var obj = getCurrentModule();
							obj.getDetails(moduleidx,idx,data.html);
							$(this).prev("h3").removeClass("module-bg-active");	
							$("#clients3 .module-actions:eq("+moduleidx+")").show();
							$("#clients3 .sort:eq("+moduleidx+")").attr("rel", data.sort).addClass("sort"+data.sort);
							}
						});			 
					})
					.siblings('div:visible').slideUp()
				
			} else {
				// load and slide up module 3
				var id = $("#clients2 .active-link").attr("rel");
				if(id == undefined) {
					return false;
				}
				var index = $("#clients2 .module-click").index($("#clients2 .module-click[rel='"+id+"']"));
	
				$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/clients/modules/"+module+"&request=getList&id="+id, success: function(data){
					$("#clients3 ul:eq("+moduleidx+")").html(data.html);
					$("#clientsActions .actionNew").attr("title",data.title);
					switch (data.perm) {
				case "sysadmin": case "admin" :
					if(data.html == "<li></li>") {
						clientsActions(3);
					} else {
						clientsActions(0);
						$('#clients3').find('input.filter').quicksearch('#clients3 li');
					}
				break;
				case "guest":
					if(data.html == "<li></li>") {
						clientsActions();
					} else {
						clientsActions(5);
						$('#clients3').find('input.filter').quicksearch('#clients3 li');
					}
				break;
			}
					
					
					if(passed_id === undefined) {
						var idx = 0;
					} else {
						var idx = $("#clients3 ul:eq("+moduleidx+") .module-click").index($("#clients3 ul:eq("+moduleidx+") .module-click[rel='"+passed_id+"']"));
					}
					
					$("#clients3 ul:eq("+moduleidx+") .module-click:eq("+idx+")").addClass('active-link');
					$("#clients3 .module-actions:visible").hide();
					setModuleDeactive($("#clients2"),index);
					$("#clients2").css("overflow", "hidden").animate({height: module_title_height}, function() {
						$("#clients-top .top-subheadline").html($("#clients2 .module-click:visible").find(".text").html());
						$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/clients&request=getDates&id="+id, success: function(data){
							//$("#clients-top .top-subheadlineTwo").html(data.startdate + ' - <span id="clientenddate">' + data.enddate + '</span>');
						}
						});
					});
					h3click.addClass("module-bg-active")
						.next('div').slideDown(function() {
							var obj = getCurrentModule();
							obj.getDetails(moduleidx,idx,data.html);
							$("#clients3 .sort:eq("+moduleidx+")").attr("rel", data.sort).addClass("sort"+data.sort);
							$("#clients3 .module-actions:eq("+moduleidx+")").show();
						})
					}
				});
			}
			$("#clients-current").val(module);
		}
		return false;
	});

 
    /*$("#clients .loadModuleStart").click(function() {
		loadModuleStart();
		return false;
	});*/
  
	
	/*$('a.insertAccess').live('click',function() {
		var rel = $(this).attr("rel");
		var field = $(this).attr("field");
		var html = '<div class="listmember" field="'+field+'" uid="'+rel+'">' + $(this).html() + '</div>';
		$("#"+field).html(html);
		$("#modalDialog").dialog("close");
		var obj = getCurrentModule();
		$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		return false;
	});*/
	
	
	
	$('a.insertClientFolderfromDialog').livequery('click',function(e) {
		e.preventDefault();
		var field = $(this).attr("field");
		var gid = $(this).attr("gid");
		var title = $(this).attr("title");
		var obj = getCurrentModule();
		obj.insertFolderFromDialog(field,gid,title);
	});
	

	/*$('a.insertClientFolderfromDialog').livequery('click',function() {
		var field = $(this).attr("field");
		var gid = $(this).attr("gid");
		var title = $(this).attr("title");
		var html = '<a class="listmember" uid="' + gid + '" field="'+field+'">' + title + '</a>';
		$("#"+field).html(html);
		$("#modalDialog").dialog('close');
		var obj = getCurrentModule();
		$('#clients .coform').ajaxSubmit(obj.poformOptions);
	});*/
	
	
// INTERLINKS FROM Content
	
	
	/*$("a.insertContract").live('click', function(e) {
		e.preventDefault();
		clients.insertContract();
	});*/
	
	
	// load a client
	$(".loadClient").live('click', function() {
		
		var obj = getCurrentModule();
		if(confirmNavigation()) {
			formChanged = false;
			$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		}
		
		var id = $(this).attr("rel");
		$("#clients2-outer > h3").trigger('click', [id]);
		return false;
	});

	
	// load a phase
	$(".loadClientsPhase").live('click', function() {
		
		var obj = getCurrentModule();
		if(confirmNavigation()) {
			formChanged = false;
			$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		}
		var cid = $('#clients input[name="id"]').val()
		obj.checkIn(cid);
		
		var id = $(this).attr("rel");
		$("#clients3 h3[rel='phases']").trigger('click', [id]);
		return false;
	});
	
	$(".loadClientsPhase2").live('click', function() {
		var id = $(this).attr("rel");
		$("#clients3 h3[rel='phases']").trigger('click', [id]);
		return false;
	});


	$('span.actionClientHandbook').click(function(){
		if($(this).hasClass("noactive")) {
			return false;
		}
		clients.actionHandbook();
		return false;
	});

	
	// barchart opacity with jquery
	$(".barchart-phase-bg").livequery( function() {
		$(this).css("opacity","0.3");
	});

	$("#todayBar").livequery( function() {
		$(this).css("opacity","0.4");
	});
	// becomes global Tooltip?
	$(".coTooltip").livequery( function() {
		$(this).tooltip({
			track: true,
			delay: 0,
			fade: 200,
			bodyHandler: function() { 
				return $(this).find(".coTooltipHtml").html(); 
			}, 
			showURL: false 
		});
	});
	
	
	$('#actionAccessOrders').live("click", function(){
		var div = $(this).attr("rel");
		var id = parseInt(div.replace(/client_/, ""));
		var cid = $("#clients2 .active-link:visible").attr("rel");
		
		$.ajax({ type: "GET", url: "/", data: "path=apps/clients&request=generateAccess&id=" + id + "&cid=" + cid, cache: false, success: function(data){
			/*$.ajax({ type: "GET", url: "/", data: "path=apps/contacts&request=getContactDetails&id="+id, success: function(html){
				$("#contacts-right").html(html);
				contactsInnerLayout.initContent('center');
				}
			});*/
			$("#"+div).html(data);
			var prev = $("#"+div).parent().prev().find('span').attr('sql','0');
			$("#modalDialog").dialog('close');
			}																																			
		});
		return false;
	});
	
	$('#actionAccessOrdersRemove').live("click", function(){
		var div = $(this).attr("rel");
		var id = parseInt(div.replace(/client_/, ""));
		
		$.ajax({ type: "GET", url: "/", data: "path=apps/clients&request=removeAccess&id=" + id, cache: false, success: function(data){
			/*$.ajax({ type: "GET", url: "/", data: "path=apps/contacts&request=getContactDetails&id="+id, success: function(html){
				$("#contacts-right").html(html);
				contactsInnerLayout.initContent('center');
				}
			});*/
			$("#"+div).html(data);
			var prev = $("#"+div).parent().prev().find('span').attr('sql','1');
			$("#modalDialog").dialog('close');
			}
		});
		return false;
	});
	
	
	$("#modalDialogClientsCreateExcel").dialog({  
		dialogClass: 'ClientsExportWindow',
		autoOpen: false,
		resizable: true,
		/*resize: function(event, ui) {
			$('#sendToTextarea').height($(this).height() - 154);
			},
		open: function(event, ui) {
			$('#sendToTextarea').height($(this).height() - 154);
			},*/
		width: 400,  
		height: 320,
		show: 'slide',
		hide: 'slide'
	})


});