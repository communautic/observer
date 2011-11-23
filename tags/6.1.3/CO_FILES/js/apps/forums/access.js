/* access Object */
function forumsAccess(name) {
	this.name = name;


	this.formProcess = function(formData, form, poformOptions) {
		formData[formData.length] = processListApps('admins');
		formData[formData.length] = processListApps('guests');
	 }
	 
	 
	this.poformOptions = { beforeSubmit: this.formProcess, dataType:  'json' };


	this.getDetails = function(moduleidx,liindex,list) {
		var id = $("#forums2 .module-click:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", data: "path=apps/forums/modules/access&request=getDetails&id="+id, success: function(html){
			$("#forums-right").html(html);
			initForumsContentScrollbar();
			//initScrollbar( '.forums3-content:visible .scrolling-content' );
			forumsActions(6);
			}
		});
	}
	
	
	this.checkIn = function(id) {
		return true;
	}


	this.actionRefresh = function() {
		$("#forums3 .active-link:visible").trigger("click");
	}


	this.actionDialog = function(offset,request,field,append,title,sql) {
		$.ajax({ type: "GET", url: "/", data: 'path=apps/forums&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
			$("#modalDialog").html(html);
			$("#modalDialog").dialog('option', 'position', offset);
			$("#modalDialog").dialog('option', 'title', title);
			$("#modalDialog").dialog('open');
			}
		});
	}


	this.actionHelp = function() {
		var url = "/?path=apps/forums/modules/access&request=getHelp";
		$("#documentloader").attr('src', url);
	}
	
}


var forums_access = new forumsAccess('forums_access');