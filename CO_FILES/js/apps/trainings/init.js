function initTrainingsContentScrollbar() {
	trainingsInnerLayout.initContent('center');
}

/* trainings Object */
function trainingsApplication(name) {
	this.name = name;
	this.isRefresh = false;

	this.init = function() {
		this.$app = $('#trainings');
		this.$appContent = $('#trainings-right');
		this.$first = $('#trainings1');
		this.$second = $('#trainings2');
		this.$third = $('#trainings3');
		this.$thirdDiv = $('#trainings3 div.thirdLevel');
		this.$layoutWest = $('#trainings div.ui-layout-west');
	}
	
	
	this.formProcess = function(formData, form, poformOptions) {
		var title = $("#trainings input.title").fieldValue();
		if(title == "") {
			$.prompt(ALERT_NO_TITLE, {submit: setTitleFocus});
			return false;
		} else {
			formData[formData.length] = { "name": "title", "value": title };
		}
	
		formData[formData.length] = processListApps('folder');
		formData[formData.length] = processListApps('management');
		formData[formData.length] = processCustomTextApps('management_ct');
		formData[formData.length] = processListApps('team');
		formData[formData.length] = processCustomTextApps('team_ct');
		formData[formData.length] = processListApps('training');
		if($('#trainingstime1').length >0) { formData[formData.length] = processStringApps('time1'); }
		if($('#trainingstime2').length >0) { formData[formData.length] = processStringApps('time2'); }
		if($('#trainingstime3').length >0) { formData[formData.length] = processStringApps('time3'); }
		if($('#trainingstime4').length >0) { formData[formData.length] = processStringApps('time4'); }
		if($('#trainingsplace1').length >0) { formData[formData.length] = processListApps('place1'); }
		if($('#trainingsplace1_ct').length >0) { formData[formData.length] = processCustomTextApps('place1_ct'); }
		if($('#trainingsplace2').length >0) { formData[formData.length] = processListApps('place2'); }
		if($('#trainingsplace2_ct').length >0) { formData[formData.length] = processCustomTextApps('place2_ct'); }
	}

	
	this.formResponse = function(data) {
		switch(data.action) {
			case "edit":
				$("#trainings2 span[rel='"+data.id+"'] .text").html($("#trainings .title").val());
			break;
			case "refresh":
				trainings.actionRefresh();
			break;
		}
	}


	this.poformOptions = { beforeSubmit: this.formProcess, dataType: 'json', success: this.formResponse };


	this.statusOnClose = function(dp) {
		var id = $("#trainings").data("second");
		var status = $("#trainings .statusTabs li span.active").attr('rel');
		var date = $("#trainings .statusTabs input").val();
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/trainings&request=updateStatus&id=" + id + "&date=" + date + "&status=" + status, cache: false, success: function(data){
				switch(data.status) {
					case "2":
						$("#trainings2 .active-link .module-item-status").addClass("module-item-active").removeClass("module-item-active-stopped");
						$("#trainingDurationEnd").html($("#trainings-right input[name='status_date']").val());
						$("#trainings .invitationLink, #trainings .registrationLink, #trainings .tookpartLink, #trainings .feedbackLink").addClass('incomplete');
					break;
					case "3":
						$("#trainings2 .active-link .module-item-status").addClass("module-item-active-stopped").removeClass("module-item-active");
						$("#trainingDurationEnd").html($("#trainings-right input[name='status_date']").val());
						$("#trainings .invitationLink, #trainings .registrationLink, #trainings .tookpartLink, #trainings .feedbackLink").addClass('incomplete');
					break;
					default:
						$("#trainings2 .active-link .module-item-status").removeClass("module-item-active").removeClass("module-item-active-stopped");
						$("#trainings .invitationLink, #trainings .registrationLink, #trainings .tookpartLink, #trainings .feedbackLink").removeClass('incomplete');
				}
			}
		});
	}


	this.actionClose = function() {
		trainingsLayout.toggle('west');
	}


	this.getNavModulesNumItems = function(id) {
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: 'path=apps/trainings&request=getNavModulesNumItems&id=' + id, success: function(data){
				$.each( data, function(k, v){
   					$('#'+k).html(v);
 				});
			}
		});
	}

	
	this.actionNew = function() {
		var module = this;
		var cid = $('#trainings input[name="id"]').val()
		module.checkIn(cid);
		var id = $('#trainings').data('first');
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: 'path=apps/trainings&request=newTraining&id=' + id, cache: false, success: function(data){
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/trainings&request=getTrainingList&id="+id, success: function(list){
				$("#trainings2 ul").html(list.html);
				var index = $("#trainings2 .module-click").index($("#trainings2 .module-click[rel='"+data.id+"']"));
				setModuleActive($("#trainings2"),index);
				$('#trainings').data({ "second" : data.id });				
				$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/trainings&request=getTrainingDetails&id="+data.id, success: function(text){
					$("#trainings-right").html(text.html);
					initTrainingsContentScrollbar();
					$('#trainings-right .focusTitle').trigger('click');
					module.getNavModulesNumItems(data.id);
					}
				});
				trainingsActions(0);
				}
			});
			}
		});
	}


	this.actionDuplicate = function() {
		var module = this;
		var cid = $('#trainings input[name="id"]').val()
		module.checkIn(cid);
		var pid = $("#trainings").data("second");
		var oid = $("#trainings").data("first");
		$.ajax({ type: "GET", url: "/", data: 'path=apps/trainings&request=createDuplicate&id=' + pid, cache: false, success: function(id){
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/trainings&request=getTrainingList&id="+oid, success: function(data){
				$("#trainings2 ul").html(data.html);
					trainingsActions(0);
					var idx = $("#trainings2 .module-click").index($("#trainings2 .module-click[rel='"+id+"']"));
					setModuleActive($("#trainings2"),idx)
					$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/trainings&request=getTrainingDetails&id="+id, success: function(text){
						$("#trainings").data("second",id);							
						$("#"+trainings.name+"-right").html(text.html);
							initTrainingsContentScrollbar();
							module.getNavModulesNumItems(id);
						}
					});
				}
			});
			}
		});
	}


	this.actionBin = function() {
		var module = this;
		var cid = $('#trainings input[name="id"]').val()
		module.checkIn(cid);
		var txt = ALERT_DELETE;
		var langbuttons = {};
		langbuttons[ALERT_YES] = true;
		langbuttons[ALERT_NO] = false;
		$.prompt(txt,{ 
			buttons:langbuttons,
			submit: function(e,v,m,f){		
				if(v){
					var id = $("#trainings").data("second");
					var fid = $("#trainings").data("first");
					$.ajax({ type: "GET", url: "/", data: "path=apps/trainings&request=binTraining&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/trainings&request=getTrainingList&id="+fid, success: function(list){
								$("#trainings2 ul").html(list.html);
								if(list.html == "<li></li>") {
									trainingsActions(3);
								} else {
									trainingsActions(0);
									setModuleActive($("#trainings2"),0);
								}
								var id = $("#trainings2 .module-click:eq(0)").attr("rel");
								if(typeof id == 'undefined') {
									$("#trainings").data("second", 0);
								} else {
									$("#trainings").data("second", id);
								}
								$("#trainings2 .module-click:eq(0)").addClass('active-link');
								$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/trainings&request=getTrainingDetails&fid="+fid+"&id="+id, success: function(text){
									$("#trainings-right").html(text.html);
									initTrainingsContentScrollbar();
									module.getNavModulesNumItems(id);
									}
								});
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
		$.ajax({ type: "GET", url: "/", async: false, data: 'path=apps/trainings&request=checkinTraining&id='+id, success: function(data){
				if(!data) {
					prompt("something wrong");
				}
			}
		});
	}

	this.actionRefresh = function() {
		var oid = $('#trainings').data('first');
		var pid = $('#trainings').data('second');
		$("#trainings2 .active-link").trigger("click");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/trainings&request=getTrainingList&id="+oid, success: function(data){
			$("#trainings2 ul").html(data.html);
			var idx = $("#trainings2 .module-click").index($("#trainings2 .module-click[rel='"+pid+"']"));
			$("#trainings2 .module-click:eq("+idx+")").addClass('active-link');
			}
		});
	}

	this.actionHandbook = function() {
		var id = $("#trainings").data("first");
		var url ='/?path=apps/trainings&request=printTrainingHandbook&id='+id;
		$("#documentloader").attr('src', url);	
	}

	this.actionPrint = function() {
		var id = $("#trainings").data("second");
		var url ='/?path=apps/trainings&request=printTrainingDetails&id='+id;
		$("#documentloader").attr('src', url);
	}
	
	this.actionPrintTwo = function() {
		var id = $("#trainings").data("second");
		var url ='/?path=apps/trainings&request=printMemberList&id='+id;
		$("#documentloader").attr('src', url);
	}


	this.actionSend = function() {
		var id = $("#trainings").data("second");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/trainings&request=getTrainingSend&id="+id, success: function(data){
			$("#modalDialogForward").html(data.html).dialog('open');
			if(data.error == 1) {
				$.prompt('<div style="text-align: center">' + ALERT_REMOVE_RECIPIENT + data.error_message + '<br /></div>');
				return false;
			}
			}
		});
	}


	this.actionSendtoResponse = function() {
		var id = $("#trainings").data("second");
		$.ajax({ type: "GET", url: "/", data: "path=apps/trainings&request=getSendtoDetails&id="+id, success: function(html){
			$("#training_sendto").html(html);
			//$("#modalDialogForward").dialog('close');
			}
		});
	}


	this.sortclick = function (obj,sortcur,sortnew) {
		var module = this;
		var cid = $('#trainings input[name="id"]').val()
		module.checkIn(cid);
		var fid = $("#trainings .module-click:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/trainings&request=getTrainingList&id="+fid+"&sort="+sortnew, success: function(data){
			$("#trainings2 ul").html(data.html);
			obj.attr("rel",sortnew);
			obj.removeClass("sort"+sortcur).addClass("sort"+sortnew);
			var id = $("#trainings2 .module-click:eq(0)").attr("rel");
			$('#trainings').data('second',id);
			if(id == undefined) {
				return false;
			}
			setModuleActive($("#trainings2"),'0');
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/trainings&request=getTrainingDetails&id="+id, success: function(text){
				$("#"+trainings.name+"-right").html(text.html);
				initTrainingsContentScrollbar()
				}
			});
			}
		});
	}


	this.sortdrag = function (order) {
		var fid = $("#trainings .module-click:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", data: "path=apps/trainings&request=setTrainingOrder&"+order+"&id="+fid, success: function(html){
			$("#trainings2 .sort").attr("rel", "3");
			$("#trainings2 .sort").removeClass("sort1").removeClass("sort2").addClass("sort3");
			}
		});
	}
	
	
	this.actionDialog = function(offset,request,field,append,title,sql) {
		switch(request) {
			case "getTrainingDialog":
				$.ajax({ type: "GET", url: "/", data: 'path=apps/trainings&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
					$("#modalDialog").html(html);
					$("#modalDialog").dialog('option', 'position', offset);
					$("#modalDialog").dialog('option', 'title', title);
					$("#modalDialog").dialog('open');
					}
				});
			break;
			case "getTrainingCatDialog":
				$.ajax({ type: "GET", url: "/", data: 'path=apps/trainings&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
					$("#modalDialog").html(html);
					$("#modalDialog").dialog('option', 'position', offset);
					$("#modalDialog").dialog('option', 'title', title);
					$("#modalDialog").dialog('open');
					}
				});
			break;
			default:
			$.ajax({ type: "GET", url: "/", data: 'path=apps/trainings&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
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


	this.coPopup = function(el,request) {
		switch(request) {
			default:
			var ele = el.parent();
			var html = el.next().html();
			$('#co-popup')
					.removeClass(function (index, css) {
					  return (css.match (/\bpopup-\w+/g) || []).join(' ');
					})
					.html(html)
					.position({
						  my: "center center",
						  at: "right+72 center",
						  of: ele,
						  using: function(coords, feedback) {
							  var $modal = $(this),
								top = coords.top,
								className = 'switch-' + feedback.horizontal;
				
							$modal.css({
								left: coords.left + 'px',
								top: top + 'px'
					})
					.removeClass(function (index, css) {
					   return (css.match (/\bswitch-\w+/g) || []).join(' ');
					})
					.addClass(className);
			  }
			});
		}
	}

	this.insertStatusDate = function(rel,text) {
		var html = '<div class="listmember" field="trainingsstatus" uid="'+rel+'" style="float: left">' + text + '</div>';
		$("#trainingsstatus").html(html);
		$("#modalDialog").dialog("close");
		$("#trainingsstatus").nextAll('img').trigger('click');
	}
	
	
	this.insertFromDialog = function(field,gid,title) {
		var html = '<a class="listmember" uid="' + gid + '" field="'+field+'">' + title + '</a>';
		$("#"+field).html(html);
		$("#modalDialog").dialog('close');
		var obj = getCurrentModule();
		$('#trainings .coform').ajaxSubmit(obj.poformOptions);
	}


	this.customContactInsert = function(cid) {
		var id = $("#trainings").data("second");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/trainings&request=addMember&pid=" + id + "&cid=" + cid, cache: false, success: function(data){
			/*if(data.error) {
				$.prompt(data.error_data + ' ' + ALERT_SENDTO_EMAIL);
			} else {*/
				if(data.status)	{																																	
					$('#trainingsmembers').append(data.html);
					$('#training_num_members').html(parseInt($('#training_num_members').html())+1)
				} else {
					$.prompt("Dieser Kontakt befindet sich schon in der Liste");
				}
			//}
			}
		});
	}


	this.customGroupInsert = function(cid) {
		var id = $("#trainings").data("second");
		$.ajax({ type: "GET", url: "/", data: "path=apps/trainings&request=getGroupIDs&cid=" + cid, cache: false, success: function(ids){
			
			var ar = ids.split(',');
			var error = '';
			var already = '';
			for (var i=0; i<ar.length; i++) {
				$.ajax({ type: "GET", url: "/", async: false, dataType:  'json', data: "path=apps/trainings&request=addMember&pid=" + id + "&cid=" + ar[i], cache: false, success: function(data){
					//if(data.error) {
						//$.prompt(data.error_data + ' ' + ALERT_SENDTO_EMAIL);
						//error = error+data.error_data;
					//} else {
						if(data.status)	{																																	
							$('#trainingsmembers').append(data.html);
							$('#training_num_members').html(parseInt($('#training_num_members').html())+1)
						} else {
							//$.prompt("Dieser Kontakt befindet sich schon in der Teilnehmeriste");
							//already = already+data.members.name;
						}
					//}
					}
				});
			}
			if(error != '') {
				$.prompt(error + ' ' + ALERT_SENDTO_EMAIL);
			}
			if(already != '') {
				$.prompt(already + ' befinden sich schon in der Teilnehmeriste"');
			}
			
		}
		});
	}


	this.togglePost = function(id,obj) {
		var module = this;
		var outer = $('#memberlog_'+id);
		outer.slideToggle();
		obj.find('span').toggleClass('active');
	}

	this.trainingsMemberAction = function(action,id,other) {
		var actionlink;
		var actionclass;
		var actionremoveclass = 'deactive';
		switch(action) {
			case 'sendInvitation':
				actionlink = 'invitation';
				actionclass = 'active';
			break;
			case 'manualInvitation':
				actionlink = 'invitation';
				actionclass = 'active';
			break;
			case 'resetInvitation':
				actionlink = 'invitation';
				actionclass = '';
				actionremoveclass = 'active deactive';
			break;
			case 'manualRegistration':
				actionlink = 'registration';
				actionclass = 'active';
			break;
			case 'removeRegistration':
				actionlink = 'registration';
				actionclass = 'deactive';
				actionremoveclass = 'active';
			break;
			case 'resetRegistration':
				actionlink = 'registration';
				actionclass = '';
				actionremoveclass = 'active deactive';
			break;
			case 'manualTookpart':
				actionlink = 'tookpart';
				actionclass = 'active';
			break;
			case 'manualTookNotpart':
				actionlink = 'tookpart';
				actionclass = 'deactive';
				actionremoveclass = 'active';
			break;
			case 'resetTookpart':
				actionlink = 'tookpart';
				actionclass = '';
				actionremoveclass = 'active deactive';
			break;
			case 'editFeedback':
				actionlink = 'feedback';
				actionclass = 'active';
			break;
			case 'sendFeedback':
				actionlink = 'feedback';
				actionclass = 'deactive';
				actionremoveclass = 'active';
			break;
			case 'resetFeedback':
				actionlink = 'feedback';
				actionclass = '';
				actionremoveclass = 'active deactive';
			break;
		}
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: 'path=apps/trainings&request='+action+'&id=' + id, success: function(data){
			if(data){
				if(data.error) {
					$.prompt(ALERT_NO_EMAIL);
				} else {
					$('#member_'+id + ' .'+actionlink+'Link').addClass(actionclass).removeClass(actionremoveclass);
					$('#co-popup').css('left',-1000);
					$('#member_log_'+id+'_content').prepend('<div class="text11">'+data.action+': ' + data.who + ', '+data.date+'</div>');
					if($('#toggler_'+id).is(':hidden')) {
						$('#toggler_'+id).show();
					}
					if(action == 'editFeedback') {
						var href = other.split(",");
						externalLoadThreeLevels('feedbacks',href[0],href[1],href[2],'trainings');
					}
				}
			} 
			}
		});
	}


	this.binItem = function(id) {
		var txt = ALERT_DELETE;
		var langbuttons = {};
		langbuttons[ALERT_YES] = true;
		langbuttons[ALERT_NO] = false;
		$.prompt(txt,{ 
			buttons:langbuttons,
			submit: function(e,v,m,f){		
				if(v){
					$.ajax({ type: "GET", url: "/", data: 'path=apps/trainings&request=binMember&id=' + id, success: function(data){
						if(data){
							$("#member_"+id).slideUp(function(){ 
								$(this).remove();
								$('#training_num_members').html(parseInt($('#training_num_members').html())-1)
							});
						} 
						}
					});
				} 
			}
		});	
	}


	this.actionHelp = function() {
		var url = "/?path=apps/trainings&request=getTrainingsHelp";
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
			submit: function(e,v,m,f){		
				if(v){
					$.ajax({ type: "GET", url: "/", data: "path=apps/trainings&request=deleteTraining&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#training_'+id).slideUp();
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/trainings&request=restoreTraining&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#training_'+id).slideUp();
						}
					}
					});
				} 
			}
		});
	}
	
