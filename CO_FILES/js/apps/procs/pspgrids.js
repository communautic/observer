/* pspgrids Object */
function procsPspgrids(name) {
	this.name = name;
	this.coPopupEditClass = 'popup-full';
	var self = this;
	this.coPopupEdit = '';

	this.formProcess = function(formData, form, poformOptions) {
		var title = $("#procs input.title").fieldValue();
		if(title == "") {
			$.prompt(ALERT_NO_TITLE, {submit: setTitleFocus});
			return false;
		} else {
			formData[formData.length] = { "name": "title", "value": title };
		}
		formData[formData.length] = processListApps('owner');
		formData[formData.length] = processCustomTextApps('owner_ct');
		formData[formData.length] = processListApps('management');
		formData[formData.length] = processCustomTextApps('management_ct');
		formData[formData.length] = processListApps('team');
		formData[formData.length] = processCustomTextApps('team_ct');
		formData[formData.length] = processListApps('pspgrid_access');
	 }
	 
	 this.formResponse = function(data) {
		 switch(data.action) {
			case "edit":
				$("#procs3 span[rel='"+data.id+"'] .text").html($("#procs .title").val());
					switch(data.access) {
						case "0":
							$("#procs3 span[rel="+data.id+"] .module-access-status").removeClass("module-access-active");
						break;
						case "1":
							$("#procs3 span[rel="+data.id+"] .module-access-status").addClass("module-access-active");
						break;
					}
			break;
		}
	}
	
	this.poformOptions = { beforeSubmit: this.formProcess, dataType: 'json', success: this.formResponse };

	this.getDetails = function(moduleidx,liindex,list) {
		if(self.coPopupEdit == '') {
			$.ajax({ type: "GET", url: "/", data: "path=apps/procs/modules/pspgrids&request=getCoPopup", success: function(html){
				self.coPopupEdit = html;
			}});
		}
		var id = $("#procs3 ul:eq("+moduleidx+") .module-click:eq("+liindex+")").attr("rel");
		$('#procs').data({ "third" : id});
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/procs/modules/pspgrids&request=getDetails&id="+id, success: function(data){
			$("#procs-right").empty().html(data.html);
			
			if($('#checkedOut').length > 0) {
					$("#procs3 ul[rel=pspgrids] .active-link .icon-checked-out").addClass('icon-checked-out-active');
				} else {
					$("#procs3 ul[rel=pspgrids] .active-link .icon-checked-out").removeClass('icon-checked-out-active');
				}
			
			if(list == 0) {
				switch (data.access) {
					case "sysadmin": case "admin":
						procsActions(12);
					break;
					case "guest":
						procsActions(5);
					break;
				}
			} else {
				switch (data.access) {
					case "sysadmin": case "admin" :
						if(list == "<li></li>") {
							procsActions(3);
						} else {
							procsActions(12);
						}
					break;
					case "guest":
						if(list == "<li></li>") {
							procsActions();
						} else {
							procsActions(5);
						}
					break;
				}
				
			}
			initProcsContentScrollbar();
			}
		});	
	}


	this.actionNew = function() {
		var module = this;
		var cid = $('#procs input[name="id"]').val()
		module.checkIn(cid);
	
		var id = $('#procs').data('second');
		$.ajax({ type: "GET", url: "/", dataType: 'json', data: 'path=apps/procs/modules/pspgrids&request=createNew&id=' + id, cache: false, success: function(data){
			$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/procs/modules/pspgrids&request=getList&id="+id, success: function(list){
				$("#procs3 ul[rel=pspgrids]").html(list.html);
				$('#procs_pspgrids_items').html(list.items);
				var liindex = $("#procs3 ul[rel=pspgrids] .module-click").index($("#procs3 ul[rel=pspgrids] .module-click[rel='"+data.id+"']"));
				$("#procs3 ul[rel=pspgrids] .module-click:eq("+liindex+")").addClass('active-link');
				var moduleidx = $("#procs3 ul").index($("#procs3 ul[rel=pspgrids]"));
				module.getDetails(moduleidx,liindex);
				setTimeout(function() { $('#procs-right .focusTitle').trigger('click'); }, 800);
				}
			});
			}
		});
	}


	this.actionDuplicate = function() {
		var module = this;
		var cid = $('#procs input[name="id"]').val()
		module.checkIn(cid);
		var id = $("#procs").data("third");
		var pid = $("#procs").data("second");
		$.ajax({ type: "GET", url: "/", data: 'path=apps/procs/modules/pspgrids&request=createDuplicate&id=' + id, cache: false, success: function(mid){
			$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/procs/modules/pspgrids&request=getList&id="+pid, success: function(data){																																																																				
				$("#procs3 ul[rel=pspgrids]").html(data.html);
				$('#procs_pspgrids_items').html(data.items);
				var moduleidx = $("#procs3 ul").index($("#procs3 ul[rel=pspgrids]"));
				var liindex = $("#procs3 ul[rel=pspgrids] .module-click").index($("#procs3 ul[rel=pspgrids] .module-click[rel='"+mid+"']"));
				module.getDetails(moduleidx,liindex);
				$("#procs3 ul[rel=pspgrids] .module-click:eq("+liindex+")").addClass('active-link');
				}
			});
			}
		});
	}
	
	
	this.actionBin = function() {
		var module = this;
		var cid = $('#procs input[name="id"]').val()
		module.checkIn(cid);
		var txt = ALERT_DELETE;
		var langbuttons = {};
		langbuttons[ALERT_YES] = true;
		langbuttons[ALERT_NO] = false;
		$.prompt(txt,{ 
			buttons:langbuttons,
			submit: function(e,v,m,f){		
				if(v){
					var id = $("#procs").data("third");
					var pid = $("#procs").data("second");
					$.ajax({ type: "GET", url: "/", data: "path=apps/procs/modules/pspgrids&request=binPspgrid&id=" + id, cache: false, success: function(data){
							if(data == "true") {
								$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/procs/modules/pspgrids&request=getList&id="+pid, success: function(data){
									$("#procs3 ul[rel=pspgrids]").html(data.html);
									$('#procs_pspgrids_items').html(data.items);
									if(data.html == "<li></li>") {
										procsActions(3);
										//alert('yo');
									} else {
										procsActions(12);
									}
									var moduleidx = $("#procs3 ul").index($("#procs3 ul[rel=pspgrids]"));
									var liindex = 0;
									module.getDetails(moduleidx,liindex);
									$("#procs3 ul[rel=pspgrids] .module-click:eq("+liindex+")").addClass('active-link');
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
		$.ajax({ type: "GET", url: "/", async: false, data: 'path=apps/procs/modules/pspgrids&request=checkinPspgrid&id='+id, success: function(data){
			if(!data) {
				prompt("something wrong");
			}
			}
		});
	}
	
	
	this.actionRefresh = function() {
		var id = $("#procs").data("third");
		var pid = $("#procs").data("second");
		$("#procs3 ul[rel=pspgrids] .active-link").trigger("click");
		$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/procs/modules/pspgrids&request=getList&id="+pid, success: function(data){																																																																				
			$("#procs3 ul[rel=pspgrids]").html(data.html);
			$('#procs_pspgrids_items').html(data.items);
			var liindex = $("#procs3 ul[rel=pspgrids] .module-click").index($("#procs3 ul[rel=pspgrids] .module-click[rel='"+id+"']"));
			$("#procs3 ul[rel=pspgrids] .module-click:eq("+liindex+")").addClass('active-link');
			}
		});
	}


	this.actionPrint = function() {
		var id = $("#procs").data("third");
		var url ='/?path=apps/procs/modules/pspgrids&request=printDetails&id='+id;
		$("#documentloader").attr('src', url);
	}


	this.actionSend = function() {
		var id = $("#procs").data("third");
		$.ajax({ type: "GET", url: "/", data: "path=apps/procs/modules/pspgrids&request=getSend&id="+id, success: function(html){
			$("#modalDialogForward").html(html).dialog('open');
			}
		});
	}


	this.actionSendtoResponse = function() {
		var id = $("#procs").data("third");
		$.ajax({ type: "GET", url: "/", data: "path=apps/procs/modules/pspgrids&request=getSendtoDetails&id="+id, success: function(html){
			$("#procspspgrid_sendto").html(html);
			//$("#modalDialogForward").dialog('close');
			}
		});
	}
	
	
	this.sortclick = function (obj,sortcur,sortnew) {
		var module = this;
		var cid = $('#procs input[name="id"]').val()
		module.checkIn(cid);
		
		var fid = $("#procs2 .module-click:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/procs/modules/pspgrids&request=getList&id="+fid+"&sort="+sortnew, success: function(data){
			$("#procs3 ul[rel=pspgrids]").html(data.html);
			$('#procs_pspgrids_items').html(data.items);
			obj.attr("rel",sortnew);
			obj.removeClass("sort"+sortcur).addClass("sort"+sortnew);
			var id = $("#procs3 ul[rel=pspgrids] .module-click:eq(0)").attr("rel");
			$('#procs').data('third',id);
			if(id == undefined) {
				return false;
			}
			var moduleidx = $("#procs3 ul").index($("#procs3 ul[rel=pspgrids]"));
			module.getDetails(moduleidx,0);
			$("#procs3 ul[rel=pspgrids] .module-click:eq(0)").addClass('active-link');
		}
		});
	}


	this.sortdrag = function (order) {
		var fid = $("#procs").data("second");
		$.ajax({ type: "GET", url: "/", data: "path=apps/procs/modules/pspgrids&request=setOrder&"+order+"&id="+fid, success: function(html){
			$("#procs3 .sort:visible").attr("rel", "3");
			$("#procs3 .sort:visible").removeClass("sort1").removeClass("sort2").addClass("sort3");
			}
		});
	}

	
	this.actionDialog = function(offset,request,field,append,title,sql) {
		switch(request) {
			case "getProjectFolderDialog":
				$.ajax({ type: "GET", url: "/", data: 'path=apps/projects&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
					$("#modalDialog").html(html);
					//$("#modalDialog").dialog('option', 'height', 50);
					$("#modalDialog").dialog('option', 'position', offset);
					$("#modalDialog").dialog('option', 'title', title);
					$("#modalDialog").dialog('open');
					}
				});
			break;
			case "getAccessDialog":
				$.ajax({ type: "GET", url: "/", data: 'path=apps/procs&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
					$("#modalDialog").html(html);
					//$("#modalDialog").dialog('option', 'height', 50);
					$("#modalDialog").dialog('option', 'position', offset);
					$("#modalDialog").dialog('option', 'title', title);
					$("#modalDialog").dialog('open');
					}
				});
			break;
			case "getPspgridStatusDialog":
				$.ajax({ type: "GET", url: "/", data: 'path=apps/procs/modules/pspgrids&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
					$("#modalDialog").html(html);
					$("#modalDialog").dialog('option', 'position', offset);
					$("#modalDialog").dialog('option', 'title', title);
					$("#modalDialog").dialog('open');
					}
				});
			break;
			case "getDocumentsDialog":
				var id = $("#procs").data("second");
				$.ajax({ type: "GET", url: "/", data: 'path=apps/procs/modules/documents&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql+'&id=' + id, success: function(html){
					$("#modalDialog").html(html);
					$("#modalDialog").dialog('option', 'position', offset);
					$("#modalDialog").dialog('option', 'title', title);
					$("#modalDialog").dialog('open');
					}
				});
			break;
			default:
			$.ajax({ type: "GET", url: "/", data: 'path=apps/procs&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
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
				var elepos = el.position();
				var id = parseInt(el.attr('id').replace(/procspspgriditem_/, ""));
				currentProcPspgridEditedNote = id;
				
				var title = el.find('div.itemTitle').text();
				var text = el.find('div.itemText').text();
				var team = el.find('div.itemTeam').html();
				var costs_employees = el.find('div.itemCostsEmployees').text();
				var costs_materials = el.find('div.itemCostsMaterials').text();
				var costs_external = el.find('div.itemCostsExternal').text();
				var costs_other = el.find('div.itemCostsOther').text();
				var days = el.find('span.days').text();
				var team_ct = el.find('div.itemTeamct').html();
				var status = el.find('div.itemStatus').text();
				
				var html = this.coPopupEdit;
				var pclass = this.coPopupEditClass;
				var copopup = $('#co-popup');
				copopup.html(html);
				copopup.find('.title').val(title);
				copopup.find('.text').val(text);
				copopup.find('.costs_employees').val(costs_employees);
				copopup.find('.costs_materials').val(costs_materials);
				copopup.find('.costs_external').val(costs_external);
				copopup.find('.costs_other').val(costs_other);
				copopup.find('.days').val(days);
				copopup.find('.statusButton').removeClass('active');
				copopup.find('.statusButton:eq('+status+')').addClass('active');
				$('#coPopup-team').html(team);
				$('#coPopup-team_ct').html(team_ct);
				$('#co-popup a.binItem').attr('rel',id);
				$('#coPopupMS').attr('rel',id);
				$('#coPopupMS').removeClass('active');
				copopup.find('.tohide').show();
				copopup.find('.tohideMS').show();
				switch(request) {
					case 'title':
						copopup.find('.tohide').hide();
					break;
					case 'ms':
						copopup.find('.tohideMS').hide();
						$('#coPopupMS').addClass('active');
					break;
				}
				copopup
					.removeClass(function (index, css) {
						   return (css.match (/\bpopup-\w+/g) || []).join(' ');
					   })
					.addClass(pclass)
					.position({
						  my: "center center",
						  at: "right+170 center",
						  of: el,
						  collision: 'flip fit',
						  within: '#procs-right .scroll-pane',
						  using: function(coords, ui) {
								var $modal = $(this),
								t = coords.top,
								l = coords.left,
								className = 'switch-' + ui.horizontal;
								$modal.css({
									//width: 0,
									//display: 'none',
									left: l + 'px',
									top: t + 'px'
								}).removeClass(function (index, css) {
						   			return (css.match (/\bswitch-\w+/g) || []).join(' ');
					   			})
								.addClass(className);
								
								//copopup.animate(css, 200, "linear");
								//copopup.fadeIn(5000);
								copopup.hide().animate({width:'toggle'}, function() { copopup.find('.arrow').offset({ top: ui.target.top+25 }); })
				  		}
					});
	}
	
	

	this.insertStatus = function(rel,text) {
		var module = this;
		var html = '<div class="listmember" field="procspspgrid_status" uid="'+rel+'" style="float: left">' + text + '</div>';
		$("#procspspgrid_status").html(html);
		$("#modalDialog").dialog("close");
		$("#procspspgrid_status").next().val("");
		$('#procs .coform').ajaxSubmit(module.poformOptions);
	}


	this.insertStatusDate = function(rel,text) {
		var html = '<div class="listmember" field="procspspgrid_status" uid="'+rel+'" style="float: left">' + text + '</div>';
		$("#procspspgrid_status").html(html);
		$("#modalDialog").dialog("close");
		$("#procspspgrid_status").nextAll('img').trigger('click');
	}
	
	
	this.insertFolderFromDialog = function(field,gid,title) {
		var html = '<span class="listmember" uid="' + gid + '" field="'+field+'">' + title + '</span>';
		$("#"+field).html(html);
		$("#modalDialog").dialog('close');
	}
	
	this.coPopupStatus = function(status) {
		var id = currentProcPspgridEditedNote;
		var note = $('#procspspgriditem_'+id);
		var curstatus = note.find('div.itemStatus').text();
		if( curstatus != status) {
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/procs/modules/pspgrids&request=setItemStatus&id="+id+"&status=" + status, success: function(forums){
				switch(curstatus) {
					case '0':
						note.removeClass('planned');
					break;
					case '1':
						note.removeClass('progress');
					break;
					case '2':
						note.removeClass('finished');
					break;
				}
				switch(status) {
					case '0':
						note.addClass('planned');
					break;
					case '1':
						note.addClass('progress');
					break;
					case '2':
						note.addClass('finished');
					break;
				}
				note.find('div.itemStatus').text(status);
				var col = note.parent();
				var notes = col.find('>div').length;
				var notes_planned = col.find('>div.planned').length;
				var notes_progress = col.find('>div.progress').length;
				var notes_finished = col.find('>div.finished').length;
				if(notes == notes_planned) {
					col.prev().prev().find('>div').removeClass('progress finished').addClass('planned');
				} else if(notes == notes_finished) {
					col.prev().prev().find('>div').removeClass('planned progress').addClass('finished');
				} else {
					col.prev().prev().find('>div').removeClass('planned finished').addClass('progress');
				}
			}
		});
		}
	}
	
