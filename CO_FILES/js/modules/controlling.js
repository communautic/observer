/* controlling Object */
function Controlling(app) {
	this.name = app +'_controlling';
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
		$.ajax({ type: "GET", url: "/", data: 'path=apps/'+ module.app + '/modules/controlling&request=getDetails&id='+id+'&pid='+pid, success: function(html){
			$('#'+ module.app + '-right').html(html);
			window['init'+ module.objectnameCaps +'ContentScrollbar']();
			window[module.app +'Actions'](8);
			}
		});
	}


	this.checkIn = function(id) {
		return true;
	}


	this.actionRefresh = function() {
		var module = this;
		$('#'+ module.app +'3 ul[rel=controlling] .active-link').trigger("click");
	}


	this.actionPrint = function() {
		var module = this;
		var id = $('#'+ module.app).data("third");
		var pid = $('#'+ module.app).data("second");
		var url ='/?path=apps/'+ module.app +'/modules/controlling&request=printDetails&pid='+pid+"&id="+id;
		if(!iOS()) {
			$("#documentloader").attr('src', url);
		} else {
			window.open(url);
		}
	}


	this.actionSend = function() {
		var module = this;
		var id = $('#'+ module.app).data("third");
		var pid = $('#'+ module.app).data("second");
		$.ajax({ type: "GET", url: "/", data: 'path=apps/'+ module.app +'/modules/controlling&request=getSend&pid='+pid+'&id='+id, success: function(html){
			$("#modalDialogForward").html(html).dialog('open');
			}
		});
	}


	this.actionSendtoResponse = function() {
		var module = this;
		var id = $('#'+ module.app).data("third");
		if($("#controlling_sendto").length > 0) {
			$.ajax({ type: "GET", url: "/", data: 'path=apps/'+ module.app +'/modules/controlling&request=getSendtoDetails&id='+id, success: function(html){
				$("#controlling_sendto").html(html);
				}
			});
		}
	}


	this.actionDialog = function(offset,request,field,append,title,sql) {
		var module = this;
		$.ajax({ type: "GET", url: "/", data: 'path=apps/projects&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
			$("#modalDialog").html(html);
			$("#modalDialog").dialog('option', 'position', offset);
			$("#modalDialog").dialog('option', 'title', title);
			$("#modalDialog").dialog('open');
			}
		})
	}


	this.actionHelp = function() {
		var module = this;
		var url = '/?path=apps/'+ module.app +'/modules/controlling&request=getHelp';
		if(!iOS()) {
			$("#documentloader").attr('src', url);
		} else {
			window.open(url);
		}
	}

}