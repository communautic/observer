function initClientsContentScrollbar() {
	clientsInnerLayout.initContent('center');
}

/* clients Object */
function clientsApplication(name) {
	this.name = name;
	

	this.init = function() {
		this.$app = $('#clients');
		this.$appContent = $('#clients-right');
		this.$first = $('#clients1');
		this.$second = $('#clients2');
		this.$third = $('#clients3');
		this.$thirdDiv = $('#clients3 div.thirdLevel');
		this.$layoutWest = $('#clients div.ui-layout-west');
	}
	
	
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


	this.poformOptions = { async: false, beforeSubmit: this.formProcess, dataType: 'json', success: this.formResponse };


	this.actionClose = function() {
		clientsLayout.toggle('west');
	}


	this.getNavModulesNumItems = function(id) {
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: 'path=apps/clients&request=getNavModulesNumItems&id=' + id, success: function(data){
				$.each( data, function(k, v){
   					$('#'+k).html(v);
 				});
			}
		});
	}

	
	this.actionNew = function() {
		var module = this;
		var cid = $('#clients input[name="id"]').val()
		module.checkIn(cid);
		var id = $('#clients').data('first');
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: 'path=apps/clients&request=newClient&id=' + id, cache: false, success: function(data){
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/clients&request=getClientList&id="+id, success: function(list){
				$("#clients2 ul").html(list.html);
				var index = $("#clients2 .module-click").index($("#clients2 .module-click[rel='"+data.id+"']"));
				setModuleActive($("#clients2"),index);
				$('#clients').data({ "second" : data.id });				
				$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/clients&request=getClientDetails&id="+data.id, success: function(text){
					$("#clients-right").html(text.html);
					initClientsContentScrollbar();
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
		var pid = $("#clients").data("second");
		var oid = $("#clients").data("first");
		$.ajax({ type: "GET", url: "/", data: 'path=apps/clients&request=createDuplicate&id=' + pid, cache: false, success: function(id){
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/clients&request=getClientList&id="+oid, success: function(data){
				$("#clients2 ul").html(data.html);
					clientsActions(0);
					var idx = $("#clients2 .module-click").index($("#clients2 .module-click[rel='"+id+"']"));
					setModuleActive($("#clients2"),idx)
					$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/clients&request=getClientDetails&id="+id, success: function(text){
						$("#clients").data("second",id);							
						$("#"+clients.name+"-right").html(text.html);
							initClientsContentScrollbar();
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
					var id = $("#clients").data("second");
					var fid = $("#clients").data("first");
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
								$("#clients").data("second", id);								
								$("#clients2 .module-click:eq(0)").addClass('active-link');
								$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/clients&request=getClientDetails&fid="+fid+"&id="+id, success: function(text){
									$("#clients-right").html(text.html);
									initClientsContentScrollbar();
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
		var oid = $('#clients').data('first');
		var pid = $('#clients').data('second');
		$("#clients2 .active-link").trigger("click");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/clients&request=getClientList&id="+oid, success: function(data){
			$("#clients2 ul").html(data.html);
			var idx = $("#clients2 .module-click").index($("#clients2 .module-click[rel='"+pid+"']"));
			$("#clients2 .module-click:eq("+idx+")").addClass('active-link');
			}
		});
	}

	this.actionPrint = function() {
		var id = $("#clients").data("second");
		var url ='/?path=apps/clients&request=printClientDetails&id='+id;
		$("#documentloader").attr('src', url);
	}


	this.actionSend = function() {
		var id = $("#clients").data("second");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/clients&request=getClientSend&id="+id, success: function(data){
			$("#modalDialogForward").html(data.html).dialog('open');
			if(data.error == 1) {
				$.prompt('<div style="text-align: center">' + ALERT_REMOVE_RECIPIENT + data.error_message + '<br /></div>');
				return false;
			}
			}
		});
	}


	this.actionSendtoResponse = function() {
		var id = $("#clients").data("second");
		$.ajax({ type: "GET", url: "/", data: "path=apps/clients&request=getSendtoDetails&id="+id, success: function(html){
			$("#client_sendto").html(html);
			//$("#modalDialogForward").dialog('close');
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
			$('#clients').data('second',id);
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


	this.datepickerOnClose = function(dp) {
		var obj = getCurrentModule();
		$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
	}

}

var clients = new clientsApplication('clients');
//clients.resetModuleHeights = clientsresetModuleHeights;
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


	this.poformOptions = { async: false, beforeSubmit: this.formProcess, dataType: 'json', success: this.formResponse };

	
	this.actionNew = function() {
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/clients&request=newFolder", cache: false, success: function(data){
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/clients&request=getFolderList", success: function(list){
				$("#clients1 ul").html(list.html);
				$("#clients1 li").show();
				var index = $("#clients1 .module-click").index($("#clients1 .module-click[rel='"+data.id+"']"));
				setModuleActive($("#clients1"),index);
				$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/clients&request=getFolderDetails&id="+data.id, success: function(text){
					$("#clients").data("first",data.id);					
					$("#"+clients.name+"-right").html(text.html);
					initClientsContentScrollbar();
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
					var id = $("#clients").data("first");
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
								$("#clients").data("first",id);								
								$("#clients1 .module-click:eq(0)").addClass('active-link');
								$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/clients&request=getFolderDetails&id="+id, success: function(text){
									$("#"+clients.name+"-right").html(text.html);
									initClientsContentScrollbar();
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
		var id = $("#clients").data("first");
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
			}
		});
	}


	this.actionExport = function() {
		var id = $("#clients").data("first");
		$.ajax({ type: "GET", url: "/", data: "path=apps/clients&request=getExportWindow&id="+id, success: function(html){
			$("#modalDialogClientsCreateExcel").html(html).dialog('open');
			}
		});
	}


	this.actionDoExport = function() {
		var folderid = $("#clients").data("first");
		var menueid = $("#clientsExportMenue .listmember").attr("uid");
		if (menueid === undefined) {
			$('#autoopenExportMenue').trigger('click');
			return false;
		} else {
			$("#modalDialogClientsCreateExcel").dialog('close');
			var url ='/?path=apps/clients/modules/orders&request=createExcel&folderid='+folderid+'&menueid='+menueid;
			$("#documentloader").attr('src', url);
		}
	}
	

	this.actionPrint = function() {
		var id = $("#clients").data("first");
		var url ='/?path=apps/clients&request=printFolderDetails&id='+id;
		$("#documentloader").attr('src', url);
	}


	this.actionSend = function() {
		var id = $("#clients").data("first");
		$.ajax({ type: "GET", url: "/", data: "path=apps/clients&request=getFolderSend&id="+id, success: function(html){
			$("#modalDialogForward").html(html).dialog('open');
			}
		});
	}


	this.actionSendtoResponse = function() {
			//$("#modalDialogForward").dialog('close');
	}

	
	this.sortclick = function (obj,sortcur,sortnew) {
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/clients&request=getFolderList&sort="+sortnew, success: function(data){
			$("#clients1 ul").html(data.html);
			obj.attr("rel",sortnew);
		  	obj.removeClass("sort"+sortcur).addClass("sort"+sortnew);
			var id = $("#clients1 .module-click:eq(0)").attr("rel");
			$('#clients').data('first',id);			
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
		//case 11:	actions = ['4','5','6']; break;
		default: 	actions = ['4','5','6'];  								// none
	}
	$('#clientsActions > li span').each( function(index) {
		if(index in oc(actions)) {
			$(this).removeClass('noactive');
		} else {
			$(this).addClass('noactive');
		}
	})
}

