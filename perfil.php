<?php
    session_start();
	require_once "/usr/local/lib/php/vendor/autoload.php";
	include("bd.php");

	$loader = new \Twig\Loader\FilesystemLoader('templates');
	$twig = new \Twig\Environment($loader);

    $variables = [];
    if(isset($_SESSION['nick'])){
       $variables['user'] = getUser($_SESSION['nick']);
    }


	echo $twig->render('perfil.html', $variables);

?>
