/* vdocs Object */
function Vdocs(app) {
	this.name = app +'_vdocs';
	this.app = app;
	this.object = window[app];
	this.objectFirst = this.app.substr(0, 1);
	this.objectnameCaps = this.objectFirst.toUpperCase() + this.app.substr(1);

	this.formProcess = function(formData, form, poformOptions) {
		var app = getCurrentApp();
		var title = $('#'+ app +' input.title').fieldValue();
		if(title == "") {
			$.prompt(ALERT_NO_TITLE, {callback: setTitleFocus});
			return false;
		} else {
			formData[formData.length] = { "name": "title", "value": title };
		}
		var content = $('#'+ app +'vdocContent').html();
		for (var i=0; i < formData.length; i++) { 
			if (formData[i].name == 'content') { 
				formData[i].value = content;
			}
		}
		formData[formData.length] = processListApps('vdoc_access');
	 }


	 this.formResponse = function(data) {
		var app = getCurrentApp();
		switch(data.action) {
			case "edit":
				$("#"+ app +"3 ul[rel=vdocs] span[rel="+data.id+"] .text").html($("#"+ app +" .title").val());
					switch(data.access) {
						case "0":
							$("#"+ app +"3 ul[rel=vdocs] span[rel="+data.id+"] .module-access-status").removeClass("module-access-active");
						break;
						case "1":
							$("#"+ app +"3 ul[rel=vdocs] span[rel="+data.id+"] .module-access-status").addClass("module-access-active");
						break;
					}
			break;
		}
	}


	this.poformOptions = { async: false, beforeSubmit: this.formProcess, dataType: 'json', success: this.formResponse };


	this.getDetails = function(moduleidx,liindex,list) {
		var module = this;
		var id = $("#"+ module.app +"3 ul:eq("+moduleidx+") .module-click:eq("+liindex+")").attr("rel");
		$('#'+ module.app).data({ "third" : id});
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: 'path=apps/'+ module.app +'/modules/vdocs&request=getDetails&id='+id, success: function(data){
			$('#'+ module.app +'-right').html(data.html);
			if($('#checkedOut').length > 0) {
				$('#'+ module.app +'3 ul[rel=vdocs] .active-link .icon-checked-out').addClass('icon-checked-out-active');
			} else {
				$('#'+ module.app +'3 ul[rel=vdocs] .active-link .icon-checked-out').removeClass('icon-checked-out-active');
			}
			if(list == 0) {
				switch (data.access) {
					case "sysadmin": case "admin":
						window[module.app +'Actions'](10);
					break;
					case "guest":
						window[module.app +'Actions'](11);
					break;
				}
			} else {
				switch (data.access) {
					case "sysadmin": case "admin" :
						if(list == "<li></li>") {
							window[module.app +'Actions'](3);
						} else {
							window[module.app +'Actions'](10);
						}
					break;
					case "guest":
						if(list == "<li></li>") {
							window[module.app +'Actions']();
						} else {
							window[module.app +'Actions'](11);
						}
					break;
				}
			}
			window['init'+ module.objectnameCaps +'ContentScrollbar']();
			}
		});
	}


	this.actionNew = function() {
		var module = this;
		var cid = $('#'+ module.app +' input[name="id"]').val()
		module.checkIn(cid);
		var id = $('#'+ module.app).data('second');
		$.ajax({ type: "GET", url: "/", dataType: 'json', data: 'path=apps/'+ module.app +'/modules/vdocs&request=createNew&id=' + id, cache: false, success: function(data){
			$.ajax({ type: "GET", url: "/", dataType: 'json', data: 'path=apps/'+ module.app +'/modules/vdocs&request=getList&id='+id, success: function(list){
				$('#'+ module.app +'3 ul[rel=vdocs]').html(list.html);
				$('#'+ module.app +'_vdocs_items').html(list.items);
				var liindex = $('#'+ module.app +'3 ul[rel=vdocs] .module-click').index($("#"+ module.app +"3 ul[rel=vdocs] .module-click[rel='"+data.id+"']"));
				$('#'+ module.app +'3 ul[rel=vdocs] .module-click:eq('+liindex+')').addClass('active-link');
				var moduleidx = $('#'+ module.app +'3 ul').index($('#'+ module.app +'3 ul[rel=vdocs]'));
				module.getDetails(moduleidx,liindex);
				setTimeout(function() { $('#'+ module.app +'-right .focusTitle').trigger('click'); }, 800);
				}
			});
			}
		});
	}
	
	
	this.actionDuplicate = function() {
		var module = this;
		var cid = $('#'+ module.app +' input[name="id"]').val()
		module.checkIn(cid);
		var id = $('#'+ module.app).data("third");
		var pid = $('#'+ module.app).data("second");
		$.ajax({ type: "GET", url: "/", data: 'path=apps/'+ module.app +'/modules/vdocs&request=createDuplicate&id=' + id, cache: false, success: function(mid){
			$.ajax({ type: "GET", url: "/", dataType: 'json', data: 'path=apps/'+ module.app +'/modules/vdocs&request=getList&id='+pid, success: function(data){																																																																				
				$('#'+ module.app +'3 ul[rel=vdocs]').html(data.html);
				$('#'+ module.app +'_vdocs_items').html(data.items);
				var moduleidx = $('#'+ module.app +'3 ul').index($('#'+ module.app +'3 ul[rel=vdocs]'));
				var liindex = $('#'+ module.app +'3 ul[rel=vdocs] .module-click').index($("#"+ module.app +"3 ul[rel=vdocs] .module-click[rel='"+mid+"']"));
				module.getDetails(moduleidx,liindex);
				$('#'+ module.app +'3 ul[rel=vdocs] .module-click:eq('+liindex+')').addClass('active-link');
				}
			});
			}
		});
	}
	
	
	this.actionBin = function() {
		var module = this;
		var cid = $('#'+ module.app +' input[name="id"]').val()
		module.checkIn(cid);
		var txt = ALERT_DELETE;
		var langbuttons = {};
		langbuttons[ALERT_YES] = true;
		langbuttons[ALERT_NO] = false;
		$.prompt(txt,{ 
			buttons:langbuttons,
			callback: function(v,m,f){		
				if(v){
					var id = $('#'+ module.app).data("third");
					var pid = $('#'+ module.app).data("second");
					$.ajax({ type: "GET", url: "/", data: 'path=apps/'+ module.app +'/modules/vdocs&request=binVDoc&id=' + id, cache: false, success: function(data){
							if(data == "true") {
								$.ajax({ type: "GET", url: "/", dataType:  'json', data: 'path=apps/'+ module.app +'/modules/vdocs&request=getList&id='+pid, success: function(data){
									$('#'+ module.app +'3 ul[rel=vdocs]').html(data.html);
									$('#'+ module.app +'_vdocs_items').html(data.items);
									if(data.html == "<li></li>") {
										window[module.app +'Actions'](3);
									} else {
										window[module.app +'Actions'](10);
									}
									var moduleidx = $('#'+ module.app +'3 ul').index($('#'+ module.app +'3 ul[rel=vdocs]'));
									var liindex = 0;
									module.getDetails(moduleidx,liindex);
									$('#'+ module.app +'3 ul[rel=vdocs] .module-click:eq('+liindex+')').addClass('active-link');
								}
								});
							}
						}
					});
				} 
			}
		});
	}


	this.checkIn = function(id) {
		var module = this;
		$.ajax({ type: "GET", url: "/", async: false, data: 'path=apps/'+ module.app +'/modules/vdocs&request=checkinVDoc&id='+id, success: function(data){
			if(!data) {
				prompt("something wrong");
			}
			}
		});
		return true;
	}


	this.actionRefresh = function() {
		var module = this;
		var id = $('#'+ module.app).data("third");
		var pid = $('#'+ module.app).data("second");
		$('#'+ module.app +'3 ul[rel=vdocs] .active-link').trigger("click");
		$.ajax({ type: "GET", url: "/", dataType: 'json', data: 'path=apps/'+ module.app +'/modules/vdocs&request=getList&id='+pid, success: function(data){																																																																				
			$('#'+ module.app +'3 ul[rel=vdocs]').html(data.html);
			$('#'+ module.app +'_vdocs_items').html(data.items);
			var liindex = $('#'+ module.app +'3 ul[rel=vdocs] .module-click').index($("#"+ module.app +"3 ul[rel=vdocs] .module-click[rel='"+id+"']"));
			$('#'+ module.app +'3 ul[rel=vdocs] .module-click:eq('+liindex+')').addClass('active-link');
			}
		});
	}


	this.actionExport = function() {
		var module = this;
		var id = $('#'+ module.app).data("third");
		var url ='/?path=apps/'+ module.app +'/modules/vdocs&request=exportDetails&id='+id;
		$("#documentloader").attr('src', url);
	}


	this.actionPrint = function() {
		var module = this;
		var id = $('#'+ module.app).data("third");
		var url ='/?path=apps/'+ module.app +'/modules/vdocs&request=printDetails&id='+id;
		$("#documentloader").attr('src', url);
	}


	this.actionSend = function() {
		var module = this;
		var id = $('#'+ module.app).data("third");
		$.ajax({ type: "GET", url: "/", data: 'path=apps/'+ module.app +'/modules/vdocs&request=getSend&id='+id, success: function(html){
			$("#modalDialogForward").html(html).dialog('open');
			}
		});
	}


	this.actionSendtoResponse = function() {
		var module = this;
		var id = $('#'+ module.app).data("third");
		$.ajax({ type: "GET", url: "/", data: 'path=apps/'+ module.app +'/modules/vdocs&request=getSendtoDetails&id='+id, success: function(html){
			$('#'+ module.app +'vdoc_sendto').html(html);
			}
		});
	}


	this.sortclick = function (obj,sortcur,sortnew) {
		var module = this;
		var cid = $('#'+ module.app +' input[name="id"]').val()
		module.checkIn(cid);
		var fid = $('#'+ module.app +'2 .module-click:visible').attr("rel");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: 'path=apps/'+ module.app +'/modules/vdocs&request=getList&id='+fid+'&sort='+sortnew, success: function(data){
			$('#'+ module.app +'3 ul[rel=vdocs]').html(data.html);
			$('#'+ module.app +'_vdocs_items').html(data.items);
			obj.attr("rel",sortnew);
			obj.removeClass("sort"+sortcur).addClass("sort"+sortnew);
			var id = $('#'+ module.app +'3 ul[rel=vdocs] .module-click:eq(0)').attr("rel");
			$('#'+ module.app).data('third',id);
			if(id == undefined) {
				return false;
			}
			var moduleidx = $('#'+ module.app +'3 ul').index($('#'+ module.app +'3 ul[rel=vdocs]'));
			module.getDetails(moduleidx,0);
			$('#'+ module.app +'3 ul[rel=vdocs] .module-click:eq(0)').addClass('active-link');
		}
		});
	}


	this.sortdrag = function (order) {
		var module = this;
		var fid = $('#'+ module.app).data("second");
		$.ajax({ type: "GET", url: "/", data: 'path=apps/'+ module.app +'/modules/vdocs&request=setOrder&'+order+'&id='+fid, success: function(html){
			$('#'+ module.app +'3 .sort:visible').attr("rel", "3");
			$('#'+ module.app +'3 .sort:visible').removeClass("sort1").removeClass("sort2").addClass("sort3");
			}
		});
	}


	this.actionDialog = function(offset,request,field,append,title,sql) {
		var module = this;
		switch(request) {
			case "getAccessDialog":
				$.ajax({ type: "GET", url: "/", data: 'path=apps/'+ module.app +'&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
					$("#modalDialog").html(html);
					//$("#modalDialog").dialog('option', 'height', 50);
					$("#modalDialog").dialog('option', 'position', offset);
					$("#modalDialog").dialog('option', 'title', title);
					$("#modalDialog").dialog('open');
					}
				});
			break;
			default:
			$.ajax({ type: "GET", url: "/", data: 'path=apps/'+ module.app +'&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
				$("#modalDialog").html(html);
				$("#modalDialog").dialog('option', 'position', offset);
				$("#modalDialog").dialog('option', 'title', title);
				$("#modalDialog").dialog('open');
				if($("#" + field + "_ct .ct-content").length > 0) {
					var ct = $("#" + field + "_ct .ct-content").html();
					ct = ct.replace(CUSTOM_NOTE + " ","");
					$("#custom-text").val(ct);
				}
				}
			});
		}
	}


	this.actionHelp = function() {
		var module = this;
		var url = '/?path=apps/'+ module.app +'/modules/vdocs&request=getHelp';
		$("#documentloader").attr('src', url);
	}


	// Recycle Bin
	this.binDelete = function(id) {
		var module = this;
		var txt = ALERT_DELETE_REALLY;
		var langbuttons = {};
		langbuttons[ALERT_YES] = true;
		langbuttons[ALERT_NO] = false;
		$.prompt(txt,{ 
			buttons:langbuttons,
			callback: function(v,m,f){		
				if(v){
					$.ajax({ type: "GET", url: "/", data: 'path=apps/'+ module.app +'/modules/vdocs&request=deleteVDoc&id=' + id, cache: false, success: function(data){
						if(data == "true") {
							$('#vdoc_'+id).slideUp();
						}
					}
					});
				} 
			}
		});
	}


	this.binRestore = function(id) {
		var module = this;
		var txt = ALERT_RESTORE;
		var langbuttons = {};
		langbuttons[ALERT_YES] = true;
		langbuttons[ALERT_NO] = false;
		$.prompt(txt,{ 
			buttons:langbuttons,
			callback: function(v,m,f){		
				if(v){
					$.ajax({ type: "GET", url: "/", data: 'path=apps/'+ module.app +'/modules/vdocs&request=restoreVDoc&id=' + id, cache: false, success: function(data){
						if(data == "true") {
							$('#vdoc_'+id).slideUp();
						}
					}
					});
				} 
			}
		});
	}

}