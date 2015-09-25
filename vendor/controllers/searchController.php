<?php
include 'base.php';
include 'collections/Base.php';
include 'collections/ArticleCollection.php';

try{
	$template = $twig->loadTemplate('search.html');

	$articlesCollection = new ArticleCollection("");
	
	$articles = $articlesCollection->search($query); //articleId extracted by the entry point (article.php) from request
	
	echo $template->render(array(
		'articles' => $articles["articles"],
		'keywords'  => $query
	));
}catch(Exception $e){
	die("Error:". $e->getMessage());
}

?>