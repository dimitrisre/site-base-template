function search( ){
	var $root = null;
	var $articles_list = null; 
	var $root2 = $()
	var self = this;
	var url = "";
	// var page = 0;
	var type = "politics";
	

	this.init = function( data ){
		url = data.url+"?q="+data.query;
		$root = data.root;
		$articles_list = $('.contents', $root);
		$.getJSON(url, {}, function( result ){
			console.log("Results (articles):", result);

			_.each( result.articles, function( v ){
					var abstract = v.body.substr(0,200); //v.body.substr(3,200);
					// console.log("Abstract:",abstract);
					var $v = $('<a href="article.php?id='+v.id+'" class="article" data-id="'+v.id+'" data-link="'+v.src+'"><div class="image_wrapper"><img class="article_image" src="'+v.img+'" /></div><div class="article_title">'+v.title+'</div><div class="article_date">'+v.date+'</div><div class="article_abstract">'+abstract+'</div></a>');
					$articles_list.append( $v );
			} );
			
			// $v = $('<div class="more_articles">').text("More...")
			// $articles_list.append( $v );
			// page += 1;
			// setupClicks( );
			$('#results_sum').text($('.article').length);
			$('#search_keywords').text(decodeURI(data.query));
			$('title').text("Sekonline Search - "+decodeURI(data.query));
		});

		// popcorn = Popcorn.youtube( $player[0],
		// 	"https://www.youtube.com/watch?v=O83bZYTz8K0&controls=2"  );
}


var article_template = '<div class="article"> \
<img class="article_image" src="{{ img }}" /> \
<div class="article_title">{{ title }}</div> \
<div class="article_body"></div> \
</div>';

function initTemplates(){
	ich.addTemplate("article_element" , article_template);

}
}