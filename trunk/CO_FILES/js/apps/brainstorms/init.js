function initBrainstormsContentScrollbar() {
	brainstormsInnerLayout.initContent('center');
}

/* brainstorms Object */
function brainstormsApplication(name) {
	this.name = name;
	
	this.init = function() {
		this.$app = $('#brainstorms');
		this.$appContent = $('#brainstorms-right');
		this.$first = $('#brainstorms1');
		this.$second = $('#brainstorms2');
		this.$third = $('#brainstorms3');
		this.$thirdDiv = $('#brainstorms3 div.thirdLevel');
		this.$layoutWest = $('#brainstorms div.ui-layout-west');
	}
	
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
				/*$("#durationStart").html($("input[name='startdate']").val());
				switch(data.status) {
					case "2":
						$("#brainstorms2 span[rel='"+data.id+"'] .module-item-status").addClass("module-item-active");
					break;
					default:
						$("#brainstorms2 span[rel='"+data.id+"'] .module-item-status").removeClass("module-item-active");
				}*/
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


	this.getNavModulesNumItems = function(id) {
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: 'path=apps/brainstorms&request=getNavModulesNumItems&id=' + id, success: function(data){
				$.each( data, function(k, v){
   					$('#'+k).html(v);
 				});
			}
		});
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
		$("#documentloader").attr('src', url);
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
		if($(this).parents("div.note").height() == 20) {
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
					height: 20
  					}, function() {
						$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/brainstorms&request=setBrainstormNoteToggle&id="+id+"&t=1"});
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
			callback: function(v,m,f){		
				if(v){
					$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/brainstorms&request=deleteBrainstormNote&id="+id, success: function(data){
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


	this.datepickerOnClose = function(dp) {
		var obj = getCurrentModule();
		if(obj.name != 'brainstorms_rosters' || obj.name != 'brainstorms_grids') {
			$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		}
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
			containment:'#brainstorms-right .scroll-pane',
			cancel: 'input,textarea',
			//stack: ".note",
			handle: '.postit-header',
			cursor: 'move',
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
			minHeight: 130, // try to hide footer with 50
			minWidth: 200,
			start: function(e,ui){ 
				ui.helper.css('z-index',++brainstormszIndex);
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
//brainstorms.resetModuleHeights = brainstormsresetModuleHeights;
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
		$("#documentloader").attr('src', url);
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
	$('#brainstormsActions > li span').each( function(index) {
		if(index in oc(actions)) {
			$(this).removeClass('noactive');
		} else {
			$(this).addClass('noactive');
		}
	})
}

var brainstormsLayout, brainstormsInnerLayout;
var brainstormszIndex = 0; // zindex notes for mindmap
var currentBrainstormEditedNote = 0;

function setcEN(id) {
	currentBrainstormEditedNote = id;
}

$(document).ready(function() {
	
	brainstorms.init();
	
	if($('#brainstorms').length > 0) {
		brainstormsLayout = $('#brainstorms').layout({
				west__onresize:				function() { resetModuleHeightsnavThree('brainstorms'); }
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

		loadModuleStartnavThree('brainstorms');
	}


	$("#brainstorms1-outer").on('click', 'h3', function(e, passed_id) {
		e.preventDefault();
		navThreeTitleFirst('brainstorms',$(this),passed_id)
		prevent_dblclick(e)
	});


	$("#brainstorms2-outer").on('click', 'h3', function(e, passed_id) {
		e.preventDefault();
		navThreeTitleSecond('brainstorms',$(this),passed_id)
		prevent_dblclick(e)
	});


	$("#brainstorms3").on('click', 'h3', function(e, passed_id) {
		e.preventDefault();
		navThreeTitleThird('brainstorms',$(this),passed_id)
		prevent_dblclick(e)
	});


	$('#brainstorms1').on('click', 'span.module-click', function(e) {
		e.preventDefault();
		navItemFirst('brainstorms',$(this))
		prevent_dblclick(e)
	});


	$('#brainstorms2').on('click', 'span.module-click', function(e) {
		e.preventDefault();
		navItemSecond('brainstorms',$(this))
		prevent_dblclick(e)
	});


	$('#brainstorms3').on('click', 'span.module-click', function(e) {
		e.preventDefault();
		navItemThird('brainstorms',$(this))
		prevent_dblclick(e)
	});

	
	$(document).on('click', 'a.insertBrainstormFolderfromDialog', function(e) {
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
	$(document).on('click', '.loadBrainstorm', function(e) {
		e.preventDefault();
		var obj = getCurrentModule();
		if(confirmNavigation()) {
			formChanged = false;
			$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		}
		var id = $(this).attr("rel");
		$("#brainstorms2-outer > h3").trigger('click', [id]);
	});


	$('span.actionConvert').on('click', function(e){
		e.preventDefault();
		if($(this).hasClass("noactive")) {
			return false;
		}
		brainstorms_grids.actionConvert();
	});


	var tmp;
	brainstorms.initItems();

	/*$(document).on('click', 'div.brainstormsNoteToggle', function(e) {
		e.preventDefault();
		var id = $(this).attr("id").replace(/note-toggle-/, "");
		var height = $(this).attr("rel");
		if($(this).parents("div.note").height() == 20) {
			$(this).find('span').addClass("icon-toggle").removeClass("icon-toggle-active");
			$(this).parents("div.note")
				.animate({ height: height+'px' }, function() {
						$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/brainstorms&request=setBrainstormNoteToggle&id="+id+"&t=0"});
				});
		} else {
			$(this).find('span').addClass("icon-toggle-active").removeClass("icon-toggle");
			$(this).parents("div.note")
				.animate({ height: 20 }, function() {
						$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/brainstorms&request=setBrainstormNoteToggle&id="+id+"&t=1"});
				});
		}
	});*/


	$(document).on('click', 'span.brainstormsAddNote', function(e) {
		e.preventDefault();
		var oid = $('#brainstorms').data('first');
		var id = $('#brainstorms').data('second');	
		//var z = ++brainstormszIndex;
		var zMax = Math.max.apply(null,$.map($('#brainstorms-outer div.note'), function(e,n){
				return parseInt($(e).css('z-index'))||1 ;
				})
			);
		var z = zMax + 1;
		brainstormszIndex = z;
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/brainstorms&request=newBrainstormNote&id="+id+"&z="+z, success: function(data){
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/brainstorms&request=getBrainstormDetails&fid="+oid+"&id="+id, success: function(text){
				$("#brainstorms-right").html(text.html);
				initBrainstormsContentScrollbar();
				}
			});
			}
		});
	});

	$(document).on('click', '#brainstorms-outer div.note-title', function(e) {
		e.preventDefault();
		var id = parseInt($(this).attr("id").replace(/note-title-/, ""));
		currentBrainstormEditedNote = id;
		var html = $(this).html().replace(/(")/gi, "&quot;");
		var input = '<input type="text" id="input-note-' + id + '" name="input-note-' + id + '" value="' + html+ '" />';
		$("#note-title-" + id).replaceWith(input);
		$("#input-note-" + id).focus();
	});

	$(document).on('click', '#brainstorms-outer div.note-text', function(e) {
		e.preventDefault();
		var id = parseInt($(this).attr("id").replace(/note-text-/, ""));
		currentBrainstormEditedNote = id;
		var html = $(this).html().replace(/(<br\s*\/?>)|(<p><\/p>)/gi, "");
		//var width = $(this).width();
		var height = $(this).height();
		var input = '<textarea id="input-text-' + id + '" name="input-text-' + id + '" style=" height: '+ height +'px; border: 0;">' + html+ '</textarea>';
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