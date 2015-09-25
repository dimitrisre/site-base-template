<?php
include '../lib/Twig/Autoloader.php';
include '../lib/Twig/Extensions/Autoloader.php';

include '../collections/Base.php';
include '../collections/ArticleCollection.php';
include '../collections/NewsCollection.php';
include '../collections/VideoCollection.php';
include '../collections/GeneralCollection.php';
include '../collections/ScrollerCollection.php';

try{
	Twig_Extensions_Autoloader::register();
	Twig_Autoloader::register();

	$loader = new Twig_Loader_Filesystem('../templates');
	$twig = new Twig_Environment($loader);
	
	$twig->addExtension(new Twig_Extensions_Extension_Text());

	$template = $twig->loadTemplate('admin.html');

	$actArticlesCollection = new ArticleCollection("act");
	$politicsArticlesCollection = new ArticleCollection("politics");
	$newsCollection = new NewsCollection("../data/slideshow_list.json");
	$videoCollection = new VideoCollection();
	$tarCollection = new GeneralCollection("tar");
	$generalCollection = new GeneralCollection("");
	$scrollerCollection = new ScrollerCollection("../data/scroller_list.json");

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
		'topics' => $scroller["scrolls"]
	));
}catch(Exception $e){
	die("Error:". $e->getMessage());
}

?>