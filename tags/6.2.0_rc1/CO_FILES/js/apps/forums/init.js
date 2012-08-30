function initForumsContentScrollbar() {
	forumsInnerLayout.initContent('center');
}

/* forums Object */
function forumsApplication(name) {
	this.name = name;
	
	this.formProcess = function(formData, form, poformOptions) {
		var title = $("#forums input.title").fieldValue();
		if(title == "") {
			$.prompt(ALERT_NO_TITLE, {callback: setTitleFocus});
			return false;
		} else {
			formData[formData.length] = { "name": "title", "value": title };
		}
	
		formData[formData.length] = processListApps('folder');
		formData[formData.length] = processListApps('status');
	}

	
	this.formResponse = function(data) {
		switch(data.action) {
			case "edit":
				$("#forums2 span[rel='"+data.id+"'] .text").html($("#forums .title").val());
				//$("#durationStart").html($("input[name='startdate']").val());
				switch(data.status) {
					case "2":
						$("#forums2 .active-link .module-item-status").addClass("module-item-active").removeClass("module-item-active-stopped");
					break;
					case "3":
						$("#forums2 .active-link .module-item-status").addClass("module-item-active-stopped").removeClass("module-item-active");
					break;
					default:
						$("#forums2 .active-link .module-item-status").removeClass("module-item-active").removeClass("module-item-active-stopped");
				}
			break;
			case "reload":
				$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/forums&request=getForumDetails&id="+data.id, success: function(text){
					$("#forums-right").html(text.html);
						initForumsContentScrollbar();
					}
				});
			break;
		}
	}


	this.poformOptions = { beforeSubmit: this.formProcess, dataType: 'json', success: this.formResponse };


	this.actionClose = function() {
		forumsLayout.toggle('west');
	}

	
	this.actionNew = function() {
		var module = this;
		var cid = $('#forums input[name="id"]').val()
		module.checkIn(cid);
		var id = $('#forums').data('first');
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: 'path=apps/forums&request=newForum&id=' + id, cache: false, success: function(data){
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/forums&request=getForumList&id="+id, success: function(list){
				$("#forums2 ul").html(list.html);
				var index = $("#forums2 .module-click").index($("#forums2 .module-click[rel='"+data.id+"']"));
				setModuleActive($("#forums2"),index);
				$('#forums').data({ "second" : data.id });
				$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/forums&request=getForumDetails&id="+data.id, success: function(text){
					$("#forums-right").html(text.html);
					initForumsContentScrollbar();
					$('#forums-right .focusTitle').trigger('click');
					}
				});
				forumsActions(0);
				}
			});
			}
		});
	}


	this.actionDuplicate = function() {
		var module = this;
		var cid = $('#forums input[name="id"]').val()
		module.checkIn(cid);
		var pid = $("#forums").data("second");
		var oid = $("#forums").data("first");
		$.ajax({ type: "GET", url: "/", data: 'path=apps/forums&request=createDuplicate&id=' + pid, cache: false, success: function(id){
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/forums&request=getForumList&id="+oid, success: function(data){
				$("#forums2 ul").html(data.html);
					forumsActions(0);
					var idx = $("#forums2 .module-click").index($("#forums2 .module-click[rel='"+id+"']"));
					setModuleActive($("#forums2"),idx)
					$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/forums&request=getForumDetails&id="+id, success: function(text){
							$("#forums").data("second",id);							
							$("#"+forums.name+"-right").html(text.html);
							initForumsContentScrollbar();
						}
					});
				}
			});
			}
		});
	}


	this.actionBin = function() {
		var module = this;
		var cid = $('#forums input[name="id"]').val()
		module.checkIn(cid);
		var txt = ALERT_DELETE;
		var langbuttons = {};
		langbuttons[ALERT_YES] = true;
		langbuttons[ALERT_NO] = false;
		$.prompt(txt,{ 
			buttons:langbuttons,
			callback: function(v,m,f){		
				if(v){
					var id = $("#forums").data("second");
					var fid = $("#forums").data("first");
					$.ajax({ type: "GET", url: "/", data: "path=apps/forums&request=binForum&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/forums&request=getForumList&id="+fid, success: function(list){
								$("#forums2 ul").html(list.html);
								if(list.html == "<li></li>") {
									forumsActions(3);
								} else {
									forumsActions(0);
									setModuleActive($("#forums2"),0);
								}
								var id = $("#forums2 .module-click:eq(0)").attr("rel");
								$("#forums").data("second", id);								
								$("#forums2 .module-click:eq(0)").addClass('active-link');
								$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/forums&request=getForumDetails&fid="+fid+"&id="+id, success: function(text){
									$("#forums-right").html(text.html);
									initForumsContentScrollbar();
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
		var oid = $('#forums').data('first');
		var pid = $('#forums').data('second');
		$("#forums2 .active-link").trigger("click");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/forums&request=getForumList&id="+oid, success: function(data){
			$("#forums2 ul").html(data.html);
			var idx = $("#forums2 .module-click").index($("#forums2 .module-click[rel='"+pid+"']"));
			$("#forums2 .module-click:eq("+idx+")").addClass('active-link');
			}
		});
	}


	this.actionPrint = function() {
		var id = $("#forums").data("second");
		var url ='/?path=apps/forums&request=printForumDetails&id='+id;
		location.href = url;
	}


	this.actionSend = function() {
		var id = $("#forums").data("second");
		$.ajax({ type: "GET", url: "/", data: "path=apps/forums&request=getForumSend&id="+id, success: function(html){
			$("#modalDialogForward").html(html).dialog('open');
			}
		});
	}


	this.actionSendtoResponse = function() {
		var id = $("#forums").data("second");
		$.ajax({ type: "GET", url: "/", data: "path=apps/forums&request=getSendtoDetails&id="+id, success: function(html){
			$("#forum_sendto").html(html);
			$("#modalDialogForward").dialog('close');
			}
		});
	}


	this.sortclick = function (obj,sortcur,sortnew) {
		var module = this;
		var cid = $('#forums input[name="id"]').val()
		module.checkIn(cid);
		var fid = $("#forums .module-click:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/forums&request=getForumList&id="+fid+"&sort="+sortnew, success: function(data){
			$("#forums2 ul").html(data.html);
			obj.attr("rel",sortnew);
			obj.removeClass("sort"+sortcur).addClass("sort"+sortnew);
			var id = $("#forums2 .module-click:eq(0)").attr("rel");
			$('#forums').data('second',id);			
			if(id == undefined) {
				return false;
			}
			setModuleActive($("#forums2"),'0');
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/forums&request=getForumDetails&id="+id, success: function(text){
				$("#"+forums.name+"-right").html(text.html);
				initForumsContentScrollbar()
				}
			});
			}
		});
	}


	this.sortdrag = function (order) {
		var fid = $("#forums .module-click:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", data: "path=apps/forums&request=setForumOrder&"+order+"&id="+fid, success: function(html){
			$("#forums2 .sort").attr("rel", "3");
			$("#forums2 .sort").removeClass("sort1").removeClass("sort2").addClass("sort3");
			}
		});
	}
	
	
	this.actionDialog = function(offset,request,field,append,title,sql) {
		$.ajax({ type: "GET", url: "/", data: 'path=apps/forums&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
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
		var html = '<div class="listmember" field="forumsstatus" uid="'+rel+'" style="float: left">' + text + '</div>';
		$("#forumsstatus").html(html);
		$("#modalDialog").dialog("close");
		$("#forumsstatus").nextAll('img').trigger('click');
	}
	
	
	this.insertItem = function(id,text,replyid) {
		var num = $('#forumsPosts .forumouter').size()+1;
		//$.ajax({ type: "POST", url: "/", dataType:  'json', data: "path=apps/brainstorms/modules/forums&request=addItem&id=" + id + "&text=" + text + "&replyid=" + replyid + "&num=" + num, success: function(data){
		$.ajax({ type: "POST", url: "/", dataType:  'json', data: { path: 'apps/forums', request: 'addForumItem', id: id, text: text, replyid: replyid, num: num }, success: function(data){
				if(replyid == 0) {
					var prev = '<div id="forumsPostouter_' + data.itemid + '" class="parent" style="border-top: 1px solid #77713D">';
					var last = '</div><div style="height: 20px;"></div>';
					$("#forumsPosts").append(prev + data.html + last);
				} else {
					var prev = '<div id="forumsPostouter_' + data.itemid + '" style="margin-left: 15px">';
					var last = '</div>';
					var postouter = $("#forumsPostouter_"+replyid);
					postouter.append(prev + data.html + last);
					$("#forumsPost_"+replyid).find('.icon-delete').toggleClass('icon-delete').toggleClass('icon-delete-inactive')
					$("#forumsPost_"+replyid).find('.binItem').addClass('deactivated');
				}
				var element = $("#forumsPost_"+data.itemid+" .cbx");
				$.jNice.CheckAddPO(element);
				$("#modalDialogForumsPost").slideUp(function() {		
							initForumsContentScrollbar();
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/forums&request=binForumItem&id=" + id, success: function(data){
						if(data){
							$("#forumsPostouter_"+id).slideUp(function(){ 
								if($(this).siblings().size() == 1) {
								$(this).prev().find('.icon-delete-inactive').toggleClass('icon-delete').toggleClass('icon-delete-inactive');
								$(this).prev().find('.binItem').removeClass('deactivated');

								}
								if($(this).hasClass('parent')) {
									$(this).next().remove();
								}
								$(this).remove();
							});
						} 
						}
					});
				} 
			}
		});	
	}

	
	
	this.insertFolderFromDialog = function(field,gid,title) {
		var html = '<a class="listmember" uid="' + gid + '" field="'+field+'">' + title + '</a>';
		$("#"+field).html(html);
		$("#modalDialog").dialog('close');
		var obj = getCurrentModule();
		$('#forums .coform').ajaxSubmit(obj.poformOptions);
	}
	
	this.actionHelp = function() {
		var url = "/?path=apps/forums&request=getForumsHelp";
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/forums&request=deleteForum&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#forum_'+id).slideUp();
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/forums&request=restoreForum&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#forum_'+id).slideUp();
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/forums&request=deleteItem&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#forum_task_'+id).slideUp();
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/forums&request=restoreItem&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#forum_task_'+id).slideUp();
						}
					}
					});
				} 
			}
		});
	}

	this.markNoticeRead = function(pid) {
		$.ajax({ type: "GET", url: "/", data: "path=apps/forums&request=markNoticeRead&pid=" + pid, cache: false});
	}
	
	this.markNewPostRead = function(pid) {
		$.ajax({ type: "GET", url: "/", data: "path=apps/forums&request=markNewPostRead&pid=" + pid, cache: false});
	}

}

