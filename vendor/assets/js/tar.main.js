function tar( ){
	var $root = $('#tar');
	var $tar_content = $('.tar_content', $root);
	var $root2 = $()
	var self = this;
	var url = "";
	var page = 1;
	
	

	this.init = function( data ){
		url = data.url;

		setupClicks();
		// getGeneral( url );

		// popcorn = Popcorn.youtube( $player[0],
		// 	"https://www.youtube.com/watch?v=O83bZYTz8K0&controls=2"  );
}

function getGeneral( url, callback ){
	$.getJSON(url, {"page":page, method:"tar"}, function( result ){
		console.log("Results (tar):", result, page);

		_.each( result.general, function( v ){
			if( v.back2 == "tar"){
				var $v = $('<div class="tar_entry"><a href="'+v.link+'"><img class="article_image" src="'+v.img+'"/>'+v.title+'</a></div>');
				$tar_content.append( $v );
			}
		} );

		if( result.general.length != 0 ){
			$v = $('<div class="more_articles">').text("More...")
			$tar_content.append( $v );
		
			setupClicks( );
			callback && callback( );
			page += 1;
		}
	});
	
}

function setupClicks( ){

	$('.more_articles', $root).click( function( ){
		console.log("Fetching page",page);
		var self = this;

		getGeneral( url, function( ){
			$(self).detach().appendTo($tar_content);
		} );
		
	} );

}

var tar_template = '<div class="tar_entry"> \
<a href="{{ link }}"> <img class="article_image" src="{{ img }}" /> \
{{ title }}</a> \
</div>';

function initTemplates(){
	ich.addTemplate("article_element" , tar_template);

}
}