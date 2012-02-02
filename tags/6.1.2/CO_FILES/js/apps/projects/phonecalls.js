/* phonecalls Object */
function projectsPhonecalls(name) {
	this.name = name;


	this.formProcess = function(formData, form, poformOptions) {
		var title = $("#projects input.title").fieldValue();
		if(title == "") {
			$.prompt(ALERT_NO_TITLE, {callback: setTitleFocus});
			return false;
		} else {
			formData[formData.length] = { "name": "title", "value": title };
		}
		
		formData[formData.length] = processListApps('management');
		formData[formData.length] = processCustomTextApps('management_ct');
		formData[formData.length] = processStringApps('phonecallstart');
		formData[formData.length] = processStringApps('phonecallend');
		formData[formData.length] = processDocListApps('documents');
		formData[formData.length] = processListApps('phonecall_access');
		formData[formData.length] = processListApps('phonecall_status');
	 }
	 
	 
	 this.formResponse = function(data) {
		 switch(data.action) {
			case "edit":
				$("#projects3 span[rel='"+data.id+"'] .text").html($("#projects .item_date").val() + ' - ' +$("#projects .title").val());
					switch(data.access) {
						case "0":
							$("#projects3 .active-link .module-access-status").removeClass("module-access-active");
						break;
						case "1":
							$("#projects3 .active-link .module-access-status").addClass("module-access-active");
						break;
					}
					/*switch(data.status) {
						case "1":
							$("#projects3 .active-link .module-item-status").addClass("module-item-active").removeClass("module-item-active-stopped");
						break;
						case "2":
							$("#projects3 .active-link .module-item-status").addClass("module-item-active-stopped").removeClass("module-item-active");
						break;
						default:
							$("#projects3 .active-link .module-item-status").removeClass("module-item-active").removeClass("module-item-active-stopped");
					}*/
			break;
		}
	}
	
	
	this.poformOptions = { beforeSubmit: this.formProcess, dataType: 'json', success: this.formResponse };


	this.getDetails = function(moduleidx,liindex,list) {
		var id = $("#projects3 ul:eq("+moduleidx+") .module-click:eq("+liindex+")").attr("rel");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects/modules/phonecalls&request=getDetails&id="+id, success: function(data){
			$("#projects-right").html(data.html);
			
			if($('#checkedOut').length > 0) {
					$("#projects3 .active-link:visible .icon-checked-out").addClass('icon-checked-out-active');
				} else {
					$("#projects3 .active-link:visible .icon-checked-out").removeClass('icon-checked-out-active');
				}
			
			if(list == 0) {
				switch (data.access) {
					case "sysadmin": case "admin":
						projectsActions(0);
					break;
					case "guest":
						projectsActions(5);
					break;
				}
			} else {
				switch (data.access) {
					case "sysadmin": case "admin" :
						if(list == "<li></li>") {
							projectsActions(3);
						} else {
							projectsActions(0);
							$('#projects3').find('input.filter').quicksearch('#projects3 li');
						}
					break;
					case "guest":
						if(list == "<li></li>") {
							projectsActions();
						} else {
							projectsActions(5);
							$('#projects3').find('input.filter').quicksearch('#projects3 li');
						}
					break;
				}
				
			}
			initProjectsContentScrollbar();
			}
		});	
	}


	this.actionNew = function() {
		var module = this;
		var cid = $('#projects input[name="id"]').val()
		module.checkIn(cid);
	
		var id = $('#projects2 .module-click:visible').attr("rel");
		$.ajax({ type: "GET", url: "/", dataType: 'json', data: 'path=apps/projects/modules/phonecalls&request=createNew&id=' + id, cache: false, success: function(data){
			$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/projects/modules/phonecalls&request=getList&id="+id, success: function(list){
				$(".projects3-content:visible ul").html(list.html);
				var liindex = $(".projects3-content:visible .module-click").index($(".projects3-content:visible .module-click[rel='"+data.id+"']"));
				$(".projects3-content:visible .module-click:eq("+liindex+")").addClass('active-link');
				var moduleidx = $(".projects3-content").index($(".projects3-content:visible"));
				module.getDetails(moduleidx,liindex);
				$('#projects3 input.filter').quicksearch('#projects3 li');
				setTimeout(function() { $('#projects-right .focusTitle').trigger('click'); }, 800);
				}
			});
			}
		});
	}


	this.actionDuplicate = function() {
		var module = this;
		var cid = $('#projects input[name="id"]').val()
		module.checkIn(cid);
		var id = $("#projects3 .active-link:visible").attr("rel");
		var pid = $("#projects2 .module-click:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", data: 'path=apps/projects/modules/phonecalls&request=createDuplicate&id=' + id, cache: false, success: function(mid){
			$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/projects/modules/phonecalls&request=getList&id="+pid, success: function(data){																																																																				
				$(".projects3-content:visible ul").html(data.html);
				var moduleidx = $(".projects3-content").index($(".projects3-content:visible"));
				var liindex = $(".projects3-content:visible .module-click").index($(".projects3-content:visible .module-click[rel='"+mid+"']"));
				module.getDetails(moduleidx,liindex);
				$(".projects3-content:visible .module-click:eq("+liindex+")").addClass('active-link');
				$('#projects3 input.filter').quicksearch('#projects3 li');
				}
			});
			}
		});
	}
	
	
	this.actionBin = function() {
		var module = this;
		var cid = $('#projects input[name="id"]').val()
		module.checkIn(cid);
		var txt = ALERT_DELETE;
		var langbuttons = {};
		langbuttons[ALERT_YES] = true;
		langbuttons[ALERT_NO] = false;
		$.prompt(txt,{ 
			buttons:langbuttons,
			callback: function(v,m,f){		
				if(v){
					var id = $("#projects3 .active-link:visible").attr("rel");
					var pid = $("#projects2 .module-click:visible").attr("rel");
					$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/phonecalls&request=binPhonecall&id=" + id, cache: false, success: function(data){
							if(data == "true") {
								$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects/modules/phonecalls&request=getList&id="+pid, success: function(data){
									$(".projects3-content:visible ul").html(data.html);
									if(data.html == "<li></li>") {
										projectsActions(3);
									} else {
										projectsActions(0);
										$('#projects3 input.filter').quicksearch('#projects3 li');
									}
									var moduleidx = $(".projects3-content").index($(".projects3-content:visible"));
									var liindex = 0;
									module.getDetails(moduleidx,liindex);
									$("#projects3 .projects3-content:visible .module-click:eq("+liindex+")").addClass('active-link');
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
		$.ajax({ type: "GET", url: "/", async: false, data: 'path=apps/projects/modules/phonecalls&request=checkinPhonecall&id='+id, success: function(data){
			if(!data) {
				prompt("something wrong");
			}
			}
		});
	}
	
	
	this.actionRefresh = function() {
		var id = $("#projects3 .active-link:visible").attr("rel");
		var pid = $("#projects2 .module-click:visible").attr("rel");
		$("#projects3 .active-link:visible").trigger("click");
		var id = $("#projects3 .active-link:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/projects/modules/phonecalls&request=getList&id="+pid, success: function(data){																																																																				
			$(".projects3-content:visible ul").html(data.html);
			var liindex = $(".projects3-content:visible .module-click").index($(".projects3-content:visible .module-click[rel='"+id+"']"));
			$(".projects3-content:visible .module-click:eq("+liindex+")").addClass('active-link');
			$('#projects3 input.filter').quicksearch('#projects3 li');
			}
		});
	}


	this.actionPrint = function() {
		var id = $("#projects3 .active-link:visible").attr("rel");
		var url ='/?path=apps/projects/modules/phonecalls&request=printDetails&id='+id;
		location.href = url;
	}


	this.actionSend = function() {
		var id = $("#projects3 .active-link:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/phonecalls&request=getSend&id="+id, success: function(html){
			$("#modalDialogForward").html(html).dialog('open');
			}
		});
	}


	this.actionSendtoResponse = function() {
		var id = $("#projects3 .active-link:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/phonecalls&request=getSendtoDetails&id="+id, success: function(html){
			$("#projectsphonecall_sendto").html(html);
			$("#modalDialogForward").dialog('close');
			}
		});
	}
	
	
	this.sortclick = function (obj,sortcur,sortnew) {
		var module = this;
		var cid = $('#projects input[name="id"]').val()
		module.checkIn(cid);
		
		var fid = $("#projects2 .module-click:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/projects/modules/phonecalls&request=getList&id="+fid+"&sort="+sortnew, success: function(data){
			$(".projects3-content:visible ul").html(data.html);
			obj.attr("rel",sortnew);
			obj.removeClass("sort"+sortcur).addClass("sort"+sortnew);
			var id = $(".projects3-content:visible .module-click:eq(0)").attr("rel");
			if(id == undefined) {
				return false;
			}
			var moduleidx = $(".projects3-content").index($(".projects3-content:visible"));
			var liindex = 0;
			module.getDetails(moduleidx,liindex);
			$("#projects3 .projects3-content:visible .module-click:eq("+liindex+")").addClass('active-link');
		}
		});
	}


	this.sortdrag = function (order) {
		var fid = $("#projects2 .module-click:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/phonecalls&request=setOrder&"+order+"&id="+fid, success: function(html){
			$("#projects3 .sort:visible").attr("rel", "3");
			$("#projects3 .sort:visible").removeClass("sort1").removeClass("sort2").addClass("sort3");
			}
		});
	}


	/*this.toggleIntern = function(id,status,obj) {
		$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/phonecalls&request=toggleIntern&id=" + id + "&status=" + status, cache: false, success: function(data){
			if(data == "true") {
				obj.toggleClass("module-item-active")
			}
			}
		});
	}*/
	
	this.actionDialog = function(offset,request,field,append,title,sql) {
		switch(request) {
			case "getAccessDialog":
				$.ajax({ type: "GET", url: "/", data: 'path=apps/projects&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
					$("#modalDialog").html(html);
					//$("#modalDialog").dialog('option', 'height', 50);
					$("#modalDialog").dialog('option', 'position', offset);
					$("#modalDialog").dialog('option', 'title', title);
					$("#modalDialog").dialog('open');
					}
				});
			break;
			case "getPhonecallStatusDialog":
				$.ajax({ type: "GET", url: "/", data: 'path=apps/projects/modules/phonecalls&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
					$("#modalDialog").html(html);
					$("#modalDialog").dialog('option', 'position', offset);
					$("#modalDialog").dialog('option', 'title', title);
					$("#modalDialog").dialog('open');
					}
				});
			break;
			case "getDocumentsDialog":
				var id = $("#projects2 .module-click:visible").attr("rel");
				$.ajax({ type: "GET", url: "/", data: 'path=apps/projects/modules/documents&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql+'&id=' + id, success: function(html){
					$("#modalDialog").html(html);
					$("#modalDialog").dialog('option', 'position', offset);
					$("#modalDialog").dialog('option', 'title', title);
					$("#modalDialog").dialog('open');
					}
				});
			break;
			default:
			$.ajax({ type: "GET", url: "/", data: 'path=apps/projects&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
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


	this.insertStatus = function(rel,text) {
		var module = this;
		var html = '<div class="listmember" field="projectsphonecall_status" uid="'+rel+'" style="float: left">' + text + '</div>';
		$("#projectsphonecall_status").html(html);
		$("#modalDialog").dialog("close");
		$("#projectsphonecall_status").next().val("");
		$('#projects .coform').ajaxSubmit(module.poformOptions);
	}
	
	
	this.actionHelp = function() {
		var url = "/?path=apps/projects/modules/phonecalls&request=getHelp";
		$("#documentloader").attr('src', url);
	}
	
	
	// Recycle Bin
	this.binDelete = function(id) {
		var txt = ALERT_DELETE_REALLY;
		var langbuttons = {};
		langbuttons[ALERT_YES] = true;
		langbuttons[ALERT_NO] = false;
		$.prompt(txt,{ 
			buttons:langbuttons,
			callback: function(v,m,f){		
				if(v){
					$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/phonecalls&request=deletePhonecall&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#phonecall_'+id).slideUp();
						}
					}
					});
				} 
			}
		});
	}
	
	
	this.binRestore = function(id) {
		var txt = ALERT_RESTORE;
		var langbuttons = {};
		langbuttons[ALERT_YES] = true;
		langbuttons[ALERT_NO] = false;
		$.prompt(txt,{ 
			buttons:langbuttons,
			callback: function(v,m,f){		
				if(v){
					$.ajax({ type: "GET", url: "/", data: "path=apps/projects/modules/phonecalls&request=restorePhonecall&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#phonecall_'+id).slideUp();
						}
					}
					});
				} 
			}
		});
	}


}


var projects_phonecalls = new projectsPhonecalls('projects_phonecalls');