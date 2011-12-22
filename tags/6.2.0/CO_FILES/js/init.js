jQuery.fn.nl2br = function(){
    return this.each(function(){
        var that = jQuery(this);
        that.val(that.val().replace(/(<br\s*\/?>)|(<p><\/p>)/gi, "\r\n"));
    });
};
//jQuery("textarea").nl2br();


var module_title_height = 27;
$(window).bind('beforeunload', function() { 
	var obj = getCurrentModule();
	var cid = $('#'+getCurrentApp()+' input[name="id"]').val()
	obj.checkIn(cid);
	if(formChanged) {
		$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		return '';
	}
});

function Application (name) {
    this.name = name;
	this.displayname;
	this.usesLayout;
	this.resetModuleHeights;
	this.modules;
	this.modules_height;
	this.save;
}

function Module(name) {
    this.name = name;
	this.save;
}


var sendformOptions = { beforeSubmit: projectSendProcess, dataType:  'json', success: projectSendResponse };

function projectSendProcess(formData, form, sendformOptions) {
	if($("#to").html() == "") {
		return false;
	}
	formData[formData.length] = processList('to');
	formData[formData.length] = processList('cc');
	
}

function projectSendResponse(data) {
	
	if(data == 1) {
		var obj = getCurrentModule();
		obj.actionSendtoResponse();
	} else {
		$("#modalDialogForward").html("Failed");
	}
	
	/*if(data == 1) {
	$("#modalDialogForward").dialog('close');
	} else {
		$("#modalDialogForward").html("Failed");
	}*/
}

function initScrollbar ( elem ) {
	//alert(elem)
	var pane = $(elem);
	//pane.jScrollPane({ horizontalGutter: 10,verticalGutter: 10})
	
		/*.jScrollPane({
			scrollbarMargin:	10	// spacing between text and scrollbar
		,	scrollbarWidth:		8
		,	arrowSize:			0
		,	showArrows:			false
		})*/
		/*.parent().css({
			width:	'100%'
		,	height:	'100%'
	})*/
	;
	
	//var api = pane.data('jsp');

};


function getCurrentApp() {
	var app = $(".active-app").attr("rel");
	return app;
}

function getCurrentModule() {
	var app = getCurrentApp();
	var cur = $("#"+app+"-current").val();
	if(cur != app) {
		cur = app+'_'+cur;
	}
	var obj = window[cur];
	if(obj === undefined) {
		return false;
	} else {
		return obj;
	}
}

// form callback if title is empty
function setTitleFocus(v,m,f) {
		var app = getCurrentApp();
		// timeout for IE focus issue
		setTimeout(function() { $("#"+app+ " .title").focus(); }, 500);
	}

