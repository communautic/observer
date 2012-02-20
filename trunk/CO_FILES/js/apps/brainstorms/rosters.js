/* rosters Object */
function brainstormsRosters(name) {
	this.name = name;


	this.formProcess = function(formData, form, poformOptions) {
		var title = $("#brainstorms input.title").fieldValue();
		if(title == "") {
			$.prompt(ALERT_NO_TITLE, {callback: setTitleFocus});
			return false;
		} else {
			formData[formData.length] = { "name": "title", "value": title };
		}
		
		formData[formData.length] = processListApps('roster_access');
	 }
	 
	 
	 this.formResponse = function(data) {
		 switch(data.action) {
			case "edit":
				$("#brainstorms3 span[rel='"+data.id+"'] .text").html($("#brainstorms .title").val());
					switch(data.access) {
						case "0":
							$("#brainstorms3 span[rel="+data.id+"] .module-access-status").removeClass("module-access-active");
						break;
						case "1":
							$("#brainstorms3 span[rel="+data.id+"] .module-access-status").addClass("module-access-active");
						break;
					}
			break;
		}
	}
	
	
	this.poformOptions = { beforeSubmit: this.formProcess, dataType: 'json', success: this.formResponse };


	this.getDetails = function(moduleidx,liindex,list) {
		var id = $("#brainstorms3 ul:eq("+moduleidx+") .module-click:eq("+liindex+")").attr("rel");
		$('#brainstorms').data({ "third" : id});
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/brainstorms/modules/rosters&request=getDetails&id="+id, success: function(data){
			$("#brainstorms-right").html(data.html);
			
			if($('#checkedOut').length > 0) {
					$("#brainstorms3 ul[rel=rosters] .active-link .icon-checked-out").addClass('icon-checked-out-active');
				} else {
					$("#brainstorms3 ul[rel=rosters] .active-link .icon-checked-out").removeClass('icon-checked-out-active');
				}
			
			if(list == 0) {
				switch (data.access) {
					case "sysadmin": case "admin":
						brainstormsActions(12);
					break;
					case "guest":
						brainstormsActions(5);
					break;
				}
			} else {
				switch (data.access) {
					case "sysadmin": case "admin" :
						if(list == "<li></li>") {
							brainstormsActions(3);
						} else {
							brainstormsActions(12);
						}
					break;
					case "guest":
						if(list == "<li></li>") {
							brainstormsActions();
						} else {
							brainstormsActions(5);
						}
					break;
				}
				
			}
			initBrainstormsContentScrollbar();
			}
		});	
	}


	this.actionNew = function() {
		var module = this;
		var cid = $('#brainstorms input[name="id"]').val()
		module.checkIn(cid);
	
		var id = $('#brainstorms').data('second');
		$.ajax({ type: "GET", url: "/", dataType: 'json', data: 'path=apps/brainstorms/modules/rosters&request=createNew&id=' + id, cache: false, success: function(data){
			$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/brainstorms/modules/rosters&request=getList&id="+id, success: function(list){
				$("#brainstorms3 ul[rel=rosters]").html(list.html);
				$('#brainstorms_rosters_items').html(list.items);
				var liindex = $("#brainstorms3 ul[rel=rosters] .module-click").index($("#brainstorms3 ul[rel=rosters] .module-click[rel='"+data.id+"']"));
				$("#brainstorms3 ul[rel=rosters] .module-click:eq("+liindex+")").addClass('active-link');
				var moduleidx = $("#brainstorms3 ul").index($("#brainstorms3 ul[rel=rosters]"));
				module.getDetails(moduleidx,liindex);
				setTimeout(function() { $('#brainstorms-right .focusTitle').trigger('click'); }, 800);
				}
			});
			}
		});
	}


	this.actionDuplicate = function() {
		var module = this;
		var cid = $('#brainstorms input[name="id"]').val()
		module.checkIn(cid);
		var id = $("#brainstorms").data("third");
		var pid = $("#brainstorms").data("second");
		$.ajax({ type: "GET", url: "/", data: 'path=apps/brainstorms/modules/rosters&request=createDuplicate&id=' + id, cache: false, success: function(mid){
			$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/brainstorms/modules/rosters&request=getList&id="+pid, success: function(data){																																																																				
				$("#brainstorms3 ul[rel=rosters]").html(data.html);
				$('#brainstorms_rosters_items').html(data.items);
				var moduleidx = $("#brainstorms3 ul").index($("#brainstorms3 ul[rel=rosters]"));
				var liindex = $("#brainstorms3 ul[rel=rosters] .module-click").index($("#brainstorms3 ul[rel=rosters] .module-click[rel='"+mid+"']"));
				module.getDetails(moduleidx,liindex);
				$("#brainstorms3 ul[rel=rosters] .module-click:eq("+liindex+")").addClass('active-link');
				}
			});
			}
		});
	}
	
	
	this.actionBin = function() {
		var module = this;
		var cid = $('#brainstorms input[name="id"]').val()
		module.checkIn(cid);
		var txt = ALERT_DELETE;
		var langbuttons = {};
		langbuttons[ALERT_YES] = true;
		langbuttons[ALERT_NO] = false;
		$.prompt(txt,{ 
			buttons:langbuttons,
			callback: function(v,m,f){		
				if(v){
					var id = $("#brainstorms").data("third");
					var pid = $("#brainstorms").data("second");
					$.ajax({ type: "GET", url: "/", data: "path=apps/brainstorms/modules/rosters&request=binRoster&id=" + id, cache: false, success: function(data){
							if(data == "true") {
								$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/brainstorms/modules/rosters&request=getList&id="+pid, success: function(data){
									$("#brainstorms3 ul[rel=rosters]").html(data.html);
									$('#brainstorms_rosters_items').html(data.items);
									if(data.html == "<li></li>") {
										brainstormsActions(3);
										alert('yo');
									} else {
										brainstormsActions(12);
									}
									var moduleidx = $("#brainstorms3 ul").index($("#brainstorms3 ul[rel=rosters]"));
									var liindex = 0;
									module.getDetails(moduleidx,liindex);
									$("#brainstorms3 ul[rel=rosters] .module-click:eq("+liindex+")").addClass('active-link');
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
		$.ajax({ type: "GET", url: "/", async: false, data: 'path=apps/brainstorms/modules/rosters&request=checkinRoster&id='+id, success: function(data){
			if(!data) {
				prompt("something wrong");
			}
			}
		});
	}
	
	
	this.actionRefresh = function() {
		var id = $("#brainstorms").data("third");
		var pid = $("#brainstorms").data("second");
		$("#brainstorms3 ul[rel=rosters] .active-link").trigger("click");
		$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/brainstorms/modules/rosters&request=getList&id="+pid, success: function(data){																																																																				
			$("#brainstorms3 ul[rel=rosters]").html(data.html);
			$('#brainstorms_rosters_items').html(data.items);
			var liindex = $("#brainstorms3 ul[rel=rosters] .module-click").index($("#brainstorms3 ul[rel=rosters] .module-click[rel='"+id+"']"));
			$("#brainstorms3 ul[rel=rosters] .module-click:eq("+liindex+")").addClass('active-link');
			}
		});
	}


	this.actionPrint = function() {
		var id = $("#brainstorms").data("third");
		var url ='/?path=apps/brainstorms/modules/rosters&request=printDetails&id='+id;
		$("#documentloader").attr('src', url);
	}


	this.actionSend = function() {
		var id = $("#brainstorms").data("third");
		$.ajax({ type: "GET", url: "/", data: "path=apps/brainstorms/modules/rosters&request=getSend&id="+id, success: function(html){
			$("#modalDialogForward").html(html).dialog('open');
			}
		});
	}


	this.actionSendtoResponse = function() {
		var id = $("#brainstorms").data("third");
		$.ajax({ type: "GET", url: "/", data: "path=apps/brainstorms/modules/rosters&request=getSendtoDetails&id="+id, success: function(html){
			$("#brainstormsroster_sendto").html(html);
			$("#modalDialogForward").dialog('close');
			}
		});
	}
	
	
	this.sortclick = function (obj,sortcur,sortnew) {
		var module = this;
		var cid = $('#brainstorms input[name="id"]').val()
		module.checkIn(cid);
		
		var fid = $("#brainstorms2 .module-click:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/brainstorms/modules/rosters&request=getList&id="+fid+"&sort="+sortnew, success: function(data){
			$("#brainstorms3 ul[rel=rosters]").html(data.html);
			$('#brainstorms_rosters_items').html(data.items);
			obj.attr("rel",sortnew);
			obj.removeClass("sort"+sortcur).addClass("sort"+sortnew);
			var id = $("#brainstorms3 ul[rel=rosters] .module-click:eq(0)").attr("rel");
			$('#brainstorms').data('third',id);
			if(id == undefined) {
				return false;
			}
			var moduleidx = $("#brainstorms3 ul").index($("#brainstorms3 ul[rel=rosters]"));
			module.getDetails(moduleidx,0);
			$("#brainstorms3 ul[rel=rosters] .module-click:eq(0)").addClass('active-link');
		}
		});
	}


	this.sortdrag = function (order) {
		var fid = $("#brainstorms").data("second");
		$.ajax({ type: "GET", url: "/", data: "path=apps/brainstorms/modules/rosters&request=setOrder&"+order+"&id="+fid, success: function(html){
			$("#brainstorms3 .sort:visible").attr("rel", "3");
			$("#brainstorms3 .sort:visible").removeClass("sort1").removeClass("sort2").addClass("sort3");
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
				$.ajax({ type: "GET", url: "/", data: 'path=apps/brainstorms&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
					$("#modalDialog").html(html);
					//$("#modalDialog").dialog('option', 'height', 50);
					$("#modalDialog").dialog('option', 'position', offset);
					$("#modalDialog").dialog('option', 'title', title);
					$("#modalDialog").dialog('open');
					}
				});
			break;
			case "getRosterStatusDialog":
				$.ajax({ type: "GET", url: "/", data: 'path=apps/brainstorms/modules/rosters&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
					$("#modalDialog").html(html);
					$("#modalDialog").dialog('option', 'position', offset);
					$("#modalDialog").dialog('option', 'title', title);
					$("#modalDialog").dialog('open');
					}
				});
			break;
			case "getDocumentsDialog":
				var id = $("#brainstorms").data("second");
				$.ajax({ type: "GET", url: "/", data: 'path=apps/brainstorms/modules/documents&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql+'&id=' + id, success: function(html){
					$("#modalDialog").html(html);
					$("#modalDialog").dialog('option', 'position', offset);
					$("#modalDialog").dialog('option', 'title', title);
					$("#modalDialog").dialog('open');
					}
				});
			break;
			default:
			$.ajax({ type: "GET", url: "/", data: 'path=apps/brainstorms&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
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
		var html = '<div class="listmember" field="brainstormsroster_status" uid="'+rel+'" style="float: left">' + text + '</div>';
		$("#brainstormsroster_status").html(html);
		$("#modalDialog").dialog("close");
		$("#brainstormsroster_status").next().val("");
		$('#brainstorms .coform').ajaxSubmit(module.poformOptions);
	}


	this.insertStatusDate = function(rel,text) {
		var html = '<div class="listmember" field="brainstormsroster_status" uid="'+rel+'" style="float: left">' + text + '</div>';
		$("#brainstormsroster_status").html(html);
		$("#modalDialog").dialog("close");
		$("#brainstormsroster_status").nextAll('img').trigger('click');
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
			var title = $("#note-title").html();
		}
		if($("#input-text").length > 0) {
			var text = $("#input-text").val();
		} else {
			var text = $("#note-text").html().replace(/(<br\s*\/?>)|(<p><\/p>)/gi, "");
		}
		$.ajax({ type: "POST", url: "/", data: { path: 'apps/brainstorms/modules/rosters', request: 'saveRosterNote', id: id, title: title, text: text }, success: function(data){
		//$.ajax({ type: "POST", url: "/", data: "path=apps/brainstorms/modules/rosters&request=saveRosterNote&id="+id+"&title="+title+"&text="+text, success: function(data){
				
				
				
				$('#item_'+id+' span:eq(0)').html(title);
				if($("#input-note").length > 0) {
					var note_title = $(document.createElement('div')).attr("id", "note-title").attr("class", "note-title").html(title);
					$("#note").find('input').replaceWith(note_title); 
				}
				if($("#input-text").length > 0) {
					//text = text.replace(/\n/g, "<br />");
					//var width = $("#input-text-"+id).width();
					var height = $("#input-text").height();
					var note_text = $(document.createElement('div')).attr("id", "note-text").attr("class", "note-text").css("height",height).html(text);
					$("#note").find('textarea').replaceWith(note_text); 
				}
				$('#note').slideUp();
				currentBrainstormRosterClickedNote = 0;
			}
		});
	}


	this.newItem = function() {
		var mid = $("#brainstorms").data("third");
		var num = parseInt($("#brainstorms-right .task_sort").size());
		$.ajax({ type: "GET", url: "/", data: "path=apps/brainstorms/modules/rosters&request=addTask&mid=" + mid + "&num=" + num + "&sort=" + num, success: function(html){
			$('#brainstormsrostertasks').append(html);
			var idx = parseInt($('.cbx').size() -1);
			var element = $('.cbx:eq('+idx+')');
			$.jNice.CheckAddPO(element);
			$('.rosterouter:eq('+idx+')').slideDown(function() {
				$(this).find(":text:eq(0)").focus();
				if(idx == 6) {
				$('#brainstorms-right .addTaskTable').clone().insertAfter('#phasetasks');
				}
				initBrainstormsContentScrollbar();
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
					$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/brainstorms/modules/rosters&request=binItem&id="+id, success: function(data){
						if(data){
							//$("#note").slideUp(function(){ 
								$("#item_"+id).slideUp(function() { 
										phase = $(this).parent();
										$(this).remove();
										phase.trigger('sortupdate');
									});
							//});
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
					$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/brainstorms/modules/rosters&request=binRosterColumn&id="+id, success: function(text){						
							//$('#brainstormscol_'+id).hide();
							//$('#brainstormscol_'+id).slideUp(function(){ 
							$('#brainstormscol_'+id).animate({width: 0}, function(){ 
								$(this).remove();
								$("#brainstorms-roster").width($("#brainstorms-roster").width()-150);
							});
						}
					});
				} 
			}
		});	
	}


	this.actionHelp = function() {
		var url = "/?path=apps/brainstorms/modules/rosters&request=getHelp";
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/brainstorms/modules/rosters&request=deleteRoster&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#roster_'+id).slideUp();
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/brainstorms/modules/rosters&request=restoreRoster&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#roster_'+id).slideUp();
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/brainstorms/modules/rosters&request=deleteRosterColumn&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#roster_col_'+id).slideUp();
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/brainstorms/modules/rosters&request=restoreRosterColumn&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#roster_col_'+id).slideUp();
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/brainstorms/modules/rosters&request=deleteRosterTask&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#roster_task_'+id).slideUp();
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/brainstorms/modules/rosters&request=restoreRosterTask&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#roster_task_'+id).slideUp();
						}
					}
					});
				} 
			}
		});
	}
	
	
	
	this.initItems = function() {
		$("#brainstorms-roster-outer div.note").livequery( function() {
			$(this)
			.draggable({
				containment:'#brainstorms-right',
				cancel: 'input,textarea'
			})
			.resizable({
				minHeight: 16,
				minWidth: 150,
				alsoResize: '#brainstorms-roster-outer div.note-text, #input-text',
				start: function(e,ui){ 
					$(this).find("textarea").height($(this).height() - 10);
				}
			});
		});
	}


	this.actionRoster = function() {
		$('#modalDialogRoster').slideDown();
	}

}

