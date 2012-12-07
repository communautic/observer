var zIndexes = 0;
var restorePoints = [];
var restorePoint = [];
var activeCanvas;
var c;
var j;
var a;

	function setImage(dataURL) {  
		var img = new Image();  
		img.onload = function() {
			var context = activeCanvas.getContext("2d");
			//context.clearRect(0, 0, 400, 400);
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
					$.ajax({ type: "GET", url: "/", dataType:  'json', data: "path=apps/patients/modules/treatments&request=updatePosition&id="+id+"&x="+x+"&y="+y, success: function(data){
						}
					});
				}
			});
		});

		$(document).on('click','div.loadCanvas',function(e) {
			e.preventDefault();
			var rel = $(this).attr('rel');
			var id = $(this).attr("id").replace(/dia-/, "");
			activeCanvas = $("#c"+rel)[0];
			zIndexes = ++zIndexes;
			$('div.loadCanvas').removeClass('active');
			$('div.loadCanvasList').removeClass('active');
			$('#canvasList_'+id).addClass('active').find('textarea').focus();
			$(this).css('z-index',zIndexes).addClass('active');
			$('.canvasDraw').css('z-index',1);
			$('#c'+rel).css('z-index',2);
		})

		$(document).on('click','.loadCanvasList',function(e) {
			e.preventDefault();
			var rel = $(this).attr('rel');
			var id = $(this).attr("id").replace(/canvasList_/, "");
			activeCanvas = $("#c"+rel)[0];
			zIndexes = ++zIndexes;
			$('div.loadCanvas').removeClass('active');
			$('#dia-'+id).css('z-index',zIndexes).addClass('active');
			$('div.loadCanvasList').removeClass('active');
			$(this).addClass('active');
			$('.canvasDraw').css('z-index',1);
			$('#c'+rel).css('z-index',2);
		})

		$(document).on('click','a.addDiagnose',function(e) {
			e.preventDefault();
			patients_treatments.newDrawing();
		})

		$(document).on('click','a.clearActive',function(e) {
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
		})

		$(document).on('click','a.undoDraw',function(e) {
			e.preventDefault();
			var id = activeCanvas.id;
			var context = activeCanvas.getContext("2d");
			context.clearRect(0, 0, 400, 400);
			//restorePoints[a].pop()
			var img = restorePoints[id].pop();
			//window.open(img);
			setImage(img);
			restorePoint[id] = img;
			var rel = $('#'+id).attr('rel');
			patients_treatments.saveDrawing(rel,img);
			
			if (restorePoints[id].length < 1) {
				//alert('no more');
			}
		})
		
		
		var color_c1 = '#FF0000';
		var color_c2 = '#000000';
		
		$('.canvasDraw').livequery(function() {
			$(this).each(function(el) {
			  var id = this.id;
			  contexts[id] = this.getContext('2d');
			  contexts[id].strokeStyle = 'color_'+id;
			  //context[id].globalCompositeOperation = "destination-out";
			  //context[id].strokeStyle = '#FF0000';

			  contexts[id].lineWidth   = 2;
			  //console.log('init ' + id);
			})
		})			

		// This will be defined on a TOUCH device such as iPad or Android, etc.
		var is_touch_device = 'ontouchstart' in document.documentElement;
		if (is_touch_device) {
            // create a drawer which tracks touch movements
			var drawer = new Array();
			$('.canvasDraw').livequery(function() {
				$(this).each(function(el) {
					var id = this.id;
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
					   },
					   touchend: function (coors) {
						  if (this.isDrawing) {
							 this.touchmove(coors);
							 this.isDrawing = false;
						  }
					   }
					};
				})
			})
            // create a function to pass touch events and coordinates to drawer
            function draw(event,obj) {
               var coors = {x: event.targetTouches[0].pageX,y: event.targetTouches[0].pageY};
			   var id = obj.id
               if (obj.offsetParent) {
                  do {
                     coors.x -= obj.offsetLeft;
                     coors.y -= obj.offsetTop;
                  }
                  while ((obj = obj.offsetParent) != null);
               }
               drawer[id][event.type](coors);
            }

			$('.canvasDraw').livequery(function() {
				$(this).each(function(el) {
					this.addEventListener('touchstart', function(){draw(event,this)}, false);
					this.addEventListener('touchmove', function(){draw(event,this)}, false);
					this.addEventListener('touchend', function(){draw(event,this)}, false);
					// prevent elastic scrolling
				   this.addEventListener('touchmove', function (event) {
					   event.preventDefault();
					}, false);
				})
			})
		} else {
			$(document).on('mousedown','.canvasDraw',function(mouseEvent) {
			   var id = $(this).attr('id');
			   var position = getPosition(mouseEvent, id);
			   contexts[id].moveTo(position.X, position.Y);
			   contexts[id].beginPath();
			   $(this).mousemove(function (mouseEvent) {
				  drawLine(mouseEvent, id);
			   }).mouseup(function (mouseEvent) {
				  finishDrawing(mouseEvent, id);
			   }).mouseout(function (mouseEvent) {
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
	   //alert(y - canvas.offsetTop - parentOffset.top);
	   //return { X: x - canvas.offsetLeft - cparentOffset.left, Y: y - canvas.offsetTop - cparentOffset.top + cparentTop};
	   return { X: x - canvas.offsetLeft - cparentOffset.left, Y: y - canvasOffset.top};
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
		drawLine(mouseEvent, id);
		console.log(id);
		var can = document.getElementById(id); 
		var img = can.toDataURL();
		window.open(img);
		restorePoints[id].push(restorePoint[id]);
		restorePoint[id] = img;
		var rel = $('#'+id).attr('rel');
		patients_treatments.saveDrawing(rel,img);
		$('#'+id).unbind("mousemove").unbind("mouseup").unbind("mouseout");
	}