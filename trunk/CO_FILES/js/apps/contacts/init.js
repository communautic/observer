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
contacts.actionPrint = printContact;
contacts.actionSend = sendContact;
contacts.actionSendtoResponse = sendContactResponse;
contacts.actionSendVcard = sendContactVcard;
contacts.actionDuplicate = duplicateContact;
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
group.actionPrint = printGroup;
group.actionSend = sendGroup;
group.actionSendtoResponse = sendGroupResponse;
group.actionSendVcard = sendGroupVcard;
group.actionDuplicate = duplicateGroup;
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
	
	var email = $("#email").fieldValue();
	var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
	if(email != "" && reg.test(email) == false) {
		$.prompt(ALERT_NO_VALID_EMAIL, {callback: setTitleFocus});
		return false;
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

function printContact() {
	var id = $("#contacts1 .active-link:visible").attr("rel");
	var url ='/?path=apps/contacts&request=printContactDetails&id='+id;
	location.href = url;
}

function printGroup() {
	var id = $("#contacts1 .active-link:visible").attr("rel");
	var url ='/?path=apps/contacts&request=printGroupDetails&id='+id;
	location.href = url;
}

function sendContact() {
	var id = $("#contacts1 .active-link:visible").attr("rel");
	$.ajax({ type: "GET", url: "/", data: "path=apps/contacts&request=getContactSend&id="+id, success: function(html){
		$("#modalDialogForward").html(html).dialog('open');
		}
	});
}

function sendGroup() {
	var id = $("#contacts1 .active-link:visible").attr("rel");
	$.ajax({ type: "GET", url: "/", data: "path=apps/contacts&request=getGroupSend&id="+id, success: function(html){
		$("#modalDialogForward").html(html).dialog('open');
		}
	});
}

function sendContactResponse() {
	$("#modalDialogForward").dialog('close');
}


function sendGroupResponse() {
	$("#modalDialogForward").dialog('close');
}


function sendContactVcard() {
	var id = $("#contacts1 .active-link:visible").attr("rel");
	$.ajax({ type: "GET", url: "/", data: "path=apps/contacts&request=getContactSendVcard&id="+id, success: function(html){
		$("#modalDialogForward").html(html).dialog('open');
		}
	});
}


function sendGroupVcard() {
	var id = $("#contacts1 .active-link:visible").attr("rel");
	$.ajax({ type: "GET", url: "/", data: "path=apps/contacts&request=getGroupSendVcard&id="+id, success: function(html){
		$("#modalDialogForward").html(html).dialog('open');
		}
	});
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


function duplicateContact() {
	var id = $("#contacts1 .active-link:visible").attr("rel");
	$.ajax({ type: "GET", url: "/", data: 'path=apps/contacts&request=duplicateContact&id=' + id, cache: false, success: function(cid){
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/contacts&request=getContactList", success: function(list){
				$("#contacts1 ul:eq(0)").html(list.html);
					contactsActions(1);

					var index = $("#contacts1 ul:eq(0) .module-click").index($("#contacts1 .module-click[rel='"+cid+"']"));
					$.ajax({ type: "GET", url: "/", data: "path=apps/contacts&request=getContactDetails&id="+cid, success: function(html){
							$("#contacts-right").html(html);
							initContactsContentScrollbar()
							$('#contacts1 input.filter').quicksearch('#contacts1 li');
						}
			   		});
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

function duplicateGroup() {
	var id = $("#contacts1 .active-link:visible").attr("rel");
	$.ajax({ type: "GET", url: "/", data: 'path=apps/contacts&request=duplicateGroup&id=' + id, cache: false, success: function(gid){
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/contacts&request=getGroupList", success: function(list){
				$("#contacts1 ul:eq(1)").html(list.html);
					contactsActions(1);

					var index = $("#contacts1 ul:eq(1) .module-click").index($("#contacts1 .module-click[rel='"+gid+"']"));
					$("#contacts1 ul:eq(1) .module-click:eq("+index+")").addClass('active-link');
					$.ajax({ type: "GET", url: "/", data: "path=apps/contacts&request=getGroupDetails&id="+gid, success: function(html){
							$("#contacts-right").html(html);
							initContactsContentScrollbar()
							$('#contacts1 input.filter').quicksearch('#contacts1 li');
						}
			   		});
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
				var id = $("#contacts1 .active-link:visible").attr("rel");
				$.ajax({ type: "GET", url: "/", data: "path=apps/contacts&request=binGroup&id=" + id, cache: false, success: function(data){
					if(data == "true") {
						$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/contacts&request=getGroupList", success: function(data){
							if(data.html == "<li></li>") {
								contactsActions(0);
							} else {
								contactsActions(1);
								$('#contacts1').find('input.filter').quicksearch('#contacts1 li');
							}
							
							$("#contacts1 ul:eq(1)").html(data.html);
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
					}
				});
			} 
		}
	});
}


function contactsActions(status) {
	/*	0= new		1= print	2= send	3 =vcard  4= duplicate	5 = access	6=delete */
	switch(status) {
		case 0: 	actions = ['0']; break;
		case 1: 	actions = ['0','1','2','3','4','5','6']; break; // contact details
		case 2: 	actions = ['1']; break;   					// just save
		case 3: 	actions = ['0']; break;   					// just new
		case 4: 	actions = ['0','6']; break; // all
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
	switch(request) {
		case "getAccessDialog":
		if($('#email').val() == "") {
			$.prompt(ALERT_NO_EMAIL);
		return false;
		}
	$.ajax({ type: "GET", url: "/", data: 'path=apps/contacts&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
				$("#modalDialog").html(html);
				$("#modalDialog").dialog('option', 'position', offset);
				$("#modalDialog").dialog('option', 'title', title);
				$("#modalDialog").dialog('open');
				}
			});
		break;
		default:
	$.ajax({ type: "GET", url: "/", data: 'path=apps/contacts&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
			$("#modalDialog").html(html);
			$("#modalDialog").dialog('option', 'position', offset);
			$("#modalDialog").dialog('option', 'title', title);
			$("#modalDialog").dialog('open');
			}
		});
	}
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
						contactsActions(1);
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
		var html = '<span class="listmember-outer"><a class="listmember" uid="' + id + '" field="'+field+'">' + value + '</a>';
		var obj = getCurrentModule();
		if (obj.name == "access") {
			insertContactAccess(field,id,value,html);
		} else {
			if($("#"+field).html() != "") {
				$("#"+field+" .listmember:visible:last").append(", ");
			}
			$("#"+field).append(html);
			var obj = getCurrentModule();
			$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
			
			// save to lastused
			$.ajax({ type: "GET", url: "/", data: "path=apps/contacts&request=saveLastUsedContacts&id="+id});
		}
	}
	
	function logGroup(field,id,value) {
		closedialog = 0;
		if($("#"+field).html() != "") {
			$("#"+field+" .listmember:visible:last").append(", ");
		}
		$.ajax({ type: "GET", url: "/", data: "path=apps/contacts&request=getUsersInGroupDialog&id="+id+"&field="+field, success: function(data){
			$("#"+field).append(data);
			var obj = getCurrentModule();
			$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		
			// save to lastused
			$.ajax({ type: "GET", url: "/", data: "path=apps/contacts&request=saveLastUsedGroups&id="+id});																												
			}
		});		
	}
	
	function logLocation(field,id,value) {
		closedialog = 0;
		var html = '<span class="listmember-outer"><a class="listmember" uid="' + id + '" field="'+field+'">' + value + '</a>';
		$("#"+field).html(html);
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
	
	// autocomplete groups search
	$('.groups-search').livequery(function() { 
		$(this).autocomplete({
			appendTo: '#tabs-2',
			source: "?path=apps/contacts&request=getGroupsSearch",
			//minLength: 2,
			select: function(event, ui) {
				var field = $(this).attr("title");
				logGroup(field, ui.item.id, ui.item.value);
			},
			close: function(event, ui) {
				$(this).val("");
			}
		});
	});
	
	// autocomplete locations search
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
				logLocation(field, ui.item.id, text);
			},
			close: function(event, ui) {
				$(this).val("");
			}
		});
	});
	
	function insertContactEmail(field,cid,name,html) {
		//alert("check email");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/contacts&request=getContactDetailsArray&id="+cid, success: function(data){
				if(data.email == "") {
					$.prompt(name + ' ' + ALERT_SENDTO_EMAIL);
				} else {
					if($("#"+field).html() != "") {
						$("#"+field+" .listmember:visible:last").append(", ");
					}
					$("#"+field).append(html);
					var obj = getCurrentModule();
					$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
					// save to lastused
					$.ajax({ type: "GET", url: "/", data: "path=apps/contacts&request=saveLastUsedContacts&id="+cid});		
				}
			}
		});
	}
	
	function insertGroupEmail(field,gid) {
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/contacts&request=getGroupMemberDetails&id="+gid, success: function(data){
			var cid;
			var html;
			var name;
			var dia = 0;
			var txt = "";
			for(var i=0; i<data.length; i++) {
				cid = data[i].id;
				name = data[i].name;
				html = '<span class="listmember-outer"><a class="listmember" uid="' + cid + '" field="'+field+'">' + name + '</a>';
				if(data[i].email == "") {
					dia = 1;
					txt += name + ' ' + ALERT_SENDTO_EMAIL + '<br /><div style="height: 10px; border-bottom: 1px solid #ccc"></div>';

				} else {
							if($("#"+field).html() != "") {
								$("#"+field+" .listmember:visible:last").append(", ");
							}
							$("#"+field).append(html);
							var obj = getCurrentModule();
							$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);

				}
			}//loop end

			if(dia == 1) {
				$("#modalDialog").dialog('close');
				$.prompt(txt);
			}	
			} 
		});
	}


	function insertContactAccess(field,cid,name,html) {
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/contacts&request=getContactDetailsArray&id="+cid, success: function(data){
			//alert(data.username);
			if(data.username == "") {
				$("#modalDialog").dialog('close');
				if(data.email == "") {
					$.prompt(name + ' ' + ALERT_SENDTO_EMAIL);
				} else {
				
				$.prompt(name + ' ' + ALERT_ACCESS_CONTACT_NOACCESSCODES,{ 
				buttons:{Ja:true, Nein:false},
				callback: function(v,m,f){		
					if(v){
						$.ajax({ type: "GET", url: "/", data: "path=apps/contacts&request=generateAccess&id=" + cid, cache: false, success: function(data){
							if($("#"+field).html() != "") {
								$("#"+field+" .listmember:visible:last").append(", ");
							}
							$("#"+field).append(html);
							var obj = getCurrentModule();
							$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
									
							// save to lastused
							$.ajax({ type: "GET", url: "/", data: "path=apps/contacts&request=saveLastUsedContacts&id="+cid});
							}
						});
						} 
					}
				});
				}
			} else {
					// maybe it'S a sysadmin
				if(data.userlevel == 1) {
					$("#modalDialog").dialog('close');
					$.prompt(name + " " + ALERT_ACCESS_IS_SYSADMIN);
				} else {
					var insert = 1;
					// check if user is in other field
					if(field == 'admins') {
						$('#guests .listmember:visible').each(function() {
							if($(this).attr('uid') == cid) {
								$("#modalDialog").dialog('close');
								insert = 0;
								$.prompt(name + " " + ALERT_ACCESS_IS_GUEST);
							}
						});
					} else {
						$('#admins .listmember:visible').each(function() {
							if($(this).attr('uid') == cid) {
								$("#modalDialog").dialog('close');
								insert = 0;
								$.prompt(name + " " + ALERT_ACCESS_IS_ADMIN);
							}
						});
						
					}
					if(insert == 1) {
						if($("#"+field).html() != "") {
							$("#"+field+" .listmember:visible:last").append(", ");
						}
						$("#"+field).append(html);
						var obj = getCurrentModule();
						$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
								
						// save to lastused
						$.ajax({ type: "GET", url: "/", data: "path=apps/contacts&request=saveLastUsedContacts&id="+cid});
					}
				}
			}
			}
		});
	}
	

	$(".addAccessFromGroup").live('click',function(e) {
		var field = $(this).attr("field");
		var name = $(this).attr("name");
		var cid = $(this).attr("cid");
		
		var html = '<span class="listmember-outer"><a class="listmember" uid="' + cid + '" field="'+field+'">' + name + '</a>';
		var cid
		$.ajax({ type: "GET", url: "/", data: "path=apps/contacts&request=generateAccess&id=" + cid, cache: false, success: function(data){
			if($("#"+field).html() != "") {
				$("#"+field+" .listmember:visible:last").append(", ");
			}
			$("#"+field).append(html);
			var obj = getCurrentModule();
			$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
			}
		});
	return false;
	});
	

	function insertGroupAccess(field,gid) {
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/contacts&request=getGroupMemberDetails&id="+gid, success: function(data){
			var cid;
			var html;
			var name;
			var dia = 0;
			var txt = "";
			for(var i=0; i<data.length; i++) {
				cid = data[i].id;
				name = data[i].name;
				html = '<span class="listmember-outer"><a class="listmember" uid="' + cid + '" field="'+field+'">' + name + '</a>';
				if(data[i].username == "") {
					dia = 1;
					if(data[i].email == "") {
						txt += name + ' ' + ALERT_SENDTO_EMAIL + '<br /><div style="height: 10px; border-bottom: 1px solid #ccc"></div>';
					} else {
						txt += name + ' ' + ALERT_ACCESS_GROUP_NOACCESSCODES + '<button value="true" class="addAccessFromGroup jqidefaultbutton" field="'+field+'" cid="'+cid+'" name="'+name+'">' + ALERT_ACCESS_GROUP_NOACCESSCODES_SEND + '</button><br /><div style="height: 10px; border-bottom: 1px solid #ccc"></div>';
					}
				} else {
				// maybe it'S a sysadmin
					if(data[i].userlevel == 1) {
						dia = 1;
						txt += name + ' ' + ALERT_ACCESS_IS_SYSADMIN + '<br /><div style="height: 10px; border-bottom: 1px solid #ccc"></div>';
					} else {
						var insert = 1;
						// check if user is in other field
						if(field == 'admins') {
							$('#guests .listmember:visible').each(function() {
								if($(this).attr('uid') == cid) {
									dia = 1;
									insert = 0;
									txt += name + ' ' + ALERT_ACCESS_IS_GUEST + '<br /><div style="height: 10px; border-bottom: 1px solid #ccc"></div>';
								}
							});
						} else {
							$('#admins .listmember:visible').each(function() {
								if($(this).attr('uid') == cid) {
									dia = 1;
									insert = 0;
									txt += name + ' ' + ALERT_ACCESS_IS_ADMIN + '<br /><div style="height: 10px; border-bottom: 1px solid #ccc"></div>';
								}
							});
						}
						if(insert == 1) {
							if($("#"+field).html() != "") {
								$("#"+field+" .listmember:visible:last").append(", ");
							}
							$("#"+field).append(html);
							var obj = getCurrentModule();
							$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
						}
					}
				}
			}//loop end
			if(dia == 1) {
				$("#modalDialog").dialog('close');
				$.prompt(txt);
			}	
			} 
		});
	}


	$('a.insertContactfromDialog').livequery('click',function() {
		var field = $(this).attr("field");
		var append = $(this).attr("append");
		var cid = $(this).attr("cid");
		var name = $(this).html();
		var html = '<span class="listmember-outer"><a class="listmember" uid="' + cid + '" field="'+field+'">' + name + '</a>';
		var obj = getCurrentModule();
		if (obj.name == "access") {
			insertContactAccess(field,cid,name,html);																																
		} else if (field == "to" || field == "cc"){
			insertContactEmail(field,cid,name,html);	
		} else {
			if($("#"+field).html() != "") {
				$("#"+field+" .listmember:visible:last").append(", ");
			}
			$("#"+field).append(html);
			var obj = getCurrentModule();
			$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
					
			// save to lastused
			$.ajax({ type: "GET", url: "/", data: "path=apps/contacts&request=saveLastUsedContacts&id="+cid});
		}
		return false;
	});


	$('a.insertGroupfromDialog').livequery('click',function() {
		var field = $(this).attr("field");
		var append = $(this).attr("append");
		var gid = $(this).attr("gid");
		var obj = getCurrentModule();
		if (obj.name == "access") {
			insertGroupAccess(field,gid);																																
		} else if (field == "to" || field == "cc"){
			insertGroupEmail(field,gid);	
		} else {
		$.ajax({ type: "GET", url: "/", data: "path=apps/contacts&request=getUsersInGroupDialog&id="+gid+"&field="+field, success: function(data){
			if($("#"+field).html() != "") {
				$("#"+field+" .listmember:visible:last").append(", ");
			}
				$("#"+field).append(data);
			var obj = getCurrentModule();
			$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
			}
		});
		}
		return false;
	});


	$('.append-custom-text').livequery('click',function() {
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


	$('#actionAccess').live("click", function(){
		var id = $("#contacts1 .active-link:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", data: "path=apps/contacts&request=generateAccess&id=" + id, cache: false, success: function(data){
			$.ajax({ type: "GET", url: "/", data: "path=apps/contacts&request=getContactDetails&id="+id, success: function(html){
				$("#contacts-right").html(html);
				contactsInnerLayout.initContent('center');
				}
			});
			$("#modalDialog").dialog('close');
			}																																			
		});
		return false;
	});


	$('#actionSysadmin').live("click", function(){
		var id = $("#contacts1 .active-link:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", data: "path=apps/contacts&request=setSysadmin&id=" + id, cache: false, success: function(data){	
			$.ajax({ type: "GET", url: "/", data: "path=apps/contacts&request=getContactDetails&id="+id, success: function(html){
				$("#contacts-right").html(html);
				contactsInnerLayout.initContent('center');
				}
			});
			$("#modalDialog").dialog('close');
			}																																			
		});
		return false;
	});


	$('#actionAccessRemove').live("click", function(){
		var id = $("#contacts1 .active-link:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", data: "path=apps/contacts&request=removeAccess&id=" + id, cache: false, success: function(data){
			$.ajax({ type: "GET", url: "/", data: "path=apps/contacts&request=getContactDetails&id="+id, success: function(html){
				$("#contacts-right").html(html);
				contactsInnerLayout.initContent('center');
				}
			});
			$("#modalDialog").dialog('close');
			}
		});
		return false;
	});


	$('#actionSysadminRemove').live("click", function(){
		var id = $("#contacts1 .active-link:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", data: "path=apps/contacts&request=removeSysadmin&id=" + id, cache: false, success: function(data){
			$.ajax({ type: "GET", url: "/", data: "path=apps/contacts&request=getContactDetails&id="+id, success: function(html){
				$("#contacts-right").html(html);
				contactsInnerLayout.initContent('center');
				}
			});
			$("#modalDialog").dialog('close');
			}
		});
		return false;
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