function initProductionsContentScrollbar() {
	productionsInnerLayout.initContent('center');
}

/* productions Object */
function productionsApplication(name) {
	this.name = name;
	
	this.init = function() {
		this.$app = $('#productions');
		this.$appContent = $('#productions-right');
		this.$first = $('#productions1');
		this.$second = $('#productions2');
		this.$third = $('#productions3');
		this.$thirdDiv = $('#productions3 div.thirdLevel');
		this.$layoutWest = $('#productions div.ui-layout-west');
	}


	this.formProcess = function(formData, form, poformOptions) {
		var title = $("#productions input.title").fieldValue();
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
		formData[formData.length] = processListApps('status');
	}

	
	this.formResponse = function(data) {
		switch(data.action) {
			case "edit":
				$("#productions2 span[rel='"+data.id+"'] .text").html($("#productions .title").val());
				$("#productionDurationStart").html($("input[name='startdate']").val());
				switch(data.status) {
					case "2":
						$("#productions2 span[rel='"+data.id+"'] .module-item-status").addClass("module-item-active").removeClass("module-item-active-stopped");
					break;
					case "3":
						$("#productions2 span[rel='"+data.id+"'] .module-item-status").addClass("module-item-active-stopped").removeClass("module-item-active");
					break;
					default:
						$("#productions2 span[rel='"+data.id+"'] .module-item-status").removeClass("module-item-active").removeClass("module-item-active-stopped");
				}
			break;
			case "reload":
				$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/productions&request=getProductionDetails&id="+data.id, success: function(text){
					$("#productions-right").html(text.html);
						initProductionsContentScrollbar();
					}
				});
			break;
		}
	}


	this.poformOptions = { async: false, beforeSubmit: this.formProcess, dataType: 'json', success: this.formResponse };


	this.actionClose = function() {
		productionsLayout.toggle('west');
	}


	this.getNavModulesNumItems = function(id) {
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: 'path=apps/productions&request=getNavModulesNumItems&id=' + id, success: function(data){
				$.each( data, function(k, v){
   					$('#'+k).html(v);
 				});
			}
		});
	}


	this.actionNew = function() {
		var module = this;
		var cid = $('#productions input[name="id"]').val()
		module.checkIn(cid);
		var id = $('#productions').data('first');
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: 'path=apps/productions&request=newProduction&id=' + id, cache: false, success: function(data){
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/productions&request=getProductionList&id="+id, success: function(list){
				$("#productions2 ul").html(list.html);
				var index = $("#productions2 .module-click").index($("#productions2 .module-click[rel='"+data.id+"']"));
				setModuleActive($("#productions2"),index);
				$('#productions').data({ "second" : data.id });
				$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/productions&request=getProductionDetails&id="+data.id, success: function(text){
					$("#productions-right").html(text.html);
					initProductionsContentScrollbar();
					$('#productions-right .focusTitle').trigger('click');
					}
				});
				productionsActions(0);
				}
			});
			}
		});
	}


	this.actionDuplicate = function() {
		var module = this;
		var cid = $('#productions input[name="id"]').val()
		module.checkIn(cid);
		var pid = $("#productions").data("second");
		var oid = $("#productions").data("first");
		$.ajax({ type: "GET", url: "/", data: 'path=apps/productions&request=createDuplicate&id=' + pid, cache: false, success: function(id){
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/productions&request=getProductionList&id="+oid, success: function(data){
				$("#productions2 ul").html(data.html);
					productionsActions(0);
					var idx = $("#productions2 .module-click").index($("#productions2 .module-click[rel='"+id+"']"));
					setModuleActive($("#productions2"),idx)
					$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/productions&request=getProductionDetails&id="+id, success: function(text){
							$("#productions").data("second",id);
							$("#"+productions.name+"-right").html(text.html);
							initProductionsContentScrollbar();
						}
					});
				}
			});
			}
		});
	}


	this.actionBin = function() {
		var module = this;
		var cid = $('#productions input[name="id"]').val()
		module.checkIn(cid);
		var txt = ALERT_DELETE;
		var langbuttons = {};
		langbuttons[ALERT_YES] = true;
		langbuttons[ALERT_NO] = false;
		$.prompt(txt,{ 
			buttons:langbuttons,
			callback: function(v,m,f){		
				if(v){
					var id = $("#productions").data("second");
					var fid = $("#productions").data("first");
					$.ajax({ type: "GET", url: "/", data: "path=apps/productions&request=binProduction&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/productions&request=getProductionList&id="+fid, success: function(list){
								$("#productions2 ul").html(list.html);
								if(list.html == "<li></li>") {
									productionsActions(3);
								} else {
									productionsActions(0);
									setModuleActive($("#productions2"),0);
								}
								var id = $("#productions2 .module-click:eq(0)").attr("rel");
								$("#productions").data("second", id);
								$("#productions2 .module-click:eq(0)").addClass('active-link');
								$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/productions&request=getProductionDetails&fid="+fid+"&id="+id, success: function(text){
									$("#productions-right").html(text.html);
									initProductionsContentScrollbar();
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
		$.ajax({ type: "GET", url: "/", async: false, data: 'path=apps/productions&request=checkinProduction&id='+id, success: function(data){
				if(!data) {
					prompt("something wrong");
				}
			}
		});
	}


	this.actionRefresh = function() {
		var oid = $('#productions').data('first');
		var pid = $('#productions').data('second');
		$("#productions2 .active-link").trigger("click");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/productions&request=getProductionList&id="+oid, success: function(data){
			$("#productions2 ul").html(data.html);
			var idx = $("#productions2 .module-click").index($("#productions2 .module-click[rel='"+pid+"']"));
			$("#productions2 .module-click:eq("+idx+")").addClass('active-link');
			}
		});
	}
	
	this.actionHandbook = function() {
		var id = $("#productions").data("second");
		var url ='/?path=apps/productions&request=printProductionHandbook&id='+id;
		$("#documentloader").attr('src', url);	
	}


	this.actionPrint = function() {
		var id = $("#productions").data("second");
		var url ='/?path=apps/productions&request=printProductionDetails&id='+id;
		$("#documentloader").attr('src', url);
	}


	this.actionSend = function() {
		var id = $("#productions").data("second");
		$.ajax({ type: "GET", url: "/", data: "path=apps/productions&request=getProductionSend&id="+id, success: function(html){
			$("#modalDialogForward").html(html).dialog('open');
			}
		});
	}


	this.actionSendtoResponse = function() {
		var id = $("#productions").data("second");
		$.ajax({ type: "GET", url: "/", data: "path=apps/productions&request=getSendtoDetails&id="+id, success: function(html){
			$("#production_sendto").html(html);
			$("#modalDialogForward").dialog('close');
			}
		});
	}


	this.sortclick = function (obj,sortcur,sortnew) {
		var module = this;
		var cid = $('#productions input[name="id"]').val()
		module.checkIn(cid);
		var fid = $("#productions .module-click:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/productions&request=getProductionList&id="+fid+"&sort="+sortnew, success: function(data){
			$("#productions2 ul").html(data.html);
			obj.attr("rel",sortnew);
			obj.removeClass("sort"+sortcur).addClass("sort"+sortnew);
			var id = $("#productions2 .module-click:eq(0)").attr("rel");
			$('#productions').data('second',id);
			if(id == undefined) {
				return false;
			}
			setModuleActive($("#productions2"),'0');
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/productions&request=getProductionDetails&id="+id, success: function(text){
				$("#"+productions.name+"-right").html(text.html);
				initProductionsContentScrollbar()
				}
			});
			}
		});
	}


	this.sortdrag = function (order) {
		var fid = $("#productions .module-click:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", data: "path=apps/productions&request=setProductionOrder&"+order+"&id="+fid, success: function(html){
			$("#productions2 .sort").attr("rel", "3");
			$("#productions2 .sort").removeClass("sort1").removeClass("sort2").addClass("sort3");
			}
		});
	}
	
	
	this.actionDialog = function(offset,request,field,append,title,sql) {
		$.ajax({ type: "GET", url: "/", data: 'path=apps/productions&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
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


	this.insertStatusDate = function(rel,text) {
		var html = '<div class="listmember" field="productionsstatus" uid="'+rel+'" style="float: left">' + text + '</div>';
		$("#productionsstatus").html(html);
		$("#modalDialog").dialog("close");
		$("#productionsstatus").nextAll('img').trigger('click');
	}
	
	
	this.insertFolderFromDialog = function(field,gid,title) {
		var html = '<a class="listmember" uid="' + gid + '" field="'+field+'">' + title + '</a>';
		$("#"+field).html(html);
		$("#modalDialog").dialog('close');
		var obj = getCurrentModule();
		$('#productions .coform').ajaxSubmit(obj.poformOptions);
	}
	
	this.actionHelp = function() {
		var url = "/?path=apps/productions&request=getProductionsHelp";
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/productions&request=deleteProduction&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#production_'+id).slideUp();
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/productions&request=restoreProduction&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#production_'+id).slideUp();
						}
					}
					});
				} 
			}
		});
	}


	this.markNoticeRead = function(pid) {
		$.ajax({ type: "GET", url: "/", data: "path=apps/productions&request=markNoticeRead&pid=" + pid, cache: false});
	}


	this.datepickerOnClose = function(dp) {
		// move entire production with kickoff
		if(dp.name == 'startdate' && $("#productionDurationEnd").html() != "" && dp.value != $("input[id='moveproduction_start']").val()) {
			var txt = ALERT_PROJECT_MOVE_ALL;
			var langbuttons = {};
			langbuttons[ALERT_YES] = true;
			langbuttons[ALERT_NO] = false;
			$.prompt(txt,{ 
				buttons:langbuttons,
				callback: function(v,m,f){		
					if(v){
						var date1 = Date.parse($("#productions input[name='startdate']").val());
						var date2 = Date.parse($("#productions input[id='moveproduction_start']").val());
						var span = new TimeSpan(date1 - date2);
						var days = span.getDays();
						var obj = getCurrentModule();
						$("#productions input[name='request']").val("moveProduction").after('<input type="hidden" value="' + days + '" name="movedays"/>');
						$('#productions .coform').ajaxSubmit(obj.poformOptions);
					} else {
						var obj = getCurrentModule();
						$('#productions .coform').ajaxSubmit(obj.poformOptions);
					}	
				}
			});
		// tasks move enddate if startdate is later
		} else if (dp.name.match(/task_startdate/)){
			var reg = /[0-9]+/.exec(dp.name);
			var end = $("#productions input[name='task_enddate["+reg+"]']").val();
			if(Date.parse(end) < Date.parse(dp.value)) {
				$("#productions input[name='task_enddate["+reg+"]']").val(dp.value)
			}
			var obj = getCurrentModule();
			$('#productions .coform').ajaxSubmit(obj.poformOptions);
		// tasks dependencies
		} else if (dp.name.match(/task_enddate/)){
			var obj = getCurrentModule();
			$('#productions .coform').ajaxSubmit(obj.poformOptions);
			var reg = /[0-9]+/.exec(dp.name);
			$.ajax({ type: "GET", url: "/", data: "path=apps/productions/modules/phases&request=getTaskDependencyExists&id="+reg, success: function(data){																																																																				
				if(data == "true") {
					var txt = ALERT_PHASE_TASKS_MOVE_ALL;
					var langbuttons = {};
					langbuttons[ALERT_YES] = true;
					langbuttons[ALERT_NO] = false;
					$.prompt(txt,{ 
						buttons:langbuttons,
						callback: function(v,m,f){		
							if(v){
								var date1 = Date.parse($("#productions input[name='task_enddate["+reg+"]']").val());
								var date2 = Date.parse($("#productions input[name='task_movedate["+reg+"]']").val());
								var span = new TimeSpan(date1 - date2);
								var days = span.getDays();
								if(days != 0) {
									$.ajax({ type: "GET", url: "/", data: "path=apps/productions/modules/phases&request=moveDependendTasks&id="+reg+"&days="+days, success: function(data){
									obj.actionRefresh();
										}
									});
								}
							}
						}
					});
				 }
				}
			});
		}
		else {
			var obj = getCurrentModule();
			//if(obj.name != 'brainstorms_rosters') {
				$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
			//}
		}
	}


}

