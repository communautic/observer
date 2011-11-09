/* orders Object */
function clientsOrders(name) {
	this.name = name;


	this.formProcess = function(formData, form, poformOptions) {
		var title = $("#clients input.title").fieldValue();
		if(title == "") {
			$.prompt(ALERT_NO_TITLE, {callback: setTitleFocus});
			return false;
		} else {
			formData[formData.length] = { "name": "title", "value": title };
		}
		
		formData[formData.length] = processDocListApps('documents');
		formData[formData.length] = processListApps('order_access');
		formData[formData.length] = processListApps('order_status');
	 }
	 
	 
	 this.formResponse = function(data) {
		 switch(data.action) {
			case "edit":
				//$("#clients3 span[rel='"+data.id+"'] .text").html($("#clients .item_date").val() + ' - ' +$("#clients .title").val());
					switch(data.access) {
						case "0":
							$("#clients3 .active-link .module-access-status").removeClass("module-access-active");
						break;
						case "1":
							$("#clients3 .active-link .module-access-status").addClass("module-access-active");
						break;
					}
					/*switch(data.status) {
						case "1":
							$("#clients3 .active-link .module-item-status").addClass("module-item-active").removeClass("module-item-active-stopped");
						break;
						case "2":
							$("#clients3 .active-link .module-item-status").addClass("module-item-active-stopped").removeClass("module-item-active");
						break;
						default:
							$("#clients3 .active-link .module-item-status").removeClass("module-item-active").removeClass("module-item-active-stopped");
					}*/
			break;
		}
	}
	
	
	this.poformOptions = { beforeSubmit: this.formProcess, dataType: 'json', success: this.formResponse };


	this.getDetails = function(moduleidx,liindex,list) {
		var id = $("#clients3 ul:eq("+moduleidx+") .module-click:eq("+liindex+")").attr("rel");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/clients/modules/orders&request=getDetails&id="+id, success: function(data){
			$("#clients-right").html(data.html);
			
			if($('#checkedOut').length > 0) {
					$("#clients3 .active-link:visible .icon-checked-out").addClass('icon-checked-out-active');
				} else {
					$("#clients3 .active-link:visible .icon-checked-out").removeClass('icon-checked-out-active');
				}
			
			if(list == 0) {
				switch (data.access) {
					case "sysadmin": case "admin":
						clientsActions(0);
					break;
					case "guest":
						clientsActions(5);
					break;
				}
			} else {
				switch (data.access) {
					case "sysadmin": case "admin" :
						if(list == "<li></li>") {
							clientsActions(3);
						} else {
							clientsActions(0);
							$('#clients3').find('input.filter').quicksearch('#clients3 li');
						}
					break;
					case "guest":
						if(list == "<li></li>") {
							clientsActions();
						} else {
							clientsActions(5);
							$('#clients3').find('input.filter').quicksearch('#clients3 li');
						}
					break;
				}
				
			}
			initClientsContentScrollbar();
			}
		});	
	}


	this.actionNew = function() {
		var module = this;
		var cid = $('#clients input[name="id"]').val()
		module.checkIn(cid);
	
		var id = $('#clients2 .module-click:visible').attr("rel");
		$.ajax({ type: "GET", url: "/", dataType: 'json', data: 'path=apps/clients/modules/orders&request=createNew&id=' + id, cache: false, success: function(data){
			$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/clients/modules/orders&request=getList&id="+id, success: function(list){
				$(".clients3-content:visible ul").html(list.html);
				var liindex = $(".clients3-content:visible .module-click").index($(".clients3-content:visible .module-click[rel='"+data.id+"']"));
				$(".clients3-content:visible .module-click:eq("+liindex+")").addClass('active-link');
				var moduleidx = $(".clients3-content").index($(".clients3-content:visible"));
				module.getDetails(moduleidx,liindex);
				$('#clients3 input.filter').quicksearch('#clients3 li');
				setTimeout(function() { $('#clients-right .focusTitle').trigger('click'); }, 800);
				}
			});
			}
		});
	}


	this.actionDuplicate = function() {
		var module = this;
		var cid = $('#clients input[name="id"]').val()
		module.checkIn(cid);
		var id = $("#clients3 .active-link:visible").attr("rel");
		var pid = $("#clients2 .module-click:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", data: 'path=apps/clients/modules/orders&request=createDuplicate&id=' + id, cache: false, success: function(mid){
			$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/clients/modules/orders&request=getList&id="+pid, success: function(data){																																																																				
				$(".clients3-content:visible ul").html(data.html);
				var moduleidx = $(".clients3-content").index($(".clients3-content:visible"));
				var liindex = $(".clients3-content:visible .module-click").index($(".clients3-content:visible .module-click[rel='"+mid+"']"));
				module.getDetails(moduleidx,liindex);
				$(".clients3-content:visible .module-click:eq("+liindex+")").addClass('active-link');
				$('#clients3 input.filter').quicksearch('#clients3 li');
				}
			});
			}
		});
	}
	
	
	this.actionBin = function() {
		var module = this;
		var cid = $('#clients input[name="id"]').val()
		module.checkIn(cid);
		var txt = ALERT_DELETE;
		var langbuttons = {};
		langbuttons[ALERT_YES] = true;
		langbuttons[ALERT_NO] = false;
		$.prompt(txt,{ 
			buttons:langbuttons,
			callback: function(v,m,f){		
				if(v){
					var id = $("#clients3 .active-link:visible").attr("rel");
					var pid = $("#clients2 .module-click:visible").attr("rel");
					$.ajax({ type: "GET", url: "/", data: "path=apps/clients/modules/orders&request=binOrder&id=" + id, cache: false, success: function(data){
							if(data == "true") {
								$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/clients/modules/orders&request=getList&id="+pid, success: function(data){
									$(".clients3-content:visible ul").html(data.html);
									if(data.html == "<li></li>") {
										clientsActions(3);
									} else {
										clientsActions(0);
										$('#clients3 input.filter').quicksearch('#clients3 li');
									}
									var moduleidx = $(".clients3-content").index($(".clients3-content:visible"));
									var liindex = 0;
									module.getDetails(moduleidx,liindex);
									$("#clients3 .clients3-content:visible .module-click:eq("+liindex+")").addClass('active-link');
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
		$.ajax({ type: "GET", url: "/", async: false, data: 'path=apps/clients/modules/orders&request=checkinOrder&id='+id, success: function(data){
			if(!data) {
				prompt("something wrong");
			}
			}
		});
	}
	
	
	this.actionRefresh = function() {
		var id = $("#clients3 .active-link:visible").attr("rel");
		var pid = $("#clients2 .module-click:visible").attr("rel");
		$("#clients3 .active-link:visible").trigger("click");
		var id = $("#clients3 .active-link:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/clients/modules/orders&request=getList&id="+pid, success: function(data){																																																																				
			$(".clients3-content:visible ul").html(data.html);
			var liindex = $(".clients3-content:visible .module-click").index($(".clients3-content:visible .module-click[rel='"+id+"']"));
			$(".clients3-content:visible .module-click:eq("+liindex+")").addClass('active-link');
			$('#clients3 input.filter').quicksearch('#clients3 li');
			}
		});
	}


	this.actionPrint = function() {
		var id = $("#clients3 .active-link:visible").attr("rel");
		var url ='/?path=apps/clients/modules/orders&request=printDetails&id='+id;
		location.href = url;
	}


	this.actionSend = function() {
		var id = $("#clients3 .active-link:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", data: "path=apps/clients/modules/orders&request=getSend&id="+id, success: function(html){
			$("#modalDialogForward").html(html).dialog('open');
			}
		});
	}


	this.actionSendtoResponse = function() {
		var id = $("#clients3 .active-link:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", data: "path=apps/clients/modules/orders&request=getSendtoDetails&id="+id, success: function(html){
			$("#clientsorder_sendto").html(html);
			$("#modalDialogForward").dialog('close');
			}
		});
	}
	
	
	this.sortclick = function (obj,sortcur,sortnew) {
		var module = this;
		var cid = $('#clients input[name="id"]').val()
		module.checkIn(cid);
		
		var fid = $("#clients2 .module-click:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/clients/modules/orders&request=getList&id="+fid+"&sort="+sortnew, success: function(data){
			$(".clients3-content:visible ul").html(data.html);
			obj.attr("rel",sortnew);
			obj.removeClass("sort"+sortcur).addClass("sort"+sortnew);
			var id = $(".clients3-content:visible .module-click:eq(0)").attr("rel");
			if(id == undefined) {
				return false;
			}
			var moduleidx = $(".clients3-content").index($(".clients3-content:visible"));
			var liindex = 0;
			module.getDetails(moduleidx,liindex);
			$("#clients3 .clients3-content:visible .module-click:eq("+liindex+")").addClass('active-link');
		}
		});
	}


	this.sortdrag = function (order) {
		var fid = $("#clients2 .module-click:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", data: "path=apps/clients/modules/orders&request=setOrder&"+order+"&id="+fid, success: function(html){
			$("#clients3 .sort:visible").attr("rel", "3");
			$("#clients3 .sort:visible").removeClass("sort1").removeClass("sort2").addClass("sort3");
			}
		});
	}


	/*this.toggleIntern = function(id,status,obj) {
		$.ajax({ type: "GET", url: "/", data: "path=apps/clients/modules/orders&request=toggleIntern&id=" + id + "&status=" + status, cache: false, success: function(data){
			if(data == "true") {
				obj.toggleClass("module-item-active")
			}
			}
		});
	}*/
	
	this.actionDialog = function(offset,request,field,append,title,sql) {
		switch(request) {
			case "getAccessDialog":
				$.ajax({ type: "GET", url: "/", data: 'path=apps/clients&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
					$("#modalDialog").html(html);
					//$("#modalDialog").dialog('option', 'height', 50);
					$("#modalDialog").dialog('option', 'position', offset);
					$("#modalDialog").dialog('option', 'title', title);
					$("#modalDialog").dialog('open');
					}
				});
			break;
			case "getOrderStatusDialog":
				$.ajax({ type: "GET", url: "/", data: 'path=apps/clients/modules/orders&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
					$("#modalDialog").html(html);
					$("#modalDialog").dialog('option', 'position', offset);
					$("#modalDialog").dialog('option', 'title', title);
					$("#modalDialog").dialog('open');
					}
				});
			break;
			case "getDocumentsDialog":
				var id = $("#clients2 .module-click:visible").attr("rel");
				$.ajax({ type: "GET", url: "/", data: 'path=apps/clients/modules/documents&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql+'&id=' + id, success: function(html){
					$("#modalDialog").html(html);
					$("#modalDialog").dialog('option', 'position', offset);
					$("#modalDialog").dialog('option', 'title', title);
					$("#modalDialog").dialog('open');
					}
				});
			break;
			default:
			$.ajax({ type: "GET", url: "/", data: 'path=apps/clients&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
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
		var html = '<div class="listmember" field="clientsorder_status" uid="'+rel+'" style="float: left">' + text + '</div>';
		$("#clientsorder_status").html(html);
		$("#modalDialog").dialog("close");
		$("#clientsorder_status").next().val("");
		$('#clients .coform').ajaxSubmit(module.poformOptions);
	}
	
	
	this.actionHelp = function() {
		var url = "/?path=apps/clients/modules/orders&request=getHelp";
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/clients/modules/orders&request=deleteOrder&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#order_'+id).slideUp();
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/clients/modules/orders&request=restoreOrder&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#order_'+id).slideUp();
						}
					}
					});
				} 
			}
		});
	}


}


var clients_orders = new clientsOrders('clients_orders');