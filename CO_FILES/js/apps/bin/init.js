/* bin Object */
var bin = new Application('bin');
bin.path = 'apps/bin/';
bin.resetModuleHeights = binresetModuleHeights;
bin.usesLayout = true;
bin.displayname = "Projekte";
bin.modules_height = bin_num_modules*module_title_height;
bin.sortclick = sortClickProject;
bin.sortdrag = sortDragProject;
bin.actionDialog = dialogProject;
bin.actionNew = newProject;
bin.actionPrint = printProject;
bin.actionDuplicate = duplicateProject;
bin.actionBin = binProject;
//bin.actionMoveProject = moveProject;
bin.poformOptions = { beforeSubmit: projectFormProcess, dataType:  'json', success: projectFormResponse };


function projectFormResponse(data) {
	switch(data.action) {
		case "edit":
			$("#bin2 a.active-link .text").html($("#bin .title").val());
			$("#durationStart").html($("input[name='startdate']").val());
		break;
		case "reload":
			$.ajax({ type: "GET", url: "/", data: "path=apps/bin&request=getProjectDetails&id="+data.id, success: function(html){
					$("#"+bin.name+"-right").html(html);
						initContentScrollbar();
					}
				});
		break;
	}
}

function printProject() {
	var id = $("#bin2 .module-click:visible").attr("rel");
	var url ='/?path=apps/bin&request=printProjectDetails&id='+id;
	location.href = url;
}