// Recycle Bin
	this.binDeleteItem = function(id) {
		var txt = ALERT_DELETE_REALLY;
		var langbuttons = {};
		langbuttons[ALERT_YES] = true;
		langbuttons[ALERT_NO] = false;
		$.prompt(txt,{ 
			buttons:langbuttons,
			submit: function(e,v,m,f){		
				if(v){
					$.ajax({ type: "GET", url: "/", data: "path=apps/trainings&request=deleteMember&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#training_'+id).slideUp();
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/trainings&request=restoreMember&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#training_'+id).slideUp();
						}
					}
					});
				} 
			}
		});
	}


	this.datepickerOnClose = function(dp) {
		if(dp.name == 'date1' && dp.value != $("input[id='movetraining_start']").val()) {
			var txt = ALERT_TRAINING_MOVE_ALL;
			var langbuttons = {};
			langbuttons[ALERT_YES] = true;
			langbuttons[ALERT_NO] = false;
			$.prompt(txt,{ 
				buttons:langbuttons,
				submit: function(e,v,m,f){		
					if(v){
						var d1 = $("#trainings input[name='date1']");
						var d2 = $("#trainings input[name='date2']");
						var d3 = $("#trainings input[name='date3']");
						var move = $("input[id='movetraining_start']");
						var date1 = Date.parse(d1.val());
						var movedate = Date.parse(move.val());
						var span = new TimeSpan(date1 - movedate);
						var days = span.getDays();
						move.val(d1.val());
						if(d2.length > 0) {
							var date2 = Date.parse(d2.val()).addDays(days);
							d2.val(date2.toString('dd.MM.yyyy'));
						}
						if(d3.length > 0) {
							var date3 = Date.parse(d3.val()).addDays(days);
							d3.val(date3.toString('dd.MM.yyyy'));
						}
						var reg = $("#trainings input[name='registration_end']");
						var dateregval = reg.val();
						if(dateregval != '') {
							var datereg = Date.parse(reg.val()).addDays(days);
							reg.val(datereg.toString('dd.MM.yyyy'));
						}
						
						var obj = getCurrentModule();
						$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
					} else {
						var d1 = $("#trainings input[name='date1']");
						var d2 = $("#trainings input[name='date2']");
						var d3 = $("#trainings input[name='date3']");
						var move = $("input[id='movetraining_start']");
						var date1 = Date.parse(d1.val());
						move.val(d1.val());
						if(d2.length > 0) {
							var date2 = Date.parse(d2.val());
							if(date1 > date2) {
								d2.val(d1.val())
							}
						}
						if(d3.length > 0) {
							var date3 = Date.parse(d3.val());
							if(date1 > date3) {
								d3.val(d1.val())
							}
						}
						var reg = $("#trainings input[name='registration_end']");
						var dateregval = reg.val();
						if(dateregval != '') {
							var datereg = Date.parse(reg.val());
							if(date1 < datereg) {
								reg.val(d1.val())
							}
						}
						
						var obj = getCurrentModule();
						$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
					}	
				}
			});
		} else if(dp.name == 'date3') {
			var d2 = $("#trainings input[name='date2']");
			var d3 = $("#trainings input[name='date3']");
			var date2 = Date.parse(d2.val());
			if(d2.length > 0) {
				var date3 = Date.parse(d3.val());
				if(date3 > date2) {
					d2.val(d3.val())
				}
			}
			var obj = getCurrentModule();
			$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		} else {
			var obj = getCurrentModule();
			$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		}
	}


	this.manageCheckpoint = function(action,date) {
		var pid = $('#trainings').data('second');
		switch(action) {
			case 'new':
				$.ajax({ type: "GET", url: "/", data: "path=apps/trainings&request=newCheckpoint&id=" + pid + "&date=" + date, cache: false });
			break;
			case 'update':
				$.ajax({ type: "GET", url: "/", data: "path=apps/trainings&request=updateCheckpoint&id=" + pid + "&date=" + date, cache: false });			
			break;
			case 'delete':
				$.ajax({ type: "GET", url: "/", data: "path=apps/trainings&request=deleteCheckpoint&id=" + pid, cache: false });
			break;
		}
	}
	
	
	this.saveCheckpointText = function() {
		var pid = $('#trainings').data('second');
		var text = $('#trainingsCheckpoint textarea').val();
		$.ajax({ type: "POST", url: "/", data: "path=apps/trainings&request=updateCheckpointText&id=" + pid + "&text=" + text, cache: false });
	}

}

