function desktopApplication(name) {
	this.name = name;

	this.checkIn = function(id) {
		return true;
	}
	
	this.actionDialog = function(offset,request,field,append,title,sql) {
		$.ajax({ type: "GET", url: "/", data: 'path=apps/projects&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
			$("#modalDialog").html(html);
			$("#modalDialog").dialog('option', 'position', offset);
			$("#modalDialog").dialog('option', 'title', title);
			$("#modalDialog").dialog('open');
			if($("#" + field + "_ct .ct-content").length > 0) {
				var ct = $("#" + field + "_ct .ct-content").html();
				ct = ct.replace(CUSTOM_NOTE + " ","");
				$("#custom-text").val(ct);
			}
			}
		});
	}
	
	this.forwardItem = function(id,users) {
		$.ajax({ type: "POST", url: "/", data: 'path=apps/desktop&request=forwardPostit&id='+id+'&users='+users, success: function(data){
				if(data){
					$('#postit-window-'+id).slideUp();
					desktoploadModuleStart();
				}
			}
			
		});
	}
	
	// notes
	this.saveItem = function(id) {
		if($("#postit-text-"+id).length > 0) {
			var text = $("#postit-text-"+id).val();
		} else {
			var text = $("#postit-text-"+id).html().replace(/(<br\s*\/?>)|(<p><\/p>)/gi, "");
		}
		$.ajax({ type: "POST", url: "/", dataType:  'json', data: { path: 'apps/desktop', request: 'savePostit', id: id, text: text }, success: function(data){
				desktoploadModuleStart();
			}
		});
	}


	this.binItem = function(id) {
		var txt = ALERT_DELETE_REALLY;
		var langbuttons = {};
		langbuttons[ALERT_YES] = true;
		langbuttons[ALERT_NO] = false;
		$.prompt(txt,{ 
			buttons:langbuttons,
			callback: function(v,m,f){		
				if(v){
					$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/desktop&request=deletePostit&id="+id, success: function(data){
						if(data){
							$("#postit-"+id).slideUp(function(){ 
								$(this).remove();
							});
						} 
						}
					});
				} 
			}
		});	
	}
	
	this.actionHelp = function() {
		var url = "/?path=apps/desktop&request=getDesktopHelp";
		$("#documentloader").attr('src', url);
	}
	
}

var desktop = new desktopApplication('desktop');

function desktoploadModuleStart() {
	if(getCurrentApp() == 'desktop') {
		if(typeof projects == "object") {
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects&request=getWidgetAlerts", success: function(data){
				$("#projectsWidgetContent").html(data.html);
				if(data.widgetaction == 'open' && $('#projectsWidgetContent').is(':hidden')) {
					$('#item_projectsWidget a.collapse').trigger('click');
				}
				}
			});
		}
		
		if(typeof brainstorms == "object") {
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/brainstorms&request=getWidgetAlerts", success: function(data){
				$("#brainstormsWidgetContent").html(data.html);
				if(data.widgetaction == 'open' && $('#brainstormsWidgetContent').is(':hidden')) {
					$('#item_brainstormsWidget a.collapse').trigger('click');
				}
				}
			});
		}
		
		if(typeof forums == "object") {
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/forums&request=getWidgetAlerts", success: function(data){
				$("#forumsWidgetContent").html(data.html);
				if(data.widgetaction == 'open' && $('#forumsWidgetContent').is(':hidden')) {
					$('#item_forumsWidget a.collapse').trigger('click');
				}
				}
			});
		}
		
		// postits
		if(currentDesktopPostit == 0) {
			var doit = 1;
			$("#desktopPostIts div.sendtoWindow").each(function() {
				if($(this).is(':visible'))	{
					doit = 0;
				}
			})
				
			if(doit == 1) {
			$.ajax({ type: "GET", url: "/", data: "path=apps/desktop&request=getPostIts", success: function(data){
				$("#desktopPostIts").html(data);
				}
			});
			}
		}
	}
}

var desktopzIndex = 0; // zindex notes for mindmap
var currentDesktopPostit = 0;