function binProject() {
	var txt = ALERT_DELETE;
	var langbuttons = {};
	langbuttons[ALERT_YES] = true;
	langbuttons[ALERT_NO] = false;
	$.prompt(txt,{ 
		buttons:langbuttons,
		callback: function(v,m,f){		
			if(v){
				var id = $("#bin2 .active-link").attr("rel");
				var fid = $("#bin .module-click:visible").attr("rel");
				$.ajax({ type: "GET", url: "/", data: "path=apps/bin&request=binProject&id=" + id, cache: false, success: function(data){
					if(data == "true") {
						$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/bin&request=getProjectList&id="+fid, success: function(list){
							$("#bin2 ul").html(list.html);
							if(list.html == "<li></li>") {
								binActions(3);
							} else {
								binActions(0);
								setModuleActive($("#bin2"),0);
							}
							var id = $("#bin2 .module-click:eq(0)").attr("rel");
							$("#bin2 .module-click:eq(0)").addClass('active-link');
							$.ajax({ type: "GET", url: "/", data: "path=apps/bin&request=getProjectDetails&fid="+fid+"&id="+id, success: function(html){
								$("#"+bin.name+"-right").html(html);
								initScrollbar( '#bin .scrolling-content' );
								initContentScrollbar();
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


function binFolder() {
	var txt = ALERT_DELETE;
	var langbuttons = {};
	langbuttons[ALERT_YES] = true;
	langbuttons[ALERT_NO] = false;
	$.prompt(txt,{ 
		buttons:langbuttons,
		callback: function(v,m,f){		
			if(v){
				var id = $("#bin1 .active-link").attr("rel");
				$.ajax({ type: "GET", url: "/", data: "path=apps/bin&request=binFolder&id=" + id, cache: false, success: function(data){
					if(data == "true") {
						$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/bin&request=getFolderList", success: function(data){
							$("#bin1 ul").html(data.html);
							if(data.html == "<li></li>") {
								binActions(3);
							} else {
								binActions(1);
							}
							var id = $("#bin1 .module-click:eq(0)").attr("rel");
							$("#bin1 .module-click:eq(0)").addClass('active-link');
							//$("#bin1 .drag:eq(0)").show();
							$.ajax({ type: "GET", url: "/", data: "path=apps/bin&request=getFolderDetails&id="+id, success: function(html){
								$("#"+bin.name+"-right").html(html);
								initScrollbar( '#bin .scrolling-content' );
								initContentScrollbar();
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


function binActions(status) {
	/*	0= new	1= save		2= print	3= send		4= duplicate	5= delete	*/
	/*	0= new	1= print	2= send		3= duplicate	4= delete	*/
	switch(status) {
		//case 0: 	actions = ['0','1','2','3','4']; break; // all actions
		case 0: actions = ['0','3','4']; break;
		//case 1: 	actions = ['0','1','2','4']; break; 	// no duplicate
		case 1: actions = ['0','4']; break;
		//case 2: 	actions = ['1']; break;   					// just save
		case 3: 	actions = ['0']; break;   					// just new
		case 4: 	actions = ['1','2']; break;   					// no new no delete
		default: 	actions = [];  								// none
	}
	$('#binActions > li a').each( function(index) {
		if(index in oc(actions)) {
			$(this).removeClass('noactive');
		} else {
			$(this).addClass('noactive');
		}
	})
}

function sortClickFolder(obj,sortcur,sortnew) {
	$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/bin&request=getFolderList&sort="+sortnew, success: function(data){
		  $("#bin1 ul").html(data.html);
		  obj.attr("rel",sortnew);
		  obj.removeClass("sort"+sortcur).addClass("sort"+sortnew);
			$('#bin1 input.filter').quicksearch('#bin1 li');
		  var id = $("#bin1 .module-click:eq(0)").attr("rel");
		  $("#bin1 .module-click:eq(0)").addClass('active-link');
		  $.ajax({ type: "GET", url: "/", data: "request=path=apps/bin&getFolderDetails&id="+id, success: function(html){
			  $("#"+bin.name+"-right").html(html);
			  initContentScrollbar()
			  }
		  });
	}
	});
}

function sortDragFolder(order) {
	$.ajax({ type: "GET", url: "/", data: "path=apps/bin&request=setFolderOrder&"+order, success: function(html){
		$("#bin1 a.sort").attr("rel", "3");
		$("#bin1 a.sort").removeClass("sort1").removeClass("sort2").addClass("sort3");
		}
	});
}

function sortClickProject(obj,sortcur,sortnew) {
	var fid = $("#bin .module-click:visible").attr("rel");
	$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/bin&request=getProjectList&id="+fid+"&sort="+sortnew, success: function(data){
		  $("#bin2 ul").html(data.html);
		  obj.attr("rel",sortnew);
		  obj.removeClass("sort"+sortcur).addClass("sort"+sortnew);
		  var id = $("#bin2 .module-click:eq(0)").attr("rel");
		  if(id == undefined) {
				return false;
			}
		  setModuleActive($("#bin2"),'0');
		  $.ajax({ type: "GET", url: "/", data: "path=apps/bin&request=getProjectDetails&id="+id, success: function(html){
			  $("#"+bin.name+"-right").html(html);
			  initContentScrollbar()
			  }
		  });
	}
	});
}

function sortDragProject(order) {
	var fid = $("#bin .module-click:visible").attr("rel");
	$.ajax({ type: "GET", url: "/", data: "path=apps/bin&request=setProjectOrder&"+order+"&id="+fid, success: function(html){
		$("#bin2 a.sort").attr("rel", "3");
		$("#bin2 a.sort").removeClass("sort1").removeClass("sort2").addClass("sort3");
		}
	});
}

function dialogProject(offset,request,field,append,title,sql) {
	//console.log(offset[0]);
	$.ajax({ type: "GET", url: "/", data: 'path=apps/bin&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
			$("#modalDialog").html(html);
			$("#modalDialog").dialog('option', 'position', offset);
			//$("#modalDialog").css('top', offset[1]);
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


function binloadModuleStart() {
	var h = $("#bin .ui-layout-west").height();
	$("#bin1 .module-inner").css("height", h-46);
	$("#bin1 .module-actions").show();
	$("#bin-current").val("bin");
	$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/bin&request=getList", success: function(data){
		$("#bin1 ul").html(data.html);
		if(data.html == "<li></li>") {
			binActions(3);
			
		} else {
			binActions(1);
		}
		//$("#bin1").css("overflow", "auto").animate({height: h-46}, function() {
			$("#bin1 li").show();
			$("#bin1 a.sort").attr("rel", data.sort).addClass("sort"+data.sort);
			binInnerLayout.initContent('center');
				initScrollbar( '#bin .scrolling-content' );
				$('#bin1 input.filter').quicksearch('#bin1 li');
			var id = $("#bin1 .module-click:eq(0)").attr("rel");
			$("#bin1 .module-click:eq(0)").addClass('active-link');
			/*$.ajax({ type: "GET", url: "/", data: "path=apps/bin&request=getFolderDetails&id="+id, success: function(html){
				$("#"+bin.name+"-right").html(html);
				binInnerLayout.initContent('center');
				$('#bin1 input.filter').quicksearch('#bin1 li');
				
				}
			});*/
		//});
	}
	});
}


function binresetModuleHeights() {
	
	var h = $("#bin .ui-layout-west").height();
	if($("#bin1").height() != module_title_height) {
		$("#bin1").css("height", h-46);
		$("#bin1 .module-inner").css("height", h-46);
	}
	initScrollbar( '#bin .scrolling-content' );
}





var binLayout, binInnerLayout;

$(document).ready(function() { 

	binLayout = $('#bin').layout({
			west__onresize:				function() { binresetModuleHeights() }
		,	resizeWhileDragging:		true
		,	spacing_open:				0
		,	closable: 				false
		,	resizable: 				false
		,	slidable:				false
		, 	west__size:				325
		,	west__closable: 		true
		,	west__resizable: 		true
		, 	south__size:			10
		,	center__onresize: "binInnerLayout.resizeAll"
		
	});
	
	binInnerLayout = $('#bin div.ui-layout-center').layout({
			center__onresize:				function() { initScrollbar( '#bin .scrolling-content' ); }
		,	resizeWhileDragging:		false
		,	spacing_open:				0			// cosmetic spacing
		,	closable: 				false
		,	resizable: 				false
		,	slidable:				false
		,	north__paneSelector:	".center-north"
		,	center__paneSelector:	".center-center"
		//,	south__paneSelector:	".center-south"
		,	west__paneSelector:	".center-west"
		, 	north__size:			80
		//, 	south__size:			63
		, 	west__size:			50
		 

	});
	
	binloadModuleStart();


	/**
	* show folder list
	*/
	$("#bin1-outer > h3").click(function() {
		if(confirmNavigation()) {
			formChanged = false;
			var obj = getCurrentModule();
			$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		}
		
		if($(this).hasClass("module-bg-active")) {
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/bin&request=getFolderList", success: function(data){
				$("#bin1 ul").html(data.html);
				if(data.html == "<li></li>") {
					binActions(3);
				} else {
					binActions(1);
				}
				initScrollbar( '#bin .scrolling-content' );
				$('#bin1 input.filter').quicksearch('#bin1 li');
				var id = $("#bin1 .module-click:eq(0)").attr("rel");
				$("#bin1 .module-click:eq(0)").addClass('active-link');
				//$("#bin1 .drag:eq(0)").show();
				$.ajax({ type: "GET", url: "/", data: "path=apps/bin&request=getFolderDetails&id="+id, success: function(html){
					$("#bin-right").html(html);
					//binInnerLayout.initContent('center');
					initContentScrollbar();
					var h = $("#bin .ui-layout-west").height();
					$("#bin1").delay(200).animate({height: h-46}, function() {
						$(this).animate({height: h-71});			 
					});
					}
				 });
				}
			});
		} else {
			var h = $("#bin .ui-layout-west").height();
			var id = $("#bin1 .module-click:visible").attr("rel");
			var index = $("#bin1 .module-click").index($("#bin1 .module-click[rel='"+id+"']"));
			
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/bin&request=getFolderList", success: function(data){
				$("#bin1 ul").html(data.html);
				if(data.html == "<li></li>") {
					binActions(3);
				} else {
					binActions(1);
				}
				$('#bin1 input.filter').quicksearch('#bin1 li');
				$.ajax({ type: "GET", url: "/", data: "path=apps/bin&request=getFolderDetails&id="+id, success: function(html){
					$("#bin1 li").show();
					setModuleActive($("#bin1"),index);
					
					$("#bin1").css("overflow", "auto").animate({height: h-46}, function() {
						$("#"+bin.name+"-right").html(html);
						initScrollbar( '#bin .scrolling-content' );
						$("#bin-current").val("folder");
						setModuleDeactive($("#bin2"),'0');
						setModuleDeactive($("#bin3"),'0');
						$("#bin2 li").show();
						$("#bin2").css("height", h-96).removeClass("module-active");
						$("#bin2").prev("h3").removeClass("white");
						$("#bin2 .module-inner").css("height", h-96);
						$("#bin3 h3").removeClass("module-bg-active");
						$("#bin3 .bin3-content:visible").slideUp();
						//binInnerLayout.initContent('center');
						initContentScrollbar();
			$("#bin1").delay(200).animate({height: h-71});
					});
					}
				 });
				}
			});
		}
		$("#bin-top .top-headline").html("");
		$("#bin-top .top-subheadline").html("");
		$("#bin-top .top-subheadlineTwo").html("");
		return false;
	});


	$("#bin1 a.module-click").live('click',function(e) {
		if($(this).hasClass("deactivated")) {
			return false;
		}

		var id = $(this).attr("rel");
		var index = $("#bin a.module-click").index(this);
		$("#bin a.module-click").removeClass("active-link");
		$(this).addClass("active-link");
			
		$.ajax({ type: "GET", url: "/", data: "path=apps/"+ id +"&request=getBin", success: function(html){
			$("#bin-right").html(html);
			binInnerLayout.initContent('center');
			}
		});
		binActions(1);
		return false;
	});


});