<?php
include 'base.php';
include 'collections/Base.php';
include 'collections/ArticleCollection.php';
include 'collections/NewsCollection.php';
include 'collections/VideoCollection.php';
include 'collections/GeneralCollection.php';
include 'collections/ScrollerCollection.php';

try{
	$template = $twig->loadTemplate('index.html');

	$actArticlesCollection = new ArticleCollection("act");
	$politicsArticlesCollection = new ArticleCollection("politics");
	$newsCollection = new NewsCollection();
	$videoCollection = new VideoCollection();
	$tarCollection = new GeneralCollection("tar");
	$generalCollection = new GeneralCollection("general");
	$scrollerCollection = new ScrollerCollection();

	$actArticles = $actArticlesCollection->fetch(0);
	$politicsArticles = $politicsArticlesCollection->fetch(0);
	$news = $newsCollection->fetch();
	$videos = $videoCollection->fetch(0);
	$tars = $tarCollection->fetch(0);
	$general = $generalCollection->fetch(0);
	$scroller = $scrollerCollection->fetch();
	// print_r($tars);

	echo $template->render(array(
		'actArticles' => $actArticles["articles"],
		'politicsArticles' => $politicsArticles["articles"],
		'news' => $news["articles"],
		'videos' => $videos["videos"],
		'tars'	=> $tars["general"],
		'generals' => $general["general"],
		'scrolls' => $scroller["scrolls"]
	));
}catch(Exception $e){
	die("Error:". $e->getMessage());
}

?>