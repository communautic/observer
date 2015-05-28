function initArchivesContentScrollbar() {
	archivesInnerLayout.initContent('center');
}

/* archives Object */
function archivesApplication(name) {
	this.name = name;
	this.isRefresh = false;
	
	this.init = function() {
		this.$app = $('#archives');
		this.$appContent = $('#archives-right');
		this.$first = $('#archives1');
		this.$second = $('#archives2');
		this.$third = $('#archives3');
		this.$thirdDiv = $('#archives3 div.thirdLevel');
		this.$layoutWest = $('#archives div.ui-layout-west');
	}

 
	this.formProcess = function(formData, form, poformOptions) {
		var title = $("#archives input.title").fieldValue();
		if(title == "") {
			setTimeout(function() {
				title = $("#archives input.title").fieldValue();
				if(title == "") {
					$.prompt(ALERT_NO_TITLE, {submit: setTitleFocus});
				}
			}, 5000)
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
	}

	
	this.formResponse = function(data) {
		switch(data.action) {
			case "edit":
				$("#archives2 span[rel='"+data.id+"'] .text").html($("#archives .title").val());
				$("#archiveDurationStart").html($("input[name='startdate']").val());
			break;
			case "reload":
				$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/archives&request=getArchiveDetails&id="+data.id, success: function(text){
					$("#archives-right").html(text.html);
						initArchivesContentScrollbar();
					}
				});
			break;
		}
	}


	this.poformOptions = { beforeSubmit: this.formProcess, dataType: 'json', success: this.formResponse };


	this.statusOnClose = function(dp) {
		var id = $("#archives").data("second");
		var status = $("#archives .statusTabs li span.active").attr('rel');
		var date = $("#archives .statusTabs input").val();
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/archives&request=updateStatus&id=" + id + "&date=" + date + "&status=" + status, cache: false, success: function(data){
				switch(data.status) {
					case "2":
						$("#archives2 span[rel='"+data.id+"'] .module-item-status").addClass("module-item-active").removeClass("module-item-active-stopped");
					break;
					case "3":
						$("#archives2 span[rel='"+data.id+"'] .module-item-status").addClass("module-item-active-stopped").removeClass("module-item-active");
					break;
					default:
						$("#archives2 span[rel='"+data.id+"'] .module-item-status").removeClass("module-item-active").removeClass("module-item-active-stopped");
				}																																				 			}
		});
	}
	

	
	



	this.actionClose = function() {
		archivesLayout.toggle('west');
	}


	this.getNavModulesNumItems = function(id) {
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: 'path=apps/archives&request=getNavModulesNumItems&id=' + id, success: function(data){
				$.each( data, function(k, v){
   					$('#'+k).html(v);
 				});
			}
		});
	}



	this.inlineDatepickerOnClose = function(dp) {
		var start = $("#archives input[name='startdate']").val();
		var end = $("#archives input[name='enddate']").val();
		if (dp.name == 'startdate' && end != ''){
			if(Date.parse(end) < Date.parse(dp.value)) {
				$("#archives input[name='enddate']").val(dp.value)
			}
		}
	}




	this.actionBin = function() {
		var mod = this;
		
		var module = $("#archives").data("first");
		var moduleFirst = module.substr(0, 1);
		var moduleCaps = moduleFirst.toUpperCase() + module.substr(1);
		var moduleCapsSingular = moduleCaps.slice(0,-1);
		
		
		var cid = $('#archives input[name="id"]').val()
		//module.checkIn(cid);
		var txt = ALERT_DELETE;
		var langbuttons = {};
		langbuttons[ALERT_YES] = true;
		langbuttons[ALERT_NO] = false;
		$.prompt(txt,{ 
			buttons:langbuttons,
			submit: function(e,v,m,f){		
				if(v){
					var id = $("#archives").data("second");
					var fid = $("#archives").data("first");
					$.ajax({ type: "GET", url: "/", data: 'path=apps/'+module+'&request=bin'+moduleCapsSingular+'&id=' + id, cache: false, success: function(data){
						if(data == "true") {
							$("#archives2 .module-click:eq(0)").trigger("click");
							mod.actionRefresh();
							/*$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/'+module+&request=getArchiveList&id="+fid, success: function(list){
								$("#archives2 ul").html(list.html);
								if(list.html == "<li></li>") {7
									archivesActions(3);
								} else {
									archivesActions(0);
									setModuleActive($("#archives2"),0);
								}
								var id = $("#archives2 .module-click:eq(0)").attr("rel");
								if(typeof id == 'undefined') {
									$("#archives").data("second", 0);
								} else {
									$("#archives").data("second", id);
								}
								$("#archives2 .module-click:eq(0)").addClass('active-link');
								$.ajax({ type: "GET", url: "/", dataType:  'json', data: 'path=apps/'+module+'&request=get'+moduleCapsSingular+'DetailsArchive&fid='+fid+'&id='+id, success: function(text){
									$("#archives-right").html(text.html);
									initArchivesContentScrollbar();
									module.getNavModulesNumItems(id);
									}
								});
							}
							});*/
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
		var module = $("#archives").data("first");
		var moduleFirst = module.substr(0, 1);
		var moduleCaps = moduleFirst.toUpperCase() + module.substr(1);
		var moduleCapsSingular = moduleCaps.slice(0,-1);
		
		var pid = $('#archives').data('second');
		$("#archives2 .active-link").trigger("click");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: 'path=apps/'+module+'&request=getArchiveList', success: function(data){
			$("#archives2 ul").html(data.html);
			var idx = $("#archives2 .module-click").index($("#archives2 .module-click[rel='"+pid+"']"));
			$("#archives2 .module-click:eq("+idx+")").addClass('active-link');
			}
		});
	}
	
	this.actionHandbook = function() {
		var id = $("#archives").data("second");
		var url ='/?path=apps/archives&request=printArchiveHandbook&id='+id;
		$("#documentloader").attr('src', url);	
	}


	this.actionPrint = function() {
		//var module = $("#archives").data("first");
		var module = $("#archives").data("first");
		var moduleFirst = module.substr(0, 1);
		var moduleCaps = moduleFirst.toUpperCase() + module.substr(1);
		var moduleCapsSingular = moduleCaps.slice(0,-1);
		var id = $("#archives").data("second");
		var url ='/?path=apps/'+module+'&request=print'+moduleCapsSingular+'Details&id='+id;
		$("#documentloader").attr('src', url);
	}


	this.actionSend = function() {
		var module = $("#archives").data("first");
		var moduleFirst = module.substr(0, 1);
		var moduleCaps = moduleFirst.toUpperCase() + module.substr(1);
		var moduleCapsSingular = moduleCaps.slice(0,-1);
		
		var id = $("#archives").data("second");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: 'path=apps/'+module+'&request=get'+moduleCapsSingular+'Send&id='+id, success: function(data){
			$("#modalDialogForward").html(data.html).dialog('open');
			if(data.error == 1) {
				$.prompt('<div style="text-align: center">' + ALERT_REMOVE_RECIPIENT + data.error_message + '<br /></div>');
				return false;
			}
			}
		});
	}


	this.actionSendtoResponse = function() {
		//$("#modalDialogForward").dialog('close');
		var module = $("#archives").data("first");
		var moduleFirst = module.substr(0, 1);
		var moduleCaps = moduleFirst.toUpperCase() + module.substr(1);
		var moduleCapsSingular = moduleCaps.slice(0,-1);
		var moduleSingular = module.slice(0,-1);
		
		var id = $("#archives").data("second");
		$.ajax({ type: "GET", url: "/", data: 'path=apps/'+module+'&request=getSendtoDetails&id='+id, success: function(html){
			$("#"+moduleSingular+"_sendto").html(html);
			}
		});
	}
	
	// meta dialog
	this.actionDialog = function(offset,request,field,append,title,sql) {
		var module = $("#archives").data("first");
		var id = $("#archives").data("second");
		if(request == 'archiveMeta') {
			$.ajax({ type: "GET", url: "/", data: 'path=apps/archives&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql+'&module='+module+'&id='+id, success: function(html){
			$("#modalDialog").html(html);
			$("#modalDialog").dialog('option', 'position', offset);
			$("#modalDialog").dialog('option', 'title', title);
			$("#modalDialog").dialog('open');
			/*if($("#" + field + "_ct .ct-content").length > 0) {
				var ct = $("#" + field + "_ct .ct-content").html();
				ct = ct.replace(CUSTOM_NOTE + " ","");
				$("#custom-text").val(ct);
			}*/
			}
		});
		} else {
			$.ajax({ type: "GET", url: "/", data: 'path=apps/'+module+'&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql+'&module='+module+'&id='+id, success: function(html){
			$("#modalDialog").html(html);
			$("#modalDialog").dialog('option', 'position', offset);
			$("#modalDialog").dialog('option', 'title', title);
			$("#modalDialog").dialog('open');
			/*if($("#" + field + "_ct .ct-content").length > 0) {
				var ct = $("#" + field + "_ct .ct-content").html();
				ct = ct.replace(CUSTOM_NOTE + " ","");
				$("#custom-text").val(ct);
			}*/
			}
		});
		}
		
	}
	
	this.insertFolderFromDialog = function(field,gid,title) {
		var html = '<span class="listmember" uid="' + gid + '" field="'+field+'">' + title + '</span>';
		$("#"+field).html(html);
		$("#modalDialog").dialog('close');
	}


	
	this.actionHelp = function() {
		var url = "/?path=apps/archives&request=getArchivesHelp";
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/archives&request=deleteArchive&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#archive_'+id).slideUp();
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/archives&request=restoreArchive&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#archive_'+id).slideUp();
						}
					}
					});
				} 
			}
		});
	}
	
	this.showItemContext = function(ele,uid,field) {
		var module = this;
		var html = '<div class="context" style="height: 50px; display: block;"><div class="dialog-text"><div style="padding: 10px;"><div class="coButton-outer"><span id="archiveDeleteMeta"class="coButton alert">L&ouml;schen</span></div></div></div></div>'
		ele.parent().append(html);
			ele.next().slideDown();
		//alert('clicked');
		/*$.ajax({ type: "GET", url: "/", data: 'path=apps/'+ module.app +'/modules/documents&request=getDocContext&id='+uid+'&field='+field, success: function(html){
			
			}
		});*/
	}
	


}

