function initForumsContentScrollbar() {
	forumsInnerLayout.initContent('center');
}

/* forums Object */
function forumsApplication(name) {
	this.name = name;
	
	this.init = function() {
		this.$app = $('#forums');
		this.$appContent = $('#forums-right');
		this.$first = $('#forums1');
		this.$second = $('#forums2');
		this.$third = $('#forums3');
		this.$thirdDiv = $('#forums3 div.thirdLevel');
		this.$layoutWest = $('#forums div.ui-layout-west');
	}
	
	this.formProcess = function(formData, form, poformOptions) {
		var title = $("#forums input.title").fieldValue();
		if(title == "") {
			$.prompt(ALERT_NO_TITLE, {submit: setTitleFocus});
			return false;
		} else {
			formData[formData.length] = { "name": "title", "value": title };
		}
	
		formData[formData.length] = processListApps('folder');
		//formData[formData.length] = processListApps('status');
	}

	
	this.formResponse = function(data) {
		switch(data.action) {
			case "edit":
				$("#forums2 span[rel='"+data.id+"'] .text").html($("#forums .title").val());
				//$("#durationStart").html($("input[name='startdate']").val());
				/*switch(data.status) {
					case "2":
						$("#forums2 span[rel='"+data.id+"'] .module-item-status").addClass("module-item-active").removeClass("module-item-active-stopped");
					break;
					case "3":
						$("#forums2 span[rel='"+data.id+"'] .module-item-status").addClass("module-item-active-stopped").removeClass("module-item-active");
					break;
					default:
						$("#forums2 span[rel='"+data.id+"'] .module-item-status").removeClass("module-item-active").removeClass("module-item-active-stopped");
				}*/
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


	this.statusOnClose = function(dp) {
		var id = $("#forums").data("second");
		var status = $("#forums .statusTabs li span.active").attr('rel');
		var date = $("#forums .statusTabs input").val();
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/forums&request=updateStatus&id=" + id + "&date=" + date + "&status=" + status, cache: false, success: function(data){
				switch(data.status) {
					case "2":
						$("#forums2 span[rel='"+data.id+"'] .module-item-status").addClass("module-item-active").removeClass("module-item-active-stopped");
					break;
					case "3":
						$("#forums2 span[rel='"+data.id+"'] .module-item-status").addClass("module-item-active-stopped").removeClass("module-item-active");
					break;
					default:
						$("#forums2 span[rel='"+data.id+"'] .module-item-status").removeClass("module-item-active").removeClass("module-item-active-stopped");
				}																																 			}
		});
	}


	this.actionClose = function() {
		forumsLayout.toggle('west');
	}


	this.getNavModulesNumItems = function(id) {
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: 'path=apps/forums&request=getNavModulesNumItems&id=' + id, success: function(data){
				$.each( data, function(k, v){
   					$('#'+k).html(v);
 				});
			}
		});
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
					module.getNavModulesNumItems(data.id);
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
		var cid = $('#forums input[name="id"]').val()
		module.checkIn(cid);
		var txt = ALERT_DELETE;
		var langbuttons = {};
		langbuttons[ALERT_YES] = true;
		langbuttons[ALERT_NO] = false;
		$.prompt(txt,{ 
			buttons:langbuttons,
			submit: function(e,v,m,f){		
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
								if(typeof id == 'undefined') {
									$("#forums").data("second", 0);
								} else {
									$("#forums").data("second", id);
								}
								$("#forums2 .module-click:eq(0)").addClass('active-link');
								$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/forums&request=getForumDetails&fid="+fid+"&id="+id, success: function(text){
									$("#forums-right").html(text.html);
									initForumsContentScrollbar();
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
		$("#documentloader").attr('src', url);
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
			//$("#modalDialogForward").dialog('close');
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
			submit: function(e,v,m,f){		
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
			submit: function(e,v,m,f){		
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
			submit: function(e,v,m,f){		
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
			submit: function(e,v,m,f){		
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
			submit: function(e,v,m,f){		
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


	this.datepickerOnClose = function(dp) {
		var obj = getCurrentModule();
		$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
	}


	this.togglePost = function(id,obj) {
		var outer = $('#forumsPostouter_'+id);
		var height = outer.height();
		if(height == 22) {
			obj.find('span').addClass("icon-toggle-post").removeClass("icon-toggle-post-active");
			outer.removeClass('toggeled')
				.animate({height: outer.data('h')}, function() { 
					$(this).css('height','auto');
				});
		} else {
			obj.find('span').addClass("icon-toggle-post-active").removeClass("icon-toggle-post");
			outer.data('h', outer.height());
			outer.animate({height: 22}).addClass('toggeled')
		}
	}

}

var forums = new forumsApplication('forums');
//forums.resetModuleHeights = forumsresetModuleHeights;
forums.modules_height = forums_num_modules*module_title_height;
forums.GuestHiddenModules = new Array("access");

// register folder object
function forumsFolders(name) {
	this.name = name;
	
	
	this.formProcess = function(formData, form, poformOptions) {
		var title = $("#forums input.title").fieldValue();
		if(title == "") {
			$.prompt(ALERT_NO_TITLE, {submit: setTitleFocus});
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
			submit: function(e,v,m,f){		
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
								if(typeof id == 'undefined') {
									$("#forums").data("first",0);
								} else {
									$("#forums").data("first",id);
								}
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
		$("#documentloader").attr('src', url);
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
			//$("#modalDialogForward").dialog('close');
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
			submit: function(e,v,m,f){		
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
			submit: function(e,v,m,f){		
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
		case 0: actions = ['0','1','2','3','5','6','7']; break;
		//case 1: 	actions = ['0','1','2','4']; break; 	// no duplicate
		case 1: actions = ['0','5','6','7']; break;
		//case 2: 	actions = ['1']; break;   					// just save
		case 3: 	actions = ['0','5','6']; break;   					// just new
		case 4: 	actions = ['0','1','2','5','6']; break;   		// new, print, send, handbook, refresh
		case 5: 	actions = ['1','2','5','6']; break;   			// print, send, refresh
		case 6: 	actions = ['5','6']; break;   			// handbook refresh
		case 7: 	actions = ['0','1','2','5','6']; break;   			// new, print, send, refresh
		case 8: 	actions = ['1','2','5','6']; break;   			// print, send, handbook, refresh
		case 9:		actions = ['0','1','2','5','6','7']; break;
		case 10: 	actions = ['0','1','2','3','4','5','6','7']; break;
		case 11: 	actions = ['1','2','4','5','6']; break; 
		default: 	actions = ['5','6'];  								// none
	}
	$('#forumsActions > li span').each( function(index) {
		if(index in oc(actions)) {
			$(this).removeClass('noactive');
		} else {
			$(this).addClass('noactive');
		}
	})
}


var forumsLayout, forumsInnerLayout;

$(document).ready(function() {
	
	forums.init();
	
	if($('#forums').length > 0) {
		forumsLayout = $('#forums').layout({
				west__onresize:				function() { resetModuleHeightsnavThree('forums'); }
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

		loadModuleStartnavThree('forums');
	}


	$("#forums1-outer").on('click', 'h3', function(e, passed_id) {
		e.preventDefault();
		navThreeTitleFirst('forums',$(this),passed_id)
		prevent_dblclick(e)
	}).disableSelection();


	$("#forums2-outer").on('click', 'h3', function(e, passed_id) {
		e.preventDefault();
		navThreeTitleSecond('forums',$(this),passed_id)
		prevent_dblclick(e)
	}).disableSelection();


	$("#forums3").on('click', 'h3', function(e, passed_id) {
		e.preventDefault();
		navThreeTitleThird('forums',$(this),passed_id)
		prevent_dblclick(e)
	}).disableSelection();


	$('#forums1').on('click', 'span.module-click',function(e) {
		e.preventDefault();
		navItemFirst('forums',$(this))
		prevent_dblclick(e)
	});


	$('#forums2').on('click', 'span.module-click',function(e) {
		e.preventDefault();
		navItemSecond('forums',$(this))
		prevent_dblclick(e)
	});


	$('#forums3').on('click', 'span.module-click',function(e) {
		e.preventDefault();
		navItemThird('forums',$(this))
		prevent_dblclick(e)
	});


	$(document).on('click', 'a.insertForumFolderfromDialog', function(e) {
		e.preventDefault();
		var field = $(this).attr("field");
		var gid = $(this).attr("gid");
		var title = $(this).attr("title");
		var obj = getCurrentModule();
		obj.insertFolderFromDialog(field,gid,title);
	});
	
	
	
// INTERLINKS FROM Content
	
	// load a forum
	$(document).on('click', '.loadForum', function(e) {
		e.preventDefault();		
		var obj = getCurrentModule();
		if(confirmNavigation()) {
			formChanged = false;
			$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		}
		var id = $(this).attr("rel");
		$("#forums2-outer > h3").trigger('click', [id]);
	});


	$("#forumsReplyText").livequery(function() {	 
		var postReply = $(this);
		$.getScript("tiny_mce/jquery.tinymce.js", function(){
			postReply.tinymce({
			script_url : 'tiny_mce/tiny_mce_gzip.php',
			doctype: '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">',
			theme : "advanced",
			skin : "coBlue",
			language: co_lang,
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


	$(document).on('click', 'a.postForumsReply', function(e) {
		e.preventDefault();
		var rel = $(this).attr('rel');
		if($("#modalDialogForumsPost").is(':visible')) {
			$("#modalDialogForumsPost").slideUp(function() {
				initForumsContentScrollbar();
				$("#modalDialogForumsPost").slideDown(function() {
					$("#forumsReplyID").val(rel);
					$("#forumsReplyText").focus();
					$('#forums-right .ui-layout-content').height($('#forums-right .ui-layout-content').height()-99)
					initForumsContentScrollbar();								
				});
			});
		} else {
			$("#modalDialogForumsPost").slideDown(function() {
				$("#forumsReplyID").val(rel);
				$("#forumsReplyText").focus();
				$('#forums-right .ui-layout-content').height($('#forums-right .ui-layout-content').height()-99)
				initForumsContentScrollbar();								
			});
		}
	});


	$(document).on('click', '#modalDialogForumsPostClose', function(e) {
		e.preventDefault();
		$("#modalDialogForumsPost").slideUp(function() {		
			initForumsContentScrollbar();									
		});
	});


	$(document).on('click', 'span.actionForumsReply', function(e) {
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


	/*$(document).on('click', 'div.forumsPostToggle', function(e) {
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
	});*/

});