function initBrainstormsContentScrollbar() {
	brainstormsInnerLayout.initContent('center');
}

/* brainstorms Object */
function brainstormsApplication(name) {
	this.name = name;
	
	this.formProcess = function(formData, form, poformOptions) {
		var title = $("#brainstorms input.title").fieldValue();
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
				$("#brainstorms2 span[rel='"+data.id+"'] .text").html($("#brainstorms .title").val());
				$("#durationStart").html($("input[name='startdate']").val());
				switch(data.status) {
					case "2":
						$("#brainstorms2 .active-link .module-item-status").addClass("module-item-active");
					break;
					default:
						$("#brainstorms2 .active-link .module-item-status").removeClass("module-item-active");
				}
			break;
			case "reload":
				$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/brainstorms&request=getBrainstormDetails&id="+data.id, success: function(text){
					$("#brainstorms-right").html(text.html);
						initBrainstormsContentScrollbar();
					}
				});
			break;
		}
	}


	this.poformOptions = { beforeSubmit: this.formProcess, dataType: 'json', success: this.formResponse };


	this.actionClose = function() {
		brainstormsLayout.toggle('west');
	}

	
	this.actionNew = function() {
		var module = this;
		var cid = $('#brainstorms input[name="id"]').val()
		module.checkIn(cid);
		var id = $('#brainstorms').data('first');
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: 'path=apps/brainstorms&request=newBrainstorm&id=' + id, cache: false, success: function(data){
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/brainstorms&request=getBrainstormList&id="+id, success: function(list){
				$("#brainstorms2 ul").html(list.html);
				var index = $("#brainstorms2 .module-click").index($("#brainstorms2 .module-click[rel='"+data.id+"']"));
				setModuleActive($("#brainstorms2"),index);
				$('#brainstorms').data({ "second" : data.id });				
				$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/brainstorms&request=getBrainstormDetails&id="+data.id, success: function(text){
					$("#brainstorms-right").html(text.html);
					initBrainstormsContentScrollbar();
					
					$('#brainstorms-right .focusTitle').trigger('click');
					}
				});
				brainstormsActions(0);
				}
			});
			}
		});
	}


	this.actionDuplicate = function() {
		var module = this;
		var cid = $('#brainstorms input[name="id"]').val()
		module.checkIn(cid);
		var pid = $("#brainstorms").data("second");
		var oid = $("#brainstorms").data("first");
		$.ajax({ type: "GET", url: "/", data: 'path=apps/brainstorms&request=createDuplicate&id=' + pid, cache: false, success: function(id){
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/brainstorms&request=getBrainstormList&id="+oid, success: function(data){
				$("#brainstorms2 ul").html(data.html);
					brainstormsActions(0);
					var idx = $("#brainstorms2 .module-click").index($("#brainstorms2 .module-click[rel='"+id+"']"));
					setModuleActive($("#brainstorms2"),idx)
					$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/brainstorms&request=getBrainstormDetails&id="+id, success: function(text){
							$("#brainstorms").data("second",id);
							$("#"+brainstorms.name+"-right").html(text.html);
							initBrainstormsContentScrollbar();
			
				
						}
					});
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
					var id = $("#brainstorms").data("second");
					var fid = $("#brainstorms").data("first");
					$.ajax({ type: "GET", url: "/", data: "path=apps/brainstorms&request=binBrainstorm&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/brainstorms&request=getBrainstormList&id="+fid, success: function(list){
								$("#brainstorms2 ul").html(list.html);
								if(list.html == "<li></li>") {
									brainstormsActions(3);
								} else {
									brainstormsActions(0);
									setModuleActive($("#brainstorms2"),0);
								}
								var id = $("#brainstorms2 .module-click:eq(0)").attr("rel");
								$("#brainstorms").data("second", id);
								$("#brainstorms2 .module-click:eq(0)").addClass('active-link');
								$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/brainstorms&request=getBrainstormDetails&fid="+fid+"&id="+id, success: function(text){
									$("#brainstorms-right").html(text.html);
									initBrainstormsContentScrollbar();
									
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
		$.ajax({ type: "GET", url: "/", async: false, data: 'path=apps/brainstorms&request=checkinBrainstorm&id='+id, success: function(data){
				if(!data) {
					prompt("something wrong");
				}
			}
		});
	}


	this.actionRefresh = function() {
		var oid = $('#brainstorms').data('first');
		var pid = $('#brainstorms').data('second');
		$("#brainstorms2 .active-link").trigger("click");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/brainstorms&request=getBrainstormList&id="+oid, success: function(data){
			$("#brainstorms2 ul").html(data.html);
			var idx = $("#brainstorms2 .module-click").index($("#brainstorms2 .module-click[rel='"+pid+"']"));
			$("#brainstorms2 .module-click:eq("+idx+")").addClass('active-link');
			}
		});
	}


	this.actionPrint = function() {
		var id = $("#brainstorms").data("second");
		var url ='/?path=apps/brainstorms&request=printBrainstormDetails&id='+id;
		location.href = url;
	}


	this.actionSend = function() {
		var id = $("#brainstorms").data("second");
		$.ajax({ type: "GET", url: "/", data: "path=apps/brainstorms&request=getBrainstormSend&id="+id, success: function(html){
			$("#modalDialogForward").html(html).dialog('open');
			}
		});
	}


	this.actionSendtoResponse = function() {
		var id = $("#brainstorms").data("second");
		//$.ajax({ type: "GET", url: "/", data: "path=apps/brainstorms&request=getSendtoDetails&id="+id, success: function(html){
			//$("#brainstorm_sendto").html(html);
			$("#modalDialogForward").dialog('close');
			//}
		//});
	}


	this.sortclick = function (obj,sortcur,sortnew) {
		var module = this;
		var cid = $('#brainstorms input[name="id"]').val()
		module.checkIn(cid);
		var fid = $("#brainstorms .module-click:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/brainstorms&request=getBrainstormList&id="+fid+"&sort="+sortnew, success: function(data){
			$("#brainstorms2 ul").html(data.html);
			obj.attr("rel",sortnew);
			obj.removeClass("sort"+sortcur).addClass("sort"+sortnew);
			var id = $("#brainstorms2 .module-click:eq(0)").attr("rel");
			$('#brainstorms').data('second',id);
			if(id == undefined) {
				return false;
			}
			setModuleActive($("#brainstorms2"),'0');
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/brainstorms&request=getBrainstormDetails&id="+id, success: function(text){
				$("#"+brainstorms.name+"-right").html(text.html);
				initBrainstormsContentScrollbar()
				}
			});
			}
		});
	}


	this.sortdrag = function (order) {
		var fid = $("#brainstorms .module-click:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", data: "path=apps/brainstorms&request=setBrainstormOrder&"+order+"&id="+fid, success: function(html){
			$("#brainstorms2 .sort").attr("rel", "3");
			$("#brainstorms2 .sort").removeClass("sort1").removeClass("sort2").addClass("sort3");
			}
		});
	}
	
	
	this.actionDialog = function(offset,request,field,append,title,sql) {
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


	this.insertStatusDate = function(rel,text) {
		var html = '<div class="listmember" field="brainstormsstatus" uid="'+rel+'" style="float: left">' + text + '</div>';
		$("#brainstormsstatus").html(html);
		$("#modalDialog").dialog("close");
		$("#brainstormsstatus").nextAll('img').trigger('click');
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
		$.ajax({ type: "POST", url: "/", data: { path: 'apps/brainstorms', request: 'saveBrainstormNote', id: id, title: title, text: text }, success: function(data){
		//$.ajax({ type: "POST", url: "/", data: "path=apps/brainstorms&request=saveBrainstormNote&id="+id+"&title="+title+"&text="+text, success: function(data){
			//if(data == "true"){
				if($("#input-note-"+id).length > 0) {
					var note_title = $(document.createElement('div')).attr("id", "note-title-" + id).attr("class", "note-title").html(title);
					$("#note-" + id).find('input').replaceWith(note_title); 
				}
				if($("#input-text-"+id).length > 0) {
					//text = text.replace(/\n/g, "<br />");
					//var width = $("#input-text-"+id).width();
					var height = $("#input-text-"+id).height();
					var note_text = $(document.createElement('div')).attr("id", "note-text-" + id).attr("class", "note-text").css("height",height).html(data);
					$("#note-" + id).find('textarea').replaceWith(note_text); 
				}
			//} 
			}
		});
	}
	
	
	this.toggleItem = function(id) {
		var height = $(this).attr("rel");
		if($(this).parents("div.note").height() == 17) {
			$(this).find('span').addClass("icon-toggle").removeClass("icon-toggle-active");
			$(this).parents("div.note")
				.animate({
					height: height+'px'
					}, function() {
						$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/brainstorms&request=setBrainstormNoteToggle&id="+id+"&t=0"});
				});
		} else {
			$(this).find('span').addClass("icon-toggle-active").removeClass("icon-toggle");
			$(this).parents("div.note")
				.animate({
					height: 17
  					}, function() {
						$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/brainstorms&request=setBrainstormNoteToggle&id="+id+"&t=1"});
				});
		}
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
					$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/brainstorms&request=binBrainstormNote&id="+id, success: function(data){
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
		var url = "/?path=apps/brainstorms&request=getBrainstormsHelp";
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/brainstorms&request=deleteBrainstorm&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#brainstorm_'+id).slideUp();
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/brainstorms&request=restoreBrainstorm&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#brainstorm_'+id).slideUp();
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/brainstorms&request=deleteItem&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#brainstorm_task_'+id).slideUp();
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/brainstorms&request=restoreItem&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#brainstorm_task_'+id).slideUp();
						}
					}
					});
				} 
			}
		});
	}


	this.markNoticeRead = function(pid) {
		$.ajax({ type: "GET", url: "/", data: "path=apps/brainstorms&request=markNoticeRead&pid=" + pid, cache: false});
	}


