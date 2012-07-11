<?php

function principal() {
    require_once 'modulos/cursos/vistas/principal.php';
}

function crearCurso() {
    if (validarUsuarioLoggeado()) {
        require_once 'modulos/categorias/modelos/categoriaModelo.php';
        require_once 'modulos/categorias/modelos/subcategoriaModelo.php';
        $categorias = getCategorias();
        $subcategorias = getSubcategoriasDeCategoria($categorias[0]->idCategoria);
        require_once 'modulos/cursos/vistas/crearCurso.php';
    }
}

function crearCursoSubmit() {
    if (validarUsuarioLoggeadoParaSubmits()) {
        if (isset($_POST['titulo']) && isset($_POST['descripcionCorta']) && isset($_POST['subcategoria']) && isset($_POST['palabrasClave'])) {
            $descripcionCorta = removeBadHtmlTags(trim($_POST['descripcionCorta']));
            $titulo = removeBadHtmlTags(trim($_POST['titulo']));
            $subcategoria = removeBadHtmlTags($_POST['subcategoria']);
            $keywords = removeBadHtmlTags(trim($_POST['palabrasClave']));

            if (strlen($titulo) >= 10 && strlen($titulo) <= 100 && strlen($descripcionCorta) >= 10 && strlen($descripcionCorta) <= 140 && strlen($keywords) <= 140) {

                require_once 'modulos/cursos/clases/Curso.php';

                $curso = new Curso();
                $curso->titulo = $titulo;
                $curso->descripcionCorta = $descripcionCorta;
                $curso->idSubcategoria = $subcategoria;
                $curso->idUsuario = getUsuarioActual()->idUsuario;
                if (strlen($keywords) > 0)
                    $curso->keywords = $keywords;

                require_once 'funcionesPHP/uniqueUrlGenerator.php';
                $curso->uniqueUrl = getCursoUniqueUrl($titulo);

                require_once 'modulos/cursos/modelos/CursoModelo.php';
                $id = altaCurso($curso);
                if ($id >= 0) {
                    $curso->idCurso = $id;
                    $url = "/curso/" . $curso->uniqueUrl;
                    setSessionMessage("<h4 class='success'>¡Haz creado un curso!</h4>");
                    redirect($url);
                } else {
                    setSessionMessage("<h4 class='error'>Ocurrió un error al dar de alta el curso. Intenta de nuevo más tarde</h4>");
                    redirect("/cursos/curso/crearCurso");
                }
            } else {
                setSessionMessage("<h4 class='error'>Los datos que introduciste no son válidos</h4>");
                redirect("/cursos/curso/crearCurso");
            }
        } else {
            setSessionMessage("<h4 class='error'>Los datos que introduciste no son válidos</h4>");
            redirect("/cursos/curso/crearCurso");
        }
    } else {
        goToIndex();
    }
}

function editarCurso() {
    require_once 'modulos/cursos/modelos/CursoModelo.php';

    $cursoUrl = $_GET['i'];
    $cursoParaModificar = getCursoFromUniqueUrl($cursoUrl);

    //Para el socialmedia container
    $titulo = $cursoParaModificar->titulo;
    $imageThumbnail = $cursoParaModificar->imagen;
    $descripcion = $cursoParaModificar->descripcionCorta;


    if ($cursoParaModificar->idUsuario == getUsuarioActual()->idUsuario) {
        require_once 'modulos/categorias/modelos/categoriaModelo.php';
        require_once 'modulos/categorias/modelos/subcategoriaModelo.php';
        require_once 'modulos/cursos/modelos/ClaseModelo.php';
        $subcategoria = getSubcategoria($cursoParaModificar->idSubcategoria);
        $categoria = getCategoriaPerteneciente($subcategoria->idSubcategoria);
        $temas = getTemas($cursoParaModificar->idCurso);
        $clases = getClases($cursoParaModificar->idCurso);
        $duracion = 0;
        if (isset($clases)) {
            foreach ($clases as $clase) {
                $duracion += $clase->duracion;
            }
        }

        $comentarios = getComentarios($cursoParaModificar->idCurso);
        $preguntas = getPreguntas($cursoParaModificar->idCurso);
        $usuarioDelCurso = getUsuarioDeCurso($cursoParaModificar->idCurso);
        $tiposClase = getTiposClase();
        $tituloPagina = substr($cursoParaModificar->titulo, 0, 50);
        $numAlumnos = getNumeroDeAlumnos($cursoParaModificar->idCurso);
        require_once 'modulos/cursos/vistas/editarCurso.php';
    } else {
        //El usuario no es dueño de este curso, no lo puede modificar
        setSessionMessage("<h4 class='error'>No puedes modificar este curso</h4>");
        goToIndex();
    }
}

