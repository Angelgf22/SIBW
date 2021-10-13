<?php
    	require_once 'bd.php';
    	session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $res= eliminarCuenta($_SESSION['nick']);

            if($res===1){
                echo'<script type="text/javascript">
                        alert("Error: No se ha podido eliminar la cuenta.");
                        window.location.href="index.php";
                        </script>';
            }else{
                    header("Location: index.php");
            }
        }

        exit;

?>