this.initItems = function() {

$('#brainstorms-outer div.note').each(function(){
		// Finding the biggest z-index value of the notes 
		tmp = $(this).css('z-index');
		if(tmp>zIndex) zIndex = tmp;
	})
	
	
	$("#brainstorms-outer div.note").livequery( function() {
		$(this).each(function(){
		tmp = $(this).css('z-index');
		if(tmp>brainstormszIndex) brainstormszIndex = tmp;
	})
		
		.draggable({
			containment:'#brainstorms-right',
			cancel: 'input,textarea',
			//stack: ".note",
			start: function(e,ui){ ui.helper.css('z-index',++brainstormszIndex); },
			stop: function(e,ui){
				var x = ui.position.left;
				var y = ui.position.top;
				var z = brainstormszIndex;
				var id = $(this).attr("id").replace(/note-/, "");
				$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/brainstorms&request=updateNotePosition&id="+id+"&x="+x+"&y="+y+"&z="+z, success: function(data){
					//$("#brainstorms-top .top-subheadlineTwo").html(data.startdate + ' - <span id="brainstormenddate">' + data.enddate + '</span>');
					}
				});
			}
		})
		.resizable({
			//alsoResize: '#brainstorms-roster-outer div.note-text, #input-text',
			minHeight: 16,
			minWidth: 150,
			start: function(e,ui){ 
				ui.helper.css('z-index',++brainstormszIndex);
				$(this).find("textarea").height($(this).height() - 10);
			},
			resize: function(e,ui){ 
				//$(this).find("textarea").height($(this).height() - 20).width($(this).width());
				$(this).find("div.note-text").height($(this).height() - 35);
			},
			stop: function(e,ui){
				var w = ui.size.width;
				var h = ui.size.height;
				var id = $(this).attr("id").replace(/note-/, "");
				$('#note-toggle-'+id).attr('rel',h);
				$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/brainstorms&request=updateNoteSize&id="+id+"&w="+w+"&h="+h, success: function(data){
					//$("#brainstorms-top .top-subheadlineTwo").html(data.startdate + ' - <span id="brainstormenddate">' + data.enddate + '</span>');
					}
				});
			}
		});
	});
}

}

