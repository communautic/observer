/* access Object */
function productionsAccess(name) {
	this.name = name;


	this.formProcess = function(formData, form, poformOptions) {
		formData[formData.length] = processListApps('admins');
		formData[formData.length] = processListApps('guests');
	 }
	 
	 
	this.poformOptions = { async: false, beforeSubmit: this.formProcess, dataType:  'json' };


	this.getDetails = function(moduleidx,liindex,list) {
		var id = $("#productions").data('second');
		$.ajax({ type: "GET", url: "/", data: "path=apps/productions/modules/access&request=getDetails&id="+id, success: function(html){
			$("#productions-right").html(html);
			initProductionsContentScrollbar();
			productionsActions(6);
			}
		});
	}
	
	
	this.checkIn = function(id) {
		return true;
	}


	this.actionRefresh = function() {
		$("#productions3 ul[rel=access] .active-link").trigger("click");
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


	this.actionHelp = function() {
		var url = "/?path=apps/productions/modules/access&request=getHelp";
		$("#documentloader").attr('src', url);
	}
	
}

var productions_access = new productionsAccess('productions_access');