function processList(list) {
	var items = $("#"+list+" .listmember").size();
	var itemlist = "";
	$("#"+list+" .listmember").each( function(i) {
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

function processListApps(list) {
	var app = getCurrentApp();
	var field = $("#"+app+list+" .listmember");
	var items = field.size();
	var itemlist = "";
	field.each( function(i) {
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

function processListArray(num) {
	var items = $("#task_team_"+num+" .listmember").size();
	var itemlist = "";
	$("#task_team_"+num+" .listmember").each( function(i) {
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
	
	return { "name": "task_team["+num+"]", "value": itemlist };
}


function processDocList(list) {
	var items = $("#"+list+" .showItemContext").size();
	var itemlist = "";
	$("#"+list+" .showItemContext").each( function(i) {
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

function processDocListApps(list) {
	var app = getCurrentApp();
	var field = $("#"+app+list+" .showItemContext");
	var items = field.size();
	var itemlist = "";
	field.each( function(i) {
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



function processCustomText(list) {
	var text = $("#"+list+" .ct-content").html();
	text = text.replace(CUSTOM_NOTE+" ","");	
	return { "name": list, "value": text };
}

function processCustomTextApps(list) {
	var app = getCurrentApp();
	var text = $("#"+app+list+" .ct-content").html();
	text = text.replace(CUSTOM_NOTE+" ","");	
	return { "name": list, "value": text };
}

function processCustomTextArray(num) {
	var text = $("#task_team_"+num+"_ct .ct-content").html();
	text = text.replace(CUSTOM_NOTE+" ","");	
	return { "name": "task_team_ct["+num+"]", "value": text };
}

function processString(list) {
	var text = $("#"+list).html();	
	return { "name": list, "value": text };
}

function processStringApps(list) {
	var app = getCurrentApp();
	var text = $("#"+app+list).html();	
	return { "name": list, "value": text };
}


// convert array to use in operator (used with action console)
function oc(a) {
	var o = {};
	for(var i=0;i<a.length;i++) {
		o[a[i]]='';
	}
	return o;
}


function setModuleDeactive(elm,index) {
	elm.find(".module-click:eq("+index+")").removeClass('active-link').addClass("deactivated");
	elm.removeClass("module-bg-active");
	//elm.find("h3").removeClass("module-bg-active").addClass("white");
	elm.find(".module-actions").hide();
	elm.find("li:not(:eq("+index+"))").hide();
	elm.find(".num").hide();
	elm.find(".icon-checked-out").removeClass('icon-checked-out-active');
	elm.prev("h3").removeClass("module-bg-active").addClass("white");
	
}

function setModuleActive(elm,index) {
	elm.find(".module-click:eq("+index+")").addClass('active-link').removeClass("deactivated");
	elm.addClass("module-bg-active");
	elm.find(".module-actions").show();
	elm.find("li:not(:eq("+index+"))").show();
	elm.find(".num").show();
	elm.prev("h3").addClass("module-bg-active").removeClass("white");
}

// calc time between 2 hour/min fields
function checkTime(field) {
		Feld = eval('document.poform.'+field);
		FeldLength = Feld.value.length;
		FeldValue = Feld.value;
		if (FeldLength == 1) {
		Feld.value = "0"+FeldValue;
		}
		if (FeldLength == 0) {
		Feld.value = "00";
		}
		var t1 = document.poform.start_hour.value+':'+document.poform.start_min.value;
		var t2 = document.poform.end_hour.value+':'+document.poform.end_min.value;
		var m = ((t2.substring(0,t2.indexOf(':'))-0) * 60 +
				(t2.substring(t2.indexOf(':')+1,t2.length)-0)) - 
				((t1.substring(0,t1.indexOf(':'))-0) * 60 +
				(t1.substring(t1.indexOf(':')+1,t1.length)-0));
		var h = Math.floor(m / 60);
		//document.write(h + ':' + (m - (h * 60)));
		document.poform.length.value = h + ':' + (m - (h * 60));
}


function initNavScroll() {
	var div = $('#navSlider');
	var divWidth = div.width();
    var liNum = $(div).find('ul').children('li').length;
    var itemWidth = liNum*100;
	if(divWidth <= itemWidth ) {
		$('#appnav').hoverscroll({
			width: divWidth,
			height: 36,
			arrows:  true
		});
	}
}

function resetNavScroll() {
	var div = $('#appnav');
	if(div.hasClass('list')) {
		div.unwrap().unwrap().removeClass('list');
		div.siblings().remove()
		initNavScroll();
	} else {
		initNavScroll();
	}
}

$(window).resize(function() {
	resetNavScroll();
	/*var top = $('#container-inner').height();
	$('.app').each(function(index) { //set the initial z-index's
		if($(this).css('top') != 0) {
		$(this).css('top',top);
		}
	});*/
});

// Apps zindex settings
var z = num_apps; //for setting the initial z-index's
var inAnimation = false; //flag for testing if we are in a animation


$(document).ready(function() {
						   
	$("#intro").show().delay(2000).fadeOut("slow");
	initNavScroll();

	$('.elastic').livequery(function() {
		$(this).elastic();
	});

	var top = $('#container-inner').height();
	$('.app').each(function(index) { //set the initial z-index's
		if(index != 0) {
			$(this).css('top',2*top);
		}
	});
	
	
	$('a.browseAway').click( function(e) {
		e.preventDefault();
		$("#intro").fadeIn();
		var src = $(this).attr("href");
		var obj = getCurrentModule();
		var cid = $('#'+getCurrentApp()+' input[name="id"]').val()
		obj.checkIn(cid);
		setTimeout(function() { window.location.href = src; },500)
	});
	
	
	$('span.logout').on('click', function(e) {
		e.preventDefault();
		var txt = ALERT_LOGOUT;
		var langbuttons = {};
		langbuttons[ALERT_YES] = true;
		langbuttons[ALERT_NO] = false;
		$.prompt(txt,{ 
			buttons:langbuttons,
			callback: function(v,m,f){		
				if(v){
					$("#intro").fadeIn();
					var src = '/?path=login';
					var obj = getCurrentModule();
					var cid = $('#'+getCurrentApp()+' input[name="id"]').val()
					obj.checkIn(cid);
					setTimeout(function() { window.location.href = src; },500)
				}
			}
		});
	});


	$('#appnav span.toggleObservers').on('click', function(e) {
		e.preventDefault();
		var obj = getCurrentModule();
		var cid = $('#'+getCurrentApp()+' input[name="id"]').val()
		obj.checkIn(cid);
		var clickobj = $(this);
		var app = $(this).attr("rel");
		var app_active = $('#appnav span.active-app').attr('rel');
		if(app != app_active) {
			$('#appnav span.toggleObservers[rel=' +  app_active + ']').removeClass("active-app");
			clickobj.addClass("active-app");
			$('#'+app_active).css('top',2*$('#'+app_active).height() + 'px')																					   
			$('#'+app).animate({ 'top' : 0 })
		}
	});


	$('.coform').livequery(function() {
		var obj = getCurrentModule();
		$(this).ajaxForm(obj.poformOptions);
		return false;
	});

	$('span.actionClose').on('click', function(e) {
		e.preventDefault();
		var app = getCurrentApp();
		var obj = window[app];
		obj.actionClose();
	})

	$('span.actionNew').on('click', function(e) {
		e.preventDefault();
		if($(this).hasClass("noactive")) {
			return false;
		}
		var obj = getCurrentModule();
		obj.actionNew();
	})
	
	// title autosave
	$("input.bg, input.title, textarea.elastic").live('blur', function() { 
		if(confirmNavigation()) {
			formChanged = false;
			var obj = getCurrentModule();
			$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		}
	});
	
	$('span.actionPrint').on('click', function(e){
		e.preventDefault();
		if($(this).hasClass("noactive")) {
			return false;
		}
		var obj = getCurrentModule();
		obj.actionPrint();
	});
	
	$('span.actionSend').on('click', function(e){
		e.preventDefault();
		if($(this).hasClass("noactive")) {
			return false;
		}
		var obj = getCurrentModule();
		obj.actionSend();
	});
	
	$('span.actionSendVcard').on('click',function(e){
		e.preventDefault();
		if($(this).hasClass("noactive")) {
			return false;
		}
		var obj = getCurrentModule();
		obj.actionSendVcard();
	});
	
	$('span.actionDuplicate').on('click', function(e){
		e.preventDefault();
		if($(this).hasClass("noactive")) {
			return false;
		}
		var obj = getCurrentModule();
		obj.actionDuplicate();
	});
	
	$('span.actionExport').on('click', function(e){
		e.preventDefault();
		if($(this).hasClass("noactive")) {
			return false;
		}
		var obj = getCurrentModule();
		obj.actionExport();
	});
	
	$(document).on('click', 'span.actionDoExport',function(e) {
		e.preventDefault();
		if($(this).hasClass("noactive")) {
			return false;
		}
		var obj = getCurrentModule();
		obj.actionDoExport();
	});
	
	$('span.actionRefresh').on('click', function(e){
		e.preventDefault();
		if($(this).hasClass("noactive")) {
			return false;
		}
		var obj = getCurrentModule();
		obj.actionRefresh();
	});
	
	$('span.actionHelp').on('click', function(e){
		e.preventDefault();
		if($(this).hasClass("noactive")) {
			return false;
		}
		var obj = getCurrentModule();
		obj.actionHelp();
	});
	

	$('span.actionBin').on('click', function(e){
		e.preventDefault();
		if($(this).hasClass("noactive")) {
			return false;
		}
		var obj = getCurrentModule();
		obj.actionBin();
	});
	
	$('a.insertStatus').live('click',function() {
		var rel = $(this).attr("rel");
		var text = $(this).html();
		var module = getCurrentModule();
		module.insertStatus(rel,text);
		return false;
	});
	
	//$(document).on('click', 'a', fn);
	//$('a.insertStatusDate').live('click',function() {
	$(document).on('click', 'a.insertStatusDate',function(e) {
		e.preventDefault();
		var rel = $(this).attr("rel");
		var text = $(this).html();
		var module = getCurrentModule();
		module.insertStatusDate(rel,text);
	});
	
	$('a.insertContract').live('click',function(e) {
		e.preventDefault();
		var rel = $(this).attr("rel");
		var text = $(this).html();
		var module = getCurrentModule();
		module.insertContract(rel,text);
	});
	
	$(".document-uploader:visible").livequery(function() {
		var module = getCurrentModule();
		module.createUploader($(this));
	})
	
	$('span.newItem').live('click',function() {
		var module = getCurrentModule();
		module.newItem();
		return false;
	});
	
	
	$('a.newItemSelection').live('click',function(e) {
		e.preventDefault();
		var rel = $(this).attr("rel");
		var module = getCurrentModule();
		module.newItemSelection(rel);
	});
	
	$('a.showItemContext').live('click',function(e) {
		e.preventDefault();
		var ele = $(this);
		var uid = $(this).attr('uid');
		var field = $(this).attr('field');
		var module = window[$(this).attr("href")];
		module.showItemContext(ele,uid,field);
	});	
	
	
	$('a.downloadDocument').live('click',function(e) {
		e.preventDefault();
		var id = $(this).attr("rel");
		var module = window[$(this).attr("mod")];
		module.downloadDocument(id);
	});
	
	$('a.insertItem').live('click',function(e) {
		e.preventDefault();
		var field = $(this).attr("field");
		var append = $(this).attr("append");
		var id = $(this).attr("did");
		var text = $(this).attr("title");
		var module = window[$(this).attr("mod")];
		module.insertItem(field,append,id,text);
	});

	
	$('a.removeItem').live('click',function() {
		var field = $(this).attr('field');
		var clicked = $(this);
		var module = window[$(this).attr("href")];
		module.removeItem(clicked,field);
		return false;
	});
	
	$('a.binItem').live('click',function() {
		if($(this).hasClass('deactivated')) {
			return false;
		} else {
		var id = $(this).attr("rel");
		var module = getCurrentModule();
		module.binItem(id);
		}
		return false;
	});
	
	$('a.binDelete').live('click',function() {
		var id = $(this).attr("rel");
		var module = window[$(this).attr("href")];
		module.binDelete(id);
		return false;
	});
	
	$('a.binRestore').live('click',function() {
		var id = $(this).attr("rel");
		var module = window[$(this).attr("href")];
		module.binRestore(id);
		return false;
	});
	
	// tasks & files
	$('a.binDeleteItem').live('click',function() {
		var id = $(this).attr("rel");
		var module = window[$(this).attr("href")];
		module.binDeleteItem(id);
		return false;
	});
	
	$('a.binRestoreItem').live('click',function() {
		var id = $(this).attr("rel");
		var module = window[$(this).attr("href")];
		module.binRestoreItem(id);
		return false;
	});
	
	$('a.insertAccess').live('click',function() {
		var rel = $(this).attr("rel");
		var field = $(this).attr("field");
		var html = '<div class="listmember" field="'+field+'" uid="'+rel+'">' + $(this).html() + '</div>';
		$("#"+field).html(html);
		$("#modalDialog").dialog("close");
		var obj = getCurrentModule();
		$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		return false;
	});
	
	
	
	$('span.actionSetLogin').click(function(){
		var username = $("#username").val();
		var password = $("#password").val();
		$.ajax({ type: "POST", url: "/", data: "path=login&changelogin=1&username="+username+"&password="+password, success: function(html){
				  $("#intro-password").fadeOut();
					}
				});
	});
	
	
	$(".sort").click(function() {
		var obj = $(this);
		var sortcur = parseInt($(this).attr("rel"));
		if(sortcur < 3) {
			var sortnew = sortcur+1;
		} else {
			var sortnew = 1;
		}
		var module = getCurrentModule();
		module.sortclick(obj,sortcur,sortnew);
		return false;
	});

	$(".sortable").sortable({
		//handle: '.drag',
		containment: 'parent',
		tolerance: 'pointer',
		cursor: 'move',
		//placeholder: 'ui-state-highlight',
		update : function () {
			var order = $(this).sortable('serialize');
			var module = getCurrentModule();
			module.sortdrag(order);
	  	}
	});
	
	
	//var sendobj;
	$('.sendForm').livequery(function() {
		//var obj = getCurrentModule();
		$(this).ajaxForm(sendformOptions);
		//sendobj = obj;
	});
	
	$('.actionSendForm').live("click", function(e) {
		$('.sendForm').ajaxSubmit(sendformOptions);
		e.preventDefault();
	});
		

		
	$('.spinner').ajaxStart(function() {
		$(this).show();
			}).ajaxStop(function() {
		$(this).hide();
	});

	// bind clicks to close diaolgs
	//$(document).bind('click', function(e) {
	$(document).mousedown(function(e) {
								  // alert("y");
		var clicked=$(e.target); // get the element clicked
		if(clicked.is('.context') || clicked.parents().is('.context')) { 
			//alert(clicked.index());
		} else {
			$('.context').slideUp(function() {
										   $(this).remove()
										   });
		}
		if($('#modalDialog').dialog("isOpen")) {
			if(clicked.is('#modalDialog') || clicked.parents().is('#modalDialog')) { 
			} else {
				$('#modalDialog').dialog("close");
			}
		}
		if($('#modalDialogTime').dialog("isOpen")) {
			if(clicked.is('#modalDialogTime') || clicked.parents().is('#modalDialogTime')) { 
			} else {
				$('#modalDialogTime').dialog("close");
			}
		}
	});


	// init custom form elements
	$('form.jNice').livequery(function() { 
		$(this).jNice();
	});
	
	// Radio fields with date fields next
	$(".jNiceRadio").live('click',function() {
		if($(this).next("input").length > 0) {
			var field = $(this).next("input").attr("title");
			if (field != "") {
				$("#"+field).val(Date.today().toString('dd.MM.yyyy'));
			}
			$("#projects .ui-datepicker-trigger-action-status").addClass("disabled");
			 $("#"+field+" ~ a").removeClass("disabled");
		}
	});

	
	// content nav focus title
	$('.focusTitle').live('click',function() {
		var app = getCurrentApp();
		$("#"+app+ " .title").focus();
		// IE Fix
		//setTimeout(function() { $("#"+app+ " .title").focus(); }, 500);
		return false;
	});
	
	
	$('.selectTextfield').live('click',function() {
		$(this).parent().next().find('input').focus();
		return false;
	});
	
	$('.selectTextarea').live('click',function() {
		$(this).parent().siblings().find('textarea').focus();
		return false;
	});
	
	$('div.toggleSendTo').live('click',function(e) {
		e.preventDefault();
		$(this).next().slideToggle();
	});
	
	// meetings show drag icon for sorting - currently DEACTIVE
	/*$(".table-task tr").live('mouseover mouseout', function(event) {
	  if (event.type == 'mouseover') {
		$(this).find(".task-drag").show();
		//.animate({opacity: '1', left: '-20px'});
		
	  } else {
		//$(this).children(":first").animate({opacity: '0', left: '0px'});
		$(this).find(".task-drag").hide();
	  }
	});*/


	$("#modalDialog").dialog({  
		autoOpen: false,
		resizable: false,
		draggable: false,
		width: 180,  
		minHeight: 20,
		show: 'slide',
		hide: 'slide'
	})


	$('.showDialog').live('click',function() {
		var offsetsubtract = 150;
		if($(this).attr("offsetsubract") > 0) {
			var offsetsubtract = 150 - $(this).attr("offsetsubract");
		}
		var offset = $(this).offset();
		offset = [offset.left+offsetsubtract,offset.top+18];
		var sql;
		var request = $(this).attr("request"); // function name
		var field = $(this).attr("field"); // field to fill selection into
		var append = $(this).attr("append"); // add to existing or single selection
		var title = $(this).attr("title"); //header of dialog
		sql = $(this).attr("sql"); // special sql if present
		
		var app = getCurrentApp();
		var module = getCurrentModule();
		
		if($("#modalDialog").is(':visible') || $("#ui-datepicker-div").is(':visible')) {
			setTimeout(function() {
				$("#modalDialog").html("");
				module.actionDialog(offset,request,field,append,title,sql);					
			}, 500);
		} else {
			$("#modalDialog").html("");
			module.actionDialog(offset,request,field,append,title,sql);
		}
		return false;
	});


	// init modalDialogs
	$("#modalDialogForward").dialog({  
		dialogClass: 'sendtoWindow',
		autoOpen: false,
		resizable: true,
		resize: function(event, ui) {
			$('#sendToTextarea').height($(this).height() - 154);
			},
		open: function(event, ui) {
			$('#sendToTextarea').height($(this).height() - 154);
			},
		width: 400,  
		height: 320,
		show: 'slide',
		hide: 'slide'
	})


	$("#modalDialogTime").dialog({  
		autoOpen: false,
		resizable: false,
		draggable: false,
		width: 180,  
		height: 260,
		show: 'slide',
		hide: 'slide'
	});


	$('.showDialogTime').live('click',function() {
		var offset = $(this).offset();
		var field = $(this).attr("rel");
		var title = $(this).attr("title"); //header of dialog
		var time = $("#"+field).html();
		if($("#modalDialogTime").is(':visible') || $("#ui-datepicker-div").is(':visible')) {
			setTimeout(function() {
				$.ajax({ type: "GET", url: "/", data: "path=view/dialog_time&field="+field+"&time="+time, success: function(html){
				  $("#modalDialogTime").html(html);
					}
				});
				$("#modalDialogTime").dialog('option', 'position', [offset.left+150,offset.top+18]);
				$("#modalDialogTime").dialog('option', 'title', title);
				$("#modalDialogTime").dialog('open');			
			}, 500);
		} else {
			$.ajax({ type: "GET", url: "/", data: "path=view/dialog_time&field="+field+"&time="+time, success: function(html){
			  $("#modalDialogTime").html(html);
				}
			});
			$("#modalDialogTime").dialog('option', 'position', [offset.left+150,offset.top+18]);
			$("#modalDialogTime").dialog('option', 'title', title);
			$("#modalDialogTime").dialog('open');
		}
		return false;
	});


	$(".coTime-hr-btn").live("click", function() {
			var obj = $(this).attr("title");
			var val = $(this).html();
			var curval = $("#"+obj).html();
			var valnew = curval.replace(/^[0-9]{2}/,val);
			$("#"+obj).html(valnew);
			var obje = getCurrentModule();
			$('#'+getCurrentApp()+' .coform').ajaxSubmit(obje.poformOptions);
			return false;
	});
	
	$(".coTime-min-ten-btn").live("click", function() {
			var obj = $(this).attr("title");
			var val = $(this).html();
			var curval = $("#"+obj).html();
			var valnew = curval.replace(/:[0-9]{1}/,":"+val);
			$("#"+obj).html(valnew);
			var obje = getCurrentModule();
			$('#'+getCurrentApp()+' .coform').ajaxSubmit(obje.poformOptions);
			return false;
	});
	
	$(".coTime-min-one-btn").live("click", function() {
			var obj = $(this).attr("title");
			var val = $(this).html();
			var curval = $("#"+obj).html();
			var valnew = curval.replace(/[0-9]{1}$/,val);
			$("#"+obj).html(valnew);
			var obje = getCurrentModule();
			$('#'+getCurrentApp()+' .coform').ajaxSubmit(obje.poformOptions);
			return false;
	});

	$(".insertStringFromDialog").live("click", function() {
			var field = $(this).attr("rel");
			var val = $(this).html();
			$('#'+field).html(val);
			var obj = getCurrentModule();
			$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
			$("#modalDialog").dialog("close");
			return false;
	});
	



$("#tabs").livequery(function() { 
	$(this).tabs({
		//select: function(){closedialog = 1;}
	});
});


// init datepicker
$('.ui-datepicker-trigger-action').live('click',function() { 
	//$(this).prev().trigger('click');
	$(this).parent().next().find('img').trigger('click');
	return false;
});






	// init datepickers dialog_button.png
	$('.datepicker').livequery(function() { 
		$(this).datepicker({ dateFormat: 'dd.mm.yy', showOn: 'button', buttonText:"", buttonImage: co_files+'/img/pixel.gif',  buttonImageOnly: true, showButtonPanel: true, changeMonth: true, changeYear: true, showAnim: 'slide',
		beforeShow: function(input,inst) {
			/*var offset = $("#"+input.name + "_alt").offset();
			//offset = [offset.left+26,offset.top+14];
			
			inst.dpDiv.css("left",offset.left+'px').css("top",offset.top+'px');*/
			if(input.name == 'enddate') {
				$(this).datepicker('option', 'minDate', new Date(Date.parse($("input[name='startdate']").val())));
			}
			if(input.name.match(/task_startdate/)) {
				//alert("yes");
					$(this).datepicker('option', 'minDate', new Date(Date.parse($("input[name='kickoff']").val())));
			}
			if(input.name.match(/task_enddate/)) {
					var reg = /[0-9]+/.exec(input.name);
					//alert(reg);
					$(this).datepicker('option', 'minDate', new Date(Date.parse($("input[name='task_startdate["+reg+"]']").val())));
			}
			
				//alert(inst.id);
			/*if(input.name == 'meeting_status_end') {
				$(this).datepicker('option', 'minDate', new Date(Date.parse($("input[name='meeting_date']").val())));
			}*/
			},
		/*onSelect: function(dateText, inst) {
			$("#"+this.name + "_alt").html(dateText);
			$(this).hide;
			},*/

		onClose: function(dateText, inst) {
				if(this.name == 'startdate' || this.name == 'enddate') {
					var date1 = Date.parse($("input[name='startdate']").val());
					var date2 = Date.parse($("input[name='enddate']").val());
					var span = new TimeSpan(date2 - date1);
					// werktage?$("input[name='days']").val(span.getDays()+1);
				}
				// move entire project with kickoff
				if(this.name == 'startdate' && $("#durationEnd").html() != "" && this.value != $("input[name='moveproject_start']").val()) {
					//var moveproject_start = $("input[name='moveproject_start']").val();
					var txt = ALERT_PROJECT_MOVE_ALL;
					var langbuttons = {};
					langbuttons[ALERT_YES] = true;
					langbuttons[ALERT_NO] = false;
					$.prompt(txt,{ 
						buttons:langbuttons,
						callback: function(v,m,f){		
							if(v){
								var date1 = Date.parse($("input[name='startdate']").val());
								var date2 = Date.parse($("input[name='moveproject_start']").val());
								var span = new TimeSpan(date1 - date2);
								var days = span.getDays();
								var app = getCurrentApp();
								var obj = getCurrentModule();
								//alert(app);
								//alert(obj);
								switch(obj.name) {
									case 'projects': // duplicate project
										$("#"+app+" input[name='request']").val("moveProject").after('<input type="hidden" value="' + days + '" name="movedays"/>');
										//$("#poform").append('<input type="hidden" value="1" name="moveproject"/>');
										//$("#poform").append('<input type="hidden" value="' + days + '" name="movedays"/>');
										//$("#actionSave").trigger('click');
										$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
									break;
									case 'phase': // duplicate phase
										/*$("input[name='editphase']").remove();
										$("#poform").append('<input type="hidden" value="1" name="movephase"/>');
										$("#poform").append('<input type="hidden" value="' + days + '" name="movedays"/>');
										$("#actionSave").trigger('click');*/
										alert("move phase");
									break;
								}
								//$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
								//projects.actionMoveProject(days);
								
								/*switch($("#pocurrent").val()) {
									case 'project': // duplicate project
										$("input[name='editproject']").remove();
										$("#poform").append('<input type="hidden" value="1" name="moveproject"/>');
										$("#poform").append('<input type="hidden" value="' + days + '" name="movedays"/>');
										$("#actionSave").trigger('click');
									break;
									case 'phase': // duplicate phase
										$("input[name='editphase']").remove();
										$("#poform").append('<input type="hidden" value="1" name="movephase"/>');
										$("#poform").append('<input type="hidden" value="' + days + '" name="movedays"/>');
										$("#actionSave").trigger('click');
									break;
								}*/
									
							} else {
								var obj = getCurrentModule();
								$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
							}	
						}
					});
				}
				else if(this.name == 'enddate' && $("input[name='moveproject_end']").length > 0 && this.value != $("input[name='moveproject_end']").val()) {
					var txt = ALERT_PROJECT_MOVE_ALL;
					var langbuttons = {};
					langbuttons[ALERT_YES] = true;
					langbuttons[ALERT_NO] = false;
					$.prompt(txt,{ 
						buttons:langbuttons,
						callback: function(v,m,f){		
							if(v){
								var date1 = Date.parse($("input[name='enddate']").val());
								var date2 = Date.parse($("input[name='moveproject_end']").val());
								var span = new TimeSpan(date1 - date2);
								var days = span.getDays();
								$("input[name='editphase']").remove();
								$("#poform").append('<input type="hidden" value="1" name="movephase"/>');
								$("#poform").append('<input type="hidden" value="' + days + '" name="movedays"/>');
								$("#actionSave").trigger('click');	
							} else {

							}	
						}
					});
				}
				else if (this.name.match(/task_startdate/)){
					var reg = /[0-9]+/.exec(this.name);
					var end = $("input[name='task_enddate["+reg+"]']").val();
					if(Date.parse(end) < Date.parse(this.value)) {
						$("input[name='task_enddate["+reg+"]']").val(this.value)
					}
					var obj = getCurrentModule();
					$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
				}
				else if (this.name.match(/task_enddate/)){
					var obj = getCurrentModule();
					$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
					var reg = /[0-9]+/.exec(this.name);
					$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/phases&request=getTaskDependencyExists&id="+reg, success: function(data){																																																																				
						 if(data == "true") {
							 var txt = ALERT_PHASE_TASKS_MOVE_ALL;
							 var langbuttons = {};
							langbuttons[ALERT_YES] = true;
							langbuttons[ALERT_NO] = false;
							$.prompt(txt,{ 
								buttons:langbuttons,
								callback: function(v,m,f){		
									if(v){
										var date1 = Date.parse($("input[name='task_enddate["+reg+"]']").val());
										var date2 = Date.parse($("input[name='task_movedate["+reg+"]']").val());
										var span = new TimeSpan(date1 - date2);
										var days = span.getDays();
										
										if(days != 0) {
											//alert(days);
										$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/phases&request=moveDependendTasks&id="+reg+"&days="+days, success: function(data){
											//var name = obj.name;
											obj.actionRefresh();
											}
										});
										}
									}
								}
							});
						 }
						}
					});
				}
				else {
					var obj = getCurrentModule();
					if(obj.name != 'brainstorms_rosters') {
						$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
					}
				}
	   		}
 		});
	}); 


});
		
		
var formChanged = false;

$(document).ready(function() {
    
	$(".textarea-title").livequery(function () {
          $(this).data('initial_value', $(this).val());
		  $(this).keyup(function() {
          if ($(this).val() != $(this).data('initial_value')) {
			  formChanged = true;
			  $(this).data('initial_value', $(this).val());
		  }
		});
     });
	
	$(".bg").livequery(function () {
          $(this).data('initial_value', $(this).val());
		  $(this).keyup(function() {
          if ($(this).val() != $(this).data('initial_value')) {
			  formChanged = true;
			  $(this).data('initial_value', $(this).val());
		  }
		});
     });
	
	$(".elastic").livequery(function () {
          $(this).data('initial_value', $(this).val());
		  $(this).keyup(function() {
          if ($(this).val() != $(this).data('initial_value')) {
			  formChanged = true;
			  $(this).data('initial_value', $(this).val());
		  }
		});
     });
});


function confirmNavigation() {
     if (formChanged) {
		  return true;
     } else {
          return false;
     }
}


function navThreeTitleFirst(objectname, clicked, passed_id) {
	var object = window[objectname];
	var objectFirst = objectname.substr(0, 1);
	var objectnameCaps = objectFirst.toUpperCase() + objectname.substr(1);
	var objectnameCapsSingular = objectnameCaps.slice(0,-1);
	var num_modules = window[objectname+'_num_modules'];
	
	var obj = getCurrentModule();
	if(confirmNavigation()) {
		formChanged = false;
		$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
	}
	$('#'+objectname+'1').data('status','open');
	$('#'+objectname+'2').data('status','closed');
	$('#'+objectname+'3').data('status','closed');
	var cid = $('#'+objectname+' input[name="id"]').val()
	obj.checkIn(cid);
	
	if(clicked.hasClass("module-bg-active")) { //module active
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/" + objectname +"&request=getFolderList", success: function(data){
			$('#'+objectname+'1 ul').html(data.html);
			$('#'+objectname+'Actions .actionNew').attr("title",data.title);
			if(data.access == "guest") {
				window[objectname+'Actions']();
			} else {
				if(data.html == "<li></li>") {
					window[objectname+'Actions'](3);
				} else {
					window[objectname+'Actions'](9);
				}
			}
			if(passed_id === undefined) {
				var id = $('#'+objectname+'1 .module-click:eq(0)').attr("rel");
				$('#'+objectname+'1 .module-click:eq(0)').addClass('active-link');
			} else {
				var id = passed_id;
				$('#'+objectname+'1 .module-click[rel='+id+']').addClass('active-link');
			}
			$('#'+objectname).data("first" , id );
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/" + objectname +"&request=getFolderDetails&id="+id, success: function(text){
				$('#'+objectname+'-right').html(text.html);
				window['init'+objectnameCaps+'ContentScrollbar']();
				var h = $('#'+objectname+' div.ui-layout-west').height();
				$('#'+objectname+'1').delay(200).animate({height: h-71}, function() {
					$(this).animate({height: h-98});
				});
				$('#'+objectname+'2-outer').delay(200).animate({top: h}, function() {
					$(this).animate({top: h-27});
				});
				}
			 });
			}
		});
	} else { //module slide out
		var h = $('#'+objectname+' div.ui-layout-west').height();
		var id = $('#'+objectname+'1 .module-click:visible').attr("rel");
		$('#'+objectname).data({"first" : id});
		var index = $('#'+objectname+'1 .module-click').index($('#'+objectname+'1 .module-click[rel='+id+']'));
		$('#'+objectname+'3').data('status','closed');
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/" + objectname +"&request=getFolderList", success: function(data){
			$('#'+objectname+'1 ul').html(data.html);
			setModuleActive($('#'+objectname+'1'),index);
			$('#'+objectname+'-current').val('folder');
			setModuleDeactive($('#'+objectname+'2'),'0');
			setModuleDeactive($('#'+objectname+'3'),'0');
			$('#'+objectname+'2-outer').animate({top: h-27});
			$('#'+objectname+'2 li').show();
			$('#'+objectname+'2').prev("h3").removeClass("white");
			$('#'+objectname+'3 h3').removeClass("module-bg-active");
			$('#'+objectname+'3 div.thirdLevel').each(function(i) { 
				var t = h-150+i*27;
				$(this).animate({top: t})
			})
			$('#'+objectname+'Actions .actionNew').attr("title",data.title);
			if(data.access == "guest") {
				window[objectname+'Actions']();
			} else {
				if(data.html == "<li></li>") {
					window[objectname+'Actions'](3);
				} else {
					window[objectname+'Actions'](9);
				}
			}
			setTimeout(function() {
				$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/" + objectname +"&request=getFolderDetails&id="+id, success: function(text){
					$('#'+objectname+'1 li').show();
					$('#'+objectname+'-right').html(text.html);
					window['init'+objectnameCaps+'ContentScrollbar']();
					}
				 });
			}, 400)
			}
		});
	}
	$('#'+objectname).data({ "current" : "folder" });
	$('#'+objectname+'-top .top-headline').html("");
	$('#'+objectname+'-top .top-subheadline').html("");
	$('#'+objectname+'-top .top-subheadlineTwo').html("");
}


