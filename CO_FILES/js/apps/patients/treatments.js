/* treatments Object */
function patientsTreatments(name) {
	this.name = name;
	var self = this;
	this.isRefresh = false;
	this.askStatus = true;
	this.coPrintOptions = '';
	this.coSendToOptions = '';
	this.coPopupEditClass = 'popup-full';


	this.formProcess = function(formData, form, poformOptions) {
		var title = $("#patients input.title").fieldValue();
		if(title == "") {
			setTimeout(function() {
				title = $("#patients input.title").fieldValue();
				if(title == "") {
					$.prompt(ALERT_NO_TITLE, {submit: setTitleFocus});
				}
			}, 5000)
			return false;
		} else {
			formData[formData.length] = { "name": "title", "value": title };
		}
		
		$("#patientstreatmenttasks > div").each(function() {
			var id = $(this).attr('id');
			var reg = /[0-9]+/.exec(id);
			var yo = "task_text_"+reg;
			var namen = "task_text["+reg+"]";
			if($('#task_'+reg+' :input[name="task_text_'+reg+'"]').length > 0) {
				//var text = $('#'+yo).tinymce().getContent();
				var text = $('#'+yo).val();
				for (var i=0; i < formData.length; i++) { 
					if (formData[i].name == yo) { 
						formData[i].name = namen;
						formData[i].value = text;
					} 
				}
			} else {
				var text = $('#'+yo).html();
				formData[formData.length] = { "name": name, "value": text };
			}
		});
		
		/*$('#patients div.treatments_task_team_list').each(function() {
			var id = $(this).attr("id");
			var reg = /[0-9]+/.exec(id);
			formData[formData.length] = processListArray('treatments_task_team',reg);
		});*/
		
		/*$('#patients div.treatments_task_team_list_ct').each(function() {
			var id = $(this).attr("id");
			//var reg = /[0-9]+/.exec(id);
			formData[formData.length] = processCustomTextFieldArray(id);
		});*/
		
		$('#patients div.task_treatmenttype').each(function() {
			var id = $(this).attr("id");
			var reg = /[0-9]+/.exec(id);
			formData[formData.length] = processListArrayTwo('task_treatmenttype',reg);
		});
		
		/*$('#patients div.task_time_list').each(function() {
			var id = $(this).attr("id");
			var reg = /[0-9]+/.exec(id);
			var html = $(this).html();
			formData[formData.length] = { "name": "task_time["+reg+"]", "value": html };
		});
		
		$('#patients div.task_place_list').each(function() {
			var id = $(this).attr("id");
			var reg = /[0-9]+/.exec(id);
			formData[formData.length] = processListArray('task_place',reg);
		});*/
		
		/*$("#canvasDivText > div").each(function() {
			var id = $(this).attr('id');
			var reg = /[0-9]+/.exec(id);
			var yo = "canvasList_text_"+reg;
			var namen = "canvasList_text["+reg+"]";
			if($('#canvasList_'+reg+' :input[name="canvasList_text_'+reg+'"]').length > 0) {
				var text = $('#'+yo).val();
				for (var i=0; i < formData.length; i++) { 
					if (formData[i].name == yo) { 
						formData[i].name = namen;
						formData[i].value = text;
					} 
				}
			} else {
				var text = $('#'+yo).html();
				formData[formData.length] = { "name": name, "value": text };
			}
		});*/
		
		formData[formData.length] = processListApps('doctor');
		formData[formData.length] = processCustomTextApps('doctor_ct');
		formData[formData.length] = processListApps('method');
		formData[formData.length] = processListApps('treatment_access');
	 }
	 
	 
	 this.formResponse = function(data) {
		 var module = getCurrentModule();
		$("#patients3 ul[rel=treatments] span[rel="+data.id+"] .text").html($("#patients .item_date").val() + ' - ' +$("#patients .title").val());
		$("#protocol2_inactive").html($.nl2br($("#protocol2").val()));
		$("#sessioncount").text(data.updatestatus);
		switch(data.access) {
			case "0":
				$("#patients3 ul[rel=treatments] span[rel="+data.id+"] .module-access-status").removeClass("module-access-active");
			break;
			case "1":
				$("#patients3 ul[rel=treatments] span[rel="+data.id+"] .module-access-status").addClass("module-access-active");
			break;
		}
		var treatid = data.id;
		if(data.changeTreatmentStatus != "0" && module.askStatus && $('.jqibox').length == 0) {
			switch(data.changeTreatmentStatus) {
				case "1":
					var txt = ALERT_STATUS_TREATMENT_ACTIVATE;
					var button = 'inprogress';
				break;
				case "2":
					var txt = ALERT_STATUS_TREATMENT_COMPLETE;
					var button = 'finished';
				break;
			}
			var langbuttons = {};
			langbuttons[ALERT_YES] = true;
			langbuttons[ALERT_NO] = false;
			$.prompt(txt,{ 
				buttons:langbuttons,
				submit: function(e,v,m,f){		
					if(v){
						$.ajax({ type: "GET", url: "/", dataType:  'json', data: 'path=apps/patients/modules/treatments&request=updateStatus&id=' + treatid + '&date=&status='+data.changeTreatmentStatus, cache: false, success: function(data){
							switch(data.status) {
								case "2":
									$("#patients3 ul[rel=treatments] span[rel="+treatid+"] .module-item-status").addClass("module-item-active").removeClass("module-item-active-stopped");
									var pid = $("#patients").data("second");
									$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/patients/modules/invoices&request=getList&id="+pid, success: function(data){
										$('#patients_invoices_items').html(data.items);
										}
									});
								break;
								case "3":
									$("#patients3 ul[rel=treatments] span[rel="+treatid+"] .module-item-status").addClass("module-item-active-stopped").removeClass("module-item-active");
								break;
								default:
									$("#patients3 ul[rel=treatments] span[rel="+treatid+"] .module-item-status").removeClass("module-item-active").removeClass("module-item-active-stopped");
							}
							$('#patients span.statusButton').removeClass('active');
							$('#patients span.statusButton.'+button).addClass('active');
							var today = new Date();
							var statusdate = today.toString("dd.MM.yyyy");
							$('#patients-right input.statusdp').val(statusdate);
							if(data.changePatientStatus != 0) { module.setPatientStatus(data.changePatientStatus); }
							}
						});
					} else {
						module.askStatus = false;
					}
				}
			});
		}
	}


	this.poformOptions = { beforeSubmit: this.formProcess, dataType: 'json', success: this.formResponse };


	this.statusOnClose = function(dp) {
		var module = this;
		var id = $("#patients").data("third");
		var status = $("#patients .statusTabs li span.active").attr('rel');
		var date = $("#patients .statusTabs input").val();
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/patients/modules/treatments&request=updateStatus&id=" + id + "&date=" + date + "&status=" + status, cache: false, success: function(data){
				switch(data.status) {
					case "2":
						$("#patients3 ul[rel=treatments] span[rel="+data.id+"] .module-item-status").addClass("module-item-active").removeClass("module-item-active-stopped");
					break;
					case "3":
						$("#patients3 ul[rel=treatments] span[rel="+data.id+"] .module-item-status").addClass("module-item-active-stopped").removeClass("module-item-active");
					break;
					default:
						$("#patients3 ul[rel=treatments] span[rel="+data.id+"] .module-item-status").removeClass("module-item-active").removeClass("module-item-active-stopped");
				}
				if(data.changePatientStatus != 0) { module.setPatientStatus(data.changePatientStatus); }
				var pid = $("#patients").data("second");
				$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/patients/modules/invoices&request=getList&id="+pid, success: function(data){																																																																				
			$('#patients_invoices_items').html(data.items);
					}
				});
			}
		});
	}


	this.setPatientStatus = function(status) {
		var app = getCurrentApp();
		switch(status) {
			case "1":
				var txt = ALERT_STATUS_PATIENT_ACTIVATE;
			break;
			case "2":
				var txt = ALERT_STATUS_PATIENT_COMPLETE;
			break;
		}
		var langbuttons = {};
		langbuttons[ALERT_YES] = true;
		langbuttons[ALERT_NO] = false;
		$.prompt(txt,{ 
			buttons:langbuttons,
			submit: function(e,v,m,f){		
				if(v){
					var pid = $('#'+ app).data("second");
					$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/patients&request=updateStatus&id=" + pid + "&date=&status="+status, cache: false, success: function(data){
						switch(data.status) {
							case "0":
								$("#patients2 .active-link .module-item-status").addClass("module-item-active-trial").removeClass("module-item-active-circle");
							break;
							case "1":
								$("#patients2 .active-link .module-item-status").addClass("module-item-active-circle").removeClass("module-item-active-trial");
							break;
							default:
								$("#patients2 .active-link .module-item-status").removeClass("module-item-active-trial").removeClass("module-item-active-circle");
						}		
						}
					});
				} 
			}
		});
	}


	this.getDetails = function(moduleidx,liindex,list) {
		//loadDemand();
		//alert(this.coPrintOptions);
		if(self.coPrintOptions == '') {
			$.ajax({ type: "GET", url: "/", data: "path=apps/patients/modules/treatments&request=getPrintOptions", success: function(html){
				self.coPrintOptions = html;
			}});
		}
		if(self.coSendToOptions == '') {
			$.ajax({ type: "GET", url: "/", data: "path=apps/patients/modules/treatments&request=getSendToOptions", success: function(html){
				self.coSendToOptions = html;
			}});
		}
		this.askStatus = true;
		contexts = [];
		var id = $("#patients3 ul:eq("+moduleidx+") .module-click:eq("+liindex+")").attr("rel");
		$('#patients').data({ "third" : id});
		var tab = 0;
		if(this.isRefresh) {
			var activetab = $('#patients-right .contentTabsList li span.active');
			tab = $('#patients-right .contentTabsList li span').index(activetab);
			this.isRefresh = false;
		}
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/patients/modules/treatments&request=getDetails&id="+id, success: function(data){
			$("#patients-right").empty().html(data.html);
			
			/*if(tab != 0) { $('#patients-right .contentTabsList li span:eq('+tab+')').trigger('click'); }
			if(appTab) {
				$('#patients-right .contentTabsList li span:eq(0)').trigger('click');
				appTab = false;
			}*/
			
			if($('#checkedOut').length > 0) {
					$("#patients3 ul[rel=treatments] .active-link .icon-checked-out").addClass('icon-checked-out-active');
				} else {
					$("#patients3 ul[rel=treatments] .active-link .icon-checked-out").removeClass('icon-checked-out-active');
				}
			
			if(list == 0) {
				switch (data.access) {
					case "sysadmin": case "admin":
						patientsActions(0);
					break;
					case "guest":
						patientsActions(5);
					break;
				}
			} else {
				switch (data.access) {
					case "sysadmin": case "admin" :
						if(list == "<li></li>") {
							patientsActions(3);
						} else {
							patientsActions(0);
						}
					break;
					case "guest":
						if(list == "<li></li>") {
							patientsActions();
						} else {
							patientsActions(5);
						}
					break;
				}
				
			}
			initPatientsContentScrollbar();	
			/*if(data.html != '') {
				c = data.canvases;
				var j;
				var a;
				$.each(c, function(i, val) {
				  j = i+1;
				  a = "c"+j;
				  if(c[i].canvas != ""){
					  setImageParam(j,'data:image/png;base64,'+c[i].canvas);
					  restorePoints[a] = [];
					  restorePoint[a] = 'data:image/png;base64,'+c[i].canvas;
				  } else {
					 restorePoints[a] = [];
					 restorePoint[a] = '';
				  }
				});
				activeCanvas = $("#c1")[0];
				setTimeout(function(){
						initPatientsContentScrollbar();			
				},300)
				
			}*/
			}
		});	
	}


	this.actionNew = function() {
		var module = this;
		var cid = $('#patients input[name="id"]').val()
		module.checkIn(cid);
	
		var id = $('#patients').data('second');
		$.ajax({ type: "GET", url: "/", dataType: 'json', data: 'path=apps/patients/modules/treatments&request=createNew&id=' + id, cache: false, success: function(data){
			$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/patients/modules/treatments&request=getList&id="+id, success: function(list){
				$("#patients3 ul[rel=treatments]").html(list.html);
				$('#patients_treatments_items').html(list.items);
				var liindex = $("#patients3 ul[rel=treatments] .module-click").index($("#patients3 ul[rel=treatments] .module-click[rel='"+data.id+"']"));
				$("#patients3 ul[rel=treatments] .module-click:eq("+liindex+")").addClass('active-link');
				var moduleidx = $("#patients3 ul").index($("#patients3 ul[rel=treatments]"));
				module.getDetails(moduleidx,liindex);
				setTimeout(function() { $('#patients-right .focusTitle').trigger('click'); }, 800);
				}
			});
			}
		});
	}


	this.actionDuplicate = function() {
		var module = this;
		var cid = $('#patients input[name="id"]').val()
		module.checkIn(cid);
		var id = $("#patients").data("third");
		var pid = $("#patients").data("second");
		$.ajax({ type: "GET", url: "/", data: 'path=apps/patients/modules/treatments&request=createDuplicate&id=' + id, cache: false, success: function(mid){
			$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/patients/modules/treatments&request=getList&id="+pid, success: function(data){																																																																				
				$("#patients3 ul[rel=treatments]").html(data.html);
				$('#patients_treatments_items').html(data.items);
				var moduleidx = $("#patients3 ul").index($("#patients3 ul[rel=treatments]"));
				var liindex = $("#patients3 ul[rel=treatments] .module-click").index($("#patients3 ul[rel=treatments] .module-click[rel='"+mid+"']"));
				module.getDetails(moduleidx,liindex);
				$("#patients3 ul[rel=treatments] .module-click:eq("+liindex+")").addClass('active-link');
				}
			});
			}
		});
	}
	
	
	this.actionBin = function() {
		var module = this;
		var cid = $('#patients input[name="id"]').val()
		module.checkIn(cid);
		var txt = ALERT_DELETE;
		var langbuttons = {};
		langbuttons[ALERT_YES] = true;
		langbuttons[ALERT_NO] = false;
		$.prompt(txt,{ 
			buttons:langbuttons,
			submit: function(e,v,m,f){		
				if(v){
					var id = $("#patients").data("third");
					var pid = $("#patients").data("second");
					$.ajax({ type: "GET", url: "/", data: "path=apps/patients/modules/treatments&request=binTreatment&id=" + id, cache: false, success: function(data){
							if(data == "true") {
								$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/patients/modules/treatments&request=getList&id="+pid, success: function(data){
									$("#patients3 ul[rel=treatments]").html(data.html);
									$('#patients_treatments_items').html(data.items);
									if(data.html == "<li></li>") {
										patientsActions(3);
									} else {
										patientsActions(0);
									}
									var moduleidx = $("#patients3 ul").index($("#patients3 ul[rel=treatments]"));
									var liindex = 0;
									module.getDetails(moduleidx,liindex);
									$("#patients3 ul[rel=treatments] .module-click:eq("+liindex+")").addClass('active-link');
									}
								});
							}
						}
					});
				} 
			}
		});
	}


	this.actionLoadTab = function(what) {
		$('#PatientsTreatmentsTabsContent > div:visible').hide();
		$('#'+what).show();
		$('.elastic').elastic(); // need to init again
		initPatientsContentScrollbar();
	}


	this.checkIn = function(id) {
		$.ajax({ type: "GET", url: "/", async: false, data: 'path=apps/patients/modules/treatments&request=checkinTreatment&id='+id, success: function(data){
			if(!data) {
				prompt("something wrong");
			}
			}
		});
	}
	
	
	this.actionRefresh = function() {
		this.isRefresh = true;
		var id = $("#patients").data("third");
		var pid = $("#patients").data("second");
		$("#patients3 ul[rel=treatments] .active-link").trigger("click");
		$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/patients/modules/treatments&request=getList&id="+pid, success: function(data){																																																																				
			$("#patients3 ul[rel=treatments]").html(data.html);
			$('#patients_treatments_items').html(data.items);
			var liindex = $("#patients3 ul[rel=treatments] .module-click").index($("#patients3 ul[rel=treatments] .module-click[rel='"+id+"']"));
			$("#patients3 ul[rel=treatments] .module-click:eq("+liindex+")").addClass('active-link');
			}
		});
	}


	/*this.actionPrint = function() {
		var id = $("#patients").data("third");
		var url ='/?path=apps/patients/modules/treatments&request=printDetails&id='+id;
		if(!iOS()) {
			$("#documentloader").attr('src', url);
		} else {
			window.open(url);
		}
	}*/
	
	this.actionPrintOption = function(option) {
		switch(option) {
			case '1':
				var id = $("#patients").data("third");
				var url ='/?path=apps/patients/modules/treatments&request=printDetails&option=plan&id='+id;
				if(!iOS()) {
					$("#documentloader").attr('src', url);
				} else {
					window.open(url);
				}
			break;
			case '2':
				var id = $("#patients").data("third");
				var url ='/?path=apps/patients/modules/treatments&request=printDetails&option=list&id='+id;
				if(!iOS()) {
					$("#documentloader").attr('src', url);
				} else {
					window.open(url);
				}
			break;
			case '3':
				var id = $("#patients").data("third");
				var url ='/?path=apps/patients/modules/treatments&request=printDetails&option=docu&id='+id;
				if(!iOS()) {
					$("#documentloader").attr('src', url);
				} else {
					window.open(url);
				}
			break;
		}
	}
	
	this.actionPrint = function() {
		var id = $("#patients").data("third");
		//var url ='/?path=apps/patients/modules/invoices&request=printDetails&id='+id;
		//$("#documentloader").attr('src', url);
		var copopup = $('#co-splitActions');
		var pclass = this.coPopupEditClass;
		copopup.html(this.coPrintOptions);
		copopup
			.removeClass(function (index, css) {
				   return (css.match (/\bpopup-\w+/g) || []).join(' ');
			   })
			.addClass(pclass)
			.position({
				  my: "center center",
				  at: "right+123 center",
				  of: '#patientsActions .listPrint',
				  collision: 'flip fit',
				  within: '#patients-right .scroll-pane',
				  using: function(coords, ui) {
						var $modal = $(this),
						t = coords.top,
						l = coords.left,
						className = 'switch-' + ui.horizontal;
						$modal.css({
							left: l + 'px',
							top: t + 'px'
						}).removeClass(function (index, css) {
							return (css.match (/\bswitch-\w+/g) || []).join(' ');
						})
						.addClass(className);
						copopup.hide().animate({width:'toggle'}, function() { 
							//copopup.find('.arrow').offset({ top: ui.target.top+25 });
							var arrowtop = Math.round(ui.target.top - ui.element.top)+20;
							copopup.find('.arrow').css('top', arrowtop); 
						})
				}
			});
	}


	/*this.actionSend = function() {
		var id = $("#patients").data("third");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/patients/modules/treatments&request=getSend&id="+id, success: function(data){
			$("#modalDialogForward").html(data.html).dialog('open');
			if(data.error == 1) {
				$.prompt('<div style="text-align: center">' + ALERT_REMOVE_RECIPIENT + data.error_message + '<br /></div>');
				return false;
			}
			}
		});
	}*/
	
	this.actionSendToOption = function(option) {
		switch(option) {
			case '1':
				var id = $("#patients").data("third");
				$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/patients/modules/treatments&request=getSend&option=plan&id="+id, success: function(data){
					$("#modalDialogForward").html(data.html).dialog('open');
					if(data.error == 1) {
						$.prompt('<div style="text-align: center">' + ALERT_REMOVE_RECIPIENT + data.error_message + '<br /></div>');
						return false;
					}
					}
				});
			break;
			case '2':
				var id = $("#patients").data("third");
				$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/patients/modules/treatments&request=getSend&option=list&id="+id, success: function(data){
					$("#modalDialogForward").html(data.html).dialog('open');
					if(data.error == 1) {
						$.prompt('<div style="text-align: center">' + ALERT_REMOVE_RECIPIENT + data.error_message + '<br /></div>');
						return false;
					}
					}
				});
				case '3':
				var id = $("#patients").data("third");
				$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/patients/modules/treatments&request=getSend&option=docu&id="+id, success: function(data){
					$("#modalDialogForward").html(data.html).dialog('open');
					if(data.error == 1) {
						$.prompt('<div style="text-align: center">' + ALERT_REMOVE_RECIPIENT + data.error_message + '<br /></div>');
						return false;
					}
					}
				});
			break;
		}
	}
	
	this.actionSend = function() {
		var id = $("#patients").data("third");
		//var url ='/?path=apps/patients/modules/invoices&request=printDetails&id='+id;
		//$("#documentloader").attr('src', url);
		var copopup = $('#co-splitActions');
		var pclass = this.coPopupEditClass;
		copopup.html(this.coSendToOptions);
		copopup
			.removeClass(function (index, css) {
				   return (css.match (/\bpopup-\w+/g) || []).join(' ');
			   })
			.addClass(pclass)
			.position({
				  my: "center center",
				  at: "right+123 center",
				  of: '#patientsActions .listSend',
				  collision: 'flip fit',
				  within: '#patients-right .scroll-pane',
				  using: function(coords, ui) {
						var $modal = $(this),
						t = coords.top,
						l = coords.left,
						className = 'switch-' + ui.horizontal;
						$modal.css({
							left: l + 'px',
							top: t + 'px'
						}).removeClass(function (index, css) {
							return (css.match (/\bswitch-\w+/g) || []).join(' ');
						})
						.addClass(className);
						copopup.hide().animate({width:'toggle'}, function() { 
							//copopup.find('.arrow').offset({ top: ui.target.top+25 });
							var arrowtop = Math.round(ui.target.top - ui.element.top)+20;
							copopup.find('.arrow').css('top', arrowtop); 
						})
				}
			});
	}



	this.actionSendtoResponse = function() {
		var id = $("#patients").data("third");
		$.ajax({ type: "GET", url: "/", data: "path=apps/patients/modules/treatments&request=getSendtoDetails&id="+id, success: function(html){
			$("#patientstreatment_sendto").html(html);
			//$("#modalDialogForward").dialog('close');
			}
		});
	}
	
	
	this.sortclick = function (obj,sortcur,sortnew) {
		var module = this;
		var cid = $('#patients input[name="id"]').val()
		module.checkIn(cid);
		
		var fid = $("#patients2 .module-click:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/patients/modules/treatments&request=getList&id="+fid+"&sort="+sortnew, success: function(data){
			$("#patients3 ul[rel=treatments]").html(data.html);
			$('#patients_treatments_items').html(data.items);
			obj.attr("rel",sortnew);
			obj.removeClass("sort"+sortcur).addClass("sort"+sortnew);
			var id = $("#patients3 ul[rel=treatments] .module-click:eq(0)").attr("rel");
			$('#patients').data('third',id);
			if(id == undefined) {
				return false;
			}
			var moduleidx = $("#patients3 ul").index($("#patients3 ul[rel=treatments]"));
			module.getDetails(moduleidx,0);
			$("#patients3 ul[rel=treatments] .module-click:eq(0)").addClass('active-link');
		}
		});
	}


	this.sortdrag = function (order) {
		var fid = $("#patients").data("second");
		$.ajax({ type: "GET", url: "/", data: "path=apps/patients/modules/treatments&request=setOrder&"+order+"&id="+fid, success: function(html){
			$("#patients3 .sort:visible").attr("rel", "3");
			$("#patients3 .sort:visible").removeClass("sort1").removeClass("sort2").addClass("sort3");
			}
		});
	}


	this.actionDialog = function(offset,request,field,append,title,sql) {
		switch(request) {
			case "getAccessDialog":
				$.ajax({ type: "GET", url: "/", data: 'path=apps/patients&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
					$("#modalDialog").html(html);
					//$("#modalDialog").dialog('option', 'height', 50);
					$("#modalDialog").dialog('option', 'position', offset);
					$("#modalDialog").dialog('option', 'title', title);
					$("#modalDialog").dialog('open');
					}
				});
			break;
			case "getTreatmentStatusDialog":
				$.ajax({ type: "GET", url: "/", data: 'path=apps/patients/modules/treatments&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
					$("#modalDialog").html(html);
					$("#modalDialog").dialog('option', 'position', offset);
					$("#modalDialog").dialog('option', 'title', title);
					$("#modalDialog").dialog('open');
					}
				});
			break;
			case "getTreatmentsTypeDialog":
				$.ajax({ type: "GET", url: "/", data: 'path=apps/patients/modules/treatments&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
					$("#modalDialog").html(html);
					$("#modalDialog").dialog('option', 'position', offset);
					$("#modalDialog").dialog('option', 'title', title);
					$("#modalDialog").dialog('open');
					}
				});
			break;
			case "getTreatmentsMethodDialog":
				$.ajax({ type: "GET", url: "/", data: 'path=apps/patients/modules/treatments&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
					$("#modalDialog").html(html);
					$("#modalDialog").dialog('option', 'position', offset);
					$("#modalDialog").dialog('option', 'title', title);
					$("#modalDialog").dialog('open');
					}
				});
			break;
			case "getDocumentsDialog":
				var id = $("#patients").data("second");
				$.ajax({ type: "GET", url: "/", data: 'path=apps/patients/modules/documents&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql+'&id=' + id, success: function(html){
					$("#modalDialog").html(html);
					$("#modalDialog").dialog('option', 'position', offset);
					$("#modalDialog").dialog('option', 'title', title);
					$("#modalDialog").dialog('open');
					}
				});
			break;
			default:
			$.ajax({ type: "GET", url: "/", data: 'path=apps/patients&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
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
	
	
	this.showItemContext = function(ele,uid,field) {
		var module = this;
		//var id = $("#"+field).val();
		if(ele.attr('edit') == 1) {
		$.ajax({ type: "GET", url: "/", data: 'path=apps/patients/modules/treatments&request=getTaskContext&id='+uid+'&field='+field, success: function(html){
			ele.parent().append(html);
			ele.next().slideDown();
			}
		});
		}
	}

	this.insertStatus = function(rel,text) {
		var module = this;
		var html = '<div class="listmember" field="patientstreatment_status" uid="'+rel+'" style="float: left">' + text + '</div>';
		$("#patientstreatment_status").html(html);
		$("#modalDialog").dialog("close");
		$("#patientstreatment_status").next().val("");
		$('#patients .coform').ajaxSubmit(module.poformOptions);
	}


	this.insertStatusDate = function(rel,text) {
		var html = '<div class="listmember" field="patientstreatment_status" uid="'+rel+'" style="float: left">' + text + '</div>';
		$("#patientstreatment_status").html(html);
		$("#modalDialog").dialog("close");
		$("#patientstreatment_status").nextAll('img').trigger('click');
	}
	
	
	this.insertFromDialog = function(field,gid,title) {
		if(field == 'treatmentsmethod') {
			var html = '<span class="listmember-outer"><span class="listmember" uid="' + gid + '" field="'+field+'">' + title + '</span></div>';
		} else {
			var html = '<span class="listmember-outer"><span class="listmember listmemberTreatmentType" uid="' + gid + '" field="'+field+'">' + title + '</span></div>';
		}
		$("#"+field).html(html);
		$("#modalDialog").dialog('close');
		var obj = getCurrentModule();
		$('#patients .coform').ajaxSubmit(obj.poformOptions);
		// get minutes
		if(field != 'treatmentsmethod') {
		var id = /[0-9]+/.exec(field);
		$.ajax({ type: "GET", url: "/", data: "path=apps/patients/modules/treatments&request=getTreatmentTypeMin&id=" + gid, success: function(html){
			$('#minutes_'+id).html(html);
			
			}
		});
		}
	}


	this.newItem = function() {
		var module = this;
		var pid = $("#patients").data("second");
		var mid = $("#patients").data("third");
		var num = $("#patientstreatmenttasks>div").length;
		$.ajax({ type: "GET", url: "/", data: "path=apps/patients/modules/treatments&request=addTask&pid=" + pid + "&mid=" + mid + "&num=" + num + "&sort=" + num, success: function(html){
			$('#patientstreatmenttasks').append(html);
			var idx = parseInt($('#patientstreatmenttasks .cbx').size() -1);
			//console.log(idx);
			var element = $('.cbx:eq('+idx+')');
			$.jNice.CheckAddPO(element);
			$('.treatmenttaskouter:eq('+idx+')').slideDown(function() {
				$(this).find(":text:eq(0)").focus();
				initPatientsContentScrollbar();
				 //module.calculateTasks();
				 module.askStatus = true;
			});
			}
		});
	}

	this.removeItem = function(clicked,field) {
		var module = this;
		//alert(field);
		clicked.parent().parent().fadeOut();
		clicked.parent().parent().prev().toggleClass('deletefromlist');
		clicked.parents(".listmember-outer").hide();
		if($("#"+field+" .listmember-outer:visible").length > 0) {
		var text = $("#"+field+" .listmember-outer:visible:last .showItemContext").html();
		var textnew = text.split(", ");
		$("#"+field+" .listmember-outer:visible:last .showItemContext").html(textnew[0]);
		}
		var tid = field.replace(/task_treatmenttype_/, "");
			var tcosts = 0;
			var tmins = 0;
			$("#"+field).find('.showItemContext:visible').each(function() {
				tcosts += parseFloat($(this).attr('costs'));
				tmins += parseInt($(this).attr('minutes'));
			})
			//$("#costs_"+tid).text(tcosts).number( true, 2, ',', '.' );
			tcosts = $.number( tcosts, 2, ',', '.' );
			$("#costs_"+tid).text(tcosts);
			$("#minutes_"+tid).text(tmins);
			
			
			var totalcosts = 0;
			$("#patients-right").find('.showItemContext:visible').each(function() {
				totalcosts += parseFloat($(this).attr('costs'));
			})
			var discount = parseInt($('#discount').val());
			if(discount != 0 && totalcosts != 0) {
				totalcosts = totalcosts - ((totalcosts/100)*discount);
			}
			totalcosts = $.number( totalcosts, 2, ',', '.' );
			$("#totalcosts").text(totalcosts);
			
		//var obj = getCurrentModule();
		$('#patients .coform').ajaxSubmit(module.poformOptions);
	}

	this.binItem = function(id) {
		var module = this;
		var txt = ALERT_DELETE;
		var langbuttons = {};
		langbuttons[ALERT_YES] = true;
		langbuttons[ALERT_NO] = false;
		$.prompt(txt,{ 
			buttons:langbuttons,
			submit: function(e,v,m,f){		
				if(v){
				$.ajax({ type: "GET", url: "/", data: "path=apps/patients/modules/treatments&request=deleteTask&id=" + id, success: function(data){
					if(data){
						$("#task_"+id).slideUp(function(){ $(this).remove(); 
																		  //module.calculateTasks();
																		  });
						
					} 
					}
				});
				} 
			}
		});
	}
	
	
	/*this.newDrawing = function() {
		var module = this;
		var mid = $("#patients").data("third");
		zIndexes++;
		var curnum = $('#patients .canvasDraw').size();
		var curcol = curnum % 10;
		var num = curnum+1;
		$.ajax({ type: "GET", url: "/", data: "path=apps/patients/modules/treatments&request=addDiagnose&mid=" + mid + "&num=" + num, success: function(id){
			//$('div.loadCanvas').removeClass('active');
			$('div.loadCanvasList .tcell-right').removeClass('active');
			var html = '<canvas class="canvasDraw" id="c'+num+'" width="400" height="400" style="z-index: '+num+'" rel="'+id+'"></canvas><div id="dia-'+id+'" style="position: absolute; width: 30px; height: 30px; z-index: '+zIndexes+'; top: '+30*num+'px; left: 30px;" class="loadCanvas active" rel="'+num+'"><div class="circle circle'+curcol+'"><div>'+num+'</div></div></div>';
			var htmltext = '<div id="canvasList_'+id+'" class="treatmentouter loadCanvasList" rel="'+num+'"><table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-protocol"><tr><td style="width: 31px; padding-left: 9px;"><span class="selectTextarea"><span><div class="circle  circle'+curcol+'"><div>'+num+'</div></div></span></span></td><td class="tcell-right active"><textarea name="canvasList_text['+id+']" class="elastic"></textarea><input name="canvasList_id['+id+']" type="hidden" value="'+id+'" /></td><td width="30"><a class="binDiagnose" rel="'+id+'"><span class="icon-delete"></span></a></td></tr></table></div>';
			$('#patients .canvasDiv').append(html);
			$('#canvasDivText').append(htmltext);
			a = 'c'+num;
			activeCanvas = $("#c"+num)[0];
			restorePoints[a] = [];
			$('span.undoTool').removeClass('active');
			if(!$('span.penTool').hasClass('active')) {
				!$('span.penTool').addClass('active');
				$('span.erasorTool').removeClass('active');
			}
			initPatientsContentScrollbar();
			}
		});		
	}*/
	
	/*this.saveDrawing = function(id,img) {
		var imgsave = '';
		if(img != '') {
			imgsave = img.replace(/^data:image\/png;base64,/, "");
			//window.open(img);
		}
		var module = this;
		$.ajax({ type: "POST", url: "/", data: "path=apps/patients/modules/treatments&request=saveDrawing&id=" + id + "&img=" + imgsave, success: function(id){
			}
		});		
	}*/


	this.binDiagnose = function(id) {
		var module = this;
		var txt = ALERT_DELETE;
		var langbuttons = {};
		langbuttons[ALERT_YES] = true;
		langbuttons[ALERT_NO] = false;
		$.prompt(txt,{ 
			buttons:langbuttons,
			submit: function(e,v,m,f){		
				if(v){
				$.ajax({ type: "GET", url: "/", data: "path=apps/patients/modules/treatments&request=deleteTask&id=" + id, success: function(data){
					if(data){
						$("#task_"+id).slideUp(function(){ $(this).remove(); 
																		  //module.calculateTasks(); 
																		  });
						
					} 
					}
				});
				} 
			}
		});
	}
	
	this.actionHelp = function() {
		var url = "/?path=apps/patients/modules/treatments&request=getHelp";
		if(!iOS()) {
			$("#documentloader").attr('src', url);
		} else {
			window.open(url);
		}
	}
	
	// Recycle Bin
	this.binDelete = function(id) {
		var txt = ALERT_DELETE_REALLY;
		var langbuttons = {};
		langbuttons[ALERT_YES] = true;
		langbuttons[ALERT_NO] = false;
		$.prompt(txt,{ 
			buttons:langbuttons,
			submit: function(e,v,m,f){		
				if(v){
					$.ajax({ type: "GET", url: "/", data: "path=apps/patients/modules/treatments&request=deleteTreatment&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#treatment_'+id).slideUp();
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
			submit: function(e,v,m,f){		
				if(v){
					$.ajax({ type: "GET", url: "/", data: "path=apps/patients/modules/treatments&request=restoreTreatment&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#treatment_'+id).slideUp();
						}
					}
					});
				} 
			}
		});
	}


	this.binDeleteItem = function(id) {
		var txt = ALERT_DELETE_REALLY;
		var langbuttons = {};
		langbuttons[ALERT_YES] = true;
		langbuttons[ALERT_NO] = false;
		$.prompt(txt,{ 
			buttons:langbuttons,
			submit: function(e,v,m,f){		
				if(v){
					$.ajax({ type: "GET", url: "/", data: "path=apps/patients/modules/treatments&request=deleteTreatmentTask&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#treatment_task_'+id).slideUp();
						}
					}
					});
				} 
			}
		});
	}
	
	
	this.binRestoreItem = function(id) {
		var txt = ALERT_RESTORE;
		var langbuttons = {};
		langbuttons[ALERT_YES] = true;
		langbuttons[ALERT_NO] = false;
		$.prompt(txt,{ 
			buttons:langbuttons,
			submit: function(e,v,m,f){		
				if(v){
					$.ajax({ type: "GET", url: "/", data: "path=apps/patients/modules/treatments&request=restoreTreatmentTask&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#treatment_task_'+id).slideUp();
						}
					}
					});
				} 
			}
		});
	}
	