var forums = new forumsApplication('forums');
forums.resetModuleHeights = forumsresetModuleHeights;
forums.modules_height = forums_num_modules*module_title_height;
forums.GuestHiddenModules = new Array("access");

// register folder object
function forumsFolders(name) {
	this.name = name;
	
	
	this.formProcess = function(formData, form, poformOptions) {
		var title = $("#forums input.title").fieldValue();
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
				$("#forums1 span[rel='"+data.id+"'] .text").html($("#forums .title").val());
			break;
		}
	}


	this.poformOptions = { beforeSubmit: this.formProcess, dataType: 'json', success: this.formResponse };

	
	this.actionNew = function() {
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/forums&request=newFolder", cache: false, success: function(data){
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/forums&request=getFolderList", success: function(list){
				$("#forums1 ul").html(list.html);
				$("#forums1 li").show();
				var index = $("#forums1 .module-click").index($("#forums1 .module-click[rel='"+data.id+"']"));
				setModuleActive($("#forums1"),index);
				$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/forums&request=getFolderDetails&id="+data.id, success: function(text){
					$("#forums").data("first",data.id);					
					$("#"+forums.name+"-right").html(text.html);
					initForumsContentScrollbar();
					$('#forums-right .focusTitle').trigger('click');
					}
				});
				forumsActions(9);
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
					var id = $("#forums").data("first");
					$.ajax({ type: "GET", url: "/", data: "path=apps/forums&request=binFolder&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/forums&request=getFolderList", success: function(data){
								$("#forums1 ul").html(data.html);
								if(data.html == "<li></li>") {
									forumsActions(3);
								} else {
									forumsActions(9);
								}
								var id = $("#forums1 .module-click:eq(0)").attr("rel");
								$("#forums").data("first",id);								
								$("#forums1 .module-click:eq(0)").addClass('active-link');
								$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/forums&request=getFolderDetails&id="+id, success: function(text){
									$("#"+forums.name+"-right").html(text.html);
									initForumsContentScrollbar();
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
		var id = $("#forums").data("first");
		$("#forums1 .active-link").trigger("click");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/forums&request=getFolderList", success: function(data){
			$("#forums1 ul").html(data.html);
			if(data.access == "guest") {
				forumsActions();
			} else {
				if(data.html == "<li></li>") {
					forumsActions(3);
				} else {
					forumsActions(9);
				}
			}
			var idx = $("#forums1 .module-click").index($("#forums1 .module-click[rel='"+id+"']"));
			$("#forums1 .module-click:eq("+idx+")").addClass('active-link');
			}
		});
	}


	this.actionPrint = function() {
		var id = $("#forums").data("first");
		var url ='/?path=apps/forums&request=printFolderDetails&id='+id;
		location.href = url;
	}


	this.actionSend = function() {
		var id = $("#forums").data("first");
		$.ajax({ type: "GET", url: "/", data: "path=apps/forums&request=getFolderSend&id="+id, success: function(html){
			$("#modalDialogForward").html(html).dialog('open');
			}
		});
	}


	this.actionSendtoResponse = function() {
		//var id = $("#forums1 .active-link").attr("rel");
		//$.ajax({ type: "GET", url: "/", data: "path=apps/forums&request=getSendtoDetails&id="+id, success: function(html){
			//$("#forum_sendto").html(html);
			$("#modalDialogForward").dialog('close');
			//}
		//});
	}

	
	this.sortclick = function (obj,sortcur,sortnew) {
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/forums&request=getFolderList&sort="+sortnew, success: function(data){
			$("#forums1 ul").html(data.html);
			obj.attr("rel",sortnew);
		  	obj.removeClass("sort"+sortcur).addClass("sort"+sortnew);
			var id = $("#forums1 .module-click:eq(0)").attr("rel");
			$('#forums').data('first',id);			
			$("#forums1 .module-click:eq(0)").addClass('active-link');
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/forums&request=getFolderDetails&id="+id, success: function(text){
				$("#forums-right").html(text.html);
				initForumsContentScrollbar()
				}
			});
			}
		});
	}


	this.sortdrag = function (order) {
		$.ajax({ type: "GET", url: "/", data: "path=apps/forums&request=setFolderOrder&"+order, success: function(html){
			$("#forums1 .sort").attr("rel", "3");
			$("#forums1 .sort").removeClass("sort1").removeClass("sort2").addClass("sort3");
			}
		});
	}
	
	
	this.actionDialog = function(offset,request,field,append,title,sql) {
		$.ajax({ type: "GET", url: "/", data: 'path=apps/forums&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
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
		var url = "/?path=apps/forums&request=getForumsFoldersHelp";
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/forums&request=deleteFolder&id=" + id, cache: false, success: function(data){
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/forums&request=restoreFolder&id=" + id, cache: false, success: function(data){
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

var forums_folder = new forumsFolders('forums_folder');


function forumsActions(status) {
	/*	0= new	1= print	2= send		3= duplicate	4= handbook		5=refresh 	6 = delete*/
	switch(status) {
		//case 0: 	actions = ['0','1','2','3','4']; break; // all actions
		case 0: actions = ['0','1','2','3','4','5','6']; break;
		//case 1: 	actions = ['0','1','2','4']; break; 	// no duplicate
		case 1: actions = ['0','4','5','6']; break;
		//case 2: 	actions = ['1']; break;   					// just save
		case 3: 	actions = ['0','4','5']; break;   					// just new
		case 4: 	actions = ['0','1','2','4','5']; break;   		// new, print, send, handbook, refresh
		case 5: 	actions = ['1','2','4','5']; break;   			// print, send, refresh
		case 6: 	actions = ['4','5']; break;   			// handbook refresh
		case 7: 	actions = ['0','1','2','4','5']; break;   			// new, print, send, refresh
		case 8: 	actions = ['1','2','4','5']; break;   			// print, send, handbook, refresh
		case 9:		actions = ['0','1','2','4','5','6']; break;
		default: 	actions = ['4','5'];  								// none
	}
	$('#forumsActions > li span').each( function(index) {
		if(index in oc(actions)) {
			$(this).removeClass('noactive');
		} else {
			$(this).addClass('noactive');
		}
	})
}


function forumsloadModuleStart() {
	var h = $("#forums div.ui-layout-west").height();
	$("#forums .ui-layout-west .radius-helper").height(h);
	$("#forums .secondLevelOuter").css('top',h-27);
	$("#forums .thirdLevelOuter").css('top',150);
	$('#forums1').data('status','open');
	$('#forums2').data('status','closed');
	$('#forums3').data('status','closed');
	$("#forums1").height(h-98);
	$("#forums1 .module-inner").height(h-98);
	$("#forums1 .module-actions").show();
	$("#forums2 .module-actions").hide();
	$("#forums2 li").show();
	$("#forums2").height(h-125-forums_num_modules*27).removeClass("module-active");
	$("#forums2 .module-inner").height(h-125-forums_num_modules*27);
	$("#forums3 .module-actions").hide();
	$("#forums3").height(h-150);
	$("#forums3 .forums3-content").height(h-(forums.modules_height+152));
	$("#forums3 div.thirdLevel").height(h-(forums.modules_height+150-27));
	$("#forums-current").val("folder");
	$("#forums3 div.thirdLevel").each(function(i) { 
		var position = $(this).position();
		var t = position.top+h-150;
		$(this).animate({top: t})
	})
	$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/forums&request=getFolderList", success: function(data){
		$("#forums1 ul").html(data.html);
		$("#forumsActions .actionNew").attr("title",data.title);
		if(data.access == "guest") {
			forumsActions();
		} else {
			if(data.html == "<li></li>") {
				forumsActions(3);
			} else {
				forumsActions(9);
			}
		}
		$("#forums1 li").show();
		$("#forums1 .sort").attr("rel", data.sort).addClass("sort"+data.sort);
		forumsInnerLayout.initContent('center');
		var id = $("#forums1 .module-click:eq(0)").attr("rel");
		$('#forums').data({ "current" : "folders" , "first" : id , "second" : 0 , "third" : 0});
		$("#forums1 .module-click:eq(0)").addClass('active-link');
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/forums&request=getFolderDetails&id="+id, success: function(text){
			$("#"+forums.name+"-right").html(text.html);
			forumsInnerLayout.initContent('center');
			}
		});
	}
	});
}