function editarInformacionCurso() {
    require_once 'modulos/cursos/modelos/CursoModelo.php';

    $idCurso = $_GET['i'];
    $cursoParaModificar = getCurso($idCurso);

    if ($cursoParaModificar->idUsuario == getUsuarioActual()->idUsuario) {
        //El curso le pertenece al usuario loggeado.
        require_once 'modulos/categorias/modelos/subcategoriaModelo.php';
        $cat = getCategoriaPerteneciente($cursoParaModificar->idSubcategoria);
        //echo 'La categoria es '.$cat->idCategoria.' nombre = '.$cat->nombre;
        require_once 'modulos/categorias/modelos/categoriaModelo.php';
        require_once 'modulos/categorias/modelos/subcategoriaModelo.php';
        $categorias = getCategorias();
        $subcategorias = getSubcategoriasDeCategoria($cat->idCategoria);

        //echo 'La subcategoria es ' . $idSubcategoria. " .";
        require_once 'modulos/cursos/vistas/editarInformacionCurso.php';
    } else {
        //Este curso no le pertenece a esta persona, no lo puede modificar.
        //Reenviar a index.                
        goToIndex();
    }
}

function editarInformacionCursoSubmit() {
    if (validarUsuarioLoggeadoParaSubmits()) {
        if (isset($_GET['i']) && isset($_POST['titulo']) && isset($_POST['descripcionCorta']) && isset($_POST['descripcion']) && isset($_POST['subcategoria']) && isset($_POST['palabrasClave'])) {
            $idCurso = removeBadHtmlTags($_GET['i']);
            $titulo = removeBadHtmlTags(trim($_POST['titulo']));
            $descripcionCorta = removeBadHtmlTags(trim($_POST['descripcionCorta']));
            $idSubcategoria = removeBadHtmlTags($_POST['subcategoria']);
            $keywords = removeBadHtmlTags(trim($_POST['palabrasClave']));
            $descripcion = removeBadHtmlTags(trim($_POST['descripcion']));

            if (strlen($titulo) >= 10 && strlen($titulo) <= 100 && strlen($descripcionCorta) >= 10 && strlen($descripcionCorta) <= 140 && strlen($keywords) <= 140) {
                //Todo bien
                require_once 'modulos/cursos/modelos/CursoModelo.php';
                $curso = getCurso($idCurso);
                $tituloAnterior = $curso->titulo;
                if ($curso->idUsuario == getUsuarioActual()->idUsuario) {
                    //El curso le pertenece al usuario loggeado. Modificamos el contenido
                    $curso->titulo = $titulo;
                    require_once 'funcionesPHP/uniqueUrlGenerator.php';
                    if ($tituloAnterior != $curso->titulo) {
                        $curso->uniqueUrl = getCursoUniqueUrl($titulo);
                    }

                    $curso->descripcionCorta = $descripcionCorta;
                    $curso->idSubcategoria = $idSubcategoria;
                    $curso->keywords = $keywords;
                    $curso->descripcion = $descripcion;

                    if (actualizaInformacionCurso($curso)) {
                        require_once 'funcionesPHP/CargarInformacionSession.php';
                        cargarCursosSession();
                        setSessionMessage("<h4 class='success'>Se modificó correctamente la información del curso.</h4>");
                    } else {
                        setSessionMessage("<h4 class='error'>Currió un error al modificar el curso. Intenta de nuevo más tarde.</h4>");
                    }
                    redirect("/curso/" . $curso->uniqueUrl);
                } else {
                    //Este curso no le pertenece a esta persona, no lo puede modificar.
                    //Reenviar a index.                
                    setSessionMessage("<h4 class='error'>No puedes modificar este curso</h4>");
                    goToIndex();
                }
            } else {
                //Datos no validos
                setSessionMessage("<h4 class='error'>Los datos enviados no son correctos</h4>");
                redirect("/cursos/curso/editarInformacionCurso/" . $idCurso);
            }
        } else {
            //no hay datos en post
            setSessionMessage("<h4 class='error'>Los datos enviados no son correctos</h4>");
            redirect("/");
        }
    } else {
        goToIndex();
    }
}

