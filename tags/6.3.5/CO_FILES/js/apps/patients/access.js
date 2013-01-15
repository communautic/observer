/* access Object */
function patientsAccess(name) {
	this.name = name;


	this.formProcess = function(formData, form, poformOptions) {
		formData[formData.length] = processListApps('admins');
		formData[formData.length] = processListApps('guests');
	 }
	 
	 
	this.poformOptions = { async: false, beforeSubmit: this.formProcess, dataType:  'json' };


	this.getDetails = function(moduleidx,liindex,list) {
		var id = $("#patients").data('second');
		$.ajax({ type: "GET", url: "/", data: "path=apps/patients/modules/access&request=getDetails&id="+id, success: function(html){
			$("#patients-right").html(html);
			initPatientsContentScrollbar();
			patientsActions(6);
			}
		});
	}
	
	
	this.checkIn = function(id) {
		return true;
	}


	this.actionRefresh = function() {
		$("#patients3 ul[rel=access] .active-link").trigger("click");
	}


	this.actionDialog = function(offset,request,field,append,title,sql) {
		$.ajax({ type: "GET", url: "/", data: 'path=apps/patients&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
			$("#modalDialog").html(html);
			$("#modalDialog").dialog('option', 'position', offset);
			$("#modalDialog").dialog('option', 'title', title);
			$("#modalDialog").dialog('open');
			}
		});
	}


	this.actionHelp = function() {
		var url = "/?path=apps/patients/modules/access&request=getHelp";
		$("#documentloader").attr('src', url);
	}
	
}

var patients_access = new patientsAccess('patients_access');