/* vdocs Object */
var projects_vdocs = new Module('projects_vdocs');
projects_vdocs.path = 'apps/projects/modules/vdocs/';
projects_vdocs.getDetails = getDetailsVDoc;
projects_vdocs.sortclick = sortClickVDoc;
projects_vdocs.sortdrag = sortDragVDoc;
projects_vdocs.actionDialog = dialogVDoc;
//projects_vdocs.addTask = addTaskVDoc;
projects_vdocs.deleteTask = deleteTask;
projects_vdocs.actionNew = newVDoc;
projects_vdocs.actionPrint = printVDoc;
projects_vdocs.actionSend = sendVDoc;
projects_vdocs.actionSendtoResponse = sendVDocResponse;
projects_vdocs.actionDuplicate = duplicateVDoc;
projects_vdocs.actionRefresh = refreshVDoc;
projects_vdocs.actionBin = binVDoc;
projects_vdocs.checkIn = checkInVDoc;
projects_vdocs.poformOptions = { beforeSubmit: vdocFormProcess, dataType:  'json', success: vdocFormResponse };
projects_vdocs.toggleIntern = vdocToggleIntern;


function getDetailsVDoc(moduleidx,liindex) {
	var id = $("#projects3 ul:eq("+moduleidx+") .module-click:eq("+liindex+")").attr("rel");
	$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/vdocs&request=getDetails&id="+id, success: function(html){
		$("#"+projects.name+"-right").html(html);
		initProjectsContentScrollbar();
		//initScrollbar( '.projects3-content:visible .scrolling-content' );
		}
	});
}


function vdocFormProcess(formData, form, poformOptions) {
	var title = $("#projects .title").fieldValue();
	if(title == "") {
		$.prompt(ALERT_NO_TITLE, {callback: setTitleFocus});
		return false;
	} else {
		formData[formData.length] = { "name": "title", "value": title };
	}
	
	var content = $('#vdocContent').html();
		for (var i=0; i < formData.length; i++) { 
			if (formData[i].name == 'content') { 
				formData[i].value = content;
			} 
		} 
	
	formData[formData.length] = processList('vdoc_access');
}


function vdocFormResponse(data) {
	switch(data.action) {
		case "edit":
			$("#projects3 span[rel='"+data.id+"'] .text").html($("#projects .title").val());
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


function newVDoc() {
	var id = $('#projects2 .module-click:visible').attr("rel");
	$.ajax({ type: "GET", url: "/", dataType: 'json', data: 'path=apps/projects/modules/vdocs&request=createNew&id=' + id, cache: false, success: function(data){
			$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/projects/modules/vdocs&request=getList&id="+id, success: function(list){
				$(".projects3-content:visible ul").html(list.html);
				var index = $(".projects3-content:visible .module-click").index($(".projects3-content:visible .module-click[rel='"+data.id+"']"));
				$(".projects3-content:visible .module-click:eq("+index+")").addClass('active-link');
				var num = index+1;
				$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/vdocs&request=getDetails&id="+data.id+"&num="+num, success: function(html){
					$("#projects-right").html(html);
					initProjectsContentScrollbar();
					}
				});
				projectsActions(0);
				$('#projects3 input.filter').quicksearch('#projects3 li');
				}
			});
		}
	});
}


function printVDoc() {
	var id = $("#projects3 .active-link:visible").attr("rel");
	var url ='/?path=apps/projects/modules/vdocs&request=printDetails&id='+id;
	location.href = url;
}


function sendVDoc() {
	var id = $("#projects3 .active-link:visible").attr("rel");
	$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/vdocs&request=getSend&id="+id, success: function(html){
		$("#modalDialogForward").html(html).dialog('open');
		}
	});
}

function sendVDocResponse() {
	var id = $("#projects3 .active-link:visible").attr("rel");
	$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/vdocs&request=getSendtoDetails&id="+id, success: function(html){
		$("#vdoc_sendto").html(html);
		$("#modalDialogForward").dialog('close');
		}
	});
}


