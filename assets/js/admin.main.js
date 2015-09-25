function admin( ){
	var self = this;
	var $root = $('#main');
	var video_i = 1;


	this.init = function( ){

		$('#tabs').tabs( { activate: function( events, ui ){
			
			if( ui.oldTab ){
				ui.oldTab.removeClass('li_active');
			}
			if( ui.newTab ){
				ui.newTab.addClass('li_active');
			}

		}});

		ich.addTemplate("video_element" , video_template);
		setupClicks( );
		
	}

	function setupClicks( ){
		$('#general1, #art_image, #photo1, #photo2, #photo3, #photo4, #photo5').on('change', function(){
			console.log("changed");
			readURL( this );
		});

		$('.add_video' ,$root).click(function( ){
			var $el = ich.video_element({ i: video_i });

			$('#video_form').prepend( $el );
			video_i += 1;

			$el.find('.remove_video').click(function( ){
				$(this).closest('.video_div').remove( );
			});
		});

		$('.getArticle').click(function(){
			var id = $('#article_id').val();
			console.log("Article id",id);

			$.getJSON( '../private/load.php?method=article&id='+id, function( results ){
				if( results.id == null ){
					var id = $('#article_id').val("");
					alert("Article does not exist");
					return false;
				}
				console.log("Article admin loaded: ",results);
				$('#article_image').attr("src",results.img);
				$('#article_title').val(results.title);
				$('#article_link').val(results.src);
				$('#article_type [value='+results.type+']').prop('selected', true); 
				tinyMCE.get('article_body').setContent(results.body);

			} );
		});

	}

	function readURL( input ) {
		$img = $(input).parent().find('img');

		if (input.files && input.files[0]) {
			var reader = new FileReader();

			reader.onload = function (e) {
				$img.attr('src', e.target.result);
			}
			reader.readAsDataURL(input.files[0]);
		}else{
			$img.attr('src', 'images/slideshow/no_image.png');
		}
	}



	var video_template = "<div class=\"video_div\"> <fieldset> \
	<legend>Video</legend> \
	<div class=\"remove_video\">x</div>\
	<div class=\"row\"> \
	<label for=\"video_link{{ i }}\">Link</label><input type=\"textarea\" id=\"video_link{{ i }}\"  name=\"video_link{{ i }}\" /> \
	</div>\
	<div class=\"row\"> \
	<label for=\"video_title{{ i }}\">Τίτλος</label><input type=\"textarea\" id=\"video_title{{ i }}\"  name=\"video_title{{ i }}\"/> \
	</div> \
	<div class=\"row\"> \
	<label for=\"video_type{{ i }}\">Τύπος</label> \
	<select id=\"video_type{{ i }}\" class=\"video_type\" name=\"video_type{{ i }}\"> \
	<option value=\"youtube\">youtube</option> \
	<option value=\"vimeo\">Vimeo</option> \
	</select> \
	</div> \
	</fieldset></div>";



}