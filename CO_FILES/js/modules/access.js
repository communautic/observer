/* access Object */
function Access(app) {
	this.name = app +'_access';
	this.app = app;
	this.object = window[app];
	this.objectFirst = this.app.substr(0, 1);
	this.objectnameCaps = this.objectFirst.toUpperCase() + this.app.substr(1);

	this.formProcess = function(formData, form, poformOptions) {
		formData[formData.length] = processListApps('admins');
		formData[formData.length] = processListApps('guests');
	 }


	this.poformOptions = { beforeSubmit: this.formProcess, dataType:  'json' };


	this.getDetails = function(moduleidx,liindex,list) {
		var module = this;
		var id = $('#'+ module.app).data('second');
		$.ajax({ type: "GET", url: "/", data: 'path=apps/'+ module.app +'/modules/access&request=getDetails&id='+id, success: function(html){
			$('#'+ module.app +'-right').html(html);
			window['init'+ module.objectnameCaps +'ContentScrollbar']();
			window[module.app +'Actions'](6);
			}
		});
	}


	this.checkIn = function(id) {
		return true;
	}


	this.actionRefresh = function() {
		var module = this;
		$('#'+ module.app +'3 ul[rel=access] .active-link').trigger("click");
	}


	this.actionDialog = function(offset,request,field,append,title,sql) {
		var module = this;
		$.ajax({ type: "GET", url: "/", data: 'path=apps/'+ module.app +'&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
			$("#modalDialog").html(html);
			$("#modalDialog").dialog('option', 'position', offset);
			$("#modalDialog").dialog('option', 'title', title);
			$("#modalDialog").dialog('open');
			}
		});
	}


	this.actionHelp = function() {
		var module = this;
		var url = '/?path=apps/'+ module.app +'/modules/access&request=getHelp';
		$("#documentloader").attr('src', url);
	}
	
}