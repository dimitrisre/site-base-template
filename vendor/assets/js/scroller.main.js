function scroller( ){
	var self = this;
	var $root = $('#scroller');
	var $container =$('.scroller_container', $root);
	var left = 0;

	self.init = function( data ){
		
		url = data.url;
		setupClicks( );		
	}

	function beginAnimation( ){
		$(".scroll_animation").css("animation-play-state","running");
		$(".scroll_animation").css("-webkit-animation-play-state","running");
	}

	function pauseAnimation( ){
		$(".scroll_animation").css("animation-play-state","paused");
		$(".scroll_animation").css("-webkit-animation-play-state","paused");
	}

	function setupClicks( ){
		$root.hover(function(){
			pauseAnimation();
		}, function(){
			beginAnimation();
		});
	}
}