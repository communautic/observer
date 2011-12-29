// JavaScript Document

$(document).ready(function() { 
	
	// prevent entire body to move
	/*$('body').bind('touchmove',function(e){
      	e.preventDefault();
	});*/
	
	// Desktop Postits Edit
	$('#desktop div.postit-text, #brainstorms-outer div.note-text').livequery(function() {
		$(this).addSwipeEvents().live('doubletap', function(e, touch) {
			$(this).trigger('dblclick');
		});
	});
	
	
	

    /*$('span').each(function() {

        var clicked = false;

        $(this).bind('click', function() {

            if(!clicked) return !(clicked = true);
        });
    });*/

	
});