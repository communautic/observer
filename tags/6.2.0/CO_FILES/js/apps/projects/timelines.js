/* timelines Object */
function projectsTimelines(name) {
	this.name = name;


	this.getDetails = function(moduleidx,liindex,list) {
		var id = $("#projects3 ul:eq("+moduleidx+") .module-click:eq("+liindex+")").attr("rel");
		$('#projects').data({ "third" : id});
		var pid = $('#projects').data('second');
		if(id == undefined) {
			return false;
		}
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects/modules/timelines&request=getDetails&id="+id+"&pid="+pid, success: function(data){
			$("#projects-right").html(data.html);
			initProjectsContentScrollbar();
				if(data.access == "guest") {
					projectsActions(5);
				} else {
					projectsActions(8);
				}
			}
		});
	}


	this.checkIn = function(id) {
		return true;
	}


	this.actionRefresh = function() {
		$("#projects3 ul[rel=timelines] .active-link").trigger("click");
	}


	this.actionPrint = function() {
		var id = $("#projects").data("third");
		var pid = $("#projects").data("second");
		var url ='/?path=apps/projects/modules/timelines&request=printDetails&pid='+pid+"&id="+id;
		location.href = url;
	}


	this.actionSend = function() {
		var id = $("#projects").data("third");
		var pid = $("#projects").data("second");
		$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/timelines&request=getSend&pid="+pid+"&id="+id, success: function(html){
			$("#modalDialogForward").html(html).dialog('open');
			}
		});
	}


	this.actionSendtoResponse = function() {
		var id = $("#projects").data("third");
		if($("#timeline_sendto").length > 0) {
			$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/tiomelines&request=getSendtoDetails&id="+id, success: function(html){
				$("#timeline_sendto").html(html);
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
		});
	}
	
	
	this.actionHelp = function() {
		var url = "/?path=apps/projects/modules/timelines&request=getHelp";
		$("#documentloader").attr('src', url);
	}

}

var projects_timelines = new projectsTimelines('projects_timelines');


$(document).ready(function() {  

	$("span.loadBarchartZoom").live('click', function(e) {
		e.preventDefault();
		var zoom = $(this).attr('rel');
		var pid = $("#projects").data("second");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects/modules/timelines&request=getDetails&id=1&pid="+pid+"&zoom="+zoom, success: function(data){
			$("#projects-right").html(data.html);
			initProjectsContentScrollbar();
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