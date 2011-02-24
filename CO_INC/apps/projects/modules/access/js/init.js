/* access Object */
var access = new Module('access');
access.path = 'apps/projects/modules/access/';
access.getDetails = getDetailsAccess;
access.actionDialog = dialogAccess;
access.addTask = addTaskAccess;
access.actionNew = newAccess;
access.actionDuplicate = duplicateAccess;
access.actionBin = binAccess;
access.poformOptions = { beforeSubmit: accessFormProcess, dataType:  'json', success: accessFormResponse };

/* Functions 
- accessFormProcess
- accessFormResponse
- newAccess
- binAccess
*/

function getDetailsAccess(moduleidx,liindex) {
	var phaseid = $("#projects3 ul:eq("+moduleidx+") .module-click:eq("+liindex+")").attr("rel");
	if(phaseid == undefined) {
					return false;
				}
	$.ajax({ type: "GET", url: "apps/projects/modules/access/", data: "request=getDetails&id="+phaseid, success: function(html){
				$("#"+projects.name+"-right").html(html);
				initContentScrollbar();
				initScrollbar( '.projects3-content:visible .scrolling-content' );
				}
		});
}

function accessFormProcess(formData, form, poformOptions) {
	var title = $("#projects .title").fieldValue();
	if(title == "") {
		$.prompt(ALERT_NO_TITLE, {callback: setTitleFocus});
		return false;
	} else {
		formData[formData.length] = { "name": "title", "value": title };
	}
	$("#loading").fadeIn();
	if($('#protocol').length > 0) {
	var protocol = $('#protocol').tinymce().getContent();
	for (var i=0; i < formData.length; i++) { 
        if (formData[i].name == 'protocol') { 
            formData[i].value = protocol;
        } 
    } 
	}
	formData[formData.length] = processList('dependency');
	formData[formData.length] = processList('management');
	formData[formData.length] = processList('team');
}


function accessFormResponse(data) {
	switch(data.action) {
		case "edit":
			$("#projects3 a.active-link .text").html($("#projects .title").val());
			var num  = $("#projects3 a.active-link .access_num").html();
			$.ajax({ type: "GET", url: "apps/projects/modules/access/", data: "request=getDetails&id="+data.id+"&num="+num, success: function(html){
				$("#projects-right").html(html);
				initContentScrollbar();
				$("#loading").fadeOut();
				}
			});
		break;
		case "new":
			var id = $("#projects2 .module-click:visible").attr("rel");
			$.ajax({ type: "GET", url: "apps/projects/modules/access/", data: "request=getList&id="+id, success: function(html){
				$(".projects3-content:visible ul").html(html);
				var index = $(".projects3-content:visible .module-click").index($(".projects3-content:visible .module-click[rel='"+data.id+"']"));
				$(".projects3-content:visible .module-click:eq("+index+")").addClass('active-link');
				//$(".projects3-content:visible .drag:eq("+index+")").show();
				var num = index+1;
				$.ajax({ type: "GET", url: "apps/projects/modules/access/", data: "request=getDetails&id="+data.id+"&num="+num, success: function(html){
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


function newAccess() {
	var id = $('#projects2 .module-click:visible').attr("rel");
	var num  = parseInt($(".projects3-content:visible a.module-click").size()+1);
	$.ajax({ type: "GET", url: "apps/projects/modules/access/", data: 'request=getNew&id=' + id + '&num=' + num, cache: false, success: function(html){
		$("#projects-right").html(html);
		setTitleFocus();
		projectsActions(2);
		initContentScrollbar();
		}
	});
}

function duplicateAccess() {
	var id = $("#projects3 .active-link").attr("rel");
	var pid = $("#projects2 .module-click:visible").attr("rel");
	$.ajax({ type: "GET", url: "apps/projects/modules/access/", data: 'request=createDuplicate&id=' + id, cache: false, success: function(accessid){
			$.ajax({ type: "GET", url: "apps/projects/modules/access/", data: "request=getList&id="+pid, success: function(html){																																																																				
				$(".projects3-content:visible ul").html(html);
				var index = $(".projects3-content:visible .module-click").index($(".projects3-content:visible .module-click[rel='"+accessid+"']"));
				$(".projects3-content:visible .module-click:eq("+index+")").addClass('active-link');
				//$(".projects3-content:visible .drag:eq("+index+")").show();
				var num = index+1;
				$.ajax({ type: "GET", url: "apps/projects/modules/access/", data: "request=getDetails&id="+accessid+"&num="+num, success: function(html){
					$("#projects-right").html(html);
					initContentScrollbar();
					$("#loading").fadeOut();
					}
				});
				projectsActions(0);
				}
			});
				}
			});
}


function binAccess() {
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
				$.ajax({ type: "GET", url: "apps/projects/modules/access/", data: "request=binAccess&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$.ajax({ type: "GET", url: "apps/projects/modules/access/", data: "request=getList&id="+pid, success: function(html){
								$(".projects3-content:visible ul").html(html);
								var id = $("#projects3 .module-click:eq(0)").attr("rel");
								$("#projects3 .projects3-content:visible .module-click:eq(0)").addClass('active-link');
								//$("#projects3 .projects3-content:visible ul:eq(0) .drag:eq(0)").show();
								$.ajax({ type: "GET", url: "apps/projects/modules/access/", data: "request=getDetails&id="+id+"&num=1", success: function(html){
									$("#projects-right").html(html);
									//initScrollbar( '#projects .scrolling-content' );
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

function dialogAccess(offset,request,field,append,title,sql) {
	$.ajax({ type: "GET", url: "apps/projects/", data: 'request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
			$("#modalDialog").html(html);
			$("#modalDialog").dialog('option', 'position', offset);
			$("#modalDialog").dialog('option', 'title', title);
			$("#modalDialog").dialog('open');
			}
		});
}

function addTaskAccess() {
	var startdate = $("input[name='startdate']").val();
	var enddate = $("input[name='enddate']").val();
	var num = parseInt($("#projects-right .tasks-entry").size());
	$.ajax({ type: "GET", url: "/apps/projects/modules/access/", data: "request=insertTask&startdate=" + startdate + "&enddate=" + enddate + "&num=" + num, success: function(html){
		$('#accesstasks').append(html);
		var idx = parseInt($('.cbx').size() -1);
		var element = $('.cbx:eq('+idx+')');
		$.jNice.CheckAddPO(element);
		$('.accessouter:eq('+idx+')').slideDown(function() {
			initContentScrollbar();								   
		});
		 }
	});
}
