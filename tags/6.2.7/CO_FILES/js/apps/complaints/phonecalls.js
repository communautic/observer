/* phonecalls Object */
function complaintsPhonecalls(name) {
	this.name = name;


	this.formProcess = function(formData, form, poformOptions) {
		var title = $("#complaints input.title").fieldValue();
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
				$("#complaints3 ul[rel=phonecalls] span[rel="+data.id+"] .text").html($("#complaints .item_date").val() + ' - ' +$("#complaints .title").val());
					switch(data.access) {
						case "0":
							$("#complaints3 ul[rel=phonecalls] span[rel="+data.id+"] .module-access-status").removeClass("module-access-active");
						break;
						case "1":
							$("#complaints3 ul[rel=phonecalls] span[rel="+data.id+"] .module-access-status").addClass("module-access-active");
						break;
					}
			break;
		}
	}
	
	
	this.poformOptions = { async: false, beforeSubmit: this.formProcess, dataType: 'json', success: this.formResponse };


	this.getDetails = function(moduleidx,liindex,list) {
		var id = $("#complaints3 ul:eq("+moduleidx+") .module-click:eq("+liindex+")").attr("rel");
		$('#complaints').data({ "third" : id});
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/complaints/modules/phonecalls&request=getDetails&id="+id, success: function(data){
			$("#complaints-right").html(data.html);
			
			if($('#checkedOut').length > 0) {
					$("#complaints3 ul[rel=phonecalls] .active-link .icon-checked-out").addClass('icon-checked-out-active');
				} else {
					$("#complaints3 ul[rel=phonecalls] .active-link .icon-checked-out").removeClass('icon-checked-out-active');
				}
			
			if(list == 0) {
				switch (data.access) {
					case "sysadmin": case "admin":
						complaintsActions(0);
					break;
					case "guest":
						complaintsActions(5);
					break;
				}
			} else {
				switch (data.access) {
					case "sysadmin": case "admin" :
						if(list == "<li></li>") {
							complaintsActions(3);
						} else {
							complaintsActions(0);
						}
					break;
					case "guest":
						if(list == "<li></li>") {
							complaintsActions();
						} else {
							complaintsActions(5);
						}
					break;
				}
				
			}
			initComplaintsContentScrollbar();
			}
		});	
	}


	this.actionNew = function() {
		var module = this;
		var cid = $('#complaints input[name="id"]').val()
		module.checkIn(cid);
	
		var id = $('#complaints').data('second');
		$.ajax({ type: "GET", url: "/", dataType: 'json', data: 'path=apps/complaints/modules/phonecalls&request=createNew&id=' + id, cache: false, success: function(data){
			$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/complaints/modules/phonecalls&request=getList&id="+id, success: function(list){
				$("#complaints3 ul[rel=phonecalls]").html(list.html);
				$('#complaints_phonecalls_items').html(list.items);
				var liindex = $("#complaints3 ul[rel=phonecalls] .module-click").index($("#complaints3 ul[rel=phonecalls] .module-click[rel='"+data.id+"']"));
				$("#complaints3 ul[rel=phonecalls] .module-click:eq("+liindex+")").addClass('active-link');
				var moduleidx = $("#complaints3 ul").index($("#complaints3 ul[rel=phonecalls]"));
				module.getDetails(moduleidx,liindex);
				setTimeout(function() { $('#complaints-right .focusTitle').trigger('click'); }, 800);
				}
			});
			}
		});
	}


	this.actionDuplicate = function() {
		var module = this;
		var cid = $('#complaints input[name="id"]').val()
		module.checkIn(cid);
		var id = $("#complaints").data("third");
		var pid = $("#complaints").data("second");
		$.ajax({ type: "GET", url: "/", data: 'path=apps/complaints/modules/phonecalls&request=createDuplicate&id=' + id, cache: false, success: function(mid){
			$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/complaints/modules/phonecalls&request=getList&id="+pid, success: function(data){																																																																				
				$("#complaints3 ul[rel=phonecalls]").html(data.html);
				$('#complaints_phonecalls_items').html(data.items);
				var moduleidx = $("#complaints3 ul").index($("#complaints3 ul[rel=phonecalls]"));
				var liindex = $("#complaints3 ul[rel=phonecalls] .module-click").index($("#complaints3 ul[rel=phonecalls] .module-click[rel='"+mid+"']"));
				module.getDetails(moduleidx,liindex);
				$("#complaints3 ul[rel=phonecalls] .module-click:eq("+liindex+")").addClass('active-link');
				}
			});
			}
		});
	}
	
	
	this.actionBin = function() {
		var module = this;
		var cid = $('#complaints input[name="id"]').val()
		module.checkIn(cid);
		var txt = ALERT_DELETE;
		var langbuttons = {};
		langbuttons[ALERT_YES] = true;
		langbuttons[ALERT_NO] = false;
		$.prompt(txt,{ 
			buttons:langbuttons,
			callback: function(v,m,f){		
				if(v){
					var id = $("#complaints").data("third");
					var pid = $("#complaints").data("second");
					$.ajax({ type: "GET", url: "/", data: "path=apps/complaints/modules/phonecalls&request=binPhonecall&id=" + id, cache: false, success: function(data){
							if(data == "true") {
								$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/complaints/modules/phonecalls&request=getList&id="+pid, success: function(data){
									$("#complaints3 ul[rel=phonecalls]").html(data.html);
									$('#complaints_phonecalls_items').html(data.items);
									if(data.html == "<li></li>") {
										complaintsActions(3);
									} else {
										complaintsActions(0);
									}
									var moduleidx = $("#complaints3 ul").index($("#complaints3 ul[rel=phonecalls]"));
									var liindex = 0;
									module.getDetails(moduleidx,liindex);
									$("#complaints3 ul[rel=phonecalls] .module-click:eq("+liindex+")").addClass('active-link');
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
		$.ajax({ type: "GET", url: "/", async: false, data: 'path=apps/complaints/modules/phonecalls&request=checkinPhonecall&id='+id, success: function(data){
			if(!data) {
				prompt("something wrong");
			}
			}
		});
	}
	
	
	this.actionRefresh = function() {
		var id = $("#complaints").data("third");
		var pid = $("#complaints").data("second");
		$("#complaints3 ul[rel=phonecalls] .active-link").trigger("click");
		$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/complaints/modules/phonecalls&request=getList&id="+pid, success: function(data){																																																																				
			$("#complaints3 ul[rel=phonecalls]").html(data.html);
			$('#complaints_phonecalls_items').html(data.items);
			var liindex = $("#complaints3 ul[rel=phonecalls] .module-click").index($("#complaints3 ul[rel=phonecalls] .module-click[rel='"+id+"']"));
			$("#complaints3 ul[rel=phonecalls] .module-click:eq("+liindex+")").addClass('active-link');
			}
		});
	}


	this.actionPrint = function() {
		var id = $("#complaints").data("third");
		var url ='/?path=apps/complaints/modules/phonecalls&request=printDetails&id='+id;
		$("#documentloader").attr('src', url);
	}


	this.actionSend = function() {
		var id = $("#complaints").data("third");
		$.ajax({ type: "GET", url: "/", data: "path=apps/complaints/modules/phonecalls&request=getSend&id="+id, success: function(html){
			$("#modalDialogForward").html(html).dialog('open');
			}
		});
	}


	this.actionSendtoResponse = function() {
		var id = $("#complaints").data("third");
		$.ajax({ type: "GET", url: "/", data: "path=apps/complaints/modules/phonecalls&request=getSendtoDetails&id="+id, success: function(html){
			$("#complaintsphonecall_sendto").html(html);
			$("#modalDialogForward").dialog('close');
			}
		});
	}
	
	
	this.sortclick = function (obj,sortcur,sortnew) {
		var module = this;
		var cid = $('#complaints input[name="id"]').val()
		module.checkIn(cid);
		
		var fid = $("#complaints2 .module-click:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/complaints/modules/phonecalls&request=getList&id="+fid+"&sort="+sortnew, success: function(data){
			$("#complaints3 ul[rel=phonecalls]").html(data.html);
			$('#complaints_phonecalls_items').html(data.items);
			obj.attr("rel",sortnew);
			obj.removeClass("sort"+sortcur).addClass("sort"+sortnew);
			var id = $("#complaints3 ul[rel=phonecalls] .module-click:eq(0)").attr("rel");
			$('#complaints').data('third',id);
			if(id == undefined) {
				return false;
			}
			var moduleidx = $("#complaints3 ul").index($("#complaints3 ul[rel=phonecalls]"));
			module.getDetails(moduleidx,0);
			$("#complaints3 ul[rel=phonecalls] .module-click:eq(0)").addClass('active-link');
		}
		});
	}


	this.sortdrag = function (order) {
		var fid = $("#complaints").data("second");
		$.ajax({ type: "GET", url: "/", data: "path=apps/complaints/modules/phonecalls&request=setOrder&"+order+"&id="+fid, success: function(html){
			$("#complaints3 .sort:visible").attr("rel", "3");
			$("#complaints3 .sort:visible").removeClass("sort1").removeClass("sort2").addClass("sort3");
			}
		});
	}


	this.actionDialog = function(offset,request,field,append,title,sql) {
		switch(request) {
			case "getAccessDialog":
				$.ajax({ type: "GET", url: "/", data: 'path=apps/complaints&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
					$("#modalDialog").html(html);
					//$("#modalDialog").dialog('option', 'height', 50);
					$("#modalDialog").dialog('option', 'position', offset);
					$("#modalDialog").dialog('option', 'title', title);
					$("#modalDialog").dialog('open');
					}
				});
			break;
			case "getPhonecallStatusDialog":
				$.ajax({ type: "GET", url: "/", data: 'path=apps/complaints/modules/phonecalls&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
					$("#modalDialog").html(html);
					$("#modalDialog").dialog('option', 'position', offset);
					$("#modalDialog").dialog('option', 'title', title);
					$("#modalDialog").dialog('open');
					}
				});
			break;
			case "getDocumentsDialog":
				var id = $("#complaints").data("second");
				$.ajax({ type: "GET", url: "/", data: 'path=apps/complaints/modules/documents&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql+'&id=' + id, success: function(html){
					$("#modalDialog").html(html);
					$("#modalDialog").dialog('option', 'position', offset);
					$("#modalDialog").dialog('option', 'title', title);
					$("#modalDialog").dialog('open');
					}
				});
			break;
			default:
			$.ajax({ type: "GET", url: "/", data: 'path=apps/complaints&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
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
		var html = '<div class="listmember" field="complaintsphonecall_status" uid="'+rel+'" style="float: left">' + text + '</div>';
		$("#complaintsphonecall_status").html(html);
		$("#modalDialog").dialog("close");
		$("#complaintsphonecall_status").next().val("");
		$('#complaints .coform').ajaxSubmit(module.poformOptions);
	}
	
	
	this.actionHelp = function() {
		var url = "/?path=apps/complaints/modules/phonecalls&request=getHelp";
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/complaints/modules/phonecalls&request=deletePhonecall&id=" + id, cache: false, success: function(data){
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/complaints/modules/phonecalls&request=restorePhonecall&id=" + id, cache: false, success: function(data){
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


var complaints_phonecalls = new complaintsPhonecalls('complaints_phonecalls');