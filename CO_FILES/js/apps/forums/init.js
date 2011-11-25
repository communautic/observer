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


	this.actionNew = function() {
		var module = this;
		var cid = $('#forums input[name="id"]').val()
		module.checkIn(cid);
		var id = $('#'+forums.name+' .module-click:visible').attr("rel");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: 'path=apps/forums&request=newForum&id=' + id, cache: false, success: function(data){
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/forums&request=getForumList&id="+id, success: function(list){
				$("#forums2 ul").html(list.html);
				var index = $("#forums2 .module-click").index($("#forums2 .module-click[rel='"+data.id+"']"));
				setModuleActive($("#forums2"),index);
				$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/forums&request=getForumDetails&id="+data.id, success: function(text){
					$("#forums-right").html(text.html);
					initForumsContentScrollbar();
					$('#forums2 input.filter').quicksearch('#forums2 li');
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
		var pid = $("#forums2 .active-link").attr("rel");
		var oid = $("#forums1 .module-click:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", data: 'path=apps/forums&request=createDuplicate&id=' + pid, cache: false, success: function(id){
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/forums&request=getForumList&id="+oid, success: function(data){
				$("#forums2 ul").html(data.html);
					forumsActions(0);
					$('#forums2 input.filter').quicksearch('#forums2 li');
					var idx = $("#forums2 .module-click").index($("#forums2 .module-click[rel='"+id+"']"));
					setModuleActive($("#forums2"),idx)
					$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/forums&request=getForumDetails&id="+id, success: function(text){
							$("#"+forums.name+"-right").html(text.html);
							initForumsContentScrollbar();
							$('#forums2 input.filter').quicksearch('#forums2 li');
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
					var id = $("#forums2 .active-link").attr("rel");
					var fid = $("#forums .module-click:visible").attr("rel");
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
								$("#forums2 .module-click:eq(0)").addClass('active-link');
								$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/forums&request=getForumDetails&fid="+fid+"&id="+id, success: function(text){
									$("#forums-right").html(text.html);
									initForumsContentScrollbar();
									$('#forums2 input.filter').quicksearch('#forums2 li');
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
		/*$.ajax({ type: "GET", url: "/", async: false, data: 'path=apps/forums&request=checkinForum&id='+id, success: function(data){
				if(!data) {
					prompt("something wrong");
				}
			}
		});*/
		return true;
	}


	this.actionRefresh = function() {
		var pid = $("#forums2 .active-link").attr("rel");
		var oid = $("#forums1 .module-click:visible").attr("rel");
		$("#forums2 .active-link:visible").trigger("click");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/forums&request=getForumList&id="+oid, success: function(data){
			$("#forums2 ul").html(data.html);
			var idx = $("#forums2 .module-click").index($("#forums2 .module-click[rel='"+pid+"']"));
			$("#forums2 .module-click:eq("+idx+")").addClass('active-link');
			$('#forums2 input.filter').quicksearch('#forums3 li');
			}
		});
	}


	this.actionPrint = function() {
		var id = $("#forums2 .active-link").attr("rel");
		var url ='/?path=apps/forums&request=printForumDetails&id='+id;
		location.href = url;
	}


	this.actionSend = function() {
		var id = $("#forums2 .active-link").attr("rel");
		$.ajax({ type: "GET", url: "/", data: "path=apps/forums&request=getForumSend&id="+id, success: function(html){
			$("#modalDialogForward").html(html).dialog('open');
			}
		});
	}


	this.actionSendtoResponse = function() {
		var id = $("#forums2 .active-link").attr("rel");
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
			$('#forums2').find('input.filter').quicksearch('#forums2 li');
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
					$("#"+forums.name+"-right").html(text.html);
					initForumsContentScrollbar();
					$('#forums1 input.filter').quicksearch('#forums1 li');
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
					var id = $("#forums1 .active-link").attr("rel");
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
								$("#forums1 .module-click:eq(0)").addClass('active-link');
								$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/forums&request=getFolderDetails&id="+id, success: function(text){
									$("#"+forums.name+"-right").html(text.html);
									initForumsContentScrollbar();
									$('#forums1 input.filter').quicksearch('#forums1 li');
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
		var id = $("#forums1 .active-link").attr("rel");
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
			$('#forums1 input.filter').quicksearch('#forums1 li');
			}
		});
	}


	this.actionPrint = function() {
		var id = $("#forums1 .active-link").attr("rel");
		var url ='/?path=apps/forums&request=printFolderDetails&id='+id;
		location.href = url;
	}


	this.actionSend = function() {
		var id = $("#forums1 .active-link").attr("rel");
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
			$('#forums1 input.filter').quicksearch('#forums1 li');
			var id = $("#forums1 .module-click:eq(0)").attr("rel");
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
	var h = $("#forums .ui-layout-west").height();
	$("#forums1 .module-inner").css("height", h-71);
	$("#forums1 .module-actions").show();
	$("#forums2 .module-actions").hide();
	$("#forums2 li").show();
	$("#forums2").css("height", h-96).removeClass("module-active");
	$("#forums2 .module-inner").css("height", h-96);
	$("#forums3 .module-actions").hide();
	$("#forums3").css("height", h-121);
	$("#forums3 .forums3-content").css("height", h-(forums.modules_height+121));
	$("#forums-current").val("folder");
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
		
		$("#forums1").css("overflow", "auto").animate({height: h-71}, function() {
			$("#forums1 li").show();
			$("#forums1 .sort").attr("rel", data.sort).addClass("sort"+data.sort);
			forumsInnerLayout.initContent('center');
			//initScrollbar( '#forums .scrolling-content' );
			$('#forums1 input.filter').quicksearch('#forums1 li');
			$("#forums3 .forums3-content").hide();
			var id = $("#forums1 .module-click:eq(0)").attr("rel");
			$("#forums1 .module-click:eq(0)").addClass('active-link');
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/forums&request=getFolderDetails&id="+id, success: function(text){
				$("#"+forums.name+"-right").html(text.html);
				forumsInnerLayout.initContent('center');
				$('#forums1 input.filter').quicksearch('#forums1 li');
				$("#forums3 .forums3-content").hide();
				}
			});
		});
	}
	});
}


