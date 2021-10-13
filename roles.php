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
    $variables['usuarios']= getUsers();


      if (isset($_GET['user'])) {
        $seleccionado = $_GET['user'];
        $_SESSION['seleccionado'] = $seleccionado;
        $variables['seleccionado'] = $seleccionado;
      } else {
        $idEv = -1;
      }



	echo $twig->render('roles.html', $variables);
?>
