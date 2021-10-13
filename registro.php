<?php
    	require_once 'bd.php';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nick = $_POST['nick_registro'];
            $pass = password_hash($_POST['password_registro'],PASSWORD_DEFAULT);
            $email = $_POST['email'];
            $res = crearUsuario($nick, $pass, $email);
        }

        if( $res === 1){
            echo'<script type="text/javascript">
                    alert("Este nick de usuario ya está escogido o algún campo no ha sido rellenado.");
                    window.location.href="login.php";
                    </script>';
        }else{//E inicia sesion tras el registro.
                  session_start();
                  $_SESSION['nick'] = $nick;  // guardo en la sesión el nick del usuario que se ha logueado
                   header("Location: index.php");
                   exit();
        }

?>