function detalles() {
    require_once 'modulos/cursos/modelos/CursoModelo.php';
    //$idCurso = $_GET['i'];
    //obtenemos el curso y el usuario actual
    //$curso = getCurso($idCurso);
    $cursoUrl = $_GET['i'];

    $curso = getCursoFromUniqueUrl($cursoUrl);

    //Para socialmedia container
    $titulo = $curso->titulo;
    $imageThumbnail = $curso->imagen;
    $descripcion = $curso->descripcionCorta;


    if (is_null($curso)) {
        //si el curso no existe mandarlo a index
        setSessionMessage("<h4 class='error'>El curso que intentas ver no existe</h4>");
        redirect("/");
    } else {
        $usuario = getUsuarioActual();
        if (!is_null($usuario)) {
            //si hay usuario loggeado, verficiar si es el dueño
            if ($curso->idUsuario == $usuario->idUsuario) {
                //Si el usuario loggeado es el dueño del curso, lo enviamos a la página de edición.                        
                //$url = "/cursos/curso/editarCurso/" . $curso->idCurso;
                //redirect($url);
                editarCurso();
            } else {
                if ($curso->publicado == 1) {
                    //revisamos que ya haya sido publicado
                    //si no es el dueño
                    require_once 'modulos/usuarios/modelos/UsuarioCursosModelo.php';
                    //Revisamos si el usuario ya esta tomando este curso          

                    if (esUsuarioUnAlumnoDelCurso($usuario->idUsuario, $curso->idCurso) ||
                            tipoUsuario() == "administrador") {
                        //Si ya es un alumno, mostramos la página donde toma las clases
                        // o si es un administrador
                        tomarCurso();
                    } else {
                        //Si no, mostramos la página donde se suscribe
                        $usuarioDelCurso = getUsuarioDeCurso($curso->idCurso);
                        $numAlumnos = getNumeroDeAlumnos($curso->idCurso);
                        $temas = getTemas($curso->idCurso);
                        $clases = getClases($curso->idCurso);
                        $duracion = 0;
                        if (isset($clases)) {
                            foreach ($clases as $clase) {
                                $duracion += $clase->duracion;
                            }
                        }
                        $comentarios = getComentarios($curso->idCurso);
                        $preguntas = getPreguntas($curso->idCurso);
                        $usuarioDelCurso = getUsuarioDeCurso($curso->idCurso);
                        require_once 'modulos/categorias/modelos/categoriaModelo.php';
                        require_once 'modulos/categorias/modelos/subcategoriaModelo.php';

                        $subcategoria = getSubcategoria($curso->idSubcategoria);
                        $categoria = getCategoriaPerteneciente($subcategoria->idSubcategoria);
                        $tituloPagina = substr($curso->titulo, 0, 50);
                        require_once 'modulos/cursos/vistas/detallesCurso.php';
                    }
                } else if (tipoUsuario() == "administrador") {
                    tomarCurso();
                } else {
                    //si no ha sido publicado lo mandamos a index
                    setSessionMessage("<h4 class='error'>El curso que intentas ver no existe</h4>");
                    redirect("/");
                }
            }
        } else {
            if ($curso->publicado == 0) {
                //si no ha sido publicado lo mandamos a index
                setSessionMessage("<h4 class='error'>El curso que intentas ver no existe</h4>");
                redirect("/");
            } else {
                $usuarioDelCurso = getUsuarioDeCurso($curso->idCurso);
                $numAlumnos = getNumeroDeAlumnos($curso->idCurso);
                $temas = getTemas($curso->idCurso);
                $clases = getClases($curso->idCurso);
                $duracion = 0;
                if (isset($clases)) {
                    foreach ($clases as $clase) {
                        $duracion += $clase->duracion;
                    }
                }
                $comentarios = getComentarios($curso->idCurso);
                $preguntas = getPreguntas($curso->idCurso);
                $usuarioDelCurso = getUsuarioDeCurso($curso->idCurso);
                //si no hay usuario loggeado mostramos la página donde se suscribe
                require_once 'modulos/categorias/modelos/categoriaModelo.php';
                require_once 'modulos/categorias/modelos/subcategoriaModelo.php';

                $subcategoria = getSubcategoria($curso->idSubcategoria);
                $categoria = getCategoriaPerteneciente($subcategoria->idSubcategoria);
                $tituloPagina = substr($curso->titulo, 0, 50);
                require_once 'modulos/cursos/vistas/detallesCurso.php';
            }
        }
    }
}

