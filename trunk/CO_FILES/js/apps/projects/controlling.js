/* controlling Object */
function projectsControlling(name) {
	this.name = name;


	this.getDetails = function(moduleidx,liindex,list) {
		var phaseid = $("#projects3 ul:eq("+moduleidx+") .module-click:eq("+liindex+")").attr("rel");
		var pid = $("#projects2 .module-click:visible").attr("rel");
		if(phaseid == undefined) {
			return false;
		}
		$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/controlling&request=getDetails&id="+phaseid+"&pid="+pid, success: function(html){
				$("#"+projects.name+"-right").html(html);
				initProjectsContentScrollbar();
				projectsActions(8);
				}
		});
	}


	this.checkIn = function(id) {
		return true;
	}


	this.actionRefresh = function() {
		$("#projects3 .active-link:visible").trigger("click");
	}


	this.actionPrint = function() {
		var pid = $("#projects2 .module-click:visible").attr("rel");
		var id = $("#projects3 .active-link:visible").attr("rel");
		var url ='/?path=apps/projects/modules/controlling&request=printDetails&pid='+pid+"&id="+id;
		location.href = url;
	}


	this.actionSend = function() {
		var pid = $("#projects2 .module-click:visible").attr("rel");
		var id = $("#projects3 .active-link:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/controlling&request=getSend&pid="+pid+"&id="+id, success: function(html){
			$("#modalDialogForward").html(html).dialog('open');
			}
		});
	}


	this.actionSendtoResponse = function() {
		var id = $("#projects3 .active-link:visible").attr("rel");
		if($("#controlling_sendto").length > 0) {
			$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/controlling&request=getSendtoDetails&id="+id, success: function(html){
				$("#controlling_sendto").html(html);
				}
			});
		}
		$("#modalDialogForward").dialog('close');
	}
	
	this.actionHelp = function() {
		var url = "/?path=apps/projects/modules/controlling&request=getHelp";
		$("#documentloader").attr('src', url);
	}

}


var projects_controlling = new projectsControlling('projects_controlling');