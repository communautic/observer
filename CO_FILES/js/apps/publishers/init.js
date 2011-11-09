function initPublishersContentScrollbar() {
	publishersInnerLayout.initContent('center');
}

/* publishers Object */
function publishersApplication(name) {
	this.name = name;
	
	this.formProcess = function(formData, form, poformOptions) {
		var title = $("#publishers input.title").fieldValue();
		if(title == "") {
			$.prompt(ALERT_NO_TITLE, {callback: setTitleFocus});
			return false;
		} else {
			formData[formData.length] = { "name": "title", "value": title };
		}
	
		formData[formData.length] = processListApps('folder');
		formData[formData.length] = processListApps('ordered_by');
		formData[formData.length] = processCustomTextApps('ordered_by_ct');
		formData[formData.length] = processListApps('management');
		formData[formData.length] = processCustomTextApps('management_ct');
		formData[formData.length] = processListApps('team');
		formData[formData.length] = processCustomTextApps('team_ct');
		formData[formData.length] = processListApps('status');
	}

	
	this.formResponse = function(data) {
		switch(data.action) {
			case "edit":
				$("#publishers2 span[rel='"+data.id+"'] .text").html($("#publishers .title").val());
				$("#durationStart").html($("input[name='startdate']").val());
				switch(data.status) {
					case "2":
						$("#publishers2 .active-link .module-item-status").addClass("module-item-active").removeClass("module-item-active-stopped");
					break;
					case "3":
						$("#publishers2 .active-link .module-item-status").addClass("module-item-active-stopped").removeClass("module-item-active");
					break;
					default:
						$("#publishers2 .active-link .module-item-status").removeClass("module-item-active").removeClass("module-item-active-stopped");
				}
			break;
			case "reload":
				$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/publishers&request=getPublisherDetails&id="+data.id, success: function(text){
					$("#publishers-right").html(text.html);
						initPublishersContentScrollbar();
					}
				});
			break;
		}
	}


	this.poformOptions = { beforeSubmit: this.formProcess, dataType: 'json', success: this.formResponse };


	this.actionNew = function() {
		var module = this;
		var cid = $('#publishers input[name="id"]').val()
		module.checkIn(cid);
		var id = $('#'+publishers.name+' .module-click:visible').attr("rel");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: 'path=apps/publishers&request=newPublisher&id=' + id, cache: false, success: function(data){
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/publishers&request=getPublisherList&id="+id, success: function(list){
				$("#publishers2 ul").html(list.html);
				var index = $("#publishers2 .module-click").index($("#publishers2 .module-click[rel='"+data.id+"']"));
				setModuleActive($("#publishers2"),index);
				$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/publishers&request=getPublisherDetails&id="+data.id, success: function(text){
					$("#publishers-right").html(text.html);
					initPublishersContentScrollbar();
					$('#publishers2 input.filter').quicksearch('#publishers2 li');
					$('#publishers-right .focusTitle').trigger('click');
					}
				});
				publishersActions(0);
				}
			});
			}
		});
	}


	this.actionDuplicate = function() {
		var module = this;
		var cid = $('#publishers input[name="id"]').val()
		module.checkIn(cid);
		var pid = $("#publishers2 .active-link").attr("rel");
		var oid = $("#publishers1 .module-click:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", data: 'path=apps/publishers&request=createDuplicate&id=' + pid, cache: false, success: function(id){
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/publishers&request=getPublisherList&id="+oid, success: function(data){
				$("#publishers2 ul").html(data.html);
					publishersActions(0);
					$('#publishers2 input.filter').quicksearch('#publishers2 li');
					var idx = $("#publishers2 .module-click").index($("#publishers2 .module-click[rel='"+id+"']"));
					setModuleActive($("#publishers2"),idx)
					$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/publishers&request=getPublisherDetails&id="+id, success: function(text){
							$("#"+publishers.name+"-right").html(text.html);
							initPublishersContentScrollbar();
							$('#publishers2 input.filter').quicksearch('#publishers2 li');
						}
					});
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
			callback: function(v,m,f){		
				if(v){
					var id = $("#publishers2 .active-link").attr("rel");
					var fid = $("#publishers .module-click:visible").attr("rel");
					$.ajax({ type: "GET", url: "/", data: "path=apps/publishers&request=binPublisher&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/publishers&request=getPublisherList&id="+fid, success: function(list){
								$("#publishers2 ul").html(list.html);
								if(list.html == "<li></li>") {
									publishersActions(3);
								} else {
									publishersActions(0);
									setModuleActive($("#publishers2"),0);
								}
								var id = $("#publishers2 .module-click:eq(0)").attr("rel");
								$("#publishers2 .module-click:eq(0)").addClass('active-link');
								$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/publishers&request=getPublisherDetails&fid="+fid+"&id="+id, success: function(text){
									$("#publishers-right").html(text.html);
									initPublishersContentScrollbar();
									$('#publishers2 input.filter').quicksearch('#publishers2 li');
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
		$.ajax({ type: "GET", url: "/", async: false, data: 'path=apps/publishers&request=checkinPublisher&id='+id, success: function(data){
				if(!data) {
					prompt("something wrong");
				}
			}
		});
	}


	this.actionRefresh = function() {
		var pid = $("#publishers2 .active-link").attr("rel");
		var oid = $("#publishers1 .module-click:visible").attr("rel");
		$("#publishers2 .active-link:visible").trigger("click");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/publishers&request=getPublisherList&id="+oid, success: function(data){
			$("#publishers2 ul").html(data.html);
			var idx = $("#publishers2 .module-click").index($("#publishers2 .module-click[rel='"+pid+"']"));
			$("#publishers2 .module-click:eq("+idx+")").addClass('active-link');
			$('#publishers2 input.filter').quicksearch('#publishers3 li');
			}
		});
	}
	
	this.actionHandbook = function() {
		var obj = getCurrentModule();
		if(obj.name == 'publishers') {
			var id = $("#publishers2 .active-link").attr("rel");
		} else {
			var id = $('#publishers2 .module-click:visible').attr("rel");
		}
		var url ='/?path=apps/publishers&request=printPublisherHandbook&id='+id;
		location.href = url;	
	}


	this.actionPrint = function() {
		var id = $("#publishers2 .active-link").attr("rel");
		var url ='/?path=apps/publishers&request=printPublisherDetails&id='+id;
		location.href = url;
	}


	this.actionSend = function() {
		var id = $("#publishers2 .active-link").attr("rel");
		$.ajax({ type: "GET", url: "/", data: "path=apps/publishers&request=getPublisherSend&id="+id, success: function(html){
			$("#modalDialogForward").html(html).dialog('open');
			}
		});
	}


	this.actionSendtoResponse = function() {
		var id = $("#publishers2 .active-link").attr("rel");
		$.ajax({ type: "GET", url: "/", data: "path=apps/publishers&request=getSendtoDetails&id="+id, success: function(html){
			$("#publisher_sendto").html(html);
			$("#modalDialogForward").dialog('close');
			}
		});
	}


	this.sortclick = function (obj,sortcur,sortnew) {
		var module = this;
		var cid = $('#publishers input[name="id"]').val()
		module.checkIn(cid);
		var fid = $("#publishers .module-click:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/publishers&request=getPublisherList&id="+fid+"&sort="+sortnew, success: function(data){
			$("#publishers2 ul").html(data.html);
			obj.attr("rel",sortnew);
			obj.removeClass("sort"+sortcur).addClass("sort"+sortnew);
			var id = $("#publishers2 .module-click:eq(0)").attr("rel");
			$('#publishers2').find('input.filter').quicksearch('#publishers2 li');
			if(id == undefined) {
				return false;
			}
			setModuleActive($("#publishers2"),'0');
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/publishers&request=getPublisherDetails&id="+id, success: function(text){
				$("#"+publishers.name+"-right").html(text.html);
				initPublishersContentScrollbar()
				}
			});
			}
		});
	}


	this.sortdrag = function (order) {
		var fid = $("#publishers .module-click:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", data: "path=apps/publishers&request=setPublisherOrder&"+order+"&id="+fid, success: function(html){
			$("#publishers2 .sort").attr("rel", "3");
			$("#publishers2 .sort").removeClass("sort1").removeClass("sort2").addClass("sort3");
			}
		});
	}
	
	
	this.actionDialog = function(offset,request,field,append,title,sql) {
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


	this.insertStatusDate = function(rel,text) {
		var html = '<div class="listmember" field="publishersstatus" uid="'+rel+'" style="float: left">' + text + '</div>';
		$("#publishersstatus").html(html);
		$("#modalDialog").dialog("close");
		$("#publishersstatus").nextAll('img').trigger('click');
	}
	
	
	this.insertFolderFromDialog = function(field,gid,title) {
		var html = '<a class="listmember" uid="' + gid + '" field="'+field+'">' + title + '</a>';
		$("#"+field).html(html);
		$("#modalDialog").dialog('close');
		var obj = getCurrentModule();
		$('#publishers .coform').ajaxSubmit(obj.poformOptions);
	}
	
	this.actionHelp = function() {
		var url = "/?path=apps/publishers&request=getPublishersHelp";
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/publishers&request=deletePublisher&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#publisher_'+id).slideUp();
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/publishers&request=restorePublisher&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#publisher_'+id).slideUp();
						}
					}
					});
				} 
			}
		});
	}


}

