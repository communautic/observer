/* vdocs Object */
function employeesVDocs(name) {
	this.name = name;
	
	this.formProcess = function(formData, form, poformOptions) {
		var title = $("#employees input.title").fieldValue();
		if(title == "") {
			$.prompt(ALERT_NO_TITLE, {callback: setTitleFocus});
			return false;
		} else {
			formData[formData.length] = { "name": "title", "value": title };
		}
		
		var content = $('#employeesvdocContent').html();
			for (var i=0; i < formData.length; i++) { 
				if (formData[i].name == 'content') { 
					formData[i].value = content;
				} 
			} 
		
		formData[formData.length] = processListApps('vdoc_access');
	 }
	 
	 
	 this.formResponse = function(data) {
		switch(data.action) {
			case "edit":
				$("#employees3 ul[rel=vdocs] span[rel="+data.id+"] .text").html($("#employees .title").val());
					switch(data.access) {
						case "0":
							$("#employees3 ul[rel=vdocs] span[rel="+data.id+"] .module-access-status").removeClass("module-access-active");
						break;
						case "1":
							$("#employees3 ul[rel=vdocs] span[rel="+data.id+"] .module-access-status").addClass("module-access-active");
						break;
					}
			break;
		}
	}


	this.poformOptions = { async: false, beforeSubmit: this.formProcess, dataType: 'json', success: this.formResponse };


	this.getDetails = function(moduleidx,liindex,list) {
			var id = $("#employees3 ul:eq("+moduleidx+") .module-click:eq("+liindex+")").attr("rel");
		$('#employees').data({ "third" : id});
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/employees/modules/vdocs&request=getDetails&id="+id, success: function(data){
			$("#employees-right").html(data.html);
			
			if($('#checkedOut').length > 0) {
					$("#employees3 ul[rel=vdocs] .active-link .icon-checked-out").addClass('icon-checked-out-active');
				} else {
					$("#employees3 ul[rel=vdocs] .active-link .icon-checked-out").removeClass('icon-checked-out-active');
				}
			
				if(list == 0) {
				switch (data.access) {
					case "sysadmin": case "admin":
						employeesActions(10);
					break;
					case "guest":
						employeesActions(11);
					break;
				}
			} else {
				switch (data.access) {
					case "sysadmin": case "admin" :
						if(list == "<li></li>") {
							employeesActions(3);
						} else {
							employeesActions(10);
						}
					break;
					case "guest":
						if(list == "<li></li>") {
							employeesActions();
						} else {
							employeesActions(11);
						}
					break;
				}
				
			}
			initEmployeesContentScrollbar();
			}
		});
	}


	this.actionNew = function() {
		var module = this;
		var cid = $('#employees input[name="id"]').val()
		module.checkIn(cid);
	
		var id = $('#employees').data('second');
		$.ajax({ type: "GET", url: "/", dataType: 'json', data: 'path=apps/employees/modules/vdocs&request=createNew&id=' + id, cache: false, success: function(data){
			$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/employees/modules/vdocs&request=getList&id="+id, success: function(list){
				$("#employees3 ul[rel=vdocs]").html(list.html);
				$('#employees_vdocs_items').html(list.items);
				var liindex = $("#employees3 ul[rel=vdocs] .module-click").index($("#employees3 ul[rel=vdocs] .module-click[rel='"+data.id+"']"));
				$("#employees3 ul[rel=vdocs] .module-click:eq("+liindex+")").addClass('active-link');
				var moduleidx = $("#employees3 ul").index($("#employees3 ul[rel=vdocs]"));
				module.getDetails(moduleidx,liindex);
				setTimeout(function() { $('#employees-right .focusTitle').trigger('click'); }, 800);
				}
			});
			}
		});
	}
	
	
	this.actionDuplicate = function() {
		var module = this;
		var cid = $('#employees input[name="id"]').val()
		module.checkIn(cid);
		var id = $("#employees").data("third");
		var pid = $("#employees").data("second");
		$.ajax({ type: "GET", url: "/", data: 'path=apps/employees/modules/vdocs&request=createDuplicate&id=' + id, cache: false, success: function(mid){
			$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/employees/modules/vdocs&request=getList&id="+pid, success: function(data){																																																																				
				$("#employees3 ul[rel=vdocs]").html(data.html);
				$('#employees_vdocs_items').html(data.items);
				var moduleidx = $("#employees3 ul").index($("#employees3 ul[rel=vdocs]"));
				var liindex = $("#employees3 ul[rel=vdocs] .module-click").index($("#employees3 ul[rel=vdocs] .module-click[rel='"+mid+"']"));
				module.getDetails(moduleidx,liindex);
				$("#employees3 ul[rel=vdocs] .module-click:eq("+liindex+")").addClass('active-link');
				}
			});
			}
		});
	}
	
	
	this.actionBin = function() {
		var module = this;
		var cid = $('#employees input[name="id"]').val()
		module.checkIn(cid);
		var txt = ALERT_DELETE;
		var langbuttons = {};
		langbuttons[ALERT_YES] = true;
		langbuttons[ALERT_NO] = false;
		$.prompt(txt,{ 
			buttons:langbuttons,
			callback: function(v,m,f){		
				if(v){
					var id = $("#employees").data("third");
					var pid = $("#employees").data("second");
					$.ajax({ type: "GET", url: "/", data: "path=apps/employees/modules/vdocs&request=binVDoc&id=" + id, cache: false, success: function(data){
							if(data == "true") {
								$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/employees/modules/vdocs&request=getList&id="+pid, success: function(data){
									$("#employees3 ul[rel=vdocs]").html(data.html);
									$('#employees_vdocs_items').html(data.items);
									if(data.html == "<li></li>") {
										employeesActions(3);
									} else {
										employeesActions(10);
									}
									var moduleidx = $("#employees3 ul").index($("#employees3 ul[rel=vdocs]"));
									var liindex = 0;
									module.getDetails(moduleidx,liindex);
									$("#employees3 ul[rel=vdocs] .module-click:eq("+liindex+")").addClass('active-link');
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
		$.ajax({ type: "GET", url: "/", async: false, data: 'path=apps/employees/modules/vdocs&request=checkinVDoc&id='+id, success: function(data){
			if(!data) {
				prompt("something wrong");
			}
			}
		});
		return true;
	}


	this.actionRefresh = function() {
		var id = $("#employees").data("third");
		var pid = $("#employees").data("second");
		$("#employees3 ul[rel=vdocs] .active-link").trigger("click");
		$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/employees/modules/vdocs&request=getList&id="+pid, success: function(data){																																																																				
			$("#employees3 ul[rel=vdocs]").html(data.html);
			$('#employees_vdocs_items').html(data.items);
			var liindex = $("#employees3 ul[rel=vdocs] .module-click").index($("#employees3 ul[rel=vdocs] .module-click[rel='"+id+"']"));
			$("#employees3 ul[rel=vdocs] .module-click:eq("+liindex+")").addClass('active-link');
			}
		});
	}


	this.actionExport = function() {
		var id = $("#employees").data("third");
		var url ='/?path=apps/employees/modules/vdocs&request=exportDetails&id='+id;
		$("#documentloader").attr('src', url);
	}
	

	this.actionPrint = function() {
		var id = $("#employees").data("third");
		var url ='/?path=apps/employees/modules/vdocs&request=printDetails&id='+id;
		$("#documentloader").attr('src', url);
	}


	this.actionSend = function() {
		var id = $("#employees").data("third");
		$.ajax({ type: "GET", url: "/", data: "path=apps/employees/modules/vdocs&request=getSend&id="+id, success: function(html){
			$("#modalDialogForward").html(html).dialog('open');
			}
		});
	}


	this.actionSendtoResponse = function() {
		var id = $("#employees").data("third");
		$.ajax({ type: "GET", url: "/", data: "path=apps/employees/modules/vdocs&request=getSendtoDetails&id="+id, success: function(html){
			$("#employeesvdoc_sendto").html(html);
			//$("#modalDialogForward").dialog('close');
			}
		});
		////$("#modalDialogForward").dialog('close');
	}


	this.sortclick = function (obj,sortcur,sortnew) {
		var module = this;
		var cid = $('#employees input[name="id"]').val()
		module.checkIn(cid);
		
		var fid = $("#employees2 .module-click:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/employees/modules/vdocs&request=getList&id="+fid+"&sort="+sortnew, success: function(data){
			$("#employees3 ul[rel=vdocs]").html(data.html);
			$('#employees_vdocs_items').html(data.items);
			obj.attr("rel",sortnew);
			obj.removeClass("sort"+sortcur).addClass("sort"+sortnew);
			var id = $("#employees3 ul[rel=vdocs] .module-click:eq(0)").attr("rel");
			$('#employees').data('third',id);
			if(id == undefined) {
				return false;
			}
			var moduleidx = $("#employees3 ul").index($("#employees3 ul[rel=vdocs]"));
			module.getDetails(moduleidx,0);
			$("#employees3 ul[rel=vdocs] .module-click:eq(0)").addClass('active-link');
		}
		});
	}


	this.sortdrag = function (order) {
		var fid = $("#employees").data("second");
		$.ajax({ type: "GET", url: "/", data: "path=apps/employees/modules/vdocs&request=setOrder&"+order+"&id="+fid, success: function(html){
			$("#employees3 .sort:visible").attr("rel", "3");
			$("#employees3 .sort:visible").removeClass("sort1").removeClass("sort2").addClass("sort3");
			}
		});
	}


	this.actionDialog = function(offset,request,field,append,title,sql) {
		switch(request) {
			case "getAccessDialog":
				$.ajax({ type: "GET", url: "/", data: 'path=apps/employees&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
					$("#modalDialog").html(html);
					//$("#modalDialog").dialog('option', 'height', 50);
					$("#modalDialog").dialog('option', 'position', offset);
					$("#modalDialog").dialog('option', 'title', title);
					$("#modalDialog").dialog('open');
					}
				});
			break;
			default:
			$.ajax({ type: "GET", url: "/", data: 'path=apps/employees&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
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


	this.actionHelp = function() {
		var url = "/?path=apps/employees/modules/vdocs&request=getHelp";
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/employees/modules/vdocs&request=deleteVDoc&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#vdoc_'+id).slideUp();
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/employees/modules/vdocs&request=restoreVDoc&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#vdoc_'+id).slideUp();
						}
					}
					});
				} 
			}
		});
	}

	
	
	
}