function navThreeTitleSecond(objectname, clicked, passed_id) {
	var object = window[objectname];
	var objectFirst = objectname.substr(0, 1);
	var objectnameCaps = objectFirst.toUpperCase() + objectname.substr(1);
	var objectnameCapsSingular = objectnameCaps.slice(0,-1);
	var num_modules = window[objectname+'_num_modules'];
	
	$('#'+objectname+'3').data('status','closed');
	var obj = getCurrentModule();
	if(confirmNavigation()) {
		formChanged = false;
		$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
	}
	var cid = $('#'+objectname+' input[name="id"]').val()
	obj.checkIn(cid);
	
	if(clicked.hasClass("module-bg-active")) {
		$('#'+objectname+'1-outer > h3').trigger("click");
	} else {
		if($('#'+objectname+'1').data('status') == 'closed') { // resize module
			$('#'+objectname+'2').data('status','open');
			var h = $('#'+objectname+' div.ui-layout-west').height();
			var id = $('#'+objectname).data('first');
			if(passed_id === undefined) {
				var objecctid = $('#'+objectname).data('second');
			} else {
				var objecctid = passed_id;					
			}
			$('#'+objectname).data({ "second" : objecctid});
			var index = $('#'+objectname+'2 .module-click').index($('#'+objectname+'2 .module-click[rel='+objecctid+']'));
			$('#'+objectname+'3 .module-actions').hide();
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/" + objectname +"&request=get"+objectnameCapsSingular+"List&id="+id, success: function(data){
				$('#'+objectname+'2 ul').html(data.html);
				$('#'+objectname+'Actions .actionNew').attr('title',data.title);	
				$('#'+objectname+'2 li').show();
				setModuleActive($('#'+objectname+'2'),index);
				$('#'+objectname+'2 .sort').attr('rel', data.sort).addClass('sort'+data.sort);
					//$(this).find('.west-ui-content').height(h-(object.modules_height+125));
					$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/"+objectname+"&request=get"+objectnameCapsSingular+"Details&id="+objecctid, success: function(text){
						$('#'+objectname+'-right').html(text.html);
						switch (text.access) {
							case "sysadmin":
								if(data.html == "<li></li>") {
									window[objectname+'Actions'](3);
								} else {
									window[objectname+'Actions'](0);
								}
							break;
							case "admin":
								if(data.html == "<li></li>") {
									window[objectname+'Actions'](3);
								} else {
									window[objectname+'Actions'](0);
								}
							break;
							case "guestadmin":
								if(data.html == "<li></li>") {
									window[objectname+'Actions'](3);
								} else {
									window[objectname+'Actions'](7);
								}
							break;
							case "guest":
								if(data.html == "<li></li>") {
									window[objectname+'Actions']();
								} else {
									window[objectname+'Actions'](5);
								}
							break;
						}
						
						if(text.access != "sysadmin") {								
							window[objectnameCaps+'2ModulesDisplay'](text.access);
						} else {
							$('#'+objectname+'3 div.thirdLevel').each(function(i) { 
								
								var t = $('#'+objectname+'3').height()-num_modules*27+i*27;
								$(this).animate({top: t})
							}) 
						}
					window['init'+objectnameCaps+'ContentScrollbar']();
					}
				});
				$('#'+objectname+'3 h3').removeClass('module-bg-active');
				}
			});
		} else {
			var id = $('#'+objectname).data('first');
			if(id == undefined) {
				return false;
			}
			var index = $('#'+objectname+'1 .module-click').index($('#'+objectname+'1 .module-click[rel='+id+']'));
			setModuleDeactive($('#'+objectname+'1'),index);
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/"+objectname+"&request=get"+objectnameCapsSingular+"List&id="+id, success: function(data){
				$('#'+objectname+'2 ul').html(data.html);
				$('#'+objectname+'Actions .actionNew').attr('title',data.title);
				if(passed_id === undefined) {
					var objecctid = $('#'+objectname+'2 .module-click:eq(0)').attr('rel');
				} else {
					var objecctid = passed_id;					
				}
				$('#'+objectname).data({ "second" : objecctid});
				if($('#'+objectname+'1').data('status') == 'open') { // slide up module
					$('#'+objectname+'1').data('status','closed');
					$('#'+objectname+'2').data('status','open');
					var idx = $('#'+objectname+'2 .module-click').index($('#'+objectname+'2 .module-click[rel='+objecctid+']'));
					setModuleActive($('#'+objectname+'2'),idx);
					$('#'+objectname+'2 .sort').attr('rel', data.sort).addClass('sort'+data.sort);
					var h = $('#'+objectname+' div.ui-layout-west').height();
					$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/"+objectname+"&request=get"+objectnameCapsSingular+"Details&id="+objecctid, success: function(text){
						$('#'+objectname+'-right').html(text.html);
						switch (text.access) {
							case "sysadmin":
								if(data.html == "<li></li>") {
									window[objectname+'Actions'](3);
								} else {
									window[objectname+'Actions'](0);
								}
							break;
							case "admin":
								if(data.html == "<li></li>") {
									window[objectname+'Actions'](3);
								} else {
									window[objectname+'Actions'](0);
								}
							break;
							case "guestadmin":
								if(data.html == "<li></li>") {
									window[objectname+'Actions'](3);
								} else {
									window[objectname+'Actions'](7);
								}
							break;
							case "guest":
								if(data.html == "<li></li>") {
									window[objectname+'Actions']();
								} else {
									window[objectname+'Actions'](5);
								}
							break;
						}
						window['init'+objectnameCaps+'ContentScrollbar']();
						if(text.access != "sysadmin") { 
							window[objectnameCaps+'2ModulesDisplay'](text.access);
						} else {
							var t = $('#'+objectname+'2').height();
							$('#'+objectname+'2').animate({height: t+num_modules*27})
							$('#'+objectname+'2-outer').animate({top: 96}, function() {
								$('#'+objectname+'3 div.thirdLevel').each(function(i) { 
									var position = $(this).position();
									var t = position.top-num_modules*module_title_height;
									$(this).animate({top: t})
								})					  								  
								$('#'+objectname+'-top .top-headline').html($('#'+objectname+'1 .deactivated').find('.text').html());
								$('#'+objectname+'2').animate({height: t})
							})
						}
					}
					});
				}
				}
			});
		}
	}
	$('#'+objectname).data({ "current" : objectname});
	$('#'+objectname+'-current').val(objectname);
	$('#'+objectname+'-top .top-subheadline').html("");
	$('#'+objectname+'-top .top-subheadlineTwo').html("");
}


