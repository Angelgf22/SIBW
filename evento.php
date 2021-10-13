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

      if (isset($_GET['ev'])) {
        $idEv = $_GET['ev'];
        $_SESSION['idEv']= $idEv;
        $variables['id']= $idEv;
      } else {
        $idEv = -1;
      }

      $variables['evento']= getEvento($idEv);
      $variables['imagenes']= getImagenes($idEv);
      $variables['comentarios']= getComentarios($idEv);


	echo $twig->render('evento.html', $variables);
?>
