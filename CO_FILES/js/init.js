jQuery.fn.nl2br = function(){
    return this.each(function(){
        var that = jQuery(this);
        that.val(that.val().replace(/(<br\s*\/?>)|(<p><\/p>)/gi, "\r\n"));
    });
};
//jQuery("textarea").nl2br();

function iOS(){
    return (
        (navigator.platform.indexOf("iPhone") != -1) ||
        (navigator.platform.indexOf("iPad") != -1)
    );
}

function dblclick_do_nothing() {
  return false;
}

function prevent_dblclick(e) {
	$(e.target).click(dblclick_do_nothing);
		  setTimeout(function(){
			$(e.target).unbind('click', dblclick_do_nothing);
		  }, 1000); 
}

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

var sendformOptions = { beforeSubmit: projectSendProcess, dataType:  'json', success: projectSendResponse };

function projectSendProcess(formData, form, sendformOptions) {
	if($("#to").html() == "") {
		return false;
	}
	var to = processList('to');
	if(to.value == "") {
		return false;
	}
	formData[formData.length] = processList('to');
	formData[formData.length] = processList('cc');
	$("#modalDialogForward").dialog('close');
}

function projectSendResponse(data) {
	if(data == 1) {
		var obj = getCurrentModule();
		obj.actionSendtoResponse();
	} else {
		$("#modalDialogForward").html("Failed");
	}
}