function navItemFirst(objectname, clicked) {		
	var objectFirst = objectname.substr(0, 1);
	var objectnameCaps = objectFirst.toUpperCase() + objectname.substr(1);
	
	if(clicked.hasClass("deactivated")) {
		$('#'+objectname+'1-outer > h3').trigger("click");
		return false;
	}
	var obj = getCurrentModule();
	if(confirmNavigation()) {
		formChanged = false;
		$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
	}
	var cid = $('#'+objectname+' input[name="id"]').val()
	obj.checkIn(cid);
	
	var id = clicked.attr("rel");
	$('#'+objectname).data({ "first" : id});
	var index = $('#'+objectname+' .module-click').index(this);
	$('#'+objectname+' .module-click').removeClass("active-link");
	clicked.addClass("active-link");

	var h = $('#'+objectname+' div.ui-layout-west').height();
	$('#'+objectname+'1').delay(200).animate({height: h-71}, function() {
		$(this).animate({height: h-98});
	});
	$('#'+objectname+'2-outer').delay(200).animate({top: h}, function() {
		$(this).animate({top: h-27});
	});
	$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/"+objectname+"&request=getFolderDetails&id="+id, success: function(text){
		$('#'+objectname+'-right').html(text.html);
		window['init'+objectnameCaps+'ContentScrollbar']();
		if(text.access == "guest") {
				window[objectname+'Actions']();
			} else {
				window[objectname+'Actions'](9);
			}
		}
	});
}


