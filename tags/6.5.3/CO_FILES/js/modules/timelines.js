/* timelines Object */
function Timelines(app) {
	this.name = app +'_timelines';
	this.app = app;
	this.object = window[app];
	this.objectFirst = this.app.substr(0, 1);
	this.objectnameCaps = this.objectFirst.toUpperCase() + this.app.substr(1);


	this.getDetails = function(moduleidx,liindex,list) {
		var module = this;
		var id = $("#"+ module.app +"3 ul:eq("+moduleidx+") .module-click:eq("+liindex+")").attr("rel");
		$('#'+ module.app).data({ "third" : id});
		var pid = $('#'+ module.app).data('second');
		if(id == undefined) {
			return false;
		}
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: 'path=apps/'+ module.app +'/modules/timelines&request=getDetails&id='+id+'&pid='+pid, success: function(data){
			$('#'+ module.app +'-right').html(data.html);
				window['init'+ module.objectnameCaps +'ContentScrollbar']();
				if(data.access == "guest") {
					window[module.app +'Actions'](5);
				} else {
					window[module.app +'Actions'](8);
				}
			}
		});
	}


	this.checkIn = function(id) {
		return true;
	}


	this.actionRefresh = function() {
		var module = this;
		$('#'+ module.app +'3 ul[rel=timelines] .active-link').trigger("click");
	}


	this.actionPrint = function() {
		var module = this;
		var id = $('#'+ module.app).data("third");
		var pid = $('#'+ module.app).data("second");
		var url ='/?path=apps/'+ module.app +'/modules/timelines&request=printDetails&pid='+pid+'&id='+id;
		$("#documentloader").attr('src', url);
	}


	this.actionSend = function() {
		var module = this;
		var id = $('#'+ module.app).data("third");
		var pid = $('#'+ module.app).data("second");
		$.ajax({ type: "GET", url: "/", data: 'path=apps/'+ module.app +'/modules/timelines&request=getSend&pid='+pid+'&id='+id, success: function(html){
			$("#modalDialogForward").html(html).dialog('open');
			}
		});
	}


	this.actionSendtoResponse = function() {
		var module = this;
		var id = $('#'+ module.app).data("third");
		if($("#timeline_sendto").length > 0) {
			$.ajax({ type: "GET", url: "/", data: 'path=apps/'+ module.app +'/modules/tiomelines&request=getSendtoDetails&id='+id, success: function(html){
				$("#timeline_sendto").html(html);
				}
			});
		}
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


	this.loadBarchartZoom = function(zoom) {
		var module = this;
		var pid = $('#'+ module.app).data("second");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: 'path=apps/'+ module.app +'/modules/timelines&request=getDetails&id=1&pid='+pid+'&zoom='+zoom, success: function(data){
			$('#'+ module.app +'-right').html(data.html);
			window['init'+ module.objectnameCaps +'ContentScrollbar']();
			}
		});
	}


	this.actionHelp = function() {
		var module = this;
		var url = '/?path=apps/'+ module.app +'/modules/timelines&request=getHelp';
		$("#documentloader").attr('src', url);
	}

}