function tomarCurso() {
    require_once 'modulos/cursos/modelos/CursoModelo.php';
    require_once 'modulos/usuarios/modelos/UsuarioCursosModelo.php';
    $cursoUrl = $_GET['i'];
    $curso = getCursoFromUniqueUrl($cursoUrl);

    //Para socialmedia container
    $titulo = $curso->titulo;
    $imageThumbnail = $curso->imagen;
    $descripcion = $curso->descripcionCorta;

    $usuario = getUsuarioActual();
    if (is_null($usuario)) {
        detalles();
    } else {
        if (esUsuarioUnAlumnoDelCurso($usuario->idUsuario, $curso->idCurso) ||
                tipoUsuario() == "administrador") {
            require_once 'modulos/categorias/modelos/categoriaModelo.php';
            require_once 'modulos/categorias/modelos/subcategoriaModelo.php';
            require_once 'modulos/cursos/modelos/ClaseModelo.php';
            $subcategoria = getSubcategoria($curso->idSubcategoria);
            $categoria = getCategoriaPerteneciente($subcategoria->idSubcategoria);
            $temas = getTemas($curso->idCurso);
            $clases = getClases($curso->idCurso);
            $duracion = 0;
            if (isset($clases)) {
                foreach ($clases as $clase) {
                    $duracion += $clase->duracion;
                }
            }
            $comentarios = getComentarios($curso->idCurso);
            $preguntas = getPreguntas($curso->idCurso);
            $usuarioDelCurso = getUsuarioDeCurso($curso->idCurso);
            $tiposClase = getTiposClase();
            $ratingUsuario = getRatingUsuario($usuario->idUsuario, $curso->idCurso);
            $numAlumnos = getNumeroDeAlumnos($curso->idCurso);
            $tituloPagina = substr($curso->titulo, 0, 50);
            require_once 'modulos/cursos/vistas/tomarCurso.php';
        } else {
            detalles();
        }
    }
}

function comentarCurso() {
    require_once 'modulos/cursos/modelos/CursoModelo.php';
    require_once 'modulos/usuarios/modelos/UsuarioCursosModelo.php';
    $idCurso = $_GET['i'];
    $curso = getCurso($idCurso);
    $texto = removeBadHtmlTags($_POST['comentario']);

    $usuario = getUsuarioActual();
    if (!is_null($usuario) && strlen(trim($texto)) > 0) {
        if (esUsuarioUnAlumnoDelCurso($usuario->idUsuario, $curso->idCurso)) {
            require_once 'modulos/cursos/clases/Comentario.php';
            require_once 'modulos/cursos/modelos/ComentarioModelo.php';
            $comentario = new Comentario();
            $comentario->idCurso = $curso->idCurso;
            $comentario->idUsuario = $usuario->idUsuario;
            $comentario->texto = $texto;
            $idComentario = altaComentario($comentario);

            if ($idComentario >= 0) {
                $comentario->avatar = $usuario->avatar;
                $comentario->nombreUsuario = $usuario->nombreUsuario;
                echo '<li class="page1">';
                if ($comentario->idUsuario == $curso->idUsuario)
                    echo '<div class="comentarioContainer blueBox">';
                else
                    echo '<div class="comentarioContainer whiteBox">';
                echo '<div class="comentarioAvatar"><img src="' . $comentario->avatar . '"></div>';
                echo '<div class="comentarioUsuario"><a href="/usuario/' . $comentario->uniqueUrlUsuario . '">' . $comentario->nombreUsuario . '</a></div>';
                echo '<div class="comentarioFecha"> Hace unos segundos</div>';
                echo '<br><br><div class="comentario left">' . $comentario->texto . '</div>';
                echo '</div>';
                echo '</li>';
            } else {
                echo 'error';
            }
        }
    }
}

