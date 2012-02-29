/* controlling Object */
function productionsControlling(name) {
	this.name = name;


	this.getDetails = function(moduleidx,liindex,list) {
		var id = $("#productions3 ul:eq("+moduleidx+") .module-click:eq("+liindex+")").attr("rel");
		$('#productions').data({ "third" : id});
		var pid = $('#productions').data('second');
		if(id == undefined) {
			return false;
		}
		$.ajax({ type: "GET", url: "/", data: "path=apps/productions/modules/controlling&request=getDetails&id="+id+"&pid="+pid, success: function(html){
				$("#productions-right").html(html);
				initProductionsContentScrollbar();
				productionsActions(8);
				}
		});
	}


	this.checkIn = function(id) {
		return true;
	}


	this.actionRefresh = function() {
		$("#productions3 ul[rel=controlling] .active-link").trigger("click");
	}


	this.actionPrint = function() {
		var id = $("#productions").data("third");
		var pid = $("#productions").data("second");
		var url ='/?path=apps/productions/modules/controlling&request=printDetails&pid='+pid+"&id="+id;
		$("#documentloader").attr('src', url);
	}


	this.actionSend = function() {
		var id = $("#productions").data("third");
		var pid = $("#productions").data("second");
		$.ajax({ type: "GET", url: "/", data: "path=apps/productions/modules/controlling&request=getSend&pid="+pid+"&id="+id, success: function(html){
			$("#modalDialogForward").html(html).dialog('open');
			}
		});
	}


	this.actionSendtoResponse = function() {
		var id = $("#productions").data("third");
		if($("#controlling_sendto").length > 0) {
			$.ajax({ type: "GET", url: "/", data: "path=apps/productions/modules/controlling&request=getSendtoDetails&id="+id, success: function(html){
				$("#controlling_sendto").html(html);
				}
			});
		}
		$("#modalDialogForward").dialog('close');
	}
	
	
	this.actionDialog = function(offset,request,field,append,title,sql) {
		$.ajax({ type: "GET", url: "/", data: 'path=apps/productions&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
			$("#modalDialog").html(html);
			$("#modalDialog").dialog('option', 'position', offset);
			$("#modalDialog").dialog('option', 'title', title);
			$("#modalDialog").dialog('open');
			}
		})
	}


	this.actionHelp = function() {
		var url = "/?path=apps/productions/modules/controlling&request=getHelp";
		$("#documentloader").attr('src', url);
	}

}


var productions_controlling = new productionsControlling('productions_controlling');