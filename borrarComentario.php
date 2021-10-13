<?php
    	require_once 'bd.php';
    	session_start();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $id_comentario = $_POST["delete"];
                $res= borrarComentario($id_comentario);

            if($res===1){
                echo'<script type="text/javascript">
                        alert("Error: No ha podido borrarse el comentario.");
                        window.location.href="evento.php";
                        </script>';
            }
        header("Location: evento.php?ev=" . $_SESSION['idEv']);
         exit;
        }

?>