$(document).ready(function() { 
	
	$("#columns").livequery( function() {
		$(".column").sortable({
				cursor: 'move',
				handle: '.widget-head',
				helper: 'clone',
				delay: 100,
				opacity: 0.8,
				revert: 300,

            containment: 'document',
			placeholder: 'widget-placeholder',
            forcePlaceholderSize: true,

				connectWith: '.column'
		}).disableSelection();
	});
	
	$('a.collapse').live('click', function (e) {
		return false;
	}).toggle(function () {
		$(this).css({backgroundPosition: '-13px 0'}).parent().next().slideUp();
		return false;
	},function () {
		$(this).css({backgroundPosition: ''}).parent().next().slideDown();
	return false;
	}); 
	
});