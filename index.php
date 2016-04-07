<?php
require_once 'vendor/autoload.php';
Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem('assets/templates');

$twig = new Twig_Environment($loader, array(
    'cache' => 'cache',
));

echo $twig->render('index.html', array('project_name' => 'Mock Auth', 'go' => 'here'));

?>