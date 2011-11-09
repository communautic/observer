/* controlling Object */
function clientsControlling(name) {
	this.name = name;


	this.getDetails = function(moduleidx,liindex,list) {
		var phaseid = $("#clients3 ul:eq("+moduleidx+") .module-click:eq("+liindex+")").attr("rel");
		var pid = $("#clients2 .module-click:visible").attr("rel");
		if(phaseid == undefined) {
			return false;
		}
		$.ajax({ type: "GET", url: "/", data: "path=apps/clients/modules/controlling&request=getDetails&id="+phaseid+"&pid="+pid, success: function(html){
				$("#"+clients.name+"-right").html(html);
				initClientsContentScrollbar();
				clientsActions(8);
				}
		});
	}


	this.checkIn = function(id) {
		return true;
	}


	this.actionRefresh = function() {
		$("#clients3 .active-link:visible").trigger("click");
	}


	this.actionPrint = function() {
		var pid = $("#clients2 .module-click:visible").attr("rel");
		var id = $("#clients3 .active-link:visible").attr("rel");
		var url ='/?path=apps/clients/modules/controlling&request=printDetails&pid='+pid+"&id="+id;
		location.href = url;
	}


	this.actionSend = function() {
		var pid = $("#clients2 .module-click:visible").attr("rel");
		var id = $("#clients3 .active-link:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", data: "path=apps/clients/modules/controlling&request=getSend&pid="+pid+"&id="+id, success: function(html){
			$("#modalDialogForward").html(html).dialog('open');
			}
		});
	}


	this.actionSendtoResponse = function() {
		var id = $("#clients3 .active-link:visible").attr("rel");
		if($("#controlling_sendto").length > 0) {
			$.ajax({ type: "GET", url: "/", data: "path=apps/clients/modules/controlling&request=getSendtoDetails&id="+id, success: function(html){
				$("#controlling_sendto").html(html);
				}
			});
		}
		$("#modalDialogForward").dialog('close');
	}
	
	this.actionHelp = function() {
		var url = "/?path=apps/clients/modules/controlling&request=getHelp";
		$("#documentloader").attr('src', url);
	}

}


var clients_controlling = new clientsControlling('clients_controlling');