/* timelines Object */
function productionsTimelines(name) {
	this.name = name;


	this.getDetails = function(moduleidx,liindex,list) {
		var id = $("#productions3 ul:eq("+moduleidx+") .module-click:eq("+liindex+")").attr("rel");
		$('#productions').data({ "third" : id});
		var pid = $('#productions').data('second');
		if(id == undefined) {
			return false;
		}
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/productions/modules/timelines&request=getDetails&id="+id+"&pid="+pid, success: function(data){
			$("#productions-right").html(data.html);
			initProductionsContentScrollbar();
				if(data.access == "guest") {
					productionsActions(5);
				} else {
					productionsActions(8);
				}
			}
		});
	}


	this.checkIn = function(id) {
		return true;
	}


	this.actionRefresh = function() {
		$("#productions3 ul[rel=timelines] .active-link").trigger("click");
	}


	this.actionPrint = function() {
		var id = $("#productions").data("third");
		var pid = $("#productions").data("second");
		var url ='/?path=apps/productions/modules/timelines&request=printDetails&pid='+pid+"&id="+id;
		$("#documentloader").attr('src', url);
	}


	this.actionSend = function() {
		var id = $("#productions").data("third");
		var pid = $("#productions").data("second");
		$.ajax({ type: "GET", url: "/", data: "path=apps/productions/modules/timelines&request=getSend&pid="+pid+"&id="+id, success: function(html){
			$("#modalDialogForward").html(html).dialog('open');
			}
		});
	}


	this.actionSendtoResponse = function() {
		var id = $("#productions").data("third");
		if($("#timeline_sendto").length > 0) {
			$.ajax({ type: "GET", url: "/", data: "path=apps/productions/modules/tiomelines&request=getSendtoDetails&id="+id, success: function(html){
				$("#timeline_sendto").html(html);
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
		});
	}


	this.loadBarchartZoom = function(zoom) {
		var pid = $("#productions").data("second");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/productions/modules/timelines&request=getDetails&id=1&pid="+pid+"&zoom="+zoom, success: function(data){
			$("#productions-right").html(data.html);
			initProductionsContentScrollbar();
			}
		});
	}


	this.actionHelp = function() {
		var url = "/?path=apps/productions/modules/timelines&request=getHelp";
		$("#documentloader").attr('src', url);
	}

}

var productions_timelines = new productionsTimelines('productions_timelines');


$(document).ready(function() {  

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


	$(document).on('click', '.but-scroll-to',function(e) {
		e.preventDefault();
		var t = $(this).attr('t');
		var l = $(this).attr('l');
		$('.scroll-pane').scrollTo(l,t);
	});
	
});