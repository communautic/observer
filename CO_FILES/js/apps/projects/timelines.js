/* timelines Object */
var timelines = new Module('timelines');
timelines.path = 'apps/projects/modules/timelines/';
timelines.getDetails = getDetailsTimeline;
timelines.actionPrint = printTimeline;

function getDetailsTimeline(moduleidx,liindex) {
	
	var pid = $("#projects2 .module-click:visible").attr("rel");
	var phaseid = $("#projects3 ul:eq("+moduleidx+") .module-click:eq("+liindex+")").attr("rel");
	//alert(moduleidx + " " + liindex + " " + phaseid);
	if(phaseid == undefined) {
		return false;
	}
	$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/timelines&request=getDetails&id="+phaseid+"&pid="+pid, success: function(data){
		$("#projects-right").html(data);
		initContentScrollbar();
		initScrollbar( '.projects3-content:visible .scrolling-content' );
		projectsActions(4);
		}
	});
}

function printTimeline() {
	alert("in Entwicklung");
}

$(document).ready(function() {  
	$(".trigger").livequery( function() {
		$(this).tooltip({
						// custom positioning
		position: 'center right',

		// move tooltip a little bit to the right
		offset: [0, 15]
						});
	});
	
	// barchart opacity with jquery
	$(".barchart-phase-bg").livequery( function() {
		$(this).css("opacity","0.5");
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

/*$(".jspPane").livequery( function() {
$(this).scroll(function() {
       alert($("#scrollE").scrollTop());
	   var $scrollingDiv = $("#barchart-container-left");
	   $scrollingDiv
				.stop()
				.animate({"marginLeft": ($("#scrollE").scrollLeft()) + "px"}, "fast" );
});
});*/


$('.barchart-scroll').livequery(function() {
										 var bc = $(this);
bc
			/*.bind(
				'jsp-initialised',
				function(event, isScrollable)
				{
					console.log('Handle jsp-initialised', this,
								'isScrollable=', isScrollable);
				}
			)
			.bind(
				'jsp-scroll-y',
				function(event, scrollPositionY, isAtTop, isAtBottom)
				{
					console.log('Handle jsp-scroll-y', this,
								'scrollPositionY=', scrollPositionY,
								'isAtTop=', isAtTop,
								'isAtBottom=', isAtBottom);
				}
			)*/
			.bind(
				'jsp-scroll-x',
				function(event, scrollPositionX, isAtLeft, isAtRight)
				{
					/*console.log('Handle jsp-scroll-x', this,
								'scrollPositionX=', scrollPositionX,
								'isAtLeft=', isAtLeft,
								'isAtRight=', isAtRight);*/
					
					var $scrollingDiv = $("#barchart-container-left");
	   $scrollingDiv
				.stop()
				.animate({"marginLeft": scrollPositionX + "px"} );
				}
			)
			/*.bind(
				'jsp-arrow-change',
				function(event, isAtTop, isAtBottom, isAtLeft, isAtRight)
				{
					console.log('Handle jsp-arrow-change', this,
								'isAtTop=', isAtTop,
								'isAtBottom=', isAtBottom,
								'isAtLeft=', isAtLeft,
								'isAtRight=', isAtRight);
				}
			)*/
			.jScrollPane({horizontalGutter: 10,verticalGutter: 10,animateScroll: true});
			
			var api = bc.data('jsp');
			
			
			/*var throttleTimeout;
			$(window).bind(
				'resize',
				function()
				{
					if ($.browser.msie) {
						// IE fires multiple resize events while you are dragging the browser window which
						// causes it to crash if you try to update the scrollpane on every one. So we need
						// to throttle it to fire a maximum of once every 50 milliseconds...
						if (!throttleTimeout) {
							throttleTimeout = setTimeout(
								function()
								{
									api.reinitialise();
									throttleTimeout = null;
								},
								50
							);
						}
					} else {
						api.reinitialise();
						
					}
				}
			);*/

			
			
			
	$('.but-scroll-to').live('click', function() {
		var t = $(this).attr('t');
		var l = $(this).attr('l');
		api.scrollTo(l,t);
		return false;
	});



	});

	$('.timeline-scroll').livequery(function() {
		$(this).jScrollPane({horizontalGutter: 10,verticalGutter: 10,animateScroll: true});
	});

	
});