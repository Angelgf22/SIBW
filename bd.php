<?php
	$mysqli = new mysqli("mysql", "pagina", "pag", "SIBW");
	if ($mysqli->connect_errno) {
       echo ("Fallo al conectar: " . $mysqli->connect_error);
    }

  function getEvento($idEv) {
	global $mysqli;
	

    $stmt = $mysqli->prepare('SELECT nombre, texto, link, fecha, generos, episodios, temporadas, imprimir_ruta, portada, publicado FROM eventos WHERE id= ?');
    $stmt->bind_param('i', $idEv);
    $stmt->execute();
    $res = $stmt->get_result();
    $stmt->close();

    $evento = array('nombre' => '----', 'texto' => '----', 'link' => 'https://www.netflix.com/es/', 'fecha' => '-', 'generos' => 'N/A', 'episodios' => '0', 'temporadas' => '0', 'imprimir_ruta' => './evento_imprimir.php?ev=-1', 'portada' => 'img/not_found.jpg', 'publicado' => '0');

    if ($res->num_rows > 0) {
      $row = $res->fetch_assoc();

      $evento = array('nombre' => $row['nombre'], 'texto' => $row['texto'], 'link' => $row['link'], 'fecha' => $row['fecha'], 'generos' => $row['generos'], 'generos' => $row['generos'], 'episodios' => $row['episodios'], 'temporadas' => $row['temporadas'], 'imprimir_ruta' => $row['imprimir_ruta'], 'portada' => $row['portada'], 'publicado' => $row['publicado']);
    }

    return $evento;

  }
  
  
   function getProhibidas() {
	global $mysqli;

 	$palabras = array();
    $res = $mysqli->query("SELECT palabra FROM prohibidas");
	
    if ($res->num_rows > 0) {

      while($row= $res->fetch_assoc()){
      	    array_push($palabras, $row['palabra']);
      }
      //echo '<pre>'; print_r($palabras); echo '</pre>';

    }

    return $palabras;
  }

  function getImagenes($idEv) {
	global $mysqli;
    $stmt = $mysqli->prepare("SELECT id, rutaimagen FROM imagenes where id_evento=?");
    $stmt->bind_param('i', $idEv);
    $stmt->execute();


    $res = $stmt->get_result();
    $stmt->close();

    $imagenes = array();
    if ($res->num_rows > 0) {
          while($row= $res->fetch_assoc()){
          	    array_push($imagenes, $row);
          }
          //echo '<pre>'; print_r($imagenes); echo '</pre>';
    }
    return $imagenes;
}



function getComentarios($idEv) {
	global $mysqli;


    $stmt = $mysqli->prepare("SELECT id, contenido, autor, fechacomentario, editado FROM comentarios WHERE id_evento=?");
    $stmt->bind_param('i', $idEv);
    $stmt->execute();
    $res = $stmt->get_result();
    $stmt->close();

    $comentarios = array();
    if ($res->num_rows > 0) {
          while($row= $res->fetch_assoc()){
          	    array_push($comentarios, $row);
          }
    }



    return $comentarios;
  }


function checkLogin($nick, $pass){
   global $mysqli;
        //$res = $mysqli->query("SELECT pass FROM usuarios WHERE nick=" . $nick );

            $stmt = $mysqli->prepare("SELECT pass FROM usuarios WHERE nick=?");
            $stmt->bind_param('s', $nick);
            $stmt->execute();
            $res = $stmt->get_result();
            $stmt->close();

        if ($res->num_rows > 0) {
            $row = $res->fetch_assoc();
            if (password_verify($pass, $row['pass'] )) {
                      return true;
                    }
        }
        return false;
   }



function crearUsuario($nick, $pass, $email){
   global $mysqli;
        //$res = $mysqli->query("SELECT pass FROM usuarios WHERE nick=" . $nick );
            $tipo= 'normal';
            $stmt = $mysqli->prepare("INSERT INTO usuarios (nick, pass, email, tipo) VALUES (?, ?, ?, ?)");
            $stmt->bind_param('ssss', $nick, $pass, $email, $tipo);
            if($stmt->execute()){
                $stmt->close();
                return 0;
            }else{
                return 1; //error jeje
            }
}

function getUser($nick){
            global $mysqli;
            //echo '<pre>'; print_r($nick); echo '</pre>';
            $stmt = $mysqli->prepare("SELECT * FROM usuarios WHERE nick=?");
            $stmt->bind_param('s', $nick);
            $stmt->execute();
            $res = $stmt->get_result();
            $stmt->close();

            if ($res->num_rows > 0) {
                $row = $res->fetch_assoc();
            }
            //echo '<pre>'; print_r($row); echo '</pre>';
            return $row;

}