var publishers = new publishersApplication('publishers');
publishers.resetModuleHeights = publishersresetModuleHeights;
publishers.modules_height = publishers_num_modules*module_title_height;
publishers.GuestHiddenModules = new Array("controlling","access");

// register folder object
function publishersFolders(name) {
	this.name = name;
	
	
	this.formProcess = function(formData, form, poformOptions) {
		var title = $("#publishers input.title").fieldValue();
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
				$("#publishers1 span[rel='"+data.id+"'] .text").html($("#publishers .title").val());
			break;
		}
	}


	this.poformOptions = { beforeSubmit: this.formProcess, dataType: 'json', success: this.formResponse };

	
	this.actionNew = function() {
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/publishers&request=newFolder", cache: false, success: function(data){
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/publishers&request=getFolderList", success: function(list){
				$("#publishers1 ul").html(list.html);
				$("#publishers1 li").show();
				var index = $("#publishers1 .module-click").index($("#publishers1 .module-click[rel='"+data.id+"']"));
				setModuleActive($("#publishers1"),index);
				$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/publishers&request=getFolderDetails&id="+data.id, success: function(text){
					$("#"+publishers.name+"-right").html(text.html);
					initPublishersContentScrollbar();
					$('#publishers1 input.filter').quicksearch('#publishers1 li');
					$('#publishers-right .focusTitle').trigger('click');
					}
				});
				publishersActions(9);
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
					var id = $("#publishers1 .active-link").attr("rel");
					$.ajax({ type: "GET", url: "/", data: "path=apps/publishers&request=binFolder&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/publishers&request=getFolderList", success: function(data){
								$("#publishers1 ul").html(data.html);
								if(data.html == "<li></li>") {
									publishersActions(3);
								} else {
									publishersActions(9);
								}
								var id = $("#publishers1 .module-click:eq(0)").attr("rel");
								$("#publishers1 .module-click:eq(0)").addClass('active-link');
								$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/publishers&request=getFolderDetails&id="+id, success: function(text){
									$("#"+publishers.name+"-right").html(text.html);
									initPublishersContentScrollbar();
									$('#publishers1 input.filter').quicksearch('#publishers1 li');
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
		var id = $("#publishers1 .active-link").attr("rel");
		$("#publishers1 .active-link").trigger("click");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/publishers&request=getFolderList", success: function(data){
			$("#publishers1 ul").html(data.html);
			if(data.access == "guest") {
				publishersActions();
			} else {
				if(data.html == "<li></li>") {
					publishersActions(3);
				} else {
					publishersActions(9);
				}
			}
			var idx = $("#publishers1 .module-click").index($("#publishers1 .module-click[rel='"+id+"']"));
			$("#publishers1 .module-click:eq("+idx+")").addClass('active-link');
			$('#publishers1 input.filter').quicksearch('#publishers1 li');
			}
		});
	}


	this.actionPrint = function() {
		var id = $("#publishers1 .active-link").attr("rel");
		var url ='/?path=apps/publishers&request=printFolderDetails&id='+id;
		location.href = url;
	}


	this.actionSend = function() {
		var id = $("#publishers1 .active-link").attr("rel");
		$.ajax({ type: "GET", url: "/", data: "path=apps/publishers&request=getFolderSend&id="+id, success: function(html){
			$("#modalDialogForward").html(html).dialog('open');
			}
		});
	}


	this.actionSendtoResponse = function() {
		//var id = $("#publishers1 .active-link").attr("rel");
		//$.ajax({ type: "GET", url: "/", data: "path=apps/publishers&request=getSendtoDetails&id="+id, success: function(html){
			//$("#publisher_sendto").html(html);
			$("#modalDialogForward").dialog('close');
			//}
		//});
	}

	
	this.sortclick = function (obj,sortcur,sortnew) {
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/publishers&request=getFolderList&sort="+sortnew, success: function(data){
			$("#publishers1 ul").html(data.html);
			obj.attr("rel",sortnew);
		  	obj.removeClass("sort"+sortcur).addClass("sort"+sortnew);
			$('#publishers1 input.filter').quicksearch('#publishers1 li');
			var id = $("#publishers1 .module-click:eq(0)").attr("rel");
			$("#publishers1 .module-click:eq(0)").addClass('active-link');
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/publishers&request=getFolderDetails&id="+id, success: function(text){
				$("#publishers-right").html(text.html);
				initPublishersContentScrollbar()
				}
			});
			}
		});
	}


	this.sortdrag = function (order) {
		$.ajax({ type: "GET", url: "/", data: "path=apps/publishers&request=setFolderOrder&"+order, success: function(html){
			$("#publishers1 .sort").attr("rel", "3");
			$("#publishers1 .sort").removeClass("sort1").removeClass("sort2").addClass("sort3");
			}
		});
	}
	
	
	this.actionDialog = function(offset,request,field,append,title,sql) {
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


	this.actionHelp = function() {
		var url = "/?path=apps/publishers&request=getPublishersFoldersHelp";
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/publishers&request=deleteFolder&id=" + id, cache: false, success: function(data){
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/publishers&request=restoreFolder&id=" + id, cache: false, success: function(data){
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

var publishers_folder = new publishersFolders('publishers_folder');


function publishersActions(status) {
	/*	0= new	1= print	2= send		3= duplicate	4= handbook		5=refresh 	6 = delete*/
	switch(status) {
		//case 0: 	actions = ['0','1','2','3','4']; break; // all actions
		case 0: actions = ['0','1','2','3','4','5','6','7']; break;
		//case 1: 	actions = ['0','1','2','4']; break; 	// no duplicate
		case 1: actions = ['0','5','6','7']; break;
		//case 2: 	actions = ['1']; break;   					// just save
		case 3: 	actions = ['0','6']; break;   					// just new
		case 4: 	actions = ['0','1','2','4','5','6']; break;   		// new, print, send, handbook, refresh
		case 5: 	actions = ['1','2','5','6']; break;   			// print, send, refresh
		case 6: 	actions = ['4','5','6']; break;   			// handbook refresh
		case 7: 	actions = ['0','1','2','5','6']; break;   			// new, print, send, refresh
		case 8: 	actions = ['1','2','4','5','6']; break;   			// print, send, handbook, refresh
		case 9:		actions = ['0','1','2','5','6','7']; break;
		default: 	actions = ['5','6'];  								// none
	}
	$('#publishersActions > li span').each( function(index) {
		if(index in oc(actions)) {
			$(this).removeClass('noactive');
		} else {
			$(this).addClass('noactive');
		}
	})
}


function publishersloadModuleStart() {
	var h = $("#publishers .ui-layout-west").height();
	$("#publishers1 h3:eq(0)").addClass("module-bg-active")
	$("#publishers1 .module-inner").css("height", h-71);
	$("#publishers1 .module-actions:eq(0)").show();
	$("#publishers1 .module-actions:eq(1)").hide();
	$(".publishers1-content").css("height", h-71);
	//$(".publishers1-content").css("height", h-(publishers.modules_height*2+71));
	$("#publishers-current").val("menues");
	$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/publishers/modules/menues&request=getList", success: function(data){
		  $("#publishers1 ul:eq(0)").html(data.html);
		  $("#publishersActions .actionNew").attr("title",data.title);
		  
		  if(data.html == "<li></li>") {
			  publishersActions(0);
		  } else {
			  publishersActions(1);
			  $('#publishers1').find('input.filter').quicksearch('#publishers1 li');
		  }
		  var id = $("#publishers1 ul:eq(0) .module-click:eq(0)").attr("rel");
		  $("#publishers1 .sort").attr("rel", data.sort).addClass("sort"+data.sort);
		  var id = $("#publishers1 .module-click:eq(0)").attr("rel");
		  $("#publishers1 .module-click:eq(0)").addClass('active-link');
		  $.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/publishers/modules/menues&request=getDetails&id="+id, success: function(data){
			  $("#publishers-right").html(data.html);
			  publishersInnerLayout.initContent('center');
			  }
		  });
		}
	});
}






