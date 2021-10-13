<?php
    	require_once 'bd.php';
    	session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $tipo = $_POST['tipo'];

                $res= cambiarRol($_SESSION['seleccionado'], $tipo);


            if($res===1){
                echo'<script type="text/javascript">
                        alert("Error: No se ha podido realizar la operacion (Debe haber almenos un superusuario en el sistema).");
                        window.location.href="roles.php";
                        </script>';
            }else{
                    header("Location: roles.php");
            }
        }

        exit;

?>