var brainstorms_rosters = new brainstormsRosters('brainstorms_rosters');


function initBrainstormsConsole() {
	$('#brainstorms-console-notes>div').livequery( function() {
		$(this).draggable({
			cursor: 'move',
			connectToSortable: ".brainstorms-phase",
			helper: "clone",
			appendTo: '#brainstorms-right',
			start: function(e, ui) {
				$(ui.helper).addClass("ui-draggable-helper");
			}
		});
	});
	$('#brainstorms-console').livequery( function() {
		$(this).draggable({handle: 'h3', containment: 'brainstorms-right', cursor: 'move'})
		.resizable({ minHeight: 16, minWidth: 150});
	});
}


function initBrainstormsOuter() {
	$('#brainstorms-roster').livequery( function() {
		$(this).sortable({
			items: '>div.drag',
			handle: 'h3',
			cursor: 'move',
			containment: 'parent',
			update: function(event,ui) {
				var order = $(this).sortable("serialize");
				//console.log('?id='+id+'&'+ order);
				$.ajax({ type: "GET", url: "/", data: "path=apps/brainstorms/modules/rosters&request=saveRosterColumns&"+ order, cache: false, success: function(data){
					}
				});
			}
		})
	});
}


function initBrainstormsPhases() {
	$('#brainstorms-roster .brainstorms-phase').livequery( function() {
		$(this).sortable({
			items: '>div',
			cursor: 'move',
			connectWith: ['.brainstorms-phase'],
			start: function(event,ui) {
				ui.item.removeClass('active');
			},
		})
		$(this).bind('sortupdate', function(event, ui) {
			var col = parseInt($(this).parent().attr("id").replace(/brainstormscol_/, ""));
			var idx = $('#brainstorms-roster .brainstorms-phase').index(this);
			$('#brainstorms-roster .brainstorms-phase:eq('+idx+')>div').each(function(index) {
				var div = $(this);
				if(index == 0 && div.find('span').hasClass('icon-milestone')) {
					div.find('>span').last().remove();
					var attr = parseInt(div.attr("id").replace(/item_/, ""));
					$.ajax({ type: "GET", url: "/", data: "path=apps/brainstorms/modules/rosters&request=toggleMilestone&id="+attr+"&ms=0", success: function(text){
						}
					});
				}
				var attr = div.attr('id');
				if (typeof attr == 'undefined' || attr == false) {
					var id = div.attr('rel');
					var pid = $("#brainstorms").data("third");
					$.ajax({ type: "GET", url: "/", async: false, data: "path=apps/brainstorms/modules/rosters&request=saveRosterNewNote&pid="+pid+"&id=" + id, cache: false, success: function(id){
						div.attr('id','item_' + id);
						div.append('<div class="binItem-Outer"><a class="binItem" rel="'+id+'"><span class="icon-delete"></span></a></div>');
						}
					});
				}
			});
			var order = $('#brainstorms-roster .brainstorms-phase:eq('+idx+')').sortable("serialize");
			$.ajax({ type: "GET", url: "/", data: "path=apps/brainstorms/modules/rosters&request=saveRosterItems&col="+col+"&"+ order, cache: false, success: function(data){
				// calc roster height
				var numitems = 0;
				$('#brainstorms-roster .brainstorms-phase').each(function() {
					var items = $(this).find('>div').size();
					if(items > numitems) {
						numitems = items;
					}
				});
				var colheight = numitems*30+57;
				if (colheight < 357) {
					colheight = 357;
				}
				$('#brainstorms-roster .brainstorms-phase').parent().height(colheight);
				}
			});
    	});
	})
}