function getCurrentApp() {
	var app = $("#appnav span.active-app").attr("rel");
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

function processCoPopupList(list) {
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
	return itemlist;
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

function processListAppsInsurance(list) {
	var app = getCurrentApp();
	var field = $("#"+app+list+" .listmemberInsurance");
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

function processListArray(field,num) {
	var items = $("#"+field+"_"+num+" .listmember").size();
	var itemlist = "";
	$("#"+field+"_"+num+" .listmember").each( function(i) {
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
	return { "name": field+"["+num+"]", "value": itemlist };
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

function processCoPopupListCustomTextApps(list) {
	var text = $("#"+list+" .ct-content").html();
	text = text.replace(CUSTOM_NOTE+" ","");	
	return text;
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

// ajax check to see if user is still logged in + experimental Internet connection check
var connectionError = 0;
function activateSessionCheck() {
	var sessionactive = setInterval(function() {
		$.ajax({ global: false, type: "GET", url: "/", dataType:  'json', data: 'path=login/sessionCheck&request=sessionCheck', success: function(data){
				if(connectionError == 1) {
					connectionError = 0;
					$.prompt.close();
				}
				if(!data.active){
					clearInterval(sessionactive);
					if(data.user != undefined) {
					var langbuttons = {};
					langbuttons[ALERT_BUTTON_LOGOUT] = true;
					langbuttons[ALERT_BUTTON_LOGIN] = false;
					$.prompt(ALERT_MESSAGE_SESSION_RENEW + ' &nbsp; <input type="password" name="pass" /><input type="hidden" name="user" value="'+data.user+'" /><br /><br />',{ 
						buttons:langbuttons,
						submit: function(e,v,m,f){		
							if(v){
								e.preventDefault();
								$.ajax({ type: "POST", url: "/", data: 'path=login/sessionCheck&request=logout', success: function(data){
									document.location.href = '/';
									}
								});
							} else {
								e.preventDefault();
								//reactivate sesssion
								$.ajax({ type: "POST", url: "/", data: 'path=login/sessionCheck&request=reactivateLogin&user='+f.user+'&pass='+f.pass, success: function(data){
										if(!data){
											alert('double check password');
										} else {
											$.prompt.close();
											// call action refresh
											var obj = getCurrentModule();
											obj.actionRefresh();
											// re-activate sessioncheck
											activateSessionCheck();
										}
									}
								});
							}
						}
					});
					} else {
						var langbuttons = {};
						langbuttons[ALERT_BUTTON_LOGIN] = true;
						$.prompt(ALERT_MESSAGE_SESSION_COOKIE,{
							buttons:langbuttons,
							submit: function(e,v,m,f){
								e.preventDefault();
								document.location.href = '/';
							}
						});
					}
				}
			},
			error: function(statusCode, errorThrown) {
				if (statusCode.status == 404) {
					if(connectionError == 0) {
						connectionError = 1;
						var txt = ALERT_MESSAGE_INTERNET;
						setTimeout(function(){
							$.prompt(txt,{buttons: {}});
						},2000)
					}
				}
			}
		});
	}, 15000);
}
activateSessionCheck();

$(window).resize(function() {
	resetNavScroll();
});

// Apps zindex settings
var z = num_apps; //for setting the initial z-index's
var inAnimation = false; //flag for testing if we are in a animation


$(document).ready(function() {
						   
	$("#intro").show().delay(2000).fadeOut("slow");
	initNavScroll();

	$('.elastic,.elastic-two').livequery(function() {
		$(this).elastic();
	});

	var top = $('#container-inner').height();
	$('.app').each(function(index) { //set the initial z-index's
		if(index != 0) {
			$(this).css('top',2*top);
		}
	});

	$('a.browseAway').on('click', function(e) {
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
			buttons: langbuttons,
			submit: function(e,v,m,f){		
				if(v){
					$("#intro").fadeIn();
					var src = '/?path=login';
					var obj = getCurrentModule();
					if(obj != false) {
						var cid = $('#'+getCurrentApp()+' input[name="id"]').val()
						obj.checkIn(cid);
					}
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
			var targetheight = 2*$('#'+app_active).height();
			$('#'+app_active).css('top', targetheight + 'px');
			var vdoctoolbar = $('#'+app_active+' div.mceExternalToolbar');
			if($('#'+app_active).data("current") == 'vdocs') {
				var vtop = targetheight + 130;
				vdoctoolbar.css('cssText', 'top: ' + vtop + 'px !important');
			}
			$('#'+app).animate({ 'top' : 0 }, function() {
				var vdoct = $('#'+app+' div.mceExternalToolbar');
				if($('#'+app).data("current") == 'vdocs') {
					vdoct.fadeIn('slow').css('cssText', 'top: 130px !important');
				}					   
			})
			var appobject = window[app];
		}
	}).disableSelection();


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
	
	$('span.actionContact').on('click', function(e) {
		e.preventDefault();
		if($(this).hasClass("noactive")) {
			return false;
		}
		e.preventDefault();
		/*var offsetsubtract = 70;
		if($(this).attr("offsetsubract") > 0) {
			var offsetsubtract = 70 - $(this).attr("offsetsubract");
		}
		var offset = $(this).offset();*/
		var offset = { my: "left top", at: "right+15 top", of: $(this) }
		//offset = [offset.left+offsetsubtract,offset.top];
		var obj = getCurrentModule();
		obj.actionContact(offset);
	})
	
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
	
	$('span.actionHandbook').on('click', function(e){
		e.preventDefault();
		if($(this).hasClass("noactive")) {
			return false;
		}
		var app = getCurrentApp();
		var obj = window[app];
		obj.actionHandbook();
	});
	
	$('span.actionPrintTwo').on('click', function(e){
		e.preventDefault();
		if($(this).hasClass("noactive")) {
			return false;
		}
		var app = getCurrentApp();
		var obj = window[app];
		obj.actionPrintTwo();
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
	
	
	$('span.actionConvert').on('click', function(e){
		e.preventDefault();
		if($(this).hasClass("noactive")) {
			return false;
		}
		var obj = getCurrentModule();
		obj.actionConvert();
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
	
	$(document).on('click','a.insertStatus',function(e) {
		e.preventDefault();
		var rel = $(this).attr("rel");
		var text = $(this).html();
		var module = getCurrentModule();
		module.insertStatus(rel,text);
	});

	$(document).on('click','a.insertStatusDate',function(e) {
		e.preventDefault();
		var rel = $(this).attr("rel");
		var text = $(this).html();
		var module = getCurrentModule();
		module.insertStatusDate(rel,text);
	});

	$(document).on('click','a.insertContract',function(e) {
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

	$(document).on('click','span.newItem',function(e) {
		e.preventDefault();
		var module = getCurrentModule();
		module.newItem();
	});
	
	$(document).on('click','span.newItemOption',function(e) {
		e.preventDefault();
		var ele = $(this);
		var rel = $(this).attr("rel");
		var module = getCurrentModule();
		module.newItemOption(ele,rel);
	});

	$(document).on('click','a.newItemSelection',function(e) {
		e.preventDefault();
		var rel = $(this).attr("rel");
		var module = getCurrentModule();
		module.newItemSelection(rel);
	});

	$(document).on('click','a.showItemContext',function(e) {
		e.preventDefault();
		var ele = $(this);
		var uid = $(this).attr('uid');
		var field = $(this).attr('field');
		var module = window[$(this).attr("href")];
		module.showItemContext(ele,uid,field);
	});

	$('.coTooltip').livequery(function() {
		$(this).tooltip({
			items: $(this),
			content: $(this).find(".coTooltipHtml").html(),
			track: true,
			show: false,
			hide: false
		});
	})

	$(document).on('click','.showCoPopup',function(e) {
		e.preventDefault();
		var el = $(this);
		var request = el.attr('request');
		var obj = getCurrentModule();
		obj.coPopup(el,request);
	});
	
	$(document).on('click','#co-popup label',function(e) {
		e.preventDefault();
		$(this).next().focus();
	});

	$(document).on('click','a.downloadDocument',function(e) {
		e.preventDefault();
		var id = $(this).attr("rel");
		var module = window[$(this).attr("mod")];
		module.downloadDocument(id);
	});

	$(document).on('click','a.insertItem',function(e) {
		e.preventDefault();
		var field = $(this).attr("field");
		var append = $(this).attr("append");
		var id = $(this).attr("did");
		var text = $(this).attr("title");
		var module = window[$(this).attr("mod")];
		module.insertItem(field,append,id,text);
	});

	$(document).on('click','a.removeItem',function(e) {
		e.preventDefault();
		var field = $(this).attr('field');
		var clicked = $(this);
		var module = window[$(this).attr("href")];
		module.removeItem(clicked,field);
	});

	$(document).on('click','a.binItem',function(e) {
		e.preventDefault();
		if($(this).hasClass('deactivated')) {
			return false;
		} else {
			var id = $(this).attr("rel");
			var module = getCurrentModule();
			module.binItem(id);
		}
	});
	
	$(document).on('click','span.binItems',function(e) {
		e.preventDefault();
		if($(this).hasClass('deactivated')) {
			return false;
		} else {
			var module = getCurrentModule();
			module.binItems();
		}
	});
	
	$(document).on('click','a.binDelete',function(e) {
		e.preventDefault();
		var id = $(this).attr("rel");
		var module = window[$(this).attr("href")];
		module.binDelete(id);
	});

	$(document).on('click','a.binRestore',function(e) {
		e.preventDefault();
		var id = $(this).attr("rel");
		var module = window[$(this).attr("href")];
		module.binRestore(id);
	});

	$(document).on('click','a.binDeleteItem',function(e) {
		e.preventDefault();
		var id = $(this).attr("rel");
		var module = window[$(this).attr("href")];
		module.binDeleteItem(id);
	});

	$(document).on('click','a.binRestoreItem',function(e) {
		e.preventDefault();
		var id = $(this).attr("rel");
		var module = window[$(this).attr("href")];
		module.binRestoreItem(id);
	});
	
	$(document).on('click','a.binDeleteColumn',function(e) {
		e.preventDefault();
		var id = $(this).attr("rel");
		var module = window[$(this).attr("href")];
		module.binDeleteColumn(id);
	});

	$(document).on('click','a.binRestoreColumn',function(e) {
		e.preventDefault();
		var id = $(this).attr("rel");
		var module = window[$(this).attr("href")];
		module.binRestoreColumn(id);
	});
	
	$(document).on('click','a.insertAccess',function(e) {
		e.preventDefault();
		var rel = $(this).attr("rel");
		var field = $(this).attr("field");
		var html = '<div class="listmember" field="'+field+'" uid="'+rel+'">' + $(this).html() + '</div>';
		$("#"+field).html(html);
		$("#modalDialog").dialog("close");
		var obj = getCurrentModule();
		$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
	});
	
	// forums app specific
	$(document).on('click','a.openReplyWindow',function(e) {
		e.preventDefault();
		var id = $(this).attr("rel");
		var module = getCurrentModule();
		module.openReplyWindow(id);
	});
	
	$(document).on('click','div.closeReplyWindow',function(e) {
		e.preventDefault();
		var module = getCurrentModule();
		module.closeReplyWindow();
	});
	
	$(document).on('click','span.postReply',function(e) {
		e.preventDefault();
		var module = getCurrentModule();
		module.postReply();
	});
	
	$(document).on('click','div.togglePost',function(e) {
		e.preventDefault();
		var id = $(this).attr("rel");
		var obj = $(this);
		var module = getCurrentModule();
		module.togglePost(id,obj);
	});

	$(".sort").on('click', function(e) {
		e.preventDefault();
		var obj = $(this);
		var sortcur = parseInt($(this).attr("rel"));
		if(sortcur < 3) {
			var sortnew = sortcur+1;
		} else {
			var sortnew = 1;
		}
		var module = getCurrentModule();
		module.sortclick(obj,sortcur,sortnew);
	});

	if(!iOS()){
	$(".sortable").sortable({
		containment: 'parent',
		tolerance: 'pointer',
		cursor: 'move',
		update : function () {
			var order = $(this).sortable('serialize');
			var module = getCurrentModule();
			module.sortdrag(order);
	  	}
	});
	}

	$('.sendForm').livequery(function() {
		$(this).ajaxForm(sendformOptions);
	});

	$(document).on('click', 'span.actionSendForm',function(e) {
		e.preventDefault();
		$('.sendForm').ajaxSubmit(sendformOptions);
	});

	// possibly bind to app?
	$(document).ajaxStart(function() {
		$('.spinner').show();
			}).ajaxStop(function() {
		$('.spinner').hide();
	});

	// bind clicks to close diaolgs
	$(document).mousedown(function(e) {
		var clicked=$(e.target); // get the element clicked
		var app = getCurrentApp();
		if(clicked.is('.context') || clicked.parents().is('.context')) { 
		} else {
			$('.context').slideUp(function() {
				$(this).remove()
			});
		}
		if(clicked.is('.appSettingsPopup') || clicked.parents().is('.appSettingsPopup')) { 
		} else {
			$('#'+app+' .appSettingsPopup').slideUp();
		}
		if(clicked.is('#co-popup') || clicked.parents().is('#co-popup')) { 
		} else {
			if(clicked.is('#modalDialog') || clicked.parents().is('#modalDialog')) { 
			} else {
			$('#co-popup').css('left',-1000);
			/*if($('#co-popup').css('left') != '-1000px') {
			$('#co-popup').animate({width:'toggle'}, function() {
				$(this).css('left',-1000).show();
			})
			}*/
			}
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

	$(document).on('click', 'span.focusTitle',function(e) {
		e.preventDefault();
		var app = getCurrentApp();
		$("#"+app+ " .title").focus();
	});

	$(document).on('click', '.selectTextfield',function(e) {
		e.preventDefault();
		$(this).parent().next().find('input').focus();
	});

	$(document).on('click', '.selectTextarea',function(e) {
		e.preventDefault();
		$(this).parent().siblings().find('textarea').focus();
	});

	$(document).on('click', 'div.toggleSendTo',function(e) {
		e.preventDefault();
		$(this).next().slideToggle();
	});
	
	$(document).on('click', 'span.loadBarchartZoom',function(e) {
		e.preventDefault();
		var zoom = $(this).attr('rel');
		var module = getCurrentModule();
		module.loadBarchartZoom(zoom);
	});

	$("#modalDialog").dialog({  
		autoOpen: false,
		resizable: false,
		draggable: false,
		width: 200,  
		minHeight: 20,
		show: 'slide',
		hide: 'slide'
	})


	$(document).on('click', '.showDialog',function(e) {
		e.preventDefault();
		/*var offsetsubtract = 150;
		if($(this).attr("offsetsubract") > 0) {
			var offsetsubtract = 150 - $(this).attr("offsetsubract");
		}
		var offset = $(this).offset();
		offset = [offset.left+offsetsubtract,offset.top+18];*/
		//new 10.2 ui offset
		//$("#modalDialog").dialog('option', 'appendTo', 'body');
		var offset = { my: "left top", at: "right+15 bottom", of: $(this) }
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
	});


	// init modalDialogs
	$("#modalDialogForward").dialog({  
		dialogClass: 'sendtoWindow',
		autoOpen: false,
		resizable: true,
		resize: function(event, ui) {
			var tofield = $('#to').height();
			if(tofield == 0) { tofield = 16; }
			var bccfield = $('#cc').height();
			if(bccfield == 0) { bccfield = 16; }
			$('#sendToTextarea').height($(this).height() - 122 - tofield - bccfield);
			},
		open: function(event, ui) {
			var tofield = $('#to').height();
			if(tofield == 0) { tofield = 16; }
			var bccfield = $('#cc').height();
			if(bccfield == 0) { bccfield = 16; }
			$('#sendToTextarea').height($(this).height() - 122 - tofield - bccfield);
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
		width: 175,  
		height: 258,
		show: 'slide',
		hide: 'slide'
	});


	$(document).on('click', '.showDialogTime',function(e) {
		e.preventDefault();
		//var offset = $(this).offset();
		var offset = { my: "left top", at: "right+15 bottom", of: $(this) };
		var field = $(this).attr("rel");
		var title = $(this).attr("title"); //header of dialog
		var time = $("#"+field).html();
		if($("#modalDialogTime").is(':visible') || $("#ui-datepicker-div").is(':visible')) {
			setTimeout(function() {
				$.ajax({ type: "GET", url: "/", data: "path=view/dialog_time&field="+field+"&time="+time, success: function(html){
				  $("#modalDialogTime").html(html);
					}
				});
				//$("#modalDialogTime").dialog('option', 'position', [offset.left+150,offset.top+18]);
				$("#modalDialogTime").dialog('option', 'position', offset);
				$("#modalDialogTime").dialog('option', 'title', title);
				$("#modalDialogTime").dialog('open');			
			}, 500);
		} else {
			$.ajax({ type: "GET", url: "/", data: "path=view/dialog_time&field="+field+"&time="+time, success: function(html){
			  $("#modalDialogTime").html(html);
				}
			});
			//$("#modalDialogTime").dialog('option', 'position', [offset.left+150,offset.top+18]);
			$("#modalDialogTime").dialog('option', 'position', offset);
			$("#modalDialogTime").dialog('option', 'title', title);
			$("#modalDialogTime").dialog('open');
		}
	});

	$(document).on('click', '.coTime-hr-btn',function(e) {
		e.preventDefault();
		var obj = $(this).attr("title");
		var val = $(this).html();
		var curval = $("#"+obj).html();
		var valnew = curval.replace(/^[0-9]{2}/,val);
		$("#"+obj).html(valnew);
		var obje = getCurrentModule();
		$('#'+getCurrentApp()+' .coform').ajaxSubmit(obje.poformOptions);
	});

	$(document).on('click', '.coTime-min-ten-btn',function(e) {
		e.preventDefault();
		var obj = $(this).attr("title");
		var val = $(this).html();
		var curval = $("#"+obj).html();
		var valnew = curval.replace(/:[0-9]{1}/,":"+val);
		$("#"+obj).html(valnew);
		var obje = getCurrentModule();
		$('#'+getCurrentApp()+' .coform').ajaxSubmit(obje.poformOptions);
	});

	$(document).on('click', '.coTime-min-one-btn',function(e) {
		e.preventDefault();
		var obj = $(this).attr("title");
		var val = $(this).html();
		var curval = $("#"+obj).html();
		var valnew = curval.replace(/[0-9]{1}$/,val);
		$("#"+obj).html(valnew);
		var obje = getCurrentModule();
		$('#'+getCurrentApp()+' .coform').ajaxSubmit(obje.poformOptions);
	});

	$(document).on('click', '.insertStringFromDialog',function(e) {
		e.preventDefault();
		var field = $(this).attr("rel");
		var val = $(this).html();
		$('#'+field).html(val);
		var obj = getCurrentModule();
		$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		$("#modalDialog").dialog("close");
	});
	
	$(document).on('click', 'a.insertFromDialog', function(e) {
		e.preventDefault();
		var field = $(this).attr("field");
		var gid = $(this).attr("gid");
		var title = $(this).attr("title");
		var obj = getCurrentModule();
		obj.insertFromDialog(field,gid,title);
	});

	$("#tabs").livequery(function() { 
		$(this).tabs({
			select: function(event, ui) {
			if(ui.index == 2) {
				
				setTimeout(function(){
			$('#custom-text').focus();
		  }, 200); 
			}
		}
		});
		$( ".tabs-bottom .ui-tabs-nav, .tabs-bottom .ui-tabs-nav > *" )
			.removeClass( "ui-corner-all ui-corner-top" )
			.addClass( "ui-corner-bottom" );
	});
	
	$(document).on('click', 'div.contentTabs ul.contentTabsList span',function(e) {
		e.preventDefault();
		var what = $(this).attr('rel');
		var app = getCurrentApp();
		var i = $('#' + app + ' div.contentTabs ul.contentTabsList span').index(this);
		$('#' + app + ' div.contentTabs ul.contentTabsList span').each(function (index) {
			if(i == index) {
				$(this).addClass('active');
			} else {
				$(this).removeClass('active');
			}
		})
		var obj = getCurrentModule();
		obj.actionLoadTab(what);
	});
	
	$(document).on('click', 'div.contentSubTabs ul span',function(e) {
		e.preventDefault();
		var what = $(this).attr('rel');
		var i = $('div.contentSubTabs ul span').index(this);
		$('div.contentSubTabs ul span').each(function (index) {
			if(i == index) {
				$(this).addClass('active');
			} else {
				$(this).removeClass('active');
			}
		})
		var obj = getCurrentModule();
		obj.actionLoadSubTab(what);
	});
	
	
	$(document).on('click', '.externalLoadThreeLevels',function(e) {
		e.preventDefault();
		var href = $(this).attr('rel').split(",");
		externalLoadThreeLevels(href[0],href[1],href[2],href[3],href[4]);
	});	

	// init datepicker
	$(document).on('click', '.ui-datepicker-trigger-action',function(e) {
		e.preventDefault();
		$(this).parent().next().find('img').trigger('click');
	});

	// init datepickers dialog_button.png
	$('.datepicker').livequery(function() { 
		$(this).datepicker({ dateFormat: 'dd.mm.yy', showOn: 'button', buttonText:"", buttonImage: co_files+'/img/pixel.gif',  buttonImageOnly: true, showButtonPanel: true, changeMonth: true, changeYear: true, yearRange: 'c-5:c+5', showAnim: 'slide',
			beforeShow: function(input,inst) {
				if(input.name == 'enddate') {
					$(this).datepicker('option', 'minDate', new Date(Date.parse($("input[name='startdate']").val())));
				}
				if(input.name.match(/task_startdate/)) {
					$(this).datepicker('option', 'minDate', new Date(Date.parse($("input[name='kickoff']").val())));
				}
				if(input.name.match(/task_enddate/)) {
					var reg = /[0-9]+/.exec(input.name);
					$(this).datepicker('option', 'minDate', new Date(Date.parse($("input[name='task_startdate["+reg+"]']").val())));
				}
				// trainings
				if(input.name == 'date2') {
					if($("input[name='date3']").length > 0) {
						$(this).datepicker('option', 'minDate', new Date(Date.parse($("input[name='date3']").val())));
					} else {
						$(this).datepicker('option', 'minDate', new Date(Date.parse($("input[name='date1']").val())));
					}
				}
				if(input.name == 'date3') {
						$(this).datepicker('option', 'minDate', new Date(Date.parse($("input[name='date1']").val())));
				}
				if(input.name == 'registration_end') {
					$(this).datepicker('option', 'maxDate', new Date(Date.parse($("input[name='date1']").val())));
				}
				setTimeout(function() {
					var d = new Date();
					var m = d.getMonth()+1;
					var y = d.getFullYear();
					var is = new Date(Date.parse(input.value));
					var month = is.getMonth()+1;
					var year = is.getFullYear();
					if(m == month && y == year ) {
						$('button.ui-datepicker-current').addClass('disabled');
					}
				}, 1 );
			},
			onChangeMonthYear: function(year,month, inst ) {
				setTimeout(function() {
					var d = new Date();
					var m = d.getMonth()+1;
					var y = d.getFullYear();
					if(m == month && y == year ) {
						$('button.ui-datepicker-current').addClass('disabled');
					}
				}, 1 );
			},
			onClose: function(dateText, inst) {
				var app = getCurrentApp();
				var object = window[app];
				object.datepickerOnClose(this);
				//setTimeout(function() { inst.input.click(); }, 5000);
	   		}
 		});
	});
	
	$(document).on('click', 'span.statusButton',function(e) {
		e.preventDefault();
		var p = $(this).parent().parent();
		if($(this).hasClass('noDate')) {
			$('#'+getCurrentApp()+' span.statusButton').removeClass('active');
			$(this).addClass('active');
			p.find('.statusdp').val('');
			p.find('.status-time').html($(this).attr('reltext'));
			var obj = getCurrentModule();
			obj.statusOnClose();
		} else if($(this).hasClass('coPopupStatus')) {
			$('#co-popup span.statusButton').removeClass('active');
			$(this).addClass('active');
			var status = $(this).attr('rel');
			var obj = getCurrentModule();
			obj.coPopupStatus(status);
		} else {
			$('#'+getCurrentApp()+' span.statusButton').removeClass('active');
			$(this).addClass('active');
			p.find('.status-time').html($(this).attr('reltext'));
			p.find('img').trigger('click');
		}
	});
	
	$('.statusdp').livequery(function() { 
		$(this).datepicker({ dateFormat: 'dd.mm.yy', showOn: 'button', buttonText:"", buttonImage: co_files+'/img/pixel.gif',  buttonImageOnly: true, showButtonPanel: true, changeMonth: true, changeYear: true, yearRange: 'c-5:c+5', showAnim: 'slide',
			beforeShow: function(input,inst) {
				var today = new Date();
				input.value = today.toString("dd.MM.yyyy");
				setTimeout(function() {
					var d = new Date();
					var m = d.getMonth()+1;
					var y = d.getFullYear();
					var is = new Date(Date.parse(input.value));
					var month = is.getMonth()+1;
					var year = is.getFullYear();
					if(m == month && y == year ) {
						$('button.ui-datepicker-current').addClass('disabled');
					}
				}, 1 );
			},
			onChangeMonthYear: function(year,month, inst ) {
				setTimeout(function() {
					var d = new Date();
					var m = d.getMonth()+1;
					var y = d.getFullYear();
					if(m == month && y == year ) {
						$('button.ui-datepicker-current').addClass('disabled');
					}
				}, 1 );
			},
			onClose: function(dateText, inst) {
				var obj = getCurrentModule();
				obj.statusOnClose();
	   		}
 		});
	});
	
	$('.checkpointdp').livequery(function() {
		var chpexistsSpan = $(this).next();
		$(this).datepicker({ dateFormat: 'dd.mm.yy', showOn: 'button', buttonText:"", buttonImage: co_files+'/img/pixel.gif',  buttonImageOnly: true, showButtonPanel: true, changeMonth: true, changeYear: true, yearRange: 'c-5:c+5', showAnim: 'slide',
			beforeShow: function(input,inst) {
				setTimeout(function() {
					if(input.value != '') {
						var d = new Date();
						var m = d.getMonth()+1;
						var y = d.getFullYear();
						var is = new Date(Date.parse(input.value));
						var month = is.getMonth()+1;
						var year = is.getFullYear();
						if(m == month && y == year ) {
							$('button.ui-datepicker-current').addClass('disabled');
						} 
					} else {
						$('button.ui-datepicker-current').addClass('disabled');
					}
					var buttonPane = $( input ).datepicker( "widget" ).find( ".ui-datepicker-buttonpane" );
					$( "<button>", {text: DATEPICKER_CLEAR, click: function() {
							$.datepicker._clearDate( input );
						}
				  	}).appendTo( buttonPane ).addClass("ui-datepicker-clear ui-state-default ui-priority-secondary ui-corner-all ui-datepicker-delete");
				}, 1 );
			},
			onChangeMonthYear: function( year, month, input, inst ) {
				setTimeout(function() {
					var d = new Date();
					var m = d.getMonth()+1;
					var y = d.getFullYear();
					if(m == month && y == year ) {
						$('button.ui-datepicker-current').addClass('disabled');
					}
					var buttonPane = $( input ).datepicker( "widget" ).find( ".ui-datepicker-buttonpane" );
					$( "<button>", {text: DATEPICKER_CLEAR, click: function() {
							$.datepicker._clearDate( input );
						}
				  	}).appendTo( buttonPane ).addClass("ui-datepicker-clear ui-state-default ui-priority-secondary ui-corner-all ui-datepicker-delete");
				}, 1 );
			},
			onClose: function(dateText, inst) {
				var action;
				var chpexists = chpexistsSpan.html();
				var obj = getCurrentModule();
				if(chpexists == 0 && dateText == "") {
					return true;
				}
				if (chpexists == 0 && dateText != "") {
					action  = 'new';
					chpexistsSpan.html('1');
					$('#'+obj.name+'Checkpoint').slideDown();
				} else if (chpexists == 1 && dateText == "") {
					action  = 'delete';
					chpexistsSpan.html('0');
					$('#'+obj.name+'Checkpoint').slideUp(function() {
						$(this).find('textarea').val('');
						});
				} else {
					action  = 'update';
				}
				obj.manageCheckpoint(action,dateText);
	   		}
 		});
	});
	
	
	// init datepickers dialog_button.png
	$('.datepickerDelete').livequery(function() { 
		$(this).datepicker({ dateFormat: 'dd.mm.yy', showOn: 'button', buttonText:"", buttonImage: co_files+'/img/pixel.gif',  buttonImageOnly: true, showButtonPanel: true, changeMonth: true, changeYear: true, yearRange: 'c-5:c+5', showAnim: 'slide',
			beforeShow: function(input,inst) {
				if(input.name == 'enddate') {
					$(this).datepicker('option', 'minDate', new Date(Date.parse($("input[name='startdate']").val())));
				}
				if(input.name.match(/task_startdate/)) {
					$(this).datepicker('option', 'minDate', new Date(Date.parse($("input[name='kickoff']").val())));
				}
				if(input.name.match(/task_enddate/)) {
					var reg = /[0-9]+/.exec(input.name);
					$(this).datepicker('option', 'minDate', new Date(Date.parse($("input[name='task_startdate["+reg+"]']").val())));
				}
				setTimeout(function() {
					var d = new Date();
					var m = d.getMonth()+1;
					var y = d.getFullYear();
					var is = new Date(Date.parse(input.value));
					var month = is.getMonth()+1;
					var year = is.getFullYear();
					if(m == month && y == year ) {
						$('button.ui-datepicker-current').addClass('disabled');
					}
					var buttonPane = $( input ).datepicker( "widget" ).find( ".ui-datepicker-buttonpane" );
					$( "<button>", {text: DATEPICKER_CLEAR, click: function() {
							$.datepicker._clearDate( input );
						}
				  	}).appendTo( buttonPane ).addClass("ui-datepicker-clear ui-state-default ui-priority-secondary ui-corner-all ui-datepicker-delete");
				}, 1 );
			},
			onChangeMonthYear: function(year,month, inst ) {
				setTimeout(function() {
					var d = new Date();
					var m = d.getMonth()+1;
					var y = d.getFullYear();
					if(m == month && y == year ) {
						$('button.ui-datepicker-current').addClass('disabled');
					}
					var buttonPane = $( input ).datepicker( "widget" ).find( ".ui-datepicker-buttonpane" );
					$( "<button>", {text: DATEPICKER_CLEAR, click: function() {
							$.datepicker._clearDate( input );
						}
				  	}).appendTo( buttonPane ).addClass("ui-datepicker-clear ui-state-default ui-priority-secondary ui-corner-all ui-datepicker-delete");
				}, 1 );
			},
			onClose: function(dateText, inst) {
				var app = getCurrentApp();
				var object = window[app];
				object.datepickerOnClose(this);
				//setTimeout(function() { inst.input.click(); }, 5000);
	   		}
 		});
	});
	
	
	// meetings sortable topics
	$('div.outerSortable').livequery( function() {
		$(this).sortable({
			items: '>div',
			handle: '.task-drag',
			axis: 'y',
			tolerance: 'pointer',
			containment: $(this),
			update: function(event,ui) {
				var order = $(this).sortable("serialize");
				var obj = getCurrentModule();
				obj.actionSortItems(order);
			}
		})
	});
	
	// vDocs Init function
	function vdocsCallback(ed) {
		setTimeout(function() {
			$('#'+getCurrentApp()+'vdocContent').tinymce().execCommand('mceAutoResize');			
		}, 300)
	}
	
	function vdocsOnInit(ed) {
		setTitleFocus();
	}
	
	function vdocsSetup(ed) {
		var timer;
		var d = 500;
		ed.onKeyUp.add(function(ed, e) {
			if(timer) { clearTimeout(timer); }
			timer = setTimeout(keyupSave, d);
		})
		ed.onChange.add(function(ed, l) {
			if(timer) { clearTimeout(timer); }
			timer = setTimeout(keyupSave, d);
		});
		ed.onPaste.add(function(ed, l) {
			if(timer) { clearTimeout(timer); }
			timer = setTimeout(keyupSave, d);
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
				if(e.preventDefault) { e.preventDefault(); }
				return false;
			}
		});
	}

	// listener for vDocs
	$("textarea.initVdocs").livequery(function() {	 
		var vdoc = $(this);
		$.getScript("tiny_mce/jquery.tinymce.js", function(){
			vdoc.tinymce({
			script_url : 'tiny_mce/tiny_mce_gzip.php',
			doctype: '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">',
			theme : "advanced",
			skin : "coVDocs",
			language: co_lang,
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
			oninit : vdocsOnInit,
			init_instance_callback: vdocsCallback,
			setup :  vdocsSetup
			});
		})
	})

});
		
		
var formChanged = false;
var checkpointChanged = false;


function keyupSave() {
	formChanged = false;
	var obj = getCurrentModule();
	$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);					   
}

function keyupSaveCheckpoint() {
	var obj = getCurrentModule();
	obj.saveCheckpointText();
} 
			
$(document).ready(function() {
	
	$(document).on('click', 'div.appSettings',function(e) {
		e.preventDefault();
		var app = getCurrentApp();
		$('#'+app+' .appSettingsPopup .content').html($(this).next().html());
		$('#'+app+' .appSettingsPopup').slideDown();
	})
	
	// costs checkbox
	$(document).on('click', 'span.toggleCosts', function(e) {
		e.preventDefault();
		var ele = $(this);
		var status = ele.attr('rel');
		var obj = getCurrentModule();
		obj.toggleCosts(ele,status);
	});
	
	$(document).on('click', 'span.toggleCurrency', function(e) {
		e.preventDefault();
		var ele = $(this);
		var cur = ele.attr('rel');
		var obj = getCurrentModule();
		obj.toggleCurrency(ele,cur);
	});
	
	$('input.currency').livequery( function() {
		$(this).number( true, 0, '', '.' );
	})
	$('span.totalcosts, #procGridCosts, #procPspgridCosts, span.itemcosts').livequery( function() {
		$(this).number( true, 0, '', '.' );
	})
	
	$('.textarea-title, .bg, .elastic').livequery(function () {
		$(this).bind('keyup paste cut', $.debounce( 500, keyupSave));
   });
	
	$('textarea.elastic-two').livequery(function () {
		$(this).bind('keyup paste cut', $.debounce( 500, keyupSaveCheckpoint));
	});
	
	$('#co-popup input, #co-popup textarea, #modalDialog input').livequery(function () {
		$(this).bind('keyup paste cut', $.debounce( 500, function() {
			var obj = getCurrentModule();
			obj.saveItem();
		}
		));
   });
	
	$('input.globalSearch').livequery(function() {
		var app = $(this).attr('rel');
		$(this).autocomplete({
			appendTo: '#'+app,
			position: {my: "right top", at: "right bottom", collision: "none"},
			source: '?path=apps/' + app + '&request=getGlobalSearch',
			//minLength: 2,
			select: function(event, ui) {
				if(app == 'contacts') {
					globalSearchAction(ui.item.id);
				} else {
					var obj = getCurrentModule();
					var cid = $('#'+app+' input[name="id"]').val()
					obj.checkIn(cid);
					var href = ui.item.id.split(",");
					externalLoadThreeLevels(href[0],href[1],href[2],href[3],href[4]);
				}
			},
			close: function(event, ui) {
				$(this).val("");
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

function confirmCheckpoint() {
     if (checkpointChanged) {
		  return true;
     } else {
          return false;
     }
}


// Three Levels of Nav
function loadModuleStartnavThree(objectname) {
	var object = window[objectname];
	var objectFirst = objectname.substr(0, 1);
	var objectnameCaps = objectFirst.toUpperCase() + objectname.substr(1);
	var num_modules = window[objectname+'_num_modules'];
	
	var h = object.$layoutWest.height();
	$('#'+objectname+' div.radius-helper').height(h);
	$('#'+objectname+' .secondLevelOuter').css('top',h-27);
	$('#'+objectname+' .thirdLevelOuter').css('top',150);
	object.$first.data('status','open');
	object.$second.data('status','closed');
	object.$third.data('status','closed');
	object.$first.height(h-98);
	$('#'+objectname+'1 .module-inner').height(h-98);
	$('#'+objectname+'1 .module-actions').show();
	$('#'+objectname+'2 .module-actions').hide();
	$('#'+objectname+'2 li').show();
	object.$second.height(h-125-num_modules*27).removeClass("module-active");
	$('#'+objectname+'2 .module-inner').height(h-125-num_modules*27);
	$('#'+objectname+'3 .module-actions').hide();
	object.$third.height(h-150);
	$('#'+objectname+'3 .'+objectname+'3-content').height(h-(object.modules_height+152));
	object.$thirdDiv.height(h-(object.modules_height+150-27));
	$('#'+objectname+'-current').val("folder");
	object.$thirdDiv.each(function(i) { 
		var position = $(this).position();
		var t = position.top+h-150;
		$(this).animate({top: t})
	})
	$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/"+objectname+"&request=getFolderList", success: function(data){
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
		$('#'+objectname+'1 li').show();
		$('#'+objectname+'1 .sort').attr("rel", data.sort).addClass("sort"+data.sort);
		var id = $('#'+objectname+'1 .module-click:eq(0)').attr("rel");
		if(id === undefined) {
			id = 0;
		}
		object.$app.data({ "current" : "folders" , "first" : id , "second" : 0 , "third" : 0});
		$('#'+objectname+'1 .module-click:eq(0)').addClass('active-link');
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/"+objectname+"&request=getFolderDetails&id="+id, success: function(text){
			object.$appContent.html(text.html);
				window['init'+objectnameCaps+'ContentScrollbar']();
			}
		});
	}
	});
}


function resetModuleHeightsnavThree(objectname) {
	var object = window[objectname];
	var objectFirst = objectname.substr(0, 1);
	var objectnameCaps = objectFirst.toUpperCase() + objectname.substr(1);
	var num_modules = window[objectname+'_num_modules'];	
	
	var t = 2*$('#container-inner').height();
	var app = getCurrentApp();
	
	if(app != objectname) {
		object.$app.css('top',t);
	}
	// fix for now - move desktop if not active
	if(app != 'desktop' && $('#desktop').css('top') != t) {
		$('#desktop').css('top',t);
	}
	var h = object.$layoutWest.height();
	$('#'+objectname+' div.radius-helper').height(h);
	object.$first.height(h-98);
	$('#'+objectname+'1 .module-inner').height(h-98);
	object.$second.height(h-125-num_modules*27);
	$('#'+objectname+'2 .module-inner').height(h-125-num_modules*27);
	object.$third.height(h-150);
	$('#'+objectname+'3 .'+objectname+'3-content').height(h-(object.modules_height+152));
	object.$thirdDiv.height(h-(object.modules_height+150-27));
	if(object.$first.data('status') == 'open') {
		$('#'+objectname+'2-outer').css('top',h-27);
		object.$thirdDiv.each(function(i) { 
			var t = h-150+i*27;
			$(this).animate({top: t})
		})
	}
	if(object.$second.data('status') == 'open') {	
		var curmods = $('#'+objectname+'3 div.thirdLevel:not(.deactivated)').size();
		object.$second.height(h-125-curmods*27).removeClass("module-active");
		$('#'+objectname+'2 .module-inner').height(h-125-curmods*27);
		$('#'+objectname+'3 .'+objectname+'3-content').height(h-(curmods*27+152));
		object.$thirdDiv.height(h-(curmods*27+150-27));
		$('#'+objectname+'3 div.thirdLevel:not(.deactivated)').each(function(i) { 
			var t = h-150-curmods*27+i*27;
			$(this).animate({top: t})
		})
	}
	if(object.$third.data('status') == 'open') {
		var obj = objectname + "_" + $("#"+objectname+"-current").val();
		var idx = $('#'+objectname+'3 .thirdLevel:not(.deactivated)').index($('#'+objectname+'3 .thirdLevel:not(.deactivated)[id='+obj+']'));	
		var curmods = $('#'+objectname+'3 div.thirdLevel:not(.deactivated)').size();
		object.$second.height(h-125-curmods*27).removeClass("module-active");
		$('#'+objectname+'2 .module-inner').height(h-125-curmods*27);
		$('#'+objectname+'3 .'+objectname+'3-content').height(h-(curmods*27+152));
		object.$thirdDiv.height(h-(curmods*27+150-27));
		$('#'+objectname+'3 div.thirdLevel:not(.deactivated)').each(function(i) { 
		if(i > idx) {
			var pos = $(this).position();
				var t = h-150-curmods*27+i*27;
				$(this).animate({top: t})
			}
		})
	}
}


function modulesDisplay(objectname,access) { // when clicking on level two item
	var object = window[objectname];
	var num_modules = window[objectname+'_num_modules'];

	var h = object.$layoutWest.height();
	if(access == "guest" || access == "guestadmin") {
		var modLen = object.GuestHiddenModules.length;
		var p_num_modules = num_modules-modLen;
		p_modules_height = p_num_modules*module_title_height;
		$('#'+objectname+'3 .'+objectname+'3-content').height(h-(p_modules_height+152));
		object.$thirdDiv.height(h-(p_modules_height+150-27));
		object.$second.height(h-125-p_num_modules*27).removeClass("module-active");
		$('#'+objectname+'2 .module-inner').height(h-125-p_num_modules*27);
		var a = 0;
		
		var t = object.$second.height();
		object.$second.animate({height: t+num_modules*27}, function() {
			$(this).animate({height: t});
		})
		
		object.$thirdDiv.each(function(i) { 
			var rel = $(this).find('h3').attr('rel');
			if(object.GuestHiddenModules.indexOf(rel) >= 0 ) {
				$(this).addClass('deactivated').animate({top: 9999})	
			} else {
				var t = object.$third.height()-p_num_modules*27+a*27;
				var position = $(this).position();
				var d = position.top+num_modules*27;
				$(this).animate({top: d}, function() {
					$(this).animate({top: t})			
				})
				a = a+1;
			}
		})
	} else {
		$('#'+objectname+'3 .'+objectname+'3-content').height(h-(object.modules_height+152));
		object.$thirdDiv.height(h-(object.modules_height+150-27));
		$('#'+objectname+'2 .module-inner').height(h-125-num_modules*27);
		var curmods = $('#'+objectname+'3 div.thirdLevel:not(.deactivated)').size();
		var t = h-125-num_modules*27;
		object.$second.animate({height: t+num_modules*27}, function() {
			$(this).animate({height: t});
		})
		object.$thirdDiv.each(function(i) { 
			$(this).removeClass('deactivated');
			var t = object.$third.height()-num_modules*27+i*27;
				var position = $(this).position();
				var d = h-150+i*27;
				$(this).animate({top: d}, function() {
					$(this).animate({top: t})			
				})
		})
	}
}


function modulesDisplayTwo(objectname,access) { // when opening level Two
	var object = window[objectname];
	var num_modules = window[objectname+'_num_modules'];

	var h = object.$layoutWest.height();
	if(access == "guest" || access == "guestadmin") {
		var modLen = object.GuestHiddenModules.length;
		var p_num_modules = num_modules-modLen;
		var p_modules_height = p_num_modules*module_title_height;
		$('#'+objectname+'3 .'+objectname+'3-content').height(h-(p_modules_height+152));
		object.$thirdDiv.height(h-(p_modules_height+150-27));
		object.$second.height(h-125-p_num_modules*27).removeClass("module-active");
		$('#'+objectname+'2 .module-inner').height(h-125-p_num_modules*27);
		var a = 0;
		var t = object.$second.height();
		object.$second.animate({height: t+p_modules_height})
		$('#'+objectname+'2-outer').animate({top: 96}, function() {
			object.$thirdDiv.each(function(i) { 
				var rel = $(this).find('h3').attr('rel');
				if(object.GuestHiddenModules.indexOf(rel) >= 0 ) {
					$(this).addClass('deactivated').animate({top: 9999})	
				} else {
					var t = object.$third.height()-p_num_modules*27+a*27;
						$(this).animate({top: t})			
					a = a+1;
				}
			})
			$('#'+objectname+'-top .top-headline').html($('#'+objectname+'1 .deactivated').find(".text").html());
			object.$second.animate({height: t})
		})
	} else {
		$('#'+objectname+'3 .'+objectname+'3-content').height(h-(object.modules_height+152));
		object.$thirdDiv.height(h-(object.modules_height+150-27));
		$('#'+objectname+'2 .module-inner').height(h-125-num_modules*27);
		var t = h-125-object.modules_height;
		object.$second.animate({height: t+object.modules_height})
		$('#'+objectname+'2-outer').animate({top: 96}, function() {
			object.$thirdDiv.each(function(i) { 
				var t = object.$third.height()-object.modules_height+i*27;
				$(this).animate({top: t})			
			})
			$('#'+objectname+'-top .top-headline').html($('#'+objectname+'1 .deactivated').find(".text").html());
			object.$second.animate({height: t})
		})
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
	if(confirmCheckpoint()) {
		checkpointChanged = false;
		obj.saveCheckpointText();
	}
	var cid = $('#'+objectname+' input[name="id"]').val()
	if(cid != undefined) {
		obj.checkIn(cid);
	}
	
	object.$first.data('status','open');
	object.$second.data('status','closed');
	object.$third.data('status','closed');
	object.$app.data({ 'second' : 0 });
	object.$app.data({ 'third' : 0 });

	
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
			object.$app.data('first' , id );
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/" + objectname +"&request=getFolderDetails&id="+id, success: function(text){
				object.$appContent.html(text.html);
				window['init'+objectnameCaps+'ContentScrollbar']();
				var h = object.$layoutWest.height();
				object.$first.delay(200).animate({height: h-71}, function() {
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
		var h = object.$layoutWest.height();
		var id = $('#'+objectname+'1 .module-click:visible').attr("rel");
		object.$app.data({'first' : id});
		var index = $('#'+objectname+'1 .module-click').index($('#'+objectname+'1 .module-click[rel='+id+']'));
		object.$third.data('status','closed');
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/" + objectname +"&request=getFolderList", success: function(data){
			$('#'+objectname+'1 ul').html(data.html);
			setModuleActive(object.$first,index);
			$('#'+objectname+'-current').val('folder');
			setModuleDeactive(object.$second,'0');
			setModuleDeactive(object.$third,'0');
			$('#'+objectname+'2-outer').animate({top: h-27});
			$('#'+objectname+'2 li').show();
			object.$second.prev("h3").removeClass("white");
			$('#'+objectname+'3 h3').removeClass("module-bg-active");
			object.$thirdDiv.each(function(i) { 
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
					object.$appContent.html(text.html);
					window['init'+objectnameCaps+'ContentScrollbar']();
					}
				 });
			}, 400)
			}
		});
	}
	object.$app.data({ "current" : "folder" });
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
	
	var obj = getCurrentModule();
	if(confirmNavigation()) {
		formChanged = false;
		$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
	}
	if(confirmCheckpoint()) {
		checkpointChanged = false;
		obj.saveCheckpointText();
	}
	var cid = $('#'+objectname+' input[name="id"]').val()
	if(cid != undefined) {
		obj.checkIn(cid);
	}
	
	object.$third.data('status','closed');
	object.$app.data({ 'third' : 0 });

	if(clicked.hasClass("module-bg-active")) {
		$('#'+objectname+'1-outer > h3').trigger("click");
	} else {
		if(object.$first.data('status') == 'closed') { // resize module
			object.$second.data('status','open');
			var h = object.$layoutWest.height();
			var id = object.$app.data('first');
			if(passed_id === undefined) {
				var objecctid = object.$app.data('second');
			} else {
				var objecctid = passed_id;					
			}
			object.$app.data({ "second" : objecctid});
			var index = $('#'+objectname+'2 .module-click').index($('#'+objectname+'2 .module-click[rel='+objecctid+']'));
			$('#'+objectname+'3 .module-actions').hide();
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/" + objectname +"&request=get"+objectnameCapsSingular+"List&id="+id, success: function(data){
				$('#'+objectname+'2 ul').html(data.html);
				$('#'+objectname+'Actions .actionNew').attr('title',data.title);	
				$('#'+objectname+'2 li').show();
				setModuleActive(object.$second,index);
				$('#'+objectname+'2 .sort').attr('rel', data.sort).addClass('sort'+data.sort);
					//$(this).find('.west-ui-content').height(h-(object.modules_height+125));
					$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/"+objectname+"&request=get"+objectnameCapsSingular+"Details&id="+objecctid, success: function(text){
						object.$appContent.html(text.html);
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
							window['modulesDisplayTwo'](objectname,text.access);
						} else {
							object.$thirdDiv.each(function(i) { 
								var t = object.$third.height()-num_modules*27+i*27;
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
			var id = object.$app.data('first');
			if(id == undefined || id == 0) {
				return false;
			}
			var index = $('#'+objectname+'1 .module-click').index($('#'+objectname+'1 .module-click[rel='+id+']'));
			setModuleDeactive(object.$first,index);
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/"+objectname+"&request=get"+objectnameCapsSingular+"List&id="+id, success: function(data){
				$('#'+objectname+'2 ul').html(data.html);
				$('#'+objectname+'Actions .actionNew').attr('title',data.title);
				if(passed_id === undefined) {
					var objecctid = $('#'+objectname+'2 .module-click:eq(0)').attr('rel');
				} else {
					var objecctid = passed_id;					
				}
				object.$app.data({ "second" : objecctid});
				if(object.$first.data('status') == 'open') { // slide up module
					object.$first.data('status','closed');
					object.$second.data('status','open');
					var idx = $('#'+objectname+'2 .module-click').index($('#'+objectname+'2 .module-click[rel='+objecctid+']'));
					setModuleActive(object.$second,idx);
					$('#'+objectname+'2 .sort').attr('rel', data.sort).addClass('sort'+data.sort);
					var h = object.$layoutWest.height();
					$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/"+objectname+"&request=get"+objectnameCapsSingular+"Details&id="+objecctid, success: function(text){
						object.getNavModulesNumItems(objecctid)
						object.$appContent.html(text.html);
						if(text.access === undefined) {
							window[objectname+'Actions'](3);
						} else {
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
						}
						window['init'+objectnameCaps+'ContentScrollbar']();
						if(text.access != "sysadmin") { 
							window['modulesDisplayTwo'](objectname,text.access);
						} else {
							var t = object.$second.height();
							object.$second.animate({height: t+num_modules*27})
							$('#'+objectname+'2-outer').animate({top: 96}, function() {
								object.$thirdDiv.each(function(i) { 
									var position = $(this).position();
									var t = position.top-num_modules*module_title_height;
									$(this).animate({top: t})
								})					  								  
								$('#'+objectname+'-top .top-headline').html($('#'+objectname+'1 .deactivated').find('.text').html());
								object.$second.animate({height: t})
							})
						}
					}
					});
				}
				}
			});
		}
	}
	object.$app.data({ "current" : objectname});
	$('#'+objectname+'-current').val(objectname);
	$('#'+objectname+'-top .top-subheadline').html("");
	$('#'+objectname+'-top .top-subheadlineTwo').html("");
}


function navThreeTitleThird(objectname, clicked, passed_id) {
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
		if(confirmCheckpoint()) {
			checkpointChanged = false;
			obj.saveCheckpointText();
		}
		var cid = $('#'+objectname+' input[name="id"]').val()
		if(cid != undefined) {
			obj.checkIn(cid);
		}
		
		var moduleidx = $('#'+objectname+'3 h3').index(clicked);
		var module = clicked.attr("rel");
		// module open and  active 
		if(clicked.hasClass("module-bg-active")) {
			$('#'+objectname+'2-outer > h3').trigger("click");
		} else {
			// module 3 allready activated
			if(object.$third.data('status') == 'open') {
				var id = object.$app.data('second');
				var mod = getCurrentModule();
				var todeactivate = mod.name.replace(objectname+'_', "");
				$('#'+objectname+'3 h3[rel='+todeactivate+']').removeClass("module-bg-active");	
				$('#'+objectname+'3 .module-actions:visible').hide();
				var curmoduleidx = $('#'+objectname+'3 h3').index($('#'+objectname+'3 h3[rel='+todeactivate+']'));
				var t = moduleidx*module_title_height;
				clicked.addClass("module-bg-active")
				$('#'+objectname+'3 div.thirdLevel:not(.deactivated)').each(function(i) { 
					if(i <= moduleidx) {
						var mx = i*module_title_height;
						$(this).animate({top: mx})
					} else {
						if(i <= curmoduleidx) {
							var position = $(this).position();
							var h = position.top+$(this).height()-27;
							$(this).animate({top: h})
						} else {
							var position = $(this).position();
							var h = position.top;
							$(this).animate({top: h})
						}
					}
				})
				
				setTimeout(function() {
					$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/"+objectname+"/modules/"+module+"&request=getList&id="+id, success: function(data){
						$('#'+objectname+'3 ul:eq('+moduleidx+')').html(data.html);
						$('#'+objectname+'Actions .actionNew').attr("title",data.title);
						switch (data.perm) {
							case "sysadmin": case "admin" :
								if(data.html == "<li></li>") {
									window[objectname+'Actions'](3);
								} else {
									window[objectname+'Actions'](0);
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
						if(passed_id === undefined) {
							var idx = 0;
						} else {
							var idx = $('#'+objectname+'3 ul:eq('+moduleidx+') .module-click').index($('#'+objectname+'3 ul:eq('+moduleidx+') .module-click[rel='+passed_id+']'));
						}
						$('#'+objectname+'3 ul:eq('+moduleidx+') .module-click:eq('+idx+')').addClass('active-link');
						var obj = getCurrentModule();
						obj.getDetails(moduleidx,idx,data.html);
						$('#'+objectname+'3 .module-actions:eq('+moduleidx+')').show();
						$('#'+objectname+'3 .sort:eq('+moduleidx+')').attr("rel", data.sort).addClass("sort"+data.sort);
						}
					});		
				}, 400);
			} else {
				// load and slide up module 3
				var id = object.$app.data('second');
				if(id == undefined || id == 0) {
					return false;
				}
				object.$second.data('status','closed');
				object.$third.data('status','open');
				var index = $('#'+objectname+'2 .module-click').index($('#'+objectname+'2 .module-click[rel='+id+']'));			
				$('#'+objectname+'3 .module-actions:visible').hide();
				clicked.addClass("module-bg-active");
				setModuleDeactive(object.$second,index);
				object.$thirdDiv.each(function(i) { 
					if(i <= moduleidx) {
						var position = $(this).position();
							var h = i*27;
							$(this).animate({top: h})
						}
					if(i == num_modules-1) {
						setTimeout(function() {
							$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/"+objectname+"/modules/"+module+"&request=getList&id="+id, success: function(data){
								$('#'+objectname+'3 ul:eq('+moduleidx+')').html(data.html);
								$('#'+objectname+'Actions .actionNew').attr("title",data.title);
								switch (data.perm) {
									case "sysadmin": case "admin" :
										if(data.html == "<li></li>") {
											window[objectname+'Actions'](3);
										} else {
											window[objectname+'Actions'](0);
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
								if(passed_id === undefined) {
									var idx = 0;
								} else {
									var idx = $('#'+objectname+'3 ul:eq('+moduleidx+') .module-click').index($('#'+objectname+'3 ul:eq('+moduleidx+') .module-click[rel='+passed_id+']'));
								}
								$('#'+objectname+'3 ul:eq('+moduleidx+') .module-click:eq('+idx+')').addClass('active-link');
								$('#'+objectname+'-top .top-subheadline').html(', ' + $('#'+objectname+'2 .deactivated').find(".text").html());
								if(objectname == 'projects') {
									$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/"+objectname+"&request=getDates&id="+id, success: function(data){
									$('#'+objectname+'-top .top-subheadlineTwo').html(data.startdate + ' - <span id="'+objectname+'enddate">' + data.enddate + '</span>');
									}
								}); }
								var obj = getCurrentModule();
								obj.getDetails(moduleidx,idx,data.html);
								$('#'+objectname+'3 .sort:eq('+moduleidx+')').attr("rel", data.sort).addClass("sort"+data.sort);
								$('#'+objectname+'3 .module-actions:eq('+moduleidx+')').show();
								}
							});
						}, 400);
					}
				})
			}
			$('#'+objectname+'-current').val(module);
			object.$app.data({ "current" : module});
		}
}


function navItemFirst(objectname, clicked) {		
	var object = window[objectname];
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
	if(confirmCheckpoint()) {
		checkpointChanged = false;
		obj.saveCheckpointText();
	}
	var cid = $('#'+objectname+' input[name="id"]').val()
	obj.checkIn(cid);
	
	var id = clicked.attr("rel");
	object.$app.data({ "first" : id});
	var index = $('#'+objectname+' .module-click').index(this);
	$('#'+objectname+' .module-click').removeClass("active-link");
	clicked.addClass("active-link");

	var h = object.$layoutWest.height();
	object.$first.delay(200).animate({height: h-71}, function() {
		$(this).animate({height: h-98});
	});
	$('#'+objectname+'2-outer').delay(200).animate({top: h}, function() {
		$(this).animate({top: h-27});
	});
	$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/"+objectname+"&request=getFolderDetails&id="+id, success: function(text){
		object.$appContent.html(text.html);
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
	var object = window[objectname];
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
	if(confirmCheckpoint()) {
		checkpointChanged = false;
		obj.saveCheckpointText();
	}
	var cid = $('#'+objectname+' input[name="id"]').val()
	obj.checkIn(cid);
	
	var fid = $('#'+objectname+'1 .deactivated').attr("rel");
	var id = clicked.attr("rel");
	object.$app.data({ "second" : id});
	var index = $('#'+objectname+' .module-click').index(this);
	$('#'+objectname+' .module-click').removeClass("active-link");
	clicked.addClass("active-link");
	$('#'+objectname+'-top .top-headline').html($('#'+objectname+'1 .deactivated').find(".text").html());
	$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/"+objectname+"&request=get"+objectnameCapsSingular+"Details&fid="+fid+"&id="+id, success: function(text){
		object.$appContent.html(text.html);		
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
		$('.'+objectname+'3-content ul').html('');
		if(text.access != "sysadmin") { 
			window['modulesDisplay'](objectname,text.access);
			object.getNavModulesNumItems(id)
		} else {
			var t = object.$second.height();
			object.$second.animate({height: t+num_modules*27}, function() {
				object.getNavModulesNumItems(id)
				$(this).animate({height: t})
			})
			object.$thirdDiv.each(function(i) { 
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
	var object = window[objectname];
	
	var obj = getCurrentModule();
	if(confirmNavigation()) {
		formChanged = false;
		$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
	}
	if(confirmCheckpoint()) {
		checkpointChanged = false;
		var obj = getCurrentModule();
		obj.saveCheckpointText();
	}
	var cid = $('#'+objectname+' input[name="id"]').val()
	obj.checkIn(cid);
	
	var id = clicked.attr("rel");
	object.$app.data({ "third" : id});
	var ulidx = $('#'+objectname+'3 ul').index(clicked.parents("ul"));
	var index = $('#'+objectname+'3 ul:eq('+ulidx+') .module-click').index($('#'+objectname+'3 ul:eq('+ulidx+') .module-click[rel='+id+']'));
	$('#'+objectname+'3 .module-click').removeClass("active-link");
	clicked.addClass("active-link");
	var list = 0;
	obj.getDetails(ulidx,index,list);
}



function externalLoadThreeLevels(objectname,f,p,ph,app) { // from Desktop
	var object = window[objectname];
	var objectFirst = objectname.substr(0, 1);
	var objectnameCaps = objectFirst.toUpperCase() + objectname.substr(1);
	var objectnameCapsSingular = objectnameCaps.slice(0,-1);
	var num_modules = window[objectname+'_num_modules'];
	
	if(objectname == app && (objectname == 'projects' || objectname == 'procs' || objectname == 'forums' || objectname == 'complaints' || objectname == 'employees' || objectname == 'patients' || objectname == 'trainings' || objectname == 'clients')) {
		object.$first.data({ "first" : f});
		$('#'+objectname+'1 .module-click').removeClass('deactivated');
		var index = $('#'+objectname+'1 .module-click').index($('#'+objectname+'1 .module-click[rel='+f+']'));
		$.ajax({ type: "GET", url: "/", dataType:  'json', async: false, data: "path=apps/" + objectname +"&request=get"+objectnameCapsSingular+"List&id="+f, success: function(data){
			$('#'+objectname+'2 ul').html(data.html);
			
			setModuleDeactive(object.$first,index);
			object.$first.find('li:eq('+index+')').show();
			//alert($('#'+objectname+'1 .deactivated').find(".text").html());
			$('#'+objectname+'-top .top-headline').html($('#'+objectname+'1 .deactivated').find(".text").html());
			}
		})
		object.$second.data({ "second" : p});
		var index = $('#'+objectname+'2 .module-click').index($('#'+objectname+'2 .module-click[rel='+p+']'));
		setModuleActive(object.$second,index);
		$('#'+objectname+'2-outer').css('top', 96);
		$('#'+objectname+'3 h3').removeClass("module-bg-active");
		$('#'+objectname+'3 .module-actions').hide();
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/" + objectname +"&request=get"+objectnameCapsSingular+"Details&fid="+f+"&id="+p, success: function(text){
			object.getNavModulesNumItems(p)
			$('#'+objectname+'-current').val(objectname);
			object.$app.data({ "current" : objectname});
			object.$app.data({ "second" : p});
			object.$first.data('status','closed');
			object.$second.data('status','open');
			object.$third.data('status','closed');
			object.$appContent.html(text.html);		
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
			var curapp = getCurrentApp();
			if(text.access == "guest" || text.access == "guestadmin") { 
				var h = object.$layoutWest.height();
				var modLen = object.GuestHiddenModules.length;
				var p_num_modules = num_modules-modLen;
				p_modules_height = p_num_modules*module_title_height;
				$('#'+objectname+'3 .'+objectname+'3-content').height(h-(p_modules_height+152));
				object.$thirdDiv.height(h-(p_modules_height+150-27));
				object.$second.height(h-125-p_num_modules*27).removeClass("module-active");
				$('#'+objectname+'2 .module-inner').height(h-125-p_num_modules*27);
				var a = 0;
				object.$thirdDiv.each(function(i) { 
					var rel = $(this).find('h3').attr('rel');
					if(object.GuestHiddenModules.indexOf(rel) >= 0 ) {
						$(this).addClass('deactivated').animate({top: 9999})	
					} else {
						var t = object.$third.height()-p_num_modules*27+a*27;
						$(this).animate({top: t})			
						a = a+1;
					}
				})
				if(objectname != curapp) {
						$('span.app_'+objectname).trigger('click');
					}
				
			} else {
				$('#'+objectname+'3 div.thirdLevel:not(.deactivated)').each(function(i) { 
					//alert(h);
					//var t = h-150-num_modules*27+i*27;
					var t = object.$third.height()-num_modules*27+i*27;
					$(this).animate({top: t})
				})
				if(objectname != curapp) {
						$('span.app_'+objectname).trigger('click');
					}
			}
			}
		});
	}

	//if(objectname == 'phases') {
	if(ph != 0) {
		var appobject = window[app];
		var appFirst = app.substr(0, 1);
		var appnameCaps = appFirst.toUpperCase() + app.substr(1);
		var appnameCapsSingular = appnameCaps.slice(0,-1);
	
		$('#'+app).data({ "first" : f});
		var index = $('#'+app+'1 .module-click').index($('#'+app+'1 .module-click[rel='+f+']'));
		$.ajax({ type: "GET", url: "/", dataType:  'json', async: false, data: "path=apps/"+app+"&request=get"+appnameCapsSingular+"List&id="+f, success: function(data){
			$('#'+app+'2 ul').html(data.html);
			$('#'+app+'1 .module-click').removeClass('deactivated');
				setModuleDeactive($('#'+app+'1'),index);
				$('#'+app+'1').find('li:eq('+index+')').show();
				$('#'+app+'-top .top-headline').html($('#'+app+'1 .deactivated').find(".text").html());
			}
		})
		$('#'+app).data({ "second" : p});
		appobject.getNavModulesNumItems(p)
		var index = $('#'+app+'2 .module-click').index($('#'+app+'2 .module-click[rel='+p+']'));
		setModuleDeactive($('#'+app+'2'),index);
		$('#'+app+'2-outer').css('top', 96);
		$('#'+app+'3 h3').removeClass("module-bg-active");
		$('#'+app+'3 .module-actions').hide();
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/"+app+"/modules/"+objectname+"&request=getList&id="+p, success: function(data){
			$('#'+app+'-current').val(objectname);
			$('#'+app).data({ "current" : objectname});
			$('#'+app).data({ "third" : ph});
			$('#'+app+'1').data('status','closed');
			$('#'+app+'2').data('status','closed');
			$('#'+app+'3').data('status','open');
			$('#'+app+'3 ul[rel='+objectname+']').html(data.html);
			$('#'+app+'Actions .actionNew').attr("title",data.title);
			switch (data.perm) {
				case "sysadmin": case "admin" :
					if(data.html == "<li></li>") {
						window[app+'Actions'](3);
					} else {
						window[app+'Actions'](0);
					}
				break;
				case "guest":
					if(data.html == "<li></li>") {
						window[app+'Actions']();
					} else {
						window[app+'Actions'](5);
					}
				break;
			}
			var moduleidx = $('#'+app+'3 h3').index($('#'+app+'3 h3[rel='+objectname+']'));
			var z = appobject.$thirdDiv.height()-27;
			$('#'+app+'3 div.thirdLevel:not(.deactivated)').each(function(i) { 
				if(i <= moduleidx) {
					var mx = i*module_title_height;
					$(this).animate({top: mx})
				} else {
					var mx = z+i*module_title_height;
					$(this).animate({top: mx})
				}
			})
			$('#'+app+'3 ul[rel='+objectname+'] .module-click[rel='+ph+']').addClass('active-link');
			var idx = $('#'+app+'3 ul[rel='+objectname+'] .module-click').index($('#'+app+'3 ul[rel='+objectname+'] .module-click[rel='+ph+']'));
			var o = window[app+'_'+objectname];
			o.getDetails(moduleidx,idx,data.html);
			//$('#'+app+'3 .module-actions:eq(0)').show();
			$('#'+app+'3 .module-actions:eq('+moduleidx+')').show();
			$('#'+app+'3 .sort:eq('+moduleidx+')').attr("rel", data.sort).addClass("sort"+data.sort);
			$('#'+app+'-top .top-subheadline').html(', ' + $('#'+app+'2 .module-click:visible').find(".text").html());
			var curapp = getCurrentApp();
			if(app == 'projects') {
				$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/"+app+"&request=getDates&id="+p, success: function(data){
					$('#'+app+'-top .top-subheadlineTwo').html(data.startdate + ' - <span id="'+ app +'enddate">' + data.enddate + '</span>');
					if(app != curapp) {
						$('span.app_'+app).trigger('click');
					}
					}
				});
			} else {
				if(app != curapp) {
						$('span.app_'+app).trigger('click');
					}
			}
			}
		});
	}

}