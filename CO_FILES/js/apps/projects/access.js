/* access Object */
var access = new Module('access');
access.path = 'apps/projects/modules/access/';
access.getDetails = getDetailsAccess;
access.actionDialog = dialogAccess;
access.actionPrint = printAccess;
access.actionSend = sendAccess;
access.actionSendtoResponse = sendAccessResponse;
access.poformOptions = { beforeSubmit: accessFormProcess, dataType:  'json', success: accessFormResponse };


function getDetailsAccess(moduleidx,liindex) {
	var id = $("#projects2 .module-click:visible").attr("rel");
	$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/access&request=getDetails&id="+id, success: function(html){
		$("#"+projects.name+"-right").html(html);
		initContentScrollbar();
		initScrollbar( '.projects3-content:visible .scrolling-content' );
		projectsActions(10);
		}
	});
}


function accessFormProcess(formData, form, poformOptions) {
	formData[formData.length] = processList('admins');
	formData[formData.length] = processList('guests');
}


function accessFormResponse(data) {
}


function printAccess() {
	var id = $("#projects3 .active-link:visible").attr("rel");
	var url ='/?path=apps/projects/modules/access&request=printDetails&id='+id;
	location.href = url;
}


function sendAccess() {
	var id = $("#projects3 .active-link:visible").attr("rel");
	$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/access&request=getSend&id="+id, success: function(html){
		$("#modalDialogForward").html(html).dialog('open');
		}
	});
}

function sendAccessResponse() {
	var id = $("#projects3 .active-link:visible").attr("rel");
	$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/access&request=getSendtoDetails&id="+id, success: function(html){
		$("#access_sendto").html(html);
		$("#modalDialogForward").dialog('close');
		}
	});
}


function dialogAccess(offset,request,field,append,title,sql) {
	$.ajax({ type: "GET", url: "/", data: 'path=apps/projects&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
		$("#modalDialog").html(html);
		$("#modalDialog").dialog('option', 'position', offset);
		$("#modalDialog").dialog('option', 'title', title);
		$("#modalDialog").dialog('open');
		}
	});
}




$(document).ready(function() { 

	
});