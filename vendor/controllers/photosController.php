<?php
include 'base.php';
include 'models/Base.php';
include 'models/AlbumModel.php';

try{
	$template = $twig->loadTemplate('photos.html');

	$albumModel = new AlbumModel();
	
	$album = $albumModel->fetch($albumId); //articleId extracted by the entry point (article.php) from request
	
	echo $template->render(array(
		'album' => $album,
	));
}catch(Exception $e){
	die("Error:". $e->getMessage());
}

?>