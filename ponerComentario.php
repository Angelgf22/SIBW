<?php
    	require_once 'bd.php';
    	session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $texto_comentario = $_POST['textocomentario'];
                $fechacomentario= date("d/m/Y") . " at " . date("h:i");

                $res= ponerComentario($_SESSION['nick'], $texto_comentario, $fechacomentario, $_SESSION['idEv']);

            if($res===1){
                echo'<script type="text/javascript">
                        alert("Error: No ha podido insertarse el comentario.");
                        window.location.href="evento.php";
                        </script>';
            }
        }
        header("Location: evento.php?ev=" . $_SESSION['idEv']);
        exit;

?>