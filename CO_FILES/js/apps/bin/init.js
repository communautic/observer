/* bin Object */
function binApplication(name) {
	this.name = name;


	this.actionClose = function() {
	  binLayout.toggle('west');
	}
 
 
	this.actionRefresh = function() {
		$("#bin1 .active-link").trigger("click");
	}


	this.actionBin = function() {
		var id = $("#bin1 .active-link").attr("rel");
		var txt = ALERT_DELETE_BIN;
		var langbuttons = {};
		langbuttons[ALERT_YES] = true;
		langbuttons[ALERT_NO] = false;
		$.prompt(txt,{ 
			buttons:langbuttons,
			callback: function(v,m,f){		
				if(v){
					$.ajax({ type: "GET", url: "/", data: "path=apps/"+ id +"&request=emptyBin", success: function(html){
						$("#bin-right").html(html);
						binInnerLayout.initContent('center');
						}
					});
				} 
			}
		});	
	}
	
	
	this.checkIn = function(id) {
		return true;
	}


	this.actionHelp = function() {
		var url = "/?path=apps/bin&request=getHelp";
		$("#documentloader").attr('src', url);
	}

}
var bin = new binApplication('bin');
bin.resetModuleHeights = binresetModuleHeights;
bin.modules_height = bin_num_modules*module_title_height;


function binActions(status) {
	switch(status) {
		case 0: actions = ['0','1','2']; break;
		default: 	actions = [];  	// none
	}
	$('#binActions > li span').each( function(index) {
		if(index in oc(actions)) {
			$(this).removeClass('noactive');
		} else {
			$(this).addClass('noactive');
		}
	})
}


function binloadModuleStart() {
	var h = $("#bin .ui-layout-west").height();
	$("#bin .ui-layout-west .radius-helper").height(h);
		if($("#bin1").height() != module_title_height) {
		$("#bin1").css("height", h-46);
		$("#bin1 .module-inner").css("height", h-46);
	}
	$("#bin-current").val("bin");
	binActions(0);
	var id = $("#bin1 .module-click:eq(0)").attr("rel");
	$("#bin1 .module-click:eq(0)").addClass('active-link');
	$.ajax({ type: "GET", url: "/", data: "path=apps/"+ id +"&request=getBin", success: function(html){
		$("#bin-right").html(html);
		binInnerLayout.initContent('center');
		}
	});
}


function binresetModuleHeights() {
	var h = $("#bin .ui-layout-west").height();
	$("#bin .ui-layout-west .radius-helper").height(h);
	if($("#bin1").height() != module_title_height) {
		$("#bin1").css("height", h-46);
		$("#bin1 .module-inner").css("height", h-46);
	}
}


var binLayout, binInnerLayout;

$(document).ready(function() {
						   
	if($('#bin').length > 0) {
		binLayout = $('#bin').layout({
				west__onresize:				function() { binresetModuleHeights() }
			,	resizeWhileDragging:		true
			,	spacing_open:				0
			,	spacing_closed:				0
			,	closable: 					false
			,	resizable: 					false
			,	slidable:					false
			, 	west__size:					325
			,	west__closable: 			true
			,	center__onresize: "binInnerLayout.resizeAll"
			
		});
		
		binInnerLayout = $('#bin div.ui-layout-center').layout({
				resizeWhileDragging:		true
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
		
		binloadModuleStart();
	}

	$("#bin1-outer > h3").click(function() {
		if(confirmNavigation()) {
			formChanged = false;
			var obj = getCurrentModule();
			$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		}
		$("#bin1 .module-click").removeClass('active-link');
		var id = $("#bin1 .module-click:eq(0)").attr("rel");
		$("#bin1 .module-click:eq(0)").addClass('active-link');
		$.ajax({ type: "GET", url: "/", data: "path=apps/"+ id +"&request=getBin", success: function(html){
			$("#bin-right").html(html);
			binInnerLayout.initContent('center');
			}
		 });
		return false;
	});


	$("#bin1 .module-click").live('click',function(e) {
		if($(this).hasClass("deactivated")) {
			return false;
		}
		var id = $(this).attr("rel");
		var index = $("#bin .module-click").index(this);
		$("#bin .module-click").removeClass("active-link");
		$(this).addClass("active-link");
			
		$.ajax({ type: "GET", url: "/", data: "path=apps/"+ id +"&request=getBin", success: function(html){
			$("#bin-right").html(html);
			binInnerLayout.initContent('center');
			}
		});
		binActions(0);
		return false;
	});


});