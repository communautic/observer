/* forums Object */
function brainstormsForums(name) {
	this.name = name;
	
	
	this.formProcess = function(formData, form, poformOptions) {
		var title = $("#brainstorms input.title").fieldValue();
		if(title == "") {
			$.prompt(ALERT_NO_TITLE, {callback: setTitleFocus});
			return false;
		} else {
			formData[formData.length] = { "name": "title", "value": title };
		}
		
		var text = $('#brainstormsReplyText').html();
		for (var i=0; i < formData.length; i++) { 
			if (formData[i].name == 'text') { 
				formData[i].value = text;
			} 
		} 
		formData[formData.length] = processListApps('forum_status');	 
	}
	
	
	this.formResponse = function(data) {
		switch(data.action) {
			case "edit":
				$("#brainstorms3 span[rel='"+data.id+"'] .text").html($("#brainstorms .title").val());
				/*$("#brainstormsforumstartdate").html(data.startdate);
				$("#brainstormsforumenddate").html(data.enddate);*/
				/*var pid = $('#brainstorms2 .module-click:visible').attr("rel");
				$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/brainstorms&request=getDates&id="+pid, success: function(brainstorm){
						$("#brainstormenddate").html(brainstorm.enddate);
					}
				});*/
				//var num  = $("#brainstorms3 .active-link .forum_num").html();
				/*switch(data.access) {
					case "0":
						$("#brainstorms3 .active-link .module-access-status").removeClass("module-access-active");
					break;
					case "1":
						$("#brainstorms3 .active-link .module-access-status").addClass("module-access-active");
					break;
				}*/
				switch(data.status) {
					case "2":
						$("#brainstorms3 .active-link .module-item-status").addClass("module-item-active");
					break;
					default:
						$("#brainstorms3 .active-link .module-item-status").removeClass("module-item-active");
				}
			break;
		}	
	}
	
	
	this.poformOptions = { beforeSubmit: this.formProcess, dataType: 'json', success: this.formResponse };
	
	
	this.getDetails = function(moduleidx,liindex,list) {
		var forumid = $("#brainstorms3 ul:eq("+moduleidx+") .module-click:eq("+liindex+")").attr("rel");
		//var num = $("#brainstorms3 ul:eq("+moduleidx+") .forum_num:eq("+liindex+")").html();
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/brainstorms/modules/forums&request=getDetails&id="+forumid, success: function(data){
			$("#brainstorms-right").html(data.html);
			if($('#checkedOut').length > 0) {
					$("#brainstorms3 .active-link:visible .icon-checked-out").addClass('icon-checked-out-active');
				} else {
					$("#brainstorms3 .active-link:visible .icon-checked-out").removeClass('icon-checked-out-active');
				}
			if(list == 0) {
				switch (data.access) {
					case "sysadmin": case "admin":
						brainstormsActions(0);
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
							brainstormsActions(0);
							$('#brainstorms3').find('input.filter').quicksearch('#brainstorms3 li');
						}
					break;
					case "guest":
						if(list == "<li></li>") {
							brainstormsActions();
						} else {
							brainstormsActions(5);
							$('#brainstorms3').find('input.filter').quicksearch('#brainstorms3 li');
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
		var id = $('#brainstorms2 .module-click:visible').attr("rel");
		$.ajax({ type: "GET", url: "/", dataType: 'json', data: 'path=apps/brainstorms/modules/forums&request=createNew&id=' + id, cache: false, success: function(data){
			var pid = $("#brainstorms2 .module-click:visible").attr("rel");
				$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/brainstorms/modules/forums&request=getList&id="+pid, success: function(ldata){
					$(".brainstorms3-content:visible ul").html(ldata.html);
					var liindex = $(".brainstorms3-content:visible .module-click").index($(".brainstorms3-content:visible .module-click[rel='"+data.id+"']"));
					$(".brainstorms3-content:visible .module-click:eq("+liindex+")").addClass('active-link');
					var moduleidx = $(".brainstorms3-content").index($(".brainstorms3-content:visible"));
					module.getDetails(moduleidx,liindex);
					$('#brainstorms3 input.filter').quicksearch('#brainstorms3 li');
					//update Brainstorm Enddate
					/*$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/brainstorms&request=getDates&id="+pid, success: function(brainstorm){
							$("#brainstormenddate").html(brainstorm.enddate);
						}
					});*/
					}
				});
			}
		});
	}


	this.actionDuplicate = function() {
		var module = this;
		var cid = $('#brainstorms input[name="id"]').val()
		module.checkIn(cid);
		var id = $("#brainstorms3 .active-link:visible").attr("rel");
		var pid = $("#brainstorms2 .module-click:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", data: 'path=apps/brainstorms/modules/forums&request=createDuplicate&id=' + id, cache: false, success: function(forumid){
			$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/brainstorms/modules/forums&request=getList&id="+pid, success: function(data){																																																																				
				$(".brainstorms3-content:visible ul").html(data.html);
				var moduleidx = $(".brainstorms3-content").index($(".brainstorms3-content:visible"));
				var liindex = $(".brainstorms3-content:visible .module-click").index($(".brainstorms3-content:visible .module-click[rel='"+forumid+"']"));
				module.getDetails(moduleidx,liindex);
				$(".brainstorms3-content:visible .module-click:eq("+liindex+")").addClass('active-link');
				brainstormsActions(0);
				$('#brainstorms3 input.filter').quicksearch('#brainstorms3 li');
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
					var id = $("#brainstorms3 .active-link:visible").attr("rel");
					var pid = $("#brainstorms2 .module-click:visible").attr("rel");
					$.ajax({ type: "GET", url: "/", data: "path=apps/brainstorms/modules/forums&request=binForum&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/brainstorms/modules/forums&request=getList&id="+pid, success: function(data){
								$(".brainstorms3-content:visible ul").html(data.html);
								if(data.html == "<li></li>") {
									brainstormsActions(3);
								} else {
									brainstormsActions(0);
									$('#brainstorms3 input.filter').quicksearch('#brainstorms3 li');
								}
								var moduleidx = $(".brainstorms3-content").index($(".brainstorms3-content:visible"));
								var liindex = 0;
								module.getDetails(moduleidx,liindex);
								$("#brainstorms3 .brainstorms3-content:visible .module-click:eq("+liindex+")").addClass('active-link');
								//update Brainstorm Enddate
								$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/brainstorms&request=getDates&id="+pid, success: function(brainstorm){
										$("#brainstormenddate").html(brainstorm.enddate);
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
		$.ajax({ type: "GET", url: "/", async: false, data: 'path=apps/brainstorms/modules/forums&request=checkinForum&id='+id, success: function(data){
			if(!data) {
				prompt("something wrong");
			}
			}
		});
	}


	this.actionRefresh = function() {
		var id = $("#brainstorms3 .active-link:visible").attr("rel");
		var pid = $("#brainstorms2 .module-click:visible").attr("rel");
		$("#brainstorms3 .active-link:visible").trigger("click");
		var id = $("#brainstorms3 .active-link:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/brainstorms/modules/forums&request=getList&id="+pid, success: function(data){																																																																				
			$(".brainstorms3-content:visible ul").html(data.html);
			var liindex = $(".brainstorms3-content:visible .module-click").index($(".brainstorms3-content:visible .module-click[rel='"+id+"']"));
			$(".brainstorms3-content:visible .module-click:eq("+liindex+")").addClass('active-link');
			$('#brainstorms3 input.filter').quicksearch('#brainstorms3 li');
			}
		});
	}


	this.actionPrint = function() {
		var id = $("#brainstorms3 .active-link:visible").attr("rel");
		var num = $("#brainstorms3 .active-link:visible").find(".forum_num").html();
		var url ='/?path=apps/brainstorms/modules/forums&request=printDetails&id='+id+"&num="+num;
		location.href = url;
	}


	this.actionSend = function() {
		var id = $("#brainstorms3 .active-link:visible").attr("rel");
		var num = $("#brainstorms3 .active-link:visible").find(".forum_num").html();
		$.ajax({ type: "GET", url: "/", data: "path=apps/brainstorms/modules/forums&request=getSend&id="+id+"&num="+num, success: function(html){
			$("#modalDialogForward").html(html).dialog('open');
			}
		});
	}


	this.actionSendtoResponse = function() {
		var id = $("#brainstorms3 .active-link:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", data: "path=apps/brainstorms/modules/forums&request=getSendtoDetails&id="+id, success: function(html){
			$("#brainstorms_forum_sendto").html(html);
			$("#modalDialogForward").dialog('close');
			}
		});
	}


	this.sortclick = function (obj,sortcur,sortnew) {
		var module = this;
		var cid = $('#brainstorms input[name="id"]').val()
		module.checkIn(cid);
		var fid = $("#brainstorms2 .module-click:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/brainstorms/modules/forums&request=getList&id="+fid+"&sort="+sortnew, success: function(data){
			$(".brainstorms3-content:visible ul").html(data.html);
			obj.attr("rel",sortnew);
			obj.removeClass("sort"+sortcur).addClass("sort"+sortnew);
			var id = $(".brainstorms3-content:visible .module-click:eq(0)").attr("rel");
			if(id == undefined) {
				return false;
			}
			var moduleidx = $(".brainstorms3-content").index($(".brainstorms3-content:visible"));
			var liindex = 0;
			module.getDetails(moduleidx,liindex);
			$("#brainstorms3 .brainstorms3-content:visible .module-click:eq("+liindex+")").addClass('active-link');
			}
		});
	}


	this.sortdrag = function (order) {
		var fid = $("#brainstorms2 .module-click:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", data: "path=apps/brainstorms/modules/forums&request=setOrder&"+order+"&id="+fid, success: function(html){
			$("#brainstorms3 .sort:visible").attr("rel", "3");
			$("#brainstorms3 .sort:visible").removeClass("sort1").removeClass("sort2").addClass("sort3");
			}
		});	
	}


	this.actionDialog = function(offset,request,field,append,title,sql) {
		switch(request) {
			case "getForumTaskDialog":
				$.ajax({ type: "GET", url: "/", data: 'path=apps/brainstorms/modules/forums&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
					$("#modalDialog").html(html);
					$("#modalDialog").dialog('option', 'position', offset);
					$("#modalDialog").dialog('option', 'title', title);
					$("#modalDialog").dialog('open');
					}
				});
			break;
			case "getForumStatusDialog":
				$.ajax({ type: "GET", url: "/", data: 'path=apps/brainstorms/modules/forums&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
					$("#modalDialog").html(html);
					$("#modalDialog").dialog('option', 'position', offset);
					$("#modalDialog").dialog('option', 'title', title);
					$("#modalDialog").dialog('open');
					}
				});
			break;
			case "getTasksDialog":
				$.ajax({ type: "GET", url: "/", data: 'path=apps/brainstorms/modules/forums&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
					$("#modalDialog").html(html);
					$("#modalDialog").dialog('option', 'position', offset);
					$("#modalDialog").dialog('option', 'title', title);
					$("#modalDialog").dialog('open');
					}
				});
			break;
			case "getDocumentsDialog":
				var id = $("#brainstorms2 .module-click:visible").attr("rel");
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



	this.insertStatusDate = function(rel,text) {
		var module = this;
		var html = '<div class="listmember" field="brainstormsforum_status" uid="'+rel+'" style="float: left">' + text + '</div>';
		$("#brainstormsforum_status").html(html);
		$("#modalDialog").dialog("close");
		$("#brainstormsforum_status").nextAll('img').trigger('click');
	}


	this.insertItem = function(id,text,replyid) {
		var num = $('#brainstormsPosts .forumouter').size()+1;
		$.ajax({ type: "POST", url: "/", dataType:  'json', data: "path=apps/brainstorms/modules/forums&request=addItem&id=" + id + "&text=" + text + "&replyid=" + replyid + "&num=" + num, success: function(data){
				if(replyid == 0) {
					var prev = '<div id="postouter_' + data.itemid + '" class="parent" style="border-top: 1px solid #77713D">';
					var last = '</div><div style="height: 20px;"></div>';
					$("#brainstormsPosts").append(prev + data.html + last);
				} else {
					var prev = '<div id="postouter_' + data.itemid + '" style="margin-left: 15px">';
					var last = '</div>';
					var postouter = $("#postouter_"+replyid);
					postouter.append(prev + data.html + last);
					$("#post_"+replyid).find('.icon-delete').toggleClass('icon-delete').toggleClass('icon-delete-inactive')
					$("#post_"+replyid).find('.binItem').addClass('deactivated');
				}
				var element = $("#post_"+data.itemid+" .cbx");
				$.jNice.CheckAddPO(element);
				$("#modalDialogBrainstormsPost").slideUp(function() {		
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/brainstorms/modules/forums&request=binItem&id=" + id, success: function(data){
						if(data){
							$("#postouter_"+id).slideUp(function(){ 
								if($(this).siblings().size() == 1) {
								$(this).prev().find('.icon-delete-inactive').toggleClass('icon-delete').toggleClass('icon-delete-inactive');
								$(this).prev().find('.binItem').removeClass('deactivated');

								}
								if($(this).hasClass('parent')) {
									$(this).next().remove();
								}
								$(this).remove();
								//var pst = $(".task_start:first").val();
								//var pen = $(".task_start:last").val();
								//$("#brainstormsforumstartdate").html(pst);
								//$("#brainstormsforumenddate").html(pen);
							});
						} 
						}
					});
				} 
			}
		});	
	}


	// dependencies
	this.actionCheckDepTasks = function() {
		return true;
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/brainstorms/modules/forums&request=deleteForum&id=" + id, cache: false, success: function(data){
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/brainstorms/modules/forums&request=restoreForum&id=" + id, cache: false, success: function(data){
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/brainstorms/modules/forums&request=deleteForumTask&id=" + id, cache: false, success: function(data){
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/brainstorms/modules/forums&request=restoreForumTask&id=" + id, cache: false, success: function(data){
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

var brainstorms_forums = new brainstormsForums('brainstorms_forums');

$(document).ready(function() {
	
	$("#brainstormsReplyText").livequery(function() {	 
		var postReply = $(this);
		$.getScript("tiny_mce/jquery.tinymce.js", function(){
			postReply.tinymce({
			script_url : 'tiny_mce/tiny_mce_gzip.php',
			doctype: '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">',
			theme : "advanced",
			skin : "coBlue",
			language: "de",
			entity_encoding : "raw",
        plugins : "emotions,inlinepopups,paste,directionality,noneditable,visualchars,nonbreaking,xhtmlxtras",
			force_br_newlines: false,
			force_p_newlines: true,
			theme_advanced_buttons1 : "bold,italic,underline,strikethrough,emotions",
			theme_advanced_buttons2 : "",
			theme_advanced_buttons3 : "",
			theme_advanced_buttons4 : "",
			//theme_advanced_buttons1 : "save,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
        	//theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,code,|,forecolor,backcolor",
       		// theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
       // theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
	   		//theme_advanced_buttons4 : "visualchars,nonbreaking,template,pagebreak",
        	theme_advanced_toolbar_location : "top",
       theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "none",
			content_css : "tiny_mce/editor.content.css"
		});
																				 })
	})
	
	
	/*$("#modalDialogBrainstormsPost").livequery( function() {
		$(this).resizable({ handles: 'n' });
	});*/
	
	$("a.postBrainstormsReply").live("click", function(e) {
		e.preventDefault();
		var rel = $(this).attr("rel");
		$("#modalDialogBrainstormsPost").slideDown(function() {
			$("#brainstormsReplyID").val(rel);
			$("#brainstormsReplyText").focus();	
			$('#brainstorms-right .ui-layout-content').height($('#brainstorms-right .ui-layout-content').height()-99)
							initBrainstormsContentScrollbar();								

		});
		
	});
	
	
	$("#modalDialogBrainstormsPostClose").live("click", function(e) {
		e.preventDefault();
		$("#modalDialogBrainstormsPost").slideUp(function() {		
					initBrainstormsContentScrollbar();									
		});
	});
	
	
	$("span.actionBrainstormsReply").live("click", function(e) {
		e.preventDefault();
		var id = $("#brainstorms3 .active-link:visible").attr("rel");
		var text = $("#brainstormsReplyText").val();
		if(text == "") {
			$.prompt(ALERT_FORUM_RESPONSE_EMPTY);
			return false;
		}
		var replyid = $("#brainstormsReplyID").val();
		brainstorms_forums.insertItem(id,text,replyid);
	});
	
	
	$("div.brainstormsPostToggle").live("click", function(e) {
		e.preventDefault();
		var id = $(this).attr("id").replace(/post-toggle-/, "");
		var outer = $('#postouter_'+id);
		var height = outer.height();
		if(height == 20) {
			$(this).find('span').addClass("icon-toggle-post").removeClass("icon-toggle-post-active");
			outer.removeClass('toggeled')
				.animate({
					height: outer.data('h')
  					}, function() { 
					
					$(this).css('height','auto');
				});
		} else {
			$(this).find('span').addClass("icon-toggle-post-active").removeClass("icon-toggle-post");
			outer.data('h', outer.height());
			outer
				.animate({
					height: 20
  					}).addClass('toggeled')
		}
	});

	
})