function forumsresetModuleHeights() {
	if(getCurrentApp() != 'forums') {
		$('#forums').css('top',2*$('#container-inner').height());
	}
	var h = $("#forums div.ui-layout-west").height();
	$("#forums .ui-layout-west .radius-helper").height(h);
	$("#forums1").height(h-98);
	$("#forums1 .module-inner").height(h-98);
	$("#forums2").height(h-125-forums_num_modules*27);
	$("#forums2 .module-inner").height(h-125-forums_num_modules*27);
	$("#forums3").height(h-150);
	$("#forums3 .forums3-content").height(h-(forums.modules_height+152));
	$("#forums3 div.thirdLevel").height(h-(forums.modules_height+150-27));
	if($('#forums1').data('status') == 'open') {
		$("#forums2-outer").css('top',h-27);
		$("#forums3 div.thirdLevel").each(function(i) { 
			var t = h-150+i*27;
			$(this).animate({top: t})
		})
	}
	if($('#forums2').data('status') == 'open') {	
		var curmods = $("#forums3 div.thirdLevel:not(.deactivated)").size();
		$("#forums2").height(h-125-curmods*27).removeClass("module-active");
		$("#forums2 .module-inner").height(h-125-curmods*27);
		$("#forums3 .forums3-content").height(h-(curmods*27+152));
		$("#forums3 div.thirdLevel").height(h-(curmods*27+150-27));
		$("#forums3 div.thirdLevel:not(.deactivated)").each(function(i) { 
			var t = h-150-curmods*27+i*27;
			$(this).animate({top: t})
		})
	}
	if($('#forums3').data('status') == 'open') {
		var obj = getCurrentModule();
		var idx = $('#forums3 .thirdLevel:not(.deactivated)').index($('#forums3 .thirdLevel:not(.deactivated)[id='+obj.name+']'));	
		var curmods = $("#forums3 div.thirdLevel:not(.deactivated)").size();
		$("#forums2").height(h-125-curmods*27).removeClass("module-active");
		$("#forums2 .module-inner").height(h-125-curmods*27);
		$("#forums3 .forums3-content").height(h-(curmods*27+152));
		$("#forums3 div.thirdLevel").height(h-(curmods*27+150-27));
		$("#forums3 div.thirdLevel:not(.deactivated)").each(function(i) { 
		if(i > idx) {
			var pos = $(this).position();
				var t = h-150-curmods*27+i*27;
				$(this).animate({top: t})
			}
		})
	}
}



