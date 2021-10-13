<?php
    	require_once 'bd.php';
    	session_start();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $id_evento= $_POST["id_visibilidad"];
                $publicado= $_POST["publicado_visibilidad"];
                $res=-1;
                if($publicado == 0){
                    $res= publicar_evento($id_evento);
                }else{
                    $res= ocultar_evento($id_evento);
                }

            if($res>=1){
                echo'<script type="text/javascript">
                        alert("Error: No ha podido cambiarse el estado del evento");
                        window.location.href="gestion.php";
                        </script>';
            }
        header("Location: gestion.php");
         exit;
        }

?>