function navItemSecond(objectname, clicked) {		
	var objectFirst = objectname.substr(0, 1);
	var objectnameCaps = objectFirst.toUpperCase() + objectname.substr(1);
	var objectnameCapsSingular = objectnameCaps.slice(0,-1);
	var num_modules = window[objectname+'_num_modules'];
	
	if(clicked.hasClass("deactivated")) {
		$('#'+objectname+'2-outer > h3').trigger("click");
		return false;
	}
	var obj = getCurrentModule();
	if(confirmNavigation()) {
		formChanged = false;
		$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
	}
	var cid = $('#'+objectname+' input[name="id"]').val()
	obj.checkIn(cid);
	
	var fid = $('#'+objectname+'1 .deactivated').attr("rel");
	var id = clicked.attr("rel");
	$('#'+objectname).data({ "second" : id});
	var index = $('#'+objectname+' .module-click').index(this);
	$('#'+objectname+' .module-click').removeClass("active-link");
	clicked.addClass("active-link");
	$('#'+objectname+'-top .top-headline').html($('#'+objectname+'1 .deactivated').find(".text").html());
	$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/"+objectname+"&request=get"+objectnameCapsSingular+"Details&fid="+fid+"&id="+id, success: function(text){
		$('#'+objectname+'-right').html(text.html);		
		if($('#checkedOut').length > 0) {
			$('#'+objectname+'2 .active-link .icon-checked-out').addClass('icon-checked-out-active');
		} else {
			$('#'+objectname+'2 .active-link .icon-checked-out').removeClass('icon-checked-out-active');
		}
		switch (text.access) {
			case "sysadmin":
				window[objectname+'Actions'](0);
			break;
			case "admin":
				window[objectname+'Actions'](0);
			break;
			case "guestadmin":
				window[objectname+'Actions'](7);
			break;
			case "guest":
				window[objectname+'Actions'](5);
			break;
		}

		window['init'+objectnameCaps+'ContentScrollbar']();
		if(text.access != "sysadmin") { 
			window[objectnameCaps+'ModulesDisplay'](text.access);
		} else {
			var t = $('#'+objectname+'2').height();
			$('#'+objectname+'2').animate({height: t+num_modules*27}, function() {
				$(this).animate({height: t});
			})
			$('#'+objectname+'3 div.thirdLevel').each(function(i) { 
				var position = $(this).position();
				var t = position.top+num_modules*27;
				$(this).animate({top: t}, function() {
					$(this).animate({top: position.top});
				})
			})
		}
		}
	});
}


function navItemThird(objectname, clicked) {		
	var obj = getCurrentModule();
	if(confirmNavigation()) {
		formChanged = false;
		$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
	}
	var cid = $('#'+objectname+' input[name="id"]').val()
	obj.checkIn(cid);
	
	var id = clicked.attr("rel");
	$('#'+objectname).data({ "third" : id});
	var ulidx = $('#'+objectname+'3 ul').index(clicked.parents("ul"));
	var index = $('#'+objectname+'3 ul:eq('+ulidx+') .module-click').index($('#'+objectname+'3 ul:eq('+ulidx+') .module-click[rel='+id+']'));
	$('#'+objectname+'3 .module-click').removeClass("active-link");
	clicked.addClass("active-link");
	var list = 0;
	obj.getDetails(ulidx,index,list);
}