/*function publishersloadModuleStart() {
	var h = $("#publishers .ui-layout-west").height();
	$("#publishers1 .module-inner").css("height", h-71);
	$("#publishers1 .module-actions").show();
	$("#publishers2 .module-actions").hide();
	$("#publishers2 li").show();
	$("#publishers2").css("height", h-96).removeClass("module-active");
	$("#publishers2 .module-inner").css("height", h-96);
	$("#publishers3 .module-actions").hide();
	$("#publishers3").css("height", h-121);
	$("#publishers3 .publishers3-content").css("height", h-(publishers.modules_height+121));
	$("#publishers-current").val("folder");
	$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/publishers&request=getFolderList", success: function(data){
		$("#publishers1 ul").html(data.html);
		$("#publishersActions .actionNew").attr("title",data.title);
		
		if(data.access == "guest") {
			publishersActions();
		} else {
			if(data.html == "<li></li>") {
				publishersActions(3);
			} else {
				publishersActions(9);
			}
		}
		
		$("#publishers1").css("overflow", "auto").animate({height: h-71}, function() {
			$("#publishers1 li").show();
			$("#publishers1 .sort").attr("rel", data.sort).addClass("sort"+data.sort);
			publishersInnerLayout.initContent('center');
			//initScrollbar( '#publishers .scrolling-content' );
			$('#publishers1 input.filter').quicksearch('#publishers1 li');
			$("#publishers3 .publishers3-content").hide();
			var id = $("#publishers1 .module-click:eq(0)").attr("rel");
			$("#publishers1 .module-click:eq(0)").addClass('active-link');
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/publishers&request=getFolderDetails&id="+id, success: function(text){
				$("#"+publishers.name+"-right").html(text.html);
				publishersInnerLayout.initContent('center');
				$('#publishers1 input.filter').quicksearch('#publishers1 li');
				$("#publishers3 .publishers3-content").hide();
				}
			});
		});
	}
	});
}*/