$(document).ready(function() { 
	desktoploadModuleStart()
	
	var refreshId = setInterval(function() {
		desktoploadModuleStart()
	}, 300000);
	
	
	$('#desktopWidgetsRefresh').on('click', function(e) {
		e.preventDefault();
		prevent_dblclick(e)
		desktoploadModuleStart();
	});

	$("#desktopcolumns .column").sortable({
		cursor: 'move',
		handle: '.widget-head',
		helper: 'clone',
		delay: 100,
		opacity: 0.8,
		revert: 300,
		containment: 'document',
		placeholder: 'widget-placeholder',
		forcePlaceholderSize: true,
		connectWith: '.column'
	}).bind('sortupdate', function(event, ui) {
		var idx = $('#desktopcolumns .column').index(this);
		var col = parseInt($(this).attr("id").replace(/column/, ""));
		var order = $('#desktopcolumns .column:eq('+idx+')').sortable("serialize");
		console.log('col '+col+' ' +order);
		$.ajax({ type: "GET", url: "/", data: "path=apps/desktop&request=updateColum&col="+col+"&"+ order, cache: false, success: function(data){

			}
		});
	});


	$('a.collapse').on('click', function(e) {
		e.preventDefault();
		var  object = $(this).attr('rel');
		var status = 1;
		if($(this).hasClass('closed')) {
			var status = 0;
		}
		$(this).toggleClass('closed').parent().next().slideToggle(function() {
			$.ajax({ type: "GET", url: "/", data: "path=apps/desktop&request=setWidgetStatus&object="+object+"&status="+ status, cache: false});
		});
	});	


	$('#desktop .postit').livequery( function() {
		$(this).draggable({
			containment:'#desktop-inner',
			cancel: '.nodrag,textarea',
			start: function(e,ui){ ui.helper.css('z-index',++desktopzIndex); },
				stop: function(e,ui){
					var x = ui.position.left;
					var y = ui.position.top;
					var z = desktopzIndex;
					var id = $(this).attr("id").replace(/postit-/, "");
					$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/desktop&request=updatePostitPosition&id="+id+"&x="+x+"&y="+y+"&z="+z});
				}
			})
			.resizable({
				minHeight: 130,
				minWidth: 300,
				start: function(e,ui){ 
					ui.helper.css('z-index',++desktopzIndex);
					$(this).find("textarea").height($(this).height()-80);
				},
				resize: function(e,ui){ 
					$(this).find("div.postit-text").height($(this).height()-80);
				},
				stop: function(e,ui){
					var w = ui.size.width;
					var h = ui.size.height;
					var id = $(this).attr("id").replace(/postit-/, "");
					$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/desktop&request=updatePostitSize&id="+id+"&w="+w+"&h="+h, success: function(data){
						}
					});
				}	   
			});
	});
	
	
	$('#desktopActions').draggable({
		containment:'#desktop-inner',
		handle: '#desktopActionsDrag'
	})
	$('#desktopActionsTrans').css('opacity',0.8);


	$("#desktopNewPostit").on('click', function(e) {
		e.preventDefault();
		prevent_dblclick(e)
		var zMax = Math.max.apply(null,$.map($('#desktopPostIts div.postit'), function(e,n){
				return parseInt($(e).css('z-index'))||1 ;
				})
			);
		var z = zMax + 1;
		desktopzIndex = z;
		var x = $('#desktop').width()/2 - 152;
		$.ajax({ type: "GET", url: "/", data: "path=apps/desktop&request=newPostit&z="+z+"&x=" + x, success: function(data){
				desktoploadModuleStart();
			}
		});
	});


	$(document).on('dblclick', '#desktop div.postit-text', function(e) {
		e.preventDefault();
		var id = parseInt($(this).attr("id").replace(/postit-text-/, ""));
		currentDesktopPostit = id;
		var html = $(this).html().replace(/(<br\s*\/?>)|(<p><\/p>)/gi, "");
		var width = $(this).width();
		var height = $(this).height();
		var input = '<textarea id="postit-text-' + id + '" name="postit-text-' + id + '" style="width: '+ width +'px; height: '+ height +'px; border: 0;">' + html+ '</textarea>';
		$("#postit-text-" + id).replaceWith(input);
		$("#postit-text-" + id).focus();
	});
	

	$(document).on('click', '#desktop .projectsLink', function(e) {
		e.preventDefault();
		var href = $(this).attr('rel').split(",");
		externalLoadThreeLevels(href[0],href[1],href[2],href[3]);
	});
	
	$(document).on('click', '#desktop .projectsLinkMarkRead', function(e) {
		e.preventDefault();
		var href = $(this).attr('rel').split(",");
		externalLoadThreeLevels(href[0],href[1],href[2],href[3]);
		projects.markNoticeRead(href[2]);
	});
	
	$(document).on('click', '#desktop .brainstormsLinkMarkRead', function(e) {
		e.preventDefault();
		var href = $(this).attr('rel').split(",");
		externalLoadThreeLevels(href[0],href[1],href[2],href[3]);
		brainstorms.markNoticeRead(href[2]);
	});
	
	$(document).on('click', '#desktop .forumsLinkMarkRead', function(e) {
		e.preventDefault();
		var href = $(this).attr('rel').split(",");
		externalLoadThreeLevels(href[0],href[1],href[2],href[3]);
		forums.markNoticeRead(href[2]);
	});
	
	$(document).on('click', '#desktop .forumsLinkNewPostRead', function(e) {
		e.preventDefault();
		var href = $(this).attr('rel').split(",");
		externalLoadThreeLevels(href[0],href[1],href[2],href[3]);
		forums.markNewPostRead(href[2]);
	});

	$(document).on('click', 'a.forwardItem', function(e) {
		e.preventDefault();
		var id = $(this).attr('rel');
		var w = $('#postit-'+id).width()
		var p = (300-w)/2-8;
		$('#postit-window-'+id).css('left',-p).slideDown();
	});
	
	$(document).on('click', 'a.forwardClose', function(e) {
		e.preventDefault();
		var id = $(this).attr('rel');
		$('#postit-window-'+id).slideUp();
	});
	
	$(document).on('click', 'span.actionForwardPostit', function(e) {
		e.preventDefault();
		var id = $(this).attr('rel');
		var users = '';
		$('#postitto'+ id + ' .listmember:not(.deletefromlist)').each(function(i) {
			users += $(this).attr('uid') + ',';														   
		})
		desktop.forwardItem(id,users);
	});


	$(document).mousedown(function(e) {
		var obj = getCurrentModule();
		if(obj.name == 'desktop') {
			var clicked=$(e.target); // get the element clicked
			if(currentDesktopPostit != 0) {
				if(clicked.is('.poostit') || clicked.parents().is('.postit')) { 
					var id = /[0-9]+/.exec(e.target.id);
					if(id != currentDesktopPostit) {
						desktop.saveItem(currentDesktopPostit);
						currentDesktopPostit = 0;
					}
				} else {
					desktop.saveItem(currentDesktopPostit);
					currentDesktopPostit = 0;
				}
			}
		}
	});


	
});