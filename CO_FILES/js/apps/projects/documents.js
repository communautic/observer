/* documents Object */
var documents = new Module('documents');
documents.path = 'apps/projects/modules/documents/';
documents.getDetails = getDetailsDocument;
documents.sortclick = sortClickDocument;
documents.sortdrag = sortDragDocument;
documents.actionDialog = dialogDocument;
documents.addTask = addTaskDocument;
documents.actionNew = newDocument;
documents.actionPrint = printDocument;
documents.actionDuplicate = duplicateDocument;
documents.actionBin = binDocument;
documents.poformOptions = { beforeSerialize: documentSerialize, beforeSubmit: documentFormProcess, dataType:  'json', success: documentFormResponse };
// 
/* Functions 
- documentFormProcess
- documentFormResponse
- newDocument
- binDocument
*/

function processDocList(list) {
	var items = $("#"+list+" .docitem").size();
	var itemlist = "";
	$("#"+list+" .docitem").each( function(i) {
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
}


function getDetailsDocument(moduleidx,liindex) {
	var phaseid = $("#projects3 ul:eq("+moduleidx+") .module-click:eq("+liindex+")").attr("rel");
	$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/documents&request=getDetails&id="+phaseid, success: function(html){
		$("#"+projects.name+"-right").html(html);
		initContentScrollbar();
		initScrollbar( '.projects3-content:visible .scrolling-content' );
		}
	});
}

function documentSerialize(formData, form, poformOptions) {
				//$("#projects .title").attr("value",$("#related_to_fake span").attr('uid'));
				//$("#related_to_protocol").attr("value",$("#related_to_protocol_fake span").attr('uid'));

	var title = $("#projects .title").val();
	if(title == "") {
		$.prompt(ALERT_NO_TITLE, {callback: setTitleFocus});
		return false;
	} else {
		formData[formData.length] = { "name": "title", "value": title };
	}
	
	/*if($('#protocol').length > 0) {
	var protocol = $('#protocol').tinymce().getContent();
	$("#protocol").attr("value",protocol);
	}*/
}

function documentFormProcess(formData, form, poformOptions) {
	var title = $("#projects .title").fieldValue();
	if(title == "") {
		$.prompt(ALERT_NO_TITLE, {callback: setTitleFocus});
		return false;
	} else {
		formData[formData.length] = { "name": "title", "value": title };
	}
	/*var uploadValue = $('input[name=upload]').fieldValue();
	if (!uploadValue[0]) {
	$.prompt(ALERT_NO_FILE);
	return false;
	}*/
	
	/*for (var i=0; i < formData.length; i++) { 
			if (formData[i].name == 'file') { 
				formData[i].value = '';
			} 
		} */
	
	formData[formData.length] = processList('document_access');
}


function documentFormResponse(data) {
	switch(data.action) {
		case "edit":
			$("#projects3 a.active-link .text").html($("#projects .title").val());
			$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/documents&request=getDetails&id="+data.id, success: function(html){
				$("#projects-right").html(html);
				initContentScrollbar();
				// do module access done status
				switch(data.access) {
					case "0":
						$("#projects3 a.active-link .module-access-status").removeClass("module-access-active");
					break;
					case "1":
						$("#projects3 a.active-link .module-access-status").addClass("module-access-active");
					break;
				}
				$("#loading").fadeOut();
				}
			});
		break;
	}
}



function newDocument() {
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
			}
		});
		}
	});
}


function printDocument() {
	alert("in Entwicklung - siehe Druckenlink unter Projekte");
}


function duplicateDocument() {
	var id = $("#projects3 .active-link").attr("rel");
	var pid = $("#projects2 .module-click:visible").attr("rel");
	$.ajax({ type: "GET", url: "/", data: 'path=apps/projects/modules/documents&request=createDuplicate&id=' + id, cache: false, success: function(did){
		$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/projects/modules/documents&request=getList&id="+pid, success: function(data){																																																																				
			$(".projects3-content:visible ul").html(data.html);
			var moduleidx = $(".projects3-content").index($(".projects3-content:visible"));
			var liindex = $(".projects3-content:visible .module-click").index($(".projects3-content:visible .module-click[rel='"+did+"']"));
			getDetailsDocument(moduleidx,liindex);
			$(".projects3-content:visible .module-click:eq("+liindex+")").addClass('active-link');
			projectsActions(0);
			}
		});
		}
	});
}

function binDocument() {
	var txt = ALERT_DELETE;
	var langbuttons = {};
	langbuttons[ALERT_YES] = true;
	langbuttons[ALERT_NO] = false;
	$.prompt(txt,{ 
		buttons:langbuttons,
		callback: function(v,m,f){		
			if(v){
				var id = $("#projects3 .active-link").attr("rel");
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
							}
						});
						}
					}
				});
			} 
		}
	});
}


function sortClickDocument(obj,sortcur,sortnew) {
	var fid = $("#projects2 .module-click:visible").attr("rel");
	$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects/modules/documents&request=getList&id="+fid+"&sort="+sortnew, success: function(data){
		  $(".projects3-content:visible ul").html(data.html);
		  obj.attr("rel",sortnew);
		  obj.removeClass("sort"+sortcur).addClass("sort"+sortnew);
		  var id = $(".projects3-content:visible .module-click:eq(0)").attr("rel");
			if(id == undefined) {
				return false;
			}
			
			var num = $(".projects3-content:visible .phase_num:eq(0)").html();
			
		  $.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/documents&request=getDetails&id="+id+"&num="+num, success: function(html){
			  $("#"+projects.name+"-right").html(html);
			  initScrollbar( '#projects .scrolling-content' );
				initContentScrollbar();
			  }
		  });
	}
	});
}


