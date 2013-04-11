/* grids Object */
function procsGrids(name) {
	this.name = name;
	this.coPopupEditClass = 'popup-full';
	var self = this;
	this.coPopupEdit = '';
	//this.coPopupEdit = '<div class="head">Bearbeiten</div><div class="content"><div class="fieldset2"><label>Titel</label><input type="text" class="title" maxlength="60" value="" /></div><div class="fieldset2"><label><span class="content-nav showDialog" request="getContactsDialog" field="coPopup-team" append="1"><span>Verantwortung</span></span></label><div class="contacts"><div id="coPopup-team" class="itemlist-field"></div><div id="coPopup-team_ct" class="itemlist-field"><a field="coPopup-team_ct" class="ct-content"></a></div></div><div style="clear: both;"></div></div><div class="fieldset2 tohide"><label>Dauer</label><input type="text" class="hours short" maxlength="100" value="" /> Stunde/n</div><div class="fieldset2 tohide"><label>Personalkosten</label><input id="personal" type="text" class="costs_employees currency" maxlength="60" value="" /></div><div class="fieldset2 tohide"><label>Materialkosten</label><input type="text" class="costs_materials currency" maxlength="60" value="" /></div><div class="fieldset2 tohide"><label>Fremdleistung</label><input type="text" class="costs_external currency" maxlength="60" value="" /></div><div class="fieldset2 tohide"><label>Sonstige Kosten</label><input type="text" class="costs_other currency" maxlength="60" value="" /></div><div class="fieldset"><label>Beschreibung</label><textarea class="text"></textarea></div><ul class="popupButtons"><li><a href="#" class="binItem alert" rel="">'+DATEPICKER_CLEAR+'</a></li></ul></div><span class="arrow"></span>';
	$.ajax({ type: "GET", url: "/", data: "path=apps/procs/modules/grids&request=getCoPopup", success: function(html){
	self.coPopupEdit = html;
																																		  }});


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
		
		formData[formData.length] = processListApps('grid_access');
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
		var id = $("#procs3 ul:eq("+moduleidx+") .module-click:eq("+liindex+")").attr("rel");
		$('#procs').data({ "third" : id});
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/procs/modules/grids&request=getDetails&id="+id, success: function(data){
			$("#procs-right").empty().html(data.html);
			
			if($('#checkedOut').length > 0) {
					$("#procs3 ul[rel=grids] .active-link .icon-checked-out").addClass('icon-checked-out-active');
				} else {
					$("#procs3 ul[rel=grids] .active-link .icon-checked-out").removeClass('icon-checked-out-active');
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
		$.ajax({ type: "GET", url: "/", dataType: 'json', data: 'path=apps/procs/modules/grids&request=createNew&id=' + id, cache: false, success: function(data){
			$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/procs/modules/grids&request=getList&id="+id, success: function(list){
				$("#procs3 ul[rel=grids]").html(list.html);
				$('#procs_grids_items').html(list.items);
				var liindex = $("#procs3 ul[rel=grids] .module-click").index($("#procs3 ul[rel=grids] .module-click[rel='"+data.id+"']"));
				$("#procs3 ul[rel=grids] .module-click:eq("+liindex+")").addClass('active-link');
				var moduleidx = $("#procs3 ul").index($("#procs3 ul[rel=grids]"));
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
		$.ajax({ type: "GET", url: "/", data: 'path=apps/procs/modules/grids&request=createDuplicate&id=' + id, cache: false, success: function(mid){
			$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/procs/modules/grids&request=getList&id="+pid, success: function(data){																																																																				
				$("#procs3 ul[rel=grids]").html(data.html);
				$('#procs_grids_items').html(data.items);
				var moduleidx = $("#procs3 ul").index($("#procs3 ul[rel=grids]"));
				var liindex = $("#procs3 ul[rel=grids] .module-click").index($("#procs3 ul[rel=grids] .module-click[rel='"+mid+"']"));
				module.getDetails(moduleidx,liindex);
				$("#procs3 ul[rel=grids] .module-click:eq("+liindex+")").addClass('active-link');
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/procs/modules/grids&request=binGrid&id=" + id, cache: false, success: function(data){
							if(data == "true") {
								$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/procs/modules/grids&request=getList&id="+pid, success: function(data){
									$("#procs3 ul[rel=grids]").html(data.html);
									$('#procs_grids_items').html(data.items);
									if(data.html == "<li></li>") {
										procsActions(3);
										//alert('yo');
									} else {
										procsActions(12);
									}
									var moduleidx = $("#procs3 ul").index($("#procs3 ul[rel=grids]"));
									var liindex = 0;
									module.getDetails(moduleidx,liindex);
									$("#procs3 ul[rel=grids] .module-click:eq("+liindex+")").addClass('active-link');
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
		$.ajax({ type: "GET", url: "/", async: false, data: 'path=apps/procs/modules/grids&request=checkinGrid&id='+id, success: function(data){
			if(!data) {
				prompt("something wrong");
			}
			}
		});
	}
	
	
	this.actionRefresh = function() {
		var id = $("#procs").data("third");
		var pid = $("#procs").data("second");
		$("#procs3 ul[rel=grids] .active-link").trigger("click");
		$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/procs/modules/grids&request=getList&id="+pid, success: function(data){																																																																				
			$("#procs3 ul[rel=grids]").html(data.html);
			$('#procs_grids_items').html(data.items);
			var liindex = $("#procs3 ul[rel=grids] .module-click").index($("#procs3 ul[rel=grids] .module-click[rel='"+id+"']"));
			$("#procs3 ul[rel=grids] .module-click:eq("+liindex+")").addClass('active-link');
			}
		});
	}


	this.actionPrint = function() {
		var id = $("#procs").data("third");
		var url ='/?path=apps/procs/modules/grids&request=printDetails&id='+id;
		$("#documentloader").attr('src', url);
	}


	this.actionSend = function() {
		var id = $("#procs").data("third");
		$.ajax({ type: "GET", url: "/", data: "path=apps/procs/modules/grids&request=getSend&id="+id, success: function(html){
			$("#modalDialogForward").html(html).dialog('open');
			}
		});
	}


	this.actionSendtoResponse = function() {
		var id = $("#procs").data("third");
		$.ajax({ type: "GET", url: "/", data: "path=apps/procs/modules/grids&request=getSendtoDetails&id="+id, success: function(html){
			$("#procsgrid_sendto").html(html);
			//$("#modalDialogForward").dialog('close');
			}
		});
	}
	
	
	this.sortclick = function (obj,sortcur,sortnew) {
		var module = this;
		var cid = $('#procs input[name="id"]').val()
		module.checkIn(cid);
		
		var fid = $("#procs2 .module-click:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/procs/modules/grids&request=getList&id="+fid+"&sort="+sortnew, success: function(data){
			$("#procs3 ul[rel=grids]").html(data.html);
			$('#procs_grids_items').html(data.items);
			obj.attr("rel",sortnew);
			obj.removeClass("sort"+sortcur).addClass("sort"+sortnew);
			var id = $("#procs3 ul[rel=grids] .module-click:eq(0)").attr("rel");
			$('#procs').data('third',id);
			if(id == undefined) {
				return false;
			}
			var moduleidx = $("#procs3 ul").index($("#procs3 ul[rel=grids]"));
			module.getDetails(moduleidx,0);
			$("#procs3 ul[rel=grids] .module-click:eq(0)").addClass('active-link');
		}
		});
	}


	this.sortdrag = function (order) {
		var fid = $("#procs").data("second");
		$.ajax({ type: "GET", url: "/", data: "path=apps/procs/modules/grids&request=setOrder&"+order+"&id="+fid, success: function(html){
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
			case "getGridStatusDialog":
				$.ajax({ type: "GET", url: "/", data: 'path=apps/procs/modules/grids&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
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
				var id = parseInt(el.attr('id').replace(/procsgriditem_/, ""));
				currentProcGridEditedNote = id;
				var title = el.find('>div:eq(1)').text();
				var text = el.find('>div:eq(2)').text();
				var team = el.find('>div:eq(3)').html();
				var costs_employees = el.find('>div:eq(4)').html();
				var costs_materials = el.find('>div:eq(5)').html();
				var costs_external = el.find('>div:eq(6)').html();
				var costs_other = el.find('>div:eq(7)').html();
				var hours = el.find('>div:eq(8)').html();
				var team_ct = el.find('>div:eq(9)').html();
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
				copopup.find('.hours').val(hours);
				$('#coPopup-team').html(team);
				$('#coPopup-team_ct').html(team_ct);
				$('#co-popup a.binItem').attr('rel',id);
				if(request == 'title' || request == 'stagegate') {
					copopup.find('.tohide').hide();
				} else {
					copopup.find('.tohide').show();
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
									left: l + 'px',
									top: t + 'px'
								}).removeClass(function (index, css) {
						   			return (css.match (/\bswitch-\w+/g) || []).join(' ');
					   			})
								.addClass(className);
								copopup.find('.arrow').offset({ top: ui.target.top });
				  		}
					});
	}
	
	

	this.insertStatus = function(rel,text) {
		var module = this;
		var html = '<div class="listmember" field="procsgrid_status" uid="'+rel+'" style="float: left">' + text + '</div>';
		$("#procsgrid_status").html(html);
		$("#modalDialog").dialog("close");
		$("#procsgrid_status").next().val("");
		$('#procs .coform').ajaxSubmit(module.poformOptions);
	}


	this.insertStatusDate = function(rel,text) {
		var html = '<div class="listmember" field="procsgrid_status" uid="'+rel+'" style="float: left">' + text + '</div>';
		$("#procsgrid_status").html(html);
		$("#modalDialog").dialog("close");
		$("#procsgrid_status").nextAll('img').trigger('click');
	}
	
	
	this.insertFolderFromDialog = function(field,gid,title) {
		var html = '<span class="listmember" uid="' + gid + '" field="'+field+'">' + title + '</span>';
		$("#"+field).html(html);
		$("#modalDialog").dialog('close');
	}
	
	
	this.coPopupContactInsert = function() {
		var id = currentProcGridEditedNote;
		var team = $('#coPopup-team').html();
		$('#procsgriditem-team-'+id).html(team);
		this.saveItem();
	}
	
	this.coPopupContactGroupInsert = function() {
		var id = currentProcGridEditedNote;
		var team = $('#coPopup-team').html();
		$('#procsgriditem-team-'+id).html(team);
		this.saveItem();
	}
	
	this.coPopupContactTextInsert = function() {
		var id = currentProcGridEditedNote;
		var team_ct = $('#coPopup-team_ct').html();
		$('#procsgriditem-team_ct-'+id).html(team_ct);
		this.saveItem();
	}
	
	this.coPopupContactDelete = function() {
		var id = currentProcGridEditedNote;
		var team = $('#coPopup-team').html();
		$('#procsgriditem-team-'+id).html(team);
		this.saveItem();
	}
	
	this.coPopupContactTextDelete = function() {
		var id = currentProcGridEditedNote;
		var team_ct = $('#coPopup-team_ct').html();
		$('#procsgriditem-team_ct-'+id).html(team_ct);
		this.saveItem();
	}
	
	// notes
	this.saveItem = function(id) {
		var id = currentProcGridEditedNote;
		var title = $('#co-popup input.title').val();
		$('#procsgriditem-title-'+id).text(title);
		
		var team = processCoPopupList('coPopup-team');
		var team_html = $('#coPopup-team').html();
		$('#procsgriditem-team-'+id).html(team_html);
		
		var team_ct = processCoPopupListCustomTextApps('coPopup-team_ct');
		
		var text = $('#co-popup textarea.text').val();
		$('#procsgriditem-text-'+id).text(text);
		
		var hours = $('#co-popup input.hours').val();
		if(hours == '') { hours = 0; }
		$('#procsgriditem-hours-'+id).text(hours);
		var costs_employees = $('#co-popup input.costs_employees').val();
		if(costs_employees == '') { costs_employees = 0; }
		$('#procsgriditem-costs_employees-'+id).text(costs_employees);
		var costs_materials = $('#co-popup input.costs_materials').val();
		if(costs_materials == '') { costs_materials = 0; }
		$('#procsgriditem-costs_materials-'+id).text(costs_materials);
		var costs_external = $('#co-popup input.costs_external').val();
		if(costs_external == '') { costs_external = 0; }
		$('#procsgriditem-costs_external-'+id).text(costs_external);
		var costs_other = $('#co-popup input.costs_other').val();
		if(costs_other == '') { costs_other = 0; }
		$('#procsgriditem-costs_other-'+id).text(costs_other);
		
		$.ajax({ type: "POST", url: "/", data: { path: 'apps/procs/modules/grids', request: 'saveGridNote', id: id, title: title, text: text, team: team, team_ct: team_ct, hours: hours, costs_employees: costs_employees, costs_materials: costs_materials, costs_external: costs_external, costs_other: costs_other }, success: function(data){
			
			var costs = 0;
			var col = $('#procsgriditem_'+id).parent();
			col.find('div.costs').each(function() { 
				costs += parseInt($(this).html());
			})
			col.next().next().find('span.totalcosts').html(costs).number( true, 0, '', '.' );
			var hours = 0;
			col.find('div.hours').each(function() { 
				hours += parseInt($(this).html());
			})
			col.next().next().find('span.totalhours').html(hours);
			}
		});
	}


	this.newItemOption = function(ele,what) {
		switch(what) {
			case 'notetitle':
				var col = parseInt(ele.parent().parent().attr("id").replace(/gridscol_/, ""));
				var pid = $("#procs").data("third");
				ele.parent().addClass('planned');
				$.ajax({ type: "GET", url: "/", data: "path=apps/procs/modules/grids&request=saveGridNewManualTitle&pid="+pid+"&col="+col, cache: false, success: function(html){	
						var phase = $('#gridscol_'+col+' .procs-col-title');
						phase.html(html);
						var element = phase.find('input');
						$.jNice.CheckAddPO(element);
						phase.next().trigger('sortupdate');
					}
				});
			break;
			case 'note':
				var idx = $('#procs-grid .newNote').index(ele);
				var pid = $("#procs").data("third");
				$.ajax({ type: "GET", url: "/", data: "path=apps/procs/modules/grids&request=saveGridNewManualNote&pid="+pid, cache: false, success: function(html){
						var phase = $('#procs-grid .procs-phase:eq('+idx+')');
						phase.append(html);
						var element = phase.find('input:last');
						$.jNice.CheckAddPO(element);
						phase.trigger('sortupdate');
					}
				});
			break;
			case 'stagegate':
				var col = parseInt(ele.parent().parent().parent().parent().attr("id").replace(/gridscol_/, ""));
				var pid = $("#procs").data("third");
				$.ajax({ type: "GET", url: "/", data: "path=apps/procs/modules/grids&request=saveGridNewManualStagegate&pid="+pid+"&col="+col, cache: false, success: function(html){	
						var phase = $('#gridscol_'+col+' .procs-col-stagegate');
						phase.html(html);
						var element = phase.find('input');
						$.jNice.CheckAddPO(element);
						phase.prev().trigger('sortupdate');
					}
				});
			break;
		}
}

	this.newItem = function() {
		var mid = $("#procs").data("third");
		var num = parseInt($("#procs-right .task_sort").size());
		$.ajax({ type: "GET", url: "/", data: "path=apps/procs/modules/grids&request=addTask&mid=" + mid + "&num=" + num + "&sort=" + num, success: function(html){
			$('#procsgridtasks').append(html);
			var idx = parseInt($('.cbx').size() -1);
			var element = $('.cbx:eq('+idx+')');
			$.jNice.CheckAddPO(element);
			$('.gridouter:eq('+idx+')').slideDown(function() {
				$(this).find(":text:eq(0)").focus();
				if(idx == 6) {
				$('#procs-right .addTaskTable').clone().insertAfter('#phasetasks');
				}
				initProcsContentScrollbar();
			});
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
					$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/procs/modules/grids&request=binItem&id="+id, success: function(data){
						if(data){
							$("#procsgriditem_"+id).fadeOut(function() { 
									phase = $(this).parent();
									if($(this).hasClass('colTitle')) {
										phase = $(this).parent().next();
										$(this).parent().html('<span class="newNoteItem newItemOption newNoteTitle" rel="notetitle"></span>');
										
									}
									if($(this).hasClass('colStagegate')) {
										phase = $(this).parent().parent().parent().prev();
										$(this).parent().html('<span class="newNoteItem newItemOption newNoteStagegate" rel="stagegate"></span>');
									}
									$(this).remove();
									phase.trigger('sortupdate');
								});
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
					$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/procs/modules/grids&request=binGridColumn&id="+id, success: function(text){						
							$('#gridscol_'+id).animate({width: 0}, function(){ 
								$(this).remove();
								$("#procs-grid").width($("#procs-grid").width()-230);
							});
						}
					});
				} 
			}
		});	
	}


	this.actionHelp = function() {
		var url = "/?path=apps/procs/modules/grids&request=getHelp";
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/procs/modules/grids&request=deleteGrid&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#grid_'+id).slideUp();
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/procs/modules/grids&request=restoreGrid&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#grid_'+id).slideUp();
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/procs/modules/grids&request=deleteGridColumn&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#grid_col_'+id).slideUp();
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/procs/modules/grids&request=restoreGridColumn&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#grid_col_'+id).slideUp();
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/procs/modules/grids&request=deleteGridTask&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#grid_task_'+id).slideUp();
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/procs/modules/grids&request=restoreGridTask&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#grid_task_'+id).slideUp();
						}
					}
					});
				} 
			}
		});
	}


	this.actionConvert = function() {
		$('#modalDialogProcsGrid').slideDown();
	}

}
var procs_grids = new procsGrids('procs_grids');
var currentProcGridEditedNote = 0;