var productions = new productionsApplication('productions');
//productions.resetModuleHeights = productionsresetModuleHeights;
productions.modules_height = productions_num_modules*module_title_height;
productions.GuestHiddenModules = new Array("controlling","access");


// register folder object
function productionsFolders(name) {
	this.name = name;


	this.formProcess = function(formData, form, poformOptions) {
		var title = $("#productions input.title").fieldValue();
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
				$("#productions1 span[rel='"+data.id+"'] .text").html($("#productions .title").val());
			break;
		}
	}


	this.poformOptions = { async: false, beforeSubmit: this.formProcess, dataType: 'json', success: this.formResponse };

	
	this.actionNew = function() {
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/productions&request=newFolder", cache: false, success: function(data){
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/productions&request=getFolderList", success: function(list){
				$("#productions1 ul").html(list.html);
				$("#productions1 li").show();
				var index = $("#productions1 .module-click").index($("#productions1 .module-click[rel='"+data.id+"']"));
				setModuleActive($("#productions1"),index);
				$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/productions&request=getFolderDetails&id="+data.id, success: function(text){
					$("#productions").data("first",data.id);
					$("#productions-right").html(text.html);
					initProductionsContentScrollbar();
					$('#productions-right .focusTitle').trigger('click');
					}
				});
				productionsActions(9);
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
					var id = $("#productions").data("first");
					$.ajax({ type: "GET", url: "/", data: "path=apps/productions&request=binFolder&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/productions&request=getFolderList", success: function(data){
								$("#productions1 ul").html(data.html);
								if(data.html == "<li></li>") {
									productionsActions(3);
								} else {
									productionsActions(9);
								}
								var id = $("#productions1 .module-click:eq(0)").attr("rel");
								$("#productions").data("first",id);
								$("#productions1 .module-click:eq(0)").addClass('active-link');
								$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/productions&request=getFolderDetails&id="+id, success: function(text){
									$("#"+productions.name+"-right").html(text.html);
									initProductionsContentScrollbar();
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
		var id = $("#productions").data("first");
		$("#productions1 .active-link").trigger("click");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/productions&request=getFolderList", success: function(data){
			$("#productions1 ul").html(data.html);
			if(data.access == "guest") {
				productionsActions();
			} else {
				if(data.html == "<li></li>") {
					productionsActions(3);
				} else {
					productionsActions(9);
				}
			}
			var idx = $("#productions1 .module-click").index($("#productions1 .module-click[rel='"+id+"']"));
			$("#productions1 .module-click:eq("+idx+")").addClass('active-link');
			}
		});
	}


	this.actionPrint = function() {
		var id = $("#productions").data("first");
		var url ='/?path=apps/productions&request=printFolderDetails&id='+id;
		$("#documentloader").attr('src', url);
	}


	this.actionSend = function() {
		var id = $("#productions").data("first");
		$.ajax({ type: "GET", url: "/", data: "path=apps/productions&request=getFolderSend&id="+id, success: function(html){
			$("#modalDialogForward").html(html).dialog('open');
			}
		});
	}


	this.actionSendtoResponse = function() {
		$("#modalDialogForward").dialog('close');
	}

	
	this.sortclick = function (obj,sortcur,sortnew) {
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/productions&request=getFolderList&sort="+sortnew, success: function(data){
			$("#productions1 ul").html(data.html);
			obj.attr("rel",sortnew);
		  	obj.removeClass("sort"+sortcur).addClass("sort"+sortnew);
			var id = $("#productions1 .module-click:eq(0)").attr("rel");
			$('#productions').data('first',id);
			$("#productions1 .module-click:eq(0)").addClass('active-link');
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/productions&request=getFolderDetails&id="+id, success: function(text){
				$("#productions-right").html(text.html);
				initProductionsContentScrollbar()
				}
			});
			}
		});
	}


	this.sortdrag = function (order) {
		$.ajax({ type: "GET", url: "/", data: "path=apps/productions&request=setFolderOrder&"+order, success: function(html){
			$("#productions1 .sort").attr("rel", "3");
			$("#productions1 .sort").removeClass("sort1").removeClass("sort2").addClass("sort3");
			}
		});
	}
	
	
	this.actionDialog = function(offset,request,field,append,title,sql) {
		$.ajax({ type: "GET", url: "/", data: 'path=apps/productions&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
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


	this.actionHelp = function() {
		var url = "/?path=apps/productions&request=getProductionsFoldersHelp";
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/productions&request=deleteFolder&id=" + id, cache: false, success: function(data){
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/productions&request=restoreFolder&id=" + id, cache: false, success: function(data){
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

var productions_folder = new productionsFolders('productions_folder');


function productionsActions(status) {
	/*	0= new	1= print	2= send		3= duplicate	4= handbook		5=refresh 	6 = delete*/
	switch(status) {
		case 0: actions = ['0','1','2','3','5','6','7','8']; break;
		case 1: actions = ['0','6','7','8']; break;
		case 3: 	actions = ['0','6','7']; break;   					// just new
		case 4: 	actions = ['0','1','2','5','6','7']; break;   		// new, print, send, handbook, refresh
		case 5: 	actions = ['1','2','6','7']; break;   			// print, send, refresh
		case 6: 	actions = ['5','6','7']; break;   			// handbook refresh
		case 7: 	actions = ['0','1','2','6','7']; break;   			// new, print, send, refresh
		case 8: 	actions = ['1','2','5','6','7']; break;   			// print, send, handbook, refresh
		case 9:		actions = ['0','1','2','6','7','8']; break;
		// vdocs
		// 0 == 10
		case 10: actions = ['0','1','2','3','4','5','6','7','8']; break;
		// 5 == 11
		case 11: 	actions = ['1','2','4','6','7']; break;   			// print, send, refresh
		default: 	actions = ['6','7'];  								// none
	}
	$('#productionsActions > li span').each( function(index) {
		if(index in oc(actions)) {
			$(this).removeClass('noactive');
		} else {
			$(this).addClass('noactive');
		}
	})
}



var productionsLayout, productionsInnerLayout;


$(document).ready(function() {
	
	productions.init();
	
	if($('#productions').length > 0) {
		productionsLayout = $('#productions').layout({
				west__onresize:				function() { resetModuleHeightsnavThree('productions'); }
			,	resizeWhileDragging:		true
			,	spacing_open:				0
			,	spacing_closed:				0
			,	closable: 					false
			,	resizable: 					false
			,	slidable:					false
			, 	west__size:					325
			,	west__closable: 			true
			,	center__onresize: 			"productionsInnerLayout.resizeAll"
		});
		
		productionsInnerLayout = $('#productions div.ui-layout-center').layout({
				center__onresize:			function() {  }
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

		loadModuleStartnavThree('productions');
	}


	$("#productions1-outer").on('click', 'h3', function(e, passed_id) {
		e.preventDefault();
		navThreeTitleFirst('productions',$(this),passed_id)
		prevent_dblclick(e)
	});


	$("#productions2-outer").on('click', 'h3', function(e, passed_id) {
		e.preventDefault();
		navThreeTitleSecond('productions',$(this),passed_id)
		prevent_dblclick(e)
	});


	$("#productions3").on('click', 'h3', function(e, passed_id) {
		e.preventDefault();
		navThreeTitleThird('productions',$(this),passed_id)
		prevent_dblclick(e)
	});

	$('#productions1').on('click', 'span.module-click', function(e) {
		e.preventDefault();
		navItemFirst('productions',$(this))
		prevent_dblclick(e)
	});


	$('#productions2').on('click', 'span.module-click', function(e) {
		e.preventDefault();
		navItemSecond('productions',$(this))
		prevent_dblclick(e)
	});


	$('#productions3').on('click', 'span.module-click', function(e) {
		e.preventDefault();
		navItemThird('productions',$(this))
		prevent_dblclick(e)
	});
	
	
	$(document).on('click', 'a.insertProductionFolderfromDialog',function(e) {
		e.preventDefault();
		var field = $(this).attr("field");
		var gid = $(this).attr("gid");
		var title = $(this).attr("title");
		var obj = getCurrentModule();
		obj.insertFolderFromDialog(field,gid,title);
	});


	// INTERLINKS FROM Content
	
	// load a production
	$(document).on('click', '.loadProduction', function(e) {
		e.preventDefault();
		var obj = getCurrentModule();
		if(confirmNavigation()) {
			formChanged = false;
			$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		}
		var id = $(this).attr("rel");
		$("#productions2-outer > h3").trigger('click', [id]);
	});

	// load a phase
	$(document).on('click', '.loadProductionsPhase', function(e) {
		e.preventDefault();
		var obj = getCurrentModule();
		if(confirmNavigation()) {
			formChanged = false;
			$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		}
		
		var id = $(this).attr("rel");
		$("#productions3 h3[rel='phases']").trigger('click', [id]);
	});


	/*$('span.actionProductionHandbook').on('click',function(e){
		e.preventDefault();
		if($(this).hasClass("noactive")) {
			return false;
		}
		productions.actionHandbook();
	});*/

	
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


});