function initProcessesContentScrollbar() {
	processesInnerLayout.initContent('center');
}

/* processes Object */
function processesApplication(name) {
	this.name = name;
	
	this.init = function() {
		this.$app = $('#processes');
		this.$appContent = $('#processes-right');
		this.$first = $('#processes1');
		this.$second = $('#processes2');
		this.$third = $('#processes3');
		this.$thirdDiv = $('#processes3 div.thirdLevel');
		this.$layoutWest = $('#processes div.ui-layout-west');
	}
	
	this.formProcess = function(formData, form, poformOptions) {
		var title = $("#processes input.title").fieldValue();
		if(title == "") {
			setTimeout(function() {
				title = $("#processes input.title").fieldValue();
				if(title == "") {
					$.prompt(ALERT_NO_TITLE, {submit: setTitleFocus});
				}
			}, 5000)
			return false;
		} else {
			formData[formData.length] = { "name": "title", "value": title };
		}
		formData[formData.length] = processListApps('folder');
	}

	
	this.formResponse = function(data) {
		switch(data.action) {
			case "edit":
				$("#processes2 span[rel='"+data.id+"'] .text").html($("#processes .title").val());
				/*$("#durationStart").html($("input[name='startdate']").val());
				switch(data.status) {
					case "2":
						$("#processes2 span[rel='"+data.id+"'] .module-item-status").addClass("module-item-active");
					break;
					default:
						$("#processes2 span[rel='"+data.id+"'] .module-item-status").removeClass("module-item-active");
				}*/
			break;
			case "reload":
				$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/processes&request=getProcessDetails&id="+data.id, success: function(text){
					$("#processes-right").html(text.html);
						initProcessesContentScrollbar();
					}
				});
			break;
		}
	}


	this.poformOptions = { beforeSubmit: this.formProcess, dataType: 'json', success: this.formResponse };


	this.actionClose = function() {
		processesLayout.toggle('west');
	}


	this.getNavModulesNumItems = function(id) {
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: 'path=apps/processes&request=getNavModulesNumItems&id=' + id, success: function(data){
				$.each( data, function(k, v){
   					$('#'+k).html(v);
 				});
			}
		});
	}
	
	
	this.actionNew = function() {
		var module = this;
		var cid = $('#processes input[name="id"]').val()
		module.checkIn(cid);
		var id = $('#processes').data('first');
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: 'path=apps/processes&request=newProcess&id=' + id, cache: false, success: function(data){
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/processes&request=getProcessList&id="+id, success: function(list){
				$("#processes2 ul").html(list.html);
				var index = $("#processes2 .module-click").index($("#processes2 .module-click[rel='"+data.id+"']"));
				setModuleActive($("#processes2"),index);
				$('#processes').data({ "second" : data.id });				
				$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/processes&request=getProcessDetails&id="+data.id, success: function(text){
					$("#processes-right").html(text.html);
					initProcessesContentScrollbar();
					$('#processes-right .focusTitle').trigger('click');
					module.getNavModulesNumItems(data.id);
					}
				});
				processesActions(0);
				}
			});
			}
		});
	}


	this.actionDuplicate = function() {
		var module = this;
		var cid = $('#processes input[name="id"]').val()
		module.checkIn(cid);
		var pid = $("#processes").data("second");
		var oid = $("#processes").data("first");
		$.ajax({ type: "GET", url: "/", data: 'path=apps/processes&request=createDuplicate&id=' + pid, cache: false, success: function(id){
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/processes&request=getProcessList&id="+oid, success: function(data){
				$("#processes2 ul").html(data.html);
					processesActions(0);
					var idx = $("#processes2 .module-click").index($("#processes2 .module-click[rel='"+id+"']"));
					setModuleActive($("#processes2"),idx)
					$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/processes&request=getProcessDetails&id="+id, success: function(text){
							$("#processes").data("second",id);
							$("#"+processes.name+"-right").html(text.html);
							initProcessesContentScrollbar();
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
		var cid = $('#processes input[name="id"]').val()
		module.checkIn(cid);
		var txt = ALERT_DELETE;
		var langbuttons = {};
		langbuttons[ALERT_YES] = true;
		langbuttons[ALERT_NO] = false;
		$.prompt(txt,{ 
			buttons:langbuttons,
			submit: function(e,v,m,f){		
				if(v){
					var id = $("#processes").data("second");
					var fid = $("#processes").data("first");
					$.ajax({ type: "GET", url: "/", data: "path=apps/processes&request=binProcess&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/processes&request=getProcessList&id="+fid, success: function(list){
								$("#processes2 ul").html(list.html);
								if(list.html == "<li></li>") {
									processesActions(3);
								} else {
									processesActions(0);
									setModuleActive($("#processes2"),0);
								}
								var id = $("#processes2 .module-click:eq(0)").attr("rel");
								if(typeof id == 'undefined') {
									$("#processes").data("second", 0);
								} else {
									$("#processes").data("second", id);
								}
								$("#processes2 .module-click:eq(0)").addClass('active-link');
								$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/processes&request=getProcessDetails&fid="+fid+"&id="+id, success: function(text){
									$("#processes-right").html(text.html);
									initProcessesContentScrollbar();
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


	this.checkIn = function(id) {
		$.ajax({ type: "GET", url: "/", async: false, data: 'path=apps/processes&request=checkinProcess&id='+id, success: function(data){
				if(!data) {
					prompt("something wrong");
				}
			}
		});
	}


	this.actionRefresh = function() {
		var oid = $('#processes').data('first');
		var pid = $('#processes').data('second');
		$("#processes2 .active-link").trigger("click");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/processes&request=getProcessList&id="+oid, success: function(data){
			$("#processes2 ul").html(data.html);
			var idx = $("#processes2 .module-click").index($("#processes2 .module-click[rel='"+pid+"']"));
			$("#processes2 .module-click:eq("+idx+")").addClass('active-link');
			}
		});
	}


	this.actionPrint = function() {
		var id = $("#processes").data("second");
		var url ='/?path=apps/processes&request=printProcessDetails&id='+id;
		$("#documentloader").attr('src', url);
	}


	this.actionSend = function() {
		var id = $("#processes").data("second");
		$.ajax({ type: "GET", url: "/", data: "path=apps/processes&request=getProcessSend&id="+id, success: function(html){
			$("#modalDialogForward").html(html).dialog('open');
			}
		});
	}


	this.actionSendtoResponse = function() {
		var id = $("#processes").data("second");
		//$.ajax({ type: "GET", url: "/", data: "path=apps/processes&request=getSendtoDetails&id="+id, success: function(html){
			//$("#process_sendto").html(html);
			//$("#modalDialogForward").dialog('close');
			//}
		//});
	}


	this.sortclick = function (obj,sortcur,sortnew) {
		var module = this;
		var cid = $('#processes input[name="id"]').val()
		module.checkIn(cid);
		var fid = $("#processes .module-click:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/processes&request=getProcessList&id="+fid+"&sort="+sortnew, success: function(data){
			$("#processes2 ul").html(data.html);
			obj.attr("rel",sortnew);
			obj.removeClass("sort"+sortcur).addClass("sort"+sortnew);
			var id = $("#processes2 .module-click:eq(0)").attr("rel");
			$('#processes').data('second',id);
			if(id == undefined) {
				return false;
			}
			setModuleActive($("#processes2"),'0');
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/processes&request=getProcessDetails&id="+id, success: function(text){
				$("#"+processes.name+"-right").html(text.html);
				initProcessesContentScrollbar()
				}
			});
			}
		});
	}


	this.sortdrag = function (order) {
		var fid = $("#processes .module-click:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", data: "path=apps/processes&request=setProcessOrder&"+order+"&id="+fid, success: function(html){
			$("#processes2 .sort").attr("rel", "3");
			$("#processes2 .sort").removeClass("sort1").removeClass("sort2").addClass("sort3");
			}
		});
	}
	
	
	this.actionDialog = function(offset,request,field,append,title,sql) {
		$.ajax({ type: "GET", url: "/", data: 'path=apps/processes&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
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
		var html = '<div class="listmember" field="processesstatus" uid="'+rel+'" style="float: left">' + text + '</div>';
		$("#processesstatus").html(html);
		$("#modalDialog").dialog("close");
		$("#processesstatus").nextAll('img').trigger('click');
	}
	
	
	// notes
	this.saveItem = function(id) {
		if($("#input-note-"+id).length > 0) {
			var title = $("#input-note-"+id).val();
		} else {
			var title = $("#note-title-"+id).html();
		}
		
		if($("#input-text-"+id).length > 0) {
			var text = $("#input-text-"+id).val();
		} else {
			//var text = $("#note-text-"+id).html().replace(/(<br\s*\/?>)|(<p><\/p>)/gi, "");
			var text = $("#note-text-"+id).html().replace(/(<br\s*\/?>)|(<p><\/p>)/gi, "");
		}
		$.ajax({ type: "POST", url: "/", data: { path: 'apps/processes', request: 'saveProcessNote', id: id, title: title, text: text }, success: function(data){
		//$.ajax({ type: "POST", url: "/", data: "path=apps/processes&request=saveProcessNote&id="+id+"&title="+title+"&text="+text, success: function(data){
			//if(data == "true"){
				if($("#input-note-"+id).length > 0) {
					var note_title = $(document.createElement('div')).attr("id", "note-title-" + id).attr("class", "note-title note-title-design").html(title);
					$("#note-" + id).find('input').replaceWith(note_title); 
				}
				if($("#input-text-"+id).length > 0) {
					//text = text.replace(/\n/g, "<br />");
					//var width = $("#input-text-"+id).width();
					var height = $("#input-text-"+id).height();
					var note_text = $(document.createElement('div')).attr("id", "note-text-" + id).attr("class", "note-text note-text-design").css("height",height).html(data);
					$("#note-" + id).find('textarea').replaceWith(note_text); 
				}
			//} 
			}
		});
	}
	
	
	this.toggleItem = function(id) {
		var height = $(this).attr("rel");
		if($(this).parents("div.note").height() == 20) {
			$(this).find('span').addClass("icon-toggle").removeClass("icon-toggle-active");
			$(this).parents("div.note")
				.animate({
					height: height+'px'
					}, function() {
						$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/processes&request=setProcessNoteToggle&id="+id+"&t=0"});
				});
		} else {
			$(this).find('span').addClass("icon-toggle-active").removeClass("icon-toggle");
			$(this).parents("div.note")
				.animate({
					height: 20
  					}, function() {
						$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/processes&request=setProcessNoteToggle&id="+id+"&t=1"});
				});
		}
	}
	
	
	this.binItem = function(id) {
		var txt = ALERT_DELETE_REALLY;
		var langbuttons = {};
		langbuttons[ALERT_YES] = true;
		langbuttons[ALERT_NO] = false;
		$.prompt(txt,{ 
			buttons:langbuttons,
			submit: function(e,v,m,f){		
				if(v){
					$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/processes&request=deleteProcessNote&id="+id, success: function(data){
						if(data){
							$("#note-"+id).slideUp(function(){ 
								$(this).remove();
							});
						} 
						}
					});
				} 
			}
		});	
	}
	
	
	this.actionHelp = function() {
		var url = "/?path=apps/processes&request=getProcessesHelp";
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/processes&request=deleteProcess&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#process_'+id).slideUp();
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/processes&request=restoreProcess&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#process_'+id).slideUp();
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
			submit: function(e,v,m,f){		
				if(v){
					$.ajax({ type: "GET", url: "/", data: "path=apps/processes&request=deleteItem&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#process_task_'+id).slideUp();
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
			submit: function(e,v,m,f){		
				if(v){
					$.ajax({ type: "GET", url: "/", data: "path=apps/processes&request=restoreItem&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#process_task_'+id).slideUp();
						}
					}
					});
				} 
			}
		});
	}


	this.markNoticeRead = function(pid) {
		$.ajax({ type: "GET", url: "/", data: "path=apps/processes&request=markNoticeRead&pid=" + pid, cache: false});
	}


	this.datepickerOnClose = function(dp) {
		var obj = getCurrentModule();
		if(obj.name != 'processes_rosters' || obj.name != 'processes_grids') {
			$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		}
	}


this.initItems = function() {

$('#processes-outer div.note').each(function(){
		// Finding the biggest z-index value of the notes 
		tmp = $(this).css('z-index');
		if(tmp>zIndex) zIndex = tmp;
	})
	
	
	$("#processes-outer div.note").livequery( function() {
		$(this).each(function(){
		tmp = $(this).css('z-index');
		if(tmp>processeszIndex) processeszIndex = tmp;
	})
		
		.draggable({
			containment:'#processes-right .scroll-pane',
			cancel: 'input,textarea',
			//stack: ".note",
			handle: '.postit-header',
			cursor: 'move',
			start: function(e,ui){ ui.helper.css('z-index',++processeszIndex); },
			stop: function(e,ui){
				var x = Math.round(ui.position.left);
				var y = Math.round(ui.position.top);
				var z = processeszIndex;
				var id = $(this).attr("id").replace(/note-/, "");
				$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/processes&request=updateNotePosition&id="+id+"&x="+x+"&y="+y+"&z="+z, success: function(data){
					//$("#processes-top .top-subheadlineTwo").html(data.startdate + ' - <span id="processenddate">' + data.enddate + '</span>');
					}
				});
			}
		})
		.resizable({
			//alsoResize: '#processes-roster-outer div.note-text, #input-text',
			minHeight: 130, // try to hide footer with 50
			minWidth: 200,
			start: function(e,ui){ 
				ui.helper.css('z-index',++processeszIndex);
				$(this).find("textarea").height($(this).height() - 100);
			},
			resize: function(e,ui){ 
				//$(this).find("textarea").height($(this).height() - 20).width($(this).width());
				$(this).find("div.note-text").height($(this).height() - 100);
				$(this).find("textarea").height($(this).height() - 100);
			},
			stop: function(e,ui){
				var w = ui.size.width;
				var h = ui.size.height;
				var id = $(this).attr("id").replace(/note-/, "");
				$('#note-toggle-'+id).attr('rel',h);
				$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/processes&request=updateNoteSize&id="+id+"&w="+w+"&h="+h, success: function(data){
					//$("#processes-top .top-subheadlineTwo").html(data.startdate + ' - <span id="processenddate">' + data.enddate + '</span>');
					}
				});
			}
		});
	});
}

}