function Forums2ModulesDisplay(access) {
	var h = $("#forums div.ui-layout-west").height();
	if(access == "guest" || access == "guestadmin") {
		var modLen = forums.GuestHiddenModules.length;
		var p_num_modules = forums_num_modules-modLen;
		var p_modules_height = p_num_modules*module_title_height;
		$("#forums3 .forums3-content").height(h-(p_modules_height+152));
		$("#forums3 div.thirdLevel").height(h-(p_modules_height+150-27));
		$("#forums2").height(h-125-p_num_modules*27).removeClass("module-active");
		$("#forums2 .module-inner").height(h-125-p_num_modules*27);
		var a = 0;
		var t = $("#forums2").height();
		$("#forums2").animate({height: t+p_modules_height})
		$("#forums2-outer").animate({top: 96}, function() {
			$("#forums3 div.thirdLevel").each(function(i) { 
				var rel = $(this).find('h3').attr('rel');
				if(forums.GuestHiddenModules.indexOf(rel) >= 0 ) {
					$(this).addClass('deactivated').animate({top: 9999})	
				} else {
					var t = $("#forums3").height()-p_num_modules*27+a*27;
						$(this).animate({top: t})			
					a = a+1;
				}
			})
			$("#forums-top .top-headline").html($("#forums1 .deactivated").find(".text").html());
			$("#forums2").animate({height: t})
		})
	} else {
		$("#forums3 .forums3-content").height(h-(forums.modules_height+152));
		$("#forums3 div.thirdLevel").height(h-(forums.modules_height+150-27));
		$("#forums2 .module-inner").height(h-125-forums_num_modules*27);
		var t = h-125-forums.modules_height;
		$("#forums2").animate({height: t+forums.modules_height})
		$("#forums2-outer").animate({top: 96}, function() {
			$("#forums3 div.thirdLevel").each(function(i) { 
				var t = $("#forums3").height()-forums.modules_height+i*27;
				$(this).animate({top: t})			
			})
			$("#forums-top .top-headline").html($("#forums1 .deactivated").find(".text").html());
			$("#forums2").animate({height: t})
		})
	}
}


