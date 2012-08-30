/* documents Object */
function complaintsDocuments(name) {
	this.name = name;
	
	
	this.createUploader = function(ele){            
		var did = $('#complaints').data("third");
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
				did: did,
				module: this.name
			},
			onSubmit: function(id, fileName){},
			onProgress: function(id, fileName, loaded, total){},
			onComplete: function(id, fileName, data){
				
				numdocs = $(".doclist-outer").size();
				num = num+1;
				if(num == numdocs) {
					$("#complaints3 ul[rel=documents] .active-link").trigger("click");
				}
			},
			onCancel: function(id, fileName){
				},
			debug: false
		});    
	}


	this.formProcess = function(formData, form, poformOptions) {
		var title = $("#complaints .title").fieldValue();
		if(title == "") {
			$.prompt(ALERT_NO_TITLE, {callback: setTitleFocus});
			return false;
		} else {
			formData[formData.length] = { "name": "title", "value": title };
		}
		
		formData[formData.length] = processListApps('document_access');
	 }
 

	 this.formResponse = function(data) {
		 switch(data.action) {
			case "edit":
				//var module = getCurrentModule();
				$("#complaints3 ul[rel=documents] span[rel="+data.id+"] .text").html($("#complaints .title").val());
				var moduleidx = $("#complaints3 ul").index($("#complaints3 ul[rel=documents]"));
				var liindex = $("#complaints3 ul[rel=documents] .module-click").index($("#complaints3 ul[rel=documents] .module-click[rel='"+data.id+"']"));
				//module.getDetails(moduleidx,liindex);
				switch(data.access) {
					case "0":
						$("#complaints3 ul[rel=documents] span[rel="+data.id+"] .module-access-status").removeClass("module-access-active");
					break;
					case "1":
						$("#complaints3 ul[rel=documents] span[rel="+data.id+"] .module-access-status").addClass("module-access-active");
					break;
				}
			break;
		}
	}


 	this.formSerialize = function(formData, form, poformOptions) {
		var title = $("#complaints .title").val();
		if(title == "") {
			$.prompt(ALERT_NO_TITLE, {callback: setTitleFocus});
			return false;
		} else {
			formData[formData.length] = { "name": "title", "value": title };
		}
	}


	this.poformOptions = { beforeSerialize: this.formSerialize, beforeSubmit: this.formProcess, dataType:  'json', success: this.formResponse };


	this.getDetails = function(moduleidx,liindex,list) {
		var id = $("#complaints3 ul:eq("+moduleidx+") .module-click:eq("+liindex+")").attr("rel");
		$('#complaints').data({ "third" : id});
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/complaints/modules/documents&request=getDetails&id="+id, success: function(data){
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
		var id = $('#complaints').data('second');
		$.ajax({ type: "GET", url: "/", dataType: 'json', data: 'path=apps/complaints/modules/documents&request=createNew&id=' + id, cache: false, success: function(data){
			$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/complaints/modules/documents&request=getList&id="+id, success: function(ldata){						
				$("#complaints3 ul[rel=documents]").html(ldata.html);
				$('#complaints_documents_items').html(ldata.items);
				var liindex = $("#complaints3 ul[rel=documents] .module-click").index($("#complaints3 ul[rel=documents] .module-click[rel='"+data.id+"']"));
				$("#complaints3 ul[rel=documents] .module-click:eq("+liindex+")").addClass('active-link');
				var moduleidx = $("#complaints3 ul").index($("#complaints3 ul[rel=documents]"));
				module.getDetails(moduleidx,liindex);
				complaintsActions(0);
				setTimeout(function() { $('#complaints-right .focusTitle').trigger('click'); }, 800);		
				}
			});
			}
		});
	}


	this.actionDuplicate = function() {
		var module = this;
		var id = $("#complaints").data("third");
		var pid = $("#complaints").data("second");
		$.ajax({ type: "GET", url: "/", data: 'path=apps/complaints/modules/documents&request=createDuplicate&id=' + id, cache: false, success: function(did){
			$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/complaints/modules/documents&request=getList&id="+pid, success: function(data){																																																																				
				$("#complaints3 ul[rel=documents]").html(data.html);
				$('#complaints_documents_items').html(data.items);
				var moduleidx = $("#complaints3 ul").index($("#complaints3 ul[rel=documents]"));
				var liindex = $("#complaints3 ul[rel=documents] .module-click").index($("#complaints3 ul[rel=documents] .module-click[rel='"+did+"']"));
				module.getDetails(moduleidx,liindex);
				$("#complaints3 ul[rel=documents] .module-click:eq("+liindex+")").addClass('active-link');
				complaintsActions(0);
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
					var id = $("#complaints").data("third");
					var pid = $("#complaints").data("second");
					$.ajax({ type: "GET", url: "/", data: "path=apps/complaints/modules/documents&request=binDocument&id=" + id, cache: false, success: function(data){
							if(data == "true") {
								$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/complaints/modules/documents&request=getList&id="+pid, success: function(data){
								$("#complaints3 ul[rel=documents]").html(data.html);
								$('#complaints_documents_items').html(data.items);
								var moduleidx = $("#complaints3 ul").index($("#complaints3 ul[rel=documents]"));
								var liindex = 0;
								module.getDetails(moduleidx,liindex);
								$("#complaints3 ul[rel=documents] .module-click:eq("+liindex+")").addClass('active-link');
								complaintsActions(0);
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
		$("#complaints3 ul[rel=documents] .active-link").trigger("click");
		$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/complaints/modules/documents&request=getList&id="+pid, success: function(data){																																																																				
			$("#complaints3 ul[rel=documents]").html(data.html);
			$('#complaints_documents_items').html(data.items);
			var liindex = $("#complaints3 ul[rel=documents] .module-click").index($("#complaints3 ul[rel=documents] .module-click[rel='"+id+"']"));
			$("#complaints3 ul[rel=documents] .module-click:eq("+liindex+")").addClass('active-link');
			}
		});
	}
	
	
	this.actionPrint = function() {
		var id = $("#complaints").data("third");
		var url ='/?path=apps/complaints/modules/documents&request=printDetails&id='+id;
		$("#documentloader").attr('src', url);
	}


	this.actionSend = function() {
		var id = $("#complaints").data("third");
		$.ajax({ type: "GET", url: "/", data: "path=apps/complaints/modules/documents&request=getSend&id="+id, success: function(html){
			$("#modalDialogForward").html(html).dialog('open');
			}
		});
	}


	this.actionSendtoResponse = function() {
		var id = $("#complaints").data("third");
		$.ajax({ type: "GET", url: "/", data: "path=apps/complaints/modules/documents&request=getSendtoDetails&id="+id, success: function(html){
			$("#complaintsdocument_sendto").html(html);
			//$("#modalDialogForward").dialog('close');
			}
		});
	}


	this.sortclick = function (obj,sortcur,sortnew) {
		var module = this;
		var fid = $("#complaints2 .module-click:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/complaints/modules/documents&request=getList&id="+fid+"&sort="+sortnew, success: function(data){
			$("#complaints3 ul[rel=documents]").html(data.html);
			$('#complaints_documents_items').html(data.items);
			obj.attr("rel",sortnew);
			obj.removeClass("sort"+sortcur).addClass("sort"+sortnew);
			var id = $("#complaints3 ul[rel=documents] .module-click:eq(0)").attr("rel");
			$('#complaints').data('third',id);
			if(id == undefined) {
				return false;
			}
			var moduleidx = $("#complaints3 ul").index($("#complaints3 ul[rel=documents]"));
			module.getDetails(moduleidx,0);
			$("#complaints3 ul[rel=documents] .module-click:eq(0)").addClass('active-link');
			}
		});
	}
	
	
	this.sortdrag = function (order) {
		var fid = $("#complaints").data("second");
		$.ajax({ type: "GET", url: "/", data: "path=apps/complaints/modules/documents&request=setOrder&"+order+"&id="+fid, success: function(html){
			$("#complaints3 .sort:visible").attr("rel", "3");
			$("#complaints3 .sort:visible").removeClass("sort1").removeClass("sort2").addClass("sort3");
			}
		});
	}


	this.actionDialog = function(offset,request,field,append,title,sql) {
		$.ajax({ type: "GET", url: "/", data: 'path=apps/complaints&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
			$("#modalDialog").html(html);
			$("#modalDialog").dialog('option', 'position', offset);
			$("#modalDialog").dialog('option', 'title', title);
			$("#modalDialog").dialog('open');
			}
		});	
	}


	this.showItemContext = function(ele,uid,field) {
		$.ajax({ type: "GET", url: "/", data: "path=apps/complaints/modules/documents&request=getDocContext&id="+uid+"&field="+field, success: function(html){
			ele.parent().append(html);
			ele.next().slideDown();
			}
		});
	}
	
	
	this.downloadDocument = function(id) {
		var url = "/?path=apps/complaints/modules/documents&request=downloadDocument&id=" + id;
		$("#documentloader").attr('src', url);
	}


	this.insertItem = function(field,append,id,text) {
		var html = '<span class="docitems-outer"><a href="complaints_documents" class="showItemContext" uid="' + id + '" field="' + field + '">' + text + '</a></span>';
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
		$('#complaints .coform').ajaxSubmit(obj.poformOptions);
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
		$('#complaints .coform').ajaxSubmit(obj.poformOptions);
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/complaints/modules/documents&request=binDocItem&id=" + id, success: function(data){
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
	
	
	this.actionHelp = function() {
		var url = "/?path=apps/complaints/modules/documents&request=getHelp";
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/complaints/modules/documents&request=deleteDocument&id=" + id, cache: false, success: function(data){
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/complaints/modules/documents&request=restoreDocument&id=" + id, cache: false, success: function(data){
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/complaints/modules/documents&request=deleteFile&id=" + id, cache: false, success: function(data){
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/complaints/modules/documents&request=restoreFile&id=" + id, cache: false, success: function(data){
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

var complaints_documents = new complaintsDocuments('complaints_documents');