var brainstorms = new brainstormsApplication('brainstorms');
brainstorms.resetModuleHeights = brainstormsresetModuleHeights;
brainstorms.modules_height = brainstorms_num_modules*module_title_height;
brainstorms.GuestHiddenModules = new Array("access");

// register folder object
function brainstormsFolders(name) {
	this.name = name;
	
	
	this.formProcess = function(formData, form, poformOptions) {
		var title = $("#brainstorms input.title").fieldValue();
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
				$("#brainstorms1 span[rel='"+data.id+"'] .text").html($("#brainstorms .title").val());
			break;
		}
	}


	this.poformOptions = { beforeSubmit: this.formProcess, dataType: 'json', success: this.formResponse };

	
	this.actionNew = function() {
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/brainstorms&request=newFolder", cache: false, success: function(data){
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/brainstorms&request=getFolderList", success: function(list){
				$("#brainstorms1 ul").html(list.html);
				$("#brainstorms1 li").show();
				var index = $("#brainstorms1 .module-click").index($("#brainstorms1 .module-click[rel='"+data.id+"']"));
				setModuleActive($("#brainstorms1"),index);
				$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/brainstorms&request=getFolderDetails&id="+data.id, success: function(text){
					$("#brainstorms").data("first",data.id);
					$("#"+brainstorms.name+"-right").html(text.html);
					initBrainstormsContentScrollbar();
					$('#brainstorms-right .focusTitle').trigger('click');
					}
				});
				brainstormsActions(9);
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
					var id = $("#brainstorms").data("first");
					$.ajax({ type: "GET", url: "/", data: "path=apps/brainstorms&request=binFolder&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/brainstorms&request=getFolderList", success: function(data){
								$("#brainstorms1 ul").html(data.html);
								if(data.html == "<li></li>") {
									brainstormsActions(3);
								} else {
									brainstormsActions(9);
								}
								var id = $("#brainstorms1 .module-click:eq(0)").attr("rel");
								$("#brainstorms").data("first",id);
								$("#brainstorms1 .module-click:eq(0)").addClass('active-link');
								$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/brainstorms&request=getFolderDetails&id="+id, success: function(text){
									$("#"+brainstorms.name+"-right").html(text.html);
									initBrainstormsContentScrollbar();
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
		var id = $("#brainstorms").data("first");
		$("#brainstorms1 .active-link").trigger("click");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/brainstorms&request=getFolderList", success: function(data){
			$("#brainstorms1 ul").html(data.html);
			if(data.html == "<li></li>") {
				brainstormsActions(3);
			} else {
				brainstormsActions(9);
			}
			var idx = $("#brainstorms1 .module-click").index($("#brainstorms1 .module-click[rel='"+id+"']"));
			$("#brainstorms1 .module-click:eq("+idx+")").addClass('active-link');
			}
		});
	}
	

	this.actionPrint = function() {
		var id = $("#brainstorms").data("first");
		var url ='/?path=apps/brainstorms&request=printFolderDetails&id='+id;
		location.href = url;
	}


	this.actionSend = function() {
		var id = $("#brainstorms").data("first");
		$.ajax({ type: "GET", url: "/", data: "path=apps/brainstorms&request=getFolderSend&id="+id, success: function(html){
			$("#modalDialogForward").html(html).dialog('open');
			}
		});
	}


	this.actionSendtoResponse = function() {
			$("#modalDialogForward").dialog('close');
	}



	this.sortclick = function (obj,sortcur,sortnew) {
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/brainstorms&request=getFolderList&sort="+sortnew, success: function(data){
			$("#brainstorms1 ul").html(data.html);
			obj.attr("rel",sortnew);
		  	obj.removeClass("sort"+sortcur).addClass("sort"+sortnew);
			var id = $("#brainstorms1 .module-click:eq(0)").attr("rel");
			$('#brainstorms').data('first',id);
			$("#brainstorms1 .module-click:eq(0)").addClass('active-link');
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/brainstorms&request=getFolderDetails&id="+id, success: function(text){
				$("#brainstorms-right").html(text.html);
				initBrainstormsContentScrollbar()
				}
			});
			}
		});
	}


	this.sortdrag = function (order) {
		$.ajax({ type: "GET", url: "/", data: "path=apps/brainstorms&request=setFolderOrder&"+order, success: function(html){
			$("#brainstorms1 .sort").attr("rel", "3");
			$("#brainstorms1 .sort").removeClass("sort1").removeClass("sort2").addClass("sort3");
			}
		});
	}
	
	
	this.actionDialog = function(offset,request,field,append,title,sql) {
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
	

	this.actionHelp = function() {
		var url = "/?path=apps/brainstorms&request=getBrainstormsFoldersHelp";
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/brainstorms&request=deleteFolder&id=" + id, cache: false, success: function(data){
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/brainstorms&request=restoreFolder&id=" + id, cache: false, success: function(data){
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

var brainstorms_folder = new brainstormsFolders('brainstorms_folder');


function brainstormsActions(status) {
	/*	0= new	1= print	2= send		3= duplicate	4= roster		5=refresh 	6 = delete*/
	switch(status) {
		//case 0: actions = ['0','1','2','3','5','6']; break;
		case 0: actions = ['0','1','2','3','5','6','7']; break;
		case 1: actions = ['0','5','6','7']; break;
		case 3: 	actions = ['0','5','6']; break;   					// just new
		//case 4: 	actions = ['0','1','2','4','5']; break;   		// new, print, send, handbook, refresh
		case 4: 	actions = ['0','1','2','4','5','6']; break;
		//case 5: 	actions = ['1','2','5']; break;   			// print, send, refresh
		case 5: 	actions = ['1','2','5','6']; break;
		case 6: 	actions = ['5','6']; break;   			// handbook refresh
		//case 7: 	actions = ['0','1','2','5']; break;   			// new, print, send, refresh
		case 7: 	actions = ['0','1','2','5','6']; break;
		//case 8: 	actions = ['1','2','4','5']; break;   			// print, send, handbook, refresh
		case 8: 	actions = ['1','2','4','5','6']; break;
		//case 9: actions = ['0','1','2','3','4','5','6']; break;
		case 9: actions = ['0','1','2','5','6','7']; break;
		case 10: actions = ['0','1','2','3','4','5','6','7']; break;
		default: 	actions = ['5','6'];  								// none
	}
	$('#brainstormsActions > li span').each( function(index) {
		if(index in oc(actions)) {
			$(this).removeClass('noactive');
		} else {
			$(this).addClass('noactive');
		}
	})
}










function brainstormsloadModuleStart() {
	var h = $("#brainstorms .ui-layout-west").height();
	$("#brainstorms .ui-layout-west .radius-helper").height(h);
	$("#brainstorms .secondLevelOuter").css('top',h-27);	
	$("#brainstorms .thirdLevelOuter").css('top',150);
	$('#brainstorms1').data('status','open');
	$('#brainstorms2').data('status','closed');
	$('#brainstorms3').data('status','closed');
	$("#brainstorms1").height(h-98);	
	$("#brainstorms1 .module-inner").height(h-98);
	$("#brainstorms1 .module-actions").show();
	$("#brainstorms2 .module-actions").hide();
	$("#brainstorms2 li").show();
	$("#brainstorms2").height(h-125-brainstorms_num_modules*27).removeClass("module-active");
	$("#brainstorms2 .module-inner").height(h-125-brainstorms_num_modules*27);
	$("#brainstorms3 .module-actions").hide();
	$("#brainstorms3").height(h-150);
	$("#brainstorms3 .brainstorms3-content").height(h-(brainstorms.modules_height+152));
	$("#brainstorms3 div.thirdLevel").height(h-(brainstorms.modules_height+150-27));
	$("#brainstorms-current").val("folder");
	$("#brainstorms3 div.thirdLevel").each(function(i) { 
		var position = $(this).position();
		var t = position.top+h-150;
		$(this).animate({top: t})
	})
	$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/brainstorms&request=getFolderList", success: function(data){
		$("#brainstorms1 ul").html(data.html);
		$("#brainstormsActions .actionNew").attr("title",data.title);

		if(data.access == "guest") {
			brainstormsActions();
		} else {
			if(data.html == "<li></li>") {
				brainstormsActions(3);
			} else {
				brainstormsActions(9);
			}
		}
		$("#brainstorms1 li").show();
		$("#brainstorms1 .sort").attr("rel", data.sort).addClass("sort"+data.sort);
		brainstormsInnerLayout.initContent('center');
		var id = $("#brainstorms1 .module-click:eq(0)").attr("rel");
		$('#brainstorms').data({ "current" : "folders" , "first" : id , "second" : 0 , "third" : 0});
		$("#brainstorms1 .module-click:eq(0)").addClass('active-link');
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/brainstorms&request=getFolderDetails&id="+id, success: function(text){
			$("#"+brainstorms.name+"-right").html(text.html);
			brainstormsInnerLayout.initContent('center');
			}
		});
	}	
	});
}


