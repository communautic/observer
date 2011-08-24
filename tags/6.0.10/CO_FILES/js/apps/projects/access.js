/* access Object */
function projectsAccess(name) {
	this.name = name;


	this.formProcess = function(formData, form, poformOptions) {
		formData[formData.length] = processListApps('admins');
		formData[formData.length] = processListApps('guests');
	 }
	 
	 
	this.poformOptions = { beforeSubmit: this.formProcess, dataType:  'json' };


	this.getDetails = function(moduleidx,liindex,list) {
		var id = $("#projects2 .module-click:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/access&request=getDetails&id="+id, success: function(html){
			$("#projects-right").html(html);
			initProjectsContentScrollbar();
			//initScrollbar( '.projects3-content:visible .scrolling-content' );
			projectsActions(6);
			}
		});
	}
	
	
	this.checkIn = function(id) {
		return true;
	}


	this.actionRefresh = function() {
		$("#projects3 .active-link:visible").trigger("click");
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

}


var projects_access = new projectsAccess('projects_access');