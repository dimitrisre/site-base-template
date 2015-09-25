<?php 
/*
* Base controller
* contains main configuration for twig templating system
*/
include 'lib/Twig/Autoloader.php';
include 'lib/Twig/Extensions/Autoloader.php';

Twig_Extensions_Autoloader::register();
Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader);

$twig->addExtension(new Twig_Extensions_Extension_Text());

?>