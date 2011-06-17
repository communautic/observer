/* documents Object */
function projectsDocuments(name) {
	this.name = name;
	
	
	this.createUploader = function(ele){            
		var did = $("#projects3 .active-link:visible").attr("rel");
		var num = 0;
		var numdocs = 0;
		var uploader = new qq.FileUploader({
			element: ele[0],
			template: '<table cellspacing="0" cellpadding="0" border="0" class="table-content"><tr><td class="tcell-left text11"><div class="qq-uploader">' + 
					'<div class="qq-upload-button">' + FILE_BROWSE + '</div></td><td class="tcell-right"></td></tr></table>' +
					'<div style="position: relative;">' +
					'<div class="qq-upload-drop-area"><span>' + FILE_DROP_AREA + '</span></div>' +
					'<div class="qq-upload-list" id="documents"></div></div>' + 
				 '</div>',
			fileTemplate: '<span class="doclist-outer">' +
					'<span class="qq-upload-file docitem" style="line-height: 15px;"></span><br />' +
					'<span class="qq-upload-spinner"></span>' +
					'<span class="qq-upload-size"></span>' +
					'<a class="qq-upload-cancel" href="#" style="line-height: 15px;">' + UPLOAD_CANCEL + '</a>' +
					'<span class="qq-upload-failed-text">Failed</span>' +
				'</span>',
			action: '/',
			sizeLimit: 50*1024*1024, // max size
			params: {
				path: 'classes/file_uploader',
				request: 'createNew',
				did: did
			},
			onSubmit: function(id, fileName){},
			onProgress: function(id, fileName, loaded, total){},
			onComplete: function(id, fileName, data){
				
				numdocs = $(".doclist-outer").size();
				num = num+1;
				if(num == numdocs) {
					$("#projects3 .active-link:visible").trigger("click");
				}
			},
			onCancel: function(id, fileName){
				},
			debug: false
		});    
	}


	this.formProcess = function(formData, form, poformOptions) {
		var title = $("#projects .title").fieldValue();
		if(title == "") {
			$.prompt(ALERT_NO_TITLE, {callback: setTitleFocus});
			return false;
		} else {
			formData[formData.length] = { "name": "title", "value": title };
		}
		
		formData[formData.length] = processList('document_access');
	 }
 

	 this.formResponse = function(data) {
		 switch(data.action) {
			case "edit":
				var module = getCurrentModule();
				$("#projects3 span[rel='"+data.id+"'] .text").html($("#projects .title").val());
				var moduleidx = $(".projects3-content").index($(".projects3-content:visible"));
				var liindex = $(".projects3-content:visible .module-click").index($(".projects3-content:visible .module-click[rel='"+data.id+"']"));
				module.getDetails(moduleidx,liindex);
				switch(data.access) {
					case "0":
						$("#projects3 .active-link .module-access-status").removeClass("module-access-active");
					break;
					case "1":
						$("#projects3 .active-link .module-access-status").addClass("module-access-active");
					break;
				}
			break;
		}
	}


 	this.formSerialize = function(formData, form, poformOptions) {
		var title = $("#projects .title").val();
		if(title == "") {
			$.prompt(ALERT_NO_TITLE, {callback: setTitleFocus});
			return false;
		} else {
			formData[formData.length] = { "name": "title", "value": title };
		}
	}


	this.poformOptions = { beforeSerialize: this.formSerialize, beforeSubmit: this.formProcess, dataType:  'json', success: this.formResponse };


	this.getDetails = function(moduleidx,liindex,list) {
		var id = $("#projects3 ul:eq("+moduleidx+") .module-click:eq("+liindex+")").attr("rel");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects/modules/documents&request=getDetails&id="+id, success: function(data){
			$("#projects-right").html(data.html);
			if(list == 0) {
				switch (data.access) {
					case "sysadmin": case "admin":
						projectsActions(0);
					break;
					case "guest":
						projectsActions(5);
					break;
				}
			} else {
				switch (data.access) {
					case "sysadmin": case "admin" :
						if(list == "<li></li>") {
							projectsActions(3);
						} else {
							projectsActions(0);
							$('#projects3').find('input.filter').quicksearch('#projects3 li');
						}
					break;
					case "guest":
						if(list == "<li></li>") {
							projectsActions();
						} else {
							projectsActions(5);
							$('#projects3').find('input.filter').quicksearch('#projects3 li');
						}
					break;
				}
				
			}
			initProjectsContentScrollbar();
			}
		});
	}


	this.actionNew = function() {	
		var module = this;
		var id = $('#projects2 .module-click:visible').attr("rel");
		$.ajax({ type: "GET", url: "/", dataType: 'json', data: 'path=apps/projects/modules/documents&request=createNew&id=' + id, cache: false, success: function(data){
			var pid = $("#projects2 .module-click:visible").attr("rel");
			$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/projects/modules/documents&request=getList&id="+pid, success: function(ldata){
				$(".projects3-content:visible ul").html(ldata.html);
				var liindex = $(".projects3-content:visible .module-click").index($(".projects3-content:visible .module-click[rel='"+data.id+"']"));
				$(".projects3-content:visible .module-click:eq("+liindex+")").addClass('active-link');
				var moduleidx = $(".projects3-content").index($(".projects3-content:visible"));
				module.getDetails(moduleidx,liindex);
				projectsActions(0);
				$('#projects3 input.filter').quicksearch('#projects3 li');
				}
			});
			}
		});
	}


	this.actionDuplicate = function() {
		var module = this;
		var id = $("#projects3 .active-link:visible").attr("rel");
		var pid = $("#projects2 .module-click:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", data: 'path=apps/projects/modules/documents&request=createDuplicate&id=' + id, cache: false, success: function(did){
			$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/projects/modules/documents&request=getList&id="+pid, success: function(data){																																																																				
				$(".projects3-content:visible ul").html(data.html);
				var moduleidx = $(".projects3-content").index($(".projects3-content:visible"));
				var liindex = $(".projects3-content:visible .module-click").index($(".projects3-content:visible .module-click[rel='"+did+"']"));
				module.getDetails(moduleidx,liindex);
				$(".projects3-content:visible .module-click:eq("+liindex+")").addClass('active-link');
				projectsActions(0);
				$('#projects3 input.filter').quicksearch('#projects3 li');
				}
			});
			}
		});
	}
	
	
	this.actionBin = function() {
		var module = this;
		var txt = ALERT_DELETE;
		var langbuttons = {};
		langbuttons[ALERT_YES] = true;
		langbuttons[ALERT_NO] = false;
		$.prompt(txt,{ 
			buttons:langbuttons,
			callback: function(v,m,f){		
				if(v){
					var id = $("#projects3 .active-link:visible").attr("rel");
					var pid = $("#projects2 .module-click:visible").attr("rel");
					$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/documents&request=binDocument&id=" + id, cache: false, success: function(data){
							if(data == "true") {
								$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/projects/modules/documents&request=getList&id="+pid, success: function(data){
								$(".projects3-content:visible ul").html(data.html);
								var moduleidx = $(".projects3-content").index($(".projects3-content:visible"));
								var liindex = 0;
								module.getDetails(moduleidx,liindex);
								$("#projects3 .projects3-content:visible .module-click:eq("+liindex+")").addClass('active-link');
								projectsActions(0);
								$('#projects3 input.filter').quicksearch('#projects3 li');
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
		$("#projects3 .active-link:visible").trigger("click");
	}
	
	
	this.actionPrint = function() {
		var id = $("#projects3 .active-link:visible").attr("rel");
		var url ='/?path=apps/projects/modules/documents&request=printDetails&id='+id;
		location.href = url;
	}


	this.actionSend = function() {
		var id = $("#projects3 .active-link:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/documents&request=getSend&id="+id, success: function(html){
			$("#modalDialogForward").html(html).dialog('open');
			}
		});
	}


	this.actionSendtoResponse = function() {
		var id = $("#projects3 .active-link:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/documents&request=getSendtoDetails&id="+id, success: function(html){
			$("#document_sendto").html(html);
			$("#modalDialogForward").dialog('close');
			}
		});
	}


	this.sortclick = function (obj,sortcur,sortnew) {
		var module = this;
		var fid = $("#projects2 .module-click:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects/modules/documents&request=getList&id="+fid+"&sort="+sortnew, success: function(data){
			$(".projects3-content:visible ul").html(data.html);
			obj.attr("rel",sortnew);
			obj.removeClass("sort"+sortcur).addClass("sort"+sortnew);
			var id = $(".projects3-content:visible .module-click:eq(0)").attr("rel");
			if(id == undefined) {
				return false;
			}
			var moduleidx = $(".projects3-content").index($(".projects3-content:visible"));
			var liindex = 0;
			module.getDetails(moduleidx,liindex);
			$("#projects3 .projects3-content:visible .module-click:eq("+liindex+")").addClass('active-link');
			}
		});
	}
	
	
	this.sortdrag = function (order) {
		var fid = $("#projects2 .module-click:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/documents&request=setOrder&"+order+"&id="+fid, success: function(html){
			$("#projects3 .sort:visible").attr("rel", "3");
			$("#projects3 .sort:visible").removeClass("sort1").removeClass("sort2").addClass("sort3");
			}
		});
	}


	this.actionDialog = function(offset,request,field,append,title,sql) {
		$.ajax({ type: "GET", url: "/", data: 'path=apps/projects&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
			$("#modalDialog").html(html);
			$("#modalDialog").dialog('option', 'position', offset);
			$("#modalDialog").dialog('option', 'title', title);
			$("#modalDialog").dialog('open');
			}
		});	
	}


	this.showItemContext = function(ele,uid,field) {
		$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/documents&request=getDocContext&id="+uid+"&field="+field, success: function(html){
			ele.parent().append(html);
			ele.next().slideDown();
			}
		});
	}
	
	
	this.downloadDocument = function(id) {
		var url = "/?path=apps/projects/modules/documents&request=downloadDocument&id=" + id;
		$("#documentloader").attr('src', url);
	}


	this.insertItem = function(field,append,id,text) {
		var html = '<span class="docitems-outer"><a href="projects_documents" class="showItemContext" uid="' + id + '" field="' + field + '">' + text + '</a></span>';
		if(append == 0) {
			$("#"+field).html(html);
			$("#modalDialog").dialog('close');
		} else {
			if($("#"+field).html() != "") {
				$("#"+field+" .showItemContext:visible:last").append(", ");
				$("#"+field).append(html);
			} else {
				$("#"+field).append(html);
			}
		}
		var obj = getCurrentModule();
		$('#projects .coform').ajaxSubmit(obj.poformOptions);
	}


	this.removeItem = function(clicked,field) {
		clicked.parent().fadeOut();
		clicked.parent().prev().toggleClass('deletefromlist');
		clicked.parents(".docitems-outer").hide();
		if($("#"+field+" .docitems-outer:visible").length > 0) {
		var text = $("#"+field+" .docitems-outer:visible:last .showItemContext").html();
		var textnew = text.split(", ");
		$("#"+field+" .docitems-outer:visible:last .showItemContext").html(textnew[0]);
		}
		var obj = getCurrentModule();
		$('#projects .coform').ajaxSubmit(obj.poformOptions);
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/documents&request=binDocItem&id=" + id, success: function(data){
						if(data){
							$("#doc_"+id).slideUp(function(){ 
								$(this).remove();
							});
						} 
						}
					});
				} 
			}
		});
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/documents&request=deleteDocument&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#document_'+id).slideUp();
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/documents&request=restoreDocument&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#document_'+id).slideUp();
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/documents&request=deleteFile&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#file_'+id).slideUp();
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/documents&request=restoreFile&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#file_'+id).slideUp();
						}
					}
					});
				} 
			}
		});
	}

}
var projects_documents = new projectsDocuments('projects_documents');
//var projects_documents = new Module('projects_documents');
//projects_documents.path = 'apps/projects/modules/documents/';
//projects_documents.getDetails = getDetailsDocument;
//projects_documents.sortclick = sortClickDocument;
//projects_documents.sortdrag = sortDragDocument;
//projects_documents.actionDialog = dialogDocument;
//projects_documents.actionNew = newDocument;
//projects_documents.actionPrint = printDocument;
//projects_documents.actionSend = sendDocument;
//projects_documents.actionSendtoResponse = sendDocumentResponse;
//projects_documents.actionDuplicate = duplicateDocument;
//projects_documents.actionRefresh = refreshDocument;
//projects_documents.actionBin = binDocument;
//projects_documents.checkIn = checkInDocument;
//projects_documents.poformOptions = { beforeSerialize: documentSerialize, beforeSubmit: documentFormProcess, dataType:  'json', success: documentFormResponse };