function ForumsModulesDisplay(access) {
	var h = $("#forums div.ui-layout-west").height();
	if(access == "guest" || access == "guestadmin") {
		var modLen = forums.GuestHiddenModules.length;
		var p_num_modules = forums_num_modules-modLen;
		p_modules_height = p_num_modules*module_title_height;
		$("#forums3 .forums3-content").height(h-(p_modules_height+152));
		$("#forums3 div.thirdLevel").height(h-(p_modules_height+150-27));
		$("#forums2").height(h-125-p_num_modules*27).removeClass("module-active");
		$("#forums2 .module-inner").height(h-125-p_num_modules*27);
		var a = 0;
		
		var t = $("#forums2").height();
		$("#forums2").animate({height: t+forums_num_modules*27}, function() {
			$(this).animate({height: t});
		})
		
		$("#forums3 div.thirdLevel").each(function(i) { 
			var rel = $(this).find('h3').attr('rel');
			if(forums.GuestHiddenModules.indexOf(rel) >= 0 ) {
				$(this).addClass('deactivated').animate({top: 9999})	
			} else {
				var t = $("#forums3").height()-p_num_modules*27+a*27;
				var position = $(this).position();
				var d = position.top+forums_num_modules*27;
				$(this).animate({top: d}, function() {
					$(this).animate({top: t})			
				})
				a = a+1;
			}
		})
	} else {
		$("#forums3 .forums3-content").height(h-(forums.modules_height+152));
		$("#forums3 div.thirdLevel").height(h-(forums.modules_height+150-27));
		$("#forums2 .module-inner").height(h-125-forums_num_modules*27);
		var curmods = $("#forums3 div.thirdLevel:not(.deactivated)").size();
		var t = h-125-forums_num_modules*27;
		$("#forums2").animate({height: t+forums_num_modules*27}, function() {
			$(this).animate({height: t});
		})
		$("#forums3 div.thirdLevel").each(function(i) { 
			$(this).removeClass('deactivated');
			var t = $("#forums3").height()-forums_num_modules*27+i*27;
				var position = $(this).position();
				var d = h-150+i*27;
				$(this).animate({top: d}, function() {
					$(this).animate({top: t})			
				})
		})
	}
}