this.coPopupType = function() {
		var id = currentProcPspgridEditedNote;
		var note = $('#procspspgriditem_'+id);
		var curtype = note.find('div.itemMilestone').text();
		if(curtype == 0) {
			var type = 1;
		} else {
			var type = 0;
		}
			$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/procs/modules/pspgrids&request=setItemType&id="+id+"&type=" + type, success: function(forums){
				switch(type) {
					case 0:
						note.attr('request','note');
						note.find('div.light').removeClass('ismilestone');
						$('#coPopupMS').removeClass('active');
					break;
					case 1:
						note.attr('request','ms');
						note.find('div.light').addClass('ismilestone');
						$('#coPopupMS').addClass('active');
					break;
				}
				note.find('div.itemMilestone').text(type);
			}
		});
	}

	this.coPopupContactInsert = function() {
		var id = currentProcPspgridEditedNote;
		var note = $('#procspspgriditem_'+id);
		var team = $('#coPopup-team').html();
		note.find('div.itemTeam').html(team);
		var team = $('#coPopup-team a:visible').text();
		note.find('div.itemTeamprint').text(team);
		this.saveItem();
	}

	this.coPopupContactGroupInsert = function() {
		var id = currentProcPspgridEditedNote;
		var note = $('#procspspgriditem_'+id);
		var team = $('#coPopup-team').html();
		//$('#procspspgriditem-team-'+id).html(team);
		note.find('div.itemTeam').html(team);
		var team = $('#coPopup-team a:visible').text();
		//$('#procspspgriditem-teamprint-'+id).text(team);
		note.find('div.itemTeamprint').text(team);
		this.saveItem();
	}
	
	this.coPopupContactTextInsert = function() {
		var id = currentProcPspgridEditedNote;
		var note = $('#procspspgriditem_'+id);
		var team_ct = $('#coPopup-team_ct').html();
		//$('#procspspgriditem-team_ct-'+id).html(team_ct);
		note.find('div.itemTeamct').html(team_ct);
		this.saveItem();
	}
	
	this.coPopupContactDelete = function() {
		var id = currentProcPspgridEditedNote;
		var note = $('#procspspgriditem_'+id);
		var team = $('#coPopup-team').html();
		//$('#procspspgriditem-team-'+id).html(team);
		note.find('div.itemTeam').html(team);
		var team = $('#coPopup-team a:visible').text();
		//$('#procspspgriditem-teamprint-'+id).text(team);
		note.find('div.itemTeamprint').text(team);
		this.saveItem();
	}
	
	this.coPopupContactTextDelete = function() {
		var id = currentProcPspgridEditedNote;
		var note = $('#procspspgriditem_'+id);
		var team_ct = $('#coPopup-team_ct').html();
		//$('#procspspgriditem-team_ct-'+id).html(team_ct);
		note.find('div.itemTeamct').html(team_ct);
		this.saveItem();
	}
	
	// notes
	this.saveItem = function(id) {
		var id = currentProcPspgridEditedNote;
		var note = $('#procspspgriditem_'+id);
		var title = $('#co-popup input.title').val();
		note.find('div.itemTitle').text(title);
		
		var team = processCoPopupList('coPopup-team');
		var team_html = $('#coPopup-team').html();
		note.find('div.itemTeam').html(team_html);
		
		var team_ct = processCoPopupListCustomTextApps('coPopup-team_ct');
		
		var text = $('#co-popup textarea.text').val();
		note.find('div.itemText').text(text);
		
		var days = $('#co-popup input.days').val();
		if(days == '') { days = 0; }
		note.find('span.days').text(days);
		
		var costs_employees = $('#co-popup input.costs_employees').val();
		if(costs_employees == '') { costs_employees = 0; }
		note.find('div.itemCostsEmployees').text(costs_employees);
		
		var costs_materials = $('#co-popup input.costs_materials').val();
		if(costs_materials == '') { costs_materials = 0; }
		note.find('div.itemCostsMaterials').text(costs_materials);
		
		var costs_external = $('#co-popup input.costs_external').val();
		if(costs_external == '') { costs_external = 0; }
		note.find('div.itemCostsExternal').text(costs_external);
		
		var costs_other = $('#co-popup input.costs_other').val();
		if(costs_other == '') { costs_other = 0; }
		note.find('div.itemCostsOther').text(costs_other);
		
		$.ajax({ type: "POST", url: "/", data: { path: 'apps/procs/modules/pspgrids', request: 'savePspgridNote', id: id, title: title, text: text, team: team, team_ct: team_ct, days: days, costs_employees: costs_employees, costs_materials: costs_materials, costs_external: costs_external, costs_other: costs_other }, success: function(data){
			var costs = 0;
			var col = note.parent();
			col.find('div.showCoPopup[request="note"] div.costs').each(function() {
				costs += parseInt($(this).html());
			})
			col.prev().prev().find('span.totalcosts').html(costs).number( true, 0, '', '.' );
			var tcosts = 0;
			$('#procs-pspgrid div.showCoPopup[request="note"] div.costs').each(function() {
				tcosts += parseInt($(this).text());
			})
			$('#procPspgridCosts').text(tcosts).number( true, 0, '', '.' );
			
			var days = 0;
			col.find('div.showCoPopup[request="note"] span.days').each(function() {
				days += parseInt($(this).html());
			})
			col.prev().prev().find('span.totaldays').html(days);
			
			var tdays = 0;
			$('#procs-pspgrid div.showCoPopup[request="note"] span.days').each(function() {
				tdays += parseInt($(this).text());
			})
			$('#procPspgridDays').text(tdays);
			}
		});
	}


	this.newItemOption = function(ele,what) {
		switch(what) {
			case 'notetitle':
				var col = parseInt(ele.parent().parent().attr("id").replace(/pspgridscol_/, ""));
				var pid = $("#procs").data("third");
				//ele.parent().addClass('planned');
				$.ajax({ type: "GET", url: "/", data: "path=apps/procs/modules/pspgrids&request=savePspgridNewManualTitle&pid="+pid+"&col="+col, cache: false, success: function(html){	
						var phase = $('#pspgridscol_'+col+' .procs-col-title');
						phase.html(html);
						phase.find('>div').fadeIn(function() {
							$(this).trigger('click'); 
							phase.next().next().trigger('sortupdate');
						})
					}
				});
			break;
			case 'note':
				var idx = $('#procs-pspgrid .newNote').index(ele);
				var pid = $("#procs").data("third");
				$.ajax({ type: "GET", url: "/", data: "path=apps/procs/modules/pspgrids&request=savePspgridNewManualNote&pid="+pid, cache: false, success: function(html){
						var phase = $('#procs-pspgrid .procs-phase:eq('+idx+')');
						phase.append(html);
						phase.find('>div:last').slideDown(function() {
							$(this).trigger('click'); 
							phase.trigger('sortupdate');
						})
					}
				});
			break;
		}
}

	/*this.newItem = function() {
		var mid = $("#procs").data("third");
		var num = parseInt($("#procs-right .task_sort").size());
		$.ajax({ type: "GET", url: "/", data: "path=apps/procs/modules/pspgrids&request=addTask&mid=" + mid + "&num=" + num + "&sort=" + num, success: function(html){
			$('#procspspgridtasks').append(html);
			$('.pspgridouter:eq('+idx+')').slideDown(function() {
				$(this).find(":text:eq(0)").focus();
				if(idx == 6) {
				$('#procs-right .addTaskTable').clone().insertAfter('#phasetasks');
				}
				initProcsContentScrollbar();
			});
			}
		});
	}*/


	this.binItem = function(id) {
		var note = $("#procspspgriditem_"+id);
		var txt = ALERT_DELETE;
		var langbuttons = {};
		langbuttons[ALERT_YES] = true;
		langbuttons[ALERT_NO] = false;
		$.prompt(txt,{ 
			buttons:langbuttons,
			submit: function(e,v,m,f){		
				if(v){
					$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/procs/modules/pspgrids&request=binItem&id="+id, success: function(data){
						if(data){
							if(note.hasClass('colTitle')) {
								note.fadeOut(function() { 
									phase = note.parent().next();
									note.parent().html('<span class="newNoteItem newItemOption newNoteTitle" rel="notetitle"></span>');
									note.remove();
								});
							} else {
								note.slideUp(function() { 
									phase = note.parent();
									note.remove();
									phase.trigger('sortupdate');
								});
							}
						} 
						}
					});
				} 
			}
		});	
	}
	
	
	this.binColumn = function(id) {
		var txt = ALERT_DELETE;
		var langbuttons = {};
		langbuttons[ALERT_YES] = true;
		langbuttons[ALERT_NO] = false;
		$.prompt(txt,{ 
			buttons:langbuttons,
			submit: function(e,v,m,f){		
				if(v){
					$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/procs/modules/pspgrids&request=binPspgridColumn&id="+id, success: function(text){						
							$('#pspgridscol_'+id).animate({width: 0}, function(){ 
								$(this).remove();
								$("#procs-pspgrid").width($("#procs-pspgrid").width()-195);
								self.updateOuterHeight();
							});
						}
					});
				} 
			}
		});	
	}


	this.actionHelp = function() {
		var url = "/?path=apps/procs/modules/pspgrids&request=getHelp";
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/procs/modules/pspgrids&request=deletePspgrid&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#pspgrid_'+id).slideUp();
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/procs/modules/pspgrids&request=restorePspgrid&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#pspgrid_'+id).slideUp();
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/procs/modules/pspgrids&request=deletePspgridColumn&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#pspgrid_col_'+id).slideUp();
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/procs/modules/pspgrids&request=restorePspgridColumn&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#pspgrid_col_'+id).slideUp();
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/procs/modules/pspgrids&request=deletePspgridTask&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#pspgrid_task_'+id).slideUp();
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/procs/modules/pspgrids&request=restorePspgridTask&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#pspgrid_task_'+id).slideUp();
						}
					}
					});
				} 
			}
		});
	}


	this.actionConvert = function() {
		$('#modalDialogProcsPspgrid').slideDown();
	}
	
	this.updateOuterHeight = function() {
		var maxHeight = Math.max.apply(null, $("#procs-pspgrid >div").map(function () {
			return $(this).height();
			}).get());
		$('#procs-pspgrid').height(maxHeight+75);
	}
	
	this.updateTotals = function(c) {
		var items = c.find('>div').size();
		var items_planned = c.find('>div.planned').length;
		var items_progress = c.find('>div.progress').length;
		var items_finished = c.find('>div.finished').length;
		if(items == items_planned) {
			c.prev().prev().find('>div').removeClass('progress finished').addClass('planned');
		} else if(items == items_finished) {
			c.prev().prev().find('>div').removeClass('planned progress').addClass('finished');
		} else {
			c.prev().prev().find('>div').removeClass('planned finished').addClass('progress');
		}
		var costs = 0;
		c.find('div.showCoPopup[request="note"] div.costs').each(function() {
			costs += parseInt($(this).html());
		})
		c.prev().prev().find('span.totalcosts').html(costs).number( true, 0, '', '.' );
		var tcosts = 0;
		$('#procs-pspgrid div.showCoPopup[request="note"] div.costs').each(function() {
			tcosts += parseInt($(this).text());
		})
		$('#procPspgridCosts').text(tcosts).number( true, 0, '', '.' );
		
		var days = 0;
		c.find('div.showCoPopup[request="note"] span.days').each(function() {
			days += parseInt($(this).html());
		})
		c.prev().prev().find('span.totaldays').html(days);
		var tdays = 0;
		$('#procs-pspgrid div.showCoPopup[request="note"] span.days').each(function() {
			tdays += parseInt($(this).text());
		})
		$('#procPspgridDays').text(tdays);
	}

}
var procs_pspgrids = new procsPspgrids('procs_pspgrids');
var currentProcPspgridEditedNote = 0;

