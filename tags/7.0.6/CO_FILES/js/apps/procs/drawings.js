/* drawings Object */
function procsDrawings(name) {
	this.name = name;


	this.formProcess = function(formData, form, poformOptions) {
		var title = $("#procs input.title").fieldValue();
		if(title == "") {
			setTimeout(function() {
				title = $("#procs input.title").fieldValue();
				if(title == "") {
					$.prompt(ALERT_NO_TITLE, {submit: setTitleFocus});
				}
			}, 5000)
			return false;
		} else {
			formData[formData.length] = { "name": "title", "value": title };
		}
	 }
	 
	 
	 this.formResponse = function(data) {
		$("#procs3 ul[rel=drawings] span[rel="+data.id+"] .text").html($("#procs .title").val());
		/*switch(data.access) {
			case "0":
				$("#procs3 ul[rel=drawings] span[rel="+data.id+"] .module-access-status").removeClass("module-access-active");
			break;
			case "1":
				$("#procs3 ul[rel=drawings] span[rel="+data.id+"] .module-access-status").addClass("module-access-active");
			break;
		}*/
	}


	this.poformOptions = { beforeSubmit: this.formProcess, dataType: 'json', success: this.formResponse };


	this.statusOnClose = function(dp) {
		var id = $("#procs").data("third");
		var status = $("#procs .statusTabs li span.active").attr('rel');
		var date = $("#procs .statusTabs input").val();
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/procs/modules/drawings&request=updateStatus&id=" + id + "&date=" + date + "&status=" + status, cache: false, success: function(data){
			switch(data.action) {
				case "edit":
					switch(data.status) {
						case "2":
							$("#procs3 ul[rel=drawings] span[rel="+data.id+"] .module-item-status").addClass("module-item-active").removeClass("module-item-active-stopped");
						break;
						case "3":
							$("#procs3 ul[rel=drawings] span[rel="+data.id+"] .module-item-status").addClass("module-item-active-stopped").removeClass("module-item-active");
						break;
						default:
							$("#procs3 ul[rel=drawings] span[rel="+data.id+"] .module-item-status").removeClass("module-item-active").removeClass("module-item-active-stopped");
					}
				break;
				/*case "reload":
					var module = getCurrentModule();
					var id = $('#procs').data('second');
					$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/procs/modules/drawings&request=getList&id="+id, success: function(list){
						$('#procs3 ul[rel=drawings]').html(list.html);
						$('#procs_drawings_items').html(list.items);
						var moduleidx = $("#procs3 ul").index($("#procs3 ul[rel=drawings]"));
						var liindex = $("#procs3 ul[rel=drawings] .module-click").index($("#procs3 ul[rel=drawings] .module-click[rel='"+data.id+"']"));
						module.getDetails(moduleidx,liindex);
						$("#procs3 ul[rel=drawings] .module-click:eq("+liindex+")").addClass('active-link');
						}
					});
				break;	*/																																													  				}
			}
		});
	}


	this.getDetails = function(moduleidx,liindex,list) {
		//loadDemand();
		contexts = [];
		var id = $("#procs3 ul:eq("+moduleidx+") .module-click:eq("+liindex+")").attr("rel");
		$('#procs').data({ "third" : id});
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/procs/modules/drawings&request=getDetails&id="+id, success: function(data){
			$("#procs-right").empty().html(data.html);
			
			if($('#checkedOut').length > 0) {
					$("#procs3 ul[rel=drawings] .active-link .icon-checked-out").addClass('icon-checked-out-active');
				} else {
					$("#procs3 ul[rel=drawings] .active-link .icon-checked-out").removeClass('icon-checked-out-active');
				}
			
			if(list == 0) {
				switch (data.access) {
					case "sysadmin": case "admin":
						procsActions(0);
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
							procsActions(0);
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
			if(data.html != '') {
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
						initProcsContentScrollbar();			
				},300)
			}
			}
		});	
	}


	this.actionNew = function() {
		var module = this;
		var cid = $('#procs input[name="id"]').val()
		module.checkIn(cid);
	
		var id = $('#procs').data('second');
		$.ajax({ type: "GET", url: "/", dataType: 'json', data: 'path=apps/procs/modules/drawings&request=createNew&id=' + id, cache: false, success: function(data){
			$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/procs/modules/drawings&request=getList&id="+id, success: function(list){
				$("#procs3 ul[rel=drawings]").html(list.html);
				$('#procs_drawings_items').html(list.items);
				var liindex = $("#procs3 ul[rel=drawings] .module-click").index($("#procs3 ul[rel=drawings] .module-click[rel='"+data.id+"']"));
				$("#procs3 ul[rel=drawings] .module-click:eq("+liindex+")").addClass('active-link');
				var moduleidx = $("#procs3 ul").index($("#procs3 ul[rel=drawings]"));
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
		$.ajax({ type: "GET", url: "/", data: 'path=apps/procs/modules/drawings&request=createDuplicate&id=' + id, cache: false, success: function(mid){
			$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/procs/modules/drawings&request=getList&id="+pid, success: function(data){																																																																				
				$("#procs3 ul[rel=drawings]").html(data.html);
				$('#procs_drawings_items').html(data.items);
				var moduleidx = $("#procs3 ul").index($("#procs3 ul[rel=drawings]"));
				var liindex = $("#procs3 ul[rel=drawings] .module-click").index($("#procs3 ul[rel=drawings] .module-click[rel='"+mid+"']"));
				module.getDetails(moduleidx,liindex);
				$("#procs3 ul[rel=drawings] .module-click:eq("+liindex+")").addClass('active-link');
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/procs/modules/drawings&request=binDrawing&id=" + id, cache: false, success: function(data){
							if(data == "true") {
								$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/procs/modules/drawings&request=getList&id="+pid, success: function(data){
									$("#procs3 ul[rel=drawings]").html(data.html);
									$('#procs_drawings_items').html(data.items);
									if(data.html == "<li></li>") {
										procsActions(3);
									} else {
										procsActions(0);
									}
									var moduleidx = $("#procs3 ul").index($("#procs3 ul[rel=drawings]"));
									var liindex = 0;
									module.getDetails(moduleidx,liindex);
									$("#procs3 ul[rel=drawings] .module-click:eq("+liindex+")").addClass('active-link');
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
		$('#ProcsDrawingsTabsContent > div:visible').hide();
		$('#'+what).show();
		$('.elastic').elastic(); // need to init again
		initProcsContentScrollbar();
	}


	this.checkIn = function(id) {
		$.ajax({ type: "GET", url: "/", async: false, data: 'path=apps/procs/modules/drawings&request=checkinDrawing&id='+id, success: function(data){
			if(!data) {
				prompt("something wrong");
			}
			}
		});
	}
	
	
	this.actionRefresh = function() {
		var id = $("#procs").data("third");
		var pid = $("#procs").data("second");
		$("#procs3 ul[rel=drawings] .active-link").trigger("click");
		$.ajax({ type: "GET", url: "/", dataType: 'json', data: "path=apps/procs/modules/drawings&request=getList&id="+pid, success: function(data){																																																																				
			$("#procs3 ul[rel=drawings]").html(data.html);
			$('#procs_drawings_items').html(data.items);
			var liindex = $("#procs3 ul[rel=drawings] .module-click").index($("#procs3 ul[rel=drawings] .module-click[rel='"+id+"']"));
			$("#procs3 ul[rel=drawings] .module-click:eq("+liindex+")").addClass('active-link');
			}
		});
	}


	this.actionPrint = function() {
		var id = $("#procs").data("third");
		var url ='/?path=apps/procs/modules/drawings&request=printDetails&id='+id;
		if(!iOS()) {
			$("#documentloader").attr('src', url);
		} else {
			window.open(url);
		}
	}


	this.actionSend = function() {
		var id = $("#procs").data("third");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/procs/modules/drawings&request=getSend&id="+id, success: function(data){
			$("#modalDialogForward").html(data.html).dialog('open');
			if(data.error == 1) {
				$.prompt('<div style="text-align: center">' + ALERT_REMOVE_RECIPIENT + data.error_message + '<br /></div>');
				return false;
			}
			}
		});
	}


	this.actionSendtoResponse = function() {
		var id = $("#procs").data("third");
		$.ajax({ type: "GET", url: "/", data: "path=apps/procs/modules/drawings&request=getSendtoDetails&id="+id, success: function(html){
			$("#procsdrawing_sendto").html(html);
			//$("#modalDialogForward").dialog('close');
			}
		});
	}
	
	
	this.sortclick = function (obj,sortcur,sortnew) {
		var module = this;
		var cid = $('#procs input[name="id"]').val()
		module.checkIn(cid);
		
		var fid = $("#procs2 .module-click:visible").attr("rel");
		$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/procs/modules/drawings&request=getList&id="+fid+"&sort="+sortnew, success: function(data){
			$("#procs3 ul[rel=drawings]").html(data.html);
			$('#procs_drawings_items').html(data.items);
			obj.attr("rel",sortnew);
			obj.removeClass("sort"+sortcur).addClass("sort"+sortnew);
			var id = $("#procs3 ul[rel=drawings] .module-click:eq(0)").attr("rel");
			$('#procs').data('third',id);
			if(id == undefined) {
				return false;
			}
			var moduleidx = $("#procs3 ul").index($("#procs3 ul[rel=drawings]"));
			module.getDetails(moduleidx,0);
			$("#procs3 ul[rel=drawings] .module-click:eq(0)").addClass('active-link');
		}
		});
	}


	this.sortdrag = function (order) {
		var fid = $("#procs").data("second");
		$.ajax({ type: "GET", url: "/", data: "path=apps/procs/modules/drawings&request=setOrder&"+order+"&id="+fid, success: function(html){
			$("#procs3 .sort:visible").attr("rel", "3");
			$("#procs3 .sort:visible").removeClass("sort1").removeClass("sort2").addClass("sort3");
			}
		});
	}


	this.actionDialog = function(offset,request,field,append,title,sql) {
		switch(request) {
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
			case "getDrawingStatusDialog":
				$.ajax({ type: "GET", url: "/", data: 'path=apps/procs/modules/drawings&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
					$("#modalDialog").html(html);
					$("#modalDialog").dialog('option', 'position', offset);
					$("#modalDialog").dialog('option', 'title', title);
					$("#modalDialog").dialog('open');
					}
				});
			break;
			case "getDrawingsTypeDialog":
				$.ajax({ type: "GET", url: "/", data: 'path=apps/procs/modules/drawings&request='+request+'&field='+field+'&append='+append+'&title='+title+'&sql='+sql, success: function(html){
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


	this.insertStatus = function(rel,text) {
		var module = this;
		var html = '<div class="listmember" field="procsdrawing_status" uid="'+rel+'" style="float: left">' + text + '</div>';
		$("#procsdrawing_status").html(html);
		$("#modalDialog").dialog("close");
		$("#procsdrawing_status").next().val("");
		$('#procs .coform').ajaxSubmit(module.poformOptions);
	}


	this.insertStatusDate = function(rel,text) {
		var html = '<div class="listmember" field="procsdrawing_status" uid="'+rel+'" style="float: left">' + text + '</div>';
		$("#procsdrawing_status").html(html);
		$("#modalDialog").dialog("close");
		$("#procsdrawing_status").nextAll('img').trigger('click');
	}
	
	
	this.insertFromDialog = function(field,gid,title) {
		var html = '<span class="listmember-outer"><span class="listmember listmemberDrawingType" uid="' + gid + '" field="'+field+'">' + title + '</span></div>';
		$("#"+field).html(html);
		$("#modalDialog").dialog('close');
		var obj = getCurrentModule();
		$('#procs .coform').ajaxSubmit(obj.poformOptions);
		// get minutes
		var id = /[0-9]+/.exec(field);
		$.ajax({ type: "GET", url: "/", data: "path=apps/procs/modules/drawings&request=getDrawingTypeMin&id=" + gid, success: function(html){
			$('#minutes_'+id).html(html);
			
			}
		});
	}


	this.newItem = function() {
		var module = this;
		var mid = $("#procs").data("third");
		var num = parseInt($("#procs-right .task_sort").size());
		$.ajax({ type: "GET", url: "/", data: "path=apps/procs/modules/drawings&request=addTask&mid=" + mid + "&num=" + num + "&sort=" + num, success: function(html){
			$('#procsdrawingtasks').append(html);
			var idx = parseInt($('#procsdrawingtasks .cbx').size() -1);
			//console.log(idx);
			var element = $('.cbx:eq('+idx+')');
			$.jNice.CheckAddPO(element);
			$('.drawingtaskouter:eq('+idx+')').slideDown(function() {
				$(this).find(":text:eq(0)").focus();
				/*if(idx == 6) {
				$('#procs-right .addTaskTable').clone().insertAfter('#phasetasks');
				}*/
				initProcsContentScrollbar();
				 module.calculateTasks();
			});
			}
		});
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
				$.ajax({ type: "GET", url: "/", data: "path=apps/procs/modules/drawings&request=deleteTask&id=" + id, success: function(data){
					if(data){
						$("#task_"+id).slideUp(function(){ $(this).remove(); module.calculateTasks(); });
						
					} 
					}
				});
				} 
			}
		});
	}
	
	
	this.newDrawing = function() {
		var module = this;
		var mid = $("#procs").data("third");
		zIndexes++;
		var curnum = $('#procs .canvasDraw').size();
		var curcol = curnum % 10;
		var num = curnum+1;
		$.ajax({ type: "GET", url: "/", data: "path=apps/procs/modules/drawings&request=addDiagnose&mid=" + mid + "&num=" + num, success: function(id){
			//$('div.loadCanvas').removeClass('active');
			$('div.loadCanvasList .tcell-right').removeClass('active');
			var html = '<canvas class="canvasDraw" id="c'+num+'" width="1400" height="1400" style="z-index: '+num+'" rel="'+id+'"></canvas><div id="dia-'+id+'" style="position: absolute; width: 30px; height: 30px; z-index: '+zIndexes+'; top: '+30*num+'px; left: 30px;" class="loadCanvas active" rel="'+num+'"><div class="circle circle'+curcol+'"><div>'+num+'</div></div></div>';
			var htmltext = '<div id="canvasList_'+id+'" class="drawingouter loadCanvasList" rel="'+num+'"><table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-protocol"><tr><td style="width: 31px; padding-left: 9px;"><span class="selectTextarea"><span><div class="circle  circle'+curcol+'"><div>'+num+'</div></div></span></span></td><td class="tcell-right active"><textarea name="canvasList_text['+id+']" class="elastic"></textarea><input name="canvasList_id['+id+']" type="hidden" value="'+id+'" /></td><td width="30"><a class="binDiagnose" rel="'+id+'"><span class="icon-delete"></span></a></td></tr></table></div>';
			$('#procs .canvasDiv').append(html);
			$('#canvasDivText').append(htmltext);
			a = 'c'+num;
			activeCanvas = $("#c"+num)[0];
			restorePoints[a] = [];
			$('span.undoTool').removeClass('active');
			if(!$('span.penTool').hasClass('active')) {
				!$('span.penTool').addClass('active');
				$('span.erasorTool').removeClass('active');
			}
			initProcsContentScrollbar();
			}
		});		
	}
	
	this.saveDrawing = function(id,img) {
		var imgsave = '';
		if(img != '') {
			imgsave = img.replace(/^data:image\/png;base64,/, "");
			//window.open(img);
		}
		var module = this;
		$.ajax({ type: "POST", url: "/", data: "path=apps/procs/modules/drawings&request=saveDrawing&id=" + id + "&img=" + imgsave, success: function(id){
			}
		});		
	}


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
				$.ajax({ type: "GET", url: "/", data: "path=apps/procs/modules/drawings&request=deleteTask&id=" + id, success: function(data){
					if(data){
						$("#task_"+id).slideUp(function(){ $(this).remove(); module.calculateTasks(); });
						
					} 
					}
				});
				} 
			}
		});
	}
	
	this.actionHelp = function() {
		var url = "/?path=apps/procs/modules/drawings&request=getHelp";
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/procs/modules/drawings&request=deleteDrawing&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#drawing_'+id).slideUp();
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/procs/modules/drawings&request=restoreDrawing&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#drawing_'+id).slideUp();
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/procs/modules/drawings&request=deleteDrawingTask&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#drawing_task_'+id).slideUp();
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/procs/modules/drawings&request=restoreDrawingTask&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#drawing_task_'+id).slideUp();
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/procs/modules/drawings&request=deleteDrawingDiagnose&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#drawing_diag_'+id).slideUp();
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/procs/modules/drawings&request=restoreDrawingDiagnose&id=" + id, cache: false, success: function(data){
						if(data == "true") {
							$('#drawing_diag_'+id).slideUp();
						}
					}
					});
				} 
			}
		});
	}


	this.manageCheckpoint = function(action,date) {
		var pid = $('#procs').data('third');
		switch(action) {
			case 'new':
				$.ajax({ type: "GET", url: "/", data: "path=apps/procs/modules/drawings&request=newCheckpoint&id=" + pid + "&date=" + date, cache: false });
			break;
			case 'update':
				$.ajax({ type: "GET", url: "/", data: "path=apps/procs/modules/drawings&request=updateCheckpoint&id=" + pid + "&date=" + date, cache: false });			
			break;
			case 'delete':
				$.ajax({ type: "GET", url: "/", data: "path=apps/procs/modules/drawings&request=deleteCheckpoint&id=" + pid, cache: false });
			break;
		}
	}
	
	this.saveCheckpointText = function() {
		var pid = $('#procs').data('third');
		var text = $('#procs_drawingsCheckpoint textarea').val();
		$.ajax({ type: "POST", url: "/", data: "path=apps/procs/modules/drawings&request=updateCheckpointText&id=" + pid + "&text=" + text, cache: false });
	}
	
	this.calculateTasks = function() {
		var total = 0;
		var num = $('#ProcsDrawingsThird .answers-outer-dynamic').size()*10;
		$('#ProcsDrawingsThird .answers-outer-dynamic span').each( function() {
			 if($(this).hasClass('active'))	{
				 total = total + parseInt($(this).html());
			 }
		})
		if(num != 0) {
			var res = Math.round(100/num*total);
		}
		$('#tab3result').html(res);
	}
	
}