function preguntarCurso() {
    require_once 'modulos/cursos/modelos/CursoModelo.php';
    require_once 'modulos/usuarios/modelos/UsuarioCursosModelo.php';
    $idCurso = $_GET['i'];
    $curso = getCurso($idCurso);
    $texto = removeBadHtmlTags($_POST['pregunta']);

    $usuario = getUsuarioActual();
    if (!is_null($usuario) && strlen(trim($texto)) > 0) {
        if (esUsuarioUnAlumnoDelCurso($usuario->idUsuario, $curso->idCurso)) {
            require_once 'modulos/cursos/clases/Pregunta.php';
            require_once 'modulos/cursos/modelos/PreguntaModelo.php';
            $pregunta = new Pregunta();
            $pregunta->idCurso = $curso->idCurso;
            $pregunta->idUsuario = $usuario->idUsuario;
            $pregunta->pregunta = $texto;
            $idPregunta = altaPregunta($pregunta);
            if ($idPregunta >= 0) {
                $pregunta->avatar = $usuario->avatar;
                $pregunta->nombreUsuario = $usuario->nombreUsuario;
                echo '<li class="page1">';
                echo '<div class="preguntaContainer whiteBox">';
                echo '<div class="comentarioAvatar"><img src="' . $pregunta->avatar . '"></div>';
                echo '<div class="comentarioUsuario"><a href="/usuario/' . $pregunta->uniqueUrlUsuario . '">' . $pregunta->nombreUsuario . '</a></div>';
                echo '<div class="comentarioFecha"> Hace unos segundos</div>';
                echo '<br><div class="comentario">' . $pregunta->pregunta . '</div>';
                echo '</div>';
                echo '</li>';

                //enviar email de notificación al dueño del curso de la pregunta
                //require_once 'modulos/email/modelos/envioEmailModelo.php';
                //$duenioCurso = getUsuarioDeCurso($curso->idCurso);
                //if (!enviarMailPreguntaEnCurso($duenioCurso->email, $curso->titulo, 'www.unova.mx/curso/' . $curso->uniqueUrl, $pregunta->pregunta))
                //    echo 'ERROR AL ENVIAR EMAIL A ' . $duenioCurso->email;
                //Se quitó esta parte para que no se envíe un mail al profesor cada vez que alguien pregunta algo
                //ahora se envía un mail semanal con un resumen
            } else {
                echo 'error';
            }
        }
    }
}

function responderPreguntaCurso() {
    require_once 'modulos/cursos/modelos/CursoModelo.php';
    require_once 'modulos/usuarios/modelos/UsuarioCursosModelo.php';
    $idCurso = $_GET['i'];
    $idPregunta = $_GET['j'];

    $curso = getCurso($idCurso);
    $texto = removeBadHtmlTags($_POST['respuesta']);

    $usuario = getUsuarioActual();
    if (!is_null($usuario) && strlen(trim($texto)) > 0) {
        if ($curso->idUsuario == $usuario->idUsuario) {
            require_once 'modulos/cursos/clases/Pregunta.php';
            require_once 'modulos/cursos/modelos/PreguntaModelo.php';
            if (responderPregunta($idPregunta, $texto)) {
                require_once 'modulos/email/modelos/envioEmailModelo.php';
                require_once 'modulos/cursos/modelos/PreguntaModelo.php';
                $datos = getInfoParaMailRespuestaPregunta($idPregunta);
                enviarMailRespuestaPregunta($datos['email'], $curso->titulo, 'www.unova.mx/curso/' . $curso->uniqueUrl, $datos['pregunta'], $texto);
                echo '<br><div class="respuesta blueBox" style="width: 80%;">';
                echo '<div class="comentarioAvatar"><img src="' . $usuario->avatar . '"></div>';
                echo '<div class="comentarioUsuario"><a href="/usuario/' . $usuario->uniqueUrl . '">' . $usuario->nombreUsuario . '</a></div>';
                echo '<br><div class="comentario">' . $texto . '</div>';
                echo '</div>';
            } else {
                echo 'error';
            }
        }
    }
}

