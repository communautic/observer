/* controlling Object */
var controlling = new Module('controlling');
controlling.path = 'apps/projects/modules/controlling/';
controlling.getDetails = getDetailsControlling;
controlling.actionDialog = dialogControlling;
controlling.addTask = addTaskControlling;
controlling.actionNew = newControlling;
controlling.actionBin = binControlling;
controlling.poformOptions = { beforeSubmit: controllingFormProcess, dataType:  'json', success: controllingFormResponse };
controlling.toggleIntern = controllingToggleIntern;
/* Functions 
- controllingFormProcess
- controllingFormResponse
- newControlling
- binControlling
*/

function getDetailsControlling(moduleidx,liindex) {
	var phaseid = $("#projects3 ul:eq("+moduleidx+") .module-click:eq("+liindex+")").attr("rel");
	var pid = $("#projects2 .module-click:visible").attr("rel");
	if(phaseid == undefined) {
					return false;
				}
	$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/controlling&request=getDetails&id="+phaseid+"&pid="+pid, success: function(html){
				$("#"+projects.name+"-right").html(html);
				initContentScrollbar();
				initScrollbar( '.projects3-content:visible .scrolling-content' );
				}
		});
}

function controllingFormProcess(formData, form, poformOptions) {
	var title = $("#projects .title").fieldValue();
	if(title == "") {
		$.prompt(ALERT_NO_TITLE, {callback: setTitleFocus});
		return false;
	} else {
		formData[formData.length] = { "name": "title", "value": title };
	}
	$("#loading").fadeIn();
	/*var protocol = nicEditors.findEditor('protocol').getContent();
	for (var i=0; i < formData.length; i++) { 
        if (formData[i].name == 'protocol') { 
            formData[i].value = protocol;
        } 
    } */
	//formData[formData.length] = processList('dependency');
}


function controllingFormResponse(data) {
	switch(data.action) {
		case "edit":
			$("#projects3 a.active-link .text").html($("#projects .controlling_date").val() + ' - ' +$("#projects .title").val());
			$("#loading").fadeOut();
		break;
		case "new":
			var id = $("#projects2 .module-click:visible").attr("rel");
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects/modules/controlling&request=getList&id="+id, success: function(html){
				$(".projects3-content:visible ul").html(html);
				var index = $(".projects3-content:visible .module-click").index($(".projects3-content:visible .module-click[rel='"+data.id+"']"));
				$(".projects3-content:visible .module-click:eq("+index+")").addClass('active-link');
				//$(".projects3-content:visible .drag:eq("+index+")").show();
				var num = index+1;
				$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/controlling&request=getDetails&id="+data.id+"&num="+num, success: function(html){
					$("#projects-right").html(html);
					initContentScrollbar();
					$("#loading").fadeOut();
					}
				});
				projectsActions(0);
				}
			});
		break;
	}
}


function newControlling() {
	var id = $('#projects2 .module-click:visible').attr("rel");
	$.ajax({ type: "GET", url: "/", data: 'path=apps/projects/modules/controlling&request=getNew&id=' + id, cache: false, success: function(html){
		$("#projects-right").html(html);
		setTitleFocus();
		projectsActions(2);
		}
	});
}


function binControlling() {
	var txt = ALERT_DELETE;
	var langbuttons = {};
	langbuttons[ALERT_YES] = true;
	langbuttons[ALERT_NO] = false;
	$.prompt(txt,{ 
		buttons:langbuttons,
		callback: function(v,m,f){		
			if(v){
				var id = $("#projects3 .active-link").attr("rel");
				var pid = $("#projects2 .module-click:visible").attr("rel");
				$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/controlling&request=binControlling&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects/modules/controlling&request=getList&id="+pid, success: function(html){
								$(".projects3-content:visible ul").html(html);
								var id = $("#projects3 .module-click:eq(0)").attr("rel");
								$("#projects3 .projects3-content:visible .module-click:eq(0)").addClass('active-link');
								//$("#projects3 .projects3-content:visible ul:eq(0) .drag:eq(0)").show();
								$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/controlling&request=getDetails&id="+id+"&num=1", success: function(html){
									$("#projects-right").html(html);
									initScrollbar( '#projects .scrolling-content' );
									initContentScrollbar();
									}
								});
								projectsActions(0);
							}
							});
						}
					}
				});
			} 
		}
	});
}


function controllingToggleIntern(id,status,obj) {
	$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/controlling&request=toggleIntern&id=" + id + "&status=" + status, cache: false, success: function(data){
		if(data == "true") {
			obj.toggleClass("module-item-active")
		}
		}
	});
}

function dialogControlling(offset,request,field,append,title,sql) {
	$.ajax({ type: "GET", url: "/", data: 'path=apps/projects&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
			$("#modalDialog").html(html);
			$("#modalDialog").dialog('option', 'position', offset);
			$("#modalDialog").dialog('option', 'title', title);
			$("#modalDialog").dialog('open');
			}
		});
}

function addTaskControlling() {
	var num = parseInt($("#projects-right .tasks-entry").size());
	$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/controlling&request=insertTask&num=" + num, success: function(html){
		$('#controllingtasks').append(html);
		var idx = parseInt($('.cbx').size() -1);
		var element = $('.cbx:eq('+idx+')');
		$.jNice.CheckAddPO(element);
		$('.controllingouter:eq('+idx+')').slideDown(function() {
			initContentScrollbar();								   
		});
		 }
	});
}