function publishersresetModuleHeights() {
	var h = $("#publishers .ui-layout-west").height();
	$(".publishers1-content").css("height", h-71);
	$("#publishers1 .module-inner").css("height", h-71);
}

function PublishersModulesDisplay(access) {
	var h = $("#publishers .ui-layout-west").height();
	if(access == "guest" || access == "guestadmin") {
		var modLen = publishers.GuestHiddenModules.length;
		var m;
		for(var i=0, len=modLen; i<len; ++i) {
			m = $('h3[rel="'+publishers.GuestHiddenModules[i]+'"]');
			m.hide();
		}
		publishers.modules_height = publishers_num_modules*module_title_height - modLen*module_title_height;
		$("#publishers3 .publishers3-content").css("height", h-(publishers.modules_height+121));
	} else {
		var modLen = publishers.GuestHiddenModules.length;
		var m;
		for(var i=0, len=modLen; i<len; ++i) {
			m = $('h3[rel="'+publishers.GuestHiddenModules[i]+'"]');
			m.show();
		}
		publishers.modules_height = publishers_num_modules*module_title_height;
		$("#publishers3 .publishers3-content").css("height", h-(publishers.modules_height+121));
	}
}


var publishersLayout, publishersInnerLayout;

$(document).ready(function() {
						   
	if($('#publishers').length > 0) {
		publishersLayout = $('#publishers').layout({
				west__onresize:				function() { publishersresetModuleHeights() }
			,	resizeWhileDragging:		true
			,	spacing_open:				0
			,	closable: 				false
			,	resizable: 				false
			,	slidable:				false
			, 	west__size:				325
			,	west__closable: 		true
			,	west__resizable: 		true
			, 	south__size:			10
			,	center__onresize: "publishersInnerLayout.resizeAll"
			
		});
		
		publishersInnerLayout = $('#publishers div.ui-layout-center').layout({
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
		
		publishersloadModuleStart();
	}

	/**
	* show publishers list
	*/
	$("#publishers1 h3").click(function(event, passed_id) {
		
		if(confirmNavigation()) {
			formChanged = false;
			var obj = getCurrentModule();
			$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		}
		
		var moduleidx = $("#publishers1 h3").index(this);
		var module = $(this).attr("rel");
		var h3click = $(this);

		// module open and  active 
		if($(this).hasClass("module-bg-active")) {
			return false;
		} else {
		$("#publishers1 h3").removeClass("module-bg-active");
				
		h3click.addClass("module-bg-active")
			.next('div').slideDown( function() {
				/*var what;
				if(module == "groups") {
					what = "Group";
				} else {
					what = "Contact";
				}*/
				$("#publishers-current").val(module);
				
				$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/publishers/modules/"+module+"&request=getList", success: function(data){					
					$("#publishers1 ul:eq("+moduleidx+")").html(data.html);
					$("#publishersActions .actionNew").attr("title",data.title);
					
					if(data.html == "<li></li>") {
						publishersActions(0);
					} else {
						publishersActions(1);
						$('#publishers1').find('input.filter').quicksearch('#publishers1 li');
					}
				
					if(passed_id === undefined) {
						var idx = 0;
					} else {
						var idx = $("#publishers1 ul:eq("+moduleidx+") .module-click").index($("#publishers1 ul:eq("+moduleidx+") .module-click[rel='"+passed_id+"']"));
					}

					$("#publishers1 ul:eq("+moduleidx+") .module-click:eq("+idx+")").addClass('active-link');
					$("#publishers1 .module-actions:visible").hide();
					var obj = getCurrentModule();
					obj.getDetails(moduleidx,idx);
					$(this).prev("h3").removeClass("module-bg-active");	
					$("#publishers1 .module-actions:eq("+moduleidx+")").show();
					$("#publishers1 .sort:eq("+moduleidx+")").attr("rel", data.sort).addClass("sort"+data.sort);
					}
				});			 
			})
			.siblings('div:visible').slideUp()
		
			
		}
		return false;
	});


	$("#publishers1 .module-click").live('click',function() {
		
		if(confirmNavigation()) {
			formChanged = false;
			var obj = getCurrentModule();
			$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		}
		
		$("#publishers1 .module-click").removeClass("active-link");
		$(this).addClass("active-link");
		var module = $(this).parents("ul").attr("rel");
		var ulidx = $("#publishers1 ul").index($(this).parents("ul"));
		
		var id = $(this).attr("rel");
		var index = $("#publishers1 ul:eq("+ulidx+") .module-click").index($("#publishers1 ul:eq("+ulidx+") .module-click[rel='"+id+"']"));
		//console.log(index);
		var obj = getCurrentModule();
		obj.getDetails(ulidx,index);
		
		/*$.ajax({ type: "GET", url: "/", data: "path=apps/publishers/modules/"+module+"&request=getDetails&id="+id, success: function(html){
			$("#publishers-right").html(html);
			initContactsContentScrollbar()
			}
		});
		publishersActions(1);*/
		return false;
	});


    $("#publishers .loadModuleStart").click(function() {
		loadModuleStart();
		return false;
	});

 
    /*$("#publishers .loadModuleStart").click(function() {
		loadModuleStart();
		return false;
	});*/
  
	
	/*$('a.insertAccess').live('click',function() {
		var rel = $(this).attr("rel");
		var field = $(this).attr("field");
		var html = '<div class="listmember" field="'+field+'" uid="'+rel+'">' + $(this).html() + '</div>';
		$("#"+field).html(html);
		$("#modalDialog").dialog("close");
		var obj = getCurrentModule();
		$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		return false;
	});*/
	
	
	
	$('a.insertPublisherFolderfromDialog').livequery('click',function(e) {
		e.preventDefault();
		var field = $(this).attr("field");
		var gid = $(this).attr("gid");
		var title = $(this).attr("title");
		var obj = getCurrentModule();
		obj.insertFolderFromDialog(field,gid,title);
	});
	

	/*$('a.insertPublisherFolderfromDialog').livequery('click',function() {
		var field = $(this).attr("field");
		var gid = $(this).attr("gid");
		var title = $(this).attr("title");
		var html = '<a class="listmember" uid="' + gid + '" field="'+field+'">' + title + '</a>';
		$("#"+field).html(html);
		$("#modalDialog").dialog('close');
		var obj = getCurrentModule();
		$('#publishers .coform').ajaxSubmit(obj.poformOptions);
	});*/
	
	
// INTERLINKS FROM Content
	
	// load a publisher
	$(".loadPublisher").live('click', function() {
		
		var obj = getCurrentModule();
		if(confirmNavigation()) {
			formChanged = false;
			$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		}
		
		var id = $(this).attr("rel");
		$("#publishers2-outer > h3").trigger('click', [id]);
		return false;
	});

	
	// load a phase
	$(".loadPublishersPhase").live('click', function() {
		
		var obj = getCurrentModule();
		if(confirmNavigation()) {
			formChanged = false;
			$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		}
		var cid = $('#publishers input[name="id"]').val()
		obj.checkIn(cid);
		
		var id = $(this).attr("rel");
		$("#publishers3 h3[rel='phases']").trigger('click', [id]);
		return false;
	});
	
	$(".loadPublishersPhase2").live('click', function() {
		var id = $(this).attr("rel");
		$("#publishers3 h3[rel='phases']").trigger('click', [id]);
		return false;
	});


	$('span.actionPublisherHandbook').click(function(){
		if($(this).hasClass("noactive")) {
			return false;
		}
		publishers.actionHandbook();
		return false;
	});

	
	// barchart opacity with jquery
	$(".barchart-phase-bg").livequery( function() {
		$(this).css("opacity","0.3");
	});

	$("#todayBar").livequery( function() {
		$(this).css("opacity","0.4");
	});
	// becomes global Tooltip?
	$(".coTooltip").livequery( function() {
		$(this).tooltip({
			track: true,
			delay: 0,
			fade: 200,
			bodyHandler: function() { 
				return $(this).find(".coTooltipHtml").html(); 
			}, 
			showURL: false 
		});
	});


});