var archives = new archivesApplication('archives');
archives.modules_height = archives_num_modules*module_title_height;
archives.GuestHiddenModules = new Array("controlling","access");


// register folder object
function archivesFolders(name) {
	this.name = name;


	this.formProcess = function(formData, form, poformOptions) {
		var title = $("#archives input.title").fieldValue();
		if(title == "") {
			setTimeout(function() {
				title = $("#archives input.title").fieldValue();
				if(title == "") {
					$.prompt(ALERT_NO_TITLE, {submit: setTitleFocus});
				}
			}, 5000)
			return false;
		} else {
			formData[formData.length] = { "name": "title", "value": title };
		}
	}
	
	
	this.formResponse = function(data) {
		switch(data.action) {
			case "edit":
				$("#archives1 span[rel='"+data.id+"'] .text").html($("#archives .title").val());
			break;
		}
	}


	this.poformOptions = { beforeSubmit: this.formProcess, dataType: 'json', success: this.formResponse };

	
	this.actionNew = function() {
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/archives&request=newFolder", cache: false, success: function(data){
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/archives&request=getFolderList", success: function(list){
				$("#archives1 ul").html(list.html);
				$("#archives1 li").show();
				var index = $("#archives1 .module-click").index($("#archives1 .module-click[rel='"+data.id+"']"));
				setModuleActive($("#archives1"),index);
				$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/archives&request=getFolderDetails&id="+data.id, success: function(text){
					$("#archives").data("first",data.id);
					$("#archives-right").html(text.html);
					initArchivesContentScrollbar();
					$('#archives-right .focusTitle').trigger('click');
					}
				});
				archivesActions(9);
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
					var id = $("#archives").data("first");
					$.ajax({ type: "GET", url: "/", data: "path=apps/archives&request=binFolder&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/archives&request=getFolderList", success: function(data){
								$("#archives1 ul").html(data.html);
								if(data.html == "<li></li>") {
									archivesActions(3);
								} else {
									archivesActions(9);
								}
								var id = $("#archives1 .module-click:eq(0)").attr("rel");
								if(typeof id == 'undefined') {
									$("#archives").data("first",0);
								} else {
									$("#archives").data("first",id);
								}
								$("#archives1 .module-click:eq(0)").addClass('active-link');
								$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/archives&request=getFolderDetails&id="+id, success: function(text){
									$("#"+archives.name+"-right").html(text.html);
									initArchivesContentScrollbar();
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


	this.actionLoadTab = function(what) {
		var id = $("#archives").data("first");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: 'path=apps/archives&request=get'+what+'&id='+id, success: function(data){
			$('#archivesFoldersTabsContent').empty().html(data.html);
			initArchivesContentScrollbar()
			}
		});
	}


	this.actionLoadSubTab = function(view) {
		var id = $("#archives").data("first");
		var what = $('#archivesFoldersTabs ul.contentTabsList span[class=active]').attr('rel');
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: 'path=apps/archives&request=get'+what+'&view='+view+'&id='+id, success: function(data){
			$('#archivesFoldersTabsContent').empty().html(data.html);
			initArchivesContentScrollbar()
			}
		});
	}


	this.loadBarchartZoom = function(zoom) {
		var id = $("#archives").data("first");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: 'path=apps/archives&request=getFolderDetailsMultiView&id='+id+'&zoom='+zoom, success: function(data){
			$('#archivesFoldersTabsContent').html(data.html);
			initArchivesContentScrollbar()
			}
		});
	}


	this.actionRefresh = function() {
		archives.isRefresh = true;
		var id = $("#archives").data("first");
		$("#archives1 .active-link").trigger("click");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/archives&request=getFolderList", success: function(data){
			$("#archives1 ul").html(data.html);
			if(data.access == "guest") {
				archivesActions();
			} else {
				if(data.html == "<li></li>") {
					archivesActions(3);
				} else {
					archivesActions(9);
				}
			}
			var idx = $("#archives1 .module-click").index($("#archives1 .module-click[rel='"+id+"']"));
			$("#archives1 .module-click:eq("+idx+")").addClass('active-link');
			}
		});
	}


	this.actionPrint = function() {
		var id = $("#archives").data("first");
		var what = $('#archivesFoldersTabs ul.contentTabsList span[class=active]').attr('rel');
		if(what == 'FolderDetailsMultiView') {
			var view= $('#archivesFoldersSubTabs ul span[class~=active]').attr('rel');
			what = what + '&view=' + view;
		}
		var url ='/?path=apps/archives&request=print'+what+'&id='+id;
		$("#documentloader").attr('src', url);
	}


	this.actionSend = function() {
		var id = $("#archives").data("first");
		var what = $('#archivesFoldersTabs ul.contentTabsList span[class=active]').attr('rel');
		if(what == 'FolderDetailsMultiView') {
			var view= $('#archivesFoldersSubTabs ul span[class~=active]').attr('rel');
			what = what + '&view=' + view;
		}
		$.ajax({ type: "GET", url: "/", data: 'path=apps/archives&request=getSend'+what+'&id='+id, success: function(html){
			$("#modalDialogForward").html(html).dialog('open');
			}
		});
	}


	this.actionSendtoResponse = function() {
		//$("#modalDialogForward").dialog('close');
	}

	
	this.sortclick = function (obj,sortcur,sortnew) {
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/archives&request=getFolderList&sort="+sortnew, success: function(data){
			$("#archives1 ul").html(data.html);
			obj.attr("rel",sortnew);
		  	obj.removeClass("sort"+sortcur).addClass("sort"+sortnew);
			var id = $("#archives1 .module-click:eq(0)").attr("rel");
			$('#archives').data('first',id);
			$("#archives1 .module-click:eq(0)").addClass('active-link');
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/archives&request=getFolderDetails&id="+id, success: function(text){
				$("#archives-right").html(text.html);
				initArchivesContentScrollbar()
				}
			});
			}
		});
	}


	this.sortdrag = function (order) {
		$.ajax({ type: "GET", url: "/", data: "path=apps/archives&request=setFolderOrder&"+order, success: function(html){
			$("#archives1 .sort").attr("rel", "3");
			$("#archives1 .sort").removeClass("sort1").removeClass("sort2").addClass("sort3");
			}
		});
	}
	
	
	this.actionDialog = function(offset,request,field,append,title,sql) {
		$.ajax({ type: "GET", url: "/", data: 'path=apps/archives&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
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
		var url = "/?path=apps/archives&request=getArchivesFoldersHelp";
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/archives&request=deleteFolder&id=" + id, cache: false, success: function(data){
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/archives&request=restoreFolder&id=" + id, cache: false, success: function(data){
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

var archives_folder = new archivesFolders('archives_folder');


function archivesActions(status) {
	/*	0= new	1= print	2= send		3= duplicate	4= handbook		5=refresh 	6 = delete*/
	switch(status) {
		case 0: actions = ['0','1','2','3','4','5','6']; break;
		case 1: actions = ['0','1','3','5']; break;
		case 2: actions = ['3','5']; break;
		/*case 3: 	actions = ['0','6','7']; break;   					// just new
		case 4: 	actions = ['0','1','2','5','6','7']; break;   		// new, print, send, handbook, refresh
		case 5: 	actions = ['1','2','6','7']; break;   			// print, send, refresh
		case 6: 	actions = ['5','6','7']; break;   			// handbook refresh
		case 7: 	actions = ['0','1','2','6','7']; break;   			// new, print, send, refresh
		case 8: 	actions = ['1','2','5','6','7']; break;   			// print, send, handbook, refresh
		case 9:		actions = ['0','1','3','5']; break;
		// vdocs
		// 0 == 10
		case 10: actions = ['0','1','2','3','4','5','6','7','8']; break;
		// 5 == 11
		case 11: 	actions = ['1','2','4','6','7']; break;   			// print, send, refresh*/
		default: 	actions = ['6','7'];  								// none
	}
	$('#archivesActions > li span').each( function(index) {
		if(index in oc(actions)) {
			$(this).removeClass('noactive');
		} else {
			$(this).addClass('noactive');
		}
	})
}


/*function archivesloadModuleStart() {
	var h = $("#archives .ui-layout-west").height();
	$("#archives .ui-layout-west .radius-helper").height(h);
	$('#archives .secondLevelOuter').css('top',h-27);
		if($("#archives1").height() != module_title_height) {
		$("#archives1").css("height", h-98);
		$("#archives1 .module-inner").css("height", h-98);
	}
	$("#archives-current").val("archives");
	archivesActions(0);
	
	
	$.ajax({ type: "GET", url: "/", data: "path=apps/archives&request=getFolderList", success: function(html){
		
		$('#archives1 ul').html(html);
		$("#archives1 .module-click:eq(0)").addClass('active-link');
					var id = $("#archives1 .module-click:eq(0)").attr("rel");
					$.ajax({ type: "GET", url: "/", data: "path=apps/"+ id +"&request=getArchive", success: function(html){
		$("#archives-right").html(html);
		archivesInnerLayout.initContent('center');
		}
	});}
		   });
	
}*/



var archivesLayout, archivesInnerLayout;


$(document).ready(function() {
	
	archives.init();
	
	if($('#archives').length > 0) {
		archivesLayout = $('#archives').layout({
				west__onresize:				function() { resetModuleHeightsnavThreeArchives('archives'); }
			,	resizeWhileDragging:		true
			,	spacing_open:				0
			,	spacing_closed:				0
			,	closable: 					false
			,	resizable: 					false
			,	slidable:					false
			, 	west__size:					325
			,	west__closable: 			true
			,	center__onresize: 			"archivesInnerLayout.resizeAll"
		});
		
		archivesInnerLayout = $('#archives div.ui-layout-center').layout({
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

		loadModuleStartnavThreeArchives('archives');
		//archivesloadModuleStart();
	}


	$("#archives1-outer").on('click', 'h3', function(e, passed_id) {
		e.preventDefault();
		navThreeTitleFirstArchive('archives',$(this),passed_id)
		prevent_dblclick(e)
	}).disableSelection();
	
	/*$("#archives1-outer").on('click', 'h3', function(e, passed_id) {
		e.preventDefault();
		prevent_dblclick(e)
		$("#archives1 .module-click").removeClass('active-link');
		var id = $("#archives1 .module-click:eq(0)").attr("rel");
		$("#archives1 .module-click:eq(0)").addClass('active-link');
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/"+ id +"&request=getArchive", success: function(data){
			$("#archives-right").html(data.html);
			archivesInnerLayout.initContent('center');
			}
		 });
	});*/


	$("#archives2-outer").on('click', 'h3', function(e, passed_id) {
		e.preventDefault();
		navThreeTitleSecondArchives('archives',$(this),passed_id)
		prevent_dblclick(e)
	}).disableSelection();


	$("#archives3").on('click', 'h3', function(e, passed_id) {
		e.preventDefault();
		navThreeTitleThirdArchives('archives',$(this),passed_id)
		prevent_dblclick(e)
	}).disableSelection();

	/*$('#archives1').on('click', 'span.module-click', function(e) {
		e.preventDefault();
		navItemFirst('archives',$(this))
		prevent_dblclick(e)
	});*/
	
	$('#archives1').on('click', 'span.module-click', function(e) {
		e.preventDefault();
		prevent_dblclick(e)
		if($(this).hasClass("deactivated")) {
			return false;
		}
		var id = $(this).attr("rel");
		$("#archives").data({ "first" : id});
		var index = $("#archives .module-click").index(this);
		$("#archives .module-click").removeClass("active-link");
		$(this).addClass("active-link");
		
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/"+ id +"&request=getArchive", success: function(data){
			$("#archives-right").html(data.html);
			archivesInnerLayout.initContent('center');
			}
		});
		archivesActions(1);
		
		var num_modules = window[id+'_num_modules'];
		$.ajax({ type: "GET", url: "/", data: "path=apps/"+id+"&request=getArchiveModules", success: function(html){
			$('#archives3').html(html);
			var h = window['archives'].$layoutWest.height();
			$('#archives2').height(h-125-num_modules*27);
			$('#archives2 .module-inner').height(h-125-num_modules*27);
			$('#archives3 .module-actions').hide();
			$('#archives3').height(h-150);
			$('#archives3 .archives3-content').height(h-(num_modules*27+152));
			$('#archives3 div.thirdLevel').height(h-(num_modules*27+150-27));
			$('#archives3 div.thirdLevel').each(function(i) { 
				var position = $(this).position();
				var t = position.top+h-150;
				$(this).css('top',t+'px');
				//$(this).animate({top: t})
			})
			}
		});
		
		
		
	});
	

	$('#archives2').on('click', 'span.module-click', function(e) {
		e.preventDefault();
		navItemSecondArchives('archives',$(this))
		prevent_dblclick(e)
	});


	$('#archives3').on('click', 'span.module-click', function(e) {
		e.preventDefault();
		navItemThirdArchives('archives',$(this))
		prevent_dblclick(e)
	});
	
	// Search
	$(document).on('click', '#archiveProjectsSearch', function(e) {
		e.preventDefault();
		var meta = $('#metaSearch').val();
		var title = $('#titleSearch').val();
		var folder = $('#folderSearch').val();
		var who = $('#calcWho').val();
		if($('#archiveManagementField').val() == '') {
			who = 0;
		}
		var start = $('#archiveStartDate').val();
		var end = $('#archiveEndDate').val();
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects&request=doArchiveSearch&meta=" + meta+ "&title=" + title+ "&folder=" + folder+ "&who=" + who+ "&start=" + start + "&end=" + end, cache: false, success: function(data){
			$('#archiveSearchResult').html(data.html);
			}
		});
	});
	
	$(document).on('click', '#archiveProcsSearch', function(e) {
		e.preventDefault();
		var meta = $('#metaSearch').val();
		var title = $('#titleSearch').val();
		var folder = $('#folderSearch').val();
		var who = $('#calcWho').val();
		if($('#archiveManagementField').val() == '') {
			who = 0;
		}
		var start = $('#archiveStartDate').val();
		var end = $('#archiveEndDate').val();
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/procs&request=doArchiveSearch&meta=" + meta+ "&title=" + title+ "&folder=" + folder+ "&who=" + who+ "&start=" + start + "&end=" + end, cache: false, success: function(data){
			$('#archiveSearchResult').html(data.html);
			}
		});
	});
	
	
	$(document).on('click', '#archiveSaveMeta',function(e) {
		e.preventDefault();
		var module = $("#archives").data("first");
		var id = $("#archives").data("second");
		var meta = $('#input-meta').val();
		if(meta == '') {
			$('#input-meta').focus();
			return false;	
		}
		var html = '<span class="meta-outer"><a href="archives" class="meta showItemContext">' + meta + '</a></span>';
		if($("#archiveMeta").html() != "") {
				$("#archiveMeta .meta:visible:last").append(", ");
			}
			$("#archiveMeta").append(html);

		// get the entire list
		var metalist = '';
		$('#archives-right .meta').each( function() {
			metalist += $(this).text();
		})
		$.ajax({ type: "GET", url: "/", data: "path=apps/"+module+"&request=archiveSaveMeta&id="+id+"&meta="+metalist, success: function(html){
			$('#input-meta').val('');
			}
		});
		prevent_dblclick(e)
	});
	
	$(document).on('click', '#archiveDeleteMeta',function(e) {
		e.preventDefault();
		
		$(this).parent().parent().parent().parent().parent().remove();
		
		if($("#archiveMeta .meta-outer").length > 0) {
			var text = $("#archiveMeta .meta-outer:last").html();
			var textnew = text.split(", ");
			$("#archiveMeta .meta-outer:last").html(textnew[0]);
		}
		
		var module = $("#archives").data("first");
		var id = $("#archives").data("second");
		// get the entire list
		var metalist = '';
		$('#archives-right .meta').each( function() {
			metalist += $(this).text();
		})
		$.ajax({ type: "GET", url: "/", data: "path=apps/"+module+"&request=archiveSaveMeta&id="+id+"&meta="+metalist, success: function(html){
			}
		});
		prevent_dblclick(e)
	});


	// INTERLINKS FROM Content
	
	// load a archive
	$(document).on('click', '.loadArchive', function(e) {
		e.preventDefault();
		var obj = getCurrentModule();
		if(confirmNavigation()) {
			formChanged = false;
			$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		}
		var id = $(this).attr("rel");
		$("#archives2-outer > h3").trigger('click', [id]);
	});

	// load a phase
	$(document).on('click', '.loadArchivesPhase', function(e) {
		e.preventDefault();
		var obj = getCurrentModule();
		if(confirmNavigation()) {
			formChanged = false;
			$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		}
		
		var id = $(this).attr("rel");
		$("#archives3 h3[rel='phases']").trigger('click', [id]);
	});
	
	// load psp
	$(document).on('click', '.loadPSP', function(e) {
		e.stopPropagation();
		var obj = getCurrentModule();
		if(confirmNavigation()) {
			formChanged = false;
			$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		}
		var fid = $("#archives").data("first");
		var id = $(this).attr("rel");
		externalLoadThreeLevels('timelines',fid,id,3,'archives');
	});


	// barchart opacity with jquery
	$(".barchart-phase-bg").livequery( function() {
		$(this).css("opacity","0.3");
	});

	$("#todayBar").livequery( function() {
		$(this).css("opacity","0.4");
	});
  
	
	// timeline gant chart and multiview
	$("#barchartScroll").livequery( function() {
		var scroller = $(this);
		scroller.scroll(function() {
			var $scrollingDiv = $("#barchart-container-left");
			$scrollingDiv.stop().animate({"marginLeft": (scroller.scrollLeft()) + "px"}, "fast" );
			$("#barchartTimeline").stop().animate({"marginTop": (scroller.scrollTop()) + "px"}, "fast" );
			if(scroller.scrollTop() != 0) {
				$("#todayBar").stop().height(scroller.innerHeight()-67);
			}
		});
	});


	$(document).on('click', '.but-scroll-to',function(e) {
		e.preventDefault();
		var t = $(this).attr('t');
		var l = $(this).attr('l');
		$('.scroll-pane').scrollTo(l,t);
	});

	
	// autocomplete archives search
	$('.archives-search').livequery(function() {
		var id = $("#archives").data("second");
		$(this).autocomplete({
			appendTo: '#tabs-1',
			source: "?path=apps/archives&request=getArchivesSearch&exclude="+id,
			//minLength: 2,
			select: function(event, ui) {
				var obj = getCurrentModule();
				obj.addParentLink(ui.item.id);
			},
			close: function(event, ui) {
				$(this).val("");
			}
		});
	});
	
	$(document).on('click', '.addArchiveLink', function(e) {
		e.preventDefault();
		var id = $(this).attr("rel");
		var obj = getCurrentModule();
		obj.addParentLink(id);
	});
	
	$('span.actionArchiveDuplicate').on('click', function(e){
		e.preventDefault();
		if($(this).hasClass("noactive")) {
			return false;
		}
		if($('#modalDialogArchiveRevive').is(':visible')) {
			$('#modalDialogArchiveRevive').hide();
		}
		$('#modalDialogArchiveDuplicate').slideDown();
	});
	
	$('span.actionArchiveRevive').on('click', function(e){
		e.preventDefault();
		if($(this).hasClass("noactive")) {
			return false;
		}
		if($('#modalDialogArchiveDuplicate').is(':visible')) {
			$('#modalDialogArchiveDuplicate').hide();
		}
		$('#modalDialogArchiveRevive').slideDown();
	});
	
	$(document).on('click', '#modalDialogArchiveReviveClose', function(e) {
		e.preventDefault();
		$("#modalDialogArchiveRevive").slideUp(function() {
			initArchivesContentScrollbar()
		});
	});
	
	$(document).on('click', '#modalDialogArchiveDuplicateClose', function(e) {
		e.preventDefault();
		$("#modalDialogArchiveDuplicate").slideUp(function() {
			initArchivesContentScrollbar()
		});
	});
	
	$(document).on('click', 'span.commandArchiveRevive', function(e) {
		e.preventDefault();
		var module = $("#archives").data("first");
		var id = $("#archives").data("second");
		var folder = $('#archiveRevivefolder>span').attr('uid');
		if(typeof folder == 'undefined' || folder == false) {
			$.prompt(ALERT_ARCHIVE_CHOOSE_FOLDER);
			return false;
		}
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/"+module+"/&request=archiveRevive&id="+id+"&folder="+folder, success: function(data){																																																	  			//$.prompt(ALERT_SUCCESS_PROJECT_EXPORT + '"'+data.fid+'"');
			$('#archives .actionRefresh').click();																																																																																					   			$.prompt('Die Daten wurden erfolgreich reaktiviert');
			//var html = '<div class="text11">Projektordner: <span class="listmember">' + data.fid + '</span>, ' + data.created_user + ', ' + data.created_date + '</div';
			//$('#project_created').append(html);
			$("#modalDialogArchiveRevive").slideUp(function() {		
				initArchivesContentScrollbar();							
			});
			}
		});
	})
	
	$(document).on('click', 'span.commandArchiveDuplicate', function(e) {
		e.preventDefault();
		var module = $("#archives").data("first");
		var id = $("#archives").data("second");
		var folder = $('#archiveDuplicatefolder>span').attr('uid');
		if(typeof folder == 'undefined' || folder == false) {
			$.prompt(ALERT_ARCHIVE_CHOOSE_FOLDER);
			return false;
		}
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/"+module+"/&request=archiveDuplicate&id="+id+"&folder="+folder, success: function(data){																																																	  			//$.prompt(ALERT_SUCCESS_PROJECT_EXPORT + '"'+data.fid+'"');
			//$('#archives .actionRefresh').click();		
																																																																																						   			$.prompt('Die Daten wurden erfolgreich dupliziert.');
			//var html = '<div class="text11">Projektordner: <span class="listmember">' + data.fid + '</span>, ' + data.created_user + ', ' + data.created_date + '</div';
			//$('#project_created').append(html);
			$("#modalDialogArchiveDuplicate").slideUp(function() {		
				//initArchivesContentScrollbar();							
			});
			}
		});
	})
	
	// Projects direct links
	// load a project
	$(document).on('click', '.loadProjectArchive', function(e) {
		e.preventDefault();
		var id = $(this).attr("rel");
		$("#archives2-outer > h3").trigger('click', [id]);
	});
	// load a phase
	$(document).on('click', '.loadProjectsPhaseArchive', function(e) {
		e.preventDefault();
		var id = $(this).attr("rel");
		$("#archives3 h3[rel='phases']").trigger('click', [id]);
	});

});