function cambiarImagen() {
    if (validarUsuarioLoggeado()) {
        require_once 'modulos/cursos/modelos/CursoModelo.php';

        $idCurso = $_GET['i'];
        $cursoParaModificar = getCurso($idCurso);
        if ($cursoParaModificar->idUsuario == getUsuarioActual()->idUsuario) {
            require_once 'modulos/cursos/vistas/editarImagen.php';
        } else {
            setSessionMessage("<h4 class='error'>No puedes modificar este curso.</h4>");
            goToIndex();
        }
    }
}

function cambiarImagenSubmit() {
    if (validarUsuarioLoggeadoParaSubmits()) {
        if (isset($_FILES['imagen']) && isset($_GET['i'])) {
            $anchoImagen = 100;
            $altoImagen = 100;

            require_once 'modulos/cursos/modelos/CursoModelo.php';
            $idCurso = $_GET['i'];
            $cursoParaModificar = getCurso($idCurso);
            if ($cursoParaModificar->idUsuario == getUsuarioActual()->idUsuario) {
                if ((($_FILES["imagen"]["type"] == "image/jpeg")
                        || ($_FILES["imagen"]["type"] == "image/pjpeg")
                        || ($_FILES["imagen"]["type"] == "image/png"))
                        && ($_FILES["imagen"]["size"] < 500000)) {
                    require_once 'funcionesPHP/CropImage.php';
                    //guardamos la imagen en el formato original
                    $file = "archivos/temporal/" . $_FILES["imagen"]["name"];

                    move_uploaded_file($_FILES["imagen"]["tmp_name"], $file);

                    $path = pathinfo($file);
                    $uniqueCode = getUniqueCode(5);
                    $destName = $uniqueCode . "_curso_" . $cursoParaModificar->idCurso . "." . $path['extension'];
                    $dest = $path['dirname'] . "/" . $destName;

                    if (cropImage($file, $dest, $altoImagen, $anchoImagen)) {
                        //Se hizo el crop correctamente                    
                        //borramos la imagen temporal
                        unlink($file);
                        require_once 'modulos/cdn/modelos/cdnModelo.php';
                        $uri = crearArchivoCDN($dest, $destName, -1);
                        $oldUri = $cursoParaModificar->imagen;
                        if ($uri != NULL) {
                            $cursoParaModificar->imagen = $uri;
                            if (actualizaImagenCurso($cursoParaModificar)) {
                                //Se actualizó correctamente la bd, borramos el archivo anterior del cdn
                                if (strpos($oldUri, "http") !== false) {
                                    //Si el oldUri contiene http, significa que esta en cloud files, lo borramos. 
                                    $splitted = explode("/", $oldUri);
                                    $fileName = $splitted[sizeof($splitted) - 1];
                                    deleteArchivoCdn($fileName, -1);
                                }
                                require_once 'funcionesPHP/CargarInformacionSession.php';
                                cargarCursosSession();
                                setSessionMessage("<h4 class='success'>Cambiaste correctamente tu imagen</h4>");
                                redirect("/curso/" . $cursoParaModificar->uniqueUrl);
                            } else {
                                //error en bd
                                setSessionMessage("<h4 class='error'>Error bd</h4>");
                                redirect("/cursos/curso/cambiarImagen/" . $cursoParaModificar->idCurso);
                            }
                        } else {
                            //Ocurrió un error al subir al cdn
                            setSessionMessage("<h4 class='error'>Error cdn</h4>");
                            redirect("/cursos/curso/cambiarImagen/" . $cursoParaModificar->idCurso);
                        }
                    } else {
                        //borramos la imagen temporal
                        unlink($file);
                        //No se pudo hacer el "crop" de la imagen
                        //echo "no se pudo hacer el crop de la imagen";
                        setSessionMessage("<h4 class='error'>Ocurrió un error al procesar tu imagen. Intenta de nuevo más tarde</h4>");
                        redirect("/cursos/curso/cambiarImagen/" . $cursoParaModificar->idCurso);
                    }
                } else {
                    //No es una imagen válida
                    setSessionMessage("<h4 class='error'>No es una imagen válida</h4>");
                    redirect("/cursos/curso/cambiarImagen/" . $cursoParaModificar->idCurso);
                }
            } else {
                setSessionMessage("<h4 class='error'>No puedes modificar este curso</h4>");
                goToIndex();
            }
        } else {
            setSessionMessage("<h4 class='error'>No es una imagen válida</h4>");
            redirect("/cursos/curso/cambiarImagen/" . $cursoParaModificar->idCurso);
        }
    } else {
        goToIndex();
    }
}

