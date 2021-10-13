<?php
    session_start();
	require_once "/usr/local/lib/php/vendor/autoload.php";
	include("bd.php");

	$loader = new \Twig\Loader\FilesystemLoader('templates');
	$twig = new \Twig\Environment($loader);

    $variables = [];
    if(isset($_SESSION['nick'])){
       $variables['user'] = getUser($_SESSION['nick']);
       $_SESSION['tipo'] = $variables['user']['tipo'];
    }

	  $variables['palabras']= getProhibidas();
      $variables['comentarios']= getAllComentarios();

	echo $twig->render('lista_comentarios.html', $variables);
?>