function brainstormsresetModuleHeights() {
	if(getCurrentApp() != 'brainstorms') {
		$('#brainstorms').css('top',2*$('#container-inner').height());
	}
	var h = $("#brainstorms div.ui-layout-west").height();
	$("#brainstorms .ui-layout-west .radius-helper").height(h);
	$("#brainstorms1").height(h-98);
	$("#brainstorms1 .module-inner").height(h-98);
	$("#brainstorms2").height(h-125-brainstorms_num_modules*27);
	$("#brainstorms2 .module-inner").height(h-125-brainstorms_num_modules*27);
	$("#brainstorms3").height(h-150);
	$("#brainstorms3 .brainstorms3-content").height(h-(brainstorms.modules_height+152));
	$("#brainstorms3 div.thirdLevel").height(h-(brainstorms.modules_height+150-27));
	if($('#brainstorms1').data('status') == 'open') {
		$("#brainstorms2-outer").css('top',h-27);
		$("#brainstorms3 div.thirdLevel").each(function(i) { 
			var t = h-150+i*27;
			$(this).animate({top: t})
		})
	}
	if($('#brainstorms2').data('status') == 'open') {	
		var curmods = $("#brainstorms3 div.thirdLevel:not(.deactivated)").size();
		$("#brainstorms2").height(h-125-curmods*27).removeClass("module-active");
		$("#brainstorms2 .module-inner").height(h-125-curmods*27);
		$("#brainstorms3 .brainstorms3-content").height(h-(curmods*27+152));
		$("#brainstorms3 div.thirdLevel").height(h-(curmods*27+150-27));
		$("#brainstorms3 div.thirdLevel:not(.deactivated)").each(function(i) { 
			var t = h-150-curmods*27+i*27;
			$(this).animate({top: t})
		})
	}
	if($('#brainstorms3').data('status') == 'open') {
		var obj = getCurrentModule();
		var idx = $('#brainstorms3 .thirdLevel:not(.deactivated)').index($('#brainstorms3 .thirdLevel:not(.deactivated)[id='+obj.name+']'));	
		var curmods = $("#brainstorms3 div.thirdLevel:not(.deactivated)").size();
		$("#brainstorms2").height(h-125-curmods*27).removeClass("module-active");
		$("#brainstorms2 .module-inner").height(h-125-curmods*27);
		$("#brainstorms3 .brainstorms3-content").height(h-(curmods*27+152));
		$("#brainstorms3 div.thirdLevel").height(h-(curmods*27+150-27));
		$("#brainstorms3 div.thirdLevel:not(.deactivated)").each(function(i) { 
		if(i > idx) {
			var pos = $(this).position();
				var t = h-150-curmods*27+i*27;
				$(this).animate({top: t})
			}
		})
	}
}