/* phases Object */
function archivesPhases(app) {
	this.name = app +'_phases';
	this.app = app;
	this.object = window[app];
	this.objectFirst = this.app.substr(0, 1);
	this.objectnameCaps = this.objectFirst.toUpperCase() + this.app.substr(1);
	
	this.getDetails = function(moduleidx,liindex,list) {
		var module = this;
		var mainmodule = $('#archives').data("first");
		var appid = $("#archives3 ul:eq("+moduleidx+") .module-click:eq("+liindex+")").attr("rel");
		$('#archives').data({ "third" : appid});
		var num = $("#archives3 ul:eq("+moduleidx+") .phase_num:eq("+liindex+")").html();
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/"+ mainmodule +"/modules/phases&request=getDetailsArchive&id="+appid+"&num="+num, success: function(data){
			$("#archives-right").html(data.html);
			window['init'+ module.objectnameCaps +'ContentScrollbar']();
			}
		});
	}
	
	this.actionRefresh = function() {
		var module = this;
		var mainmodule = $('#'+ module.app).data("first");
		var id = $('#'+ module.app).data("third");
		var pid = $('#'+ module.app).data("second");
		$('#'+ module.app +'3 ul[rel=phases] .active-link').trigger("click");
		$.ajax({ type: "GET", url: "/", dataType: 'json', data: 'path=apps/'+ mainmodule +'/modules/phases&request=getListArchive&id='+pid, success: function(data){																																																																				
			$('#'+ module.app +'3 ul[rel=phases]').html(data.html);
			var liindex = $('#'+ module.app +'3 ul[rel=phases] .module-click').index($("#"+ module.app +"3 ul[rel=phases] .module-click[rel='"+id+"']"));
			$("#"+ module.app +"3 ul[rel=phases] .module-click:eq("+liindex+")").addClass('active-link');
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: 'path=apps/'+ module.app +'&request=getDates&id='+pid, success: function(val){
						$('#'+ module.app +'enddate').html(val.enddate);
					}
				});
			}
		});
	}


	this.actionPrint = function() {
		var module = this;
		var mainmodule = $('#'+ module.app).data("first");
		var id = $('#'+ module.app).data("third");
		var num = $('#'+ module.app +'3 ul[rel=phases] .active-link').find(".phase_num").html();
		var url ='/?path=apps/'+ mainmodule +'/modules/phases&request=printDetails&id='+id+"&num="+num;
		if(!iOS()) {
			$("#documentloader").attr('src', url);
		} else {
			window.open(url);
		}
	}


	this.actionSend = function() {
		var module = this;
		var mainmodule = $('#'+ module.app).data("first");
		var id = $('#'+ module.app).data("third");
		var num = $('#'+ module.app +'3 ul[rel=phases] .active-link').find(".phase_num").html();
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: 'path=apps/'+ mainmodule +'/modules/phases&request=getSend&id='+id+'&num='+num, success: function(data){
			$("#modalDialogForward").html(data.html).dialog('open');
			if(data.error == 1) {
				$.prompt('<div style="text-align: center">' + ALERT_REMOVE_RECIPIENT + data.error_message + '<br /></div>');
				return false;
			}
			}
		});
	}


	this.actionSendtoResponse = function() {
		var module = this;
		var mainmodule = $('#'+ module.app).data("first");
		var id = $('#'+ module.app).data("third");
		$.ajax({ type: "GET", url: "/", data: 'path=apps/'+ mainmodule +'/modules/phases&request=getSendtoDetails&id='+id, success: function(html){
			$('#'+ mainmodule +'_phase_sendto').html(html);
			}
		});
	}
	
	this.actionDialog = function(offset,request,field,append,title,sql) {
		var module = this;
		var mainmodule = $('#'+ module.app).data("first");
			$.ajax({ type: "GET", url: "/", data: 'path=apps/'+ mainmodule +'&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
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
	
	this.checkIn = function(id) {
		return true;
	}

	
	this.actionHelp = function() {
		var module = this;
		var url = "/?path=apps/archives&request=getArchivesHelp";
		if(!iOS()) {
			$("#documentloader").attr('src', url);
		} else {
			window.open(url);
		}
	}
}
var archives_phases = new archivesPhases('archives');


/* meetings Object */
function archivesMeetings(app) {
	this.name = app +'_meetings';
	this.app = app;
	this.object = window[app];
	this.objectFirst = this.app.substr(0, 1);
	this.objectnameCaps = this.objectFirst.toUpperCase() + this.app.substr(1);
	
	
	this.getDetails = function(moduleidx,liindex,list) {
		var module = this;
		var mainmodule = $('#archives').data("first");
		var id = $("#archives3 ul:eq("+moduleidx+") .module-click:eq("+liindex+")").attr("rel");
		$('#archives').data({ "third" : id});
		var fid = $('#archives').data('first');
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/"+ mainmodule +"/modules/meetings&request=getDetailsArchive&id="+id+"&fid="+fid, success: function(data){
			$("#archives-right").html(data.html);
			window['init'+ module.objectnameCaps +'ContentScrollbar']();
			}
		});	
	}
	

	this.actionRefresh = function() {
		var module = this;
		var mainmodule = $('#'+ module.app).data("first");
		var id = $('#'+ module.app).data("third");
		var pid = $('#'+ module.app).data("second");
		$('#'+ module.app +'3 ul[rel=meetings] .active-link').trigger("click");
		$.ajax({ type: "GET", url: "/", dataType: 'json', data: 'path=apps/'+ mainmodule +'/modules/meetings&request=getListArchive&id='+pid, success: function(data){																																																																				
			$('#'+ module.app +'3 ul[rel=meetings]').html(data.html);
			var liindex = $('#'+ module.app +'3 ul[rel=meetings] .module-click').index($("#"+ module.app +"3 ul[rel=meetings] .module-click[rel='"+id+"']"));
			$("#"+ module.app +"3 ul[rel=meetings] .module-click:eq("+liindex+")").addClass('active-link');
			/*$.ajax({ type: "GET", url: "/", dataType:  'json', data: 'path=apps/'+ module.app +'&request=getDates&id='+pid, success: function(val){
						$('#'+ module.app +'enddate').html(val.enddate);
					}
				});*/
			}
		});
	}


	this.actionPrint = function() {
		var module = this;
		var mainmodule = $('#'+ module.app).data("first");
		var id = $('#'+ module.app).data("third");
		var url ='/?path=apps/'+ mainmodule +'/modules/meetings&request=printDetails&id='+id;
		if(!iOS()) {
			$("#documentloader").attr('src', url);
		} else {
			window.open(url);
		}
	}


	this.actionSend = function() {
		var module = this;
		var mainmodule = $('#'+ module.app).data("first");
		var id = $('#'+ module.app).data("third");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: 'path=apps/'+ mainmodule +'/modules/meetings&request=getSend&id='+id, success: function(data){
			$("#modalDialogForward").html(data.html).dialog('open');
			if(data.error == 1) {
				$.prompt('<div style="text-align: center">' + ALERT_REMOVE_RECIPIENT + data.error_message + '<br /></div>');
				return false;
			}
			}
		});
	}


	this.actionSendtoResponse = function() {
		var module = this;
		var mainmodule = $('#'+ module.app).data("first");
		var id = $('#'+ module.app).data("third");
		$.ajax({ type: "GET", url: "/", data: 'path=apps/'+ mainmodule +'/modules/meetings&request=getSendtoDetails&id='+id, success: function(html){
			$('#'+ mainmodule +'_phase_sendto').html(html);
			}
		});
	}
	
	this.actionDialog = function(offset,request,field,append,title,sql) {
		var module = this;
		var mainmodule = $('#'+ module.app).data("first");
			$.ajax({ type: "GET", url: "/", data: 'path=apps/'+ mainmodule +'&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
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
	
	this.togglePost = function(id,obj) {
		var module = this;
		var mainmodule = $('#'+ module.app).data("first");
		var outer = $('#'+ mainmodule +'meetingtask_'+id);
		outer.slideToggle();
		obj.find('span').toggleClass('active');
	}
	
	this.checkIn = function(id) {
		return true;
	}

	
	this.actionHelp = function() {
		var module = this;
		var url = "/?path=apps/archives&request=getArchivesHelp";
		if(!iOS()) {
			$("#documentloader").attr('src', url);
		} else {
			window.open(url);
		}
	}
}
var archives_meetings = new archivesMeetings('archives');


/* phonecalls Object */
function archivesPhonecalls(app) {
	this.name = app +'_phonecalls';
	this.app = app;
	this.object = window[app];
	this.objectFirst = this.app.substr(0, 1);
	this.objectnameCaps = this.objectFirst.toUpperCase() + this.app.substr(1);
	
	this.getDetails = function(moduleidx,liindex,list) {
		var module = this;
		var mainmodule = $('#archives').data("first");
		var id = $("#archives3 ul:eq("+moduleidx+") .module-click:eq("+liindex+")").attr("rel");
		$('#archives').data({ "third" : id});
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/"+ mainmodule +"/modules/phonecalls&request=getDetailsArchive&id="+id, success: function(data){
			$("#archives-right").html(data.html);
			window['init'+ module.objectnameCaps +'ContentScrollbar']();
			}
		});	
	}
	
	this.actionRefresh = function() {
		var module = this;
		var mainmodule = $('#'+ module.app).data("first");
		var id = $('#'+ module.app).data("third");
		var pid = $('#'+ module.app).data("second");
		$('#'+ module.app +'3 ul[rel=phonecalls] .active-link').trigger("click");
		$.ajax({ type: "GET", url: "/", dataType: 'json', data: 'path=apps/'+ mainmodule +'/modules/phonecalls&request=getListArchive&id='+pid, success: function(data){																																																																				
			$('#'+ module.app +'3 ul[rel=phonecalls]').html(data.html);
			var liindex = $('#'+ module.app +'3 ul[rel=phonecalls] .module-click').index($("#"+ module.app +"3 ul[rel=phonecalls] .module-click[rel='"+id+"']"));
			$("#"+ module.app +"3 ul[rel=phonecalls] .module-click:eq("+liindex+")").addClass('active-link');
			/*$.ajax({ type: "GET", url: "/", dataType:  'json', data: 'path=apps/'+ module.app +'&request=getDates&id='+pid, success: function(val){
						$('#'+ module.app +'enddate').html(val.enddate);
					}
				});*/
			}
		});
	}


	this.actionPrint = function() {
		var module = this;
		var mainmodule = $('#'+ module.app).data("first");
		var id = $('#'+ module.app).data("third");
		var url ='/?path=apps/'+ mainmodule +'/modules/phonecalls&request=printDetails&id='+id;
		if(!iOS()) {
			$("#documentloader").attr('src', url);
		} else {
			window.open(url);
		}
	}


	this.actionSend = function() {
		var module = this;
		var mainmodule = $('#'+ module.app).data("first");
		var id = $('#'+ module.app).data("third");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: 'path=apps/'+ mainmodule +'/modules/phonecalls&request=getSend&id='+id, success: function(data){
			$("#modalDialogForward").html(data.html).dialog('open');
			if(data.error == 1) {
				$.prompt('<div style="text-align: center">' + ALERT_REMOVE_RECIPIENT + data.error_message + '<br /></div>');
				return false;
			}
			}
		});
	}


	this.actionSendtoResponse = function() {
		var module = this;
		var mainmodule = $('#'+ module.app).data("first");
		var id = $('#'+ module.app).data("third");
		$.ajax({ type: "GET", url: "/", data: 'path=apps/'+ mainmodule +'/modules/phonecalls&request=getSendtoDetails&id='+id, success: function(html){
			$('#'+ mainmodule +'_phase_sendto').html(html);
			}
		});
	}
	
	this.actionDialog = function(offset,request,field,append,title,sql) {
		var module = this;
		var mainmodule = $('#'+ module.app).data("first");
			$.ajax({ type: "GET", url: "/", data: 'path=apps/'+ mainmodule +'&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
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
	
	this.checkIn = function(id) {
		return true;
	}
	
	this.actionHelp = function() {
		var module = this;
		var url = "/?path=apps/archives&request=getArchivesHelp";
		if(!iOS()) {
			$("#documentloader").attr('src', url);
		} else {
			window.open(url);
		}
	}
}
var archives_phonecalls = new archivesPhonecalls('archives');


/* documents Object */
function archivesDocuments(app) {
	this.name = app +'_documents';
	this.app = app;
	this.object = window[app];
	this.objectFirst = this.app.substr(0, 1);
	this.objectnameCaps = this.objectFirst.toUpperCase() + this.app.substr(1);
	
	this.getDetails = function(moduleidx,liindex,list) {
		var module = this;
		var mainmodule = $('#archives').data("first");
		var id = $("#archives3 ul:eq("+moduleidx+") .module-click:eq("+liindex+")").attr("rel");
		$('#archives').data({ "third" : id});
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/"+ mainmodule +"/modules/documents&request=getDetailsArchive&id="+id, success: function(data){
			$("#archives-right").html(data.html);
			window['init'+ module.objectnameCaps +'ContentScrollbar']();
			}
		});	
	}
	
	this.actionRefresh = function() {
		var module = this;
		var mainmodule = $('#'+ module.app).data("first");
		var id = $('#'+ module.app).data("third");
		var pid = $('#'+ module.app).data("second");
		$('#'+ module.app +'3 ul[rel=documents] .active-link').trigger("click");
		$.ajax({ type: "GET", url: "/", dataType: 'json', data: 'path=apps/'+ mainmodule +'/modules/documents&request=getListArchive&id='+pid, success: function(data){																																																																				
			$('#'+ module.app +'3 ul[rel=documents]').html(data.html);
			var liindex = $('#'+ module.app +'3 ul[rel=documents] .module-click').index($("#"+ module.app +"3 ul[rel=documents] .module-click[rel='"+id+"']"));
			$("#"+ module.app +"3 ul[rel=documents] .module-click:eq("+liindex+")").addClass('active-link');
			/*$.ajax({ type: "GET", url: "/", dataType:  'json', data: 'path=apps/'+ module.app +'&request=getDates&id='+pid, success: function(val){
						$('#'+ module.app +'enddate').html(val.enddate);
					}
				});*/
			}
		});
	}

	this.actionPrint = function() {
		var module = this;
		var mainmodule = $('#'+ module.app).data("first");
		var id = $('#'+ module.app).data("third");
		var url ='/?path=apps/'+ mainmodule +'/modules/documents&request=printDetails&id='+id;
		if(!iOS()) {
			$("#documentloader").attr('src', url);
		} else {
			window.open(url);
		}
	}

	this.actionSend = function() {
		var module = this;
		var mainmodule = $('#'+ module.app).data("first");
		var id = $('#'+ module.app).data("third");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: 'path=apps/'+ mainmodule +'/modules/documents&request=getSend&id='+id, success: function(data){
			$("#modalDialogForward").html(data.html).dialog('open');
			if(data.error == 1) {
				$.prompt('<div style="text-align: center">' + ALERT_REMOVE_RECIPIENT + data.error_message + '<br /></div>');
				return false;
			}
			}
		});
	}

	this.actionSendtoResponse = function() {
		var module = this;
		var mainmodule = $('#'+ module.app).data("first");
		var id = $('#'+ module.app).data("third");
		$.ajax({ type: "GET", url: "/", data: 'path=apps/'+ mainmodule +'/modules/documents&request=getSendtoDetails&id='+id, success: function(html){
			$('#'+ mainmodule +'_phase_sendto').html(html);
			}
		});
	}
	
	this.actionDialog = function(offset,request,field,append,title,sql) {
		var module = this;
		var mainmodule = $('#'+ module.app).data("first");
			$.ajax({ type: "GET", url: "/", data: 'path=apps/'+ mainmodule +'&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
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
	
	this.checkIn = function(id) {
		return true;
	}
	
	this.actionHelp = function() {
		var module = this;
		var url = "/?path=apps/archives&request=getArchivesHelp";
		if(!iOS()) {
			$("#documentloader").attr('src', url);
		} else {
			window.open(url);
		}
	}
}
var archives_documents = new archivesDocuments('archives');


/* vdocs Object */
function archivesVdocs(app) {
	this.name = app +'_vdocs';
	this.app = app;
	this.object = window[app];
	this.objectFirst = this.app.substr(0, 1);
	this.objectnameCaps = this.objectFirst.toUpperCase() + this.app.substr(1);
	
	this.getDetails = function(moduleidx,liindex,list) {
		var module = this;
		var mainmodule = $('#archives').data("first");
		var id = $("#archives3 ul:eq("+moduleidx+") .module-click:eq("+liindex+")").attr("rel");
		$('#archives').data({ "third" : id});
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/"+ mainmodule +"/modules/vdocs&request=getDetailsArchive&id="+id, success: function(data){
			$("#archives-right").html(data.html);
			window['init'+ module.objectnameCaps +'ContentScrollbar']();
			}
		});	
	}
	
	this.actionRefresh = function() {
		var module = this;
		var mainmodule = $('#'+ module.app).data("first");
		var id = $('#'+ module.app).data("third");
		var pid = $('#'+ module.app).data("second");
		$('#'+ module.app +'3 ul[rel=vdocs] .active-link').trigger("click");
		$.ajax({ type: "GET", url: "/", dataType: 'json', data: 'path=apps/'+ mainmodule +'/modules/vdocs&request=getListArchive&id='+pid, success: function(data){																																																																				
			$('#'+ module.app +'3 ul[rel=vdocs]').html(data.html);
			var liindex = $('#'+ module.app +'3 ul[rel=vdocs] .module-click').index($("#"+ module.app +"3 ul[rel=vdocs] .module-click[rel='"+id+"']"));
			$("#"+ module.app +"3 ul[rel=vdocs] .module-click:eq("+liindex+")").addClass('active-link');
			/*$.ajax({ type: "GET", url: "/", dataType:  'json', data: 'path=apps/'+ module.app +'&request=getDates&id='+pid, success: function(val){
						$('#'+ module.app +'enddate').html(val.enddate);
					}
				});*/
			}
		});
	}

	this.actionPrint = function() {
		var module = this;
		var mainmodule = $('#'+ module.app).data("first");
		var id = $('#'+ module.app).data("third");
		var url ='/?path=apps/'+ mainmodule +'/modules/vdocs&request=printDetails&id='+id;
		if(!iOS()) {
			$("#documentloader").attr('src', url);
		} else {
			window.open(url);
		}
	}

	this.actionSend = function() {
		var module = this;
		var mainmodule = $('#'+ module.app).data("first");
		var id = $('#'+ module.app).data("third");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: 'path=apps/'+ mainmodule +'/modules/vdocs&request=getSend&id='+id, success: function(data){
			$("#modalDialogForward").html(data.html).dialog('open');
			if(data.error == 1) {
				$.prompt('<div style="text-align: center">' + ALERT_REMOVE_RECIPIENT + data.error_message + '<br /></div>');
				return false;
			}
			}
		});
	}

	this.actionSendtoResponse = function() {
		var module = this;
		var mainmodule = $('#'+ module.app).data("first");
		var id = $('#'+ module.app).data("third");
		$.ajax({ type: "GET", url: "/", data: 'path=apps/'+ mainmodule +'/modules/vdocs&request=getSendtoDetails&id='+id, success: function(html){
			$('#'+ mainmodule +'_phase_sendto').html(html);
			}
		});
	}
	
	this.actionDialog = function(offset,request,field,append,title,sql) {
		var module = this;
		var mainmodule = $('#'+ module.app).data("first");
			$.ajax({ type: "GET", url: "/", data: 'path=apps/'+ mainmodule +'&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
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
	
	this.checkIn = function(id) {
		return true;
	}
	
	this.actionHelp = function() {
		var module = this;
		var url = "/?path=apps/archives&request=getArchivesHelp";
		if(!iOS()) {
			$("#documentloader").attr('src', url);
		} else {
			window.open(url);
		}
	}
}
var archives_vdocs = new archivesVdocs('archives');


/* controlling Object */
function archivesControlling(app) {
	this.name = app +'_controlling';
	this.app = app;
	this.object = window[app];
	this.objectFirst = this.app.substr(0, 1);
	this.objectnameCaps = this.objectFirst.toUpperCase() + this.app.substr(1);
	
	this.getDetails = function(moduleidx,liindex,list) {
		var module = this;
		var mainmodule = $('#archives').data("first");
		var id = $("#archives3 ul:eq("+moduleidx+") .module-click:eq("+liindex+")").attr("rel");
		$('#archives').data({ "third" : id});
		var pid = $('#archives').data('second');
		if(id == undefined) {
			return false;
		}
		$.ajax({ type: "GET", url: "/", data: 'path=apps/'+ mainmodule +'/modules/controlling&request=getDetailsArchive&id='+id+'&pid='+pid, success: function(data){
			$("#archives-right").html(data);
			window['init'+ module.objectnameCaps +'ContentScrollbar']();
			//window[module.app +'Actions'](8);
			}
		});	
	}
	
	
	this.actionRefresh = function() {
		var module = this;
		var mainmodule = $('#'+ module.app).data("first");
		var id = $('#'+ module.app).data("third");
		var pid = $('#'+ module.app).data("second");
		$('#'+ module.app +'3 ul[rel=controlling] .active-link').trigger("click");
		$.ajax({ type: "GET", url: "/", dataType: 'json', data: 'path=apps/'+ mainmodule +'/modules/controlling&request=getListArchive&id='+pid, success: function(data){																																																																				
			$('#'+ module.app +'3 ul[rel=controlling]').html(data.html);
			var liindex = $('#'+ module.app +'3 ul[rel=controlling] .module-click').index($("#"+ module.app +"3 ul[rel=controlling] .module-click[rel='"+id+"']"));
			$("#"+ module.app +"3 ul[rel=controlling] .module-click:eq("+liindex+")").addClass('active-link');
			/*$.ajax({ type: "GET", url: "/", dataType:  'json', data: 'path=apps/'+ module.app +'&request=getDates&id='+pid, success: function(val){
						$('#'+ module.app +'enddate').html(val.enddate);
					}
				});*/
			}
		});
	}

	this.actionPrint = function() {
		var module = this;
		var mainmodule = $('#'+ module.app).data("first");
		var id = $('#'+ module.app).data("third");
		var pid = $('#'+ module.app).data("second");
		var url ='/?path=apps/'+ mainmodule +'/modules/controlling&request=printDetails&pid='+pid+"&id="+id;
		if(!iOS()) {
			$("#documentloader").attr('src', url);
		} else {
			window.open(url);
		}
	}
	

	this.actionSend = function() {
		var module = this;
		var mainmodule = $('#'+ module.app).data("first");
		var id = $('#'+ module.app).data("third");
		var pid = $('#'+ module.app).data("second");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: 'path=apps/'+ mainmodule +'/modules/controlling&request=getSend&pid='+pid+'&id='+id, success: function(data){
			$("#modalDialogForward").html(data.html).dialog('open');
			if(data.error == 1) {
				$.prompt('<div style="text-align: center">' + ALERT_REMOVE_RECIPIENT + data.error_message + '<br /></div>');
				return false;
			}
			}
		});
	}

	this.actionSendtoResponse = function() {
		var module = this;
		var mainmodule = $('#'+ module.app).data("first");
		var id = $('#'+ module.app).data("third");
		$.ajax({ type: "GET", url: "/", data: 'path=apps/'+ mainmodule +'/modules/controlling&request=getSendtoDetails&id='+id, success: function(html){
			$('#'+ mainmodule +'_phase_sendto').html(html);
			}
		});
	}
	
	this.actionDialog = function(offset,request,field,append,title,sql) {
		var module = this;
		var mainmodule = $('#'+ module.app).data("first");
			$.ajax({ type: "GET", url: "/", data: 'path=apps/'+ mainmodule +'&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
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
	
	this.checkIn = function(id) {
		return true;
	}
	
	this.actionHelp = function() {
		var module = this;
		var url = "/?path=apps/archives&request=getArchivesHelp";
		if(!iOS()) {
			$("#documentloader").attr('src', url);
		} else {
			window.open(url);
		}
	}
}
var archives_controlling = new archivesControlling('archives');


/* timelines Object */
function archivesTimelines(app) {
	this.name = app +'_timelines';
	this.app = app;
	this.object = window[app];
	this.objectFirst = this.app.substr(0, 1);
	this.objectnameCaps = this.objectFirst.toUpperCase() + this.app.substr(1);
	
	this.getDetails = function(moduleidx,liindex,list) {
		var module = this;
		var mainmodule = $('#archives').data("first");
		var id = $("#archives3 ul:eq("+moduleidx+") .module-click:eq("+liindex+")").attr("rel");
		$('#archives').data({ "third" : id});
		var pid = $('#archives').data('second');
		if(id == undefined) {
			return false;
		}
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: 'path=apps/'+ mainmodule +'/modules/timelines&request=getDetailsArchive&id='+id+'&pid='+pid, success: function(data){
			$("#archives-right").html(data.html);
			window['init'+ module.objectnameCaps +'ContentScrollbar']();
			//window[module.app +'Actions'](8);
			}
		});	
	}
	
	
	this.actionRefresh = function() {
		var module = this;
		var mainmodule = $('#'+ module.app).data("first");
		var id = $('#'+ module.app).data("third");
		var pid = $('#'+ module.app).data("second");
		$('#'+ module.app +'3 ul[rel=timelines] .active-link').trigger("click");
		$.ajax({ type: "GET", url: "/", dataType: 'json', data: 'path=apps/'+ mainmodule +'/modules/timelines&request=getListArchive&id='+pid, success: function(data){																																																																				
			$('#'+ module.app +'3 ul[rel=timelines]').html(data.html);
			var liindex = $('#'+ module.app +'3 ul[rel=timelines] .module-click').index($("#"+ module.app +"3 ul[rel=timelines] .module-click[rel='"+id+"']"));
			$("#"+ module.app +"3 ul[rel=timelines] .module-click:eq("+liindex+")").addClass('active-link');
			/*$.ajax({ type: "GET", url: "/", dataType:  'json', data: 'path=apps/'+ module.app +'&request=getDates&id='+pid, success: function(val){
						$('#'+ module.app +'enddate').html(val.enddate);
					}
				});*/
			}
		});
	}

	this.actionPrint = function() {
		var module = this;
		var mainmodule = $('#'+ module.app).data("first");
		var id = $('#'+ module.app).data("third");
		var pid = $('#'+ module.app).data("second");
		var url ='/?path=apps/'+ mainmodule +'/modules/timelines&request=printDetails&pid='+pid+'&id='+id;
		if(!iOS()) {
			$("#documentloader").attr('src', url);
		} else {
			window.open(url);
		}
	}

	this.actionSend = function() {
		var module = this;
		var mainmodule = $('#'+ module.app).data("first");
		var id = $('#'+ module.app).data("third");
		var pid = $('#'+ module.app).data("second");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: 'path=apps/'+ mainmodule +'/modules/timelines&request=getSend&pid='+pid+'&id='+id, success: function(data){
			$("#modalDialogForward").html(data.html).dialog('open');
			if(data.error == 1) {
				$.prompt('<div style="text-align: center">' + ALERT_REMOVE_RECIPIENT + data.error_message + '<br /></div>');
				return false;
			}
			}
		});
	}

	this.actionSendtoResponse = function() {
		var module = this;
		var mainmodule = $('#'+ module.app).data("first");
		var id = $('#'+ module.app).data("third");
		$.ajax({ type: "GET", url: "/", data: 'path=apps/'+ mainmodule +'/modules/timelines&request=getSendtoDetails&id='+id, success: function(html){
			$('#'+ mainmodule +'_phase_sendto').html(html);
			}
		});
	}
	
	this.actionDialog = function(offset,request,field,append,title,sql) {
		var module = this;
		var mainmodule = $('#'+ module.app).data("first");
			$.ajax({ type: "GET", url: "/", data: 'path=apps/'+ mainmodule +'&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
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
	
	this.checkIn = function(id) {
		return true;
	}
	
	this.loadBarchartZoom = function(zoom) {
		var module = this;
		var mainmodule = $('#'+ module.app).data("first");
		var id = $('#'+ module.app).data("second");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: 'path=apps/'+ mainmodule +'/modules/timelines&request=getDetailsArchive&id=1&pid='+id+'&zoom='+zoom, success: function(data){
			$('#'+ module.app +'-right').html(data.html);
			window['init'+ module.objectnameCaps +'ContentScrollbar']();
			}
		});
	}
	
	this.actionHelp = function() {
		var module = this;
		var url = "/?path=apps/archives&request=getArchivesHelp";
		if(!iOS()) {
			$("#documentloader").attr('src', url);
		} else {
			window.open(url);
		}
	}
}
var archives_timelines = new archivesTimelines('archives');


