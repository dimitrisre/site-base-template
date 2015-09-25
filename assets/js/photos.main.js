function photos( ){
	var self = this;
	var $root = $('#photos');
	var albumId = -1;
	var url;
	var n = 0;

	self.init = function( data ){
		url = data.url;
		albumId = data.albumId;
		console.log("Herererere");
		setupClicks( );
	}
			


	function setupClicks(){
		console.log("Hererere");
		$('.photo_entry', $root).click( function( ){
			console.log("click--->",this);
			$('.contents', $root).addClass("contents_maximized");//.append( ich.info_element() );
			
			$('.photo_entry').removeClass('photo_entry').addClass('photo_entry_maximized');
			
			// $(this).css({display:"block"});
			$(this).addClass('selected');

			$('.photo_entry_maximized', $root).each(function(){
				var h = $(this).height();
				var w = $(this).width();
				h = -Math.floor(h/2);
				w = -Math.floor(w/2);

				$(this).css({
					"margin-top"  : h+"px",
					"margin-left" : w+"px"
				});

			})
			
			
		});

		$(document).keyup(function(e) {
			if (e.keyCode == 27/*escape*/) {
				$('.contents_maximized', $root).removeClass('contents_maximized');
				$('.photo_entry_maximized', $root).removeClass('photo_entry_maximized').addClass('photo_entry');
				$('.photo_entry', $root).css({
					"margin-top"  :"none",
					"margin-left" : "none"
				});
				// $('.photo_info', $root).remove( );
				$('.selected').removeClass('selected');
				// setupClicks( );
			}else if( e.keyCode == "39" /*right*/){
				var n = $('#photos').data("length");
				var ni = $('.selected', $root).data("n")
				
				if( ni < n ){
					ni++;
					$('.selected', $root).removeClass('selected');
					$('.photo_entry_maximized[data-n="'+ni+'"]', $root).addClass('selected');
				}

			}else if( e.keyCode == "37" /*left*/){
				var n = $('#photos').data("length");
				var ni = $('.selected', $root).data("n");
				
				if( ni >= 0 ){
					ni--;
					$('.selected', $root).removeClass('selected');
					$('.photo_entry_maximized[data-n="'+ni+'"]', $root).addClass('selected');
				}
			}   
		});

	}
}