function Brainstorms2ModulesDisplay(access) {
	var h = $("#brainstorms div.ui-layout-west").height();
	if(access == "guest" || access == "guestadmin") {
		var modLen = brainstorms.GuestHiddenModules.length;
		var p_num_modules = brainstorms_num_modules-modLen;
		var p_modules_height = p_num_modules*module_title_height;
		$("#brainstorms3 .brainstorms3-content").height(h-(p_modules_height+152));
		$("#brainstorms3 div.thirdLevel").height(h-(p_modules_height+150-27));
		$("#brainstorms2").height(h-125-p_num_modules*27).removeClass("module-active");
		$("#brainstorms2 .module-inner").height(h-125-p_num_modules*27);
		var a = 0;
		var t = $("#brainstorms2").height();
		$("#brainstorms2").animate({height: t+p_modules_height})
		$("#brainstorms2-outer").animate({top: 96}, function() {
			$("#brainstorms3 div.thirdLevel").each(function(i) { 
				var rel = $(this).find('h3').attr('rel');
				if(brainstorms.GuestHiddenModules.indexOf(rel) >= 0 ) {
					$(this).addClass('deactivated').animate({top: 9999})	
				} else {
					var t = $("#brainstorms3").height()-p_num_modules*27+a*27;
						$(this).animate({top: t})			
					a = a+1;
				}
			})
			$("#brainstorms-top .top-headline").html($("#brainstorms1 .deactivated").find(".text").html());
			$("#brainstorms2").animate({height: t})
		})
	} else {
		$("#brainstorms3 .brainstorms3-content").height(h-(brainstorms.modules_height+152));
		$("#brainstorms3 div.thirdLevel").height(h-(brainstorms.modules_height+150-27));
		$("#brainstorms2 .module-inner").height(h-125-brainstorms_num_modules*27);
		var t = h-125-brainstorms.modules_height;
		$("#brainstorms2").animate({height: t+brainstorms.modules_height})
		$("#brainstorms2-outer").animate({top: 96}, function() {
			$("#brainstorms3 div.thirdLevel").each(function(i) { 
				var t = $("#brainstorms3").height()-brainstorms.modules_height+i*27;
				$(this).animate({top: t})			
			})
			$("#brainstorms-top .top-headline").html($("#brainstorms1 .deactivated").find(".text").html());
			$("#brainstorms2").animate({height: t})
		})
	}
}


function BrainstormsModulesDisplay(access) {
	var h = $("#brainstorms div.ui-layout-west").height();
	if(access == "guest" || access == "guestadmin") {
		var modLen = brainstorms.GuestHiddenModules.length;
		var p_num_modules = brainstorms_num_modules-modLen;
		p_modules_height = p_num_modules*module_title_height;
		$("#brainstorms3 .brainstorms3-content").height(h-(p_modules_height+152));
		$("#brainstorms3 div.thirdLevel").height(h-(p_modules_height+150-27));
		$("#brainstorms2").height(h-125-p_num_modules*27).removeClass("module-active");
		$("#brainstorms2 .module-inner").height(h-125-p_num_modules*27);
		var a = 0;
		
		var t = $("#brainstorms2").height();
		$("#brainstorms2").animate({height: t+brainstorms_num_modules*27}, function() {
			$(this).animate({height: t});
		})
		
		$("#brainstorms3 div.thirdLevel").each(function(i) { 
			var rel = $(this).find('h3').attr('rel');
			if(brainstorms.GuestHiddenModules.indexOf(rel) >= 0 ) {
				$(this).addClass('deactivated').animate({top: 9999})	
			} else {
				var t = $("#brainstorms3").height()-p_num_modules*27+a*27;
				var position = $(this).position();
				var d = position.top+brainstorms_num_modules*27;
				$(this).animate({top: d}, function() {
					$(this).animate({top: t})			
				})
				a = a+1;
			}
		})
	} else {
		$("#brainstorms3 .brainstorms3-content").height(h-(brainstorms.modules_height+152));
		$("#brainstorms3 div.thirdLevel").height(h-(brainstorms.modules_height+150-27));
		$("#brainstorms2 .module-inner").height(h-125-brainstorms_num_modules*27);
		var curmods = $("#brainstorms3 div.thirdLevel:not(.deactivated)").size();
		var t = h-125-brainstorms_num_modules*27;
		$("#brainstorms2").animate({height: t+brainstorms_num_modules*27}, function() {
			$(this).animate({height: t});
		})
		$("#brainstorms3 div.thirdLevel").each(function(i) { 
			$(this).removeClass('deactivated');
			var t = $("#brainstorms3").height()-brainstorms_num_modules*27+i*27;
				var position = $(this).position();
				var d = h-150+i*27;
				$(this).animate({top: d}, function() {
					$(this).animate({top: t})			
				})
		})
	}
}