var trainings = new trainingsApplication('trainings');
//trainings.resetModuleHeights = trainingsresetModuleHeights;
trainings.modules_height = trainings_num_modules*module_title_height;
trainings.GuestHiddenModules = new Array("access");

// register folder object
function trainingsFolders(name) {
	this.name = name;
	
	
	this.formProcess = function(formData, form, poformOptions) {
		var title = $("#trainings input.title").fieldValue();
		if(title == "") {
			$.prompt(ALERT_NO_TITLE, {submit: setTitleFocus});
			return false;
		} else {
			formData[formData.length] = { "name": "title", "value": title };
		}
	}
	
	
	this.formResponse = function(data) {
		switch(data.action) {
			case "edit":
				$("#trainings1 span[rel='"+data.id+"'] .text").html($("#trainings .title").val());
			break;
		}
	}


	this.poformOptions = { beforeSubmit: this.formProcess, dataType: 'json', success: this.formResponse };

	
	this.actionNew = function() {
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/trainings&request=newFolder", cache: false, success: function(data){
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/trainings&request=getFolderList", success: function(list){
				$("#trainings1 ul").html(list.html);
				$("#trainings1 li").show();
				var index = $("#trainings1 .module-click").index($("#trainings1 .module-click[rel='"+data.id+"']"));
				setModuleActive($("#trainings1"),index);
				$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/trainings&request=getFolderDetails&id="+data.id, success: function(text){
					$("#trainings").data("first",data.id);					
					$("#"+trainings.name+"-right").html(text.html);
					initTrainingsContentScrollbar();
					$('#trainings-right .focusTitle').trigger('click');
					}
				});
				trainingsActions(9);
				}
			});
			}
		});
	}
	
	
	this.actionBin = function() {
		var txt = ALERT_DELETE;
		var langbuttons = {};
		langbuttons[ALERT_YES] = true;
		langbuttons[ALERT_NO] = false;
		$.prompt(txt,{ 
			buttons:langbuttons,
			submit: function(e,v,m,f){		
				if(v){
					var id = $("#trainings").data("first");
					$.ajax({ type: "GET", url: "/", data: "path=apps/trainings&request=binFolder&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/trainings&request=getFolderList", success: function(data){
								$("#trainings1 ul").html(data.html);
								if(data.html == "<li></li>") {
									trainingsActions(3);
								} else {
									trainingsActions(9);
								}
								var id = $("#trainings1 .module-click:eq(0)").attr("rel");
								if(typeof id == 'undefined') {
									$("#trainings").data("first",0);
								} else {
									$("#trainings").data("first",id);
								}
								$("#trainings1 .module-click:eq(0)").addClass('active-link');
								$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/trainings&request=getFolderDetails&id="+id, success: function(text){
									$("#"+trainings.name+"-right").html(text.html);
									initTrainingsContentScrollbar();
								}
								});
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
		return true;
	}


	this.actionLoadTab = function(what) {
		var id = $("#trainings").data("first");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: 'path=apps/trainings&request=get'+what+'&id='+id, success: function(data){
			$('#trainingsFoldersTabsContent').empty().html(data.html);
			initTrainingsContentScrollbar()
			}
		});
	}
	
	this.actionLoadSubTab = function(view) {
		var id = $("#trainings").data("first");
		var what = $('#trainingsFoldersTabs ul.contentTabsList span[class=active]').attr('rel');
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: 'path=apps/trainings&request=get'+what+'&view='+view+'&id='+id, success: function(data){
			$('#trainingsFoldersTabsContent').empty().html(data.html);
			initTrainingsContentScrollbar()
			}
		});
	}

	this.loadBarchartZoom = function(zoom) {
		var id = $("#trainings").data("first");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: 'path=apps/trainings&request=getFolderDetailsMultiView&id='+id+'&zoom='+zoom, success: function(data){
			$('#trainingsFoldersTabsContent').html(data.html);
			initTrainingsContentScrollbar()
			}
		});
	}

	this.actionRefresh = function() {
		trainings.isRefresh = true;
		var id = $("#trainings").data("first");
		$("#trainings1 .active-link").trigger("click");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/trainings&request=getFolderList", success: function(data){
			$("#trainings1 ul").html(data.html);
			if(data.access == "guest") {
				trainingsActions();
			} else {
				if(data.html == "<li></li>") {
					trainingsActions(3);
				} else {
					trainingsActions(9);
				}
			}
			var idx = $("#trainings1 .module-click").index($("#trainings1 .module-click[rel='"+id+"']"));
			$("#trainings1 .module-click:eq("+idx+")").addClass('active-link');
			}
		});
	}
	

	this.actionPrint = function() {
		var id = $("#trainings").data("first");
		var what = $('#trainingsFoldersTabs ul.contentTabsList span[class=active]').attr('rel');
		if(what == 'FolderDetailsMultiView') {
			var view= $('#trainingsFoldersSubTabs ul span[class~=active]').attr('rel');
			what = what + '&view=' + view;
		}
		var url ='/?path=apps/trainings&request=print'+what+'&id='+id;
		$("#documentloader").attr('src', url);
	}

	this.actionSend = function() {
		var id = $("#trainings").data("first");
		var what = $('#trainingsFoldersTabs ul.contentTabsList span[class=active]').attr('rel');
		if(what == 'FolderDetailsMultiView') {
			var view= $('#trainingsFoldersSubTabs ul span[class~=active]').attr('rel');
			what = what + '&view=' + view;
		}
		$.ajax({ type: "GET", url: "/", data: 'path=apps/trainings&request=getSend'+what+'&id='+id, success: function(html){
			$("#modalDialogForward").html(html).dialog('open');
			}
		});
	}


	this.actionSendtoResponse = function() {
			//$("#modalDialogForward").dialog('close');
	}

	
	this.sortclick = function (obj,sortcur,sortnew) {
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/trainings&request=getFolderList&sort="+sortnew, success: function(data){
			$("#trainings1 ul").html(data.html);
			obj.attr("rel",sortnew);
		  	obj.removeClass("sort"+sortcur).addClass("sort"+sortnew);
			var id = $("#trainings1 .module-click:eq(0)").attr("rel");
			$('#trainings').data('first',id);			
			$("#trainings1 .module-click:eq(0)").addClass('active-link');
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/trainings&request=getFolderDetails&id="+id, success: function(text){
				$("#trainings-right").html(text.html);
				initTrainingsContentScrollbar()
				}
			});
			}
		});
	}


	this.sortdrag = function (order) {
		$.ajax({ type: "GET", url: "/", data: "path=apps/trainings&request=setFolderOrder&"+order, success: function(html){
			$("#trainings1 .sort").attr("rel", "3");
			$("#trainings1 .sort").removeClass("sort1").removeClass("sort2").addClass("sort3");
			}
		});
	}
	
	
	this.insertItem = function(field,append,id,text) {
		var html = '<span class="listmember-outer"><a class="listmember" uid="' + id + '" field="'+field+'">' + text + '</a>';
		$("#"+field).html(html);
		$("#modalDialog").dialog('close');
		/*var obj = getCurrentModule();
		$('#projects .coform').ajaxSubmit(obj.poformOptions);*/
	}
	
	this.actionDialog = function(offset,request,field,append,title,sql) {
		switch(request) {
			case "getMenuesDialog":
				$.ajax({ type: "GET", url: "/", data: 'path=apps/publishers/modules/menues&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
					$("#modalDialog").html(html);
					$("#modalDialog").dialog('option', 'position', offset);
					$("#modalDialog").dialog('option', 'title', title);
					$("#modalDialog").dialog('open');
					}
				});
			break;
			default:
				$.ajax({ type: "GET", url: "/", data: 'path=apps/trainings&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
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
		var url = "/?path=apps/trainings&request=getTrainingsFoldersHelp";
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
			submit: function(e,v,m,f){		
				if(v){
					$.ajax({ type: "GET", url: "/", data: "path=apps/trainings&request=deleteFolder&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#folder_'+id).slideUp();
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/trainings&request=restoreFolder&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#folder_'+id).slideUp();
						}
						}
					});
				} 
			}
		});
	}

	
}