function duplicateVDoc() {
	var id = $("#projects3 .active-link:visible").attr("rel");
	var pid = $("#projects2 .module-click:visible").attr("rel");
	$.ajax({ type: "GET", url: "/", data: 'path=apps/projects/modules/vdocs&request=createDuplicate&id=' + id, cache: false, success: function(mid){
		$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/projects/modules/vdocs&request=getList&id="+pid, success: function(data){																																																																				
			$(".projects3-content:visible ul").html(data.html);
			var moduleidx = $(".projects3-content").index($(".projects3-content:visible"));
			var liindex = $(".projects3-content:visible .module-click").index($(".projects3-content:visible .module-click[rel='"+mid+"']"));
			getDetailsVDoc(moduleidx,liindex);
			$(".projects3-content:visible .module-click:eq("+liindex+")").addClass('active-link');
			projectsActions(0);
			$('#projects3 input.filter').quicksearch('#projects3 li');
			}
		});
		}
	});
}

function refreshVDoc() {
	$("#projects3 .active-link:visible").trigger("click");
}


function binVDoc() {
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
				$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/vdocs&request=binVDoc&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects/modules/vdocs&request=getList&id="+pid, success: function(data){
								$(".projects3-content:visible ul").html(data.html);
								if(data.html == "<li></li>") {
									projectsActions(3);
								} else {
									projectsActions(0);
									$('#projects3 input.filter').quicksearch('#projects3 li');
								}
								var moduleidx = $(".projects3-content").index($(".projects3-content:visible"));
								var liindex = 0;
								getDetailsVDoc(moduleidx,liindex);
								$("#projects3 .projects3-content:visible .module-click:eq("+liindex+")").addClass('active-link');
								//projectsActions(0);
							}
							});
						}
					}
				});
			} 
		}
	});
}

function checkInVDoc() {
	return true;
}

function sortClickVDoc(obj,sortcur,sortnew) {
	var fid = $("#projects2 .module-click:visible").attr("rel");
	$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects/modules/vdocs&request=getList&id="+fid+"&sort="+sortnew, success: function(data){
		  $(".projects3-content:visible ul").html(data.html);
		  obj.attr("rel",sortnew);
		  obj.removeClass("sort"+sortcur).addClass("sort"+sortnew);
		  var id = $(".projects3-content:visible .module-click:eq(0)").attr("rel");
			if(id == undefined) {
				return false;
			}
			
			var num = $(".projects3-content:visible .phase_num:eq(0)").html();
			
		  $.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/vdocs&request=getDetails&id="+id+"&num="+num, success: function(html){
			  $("#"+projects.name+"-right").html(html);
			 //initScrollbar( '#projects .scrolling-content' );
				initProjectsContentScrollbar();
			  }
		  });
	}
	});
}


function sortDragVDoc(order) {
	var fid = $("#projects2 .module-click:visible").attr("rel");
	$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/vdocs&request=setOrder&"+order+"&id="+fid, success: function(html){
		$("#projects3 .sort:visible").attr("rel", "3");
		$("#projects3 .sort:visible").removeClass("sort1").removeClass("sort2").addClass("sort3");
		}
	});
}


function vdocToggleIntern(id,status,obj) {
	$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/vdocs&request=toggleIntern&id=" + id + "&status=" + status, cache: false, success: function(data){
		if(data == "true") {
			obj.toggleClass("module-item-active")
		}
		}
	});
}