function forumsresetModuleHeights() {
	
	var h = $("#forums .ui-layout-west").height();
	if($("#forums1").height() != module_title_height) {
		$("#forums1").css("height", h-71);
		$("#forums1 .module-inner").css("height", h-71);
	}
	if($("#forums2").height() != module_title_height) {
		//$("#forums2").css("height", h-96);
		$("#forums2 .module-inner").css("height", h-96);
		$("#forums2").css("overflow", "auto").animate({height: h-(forums.modules_height+96)}, function() {
			$(this).find('.west-ui-content	').height(h-(forums.modules_height+96));																							   
		});
	}
	$("#forums3").css("height", h-121);
	$("#forums3 .forums3-content").css("height", h-(forums.modules_height+121));
	//initScrollbar( '#forums .scrolling-content' );
}

function ForumsModulesDisplay(access) {
	var h = $("#forums .ui-layout-west").height();
	if(access == "guest" || access == "guestadmin") {
		var modLen = forums.GuestHiddenModules.length;
		var m;
		for(var i=0, len=modLen; i<len; ++i) {
			m = $('h3[rel="'+forums.GuestHiddenModules[i]+'"]');
			m.hide();
		}
		forums.modules_height = forums_num_modules*module_title_height - modLen*module_title_height;
		$("#forums3 .forums3-content").css("height", h-(forums.modules_height+121));
	} else {
		var modLen = forums.GuestHiddenModules.length;
		var m;
		for(var i=0, len=modLen; i<len; ++i) {
			m = $('h3[rel="'+forums.GuestHiddenModules[i]+'"]');
			m.show();
		}
		forums.modules_height = forums_num_modules*module_title_height;
		$("#forums3 .forums3-content").css("height", h-(forums.modules_height+121));
	}
}


var forumsLayout, forumsInnerLayout;