function BrainstormsExternalLoad(what,f,p,ph) { // from Desktop
	if(what == 'brainstorms') {
		$('#brainstorms').data({ "first" : f});
		var index = $('#brainstorms1 .module-click').index($('#brainstorms1 .module-click[rel='+f+']'));
		$.ajax({ type: "GET", url: "/", dataType:  'json', async: false, data: "path=apps/brainstorms&request=getBrainstormList&id="+f, success: function(data){
			$("#brainstorms2 ul").html(data.html);
			setModuleDeactive($("#brainstorms1"),index);
			$('#brainstorms1').find('li:eq('+index+')').show();
			$("#brainstorms-top .top-headline").html($("#brainstorms1 .deactivated").find(".text").html());
			}
		})
		$('#brainstorms').data({ "second" : p});
		var index = $("#brainstorms2 .module-click").index($("#brainstorms2 .module-click[rel='"+p+"']"));
		setModuleActive($("#brainstorms2"),index);
		$("#brainstorms2-outer").css('top', 96);
		$('#brainstorms3 h3').removeClass("module-bg-active");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/brainstorms&request=getBrainstormDetails&fid="+f+"&id="+p, success: function(text){
			$("#brainstorms-current").val(what);
			$('#brainstorms').data({ "current" : what});
			$('#brainstorms').data({ "second" : p});
			$('#brainstorms1').data('status','closed');
			$('#brainstorms2').data('status','open');
			$('#brainstorms3').data('status','closed');
			$("#brainstorms-right").html(text.html);		
			if($('#checkedOut').length > 0) {
				$("#brainstorms2 .active-link .icon-checked-out").addClass('icon-checked-out-active');
			} else {
				$("#brainstorms2 .active-link .icon-checked-out").removeClass('icon-checked-out-active');
			}
			switch (text.access) {
				case "sysadmin":
					brainstormsActions(0);
				break;
				case "admin":
					brainstormsActions(0);
				break;
				case "guestadmin":
					brainstormsActions(7);
				break;
				case "guest":
					brainstormsActions(5);
				break;
			}
			initBrainstormsContentScrollbar();
			if(text.access != "sysadmin" || text.access != "admin") { 
				var h = $("#brainstorms div.ui-layout-west").height();
				var modLen = brainstorms.GuestHiddenModules.length;
				var p_num_modules = brainstorms_num_modules-modLen;
				p_modules_height = p_num_modules*module_title_height;
				$("#brainstorms3 .brainstorms3-content").height(h-(p_modules_height+152));
				$("#brainstorms3 div.thirdLevel").height(h-(p_modules_height+150-27));
				$("#brainstorms2").height(h-125-p_num_modules*27).removeClass("module-active");
				$("#brainstorms2 .module-inner").height(h-125-p_num_modules*27);
				var a = 0;
				$("#brainstorms3 div.thirdLevel").each(function(i) { 
					var rel = $(this).find('h3').attr('rel');
					if(brainstorms.GuestHiddenModules.indexOf(rel) >= 0 ) {
						$(this).addClass('deactivated').animate({top: 9999})	
					} else {
						var t = $("#brainstorms3").height()-p_num_modules*27+a*27;
						$(this).animate({top: t})			
						a = a+1;
					}
				})
				$('span.app_brainstorms').trigger('click');
			} else {
				$("#brainstorms3 div.thirdLevel:not(.deactivated)").each(function(i) { 
					var t = h-150-brainstorms_num_modules*27+i*27;
					$(this).animate({top: t})
				})
				$('span.app_brainstorms').trigger('click');
			}
			}
		});
	}
	
	if(what == 'phases') {
		$('#brainstorms').data({ "first" : f});
		var index = $('#brainstorms1 .module-click').index($('#brainstorms1 .module-click[rel='+f+']'));
		$.ajax({ type: "GET", url: "/", dataType:  'json', async: false, data: "path=apps/brainstorms&request=getBrainstormList&id="+f, success: function(data){
			$("#brainstorms2 ul").html(data.html);
				setModuleDeactive($("#brainstorms1"),index);
				$('#brainstorms1').find('li:eq('+index+')').show();
				$("#brainstorms-top .top-headline").html($("#brainstorms1 .deactivated").find(".text").html());
			}
		})
		$('#brainstorms').data({ "second" : p});
			
		var index = $("#brainstorms2 .module-click").index($("#brainstorms2 .module-click[rel='"+p+"']"));
		setModuleDeactive($("#brainstorms2"),index);
		$("#brainstorms2-outer").css('top', 96);
		$('#brainstorms3 h3').removeClass("module-bg-active");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/brainstorms/modules/"+what+"&request=getList&id="+p, success: function(data){
			$("#brainstorms-current").val(what);
			$('#brainstorms').data({ "current" : what});
			$('#brainstorms').data({ "third" : ph});
			$('#brainstorms1').data('status','closed');
			$('#brainstorms2').data('status','closed');
			$('#brainstorms3').data('status','open');
			$('#brainstorms3 ul[rel='+what+']').html(data.html);
			$("#brainstormsActions .actionNew").attr("title",data.title);
			switch (data.perm) {
				case "sysadmin": case "admin" :
					if(data.html == "<li></li>") {
						brainstormsActions(3);
					} else {
						brainstormsActions(0);
					}
				break;
				case "guest":
					if(data.html == "<li></li>") {
						brainstormsActions();
					} else {
						brainstormsActions(5);
					}
				break;
			}
			$("#brainstorms3 div.thirdLevel").each(function(i) { 
				if(i == 0) {
				var t = 0;
				} else {
					var n = $(this).height();
					var t = n+i*module_title_height-27;
				}
				$(this).animate({top: t})
			})		
			$('#brainstorms3 ul[rel='+what+'] .module-click[rel='+ph+']').addClass('active-link');
			var idx = $('#brainstorms3 ul[rel='+what+'] .module-click').index($('#brainstorms3 ul[rel='+what+'] .module-click[rel='+ph+']'));
			brainstorms_phases.getDetails(0,idx,data.html);
			$("#brainstorms3 .module-actions:eq(0)").show();
			$("#brainstorms3 .sort:eq(0)").attr("rel", data.sort).addClass("sort"+data.sort);
			$("#brainstorms-top .top-subheadline").html(', ' + $("#brainstorms2 .module-click:visible").find(".text").html());
			/*$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/brainstorms&request=getDates&id="+p, success: function(data){
				$("#brainstorms-top .top-subheadlineTwo").html(data.startdate + ' - <span id="projectenddate">' + data.enddate + '</span>');
				$('span.app_brainstorms').trigger('click');
				}
			});*/
			}
		});
	}
}


var brainstormsLayout, brainstormsInnerLayout;
var brainstormszIndex = 0; // zindex notes for mindmap
var currentBrainstormEditedNote = 0;

function setcEN(id) {
	currentBrainstormEditedNote = id;
}

