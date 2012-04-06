function initComplaintsContentScrollbar() {
	complaintsInnerLayout.initContent('center');
}

/* complaints Object */
function complaintsApplication(name) {
	this.name = name;
	

	this.init = function() {
		this.$app = $('#complaints');
		this.$appContent = $('#complaints-right');
		this.$first = $('#complaints1');
		this.$second = $('#complaints2');
		this.$third = $('#complaints3');
		this.$thirdDiv = $('#complaints3 div.thirdLevel');
		this.$layoutWest = $('#complaints div.ui-layout-west');
	}
	
	
	this.formProcess = function(formData, form, poformOptions) {
		var title = $("#complaints input.title").fieldValue();
		if(title == "") {
			$.prompt(ALERT_NO_TITLE, {callback: setTitleFocus});
			return false;
		} else {
			formData[formData.length] = { "name": "title", "value": title };
		}
	
		formData[formData.length] = processListApps('folder');
		formData[formData.length] = processListApps('ordered_by');
		formData[formData.length] = processCustomTextApps('ordered_by_ct');
		formData[formData.length] = processListApps('management');
		formData[formData.length] = processCustomTextApps('management_ct');
		formData[formData.length] = processListApps('team');
		formData[formData.length] = processCustomTextApps('team_ct');
		formData[formData.length] = processListApps('complaint');
		formData[formData.length] = processListApps('complaintcat');
		formData[formData.length] = processListApps('status');
	}

	
	this.formResponse = function(data) {
		switch(data.action) {
			case "edit":
				$("#complaints2 span[rel='"+data.id+"'] .text").html($("#complaints .title").val());
				$("#complaintDurationStart").html($("#complaints-right input[name='startdate']").val());
				switch(data.status) {
					case "2":
						$("#complaints2 .active-link .module-item-status").addClass("module-item-active").removeClass("module-item-active-stopped");
						$("#complaintDurationEnd").html($("#complaints-right input[name='status_date']").val());
					break;
					case "3":
						$("#complaints2 .active-link .module-item-status").addClass("module-item-active-stopped").removeClass("module-item-active");
						$("#complaintDurationEnd").html($("#complaints-right input[name='status_date']").val());
					break;
					default:
						$("#complaints2 .active-link .module-item-status").removeClass("module-item-active").removeClass("module-item-active-stopped");
				}
			break;
		}
	}


	this.poformOptions = { async: false, beforeSubmit: this.formProcess, dataType: 'json', success: this.formResponse };


	this.actionClose = function() {
		complaintsLayout.toggle('west');
	}


	this.getNavModulesNumItems = function(id) {
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: 'path=apps/complaints&request=getNavModulesNumItems&id=' + id, success: function(data){
				$.each( data, function(k, v){
   					$('#'+k).html(v);
 				});
			}
		});
	}

	
	this.actionNew = function() {
		var module = this;
		var cid = $('#complaints input[name="id"]').val()
		module.checkIn(cid);
		var id = $('#complaints').data('first');
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: 'path=apps/complaints&request=newComplaint&id=' + id, cache: false, success: function(data){
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/complaints&request=getComplaintList&id="+id, success: function(list){
				$("#complaints2 ul").html(list.html);
				var index = $("#complaints2 .module-click").index($("#complaints2 .module-click[rel='"+data.id+"']"));
				setModuleActive($("#complaints2"),index);
				$('#complaints').data({ "second" : data.id });				
				$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/complaints&request=getComplaintDetails&id="+data.id, success: function(text){
					$("#complaints-right").html(text.html);
					initComplaintsContentScrollbar();
					$('#complaints-right .focusTitle').trigger('click');
					}
				});
				complaintsActions(0);
				}
			});
			}
		});
	}


	this.actionDuplicate = function() {
		var module = this;
		var cid = $('#complaints input[name="id"]').val()
		module.checkIn(cid);
		var pid = $("#complaints").data("second");
		var oid = $("#complaints").data("first");
		$.ajax({ type: "GET", url: "/", data: 'path=apps/complaints&request=createDuplicate&id=' + pid, cache: false, success: function(id){
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/complaints&request=getComplaintList&id="+oid, success: function(data){
				$("#complaints2 ul").html(data.html);
					complaintsActions(0);
					var idx = $("#complaints2 .module-click").index($("#complaints2 .module-click[rel='"+id+"']"));
					setModuleActive($("#complaints2"),idx)
					$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/complaints&request=getComplaintDetails&id="+id, success: function(text){
						$("#complaints").data("second",id);							
						$("#"+complaints.name+"-right").html(text.html);
							initComplaintsContentScrollbar();
						}
					});
				}
			});
			}
		});
	}


	this.actionBin = function() {
		var module = this;
		var cid = $('#complaints input[name="id"]').val()
		module.checkIn(cid);
		var txt = ALERT_DELETE;
		var langbuttons = {};
		langbuttons[ALERT_YES] = true;
		langbuttons[ALERT_NO] = false;
		$.prompt(txt,{ 
			buttons:langbuttons,
			callback: function(v,m,f){		
				if(v){
					var id = $("#complaints").data("second");
					var fid = $("#complaints").data("first");
					$.ajax({ type: "GET", url: "/", data: "path=apps/complaints&request=binComplaint&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/complaints&request=getComplaintList&id="+fid, success: function(list){
								$("#complaints2 ul").html(list.html);
								if(list.html == "<li></li>") {
									complaintsActions(3);
								} else {
									complaintsActions(0);
									setModuleActive($("#complaints2"),0);
								}
								var id = $("#complaints2 .module-click:eq(0)").attr("rel");
								$("#complaints").data("second", id);								
								$("#complaints2 .module-click:eq(0)").addClass('active-link');
								$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/complaints&request=getComplaintDetails&fid="+fid+"&id="+id, success: function(text){
									$("#complaints-right").html(text.html);
									initComplaintsContentScrollbar();
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
		$.ajax({ type: "GET", url: "/", async: false, data: 'path=apps/complaints&request=checkinComplaint&id='+id, success: function(data){
				if(!data) {
					prompt("something wrong");
				}
			}
		});
	}


	this.actionRefresh = function() {
		var oid = $('#complaints').data('first');
		var pid = $('#complaints').data('second');
		$("#complaints2 .active-link").trigger("click");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/complaints&request=getComplaintList&id="+oid, success: function(data){
			$("#complaints2 ul").html(data.html);
			var idx = $("#complaints2 .module-click").index($("#complaints2 .module-click[rel='"+pid+"']"));
			$("#complaints2 .module-click:eq("+idx+")").addClass('active-link');
			}
		});
	}

	this.actionPrint = function() {
		var id = $("#complaints").data("second");
		var url ='/?path=apps/complaints&request=printComplaintDetails&id='+id;
		$("#documentloader").attr('src', url);
	}


	this.actionSend = function() {
		var id = $("#complaints").data("second");
		$.ajax({ type: "GET", url: "/", data: "path=apps/complaints&request=getComplaintSend&id="+id, success: function(html){
			$("#modalDialogForward").html(html).dialog('open');
			}
		});
	}


	this.actionSendtoResponse = function() {
		var id = $("#complaints").data("second");
		$.ajax({ type: "GET", url: "/", data: "path=apps/complaints&request=getSendtoDetails&id="+id, success: function(html){
			$("#complaint_sendto").html(html);
			$("#modalDialogForward").dialog('close');
			}
		});
	}


	this.sortclick = function (obj,sortcur,sortnew) {
		var module = this;
		var cid = $('#complaints input[name="id"]').val()
		module.checkIn(cid);
		var fid = $("#complaints .module-click:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/complaints&request=getComplaintList&id="+fid+"&sort="+sortnew, success: function(data){
			$("#complaints2 ul").html(data.html);
			obj.attr("rel",sortnew);
			obj.removeClass("sort"+sortcur).addClass("sort"+sortnew);
			var id = $("#complaints2 .module-click:eq(0)").attr("rel");
			$('#complaints').data('second',id);
			if(id == undefined) {
				return false;
			}
			setModuleActive($("#complaints2"),'0');
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/complaints&request=getComplaintDetails&id="+id, success: function(text){
				$("#"+complaints.name+"-right").html(text.html);
				initComplaintsContentScrollbar()
				}
			});
			}
		});
	}


	this.sortdrag = function (order) {
		var fid = $("#complaints .module-click:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", data: "path=apps/complaints&request=setComplaintOrder&"+order+"&id="+fid, success: function(html){
			$("#complaints2 .sort").attr("rel", "3");
			$("#complaints2 .sort").removeClass("sort1").removeClass("sort2").addClass("sort3");
			}
		});
	}
	
	
	this.actionDialog = function(offset,request,field,append,title,sql) {
		switch(request) {
			case "getComplaintDialog":
				$.ajax({ type: "GET", url: "/", data: 'path=apps/complaints&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
					$("#modalDialog").html(html);
					$("#modalDialog").dialog('option', 'position', offset);
					$("#modalDialog").dialog('option', 'title', title);
					$("#modalDialog").dialog('open');
					}
				});
			break;
			case "getComplaintCatDialog":
				$.ajax({ type: "GET", url: "/", data: 'path=apps/complaints&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
					$("#modalDialog").html(html);
					$("#modalDialog").dialog('option', 'position', offset);
					$("#modalDialog").dialog('option', 'title', title);
					$("#modalDialog").dialog('open');
					}
				});
			break;
			default:
			$.ajax({ type: "GET", url: "/", data: 'path=apps/complaints&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
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
		var html = '<div class="listmember" field="complaintsstatus" uid="'+rel+'" style="float: left">' + text + '</div>';
		$("#complaintsstatus").html(html);
		$("#modalDialog").dialog("close");
		$("#complaintsstatus").nextAll('img').trigger('click');
	}
	
	
	/*this.insertComplaintFromDialog = function(field,gid,title) {
		var html = '<a class="listmember" uid="' + gid + '" field="'+field+'">' + title + '</a>';
		$("#"+field).html(html);
		$("#modalDialog").dialog('close');
		var obj = getCurrentModule();
		$('#complaints .coform').ajaxSubmit(obj.poformOptions);
	}*/
	
	
	this.insertFromDialog = function(field,gid,title) {
		var html = '<a class="listmember" uid="' + gid + '" field="'+field+'">' + title + '</a>';
		$("#"+field).html(html);
		$("#modalDialog").dialog('close');
		var obj = getCurrentModule();
		$('#complaints .coform').ajaxSubmit(obj.poformOptions);
	}
	
	this.actionHelp = function() {
		var url = "/?path=apps/complaints&request=getComplaintsHelp";
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/complaints&request=deleteComplaint&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#complaint_'+id).slideUp();
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/complaints&request=restoreComplaint&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#complaint_'+id).slideUp();
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
		var pid = $('#complaints').data('second');
		switch(action) {
			case 'new':
				$.ajax({ type: "GET", url: "/", data: "path=apps/complaints&request=newCheckpoint&id=" + pid + "&date=" + date, cache: false });
			break;
			case 'update':
				$.ajax({ type: "GET", url: "/", data: "path=apps/complaints&request=updateCheckpoint&id=" + pid + "&date=" + date, cache: false });			
			break;
			case 'delete':
				$.ajax({ type: "GET", url: "/", data: "path=apps/complaints&request=deleteCheckpoint&id=" + pid, cache: false });
			break;
		}
	}

}

