<?php
	/*
	* Functions to save in the databse from admin panel.
	*/
include '../../collections/Base.php';
include '../../models/Base.php';

include '../../collections/ArticleCollection.php';
include '../../collections/NewsCollection.php';
include '../../collections/VideoCollection.php';
include '../../collections/GeneralCollection.php';
include '../../collections/ScrollerCollection.php';
include '../../models/ArticleModel.php';
include '../../models/AlbumModel.php';

$method = $_POST["method"];
// $page = isset($_POST["page"])?$_POST["page"]:-1;

	
	$generalCollection = new GeneralCollection("");
	

	if($method=='scroller'){
		
		$link0 = $_POST["topic_link0"];
		$link1 = $_POST["topic_link1"];
		$link2 = $_POST["topic_link2"];
		$link3 = $_POST["topic_link3"];
		$link4 = $_POST["topic_link4"];
		$link5 = $_POST["topic_link5"];
		$link6 = $_POST["topic_link6"];
		$link7 = $_POST["topic_link7"];

		$title0 = /*(*/ $_POST["topic_text0"]/* )*/;
		$title1 = /*(*/ $_POST["topic_text1"]/* )*/;
		$title2 = /*(*/ $_POST["topic_text2"]/* )*/;
		$title3 = /*(*/ $_POST["topic_text3"]/* )*/;
		$title4 = /*(*/ $_POST["topic_text4"]/* )*/;
		$title5 = /*(*/ $_POST["topic_text5"]/* )*/;
		$title6 = /*(*/ $_POST["topic_text6"]/* )*/;
		$title7 = /*(*/ $_POST["topic_text7"]/* )*/;

		$scrollSpecs = array(
			"scrolls" => array(
				array("src" => $link0 , "title" => $title0), 
				array("src" => $link1 , "title" => $title1),
				array("src" => $link2 , "title" => $title2),
				array("src" => $link3 , "title" => $title3),
				array("src" => $link4 , "title" => $title4),
				array("src" => $link5 , "title" => $title5),
				array("src" => $link6 , "title" => $title6),
				array("src" => $link7 , "title" => $title7)
			)
		);
		// echo getcwd();
		$scrollerCollection = new ScrollerCollection("../../data/scroller_list.json");

		if( !$scrollerCollection->save(json_encode($scrollSpecs)) ){
			die("Cannot open file to save scroll content.");
		}

		echo "<h1>Scroller successfully saved or updated</h1><br>";
		echo "<button onclick=\"window.history.back()\">Previous page</button>";
		echo "<button onclick=\"window.history.go(-2)\">Initial</button>";

	}elseif($method=='slideshow'){
		$fnames = array(0=>"s1.jpg",1=>"s2.jpg",2=>"s3.jpg",3=>"s4.jpg",4=>"s5.jpg");
		$i = 0;
		try {
		    
		    // Undefined | Multiple Files | $_FILES Corruption Attack
		    // If this request falls under any of them, treat it invalid.
		    foreach ($_FILES as $key => $value) {
			    
			    
			    if (
			        !isset($_FILES[$key]['error'][0]) /*||
			        is_array($_FILES[$key]['error'])*/
			    ) {
			    	echo "Return Code: " . $_FILES["$key"]["error"][0] . "<br>";
			        throw new RuntimeException('Invalid parameters.');
			    }

			    // Check $_FILES[$key]['error'] value.
			    switch ($_FILES[$key]['error'][0]) {
			        case UPLOAD_ERR_OK:
			            break;
			        case UPLOAD_ERR_NO_FILE:
			            throw new RuntimeException('No file sent.');
			        case UPLOAD_ERR_INI_SIZE:
			        case UPLOAD_ERR_FORM_SIZE:
			            throw new RuntimeException('Exceeded filesize limit.');
			        default:
			            throw new RuntimeException('Unknown errors.');
			    }

			    // You should also check filesize here. 
			    if ($_FILES[$key]['size'][0] > 10000000) {
			        throw new RuntimeException('Exceeded filesize limit.');
			    }

			    // DO NOT TRUST $_FILES[$key]['mime'] VALUE !!
			    // Check MIME Type by yourself.
			    $finfo = new finfo(FILEINFO_MIME_TYPE);
			    if (false === $ext = array_search(
			        $finfo->file($_FILES[$key]['tmp_name'][0]),
			        array(
			            'jpg' => 'image/jpeg',
			            'png' => 'image/png',
			            'gif' => 'image/gif',
			        ),
			        true
			    )) {
			        throw new RuntimeException('Invalid file format.');
			    }

			    // You should name it uniquely.
			    // DO NOT USE $_FILES[$key]['name'] WITHOUT ANY VALIDATION !!
			    // On this example, obtain safe unique name from its binary data.
			    if (!move_uploaded_file(
			        $_FILES[$key]['tmp_name'][0],
			        realpath('../../images/slideshow/')."/".$fnames[$i])	        
			    ) {
			        throw new RuntimeException('Failed to move uploaded file.');
			    }
			    $i++;

			}
		} catch (RuntimeException $e) {

			    echo $e->getMessage();

		}

		$link1 = $_POST["link1"];
		$link2 = $_POST["link2"];
		$link3 = $_POST["link3"];
		$link4 = $_POST["link4"];
		$link5 = $_POST["link5"];

		$title1 = $_POST["title1"];
		$title2 = $_POST["title2"];
		$title3 = $_POST["title3"];
		$title4 = $_POST["title4"];
		$title5 = $_POST["title5"];

		$time = $_POST["time"];
		$articleSpecs = array(
			"articles" => array( 
				array("src" => $link1 , "desc" => $title1),
				array("src" => $link2 , "desc" => $title2),
				array("src" => $link3 , "desc" => $title3),
				array("src" => $link4 , "desc" => $title4),
				array("src" => $link5 , "desc" => $title5),
				array("time" => intval( $time )*1000)
			)
		);

		$newsCollection = new NewsCollection("../../data/slideshow_list.json");

		if( !$newsCollection->save(json_encode($articleSpecs)) ){
			die("Cannot open file to save slideshow content.");
		}

		echo "<h1>Slideshow successfully saved</h1><br>";
		echo "<button onclick=\"window.history.back()\">Back</button>";
		echo "<button onclick=\"window.history.go(-2)\">Home</button>";

	}elseif($method=='videos') {
		$videosSpecs = array( "videos"=>array() );//json_decode( $jsonString , true);

		$count = 1;
		foreach ($_POST as $key => $value) {
			if($key == "method"){
				continue;
			}
			if( $count == 3 ){

				$type = $value;
				$t = array( "type" => $type, "src" => $src, "title" => $title );
				array_push( $videosSpecs["videos"], $t);
				$count = 0;

			}elseif ( $count == 1) {

				$src = $value;

			}elseif ( $count == 2) {

				$title = $value;

			}
			$count +=1;
		}

		$videosCollection = new VideoCollection();
		$res = $videosCollection->save($videosSpecs["videos"]);

		if( !$res ){
			die("Cannot upload the videos");
		}

		echo "<h1>Videos successfully saved</h1><br>";
		echo "<button onclick=\"window.history.back()\">Return</button>";
		echo "<button onclick=\"window.history.go(-2)\">Home</button>";
	
	}elseif($method=='article'){
		$fname = "../../images/articles/".$_FILES["art_image"]['name'];//tempnam("../images/articles", "photo");
		echo "fname==$fname";

		$dtz = new DateTimeZone("Europe/Athens"); //Your timezone
		$now = new DateTime(date("M-d-Y"), $dtz);
		// echo $now->format("M d, Y");

		$article_date = "".$now->format("M d, Y");
		// print_r($_FILES);

		$i = 0;
		try {
			
		    // Undefined | Multiple Files | $_FILES Corruption Attack
		    // If this request falls under any of them, treat it invalid.
			if (
				$_FILES["art_image"]['error'][0] > 0 ||
				is_array($_FILES["art_image"]['error'])
				) {
				echo "Return Code: " . $_FILES["art_image"]["error"] . "<br>";
			throw new RuntimeException('Invalid parameters.');
		}

			    // Check $_FILES[$key]['error'] value.
		switch ($_FILES["art_image"]['error']) {
			case UPLOAD_ERR_OK:
			break;
			case UPLOAD_ERR_NO_FILE:
			throw new RuntimeException('No file sent.');
			case UPLOAD_ERR_INI_SIZE:
			case UPLOAD_ERR_FORM_SIZE:
			throw new RuntimeException('Exceeded filesize limit.');
			default:
			throw new RuntimeException('Unknown errors.');
		}

			    // You should also check filesize here. 
		if ($_FILES["art_image"]['size'] > 10000000) {
			throw new RuntimeException('Exceeded filesize limit.');
		}

			    // DO NOT TRUST $_FILES[$key]['mime'] VALUE !!
			    // Check MIME Type by yourself.
			    // $finfo = new finfo(FILEINFO_MIME_TYPE);
			    // if (false === $ext = array_search(
			    //     $finfo->file($_FILES["art_image"]['name']),
			    //     array(
			    //         'jpg' => 'image/jpeg',
			    //         'png' => 'image/png',
			    //         'gif' => 'image/gif',
			    //     ),
			    //     true
			    // )) {
			    //     throw new RuntimeException('Invalid file format.');
			    // }

			    // You should name it uniquely.
			    // DO NOT USE $_FILES[$key]['name'] WITHOUT ANY VALIDATION !!
			    // On this example, obtain safe unique name from its binary data.
		if (!move_uploaded_file(
			$_FILES["art_image"]['tmp_name'],$fname)	        
			) {
			throw new RuntimeException('Failed to move uploaded file.');
		}
		$i++;


		} catch (RuntimeException $e) {

			echo $e->getMessage();

		}


		$link  = $_POST["article_link"];
		$title = $_POST["article_title"];
		$body  = $_POST["article_body"];
		$type = $_POST["article_type"];
		$article_id = $_POST["article_id"];

		// print_r($_POST);

		$clean_body =  $body ;
		$clean_title =  $title;

		$articleModel = new ArticleModel();

		if( $article_id !="" ){
			echo "Trying to update article".$article_id;
			if( $title!="" && $body!="" ){
				
				$articleParams = array(
					"id"=>$article_id, 
					"type"=>$type, 
					"link"=>$link, 
					"title"=> $clean_title, 
					"body"=>$clean_body, 
					"img"=>"images/articles/".$_FILES["art_image"]["name"]);

				$res = $articleModel->update($articleParams);
			}
		}else{
			$articleParams = array(
					"type"=>$type, 
					"link"=>$link, 
					"title"=> $clean_title, 
					"body"=>$clean_body, 
					"img"=>"images/articles/".$_FILES["art_image"]["name"]);
			$res = $articleModel->save($articleParams);
		}

		if( !$res ){
			die("Could not upload article");
		}

		echo "<h1>Articles and images successfully saved</h1><br>";
		echo "<button onclick=\"window.history.back()\">Back</button>";
		echo "<button onclick=\"window.history.go(-2)\">Home</button>";
	
	}elseif($method=='new_middle'){

		$generalCollection = new GeneralCollection("general");
		$fname = "../../images/general/".$_FILES['general1']['name'];//tempnam("../images/articles", "photo");

		$i = 0;
		try {
		    
		    // Undefined | Multiple Files | $_FILES Corruption Attack
		    // If this request falls under any of them, treat it invalid.
			    if (
			        $_FILES['general1']['error'][0] > 0 ||
			        is_array($_FILES['general1']['error'])
			    ) {
			    	echo "Return Code: " . $_FILES['general1']["error"] . "<br>";
			        throw new RuntimeException('Invalid parameters.');
			    }

			    // Check $_FILES[$key]['error'] value.
			    switch ($_FILES['general1']['error']) {
			        case UPLOAD_ERR_OK:
			            break;
			        case UPLOAD_ERR_NO_FILE:
			            throw new RuntimeException('No file sent.');
			        case UPLOAD_ERR_INI_SIZE:
			        case UPLOAD_ERR_FORM_SIZE:
			            throw new RuntimeException('Exceeded filesize limit.');
			        default:
			            throw new RuntimeException('Unknown errors.');
			    }

			    // You should also check filesize here. 
			    if ($_FILES['general1']['size'] > 10000000) {
			        throw new RuntimeException('Exceeded filesize limit.');
			    }

			    // DO NOT TRUST $_FILES[$key]['mime'] VALUE !!
			    // Check MIME Type by yourself.
			    // $finfo = new finfo(FILEINFO_MIME_TYPE);
			    // if (false === $ext = array_search(
			    //     $finfo->file($_FILES['general1']['name']),
			    //     array(
			    //         'jpg' => 'image/jpeg',
			    //         'png' => 'image/png',
			    //         'gif' => 'image/gif',
			    //     ),
			    //     true
			    // )) {
			    //     throw new RuntimeException('Invalid file format.');
			    // }

			    // You should name it uniquely.
			    // DO NOT USE $_FILES[$key]['name'] WITHOUT ANY VALIDATION !!
			    // On this example, obtain safe unique name from its binary data.
			    if (!move_uploaded_file(
			        $_FILES['general1']['tmp_name'],$fname)	        
			    ) {
			        throw new RuntimeException('Failed to move uploaded file.');
			    }
			    $i++;

			
		} catch (RuntimeException $e) {

			    echo $e->getMessage();

		}


		$link  = $_POST["generalLink1"];
		$title = $_POST["generalTitle1"];
		$type  = $_POST["generalType"];
		// echo "$link --- $title---"."images/general/".$_FILES['general1']["name"];
		$generalParams = array(
					"type"=>$type, 
					"link"=>$link, 
					"title"=> $clean_title,  
					"img"=>"images/articles/".$_FILES["art_image"]["name"]);
		
		$res = $generalCollection->save($generalParams);
		// echo "heere";
		if( !$res ){
			die("Could not upload article");
		}

		echo "<h1>Generals successfully saved</h1><br>";
		echo "<button onclick=\"window.history.back()\">Back</button>";
		echo "<button onclick=\"window.history.go(-2)\">Home</button>";
	
	}elseif($method=='update_middle'){
		$generalCollection = new GeneralCollection("general");
		$i = 0;
		// print_r( $_POST );
		// print_r( $_FILES );
		foreach ($_POST as $key => $value) {

			if( strncmp( $key, "delete" , strlen("delete") ) == 0 ){
				$res = $generalCollection->delete( $value );
			} else if( strncmp( $key, "update" , strlen("update") ) == 0 ){
				////FILE IMAGE///
				// 	$fname = "../images/general/".$_FILES[$value]["name"];
				// 	try {

				//     // Undefined | Multiple Files | $_FILES Corruption Attack
				//     // If this request falls under any of them, treat it invalid.
				// 			if (
				// 				$_FILES[$value]['error'][0] > 0 ||
				// 				is_array($_FILES[$value]['error'])
				// 				) {
				// 				echo "Return Code: " . $_FILES[$value]["error"] . "<br>";
				// 			throw new RuntimeException('Invalid parameters.');
				// 		}

				// 	    // Check $_FILES[$key]['error'] value.
				// 		switch ($_FILES[$value]['error']) {
				// 			case UPLOAD_ERR_OK:
				// 			break;
				// 			case UPLOAD_ERR_NO_FILE:
				// 			throw new RuntimeException('No file sent.');
				// 			case UPLOAD_ERR_INI_SIZE:
				// 			case UPLOAD_ERR_FORM_SIZE:
				// 			throw new RuntimeException('Exceeded filesize limit.');
				// 			default:
				// 			throw new RuntimeException('Unknown errors.');
				// 		}

				// 	    // You should also check filesize here. 
				// 		if ($_FILES[$value]['size'] > 10000000) {
				// 			throw new RuntimeException('Exceeded filesize limit.');
				// 		}

				// 	    // DO NOT TRUST $_FILES[$key]['mime'] VALUE !!
				// 	    // Check MIME Type by yourself.
				// 	    // $finfo = new finfo(FILEINFO_MIME_TYPE);
				// 	    // if (false === $ext = array_search(
				// 	    //     $finfo->file($_FILES[$value]['name']),
				// 	    //     array(
				// 	    //         'jpg' => 'image/jpeg',
				// 	    //         'png' => 'image/png',
				// 	    //         'gif' => 'image/gif',
				// 	    //     ),
				// 	    //     true
				// 	    // )) {
				// 	    //     throw new RuntimeException('Invalid file format.');
				// 	    // }

				// 	    // You should name it uniquely.
				// 	    // DO NOT USE $_FILES[$key]['name'] WITHOUT ANY VALIDATION !!
				// 	    // On this example, obtain safe unique name from its binary data.
				// 		if (!move_uploaded_file(
				// 			$_FILES[$value]['tmp_name'],$fname)	        
				// 			) {
				// 			throw new RuntimeException('Failed to move uploaded file.');
				// 	}
				// 	$i++;

					
				// } catch (RuntimeException $e) {

				// 	echo $e->getMessage();

				// }
				////END OF IMAGE///
				$title = " ";
				if( isset( $_POST["title".$value] ) ){
					$title = $_POST["title".$value];
				}
				$link = $_POST["link".$value];
				
				$back1 = intval( $_POST["priority".$value] );
				$type = $_POST["type".$value];
				$img = " ";//"images/general/".$_FILES[$value]["name"];

				$generalParams = array( 
					"link"=>$link, 
					"title" => $title, 
					"img" => $img, 
					"back1" => $back1, 
					"type" => $type,
					"id" => $value );

				$res = $generalCollection->update($generalParams);
			}
		}


		// $link  = $ $_POST["generalLink1"];
		// $title = $ $_POST["generalTitle1"];
		// // echo "$link --- $title---"."images/general/".$_FILES[$value]["name"];
		// $res = $sekdb->insertGeneral( $link, $title, "images/general/".$_FILES[$value]["name"] );
		// // echo "heere";
		// if( !$res ){
		// 	die("Could not upload article");
		// }
		
		echo "<h1>Generals successfully saved</h1><br>";
		echo "<button onclick=\"window.history.back()\">Back</button>";
		echo "<button onclick=\"window.history.go(-2)\">Home</button>";
	}elseif($method == "general_files"){
		$ypografes_file = "../../images/pdf/ypografes.pdf";//tempnam("../images/articles", "photo");
		$dou_file = "../../images/pdf/doudoukokeimeno.pdf";//tempnam("../images/articles", "photo");
		$ea_file = "../../images/elections/1130.jpg";
		$general_file = "../../images/general/".$_FILES['general_file']['name'];

		// print_r($_FILES);
		// $i = 0;
		try {
		    
		    // Undefined | Multiple Files | $_FILES Corruption Attack
		    // If this request falls under any of them, treat it invalid.
		    if( $_FILES['ypografes_file']['name'] !== "" ){
		    	// echo "Here ypografes file";
			    if (
			        $_FILES['ypografes_file']['error'][0] > 0 ||
			        is_array($_FILES['ypografes_file']['error'])
			    ) {
			    	echo "Return Code: " . $_FILES['ypografes_file']["error"] . "<br>";
			        throw new RuntimeException('Invalid parameters.');
			    }

			    // Check $_FILES[$key]['error'] value.
			    switch ($_FILES['ypografes_file']['error']) {
			        case UPLOAD_ERR_OK:
			            break;
			        case UPLOAD_ERR_NO_FILE:
			            throw new RuntimeException('No file sent.');
			        case UPLOAD_ERR_INI_SIZE:
			        case UPLOAD_ERR_FORM_SIZE:
			            throw new RuntimeException('Exceeded filesize limit.');
			        default:
			            throw new RuntimeException('Unknown errors.');
			    }

			    // You should also check filesize here. 
			    if ($_FILES['ypografes_file']['size'] > 10000000) {
			        throw new RuntimeException('Exceeded filesize limit.');
			    }

			    // DO NOT TRUST $_FILES[$key]['mime'] VALUE !!
			    // Check MIME Type by yourself.
			    // $finfo = new finfo(FILEINFO_MIME_TYPE);
			    // if (false === $ext = array_search(
			    //     $finfo->file($_FILES['general1']['name']),
			    //     array(
			    //         'jpg' => 'image/jpeg',
			    //         'png' => 'image/png',
			    //         'gif' => 'image/gif',
			    //     ),
			    //     true
			    // )) {
			    //     throw new RuntimeException('Invalid file format.');
			    // }

			    // You should name it uniquely.
			    // DO NOT USE $_FILES[$key]['name'] WITHOUT ANY VALIDATION !!
			    // On this example, obtain safe unique name from its binary data.
			    if (!move_uploaded_file(
			        $_FILES['ypografes_file']['tmp_name'],$ypografes_file)	        
			    ) {
			        throw new RuntimeException('Failed to move uploaded file.');
			    }
			}

			if( $_FILES['ntou_file']['name'] !== "" ){
				// echo "Here ntou file";
			    if (
			        $_FILES['ntou_file']['error'][0] > 0 ||
			        is_array($_FILES['ntou_file']['error'])
			    ) {
			    	echo "Return Code: " . $_FILES['ntou_file']["error"] . "<br>";
			        throw new RuntimeException('Invalid parameters.');
			    }

			    // Check $_FILES[$key]['error'] value.
			    switch ($_FILES['ntou_file']['error']) {
			        case UPLOAD_ERR_OK:
			            break;
			        case UPLOAD_ERR_NO_FILE:
			            throw new RuntimeException('No file sent.');
			        case UPLOAD_ERR_INI_SIZE:
			        case UPLOAD_ERR_FORM_SIZE:
			            throw new RuntimeException('Exceeded filesize limit.');
			        default:
			            throw new RuntimeException('Unknown errors.');
			    }

			    // You should also check filesize here. 
			    if ($_FILES['ntou_file']['size'] > 10000000) {
			        throw new RuntimeException('Exceeded filesize limit.');
			    }

			    // DO NOT TRUST $_FILES[$key]['mime'] VALUE !!
			    // Check MIME Type by yourself.
			    // $finfo = new finfo(FILEINFO_MIME_TYPE);
			    // if (false === $ext = array_search(
			    //     $finfo->file($_FILES['general1']['name']),
			    //     array(
			    //         'jpg' => 'image/jpeg',
			    //         'png' => 'image/png',
			    //         'gif' => 'image/gif',
			    //     ),
			    //     true
			    // )) {
			    //     throw new RuntimeException('Invalid file format.');
			    // }

			    // You should name it uniquely.
			    // DO NOT USE $_FILES[$key]['name'] WITHOUT ANY VALIDATION !!
			    // On this example, obtain safe unique name from its binary data.
			    if (!move_uploaded_file(
			        $_FILES['ntou_file']['tmp_name'],$dou_file)	        
			    ) {
			        throw new RuntimeException('Failed to move uploaded file.');
			    }
			}

			if( $_FILES['ea_file']['name'] !== "" ){
				// echo "Here ea file";
			    if (
			        $_FILES['ea_file']['error'][0] > 0 ||
			        is_array($_FILES['ea_file']['error'])
			    ) {
			    	echo "Return Code: " . $_FILES['ea_file']["error"] . "<br>";
			        throw new RuntimeException('Invalid parameters.');
			    }

			    // Check $_FILES[$key]['error'] value.
			    switch ($_FILES['ea_file']['error']) {
			        case UPLOAD_ERR_OK:
			            break;
			        case UPLOAD_ERR_NO_FILE:
			            throw new RuntimeException('No file sent.');
			        case UPLOAD_ERR_INI_SIZE:
			        case UPLOAD_ERR_FORM_SIZE:
			            throw new RuntimeException('Exceeded filesize limit.');
			        default:
			            throw new RuntimeException('Unknown errors.');
			    }

			    // You should also check filesize here. 
			    if ($_FILES['ea_file']['size'] > 10000000) {
			        throw new RuntimeException('Exceeded filesize limit.');
			    }

			    // DO NOT TRUST $_FILES[$key]['mime'] VALUE !!
			    // Check MIME Type by yourself.
			    // $finfo = new finfo(FILEINFO_MIME_TYPE);
			    // if (false === $ext = array_search(
			    //     $finfo->file($_FILES['general1']['name']),
			    //     array(
			    //         'jpg' => 'image/jpeg',
			    //         'png' => 'image/png',
			    //         'gif' => 'image/gif',
			    //     ),
			    //     true
			    // )) {
			    //     throw new RuntimeException('Invalid file format.');
			    // }

			    // You should name it uniquely.
			    // DO NOT USE $_FILES[$key]['name'] WITHOUT ANY VALIDATION !!
			    // On this example, obtain safe unique name from its binary data.
			    if (!move_uploaded_file(
			        $_FILES['ea_file']['tmp_name'],$ea_file)	        
			    ) {
			        throw new RuntimeException('Failed to move uploaded file.');
			    }
			}
			
			if( $_FILES['general_file']['name']!== "" ){
				// echo "Here general file";
			    if (
			        $_FILES['general_file']['error'][0] > 0 ||
			        is_array($_FILES['general_file']['error'])
			    ) {
			    	echo "Return Code: " . $_FILES['general_file']["error"] . "<br>";
			        throw new RuntimeException('Invalid parameters.');
			    }

			    // Check $_FILES[$key]['error'] value.
			    switch ($_FILES['general_file']['error']) {
			        case UPLOAD_ERR_OK:
			            break;
			        case UPLOAD_ERR_NO_FILE:
			            throw new RuntimeException('No file sent.');
			        case UPLOAD_ERR_INI_SIZE:
			        case UPLOAD_ERR_FORM_SIZE:
			            throw new RuntimeException('Exceeded filesize limit.');
			        default:
			            throw new RuntimeException('Unknown errors.');
			    }

			    // You should also check filesize here. 
			    if ($_FILES['general_file']['size'] > 10000000) {
			        throw new RuntimeException('Exceeded filesize limit.');
			    }

			    // DO NOT TRUST $_FILES[$key]['mime'] VALUE !!
			    // Check MIME Type by yourself.
			    // $finfo = new finfo(FILEINFO_MIME_TYPE);
			    // if (false === $ext = array_search(
			    //     $finfo->file($_FILES['general1']['name']),
			    //     array(
			    //         'jpg' => 'image/jpeg',
			    //         'png' => 'image/png',
			    //         'gif' => 'image/gif',
			    //     ),
			    //     true
			    // )) {
			    //     throw new RuntimeException('Invalid file format.');
			    // }

			    // You should name it uniquely.
			    // DO NOT USE $_FILES[$key]['name'] WITHOUT ANY VALIDATION !!
			    // On this example, obtain safe unique name from its binary data.
			    if (!move_uploaded_file(
			        $_FILES['general_file']['tmp_name'],$general_file)	        
			    ) {
			        throw new RuntimeException('Failed to move uploaded file.');
			    }
			}

			
		} catch (RuntimeException $e) {

			    echo $e->getMessage();

		}


		// $link  = $purifier->purify( $_POST["generalLink1"] );
		// $title = $purifier->purify( $_POST["generalTitle1"] );
		// // echo "$link --- $title---"."images/general/".$_FILES['general1']["name"];
		// $res = $sekdb->insertGeneral( $link, $title, "images/general/".$_FILES['general1']["name"] );
		// // echo "heere";
		// if( !$res ){
		// 	die("Could not upload article");
		// }
		// $sekdb->disconnect( );
		echo "--- general file link---"."<a href=\"../../images/general/".$_FILES['general_file']["name"]."\">"."http://sekonline.gr/images/general/".$_FILES['general_file']["name"]."</a>";
		echo "<h1>Files successfully saved</h1><br>";
		echo "<button onclick=\"window.history.back()\">Back</button>";
		echo "<button onclick=\"window.history.go(-2)\">Home</button>";

	}elseif($method == "photos"){
		$basePath = "../../images/albums/";
		$albumModel = new AlbumModel();

		if($_FILES["zip_file"]["name"]) {
			$filename = $_FILES["zip_file"]["name"];
			$source = $_FILES["zip_file"]["tmp_name"];
			$type = $_FILES["zip_file"]["type"];
			
			$name = explode(".", $filename);
			$title = $name[0];

			$accepted_types = array('application/zip', 'application/x-zip-compressed', 'multipart/x-zip', 'application/x-compressed');
			foreach($accepted_types as $mime_type) {
				if($mime_type == $type) {
					$okay = true;
					break;
				} 
			}
			
			$continue = strtolower($name[1]) == 'zip' ? true : false;
			if(!$continue) {
				$message = "The file you are trying to upload is not a .zip file. Please try again.";
			}


			$target_path = $basePath.$filename;  // change this to the correct site path
			if(move_uploaded_file($source, $target_path)) {
				$zip = new ZipArchive();
				$x = $zip->open($target_path);
				if ($x === true) {

					$zip->extractTo($basePath); // change this to the correct site path
					$zip->close();


					unlink($target_path);
				}
				$message = "Your .zip file was uploaded and unpacked.";
				$albumJson = array( 
					"title" => $title,
					"path"	=> $title,
					"comment"=> ""
					);
				$res = $albumModel->put( $albumJson );

				if( !$res ){
					die("Could not insert photo album");
				}
				$albumId = $albumModel->getAlbumId( $title );
				
				$root = $basePath.$title;
				echo "ROOT---->".$root;
				$last_letter  = $root[strlen($root)-1]; 
				$root  = ($last_letter == '\\' || $last_letter == '/') ? $root : $root.DIRECTORY_SEPARATOR; 

				if ($handle = opendir($root)) { 
					while (false !== ($file = readdir($handle))) { 
						if ($file == '.' || $file == '..') { 
							continue; 
						}
						$photoJson = array(	
							"src" => $file,
							"title" => $file,
							"comment" => "",
							"album_id" => $albumId
						);
						$res = $albumModel->putPhoto($photoJson); 	
						if( !$res ){
							die("Could not insert photo in the table");
						}
					}  
					closedir($handle); 
				} 
				echo $message."    album id url: http://sekonline.gr/photos.php?id=".$albumId."    .Copy this link and paste it in your article!";
			} else {	
				$message = "There was a problem with the upload. Please try again.";

			}
			
		}
	}

	// elseif($method=='politics'){
	// 	$politicsArticlesCollection = new ArticleCollection("politics");
	// 	$ret = $politicsArticlesCollection->fetch($page);
	// }
	// elseif($method=='videos'){
	// 	$videoCollection = new VideoCollection();
	// 	$ret = $videoCollection->fetch($page);
	// }
	// elseif($method=='tar'){
	// 	$tarCollection = new GeneralCollection("tar");
	// 	$ret = $tarCollection->fetch($page);
	// }elseif($method=='article'){
	// 	$id = $_GET["id"];

	// 	$articleModel = new ArticleModel();
	// 	$ret = $articleModel->fetch($id);
	// }
	else{
		echo "No such method";
	}

		// echo json_encode($ret);
?>