$(document).ready(function() {
// console
	$('#procs-console-notes>div').livequery( function() {
		$(this).draggable({
			connectToSortable: ".procs-phase",
			helper: "clone",
			appendTo: '#procs-right',
			zIndex: 102,
			revert: 'invalid',
			start: function(e, ui) {
				$(ui.helper).addClass("ui-draggable-helper-grid");
			}
		});
	});

	$('#procs-console').livequery( function() {
		$(this).draggable({handle: 'h3', containment: '#procs-right .scroll-pane', cursor: 'move'})
		.resizable({ minHeight: 25, minWidth: 230});
	});

// grid outer
	$('#procs-grid').livequery( function() {
		$(this).sortable({
			items: '>div',
			handle: 'h3',
			handle: '.dragColActive',
			axis: 'x',
			tolerance: 'pointer',
			containment: '#procs-grid',
			update: function(event,ui) {
				var order = $(this).sortable("serialize");
				$.ajax({ type: "GET", url: "/", data: "path=apps/procs/modules/grids&request=saveGridColumns&"+ order, cache: false, success: function(data){
					}
				});
			}
		})
	});

// Title
	$('#procs-grid .procs-col-title').livequery( function() {
		$(this).droppable({
			accept: '.droppable',
			drop: function( event, ui ) {
				var tocopy = false;
				var orig = false;
				var attr = ui.draggable.attr('id');
				if($(this).find('>div').length > 0) {
					tocopy = $(this).html();
					orig = $(this).find('>div').attr('id');
					if(attr != 'undefined') {
						if(orig == attr) {
							return false;	
						}
					}
				}
				var idx = $('#procs-grid .procs-col-title').index(this);
				if(tocopy) {
					$('#procs-grid .procs-phase:eq('+idx+')').prepend(tocopy);
					$('#procs-grid .procs-phase:eq('+idx+') > div:eq(0)').removeClass('colTitle').removeClass('ui-sortable-helper').removeClass('ui-draggable').removeClass('ui-draggable-dragging').attr('style','');
				}
				var insert = ui.draggable.clone();
				$(this).html(insert.attr('style','').addClass('colTitle').removeClass('ui-sortable-helper').attr('request','title')).addClass('planned');
				var pid = $("#procs").data("third");
				var col = parseInt($(this).parent().attr("id").replace(/gridscol_/, ""));
				
				if(ui.draggable.hasClass('colStagegate')) {
					var id = ui.draggable.attr('rel');
					$('#procs-grid div[id=procsgriditem_'+id+']').remove();
					insert.attr('id','procsgriditem_' + id).removeClass('colStagegate');
					$.ajax({ type: "GET", url: "/", async: false, data: "path=apps/procs/modules/grids&request=saveGridNoteTitle&id=" + id + "&col="+col, cache: false, success: function(id){
							$('#procs-grid .procs-phase:eq('+idx+')').trigger('sortupdate');
						}
					});
				} else if (typeof attr == 'undefined' || attr == false) {
					var id = ui.draggable.attr('rel');
					$.ajax({ type: "GET", url: "/", data: "path=apps/procs/modules/grids&request=saveGridNewNoteTitle&pid="+pid+"&id=" + id+"&col="+col, cache: false, success: function(id){
						insert.attr('id','procsgriditem_' + id).attr('rel',id);
						insert.find('div.itemTitle').attr('id','procsgriditem-title-' + id);
						insert.find('div.itemText').attr('id','procsgriditem-text-' + id);
						var e = '<input name="" type="checkbox" value="'+id+'" class="cbx jNiceHidden" />';
						var e = insert.find('div.statusItem').html(e);
						
						var element = insert.find('input');
						$.jNice.CheckAddPO(element);
						$('#procs-grid .procs-phase:eq('+idx+')').trigger('sortupdate');
						}
					});
				} else { // if dropped from list
					if(ui.draggable.hasClass('colTitle')) {
						ui.draggable.parent().html('<span class="newNoteItem newNoteTitle"></span>');
					}
					var dragidx = $('#procs-grid .procs-phase').index(ui.draggable.parent());
					ui.draggable.remove();
					var id = attr.replace(/procsgriditem_/, "");
					$.ajax({ type: "GET", url: "/", async: false, data: "path=apps/procs/modules/grids&request=saveGridNoteTitle&id=" + id + "&col="+col, cache: false, success: function(id){
						if(dragidx != idx) {
							$('#procs-grid .procs-phase:eq('+idx+')').trigger('sortupdate');
						}
						}
					});
				}
			}
		})	
	})

	$('#procs-grid .procs-col-title>div').livequery( function() {
		$(this).draggable({
			connectToSortable: ".procs-phase",
			helper: "clone",
			//handle: '.dragItem',
			revert: 'invalid',
			appendTo: '#procs-right',
			zIndex: 101,
			start: function(e, ui) {
				$(ui.helper).addClass("ui-draggable-helper-grid");
			}
		});
	})


// Stagegate
	$('#procs-grid .procs-col-stagegate').livequery( function() {
		$(this).droppable({
			accept: '.droppable',
			drop: function( event, ui ) {
				var tocopy = false;
				var orig = false;
				var attr = ui.draggable.attr('id');
				if($(this).find('>div').length > 0) {
					tocopy = $(this).html();
					orig = $(this).find('>div').attr('id');
					if(attr != 'undefined') {
						if(orig == attr) {
							return false;	
						}
					}
				}
				var idx = $('#procs-grid .procs-col-stagegate').index(this);
				if(tocopy) {
					$('#procs-grid .procs-phase:eq('+idx+')').prepend(tocopy);
					$('#procs-grid .procs-phase:eq('+idx+') > div:eq(0)').removeClass('colStagegate').removeClass('ui-sortable-helper').removeClass('ui-draggable').removeClass('ui-draggable-dragging').attr('style','');
				}
				var insert = ui.draggable.clone();
				$(this).html(insert.attr('style','').addClass('colStagegate').removeClass('ui-sortable-helper').attr('request','stagegate'));
				//var attr = ui.draggable.attr('id');
				var pid = $("#procs").data("third");
				var col = parseInt($(this).parent().parent().parent().attr("id").replace(/gridscol_/, ""));
				if(ui.draggable.hasClass('colTitle')) {
					var id = ui.draggable.attr('rel');
					$('#procs-grid div[id=procsgriditem_'+id+']').remove();
					insert.attr('id','procsgriditem_' + id).removeClass('colTitle');
					$.ajax({ type: "GET", url: "/", async: false, data: "path=apps/procs/modules/grids&request=saveGridNoteStagegate&id=" + id + "&col="+col, cache: false, success: function(id){
						$('#procs-grid .procs-phase:eq('+idx+')').trigger('sortupdate');
						}
					});
				} else if (typeof attr == 'undefined' || attr == false) {
					var id = ui.draggable.attr('rel');
					$.ajax({ type: "GET", url: "/", async: false, data: "path=apps/procs/modules/grids&request=saveGridNewNoteStagegate&pid="+pid+"&id=" + id+"&col="+col, cache: false, success: function(id){
						insert.attr('id','procsgriditem_' + id).attr('rel',id);
						var e = '<input name="" type="checkbox" value="'+id+'" class="cbx jNiceHidden" />';
						var e = insert.find('div.statusItem').html(e);
						var element = insert.find('input');
						$.jNice.CheckAddPO(element);
						$('#procs-grid .procs-phase:eq('+idx+')').trigger('sortupdate');
						}
					});
				} else { // if dropped from list
					if(ui.draggable.hasClass('colStagegate')) {
						ui.draggable.parent().html('<span class="newNoteItem newNoteStagegate"></span>');
					}
					var dragidx = $('#procs-grid .procs-phase').index(ui.draggable.parent());
					ui.draggable.remove();
					var id = attr.replace(/procsgriditem_/, "");
					$.ajax({ type: "GET", url: "/", async: false, data: "path=apps/procs/modules/grids&request=saveGridNoteStagegate&id=" + id + "&col="+col, cache: false, success: function(id){
						if(dragidx != idx) {
							$('#procs-grid .procs-phase:eq('+idx+')').trigger('sortupdate');
						}
						}
					});
				}
			}
		})	
	})

	$('#procs-grid .procs-col-stagegate>div').livequery( function() {
		$(this).draggable({
			connectToSortable: ".procs-phase",
			helper: "clone",
			revert: 'invalid',
			appendTo: '#procs-right',
			zIndex: 101,
			start: function(e, ui) {
				$(ui.helper).addClass("ui-draggable-helper-grid");
			}
		});
	})


// SORTABLE LIST
	$('#procs-grid .procs-phase').livequery( function() {
		$(this).sortable({
			items: '>div',
			//handle: '.dragItem',
			connectWith: '.procs-phase,.procs-col-title,.procs-col-stagegate',
			receive: function (event, ui) { // add this handler
				setTimeout(function() {
					if(ui.item.hasClass('colTitle')) {
						ui.item.parent().html('<span class="newNoteItem newNoteTitle"></span>');
						ui.item.remove();
					}
					if(ui.item.hasClass('colStagegate')) {
						ui.item.parent().html('<span class="newNoteItem newNoteStagegate"></span>');
						ui.item.remove();
					}
				}, 100);
			}
		}).disableSelection().bind('sortupdate', function(event, ui) {
			var col = parseInt($(this).parent().attr("id").replace(/gridscol_/, ""));
			var idx = $('#procs-grid .procs-phase').index(this);
			$('#procs-grid .procs-phase:eq('+idx+')>div').each(function(index) {
				var div = $(this);
				var attr = div.attr('id');
				if (typeof attr == 'undefined' || attr == false) {
					if(div.hasClass('colTitle') || div.hasClass('colStagegate')) {
						var id = div.attr('rel');
						div.removeClass('colTitle'). removeClass('colStagegate').removeClass('ui-draggable').removeClass('ui-draggable-dragging').attr('style','').attr('request','note');
						div.attr('id','procsgriditem_' + id);
						var e = '<input name="" type="checkbox" value="'+id+'" class="cbx jNiceHidden" />';
						var e = div.find('div.statusItem').html(e);
						var element = div.find('input');
						$.jNice.CheckAddPO(element);						
					} else {
						var id = div.attr('rel');
						if (typeof id != 'undefined') {
							var pid = $("#procs").data("third");
							$.ajax({ type: "GET", url: "/", async: false, data: "path=apps/procs/modules/grids&request=saveGridNewNote&pid="+pid+"&id=" + id, cache: false, success: function(id){
								div.attr('id','procsgriditem_' + id);
								div.find('div.itemTitle').attr('id','procsgriditem-title-' + id);
								div.find('div.itemText').attr('id','procsgriditem-text-' + id);
								div.append('<div id="procsgriditem-team-'+ id +'" style="display: none;"></div><div id="procsgriditem-costs_employees-'+ id +'" style="display: none;" class="costs">0</div><div id="procsgriditem-costs_materials-'+ id +'" style="display: none;" class="costs">0</div><div id="procsgriditem-costs_external-'+ id +'" style="display: none;" class="costs">0</div><div id="procsgriditem-costs_other-'+ id +'" style="display: none;" class="costs">0</div><div id="procsgriditem-hours-'+ id +'" style="display: none;" class="hours">0</div><div id="procsgriditem-team_ct-'+ id +'" style="display: none;"><a class="ct-content" field="coPopup-team_ct"></a></div>');
								var e = '<input name="" type="checkbox" value="'+id+'" class="cbx jNiceHidden" />';
								var e = div.find('div.statusItem').html(e);
								var element = div.find('input');
								$.jNice.CheckAddPO(element);
								}
							});
						}
					}
				}
			});
			var order = $('#procs-grid .procs-phase:eq('+idx+')').sortable("serialize");
			$.ajax({ type: "GET", url: "/", data: "path=apps/procs/modules/grids&request=saveGridItems&col="+col+"&"+ order, cache: false, success: function(data){
				var titleset = $('div.procs-col-title:eq('+idx+')').html();
				var title = 0;
				if(titleset != "" && titleset != '<span class="newNoteItem newNoteTitle"></span>') {
					title = 1;
				}
				var ncbx = $('div.procs-phase:eq('+idx+') input:checkbox').length;
				var n = $('div.procs-phase:eq('+idx+') input:checked').length;
				if(ncbx > 0 || title == 1) {
					$('div.procs-col-title:eq('+idx+')').removeClass('progress').removeClass('finished').addClass('planned');
					$('div.procs-col-footer:eq('+idx+') .procs-stagegate').removeClass('active');
				}
				if(ncbx == 0 && title == 0) {
					$('div.procs-col-title:eq('+idx+')').removeClass('progress').removeClass('finished').removeClass('planned');
					$('div.procs-col-footer:eq('+idx+') .procs-stagegate').removeClass('active');
				}
				if(ncbx > n && n > 0) {
					$('div.procs-col-title:eq('+idx+')').removeClass('planned').removeClass('finished').addClass('progress');
					$('div.procs-col-footer:eq('+idx+') .procs-stagegate').removeClass('active');
				}
				if(ncbx > 0 && n == ncbx) {
					$('div.procs-col-title:eq('+idx+')').removeClass('planned').removeClass('finished').addClass('finished');
					$('div.procs-col-footer:eq('+idx+') .procs-stagegate').addClass('active');
				}
				var c = $('#procs-grid .procs-phase:eq('+idx+')');
				var items = c.find('>div').size();
				var listheight = items*27+27;
				if (listheight < 27) {
					listheight = 27;
				}
				var colheight = items*27+78+80+8+4;
				if (colheight < 158+8+4) {
					colheight = 158+8+4;
				}
				c.animate({height: listheight}).parent().animate({height: colheight});
				
				var costs = 0;
				c.find('div.costs').each(function() { 
					costs += parseInt($(this).html());
				})
				c.next().next().find('span.totalcosts').html(costs).number( true, 0, '', '.' );
				var hours = 0;
				c.find('div.hours').each(function() { 
					hours += parseInt($(this).html());
				})
				c.next().next().find('span.totalhours').html(hours);
				
				
				
				}
			});
    	});
	})


	$(document).on('click', '#procs-console a.collapse', function(e) {
		e.preventDefault();
		var height = 25;
		if($(this).hasClass('closed')) {
			var height = 250;
		}
		$(this).toggleClass('closed').parent().parent().animate({'height': height});
	});	


	$(document).on('click', '#procs-add-column', function(e) {
		e.preventDefault();
		var pid = $("#procs").data("third");
		var sor = $('#procs-grid>div').size();
		var styles = '';
		$("#procs-grid").width($("#procs-grid").width()+230);
		$.ajax({ type: "GET", url: "/", data: "path=apps/procs/modules/grids&request=newGridColumn&id="+pid+"&sort="+sor, cache: false, success: function(num){
			$("#procs-grid").append('<div id="gridscol_' + num + '"><div class="dragCol"><div id="procs-col-delete-' + num + '" class="procs-column-delete"><span class="icon-delete"></span></div></div><div class="procs-col-title  ui-droppable"><span rel="notetitle" class="newNoteItem newItemOption newNoteTitle"></span></div><div class="grids-spacer"></div><div style="height: 27px;" class="procs-phase procs-phase-design ui-sortable"><span rel="note" class="newNoteItem newItemOption newNote"></span></div><div class="grids-spacer"></div><div class="procs-col-footer"><div class="procs-col-footer-stagegate"><div class="procs-stagegate   "></div><div class="procs-col-stagegate ui-droppable"><span rel="stagegate" class="newNoteItem newItemOption newNoteStagegate"></span></div></div><div class="grids-spacer"></div><div class="procs-col-footer-days"><div class="left"><span class="totalhours"> 0</span> <span>h</span></div><div class="right"><span>&euro;</span> <span class="totalcosts">0</span></div><div></div></div></div></div>').sortable("refresh");
			}
		});
	})


	$(document).on('click', 'div.procs-column-delete', function(e) {
		e.preventDefault();
		var id = $(this).attr("id").replace(/procs-col-delete-/, "");
		procs_grids.binColumn(id);
	});


	$(document).on('click', 'span.actionProcsGridsConvert', function(e) {
		e.preventDefault();
		var id = $("#procs").data("third");
		var kickofffield = Date.parse($("#procs input[name='kickoff']").val());
		var kickoff = kickofffield.toString("yyyy-MM-dd");
		var folder = $('#procsgridprojectsfolder>span').attr('uid');
		if(typeof folder == 'undefined' || folder == false) {
			$.prompt(ALERT_CHOOSE_FOLDER);
			return false;
		}
		var protocol = $("#gridProtocol").val();
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/procs/modules/grids&request=convertToProject&id="+id+"&kickoff="+kickoff+"&folder="+folder+"&protocol="+protocol, success: function(data){																																																	  			$.prompt(ALERT_SUCCESS_PROJECT_EXPORT + '"'+data.fid+'"');
			var html = '<div class="text11">Projektordner: <span class="listmember">' + data.fid + '</span>, ' + data.created_user + ', ' + data.created_date + '</div';
			$('#project_created').append(html);
			$("#modalDialogProcsGrid").slideUp(function() {		
				initProcsContentScrollbar();							
			});
			}
		});
	})


	$(document).on('click', '#modalDialogProcsGridClose', function(e) {
		e.preventDefault();
		$("#modalDialogProcsGrid").slideUp(function() {
			initProcsContentScrollbar();
		});
	});

	/*$('input.currency').livequery( function() {
		//$(this).inputmask('integer', { 'autoGroup': true, 'groupSeparator': ".", 'groupSize': 3, 'autoUnmask' : true });
		$(this).formatCurrency({ symbol: '', roundToDecimalPlace: -1, eventOnDecimalsEntered: true })
		.keyup(function(e) {
				var e = window.event || e;
				var keyUnicode = e.charCode || e.keyCode;
				if (e !== undefined) {
					switch (keyUnicode) {
						case 16: break; // Shift
						case 27: this.value = ''; break; // Esc: clear entry
						case 35: break; // End
						case 36: break; // Home
						case 37: break; // cursor left
						case 38: break; // cursor up
						case 39: break; // cursor right
						case 40: break; // cursor down
						case 78: break; // N (Opera 9.63+ maps the "." from the number key section to the "N" key too!) (See: http://unixpapa.com/js/key.html search for ". Del")
						case 110: break; // . number block (Opera 9.63+ maps the "." from the number block to the "N" key (78) !!!)
						case 190: break; // .
						default: $(this).formatCurrency({ symbol: '', roundToDecimalPlace: -1, eventOnDecimalsEntered: true });
					}
				}
			})
	})*/
	$('input.currency').livequery( function() {
		$(this).number( true, 0, '', '.' );
	})
	$('span.totalcosts').livequery( function() {
		$(this).number( true, 0, '', '.' );
	})

});