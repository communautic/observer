/* menues Object */
function publishersMenues(name) {
	this.name = name;


	this.formProcess = function(formData, form, poformOptions) {
		var title = $("#publishers input.title").fieldValue();
		if(title == "") {
			setTimeout(function() {
				title = $("#publishers input.title").fieldValue();
				if(title == "") {
					$.prompt(ALERT_NO_TITLE, {submit: setTitleFocus});
				}
			}, 5000)
			return false;
		} else {
			formData[formData.length] = { "name": "title", "value": title };
		}
		
		formData[formData.length] = processListApps('management');
		formData[formData.length] = processCustomTextApps('management_ct');
		formData[formData.length] = processListApps('menue_access');
		//formData[formData.length] = processListApps('menue_status');
	 }
	 
	 
	 this.formResponse = function(data) {
		 switch(data.action) {
			case "edit":
				$("#publishers1 ul[rel=menues] span[rel="+data.id+"] .text").html($("#publishers .title").val());
					switch(data.access) {
						case "0":
							$("#publishers1 ul[rel=menues] span[rel="+data.id+"] .module-access-status").removeClass("module-access-active");
						break;
						case "1":
							$("#publishers1 ul[rel=menues] span[rel="+data.id+"] .module-access-status").addClass("module-access-active");
						break;
					}
					switch(data.status) {
						case "2":
							$("#publishers1 ul[rel=menues] span[rel="+data.id+"] .module-item-status").addClass("module-item-active").removeClass("module-item-active-stopped");
						break;
						default:
							$("#publishers1 ul[rel=menues] span[rel="+data.id+"] .module-item-status").removeClass("module-item-active").removeClass("module-item-active-stopped");
					}
			break;
		}
	}
	
	
	this.poformOptions = { beforeSubmit: this.formProcess, dataType: 'json', success: this.formResponse };


	this.statusOnClose = function(dp) {
		var id = $('#publishers input[name="id"]').val()
		var status = $("#publishers .statusTabs li span.active").attr('rel');
		var date = $("#publishers .statusTabs input").val();
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/publishers/modules/menues&request=updateStatus&id=" + id + "&date=" + date + "&status=" + status, cache: false, success: function(data){
				switch(data.status) {
					case "2":
						$("#publishers1 ul[rel=menues] span[rel="+data.id+"] .module-item-status").addClass("module-item-active").removeClass("module-item-active-stopped");
					break;
					default:
						$("#publishers1 ul[rel=menues] span[rel="+data.id+"] .module-item-status").removeClass("module-item-active").removeClass("module-item-active-stopped");
				}
			}
		});
	}


	this.getDetails = function(moduleidx,liindex,list) {
		var id = $("#publishers1 ul:eq("+moduleidx+") .module-click:eq("+liindex+")").attr("rel");
		$('#publishers').data({ "first" : id});
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/publishers/modules/menues&request=getDetails&id="+id, success: function(data){
			$("#publishers-right").html(data.html);
			
			if($('#checkedOut').length > 0) {
					$("#publishers1 ul[rel=menues] .active-link .icon-checked-out").addClass('icon-checked-out-active');
				} else {
					$("#publishers1 ul[rel=menues] .active-link .icon-checked-out").removeClass('icon-checked-out-active');
				}
			
			if(list == 0) {
				switch (data.access) {
					case "sysadmin": case "admin":
						publishersActions(0);
					break;
					case "guest":
						publishersActions(5);
					break;
				}
			} else {
				switch (data.access) {
					case "sysadmin": case "admin" :
						if(list == "<li></li>") {
							publishersActions(3);
						} else {
							publishersActions(0);
						}
					break;
					case "guest":
						if(list == "<li></li>") {
							publishersActions();
						} else {
							publishersActions(5);
						}
					break;
				}
				
			}
			initPublishersContentScrollbar();
			}
		});	
	}


	this.actionNew = function() {
		var module = this;
		var cid = $('#publishers input[name="id"]').val()
		module.checkIn(cid);
	

		$.ajax({ type: "GET", url: "/", dataType: 'json', data: 'path=apps/publishers/modules/menues&request=createNew', cache: false, success: function(data){
			$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/publishers/modules/menues&request=getList", success: function(list){
				$("#publishers1 ul[rel=menues]").html(list.html);
				var liindex = $("#publishers1 ul[rel=menues] .module-click").index($("#publishers1 ul[rel=menues] .module-click[rel='"+data.id+"']"));
				$("#publishers1 ul[rel=menues] .module-click:eq("+liindex+")").addClass('active-link');
				var moduleidx = $("#publishers1 ul").index($("#publishers1 ul[rel=menues]"));
				module.getDetails(moduleidx,liindex);
				setTimeout(function() { $('#publishers-right .focusTitle').trigger('click'); }, 800);
				}
			});
			}
		});
	}


	this.actionDuplicate = function() {
		var module = this;
		var cid = $('#publishers input[name="id"]').val()
		module.checkIn(cid);
		var id = $("#publishers").data("first");
		$.ajax({ type: "GET", url: "/", data: 'path=apps/publishers/modules/menues&request=createDuplicate&id=' + id, cache: false, success: function(mid){
			$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/publishers/modules/menues&request=getList", success: function(data){																																																																				
				$("#publishers1 ul[rel=menues]").html(data.html);
				var moduleidx = $("#publishers1 ul").index($("#publishers1 ul[rel=menues]"));
				var liindex = $("#publishers1 ul[rel=menues] .module-click").index($("#publishers1 ul[rel=menues] .module-click[rel='"+mid+"']"));
				module.getDetails(moduleidx,liindex);
				$("#publishers1 ul[rel=menues] .module-click:eq("+liindex+")").addClass('active-link');
				}
			});
			}
		});
	}
	
	
	this.actionBin = function() {
		var module = this;
		var cid = $('#publishers input[name="id"]').val()
		module.checkIn(cid);
		var txt = ALERT_DELETE;
		var langbuttons = {};
		langbuttons[ALERT_YES] = true;
		langbuttons[ALERT_NO] = false;
		$.prompt(txt,{ 
			buttons:langbuttons,
			submit: function(e,v,m,f){		
				if(v){
					var id = $("#publishers").data("first");
					//var pid = $("#publishers2 .module-click:visible").attr("rel");
					$.ajax({ type: "GET", url: "/", data: "path=apps/publishers/modules/menues&request=binMenue&id=" + id, cache: false, success: function(data){
							if(data == "true") {
								$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/publishers/modules/menues&request=getList", success: function(data){
									$("#publishers1 ul[rel=menues]").html(data.html);
									if(data.html == "<li></li>") {
										publishersActions(3);
									} else {
										publishersActions(0);
									}
									var moduleidx = $("#publishers1 ul").index($("#publishers1 ul[rel=menues]"));
									var liindex = 0;
									module.getDetails(moduleidx,liindex);
									$("#publishers1 ul[rel=menues] .module-click:eq("+liindex+")").addClass('active-link');
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
		var id = $("#publishers").data("first");
		$("#publishers1 ul[rel=menues] .active-link").trigger("click");
		$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/publishers/modules/menues&request=getList", success: function(data){																																																																				
			$("#publishers1 ul[rel=menues]").html(data.html);
			var liindex = $("#publishers1 ul[rel=menues] .module-click").index($("#publishers1 ul[rel=menues] .module-click[rel='"+id+"']"));
			$("#publishers1 ul[rel=menues] .module-click:eq("+liindex+")").addClass('active-link');
			}
		});
	}


	this.actionPrint = function() {
		var id = $("#publishers").data("first");
		var url ='/?path=apps/publishers/modules/menues&request=printDetails&id='+id;
		if(!iOS()) {
			$("#documentloader").attr('src', url);
		} else {
			window.open(url);
		}
	}


	this.actionSend = function() {
		var id = $("#publishers").data("first");
		$.ajax({ type: "GET", url: "/", data: "path=apps/publishers/modules/menues&request=getSend&id="+id, success: function(html){
			$("#modalDialogForward").html(html).dialog('open');
			}
		});
	}


	this.actionSendtoResponse = function() {
		var id = $("#publishers").data("first");
		$.ajax({ type: "GET", url: "/", data: "path=apps/publishers/modules/menues&request=getSendtoDetails&id="+id, success: function(html){
			$("#publishersmenue_sendto").html(html);
			//$("#modalDialogForward").dialog('close');
			}
		});
	}
	
	
	this.sortclick = function (obj,sortcur,sortnew) {
		var module = this;
		var cid = $('#publishers input[name="id"]').val()
		module.checkIn(cid);
		
		//var fid = $("#publishers2 .module-click:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/publishers/modules/menues&request=getList&sort="+sortnew, success: function(data){
			$("#publishers1 ul[rel=menues]").html(data.html);
			obj.attr("rel",sortnew);
			obj.removeClass("sort"+sortcur).addClass("sort"+sortnew);
			var id = $("#publishers1 ul[rel=menues] .module-click:eq(0)").attr("rel");
			$("#publishers").data("first",id);
			if(id == undefined) {
				return false;
			}
			var moduleidx = $("#publishers1 ul").index($("#publishers1 ul[rel=menues]"));
			var liindex = 0;
			module.getDetails(moduleidx,liindex);
			$("#publishers1 ul[rel=menues] .module-click:eq("+liindex+")").addClass('active-link');
		}
		});
	}


	this.sortdrag = function (order) {
		var fid = $("#publishers2 .module-click:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", data: "path=apps/publishers/modules/menues&request=setOrder&"+order+"&id="+fid, success: function(html){
			$("#publishers1 .sort:visible").attr("rel", "3");
			$("#publishers1 .sort:visible").removeClass("sort1").removeClass("sort2").addClass("sort3");
			}
		});
	}


	/*this.toggleIntern = function(id,status,obj) {
		$.ajax({ type: "GET", url: "/", data: "path=apps/publishers/modules/menues&request=toggleIntern&id=" + id + "&status=" + status, cache: false, success: function(data){
			if(data == "true") {
				obj.toggleClass("module-item-active")
			}
			}
		});
	}*/
	
	this.actionDialog = function(offset,request,field,append,title,sql) {
		switch(request) {
			case "getAccessDialog":
				$.ajax({ type: "GET", url: "/", data: 'path=apps/publishers&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
					$("#modalDialog").html(html);
					//$("#modalDialog").dialog('option', 'height', 50);
					$("#modalDialog").dialog('option', 'position', offset);
					$("#modalDialog").dialog('option', 'title', title);
					$("#modalDialog").dialog('open');
					}
				});
			break;
			case "getMenueStatusDialog":
				$.ajax({ type: "GET", url: "/", data: 'path=apps/publishers/modules/menues&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
					$("#modalDialog").html(html);
					$("#modalDialog").dialog('option', 'position', offset);
					$("#modalDialog").dialog('option', 'title', title);
					$("#modalDialog").dialog('open');
					}
				});
			break;
			case "getDocumentsDialog":
				var id = $("#publishers").data("first");
				$.ajax({ type: "GET", url: "/", data: 'path=apps/publishers/modules/documents&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql+'&id=' + id, success: function(html){
					$("#modalDialog").html(html);
					$("#modalDialog").dialog('option', 'position', offset);
					$("#modalDialog").dialog('option', 'title', title);
					$("#modalDialog").dialog('open');
					}
				});
			break;
			default:
			$.ajax({ type: "GET", url: "/", data: 'path=apps/publishers&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
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
		if(rel == 1) {
			var txt = ALERT_PUBLISHERS_ARCHIVE_OTHERS;
			var langbuttons = {};
			langbuttons[ALERT_YES] = true;
			langbuttons[ALERT_NO] = false;
			$.prompt(txt,{ 
				buttons:langbuttons,
				submit: function(e,v,m,f){		
					if(v){
						var id = $('#publishers input[name="id"]').val();
						var html = '<div class="listmember" field="publishersmenue_status" uid="'+rel+'" style="float: left">' + text + '</div>';
						$("#publishersmenue_status").html(html);
						$("#modalDialog").dialog("close");
						$("#publishersmenue_status").nextAll('img').trigger('click');
						$.ajax({ type: "GET", url: "/", data: 'path=apps/publishers/modules/menues&request=archiveOthers&id='+id, success: function(data){
							$('#publishers1 ul:eq(0) .module-click[rel!="'+id+'"]').find('.module-item-status').addClass('module-item-active');																										  
							}
						});
					} else {
						var html = '<div class="listmember" field="publishersmenue_status" uid="'+rel+'" style="float: left">' + text + '</div>';
						$("#publishersmenue_status").html(html);
						$("#modalDialog").dialog("close");
						$("#publishersmenue_status").nextAll('img').trigger('click');
					}
				}
			});
		} else {
			var html = '<div class="listmember" field="publishersmenue_status" uid="'+rel+'" style="float: left">' + text + '</div>';
			$("#publishersmenue_status").html(html);
			$("#modalDialog").dialog("close");
			$("#publishersmenue_status").nextAll('img').trigger('click');
		}
	}
	
	// menue Items
	this.saveItem = function(what) {
		var id = $("#publishers").data("first");
		var text = $("#input-text").val();
		$.ajax({ type: "POST", url: "/", data: { path: 'apps/publishers/modules/menues', request: 'saveItem', id: id, what: what, text: text }, success: function(data){
				//var note_text = $(document.createElement('div')).attr("id", "note-text").attr("class", "note-text").css("height",height).html(text);
				$("#"+what).html(data); 
				currentPublishersMenueItem = ''
			}
		});
	}

	
	
	this.actionHelp = function() {
		var url = "/?path=apps/publishers/modules/menues&request=getHelp";
		if(!iOS()) {
			$("#documentloader").attr('src', url);
		} else {
			window.open(url);
		}
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/publishers/modules/menues&request=deleteMenue&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#menue_'+id).slideUp();
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/publishers/modules/menues&request=restoreMenue&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#menue_'+id).slideUp();
						}
					}
					});
				} 
			}
		});
	}


}