/*function processDocList(list) {
	var items = $("#"+list+" .showItemContext").size();
	var itemlist = "";
	$("#"+list+" .showItemContext").each( function(i) {
		if ( $(this).hasClass("deletefromlist") ) {
			itemlist += "";
		} else if ( $(this).hasClass("addtolist") ) {
			itemlist += $(this).attr("uid") + ",";
		} else {
			itemlist += $(this).attr("uid") + ",";
		}
		if(items-1 == i) {
		itemlist = itemlist.slice(0, -1)
		}
	})									
	return { "name": list, "value": itemlist };
}*/


/*function getDetailsDocument(moduleidx,liindex,list) {
	var id = $("#projects3 ul:eq("+moduleidx+") .module-click:eq("+liindex+")").attr("rel");
	$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects/modules/documents&request=getDetails&id="+id, success: function(data){
		$("#projects-right").html(data.html);
		if(list == 0) {
			switch (data.access) {
				case "sysadmin": case "admin":
					projectsActions(0);
				break;
				case "guest":
					projectsActions(5);
				break;
			}
		} else {
			switch (data.access) {
				case "sysadmin": case "admin" :
					if(list == "<li></li>") {
						projectsActions(3);
					} else {
						projectsActions(0);
						$('#projects3').find('input.filter').quicksearch('#projects3 li');
					}
				break;
				case "guest":
					if(list == "<li></li>") {
						projectsActions();
					} else {
						projectsActions(5);
						$('#projects3').find('input.filter').quicksearch('#projects3 li');
					}
				break;
			}
			
		}
		initProjectsContentScrollbar();
		}
	});
}*/