this.binDeleteColumn = function(id) {
		var txt = ALERT_DELETE_REALLY;
		var langbuttons = {};
		langbuttons[ALERT_YES] = true;
		langbuttons[ALERT_NO] = false;
		$.prompt(txt,{ 
			buttons:langbuttons,
			submit: function(e,v,m,f){		
				if(v){
					$.ajax({ type: "GET", url: "/", data: "path=apps/patients/modules/treatments&request=deleteTreatmentDiagnose&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#treatment_diag_'+id).slideUp();
						}
					}
					});
				} 
			}
		});
	}

	this.binRestoreColumn = function(id) {
		var txt = ALERT_RESTORE;
		var langbuttons = {};
		langbuttons[ALERT_YES] = true;
		langbuttons[ALERT_NO] = false;
		$.prompt(txt,{ 
			buttons:langbuttons,
			submit: function(e,v,m,f){		
				if(v){
					$.ajax({ type: "GET", url: "/", data: "path=apps/patients/modules/treatments&request=restoreTreatmentDiagnose&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#treatment_diag_'+id).slideUp();
						}
					}
					});
				} 
			}
		});
	}


	this.manageCheckpoint = function(action,date) {
		var pid = $('#patients').data('third');
		switch(action) {
			case 'new':
				$.ajax({ type: "GET", url: "/", data: "path=apps/patients/modules/treatments&request=newCheckpoint&id=" + pid + "&date=" + date, cache: false });
			break;
			case 'update':
				$.ajax({ type: "GET", url: "/", data: "path=apps/patients/modules/treatments&request=updateCheckpoint&id=" + pid + "&date=" + date, cache: false });			
			break;
			case 'delete':
				$.ajax({ type: "GET", url: "/", data: "path=apps/patients/modules/treatments&request=deleteCheckpoint&id=" + pid, cache: false });
			break;
		}
	}
	
	this.saveCheckpointText = function() {
		var pid = $('#patients').data('third');
		var text = $('#patients_treatmentsCheckpoint textarea').val();
		$.ajax({ type: "POST", url: "/", data: "path=apps/patients/modules/treatments&request=updateCheckpointText&id=" + pid + "&text=" + text, cache: false });
	}
	
	/*this.calculateTasks = function() {
		var total = 0;
		var num = $('#PatientsTreatmentsThird .answers-outer-dynamic').size()*10;
		$('#PatientsTreatmentsThird .answers-outer-dynamic span').each( function() {
			 if($(this).hasClass('active'))	{
				 total = total + parseInt($(this).html());
			 }
		})
		if(num != 0) {
			var res = Math.round(100/num*total);
		}
		$('#tab3result').html(res);
	}*/
	
}