var publishers_menues = new publishersMenues('publishers_menues');

var currentPublishersMenueItem = '';

$(document).ready(function() {
	
	$(document).on('dblclick', 'table.menue-grid td.edit', function(e) {
		e.preventDefault();
		var id = $(this).attr("id");
		if(currentPublishersMenueItem != '' && currentPublishersMenueItem != id) {
			publishers_menues.saveItem(currentPublishersMenueItem);
		} else {
		currentPublishersMenueItem = $(this).attr("id");
		var html = $(this).html().replace(/(<br\s*\/?>)|(<p><\/p>)/gi, "");
		var width = $(this).width();
		var height = $(this).height();
		var input = '<textarea id="input-text" name="input-text" class="elastic" style="text-align: center; width: '+ width +'px; height: '+ height +'px; border: 0;">' + html+ '</textarea>';
		$(this).html(input);
		$("#input-text").focus();
		}
	});
	
	
	$(document).mousedown(function(e) {
		var obj = getCurrentModule();
		if(obj.name == 'publishers_menues') {
			var clicked=$(e.target); // get the element clicked
			if(currentPublishersMenueItem != '') {
				if(clicked.is('.edit') || clicked.parents().is('.edit')) { 
					//return false;
				} else {
					publishers_menues.saveItem(currentPublishersMenueItem);
				}
			}
		}
	});

})