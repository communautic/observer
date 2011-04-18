/* contacts Object */
var contacts = new Application('contacts');
contacts.path = 'apps/contacts/';
contacts.resetModuleHeights = contactsresetModuleHeights;
contacts.usesLayout = true;
contacts.displayname = "Projekte";
contacts.getDetails = getDetailsContact;
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
group.getDetails = getDetailsGroup;
group.sortclick = sortClickGroup;
group.sortdrag = sortDragGroup;
group.actionDialog = dialogContact;
group.actionNew = newGroup;
group.actionBin = binGroup;
group.poformOptions = { beforeSubmit: groupFormProcess, dataType:  'json', success: groupFormResponse };


function getDetailsGroup(moduleidx,liindex) {
	var id = $("#contacts1 ul:eq("+moduleidx+") .module-click:eq("+liindex+")").attr("rel");
	$.ajax({ type: "GET", url: "/", data: "path=apps/contacts&request=getGroupDetails&id="+id, success: function(html){
		$("#contacts-right").html(html);
		contactsInnerLayout.initContent('center');
		}
	});
}


function getDetailsContact(moduleidx,liindex) {
	var id = $("#contacts1 ul:eq("+moduleidx+") .module-click:eq("+liindex+")").attr("rel");
	$.ajax({ type: "GET", url: "/", data: "path=apps/contacts&request=getContactDetails&id="+id, success: function(html){
		$("#contacts-right").html(html);
		contactsInnerLayout.initContent('center');
		}
	});
}

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
			$("#contacts1 ul:eq(0) span[rel='"+data.id+"'] .text").html(name);
		break;
	}
}


function groupFormResponse(data) {
	switch(data.action) {
		case "edit":
			$("#contacts1 ul:eq(1) span[rel='"+data.id+"'] .text").html($("#contacts .title").val());
		break;
	}
}


