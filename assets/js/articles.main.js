function articles( ){
	var $root = null;
	var $articles_list = null; 
	var $root2 = $()
	var self = this;
	var url = "";
	var page = 1;
	var type = "politics";
	

this.init = function( data ){
	url = data.url;
	type = data.type;
	$root = data.root;
	$articles_list = $('.articles_list', $root);

	setupClicks( );
	// popcorn = Popcorn.youtube( $player[0],
	// 	"https://www.youtube.com/watch?v=O83bZYTz8K0&controls=2"  );
}

this.fetch = function( id , url2){
	initTemplates();
	$.getJSON(url2, {"id":id}, function( result ){
		// console.log("Article" , result);
		// var article_v = ich.article_element( result );
		// $('.article_body',$(article_v)).html(v.body);

		var article_v = $('<div class="article"> \
		<img class="article_image" src="'+result.img+'" /> \
		<div class="article_title">'+result.title+'</div> \
		<div class="article_body">'+result.body+'</div> \
		</div>');
		$('#main').append( article_v );
	});
}

this.prefetch = function( data ){
	initTemplates();
	//$.getJSON(url2, {"id":id}, function( result ){
		// console.log("Article" , result);
		// var article_v = ich.article_element( result );
		// $('.article_body',$(article_v)).html(v.body);

		var article_v = $('<div class="article"> \
		<img class="article_image" src="'+data.img+'" /> \
		<div class="article_title">'+data.title+'</div> \
		<div class="article_body">'+data.body+'</div> \
		</div>');
		$('#main').append( article_v );
	//});
}

function setupClicks( ){

	$('.more_articles', $root).click( function( ){
		 console.log("Fetching page",page, $root);
		var self = this;

		$.getJSON(url, {"page":page, "method":type}, function( result ){
			console.log("Results (articles):",type, result);

			_.each( result.articles, function( v ){
				if( v.type == type){
					var $article_v = $('<a href="article.php?id='+v.id+'" class="article" data-id="'+v.id+'" data-link="'+v.src+'"><img class="article_image" src="'+v.img+'" /><div class="article_title">'+v.title+'</div><div class="article_abstract">'+v.body+'</div><div class="article_date">'+v.date+'</div></a>');
					$articles_list.append( $article_v );
				}
			} );
			
			$(self).detach().appendTo($articles_list);
			page += 1;

		} );
	});

	$('.article', $root).click( function( ){
		// console.log("Clicking an article", $(this).data("id"));
		//var loc = window.location.href.replace("#","");
		// var loc="";
		// if( !window.location.origin ) {
		// 	loc = widnow.location.origin = window.location.protocol+"//"+window.location.host;
		// }
		// window.location.href = loc+"/article.php?id="+$(this).data("id");
	} );
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