var patients_treatments = new patientsTreatments('patients_treatments');

var zIndexes = 0;
var restorePoints = [];
var restorePoint = [];
var activeCanvas;
var c;
var j;
var a;
var colors = ['#3C4664','#EB4600','#915500','#0A960A','#AA19AA','#3C4664','#EB4600','#915500','#0A960A','#AA19AA'];

	function setImage(dataURL) {  
		var img = new Image();  
		img.onload = function() {
			var context = activeCanvas.getContext("2d");
			//context.clearRect(0, 0, 400, 400);
			context.drawImage(img, 0, 0);
		}  
		img.src = dataURL; 
	}  
	
	function setImageParam(j,dataURL) {  
		var img = new Image();  
		img.onload = function() {
			var context = $("#c"+j)[0].getContext("2d");
			context.drawImage(img, 0, 0);
		}  
		img.src = dataURL; 
	}  
	
	
	function treatmentsSelect(field,str,value) {
		closedialog = 0;
		str = str.split(",");
		var id = str[0];
		var costs = str[1];
		var minutes = str[2];
		var html = '<span class="listmember-outer"><a href="patients_treatments" class="showItemContext" edit="1" uid="' + id + '" field="'+field+'" costs="'+costs+'" minutes="'+minutes+'">' + value + '</a>';
		var app = getCurrentApp();
		var obj = getCurrentModule();
			if($("#"+field).html() != "") {
				$("#"+field+" .showItemContext:visible:last").append(", ");
			}
			$("#"+field).append(html);
			
			// recalc
			var tid = field.replace(/task_treatmenttype_/, "");
			var tcosts = 0;
			var tmins = 0;
			$("#"+field).find('.showItemContext:visible').each(function() {
				tcosts += parseFloat($(this).attr('costs'));
				tmins += parseInt($(this).attr('minutes'));
			})
			//$("#costs_"+tid).text(tcosts).number( true, 2, ',', '.' );
			//$("#costs_"+tid).text(tcosts);
			tcosts = $.number( tcosts, 2, ',', '.' );
			$("#costs_"+tid).text(tcosts);
			$("#minutes_"+tid).text(tmins);
			
			var totalcosts = 0;
			$("#patients-right").find('.showItemContext:visible').each(function() {
				totalcosts += parseFloat($(this).attr('costs'));
			})
			var discount = parseInt($('#discount').val());
			if(discount != 0 && totalcosts != 0) {
				totalcosts = totalcosts - ((totalcosts/100)*discount);
			}
			totalcosts = $.number( totalcosts, 2, ',', '.' );
			$("#totalcosts").text(totalcosts);
			
			
			$('#'+app+' .coform').ajaxSubmit(obj.poformOptions);
			$.ajax({ type: "GET", url: "/", data: "path=apps/patients/modules/treatments&request=saveLastUsedTreatments&id="+id}); 
			
	}
	

	$(document).ready(function () {
		
		
		$(document).on('click','.loadCalendarEvent',function(e) {
			e.preventDefault();
			var href = $(this).attr('rel').split(",");
			externalLoadCalendar(href[0],href[1],href[2],href[3]);
			editEventID = href[4];
			if($('#event_'+editEventID).length > 0) {
				//$('#event_'+editEventID).addClass('fc-event-treatment-active');
				$('#event_'+editEventID+' .fc-event-treatment-icon').css('background-color','#BBFF00')
			}
			//setTimeout(function() { $('#event_'+href[4]).trigger('click') }, 1000)
		})
		
		
		
		// autocomplete contacts search
	$('.treatments-search').livequery(function() { 
		$(this).autocomplete({
			appendTo: '#tabs-1',
			source: "?path=apps/patients/modules/treatments&request=getTreatmentsSearch",
			//minLength: 2,
			select: function(event, ui) {
				var field = $(this).attr("field");
				treatmentsSelect(field, ui.item.id, ui.item.value);
			},
			close: function(event, ui) {
				$(this).val("");
			}
		});
	});
		
		
		/*$("div.loadCanvas").livequery( function() {
			$(this).each(function(){
				tmp = $(this).css('z-index');
				if(tmp>zIndexes) zIndexes = tmp;
			})						  
		})	*/						  
		
		/*$('div.loadCanvas.active').livequery( function() {
			$(this).draggable({
				containment:"parent",
				cursor: 'move',
				stop: function(e,ui){
					var x = Math.round(ui.position.left);
					var y = Math.round(ui.position.top);
					var id = $(this).attr("id").replace(/dia-/, "");
					$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/patients/modules/treatments&request=updatePosition&id="+id+"&x="+x+"&y="+y, success: function(data){
						}
					});
				}
			});
		});*/

		/*$(document).on('click','div.loadCanvas',function(e) {
			e.preventDefault();
			//var rel = $(this).attr('rel');
			var id = $(this).attr("id").replace(/dia-/, "");
			$('#canvasList_'+id).trigger('click');
		})*/

		/*$(document).on('click','.loadCanvasList',function(e) {
			e.preventDefault();
			var rel = $(this).attr('rel');
			var id = $(this).attr("id").replace(/canvasList_/, "");
			activeCanvas = $("#c"+rel)[0];
			//activeCanvas.globalCompositeOperation = "source-over";
			zIndexes = ++zIndexes;
			$('div.loadCanvas').removeClass('active');
			$('#dia-'+id).css('z-index',zIndexes).addClass('active');
			$('div.loadCanvasList .tcell-right').removeClass('active');
			$(this).find('.tcell-right').addClass('active');
			$('.canvasDraw').css('z-index',1);
			$('#c'+rel).css('z-index',2);
			if (restorePoints['c'+rel].length > 0) {
				$('span.undoTool').addClass('active');
			} else {
				$('span.undoTool').removeClass('active');
			}
			$('span.penTool').trigger('click');
		})*/

		/*$(document).on('click','span.addTool',function(e) {
			e.preventDefault();
			patients_treatments.newDrawing();
		})

		$(document).on('click','span.clearTool',function(e) {
			e.preventDefault();
			var context = activeCanvas.getContext("2d");
			context.clearRect(0, 0, 400, 400);
			var id = activeCanvas.id;
			//var rel = $('#'+id).attr('rel');
			//patients_treatments.saveDrawing(rel,'');
			
			//var can = document.getElementById(id); 
			//var img = can.toDataURL();
			var img = '';
			restorePoints[id].push(restorePoint[id]);
			restorePoint[id] = '';
			var rel = $('#'+id).attr('rel');
			patients_treatments.saveDrawing(rel,img);
		})*/

		/*$(document).on('click','span.undoTool',function(e) {
			e.preventDefault();
			var id = activeCanvas.id;
			if($(this).hasClass('active')) {
				var context = activeCanvas.getContext("2d");
				var currentComp = context.globalCompositeOperation;
				if(currentComp != 'source-over') {
					context.globalCompositeOperation = "source-over";
				}
				context.clearRect(0, 0, 400, 400);
				var img = restorePoints[id].pop();
				setImage(img);
				restorePoint[id] = img;
				var rel = $('#'+id).attr('rel');
				patients_treatments.saveDrawing(rel,img);
				if(currentComp != 'source-over') {
					setTimeout( function() { context.globalCompositeOperation = currentComp; }, 300);					
				}
			}
			if (restorePoints[id].length < 1) {
				$(this).removeClass('active');
			}
		})*/
		
		/*$(document).on('click','span.erasorTool',function(e) {
			e.preventDefault();
			$(this).addClass('active');
			$('span.penTool').removeClass('active');
			$('.canvasDraw').each(function(i,el) {
				var id = this.id;
				contexts[id].globalCompositeOperation = "destination-out";
				contexts[id].strokeStyle = 'rgba(0,0,0,1.0)';
				contexts[id].lineWidth   = 10;
			});
		})

		$(document).on('click','span.penTool',function(e) {
			e.preventDefault();
			$(this).addClass('active');
			$('span.erasorTool').removeClass('active');
			$('.canvasDraw').each(function(i,el) {
				var id = this.id;
				var index = $(".canvasDraw").index(this);
			  	var curcol = index % 10;
				contexts[id].globalCompositeOperation = "source-over";
				contexts[id].strokeStyle = colors[curcol];
				contexts[id].lineWidth   = 3;
			});
		})*/
		
		/*var curcol = 0;
		$('.canvasDraw').livequery(function() {
			  var id = this.id;
			  var rel = $(this).attr('rel');
			  var index = $(".canvasDraw").index(this);
			  var curcol = index % 10;
			  contexts[id] = this.getContext('2d');
			  contexts[id].strokeStyle = colors[curcol];
			  contexts[id].lineWidth   = 3;
		})			*/

		// This will be defined on a TOUCH device such as iPad or Android, etc.
		/*var is_touch_device = 'ontouchstart' in document.documentElement;
		if (is_touch_device) {
            // create a drawer which tracks touch movements
			var drawer = new Array();
			$('.canvasDraw').livequery(function() {
				//$(this).each(function(el) {
					var id = this.id;
					
					this.addEventListener('touchstart', function(){draw(event,this)}, false);
					this.addEventListener('touchmove', function(){draw(event,this)}, false);
					//this.addEventListener('touchend', function(){draw(event,this)}, false);
					// prevent elastic scrolling
				   this.addEventListener('touchmove', function (event) {
					   event.preventDefault();
					}, false);
					
					drawer[id] = {
					   isDrawing: false,
					   touchstart: function (coors) {
						  contexts[id].beginPath();
						  contexts[id].moveTo(coors.x, coors.y);
						  this.isDrawing = true;
					   },
					   touchmove: function (coors) {
						  if (this.isDrawing) {
							 contexts[id].lineTo(coors.x, coors.y);
							 contexts[id].stroke();
						  }
					   }
					};
				//})
			})
            // create a function to pass touch events and coordinates to drawer
            function draw(event,obj) {
			   var id = obj.id
			   var cparent = $('#patients-right .scroll-pane');
			   var cparentTop = cparent.scrollTop();
			   var coors = {x: event.targetTouches[0].pageX,y: event.targetTouches[0].pageY+cparentTop};
               if (obj.offsetParent) {
                  do {
                     coors.x -= obj.offsetLeft;
                     coors.y -= obj.offsetTop
                  }
                  while ((obj = obj.offsetParent) != null);
               }
               drawer[id][event.type](coors);
			   
            }
			
			$(document).on('touchend','.canvasDraw',function(mouseEvent) {
				var id = $(this).attr('id');
				if (drawer[id].isDrawing) {
					drawer[id].isDrawing = false;
					$('#patients span.undoTool').addClass('active');
					var can = document.getElementById(id); 
					var img = can.toDataURL();
					restorePoints[id].push(restorePoint[id]);
					restorePoint[id] = img;
					var rel = $('#'+id).attr('rel');
					patients_treatments.saveDrawing(rel,img);
				}
			});

		} else {
			// Pencil
			$(document).on('mousedown','.canvasDraw',function(mouseEvent) {
			   var id = $(this).attr('id');
			   var position = getPosition(mouseEvent, id);
			   contexts[id].moveTo(position.X, position.Y);
			   contexts[id].beginPath();
			   $(this).mousemove(function (mouseEvent) {
				  drawLine(mouseEvent, id);
			   }).mouseup(function (mouseEvent) {
				   drawLine(mouseEvent, id);
				  finishDrawing(mouseEvent, id);
			   }).mouseout(function (mouseEvent) {
				   drawLine(mouseEvent, id);
				  finishDrawing(mouseEvent, id);
			   });
			});
		}*/
		
	});
	  
	  
	/*var contexts = new Array(); 
	function getPosition(e, id) {
	   var x, y;
	   var canvas = $('#'+id).get(0);
	   var canvasOffset = $('#'+id).offset();
	   var cparent = $('#patients-right .scroll-pane');
	   var cparentOffset = cparent.offset();
	   var cparentTop = cparent.scrollTop();
	   if (e.pageX != undefined && e.pageY != undefined) {
		  x = e.pageX;
		  y = e.pageY;
	   } else {
		  x = e.clientX + document.body.scrollLeft + document.documentElement.scrollLeft;
		  y = e.clientY + document.body.scrollTop + document.documentElement.scrollTop;
	   }
	   return { X: x - canvas.offsetLeft - cparentOffset.left, Y: y - canvasOffset.top};
	}*/
 
 
	// draws a line to the x and y coordinates of the mouse event inside
	// the specified element using the specified context
	/*function drawLine(mouseEvent, id) {
	   var position = getPosition(mouseEvent, id);
	   contexts[id].lineTo(position.X, position.Y);
	   contexts[id].stroke();
	}*/
 
	// draws a line from the last coordiantes in the path to the finishing
	// coordinates and unbind any event handlers which need to be preceded
	// by the mouse down event
	/*function finishDrawing(mouseEvent, id) {
		//drawLine(mouseEvent, id);
		$('#patients span.undoTool').addClass('active');
		var can = document.getElementById(id); 
		var img = can.toDataURL();
		restorePoints[id].push(restorePoint[id]);
		restorePoint[id] = img;
		var rel = $('#'+id).attr('rel');
		patients_treatments.saveDrawing(rel,img);
		$('#'+id).unbind("mousemove").unbind("mouseup").unbind("mouseout");
	}*/
	
	/*$(document).on('click','a.binDiagnose',function(e) {
		e.preventDefault();
		if($(this).hasClass('deactivated')) {
			return false;
		} else {
			var id = $(this).attr("rel");
			var txt = ALERT_DELETE;
			var langbuttons = {};
			langbuttons[ALERT_YES] = true;
			langbuttons[ALERT_NO] = false;
			$.prompt(txt,{ 
				buttons:langbuttons,
				submit: function(e,v,m,f){		
					if(v){
					$.ajax({ type: "GET", url: "/", data: "path=apps/patients/modules/treatments&request=binDiagnose&id=" + id, success: function(data){
						if(data){
							var canvasid = $('canvas[rel='+id+']').attr('id');
							restorePoints[canvasid] = [];
							restorePoint[canvasid] = [];
							$("#canvasList_"+id).prev().trigger('click');
							$("#canvasList_"+id).slideUp(function(){ 
									$(this).remove();
							});
							$('#dia-'+id).fadeOut(function(){ 
									$(this).remove();
							});
							$('canvas[rel='+id+']').fadeOut(function(){ 
									$(this).remove();
							});
						} 
						}
					});
					} 
				}
			});
		}
	});*/
	
	$(document).on('click', 'a.insertTreatmentfromDialog', function(e) {
		e.preventDefault();
		var field = $(this).attr("field");
		var append = $(this).attr("append");
		var cid = $(this).attr("cid");
		var name = $(this).html();
		var costs = $(this).attr("costs");
		var minutes = $(this).attr("minutes");
		var html = '<span class="listmember-outer"><a href="patients_treatments" class="showItemContext" edit="1" uid="' + cid + '" field="'+field+'" costs="'+costs+'" minutes="'+minutes+'">' + name + '</a>';
		var app = getCurrentApp();
		var obj = getCurrentModule();
			if($("#"+field).html() != "") {
				$("#"+field+" .showItemContext:visible:last").append(", ");
			}
			$("#"+field).append(html);
			// recalc
			var tid = field.replace(/task_treatmenttype_/, "");
			var tcosts = 0;
			var tmins = 0;
			$("#"+field).find('.showItemContext:visible').each(function() {
				tcosts += parseFloat($(this).attr('costs'));
				tmins += parseInt($(this).attr('minutes'));
			})
			//$("#costs_"+tid).text(tcosts).number( true, 2, ',', '.' );
			tcosts = $.number( tcosts, 2, ',', '.' );
			$("#costs_"+tid).text(tcosts);
			$("#minutes_"+tid).text(tmins);
			
			var totalcosts = 0;
			$("#patients-right").find('.showItemContext:visible').each(function() {
				totalcosts += parseFloat($(this).attr('costs'));
			})
			var discount = parseInt($('#discount').val());
			if(discount != 0 && totalcosts != 0) {
				totalcosts = totalcosts - ((totalcosts/100)*discount);
			}
			totalcosts = $.number( totalcosts, 2, ',', '.' );
			$("#totalcosts").text(totalcosts);
			
			//var obj = getCurrentModule();
			$('#'+app+' .coform').ajaxSubmit(obj.poformOptions);
			// save to lastused
			$.ajax({ type: "GET", url: "/", data: "path=apps/patients/modules/treatments&request=saveLastUsedTreatments&id="+cid});
	});