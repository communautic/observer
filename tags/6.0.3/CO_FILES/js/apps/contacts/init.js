/* contacts Object */
var contacts = new Application('contacts');
contacts.path = 'apps/contacts/';
contacts.resetModuleHeights = contactsresetModuleHeights;
contacts.usesLayout = true;
contacts.displayname = "Projekte";
contacts.modules_height = contacts_num_modules*module_title_height;
contacts.sortclick = sortClickContact;
contacts.sortdrag = sortDragContact;
contacts.actionDialog = dialogContact;
contacts.actionNew = newContact;
contacts.actionBin = binContact;
contacts.poformOptions = { beforeSubmit: contactFormProcess, dataType:  'json', success: contactFormResponse };

// register group object
var group = new Module('group');
group.path = 'apps/contacts/';
group.sortclick = sortClickGroup;
group.sortdrag = sortDragGroup;
group.actionDialog = dialogContact;
group.actionNew = newGroup;
group.actionBin = binGroup;
group.poformOptions = { beforeSubmit: groupFormProcess, dataType:  'json', success: groupFormResponse };


function initContactsContentScrollbar() {
	contactsInnerLayout.initContent('center');
}


function contactFormProcess(formData, form, poformOptions) {
	var title = $("#contacts .title").fieldValue();
	if(title == "") {
		$.prompt(ALERT_NO_TITLE, {callback: setTitleFocus});
		return false;
	} else {
		formData[formData.length] = { "name": "lastname", "value": title };
	}
	formData[formData.length] = processString('lang');
	formData[formData.length] = processString('timezone');
}


function groupFormProcess(formData, form, poformOptions) {
	var title = $("#contacts .title").fieldValue();
	if(title == "") {
		$.prompt(ALERT_NO_TITLE, {callback: setTitleFocus});
		return false;
	} else {
		formData[formData.length] = { "name": "title", "value": title };
	}
	formData[formData.length] = processList('members');
}


function contactFormResponse(data) {
	switch(data.action) {
		case "edit":
			var name = $("#contacts .title").val() + ' ' + $("#contacts .title2").val();
			$("#contacts2 a[rel='"+data.id+"'] .text").html(name);
		break;
	}
}


function groupFormResponse(data) {
	switch(data.action) {
		case "edit":
			$("#contacts1 a[rel='"+data.id+"'] .text").html($("#contacts .title").val());
		break;
	}
}


function newContact() {
	var id = $('#'+contacts.name+' .module-click:visible').attr("rel");
	$.ajax({ type: "GET", url: "/", dataType:  'json', data: 'path=apps/contacts&request=newContact&id=' + id, cache: false, success: function(data){
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/contacts&request=getContactList&id="+id, success: function(list){
				$("#contacts2 ul").html(list.html);
				var index = $("#contacts2 .module-click").index($("#contacts2 .module-click[rel='"+data.id+"']"));
				setModuleActive($("#contacts2"),index);
				$.ajax({ type: "GET", url: "/", data: "path=apps/contacts&request=getContactDetails&id="+data.id, success: function(html){
					$("#"+contacts.name+"-right").html(html);
					initContactsContentScrollbar()
					$('#contacts2 input.filter').quicksearch('#contacts2 li');
					}
				});
				contactsActions(0);
				}
			});
		
		
		}
	});	
	
}


function newGroup() {
	$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/contacts&request=newGroup", cache: false, success: function(data){
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/contacts&request=getGroupList", success: function(list){
				$("#contacts1 ul:eq(1)").html(list.html);
				$("#contacts1 li").show();
				$("#contacts1 .module-click").removeClass('active-link');
				var index = $("#contacts1 .module-click").index($("#contacts1 .module-click[rel='"+data.id+"']"));
				setModuleActive($("#contacts1"),index);
				$.ajax({ type: "GET", url: "/", data: "path=apps/contacts&request=getGroupDetails&id="+data.id, success: function(html){
					$("#"+contacts.name+"-right").html(html);
					initContactsContentScrollbar()
					$('#contacts1 input.filter').quicksearch('#contacts1 li');
					}
				});
				contactsActions(1);
				}
			});
		}
	});
}