var clientsLayout, clientsInnerLayout;


$(document).ready(function() {
	
	clients.init();
	
	if($('#clients').length > 0) {
		clientsLayout = $('#clients').layout({
				west__onresize:				function() { resetModuleHeightsnavThree('clients'); }
			,	resizeWhileDragging:		true
			,	spacing_open:				0
			,	spacing_closed:				0
			,	closable: 					false
			,	resizable: 					false
			,	slidable:					false
			, 	west__size:					325
			,	west__closable: 			true
			,	center__onresize: "clientsInnerLayout.resizeAll"
			
		});
		
		clientsInnerLayout = $('#clients div.ui-layout-center').layout({
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

		loadModuleStartnavThree('clients');
	}


	$("#clients1-outer").on('click', 'h3', function(e, passed_id) {
		e.preventDefault();
		navThreeTitleFirst('clients',$(this),passed_id)
		prevent_dblclick(e)
	}).disableSelection();


	$("#clients2-outer").on('click', 'h3', function(e, passed_id) {
		e.preventDefault();
		navThreeTitleSecond('clients',$(this),passed_id)
		prevent_dblclick(e)
	}).disableSelection();


	$("#clients3").on('click', 'h3', function(e, passed_id) {
		e.preventDefault();
		navThreeTitleThird('clients',$(this),passed_id)
		prevent_dblclick(e)
	}).disableSelection();


	$('#clients1').on('click', 'span.module-click',function(e) {
		e.preventDefault();
		navItemFirst('clients',$(this))
		prevent_dblclick(e)
	});


	$('#clients2').on('click', 'span.module-click',function(e) {
		e.preventDefault();
		navItemSecond('clients',$(this))
		prevent_dblclick(e)
	});


	$('#clients3').on('click', 'span.module-click',function(e) {
		e.preventDefault();
		navItemThird('clients',$(this))
		prevent_dblclick(e)
	});


	$(document).on('click', 'a.insertClientFolderfromDialog', function(e) {
		e.preventDefault();
		var field = $(this).attr("field");
		var gid = $(this).attr("gid");
		var title = $(this).attr("title");
		var obj = getCurrentModule();
		obj.insertFolderFromDialog(field,gid,title);
	});
	
	
// INTERLINKS FROM Content
	
	// load a client
	$(document).on('click', '.loadClient', function(e) {	
		e.preventDefault();
		var obj = getCurrentModule();
		if(confirmNavigation()) {
			formChanged = false;
			$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		}
		var id = $(this).attr("rel");
		$("#clients2-outer > h3").trigger('click', [id]);
	});

	$(document).on('click', '#actionAccessOrders', function(e) {	
		e.preventDefault();
		var div = $(this).attr("rel");
		var id = parseInt(div.replace(/client_/, ""));
		var cid = $("#clients2 .active-link:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", data: "path=apps/clients&request=generateAccess&id=" + id + "&cid=" + cid, cache: false, success: function(data){
			$("#"+div).html(data);
			var prev = $("#"+div).parent().prev().find('span').attr('sql','0');
			$("#modalDialog").dialog('close');
			}																																			
		});
	});

	$(document).on('click', '#actionAccessOrdersRemove', function(e) {	
		e.preventDefault();
		var div = $(this).attr("rel");
		var id = parseInt(div.replace(/client_/, ""));
		$.ajax({ type: "GET", url: "/", data: "path=apps/clients&request=removeAccess&id=" + id, cache: false, success: function(data){
			$("#"+div).html(data);
			var prev = $("#"+div).parent().prev().find('span').attr('sql','1');
			$("#modalDialog").dialog('close');
			}
		});
	});
	
	
	$("#modalDialogClientsCreateExcel").dialog({  
		dialogClass: 'ClientsExportWindow',
		autoOpen: false,
		resizable: true,
		width: 400,  
		height: 320,
		show: 'slide',
		hide: 'slide'
	})

	$('#clients .globalSearch').livequery(function() {
		$(this).autocomplete({
			appendTo: '#clients',
			position: {my: "left top", at: "left bottom", collision: "none",offset: "-104 0"},
			source: "?path=apps/clients&request=getGlobalSearch",
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