var currentBrainstormRosterClickedNote = 0;
var currentBrainstormRosterEditedNote = 0;

$(document).ready(function() {

	initBrainstormsConsole();
	initBrainstormsOuter();
	initBrainstormsPhases();
	brainstorms_rosters.initItems();


	$(document).on('click', '#brainstorms-add-column', function(e) {
		e.preventDefault();
		var pid = $("#brainstorms").data("third");
		var sor = $('#brainstorms-roster>div').size();
		var styles = '';
		if(sor != 0) {
			var styles = ' style="height: ' + $('#brainstorms-roster>div:eq(0)').height() + 'px"';
		}
		$("#brainstorms-roster").width($("#brainstorms-roster").width()+150);
		$.ajax({ type: "GET", url: "/", data: "path=apps/brainstorms/modules/rosters&request=newRosterColumn&id="+pid+"&sort="+sor, cache: false, success: function(num){
			$("#brainstorms-roster").append('<div id="brainstormscol_' + num + '" class="drag" ' + styles +'><h3 class="ui-widget-header">&nbsp;<div class="brainstorms-column-delete" id="brainstorms-col-delete-' + num + '"><span class="icon-delete"></span></div></h3><div class="brainstorms-phase brainstorms-phase-design"></div></div>').sortable("refresh");
			initBrainstormsPhases();
			}
		});
	})

	$(document).on('click', 'div.brainstorms-column-delete', function(e) {
		e.preventDefault();
		var id = $(this).attr("id").replace(/brainstorms-col-delete-/, "");
		brainstorms_rosters.binColumn(id);
	});

	$(document).on('click', 'span.toggleMilestone', function(e) {
		e.preventDefault();
		var ms = 0;
		var id = currentBrainstormRosterClickedNote;
		if($(this).hasClass('icon-milestone-grey')) {
			$(this).removeClass('icon-milestone-grey');
			$('#item_'+id).append('<span class="icon-milestone"></span>');
			var ms = 1;
		} else {
			$(this).addClass('icon-milestone-grey');
			$('#item_'+id+'>span').last().remove();
		}
		$.ajax({ type: "GET", url: "/", data: "path=apps/brainstorms/modules/rosters&request=toggleMilestone&id="+id+"&ms="+ms, success: function(text){
			}
		});
	});


	$(document).on('dblclick', '#brainstorms-roster .brainstorms-phase', function(e) {
		e.preventDefault();
		var clicked=$(e.target);
		if(clicked.parents().is('.brainstorms-phase')) {
			return false;
		} else {
			var phase = $(this);
			var idx = phase.index(this);
			var pid = $("#brainstorms").data("third");
			$.ajax({ type: "GET", url: "/", data: "path=apps/brainstorms/modules/rosters&request=saveRosterNewManualNote&pid="+pid, cache: false, success: function(html){
					phase.append(html);
					phase.trigger('sortupdate');
				}
			});
		}
	});
	$(document).on('mousedown', '#brainstorms-roster .brainstorms-phase', function(){ return false; }) 

	$(document).on('mouseover mouseout', '#brainstorms-roster .brainstorms-phase>div', function(e){ 
		if (e.type == 'mouseover') {
			$(this).find(".binItem-Outer").show();
	  	} else {
			$(this).find(".binItem-Outer").hide();
	  	}
	});	

	$(document).on('dblclick', '#brainstorms-roster .brainstorms-phase>div', function(e) {
		e.preventDefault();
		var phase = false;
		var addtop = 50;
		if($(this).is(':first-child')) {
			phase = true;
			addtop = 60;
		}
		if($('#input-note').is(':visible') || $('#input-text').is(':visible')) {
			brainstorms_rosters.saveItem(currentBrainstormRosterClickedNote);
			return false;
		} else {
			var id = parseInt($(this).attr("id").replace(/item_/, ""));
			currentBrainstormRosterClickedNote = id;
			var note = $(this);
			var left = note.parent().parent().position();
			left = left.left;
			var pos = note.position();
			var top = pos.top+addtop;
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/brainstorms/modules/rosters&request=getRosterNote&id="+id, success: function(data){
				$('#note-title').html(data.title);
				$('#note-text').html(data.text);
				$('#note-info-content').html(data.info);
				if(phase) {
					$('#note-info').css('right','6px');
					$('#ms-toggle').hide();
				} else {
					$('#note-info').css('right','28px');
					$('#ms-toggle').show();
					if(data.ms == "1") {
						$('#note-milestone').removeClass('icon-milestone-grey');	
					} else {
						$('#note-milestone').addClass('icon-milestone-grey');
					}
				}
				$('#note').css('top', top+'px').css('left', left+'px').slideDown();
				}
			});
		}
	})

	$(document).on('dblclick', '#brainstorms-notes-outer div.note-title', function(e) {
		e.preventDefault();
		var html = $(this).html().replace(/(")/gi, "&quot;");
		var input = '<input type="text" id="input-note" name="input-note" value="' + html+ '" />';
		$(this).replaceWith(input);
		$("#input-note").focus();
	});

	$(document).on('dblclick', '#brainstorms-roster-outer div.note-text', function(e) {
		e.preventDefault();
		var html = $(this).html().replace(/(<br\s*\/?>)|(<p><\/p>)/gi, "");
		var width = $(this).width();
		var height = $(this).height();
		var input = '<textarea id="input-text" name="input-text" style="width: '+ width +'px; height: '+ height +'px; border: 0;">' + html+ '</textarea>';
		$("#note-text").replaceWith(input);
		$("#input-text").focus();
	});


	$(document).on('click', 'span.actionBrainstormsRostersConvert', function(e) {
		e.preventDefault();
		var id = $("#brainstorms").data("third");
		var kickofffield = Date.parse($("#brainstorms input[name='kickoff']").val());
		var kickoff = kickofffield.toString("yyyy-MM-dd");
		var folder = $('#rosterprojectsfolder>span').attr('uid');
		if(typeof folder == 'undefined' || folder == false) {
			$.prompt(ALERT_CHOOSE_FOLDER);
			return false;
		}
		var protocol = $("#rosterProtocol").val();
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/brainstorms/modules/rosters&request=convertToProject&id="+id+"&kickoff="+kickoff+"&folder="+folder+"&protocol="+protocol, success: function(data){
			var html = '<div class="text11">Projektordner: <span class="listmember">' + data.fid + '</span>, ' + data.created_user + ', ' + data.created_date + '</div';
			$('#project_created').append(html);
			$("#modalDialogRoster").slideUp(function() {		
				initBrainstormsContentScrollbar();							
			});
			}
		});
	})

	$(document).on('click', '#modalDialogBrainstormsRosterClose', function(e) {
		e.preventDefault();
		$("#modalDialogRoster").slideUp(function() {		
			initBrainstormsContentScrollbar();									
		});
	});
	
	$(document).on('click', 'a.binDeleteColumn', function(e) {
		e.preventDefault();
		var id = $(this).attr("rel");
		brainstorms_rosters.binDeleteColumn(id);
	});
	
	$(document).on('click', 'a.binRestoreColumn', function(e) {
		e.preventDefault();
		var id = $(this).attr("rel");
		brainstorms_rosters.binRestoreColumn(id);
	});


	$(document).mousedown(function(e) {
		var obj = getCurrentModule();
		if(obj.name == 'brainstorms_rosters') {
			var clicked=$(e.target); // get the element clicked
			if(currentBrainstormRosterClickedNote != 0) {
				if(clicked.is('.note') || clicked.parents().is('.note')) { 
					//return false;
				} else {
					brainstorms_rosters.saveItem(currentBrainstormRosterClickedNote);
					
				}
			}
		}
	});

});