function binContact() {
	var txt = ALERT_DELETE;
	$.prompt(txt,{ 
		buttons:{Ja:true, Nein:false},
		callback: function(v,m,f){		
			if(v){
				var id = $("#contacts2 .active-link").attr("rel");
				var fid = $("#contacts .module-click:visible").attr("rel");
				$.ajax({ type: "GET", url: "/", data: "path=apps/contacts&request=binContact&id=" + id, cache: false, success: function(data){
					if(data == "true") {
						$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/contacts&request=getContactList&id="+fid, success: function(list){
							$("#contacts2 ul").html(list.html);
							if(list.html == "<li></li>") {
								contactsActions(3);
							} else {
								contactsActions(1);
								setModuleActive($("#contacts2"),0);
							}
							var id = $("#contacts2 .module-click:eq(0)").attr("rel");
							$("#contacts2 .module-click:eq(0)").addClass('active-link');
							$.ajax({ type: "GET", url: "/", data: "path=apps/contacts&request=getContactDetails&id="+id, success: function(html){
								$("#"+contacts.name+"-right").html(html);
								initContactsContentScrollbar()
								$('#contacts2 input.filter').quicksearch('#contacts2 li');
								}
							});
							
							contactsActions(0);
							}
						});
					}
					}
				});
			} 
		}
	});
}


function binGroup() {
	var txt = ALERT_DELETE;
	$.prompt(txt,{ 
		buttons:{Ja:true, Nein:false},
		callback: function(v,m,f){		
			if(v){
				var id = $("#contacts1 .active-link").attr("rel");
				$.ajax({ type: "GET", url: "/", data: "path=apps/contacts&request=binGroup&id=" + id, cache: false, success: function(data){
					if(data == "true") {
						$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/contacts&request=getGroupList", success: function(data){
							$("#contacts1 ul:eq(1)").html(data.html);
							var id = $("#contacts1 .module-click:eq(0)").attr("rel");
							$("#contacts1 .module-click:eq(0)").addClass('active-link');
							//$("#contacts1 .drag:eq(0)").show();
							$.ajax({ type: "GET", url: "/", data: "path=apps/contacts&request=getGroupDetails&id="+id, success: function(html){
								$("#"+contacts.name+"-right").html(html);
								//initScrollbar( '#contacts .scrolling-content' );
								initContactsContentScrollbar()
								$('#contacts1 input.filter').quicksearch('#contacts1 li');
								}
							});
							contactsActions(1);
							}
						});
					}
					}
				});
			} 
		}
	});
}


function contactsActions(status) {
	/*	0= new	1= save		2= print	3= send		4= duplicate	5= export	6= import	7=empty		8=delete */
	switch(status) {
		case 0: 	actions = ['0']; break; // system group
		case 1: 	actions = ['0','7']; break; // contact details
		case 2: 	actions = ['1']; break;   					// just save
		case 3: 	actions = ['0']; break;   					// just new
		case 4: 	actions = ['0','7']; break; // all
		default: 	actions = [];  								// none
	}
	$('#contactsActions > li a').each( function(index) {
		if(index in oc(actions)) {
			$(this).removeClass('noactive');
		} else {
			$(this).addClass('noactive');
		}
	})
}

function sortClickGroup(obj,sortcur,sortnew) {
	$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/contacts&request=getGroupList&sort="+sortnew, success: function(data){
		$("#contacts1 ul:eq(1)").html(data.html);
		obj.attr("rel",sortnew);
		obj.removeClass("sort"+sortcur).addClass("sort"+sortnew);
		  
		var id = $("#contacts1 .module-click:eq(0)").attr("rel");
		$("#contacts1 .module-click:eq(0)").addClass('active-link');
		//$("#contacts1 .drag:eq(0)").show();
		$.ajax({ type: "GET", url: "/", data: "path=apps/contacts&request=getGroupDetails&id="+id, success: function(html){
			$("#"+contacts.name+"-right").html(html);
			//initScrollbar( '#contacts .scrolling-content' );
			}
		});
		}
	});
}