function ForumsExternalLoad(what,f,p,ph) { // from Desktop
	if(what == 'forums') {
		$('#forums').data({ "first" : f});
		var index = $('#forums1 .module-click').index($('#forums1 .module-click[rel='+f+']'));
		$.ajax({ type: "GET", url: "/", dataType:  'json', async: false, data: "path=apps/forums&request=getForumList&id="+f, success: function(data){
			$("#forums2 ul").html(data.html);
			setModuleDeactive($("#forums1"),index);
			$('#forums1').find('li:eq('+index+')').show();
			$("#forums-top .top-headline").html($("#forums1 .deactivated").find(".text").html());
			}
		})
		$('#forums').data({ "second" : p});
		var index = $("#forums2 .module-click").index($("#forums2 .module-click[rel='"+p+"']"));
		setModuleActive($("#forums2"),index);
		$("#forums2-outer").css('top', 96);
		$('#forums3 h3').removeClass("module-bg-active");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/forums&request=getForumDetails&fid="+f+"&id="+p, success: function(text){
			$("#forums-current").val(what);
			$('#forums').data({ "current" : what});
			$('#forums').data({ "second" : p});
			$('#forums1').data('status','closed');
			$('#forums2').data('status','open');
			$('#forums3').data('status','closed');
			$("#forums-right").html(text.html);		
			if($('#checkedOut').length > 0) {
				$("#forums2 .active-link .icon-checked-out").addClass('icon-checked-out-active');
			} else {
				$("#forums2 .active-link .icon-checked-out").removeClass('icon-checked-out-active');
			}
			switch (text.access) {
				case "sysadmin":
					forumsActions(0);
				break;
				case "admin":
					forumsActions(0);
				break;
				case "guestadmin":
					forumsActions(7);
				break;
				case "guest":
					forumsActions(5);
				break;
			}
			initForumsContentScrollbar();
			if(text.access != "sysadmin" || text.access != "admin") { 
				var h = $("#forums div.ui-layout-west").height();
				var modLen = forums.GuestHiddenModules.length;
				var p_num_modules = forums_num_modules-modLen;
				p_modules_height = p_num_modules*module_title_height;
				$("#forums3 .forums3-content").height(h-(p_modules_height+152));
				$("#forums3 div.thirdLevel").height(h-(p_modules_height+150-27));
				$("#forums2").height(h-125-p_num_modules*27).removeClass("module-active");
				$("#forums2 .module-inner").height(h-125-p_num_modules*27);
				var a = 0;
				$("#forums3 div.thirdLevel").each(function(i) { 
					var rel = $(this).find('h3').attr('rel');
					if(forums.GuestHiddenModules.indexOf(rel) >= 0 ) {
						$(this).addClass('deactivated').animate({top: 9999})	
					} else {
						var t = $("#forums3").height()-p_num_modules*27+a*27;
						$(this).animate({top: t})			
						a = a+1;
					}
				})
				$('span.app_forums').trigger('click');
			} else {
				$("#forums3 div.thirdLevel:not(.deactivated)").each(function(i) { 
					var t = h-150-forums_num_modules*27+i*27;
					$(this).animate({top: t})
				})
				$('span.app_forums').trigger('click');
			}
			}
		});
	}
	
	if(what == 'phases') {
		$('#forums').data({ "first" : f});
		var index = $('#forums1 .module-click').index($('#forums1 .module-click[rel='+f+']'));
		$.ajax({ type: "GET", url: "/", dataType:  'json', async: false, data: "path=apps/forums&request=getForumList&id="+f, success: function(data){
			$("#forums2 ul").html(data.html);
				setModuleDeactive($("#forums1"),index);
				$('#forums1').find('li:eq('+index+')').show();
				$("#forums-top .top-headline").html($("#forums1 .deactivated").find(".text").html());
			}
		})
		$('#forums').data({ "second" : p});
			
		var index = $("#forums2 .module-click").index($("#forums2 .module-click[rel='"+p+"']"));
		setModuleDeactive($("#forums2"),index);
		$("#forums2-outer").css('top', 96);
		$('#forums3 h3').removeClass("module-bg-active");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/forums/modules/"+what+"&request=getList&id="+p, success: function(data){
			$("#forums-current").val(what);
			$('#forums').data({ "current" : what});
			$('#forums').data({ "third" : ph});
			$('#forums1').data('status','closed');
			$('#forums2').data('status','closed');
			$('#forums3').data('status','open');
			$('#forums3 ul[rel='+what+']').html(data.html);
			$("#forumsActions .actionNew").attr("title",data.title);
			switch (data.perm) {
				case "sysadmin": case "admin" :
					if(data.html == "<li></li>") {
						forumsActions(3);
					} else {
						forumsActions(0);
					}
				break;
				case "guest":
					if(data.html == "<li></li>") {
						forumsActions();
					} else {
						forumsActions(5);
					}
				break;
			}
			$("#forums3 div.thirdLevel").each(function(i) { 
				if(i == 0) {
				var t = 0;
				} else {
					var n = $(this).height();
					var t = n+i*module_title_height-27;
				}
				$(this).animate({top: t})
			})		
			$('#forums3 ul[rel='+what+'] .module-click[rel='+ph+']').addClass('active-link');
			var idx = $('#forums3 ul[rel='+what+'] .module-click').index($('#forums3 ul[rel='+what+'] .module-click[rel='+ph+']'));
			forums_phases.getDetails(0,idx,data.html);
			$("#forums3 .module-actions:eq(0)").show();
			$("#forums3 .sort:eq(0)").attr("rel", data.sort).addClass("sort"+data.sort);
			$("#forums-top .top-subheadline").html(', ' + $("#forums2 .module-click:visible").find(".text").html());
			/*$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/forums&request=getDates&id="+p, success: function(data){
				$("#forums-top .top-subheadlineTwo").html(data.startdate + ' - <span id="forumenddate">' + data.enddate + '</span>');
				$('span.app_forums').trigger('click');
				}
			});*/
			}
		});
	}
}



