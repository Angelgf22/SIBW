<?php
    	require_once 'bd.php';
    	session_start();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $id_evento = $_POST["delete"];
                $res= borrarEvento($id_evento);

            if($res>=1){
                echo'<script type="text/javascript">
                        alert("Error: No ha podido borrarse el evento");
                        window.location.href="gestion.php";
                        </script>';
            }
        header("Location: gestion.php");
         exit;
        }

?>