function dialogVDoc(offset,request,field,append,title,sql) {
	switch(request) {
		case "getAccessDialog":
			$.ajax({ type: "GET", url: "/", data: 'path=apps/projects&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
				$("#modalDialog").html(html);
				//$("#modalDialog").dialog('option', 'height', 50);
				$("#modalDialog").dialog('option', 'position', offset);
				$("#modalDialog").dialog('option', 'title', title);
				$("#modalDialog").dialog('open');
				}
			});
		break;
		case "getVDocStatusDialog":
			$.ajax({ type: "GET", url: "/", data: 'path=apps/projects/modules/vdocs&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
				$("#modalDialog").html(html);
				$("#modalDialog").dialog('option', 'position', offset);
				$("#modalDialog").dialog('option', 'title', title);
				$("#modalDialog").dialog('open');
				}
			});
		break;
		case "getDocumentsDialog":
			var id = $("#projects2 .module-click:visible").attr("rel");
			$.ajax({ type: "GET", url: "/", data: 'path=apps/projects/modules/documents&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql+'&id=' + id, success: function(html){
				$("#modalDialog").html(html);
				$("#modalDialog").dialog('option', 'position', offset);
				$("#modalDialog").dialog('option', 'title', title);
				$("#modalDialog").dialog('open');
				}
			});
		break;
		default:
		$.ajax({ type: "GET", url: "/", data: 'path=apps/projects&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
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


function deleteTask(id) {
	
	var txt = ALERT_DELETE;
	var langbuttons = {};
	langbuttons[ALERT_YES] = true;
	langbuttons[ALERT_NO] = false;
	$.prompt(txt,{ 
		buttons:langbuttons,
		callback: function(v,m,f){		
			if(v){
			$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/vdocs&request=deleteTask&id=" + id, success: function(data){
				if(data){
					$("#task_"+id).slideUp(function(){ $(this).remove(); });
					
				} 
				}
			});
			} 
		}
	});
}


$(document).ready(function() { 


function myCustomInitInstance(ed) {
		var ele = ed.id;
		$("#"+ele).data('initial_value', $("#"+ele).html());
		ed.onKeyUp.add(function(ed, l) {
			var content = ed.getContent();
			 if (content != $("#"+ele).data('initial_value')) {
			  formChanged = true;
			  $("#"+ele).data('initial_value', content);
		  }
		});
	}
	
	function mySave(ed) {
		return false;
	}
	
	
	$(".mce_save").live('click',function(e) {
										 
					var obj = getCurrentModule();
		$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);	
		return false;
										 }
										)


	$("#vdocContent").livequery(function() {	 
		var vdoc = $(this);
		$.getScript("tiny_mce/jquery.tinymce.js", function(){
			vdoc.tinymce({
			script_url : 'tiny_mce/tiny_mce_gzip.php',
			doctype: '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">',
			theme : "advanced",
			language: "de",
			entity_encoding : "raw",
        plugins : "autoresize,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
			force_br_newlines: false,
			force_p_newlines: true,
			theme_advanced_buttons1 : "save,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
        theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,code,|,forecolor,backcolor",
        theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
       // theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
	   theme_advanced_buttons4 : "visualchars,nonbreaking,template,pagebreak",
        theme_advanced_toolbar_location : "external",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom",
        //theme_advanced_resizing : true,
			content_css : "tiny_mce/editor.content.css",
			//theme_advanced_resizing_min_height : 24
			init_instance_callback: myCustomInitInstance,
			save_onsavecallback: mySave
		});
																				 })
	})
		

	
	
	
	// Recycle bin functions


	$(".bin-deleteVDoc").live('click',function(e) {
		var id = $(this).attr("rel");
		var txt = ALERT_DELETE_REALLY;
		var langbuttons = {};
		langbuttons[ALERT_YES] = true;
		langbuttons[ALERT_NO] = false;
		$.prompt(txt,{ 
			buttons:langbuttons,
			callback: function(v,m,f){		
				if(v){
					$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/vdocs&request=deleteVDoc&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#vdoc_'+id).slideUp();
						}
					}
					});
				} 
			}
		});
		return false;
	});
	
	$(".bin-restoreVDoc").live('click',function(e) {
		var id = $(this).attr("rel");
		var txt = ALERT_RESTORE;
		var langbuttons = {};
		langbuttons[ALERT_YES] = true;
		langbuttons[ALERT_NO] = false;
		$.prompt(txt,{ 
			buttons:langbuttons,
			callback: function(v,m,f){		
				if(v){
					$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/vdocs&request=restoreVDoc&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#vdoc_'+id).slideUp();
						}
					}
					});
				} 
			}
		});
		return false;
	});
	
});