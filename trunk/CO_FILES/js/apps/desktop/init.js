function desktopApplication(name) {
	this.name = name;
	this.isRefresh = false;
	
	this.checkIn = function(id) {
		return true;
	}
	
	this.actionDialog = function(offset,request,field,append,title,sql) {
		$.ajax({ type: "GET", url: "/", data: 'path=apps/contacts&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
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
	
	this.markRead = function(id) {
		$.ajax({ type: "POST", url: "/", data: 'path=apps/desktop&request=markPostitRead&id='+id, success: function(data){
				if(data){
					desktoploadModuleStart();
				}
			}
		});
	}
	
	// notes
	this.saveItem = function(id) {
		var text = $("#postit-text-"+id).val();
		$.ajax({ type: "POST", url: "/", dataType:  'json', data: { path: 'apps/desktop', request: 'savePostit', id: id, text: text }, success: function(data){
				//desktoploadModuleStart();
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
			submit: function(e,v,m,f){		
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
	
	this.markCheckpointRead = function(app,module,id) {
		$.ajax({ type: "GET", url: "/", async: false, data: "path=apps/desktop&request=markCheckpointRead&app=" + app + "&module=" + module + "&id=" + id, cache: false });
	}

	this.actionRefresh = function() {
		desktoploadModuleStart();
	}

}

var desktop = new desktopApplication('desktop');

function desktoploadProjectsModuleStart() {
	$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects&request=getWidgetAlerts", success: function(data){
		$("#projectsWidgetContent").html(data.html);
		if(data.widgetaction == 'open' && $('#projectsWidgetContent').is(':hidden')) {
			$('#item_projectsWidget a.collapse').trigger('click');
		}
		}
	});
}
function desktoploadPatientsModuleStart() {
	$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/patients&request=getWidgetAlerts", success: function(data){
		$("#patientsWidgetContent").html(data.html);
		if(data.widgetaction == 'open' && $('#patientsWidgetContent').is(':hidden')) {
			$('#item_patientsWidget a.collapse').trigger('click');
		}
		}
	});
}
function desktoploadProcsModuleStart() {
	$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/procs&request=getWidgetAlerts", success: function(data){
		$("#procsWidgetContent").html(data.html);
		if(data.widgetaction == 'open' && $('#procsWidgetContent').is(':hidden')) {
			$('#item_procsWidget a.collapse').trigger('click');
		}
		}
	});
}
function desktoploadTrainingsModuleStart() {
	$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/trainings&request=getWidgetAlerts", success: function(data){
		$("#trainingsWidgetContent").html(data.html);
		if(data.widgetaction == 'open' && $('#trainingsWidgetContent').is(':hidden')) {
			$('#item_trainingsWidget a.collapse').trigger('click');
		}
		}
	});
}
function desktoploadForumsModuleStart() {
	$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/forums&request=getWidgetAlerts", success: function(data){
		$("#forumsWidgetContent").html(data.html);
		if(data.widgetaction == 'open' && $('#forumsWidgetContent').is(':hidden')) {
			$('#item_forumsWidget a.collapse').trigger('click');
		}
		}
	});
}
function desktoploadCheckpointsModuleStart() {
	$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/desktop&request=getCheckpoints", success: function(data){
		$("#checkpointsWidgetContent").empty().html(data.html);
		if(data.widgetaction == 'open' && $('#checkpointsWidgetContent').is(':hidden')) {
			$('#item_checkpointsWidget a.collapse').trigger('click');
		}
		}
	});
}
function desktoploadCalendarModuleStart() {
	$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/calendar&request=getWidgetAlerts", success: function(data){
		$("#calendarWidgetContent").html(data.html);
		if(data.widgetaction == 'open' && $('#calendarWidgetContent').is(':hidden')) {
			$('#item_calendarWidget a.collapse').trigger('click');
		}
		}
	});
}