/*function documentSerialize(formData, form, poformOptions) {
	var title = $("#projects .title").val();
	if(title == "") {
		$.prompt(ALERT_NO_TITLE, {callback: setTitleFocus});
		return false;
	} else {
		formData[formData.length] = { "name": "title", "value": title };
	}
}*/


/*function documentFormProcess(formData, form, poformOptions) {
	var title = $("#projects .title").fieldValue();
	if(title == "") {
		$.prompt(ALERT_NO_TITLE, {callback: setTitleFocus});
		return false;
	} else {
		formData[formData.length] = { "name": "title", "value": title };
	}
	
	formData[formData.length] = processList('document_access');
}*/


/*function documentFormResponse(data) {
	switch(data.action) {
		case "edit":
			$("#projects3 span[rel='"+data.id+"'] .text").html($("#projects .title").val());
			var moduleidx = $(".projects3-content").index($(".projects3-content:visible"));
			var liindex = $(".projects3-content:visible .module-click").index($(".projects3-content:visible .module-click[rel='"+data.id+"']"));
			getDetailsDocument(moduleidx,liindex);
			switch(data.access) {
				case "0":
					$("#projects3 .active-link .module-access-status").removeClass("module-access-active");
				break;
				case "1":
					$("#projects3 .active-link .module-access-status").addClass("module-access-active");
				break;
			}
		break;
	}
}*/