function inscribirUsuario() {
    if (isset($_GET['i'])) {
        if (validarUsuarioLoggeado()) {
            $usuario = getUsuarioActual();
            $idCurso = removeBadHtmlTags($_GET['i']);
            require_once 'modulos/cursos/modelos/CursoModelo.php';
            $curso = getCurso($idCurso);
            if ($usuario->activado == 1) {
                if (isset($curso)) {
                    if ($curso->idUsuario != $usuario->idUsuario) {
                        require_once 'modulos/usuarios/modelos/UsuarioCursosModelo.php';
                        if (!esUsuarioUnAlumnoDelCurso($usuario->idUsuario, $idCurso)) {
                            //validar que el saldo del usuario sea suficiente para inscribirse a este curso
                            if ($usuario->saldo >= $curso->precio) {
                                //El usuario tiene saldo suficiente para suscribirse al curso
                                //Actualizamos el saldo del usuario
                                require_once 'modulos/usuarios/modelos/usuarioModelo.php';
                                if (actualizaSaldoUsuario($usuario->idUsuario, -$curso->precio)) {
                                    //Se actualizó correctamente el saldo del usuario, procedemos
                                    //a inscribir al usuario
                                    if (inscribirUsuarioCurso($usuario->idUsuario, $idCurso)) {
                                        require_once('funcionesPHP/CargarInformacionSession.php');
                                        cargarCursosSession();
                                        cargarUsuarioSession();
                                        setSessionMessage("<h4 class='success'>Haz quedado inscrito a este curso</h4>");

                                        require_once 'modulos/email/modelos/envioEmailModelo.php';
                                        //enviar email al usuario que se suscribió
                                        enviarMailSuscripcionCurso($usuario->email, $curso->titulo, $curso->imagen, 'www.unova.mx/curso/' . $curso->uniqueUrl);
                                        //enviar email al dueño del curso que alguien se suscribió
                                        //$duenioCurso = getUsuarioDeCurso($curso->idCurso);
                                        //enviarMailAlumnoSuscrito($duenioCurso->email, $curso->titulo, 'www.unova.mx/curso/' . $curso->uniqueUrl);
                                        //Se quitó el envio al profesor al momento de que un alumno se suscribe para evitar enviar muchos
                                        //mails y que lleguen a spam
                                        //Ahora, se envía un correeo semanal con el resumen de los nuevos alumnos
                                    } else {
                                        //Ocurrió un error al inscribir al usuario, pero ya se actualizó el saldo,
                                        //debemos regresar al saldo a la cantidad correcta
                                        actualizaSaldoUsuario($usuario->idUsuario, $curso->precio);
                                        setSessionMessage("<h4 class='error'>Ocurrió un error al inscribirte al curso 2</h4>");
                                    }
                                } else {
                                    //Ocurrió un error al disminuir el saldo
                                    setSessionMessage("<h4 class='error'>Ocurrió un error al inscribirte al curso</h4>");
                                }
                                redirect("/curso/" . $curso->uniqueUrl);
                            } else {
                                //No tiene saldo suficiente para suscribirse al curso, lo enviamos a
                                //una página donde puede recargar saldo
                                setSessionMessage("<h4 class='error'>No tienes el saldo suficiente para suscribirte</h4>");
                                redirect("/");
                            }
                        } else {
                            //el usuario ya está inscrito
                            setSessionMessage("<h4 class='error'>Ya estás suscrito a este curso</h4>");
                            redirect("/curso/" . $curso->uniqueUrl);
                        }
                    } else {
                        //el curso pertenece al usuario
                        setSessionMessage("<h4 class='error'>No puedes inscribirte a tu propio curso</h4>");
                        goToIndex();
                    }
                } else {
                    //el curso no existe
                    setSessionMessage("<h4 class='error'>Curso no válido</h4>");
                    goToIndex();
                }
            } else {
                //El usuario no ha confirmado su cuenta
                setSessionMessage("<h4 class='error'>Debes confirmar tu cuenta para poder inscribirte a este curso</h4><h4 class='notice'><a href='/usuarios/usuario/enviarCorreoConfirmacion'>Click aquí para confirmar cuenta</a></h4>");
                redirect("/curso/" . $curso->uniqueUrl);
            }
        } else {
            ////no hay usuario loggeado            
        }
    } else {
        //no hay i, ir a index
        goToIndex();
    }
}

