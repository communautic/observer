/* timelines Object */
var timelines = new Module('timelines');
timelines.path = 'apps/projects/modules/timelines/';
timelines.getDetails = getDetailsTimeline;
timelines.actionDialog = dialogTimeline;
timelines.actionPrint = printTimeline;
timelines.actionSend = sendTimeline;
timelines.actionRefresh = refreshTimeline;
timelines.actionSendtoResponse = sendTimelineResponse;
timelines.checkIn = checkInTimeline;

function getDetailsTimeline(moduleidx,liindex) {
	var pid = $("#projects2 .module-click:visible").attr("rel");
	var id = $("#projects3 ul:eq("+moduleidx+") .module-click:eq("+liindex+")").attr("rel");
	if(id == undefined) {
		return false;
	}
	$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects/modules/timelines&request=getDetails&id="+id+"&pid="+pid, success: function(data){
		$("#projects-right").html(data.html);
		initContentScrollbar();
		initScrollbar( '.projects3-content:visible .scrolling-content' );
			if(id == "2" || id == "4") {
				if(data.access == "guest") {
					projectsActions(5);
				} else {
					projectsActions(4);
				}
			} else {
				if(data.access == "guest") {
					projectsActions();
				} else {
					projectsActions(6);
				}
			}
		}
	});
}


function printTimeline() {
	var pid = $("#projects2 .module-click:visible").attr("rel");
	var id = $("#projects3 .active-link:visible").attr("rel");
	var url ='/?path=apps/projects/modules/timelines&request=printDetails&pid='+pid+"&id="+id;
	location.href = url;
}


function sendTimeline() {
	var pid = $("#projects2 .module-click:visible").attr("rel");
	var id = $("#projects3 .active-link:visible").attr("rel");
	$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/timelines&request=getSend&pid="+pid+"&id="+id, success: function(html){
		$("#modalDialogForward").html(html).dialog('open');
		}
	});
}

function sendTimelineResponse() {
	var id = $("#projects3 .active-link:visible").attr("rel");
	if($("#timeline_sendto").length > 0) {
		$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/tiomelines&request=getSendtoDetails&id="+id, success: function(html){
			$("#timeline_sendto").html(html);
			
			}
		});
	}
	$("#modalDialogForward").dialog('close');
}

function refreshTimeline() {
	$("#projects3 .active-link:visible").trigger("click");
}

function checkInTimeline() {
	return true;
}

function dialogTimeline(offset,request,field,append,title,sql) {
	$.ajax({ type: "GET", url: "/", data: 'path=apps/projects&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
		$("#modalDialog").html(html);
		$("#modalDialog").dialog('option', 'position', offset);
		$("#modalDialog").dialog('option', 'title', title);
		$("#modalDialog").dialog('open');
		}
	});
}


$(document).ready(function() {  
	$(".trigger").livequery( function() {
		$(this).tooltip({
		position: 'center right',
		offset: [0, 15]
		});
	});


	// barchart opacity with jquery
	$(".barchart-phase-bg").livequery( function() {
		$(this).css("opacity","0.3");
	});


	$(".phaseTooltip").livequery( function() {
		$(this).tooltip({
			track: true,
			delay: 0,
			fade: 200,
			bodyHandler: function() { 
				return $(this).find(".phaseTooltipHtml").html(); 
			}, 
			showURL: false 
		});
	});


	$(".coTooltip").livequery( function() {
		$(this).tooltip({
			track: true,
			delay: 0,
			fade: 200,
			bodyHandler: function() { 
				return $(this).find(".coTooltipHtml").html(); 
			}, 
			showURL: false 
		});
	});


	$("#barchartScroll").livequery( function() {
		$(this).scroll(function() {
			var $scrollingDiv = $("#barchart-container-left");
			$scrollingDiv.stop().animate({"marginLeft": ($("#barchartScroll").scrollLeft()) + "px"}, "fast" );
			$("#barchartTimeline").stop().animate({"marginTop": ($("#barchartScroll").scrollTop()) + "px"}, "fast" );
			$("#todayBar").stop().height($("#barchartScroll").innerHeight()-67);
		});
	});


	$('.but-scroll-to').live('click', function() {
		var t = $(this).attr('t');
		var l = $(this).attr('l');
		$('.scroll-pane').scrollTo(l,t);
		return false;
	});
	
});