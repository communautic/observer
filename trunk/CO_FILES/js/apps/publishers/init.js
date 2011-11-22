function initPublishersContentScrollbar() {
	publishersInnerLayout.initContent('center');
}

/* publishers Object */
function publishersApplication(name) {
	this.name = name;
}

var publishers = new publishersApplication('publishers');
publishers.resetModuleHeights = publishersresetModuleHeights;
publishers.modules_height = publishers_num_modules*module_title_height;
publishers.GuestHiddenModules = new Array("access");

function publishersActions(status) {
	/*	0= new	1= print	2= send		3= duplicate	4= handbook		5=refresh 	6 = delete*/
	switch(status) {
		//case 0: 	actions = ['0','1','2','3','4']; break; // all actions
		case 0: actions = ['0','1','2','3','4','5']; break;
		//case 1: 	actions = ['0','1','2','4']; break; 	// no duplicate
		case 1: actions = ['0','4']; break;
		//case 2: 	actions = ['1']; break;   					// just save
		case 3: 	actions = ['0','4']; break;   					// just new
		case 4: 	actions = ['0','1','2','4']; break;   		// new, print, send, handbook, refresh
		case 5: 	actions = ['1','2']; break;   			// print, send, refresh
		case 6: 	actions = ['4','5']; break;   			// handbook refresh
		case 7: 	actions = ['0','1','2']; break;   			// new, print, send, refresh
		case 8: 	actions = ['1','2','4']; break;   			// print, send, handbook, refresh
		case 9:		actions = ['0','1','2','5']; break;
		default: 	actions = [];  								// none
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
			  publishersActions(1);
		  } else {
			  publishersActions(0);
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
		var obj = getCurrentModule();
		obj.getDetails(ulidx,index);
		return false;
	});


});