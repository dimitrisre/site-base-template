<?php
include 'base.php';
include 'models/Base.php';
include 'models/ArticleModel.php';

try{
	$template = $twig->loadTemplate('article.html');

	$articleModel = new ArticleModel();
	
	$article = $articleModel->fetch($articleId); //articleId extracted by the entry point (article.php) from request
	
	echo $template->render(array(
		'article' => $article,
	));
}catch(Exception $e){
	die("Error:". $e->getMessage());
}

?>