function sortDragDocument(order) {
	var fid = $("#projects2 .module-click:visible").attr("rel");
	$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/documents&request=setOrder&"+order+"&id="+fid, success: function(html){
		$("#projects3 a.sort:visible").attr("rel", "3");
		$("#projects3 a.sort:visible").removeClass("sort1").removeClass("sort2").addClass("sort3");
		}
	});
}



function dialogDocument(offset,request,field,append,title,sql) {
	$.ajax({ type: "GET", url: "/", data: 'path=apps/projects&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
			$("#modalDialog").html(html);
			$("#modalDialog").dialog('option', 'position', offset);
			$("#modalDialog").dialog('option', 'title', title);
			$("#modalDialog").dialog('open');
			}
		});
}

function addTaskDocument() {
	var startdate = $("input[name='startdate']").val();
	var enddate = $("input[name='enddate']").val();
	var num = parseInt($("#projects-right .tasks-entry").size());
	$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/documents&request=insertTask&startdate=" + startdate + "&enddate=" + enddate + "&num=" + num, success: function(html){
		$('#documenttasks').append(html);
		var idx = parseInt($('.cbx').size() -1);
		var element = $('.cbx:eq('+idx+')');
		$.jNice.CheckAddPO(element);
		$('.documentouter:eq('+idx+')').slideDown(function() {
			initContentScrollbar();								   
		});
		 }
	});
}

function createUploader(ele){            
	var did = $("#projects3 .active-link").attr("rel");
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
                '<table cellspacing="0" cellpadding="0" border="0" class="table-content"><tr><td class="tcell-left text11">Dateiname/Format</td><td class="tcell-right"><a title="Download" rel="" class="downloadDocument" href="Download">' +
				'<span class="qq-upload-file docitem"></span>' +
				'</a></td><td width="30"><a rel="" class="deleteDoc" href="#"><span class="icon-delete"></span></a></td></tr><tr><td class="tcell-left text11">Dateigr&ouml;sse</td><td class="tcell-right">' +
                '<span class="qq-upload-spinner"></span>' +
                '<span class="qq-upload-size"></span>' +
				'<a class="qq-upload-cancel" href="#">Cancel</a>' +
                '<span class="qq-upload-failed-text">Failed</span>' +
				'</td><td></td></tr></table>' +
            '</span>',   
		action: '/',
		sizeLimit: 10240000, // max size
		params: {
			path: 'classes/file_uploader',
			request: 'createNew',
			did: did
		},
		onSubmit: function(id, fileName){},
		onProgress: function(id, fileName, loaded, total){},
		onComplete: function(id, fileName, data){
			$("#documents .doclist-outer:last").attr("id","doc_"+data.id);
			$("#documents .deleteDoc:last").attr("rel", data.id);
			$("#documents .downloadDocument:last").attr("rel", data.id);
			numdocs = $("#documents .docitem").size();
			num = num+1;
		},
		onCancel: function(id, fileName){},
        debug: false
	});    
}


$(document).ready(function() { 		
	$(".document-uploader").livequery(function() {
		createUploader($(this));
	})


	$('a.downloadDocument').live("click", function(){
		var id = $(this).attr("rel");
		var url = "/?path=apps/projects/modules/documents&request=downloadDocument&id=" + id;
		$("#documentloader").attr('src', url);
		return false;
	});


	$('a.insertDocumentfromDialog').live('click',function() {
		var field = $(this).attr("field");
		var append = $(this).attr("append");
		var id = $(this).attr("did");
		var text = $(this).html();
		var html = '<span class="docitems-outer"><a class="docitem" uid="' + id + '" field="' + field + '">' + text + '</a></span>';
		if(append == 0) {
			$("#"+field).html(html);
			$("#modalDialog").dialog('close');
		} else {
			if($("#"+field).html() != "") {
				$("#"+field+" .docitems-outer:visible:last .docitem").append(", ");
				$("#"+field).append(html);
			} else {
				$("#"+field).append(html);
			}
		}
		var obj = getCurrentModule();
		$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		return false;
	});


	$('a.docitem').live('click',function() {
		var ele = $(this);
		var uid = $(this).attr('uid');
		var field = $(this).attr('field');
		$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/documents&request=getDocContext&id="+uid+"&field="+field, success: function(html){
			ele.parent().append(html);
			ele.next().slideDown();
			}
		});
		return false;
	});


	$('a.delete-docitem').livequery('click',function() {
		var field = $(this).attr('field');
		$(this).parent().fadeOut();
		$(this).parent().prev().toggleClass('deletefromlist');
		$(this).parents(".docitems-outer").hide();
		if($("#"+field+" .docitems-outer:visible").length > 0) {
		var text = $("#"+field+" .docitems-outer:visible:last .docitem").html();
		var textnew = text.split(", ");
		$("#"+field+" .docitems-outer:visible:last .docitem").html(textnew[0]);
		}
		var obj = getCurrentModule();
		$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		return false;
	});
	
	
	
	$('a.deleteDoc').livequery('click',function() {
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
	});


})