/*function newDocument() {
	var id = $('#projects2 .module-click:visible').attr("rel");
	$.ajax({ type: "GET", url: "/", dataType: 'json', data: 'path=apps/projects/modules/documents&request=createNew&id=' + id, cache: false, success: function(data){
		var pid = $("#projects2 .module-click:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/projects/modules/documents&request=getList&id="+pid, success: function(ldata){
			$(".projects3-content:visible ul").html(ldata.html);
			var liindex = $(".projects3-content:visible .module-click").index($(".projects3-content:visible .module-click[rel='"+data.id+"']"));
			$(".projects3-content:visible .module-click:eq("+liindex+")").addClass('active-link');
			var moduleidx = $(".projects3-content").index($(".projects3-content:visible"));
			getDetailsDocument(moduleidx,liindex);
			projectsActions(0);
			$('#projects3 input.filter').quicksearch('#projects3 li');
			}
		});
		}
	});
}*/


/*function printDocument() {
	var id = $("#projects3 .active-link:visible").attr("rel");
	var url ='/?path=apps/projects/modules/documents&request=printDetails&id='+id;
	location.href = url;
}


function sendDocument() {
	var id = $("#projects3 .active-link:visible").attr("rel");
	$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/documents&request=getSend&id="+id, success: function(html){
		$("#modalDialogForward").html(html).dialog('open');
		}
	});
}

function sendDocumentResponse() {
	var id = $("#projects3 .active-link:visible").attr("rel");
	$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/documents&request=getSendtoDetails&id="+id, success: function(html){
		$("#document_sendto").html(html);
		$("#modalDialogForward").dialog('close');
		}
	});
}*/