$(document).ready(function() {
						   
	if($('#forums').length > 0) {
		forumsLayout = $('#forums').layout({
				west__onresize:				function() { forumsresetModuleHeights() }
			,	resizeWhileDragging:		true
			,	spacing_open:				0
			,	closable: 				false
			,	resizable: 				false
			,	slidable:				false
			, 	west__size:				325
			,	west__closable: 		true
			,	west__resizable: 		true
			, 	south__size:			10
			,	center__onresize: "forumsInnerLayout.resizeAll"
			
		});
		
		forumsInnerLayout = $('#forums div.ui-layout-center').layout({
				center__onresize:				function() {  }
			,	resizeWhileDragging:		false
			,	spacing_open:				0			// cosmetic spacing
			,	closable: 				false
			,	resizable: 				false
			,	slidable:				false
			,	north__paneSelector:	".center-north"
			,	center__paneSelector:	".center-center"
			,	west__paneSelector:	".center-west"
			, 	north__size:			80
			, 	west__size:			50
			 
	
		});
		
		forumsloadModuleStart();
	}

	$("#forums1-outer > h3").click(function(event, passed_id) {
		var obj = getCurrentModule();
		if(confirmNavigation()) {
			formChanged = false;
			$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		}
		var cid = $('#forums input[name="id"]').val()
		obj.checkIn(cid);
		
		if($(this).hasClass("module-bg-active")) {
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
				//initScrollbar( '#forums .scrolling-content' );
				$('#forums1 input.filter').quicksearch('#forums1 li');
				if(passed_id === undefined) {
						var id = $("#forums1 .module-click:eq(0)").attr("rel");
						$("#forums1 .module-click:eq(0)").addClass('active-link');
					} else {
						var id = passed_id;
						$("#forums1 .module-click[rel='"+id+"']").addClass('active-link');
					}
				
				
				//$("#forums1 .drag:eq(0)").show();
				$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/forums&request=getFolderDetails&id="+id, success: function(text){
					$("#forums-right").html(text.html);
					//forumsInnerLayout.initContent('center');
					initForumsContentScrollbar();
					var h = $("#forums .ui-layout-west").height();
					$("#forums1").delay(200).animate({height: h-46}, function() {
						$(this).animate({height: h-71});			 
					});
					}
				 });
				}
			});
		} else {
			var h = $("#forums .ui-layout-west").height();
			var id = $("#forums1 .module-click:visible").attr("rel");
			var index = $("#forums1 .module-click").index($("#forums1 .module-click[rel='"+id+"']"));
			
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
				$('#forums1 input.filter').quicksearch('#forums1 li');
				$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/forums&request=getFolderDetails&id="+id, success: function(text){
					$("#forums1 li").show();
					setModuleActive($("#forums1"),index);
					
					$("#forums1").css("overflow", "auto").animate({height: h-46}, function() {
						$("#"+forums.name+"-right").html(text.html);
						//initScrollbar( '#forums .scrolling-content' );
						$("#forums-current").val("folder");
						setModuleDeactive($("#forums2"),'0');
						setModuleDeactive($("#forums3"),'0');
						$("#forums2 li").show();
						$("#forums2").css("height", h-96).removeClass("module-active");
						$("#forums2").prev("h3").removeClass("white");
						$("#forums2 .module-inner").css("height", h-96);
						$("#forums3 h3").removeClass("module-bg-active");
						$("#forums3 .forums3-content:visible").slideUp();
						initForumsContentScrollbar();
						$("#forums1").delay(200).animate({height: h-71});
					});
					}
				 });
				}
			});
		}
		$("#forums-top .top-headline").html("");
		$("#forums-top .top-subheadline").html("");
		$("#forums-top .top-subheadlineTwo").html("");
		return false;
	});


	$("#forums2-outer > h3").click(function(event, passed_id) {
		var obj = getCurrentModule();
		if(confirmNavigation()) {
			formChanged = false;
			$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		}
		var cid = $('#forums input[name="id"]').val()
		obj.checkIn(cid);
		
		if($(this).hasClass("module-bg-active")) {
			$("#forums1-outer > h3").trigger("click");
		} else {
			if($("#forums2").height() == module_title_height) {
				var h = $("#forums .ui-layout-west").height();
				var id = $("#forums1 .module-click:visible").attr("rel");
				var forumid = $("#forums2 .module-click:visible").attr("rel");
				var index = $("#forums2 .module-click").index($("#forums2 .module-click[rel='"+forumid+"']"));
				$("#forums3 .module-actions:visible").hide();
				$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/forums&request=getForumList&id="+id, success: function(data){
					$("#forums2 ul").html(data.html);
					$("#forumsActions .actionNew").attr("title",data.title);
					
					$("#forums2 li").show();
					setModuleActive($("#forums2"),index);
					$("#forums2 .sort").attr("rel", data.sort).addClass("sort"+data.sort);
					$('#forums2 input.filter').quicksearch('#forums2 li');
					$("#forums2").css("overflow", "auto").animate({height: h-(forums.modules_height+96)}, function() {
					$(this).find('.west-ui-content	').height(h-(forums.modules_height+96));
					$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/forums&request=getForumDetails&id="+forumid, success: function(text){
						$("#forums-right").html(text.html);

						switch (text.access) {
									case "sysadmin":
										if(data.html == "<li></li>") {
											forumsActions(3);
										} else {
											forumsActions(0);
											$('#forums2').find('input.filter').quicksearch('#forums2 li');
										}
									break;
									case "admin":
										if(data.html == "<li></li>") {
											forumsActions(3);
										} else {
											forumsActions(0);
											$('#forums2').find('input.filter').quicksearch('#forums2 li');
										}
									break;
									case "guestadmin":
										if(data.html == "<li></li>") {
											forumsActions(3);
										} else {
											forumsActions(7);
											$('#forums2').find('input.filter').quicksearch('#forums2 li');
										}
									break;
									case "guest":
										if(data.html == "<li></li>") {
											forumsActions();
										} else {
											forumsActions(5);
											$('#forums2').find('input.filter').quicksearch('#forums2 li');
										}
									break;
								}
						initForumsContentScrollbar();
						}
					});
					$("#forums3 h3").removeClass("module-bg-active");
					});
					$(".forums3-content").slideUp();
					}
				});
			} else {
				var id = $("#forums1 .active-link").attr("rel");
				if(id == undefined) {
					return false;
				}
				var index = $("#forums1 .module-click").index($("#forums1 .module-click[rel='"+id+"']"));
				$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/forums&request=getForumList&id="+id, success: function(data){
					$("#forums2 ul").html(data.html);
					$("#forumsActions .actionNew").attr("title",data.title);
					if(passed_id === undefined) {
						var forumid = $("#forums2 .module-click:eq(0)").attr("rel");
					} else {
						var forumid = passed_id;					
					}
				
					if($("#forums1").height() != module_title_height) {
						var idx = $("#forums2 .module-click").index($("#forums2 .module-click[rel='"+forumid+"']"));
						setModuleActive($("#forums2"),idx);
						$("#forums2 .sort").attr("rel", data.sort).addClass("sort"+data.sort);
						setModuleDeactive($("#forums1"),index);
						$("#forums1").css("overflow", "hidden").animate({height: module_title_height}, function() {
							$("#forums-top .top-headline").html($("#forums .module-click:visible").find(".text").html());
							$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/forums&request=getForumDetails&id="+forumid, success: function(text){
								$("#forums-right").html(text.html);

								switch (text.access) {
									case "sysadmin":
										if(data.html == "<li></li>") {
											forumsActions(3);
										} else {
											forumsActions(0);
											$('#forums2').find('input.filter').quicksearch('#forums2 li');
										}
									break;
									case "admin":
										if(data.html == "<li></li>") {
											forumsActions(3);
										} else {
											forumsActions(0);
											$('#forums2').find('input.filter').quicksearch('#forums2 li');
										}
									break;
									case "guestadmin":
										if(data.html == "<li></li>") {
											forumsActions(3);
										} else {
											forumsActions(7);
											$('#forums2').find('input.filter').quicksearch('#forums2 li');
										}
									break;
									case "guest":
										if(data.html == "<li></li>") {
											forumsActions();
										} else {
											forumsActions(5);
											$('#forums2').find('input.filter').quicksearch('#forums2 li');
										}
									break;
								}
								initForumsContentScrollbar();
								var h = $("#forums .ui-layout-west").height();
								if(text.access != "sysadmin") { ForumsModulesDisplay(text.access); }
								$("#forums2").delay(200).animate({height: h-(forums.modules_height+96)}, function() {
									$(this).find('.west-ui-content	').height(h-(forums.modules_height+96));																			  
									});
								}
							});
						});
					} else {
						$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/forums&request=getForumDetails&id="+forumid, success: function(text){
							$("#"+forums.name+"-right").html(text.html);
							initForumsContentScrollbar();
							}
						});
					}
					}
				});
			}
		}
		$("#forums-current").val("forums");
		$("#forums-top .top-subheadline").html("");
		$("#forums-top .top-subheadlineTwo").html("");
		return false;
	});


	$("#forums1 .module-click").live('click',function(e) {
		if($(this).hasClass("deactivated")) {
			$("#forums1-outer > h3").trigger("click");
			return false;
		}
		var obj = getCurrentModule();
		if(confirmNavigation()) {
			formChanged = false;
			$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		}
		var cid = $('#forums input[name="id"]').val()
		obj.checkIn(cid);
		
		var id = $(this).attr("rel");
		var index = $("#forums .module-click").index(this);
		$("#forums .module-click").removeClass("active-link");
		$(this).addClass("active-link");

		var h = $("#forums .ui-layout-west").height();
		$("#forums1").delay(200).animate({height: h-46}, function() {
			$(this).animate({height: h-71});
		});
			
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/forums&request=getFolderDetails&id="+id, success: function(text){
			$("#forums-right").html(text.html);
			forumsInnerLayout.initContent('center');
			if(text.access == "guest") {
					forumsActions();
				} else {
					forumsActions(9);
				}
			}
		});
		
		return false;
	});


	$("#forums2 .module-click").live('click',function(e) {
		if($(this).hasClass("deactivated")) {
			$("#forums2-outer > h3").trigger("click");
			return false;
		}
		var obj = getCurrentModule();
		if(confirmNavigation()) {
			formChanged = false;
			$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		}
		var cid = $('#forums input[name="id"]').val()
		obj.checkIn(cid);
		
		var fid = $("#forums .module-click:visible").attr("rel");
		var id = $(this).attr("rel");
		var index = $("#forums .module-click").index(this);
		$("#forums .module-click").removeClass("active-link");
		$(this).addClass("active-link");
		$("#forums-top .top-headline").html($("#forums .module-click:visible").find(".text").html());
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/forums&request=getForumDetails&fid="+fid+"&id="+id, success: function(text){
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
			
			var h = $("#forums .ui-layout-west").height();
			$("#forums2").delay(200).animate({height: h-96}, function() {
				if(text.access != "sysadmin") { ForumsModulesDisplay(text.access); }
				$(this).animate({height: h-(forums.modules_height+96)}, function() {
				$(this).find('.west-ui-content	').height(h-(forums.modules_height+96));									   
				});			 
			});
			
			}
			
		});
		return false;
	});


	$("#forums3 .module-click").live('click',function() {
		var obj = getCurrentModule();
		if(confirmNavigation()) {
			formChanged = false;
			$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		}
		var cid = $('#forums input[name="id"]').val()
		obj.checkIn(cid);
		
		var id = $(this).attr("rel");
		var ulidx = $("#forums3 ul").index($(this).parents("ul"));
		var index = $("#forums3 ul:eq("+ulidx+") .module-click").index($("#forums3 ul:eq("+ulidx+") .module-click[rel='"+id+"']"));
		$("#forums3 .module-click").removeClass("active-link");
		$(this).addClass("active-link");
		
		var obj = getCurrentModule();
		var list = 0;
		obj.getDetails(ulidx,index,list);
		 return false;
	});


	$("#forums3 h3").click(function(event, passed_id) {
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
			if($("#forums2").height() == module_title_height) {
				var id = $("#forums2 .module-click:visible").attr("rel");
				$("#forums3 h3").removeClass("module-bg-active");
				
				h3click.addClass("module-bg-active")
					.next('div').slideDown( function() {
						$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/forums/modules/"+module+"&request=getList&id="+id, success: function(data){
							$("#forums3 ul:eq("+moduleidx+")").html(data.html);
							$("#forumsActions .actionNew").attr("title",data.title);
							switch (data.perm) {
				case "sysadmin": case "admin" :
					if(data.html == "<li></li>") {
						forumsActions(3);
					} else {
						forumsActions(0);
						$('#forums3').find('input.filter').quicksearch('#forums3 li');
					}
				break;
				case "guest":
					if(data.html == "<li></li>") {
						forumsActions();
					} else {
						forumsActions(5);
						$('#forums3').find('input.filter').quicksearch('#forums3 li');
					}
				break;
			}
							
							
							if(passed_id === undefined) {
								var idx = 0;
							} else {
								var idx = $("#forums3 ul:eq("+moduleidx+") .module-click").index($("#forums3 ul:eq("+moduleidx+") .module-click[rel='"+passed_id+"']"));
							}

							$("#forums3 ul:eq("+moduleidx+") .module-click:eq("+idx+")").addClass('active-link');
							$("#forums3 .module-actions:visible").hide();
							var obj = getCurrentModule();
							obj.getDetails(moduleidx,idx,data.html);
							$(this).prev("h3").removeClass("module-bg-active");	
							$("#forums3 .module-actions:eq("+moduleidx+")").show();
							$("#forums3 .sort:eq("+moduleidx+")").attr("rel", data.sort).addClass("sort"+data.sort);
							}
						});			 
					})
					.siblings('div:visible').slideUp()
				
			} else {
				// load and slide up module 3
				var id = $("#forums2 .active-link").attr("rel");
				if(id == undefined) {
					return false;
				}
				var index = $("#forums2 .module-click").index($("#forums2 .module-click[rel='"+id+"']"));
	
				$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/forums/modules/"+module+"&request=getList&id="+id, success: function(data){
					$("#forums3 ul:eq("+moduleidx+")").html(data.html);
					$("#forumsActions .actionNew").attr("title",data.title);
					switch (data.perm) {
				case "sysadmin": case "admin" :
					if(data.html == "<li></li>") {
						forumsActions(3);
					} else {
						forumsActions(0);
						$('#forums3').find('input.filter').quicksearch('#forums3 li');
					}
				break;
				case "guest":
					if(data.html == "<li></li>") {
						forumsActions();
					} else {
						forumsActions(5);
						$('#forums3').find('input.filter').quicksearch('#forums3 li');
					}
				break;
			}
					
					
					if(passed_id === undefined) {
						var idx = 0;
					} else {
						var idx = $("#forums3 ul:eq("+moduleidx+") .module-click").index($("#forums3 ul:eq("+moduleidx+") .module-click[rel='"+passed_id+"']"));
					}
					
					$("#forums3 ul:eq("+moduleidx+") .module-click:eq("+idx+")").addClass('active-link');
					$("#forums3 .module-actions:visible").hide();
					setModuleDeactive($("#forums2"),index);
					$("#forums2").css("overflow", "hidden").animate({height: module_title_height}, function() {
						$("#forums-top .top-subheadline").html($("#forums2 .module-click:visible").find(".text").html());
						/*$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/forums&request=getDates&id="+id, success: function(data){
							$("#forums-top .top-subheadlineTwo").html(data.startdate + ' - <span id="forumenddate">' + data.enddate + '</span>');
						}
						});*/
					});
					h3click.addClass("module-bg-active")
						.next('div').slideDown(function() {
							var obj = getCurrentModule();
							obj.getDetails(moduleidx,idx,data.html);
							$("#forums3 .sort:eq("+moduleidx+")").attr("rel", data.sort).addClass("sort"+data.sort);
							$("#forums3 .module-actions:eq("+moduleidx+")").show();
						})
					}
				});
			}
			$("#forums-current").val(module);
		}
		return false;
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
		var id = $("#forums2 .active-link:visible").attr("rel");
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