$(document).ready(function() {
// console
	$('#procs-console-pspgrids-notes>div').livequery( function() {
		$(this).draggable({
			connectToSortable: ".procs-phase",
			helper: "clone",
			//cursor: "move",
			appendTo: '#procs-right',
			zIndex: 102,
			revert: 'invalid',
			start: function(e, ui) {
				$(ui.helper).addClass("ui-draggable-helper-pspgrid");
			}
		});
	});

	$('#procs-console-pspgrids').livequery( function() {
		$(this).draggable({handle: 'h3', containment: '#procs-right .scroll-pane', cursor: 'move'})
		.resizable({ minHeight: 25, minWidth: 230});
	});

// pspgrid outer
	$('#procs-pspgrid').livequery( function() {
		$(this).sortable({
			items: '>div',
			//handle: 'h3',
			handle: '.dragColActive',
			axis: 'x',
			tolerance: 'pointer',
			containment: '#procs-pspgrid',
			update: function(event,ui) {
				var order = $(this).sortable("serialize");
				$.ajax({ type: "GET", url: "/", data: "path=apps/procs/modules/pspgrids&request=savePspgridColumns&"+ order, cache: false, success: function(data){
					}
				});
			}
		})
	});

// Title
	$('#procs-pspgrid .procs-col-title').livequery( function() {
		$(this).droppable({
			accept: '.droppable',
			drop: function( event, ui ) {
				var tocopy = false;
				var orig = false;
				var attr = ui.draggable.attr('id');
				if($(this).find('>div').length > 0) { //title is set
					tocopy = $(this).html();
					tocopyid = $(this).find('>div').attr('rel');
					orig = $(this).find('>div').attr('id');
					if(attr != 'undefined') {
						if(orig == attr) {
							return false;	
						}
					}
				}
				var idx = $('#procs-pspgrid .procs-col-title').index(this);
				//var c = $('#procs-pspgrid .procs-phase:eq('+idx+')');
				if(tocopy) {
					//$('#procs-pspgrid .procs-phase:eq('+idx+')').prepend(tocopy);
					//$('#procs-pspgrid .procs-phase:eq('+idx+') > div:eq(0)').removeClass('colTitle').removeClass('ui-sortable-helper').removeClass('ui-draggable').removeClass('ui-draggable-dragging').attr('style','');
					$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/procs/modules/pspgrids&request=binItem&id="+tocopyid , success: function(data){
						if(data){} 
						}
					});
				}
				var insert = ui.draggable.clone();
				$(this).html(insert.attr('style','').addClass('colTitle').removeClass('ui-sortable-helper').attr('request','title'));
				var pid = $("#procs").data("third");
				var col = parseInt($(this).parent().attr("id").replace(/pspgridscol_/, ""));
				
				if (typeof attr == 'undefined' || attr == false) {
					var id = ui.draggable.attr('rel');
					$.ajax({ type: "GET", url: "/", data: "path=apps/procs/modules/pspgrids&request=savePspgridNewNoteTitle&pid="+pid+"&id=" + id+"&col="+col, cache: false, success: function(id){
						insert.attr('id','procspspgriditem_' + id).attr('rel',id);
						//insert.find('div.itemTitle').attr('id','procspspgriditem-title-' + id);
						//insert.find('div.itemText').attr('id','procspspgriditem-text-' + id);
						//$('#procs-pspgrid .procs-phase:eq('+idx+')').trigger('sortupdate');
						}
					});
				} else { // if dropped from list
					if(ui.draggable.hasClass('colTitle')) {
						ui.draggable.parent().html('<span class="newNoteItem newItemOption newNoteTitle" rel="notetitle"></span>');
					}
					var dragidx = $('#procs-pspgrid .procs-phase').index(ui.draggable.parent());
					ui.draggable.remove();
					var id = attr.replace(/procspspgriditem_/, "");
					$.ajax({ type: "GET", url: "/", async: false, data: "path=apps/procs/modules/pspgrids&request=savePspgridNoteTitle&id=" + id + "&col="+col, cache: false, success: function(id){
						/*if(dragidx != idx) {
							$('#procs-pspgrid .procs-phase:eq('+idx+')').trigger('sortupdate');
						}*/
						}
					});
				}
			}
		})	
	})

	$('#procs-pspgrid .procs-col-title>div').livequery( function() {
		$(this).draggable({
			connectToSortable: ".procs-phase",
			helper: "clone",
			//cursor: "move",
			revert: 'invalid',
			appendTo: '#procs-right',
			zIndex: 101,
			start: function(e, ui) {
				$(ui.helper).addClass("ui-draggable-helper-pspgrid");
			}
		});
	})