$(document).ready(function() {
						   
	if($('#brainstorms').length > 0) {
		brainstormsLayout = $('#brainstorms').layout({
				west__onresize:				function() { brainstormsresetModuleHeights() }
			,	resizeWhileDragging:		true
			,	spacing_open:				0
			,	spacing_closed:				0
			,	closable: 					false
			,	resizable: 					false
			,	slidable:					false
			, 	west__size:					325
			,	west__closable: 			true
			,	center__onresize: "brainstormsInnerLayout.resizeAll"
			
		});
		
		brainstormsInnerLayout = $('#brainstorms div.ui-layout-center').layout({
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
		
		brainstormsloadModuleStart();
	}


	$("#brainstorms1-outer > h3").on('click', function(e, passed_id) {
		e.preventDefault();
		navThreeTitleFirst('brainstorms',$(this),passed_id)
	});


	$("#brainstorms2-outer > h3").on('click', function(e, passed_id) {
		e.preventDefault();
		navThreeTitleSecond('brainstorms',$(this),passed_id)
	});


	$(document).on('click', '#brainstorms1 .module-click',function(e) {
		e.preventDefault();
		navItemFirst('brainstorms',$(this))
	});


	$(document).on('click', '#brainstorms2 .module-click',function(e) {
		e.preventDefault();
		navItemSecond('brainstorms',$(this))
	});


	$(document).on('click', '#brainstorms3 .module-click',function(e) {
		e.preventDefault();
		navItemThird('brainstorms',$(this))
	});


	$("#brainstorms3 h3").on('click', function(e, passed_id) {
		e.preventDefault();
		var obj = getCurrentModule();
		if(confirmNavigation()) {
			formChanged = false;
			$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		}
		var cid = $('#brainstorms input[name="id"]').val()
		obj.checkIn(cid);
		
		var moduleidx = $("#brainstorms3 h3").index(this);
		var module = $(this).attr("rel");
		var h3click = $(this);
		// module open and  active 
		if($(this).hasClass("module-bg-active")) {
			$("#brainstorms2-outer > h3").trigger("click");
		} else {
			// module 3 allready activated
			if($('#brainstorms3').data('status') == 'open') {
				var id = $("#brainstorms").data('second');				
				var mod = getCurrentModule();
				var todeactivate = mod.name.replace(/brainstorms_/, "");				
				$('#brainstorms3 h3[rel='+todeactivate+']').removeClass("module-bg-active");
				$("#brainstorms3 .module-actions:visible").hide();
				var curmoduleidx = $("#brainstorms3 h3").index($('#brainstorms3 h3[rel='+todeactivate+']'));
				var t = moduleidx*module_title_height;
				h3click.addClass("module-bg-active")
				$("#brainstorms3 div.thirdLevel:not(.deactivated)").each(function(i) { 
					if(i <= moduleidx) {
						var mx = i*module_title_height;
						$(this).animate({top: mx})
					} else {
						if(i <= curmoduleidx) {
							var position = $(this).position();
							var h = position.top+$(this).height()-27;
							$(this).animate({top: h})
						} else {
							var position = $(this).position();
							var h = position.top;
							$(this).animate({top: h})
						}
					}
				})

				setTimeout(function() {
					$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/brainstorms/modules/"+module+"&request=getList&id="+id, success: function(data){
						$("#brainstorms3 ul:eq("+moduleidx+")").html(data.html);
						$("#brainstormsActions .actionNew").attr("title",data.title);	
						switch (data.perm) {
							case "sysadmin": case "admin" :
								if(data.html == "<li></li>") {
									brainstormsActions(3);
								} else {
									brainstormsActions(0);
								}
							break;
							case "guest":
								if(data.html == "<li></li>") {
									brainstormsActions();
								} else {
									brainstormsActions(5);
								}
							break;
						}
						if(passed_id === undefined) {
							var idx = 0;
						} else {
							var idx = $("#brainstorms3 ul:eq("+moduleidx+") .module-click").index($("#brainstorms3 ul:eq("+moduleidx+") .module-click[rel='"+passed_id+"']"));
						}
						$("#brainstorms3 ul:eq("+moduleidx+") .module-click:eq("+idx+")").addClass('active-link');
						var obj = getCurrentModule();
						obj.getDetails(moduleidx,idx,data.html);
						$(this).prev("h3").removeClass("module-bg-active");	
						$("#brainstorms3 .module-actions:eq("+moduleidx+")").show();
						$("#brainstorms3 .sort:eq("+moduleidx+")").attr("rel", data.sort).addClass("sort"+data.sort);
						}
					});			 
				}, 400);
			} else {
				// load and slide up module 3
				var id = $("#brainstorms").data('second');
				$('#brainstorms2').data('status','closed');
				$('#brainstorms3').data('status','open');
				if(id == undefined) {
					return false;
				}
				var index = $("#brainstorms2 .module-click").index($("#brainstorms2 .module-click[rel='"+id+"']"));
				$("#brainstorms3 .module-actions:visible").hide();
				h3click.addClass("module-bg-active");
				setModuleDeactive($("#brainstorms2"),index);
				$("#brainstorms3 div.thirdLevel").each(function(i) { 
					if(i <= moduleidx) {
						var position = $(this).position();
							var h = i*27;
							$(this).animate({top: h})
						}
					if(i == brainstorms_num_modules-1) {
						setTimeout(function() {
							$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/brainstorms/modules/"+module+"&request=getList&id="+id, success: function(data){
								$("#brainstorms3 ul:eq("+moduleidx+")").html(data.html);
								$("#brainstormsActions .actionNew").attr("title",data.title);	
								switch (data.perm) {
									case "sysadmin": case "admin" :
										if(data.html == "<li></li>") {
											brainstormsActions(3);
										} else {
											brainstormsActions(0);
										}
									break;
									case "guest":
										if(data.html == "<li></li>") {
											brainstormsActions();
										} else {
											brainstormsActions(5);
										}
									break;
								}
								if(passed_id === undefined) {
									var idx = 0;
								} else {
									var idx = $("#brainstorms3 ul:eq("+moduleidx+") .module-click").index($("#brainstorms3 ul:eq("+moduleidx+") .module-click[rel='"+passed_id+"']"));
								}
								$("#brainstorms3 ul:eq("+moduleidx+") .module-click:eq("+idx+")").addClass('active-link');
								$("#brainstorms-top .top-subheadline").html(', ' + $("#brainstorms2 .deactivated").find(".text").html());
								var obj = getCurrentModule();
								obj.getDetails(moduleidx,idx,data.html);
								$("#brainstorms3 .sort:eq("+moduleidx+")").attr("rel", data.sort).addClass("sort"+data.sort);
								$("#brainstorms3 .module-actions:eq("+moduleidx+")").show();
								}
							});
						}, 400);
					}
				})
			}
			$("#brainstorms-current").val(module);
			$('#brainstorms').data({ "current" : module});
		}
	});


	$('a.insertBrainstormFolderfromDialog').livequery('click',function(e) {
		e.preventDefault();
		var field = $(this).attr("field");
		var gid = $(this).attr("gid");
		var title = $(this).attr("title");
		var html = '<a class="listmember" uid="' + gid + '" field="'+field+'">' + title + '</a>';
		$("#"+field).html(html);
		$("#modalDialog").dialog('close');
		var obj = getCurrentModule();
		$('#brainstorms .coform').ajaxSubmit(obj.poformOptions);
	});
	
	
