<?php
include 'base.php';

try{
	$template = $twig->loadTemplate('member.html');
	echo $template->render(array());
}catch(Exception $e){
	die("Error:". $e->getMessage());
}

?>