var complaints = new complaintsApplication('complaints');
//complaints.resetModuleHeights = complaintsresetModuleHeights;
complaints.modules_height = complaints_num_modules*module_title_height;
complaints.GuestHiddenModules = new Array("access");

// register folder object
function complaintsFolders(name) {
	this.name = name;
	
	
	this.formProcess = function(formData, form, poformOptions) {
		var title = $("#complaints input.title").fieldValue();
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
				$("#complaints1 span[rel='"+data.id+"'] .text").html($("#complaints .title").val());
			break;
		}
	}


	this.poformOptions = { async: false, beforeSubmit: this.formProcess, dataType: 'json', success: this.formResponse };

	
	this.actionNew = function() {
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/complaints&request=newFolder", cache: false, success: function(data){
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/complaints&request=getFolderList", success: function(list){
				$("#complaints1 ul").html(list.html);
				$("#complaints1 li").show();
				var index = $("#complaints1 .module-click").index($("#complaints1 .module-click[rel='"+data.id+"']"));
				setModuleActive($("#complaints1"),index);
				$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/complaints&request=getFolderDetails&id="+data.id, success: function(text){
					$("#complaints").data("first",data.id);					
					$("#"+complaints.name+"-right").html(text.html);
					initComplaintsContentScrollbar();
					$('#complaints-right .focusTitle').trigger('click');
					}
				});
				complaintsActions(9);
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
					var id = $("#complaints").data("first");
					$.ajax({ type: "GET", url: "/", data: "path=apps/complaints&request=binFolder&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/complaints&request=getFolderList", success: function(data){
								$("#complaints1 ul").html(data.html);
								if(data.html == "<li></li>") {
									complaintsActions(3);
								} else {
									complaintsActions(9);
								}
								var id = $("#complaints1 .module-click:eq(0)").attr("rel");
								$("#complaints").data("first",id);								
								$("#complaints1 .module-click:eq(0)").addClass('active-link');
								$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/complaints&request=getFolderDetails&id="+id, success: function(text){
									$("#"+complaints.name+"-right").html(text.html);
									initComplaintsContentScrollbar();
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
		var id = $("#complaints").data("first");
		$("#complaints1 .active-link").trigger("click");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/complaints&request=getFolderList", success: function(data){
			$("#complaints1 ul").html(data.html);
			if(data.access == "guest") {
				complaintsActions();
			} else {
				if(data.html == "<li></li>") {
					complaintsActions(3);
				} else {
					complaintsActions(9);
				}
			}
			var idx = $("#complaints1 .module-click").index($("#complaints1 .module-click[rel='"+id+"']"));
			$("#complaints1 .module-click:eq("+idx+")").addClass('active-link');
			}
		});
	}
	

	this.actionPrint = function() {
		var id = $("#complaints").data("first");
		var url ='/?path=apps/complaints&request=printFolderDetails&id='+id;
		$("#documentloader").attr('src', url);
	}


	this.actionSend = function() {
		var id = $("#complaints").data("first");
		$.ajax({ type: "GET", url: "/", data: "path=apps/complaints&request=getFolderSend&id="+id, success: function(html){
			$("#modalDialogForward").html(html).dialog('open');
			}
		});
	}


	this.actionSendtoResponse = function() {
			$("#modalDialogForward").dialog('close');
	}

	
	this.sortclick = function (obj,sortcur,sortnew) {
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/complaints&request=getFolderList&sort="+sortnew, success: function(data){
			$("#complaints1 ul").html(data.html);
			obj.attr("rel",sortnew);
		  	obj.removeClass("sort"+sortcur).addClass("sort"+sortnew);
			var id = $("#complaints1 .module-click:eq(0)").attr("rel");
			$('#complaints').data('first',id);			
			$("#complaints1 .module-click:eq(0)").addClass('active-link');
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/complaints&request=getFolderDetails&id="+id, success: function(text){
				$("#complaints-right").html(text.html);
				initComplaintsContentScrollbar()
				}
			});
			}
		});
	}


	this.sortdrag = function (order) {
		$.ajax({ type: "GET", url: "/", data: "path=apps/complaints&request=setFolderOrder&"+order, success: function(html){
			$("#complaints1 .sort").attr("rel", "3");
			$("#complaints1 .sort").removeClass("sort1").removeClass("sort2").addClass("sort3");
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
				$.ajax({ type: "GET", url: "/", data: 'path=apps/complaints&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
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
		var url = "/?path=apps/complaints&request=getComplaintsFoldersHelp";
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/complaints&request=deleteFolder&id=" + id, cache: false, success: function(data){
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/complaints&request=restoreFolder&id=" + id, cache: false, success: function(data){
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

var complaints_folder = new complaintsFolders('complaints_folder');


function complaintsActions(status) {
	/*	0= new	1= print	2= send		3= duplicate	4= handbook		5=refresh 	6 = delete*/
	switch(status) {
		//case 0: actions = ['0','1','2','3','5','6']; break;
		case 0: actions = ['0','1','2','3','6','7','8']; break;
		case 1: actions = ['0','6','7','8']; break;
		case 3: 	actions = ['0','6','7']; break;   					// just new
		//case 4: 	actions = ['0','1','2','4','5']; break;   		// new, print, send, handbook, refresh
		case 4: 	actions = ['0','1','2','5','6','7']; break;
		//case 5: 	actions = ['1','2','5']; break;   			// print, send, refresh
		case 5: 	actions = ['1','2','6','7']; break;
		case 6: 	actions = ['6','7']; break;   			// handbook refresh
		//case 7: 	actions = ['0','1','2','5']; break;   			// new, print, send, refresh
		case 7: 	actions = ['0','1','2','6','7']; break;
		//case 8: 	actions = ['1','2','4','5']; break;   			// print, send, handbook, refresh
		case 8: 	actions = ['1','2','5','6','7']; break;
		//case 9: actions = ['0','1','2','3','4','5','6']; break;
		case 9: actions = ['0','1','2','6','7','8']; break;
		
		// vdocs
		// 0 == 10
		case 10: actions = ['0','1','2','3','5','6','7','8']; break;
		// 5 == 11
		case 11: 	actions = ['1','2','5','6','7']; break;   			// print, send, refresh
		
		// rosters
		case 12: actions = ['0','1','2','3','4','6','7','8']; break;
		
		
		default: 	actions = ['6','7'];  								// none
	}
	$('#complaintsActions > li span').each( function(index) {
		if(index in oc(actions)) {
			$(this).removeClass('noactive');
		} else {
			$(this).addClass('noactive');
		}
	})
}

var complaintsLayout, complaintsInnerLayout;


$(document).ready(function() {
	
	complaints.init();
	
	if($('#complaints').length > 0) {
		complaintsLayout = $('#complaints').layout({
				west__onresize:				function() { resetModuleHeightsnavThree('complaints'); }
			,	resizeWhileDragging:		true
			,	spacing_open:				0
			,	spacing_closed:				0
			,	closable: 					false
			,	resizable: 					false
			,	slidable:					false
			, 	west__size:					325
			,	west__closable: 			true
			,	center__onresize: "complaintsInnerLayout.resizeAll"
			
		});
		
		complaintsInnerLayout = $('#complaints div.ui-layout-center').layout({
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

		loadModuleStartnavThree('complaints');
	}


	$("#complaints1-outer").on('click', 'h3', function(e, passed_id) {
		e.preventDefault();
		navThreeTitleFirst('complaints',$(this),passed_id)
		prevent_dblclick(e)
	}).disableSelection();


	$("#complaints2-outer").on('click', 'h3', function(e, passed_id) {
		e.preventDefault();
		navThreeTitleSecond('complaints',$(this),passed_id)
		prevent_dblclick(e)
	}).disableSelection();


	$("#complaints3").on('click', 'h3', function(e, passed_id) {
		e.preventDefault();
		navThreeTitleThird('complaints',$(this),passed_id)
		prevent_dblclick(e)
	}).disableSelection();


	$('#complaints1').on('click', 'span.module-click',function(e) {
		e.preventDefault();
		navItemFirst('complaints',$(this))
		prevent_dblclick(e)
	});


	$('#complaints2').on('click', 'span.module-click',function(e) {
		e.preventDefault();
		navItemSecond('complaints',$(this))
		prevent_dblclick(e)
	});


	$('#complaints3').on('click', 'span.module-click',function(e) {
		e.preventDefault();
		navItemThird('complaints',$(this))
		prevent_dblclick(e)
	});


	$(document).on('click', 'a.insertComplaintFolderfromDialog', function(e) {
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
	
	// load a complaint
	$(document).on('click', '.loadComplaint', function(e) {	
		e.preventDefault();
		var obj = getCurrentModule();
		if(confirmNavigation()) {
			formChanged = false;
			$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		}
		var id = $(this).attr("rel");
		$("#complaints2-outer > h3").trigger('click', [id]);
	});


});