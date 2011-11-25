//$.extend($.datepicker,{_checkOffset:function(inst,offset,isFixed){ alert(offset); return offset}});
var module_title_height = 25;

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

function initScrollbar ( elem ) {
	//alert(elem)
	$(elem)
		.jScrollPane({
			scrollbarMargin:	10	// spacing between text and scrollbar
		,	scrollbarWidth:		8
		,	arrowSize:			0
		,	showArrows:			false
		})
		.parent().css({
			width:	'100%'
		,	height:	'100%'
	})
	;
};

function initContentScrollbar() {
	projectsInnerLayout.initContent('center');
	initScrollbar( '#projects-right .scrolling-content' );
}


function getCurrentApp() {
	//var app = $(".app:visible").attr("id");
	var app = $(".active-app").attr("href");
	return app;
}

function getCurrentModule() {
	var app = getCurrentApp();
	var cur = $("#"+app+"-current").val();
	var obj = window[cur];
	return obj;
}


function setTitleFocus(v,m,f) {
		var app = getCurrentApp();
		$("#"+app+ " .title").focus();
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

function processCustomText(list) {
	var text = $("#"+list+" .ct-content").html();
	text = text.replace(CUSTOM_NOTE+" ","");	
	return { "name": list, "value": text };
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
	
$(document).ready(function() { 
						   
	var z = num_apps; //for setting the initial z-index's
	var inAnimation = false; //flag for testing if we are in a animation

	$('.app').each(function() { //set the initial z-index's
		 //at the end we have the highest z-index value stored in the z variable
		$(this).css('z-index', z); //apply increased z-index to <img>
		z--;
	});


	$('a.toggleObservsers').click( function() {
		var clickobj = $(this);
		var app = $(this).attr("href");
		var zidx = $("#" + app).css('z-index');
		if(zidx == num_apps) {
			return false;
		}
		if(zidx != num_apps-1) {
			$('.app').each(function() {
				if($(this).css("z-index") == 2)		 {
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
		$('a.toggleObservsers').removeClass("active-app");
		clickobj.addClass("active-app");
		$('.app').each(function() { //process each image
			if($(this).css('z-index') == processZindex) {
				$(this).animate({ 
						'top' : '25%',
						'height' : '50%',
						//'width' : 	'40%',
						'left'  : '-60%'
					},'slow', function() { 																				
          				$(this).css('z-index', newZindex)
								.animate({ 
										'top' : '50%' ,
										'height' : '25%',
										'width' : 	'50%',
										'left'  : '50%'
									},'slow', function() {
              						$(this).animate({ 
										'top' : '0' ,
										'height' : '100%',
										'width' : 	'100%',
										'left'  : '0'
									},'slow', function() {
              						inAnimation = false;
            					});
            					});
        		});
      		} else {
				var newheight = parseInt($(this).height()/2);
				var newtop = parseInt(($(this).height() - newheight) / 2);
				//var newwidth = parseInt($(this).width()/2);
				$(this).animate({ 
						'top' : newtop + 'px',
						'left' : '60%',
						'height' : newheight + 'px',
						'width' :  '40%'
					},'slow', function() {
          				$(this).css('z-index', parseInt($(this).css('z-index')) + inDeCrease)
							  .animate({ 'top' : '0' ,
										 'height' : '100%',
									'width' : 	'100%',
									'left'  : '0'
					 
					 			},'slow');
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
	
	$('a.actionNew').click(function() {
		if($(this).hasClass("noactive")) {
			return false;
		}
		var obj = getCurrentModule();
		obj.actionNew();
		return false;
	});	
	
	
	$('a.actionSave').click(function(){
		if($(this).hasClass("noactive")) {
			return false;
		}
		var obj = getCurrentModule();
		$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		return false;
	});
	
	$('a.actionPrint').click(function(){
		if($(this).hasClass("noactive")) {
			return false;
		}
		//$("#"+projects.name+"-right").jqprint({ printContainer: false });
		//$.ajax({ type: "GET", url: "http://po61.communautic.com/dompdf/cert.php",cache: false });
		//var url = 'http://po61.communautic.com/dompdf/cert.php';
		//var url ='http://po61.communautic.com/apps/projects/?request=printProjectDetails&id=28';
		//location.href = url;
		var obj = getCurrentModule();
		obj.actionPrint();
		return false;
	});
	
	$('a.actionSend').click(function(){
		if($(this).hasClass("noactive")) {
			return false;
		}
		$("#modalDialogForward").dialog('open');
		return false;
	});
	
	$('a.actionDuplicate').click(function(){
		if($(this).hasClass("noactive")) {
			return false;
		}
		var obj = getCurrentModule();
		obj.actionDuplicate();
		return false;
	});
	
	$('a.actionBin').click(function(){
		if($(this).hasClass("noactive")) {
			return false;
		}
		var obj = getCurrentModule();
		obj.actionBin();
		return false;
	});
	
	
	$("a.sort").click(function() {
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
		cursor: 'crosshair',
		//placeholder: 'ui-state-highlight',
		update : function () {
			var order = $(this).sortable('serialize');
			var module = getCurrentModule();
			module.sortdrag(order);
	  	}
	});
	

	/*$(".module-item-status").live('click',function() {
		var obj = $(this);
		var module = getCurrentModule();
		var id = $(this).next().attr("rel");
		if($(this).hasClass("module-item-active")) {
			var status = 0;
		} else {
			var status = 1;
		}
		//alert(id);
		module.toggleIntern(id,status,obj);
		return false;
	});
	
	$(".module-item-status").live('mouseover mouseout', function(event) {
	  if (event.type == 'mouseover') {
		$(this).next().addClass("hover-bg");
		
	  } else {
		$(this).next().removeClass("hover-bg");
	  }
	});*/
	
	/*$(".module-access-status").live('mouseover mouseout', function(event) {
	  if (event.type == 'mouseover') {
		$(this).next().addClass("hover-bg");
		
	  } else {
		$(this).next().removeClass("hover-bg");
	  }
	});*/
	
		
		// disable right click
		/*$(document).bind("contextmenu",function(e){
			return false;
		});*/
		

		
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
		
		if($('#protocol_external').is(":visible")) {
			if(clicked.is('#protocol_parent') || clicked.parents().is('#protocol_parent')) { 
			} else {
				$("#protocol_external").fadeOut( function() {									   
					$(".protocol-outer:visible").animate({ marginBottom: "0px" }, 200 );  
				});	
			}
		}
		
		
	});
	
	/*$("a,#projects1 a.module-click").live("click", function(e) {

		var clicked=$(e.target);
		if(clicked.is('.center-center') || clicked.parents().is('.center-center')) { 
			alert("clicked within edit area");
		} else {
			alert("outside edit area");
			e.stopImmediatePropagation();
		}
		return false;
	})*/

	
	// init custom form elements
	$('form.jNice').livequery(function() { 
		$(this).jNice();
	});
	
	// Radio fields with date fields next
	$(".jNiceRadio").livequery('click',function() {
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
	$('a.focusTitle').live('click',function() {
		var app = getCurrentApp();
		//$(".title:visible").focus();
		$("#"+app+ " .title").focus();
		return false;
	});
	
	$('a.focusText').live('click',function() {
		$(this).parent().next().find("input").focus();
		$(this).parent().next().find("textarea").focus();
		return false;
	});
	
	
	// init modalDialogs
	$("#modalDialog").dialog({  
		autoOpen: false,
		resizable: false,
		draggable: false,
		width: 180,  
		//height: 170,
		minHeight: 100,
		show: 'slide',
		hide: 'slide'
	})
	
	//bind all modal Dialogs
	$('a.showDialog').live('click',function() {
		$("#modalDialog").html("");
		//closedialog = 0;
		var offset = $(this).offset();
		offset = [offset.left+150,offset.top+18];
		var sql;
		// get field and mode
		var request = $(this).attr("request"); // function name
		var field = $(this).attr("field"); // field to fill selection into
		var append = $(this).attr("append"); // add to existing or single selection
		var title = $(this).attr("title"); //header of dialog
		sql = $(this).attr("sql"); // special sql if present
		var module = getCurrentModule();
		module.actionDialog(offset,request,field,append,title,sql);
		return false;
	});
	
		// init modalDialogs
	$("#modalDialogForward").dialog({  
		autoOpen: false,
		resizable: true,
		width: 400,  
		height: 300,
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

	$('a.showDialogTime').livequery('click',function() {
		var offset = $(this).offset();
		var field = $(this).attr("rel");
		var title = $(this).attr("title"); //header of dialog
		var time = $("#"+field).html();
		$.ajax({ type: "GET", url: "view/dialog_time.php", data: "field="+field+"&time="+time, success: function(html){
		  $("#modalDialogTime").html(html);
			}
		});
		$("#modalDialogTime").dialog('option', 'position', [offset.left+150,offset.top+18]);
		$("#modalDialogTime").dialog('option', 'title', title);
		$("#modalDialogTime").dialog('open');
		return false;
	});
	  
	$(".coTime-hr-btn").live("click", function() {
			var obj = $(this).attr("title");
			var val = $(this).html();
			var curval = $("#"+obj).html();
			var valnew = curval.replace(/^[0-9]{2}/,val);
			$("#"+obj).html(valnew);
			return false;
	});
	
	$(".coTime-min-ten-btn").live("click", function() {
			var obj = $(this).attr("title");
			var val = $(this).html();
			var curval = $("#"+obj).html();
			var valnew = curval.replace(/:[0-9]{1}/,":"+val);
			$("#"+obj).html(valnew);
			return false;
	});
	
	$(".coTime-min-one-btn").live("click", function() {
			var obj = $(this).attr("title");
			var val = $(this).html();
			var curval = $("#"+obj).html();
			var valnew = curval.replace(/[0-9]{1}$/,val);
			$("#"+obj).html(valnew);
			return false;
	});




$("#tabs").livequery(function() { 
	$(this).tabs({
		//select: function(){closedialog = 1;}
	});
});

// custom link to init datepicker
/*$('a.ui-datepicker-trigger-action, a.ui-datepicker-trigger-action-status, a.ui-datepicker-trigger-action-task ').livequery('click',function() { 
	$(this).prev().trigger('click');
	return false;
});*/

$('a.ui-datepicker-trigger-action').livequery('click',function() { 
	//$(this).prev().trigger('click');
	$(this).parent().next().find('img').trigger('click');
	return false;
});






	// init datepickers dialog_button.png
	$('.datepicker').livequery(function() { 
		$(this).datepicker({ dateFormat: 'dd.mm.yy', showOn: 'button', buttonText:"", buttonImage: '/img/pixel.gif',  buttonImageOnly: true, showButtonPanel: true, changeMonth: true, changeYear: true, showAnim: 'slide',
		beforeShow: function(input,inst) {
			/*var offset = $("#"+input.name + "_alt").offset();
			//offset = [offset.left+26,offset.top+14];
			
			inst.dpDiv.css("left",offset.left+'px').css("top",offset.top+'px');*/
			if(input.name == 'enddate') {
				$(this).datepicker('option', 'minDate', new Date(Date.parse($("input[name='startdate']").val())));
			}
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
				if(this.name == 'startdate' && $("input[name='moveproject_start']").length > 0 && this.value != $("input[name='moveproject_start']").val()) {
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
								switch($("#pocurrent").val()) {
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
								}
									
							} else {

							}	
						}
					});
				}
				if(this.name == 'enddate' && $("input[name='moveproject_end']").length > 0 && this.value != $("input[name='moveproject_end']").val()) {
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
				
	   		}
 		});
	}); 
		
	
	
	
	

   function myInitInstance(inst) {
   
          tinymce.dom.Event.add(inst.getWin(), 'resize', function(e) {
   
             // Do your thing here :-)
		  alert("hoho");
   
          });
   
      }


	
	// bind tinymce editors
	//$("textarea.tinymce").livequery(function() {
	// Well, try this on for size!
	$(".protocol-outer").livequery(function() {
		$(this).resize(function(e){
			initScrollbar( '.center-center .scrolling-content' );
			//$(".center-center .scroll-pane").jScrollPane();
		});
	});
	
	// protocol slide
	$('a.protocolToggle').livequery('click',function() {
		$(this).parent().next().find(".protocol-outer").slideToggle();
		return false;
	});
	
	

	// init on click
	$("a.activateToolbar").livequery("click",function() {
			tinyMCE.execCommand('mceFocus',false,'protocol');
			$(".protocol-outer:visible").animate({ marginBottom: "27px" }, 200, function() {
				$("#protocol_external").fadeIn();																		
			});

			
			
			return false;
	})
	
	$("textarea.tinymce").livequery(function() {
			initTiny($(this));
			return false;
	})
	
	
	function myCustomInitInstance(ed) {
    	//var s = ed.settings;
    	tinymce.dom.Event.add(ed.getWin(), 'focus', function(e) {
        	$(".protocol-outer:visible").animate({ marginBottom: "27px" }, 200, function() {
				$("#protocol_external").fadeIn();																		
			});
    	});
    /*tinymce.dom.Event.add(ed.getWin(), 'blur', function(e) {
        if($(realID)) {
            $(realID).setStyle({width:'190px'});
        }
    });*/
	}
	
	
	function initTiny(ele) {
		ele.tinymce({
			// Location of TinyMCE script
			
			script_url : 'js/tiny_mce/tiny_mce_gzip.php',
			doctype: '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">',
			width: "100%",
			// General options
			theme : "advanced",
			skin : "co",
			skin_variant : "silver",
			language: "de",
			entity_encoding : "raw",
			plugins : "autoresize,safari,save,advlink,iespell,inlinepopups,paste,visualchars,nonbreaking,xhtmlxtras",
			force_br_newlines: false,
			force_p_newlines: true,
			// Theme options
			
			theme_advanced_buttons1 : "undo,redo,bold,italic,underline,strikethrough,sub,sup,|,justifyleft,justifycenter,justifyright,justifyfull,hr,removeformat,|,charmap,|,cut,copy,paste,pastetext,pasteword,cleanup",
			theme_advanced_buttons2 : "",
			theme_advanced_buttons3 : "",
			theme_advanced_buttons4 : "",
			theme_advanced_toolbar_location : "external",
			//theme_advanced_toolbar_location : "bottom",
			//theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar : false,
		//theme_advanced_statusbar_location : "bottom",
			//theme_advanced_resizing : true,

			// Example content CSS (should be your site CSS)
			content_css : "css/editor.content.css",
			init_instance_callback: myCustomInitInstance

		});
	}
	//})

/*$(".scrolling-content").livequery(function() {
$(this).draggable({ axis: "y", scroll: true, scrollSensitivity: 100,
									drag: function() {
				initScrollbar($(this));
			}
});
});*/
	

	// file upload fields
	/*$('input[type=file]').livequery(function(){
		
		$(this).wrap('<div class="fileinputs"></div>');
		$(this).addClass('file').css('opacity', 0); //set to invisible
		$(this).parent().append($('<div class="fakefile" />').append($('<div class="text11" style="padding:0 0 0 15px; width:136px; float: left;">'+FILE_BROWSE+'</div><div  style="float: left;"><a href="#" class="showDialog"title=""></a></div>')).append($('<input type="text" class="input-field" style="float: left" />').attr('id',$(this).attr('id')+'__fake')));
		$(this).bind('change', function() {
			$('#'+$(this).attr('id')+'__fake').val($(this).val());
		});
		$(this).bind('mouseout', function() {
			$('#'+$(this).attr('id')+'__fake').val($(this).val());
		});
	});*/
	
	

	
	
});
		
		