var procs_drawings = new procsDrawings('procs_drawings');

var zIndexes = 0;
var restorePoints = [];
var restorePoint = [];
var activeCanvas;
var c;
var j;
var a;
var colors = ['#3C4664','#EB4600','#915500','#0A960A','#AA19AA','#3C4664','#EB4600','#915500','#0A960A','#AA19AA'];
var imgw = [];

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
			//imgw.push(img.naturalWidth);
  			//var height[] = img.naturalHeight;
			//console.log(width);
			var context = $("#c"+j)[0].getContext("2d");
			context.drawImage(img, 0, 0);
		}  
		img.src = dataURL; 
	}  


	$(document).ready(function () {
		$("div.loadCanvas").livequery( function() {
			$(this).each(function(){
				tmp = $(this).css('z-index');
				if(tmp>zIndexes) zIndexes = tmp;
			})						  
		})							  
		
		$('div.loadCanvas.active').livequery( function() {
			$(this).draggable({
				containment:"parent",
				cursor: 'move',
				stop: function(e,ui){
					var x = Math.round(ui.position.left);
					var y = Math.round(ui.position.top);
					var id = $(this).attr("id").replace(/dia-/, "");
					$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/procs/modules/drawings&request=updatePosition&id="+id+"&x="+x+"&y="+y, success: function(data){
						}
					});
				}
			});
		});

		$(document).on('click','div.loadCanvas',function(e) {
			e.preventDefault();
			//var rel = $(this).attr('rel');
			var id = $(this).attr("id").replace(/dia-/, "");
			/*activeCanvas = $("#c"+rel)[0];
			zIndexes = ++zIndexes;
			$('div.loadCanvas').removeClass('active');
			$('div.loadCanvasList .tcell-right').removeClass('active');
			$('#canvasList_'+id).find('.tcell-right').addClass('active').find('textarea').focus();
			$(this).css('z-index',zIndexes).addClass('active');
			$('.canvasDraw').css('z-index',1);
			$('#c'+rel).css('z-index',2);*/
			$('#canvasList_'+id).trigger('click');
		})

		$(document).on('click','.loadCanvasList',function(e) {
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
			$('#procs .canvasDraw').css('z-index',1);
			$('#c'+rel).css('z-index',2);
			if (restorePoints['c'+rel].length > 0) {
				$('span.undoTool').addClass('active');
			} else {
				$('span.undoTool').removeClass('active');
			}
			/*if(!$('span.penTool').hasClass('active')) {
				!$('span.penTool').addClass('active');
				$('span.erasorTool').removeClass('active');
			}*/
			$('span.penTool').trigger('click');
		})

		$(document).on('click','span.addTool',function(e) {
			e.preventDefault();
			procs_drawings.newDrawing();
		})

		$(document).on('click','span.clearTool',function(e) {
			e.preventDefault();
			var context = activeCanvas.getContext("2d");
			context.clearRect(0, 0, 1400, 1400);
			var id = activeCanvas.id;
			//var rel = $('#'+id).attr('rel');
			//procs_drawings.saveDrawing(rel,'');
			
			//var can = document.getElementById(id); 
			//var img = can.toDataURL();
			var img = '';
			restorePoints[id].push(restorePoint[id]);
			restorePoint[id] = '';
			var rel = $('#'+id).attr('rel');
			procs_drawings.saveDrawing(rel,img);
		})

		$(document).on('click','span.undoTool',function(e) {
			e.preventDefault();
			var id = activeCanvas.id;
			if($(this).hasClass('active')) {
				var context = activeCanvas.getContext("2d");
				var currentComp = context.globalCompositeOperation;
				if(currentComp != 'source-over') {
					context.globalCompositeOperation = "source-over";
				}
				context.clearRect(0, 0, 1400, 1400);
				var img = restorePoints[id].pop();
				setImage(img);
				restorePoint[id] = img;
				var rel = $('#'+id).attr('rel');
				procs_drawings.saveDrawing(rel,img);
				if(currentComp != 'source-over') {
					setTimeout( function() { context.globalCompositeOperation = currentComp; }, 300);					
				}
			}
			if (restorePoints[id].length < 1) {
				$(this).removeClass('active');
			}
		})
		
		$(document).on('click','span.erasorTool',function(e) {
			e.preventDefault();
			$(this).addClass('active');
			$('span.penTool').removeClass('active');
			$('#procs .canvasDraw').each(function(i,el) {
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
			$('#procs .canvasDraw').each(function(i,el) {
				var id = this.id;
				var index = $("#procs .canvasDraw").index(this);
			  	var curcol = index % 10;
				contexts[id].globalCompositeOperation = "source-over";
				contexts[id].strokeStyle = colors[curcol];
				contexts[id].lineWidth   = 3;
			});
		})
		
		var curcol = 0;
		
		/*Array.prototype.max = function () {
			return Math.max.apply(Math, this);
		};
		console.log(imgw[0]);
		console.log(imgw.max());*/

		$('#procs .canvasDraw').livequery(function() {
			//$(this).each(function(i,el) {
			  var id = this.id;
			  var rel = $(this).attr('rel');
			  var index = $("#procs .canvasDraw").index(this);
			  var curcol = index % 10;
			  contexts[id] = this.getContext('2d');
			  contexts[id].strokeStyle = colors[curcol];
			  //contexts[id].width = '1200';
			//  $('#dia-'+rel).css('background',colors[curcol])
			  contexts[id].lineWidth   = 3;
			  
			//})
		})			

		// This will be defined on a TOUCH device such as iPad or Android, etc.
		var is_touch_device = 'ontouchstart' in document.documentElement;
		if (is_touch_device) {
            // create a drawer which tracks touch movements
			var drawer = new Array();
			$('#procs .canvasDraw').livequery(function() {
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
					   /*,
					   touchend: function (coors) {
						  alert('yoyo');
						  if (this.isDrawing) {
							 this.touchmove(coors);
							 this.isDrawing = false;
							 
							 var can = document.getElementById(id); 
		var img = can.toDataURL();
		restorePoints[id].push(restorePoint[id]);
		restorePoint[id] = img;
		var rel = $('#'+id).attr('rel');
		procs_drawings.saveDrawing(rel,img);
						  }
					   }*/
					};
				//})
			})
            // create a function to pass touch events and coordinates to drawer
            function draw(event,obj) {
			   var id = obj.id
			   var cparent = $('#procs-right .scroll-pane');
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
			
			$(document).on('touchend','#procs .canvasDraw',function(mouseEvent) {
				var id = $(this).attr('id');
				if (drawer[id].isDrawing) {
					drawer[id].isDrawing = false;
					$('#procs span.undoTool').addClass('active');
					var can = document.getElementById(id); 
					var img = can.toDataURL();
					restorePoints[id].push(restorePoint[id]);
					restorePoint[id] = img;
					var rel = $('#'+id).attr('rel');
					procs_drawings.saveDrawing(rel,img);
				}
			});

			/*$('.canvasDraw').livequery(function() {
				//$(this).each(function(el) {
					this.addEventListener('touchstart', function(){draw(event,this)}, false);
					this.addEventListener('touchmove', function(){draw(event,this)}, false);
					this.addEventListener('touchend', function(){draw(event,this)}, false);
					// prevent elastic scrolling
				   this.addEventListener('touchmove', function (event) {
					   event.preventDefault();
					}, false);
				//})
			})*/
		} else {
			// Pencil
			$(document).on('mousedown','#procs .canvasDraw',function(mouseEvent) {
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
		}
	});
	  
	  
	var contexts = new Array(); 
	function getPosition(e, id) {
	   var x, y;
	   var canvas = $('#'+id).get(0);
	   var canvasOffset = $('#'+id).offset();
	   var cparent = $('#procs-right .scroll-pane');
	   var cparentOffset = cparent.offset();
	   var cparentTop = cparent.scrollTop();
	   var cparentLeft = cparent.scrollLeft();
	   if (e.pageX != undefined && e.pageY != undefined) {
		  x = e.pageX;
		  y = e.pageY;
	   } else {
		  x = e.clientX + document.body.scrollLeft + document.documentElement.scrollLeft;
		  y = e.clientY + document.body.scrollTop + document.documentElement.scrollTop;
	   }
	   return { X: x - canvasOffset.left, Y: y - canvasOffset.top};
	}
 
 
	// draws a line to the x and y coordinates of the mouse event inside
	// the specified element using the specified context
	function drawLine(mouseEvent, id) {
	   var position = getPosition(mouseEvent, id);
	   contexts[id].lineTo(position.X, position.Y);
	   contexts[id].stroke();
	}
 
	// draws a line from the last coordiantes in the path to the finishing
	// coordinates and unbind any event handlers which need to be preceded
	// by the mouse down event
	function finishDrawing(mouseEvent, id) {
		//drawLine(mouseEvent, id);
		$('#procs span.undoTool').addClass('active');
		var can = document.getElementById(id); 
		var img = can.toDataURL();
		restorePoints[id].push(restorePoint[id]);
		restorePoint[id] = img;
		var rel = $('#'+id).attr('rel');
		procs_drawings.saveDrawing(rel,img);
		$('#'+id).unbind("mousemove").unbind("mouseup").unbind("mouseout");
	}
	
	$(document).on('click','a.binDiagnose',function(e) {
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
					$.ajax({ type: "GET", url: "/", data: "path=apps/procs/modules/drawings&request=binDiagnose&id=" + id, success: function(data){
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
	});