function desktoploadModuleStart() {
	if(getCurrentApp() == 'desktop') {
		if(typeof projects == "object") { desktoploadProjectsModuleStart() }
		if(typeof patients == "object") { desktoploadPatientsModuleStart() }
		if(typeof procs == "object") { desktoploadProcsModuleStart() }
		if(typeof trainings == "object") { desktoploadTrainingsModuleStart() }
		if(typeof forums == "object") { desktoploadForumsModuleStart() }
		if(typeof calendar == "object") { desktoploadCalendarModuleStart() }
		desktoploadCheckpointsModuleStart()
		// postits
		var doit = 1;
		$("#desktopPostIts div.sendtoWindow").each(function() {
			if($(this).is(':visible')) {
				doit = 0;
			}
		})
		$("#desktopPostIts textarea.postit-text").each(function() {
			if($(this).is(':focus')) {
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

//var desktopzIndex = 0; // zindex notes for mindmap

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
		$.ajax({ type: "GET", url: "/", data: "path=apps/desktop&request=updateColum&col="+col+"&"+ order, cache: false, success: function(data){

			}
		});
	});


	$('#desktopcolumns a.collapse').on('click', function(e) {
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
			cursor: 'move',
			handle: '.postit-header',
			start: function(e,ui){ 
			//ui.helper.css('z-index',++desktopzIndex); 
				var zMax = 0;
				zMax = Math.max.apply(null,$.map($('#desktopPostIts div.postit'), function(e,n){
					return parseInt($(e).css('z-index'))||1 ;
				}));
				var z = zMax + 1;
				$(this).css('z-index',z);
			},
				stop: function(e,ui){
					var x = Math.round(ui.position.left);
					var y = Math.round(ui.position.top);
					var z = $(this).css('z-index');
					var id = $(this).attr("id").replace(/postit-/, "");
					$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/desktop&request=updatePostitPosition&id="+id+"&x="+x+"&y="+y+"&z="+z});
				}
			})
			.resizable({
				minHeight: 130,
				minWidth: 300,
				start: function(e,ui){ 
					//ui.helper.css('z-index',++desktopzIndex);
					var zMax = 0;
					zMax = Math.max.apply(null,$.map($('#desktopPostIts div.postit'), function(e,n){
						return parseInt($(e).css('z-index'))||1 ;
					}));
					var z = zMax + 1;
					$(this).css('z-index',z);
					$(this).find("textarea").height($(this).height()-80);
					var x = Math.round(ui.position.left);
					var y = Math.round(ui.position.top);
					var id = $(this).attr("id").replace(/postit-/, "");
					$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/desktop&request=updatePostitPosition&id="+id+"&x="+x+"&y="+y+"&z="+z});
				},
				resize: function(e,ui){ 
					$(this).find("textarea").height($(this).height()-80);
				},
				stop: function(e,ui){
					var w = Math.round(ui.size.width);
					var h = Math.round(ui.size.height);
					var id = $(this).attr("id").replace(/postit-/, "");
					$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/desktop&request=updatePostitSize&id="+id+"&w="+w+"&h="+h, success: function(data){
						}
					});
				}	   
			})
			.click(function(e) { 
				e.preventDefault();
				var zMax = 0;
				zMax = Math.max.apply(null,$.map($('#desktopPostIts div.postit'), function(e,n){
					return parseInt($(e).css('z-index'))||1 ;
				}));
				var z = zMax + 1;
				$(this).css('z-index',z);
				var loc = $(this).position();
				var x = loc.left;
				var y = loc.top;
				var id = $(this).attr("id").replace(/postit-/, "");
				$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/desktop&request=updatePostitPosition&id="+id+"&x="+x+"&y="+y+"&z="+z});
			})
	});
	
	
	$('#desktopActions').draggable({
		containment:'#desktop-inner',
		handle: '#desktopActionsDrag'
	})
	$('#desktopActionsTrans').css('opacity',0.8);


	$("#desktopNewPostit").on('click', function(e) {
		e.preventDefault();
		prevent_dblclick(e)
		var zMax = 0;
		if($('#desktopPostIts div.postit').length > 0) {
			zMax = Math.max.apply(null,$.map($('#desktopPostIts div.postit'), function(e,n){
						return parseInt($(e).css('z-index'))||1 ;
					}));
		}
		var z = zMax + 1;
		//desktopzIndex = z;
		var x = $('#desktop').width()/2 - 152;
		$.ajax({ type: "GET", url: "/", data: "path=apps/desktop&request=newPostit&z="+z+"&x=" + x, success: function(data){
				desktoploadModuleStart();
			}
		});
	});
	
	$(document).on('click', '#desktop .projectsLink', function(e) {
		e.preventDefault();
		var href = $(this).attr('rel').split(",");
		externalLoadThreeLevels(href[0],href[1],href[2],href[3],'projects');
	});
	$(document).on('click', '#desktop .projectsLinkMarkRead', function(e) {
		e.preventDefault();
		var href = $(this).attr('rel').split(",");
		externalLoadThreeLevels(href[0],href[1],href[2],href[3],'projects');
		projects.markNoticeRead(href[2]);
		setTimeout(function() { desktoploadProjectsModuleStart() },500);
	});
	$(document).on('click', '#desktop .projectsInlineMarkRead', function(e) {
		e.preventDefault();
		e.stopPropagation();
		var href = $(this).attr('rel').split(",");
		var w = $(this).parent().parent();
		w.slideUp(function() {
			projects.markNoticeRead(href[2]);
			w.remove();
			if($("#projectsWidgetContent>div").length == 0) {
				setTimeout(function() { desktoploadProjectsModuleStart() },500);
			}
		})
	});
	$(document).on('click', '#desktop .projectsLinkDelete', function(e) {
		e.preventDefault();
		var href = $(this).attr('rel').split(",");
		var id = $(this).attr('link');
		externalLoadThreeLevels(href[0],href[1],href[2],href[3],'projects');
		projects.markNoticeDelete(id);
		setTimeout(function() { desktoploadProjectsModuleStart() },500);
	});
	$(document).on('click', '#desktop .projectsLinkInlineDelete', function(e) {
		e.preventDefault();
		var href = $(this).attr('rel').split(",");
		var id = $(this).attr('link');
		var w = $(this).parent().parent();
		w.slideUp(function() {
			projects.markNoticeDelete(id);
			w.remove();
			if($("#projectsWidgetContent>div").length == 0) {
				setTimeout(function() { desktoploadProjectsModuleStart() },500);
			}
		})
		
	});
	
	$(document).on('click', '#desktop .procsLinkMarkRead', function(e) {
		e.preventDefault();
		var href = $(this).attr('rel').split(",");
		externalLoadThreeLevels(href[0],href[1],href[2],href[3],'procs');
		procs.markNoticeRead(href[2]);
		setTimeout(function() { desktoploadProcsModuleStart() },500);
	});
	$(document).on('click', '#desktop .procsInlineMarkRead', function(e) {
		e.preventDefault();
		var href = $(this).attr('rel').split(",");
		var w = $(this).parent().parent();
		w.slideUp(function() {
			procs.markNoticeRead(href[2]);
			w.remove();
			if($("#procsWidgetContent>div").length == 0) {
				setTimeout(function() { desktoploadProcsModuleStart() },500);
			}
		})
	});
	
	$(document).on('click', '#desktop .patientsLink', function(e) {
		e.preventDefault();
		var href = $(this).attr('rel').split(",");
		externalLoadThreeLevels(href[0],href[1],href[2],href[3],'patients');
	});
	
	$(document).on('click', '#desktop .trainingsLink', function(e) {
		e.preventDefault();
		var href = $(this).attr('rel').split(",");
		externalLoadThreeLevels(href[0],href[1],href[2],href[3],'trainings');
	});

	$(document).on('click', '#desktop .forumsLinkMarkRead', function(e) {
		e.preventDefault();
		var href = $(this).attr('rel').split(",");
		externalLoadThreeLevels(href[0],href[1],href[2],href[3],'forums');
		forums.markNoticeRead(href[2]);
		setTimeout(function() { desktoploadForumsModuleStart() },500);
	});
	$(document).on('click', '#desktop .forumsInlineMarkRead', function(e) {
		e.preventDefault();
		var href = $(this).attr('rel').split(",");
		var w = $(this).parent().parent();
		w.slideUp(function() {
			forums.markNoticeRead(href[2]);
			w.remove();
			if($("#forumsWidgetContent>div").length == 0) {
				setTimeout(function() { desktoploadForumsModuleStart() },500);
			}
		})
	});
	$(document).on('click', '#desktop .forumsLinkNewPostRead', function(e) {
		e.preventDefault();
		var href = $(this).attr('rel').split(",");
		externalLoadThreeLevels(href[0],href[1],href[2],href[3],'forums');
		forums.markNewPostRead(href[2]);
		setTimeout(function() { desktoploadForumsModuleStart() },500);
	});
	$(document).on('click', '#desktop .forumsInlineNewPostRead', function(e) {
		e.preventDefault();
		var href = $(this).attr('rel').split(",");
		var w = $(this).parent().parent();
		w.slideUp(function() {
			forums.markNewPostRead(href[2]);
			w.remove();
			if($("#forumsWidgetContent>div").length == 0) {
				setTimeout(function() { desktoploadForumsModuleStart() },500);
			}
		})
	});
	
	
	$(document).on('click', '#desktop .calendarLinkRead', function(e) {
		e.preventDefault();
		var href = $(this).attr('rel').split(",");
		externalLoadCalendar(href[0],href[1],href[2],href[3]);
		setTimeout(function() { desktoploadCalendarModuleStart() },500);
	});
	$(document).on('click', '#desktop .calendarInlineRead', function(e) {
		e.preventDefault();
		var href = $(this).attr('rel');
		var w = $(this).parent().parent();
		w.slideUp(function() {
			calendar.markRead(href);
			w.remove();
			if($("#calendarWidgetContent>div").length == 0) {
				setTimeout(function() { desktoploadCalendarModuleStart() },500);
			}
		})
	});
	
	$(document).on('click', '#desktop .checkpointMarkRead', function(e) {
		e.preventDefault();
		var href = $(this).attr('rel').split(",");
		var app = href[0];
		var module = href[4];
		if(app == module) {
			var id = href[2];
		} else {
			var id = href[3];
		}
		desktop.markCheckpointRead(app,module,id);
		externalLoadThreeLevels(href[4],href[1],href[2],href[3],href[0]);
	});
	$(document).on('click', '#desktop .checkpointInlineMarkRead', function(e) {
		e.preventDefault();
		var href = $(this).attr('rel').split(",");
		var app = href[0];
		var module = href[4];
		if(app == module) {
			var id = href[2];
		} else {
			var id = href[3];
		}
		var w = $(this).parent().parent();
		w.slideUp(function() {
			desktop.markCheckpointRead(app,module,id);
			w.remove();
			if($("#checkpointsWidgetContent>div").length == 0) {
				setTimeout(function() { desktoploadCheckpointsModuleStart() },500);
			}
		})
	});

	$(document).on('click', 'a.markreadItem', function(e) {
		e.preventDefault();
		var id = $(this).attr('rel');
		desktop.markRead(id);
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

});