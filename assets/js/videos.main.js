function videos( ){
	var $root 		= $('#videos');
	var $player 	= $('#videoplayer');
	var $video_list = $('#videolist');
	var popcorn;
	var self = this;
	var url = "";
	var page = 0;

	this.init = function( data ){
		url = data.url;

		// $.getJSON(url, {"page":page}, function( result ){
		// 	console.log("Results (videos):", result);

		// 	_.each( result.videos, function( v ){
		// 		v.src += "&controls=2";
		// 		var $v = $('<div class="video_link" data-type="'+v.type+'" data-link="'+v.src+'">'+v.title+'</div>');
		// 		$video_list.append( $v );
		// 		$v.click( function( ){
		// 			console.log("New video link clicked");
		// 			var type = $(this).data("type");
		// 			var link = $(this).data("link");

		// 			var win = window.open(link, "_blank");
		// 			win.focus();
		// 		} );
		// 	} );
		// 	// popcorn = Popcorn.youtube( $player[0], result.videos[0].src );

		// 	$v = $('<div class="more_videos">').text("More...")
		// 	$video_list.append( $v );
		// 	page += 1;
		// });
		$('.video_link').click(function( ){
					console.log("New video link clicked");
					var type = $(this).data("type");
					var link = $(this).data("link");

					var win = window.open(link, "_blank");
					win.focus();
		})
		setupClicks( );

		// popcorn = Popcorn.youtube( $player[0],
		// 	"https://www.youtube.com/watch?v=O83bZYTz8K0&controls=2"  );
}

function setupClicks( ){

	$('.more_videos', $root).click( function( ){
		console.log("Fetching page",page);
		var self = this;

		$.getJSON(url, {"page":page, method:"videos"}, function( result ){
			console.log("Results (videos):", result);

			_.each( result.videos, function( v ){
				var $v = $('<div class="video_link" data-type="'+v.type+'" data-link="'+v.src+'">'+v.title+'</div>');
				$video_list.append( $v );
				$v.click( function( ){
					console.log("New video link clicked");
					var type = $(this).data("type");
					var link = $(this).data("link");

					var win = window.open(link, "_blank");
					win.focus();
				} );
			} );
			
			$(self).detach().appendTo($video_list);
			page += 1;

		} );
	});
}
}