/* access Object */
function archivesAccess(app) {
	this.name = app +'_access';
	this.app = app;
	this.object = window[app];
	this.objectFirst = this.app.substr(0, 1);
	this.objectnameCaps = this.objectFirst.toUpperCase() + this.app.substr(1);
	
	this.getDetails = function(moduleidx,liindex,list) {
		var module = this;
		var mainmodule = $('#archives').data("first");
		var id = $("#archives3 ul:eq("+moduleidx+") .module-click:eq("+liindex+")").attr("rel");
		$('#archives').data({ "third" : id});
		$.ajax({ type: "GET", url: "/", data: "path=apps/"+ mainmodule +"/modules/access&request=getDetailsArchive&id="+id, success: function(data){
			$("#archives-right").html(data);
			window['init'+ module.objectnameCaps +'ContentScrollbar']();
			window[module.app +'Actions'](2);
			}
		});	
	}
	
	this.actionRefresh = function() {
		var module = this;
		var mainmodule = $('#'+ module.app).data("first");
		var id = $('#'+ module.app).data("third");
		var pid = $('#'+ module.app).data("second");
		$('#'+ module.app +'3 ul[rel=access] .active-link').trigger("click");
		$.ajax({ type: "GET", url: "/", dataType: 'json', data: 'path=apps/'+ mainmodule +'/modules/access&request=getListArchive&id='+pid, success: function(data){																																																																				
			$('#'+ module.app +'3 ul[rel=access]').html(data.html);
			var liindex = $('#'+ module.app +'3 ul[rel=access] .module-click').index($("#"+ module.app +"3 ul[rel=access] .module-click[rel='"+id+"']"));
			$("#"+ module.app +"3 ul[rel=access] .module-click:eq("+liindex+")").addClass('active-link');
			}
		});
	}

	this.actionDialog = function(offset,request,field,append,title,sql) {
		var module = this;
		var mainmodule = $('#'+ module.app).data("first");
			$.ajax({ type: "GET", url: "/", data: 'path=apps/'+ mainmodule +'&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
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
	
	this.checkIn = function(id) {
		return true;
	}
	
	this.actionHelp = function() {
		var module = this;
		var url = "/?path=apps/archives&request=getArchivesHelp";
		if(!iOS()) {
			$("#documentloader").attr('src', url);
		} else {
			window.open(url);
		}
	}
}
var archives_access = new archivesAccess('archives');