<?php
require_once 'vendor/autoload.php';
Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem('assets/templates');

$twig = new Twig_Environment($loader, array(
    'cache' => 'cache',
));

if ( isset( $_COOKIE['mockauth'] ) ) {
	echo $twig->render('success.html', array('project_name' => 'Mock Auth', 'username' => $_COOKIE['mockauth']));
} 
else {
	header('HTTP/1.0 403 Forbidden');
	echo $twig->render('403.html', array('project_name' => 'Mock Auth'));
} ?>