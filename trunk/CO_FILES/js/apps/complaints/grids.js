/* grids Object */
function complaintsGrids(name) {
	this.name = name;


	this.formProcess = function(formData, form, poformOptions) {
		var title = $("#complaints input.title").fieldValue();
		if(title == "") {
			$.prompt(ALERT_NO_TITLE, {callback: setTitleFocus});
			return false;
		} else {
			formData[formData.length] = { "name": "title", "value": title };
		}
		
		formData[formData.length] = processListApps('owner');
		formData[formData.length] = processCustomTextApps('owner_ct');
		formData[formData.length] = processListApps('management');
		formData[formData.length] = processCustomTextApps('management_ct');
		formData[formData.length] = processListApps('team');
		formData[formData.length] = processCustomTextApps('team_ct');
		
		formData[formData.length] = processListApps('grid_access');
	 }
	 
	 
	 this.formResponse = function(data) {
		 switch(data.action) {
			case "edit":
				$("#complaints3 span[rel='"+data.id+"'] .text").html($("#complaints .title").val());
					switch(data.access) {
						case "0":
							$("#complaints3 span[rel="+data.id+"] .module-access-status").removeClass("module-access-active");
						break;
						case "1":
							$("#complaints3 span[rel="+data.id+"] .module-access-status").addClass("module-access-active");
						break;
					}
			break;
		}
	}
	
	
	this.poformOptions = { async: false, beforeSubmit: this.formProcess, dataType: 'json', success: this.formResponse };


	this.getDetails = function(moduleidx,liindex,list) {
		var id = $("#complaints3 ul:eq("+moduleidx+") .module-click:eq("+liindex+")").attr("rel");
		$('#complaints').data({ "third" : id});
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/complaints/modules/grids&request=getDetails&id="+id, success: function(data){
			$("#complaints-right").empty().html(data.html);
			
			if($('#checkedOut').length > 0) {
					$("#complaints3 ul[rel=grids] .active-link .icon-checked-out").addClass('icon-checked-out-active');
				} else {
					$("#complaints3 ul[rel=grids] .active-link .icon-checked-out").removeClass('icon-checked-out-active');
				}
			
			if(list == 0) {
				switch (data.access) {
					case "sysadmin": case "admin":
						complaintsActions(12);
					break;
					case "guest":
						complaintsActions(5);
					break;
				}
			} else {
				switch (data.access) {
					case "sysadmin": case "admin" :
						if(list == "<li></li>") {
							complaintsActions(3);
						} else {
							complaintsActions(12);
						}
					break;
					case "guest":
						if(list == "<li></li>") {
							complaintsActions();
						} else {
							complaintsActions(5);
						}
					break;
				}
				
			}
			initComplaintsContentScrollbar();
			}
		});	
	}


	this.actionNew = function() {
		var module = this;
		var cid = $('#complaints input[name="id"]').val()
		module.checkIn(cid);
	
		var id = $('#complaints').data('second');
		$.ajax({ type: "GET", url: "/", dataType: 'json', data: 'path=apps/complaints/modules/grids&request=createNew&id=' + id, cache: false, success: function(data){
			$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/complaints/modules/grids&request=getList&id="+id, success: function(list){
				$("#complaints3 ul[rel=grids]").html(list.html);
				$('#complaints_grids_items').html(list.items);
				var liindex = $("#complaints3 ul[rel=grids] .module-click").index($("#complaints3 ul[rel=grids] .module-click[rel='"+data.id+"']"));
				$("#complaints3 ul[rel=grids] .module-click:eq("+liindex+")").addClass('active-link');
				var moduleidx = $("#complaints3 ul").index($("#complaints3 ul[rel=grids]"));
				module.getDetails(moduleidx,liindex);
				setTimeout(function() { $('#complaints-right .focusTitle').trigger('click'); }, 800);
				}
			});
			}
		});
	}


	this.actionDuplicate = function() {
		var module = this;
		var cid = $('#complaints input[name="id"]').val()
		module.checkIn(cid);
		var id = $("#complaints").data("third");
		var pid = $("#complaints").data("second");
		$.ajax({ type: "GET", url: "/", data: 'path=apps/complaints/modules/grids&request=createDuplicate&id=' + id, cache: false, success: function(mid){
			$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/complaints/modules/grids&request=getList&id="+pid, success: function(data){																																																																				
				$("#complaints3 ul[rel=grids]").html(data.html);
				$('#complaints_grids_items').html(data.items);
				var moduleidx = $("#complaints3 ul").index($("#complaints3 ul[rel=grids]"));
				var liindex = $("#complaints3 ul[rel=grids] .module-click").index($("#complaints3 ul[rel=grids] .module-click[rel='"+mid+"']"));
				module.getDetails(moduleidx,liindex);
				$("#complaints3 ul[rel=grids] .module-click:eq("+liindex+")").addClass('active-link');
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
					var id = $("#complaints").data("third");
					var pid = $("#complaints").data("second");
					$.ajax({ type: "GET", url: "/", data: "path=apps/complaints/modules/grids&request=binGrid&id=" + id, cache: false, success: function(data){
							if(data == "true") {
								$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/complaints/modules/grids&request=getList&id="+pid, success: function(data){
									$("#complaints3 ul[rel=grids]").html(data.html);
									$('#complaints_grids_items').html(data.items);
									if(data.html == "<li></li>") {
										complaintsActions(3);
										//alert('yo');
									} else {
										complaintsActions(12);
									}
									var moduleidx = $("#complaints3 ul").index($("#complaints3 ul[rel=grids]"));
									var liindex = 0;
									module.getDetails(moduleidx,liindex);
									$("#complaints3 ul[rel=grids] .module-click:eq("+liindex+")").addClass('active-link');
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
		$.ajax({ type: "GET", url: "/", async: false, data: 'path=apps/complaints/modules/grids&request=checkinGrid&id='+id, success: function(data){
			if(!data) {
				prompt("something wrong");
			}
			}
		});
	}
	
	
	this.actionRefresh = function() {
		var id = $("#complaints").data("third");
		var pid = $("#complaints").data("second");
		$("#complaints3 ul[rel=grids] .active-link").trigger("click");
		$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/complaints/modules/grids&request=getList&id="+pid, success: function(data){																																																																				
			$("#complaints3 ul[rel=grids]").html(data.html);
			$('#complaints_grids_items').html(data.items);
			var liindex = $("#complaints3 ul[rel=grids] .module-click").index($("#complaints3 ul[rel=grids] .module-click[rel='"+id+"']"));
			$("#complaints3 ul[rel=grids] .module-click:eq("+liindex+")").addClass('active-link');
			}
		});
	}


	this.actionPrint = function() {
		var id = $("#complaints").data("third");
		var url ='/?path=apps/complaints/modules/grids&request=printDetails&id='+id;
		$("#documentloader").attr('src', url);
	}


	this.actionSend = function() {
		var id = $("#complaints").data("third");
		$.ajax({ type: "GET", url: "/", data: "path=apps/complaints/modules/grids&request=getSend&id="+id, success: function(html){
			$("#modalDialogForward").html(html).dialog('open');
			}
		});
	}


	this.actionSendtoResponse = function() {
		var id = $("#complaints").data("third");
		$.ajax({ type: "GET", url: "/", data: "path=apps/complaints/modules/grids&request=getSendtoDetails&id="+id, success: function(html){
			$("#complaintsgrid_sendto").html(html);
			//$("#modalDialogForward").dialog('close');
			}
		});
	}
	
	
	this.sortclick = function (obj,sortcur,sortnew) {
		var module = this;
		var cid = $('#complaints input[name="id"]').val()
		module.checkIn(cid);
		
		var fid = $("#complaints2 .module-click:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/complaints/modules/grids&request=getList&id="+fid+"&sort="+sortnew, success: function(data){
			$("#complaints3 ul[rel=grids]").html(data.html);
			$('#complaints_grids_items').html(data.items);
			obj.attr("rel",sortnew);
			obj.removeClass("sort"+sortcur).addClass("sort"+sortnew);
			var id = $("#complaints3 ul[rel=grids] .module-click:eq(0)").attr("rel");
			$('#complaints').data('third',id);
			if(id == undefined) {
				return false;
			}
			var moduleidx = $("#complaints3 ul").index($("#complaints3 ul[rel=grids]"));
			module.getDetails(moduleidx,0);
			$("#complaints3 ul[rel=grids] .module-click:eq(0)").addClass('active-link');
		}
		});
	}


	this.sortdrag = function (order) {
		var fid = $("#complaints").data("second");
		$.ajax({ type: "GET", url: "/", data: "path=apps/complaints/modules/grids&request=setOrder&"+order+"&id="+fid, success: function(html){
			$("#complaints3 .sort:visible").attr("rel", "3");
			$("#complaints3 .sort:visible").removeClass("sort1").removeClass("sort2").addClass("sort3");
			}
		});
	}

	
	this.actionDialog = function(offset,request,field,append,title,sql) {
		switch(request) {
			case "getProjectFolderDialog":
				$.ajax({ type: "GET", url: "/", data: 'path=apps/projects&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
					$("#modalDialog").html(html);
					//$("#modalDialog").dialog('option', 'height', 50);
					$("#modalDialog").dialog('option', 'position', offset);
					$("#modalDialog").dialog('option', 'title', title);
					$("#modalDialog").dialog('open');
					}
				});
			break;
			case "getAccessDialog":
				$.ajax({ type: "GET", url: "/", data: 'path=apps/complaints&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
					$("#modalDialog").html(html);
					//$("#modalDialog").dialog('option', 'height', 50);
					$("#modalDialog").dialog('option', 'position', offset);
					$("#modalDialog").dialog('option', 'title', title);
					$("#modalDialog").dialog('open');
					}
				});
			break;
			case "getGridStatusDialog":
				$.ajax({ type: "GET", url: "/", data: 'path=apps/complaints/modules/grids&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
					$("#modalDialog").html(html);
					$("#modalDialog").dialog('option', 'position', offset);
					$("#modalDialog").dialog('option', 'title', title);
					$("#modalDialog").dialog('open');
					}
				});
			break;
			case "getDocumentsDialog":
				var id = $("#complaints").data("second");
				$.ajax({ type: "GET", url: "/", data: 'path=apps/complaints/modules/documents&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql+'&id=' + id, success: function(html){
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


	this.insertStatus = function(rel,text) {
		var module = this;
		var html = '<div class="listmember" field="complaintsgrid_status" uid="'+rel+'" style="float: left">' + text + '</div>';
		$("#complaintsgrid_status").html(html);
		$("#modalDialog").dialog("close");
		$("#complaintsgrid_status").next().val("");
		$('#complaints .coform').ajaxSubmit(module.poformOptions);
	}


	this.insertStatusDate = function(rel,text) {
		var html = '<div class="listmember" field="complaintsgrid_status" uid="'+rel+'" style="float: left">' + text + '</div>';
		$("#complaintsgrid_status").html(html);
		$("#modalDialog").dialog("close");
		$("#complaintsgrid_status").nextAll('img').trigger('click');
	}
	
	
	this.insertFolderFromDialog = function(field,gid,title) {
		var html = '<span class="listmember" uid="' + gid + '" field="'+field+'">' + title + '</span>';
		$("#"+field).html(html);
		$("#modalDialog").dialog('close');
	}
	
	
	// notes
	this.saveItem = function(id) {
		if($("#input-note").length > 0) {
			var title = $("#input-note").val();
		} else {
			var title = $("#complaints-grid-note-title").html();
		}
		if($("#input-text").length > 0) {
			var text = $("#input-text").val();
		} else {
			var text = $("#complaints-grid-note-text").html().replace(/(<br\s*\/?>)|(<p><\/p>)/gi, "");
		}
		$.ajax({ type: "POST", url: "/", data: { path: 'apps/complaints/modules/grids', request: 'saveGridNote', id: id, title: title, text: text }, success: function(data){
		//$.ajax({ type: "POST", url: "/", data: "path=apps/complaints/modules/grids&request=saveGridNote&id="+id+"&title="+title+"&text="+text, success: function(data){
				
				
				
				$('#item_'+id+' div.itemTitle').html(title);
				if($("#input-note").length > 0) {
					var note_title = $(document.createElement('div')).attr("id", "complaints-grid-note-title").attr("class", "note-title note-title-design").html(title);
					$("#complaints-grid-note").find('input').replaceWith(note_title); 
				}
				if($("#input-text").length > 0) {
					var height = $("#input-text").height();
					var note_text = $(document.createElement('div')).attr("id", "complaints-grid-note-text").attr("class", "note-text note-text-design").css("height",height).html(text);
					$("#complaints-grid-note").find('textarea').replaceWith(note_text); 
				}
				$('#complaints-grid-note').slideUp();
				currentComplaintGridClickedNote = 0;
			}
		});
	}


	this.newItem = function() {
		var mid = $("#complaints").data("third");
		var num = parseInt($("#complaints-right .task_sort").size());
		$.ajax({ type: "GET", url: "/", data: "path=apps/complaints/modules/grids&request=addTask&mid=" + mid + "&num=" + num + "&sort=" + num, success: function(html){
			$('#complaintsgridtasks').append(html);
			var idx = parseInt($('.cbx').size() -1);
			var element = $('.cbx:eq('+idx+')');
			$.jNice.CheckAddPO(element);
			$('.gridouter:eq('+idx+')').slideDown(function() {
				$(this).find(":text:eq(0)").focus();
				if(idx == 6) {
				$('#complaints-right .addTaskTable').clone().insertAfter('#phasetasks');
				}
				initComplaintsContentScrollbar();
			});
			}
		});
	}


	this.binItem = function(id) {
		var txt = ALERT_DELETE;
		var langbuttons = {};
		langbuttons[ALERT_YES] = true;
		langbuttons[ALERT_NO] = false;
		$.prompt(txt,{ 
			buttons:langbuttons,
			callback: function(v,m,f){		
				if(v){
					$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/complaints/modules/grids&request=binItem&id="+id, success: function(data){
						if(data){
							$("#item_"+id).slideUp(function() { 
									phase = $(this).parent();
									if($(this).hasClass('colTitle')) {
										phase = $(this).parent().next();
										$(this).parent().html('<span class="newNoteItem newNoteTitle"></span>');
										
									}
									if($(this).hasClass('colStagegate')) {
										phase = $(this).parent().parent().parent().prev();
										$(this).parent().html('<span class="newNoteItem newNoteStagegate"></span>');
									}
									//phase = $(this).parent();
									$(this).remove();
									phase.trigger('sortupdate');
								});
						} 
						}
					});
				} 
			}
		});	
	}
	
	
	this.binColumn = function(id) {
		var txt = ALERT_DELETE;
		var langbuttons = {};
		langbuttons[ALERT_YES] = true;
		langbuttons[ALERT_NO] = false;
		$.prompt(txt,{ 
			buttons:langbuttons,
			callback: function(v,m,f){		
				if(v){
					$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/complaints/modules/grids&request=binGridColumn&id="+id, success: function(text){						
							$('#gridscol_'+id).animate({width: 0}, function(){ 
								$(this).remove();
								$("#complaints-grid").width($("#complaints-grid").width()-230);
							});
						}
					});
				} 
			}
		});	
	}


	this.actionHelp = function() {
		var url = "/?path=apps/complaints/modules/grids&request=getHelp";
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/complaints/modules/grids&request=deleteGrid&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#grid_'+id).slideUp();
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/complaints/modules/grids&request=restoreGrid&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#grid_'+id).slideUp();
						}
					}
					});
				} 
			}
		});
	}
	
	this.binDeleteColumn = function(id) {
		var txt = ALERT_DELETE_REALLY;
		var langbuttons = {};
		langbuttons[ALERT_YES] = true;
		langbuttons[ALERT_NO] = false;
		$.prompt(txt,{ 
			buttons:langbuttons,
			callback: function(v,m,f){		
				if(v){
					$.ajax({ type: "GET", url: "/", data: "path=apps/complaints/modules/grids&request=deleteGridColumn&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#grid_col_'+id).slideUp();
						}
					}
					});
				} 
			}
		});
	}

	this.binRestoreColumn = function(id) {
		var txt = ALERT_RESTORE;
		var langbuttons = {};
		langbuttons[ALERT_YES] = true;
		langbuttons[ALERT_NO] = false;
		$.prompt(txt,{ 
			buttons:langbuttons,
			callback: function(v,m,f){		
				if(v){
					$.ajax({ type: "GET", url: "/", data: "path=apps/complaints/modules/grids&request=restoreGridColumn&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#grid_col_'+id).slideUp();
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
			callback: function(v,m,f){		
				if(v){
					$.ajax({ type: "GET", url: "/", data: "path=apps/complaints/modules/grids&request=deleteGridTask&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#grid_task_'+id).slideUp();
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
			callback: function(v,m,f){		
				if(v){
					$.ajax({ type: "GET", url: "/", data: "path=apps/complaints/modules/grids&request=restoreGridTask&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#grid_task_'+id).slideUp();
						}
					}
					});
				} 
			}
		});
	}


	this.actionConvert = function() {
		$('#modalDialogComplaintsGrid').slideDown();
	}

}

var complaints_grids = new complaintsGrids('complaints_grids');

var currentComplaintGridClickedNote = 0;
var currentComplaintGridEditedNote = 0;

$(document).ready(function() {

// console
	/*$('#complaints-console-notes>div').livequery( function() {
		$(this).draggable({
			connectToSortable: ".complaints-phase",
			helper: "clone",
			appendTo: '#complaints-right',
			zIndex: 102,
			revert: 'invalid',
			start: function(e, ui) {
				$(ui.helper).addClass("ui-draggable-helper-grid");
			}
		});
	});

	$('#complaints-console').livequery( function() {
		$(this).draggable({handle: 'h3', containment: '#complaints-right .scroll-pane', cursor: 'move'})
		.resizable({ minHeight: 25, minWidth: 230});
	});*/

// grid outer
	$('#complaints-grid').livequery( function() {
		$(this).sortable({
			items: '>div',
			handle: 'h3',
			handle: '.dragColActive',
			axis: 'x',
			tolerance: 'pointer',
			containment: '#complaints-grid',
			update: function(event,ui) {
				var order = $(this).sortable("serialize");
				$.ajax({ type: "GET", url: "/", data: "path=apps/complaints/modules/grids&request=saveGridColumns&"+ order, cache: false, success: function(data){
					}
				});
			}
		})
	});

// Title
	$('#complaints-grid .complaints-col-title').livequery( function() {
		$(this).droppable({
			accept: '.droppable',
			drop: function( event, ui ) {
				var tocopy = false;
				var orig = false;
				var attr = ui.draggable.attr('id');
				if($(this).find('>div').length > 0) {
					tocopy = $(this).html();
					orig = $(this).find('>div').attr('id');
					if(attr != 'undefined') {
						if(orig == attr) {
							return false;	
						}
					}
				}
				var idx = $('#complaints-grid .complaints-col-title').index(this);
				if(tocopy) {
					$('#complaints-grid .complaints-phase:eq('+idx+')').prepend(tocopy);
					$('#complaints-grid .complaints-phase:eq('+idx+') > div:eq(0)').removeClass('colTitle').removeClass('ui-sortable-helper').removeClass('ui-draggable').removeClass('ui-draggable-dragging').attr('style','');
				}
				var insert = ui.draggable.clone();
				$(this).html(insert.attr('style','').addClass('colTitle').removeClass('ui-sortable-helper')).addClass('planned');
				var pid = $("#complaints").data("third");
				var col = parseInt($(this).parent().attr("id").replace(/gridscol_/, ""));
				
				if(ui.draggable.hasClass('colStagegate')) {
					var id = ui.draggable.attr('rel');
					$('#complaints-grid div[id=item_'+id+']').remove();
					insert.attr('id','item_' + id).removeClass('colStagegate');
					$.ajax({ type: "GET", url: "/", async: false, data: "path=apps/complaints/modules/grids&request=saveGridNoteTitle&id=" + id + "&col="+col, cache: false, success: function(id){
							$('#complaints-grid .complaints-phase:eq('+idx+')').trigger('sortupdate');
						}
					});
				} else if (typeof attr == 'undefined' || attr == false) {
					var id = ui.draggable.attr('rel');
					$.ajax({ type: "GET", url: "/", data: "path=apps/complaints/modules/grids&request=saveGridNewNoteTitle&pid="+pid+"&id=" + id+"&col="+col, cache: false, success: function(id){
						insert.attr('id','item_' + id).attr('rel',id);
						var e = '<input name="" type="checkbox" value="'+id+'" class="cbx jNiceHidden" />';
						var e = insert.find('div.statusItem').html(e);
						var element = insert.find('input');
						$.jNice.CheckAddPO(element);
						$('#complaints-grid .complaints-phase:eq('+idx+')').trigger('sortupdate');
						}
					});
				} else { // if dropped from list
					if(ui.draggable.hasClass('colTitle')) {
						ui.draggable.parent().html('<span class="newNoteItem newNoteTitle"></span>');
					}
					var dragidx = $('#complaints-grid .complaints-phase').index(ui.draggable.parent());
					ui.draggable.remove();
					var id = attr.replace(/item_/, "");
					$.ajax({ type: "GET", url: "/", async: false, data: "path=apps/complaints/modules/grids&request=saveGridNoteTitle&id=" + id + "&col="+col, cache: false, success: function(id){
						if(dragidx != idx) {
							$('#complaints-grid .complaints-phase:eq('+idx+')').trigger('sortupdate');
						}
						}
					});
				}
			}
		})	
	})

	$('#complaints-grid .complaints-col-title>div').livequery( function() {
		$(this).draggable({
			connectToSortable: ".complaints-phase",
			helper: "clone",
			handle: '.dragItem',
			revert: 'invalid',
			appendTo: '#complaints-right',
			zIndex: 101,
			start: function(e, ui) {
				$(ui.helper).addClass("ui-draggable-helper-grid");
			}
		});
	})


// Stagegate
	$('#complaints-grid .complaints-col-stagegate').livequery( function() {
		$(this).droppable({
			accept: '.droppable',
			drop: function( event, ui ) {
				var tocopy = false;
				var orig = false;
				var attr = ui.draggable.attr('id');
				if($(this).find('>div').length > 0) {
					tocopy = $(this).html();
					orig = $(this).find('>div').attr('id');
					if(attr != 'undefined') {
						if(orig == attr) {
							return false;	
						}
					}
				}
				var idx = $('#complaints-grid .complaints-col-stagegate').index(this);
				if(tocopy) {
					$('#complaints-grid .complaints-phase:eq('+idx+')').prepend(tocopy);
					$('#complaints-grid .complaints-phase:eq('+idx+') > div:eq(0)').removeClass('colStagegate').removeClass('ui-sortable-helper').removeClass('ui-draggable').removeClass('ui-draggable-dragging').attr('style','');
				}
				var insert = ui.draggable.clone();
				$(this).html(insert.attr('style','').addClass('colStagegate').removeClass('ui-sortable-helper'));
				//var attr = ui.draggable.attr('id');
				var pid = $("#complaints").data("third");
				var col = parseInt($(this).parent().parent().parent().attr("id").replace(/gridscol_/, ""));
				if(ui.draggable.hasClass('colTitle')) {
					var id = ui.draggable.attr('rel');
					$('#complaints-grid div[id=item_'+id+']').remove();
					insert.attr('id','item_' + id).removeClass('colTitle');
					$.ajax({ type: "GET", url: "/", async: false, data: "path=apps/complaints/modules/grids&request=saveGridNoteStagegate&id=" + id + "&col="+col, cache: false, success: function(id){
						$('#complaints-grid .complaints-phase:eq('+idx+')').trigger('sortupdate');
						}
					});
				} else if (typeof attr == 'undefined' || attr == false) {
					var id = ui.draggable.attr('rel');
					$.ajax({ type: "GET", url: "/", async: false, data: "path=apps/complaints/modules/grids&request=saveGridNewNoteStagegate&pid="+pid+"&id=" + id+"&col="+col, cache: false, success: function(id){
						insert.attr('id','item_' + id).attr('rel',id);
						var e = '<input name="" type="checkbox" value="'+id+'" class="cbx jNiceHidden" />';
						var e = insert.find('div.statusItem').html(e);
						var element = insert.find('input');
						$.jNice.CheckAddPO(element);
						$('#complaints-grid .complaints-phase:eq('+idx+')').trigger('sortupdate');
						}
					});
				} else { // if dropped from list
					if(ui.draggable.hasClass('colStagegate')) {
						ui.draggable.parent().html('<span class="newNoteItem newNoteStagegate"></span>');
					}
					var dragidx = $('#complaints-grid .complaints-phase').index(ui.draggable.parent());
					ui.draggable.remove();
					var id = attr.replace(/item_/, "");
					$.ajax({ type: "GET", url: "/", async: false, data: "path=apps/complaints/modules/grids&request=saveGridNoteStagegate&id=" + id + "&col="+col, cache: false, success: function(id){
						if(dragidx != idx) {
							$('#complaints-grid .complaints-phase:eq('+idx+')').trigger('sortupdate');
						}
						}
					});
				}
			}
		})	
	})

	$('#complaints-grid .complaints-col-stagegate>div').livequery( function() {
		$(this).draggable({
			connectToSortable: ".complaints-phase",
			helper: "clone",
			handle: '.dragItem',
			revert: 'invalid',
			appendTo: '#complaints-right',
			zIndex: 101,
			start: function(e, ui) {
				$(ui.helper).addClass("ui-draggable-helper-grid");
			}
		});
	})


// SORTABLE LIST
	$('#complaints-grid .complaints-phase').livequery( function() {
		$(this).sortable({
			items: '>div',
			handle: '.dragItem',
			connectWith: '.complaints-phase,.complaints-col-title,.complaints-col-stagegate',
			receive: function (event, ui) { // add this handler
				setTimeout(function() {
					if(ui.item.hasClass('colTitle')) {
						ui.item.parent().html('<span class="newNoteItem newNoteTitle"></span>');
						ui.item.remove();
					}
					if(ui.item.hasClass('colStagegate')) {
						ui.item.parent().html('<span class="newNoteItem newNoteStagegate"></span>');
						ui.item.remove();
					}
				}, 100);
			}
		}).disableSelection().bind('sortupdate', function(event, ui) {
			var col = parseInt($(this).parent().attr("id").replace(/gridscol_/, ""));
			var idx = $('#complaints-grid .complaints-phase').index(this);
			$('#complaints-grid .complaints-phase:eq('+idx+')>div').each(function(index) {
				var div = $(this);
				var attr = div.attr('id');
				if (typeof attr == 'undefined' || attr == false) {
					if(div.hasClass('colTitle') || div.hasClass('colStagegate')) {
						var id = div.attr('rel');
						div.removeClass('colTitle'). removeClass('colStagegate').removeClass('ui-draggable').removeClass('ui-draggable-dragging').attr('style','');
						div.attr('id','item_' + id);
						var e = '<input name="" type="checkbox" value="'+id+'" class="cbx jNiceHidden" />';
						var e = div.find('div.statusItem').html(e);
						var element = div.find('input');
						$.jNice.CheckAddPO(element);						
					} else {
						var id = div.attr('rel');
						if (typeof id != 'undefined') {
							var pid = $("#complaints").data("third");
							$.ajax({ type: "GET", url: "/", async: false, data: "path=apps/complaints/modules/grids&request=saveGridNewNote&pid="+pid+"&id=" + id, cache: false, success: function(id){
								div.attr('id','item_' + id);
								var e = '<input name="" type="checkbox" value="'+id+'" class="cbx jNiceHidden" />';
								var e = div.find('div.statusItem').html(e);
								var element = div.find('input');
								$.jNice.CheckAddPO(element);
								}
							});
						}
					}
				}
			});
			var order = $('#complaints-grid .complaints-phase:eq('+idx+')').sortable("serialize");
			$.ajax({ type: "GET", url: "/", async: false, data: "path=apps/complaints/modules/grids&request=saveGridItems&col="+col+"&"+ order, cache: false, success: function(data){
				var titleset = $('div.complaints-col-title:eq('+idx+')').html();
				var title = 0;
				if(titleset != "" && titleset != '<span class="newNoteItem newNoteTitle"></span>') {
					title = 1;
				}
				var ncbx = $('div.complaints-phase:eq('+idx+') input:checkbox').length;
				var n = $('div.complaints-phase:eq('+idx+') input:checked').length;
				if(ncbx > 0 || title == 1) {
					$('div.complaints-col-title:eq('+idx+')').removeClass('progress').removeClass('finished').addClass('planned');
					$('div.complaints-col-footer:eq('+idx+') .complaints-stagegate').removeClass('active');
				}
				if(ncbx == 0 && title == 0) {
					$('div.complaints-col-title:eq('+idx+')').removeClass('progress').removeClass('finished').removeClass('planned');
					$('div.complaints-col-footer:eq('+idx+') .complaints-stagegate').removeClass('active');
				}
				if(ncbx > n && n > 0) {
					$('div.complaints-col-title:eq('+idx+')').removeClass('planned').removeClass('finished').addClass('progress');
					$('div.complaints-col-footer:eq('+idx+') .complaints-stagegate').removeClass('active');
				}
				if(ncbx > 0 && n == ncbx) {
					$('div.complaints-col-title:eq('+idx+')').removeClass('planned').removeClass('finished').addClass('finished');
					$('div.complaints-col-footer:eq('+idx+') .complaints-stagegate').addClass('active');
				}
				// calc grid height
				var numitems = 0;
				$('#complaints-grid .complaints-phase').each(function() {
					var items = $(this).find('>div').size();
					// set new
					var t = items*27+78+4;
					$(this).find('>span').animate({top: t});
					
					if(items > numitems) {
						numitems = items;
					}
				});
				var colheight = numitems*27+78+80+8;
				if (colheight < 266+8) {
					colheight = 266+8;
				}
				var listheight = numitems*27+27;
				if (listheight < 135) {
					listheight = 135;
				}
				$('#complaints-grid .complaints-phase').height(listheight).parent().animate({height: colheight});
				$('#complaints-grid').animate({height: colheight+1});
				}
			});
    	});
	})
	
	/*$(document).on('click', '#complaints-console a.collapse', function(e) {
		e.preventDefault();
		var height = 25;
		if($(this).hasClass('closed')) {
			var height = 250;
		}
		$(this).toggleClass('closed').parent().parent().animate({'height': height});
	});	*/
	
	
	$("#complaints-grid input.colDays").livequery(function () {
          if($(this).hasClass('noperm')) {
			  return false;
		  }
		  $(this).data('initial_value', $(this).val());
		  $(this).keydown(function(event) {
			// Allow only backspace and delete
			if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 32 ) {
				// let it happen, don't do anything
			}
			else {
				// Ensure that it is a number and stop the keypress
				if ((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
					event.preventDefault(); 
				}   
			}
		})
		//$(this).blur(function() {
		$(this).blur(function() {
			var days = $(this).val();
			if (days != $(this).data('initial_value')) {
				var col = parseInt($(this).parent().parent().parent().parent().attr("id").replace(/gridscol_/, ""));
				if(days == '') {
				  $(this).val('0');
				  days = 0;
				}
				
				$.ajax({ type: "GET", url: "/", data: "path=apps/complaints/modules/grids&request=saveGridColDays&id="+col+"&days="+days, cache: false, success: function(num){
			}
		});
				var total = 0;
				$("#complaints-grid input.colDays").each(function() {
					total += parseInt($(this).val());					 
				})
				$('#complaintGridDays').html(total);
				$(this).data('initial_value', $(this).val());
		  	}
		});
	});


	$(document).on('click', '#complaints-add-column', function(e) {
		e.preventDefault();
		var pid = $("#complaints").data("third");
		var sor = $('#complaints-grid>div').size();
		var styles = '';
		if(sor != 0) {
			//var styles = ' style="height: ' + $('#complaints-grid>div:eq(0)').height() + 'px"';
		}
		$("#complaints-grid").width($("#complaints-grid").width()+230);
		$.ajax({ type: "GET", url: "/", data: "path=apps/complaints/modules/grids&request=newGridColumn&id="+pid+"&sort="+sor, cache: false, success: function(num){
			$("#complaints-grid").append('<div id="gridscol_' + num + '"><div id="complaints-col-delete-' + num + '" class="complaints-column-delete"><span class="icon-delete"></span></div><div class="dragCol"></div><div class="complaints-col-title"><span class="newNoteItem newNoteTitle"></span></div><div class="grids-spacer"></div><div class="complaints-phase complaints-phase-design ui-sortable"><span class="newNoteItem newNote"></span></div><div class="grids-spacer"></div><div class="complaints-col-footer"><div class="complaints-col-footer-stagegate"><div class="complaints-stagegate"></div><div class="complaints-col-stagegate ui-droppable"><span class="newNoteItem newNoteStagegate"></span></div></div><div class="complaints-col-footer-days"><div style=""><input type="text" style="margin" maxlength="3" size="3" value="0" name="" class="colDays"></div></div></div></div>').sortable("refresh");
			//initComplaintsPhases();
			// calc grid height
				var numitems = 0;
				$('#complaints-grid .complaints-phase').each(function() {
					var items = $(this).find('>div').size();
					// set new
					var t = items*27+78+4;
					$(this).find('>span').animate({top: t});
					
					if(items > numitems) {
						numitems = items;
					}
				});
				var colheight = numitems*27+78+80+8;
				if (colheight < 266+8) {
					colheight = 266+8;
				}
				var listheight = numitems*27+27;
				if (listheight < 135) {
					listheight = 135;
				}
				$('#complaints-grid .complaints-phase').height(listheight).parent().animate({height: colheight});
				$('#complaints-grid').animate({height: colheight+1});
			}
		});
	})

	$(document).on('click', 'div.complaints-column-delete', function(e) {
		e.preventDefault();
		var id = $(this).attr("id").replace(/complaints-col-delete-/, "");
		complaints_grids.binColumn(id);
	});


	$(document).on('click', '#complaints-grid span.newNote', function(e) {
		e.preventDefault();
			//var clicked = $(this);
			var idx = $('#complaints-grid .newNote').index(this);
			var pid = $("#complaints").data("third");
			$.ajax({ type: "GET", url: "/", data: "path=apps/complaints/modules/grids&request=saveGridNewManualNote&pid="+pid, cache: false, success: function(html){
					var phase = $('#complaints-grid .complaints-phase:eq('+idx+')');
					phase.append(html);
					var element = phase.find('input:last');
					$.jNice.CheckAddPO(element);
					phase.trigger('sortupdate');
				}
			});
	});
	
	
	$(document).on('click', '#complaints-grid .newNoteTitle', function(e) {
		e.preventDefault();
		var col = parseInt($(this).parent().parent().attr("id").replace(/gridscol_/, ""));
		var pid = $("#complaints").data("third");
		$(this).parent().addClass('planned');
		$.ajax({ type: "GET", url: "/", data: "path=apps/complaints/modules/grids&request=saveGridNewManualTitle&pid="+pid+"&col="+col, cache: false, success: function(html){	
				//var phase = $('#complaints-grid .complaints-col-title:eq('+idx+')');
				var phase = $('#gridscol_'+col+' .complaints-col-title');
				phase.html(html);
				var element = phase.find('input');
				$.jNice.CheckAddPO(element);
				phase.next().trigger('sortupdate');
			}
		});
	});
	
	
	$(document).on('click', '#complaints-grid .newNoteStagegate', function(e) {
		e.preventDefault();
		var col = parseInt($(this).parent().parent().parent().parent().attr("id").replace(/gridscol_/, ""));
		var pid = $("#complaints").data("third");
		$.ajax({ type: "GET", url: "/", data: "path=apps/complaints/modules/grids&request=saveGridNewManualStagegate&pid="+pid+"&col="+col, cache: false, success: function(html){	
				var phase = $('#gridscol_'+col+' .complaints-col-stagegate');
				phase.html(html);
				var element = phase.find('input');
				$.jNice.CheckAddPO(element);
				phase.prev().trigger('sortupdate');
			}
		});
	});


	$(document).on('click', '#complaints-grid div.itemTitle', function(e) {
		e.preventDefault()
		if($(this).hasClass('noperm')) {
			return false;
		}
		var addtop = 162;
		var addleft = 15;
		if($(this).parent().hasClass('colStagegate')) {
			var idx = $('#complaints-grid .newNote').index(this);
			var f = $('#complaints-grid .complaints-col-footer:eq(0)').position();
			var l = $(this).parent().parent().parent().parent().parent().position();
			addtop = f.top+addtop;
			addleft = l.left+addleft;
		}
		if($('#input-note').is(':visible') || $('#input-text').is(':visible')) {
			complaints_grids.saveItem(currentComplaintGridClickedNote);
			return false;
		} else {
			var id = parseInt($(this).parent().attr("id").replace(/item_/, ""));
			var note = $(this).parent();
			var left = note.parent().parent().position();
			left = left.left+addleft;
			var pos = note.position();
			var top = pos.top+addtop;
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/complaints/modules/grids&request=getGridNote&id="+id, success: function(data){
				currentComplaintGridClickedNote = id;
				$('#complaints-grid-note-title').html(data.title);
				$('#complaints-grid-note-text').html(data.text);
				$('#complaints-grid-note-save a').attr('rel',id);
				$('#complaints-grid-note-info-content').html(data.info);
				$('#complaints-grid-note-info').css('right','28px');
				$('#complaints-grid-note').css('top', top+'px').css('left', left+'px').slideDown();
				}
			});
		}
	})

	$(document).on('click', '#complaints-notes-outer div.note-title', function(e) {
		e.preventDefault();
		var html = $(this).html().replace(/(")/gi, "&quot;");
		var input = '<input type="text" id="input-note" name="input-note" value="' + html+ '" />';
		$(this).replaceWith(input);
		$("#input-note").focus();
	});

	$(document).on('click', '#complaints-grid-outer div.note-text', function(e) {
		e.preventDefault();
		var html = $(this).html().replace(/(<br\s*\/?>)|(<p><\/p>)/gi, "");
		var width = $(this).width();
		var height = $(this).height();
		var input = '<textarea id="input-text" name="input-text" style="width: '+ width +'px; height: '+ height +'px; border: 0;">' + html+ '</textarea>';
		$("#complaints-grid-note-text").replaceWith(input);
		$("#input-text").focus();
	});


	$(document).on('click', 'span.actionComplaintsGridsConvert', function(e) {
		e.preventDefault();
		var id = $("#complaints").data("third");
		var kickofffield = Date.parse($("#complaints input[name='kickoff']").val());
		var kickoff = kickofffield.toString("yyyy-MM-dd");
		var folder = $('#complaintsgridprojectsfolder>span').attr('uid');
		if(typeof folder == 'undefined' || folder == false) {
			$.prompt(ALERT_CHOOSE_FOLDER);
			return false;
		}
		var protocol = $("#gridProtocol").val();
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/complaints/modules/grids&request=convertToProject&id="+id+"&kickoff="+kickoff+"&folder="+folder+"&protocol="+protocol, success: function(data){
			var html = '<div class="text11">Projektordner: <span class="listmember">' + data.fid + '</span>, ' + data.created_user + ', ' + data.created_date + '</div';
			$('#project_created').append(html);
			$("#modalDialogComplaintsGrid").slideUp(function() {		
				initComplaintsContentScrollbar();							
			});
			}
		});
	})

	$(document).on('click', '#modalDialogComplaintsGridClose', function(e) {
		e.preventDefault();
		$("#modalDialogComplaintsGrid").slideUp(function() {		
			initComplaintsContentScrollbar();									
		});
	});


	$(document).mousedown(function(e) {
		var obj = getCurrentModule();
		if(obj.name == 'complaints_grids') {
			var clicked=$(e.target); // get the element clicked
			if(currentComplaintGridClickedNote != 0) {
				if(clicked.is('.note') || clicked.parents().is('.note')) { 
					//return false;
				} else {
					complaints_grids.saveItem(currentComplaintGridClickedNote);
					
				}
			}
		}
	});

});