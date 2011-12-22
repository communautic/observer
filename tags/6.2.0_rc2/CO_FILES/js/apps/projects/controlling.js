/* controlling Object */
function projectsControlling(name) {
	this.name = name;


	this.getDetails = function(moduleidx,liindex,list) {
		var id = $("#projects3 ul:eq("+moduleidx+") .module-click:eq("+liindex+")").attr("rel");
		$('#projects').data({ "third" : id});
		var pid = $('#projects').data('second');
		if(id == undefined) {
			return false;
		}
		$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/controlling&request=getDetails&id="+id+"&pid="+pid, success: function(html){
				$("#projects-right").html(html);
				initProjectsContentScrollbar();
				projectsActions(8);
				}
		});
	}


	this.checkIn = function(id) {
		return true;
	}


	this.actionRefresh = function() {
		$("#projects3 ul[rel=controlling] .active-link").trigger("click");
	}


	this.actionPrint = function() {
		var id = $("#projects").data("third");
		var pid = $("#projects").data("second");
		var url ='/?path=apps/projects/modules/controlling&request=printDetails&pid='+pid+"&id="+id;
		location.href = url;
	}


	this.actionSend = function() {
		var id = $("#projects").data("third");
		var pid = $("#projects").data("second");
		$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/controlling&request=getSend&pid="+pid+"&id="+id, success: function(html){
			$("#modalDialogForward").html(html).dialog('open');
			}
		});
	}


	this.actionSendtoResponse = function() {
		var id = $("#projects").data("third");
		if($("#controlling_sendto").length > 0) {
			$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/controlling&request=getSendtoDetails&id="+id, success: function(html){
				$("#controlling_sendto").html(html);
				}
			});
		}
		$("#modalDialogForward").dialog('close');
	}
	
	
	this.actionDialog = function(offset,request,field,append,title,sql) {
		$.ajax({ type: "GET", url: "/", data: 'path=apps/projects&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
			$("#modalDialog").html(html);
			$("#modalDialog").dialog('option', 'position', offset);
			$("#modalDialog").dialog('option', 'title', title);
			$("#modalDialog").dialog('open');
			}
		})
	}


	this.actionHelp = function() {
		var url = "/?path=apps/projects/modules/controlling&request=getHelp";
		$("#documentloader").attr('src', url);
	}

}


var projects_controlling = new projectsControlling('projects_controlling');