/*function duplicateDocument() {
	var id = $("#projects3 .active-link:visible").attr("rel");
	var pid = $("#projects2 .module-click:visible").attr("rel");
	$.ajax({ type: "GET", url: "/", data: 'path=apps/projects/modules/documents&request=createDuplicate&id=' + id, cache: false, success: function(did){
		$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/projects/modules/documents&request=getList&id="+pid, success: function(data){																																																																				
			$(".projects3-content:visible ul").html(data.html);
			var moduleidx = $(".projects3-content").index($(".projects3-content:visible"));
			var liindex = $(".projects3-content:visible .module-click").index($(".projects3-content:visible .module-click[rel='"+did+"']"));
			getDetailsDocument(moduleidx,liindex);
			$(".projects3-content:visible .module-click:eq("+liindex+")").addClass('active-link');
			projectsActions(0);
			$('#projects3 input.filter').quicksearch('#projects3 li');
			}
		});
		}
	});
}*/


/*function refreshDocument() {
	$("#projects3 .active-link:visible").trigger("click");
}*/

/*function binDocument() {
	var txt = ALERT_DELETE;
	var langbuttons = {};
	langbuttons[ALERT_YES] = true;
	langbuttons[ALERT_NO] = false;
	$.prompt(txt,{ 
		buttons:langbuttons,
		callback: function(v,m,f){		
			if(v){
				var id = $("#projects3 .active-link:visible").attr("rel");
				var pid = $("#projects2 .module-click:visible").attr("rel");
				$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/documents&request=binDocument&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/projects/modules/documents&request=getList&id="+pid, success: function(data){
							$(".projects3-content:visible ul").html(data.html);
							var moduleidx = $(".projects3-content").index($(".projects3-content:visible"));
							var liindex = 0;
							getDetailsDocument(moduleidx,liindex);
							$("#projects3 .projects3-content:visible .module-click:eq("+liindex+")").addClass('active-link');
							projectsActions(0);
							$('#projects3 input.filter').quicksearch('#projects3 li');
							}
						});
						}
					}
				});
			} 
		}
	});
}*/


/*function checkInDocument() {
	return true;
}*/

/*function sortClickDocument(obj,sortcur,sortnew) {
	var fid = $("#projects2 .module-click:visible").attr("rel");
	$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects/modules/documents&request=getList&id="+fid+"&sort="+sortnew, success: function(data){
		$(".projects3-content:visible ul").html(data.html);
		obj.attr("rel",sortnew);
		obj.removeClass("sort"+sortcur).addClass("sort"+sortnew);
		var id = $(".projects3-content:visible .module-click:eq(0)").attr("rel");
		if(id == undefined) {
			return false;
		}
		var moduleidx = $(".projects3-content").index($(".projects3-content:visible"));
		var liindex = 0;
		getDetailsDocument(moduleidx,liindex);
		$("#projects3 .projects3-content:visible .module-click:eq("+liindex+")").addClass('active-link');
		}
	});
}*/


