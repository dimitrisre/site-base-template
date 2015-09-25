<?php
	header("Cache-Control: max-age=600");
	header('Content-type: text/xml; charset=utf-8');
	include "collections/Base.php";
	include "collections/ArticleCollection.php";

	$actArticlesCollection = new ArticleCollection("act");
	$sitemap_data = $actArticlesCollection->fetchAll();

	$domtree = new DOMDocument('1.0', 'UTF-8');

	$urlset_elem = $domtree->createElement("urlset");
	
	$domtree->appendChild( $urlset_elem );
	$urlset_elem->setAttribute("xmlns", "http://www.sitemaps.org/schemas/sitemap/0.9");
	$urlset_elem->setAttribute("xmlns:image", "http://www.google.com/schemas/sitemap-image/1.1");

	foreach ( $sitemap_data["articles"] as $a) {
		$sitemap_item_link = $domtree->createElement("url");
		
		$sitemap_item_loc= $domtree->createElement("loc");
		$sitemap_item_loc->appendChild( new DOMText("http://www.sekonline.gr/article.php?id=".$a["id"]) );
		
		$sitemap_item_image = $domtree->createElement("image:image");
		$sitemap_item_image_loc = $domtree->createElement("image:loc");
		$sitemap_item_image_loc->appendChild( new DOMText("http://www.sekonline.gr/".$a["img"]) );
		
		$sitemap_item_image->appendChild($sitemap_item_image_loc);
		$sitemap_item_link->appendChild($sitemap_item_loc);
		$sitemap_item_link->appendChild($sitemap_item_image);
		
		$urlset_elem->appendChild( $sitemap_item_link );

	}

	echo $domtree->saveXML( );
?>