var trainings_folder = new trainingsFolders('trainings_folder');


function trainingsActions(status) {
	var obj = getCurrentModule();
	switch(status) {
		case 0: 
			if(obj.name == 'trainings_feedbacks') {
				actions = ['1','2','4','5','6','7'];
			} else {
				actions = ['0','1','2','3','4','5','6','7','8'];
			}
		break;
		case 1: actions = ['0','6','7','8']; break;
		case 3: 	
		if(obj.name == 'trainings_feedbacks') {
				actions = ['6','7'];
			} else {
				actions = ['0','6','7']; 
			}
		break;
		case 4: 	actions = ['0','1','2','4','6','7']; break;   		// new, print, send, handbook, refresh
		case 5: 	actions = ['1','2','6','7']; break;   			// print, send, refresh
		case 6: 	actions = ['5','6','7']; break;   			// handbook refresh
		case 7: 	actions = ['0','1','2','6','7']; break;   			// new, print, send, refresh
		case 8: 	actions = ['1','2','4','5','6','7']; break;   			// print, send, handbook, refresh
		case 9:		actions = ['0','1','2','4','6','7','8']; break;
		// vdocs
		// 0 == 10
		case 10: actions = ['0','1','2','3','4','5','6','7','8']; break;
		// 5 == 11
		case 11: 	actions = ['1','2','4','6','7']; break;   			// print, send, refresh
		default: 	actions = ['6','7'];  								// none
	}
	
	$('#trainingsActions > li span').each( function(index) {
		if(index in oc(actions)) {
			$(this).removeClass('noactive');
		} else {
			$(this).addClass('noactive');
		}
	})
}