var employees_vdocs = new employeesVDocs('employees_vdocs');


$(document).ready(function() { 

	function myCustomInitInstance(ed) {
		var ele = ed.id;
		$("#"+ele).data('initial_value', $("#"+ele).html());
		var obj = getCurrentModule();
		ed.onKeyUp.add(function(ed, l) {
			var content = ed.getContent();
			if (content != $("#"+ele).data('initial_value')) {
				formChanged = true;
				$("#"+ele).data('initial_value', content);
			}
		});
		ed.onChange.add(function(ed, l) {
			var content = ed.getContent();
			if (content != $("#"+ele).data('initial_value')) {
				formChanged = true;
				$("#"+ele).data('initial_value', content);
			}
		});
		ed.onPaste.add(function(ed, l) {
			var content = ed.getContent();
			if (content != $("#"+ele).data('initial_value')) {
				formChanged = true;
				$("#"+ele).data('initial_value', content);
			}
		});
		//FF
		$(ed.getDoc()).bind('blur', function(){ 
			if(confirmNavigation()) {
				formChanged = false;
				var obj = getCurrentModule();
				$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
			}
		});
		// Webkit
		$(ed.getWin()).bind('blur', function(){ 
			if(confirmNavigation()) {
				formChanged = false;
				var obj = getCurrentModule();
				$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
			}
		});
		// Tab functionality
		ed.onKeyDown.add(function(inst, e) {
			// Firefox uses the e.which event for keypress
			// While IE and others use e.keyCode, so we look for both
        	if (e.keyCode) code = e.keyCode;
			else if (e.which) code = e.which;
			if(code == 9 && !e.altKey && !e.ctrlKey) {
				// toggle between Indent and Outdent command, depending on if SHIFT is pressed
				if (e.shiftKey) ed.execCommand('Outdent');
				else ed.execCommand('Indent');
				// prevent tab key from leaving editor in some browsers
				if(e.preventDefault) {
					e.preventDefault();
				}
				return false;
			}
    	});
		setTimeout(function() {
			$("#employeesvdocContent").tinymce().execCommand('mceAutoResize');			
		}, 300)
	}

	$("#employeesvdocContent").livequery(function() {	 
		var vdoc = $(this);
		$.getScript("tiny_mce/jquery.tinymce.js", function(){
			vdoc.tinymce({
			script_url : 'tiny_mce/tiny_mce_gzip.php',
			doctype: '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">',
			theme : "advanced",
			skin : "coVDocs",
			language: co_lang,
			//entity_encoding : "raw",
        	plugins : "autosave,autoresize,pagebreak,emotions,inlinepopups,paste,visualchars,nonbreaking,xhtmlxtras",
			force_br_newlines: false,
			force_p_newlines: true,
			theme_advanced_buttons1 : "undo,redo,|,bold,italic,underline,strikethrough,|,sub,sup,|,justifyleft,justifycenter,justifyright,justifyfull,|,fontsizeselect,|,forecolor,backcolor",
        	theme_advanced_buttons2 : "cut,copy,paste,|,bullist,numlist,|,outdent,indent,|,hr,|,charmap,emotions,visualchars,nonbreaking,pagebreak,|,removeformat,cleanup,code",
        	theme_advanced_buttons3 : "",
			theme_advanced_buttons4 : "",
       		theme_advanced_toolbar_location : "external",
        	theme_advanced_toolbar_align : "left",
        	theme_advanced_statusbar_location : "none",
			content_css : "tiny_mce/editor.content.css",
			autosave_ask_before_unload : false,
			autoresize_on_init : false,
			init_instance_callback: myCustomInitInstance
		});
		})
	})
	
});