var forumsLayout, forumsInnerLayout;

$(document).ready(function() {
						   
	if($('#forums').length > 0) {
		forumsLayout = $('#forums').layout({
				west__onresize:				function() { forumsresetModuleHeights() }
			,	resizeWhileDragging:		true
			,	spacing_open:				0
			,	spacing_closed:				0
			,	closable: 					false
			,	resizable: 					false
			,	slidable:					false
			, 	west__size:					325
			,	west__closable: 			true
			,	center__onresize: "forumsInnerLayout.resizeAll"
			
		});
		
		forumsInnerLayout = $('#forums div.ui-layout-center').layout({
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
		
		forumsloadModuleStart();
	}


	$("#forums1-outer > h3").on('click', function(e, passed_id) {
		e.preventDefault();
		navThreeTitleFirst('forums',$(this),passed_id)
	});


	$("#forums2-outer > h3").on('click', function(e, passed_id) {
		e.preventDefault();
		navThreeTitleSecond('forums',$(this),passed_id)
	});


	$(document).on('click', '#forums1 .module-click',function(e) {
		e.preventDefault();
		navItemFirst('forums',$(this))
	});


	$(document).on('click', '#forums2 .module-click',function(e) {
		e.preventDefault();
		navItemSecond('forums',$(this))
	});


	$(document).on('click', '#forums3 .module-click',function(e) {
		e.preventDefault();
		navItemThird('forums',$(this))
	});


	$("#forums3 h3").on('click', function(e, passed_id) {
		e.preventDefault();
		var obj = getCurrentModule();
		if(confirmNavigation()) {
			formChanged = false;
			$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		}
		var cid = $('#forums input[name="id"]').val()
		obj.checkIn(cid);
		
		var moduleidx = $("#forums3 h3").index(this);
		var module = $(this).attr("rel");
		var h3click = $(this);
		// module open and  active 
		if($(this).hasClass("module-bg-active")) {
			$("#forums2-outer > h3").trigger("click");
		} else {
			// module 3 allready activated
			if($('#forums3').data('status') == 'open') {
				var id = $("#forums").data('second');
				var mod = getCurrentModule();
				var todeactivate = mod.name.replace(/forums_/, "");
				$('#forums3 h3[rel='+todeactivate+']').removeClass("module-bg-active");
				$("#forums3 .module-actions:visible").hide();
				var curmoduleidx = $("#forums3 h3").index($('#forums3 h3[rel='+todeactivate+']'));
				var t = moduleidx*module_title_height;				
				h3click.addClass("module-bg-active")
				$("#forums3 div.thirdLevel:not(.deactivated)").each(function(i) { 
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
						$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/forums/modules/"+module+"&request=getList&id="+id, success: function(data){
							$("#forums3 ul:eq("+moduleidx+")").html(data.html);
							$("#forumsActions .actionNew").attr("title",data.title);
							switch (data.perm) {
								case "sysadmin": case "admin" :
									if(data.html == "<li></li>") {
										forumsActions(3);
									} else {
										forumsActions(0);
									}
								break;
								case "guest":
									if(data.html == "<li></li>") {
										forumsActions();
									} else {
										forumsActions(5);
									}
								break;
							}
							if(passed_id === undefined) {
								var idx = 0;
							} else {
								var idx = $("#forums3 ul:eq("+moduleidx+") .module-click").index($("#forums3 ul:eq("+moduleidx+") .module-click[rel='"+passed_id+"']"));
							}
							$("#forums3 ul:eq("+moduleidx+") .module-click:eq("+idx+")").addClass('active-link');
							var obj = getCurrentModule();
							obj.getDetails(moduleidx,idx,data.html);
							$(this).prev("h3").removeClass("module-bg-active");	
							$("#forums3 .module-actions:eq("+moduleidx+")").show();
							$("#forums3 .sort:eq("+moduleidx+")").attr("rel", data.sort).addClass("sort"+data.sort);
							}
						});			 
				}, 400);
			} else {
				// load and slide up module 3
				var id = $("#forums").data('second');
				$('#forums2').data('status','closed');
				$('#forums3').data('status','open');				
				if(id == undefined) {
					return false;
				}
				var index = $("#forums2 .module-click").index($("#forums2 .module-click[rel='"+id+"']"));
				$("#forums3 .module-actions:visible").hide();
				h3click.addClass("module-bg-active");
				setModuleDeactive($("#forums2"),index);
				$("#forums3 div.thirdLevel").each(function(i) { 
					if(i <= moduleidx) {
						var position = $(this).position();
							var h = i*27;
							$(this).animate({top: h})
						}
					if(i == forums_num_modules-1) {
						setTimeout(function() {
							$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/forums/modules/"+module+"&request=getList&id="+id, success: function(data){
								$("#forums3 ul:eq("+moduleidx+")").html(data.html);
								$("#forumsActions .actionNew").attr("title",data.title);
								switch (data.perm) {
							case "sysadmin": case "admin" :
								if(data.html == "<li></li>") {
									forumsActions(3);
								} else {
									forumsActions(0);
								}
							break;
							case "guest":
								if(data.html == "<li></li>") {
									forumsActions();
								} else {
									forumsActions(5);
								}
							break;
						}
						if(passed_id === undefined) {
							var idx = 0;
						} else {
							var idx = $("#forums3 ul:eq("+moduleidx+") .module-click").index($("#forums3 ul:eq("+moduleidx+") .module-click[rel='"+passed_id+"']"));
						}
						$("#forums3 ul:eq("+moduleidx+") .module-click:eq("+idx+")").addClass('active-link');
						$("#forums-top .top-subheadline").html(', ' + $("#forums2 .module-click:visible").find(".text").html());
						/*$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/forums&request=getDates&id="+id, success: function(data){
							$("#forums-top .top-subheadlineTwo").html(data.startdate + ' - <span id="forumenddate">' + data.enddate + '</span>');
						}
						});*/
						var obj = getCurrentModule();
						obj.getDetails(moduleidx,idx,data.html);
						$("#forums3 .sort:eq("+moduleidx+")").attr("rel", data.sort).addClass("sort"+data.sort);
						$("#forums3 .module-actions:eq("+moduleidx+")").show();
						}
					});
				}, 400);
			}
		})
	}
			$("#forums-current").val(module);
		$('#forums').data({ "current" : module});
		}
	});


	$('a.insertForumFolderfromDialog').livequery('click',function(e) {
		e.preventDefault();
		var field = $(this).attr("field");
		var gid = $(this).attr("gid");
		var title = $(this).attr("title");
		var obj = getCurrentModule();
		obj.insertFolderFromDialog(field,gid,title);
	});
	
	
	
