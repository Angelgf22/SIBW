<?php
    session_start();
	require_once "/usr/local/lib/php/vendor/autoload.php";
	
	$loader = new \Twig\Loader\FilesystemLoader('templates');
	$twig = new \Twig\Environment($loader);

	require_once 'bd.php';

	$variables = [];
	if(isset($_SESSION['nick'])){
	    $variables['user'] = getUser($_SESSION['nick']);
	}
	$variables['eventosLista']= getEventosLista();
	echo $twig->render('portada.html', $variables);
?>