function sortDragGroup(order) {
	$.ajax({ type: "GET", url: "/", data: "path=apps/contacts&request=setGroupOrder&"+order, success: function(html){
		$("#contacts1 a.sort").attr("rel", "3");
		$("#contacts1 a.sort").removeClass("sort1").removeClass("sort2").addClass("sort3");
		}
	});
}

function sortClickContact(obj,sortcur,sortnew) {
	var fid = $("#contacts .module-click:visible").attr("rel");
	$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/contacts&request=getContactList&id="+fid+"&sort="+sortnew, success: function(data){
		  $("#contacts2 ul").html(data.html);
		  obj.attr("rel",sortnew);
		  obj.removeClass("sort"+sortcur).addClass("sort"+sortnew);
		  var id = $("#contacts2 .module-click:eq(0)").attr("rel");
		  if(id == undefined) {
				return false;
			}
		  setModuleActive($("#contacts2"),'0');
		  $.ajax({ type: "GET", url: "/", data: "path=apps/contacts&request=getContactDetails&id="+id, success: function(html){
			  $("#"+contacts.name+"-right").html(html);
			  //initScrollbar( '#contacts .scrolling-content' );
			  }
		  });
	}
	});
}

function sortDragContact(order) {
	var fid = $("#contacts .module-click:visible").attr("rel");
	$.ajax({ type: "GET", url: "/", data: "path=apps/contacts&request=setContactOrder&"+order+"&id="+fid, success: function(html){
		$("#contacts2 a.sort").attr("rel", "3");
		$("#contacts2 a.sort").removeClass("sort1").removeClass("sort2").addClass("sort3");
		}
	});
}


function dialogContact(offset,request,field,append,title,sql) {
	$.ajax({ type: "GET", url: "/", data: 'path=apps/contacts&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
			$("#modalDialog").html(html);
			$("#modalDialog").dialog('option', 'position', offset);
			$("#modalDialog").dialog('option', 'title', title);
			$("#modalDialog").dialog('open');
			}
		});
}
	

function contactsloadModuleStart() {
	var h = $("#contacts .ui-layout-west").height();
	$("#contacts1 .module-inner").css("height", h-71);
	$("#contacts1 .module-actions").show();
	$("#contacts2 .module-actions").hide();
	$("#contacts2 .module-actions").hide();
	$("#contacts2 li").show();
	$("#contacts2").css("height", h-(contacts.modules_height+96)).removeClass("module-active");
	$("#contacts2 .module-inner").css("height", h-(contacts.modules_height+96));
	//$("#contacts3").css("height", h-121);
	//$("#contacts3 .contacts3-content").css("height", h-(contacts.modules_height+121));
	$("#contacts-current").val("group");
	//$("#contacts2-groups-outer").hide();
	$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/contacts&request=getGroupList", success: function(data){
			$("#contacts1 ul:eq(1)").html(data.html);
			contactsActions(0);
			$("#contacts1").css("overflow", "auto").animate({height: h-71}, function() {
		  		$("#contacts1 li").show();
				$("#contacts1 a.sort").attr("rel", data.sort).addClass("sort"+data.sort);
				var id = $("#contacts1 .module-click:eq(0)").attr("rel");
				$("#contacts1 .module-click:eq(0)").addClass('active-link');
				//$("#contacts1 .drag:eq(0)").show();
				$.ajax({ type: "GET", url: "/", data: "path=apps/contacts&request=getGroupDetails&id="+id, success: function(html){
				$("#"+contacts.name+"-right").html(html);
				contactsInnerLayout.initContent('center');
				//initScrollbar( '#contacts .scrolling-content' );
				$('#contacts1 input.filter').quicksearch('#contacts1 li');
				//$("#contacts3 .contacts3-content").hide();
				}
			});

			});
			//qs.cache();
		}
		
		
	});
}


function contactsresetModuleHeights() {
	var h = $("#contacts .ui-layout-west").height();
	if($("#contacts1").height() != module_title_height) {
		$("#contacts1").css("height", h-71);
		$("#contacts1 .module-inner").css("height", h-50);
	}
	if($("#contacts2").height() != module_title_height) {
		$("#contacts2").css("height", h-(contacts.modules_height+96));
		$("#contacts2 .module-inner").css("height", h-(contacts.modules_height+96));
	}
}