function ponerComentario($autor_comentario, $texto_comentario, $fecha_comentario, $idEv){
    global $mysqli;
            $stmt = $mysqli->prepare("INSERT INTO comentarios (id_evento, contenido, autor, fechacomentario) VALUES (?, ?, ?, ?)");
            $stmt->bind_param('isss', $idEv, $texto_comentario, $autor_comentario, $fecha_comentario);
            if($stmt->execute()){
                $stmt->close();
                return 0;
            }else{
                $stmt->close();
                return 1;
            }
}


function borrarComentario($id_comentario){

    global $mysqli;
            $stmt = $mysqli->prepare("DELETE FROM comentarios where id=?");
            $stmt->bind_param('i', $id_comentario);
            //console_log( $id_comentario);
            if($stmt->execute()){
                $stmt->close();
                return 0;
            }else{
                $stmt->close();
                return 1;
            }



}

function editarComentario($id_comentario, $nuevo_texto, $editado){

            global $mysqli;
            $stmt = $mysqli->prepare("UPDATE comentarios SET contenido=?, editado=? where id=?");
            $stmt->bind_param('ssi', $nuevo_texto, $editado, $id_comentario);
            //console_log( $id_comentario);
            if($stmt->execute()){
                $stmt->close();
                return 0;
            }else{
                $stmt->close();
                return 1;
            }
}


function getAllComentarios(){
	global $mysqli;


    $stmt = $mysqli->prepare("SELECT id, contenido, autor, fechacomentario, editado FROM comentarios");
    $stmt->execute();
    $res = $stmt->get_result();
    $stmt->close();

    $comentarios = array();
    if ($res->num_rows > 0) {
          while($row= $res->fetch_assoc()){
          	    array_push($comentarios, $row);
          }
    }

    return $comentarios;

}

function getEventosLista(){
	global $mysqli;


    $stmt = $mysqli->prepare("SELECT id, nombre, portada, publicado FROM eventos");
    $stmt->execute();
    $res = $stmt->get_result();
    $stmt->close();

    $eventos = array();
    if ($res->num_rows > 0) {
          while($row= $res->fetch_assoc()){
          	    array_push($eventos, $row);
          }
    }

    return $eventos;

}


 function editarPerfilPassword($nick_nuevo, $email_nuevo, $password_nuevo, $nick_actual){

             global $mysqli;
             $stmt = $mysqli->prepare("UPDATE usuarios SET nick=?, pass=?, email=? where nick=?");
             $stmt->bind_param('ssss', $nick_nuevo, $password_nuevo, $email_nuevo, $nick_actual);
             if($stmt->execute()){
                 $stmt->close();
                 return 0;
             }else{
                 $stmt->close();
                 return 1;
             }
 }


 function editarPerfil($nick_nuevo, $email_nuevo, $nick_actual){

             global $mysqli;
             $stmt = $mysqli->prepare("UPDATE usuarios SET nick=?, email=? where nick=?");
             $stmt->bind_param('sss', $nick_nuevo, $email_nuevo, $nick_actual);
             if($stmt->execute()){
                 $stmt->close();
                 return 0;
             }else{
                 $stmt->close();
                 return 1;
             }
 }


function borrarEvento($id_evento){
        global $mysqli;
                $stmt = $mysqli->prepare("DELETE FROM eventos where id=?");
                $stmt->bind_param('i', $id_evento);
                //console_log( $id_comentario);
                $res= 0;
                if($stmt->execute()){
                    $stmt->close();
                }else{
                    $stmt->close();
                    $res++;
                }
                $stmt = $mysqli->prepare("DELETE FROM comentarios where id_evento=?");
                $stmt->bind_param('i', $id_evento);

                if($stmt->execute()){
                    $stmt->close();
                }else{
                    $stmt->close();
                    $res++;
                }

                $stmt = $mysqli->prepare("DELETE FROM imagenes where id_evento=?");
                $stmt->bind_param('i', $id_evento);

                if($stmt->execute()){
                    $stmt->close();
                }else{
                    $stmt->close();
                    $res++;
                }
}


function getPortada($idEv){
	global $mysqli;


    $stmt = $mysqli->prepare("SELECT portada FROM eventos where id=?");
    $stmt->bind_param('i', $idEv);
    $stmt->execute();
    $res = $stmt->get_result();
    $stmt->close();

    $portada = array();
    if ($res->num_rows > 0) {
          while($row= $res->fetch_assoc()){
          	    array_push($portada, $row);
          }
    }

    return $portada;

}

