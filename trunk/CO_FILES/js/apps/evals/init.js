function initEvalsContentScrollbar() {
	evalsInnerLayout.initContent('center');
}

/* evals Object */
function evalsApplication(name) {
	this.name = name;
	this.isRefresh = false;

	this.init = function() {
		this.$app = $('#evals');
		this.$appContent = $('#evals-right');
		this.$first = $('#evals1');
		this.$second = $('#evals2');
		this.$third = $('#evals3');
		this.$thirdDiv = $('#evals3 div.thirdLevel');
		this.$layoutWest = $('#evals div.ui-layout-west');
	}
	
	
	this.formProcess = function(formData, form, poformOptions) {
		var title = $("#evals input.title").fieldValue();
		if(title == "") {
			setTimeout(function() {
				title = $("#evals input.title").fieldValue();
				if(title == "") {
					$.prompt(ALERT_NO_TITLE, {submit: setTitleFocus});
				}
			}, 5000)
			return false;
		} else {
			formData[formData.length] = { "name": "title", "value": title };
		}
	
		formData[formData.length] = processListApps('folder');
		formData[formData.length] = processListApps('kind');
		formData[formData.length] = processListApps('area');
		formData[formData.length] = processListApps('department');
		formData[formData.length] = processListApps('education');
		formData[formData.length] = processListApps('family');
		//formData[formData.length] = processListApps('status');
	}

	
	this.formResponse = function(data) {
		switch(data.action) {
			case "edit":
				$("#evals2 span[rel='"+data.id+"'] .text").html($("#evals .title").val());
				$("#evalDurationStart").html($("#evals-right input[name='startdate']").val());
			break;
		}
	}


	this.poformOptions = { beforeSubmit: this.formProcess, dataType: 'json', success: this.formResponse };


	this.statusOnClose = function(dp) {
		var id = $("#evals").data("second");
		var status = $("#evals .statusTabs li span.active").attr('rel');
		var date = $("#evals .statusTabs input").val();
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/evals&request=updateStatus&id=" + id + "&date=" + date + "&status=" + status, cache: false, success: function(data){
				switch(data.status) {
					case "0":
						$("#evals2 .active-link .module-item-status").addClass("module-item-active-trial").removeClass("module-item-active-maternity").removeClass("module-item-active-leave");
						$("#evalDurationEnd").html($("#evals-right input[name='status_date']").val());
					break;
					case "2":
						$("#evals2 .active-link .module-item-status").addClass("module-item-active-maternity").removeClass("module-item-active-trial").removeClass("module-item-active-leave");
						$("#evalDurationEnd").html($("#evals-right input[name='status_date']").val());
					break;
					case "3":
						$("#evals2 .active-link .module-item-status").addClass("module-item-active-leave").removeClass("module-item-active-trial").addClass("module-item-active-maternity");
						$("#evalDurationEnd").html($("#evals-right input[name='status_date']").val());
					break;
					default:
						$("#evals2 .active-link .module-item-status").removeClass("module-item-active-trial").removeClass("module-item-active-maternity").removeClass("module-item-active-leave");
				}																															 			}
		});
	}


	this.actionClose = function() {
		evalsLayout.toggle('west');
	}


	this.getNavModulesNumItems = function(id) {
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: 'path=apps/evals&request=getNavModulesNumItems&id=' + id, success: function(data){
				$.each( data, function(k, v){
   					$('#'+k).html(v);
 				});
			}
		});
	}

	
	this.actionNew = function() {
		var module = this;
		var cid = $('#evals input[name="id"]').val()
		module.checkIn(cid);
		var id = $('#evals').data('first');
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: 'path=apps/evals&request=newEval&id=' + id, cache: false, success: function(data){
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/evals&request=getEvalList&id="+id, success: function(list){
				$("#evals2 ul").html(list.html);
				var index = $("#evals2 .module-click").index($("#evals2 .module-click[rel='"+data.id+"']"));
				setModuleActive($("#evals2"),index);
				$('#evals').data({ "second" : data.id });				
				$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/evals&request=getEvalDetails&id="+data.id, success: function(text){
					$("#evals-right").html(text.html);
					initEvalsContentScrollbar();
					$('#evals-right .focusTitle').trigger('click');
					
					}
				});
				evalsActions(0);
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
		var pid = $('#evals input[name="id"]').val()
		module.checkIn(pid);
		$("#modalDialog").dialog('close');
		var id = $('#evals').data('first');
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: 'path=apps/evals&request=newEval&id=' + id + '&cid=' + cid, cache: false, success: function(data){
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/evals&request=getEvalList&id="+id, success: function(list){
				$("#evals2 ul").html(list.html);
				var index = $("#evals2 .module-click").index($("#evals2 .module-click[rel='"+data.id+"']"));
				setModuleActive($("#evals2"),index);
				$('#evals').data({ "second" : data.id });				
				$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/evals&request=getEvalDetails&id="+data.id, success: function(text){
					$("#evals-right").html(text.html);
					initEvalsContentScrollbar();
					module.getNavModulesNumItems(data.id);
					//$('#evals-right .focusTitle').trigger('click');
					$.ajax({ type: "GET", url: "/", data: "path=apps/contacts&request=saveLastUsedContacts&id="+cid});
					}
				});
				evalsActions(0);
				}
			});
			}
		});
	}



	this.actionDuplicate = function() {
		var module = this;
		var cid = $('#evals input[name="id"]').val()
		module.checkIn(cid);
		var pid = $("#evals").data("second");
		var oid = $("#evals").data("first");
		$.ajax({ type: "GET", url: "/", data: 'path=apps/evals&request=createDuplicate&id=' + pid, cache: false, success: function(id){
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/evals&request=getEvalList&id="+oid, success: function(data){
				$("#evals2 ul").html(data.html);
					evalsActions(0);
					var idx = $("#evals2 .module-click").index($("#evals2 .module-click[rel='"+id+"']"));
					setModuleActive($("#evals2"),idx)
					$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/evals&request=getEvalDetails&id="+id, success: function(text){
						$("#evals").data("second",id);							
						$("#"+evals.name+"-right").html(text.html);
							initEvalsContentScrollbar();
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
		var cid = $('#evals input[name="id"]').val()
		module.checkIn(cid);
		var txt = ALERT_DELETE;
		var langbuttons = {};
		langbuttons[ALERT_YES] = true;
		langbuttons[ALERT_NO] = false;
		$.prompt(txt,{ 
			buttons:langbuttons,
			submit: function(e,v,m,f){		
				if(v){
					var id = $("#evals").data("second");
					var fid = $("#evals").data("first");
					$.ajax({ type: "GET", url: "/", data: "path=apps/evals&request=binEval&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/evals&request=getEvalList&id="+fid, success: function(list){
								$("#evals2 ul").html(list.html);
								if(list.html == "<li></li>") {
									evalsActions(3);
								} else {
									evalsActions(0);
									setModuleActive($("#evals2"),0);
								}
								var id = $("#evals2 .module-click:eq(0)").attr("rel");
								
								if(typeof id == 'undefined') {
									$("#evals").data("second", 0);
								} else {
									$("#evals").data("second", id);
								}
								$("#evals2 .module-click:eq(0)").addClass('active-link');
								$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/evals&request=getEvalDetails&fid="+fid+"&id="+id, success: function(text){
									$("#evals-right").html(text.html);
									initEvalsContentScrollbar();
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
		$('#EvalsTabsContent > div:visible').hide();
		$('#'+what).show();
		$('.elastic').elastic(); // need to init again
		initEvalsContentScrollbar();
	}
	
	this.checkIn = function(id) {
		$.ajax({ type: "GET", url: "/", async: false, data: 'path=apps/evals&request=checkinEval&id='+id, success: function(data){
				if(!data) {
					prompt("something wrong");
				}
			}
		});
	}


	this.actionRefresh = function() {
		var oid = $('#evals').data('first');
		var pid = $('#evals').data('second');
		$("#evals2 .active-link").trigger("click");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/evals&request=getEvalList&id="+oid, success: function(data){
			$("#evals2 ul").html(data.html);
			var idx = $("#evals2 .module-click").index($("#evals2 .module-click[rel='"+pid+"']"));
			$("#evals2 .module-click:eq("+idx+")").addClass('active-link');
			}
		});
	}


	this.actionHandbook = function() {
		var id = $("#evals").data("second");
		var url ='/?path=apps/evals&request=printEvalHandbook&id='+id;
		if(!iOS()) {
			$("#documentloader").attr('src', url);
		} else {
			window.open(url);
		}
	}


	this.actionPrint = function() {
		var id = $("#evals").data("second");
		var url ='/?path=apps/evals&request=printEvalDetails&id='+id;
		if(!iOS()) {
			$("#documentloader").attr('src', url);
		} else {
			window.open(url);
		}
	}


	this.actionSend = function() {
		var id = $("#evals").data("second");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/evals&request=getEvalSend&id="+id, success: function(data){
			$("#modalDialogForward").html(data.html).dialog('open');
			if(data.error == 1) {
				$.prompt('<div style="text-align: center">' + ALERT_REMOVE_RECIPIENT + data.error_message + '<br /></div>');
				return false;
			}
			}
		});
	}


	this.actionSendtoResponse = function() {
		var id = $("#evals").data("second");
		$.ajax({ type: "GET", url: "/", data: "path=apps/evals&request=getSendtoDetails&id="+id, success: function(html){
			$("#eval_sendto").html(html);
			//$("#modalDialogForward").dialog('close');
			}
		});
	}


	this.sortclick = function (obj,sortcur,sortnew) {
		var module = this;
		var cid = $('#evals input[name="id"]').val()
		module.checkIn(cid);
		var fid = $("#evals .module-click:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/evals&request=getEvalList&id="+fid+"&sort="+sortnew, success: function(data){
			$("#evals2 ul").html(data.html);
			obj.attr("rel",sortnew);
			obj.removeClass("sort"+sortcur).addClass("sort"+sortnew);
			var id = $("#evals2 .module-click:eq(0)").attr("rel");
			$('#evals').data('second',id);
			if(id == undefined) {
				return false;
			}
			setModuleActive($("#evals2"),'0');
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/evals&request=getEvalDetails&id="+id, success: function(text){
				$("#"+evals.name+"-right").html(text.html);
				initEvalsContentScrollbar()
				}
			});
			}
		});
	}


	this.sortdrag = function (order) {
		var fid = $("#evals .module-click:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", data: "path=apps/evals&request=setEvalOrder&"+order+"&id="+fid, success: function(html){
			$("#evals2 .sort").attr("rel", "3");
			$("#evals2 .sort").removeClass("sort1").removeClass("sort2").addClass("sort3");
			}
		});
	}
	
	
	this.actionDialog = function(offset,request,field,append,title,sql) {
		switch(request) {
			case "getEvalDialog":
				$.ajax({ type: "GET", url: "/", data: 'path=apps/evals&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
					$("#modalDialog").html(html);
					$("#modalDialog").dialog('option', 'position', offset);
					$("#modalDialog").dialog('option', 'title', title);
					$("#modalDialog").dialog('open');
					}
				});
			break;
			case "getContactsImportDialog":
				$.ajax({ type: "GET", url: "/", data: 'path=apps/evals&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
					$("#modalDialog").html(html);
					$("#modalDialog").dialog('option', 'position', offset);
					$("#modalDialog").dialog('option', 'title', title);
					$("#modalDialog").dialog('open');
					}
				});
			break;
			case "getEvalCatDialog":
				$.ajax({ type: "GET", url: "/", data: 'path=apps/evals&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
					$("#modalDialog").html(html);
					$("#modalDialog").dialog('option', 'position', offset);
					$("#modalDialog").dialog('option', 'title', title);
					$("#modalDialog").dialog('open');
					}
				});
			break;
			default:
			$.ajax({ type: "GET", url: "/", data: 'path=apps/evals&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
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
		var html = '<div class="listmember" field="evalsstatus" uid="'+rel+'" style="float: left">' + text + '</div>';
		$("#evalsstatus").html(html);
		$("#modalDialog").dialog("close");
		$("#evalsstatus").nextAll('img').trigger('click');
	}
	
	
	/*this.insertEvalFromDialog = function(field,gid,title) {
		var html = '<a class="listmember" uid="' + gid + '" field="'+field+'">' + title + '</a>';
		$("#"+field).html(html);
		$("#modalDialog").dialog('close');
		var obj = getCurrentModule();
		$('#evals .coform').ajaxSubmit(obj.poformOptions);
	}*/
	
	
	this.insertFromDialog = function(field,gid,title) {
		var html = '<a class="listmember" uid="' + gid + '" field="'+field+'">' + title + '</a>';
		$("#"+field).html(html);
		$("#modalDialog").dialog('close');
		var obj = getCurrentModule();
		$('#evals .coform').ajaxSubmit(obj.poformOptions);
	}
	
	this.actionHelp = function() {
		var url = "/?path=apps/evals&request=getEvalsHelp";
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/evals&request=deleteEval&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#eval_'+id).slideUp();
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/evals&request=restoreEval&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#eval_'+id).slideUp();
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
		var pid = $('#evals').data('second');
		switch(action) {
			case 'new':
				$.ajax({ type: "GET", url: "/", data: "path=apps/evals&request=newCheckpoint&id=" + pid + "&date=" + date, cache: false });
			break;
			case 'update':
				$.ajax({ type: "GET", url: "/", data: "path=apps/evals&request=updateCheckpoint&id=" + pid + "&date=" + date, cache: false });			
			break;
			case 'delete':
				$.ajax({ type: "GET", url: "/", data: "path=apps/evals&request=deleteCheckpoint&id=" + pid, cache: false });
			break;
		}
	}
	
	
	this.saveCheckpointText = function() {
		var pid = $('#evals').data('second');
		var text = $('#evalsCheckpoint textarea').val();
		$.ajax({ type: "POST", url: "/", data: "path=apps/evals&request=updateCheckpointText&id=" + pid + "&text=" + text, cache: false });
	}

}