var contactsLayout, contactsInnerLayout;

$(document).ready(function() { 

	contactsLayout = $('#contacts').layout({
			west__onresize:				function() { contactsresetModuleHeights() }
		,	resizeWhileDragging:		true
		,	spacing_open:				0
		,	closable: 				false
		,	resizable: 				false
		,	slidable:				false
		, 	west__size:				325
		,	west__closable: 		true
		,	west__resizable: 		true
		,	center__onresize: "contactsInnerLayout.resizeAll"
		
	});
	
	contactsInnerLayout = $('#contacts div.ui-layout-center').layout({
		//	center__onresize:				function() { initScrollbar( '#contacts .scrolling-content' ); },
			resizeWhileDragging:		false
		,	spacing_open:				0			// cosmetic spacing
		,	closable: 				false
		,	resizable: 				false
		,	slidable:				false
		,	north__paneSelector:	".center-north"
		,	center__paneSelector:	".center-center"
		//,	south__paneSelector:	".center-south"
		,	west__paneSelector:	".center-west"
		, 	north__size:			80
		, 	west__size:			50
		 

	});
	
	contactsloadModuleStart();

	/**
	* show group list
	*/
	$("#contacts1-outer > h3").click(function(event, passed_id) {
		if(confirmNavigation()) {
			formChanged = false;
			var obj = getCurrentModule();
			$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		}

		if($(this).hasClass("module-bg-active")) {
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/contacts&request=getGroupList", success: function(data){
				$("#contacts1 ul:eq(1)").html(data.html);
				if(data.html == "<li></li>") {
					contactsActions(0);
				} else {
					contactsActions(1);
				}
				//initScrollbar( '#contacts .scrolling-content' );
				$('#contacts1 input.filter').quicksearch('#contacts1 li');
				var id = $("#contacts1 .module-click:eq(0)").attr("rel");
				$("#contacts1 .module-click:eq(0)").addClass('active-link');
				//$("#contacts2-groups-outer").hide();
				//$("#contacts2-outer").show();
				$.ajax({ type: "GET", url: "/", data: "path=apps/contacts&request=getGroupDetails&id="+id, success: function(html){
					$("#"+contacts.name+"-right").html(html);
					$("#contacts1").delay(200).animate({height: h-46}, function() {
						$(this).animate({height: h-71});			 
					});
					}
				 });
				}
			});
		} else {
			var h = $("#contacts .ui-layout-west").height();
			var id;
			if(passed_id === undefined) {
				id = $("#contacts1 .module-click:visible").attr("rel");
			} else {
				id = passed_id;
			}
			var index = $("#contacts1 .module-click").index($("#contacts1 .module-click[rel='"+id+"']"));
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/contacts&request=getGroupList", success: function(data){
				$("#contacts1 ul:eq(1)").html(data.html);
				$('#contacts1 input.filter').quicksearch('#contacts1 li');
				$.ajax({ type: "GET", url: "/", data: "path=apps/contacts&request=getGroupDetails&id="+id, success: function(html){
					$("#contacts1 li").show();
					setModuleActive($("#contacts1"),index);
					$("#contacts1").css("overflow", "auto").animate({height: h-71}, function() {
						$("#"+contacts.name+"-right").html(html);
						//initScrollbar( '#contacts .scrolling-content' );
						$("#contacts-current").val("group");
						contactsActions(0);
						setModuleDeactive($("#contacts2"),'0');
						//setModuleDeactive($("#contacts3"),'0');
						$("#contacts2 li").show();
						$("#contacts2").css("height", h-(contacts.modules_height+96)).removeClass("module-active");
						$("#contacts2").prev("h3").removeClass("white");
						$("#contacts2 .module-inner").css("height", h-(contacts.modules_height+90));
						//$("#contacts3 .contacts3-content:visible").slideUp();
					});
					}
				 });
				}
			});
		}
		$("#contacts-top .top-headline").html("");
		$("#contacts-top .top-subheadline").html("");
		return false;
	});
	
	

	/**
	* show contacts list
	*/
	$("#contacts2-outer > h3").click(function() {
		
		if(confirmNavigation()) {
			formChanged = false;
			var obj = getCurrentModule();
			$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		}
		
		if($(this).hasClass("module-bg-active")) {
			$("#contacts1-outer > h3").trigger("click");
		} else {
			if($("#contacts2").height() == module_title_height) {
				var h = $("#contacts .ui-layout-west").height();
				var id = $("#contacts1 .module-click:visible").attr("rel");
				var contactid = $("#contacts2 .module-click:eq(0)").attr("rel");
				var index = $("#contacts2 .module-click").index($("#contacts2 .module-click[rel='"+id+"']"));
				
				//contactsActions(0);
				$.ajax({ type: "GET", url: "/", data: "path=apps/contacts&request=getContactDetails&id="+id, success: function(html){
					$("#"+contacts.name+"-right").html(html);
					$("#contacts2 li").show();
					setModuleActive($("#contacts2"),index);
					$("#contacts2").css("overflow", "auto").animate({height: h-(contacts.modules_height+90)}, function() {
						//initScrollbar( '#contacts .scrolling-content' );
						initContactsContentScrollbar()
						//$("#contacts3 h3").removeClass("module-bg-active");
					});
					//$(".contacts3-content").slideUp();
				}
				});
			} else {
				var id = $("#contacts1 .active-link").attr("rel");
				if(id == 0) { // load all system contacts - then slide up
					var index = $("#contacts1 .module-click").index($("#contacts1 .module-click[rel='"+id+"']"));
					
					$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/contacts&request=getContactList&id="+id, success: function(data){
						$("#contacts2 ul").html(data.html);
						if(data.html == "<li></li>") {
							contactsActions(3);
						} else {
							contactsActions(1);
						}
						$('#contacts2 input.filter').quicksearch('#contacts2 li');
						var contactid = $("#contacts2 .module-click:eq(0)").attr("rel");
						$("#contacts-top .top-headline").html($("#contacts1 a.module-click:visible").find(".text").html());
						$.ajax({ type: "GET", url: "/", data: "path=apps/contacts&request=getContactDetails&id="+contactid, success: function(html){
							$("#"+contacts.name+"-right").html(html);
							if($("#contacts1").height() != module_title_height) {
								setModuleActive($("#contacts2"),0)
								setModuleDeactive($("#contacts1"),index);
								$("#contacts1").css("overflow", "hidden").animate({height: module_title_height}, function() {
									initContactsContentScrollbar()
								});
							}
						}
						});
					}
					});
				}
			}
		}
		$("#contacts-current").val("contacts");
		return false;
	});

  
	$("#contacts1 a.module-click").live('click',function() {
		if($(this).hasClass("deactivated")) {
			return false;
		}
		if(confirmNavigation()) {
			formChanged = false;
			var obj = getCurrentModule();
			$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		}
		var id = $(this).attr("rel");
		var index = $("#contacts a.module-click").index(this);
		var ulindex = $('#contacts1 ul').index($(this).parents('#contacts ul'));
		$("#contacts a.module-click").removeClass("active-link");
		$(this).addClass("active-link");
		$.ajax({ type: "GET", url: "/", data: "path=apps/contacts&request=getGroupDetails&id="+id, success: function(html){
			$("#"+contacts.name+"-right").html(html);
			initContactsContentScrollbar();
			}
		});
		var h = $("#contacts .ui-layout-west").height();
		if(ulindex == 0) {
			$("#contacts1").delay(200).animate({height: h-46}, function() {
			$(this).animate({height: h-71});
		});
			contactsActions(0);
		} else {
			$("#contacts1").delay(200).animate({height: h-46});
			contactsActions(4);
		}
		return false;
	});


	$("#contacts2 a.module-click").live('click',function() {
		if($(this).hasClass("deactivated")) {
			return false;
		}
		
		if(confirmNavigation()) {
			formChanged = false;
			var obj = getCurrentModule();
			$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		}
		
		var fid = $("#contacts .module-click:visible").attr("rel");
		var id = $(this).attr("rel");
		var index = $("#contacts a.module-click").index(this);
		$("#contacts a.module-click").removeClass("active-link");
		$(this).addClass("active-link");
		//$("#contacts2 a.module-click:not(.active-link) .drag").hide();
		$.ajax({ type: "GET", url: "/", data: "path=apps/contacts&request=getContactDetails&id="+id, success: function(html){
			$("#"+contacts.name+"-right").html(html);
				initContactsContentScrollbar()
				}
		});
		contactsActions(1);
		return false;
	});


    $("#contacts .loadModuleStart").click(function() {
		loadModuleStart();
		return false;
	});
  
  /*$("a.loadModule1").click(function() {
		if($("#contacts").is(":hidden")) {
			var appdeactivate = $("div.app:visible").attr("id");
			$('#contacts').slideToggle();
			$('#' + appdeactivate).slideToggle();
		}
		
		var id = $(this).attr("rel");
		loadModule1(id);
		setModule2Height();
		return false;
	});*/
  
    /*$(".loadModule2").click(function() {
		var id = $(this).attr("rel");
		loadModule2(id);
		setModule3Height();
		return false;
	});*/
		
	// ************************
	// Contact Dialog Functions
	//**************************
		
		// function to add selection to list
		function log(field,id,value) {
			closedialog = 0;
			if($("#"+field).html() != "") {
				//$("#"+field+" .listmember-outer:visible:last .listmember").append(", ");
				$("#"+field+" .listmember:visible:last").append(", ");
			}
			var html = '<span class="listmember-outer"><a class="listmember" uid="' + id + '" field="'+field+'">' + value + '</a>';
			$("#"+field).append(html);
			var obj = getCurrentModule();
			$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
			// Save last selected user to user prefs
			//$.ajax({ type: "GET", url: "/", data: "path=apps/contacts&request=setPreflast10Users&id="+id, success: function(data){
			//});
		}
		
		// autocomplete contacts search
		$('.contacts-search').livequery(function() { 
			$(this).autocomplete({
				appendTo: '#tabs-1',
				source: "?path=apps/contacts&request=getContactsSearch",
				//minLength: 2,
				select: function(event, ui) {
					var field = $(this).attr("title");
					log(field, ui.item.id, ui.item.value);
				},
				close: function(event, ui) {
					$(this).val("");
				}
			});
		});
		
		// autocomplete contacts search
		$('.places-search').livequery(function() { 
			$(this).autocomplete({
				appendTo: '#tabs-1',
				source: "?path=apps/contacts&request=getPlacesSearch",
				//minLength: 2,
				select: function(event, ui) {
					var field = $(this).attr("title");
					log(field, ui.item.id, ui.item.value);
				},
				close: function(event, ui) {
					$(this).val("");
				}
			});
		});
		
		
	$('a.insertGroupfromDialog').livequery('click',function() {
		var field = $(this).attr("field");
		var append = $(this).attr("append");
		var gid = $(this).attr("gid");
		$.ajax({ type: "GET", url: "/", data: "path=apps/contacts&request=getUsersInGroupDialog&id="+gid+"&field="+field, success: function(data){
			if(append == 0) {
				$("#"+field).html(data);
				$("#modalDialog").dialog('close');
				var obj = getCurrentModule();
				$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
			} else {
				if($("#"+field).html() != "") {
					//$("#"+field+" .listmember-outer:visible:last .listmember").append(", ");
					$("#"+field+" .listmember:visible:last").append(", ");
				}
					$("#"+field).append(data);
				}
				var obj = getCurrentModule();
				$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
			}
		});
		return false;
	});
			 
	$('a.append-custom-text').livequery('click',function() {
		var field = $(this).attr("field")+"_ct";
		var html = '<a field="' + field + '" class="ct-content">' + CUSTOM_NOTE + ' ' + $("#custom-text").val() + '</a>';
		$("#"+field).html(html);
		var obj = getCurrentModule();
		$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		return false;
	});
	
	$('a.delete-listmember').livequery('click',function() {
		var field = $(this).attr('field');
		$(this).parent().fadeOut();
		$(this).parent().prev().toggleClass('deletefromlist');
		$(this).parents(".listmember-outer").hide();
		if($("#"+field+" .listmember-outer:visible").length > 0) {
			var text = $("#"+field+" .listmember-outer:visible:last .listmember").html();
			var textnew = text.split(", ");
			$("#"+field+" .listmember-outer:visible:last .listmember").html(textnew[0]);
		}
		var obj = getCurrentModule();
		$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		return false;
	});
	
	
	$('a.listmember').live('click',function() {
		//$('.context').remove();
		var ele = $(this);
		var uid = $(this).attr('uid');
		var field = $(this).attr('field');
		$.ajax({ type: "GET", url: "/", data: "path=apps/contacts&request=getUserContext&id="+uid+"&field="+field, success: function(html){
				ele.parent().append(html);
				ele.next().slideDown();
				}
			});
		return false;
	});
	
		
	$('a.ct-content').live('click',function() {
		//$('.context').remove();
		var ele = $(this);
		var field = ele.attr('field');
		$.ajax({ type: "GET", url: "/", data: "path=apps/contacts&request=getCustomTextContext&field="+field, success: function(html){
				ele.parent().append(html);
				ele.next().slideDown();
				}
			});

		return false;
	});
	
	$('a.delete-ct').live('click',function() {
		$(this).parent().prev().html("");
		$(this).parent().remove();
		var obj = getCurrentModule();
		$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		return false;
	});
		
		
		$("a.globalLoadContactsGroup").live('click', function() {
				
				
				var id = $(this).attr("rel");
				$("#contacts1-outer > h3").trigger('click', [id]);
			
		});
		
		
		
	// Recycle bin functions
	$(".bin-deleteGroup").live('click',function(e) {
		var id = $(this).attr("rel");
		var txt = ALERT_DELETE_REALLY;
		var langbuttons = {};
		langbuttons[ALERT_YES] = true;
		langbuttons[ALERT_NO] = false;
		$.prompt(txt,{ 
			buttons:langbuttons,
			callback: function(v,m,f){		
				if(v){
					$.ajax({ type: "GET", url: "/", data: "path=apps/contacts&request=deleteGroup&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#group_'+id).slideUp();
						}
					}
					});
				} 
			}
		});
	
		return false;
	});
	
	$(".bin-restoreGroup").live('click',function(e) {
		var id = $(this).attr("rel");
		var txt = ALERT_RESTORE;
		var langbuttons = {};
		langbuttons[ALERT_YES] = true;
		langbuttons[ALERT_NO] = false;
		$.prompt(txt,{ 
			buttons:langbuttons,
			callback: function(v,m,f){		
				if(v){
					$.ajax({ type: "GET", url: "/", data: "path=apps/contacts&request=restoreGroup&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#group_'+id).slideUp();
						}
					}
					});
				} 
			}
		});
	
		return false;
	});


	$(".bin-deleteContact").live('click',function(e) {
		var id = $(this).attr("rel");
		var txt = ALERT_DELETE_REALLY;
		var langbuttons = {};
		langbuttons[ALERT_YES] = true;
		langbuttons[ALERT_NO] = false;
		$.prompt(txt,{ 
			buttons:langbuttons,
			callback: function(v,m,f){		
				if(v){
					$.ajax({ type: "GET", url: "/", data: "path=apps/contacts&request=deleteContact&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#contact_'+id).slideUp();
						}
					}
					});
				} 
			}
		});
	
		return false;
	});
	
	$(".bin-restoreContact").live('click',function(e) {
		var id = $(this).attr("rel");
		var txt = ALERT_RESTORE;
		var langbuttons = {};
		langbuttons[ALERT_YES] = true;
		langbuttons[ALERT_NO] = false;
		$.prompt(txt,{ 
			buttons:langbuttons,
			callback: function(v,m,f){		
				if(v){
					$.ajax({ type: "GET", url: "/", data: "path=apps/contacts&request=restoreContact&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#contact_'+id).slideUp();
						}
					}
					});
				} 
			}
		});
	
		return false;
	});


});