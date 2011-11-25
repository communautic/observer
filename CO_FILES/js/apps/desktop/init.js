function desktopApplication(name) {
	this.name = name;
	//this.poformOptions = { };
	this.checkIn = function(id) {
		return true;
	}
	
		// notes
	this.saveItem = function(id) {
		if($("#postit-text-"+id).length > 0) {
			var text = $("#postit-text-"+id).val();
		} else {
			var text = $("#postit-text-"+id).html().replace(/(<br\s*\/?>)|(<p><\/p>)/gi, "");
		}
		$.ajax({ type: "POST", url: "/", data: { path: 'apps/desktop', request: 'savePostit', id: id, text: text }, success: function(data){
				if($("#postit-text-"+id).length > 0) {
					var height = $("#postit-text-"+id).height();
					var note_text = $(document.createElement('div')).attr("id", "postit-text-" + id).attr("class", "postit-text").css("height",height).html(data);
					$("#postit-" + id).find('textarea').replaceWith(note_text); 
				}
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
	
}

var desktop = new desktopApplication('desktop');
//desktop.resetModuleHeights = desktopresetModuleHeights;
//desktop.usesLayout = false;
//desktop.poformOptions = { };

function desktoploadModuleStart() {

	if(typeof projects == "object") {
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects&request=getWidgetAlerts", success: function(data){
			$("#projectsWidgetContent").html(data.html);
			if(data.widgetaction == 'open' && $('#projectsWidgetContent').is(':hidden')) {
				$('#item_projectsWidget a.collapse').trigger('click');
			}
			}
		});
	}
}

var desktopzIndex = 0; // zindex notes for mindmap
var currentDesktopPostit = 0;

$(document).ready(function() { 
	desktoploadModuleStart()
	
	/*var refreshId = setInterval(function() {
		desktoploadModuleStart()
	}, 5000);*/
	
	$('#widgetsRefresh').click(function(e) {
		e.preventDefault();
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
	
	/*$('a.collapse').toggle(function () {
		$(this).css({backgroundPosition: '-13px 0'}).parent().next().slideUp();
	},function () {
		$(this).css({backgroundPosition: ''}).parent().next().slideDown();
	}); */
	
	$('a.collapse').click(function(e) {
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
					containment:'#desktop',
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
					minHeight: 16,
					minWidth: 150,
					start: function(e,ui){ 
						ui.helper.css('z-index',++desktopzIndex);
						$(this).find("textarea").height($(this).height());
					},
					resize: function(e,ui){ 
						$(this).find("div.postit-text").height($(this).height());
					},
					stop: function(e,ui){
						var w = ui.size.width;
						var h = ui.size.height;
						var id = $(this).attr("id").replace(/postit-/, "");
						$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/desktop&request=updatePostitSize&id="+id+"&w="+w+"&h="+h, success: function(data){
							//$("#brainstorms-top .top-subheadlineTwo").html(data.startdate + ' - <span id="brainstormenddate">' + data.enddate + '</span>');
							}
						});
					}

						   
				});
	});


	$("#desktop a.addPostit").click( function(e) {
		e.preventDefault();
		var z = ++desktopzIndex;
		$.ajax({ type: "GET", url: "/", data: "path=apps/desktop&request=newPostit&z="+z, success: function(data){
				$("#desktop").append(data);
			}
		});
	});
	
	$("#desktop div.postit-text").live("dblclick", function(e) {
		var id = parseInt($(this).attr("id").replace(/postit-text-/, ""));
		currentDesktopPostit = id;
		e.preventDefault();
		var html = $(this).html().replace(/(<br\s*\/?>)|(<p><\/p>)/gi, "");
		var width = $(this).width();
		var height = $(this).height();
		var input = '<textarea id="postit-text-' + id + '" name="postit-text-' + id + '" style="width: '+ width +'px; height: '+ height +'px; border: 0;">' + html+ '</textarea>';
		$("#postit-text-" + id).replaceWith(input);
		$("#postit-text-" + id).focus();
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