// INTERLINKS FROM Content
	
	// load a forum
	$(".loadForum").live('click', function() {
		
		var obj = getCurrentModule();
		if(confirmNavigation()) {
			formChanged = false;
			$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		}
		
		var id = $(this).attr("rel");
		$("#forums2-outer > h3").trigger('click', [id]);
		return false;
	});


$("#forumsReplyText").livequery(function() {	 
		var postReply = $(this);
		$.getScript("tiny_mce/jquery.tinymce.js", function(){
			postReply.tinymce({
			script_url : 'tiny_mce/tiny_mce_gzip.php',
			doctype: '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">',
			theme : "advanced",
			skin : "coBlue",
			language: "de",
			entity_encoding : "raw",
        	plugins : "advlink,emotions,inlinepopups,paste,directionality,noneditable,visualchars,nonbreaking,xhtmlxtras",
			force_br_newlines: false,
			force_p_newlines: true,
			theme_advanced_buttons1 : "bold,italic,underline,strikethrough,emotions",
			theme_advanced_buttons2 : "",
			theme_advanced_buttons3 : "",
			theme_advanced_buttons4 : "",
        	theme_advanced_toolbar_location : "top",
       		theme_advanced_toolbar_align : "left",
        	theme_advanced_statusbar_location : "none",
			content_css : "tiny_mce/editor.content.css"
			});
		})
	})

	
	$("a.postForumsReply").live("click", function(e) {
		e.preventDefault();
		var rel = $(this).attr("rel");
		$("#modalDialogForumsPost").slideDown(function() {
			$("#forumsReplyID").val(rel);
			$("#forumsReplyText").focus();	
			$('#forums-right .ui-layout-content').height($('#forums-right .ui-layout-content').height()-99)
			initForumsContentScrollbar();								
		});
	});


	$("#modalDialogForumsPostClose").live("click", function(e) {
		e.preventDefault();
		$("#modalDialogForumsPost").slideUp(function() {		
			initForumsContentScrollbar();									
		});
	});


	$("span.actionForumsReply").live("click", function(e) {
		e.preventDefault();
		var id = $("#forums").data('second');
		var text = $("#forumsReplyText").val();
		if(text == "") {
			$.prompt(ALERT_FORUM_RESPONSE_EMPTY);
			return false;
		}
		var replyid = $("#forumsReplyID").val();
		forums.insertItem(id,text,replyid);
	});


	$("div.forumsPostToggle").live("click", function(e) {
		e.preventDefault();
		var id = $(this).attr("id").replace(/post-toggle-/, "");
		var outer = $('#forumsPostouter_'+id);
		var height = outer.height();
		if(height == 20) {
			$(this).find('span').addClass("icon-toggle-post").removeClass("icon-toggle-post-active");
			outer.removeClass('toggeled')
				.animate({height: outer.data('h')}, function() { 
					$(this).css('height','auto');
				});
		} else {
			$(this).find('span').addClass("icon-toggle-post-active").removeClass("icon-toggle-post");
			outer.data('h', outer.height());
			outer.animate({height: 20}).addClass('toggeled')
		}
	});


});