/*function sortDragDocument(order) {
	var fid = $("#projects2 .module-click:visible").attr("rel");
	$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/documents&request=setOrder&"+order+"&id="+fid, success: function(html){
		$("#projects3 .sort:visible").attr("rel", "3");
		$("#projects3 .sort:visible").removeClass("sort1").removeClass("sort2").addClass("sort3");
		}
	});
}*/


/*function dialogDocument(offset,request,field,append,title,sql) {
	$.ajax({ type: "GET", url: "/", data: 'path=apps/projects&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
			$("#modalDialog").html(html);
			$("#modalDialog").dialog('option', 'position', offset);
			$("#modalDialog").dialog('option', 'title', title);
			$("#modalDialog").dialog('open');
			}
		});
}*/


/*function addTaskDocument() {
	var startdate = $("input[name='startdate']").val();
	var enddate = $("input[name='enddate']").val();
	var num = parseInt($("#projects-right .tasks-entry").size());
	$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/documents&request=insertTask&startdate=" + startdate + "&enddate=" + enddate + "&num=" + num, success: function(html){
		$('#documenttasks').append(html);
		var idx = parseInt($('.cbx').size() -1);
		var element = $('.cbx:eq('+idx+')');
		$.jNice.CheckAddPO(element);
		$('.documentouter:eq('+idx+')').slideDown(function() {
			initProjectsContentScrollbar();								   
		});
		 }
	});
}*/

/*function createUploader(ele){            
	var did = $("#projects3 .active-link:visible").attr("rel");
	var num = 0;
	var numdocs = 0;
	var uploader = new qq.FileUploader({
		element: ele[0],
		template: '<table cellspacing="0" cellpadding="0" border="0" class="table-content"><tr><td class="tcell-left text11"><div class="qq-uploader">' + 
                '<div class="qq-upload-button">' + FILE_BROWSE + '</div></td><td class="tcell-right"></td></tr></table>' +
				'<div style="position: relative;">' +
				'<div class="qq-upload-drop-area"><span>' + FILE_DROP_AREA + '</span></div>' +
                '<div class="qq-upload-list" id="documents"></div></div>' + 
             '</div>',
		fileTemplate: '<span class="doclist-outer">' +
				'<span class="qq-upload-file docitem" style="line-height: 15px;"></span><br />' +
                '<span class="qq-upload-spinner"></span>' +
                '<span class="qq-upload-size"></span>' +
				'<a class="qq-upload-cancel" href="#" style="line-height: 15px;">' + UPLOAD_CANCEL + '</a>' +
                '<span class="qq-upload-failed-text">Failed</span>' +
            '</span>',
		action: '/',
		sizeLimit: 50*1024*1024, // max size
		params: {
			path: 'classes/file_uploader',
			request: 'createNew',
			did: did
		},
		onSubmit: function(id, fileName){},
		onProgress: function(id, fileName, loaded, total){},
		onComplete: function(id, fileName, data){
			
			numdocs = $(".doclist-outer").size();
			num = num+1;
			if(num == numdocs) {
				$("#projects3 .active-link:visible").trigger("click");
			}
		},
		onCancel: function(id, fileName){
			},
        debug: false
	});    
}*/


