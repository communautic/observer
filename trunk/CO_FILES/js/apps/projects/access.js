/* access Object */
function projectsAccess(name) {
	this.name = name;


	this.formProcess = function(formData, form, poformOptions) {
		formData[formData.length] = processList('admins');
		formData[formData.length] = processList('guests');
	 }
	 
	 
	this.poformOptions = { beforeSubmit: this.formProcess, dataType:  'json' };


	this.getDetails = function(moduleidx,liindex,list) {
		var id = $("#projects2 .module-click:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/access&request=getDetails&id="+id, success: function(html){
			$("#projects-right").html(html);
			initProjectsContentScrollbar();
			//initScrollbar( '.projects3-content:visible .scrolling-content' );
			projectsActions(6);
			}
		});
	}
	
	
	this.checkIn = function(id) {
		return true;
	}


	this.actionRefresh = function() {
		$("#projects3 .active-link:visible").trigger("click");
	}


	/*this.actionPrint = function() {
		var id = $("#projects3 .active-link:visible").attr("rel");
		var url ='/?path=apps/projects/modules/access&request=printDetails&id='+id;
		location.href = url;
	}*/
	
	
	/*this.actionSend = function() {
		var id = $("#projects3 .active-link:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/access&request=getSend&id="+id, success: function(html){
			$("#modalDialogForward").html(html).dialog('open');
			}
		});
	}*/
	
	
	/*this.actionSendtoResponse = function() {
		var id = $("#projects3 .active-link:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/access&request=getSendtoDetails&id="+id, success: function(html){
			$("#access_sendto").html(html);
			$("#modalDialogForward").dialog('close');
			}
		});
	}*/
	
	
	this.actionDialog = function(offset,request,field,append,title,sql) {
		$.ajax({ type: "GET", url: "/", data: 'path=apps/projects&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
			$("#modalDialog").html(html);
			$("#modalDialog").dialog('option', 'position', offset);
			$("#modalDialog").dialog('option', 'title', title);
			$("#modalDialog").dialog('open');
			}
		});
	}

}
var projects_access = new projectsAccess('projects_access');
//projects_access.path = 'apps/projects/modules/access/';
//projects_access.getDetails = getDetailsAccess;
//projects_access.actionDialog = dialogAccess;
//projects_access.actionPrint = printAccess;
//projects_access.actionSend = sendAccess;
//projects_access.actionSendtoResponse = sendAccessResponse;
//projects_access.actionRefresh = refreshAccess;
//projects_access.checkIn = checkInAccess;
//projects_access.poformOptions = { beforeSubmit: accessFormProcess, dataType:  'json', success: accessFormResponse };


/*function getDetailsAccess(moduleidx,liindex) {
	var id = $("#projects2 .module-click:visible").attr("rel");
	$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/access&request=getDetails&id="+id, success: function(html){
		$("#"+projects.name+"-right").html(html);
		initProjectsContentScrollbar();
		initScrollbar( '.projects3-content:visible .scrolling-content' );
		projectsActions(6);
		}
	});
}*/


/*function accessFormProcess(formData, form, poformOptions) {
	formData[formData.length] = processList('admins');
	formData[formData.length] = processList('guests');
}*/


/*function accessFormResponse(data) {
}*/


/*function printAccess() {
	var id = $("#projects3 .active-link:visible").attr("rel");
	var url ='/?path=apps/projects/modules/access&request=printDetails&id='+id;
	location.href = url;
}*/


/*function sendAccess() {
	var id = $("#projects3 .active-link:visible").attr("rel");
	$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/access&request=getSend&id="+id, success: function(html){
		$("#modalDialogForward").html(html).dialog('open');
		}
	});
}*/

/*function sendAccessResponse() {
	var id = $("#projects3 .active-link:visible").attr("rel");
	$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/access&request=getSendtoDetails&id="+id, success: function(html){
		$("#access_sendto").html(html);
		$("#modalDialogForward").dialog('close');
		}
	});
}*/

/*function refreshAccess() {
	$("#projects3 .active-link:visible").trigger("click");
}*/

/*function dialogAccess(offset,request,field,append,title,sql) {
	$.ajax({ type: "GET", url: "/", data: 'path=apps/projects&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
		$("#modalDialog").html(html);
		$("#modalDialog").dialog('option', 'position', offset);
		$("#modalDialog").dialog('option', 'title', title);
		$("#modalDialog").dialog('open');
		}
	});
}*/

/*function checkInAccess() {
	return true;
}*/




//$(document).ready(function() { 

	
//});