/* invoices Object */
function patientsInvoices(name) {
	this.name = name;
	var self = this;
	this.coPrintOptions = '';
	this.coSendToOptions = '';
	this.coPopupEditClass = 'popup-full';

	this.formProcess = function(formData, form, poformOptions) {
		formData[formData.length] = processListApps('invoiceaddress');
		formData[formData.length] = processListApps('invoice_carrier');
		formData[formData.length] = processStringApps('payment_type');
		formData[formData.length] = processDocListApps('documents');
		formData[formData.length] = processListApps('invoice_access');
		}
	this.formResponse = function(data) {
		switch(data.access) {
			case "0":
				$("#patients3 ul[rel=invoices] span[rel="+data.id+"] .module-access-status").removeClass("module-access-active");
			break;
			case "1":
				$("#patients3 ul[rel=invoices] span[rel="+data.id+"] .module-access-status").addClass("module-access-active");
			break;
		}	
	}
	this.poformOptions = { beforeSubmit: this.formProcess, dataType: 'json', success: this.formResponse };

	this.statusOnClose = function(dp) {
		var module = this;
		var id = $("#patients").data("third");
		var status = $("#patients .statusTabs li span.active").attr('rel');
		var date = $("#patients .statusTabs input").val();
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/patients/modules/invoices&request=updateStatus&id=" + id + "&date=" + date + "&status=" + status, cache: false, success: function(data){
				switch(data.status) {
					case "1":
						$("#patients3 ul[rel=invoices] span[rel="+data.id+"] .module-item-status").addClass("module-item-active-trial").removeClass("module-item-active-circle");
					break;
					case "2":
						$("#patients3 ul[rel=invoices] span[rel="+data.id+"] .module-item-status").addClass("module-item-active-circle").removeClass("module-item-active-trial");
						$('#patients-right input.payment_reminder').val('');
						module.actionRefresh();
					break;
					case "3":
						$("#patients3 ul[rel=invoices] span[rel="+data.id+"] .module-item-status").addClass("module-item-active-storno").removeClass("module-item-active-trial");
						$('#patients-right input.payment_reminder').val('');
						module.actionRefresh();
					break;
					default:
						$("#patients3 ul[rel=invoices] span[rel="+data.id+"] .module-item-status").removeClass("module-item-active-trial").removeClass("module-item-active-circle");
				}
			}
		});
	}


	this.getDetails = function(moduleidx,liindex,list) {
		if(self.coPrintOptions == '') {
			$.ajax({ type: "GET", url: "/", data: "path=apps/patients/modules/invoices&request=getPrintOptions", success: function(html){
				self.coPrintOptions = html;
			}});
		}
		if(self.coSendToOptions == '') {
			$.ajax({ type: "GET", url: "/", data: "path=apps/patients/modules/invoices&request=getSendToOptions", success: function(html){
				self.coSendToOptions = html;
			}});
		}
		var id = $("#patients3 ul:eq("+moduleidx+") .module-click:eq("+liindex+")").attr("rel");
		$('#patients').data({ "third" : id});
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/patients/modules/invoices&request=getDetails&id="+id, success: function(data){
			$("#patients-right").html(data.html);
			
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
			}
		});	
	}


	this.checkIn = function(id) {
		return true;
	}
	
	
	this.actionRefresh = function() {
		var id = $("#patients").data("third");
		var pid = $("#patients").data("second");
		$("#patients3 ul[rel=invoices] .active-link").trigger("click");
		$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/patients/modules/invoices&request=getList&id="+pid, success: function(data){																																																																				
			$("#patients3 ul[rel=invoices]").html(data.html);
			$('#patients_invoices_items').html(data.items);
			var liindex = $("#patients3 ul[rel=invoices] .module-click").index($("#patients3 ul[rel=invoices] .module-click[rel='"+id+"']"));
			$("#patients3 ul[rel=invoices] .module-click:eq("+liindex+")").addClass('active-link');
			}
		});
	}


	/* Original
	this.actionPrint = function() {
		var id = $("#patients").data("third");
		var url ='/?path=apps/patients/modules/invoices&request=printDetails&id='+id;
		$("#documentloader").attr('src', url);
	}*/
	
	this.actionPrintOption = function(option) {
		switch(option) {
			case '1':
				var id = $("#patients").data("third");
				var url ='/?path=apps/patients/modules/invoices&request=printDetails&option=invoice&id='+id;
				if(!iOS()) {
					$("#documentloader").attr('src', url);
				} else {
					window.open(url);
				}
			break;
			case '2':
				var id = $("#patients").data("third");
				var url ='/?path=apps/patients/modules/invoices&request=printDetails&option=reminder&id='+id;
				if(!iOS()) {
					$("#documentloader").attr('src', url);
				} else {
					window.open(url);
				}
			break;
			case '3':
				var id = $("#patients").data("third");
				var url ='/?path=apps/patients/modules/invoices&request=printDetails&option=stationary&id='+id;
				if(!iOS()) {
					$("#documentloader").attr('src', url);
				} else {
					window.open(url);
				}
			break;
			case '4':
				var id = $("#patients").data("third");
				var url ='/?path=apps/patients/modules/invoices&request=printDetails&option=services&id='+id;
				if(!iOS()) {
					$("#documentloader").attr('src', url);
				} else {
					window.open(url);
				}
			break;
			case '5':
				var id = $("#patients").data("third");
				var url ='/?path=apps/patients/modules/invoices&request=printDetails&option=invoice_plain&id='+id;
				if(!iOS()) {
					$("#documentloader").attr('src', url);
				} else {
					window.open(url);
				}
			break;
			case '6':
				var id = $("#patients").data("third");
				var url ='/?path=apps/patients/modules/invoices&request=printDetails&option=beleg&id='+id;
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
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/patients/modules/invoices&request=getSend&id="+id, success: function(data){
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
				$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/patients/modules/invoices&request=getSend&option=invoice&id="+id, success: function(data){
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
				$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/patients/modules/invoices&request=getSend&option=reminder&id="+id, success: function(data){
					$("#modalDialogForward").html(data.html).dialog('open');
					if(data.error == 1) {
						$.prompt('<div style="text-align: center">' + ALERT_REMOVE_RECIPIENT + data.error_message + '<br /></div>');
						return false;
					}
					}
				});
			break;
			case '3':
				var id = $("#patients").data("third");
				$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/patients/modules/invoices&request=getSend&option=stationary&id="+id, success: function(data){
					$("#modalDialogForward").html(data.html).dialog('open');
					if(data.error == 1) {
						$.prompt('<div style="text-align: center">' + ALERT_REMOVE_RECIPIENT + data.error_message + '<br /></div>');
						return false;
					}
					}
				});
			break;
			case '4':
				var id = $("#patients").data("third");
				$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/patients/modules/invoices&request=getSend&option=services&id="+id, success: function(data){
					$("#modalDialogForward").html(data.html).dialog('open');
					if(data.error == 1) {
						$.prompt('<div style="text-align: center">' + ALERT_REMOVE_RECIPIENT + data.error_message + '<br /></div>');
						return false;
					}
					}
				});
			break;
			case '5':
				var id = $("#patients").data("third");
				$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/patients/modules/invoices&request=getSend&option=invoice_plain&id="+id, success: function(data){
					$("#modalDialogForward").html(data.html).dialog('open');
					if(data.error == 1) {
						$.prompt('<div style="text-align: center">' + ALERT_REMOVE_RECIPIENT + data.error_message + '<br /></div>');
						return false;
					}
					}
				});
			break;
			case '6':
				var id = $("#patients").data("third");
				$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/patients/modules/invoices&request=getSend&option=beleg&id="+id, success: function(data){
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
		$.ajax({ type: "GET", url: "/", data: "path=apps/patients/modules/invoices&request=getSendtoDetails&id="+id, success: function(html){
			$("#patientsinvoice_sendto").html(html);
			//$("#modalDialogForward").dialog('close');
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
			case "getInvoiceStatusDialog":
				$.ajax({ type: "GET", url: "/", data: 'path=apps/patients/modules/invoices&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
					$("#modalDialog").html(html);
					$("#modalDialog").dialog('option', 'position', offset);
					$("#modalDialog").dialog('option', 'title', title);
					$("#modalDialog").dialog('open');
					}
				});
			break;
			case "getInvoiceCatDialog":
				$.ajax({ type: "GET", url: "/", data: 'path=apps/patients/modules/invoices&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
					$("#modalDialog").html(html);
					$("#modalDialog").dialog('option', 'position', offset);
					$("#modalDialog").dialog('option', 'title', title);
					$("#modalDialog").dialog('open');
					}
				});
			break;
			case "getPaymentTypeDialog":
				$.ajax({ type: "GET", url: "/", data: 'path=apps/patients/modules/invoices&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
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
	
	
	this.manageCheckpoint = function(action,date) {
		var pid = $("#patients").data('third');
		switch(action) {
			case 'new':
				$.ajax({ type: "GET", url: "/", data: 'path=apps/patients/modules/invoices&request=newCheckpoint&id='+ pid +'&date='+ date, cache: false });
			break;
			case 'update':
				$.ajax({ type: "GET", url: "/", data: 'path=apps/patients/modules/invoices&request=updateCheckpoint&id='+ pid +'&date='+ date, cache: false });			
			break;
			case 'delete':
				$.ajax({ type: "GET", url: "/", data: 'path=apps/patients/modules/invoices&request=deleteCheckpoint&id='+ pid, cache: false });
			break;
		}
	}


	this.saveCheckpointText = function() {
		var pid = $("#patients").data('third');
		var text = $('#patients_invoicesCheckpoint textarea').val();
		$.ajax({ type: "POST", url: "/", data: 'path=apps/patients/modules/invoices&request=updateCheckpointText&id='+ pid +'&text='+ text, cache: false });
	}
	
	

	this.actionHelp = function() {
		var url = "/?path=apps/patients/modules/invoices&request=getHelp";
		if(!iOS()) {
			$("#documentloader").attr('src', url);
		} else {
			window.open(url);
		}
	}
		
}

var patients_invoices = new patientsInvoices('patients_invoices');

$(document).ready(function() {				   
	$(document).on('click', '.invoice-outer.active span',function(e) {
		e.preventDefault();
		var q = $(this).attr('rel');
		var val = $(this).attr('v');
		$(this).siblings().removeClass('active');
		$(this).addClass('active');
		
		// update question %
		$('#'+q+'_result').html(val*20);
		
		var total = 0;
		$('#patients .invoice-outer span').each( function() {
			if($(this).hasClass('active'))	{
				total = total + parseInt($(this).attr('v'));
			}
		})
		var res = Math.round(100/25*total);
		$('#total_result').html(res);
		var id = $('#patients').data('third');
		$.ajax({ type: "GET", url: "/", data: "path=apps/patients/modules/invoices&request=updateQuestion&id=" + id + "&field=invoice_" + q + "&val=" + val, cache: false });
		
	});
	
	$(document).on('click', '.insertPaymentTypeFromDialog',function(e) {
		e.preventDefault();
		var field = $(this).attr("rel");
		var val = $(this).html();
		$('#'+field).html(val);
		var id = $("#patients").data("third");
		if(val == 'Barzahlung') {
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: 'path=apps/patients/modules/invoices&request=setBar&id='+id, success: function(data){
					$('#beleg_nummer').text(data.beleg_nummer);
					$('#beleg_datum').val(data.beleg_datum);
					$('#beleg_time').val(data.beleg_time);
					$('#barDetails').slideDown();
					$('#transferDetails').slideUp();
					}
				});
		} else {
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: 'path=apps/patients/modules/invoices&request=removeBar&id='+id, success: function(data){
					$('#beleg_nummer').text('0');
					$('#beleg_datum').val('');
					$('#beleg_time').val('');
					$('#barDetails').slideUp();
					$('#transferDetails').slideDown();
					}
				});
			
		}
		/*var obj = getCurrentModule();
		$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);*/
		$("#modalDialog").dialog("close");
	});
	
});	