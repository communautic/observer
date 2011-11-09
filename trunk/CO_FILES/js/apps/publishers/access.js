/* access Object */
function publishersAccess(name) {
	this.name = name;


	this.formProcess = function(formData, form, poformOptions) {
		formData[formData.length] = processListApps('admins');
		formData[formData.length] = processListApps('guests');
	 }
	 
	 
	this.poformOptions = { beforeSubmit: this.formProcess, dataType:  'json' };


	this.getDetails = function(moduleidx,liindex,list) {
		$.ajax({ type: "GET", url: "/", data: "path=apps/publishers/modules/access&request=getDetails", success: function(html){
			$("#publishers-right").html(html);
			initPublishersContentScrollbar();
			//initScrollbar( '.publishers3-content:visible .scrolling-content' );
			publishersActions(6);
			}
		});
	}
	
	
	this.checkIn = function(id) {
		return true;
	}


	this.actionRefresh = function() {
		$("#publishers1 .active-link:visible").trigger("click");
	}


	this.actionDialog = function(offset,request,field,append,title,sql) {
		$.ajax({ type: "GET", url: "/", data: 'path=apps/publishers&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
			$("#modalDialog").html(html);
			$("#modalDialog").dialog('option', 'position', offset);
			$("#modalDialog").dialog('option', 'title', title);
			$("#modalDialog").dialog('open');
			}
		});
	}


	this.actionHelp = function() {
		var url = "/?path=apps/publishers/modules/access&request=getHelp";
		$("#documentloader").attr('src', url);
	}
	
}


var publishers_access = new publishersAccess('publishers_access');