function editarEvento($titulo, $episodios, $temporadas, $fecha, $contenido, $generos, $link, $portada, $idEv){
             global $mysqli;
             $stmt = $mysqli->prepare("UPDATE eventos SET nombre=?, texto=?, link=?, fecha=?, generos=?, episodios=?, temporadas=?, imprimir_ruta=?, portada=? where id=?");
             $stmt->bind_param('sssssssssi', $titulo, $contenido, $link, $fecha, $generos, $episodios, $temporadas, $imprimir_ruta, $portada, $idEv);

             if($stmt->execute()){
                 $stmt->close();
                 return 0;
             }else{
                 $stmt->close();
                 return 1;
             }

}


function editarEventoSinPortada($titulo, $episodios, $temporadas, $fecha, $contenido, $generos, $link, $idEv){
             global $mysqli;
             $stmt = $mysqli->prepare("UPDATE eventos SET nombre=?, texto=?, link=?, fecha=?, generos=?, episodios=?, temporadas=?, imprimir_ruta=? where id=?");
             $stmt->bind_param('ssssssssi', $titulo, $contenido, $link, $fecha, $generos, $episodios, $temporadas, $imprimir_ruta, $idEv);

             if($stmt->execute()){
                 $stmt->close();
                 return 0;
             }else{
                 $stmt->close();
                 return 1;
             }

}

function actualizarImagen($galeria, $id_evento, $posicion){
        global $mysqli;
        //console_log($galeria);
        if(isset(getImagenes($id_evento)[$posicion]['id'])){
            $id= getImagenes($id_evento)[$posicion]['id'];
             $stmt = $mysqli->prepare("UPDATE imagenes SET rutaimagen=? where id=?");
             $stmt->bind_param('si', $galeria, $id);
             if($stmt->execute()){
                 $stmt->close();
                 return 0;
             }else{
                 $stmt->close();
                 return 1;
             }
        }else{
        //console_log($galeria);
             $stmt = $mysqli->prepare("INSERT INTO imagenes (rutaimagen, id_evento) VALUES (?, ?)");
             $stmt->bind_param('si', $galeria, $id_evento);
             if($stmt->execute()){
                 $stmt->close();
                 return 0;
             }else{
                 $stmt->close();
                 return 1;
             }


        }


}





