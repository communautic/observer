/* forums Object */
function complaintsForums(name) {
	this.name = name;


	this.formProcess = function(formData, form, poformOptions) {
		var title = $("#complaints input.title").fieldValue();
		if(title == "") {
			$.prompt(ALERT_NO_TITLE, {callback: setTitleFocus});
			return false;
		} else {
			formData[formData.length] = { "name": "title", "value": title };
		}

		formData[formData.length] = processListApps('forum_access');
		//formData[formData.length] = processListApps('forum_status');
	 }
	 
	 
	 this.formResponse = function(data) {
		 switch(data.action) {
			case "edit":
				$("#complaints3 ul[rel=forums] span[rel="+data.id+"] .text").html($("#complaints .title").val());
					switch(data.access) {
						case "0":
							$("#complaints3 ul[rel=forums] span[rel="+data.id+"] .module-access-status").removeClass("module-access-active");
						break;
						case "1":
							$("#complaints3 ul[rel=forums] span[rel="+data.id+"] .module-access-status").addClass("module-access-active");
						break;
					}
					switch(data.status) {
						case "2":
							$("#complaints3 ul[rel=forums] span[rel="+data.id+"] .module-item-status").addClass("module-item-active").removeClass("module-item-active-stopped");
						break;
						case "3":
							$("#complaints3 ul[rel=forums] span[rel="+data.id+"] .module-item-status").addClass("module-item-active-stopped").removeClass("module-item-active");
						break;
						default:
							$("#complaints3 ul[rel=forums] span[rel="+data.id+"] .module-item-status").removeClass("module-item-active").removeClass("module-item-active-stopped");
					}
					
					
			break;
		}
	}

	
	this.poformOptions = { async: false, beforeSubmit: this.formProcess, dataType: 'json', success: this.formResponse };


	this.statusOnClose = function(dp) {
		var id = $("#complaints").data("third");
		var status = $("#complaints .statusTabs li span.active").attr('rel');
		var date = $("#complaints .statusTabs input").val();
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/complaints/modules/forums&request=updateStatus&id=" + id + "&date=" + date + "&status=" + status, cache: false, success: function(data){
			switch(data.status) {
					case "2":
						$("#complaints3 ul[rel=forums] span[rel="+data.id+"] .module-item-status").addClass("module-item-active").removeClass("module-item-active-stopped");
					break;
					case "3":
						$("#complaints3 ul[rel=forums] span[rel="+data.id+"] .module-item-status").addClass("module-item-active-stopped").removeClass("module-item-active");
					break;
					default:
						$("#complaints3 ul[rel=forums] span[rel="+data.id+"] .module-item-status").removeClass("module-item-active").removeClass("module-item-active-stopped");
				}		
			}
		});
	}


	this.getDetails = function(moduleidx,liindex,list) {
		var id = $("#complaints3 ul:eq("+moduleidx+") .module-click:eq("+liindex+")").attr("rel");
		$('#complaints').data({ "third" : id});
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/complaints/modules/forums&request=getDetails&id="+id, success: function(data){
			$("#complaints-right").html(data.html);
			
			if(list == 0) {
				switch (data.access) {
					case "sysadmin": case "admin":
						complaintsActions(0);
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
							complaintsActions(0);
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
		$.ajax({ type: "GET", url: "/", dataType: 'json', data: 'path=apps/complaints/modules/forums&request=createNew&id=' + id, cache: false, success: function(data){
			$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/complaints/modules/forums&request=getList&id="+id, success: function(list){
				$("#complaints3 ul[rel=forums]").html(list.html);
				$('#complaints_forums_items').html(list.items);
				var liindex = $("#complaints3 ul[rel=forums] .module-click").index($("#complaints3 ul[rel=forums] .module-click[rel='"+data.id+"']"));
				$("#complaints3 ul[rel=forums] .module-click:eq("+liindex+")").addClass('active-link');
				var moduleidx = $("#complaints3 ul").index($("#complaints3 ul[rel=forums]"));
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
		$.ajax({ type: "GET", url: "/", data: 'path=apps/complaints/modules/forums&request=createDuplicate&id=' + id, cache: false, success: function(mid){
			$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/complaints/modules/forums&request=getList&id="+pid, success: function(data){																																																																				
				$("#complaints3 ul[rel=forums]").html(data.html);
				$('#complaints_forums_items').html(data.items);
				var moduleidx = $("#complaints3 ul").index($("#complaints3 ul[rel=forums]"));
				var liindex = $("#complaints3 ul[rel=forums] .module-click").index($("#complaints3 ul[rel=forums] .module-click[rel='"+mid+"']"));
				module.getDetails(moduleidx,liindex);
				$("#complaints3 ul[rel=forums] .module-click:eq("+liindex+")").addClass('active-link');
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/complaints/modules/forums&request=binForum&id=" + id, cache: false, success: function(data){
							if(data == "true") {
								$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/complaints/modules/forums&request=getList&id="+pid, success: function(data){
									$("#complaints3 ul[rel=forums]").html(data.html);
									$('#complaints_forums_items').html(data.items);
									if(data.html == "<li></li>") {
										complaintsActions(3);
									} else {
										complaintsActions(0);
									}
									var moduleidx = $("#complaints3 ul").index($("#complaints3 ul[rel=forums]"));
									var liindex = 0;
									module.getDetails(moduleidx,liindex);
									$("#complaints3 ul[rel=forums] .module-click:eq("+liindex+")").addClass('active-link');
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
		var id = $("#complaints").data("third");
		var pid = $("#complaints").data("second");
		$("#complaints3 ul[rel=forums] .active-link").trigger("click");
		$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/complaints/modules/forums&request=getList&id="+pid, success: function(data){																																																																				
			$("#complaints3 ul[rel=forums]").html(data.html);
			$('#complaints_forums_items').html(data.items);
			var liindex = $("#complaints3 ul[rel=forums] .module-click").index($("#complaints3 ul[rel=forums] .module-click[rel='"+id+"']"));
			$("#complaints3 ul[rel=forums] .module-click:eq("+liindex+")").addClass('active-link');
			}
		});
	}


	this.actionPrint = function() {
		var id = $("#complaints").data("third");
		var url ='/?path=apps/complaints/modules/forums&request=printDetails&id='+id;
		$("#documentloader").attr('src', url);
	}


	this.actionSend = function() {
		var id = $("#complaints").data("third");
		$.ajax({ type: "GET", url: "/", data: "path=apps/complaints/modules/forums&request=getSend&id="+id, success: function(html){
			$("#modalDialogForward").html(html).dialog('open');
			}
		});
	}


	this.actionSendtoResponse = function() {
		var id = $("#complaints").data("third");
		$.ajax({ type: "GET", url: "/", data: "path=apps/complaints/modules/forums&request=getSendtoDetails&id="+id, success: function(html){
			$("#complaintsforum_sendto").html(html);
			$("#modalDialogForward").dialog('close');
			}
		});
	}
	
	
	this.sortclick = function (obj,sortcur,sortnew) {
		var module = this;
		var cid = $('#complaints input[name="id"]').val()
		module.checkIn(cid);
		
		var fid = $("#complaints2 .module-click:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/complaints/modules/forums&request=getList&id="+fid+"&sort="+sortnew, success: function(data){
			$("#complaints3 ul[rel=forums]").html(data.html);
			$('#complaints_forums_items').html(data.items);
			obj.attr("rel",sortnew);
			obj.removeClass("sort"+sortcur).addClass("sort"+sortnew);
			var id = $("#complaints3 ul[rel=forums] .module-click:eq(0)").attr("rel");
			$('#complaints').data('third',id);
			if(id == undefined) {
				return false;
			}
			var moduleidx = $("#complaints3 ul").index($("#complaints3 ul[rel=forums]"));
			module.getDetails(moduleidx,0);
			$("#complaints3 ul[rel=forums] .module-click:eq(0)").addClass('active-link');
		}
		});
	}


	this.sortdrag = function (order) {
		var fid = $("#complaints").data("second");
		$.ajax({ type: "GET", url: "/", data: "path=apps/complaints/modules/forums&request=setOrder&"+order+"&id="+fid, success: function(html){
			$("#complaints3 .sort:visible").attr("rel", "3");
			$("#complaints3 .sort:visible").removeClass("sort1").removeClass("sort2").addClass("sort3");
			}
		});
	}


	this.actionDialog = function(offset,request,field,append,title,sql) {
		switch(request) {
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
			case "getForumStatusDialog":
				$.ajax({ type: "GET", url: "/", data: 'path=apps/complaints/modules/forums&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
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
		var html = '<div class="listmember" field="complaintsforum_status" uid="'+rel+'" style="float: left">' + text + '</div>';
		$("#complaintsforum_status").html(html);
		$("#modalDialog").dialog("close");
		$("#complaintsforum_status").next().val("");
		$('#complaints .coform').ajaxSubmit(module.poformOptions);
	}


	this.insertStatusDate = function(rel,text) {
		var html = '<div class="listmember" field="complaintsforum_status" uid="'+rel+'" style="float: left">' + text + '</div>';
		$("#complaintsforum_status").html(html);
		$("#modalDialog").dialog("close");
		$("#complaintsforum_status").nextAll('img').trigger('click');
	}


	this.newItem = function() {
		var mid = $("#complaints").data("third");
		var num = parseInt($("#complaints-right .task_sort").size());
		$.ajax({ type: "GET", url: "/", data: "path=apps/complaints/modules/forums&request=addTask&mid=" + mid + "&num=" + num + "&sort=" + num, success: function(html){
			$('#complaintsforumtasks').append(html);
			var idx = parseInt($('.cbx').size() -1);
			var element = $('.cbx:eq('+idx+')');
			$.jNice.CheckAddPO(element);
			$('.forumouter:eq('+idx+')').slideDown(function() {
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
				$.ajax({ type: "GET", url: "/", data: "path=apps/complaints/modules/forums&request=binItem&id=" + id, success: function(data){
						if(data){
							$("#complaintsForumsPostouter_"+id).slideUp(function(){ 
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
	
	this.actionHelp = function() {
		var url = "/?path=apps/complaints/modules/forums&request=getHelp";
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/complaints/modules/forums&request=deleteForum&id=" + id, cache: false, success: function(data){
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/complaints/modules/forums&request=restoreForum&id=" + id, cache: false, success: function(data){
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/complaints/modules/forums&request=deleteItem&id=" + id, cache: false, success: function(data){
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/complaints/modules/forums&request=restoreItem&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#forum_task_'+id).slideUp();
						}
					}
					});
				} 
			}
		});
	}
	
	
	this.openReplyWindow= function(id) {
		/*$("#modalDialogComplaintsForumsPost").slideDown(function() {
			$(this).find('.forumsReplyID').val(id);
			$(this).find('.forumsReplyText').focus();
			$('#complaints-right .ui-layout-content').height($('#complaints-right .ui-layout-content').height()-99)
			initComplaintsContentScrollbar();
		})*/
		
		var dia = $("#modalDialogComplaintsForumsPost");
		if(dia.is(':visible')) {
			dia.slideUp(function() {
				initComplaintsContentScrollbar();	
				dia.slideDown(function() {
					dia.find('.forumsReplyID').val(id);
					dia.find('.forumsReplyText').focus();
					$('#complaints-right .ui-layout-content').height($('#complaints-right .ui-layout-content').height()-99)
					initComplaintsContentScrollbar();								
				});
			});
		} else {
			dia.slideDown(function() {
				$(this).find('.forumsReplyID').val(id);
			$(this).find('.forumsReplyText').focus();
			$('#complaints-right .ui-layout-content').height($('#complaints-right .ui-layout-content').height()-99)
			initComplaintsContentScrollbar();								
			});
		}
		
		
	}
	
	
	this.closeReplyWindow = function(id) {
		$("#modalDialogComplaintsForumsPost").slideUp(function() {		
			initComplaintsContentScrollbar();								
		});
	}
	
	this.postReply = function(id) {
		var id = $("#complaints").data('third');
		var w = $("#modalDialogComplaintsForumsPost");
		var text = w.find(".forumsReplyText").val();
		if(text == "") {
			$.prompt(ALERT_FORUM_RESPONSE_EMPTY);
			return false;
		}
		var replyid = w.find(".forumsReplyID").val();
		this.insertItem(id,text,replyid);
	}
	
	
	this.insertItem = function(id,text,replyid) {
		var num = $('#complaintsForumsPosts .forumouter').size()+1;
		$.ajax({ type: "POST", url: "/", dataType:  'json', data: { path: 'apps/complaints/modules/forums', request: 'addItem', id: id, text: text, replyid: replyid, num: num }, success: function(data){
				if(replyid == 0) {
					var prev = '<div id="complaintsForumsPostouter_' + data.itemid + '" class="parent" style="border-top: 1px solid #77713D">';
					var last = '</div><div style="height: 20px;"></div>';
					$("#complaintsForumsPosts").append(prev + data.html + last);
				} else {
					var prev = '<div id="complaintsForumsPostouter_' + data.itemid + '" style="margin-left: 15px">';
					var last = '</div>';
					var postouter = $("#complaintsForumsPostouter_"+replyid);
					postouter.append(prev + data.html + last);
					$("#complaintsForumsPost_"+replyid).find('.icon-delete').toggleClass('icon-delete').toggleClass('icon-delete-inactive')
					$("#complaintsForumsPost_"+replyid).find('.binItem').addClass('deactivated');
				}
				var element = $("#complaintsForumsPost_"+data.itemid+" .cbx");
				$.jNice.CheckAddPO(element);
				$("#modalDialogComplaintsForumsPost").slideUp(function() {		
					initComplaintsContentScrollbar();
				});
			}
		});
	}

	this.togglePost = function(id,obj) {
		var outer = $('#complaintsForumsPostouter_'+id);
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

var complaints_forums = new complaintsForums('complaints_forums');

$(document).ready(function() {
	$("#complaints-right .forumsReplyText").livequery(function() {	 
		var postReply = $(this);
		$.getScript("tiny_mce/jquery.tinymce.js", function(){
			postReply.tinymce({
			script_url : 'tiny_mce/tiny_mce_gzip.php',
			doctype: '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">',
			theme : "advanced",
			skin : "coGrey",
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

});