var trainingsLayout, trainingsInnerLayout;


$(document).ready(function() {
	
	trainings.init();
	
	if($('#trainings').length > 0) {
		trainingsLayout = $('#trainings').layout({
				west__onresize:				function() { resetModuleHeightsnavThree('trainings'); }
			,	resizeWhileDragging:		true
			,	spacing_open:				0
			,	spacing_closed:				0
			,	closable: 					false
			,	resizable: 					false
			,	slidable:					false
			, 	west__size:					325
			,	west__closable: 			true
			,	center__onresize: "trainingsInnerLayout.resizeAll"
			
		});
		
		trainingsInnerLayout = $('#trainings div.ui-layout-center').layout({
				center__onresize:				function() {  }
			,	resizeWhileDragging:		true
			,	spacing_open:				0
			,	closable: 					false
			,	resizable: 					false
			,	slidable:					false
			,	north__paneSelector:		".center-north"
			,	center__paneSelector:		".center-center"
			,	west__paneSelector:			".center-west"
			, 	north__size:				68
			, 	west__size:					60
		});

		loadModuleStartnavThree('trainings');
	}


	$("#trainings1-outer").on('click', 'h3', function(e, passed_id) {
		e.preventDefault();
		navThreeTitleFirst('trainings',$(this),passed_id)
		prevent_dblclick(e)
	}).disableSelection();


	$("#trainings2-outer").on('click', 'h3', function(e, passed_id) {
		e.preventDefault();
		navThreeTitleSecond('trainings',$(this),passed_id)
		prevent_dblclick(e)
	}).disableSelection();


	$("#trainings3").on('click', 'h3', function(e, passed_id) {
		e.preventDefault();
		navThreeTitleThird('trainings',$(this),passed_id)
		prevent_dblclick(e)
	}).disableSelection();


	$('#trainings1').on('click', 'span.module-click',function(e) {
		e.preventDefault();
		navItemFirst('trainings',$(this))
		prevent_dblclick(e)
	});


	$('#trainings2').on('click', 'span.module-click',function(e) {
		e.preventDefault();
		navItemSecond('trainings',$(this))
		prevent_dblclick(e)
	});


	$('#trainings3').on('click', 'span.module-click',function(e) {
		e.preventDefault();
		navItemThird('trainings',$(this))
		prevent_dblclick(e)
	});


	$(document).on('click', 'a.insertTrainingFolderfromDialog', function(e) {
		e.preventDefault();
		var field = $(this).attr("field");
		var gid = $(this).attr("gid");
		var title = $(this).attr("title");
		var obj = getCurrentModule();
		obj.insertFromDialog(field,gid,title);
	});
	
	
// INTERLINKS FROM Content
	
	// load a training
	$(document).on('click', '.loadTraining', function(e) {	
		e.preventDefault();
		var obj = getCurrentModule();
		if(confirmNavigation()) {
			formChanged = false;
			$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
		}
		var id = $(this).attr("rel");
		$("#trainings2-outer > h3").trigger('click', [id]);
	});
	

	// autocomplete trainings search
	$('.trainings-search').livequery(function() {
		var id = $("#trainings").data("second");
		$(this).autocomplete({
			appendTo: '#tabs-1',
			source: "?path=apps/trainings&request=getTrainingsSearch&exclude="+id,
			//minLength: 2,
			select: function(event, ui) {
				var obj = getCurrentModule();
				obj.addParentLink(ui.item.id);

			},
			close: function(event, ui) {
				$(this).val("");
			}
		});
	});
	
	$(document).on('click', '.addTrainingLink', function(e) {
		e.preventDefault();
		var id = $(this).attr("rel");
		var obj = getCurrentModule();
		obj.addParentLink(id);
	});
	
	$(document).on('click', '.trainingsMemberAction', function(e) {
		e.preventDefault();
		var userid = $(this).attr("uid");
		var action = $(this).attr("rel");
		var other = $(this).attr("act");
		var obj = getCurrentModule();
		obj.trainingsMemberAction(action,userid,other);
	});


});