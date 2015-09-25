<?php
include '../collections/Base.php';
include '../models/Base.php';

include '../collections/ArticleCollection.php';
include '../collections/NewsCollection.php';
include '../collections/VideoCollection.php';
include '../collections/GeneralCollection.php';
include '../collections/ScrollerCollection.php';
include '../models/ArticleModel.php';

$method = $_GET["method"];
$page = isset($_GET["page"])?$_GET["page"]:-1;

	
	$generalCollection = new GeneralCollection("");
	

		if($method=='act'){
			$actArticlesCollection = new ArticleCollection("act");
			$ret = $actArticlesCollection->fetch($page);
		}
		elseif($method=='politics'){
			$politicsArticlesCollection = new ArticleCollection("politics");
			$ret = $politicsArticlesCollection->fetch($page);
		}
		elseif($method=='videos'){
			$videoCollection = new VideoCollection();
			$ret = $videoCollection->fetch($page);
		}
		elseif($method=='tar'){
			$tarCollection = new GeneralCollection("tar");
			$ret = $tarCollection->fetch($page);
		}elseif($method=='article'){
			$id = $_GET["id"];

			$articleModel = new ArticleModel();
			$ret = $articleModel->fetch($id);
		}
		else{
			echo "No such method";
		}

		echo json_encode($ret);
	
?>