// INTERLINKS FROM Content
	
	// load a brainstorm
	$(".loadBrainstorm").live('click', function() {
		
		var obj = getCurrentModule();
		if(confirmNavigation()) {
			formChanged = false;
			$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		}
		
		var id = $(this).attr("rel");
		$("#brainstorms2-outer > h3").trigger('click', [id]);
		return false;
	});

	
	// load a phase
	/*$(".loadBrainstormsPhase").live('click', function() {
		
		var obj = getCurrentModule();
		if(confirmNavigation()) {
			formChanged = false;
			$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		}
		var cid = $('#brainstorms input[name="id"]').val()
		obj.checkIn(cid);
		
		var id = $(this).attr("rel");
		$("#brainstorms3 h3[rel='phases']").trigger('click', [id]);
		return false;
	});
	
	$(".loadBrainstormsPhase2").live('click', function() {
		var id = $(this).attr("rel");
		$("#brainstorms3 h3[rel='phases']").trigger('click', [id]);
		return false;
	});*/


	$('span.actionRoster').click(function(){
		if($(this).hasClass("noactive")) {
			return false;
		}
		brainstorms_rosters.actionRoster();
		return false;
	});


	var tmp;
	brainstorms.initItems();


	$("div.brainstormsNoteToggle").live("click", function(e) {
		e.preventDefault();
		var id = $(this).attr("id").replace(/note-toggle-/, "");
		var height = $(this).attr("rel");
		if($(this).parents("div.note").height() == 17) {
			$(this).find('span').addClass("icon-toggle").removeClass("icon-toggle-active");
			$(this).parents("div.note")
				.animate({ height: height+'px' }, function() {
						$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/brainstorms&request=setBrainstormNoteToggle&id="+id+"&t=0"});
				});
		} else {
			$(this).find('span').addClass("icon-toggle-active").removeClass("icon-toggle");
			$(this).parents("div.note")
				.animate({ height: 17 }, function() {
						$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/brainstorms&request=setBrainstormNoteToggle&id="+id+"&t=1"});
				});
		}
	});


	$("span.brainstormsAddNote").live("click", function(e) {
		e.preventDefault();
		//var id = $("#brainstorms2 .active-link").attr("rel");
		//var oid = $("#brainstorms1 .module-click:visible").attr("rel");
		var oid = $('#brainstorms').data('first');
		var id = $('#brainstorms').data('second');	
		var z = ++brainstormszIndex;
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/brainstorms&request=newBrainstormNote&id="+id+"&z="+z, success: function(data){
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/brainstorms&request=getBrainstormDetails&fid="+oid+"&id="+id, success: function(text){
				$("#brainstorms-right").html(text.html);
				initBrainstormsContentScrollbar();
				}
			});
			}
		});
	});


	$("#brainstorms-outer div.note-title").live("dblclick", function(e) {
		var id = parseInt($(this).attr("id").replace(/note-title-/, ""));
		currentBrainstormEditedNote = id;
		e.preventDefault();
		var html = $(this).html().replace(/(")/gi, "&quot;");
		var input = '<input type="text" id="input-note-' + id + '" name="input-note-' + id + '" value="' + html+ '" />';
		$("#note-title-" + id).replaceWith(input);
		$("#input-note-" + id).focus();
	});


	$("#brainstorms-outer div.note-text").live("dblclick", function(e) {
		var id = parseInt($(this).attr("id").replace(/note-text-/, ""));
		currentBrainstormEditedNote = id;
		e.preventDefault();
		var html = $(this).html().replace(/(<br\s*\/?>)|(<p><\/p>)/gi, "");
		var width = $(this).width();
		var height = $(this).height();
		var input = '<textarea id="input-text-' + id + '" name="input-text-' + id + '" style="width: '+ width +'px; height: '+ height +'px; border: 0;">' + html+ '</textarea>';
		$("#note-text-" + id).replaceWith(input);
		$("#input-text-" + id).focus();
	});


	$(document).mousedown(function(e) {
		var obj = getCurrentModule();
		if(obj.name == 'brainstorms') {
			var clicked=$(e.target); // get the element clicked
			if(currentBrainstormEditedNote != 0) {
				if(clicked.is('.note') || clicked.parents().is('.note')) { 
					var id = /[0-9]+/.exec(e.target.id);
					if(id != currentBrainstormEditedNote) {
						brainstorms.saveItem(currentBrainstormEditedNote);
						currentBrainstormEditedNote = 0;
					}
				} else {
					brainstorms.saveItem(currentBrainstormEditedNote);
					currentBrainstormEditedNote = 0;
				}
			}
		}
	});

});