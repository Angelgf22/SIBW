<?php
    	require_once 'bd.php';
    	session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $id_comentario = $_POST["id_edit"];
                $nuevo_texto = $_POST["editComentario"];
                $editado= "  Editado por " . $_SESSION['nick'] . "  (". $_SESSION['tipo'] . ")";
                $res= editarComentario($id_comentario, $nuevo_texto, $editado);//TO DO

            if($res===1){
                echo'<script type="text/javascript">
                        alert("Error: No se ha podido editar el comentario.");
                        window.location.href="evento.php";
                        </script>';
            }
        }
        header("Location: evento.php?ev=" . $_SESSION['idEv']);
        exit;

?>