/*
 * jNice
 * version: 1.0 (11.26.08)
 * by Sean Mooney (sean@whitespace-creative.com) 
 * Examples at: http://www.whitespace-creative.com/jquery/jnice/
 * Dual licensed under the MIT and GPL licenses:
 *   http://www.opensource.org/licenses/mit-license.php
 *   http://www.gnu.org/licenses/gpl.html
 *
 * To Use: place in the head 
 *  <link href="inc/style/jNice.css" rel="stylesheet" type="text/css" />
 *  <script type="text/javascript" src="inc/js/jquery.jNice.js"></script>
 *
 * And apply the jNice class to the form you want to style
 *
 * To Do: Add textareas, Add File upload
 *
 ******************************************** */
(function($){
	$.fn.jNice = function(options){
		var self = this;
		/*var safari = $.browser.safari;  We need to check for safari to fix the input:text problem */
		/* Apply document listener */
		$(document).mousedown(checkExternalClick);
		/* each form */
		return this.each(function(){
			//$('input:submit, input:reset, input:button', this).each(ButtonAdd);
			//$('button').focus(function(){ $(this).addClass('jNiceFocus')}).blur(function(){ $(this).removeClass('jNiceFocus')});
			//$('input:text:visible, input:password', this).each(TextAdd);
			/* If this is safari we need to add an extra class */
			//if (safari){$('.jNiceInputWrapper').each(function(){$(this).addClass('jNiceSafari').find('input').css('width', $(this).width()+11);});}
			$('input:checkbox', this).each(CheckAdd);
			$('input:radio', this).each(RadioAdd);
			$('select', this).each(function(index){ SelectAdd(this, index); });
			/* Add a new handler for the reset action */
			$(this).bind('reset',function(){var action = function(){ Reset(this); }; window.setTimeout(action, 10); });
			//$('.jNiceHidden').css({opacity:0});
		});		
	};/* End the Plugin */

	var Reset = function(form){
		var sel;
		$('.jNiceSelectWrapper select', form).each(function(){sel = (this.selectedIndex<0) ? 0 : this.selectedIndex; $('ul', $(this).parent()).each(function(){$('a:eq('+ sel +')', this).click();});});
		$('a.jNiceCheckbox, a.jNiceRadio', form).removeClass('jNiceChecked');
		$('input:checkbox, input:radio', form).each(function(){if(this.checked){$('a', $(this).parent()).addClass('jNiceChecked');}});
	};

	var RadioAdd = function(){
		//var $input = $(this).addClass('jNiceHidden').wrap('<span class="jRadioWrapper jNiceWrapper"></span>');
		var $input = $(this).wrap('<span class="jRadioWrapper jNiceWrapper"></span>');
		var $wrapper = $input.parent();
		var $a = $('<span class="jNiceRadio"></span>');
		$wrapper.prepend($a);
		/* Click Handler */
		$a.click(function(){
				var $input = $(this).addClass('jNiceChecked').siblings('input').attr('checked',true);
				/* uncheck all others of same name */
				$('input:radio[name="'+ $input.attr('name') +'"]').not($input).each(function(){
					$(this).attr('checked',false).siblings('.jNiceRadio').removeClass('jNiceChecked');
					// activate create
					/*if($(this).attr('name') == 'protocol' || $(this).attr('name') == 'document') {
						$("#actionconsole > ul > li:eq(3)").addClass('activated');
					}*/
					var input = $a.siblings('input')[0];
					alert(input.value);
				});
				return false;
		});
		$input.click(function(){
			if(this.checked){
				var $input = $(this).siblings('.jNiceRadio').addClass('jNiceChecked').end();
				/* uncheck all others of same name */
				$('input:radio[name="'+ $input.attr('name') +'"]').not($input).each(function(){
					$(this).attr('checked',false).siblings('.jNiceRadio').removeClass('jNiceChecked');
				});
			}
		}).focus(function(){ $a.addClass('jNiceFocus'); }).blur(function(){ $a.removeClass('jNiceFocus'); });

		/* set the default state */
		if (this.checked){ $a.addClass('jNiceChecked'); }
	};

	var CheckAdd = function(){
		//var $input = $(this).addClass('jNiceHidden').wrap('<span class="jNiceWrapper"></span>');
		var $input = $(this).wrap('<span class="jNiceWrapper"></span>');
		if($(this).hasClass('noperm')) {
			var $wrapper = $input.parent().append('<span class="jNiceCheckbox noperm"></span>');
		} else {
			var $wrapper = $input.parent().append('<span class="jNiceCheckbox"></span>');
		}
		/* Click Handler */
		var $a = $wrapper.find('.jNiceCheckbox').click(function(){
				var $a = $(this);
				if($(this).hasClass('noperm')) {
					return false;
				}
				
				var obj = getCurrentModule();
				if(obj.name == "forums") {
					var input = $a.siblings('input')[0];
					var itemid = input.value;
					if (input.checked===true){
						input.checked = false;
						$a.removeClass('jNiceChecked');
						$("#forumsAnswer_"+itemid).slideUp(function() { 
							$(this).remove();
							if($('#forumsAnswer').html() == "") {
								$('#forumsAnswerOuter').slideUp();
							}		 
						});
						var status = 0;
					} else {
						input.checked = true;
						$a.addClass('jNiceChecked');
						$('#forumsAnswerOuter').slideDown();
						$("#forumsPostanswer_"+itemid).clone().attr('id','forumsAnswer_'+itemid).css('display','none').appendTo('#forumsAnswer').slideDown();
						var status = 1;
					}
					$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/forums&request=setItemStatus&id="+itemid+"&status=" + status, success: function(forums){
						}
					});

				} else if(obj.name == "complaints_forums") {
					var input = $a.siblings('input')[0];
					var itemid = input.value;
					if (input.checked===true){
						input.checked = false;
						$a.removeClass('jNiceChecked');
						$("#complaintsForumsAnswer_"+itemid).slideUp(function() { 
							$(this).remove();
							if($('#complaintsForumsAnswer').html() == "") {
								$('#complaintsForumsAnswerOuter').slideUp();
							}		 
						});
						var status = 0;
					} else {
						input.checked = true;
						$a.addClass('jNiceChecked');
						$('#complaintsForumsAnswerOuter').slideDown();
						$("#complaintsForumsPostanswer_"+itemid).clone().attr('id','complaintsForumsAnswer_'+itemid).css('display','none').appendTo('#complaintsForumsAnswer').slideDown();
						var status = 1;
					}
					$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/complaints/modules/forums&request=setItemStatus&id="+itemid+"&status=" + status, success: function(forums){
						}
					});
				} else if(obj.name == "procs_grids") {
					var input = $a.siblings('input')[0];
					var itemid = input.value;
					var col = $('div.procs-phase').index($a.closest('div.procs-phase'));
					var ncbx = $('div.procs-phase:eq('+col+') input:checkbox').length;
					if (input.checked===true){
						input.checked = false;
						$a.removeClass('jNiceChecked');
						var n = $('div.procs-phase:eq('+col+') input:checked').length;
						if(n == 0) {
							$('div.procs-col-title:eq('+col+')').removeClass('progress').removeClass('finished').addClass('planned');
						}
						if(ncbx > n && n > 0) {
							$('div.procs-col-title:eq('+col+')').removeClass('planned').removeClass('finished').addClass('progress');
						}
						$('div.procs-col-footer:eq('+col+') .procs-stagegate').removeClass('active');
						var status = 0;
					} else {
						input.checked = true;
						$a.addClass('jNiceChecked');
						var n = $('div.procs-phase:eq('+col+') input:checked').length;
						if(ncbx > n && n > 0) {
							$('div.procs-col-title:eq('+col+')').removeClass('planned').removeClass('finished').addClass('progress');
						}
						if(ncbx == n) {
							$('div.procs-col-title:eq('+col+')').removeClass('planned').removeClass('progress').addClass('finished');
							$('div.procs-col-footer:eq('+col+') .procs-stagegate').addClass('active');
						}
						var status = 1;
					}
					$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/procs/modules/grids&request=setItemStatus&id="+itemid+"&status=" + status, success: function(forums){
						}
					});
				} else if(obj.name == "complaints_grids") {
					var input = $a.siblings('input')[0];
					var itemid = input.value;
					var col = $('div.complaints-phase').index($a.closest('div.complaints-phase'));
					var ncbx = $('div.complaints-phase:eq('+col+') input:checkbox').length;
					if (input.checked===true){
						input.checked = false;
						$a.removeClass('jNiceChecked');
						var n = $('div.complaints-phase:eq('+col+') input:checked').length;
						if(n == 0) {
							$('div.complaints-col-title:eq('+col+')').removeClass('progress').removeClass('finished').addClass('planned');
						}
						if(ncbx > n && n > 0) {
							$('div.complaints-col-title:eq('+col+')').removeClass('planned').removeClass('finished').addClass('progress');
						}
						$('div.complaints-col-footer:eq('+col+') .complaints-stagegate').removeClass('active');
						var status = 0;
					} else {
						input.checked = true;
						$a.addClass('jNiceChecked');
						var n = $('div.complaints-phase:eq('+col+') input:checked').length;
						if(ncbx > n && n > 0) {
							$('div.complaints-col-title:eq('+col+')').removeClass('planned').removeClass('finished').addClass('progress');
						}
						if(ncbx == n) {
							$('div.complaints-col-title:eq('+col+')').removeClass('planned').removeClass('progress').addClass('finished');
							$('div.complaints-col-footer:eq('+col+') .complaints-stagegate').addClass('active');
						}
						var status = 1;
					}
					$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/complaints/modules/grids&request=setItemStatus&id="+itemid+"&status=" + status, success: function(forums){
						}
					});
					
				} else if(obj.name == "clients") {
					var input = $a.siblings('input')[0];
					var itemid = input.value;
					var cid = $('#clients input[name="id"]').val();
					if (input.checked===true){
						var txt = ALERT_CLIENT_ACCESS_REMOVE;
						var langbuttons = {};
						langbuttons[ALERT_YES] = true;
						langbuttons[ALERT_NO] = false;
						$.prompt(txt,{ 
							buttons:langbuttons,
							submit: function(e,v,m,f){		
								if(v){
									input.checked = false;
									$a.removeClass('jNiceChecked');
									$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/clients&request=&request=removeAccess&id="+itemid+"&cid=" + cid, success: function(brainstorm){
										$('#access_tr_'+itemid).slideUp();
										//console.log(itemid);
										}
									});
								} 
							}
						});
					} else {
						var txt = ALERT_CLIENT_ACCESS;
						var langbuttons = {};
						langbuttons[ALERT_YES] = true;
						langbuttons[ALERT_NO] = false;
						$.prompt(txt,{ 
							buttons:langbuttons,
							submit: function(e,v,m,f){		
								if(v){
									input.checked = true;
									$a.addClass('jNiceChecked');
									$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/clients&request=&request=generateAccess&id="+itemid+"&cid=" + cid, success: function(brainstorm){
										}
									});
								} 
							}
						});
					}
				
				} else {
					var input = $a.siblings('input')[0];
					if (input.checked===true){
						input.checked = false;
						$a.removeClass('jNiceChecked');
						$("#donedate_"+input.value).slideUp('slow');
					}
					else {
						input.checked = true;
						$a.addClass('jNiceChecked');
						$("#donedate_"+input.value).slideDown('slow');
					}
					
					var obj = getCurrentModule();
					$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
				}
				return false;
		});
		$input.click(function(){
			if(this.checked){ $a.addClass('jNiceChecked'); 	}
			else { $a.removeClass('jNiceChecked'); }
		}).focus(function(){ $a.addClass('jNiceFocus'); }).blur(function(){ $a.removeClass('jNiceFocus'); });
		
		/* set the default state */
		if (this.checked){$('.jNiceCheckbox', $wrapper).addClass('jNiceChecked');}
	};
	
	var CheckAddPO = function(element){
		//var checkbox = element;
		var $checkbox = $(element);
		var $input = $checkbox.addClass('jNiceHidden').wrap('<span class="jNiceWrapper"></span>');
		var $wrapper = $input.parent().append('<span class="jNiceCheckbox"></span>');
		/* Click Handler */
		
		var $a = $wrapper.find('.jNiceCheckbox').click(function(){
				var $a = $(this);
				var obj = getCurrentModule();
				if(obj.name == "forums") {
					var input = $a.siblings('input')[0];
					var itemid = input.value;
					if (input.checked===true){
						input.checked = false;
						$a.removeClass('jNiceChecked');
						$("#forumsAnswer_"+itemid).slideUp(function() { 
							$(this).remove();
							if($('#forumsAnswer').html() == "") {
								$('#forumsAnswerOuter').slideUp();
							}		 
						});
						var status = 0;
						
					} else {
						input.checked = true;
						$a.addClass('jNiceChecked');
						$('#forumsAnswerOuter').slideDown();
						$("#forumsPostanswer_"+itemid).clone().attr('id','forumsAnswer_'+itemid).css('display','none').appendTo('#forumsAnswer').slideDown();
						var status = 1;
					}
					$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/forums&request=setItemStatus&id="+itemid+"&status=" + status, success: function(forums){
									}
								});

				} else if(obj.name == "complaints_forums") {
					var input = $a.siblings('input')[0];
					var itemid = input.value;
					if (input.checked===true){
						input.checked = false;
						$a.removeClass('jNiceChecked');
						$("#complaintsForumsAnswer_"+itemid).slideUp(function() { 
							$(this).remove();
							if($('#complaintsForumsAnswer').html() == "") {
								$('#complaintsForumsAnswerOuter').slideUp();
							}		 
						});
						var status = 0;
					} else {
						input.checked = true;
						$a.addClass('jNiceChecked');
						$('#complaintsForumsAnswerOuter').slideDown();
						$("#complaintsForumsPostanswer_"+itemid).clone().attr('id','complaintsForumsAnswer_'+itemid).css('display','none').appendTo('#complaintsForumsAnswer').slideDown();
						var status = 1;
					}
					$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/complaints/modules/forums&request=setItemStatus&id="+itemid+"&status=" + status, success: function(forums){
						}
					});
				} else if(obj.name == "procs_grids") {
					var input = $a.siblings('input')[0];
					var itemid = input.value;
					var col = $('div.procs-phase').index($a.closest('div.procs-phase'));
					var ncbx = $('div.procs-phase:eq('+col+') input:checkbox').length;
					if (input.checked===true){
						input.checked = false;
						$a.removeClass('jNiceChecked');
						var n = $('div.procs-phase:eq('+col+') input:checked').length;
						if(n == 0) {
							$('div.procs-col-title:eq('+col+')').removeClass('progress').removeClass('finished').addClass('planned');
						}
						if(ncbx > n && n > 0) {
							$('div.procs-col-title:eq('+col+')').removeClass('planned').removeClass('finished').addClass('progress');
						}
						$('div.procs-col-footer:eq('+col+') .procs-stagegate').removeClass('active');
						var status = 0;
					} else {
						input.checked = true;
						$a.addClass('jNiceChecked');
						var n = $('div.procs-phase:eq('+col+') input:checked').length;
						if(ncbx > n && n > 0) {
							$('div.procs-col-title:eq('+col+')').removeClass('planned').removeClass('finished').addClass('progress');
						}
						if(ncbx == n) {
							$('div.procs-col-title:eq('+col+')').removeClass('planned').removeClass('progress').addClass('finished');
							$('div.procs-col-footer:eq('+col+') .procs-stagegate').addClass('active');
						}
						var status = 1;
					}
					$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/procs/modules/grids&request=setItemStatus&id="+itemid+"&status=" + status, success: function(forums){
						}
					});
					} else if(obj.name == "complaints_grids") {
					var input = $a.siblings('input')[0];
					var itemid = input.value;
					var col = $('div.complaints-phase').index($a.closest('div.complaints-phase'));
					var ncbx = $('div.complaints-phase:eq('+col+') input:checkbox').length;
					if (input.checked===true){
						input.checked = false;
						$a.removeClass('jNiceChecked');
						var n = $('div.complaints-phase:eq('+col+') input:checked').length;
						if(n == 0) {
							$('div.complaints-col-title:eq('+col+')').removeClass('progress').removeClass('finished').addClass('planned');
						}
						if(ncbx > n && n > 0) {
							$('div.complaints-col-title:eq('+col+')').removeClass('planned').removeClass('finished').addClass('progress');
						}
						$('div.complaints-col-footer:eq('+col+') .complaints-stagegate').removeClass('active');
						var status = 0;
						
					} else {
						input.checked = true;
						$a.addClass('jNiceChecked');
						var n = $('div.complaints-phase:eq('+col+') input:checked').length;
						
						if(ncbx > n && n > 0) {
							$('div.complaints-col-title:eq('+col+')').removeClass('planned').removeClass('finished').addClass('progress');
						}
						
						if(ncbx == n) {
							$('div.complaints-col-title:eq('+col+')').removeClass('planned').removeClass('progress').addClass('finished');
							$('div.complaints-col-footer:eq('+col+') .complaints-stagegate').addClass('active');
						}
						//$('#forumsAnswerOuter').slideDown();
						//$("#forumsPostanswer_"+itemid).clone().attr('id','forumsAnswer_'+itemid).css('display','none').appendTo('#forumsAnswer').slideDown();
						var status = 1;
					}
					$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/complaints/modules/grids&request=setItemStatus&id="+itemid+"&status=" + status, success: function(forums){
									}
								});

			
				} else if(obj.name == "clients") {
					var input = $a.siblings('input')[0];
					var itemid = input.value;
					var cid = $('#clients input[name="id"]').val();
					if (input.checked===true){
						var txt = ALERT_CLIENT_ACCESS_REMOVE;
						var langbuttons = {};
						langbuttons[ALERT_YES] = true;
						langbuttons[ALERT_NO] = false;
						$.prompt(txt,{ 
							buttons:langbuttons,
							submit: function(e,v,m,f){		
								if(v){
									input.checked = false;
									$a.removeClass('jNiceChecked');
									$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/clients&request=&request=removeAccess&id="+itemid+"&cid=" + cid, success: function(brainstorm){
										$('#access_tr_'+itemid).slideUp();
										//console.log(itemid);
										}
									});
								} 
							}
						});
					} else {
						var txt = ALERT_CLIENT_ACCESS;
						var langbuttons = {};
						langbuttons[ALERT_YES] = true;
						langbuttons[ALERT_NO] = false;
						$.prompt(txt,{ 
							buttons:langbuttons,
							submit: function(e,v,m,f){		
								if(v){
									input.checked = true;
									$a.addClass('jNiceChecked');
									$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/clients&request=&request=generateAccess&id="+itemid+"&cid=" + cid, success: function(brainstorm){
										}
									});
								} 
							}
						});
					}
					
				
				} else {
					var input = $a.siblings('input')[0];
					if (input.checked===true){
						input.checked = false;
						$a.removeClass('jNiceChecked');
						$("#donedate_"+input.value).slideUp('slow');
					}
					else {
						input.checked = true;
						$a.addClass('jNiceChecked');
						$("#donedate_"+input.value).slideDown('slow');
					}
				}
				//var obj = getCurrentModule();
				$('#'+getCurrentApp()+' .coform').ajaxSubmit(obj.poformOptions);
				return false;
		});
		$input.click(function(){
			if(this.checked){ $a.addClass('jNiceChecked'); 	}
			else { $a.removeClass('jNiceChecked'); }
			
		}).focus(function(){ $a.addClass('jNiceFocus'); }).blur(function(){ $a.removeClass('jNiceFocus'); });
		
		/* set the default state */
		if (this.checked){$('.jNiceCheckbox', $wrapper).addClass('jNiceChecked');}
	};

	var TextAdd = function(){
		var $input = $(this).addClass('jNiceInput').wrap('<div class="jNiceInputWrapper"><div class="jNiceInputInner"></div></div>');
		var $wrapper = $input.parents('.jNiceInputWrapper');
		$input.focus(function(){ 
			$wrapper.addClass('jNiceInputWrapper_hover');
		}).blur(function(){
			$wrapper.removeClass('jNiceInputWrapper_hover');
		});
	};

	var ButtonAdd = function(){
		var value = $(this).attr('value');
		$(this).replaceWith('<button id="'+ this.id +'" name="'+ this.name +'" type="'+ this.type +'" class="'+ this.className +'" value="'+ value +'"><span><span>'+ value +'</span></span>');
	};

	/* Hide all open selects */
	var SelectHide = function(){
			$('.jNiceSelectWrapper ul:visible').hide();
	};

	/* Check for an external click */
	var checkExternalClick = function(event) {
		if ($(event.target).parents('.jNiceSelectWrapper').length === 0) { SelectHide(); }
	};

	var SelectAdd = function(element, index){
		var $select = $(element);
		index = index || $select.css('zIndex')*1;
		index = (index) ? index : 0;
		/* First thing we do is Wrap it */
		$select.wrap($('<div class="jNiceWrapper"></div>').css({zIndex: 100-index}));
		var width = $select.width();
		$select.addClass('jNiceHidden').after('<div class="jNiceSelectWrapper"><div><span class="jNiceSelectText"></span><span class="jNiceSelectOpen"></span></div><ul></ul></div>');
		var $wrapper = $(element).siblings('.jNiceSelectWrapper').css({width: width +'px'});
		$('.jNiceSelectText, .jNiceSelectWrapper ul', $wrapper).width( width - $('.jNiceSelectOpen', $wrapper).width());
		/* IF IE 6 */
		if ($.browser.msie && jQuery.browser.version < 7) {
			$select.after($('<iframe src="javascript:\'\';" marginwidth="0" marginheight="0" align="bottom" scrolling="no" tabIndex="-1" frameborder="0"></iframe>').css({ height: $select.height()+4 +'px' }));
		}
		/* Now we add the options */
		SelectUpdate(element);
		/* Apply the click handler to the Open */
		$('div', $wrapper).click(function(){
			var $ul = $(this).siblings('ul');
			if ($ul.css('display')=='none'){ SelectHide(); } /* Check if box is already open to still allow toggle, but close all other selects */
			$ul.slideToggle();
			var offSet = ($('a.selected', $ul).offset().top - $ul.offset().top);
			$ul.animate({scrollTop: offSet});
			return false;
		});
		/* Add the key listener */
		$select.keydown(function(e){
			var selectedIndex = this.selectedIndex;
			switch(e.keyCode){
				case 40: /* Down */
					if (selectedIndex < this.options.length - 1){ selectedIndex+=1; }
					break;
				case 38: /* Up */
					if (selectedIndex > 0){ selectedIndex-=1; }
					break;
				default:
					return;
					break;
			}
			$('ul a', $wrapper).removeClass('selected').eq(selectedIndex).addClass('selected');
			$('span:eq(0)', $wrapper).html($('option:eq('+ selectedIndex +')', $select).attr('selected', 'selected').text());
			return false;
		}).focus(function(){ $wrapper.addClass('jNiceFocus'); }).blur(function(){ $wrapper.removeClass('jNiceFocus'); });
	};

	var SelectUpdate = function(element){
		var $select = $(element);
		var $wrapper = $select.siblings('.jNiceSelectWrapper');
		var $ul = $wrapper.find('ul').find('li').remove().end().hide();
		$('option', $select).each(function(i){
			$ul.append('<li><a href="#" index="'+ i +'">'+ this.text +'</a></li>');
		});
		/* Add click handler to the a */
		$ul.find('a').click(function(){
			$('a.selected', $wrapper).removeClass('selected');
			$(this).addClass('selected');	
			/* Fire the onchange event */
			if ($select[0].selectedIndex != $(this).attr('index') && $select[0].onchange) { $select[0].selectedIndex = $(this).attr('index'); $select[0].onchange(); }
			$select[0].selectedIndex = $(this).attr('index');
			$('span:eq(0)', $wrapper).html($(this).html());
			$ul.hide();
			return false;
		});
		/* Set the defalut */
		$('a:eq('+ $select[0].selectedIndex +')', $ul).click();
	};

	var SelectRemove = function(element){
		var zIndex = $(element).siblings('.jNiceSelectWrapper').css('zIndex');
		$(element).css({zIndex: zIndex}).removeClass('jNiceHidden');
		$(element).siblings('.jNiceSelectWrapper').remove();
	};

	/* Utilities */
	$.jNice = {
			CheckAddPO : function(element){ 	CheckAddPO(element); },
			SelectAdd : function(element, index){ 	SelectAdd(element, index); },
			SelectRemove : function(element){ SelectRemove(element); },
			SelectUpdate : function(element){ SelectUpdate(element); }
	};/* End Utilities */

	/* Automatically apply to any forms with class jNice */
	$(function(){$('form.jNice').jNice();	});
})(jQuery);