// SORTABLE LIST
	$('#procs-pspgrid .procs-phase').livequery( function() {
		$(this).sortable({
			items: '>div',
			//handle: '.dragItem',
			cursor: "move",
			connectWith: '.procs-phase,.procs-col-title',
			receive: function (event, ui) { // add this handler
				setTimeout(function() {
					if(ui.item.hasClass('colTitle')) {
						ui.item.parent().html('<span rel="notetitle" class="newNoteItem newItemOption newNoteTitle"></span>');
						ui.item.remove();
					}
				}, 100);
			}
		}).disableSelection().bind('sortupdate', function(event, ui) {
			var col = parseInt($(this).parent().attr("id").replace(/pspgridscol_/, ""));
			var idx = $('#procs-pspgrid .procs-phase').index(this);
			procs_pspgrids.updateOuterHeight();
			$('#procs-pspgrid .procs-phase:eq('+idx+')>div').each(function(index) {
				var div = $(this);
				var attr = div.attr('id');
				if (typeof attr == 'undefined' || attr == false) {
					if(div.hasClass('colTitle')) {
						var id = div.attr('rel');
						div.removeClass('colTitle').removeClass('ui-draggable').removeClass('ui-draggable-dragging').attr('style','').attr('request','note');
						div.attr('id','procspspgriditem_' + id);			
					} else {
						var id = div.attr('rel');
						if (typeof id != 'undefined') {
							var pid = $("#procs").data("third");
							$.ajax({ type: "GET", url: "/", async: false, data: "path=apps/procs/modules/pspgrids&request=savePspgridNewNote&pid="+pid+"&id=" + id, cache: false, success: function(id){
								div.attr('id','procspspgriditem_' + id);
								div.find('div.itemTitle').attr('id','procspspgriditem-title-' + id);
								div.find('div.itemText').attr('id','procspspgriditem-text-' + id);
								div.append('<div id="procspspgriditem-team-'+ id +'" style="display: none;"></div><div id="procspspgriditem-costs_employees-'+ id +'" style="display: none;" class="costs">0</div><div id="procspspgriditem-costs_materials-'+ id +'" style="display: none;" class="costs">0</div><div id="procspspgriditem-costs_external-'+ id +'" style="display: none;" class="costs">0</div><div id="procspspgriditem-costs_other-'+ id +'" style="display: none;" class="costs">0</div><div id="procspspgriditem-days-'+ id +'" style="display: none;" class="days">0</div><div id="procspspgriditem-team_ct-'+ id +'" style="display: none;"><a class="ct-content" field="coPopup-team_ct"></a></div>');
								}
							});
						}
					}
				}
			});
			var order = $('#procs-pspgrid .procs-phase:eq('+idx+')').sortable("serialize");
			$.ajax({ type: "GET", url: "/", data: "path=apps/procs/modules/pspgrids&request=savePspgridItems&col="+col+"&"+ order, cache: false, success: function(data){
				var titleset = $('div.procs-col-title:eq('+idx+')').html();
				var title = 0;
				if(titleset != "" && titleset != '<span class="newNoteItem newNoteTitle"></span>') {
					title = 1;
				}
				var c = $('#procs-pspgrid .procs-phase:eq('+idx+')');
				procs_pspgrids.updateTotals(c);
				}
			});
    	});
	})


	$(document).on('click', '#procs-console-pspgrids a.collapse', function(e) {
		e.preventDefault();
		var height = 25;
		if($(this).hasClass('closed')) {
			var height = 250;
		}
		$(this).toggleClass('closed').parent().parent().animate({'height': height});
	});	


	$(document).on('click', '#procs-pspgrid-add-column', function(e) {
		e.preventDefault();
		var pid = $("#procs").data("third");
		var sor = $('#procs-pspgrid>div').size();
		var styles = '';
		$("#procs-pspgrid").width($("#procs-pspgrid").width()+230);
		$.ajax({ type: "GET", url: "/", data: "path=apps/procs/modules/pspgrids&request=newPspgridColumn&id="+pid+"&sort="+sor, cache: false, success: function(num){
			$("#procs-pspgrid").append('<div id="pspgridscol_' + num + '"><div class="dragCol dragColActive"><div id="procs-pspgrid-col-delete-' + num + '" class="procs-pspgrid-column-delete"><span class="icon-delete"></span></div></div><div class="procs-col-title ui-droppable"><span rel="notetitle" class="newNoteItem newItemOption newNoteTitle"></span></div><div class="pspgrids-spacer"></div><div class="procs-phase procs-phase-design ui-sortable"></div><span rel="note" class="newNoteItem newItemOption newNote"></span><span style="display: block; background: #fff; height: 20px; width: 10px; margin: -31px 0 0 0;" class="newNoteBlind"></span></div>').sortable("refresh");
			}
		});
	})


	$(document).on('click', 'div.procs-pspgrid-column-delete', function(e) {
		e.preventDefault();
		var id = $(this).attr("id").replace(/procs-pspgrid-col-delete-/, "");
		procs_pspgrids.binColumn(id);
	});


	$(document).on('click', 'span.actionProcsPspgridsConvert', function(e) {
		e.preventDefault();
		var id = $("#procs").data("third");
		var kickofffield = Date.parse($("#procs input[name='kickoff']").val());
		var kickoff = kickofffield.toString("yyyy-MM-dd");
		var folder = $('#procspspgridprojectsfolder>span').attr('uid');
		if(typeof folder == 'undefined' || folder == false) {
			$.prompt(ALERT_CHOOSE_FOLDER);
			return false;
		}
		var protocol = $("#pspgridProtocol").val();
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/procs/modules/pspgrids&request=convertToProject&id="+id+"&kickoff="+kickoff+"&folder="+folder+"&protocol="+protocol, success: function(data){																																																	  			$.prompt(ALERT_SUCCESS_PROJECT_EXPORT + '"'+data.fid+'"');
			var html = '<div class="text11">Projektordner: <span class="listmember">' + data.fid + '</span>, ' + data.created_user + ', ' + data.created_date + '</div';
			$('#project_created').append(html);
			$("#modalDialogProcsPspgrid").slideUp(function() {		
				initProcsContentScrollbar();							
			});
			}
		});
	})

	$(document).on('click', '#modalDialogProcsPspgridClose', function(e) {
		e.preventDefault();
		$("#modalDialogProcsPspgrid").slideUp(function() {
			initProcsContentScrollbar();
		});
	});

	$('input.currency').livequery( function() {
		$(this).number( true, 0, '', '.' );
	})
	$('span.totalcosts, #procPspgridCosts').livequery( function() {
		$(this).number( true, 0, '', '.' );
	})
	$(document).on('click', '#coPopupMS', function(e) {
		e.preventDefault();
		var id = $(this).attr('rel');
		$('.tohideMS').toggle();
		$('#co-popup').position({
						  my: "center center",
						  at: "right+170 center",
						  of: '#procspspgriditem_'+id,
						  collision: 'flip fit',
						  within: '#procs-right .scroll-pane',
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
								$('#co-popup').find('.arrow').offset({ top: ui.target.top });
				  		}
					});
		procs_pspgrids.coPopupType();
	})
	
});