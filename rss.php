<?php
	include "collections/Base.php";
	include "collections/ArticleCollection.php";
	header("Cache-Control: max-age=600");
	header("Content-Type: application/rss+xml; charset=utf-8");

	$actArticlesCollection = new ArticleCollection("act");

	$rss_data = $actArticlesCollection->fetchAll();

	$domtree = new DOMDocument('1.0', 'UTF-8');

	//$xmlRoot = $domtree->createElement("xml");
	//$domtree->appendChild( $xmlRoot );

	$rss_elem = $domtree->createElement("rss");
	//$xmlRoot->appendChild( $rss_elem );
	$domtree->appendChild( $rss_elem );
	$rss_elem->setAttribute("version", "2.0");

	$channel = $domtree->createElement("channel");
	$rss_elem->appendChild( $channel );

	$rss_title = $domtree->createElement("title");
	$rss_title->appendChild( new DOMText("SEK") );

	$rss_link = $domtree->createElement("link");
	$rss_link->appendChild( new DOMText("http://sekonline.gr") );

	$rss_description = $domtree->createElement("description");
	$rss_description->appendChild( new DOMText("News from sek") );

	$channel->appendChild( $rss_title );
	$channel->appendChild( $rss_link );
	$channel->appendChild( $rss_description );

	foreach ( $rss_data["articles"] as $a) {
		$rss_item = $domtree->createElement("item");

		$rss_item_title = $domtree->createElement("title");
		$rss_item_title->appendChild( new DOMText( strip_tags($a["title"]) ) );

		$rss_item_link = $domtree->createElement("link");
		$rss_item_link->appendChild( new DOMText("http://sekonline.gr/article.php?id=".$a["id"]) );

		//get the first sentece of the text
		$description = explode('.', $a["body"]);
		$my_desc = $description[0]; //strip it from any tags

		$rss_item_description = $domtree->createElement("description");
		$rss_item_description->appendChild( new DOMText( $a["body"] ) );

		$rss_item->appendChild( $rss_item_title );
		$rss_item->appendChild( $rss_item_link );
		$rss_item->appendChild( $rss_item_description );
		$channel->appendChild( $rss_item );

	}

	echo $domtree->saveXML( );
?>