//$(document).ready(function() { 		
	/*$(".document-uploader").livequery(function() {
		createUploader($(this));
	})*/


	/*$('a.downloadDocument').live("click", function(){
		var id = $(this).attr("rel");
		var url = "/?path=apps/projects/modules/documents&request=downloadDocument&id=" + id;
		$("#documentloader").attr('src', url);
		return false;
	});*/


	/*$('a.insertDocumentfromDialog').live('click',function() {
		var field = $(this).attr("field");
		var append = $(this).attr("append");
		var id = $(this).attr("did");
		var text = $(this).html();
		var html = '<span class="docitems-outer"><a href="projects_documents" class="showItemContext" uid="' + id + '" field="' + field + '">' + text + '</a></span>';
		if(append == 0) {
			$("#"+field).html(html);
			$("#modalDialog").dialog('close');
		} else {
			if($("#"+field).html() != "") {
				$("#"+field+" .showItemContext:visible:last").append(", ");
				$("#"+field).append(html);
			} else {
				$("#"+field).append(html);
			}
		}
		var obj = getCurrentModule();
		$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		return false;
	});*/


	/*$('.docitemRelated').live('click',function() {
		var ele = $(this);
		var uid = $(this).attr('uid');
		var field = $(this).attr('field');
		$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/documents&request=getDocContext&id="+uid+"&field="+field, success: function(html){
			ele.parent().append(html);
			ele.next().slideDown();
			}
		});
		return false;
	});*/


	/*$('a.removeItem').livequery('click',function() {
		var field = $(this).attr('field');
		$(this).parent().fadeOut();
		$(this).parent().prev().toggleClass('deletefromlist');
		$(this).parents(".docitems-outer").hide();
		if($("#"+field+" .docitems-outer:visible").length > 0) {
		var text = $("#"+field+" .docitems-outer:visible:last .docitemRelated").html();
		var textnew = text.split(", ");
		$("#"+field+" .docitems-outer:visible:last .docitemRelated").html(textnew[0]);
		}
		var obj = getCurrentModule();
		$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		return false;
	});*/
	
	
	
	/*$('.deleteDoc').livequery('click',function() {
		var id = $(this).attr('rel');
		var txt = ALERT_DELETE;
		var langbuttons = {};
		langbuttons[ALERT_YES] = true;
		langbuttons[ALERT_NO] = false;
		$.prompt(txt,{ 
			buttons:langbuttons,
			callback: function(v,m,f){		
				if(v){
					$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/documents&request=binDocItem&id=" + id, success: function(data){
						if(data){
							$("#doc_"+id).slideUp(function(){ 
									$(this).remove();
							});
						} 
						}
					});
				} 
			}
		});
	});*/


// Recycle bin functions

	
	/*$(".bin-deleteDocumentFolder").live('click',function(e) {
		var id = $(this).attr("rel");
		var txt = ALERT_DELETE_REALLY;
		var langbuttons = {};
		langbuttons[ALERT_YES] = true;
		langbuttons[ALERT_NO] = false;
		$.prompt(txt,{ 
			buttons:langbuttons,
			callback: function(v,m,f){		
				if(v){
					$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/documents&request=deleteDocument&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#document_'+id).slideUp();
						}
					}
					});
				} 
			}
		});
		return false;
	});*/
	
	/*$(".bin-restoreDocumentFolder").live('click',function(e) {
		var id = $(this).attr("rel");
		var txt = ALERT_RESTORE;
		var langbuttons = {};
		langbuttons[ALERT_YES] = true;
		langbuttons[ALERT_NO] = false;
		$.prompt(txt,{ 
			buttons:langbuttons,
			callback: function(v,m,f){		
				if(v){
					$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/documents&request=restoreDocument&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#document_'+id).slideUp();
						}
					}
					});
				} 
			}
		});
		return false;
	});*/

	
	
	
	/*$(".bin-deleteFile").live('click',function(e) {
		var id = $(this).attr("rel");
		var txt = ALERT_DELETE_REALLY;
		var langbuttons = {};
		langbuttons[ALERT_YES] = true;
		langbuttons[ALERT_NO] = false;
		$.prompt(txt,{ 
			buttons:langbuttons,
			callback: function(v,m,f){		
				if(v){
					$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/documents&request=deleteFile&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#file_'+id).slideUp();
						}
					}
					});
				} 
			}
		});
		return false;
	});
	
	$(".bin-restoreFile").live('click',function(e) {
		var id = $(this).attr("rel");
		var txt = ALERT_RESTORE;
		var langbuttons = {};
		langbuttons[ALERT_YES] = true;
		langbuttons[ALERT_NO] = false;
		$.prompt(txt,{ 
			buttons:langbuttons,
			callback: function(v,m,f){		
				if(v){
					$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/documents&request=restoreFile&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#file_'+id).slideUp();
						}
					}
					});
				} 
			}
		});
		return false;
	});*/


//})