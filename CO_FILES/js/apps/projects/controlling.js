/* controlling Object */
var controlling = new Module('controlling');
controlling.path = 'apps/projects/modules/controlling/';
controlling.getDetails = getDetailsControlling;
controlling.actionDialog = dialogControlling;
controlling.actionPrint = printControlling;
controlling.actionSend = sendControlling;
controlling.actionSendtoResponse = sendControllingResponse;

function getDetailsControlling(moduleidx,liindex) {
	var phaseid = $("#projects3 ul:eq("+moduleidx+") .module-click:eq("+liindex+")").attr("rel");
	var pid = $("#projects2 .module-click:visible").attr("rel");
	if(phaseid == undefined) {
		return false;
	}
	$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/controlling&request=getDetails&id="+phaseid+"&pid="+pid, success: function(html){
				$("#"+projects.name+"-right").html(html);
				initContentScrollbar();
				projectsActions(4);
				}
		});
}


function printControlling() {
	var pid = $("#projects2 .module-click:visible").attr("rel");
	var id = $("#projects3 .active-link:visible").attr("rel");
	var url ='/?path=apps/projects/modules/controlling&request=printDetails&pid='+pid+"&id="+id;
	location.href = url;
}


function sendControlling() {
	var pid = $("#projects2 .module-click:visible").attr("rel");
	var id = $("#projects3 .active-link:visible").attr("rel");
	$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/controlling&request=getSend&pid="+pid+"&id="+id, success: function(html){
		$("#modalDialogForward").html(html).dialog('open');
		}
	});
}

function sendControllingResponse() {
	var id = $("#projects3 .active-link:visible").attr("rel");
	if($("#controlling_sendto").length > 0) {
		$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/controlling&request=getSendtoDetails&id="+id, success: function(html){
			$("#controlling_sendto").html(html);
			
			}
		});
	}
	$("#modalDialogForward").dialog('close');
}

function dialogControlling(offset,request,field,append,title,sql) {
	$.ajax({ type: "GET", url: "/", data: 'path=apps/projects&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
			$("#modalDialog").html(html);
			$("#modalDialog").dialog('option', 'position', offset);
			$("#modalDialog").dialog('option', 'title', title);
			$("#modalDialog").dialog('open');
			}
		});
}