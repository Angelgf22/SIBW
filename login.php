<?php
	require_once "/usr/local/lib/php/vendor/autoload.php";

	$loader = new \Twig\Loader\FilesystemLoader('templates');
	$twig = new \Twig\Environment($loader);

	require_once 'bd.php';

	  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nick = $_POST['nick'];
        $pass = $_POST['password'];

        if (checkLogin($nick, $pass)){
          session_start();

          $_SESSION['nick'] = $nick;  // guardo en la sesión el nick del usuario que se ha logueado
        }else{
                    echo'<script type="text/javascript">
                            alert("El usuario o la contraseña introducidos no son correctos.");
                            window.location.href="login.php";
                            </script>';
                   exit;
        }

            header("Location: index.php");
            exit();
      }

	echo $twig->render('login.html', []);
?>
