<?php
    	require_once 'bd.php';


    	session_start();


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors= array();
            $titulo = $_POST['titulo'];
            $episodios = $_POST['episodios'];
            $temporadas = $_POST['temporadas'];
            $fecha = $_POST['fecha'];
            $contenido = $_POST['contenido'];
            $generos = $_POST['generos'];
            $link = $_POST['link'];

            if(isset($_FILES['portada'])){
                $errors= array();
                $file_name = $_FILES['portada']['name'];
                $file_size = $_FILES['portada']['size'];
                $file_tmp = $_FILES['portada']['tmp_name'];
                $file_type = $_FILES['portada']['type'];
                $file_ext = strtolower(end(explode('.',$_FILES['portada']['name'])));

                $extensions= array("jpeg","jpg","png");

                if (in_array($file_ext,$extensions) === false){
                  $errors[] = "Extensión no permitida, elige una imagen JPEG o PNG.";
                }

                if ($file_size > 2097152){
                  $errors[] = 'Tamaño del fichero demasiado grande';
                }

                if (empty($errors)==true) {
                  move_uploaded_file($file_tmp, "imagenesSubidas/" . $file_name);

                  $portada = "imagenesSubidas/" . $file_name;
                }

                if (sizeof($errors) > 0) {
                  $variables['errores'] = $errors;
                }

                if(sizeof($errors) === 0)
                    $res = editarEvento($titulo, $episodios, $temporadas, $fecha, $contenido, $generos, $link, $portada, $_SESSION['idEv']);

            }

            if($_FILES['portada']['name'] === '')
                $res= editarEventoSinPortada($titulo, $episodios, $temporadas, $fecha, $contenido, $generos, $link, $_SESSION['idEv']);


                        if(isset($_FILES['galeria1'])){
                            $errors= array();
                            $file_name = $_FILES['galeria1']['name'];
                            $file_size = $_FILES['galeria1']['size'];
                            $file_tmp = $_FILES['galeria1']['tmp_name'];
                            $file_type = $_FILES['galeria1']['type'];
                            $file_ext = strtolower(end(explode('.',$_FILES['galeria1']['name'])));

                            $extensions= array("jpeg","jpg","png");

                            if (in_array($file_ext,$extensions) === false){
                              $errors[] = "Extensión no permitida, elige una imagen JPEG o PNG.";
                            }

                            if ($file_size > 2097152){
                              $errors[] = 'Tamaño del fichero demasiado grande';

                            }

                            if (empty($errors)==true) {

                              move_uploaded_file($file_tmp, "imagenesSubidas/" . $file_name);

                              $galeria1 = "imagenesSubidas/" . $file_name;

                            }

                            if (sizeof($errors) > 0) {
                              $variables['errores'] = $errors;
                            }
                            if(sizeof($errors) === 0)
                               actualizarImagen($galeria1, $_SESSION['idEv'], 0);


                        }




                        if(isset($_FILES['galeria2'])){
                            $errors= array();
                            $file_name = $_FILES['galeria2']['name'];
                            $file_size = $_FILES['galeria2']['size'];
                            $file_tmp = $_FILES['galeria2']['tmp_name'];
                            $file_type = $_FILES['galeria2']['type'];
                            $file_ext = strtolower(end(explode('.',$_FILES['galeria2']['name'])));

                            $extensions= array("jpeg","jpg","png");

                            if (in_array($file_ext,$extensions) === false){
                              $errors[] = "Extensión no permitida, elige una imagen JPEG o PNG.";
                            }

                            if ($file_size > 2097152){
                              $errors[] = 'Tamaño del fichero demasiado grande';

                            }

                            if (empty($errors)==true) {

                              move_uploaded_file($file_tmp, "imagenesSubidas/" . $file_name);

                              $galeria2 = "imagenesSubidas/" . $file_name;

                            }
                            //console_log($errors);
                            if (sizeof($errors) > 0) {
                              $variables['errores'] = $errors;
                            }

                            if(sizeof($errors) === 0)
                                actualizarImagen($galeria2, $_SESSION['idEv'], 1);
                        }


                        if(isset($_FILES['galeria3'])){
                            $errors= array();
                            $file_name = $_FILES['galeria3']['name'];
                            $file_size = $_FILES['galeria3']['size'];
                            $file_tmp = $_FILES['galeria3']['tmp_name'];
                            $file_type = $_FILES['galeria3']['type'];
                            $file_ext = strtolower(end(explode('.',$_FILES['galeria3']['name'])));

                            $extensions= array("jpeg","jpg","png");

                            if (in_array($file_ext,$extensions) === false){
                              $errors[] = "Extensión no permitida, elige una imagen JPEG o PNG.";
                            }

                            if ($file_size > 2097152){
                              $errors[] = 'Tamaño del fichero demasiado grande';

                            }

                            if (empty($errors)==true) {

                              move_uploaded_file($file_tmp, "imagenesSubidas/" . $file_name);

                              $galeria3 = "imagenesSubidas/" . $file_name;

                            }
                            if (sizeof($errors) > 0) {
                              $variables['errores'] = $errors;
                            }
                             if(sizeof($errors) === 0)
                                 actualizarImagen($galeria3, $_SESSION['idEv'], 2);
                        }


                        if(isset($_POST['etiqueta1'])){
                                 $etiqueta1 = $_POST['etiqueta1'];
                                 actualizarEtiqueta($etiqueta1, $_SESSION['idEv'], 0);
                        }
                        if(isset($_POST['etiqueta2'])){
                                 $etiqueta1 = $_POST['etiqueta2'];
                                 actualizarEtiqueta($etiqueta1, $_SESSION['idEv'], 1);
                        }
                        if(isset($_POST['etiqueta3'])){
                                 $etiqueta1 = $_POST['etiqueta3'];
                                 actualizarEtiqueta($etiqueta1, $_SESSION['idEv'], 2);
                        }
        }


        if( $res === 1){
            echo'<script type="text/javascript">
                    alert("No se ha podido completar ");
                    window.location.href="gestion.php";
                    </script>';
        }else{
                   header("Location: evento.php?ev=" . $_SESSION['idEv']);
                   exit();
        }

?>