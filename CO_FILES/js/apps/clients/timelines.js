/* timelines Object */
function clientsTimelines(name) {
	this.name = name;


	this.getDetails = function(moduleidx,liindex,list) {
		var pid = $("#clients2 .module-click:visible").attr("rel");
		var id = $("#clients3 ul:eq("+moduleidx+") .module-click:eq("+liindex+")").attr("rel");
		if(id == undefined) {
			return false;
		}
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/clients/modules/timelines&request=getDetails&id="+id+"&pid="+pid, success: function(data){
			$("#clients-right").html(data.html);
			initClientsContentScrollbar();
			//initScrollbar( '.clients3-content:visible .scrolling-content' );
					if(data.access == "guest") {
						clientsActions(5);
					} else {
						clientsActions(8);
					}
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
		var url ='/?path=apps/clients/modules/timelines&request=printDetails&pid='+pid+"&id="+id;
		location.href = url;
	}


	this.actionSend = function() {
		var pid = $("#clients2 .module-click:visible").attr("rel");
		var id = $("#clients3 .active-link:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", data: "path=apps/clients/modules/timelines&request=getSend&pid="+pid+"&id="+id, success: function(html){
			$("#modalDialogForward").html(html).dialog('open');
			}
		});
	}


	this.actionSendtoResponse = function() {
		var id = $("#clients3 .active-link:visible").attr("rel");
		if($("#timeline_sendto").length > 0) {
			$.ajax({ type: "GET", url: "/", data: "path=apps/clients/modules/tiomelines&request=getSendtoDetails&id="+id, success: function(html){
				$("#timeline_sendto").html(html);
				}
			});
		}
		$("#modalDialogForward").dialog('close');
	}


	this.actionDialog = function(offset,request,field,append,title,sql) {
		$.ajax({ type: "GET", url: "/", data: 'path=apps/clients&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
			$("#modalDialog").html(html);
			$("#modalDialog").dialog('option', 'position', offset);
			$("#modalDialog").dialog('option', 'title', title);
			$("#modalDialog").dialog('open');
			}
		});
	}
	
	
	this.actionHelp = function() {
		var url = "/?path=apps/clients/modules/timelines&request=getHelp";
		$("#documentloader").attr('src', url);
	}


}


var clients_timelines = new clientsTimelines('clients_timelines');


$(document).ready(function() {  
	
	
	$("span.loadBarchartZoom").live('click', function(e) {
		e.preventDefault();
		var zoom = $(this).attr('rel');
		var pid = $("#clients2 .module-click:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/clients/modules/timelines&request=getDetails&id=1&pid="+pid+"&zoom="+zoom, success: function(data){
			$("#clients-right").html(data.html);
			initClientsContentScrollbar();
			}
		});
	});


	$("#barchartScroll").livequery( function() {
		var scroller = $(this);
		scroller.scroll(function() {
			var $scrollingDiv = $("#barchart-container-left");
			$scrollingDiv.stop().animate({"marginLeft": (scroller.scrollLeft()) + "px"}, "fast" );
			$("#barchartTimeline").stop().animate({"marginTop": (scroller.scrollTop()) + "px"}, "fast" );
			if(scroller.scrollTop() != 0) {
				$("#todayBar").stop().height(scroller.innerHeight()-67);
			}
		});
	});


	$('.but-scroll-to').live('click', function() {
		var t = $(this).attr('t');
		var l = $(this).attr('l');
		$('.scroll-pane').scrollTo(l,t);
		return false;
	});
	
});