function agregarContenido() {
    if (validarUsuarioLoggeado()) {

        if (isset($_GET['i'])) {
            $idCurso = $_GET['i'];
            $idTema = -1;
            $usuarioActual = getUsuarioActual();

            require_once 'modulos/cursos/modelos/CursoModelo.php';
            $curso = getCurso($idCurso);
            if ($usuarioActual->idUsuario == getIdUsuarioDeCurso($idCurso)) {
                if (isset($_GET['j'])) {
                    $idTema = $_GET['j'];
                } else {
                    //no hay get['idTema'],
                    //buscamos un tema y si no hay
                    //creamos un tema con el mismo nombre que el curso

                    require_once 'modulos/cursos/modelos/TemaModelo.php';
                    require_once 'modulos/cursos/clases/Tema.php';
                    $temas = getTemas($idCurso);
                    if (isset($temas)) {
                        $idTema = $temas[0]->idTema;
                    } else {
                        $tema = new Tema();
                        $tema->nombre = $curso->titulo;
                        $tema->idCurso = $curso->idCurso;
                        $idTema = altaTema($tema);
                    }
                }
                if ($idTema >= 0) {
                    //Tenemos un idTema correcto
                    require_once 'modulos/cursos/vistas/agregarContenido.php';
                } else {
                    //Ocurrió un error al dar de alta el tema
                    setSessionMessage("<h3 class='error'>Ocurrió un error al dar de alta el tema</h4>");
                    redirect("/curso/" . $curso->uniqueUrl);
                }
            } else {
                //Error, el usuario no es dueño de este curso, no puede modificar
                goToIndex();
            }
        } else {
            //Error, no hay get['i']
            goToIndex();
        }
    }
}

function calificarCurso() {
    $idUsuario = $_GET['iu'];
    $idCurso = $_GET['ic'];
    $rating = $_GET['rating'];

    require_once 'modulos/usuarios/modelos/UsuarioCursosModelo.php';
    if (esUsuarioUnAlumnoDelCurso($idUsuario, $idCurso)) {
        if (setRatingUsuario($idUsuario, $idCurso, $rating)) {
            echo "Tu calificación ha sido guardada. ¡Gracias!";
        } else {
            echo "Ocurrió un error al calificar el curso";
        }
    } else {
        echo "Ocurrió un error al calificar el curso";
    }
}

function publicar() {
    $idCurso = $_GET['ic'];
    $usuario = getUsuarioActual();
    if (isset($usuario)) {
        if ($usuario->activado == 1) {
            require_once 'modulos/cursos/modelos/CursoModelo.php';
            if (getIdUsuarioDeCurso($idCurso) == $usuario->idUsuario) {
                //Si el usuario loggeado es del curso, publicar
                if (setPublicarCurso($idCurso, 1)) {
                    echo ' ok';
                } else {
                    echo 'ERROR BD';
                }
            } else {
                echo 'ERROR. Usuario no dueño';
            }
        } else {
            //El usuario no ha confirmado su cuenta
            echo 'ERROR. Usuario no activado.';
        }
    } else {
        echo 'ERROR. Usuario no loggeado';
    }
}

function reportarCurso() {
    if (validarUsuarioLoggeadoParaSubmits()) {
        $idCurso = $_GET['i'];
        require_once 'modulos/cursos/modelos/CursoModelo.php';
        $array = array();
        if (isset($_SESSION['reportes'])) {
            $array = $_SESSION['reportes'];
        }
        
        if (in_array($idCurso,$array)) {
            echo 'no';
        } else {
            if (sumarTotalReportes($idCurso)) {
                array_push($array, $idCurso);
                echo 'ok';
            } else {
                echo 'error';
            }
        }
        $_SESSION['reportes'] = $array;
    }
}

?>
