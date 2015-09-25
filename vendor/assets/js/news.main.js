function news( ){
	var anim_id = -1;
	var curr = 0;
	var elems = new Array();
	var self = this;
	var $root = $('#news');
	var url = "";
	var time = 7000;

	self.init = function( data ){
		
		elems[4] = $('.article1', $root);
		elems[3] = $('.article2', $root);
		elems[2] = $('.article3', $root);
		elems[1] = $('.article4', $root);
		elems[0] = $('.article5', $root);
		url = data.url;
		
		$('#time').val(time*1000);
		
		beginAnimation( );
		setupClicks( );
	
	}

	self.load = function( data ){
		// $.getJSON( data.url , function( result ){
		// 	console.log("results slideshow admin:",result);
		// 	_.each( result.articles, function( a, i ){
		// 		if( i > 4){
		// 			$('#time').val( a.time/1000 );
		// 			return false;
		// 		}

		// 		$("#title"+(i+1)).val( a.desc );
		// 		$("#link"+(i+1)).val( a.src );
		// 	} );

		// } );
	}

	function beginAnimation( ){
		if( anim_id < 0 ){
			anim_id = setInterval( function( ){
				elems[curr].fadeOut( time/7 );
				curr = (curr+1)%5;
				elems[curr].fadeIn( time/7 );
			}, time );
		}
	}

	function stopAnimation( ){
		clearInterval( anim_id );
		anim_id = -1;
	}
	function setupClicks(){
		$('.right_nav', $root).click( function(){
			stopAnimation( );

			elems[curr].fadeOut( 1000 );
			curr = (curr+1)%5;
			elems[curr].fadeIn( 1000 );
			
			beginAnimation( );
		});

		$('.left_nav', $root).click( function(){
			stopAnimation( );

			elems[curr].fadeOut( 1000 );
			curr = ((curr-1) < 0) ? 0 : curr-1;
			elems[curr].fadeIn( 1000 );

			beginAnimation( );
		});
	}
}