var evals = new evalsApplication('evals');
//evals.resetModuleHeights = evalsresetModuleHeights;
evals.modules_height = evals_num_modules*module_title_height;
evals.GuestHiddenModules = new Array("access");

// register folder object
function evalsFolders(name) {
	this.name = name;
	
	
	this.formProcess = function(formData, form, poformOptions) {
		var title = $("#evals input.title").fieldValue();
		if(title == "") {
			setTimeout(function() {
				title = $("#evals input.title").fieldValue();
				if(title == "") {
					$.prompt(ALERT_NO_TITLE, {submit: setTitleFocus});
				}
			}, 5000)
			return false;
		} else {
			formData[formData.length] = { "name": "title", "value": title };
		}
	}
	
	
	this.formResponse = function(data) {
		switch(data.action) {
			case "edit":
				$("#evals1 span[rel='"+data.id+"'] .text").html($("#evals .title").val());
			break;
		}
	}


	this.poformOptions = { beforeSubmit: this.formProcess, dataType: 'json', success: this.formResponse };

	
	this.actionNew = function() {
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/evals&request=newFolder", cache: false, success: function(data){
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/evals&request=getFolderList", success: function(list){
				$("#evals1 ul").html(list.html);
				$("#evals1 li").show();
				var index = $("#evals1 .module-click").index($("#evals1 .module-click[rel='"+data.id+"']"));
				setModuleActive($("#evals1"),index);
				$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/evals&request=getFolderDetails&id="+data.id, success: function(text){
					$("#evals").data("first",data.id);					
					$("#"+evals.name+"-right").html(text.html);
					initEvalsContentScrollbar();
					$('#evals-right .focusTitle').trigger('click');
					}
				});
				evalsActions(9);
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
					var id = $("#evals").data("first");
					$.ajax({ type: "GET", url: "/", data: "path=apps/evals&request=binFolder&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/evals&request=getFolderList", success: function(data){
								$("#evals1 ul").html(data.html);
								if(data.html == "<li></li>") {
									evalsActions(3);
								} else {
									evalsActions(9);
								}
								var id = $("#evals1 .module-click:eq(0)").attr("rel");
								if(typeof id == 'undefined') {
									$("#evals").data("first",0);
								} else {
									$("#evals").data("first",id);
								}
								$("#evals1 .module-click:eq(0)").addClass('active-link');
								$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/evals&request=getFolderDetails&id="+id, success: function(text){
									$("#"+evals.name+"-right").html(text.html);
									initEvalsContentScrollbar();
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
		var id = $("#evals").data("first");
		$("#evals1 .active-link").trigger("click");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/evals&request=getFolderList", success: function(data){
			$("#evals1 ul").html(data.html);
			if(data.access == "guest") {
				evalsActions();
			} else {
				if(data.html == "<li></li>") {
					evalsActions(3);
				} else {
					evalsActions(9);
				}
			}
			var idx = $("#evals1 .module-click").index($("#evals1 .module-click[rel='"+id+"']"));
			$("#evals1 .module-click:eq("+idx+")").addClass('active-link');
			}
		});
	}
	

	this.actionPrint = function() {
		var id = $("#evals").data("first");
		var url ='/?path=apps/evals&request=printFolderDetails&id='+id;
		if(!iOS()) {
			$("#documentloader").attr('src', url);
		} else {
			window.open(url);
		}
	}


	this.actionSend = function() {
		var id = $("#evals").data("first");
		$.ajax({ type: "GET", url: "/", data: "path=apps/evals&request=getFolderSend&id="+id, success: function(html){
			$("#modalDialogForward").html(html).dialog('open');
			}
		});
	}


	this.actionSendtoResponse = function() {
			//$("#modalDialogForward").dialog('close');
	}

	
	this.sortclick = function (obj,sortcur,sortnew) {
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/evals&request=getFolderList&sort="+sortnew, success: function(data){
			$("#evals1 ul").html(data.html);
			obj.attr("rel",sortnew);
		  	obj.removeClass("sort"+sortcur).addClass("sort"+sortnew);
			var id = $("#evals1 .module-click:eq(0)").attr("rel");
			$('#evals').data('first',id);			
			$("#evals1 .module-click:eq(0)").addClass('active-link');
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/evals&request=getFolderDetails&id="+id, success: function(text){
				$("#evals-right").html(text.html);
				initEvalsContentScrollbar()
				}
			});
			}
		});
	}


	this.sortdrag = function (order) {
		$.ajax({ type: "GET", url: "/", data: "path=apps/evals&request=setFolderOrder&"+order, success: function(html){
			$("#evals1 .sort").attr("rel", "3");
			$("#evals1 .sort").removeClass("sort1").removeClass("sort2").addClass("sort3");
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
				$.ajax({ type: "GET", url: "/", data: 'path=apps/evals&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
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
		var url = "/?path=apps/evals&request=getEvalsFoldersHelp";
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/evals&request=deleteFolder&id=" + id, cache: false, success: function(data){
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/evals&request=restoreFolder&id=" + id, cache: false, success: function(data){
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

var evals_folder = new evalsFolders('evals_folder');


function evalsActions(status) {
	/*	0= new	1= print	2= send		3= duplicate	4= handbook		5=refresh 	6 = delete*/
	var obj = getCurrentModule();
	switch(status) {
		case 0: 
			if(obj.name == 'evals') {
				actions = ['1','2','3','5','6','7','8']; 
			} else {
				actions = ['0','2','3','4','5','6','7','8']; 
			}
		break;
		case 1: actions = ['0','5','6','7']; break;
		case 3: 
			if(obj.name == 'evals') {
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
		case 11: 	actions = ['1','2','6','7','8']; break;
		// rosters
		case 12: actions = ['0','1','2','3','4','6','7','8']; break;
		default: 	actions = ['6','7'];  								// none
	}
	$('#evalsActions > li span').each( function(index) {
		if(index in oc(actions)) {
			$(this).removeClass('noactive');
		} else {
			$(this).addClass('noactive');
		}
	})
}

var evalsLayout, evalsInnerLayout;


$(document).ready(function() {
	
	evals.init();
	
	if($('#evals').length > 0) {
		evalsLayout = $('#evals').layout({
				west__onresize:				function() { resetModuleHeightsnavThree('evals'); }
			,	resizeWhileDragging:		true
			,	spacing_open:				0
			,	spacing_closed:				0
			,	closable: 					false
			,	resizable: 					false
			,	slidable:					false
			, 	west__size:					325
			,	west__closable: 			true
			,	center__onresize: "evalsInnerLayout.resizeAll"
			
		});
		
		evalsInnerLayout = $('#evals div.ui-layout-center').layout({
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

		loadModuleStartnavThree('evals');
	}


	$("#evals1-outer").on('click', 'h3', function(e, passed_id) {
		e.preventDefault();
		navThreeTitleFirst('evals',$(this),passed_id)
		prevent_dblclick(e)
	}).disableSelection();


	$("#evals2-outer").on('click', 'h3', function(e, passed_id) {
		e.preventDefault();
		navThreeTitleSecond('evals',$(this),passed_id)
		prevent_dblclick(e)
	}).disableSelection();


	$("#evals3").on('click', 'h3', function(e, passed_id) {
		e.preventDefault();
		navThreeTitleThird('evals',$(this),passed_id)
		prevent_dblclick(e)
	}).disableSelection();


	$('#evals1').on('click', 'span.module-click',function(e) {
		e.preventDefault();
		navItemFirst('evals',$(this))
		prevent_dblclick(e)
	});


	$('#evals2').on('click', 'span.module-click',function(e) {
		e.preventDefault();
		navItemSecond('evals',$(this))
		prevent_dblclick(e)
	});


	$('#evals3').on('click', 'span.module-click',function(e) {
		e.preventDefault();
		navItemThird('evals',$(this))
		prevent_dblclick(e)
	});


	$(document).on('click', 'a.insertEvalFolderfromDialog', function(e) {
		e.preventDefault();
		var field = $(this).attr("field");
		var gid = $(this).attr("gid");
		var title = $(this).attr("title");
		var obj = getCurrentModule();
		obj.insertFromDialog(field,gid,title);
	});
	
	
// INTERLINKS FROM Content
	
	// load a eval
	$(document).on('click', '.loadEval', function(e) {	
		e.preventDefault();
		var obj = getCurrentModule();
		if(confirmNavigation()) {
			formChanged = false;
			$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		}
		var id = $(this).attr("rel");
		$("#evals2-outer > h3").trigger('click', [id]);
	});


// autocomplete evals search
	$('.evals-search').livequery(function() {
		var id = $("#evals").data("second");
		$(this).autocomplete({
			appendTo: '#tabs-1',
			source: "?path=apps/evals&request=getEvalsSearch&exclude="+id,
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
	
	$(document).on('click', '.addEvalLink', function(e) {
		e.preventDefault();
		var id = $(this).attr("rel");
		var obj = getCurrentModule();
		obj.addParentLink(id);
	});

});