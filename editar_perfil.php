<?php
    	require_once 'bd.php';
    	session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $nick_nuevo = $_POST["nick_edit"];
                $email_nuevo = $_POST["email_edit"];
                if(!empty($_POST["password_edit"])){
                    $password_nuevo= password_hash($_POST['password_edit'],PASSWORD_DEFAULT);
                    $res= editarPerfilPassword($nick_nuevo, $email_nuevo, $password_nuevo, $_SESSION['nick']);
                    if($res===0)
                        $_SESSION['nick'] = $nick_nuevo;
                }else{
                    $res= editarPerfil($nick_nuevo, $email_nuevo, $_SESSION['nick']);
                    if($res===0)
                        $_SESSION['nick'] = $nick_nuevo;
                }

            if($res===1){
                echo'<script type="text/javascript">
                        alert("Error: No se ha podido editar los datos del perfil.");
                        window.location.href="perfil.php";
                        </script>';
            }else{
                    header("Location: perfil.php");
            }
        }

        exit;

?>