function header( ){
	var self = this;
	var $root = $('#header');
	

	self.init = function( data ){
		
		// url = data.url;
		
		// $.getJSON(url , function( result ){
		setupClicks( );
		// });

		
	}

	function setupClicks( ){
		$('.menu_item , .menu_element', $root).click( function( ){
			if($(this).hasClass("menu_element") && $(this).children().length > 0){
				return;
			}
			// console.log("Clicking an article", $(this),$(this).data("id") , $(this).data("href"));
			if( $(this).data("href")!=null ){
				// console.log("in href:",$(this).data("href"));
				window.location.href = $(this).data("href");	
				return;
			}			
			var loc="";
			if( !window.location.origin ) {
				loc = widnow.location.origin = window.location.protocol+"//"+window.location.host;
			}
			// console.log("in data id:",$(this).data("id"));
			window.location.href = loc+"article.php?id="+$(this).data("id");
		} );

	}
}