var processes = new processesApplication('processes');
//processes.resetModuleHeights = processesresetModuleHeights;
processes.modules_height = processes_num_modules*module_title_height;
processes.GuestHiddenModules = new Array("access");

// register folder object
function processesFolders(name) {
	this.name = name;
	
	
	this.formProcess = function(formData, form, poformOptions) {
		var title = $("#processes input.title").fieldValue();
		if(title == "") {
			setTimeout(function() {
				title = $("#processes input.title").fieldValue();
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
				$("#processes1 span[rel='"+data.id+"'] .text").html($("#processes .title").val());
			break;
		}
	}


	this.poformOptions = { beforeSubmit: this.formProcess, dataType: 'json', success: this.formResponse };

	
	this.actionNew = function() {
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/processes&request=newFolder", cache: false, success: function(data){
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/processes&request=getFolderList", success: function(list){
				$("#processes1 ul").html(list.html);
				$("#processes1 li").show();
				var index = $("#processes1 .module-click").index($("#processes1 .module-click[rel='"+data.id+"']"));
				setModuleActive($("#processes1"),index);
				$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/processes&request=getFolderDetails&id="+data.id, success: function(text){
					$("#processes").data("first",data.id);
					$("#"+processes.name+"-right").html(text.html);
					initProcessesContentScrollbar();
					$('#processes-right .focusTitle').trigger('click');
					}
				});
				processesActions(9);
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
					var id = $("#processes").data("first");
					$.ajax({ type: "GET", url: "/", data: "path=apps/processes&request=binFolder&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/processes&request=getFolderList", success: function(data){
								$("#processes1 ul").html(data.html);
								if(data.html == "<li></li>") {
									processesActions(3);
								} else {
									processesActions(9);
								}
								var id = $("#processes1 .module-click:eq(0)").attr("rel");
								if(typeof id == 'undefined') {
									$("#processes").data("first",0);
								} else {
									$("#processes").data("first",id);
								}
								$("#processes1 .module-click:eq(0)").addClass('active-link');
								$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/processes&request=getFolderDetails&id="+id, success: function(text){
									$("#"+processes.name+"-right").html(text.html);
									initProcessesContentScrollbar();
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
		var id = $("#processes").data("first");
		$("#processes1 .active-link").trigger("click");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/processes&request=getFolderList", success: function(data){
			$("#processes1 ul").html(data.html);
			if(data.html == "<li></li>") {
				processesActions(3);
			} else {
				processesActions(9);
			}
			var idx = $("#processes1 .module-click").index($("#processes1 .module-click[rel='"+id+"']"));
			$("#processes1 .module-click:eq("+idx+")").addClass('active-link');
			}
		});
	}
	

	this.actionPrint = function() {
		var id = $("#processes").data("first");
		var url ='/?path=apps/processes&request=printFolderDetails&id='+id;
		$("#documentloader").attr('src', url);
	}


	this.actionSend = function() {
		var id = $("#processes").data("first");
		$.ajax({ type: "GET", url: "/", data: "path=apps/processes&request=getFolderSend&id="+id, success: function(html){
			$("#modalDialogForward").html(html).dialog('open');
			}
		});
	}


	this.actionSendtoResponse = function() {
			//$("#modalDialogForward").dialog('close');
	}



	this.sortclick = function (obj,sortcur,sortnew) {
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/processes&request=getFolderList&sort="+sortnew, success: function(data){
			$("#processes1 ul").html(data.html);
			obj.attr("rel",sortnew);
		  	obj.removeClass("sort"+sortcur).addClass("sort"+sortnew);
			var id = $("#processes1 .module-click:eq(0)").attr("rel");
			$('#processes').data('first',id);
			$("#processes1 .module-click:eq(0)").addClass('active-link');
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/processes&request=getFolderDetails&id="+id, success: function(text){
				$("#processes-right").html(text.html);
				initProcessesContentScrollbar()
				}
			});
			}
		});
	}


	this.sortdrag = function (order) {
		$.ajax({ type: "GET", url: "/", data: "path=apps/processes&request=setFolderOrder&"+order, success: function(html){
			$("#processes1 .sort").attr("rel", "3");
			$("#processes1 .sort").removeClass("sort1").removeClass("sort2").addClass("sort3");
			}
		});
	}
	
	
	this.actionDialog = function(offset,request,field,append,title,sql) {
		$.ajax({ type: "GET", url: "/", data: 'path=apps/processes&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
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
		var url = "/?path=apps/processes&request=getProcessesFoldersHelp";
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/processes&request=deleteFolder&id=" + id, cache: false, success: function(data){
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/processes&request=restoreFolder&id=" + id, cache: false, success: function(data){
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

var processes_folder = new processesFolders('processes_folder');


function processesActions(status) {
	/*	0= new	1= print	2= send		3= duplicate	4= roster		5=refresh 	6 = delete*/
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
		case 10: actions = ['0','1','2','3','4','6','7','8']; break;
		// 5 == 11
		case 11: 	actions = ['1','2','4','6','7']; break;   			// print, send, refresh
		
		// rosters
		case 12: actions = ['0','1','2','3','5','6','7','8']; break;
		
		
		default: 	actions = ['6','7'];  								// none
	}
	$('#processesActions > li span').each( function(index) {
		if(index in oc(actions)) {
			$(this).removeClass('noactive');
		} else {
			$(this).addClass('noactive');
		}
	})
}

var processesLayout, processesInnerLayout;
var processeszIndex = 0; // zindex notes for mindmap
var currentProcessEditedNote = 0;

function setcEN(id) {
	currentProcessEditedNote = id;
}

$(document).ready(function() {
	
	processes.init();
	
	if($('#processes').length > 0) {
		processesLayout = $('#processes').layout({
				west__onresize:				function() { resetModuleHeightsnavThree('processes'); }
			,	resizeWhileDragging:		true
			,	spacing_open:				0
			,	spacing_closed:				0
			,	closable: 					false
			,	resizable: 					false
			,	slidable:					false
			, 	west__size:					325
			,	west__closable: 			true
			,	center__onresize: "processesInnerLayout.resizeAll"
			
		});
		
		processesInnerLayout = $('#processes div.ui-layout-center').layout({
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

		loadModuleStartnavThree('processes');
	}


	$("#processes1-outer").on('click', 'h3', function(e, passed_id) {
		e.preventDefault();
		navThreeTitleFirst('processes',$(this),passed_id)
		prevent_dblclick(e)
	}).disableSelection();


	$("#processes2-outer").on('click', 'h3', function(e, passed_id) {
		e.preventDefault();
		navThreeTitleSecond('processes',$(this),passed_id)
		prevent_dblclick(e)
	}).disableSelection();


	$("#processes3").on('click', 'h3', function(e, passed_id) {
		e.preventDefault();
		navThreeTitleThird('processes',$(this),passed_id)
		prevent_dblclick(e)
	}).disableSelection();


	$('#processes1').on('click', 'span.module-click', function(e) {
		e.preventDefault();
		navItemFirst('processes',$(this))
		prevent_dblclick(e)
	});


	$('#processes2').on('click', 'span.module-click', function(e) {
		e.preventDefault();
		navItemSecond('processes',$(this))
		prevent_dblclick(e)
	});


	$('#processes3').on('click', 'span.module-click', function(e) {
		e.preventDefault();
		navItemThird('processes',$(this))
		prevent_dblclick(e)
	});

	
	$(document).on('click', 'a.insertProcessFolderfromDialog', function(e) {
		e.preventDefault();
		var field = $(this).attr("field");
		var gid = $(this).attr("gid");
		var title = $(this).attr("title");
		var html = '<a class="listmember" uid="' + gid + '" field="'+field+'">' + title + '</a>';
		$("#"+field).html(html);
		$("#modalDialog").dialog('close');
		var obj = getCurrentModule();
		$('#processes .coform').ajaxSubmit(obj.poformOptions);
	});
	
	
// INTERLINKS FROM Content
	
	// load a process
	$(document).on('click', '.loadProcess', function(e) {
		e.preventDefault();
		var obj = getCurrentModule();
		if(confirmNavigation()) {
			formChanged = false;
			$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		}
		var id = $(this).attr("rel");
		$("#processes2-outer > h3").trigger('click', [id]);
	});


	/*$('span.actionConvert').on('click', function(e){
		e.preventDefault();
		if($(this).hasClass("noactive")) {
			return false;
		}
		processes_grids.actionConvert();
	});*/


	var tmp;
	processes.initItems();

	/*$(document).on('click', 'div.processesNoteToggle', function(e) {
		e.preventDefault();
		var id = $(this).attr("id").replace(/note-toggle-/, "");
		var height = $(this).attr("rel");
		if($(this).parents("div.note").height() == 20) {
			$(this).find('span').addClass("icon-toggle").removeClass("icon-toggle-active");
			$(this).parents("div.note")
				.animate({ height: height+'px' }, function() {
						$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/processes&request=setProcessNoteToggle&id="+id+"&t=0"});
				});
		} else {
			$(this).find('span').addClass("icon-toggle-active").removeClass("icon-toggle");
			$(this).parents("div.note")
				.animate({ height: 20 }, function() {
						$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/processes&request=setProcessNoteToggle&id="+id+"&t=1"});
				});
		}
	});*/


	$(document).on('click', 'span.processesAddNote', function(e) {
		e.preventDefault();
		var oid = $('#processes').data('first');
		var id = $('#processes').data('second');	
		//var z = ++processeszIndex;
		var zMax = Math.max.apply(null,$.map($('#processes-outer div.note'), function(e,n){
				return parseInt($(e).css('z-index'))||1 ;
				})
			);
		var z = zMax + 1;
		processeszIndex = z;
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/processes&request=newProcessNote&id="+id+"&z="+z, success: function(data){
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/processes&request=getProcessDetails&fid="+oid+"&id="+id, success: function(text){
				$("#processes-right").html(text.html);
				initProcessesContentScrollbar();
				}
			});
			}
		});
	});

	$(document).on('click', '#processes-outer div.note-title', function(e) {
		e.preventDefault();
		var id = parseInt($(this).attr("id").replace(/note-title-/, ""));
		currentProcessEditedNote = id;
		var html = $(this).html().replace(/(")/gi, "&quot;");
		var input = '<input type="text" id="input-note-' + id + '" name="input-note-' + id + '" value="' + html+ '" />';
		$("#note-title-" + id).replaceWith(input);
		$("#input-note-" + id).focus();
	});

	$(document).on('click', '#processes-outer div.note-text', function(e) {
		e.preventDefault();
		var id = parseInt($(this).attr("id").replace(/note-text-/, ""));
		currentProcessEditedNote = id;
		var html = $(this).html().replace(/(<br\s*\/?>)|(<p><\/p>)/gi, "");
		//var width = $(this).width();
		var height = $(this).height();
		var input = '<textarea id="input-text-' + id + '" name="input-text-' + id + '" style=" height: '+ height +'px; border: 0;">' + html+ '</textarea>';
		$("#note-text-" + id).replaceWith(input);
		$("#input-text-" + id).focus();
	});


	$(document).mousedown(function(e) {
		var obj = getCurrentModule();
		if(obj.name == 'processes') {
			var clicked=$(e.target); // get the element clicked
			if(currentProcessEditedNote != 0) {
				if(clicked.is('.note') || clicked.parents().is('.note')) { 
					var id = /[0-9]+/.exec(e.target.id);
					if(id != currentProcessEditedNote) {
						processes.saveItem(currentProcessEditedNote);
						currentProcessEditedNote = 0;
					}
				} else {
					processes.saveItem(currentProcessEditedNote);
					currentProcessEditedNote = 0;
				}
			}
		}
	});
	

	// autocomplete processes search
	$('.processes-search').livequery(function() {
		var id = $("#processes").data("second");
		$(this).autocomplete({
			appendTo: '#tabs-1',
			source: "?path=apps/processes&request=getProcessesSearch&exclude="+id,
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
	
	$(document).on('click', '.addProcessLink', function(e) {
		e.preventDefault();
		var id = $(this).attr("rel");
		var obj = getCurrentModule();
		obj.addParentLink(id);
	});


	$('#processes .globalSearch').livequery(function() {
		$(this).autocomplete({
			appendTo: '#processes',
			position: {my: "left top", at: "left bottom", collision: "none",offset: "-104 0"},
			source: "?path=apps/processes&request=getGlobalSearch",
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