function insertEvento($titulo, $episodios, $temporadas, $fecha, $contenido, $generos, $link, $portada){
             global $mysqli;
             $stmt = $mysqli->prepare("INSERT INTO eventos (nombre, texto, link, fecha, generos, episodios, temporadas, imprimir_ruta, portada) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
             $stmt->bind_param('sssssssss', $titulo, $contenido, $link, $fecha, $generos, $episodios, $temporadas, $imprimir_ruta, $portada);

             if($stmt->execute()){
                 $stmt->close();
                 return $mysqli->insert_id;
             }else{
                 $stmt->close();
                 return -1;
             }

}



function insertEventoSinPortada($titulo, $episodios, $temporadas, $fecha, $contenido, $generos, $link){
             global $mysqli;
             $stmt = $mysqli->prepare("INSERT INTO eventos (nombre, texto, link, fecha, generos, episodios, temporadas, imprimir_ruta) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
             $stmt->bind_param('ssssssss', $titulo, $contenido, $link, $fecha, $generos, $episodios, $temporadas, $imprimir_ruta);

             if($stmt->execute()){
                 $stmt->close();
                 return $mysqli->insert_id;
             }else{
                 $stmt->close();
                 return -1;
             }
}


function getUsers(){
	global $mysqli;

    $stmt = $mysqli->prepare("SELECT * FROM usuarios");
    $stmt->execute();
    $res = $stmt->get_result();
    $stmt->close();

    $usuarios = array();
    if ($res->num_rows > 0) {
          while($row= $res->fetch_assoc()){
          	    array_push($usuarios, $row);
          }
    }

    return $usuarios;

}

function cambiarRol($nick, $tipo){
    	global $mysqli;

        $super= 'superusuario';
        $stmt = $mysqli->prepare("SELECT COUNT(tipo) FROM usuarios where tipo=?");
        $stmt->bind_param('s', $super);
        $stmt->execute();
        $res = $stmt->get_result();
        $stmt->close();

        $cuenta = array();
        if ($res->num_rows > 0) {
              while($row= $res->fetch_assoc()){
              	    array_push($cuenta, $row);
              }
        }


        $stmt = $mysqli->prepare("SELECT tipo FROM usuarios where nick=?");
        $stmt->bind_param('s', $nick);
        $stmt->execute();
        $res2 = $stmt->get_result();
        $stmt->close();


        $tipoact = array();
        if ($res2->num_rows > 0) {
               while($row= $res2->fetch_assoc()){
                    array_push($tipoact, $row);
               }
        }

        if ($cuenta[0]['COUNT(tipo)'] === 1 and $tipoact[0]['tipo'] === 'superusuario') {
            return 1;
        }else{

            $stmt = $mysqli->prepare("UPDATE usuarios SET tipo=? where nick=?");
            $stmt->bind_param('ss', $tipo, $nick);
            if($stmt->execute()){
                 $stmt->close();
            }else{
                 $stmt->close();
                 return 1;
            }


        }

        return 0;

}

  function getEtiquetas($idEv) {
	global $mysqli;
    $stmt = $mysqli->prepare("SELECT * FROM etiquetas where id_evento=?");
    $stmt->bind_param('i', $idEv);
    $stmt->execute();


    $res = $stmt->get_result();
    $stmt->close();

    $etiquetas = array();
    if ($res->num_rows > 0) {
          while($row= $res->fetch_assoc()){
          	    array_push($etiquetas, $row);
          }
          //echo '<pre>'; print_r($etiquetas); echo '</pre>';
    }

    return $etiquetas;
}


function actualizarEtiqueta($etiqueta, $id_evento, $posicion){
        global $mysqli;

        if(isset(getEtiquetas($id_evento)[$posicion]['id'])){
            $id= getEtiquetas($id_evento)[$posicion]['id'];
             $stmt = $mysqli->prepare("UPDATE etiquetas SET etiqueta=? where id=?");
             $stmt->bind_param('si', $etiqueta, $id);
             if($stmt->execute()){
                 $stmt->close();
                 return 0;
             }else{
                 $stmt->close();
                 return 1;
             }
        }else{
             $stmt = $mysqli->prepare("INSERT INTO etiquetas (etiqueta, id_evento) VALUES (?, ?)");
             $stmt->bind_param('si', $etiqueta, $id_evento);
             if($stmt->execute()){
                 $stmt->close();
                 return 0;
             }else{
                 $stmt->close();
                 return 1;
             }


        }
}


function eliminarCuenta($nick){
    global $mysqli;
            $stmt = $mysqli->prepare("DELETE FROM usuarios where nick=?");
            $stmt->bind_param('s', $nick);
            if($stmt->execute()){
                $stmt->close();
                return 0;
            }else{
                $stmt->close();
                return 1;
            }
}

function publicar_evento($id_evento){

             global $mysqli;
             $stmt = $mysqli->prepare("UPDATE eventos SET publicado=? WHERE id=?");
             $val= 1;
             $stmt->bind_param('ii', $val, $id_evento);
             if($stmt->execute()){
                 $stmt->close();
                 return 0;
             }else{
                 $stmt->close();
                 return 1;
             }
}

function ocultar_evento($id_evento){

             global $mysqli;
             $stmt = $mysqli->prepare("UPDATE eventos SET publicado=? WHERE id=?");
             $val= 0;
             $stmt->bind_param('ii', $val, $id_evento);
             if($stmt->execute()){
                 $stmt->close();
                 return 0;
             }else{
                 $stmt->close();
                 return 1;
             }
}

function busqueda($buscado, $tipo){
	global $mysqli;

    $aux= "%" . $buscado . "%";

    if(!($tipo == 'superusuario' or $tipo == 'gestor'))
        $stmt = $mysqli->prepare('SELECT id, nombre FROM eventos WHERE (nombre LIKE ? OR texto LIKE ? OR generos LIKE ?) AND publicado=TRUE LIMIT 9');
    else{
                $stmt = $mysqli->prepare('SELECT id, nombre FROM eventos WHERE nombre LIKE ? OR texto LIKE ? OR generos LIKE ? LIMIT 9');

    }

    if($stmt === false) return 1;
    $stmt->bind_param('sss', $aux, $aux, $aux);
    $stmt->execute();
    $res = $stmt->get_result();
    $stmt->close();

    $coincidencias = array();
    if ($res->num_rows > 0) {
          while($row= $res->fetch_assoc()){
          	    array_push($coincidencias, $row);
          }
    }
    return $coincidencias;

}



//DEPURACION funcion auxiliar -----------
function console_log( $data ){
  echo '<script>';
  echo 'console.log('. json_encode( $data ) .')';
  echo '</script>';
}

?>