function newContact() {
	$.ajax({ type: "GET", url: "/", dataType:  'json', data: 'path=apps/contacts&request=newContact', cache: false, success: function(data){
		//$('#totalContacts').html("(" + data.num + ")");
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/contacts&request=getContactList", success: function(list){
				$("#contacts1 ul:eq(0)").html(list.html);
				var index = $("#contacts1 .module-click").index($("#contacts1 .module-click[rel='"+data.id+"']"));
				$("#contacts1 ul:eq(0) .module-click:eq("+index+")").addClass('active-link');
				$.ajax({ type: "GET", url: "/", data: "path=apps/contacts&request=getContactDetails&id="+data.id, success: function(html){
					$("#contacts-right").html(html);
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


function newGroup() {
	$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/contacts&request=newGroup", cache: false, success: function(data){
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/contacts&request=getGroupList", success: function(list){
				$("#contacts1 ul:eq(1)").html(list.html);
				var index = $("#contacts1 ul:eq(1) .module-click").index($("#contacts1 .module-click[rel='"+data.id+"']"));
				$("#contacts1 ul:eq(1) .module-click:eq("+index+")").addClass('active-link');
				$.ajax({ type: "GET", url: "/", data: "path=apps/contacts&request=getGroupDetails&id="+data.id, success: function(html){
					$("#contacts-right").html(html);
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
				var id = $("#contacts1 .active-link:visible").attr("rel");
				$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/contacts&request=binContact&id=" + id, cache: false, success: function(data){
					if(data.status == "true") {
						//$('#totalContacts').html("(" + data.num + ")");
						$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/contacts&request=getContactList", success: function(list){
							$("#contacts1 ul:eq(0)").html(list.html);
							if(list.html == "<li></li>") {
								contactsActions(0);
							} else {
								contactsActions(1);
							}
							var id = $("#contacts1 ul:eq(0) .module-click:eq(0)").attr("rel");
							$("#contacts1 ul:eq(0) .module-click:eq(0)").addClass('active-link');
							$.ajax({ type: "GET", url: "/", data: "path=apps/contacts&request=getContactDetails&id="+id, success: function(html){
								$("#contacts-right").html(html);
								initContactsContentScrollbar()
								$('#contacts1 input.filter').quicksearch('#contacts1 li');
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
							var id = $("#contacts1 ul:eq(1) .module-click:eq(0)").attr("rel");
							$("#contacts1 ul:eq(1) .module-click:eq(0)").addClass('active-link');
							$.ajax({ type: "GET", url: "/", data: "path=apps/contacts&request=getGroupDetails&id="+id, success: function(html){
								$("#contacts-right").html(html);
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
	$('#contactsActions > li span').each( function(index) {
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
		  
		var id = $("#contacts1 ul:eq(1) .module-click:eq(0)").attr("rel");
		$("#contacts1 ul:eq(1) .module-click:eq(0)").addClass('active-link');
		$.ajax({ type: "GET", url: "/", data: "path=apps/contacts&request=getGroupDetails&id="+id, success: function(html){
			$("#contacts-right").html(html);
			initContactsContentScrollbar()
			}
		});
		}
	});
}


function sortDragGroup(order) {
	$.ajax({ type: "GET", url: "/", data: "path=apps/contacts&request=setGroupOrder&"+order, success: function(html){
		$("#contacts1 .sort:eq(1)").attr("rel", "3");
		$("#contacts1 .sort:eq(1)").removeClass("sort1").removeClass("sort2").addClass("sort3");
		}
	});
}


function sortClickContact(obj,sortcur,sortnew) {
	$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/contacts&request=getContactList&sort="+sortnew, success: function(data){
		  $("#contacts1 ul:eq(0)").html(data.html);
		  obj.attr("rel",sortnew);
		  obj.removeClass("sort"+sortcur).addClass("sort"+sortnew);
		  var id = $("#contacts1 ul:eq(0) .module-click:eq(0)").attr("rel");
		  if(id == undefined) {
				return false;
			}
		  $("#contacts1 ul:eq(0) .module-click:eq(0)").addClass('active-link');
		  $.ajax({ type: "GET", url: "/", data: "path=apps/contacts&request=getContactDetails&id="+id, success: function(html){
			  $("#contacts-right").html(html);
			  initContactsContentScrollbar()
			  }
		  });
	}
	});
}


function sortDragContact(order) {
	$.ajax({ type: "GET", url: "/", data: "path=apps/contacts&request=setContactOrder&"+order, success: function(html){
		$("#contacts1 .sort:eq(0)").attr("rel", "3");
		$("#contacts1 .sort:eq(0)").removeClass("sort1").removeClass("sort2").addClass("sort3");
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
	$("#contacts1 h3:eq(0)").addClass("module-bg-active")
	$("#contacts1 .module-inner").css("height", h-71);
	$("#contacts1 .module-actions:eq(0)").show();
	$("#contacts1 .module-actions:eq(1)").hide();
	$(".contacts1-content").css("height", h-(contacts.modules_height*2+71));
	$("#contacts-current").val("contacts");
	$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/contacts&request=getContactList", success: function(data){
		  $("#contacts1 ul:eq(0)").html(data.html);
		  if(data.html == "<li></li>") {
			  contactsActions(0);
		  } else {
			  contactsActions(1);
			  $('#contacts1').find('input.filter').quicksearch('#contacts1 li');
		  }
		  var id = $("#contacts1 ul:eq(0) .module-click:eq(0)").attr("rel");
		  $("#contacts1 .sort").attr("rel", data.sort).addClass("sort"+data.sort);
		  var id = $("#contacts1 .module-click:eq(0)").attr("rel");
		  $("#contacts1 .module-click:eq(0)").addClass('active-link');
		  $.ajax({ type: "GET", url: "/", data: "path=apps/contacts&request=getContactDetails&id="+id, success: function(html){
			  $("#contacts-right").html(html);
			  contactsInnerLayout.initContent('center');
			  }
		  });
		}
	});
}


function contactsresetModuleHeights() {
	var h = $("#contacts .ui-layout-west").height();
	$(".contacts1-content").css("height", h-(contacts.modules_height*2+71));
	$("#contacts1 .module-inner").css("height", h-71);
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
			resizeWhileDragging:		false
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
	
	contactsloadModuleStart();
	

	/**
	* show contacts list
	*/
	$("#contacts1 h3").click(function(event, passed_id) {
		
		if(confirmNavigation()) {
			formChanged = false;
			var obj = getCurrentModule();
			$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		}
		
		var moduleidx = $("#contacts1 h3").index(this);
		var module = $(this).attr("rel");
		var h3click = $(this);

		// module open and  active 
		if($(this).hasClass("module-bg-active")) {
			return false;
		} else {
		$("#contacts1 h3").removeClass("module-bg-active");
				
		h3click.addClass("module-bg-active")
			.next('div').slideDown( function() {
				var what;
				if(module == "group") {
					what = "Group";
				} else {
					what = "Contact";
				}
				
				$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/contacts&request=get"+what+"List", success: function(data){					
					$("#contacts1 ul:eq("+moduleidx+")").html(data.html);
					if(data.html == "<li></li>") {
						contactsActions(0);
					} else {
						projectsActions(1);
						$('#contacts1').find('input.filter').quicksearch('#contacts1 li');
					}
				
					if(passed_id === undefined) {
						var idx = 0;
					} else {
						var idx = $("#contacts1 ul:eq("+moduleidx+") .module-click").index($("#contacts1 ul:eq("+moduleidx+") .module-click[rel='"+passed_id+"']"));
					}

					$("#contacts1 ul:eq("+moduleidx+") .module-click:eq("+idx+")").addClass('active-link');
					$("#contacts1 .module-actions:visible").hide();
					var obj = getCurrentModule();
					obj.getDetails(moduleidx,idx);
					$(this).prev("h3").removeClass("module-bg-active");	
					$("#contacts1 .module-actions:eq("+moduleidx+")").show();
					$("#contacts1 .sort:eq("+moduleidx+")").attr("rel", data.sort).addClass("sort"+data.sort);
					}
				});			 
			})
			.siblings('div:visible').slideUp()
		
			$("#contacts-current").val(module);
		}
		return false;
	});


	$("#contacts1 .module-click").live('click',function() {
		
		if(confirmNavigation()) {
			formChanged = false;
			var obj = getCurrentModule();
			$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		}
		
		$("#contacts1 .module-click").removeClass("active-link");
		$(this).addClass("active-link");
		var module = $(this).parents("ul").attr("rel");
		var id = $(this).attr("rel");
		
		var what;
		if(module == "group") {
			what = "Group";
		} else {
			what = "Contact";
		}
							
		$.ajax({ type: "GET", url: "/", data: "path=apps/contacts&request=get"+what+"Details&id="+id, success: function(html){
			$("#contacts-right").html(html);
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
  
		
	// ************************
	// Contact Dialog Functions
	//**************************
		
	// function to add selection to list
	function log(field,id,value) {
		closedialog = 0;
		if($("#"+field).html() != "") {
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
				var text = ui.item.value;
					text = text.split(",");
					text = text[1] + ', ' + text[2];
				log(field, ui.item.id, text);
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


	// INTERLINKS FROM Content
	$(".loadGroup").live('click', function(e) {
		var id = $(this).attr("rel");
		$("#contacts1-outer > h3").trigger('click', [id]);
		e.preventDefault();
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