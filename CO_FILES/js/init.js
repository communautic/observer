var module_title_height = 25;
$(window).bind('beforeunload', function() { 
	if(formChanged) {
		return '' ; 
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

function Module (name) {
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

function initContentScrollbar() {
	projectsInnerLayout.initContent('center');
	initScrollbar( '#projects-right .scrolling-content' );
	initScrollbar( '#projects-right .scroll-pane' );
}


function getCurrentApp() {
	var app = $(".active-app").attr("rel");
	return app;
}

function getCurrentModule() {
	var app = getCurrentApp();
	var cur = $("#"+app+"-current").val();
	var obj = window[cur];
	return obj;
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


function processCustomText(list) {
	var text = $("#"+list+" .ct-content").html();
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

// Apps zindex settings
var z = num_apps; //for setting the initial z-index's
var inAnimation = false; //flag for testing if we are in a animation


$(document).ready(function() { 
						   
	
	$('.elastic').livequery(function() {
		$(this).elastic();
	});
	/*$('.scroll-pane').livequery(function() {
		//$(this).jScrollPane();
		var ele = $(this);
		initScrollbar(ele);
	});*/
	

	
	$("#intro").show().delay(2000).fadeOut("slow");

	$('.app').each(function() { //set the initial z-index's
		 //at the end we have the highest z-index value stored in the z variable
		$(this).css('z-index', z); //apply increased z-index to <img>
		z--;
	});
	
	$('.toggleObservers').click( function() {
		var clickobj = $(this);
		var app = $(this).attr("rel");
		var zidx = $("#" + app).css('z-index');
		if(zidx == num_apps) {
			return false;
		}
		if(zidx != num_apps-1) {
			$('.app').each(function() {
				if($(this).css("z-index") == num_apps-1)		 {
					$(this).css("z-index",zidx)
				}
			});
			$("#" + app).css('z-index', parseInt(num_apps-1));
		}
	
		if(inAnimation) return false; //if already swapping pictures just return
		else inAnimation = true; //set the flag that we process a image
		var processZindex = num_apps; 
		var direction = '-'; 
		var newZindex = 1; 
		var inDeCrease = 1; 
		$('.toggleObservers').removeClass("active-app");
		clickobj.addClass("active-app");
		$('.app').each(function() { //process each image
			if($(this).css('z-index') == processZindex) {
				$(this).animate({ 'top' : direction + $(this).height() + 'px' },'slow', function() { 																				
					$(this).css('z-index', newZindex)
					.animate({ 'top' : '0' },'fast', function() {
						inAnimation = false;
					});
        		});
      		} else {
				$(this).animate({ 'top' : '0' },'slow', function() {
					$(this).css('z-index', parseInt($(this).css('z-index')) + inDeCrease)  
        		});
      		}
    	});
		return false;
	});
	
	
	$('.coform').livequery(function() {
		var obj = getCurrentModule();
		$(this).ajaxForm(obj.poformOptions);
		return false;
	});
	
	$('span.actionNew').click(function() {
		if($(this).hasClass("noactive")) {
			return false;
		}
		var obj = getCurrentModule();
		obj.actionNew();
		return false;
	});	
	
	
	/*$('span.actionSave').click(function(){
		if($(this).hasClass("noactive")) {
			return false;
		}
		var obj = getCurrentModule();
		$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		return false;
	});*/
	
	// title autosave
	$("input.bg, input.title, textarea.elastic").live('blur', function() { 
		if(confirmNavigation()) {
			formChanged = false;
			var obj = getCurrentModule();
			$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		}
	});
	
	$('span.actionPrint').click(function(){
		if($(this).hasClass("noactive")) {
			return false;
		}
		var obj = getCurrentModule();
		obj.actionPrint();
		return false;
	});
	
	$('span.actionSend').click(function(e){
		if($(this).hasClass("noactive")) {
			return false;
		}
		var obj = getCurrentModule();
		obj.actionSend();
		e.preventDefault();
	});
	
	$('span.actionSendVcard').click(function(e){
		if($(this).hasClass("noactive")) {
			return false;
		}
		var obj = getCurrentModule();
		obj.actionSendVcard();
		e.preventDefault();
	});
	
	$('span.actionDuplicate').click(function(){
		if($(this).hasClass("noactive")) {
			return false;
		}
		var obj = getCurrentModule();
		obj.actionDuplicate();
		return false;
	});


	$('span.actionBin').click(function(){
		if($(this).hasClass("noactive")) {
			return false;
		}
		var obj = getCurrentModule();
		obj.actionBin();
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
		/*$('div[id$="_external"]').each(function() {
			var id = $(this).attr('id');
			var ele = id.replace(/_external/g, "");
			if($('#'+ele+'_external').is(":visible")) {
				if(clicked.is('#'+ele+'_parent') || clicked.parents().is('#'+ele+'_parent')) { 
				} else {
					$('#'+ele+'_external').fadeOut( function() {									   
						$('#'+ele).parent().animate({ marginBottom: "0px" }, 200 );
						
						if(confirmNavigation()) {
							formChanged = false;
							var obj = getCurrentModule();
							$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
						}
						$(this).unbind();
					});	
				}
			}
		}) */
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

	

	
	//content links to text fields
	/*$('a.activateTextarea').live('click',function() {
		$(this).parent().next().find("input").removeClass("textarea-title-new").focus();
		return false;
	});*/
	
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
		$(this).parent().next().find('textarea').focus();
		return false;
	});
	
	
	/*$('a.focusText').live('click',function() {
		$(this).parent().next().find("input").focus();
		$(this).parent().next().find("textarea").focus();
		return false;
	});*/


	$("#modalDialog").dialog({  
		autoOpen: false,
		resizable: false,
		draggable: false,
		width: 180,  
		//height: 170,
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
				// move entire project
				if(this.name == 'startdate' && $("#durationEnd").html() != "" && this.value != $("input[name='moveproject_start']").val()) {
					//var moveproject_start = $("input[name='moveproject_start']").val();
					var txt = ALERT_PROJECT_MOVE_ALL;
					$.prompt(txt,{ 
						buttons:{Ja:true, Nein:false},
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
					$.prompt(txt,{ 
						buttons:{Ja:true, Nein:false},
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
				else {
				var obj = getCurrentModule();
				$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
				}
	   		}
 		});
	}); 
	
	
	// bind tinymce editors
	//$("textarea.tinymce").livequery(function() {
	// Well, try this on for size!
	/*$(".protocol-outer").livequery(function() {
		$(this).resize(function(e){
			initScrollbar( '.center-center .scrolling-content' );
			//$(".center-center .scroll-pane").jScrollPane();
		});
	});*/


	/*$('.protocolToggle').live('click',function() {
		var ele = 'protocol';
		if($('#' + ele + '_external').is(":visible")) {
			$('#'+ele+'_external').fadeOut( function() {									   
				$('#'+ele).parent().animate({ marginBottom: "0px" }, 200 );
					if(confirmNavigation()) {
						formChanged = false;
						//$(".tinymce").html($('protocol').html());
						tinyMCE.triggerSave();
						var obj = getCurrentModule();
						$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
					}
				});	
			} else {
				if ($("#"+ele).is(':visible')) $("#"+ele).tinymce().show();
				tinyMCE.execCommand('mceFocus',false,ele);
			}
			
		return false;
	});*/


	/*function myCustomInitInstance(ed) {
		var ele = ed.id;
		//$("#"+ele+"_tbl").height(0);
		
		$("#"+ele).tinymce().hide();
    	
		$("#"+ele).data('initial_value', $("#"+ele).html());
		ed.onKeyUp.add(function(ed, l) {
			var content = ed.getContent();
			 if (content != $("#"+ele).data('initial_value')) {
			  formChanged = true;
			  $("#"+ele).data('initial_value', content);
		  }
		});
		
		tinymce.dom.Event.add(ed.getWin(), 'focus', function(e) {
			$("#"+ele).parent().animate({ marginBottom: "27px" }, 200, function() {
				$("#"+ele+"_external").fadeIn();	
				
			});
    	});
	}*/
	
	
	/*$(".mceIcon").live("click", function(e) {
		var obj = getCurrentModule();
		$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		e.preventDefault();
	})*/


	/*$(".tinymce").livequery(function() {
			$(this).tinymce({
			script_url : 'tiny_mce/tiny_mce_gzip.php',
			doctype: '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">',
			width: "100%",
			theme : "advanced",
			skin : "co",
			skin_variant : "silver",
			language: "de",
			entity_encoding : "raw",
			plugins : "autoresize,safari,save,advlink,iespell,inlinepopups,paste,visualchars,nonbreaking,xhtmlxtras",
			force_br_newlines: false,
			force_p_newlines: true,
			theme_advanced_buttons1 : "undo,redo,bold,italic,underline,strikethrough,sub,sup,|,justifyleft,justifycenter,justifyright,justifyfull,hr,removeformat,|,charmap,|,cut,copy,paste,pastetext,pasteword,cleanup",
			theme_advanced_buttons2 : "",
			theme_advanced_buttons3 : "",
			theme_advanced_buttons4 : "",
			theme_advanced_toolbar_location : "external",
			theme_advanced_statusbar : false,
			content_css : "tiny_mce/editor.content.css",
			theme_advanced_resizing_min_height : 24,
			init_instance_callback: myCustomInitInstance
		});
	})*/


	/*$(".tinymce").live("click",function() {
		var ele = $(this).attr("id");
		$(this).tinymce().show();
		$(this).parent().animate({ marginBottom: "27px" }, 200, function() {
			$("#"+ele+"_external").fadeIn();	
		});
		return false;
	})	*/


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