function articles( ){
	var $root = null;
	var $articles_list = null; 
	var $root2 = $()
	var self = this;
	var url = "";
	var page = 0;
	var type = "politics";
	

	this.init = function( data ){
		url = data.url;
		type = data.type;
		$root = data.root;
		$articles_list = $('.articles_list', $root);
		$.getJSON(url, {"page":page, "type":type}, function( result ){
			console.log("Results (articles):", result, page);

			_.each( result.articles, function( v ){
				if( v.type == type){
					var abstract = $(v.body).text().substr(0,200); //v.body.substr(3,200);
					// console.log("Abstract:",abstract);
					var $v = $('<a href="article.php?id='+v.id+'" class="article" data-id="'+v.id+'" data-link="'+v.src+'"><img class="article_image" src="'+v.img+'" /><div class="article_title">'+v.title+'</div><div class="article_date">'+v.date+'</div></a>');
					$articles_list.append( $v );
				}
			} );
			
			$v = $('<div class="more_articles">').text("More...")
			$articles_list.append( $v );
			page += 1;
			setupClicks( );
		});

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

function setupClicks( ){

	$('.more_articles', $root).click( function( ){
		 console.log("Fetching page",page, $root);
		var self = this;

		$.getJSON(url, {"page":page, "type":type}, function( result ){
			console.log("Results (articles):",type, result);

			_.each( result.articles, function( v ){
				if( v.type == type){
					var $article_v = $('<a href="article.php?id='+v.id+'" class="article" data-id="'+v.id+'" data-link="'+v.src+'"><img class="article_image" src="'+v.img+'" /><div class="article_title">'+v.title+'</div><div class="article_date">'+v.date+'</div></a>');
					$article_v.click(function( ){
						// console.log("Clicking an article", $(this).data("id"));
						//var loc = window.location.href.replace("#","");
						// var loc="";
						// if( !window.location.origin ) {
						// 	loc = widnow.location.origin = window.location.protocol+"//"+window.location.host;
						// }
						// window.location.href = loc+"/article.php?id="+$(this).data("id");
					});
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





function general( ){
	var self = this;
	var $root = $('#middle');
	var page = 0;
	self.init = function( data ){
		
		url = data.url;
		
		$.getJSON(url ,{page:page , type:"general"}, function( result ){
			console.log("General:", result);

			_.each( result.general, function( a ){
				if( a.back2 != "tar" ){
					var $sc = $("<div class='general_div'>");
					$sc.append("<a href='"+a.link+"'><img src='"+a.img+"'>"+a.title+"</a>");
					$root.append( $sc );
				}

				
			} );
			setupClicks( );

		});

		
	}

	function setupClicks( ){
		
	}
}




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




function news( ){
	var anim_id = -1;
	var curr = 0;
	var elems = new Array();
	var self = this;
	var $root = $('#news');
	var url = "";
	var time = 7;

	self.init = function( data ){
		
		elems[0] = $('.article1', $root);
		elems[1] = $('.article2', $root);
		elems[2] = $('.article3', $root);
		elems[3] = $('.article4', $root);
		elems[4] = $('.article5', $root);
		url = data.url;
		
		$.getJSON(url , function( result ){
			console.log("Results:", result);

			_.each( result.articles, function( a , i){
				if( i > 4){
					if( a.time > 0){
						time = parseInt( a.time );
					}
					return false;
				}
				$(".basic_link" , elems[i]).text( a.desc );	
				$(".basic_link" , elems[i]).attr("href",a.src);
				$(".more_link" , elems[i]).attr("href",a.src);
			} );

			beginAnimation( );
			setupClicks( );
		});

		
	}

	self.load = function( data ){
		$.getJSON( data.url , function( result ){
			console.log("results slideshow admin:",result);
			_.each( result.articles, function( a, i ){
				if( i > 4){
					$('#time').val( a.time/1000 );
					return false;
				}

				$("#title"+(i+1)).val( a.desc );
				$("#link"+(i+1)).val( a.src );
			} );

		} );
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





function photos( ){
	var self = this;
	var $root = $('#photos');
	var path = "images/albums/";
	var albumId = -1;
	var url;
	var n = 0;

	self.init = function( data ){
		url = data.url;
		albumId = data.albumId;

		console.log(data);
		initTemplates( );

		$.ajax({
			dataType: "json",
			url: url,
			data: {id:albumId},
			success: function( result ){
				console.log("Album Results:", result);

				$('.album .title',$root).text(result.title);
				path+=(result.path+"/");
				self.loadPhotos( result.photos );
				setupClicks( );
			}
		});
		// $.getJSON(url , {id:albumId}, function( result ){
			
		// });
	self.loadPhotos = function( photos ){
		_.each( photos, function( p , i){
			n++;
			p.src = path+p.src;
			p.i = i;
			var $el = ich.photo_element( p );
			$('.album .contents').append( $el );
		} ); 
	}
}

function setupClicks(){
	$('.photo_entry', $root).click( function( ){
		
		$('.contents', $root).addClass("contents_maximized").append( ich.info_element() );
		
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
			$('.photo_info', $root).remove( );
			$('.selected').removeClass('selected');
			// setupClicks( );
		}else if( e.keyCode == "39" /*right*/){
			var ni = $('.selected', $root).data("n")
			
			if( ni + 1 < n ){
				ni++;
				$('.selected', $root).removeClass('selected');
				$('.photo_entry_maximized[data-n="'+ni+'"]', $root).addClass('selected');
			}

		}else if( e.keyCode == "37" /*left*/){
			var ni = $('.selected', $root).data("n");
			
			if( ni - 1 >= 0 ){
				ni--;
				$('.selected', $root).removeClass('selected');
				$('.photo_entry_maximized[data-n="'+ni+'"]', $root).addClass('selected');
			}
		}   
	});

}

var photo_template = '<img class="photo_entry" src="{{ src }}" data-n={{ i }} />';
var info_template = '<div class="photo_info">Χρησιμοποιήσε το αριστερά και δεξιά για να περάσεις τις  φωτογραφίες.Πίεσε το Esc για έξοδο απο fullscreen mode.</div>'

function initTemplates(){
	ich.addTemplate("photo_element" , photo_template);
	ich.addTemplate("info_element" , info_template);

}

}



function scroller( ){
	var self = this;
	var $root = $('#scroller');
	var $container =$('.scroller_container', $root);
	var left = 0;

	self.init = function( data ){
		
		url = data.url;
		
		$.getJSON(url , function( result ){
			console.log("Results(sc):", result);

			_.each( result.scrolls, function( a ){

				var $sc = $("<div class='scroll_div'>");
				$sc.append("<a href='"+a.src+"'>"+a.title+"</a>");
				$sc.append("<div class='seperator'>.</div>");
				$container.append( $sc );

				
			} );
			$container.addClass("scroll_animation");
			setupClicks( );

		});

		
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



function tar( ){
	var $root = $('#tar');
	var $tar_content = $('.tar_content', $root);
	var $root2 = $()
	var self = this;
	var url = "";
	var page = 0;
	
	

	this.init = function( data ){
		url = data.url;

		getGeneral( url );

		// popcorn = Popcorn.youtube( $player[0],
		// 	"https://www.youtube.com/watch?v=O83bZYTz8K0&controls=2"  );
}

function getGeneral( url, callback ){
	$.getJSON(url, {"page":page, type:"tar"}, function( result ){
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

		$.getJSON(url, {"page":page}, function( result ){
			console.log("Results (videos):", result);

			_.each( result.videos, function( v ){
				v.src += "&controls=2";
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
			// popcorn = Popcorn.youtube( $player[0], result.videos[0].src );

			$v = $('<div class="more_videos">').text("More...")
			$video_list.append( $v );
			page += 1;
			setupClicks( );
		});

		// popcorn = Popcorn.youtube( $player[0],
		// 	"https://www.youtube.com/watch?v=O83bZYTz8K0&controls=2"  );
}

function setupClicks( ){

	$('.more_videos', $root).click( function( ){
		console.log("Fetching page",page);
		var self = this;

		$.getJSON(url, {"page":page}, function( result ){
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
