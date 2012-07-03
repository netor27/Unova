<?php

function agregarTema() {
    if (validarUsuarioLoggeado()) {

        if (isset($_GET['i'])) {
            $idCurso = $_GET['i'];
            require_once 'modulos/cursos/modelos/CursoModelo.php';
            if (getUsuarioActual()->idUsuario == getIdUsuarioDeCurso($idCurso)) {
                require_once 'modulos/cursos/vistas/agregarTema.php';
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

function agregarTemaSubmit() {
    if (validarUsuarioLoggeadoParaSubmits()) {

        if (isset($_POST['titulo']) && isset($_POST['idCurso'])) {
            $titulo = removeBadHtmlTags(trim($_POST['titulo']));
            if (strlen($titulo) >= 5 && strlen($titulo) <= 50) {
                require_once 'modulos/cursos/clases/Tema.php';
                require_once 'modulos/cursos/modelos/TemaModelo.php';
                require_once 'modulos/cursos/modelos/CursoModelo.php';
                $tema = new Tema();
                $idCurso = $_POST['idCurso'];
                $curso = getCurso($idCurso);
                if (getUsuarioActual()->idUsuario == getIdUsuarioDeCurso($idCurso)) {
                    //El curso pertenece al usuario
                    $tema->idCurso = $idCurso;
                    $tema->nombre = $titulo;
                    $tema->idTema = altaTema($tema);
                    if ($tema->idTema >= 0) {
                        setSessionMessage("<h4 class='success'>¡Se agregó un tema!</h4>");
                        redirect("/curso/" . $curso->uniqueUrl);
                    } else {
                        //Error al insertar
                        $error = "Ocurrió un error al agregar el tema. Intenta de nuevo más tarde.";
                        require_once 'modulos/cursos/vistas/agregarTema.php';
                    }
                } else {
                    //El curso no pertenece al usuario
                    setSessionMessage("<h4 class'error'>No puedes modificar este curso</h4>");
                    goToIndex();
                }
            } else {
                $error = "Los datos introducidos no son válidos";
                require_once 'modulos/cursos/vistas/agregarTema.php';
            }
        } else {
            $error = "No especificaste un título para el tema";
            require_once 'modulos/cursos/vistas/agregarTema.php';
        }
    } else {
        goToIndex();
    }
}

function editarTema() {
    if (validarUsuarioLoggeado()) {

        if (isset($_GET['i'])) {
            $idCurso = $_GET['i'];
            $idTema = $_GET['j'];
            require_once 'modulos/cursos/modelos/CursoModelo.php';
            require_once 'modulos/cursos/modelos/TemaModelo.php';
            if (getUsuarioActual()->idUsuario == getIdUsuarioDeCurso($idCurso)) {
                $tema = getTema($idTema);
                require_once 'modulos/cursos/vistas/editarTema.php';
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

function editarTemaSubmit() {
    if (validarUsuarioLoggeadoParaSubmits()) {
        if (isset($_POST['titulo']) && isset($_POST['idCurso']) && isset($_POST['idTema'])) {
            $titulo = removeBadHtmlTags(trim($_POST['titulo']));
            $idCurso = $_POST['idCurso'];
            $idTema = $_POST['idTema'];
            require_once 'modulos/cursos/modelos/CursoModelo.php';
            if (getUsuarioActual()->idUsuario == getIdUsuarioDeCurso($idCurso)) {

                if (strlen($titulo) >= 5 && strlen($titulo) <= 50) {
                    $curso = getCurso($idCurso);
                    require_once 'modulos/cursos/clases/Tema.php';
                    require_once 'modulos/cursos/modelos/TemaModelo.php';
                    $tema = new Tema();
                    $tema->idCurso = $idCurso;
                    $tema->nombre = $titulo;
                    $tema->idTema = $idTema;
                    if (actualizaTema($tema)) {
                        setSessionMessage("<h4 class='success'>Se modificó el nombre del tema correctamente</h4>");
                        redirect("/curso/" . $curso->uniqueUrl);
                    } else {
                        setSessionMessage("<h4 class='error'>Ocurrió un error al modificar el tema. Intenta de nuevo más tarde.</h4>");
                        redirect("/curso/" . $curso->uniqueUrl);
                    }
                } else {
                    $error = "Los datos introducidos no son válidos";
                    require_once 'modulos/cursos/vistas/agregarTema.php';
                }
            } else {
                setSessionMessage("<h4 class='error'>No puedes modificar este curso</h4>");
                goToIndex();
            }
        } else {
            setSessionMessage("<h4 class='error'>Los datos enviados no son válidos</h4>");
            goToIndex();
        }
    } else {
        goToIndex();
    }
}

function borrarTema() {
    if (validarUsuarioLoggeadoParaSubmits()) {
        if (isset($_GET['i'])) {
            $idCurso = $_GET['i'];
            $idTema = $_GET['j'];
            require_once 'modulos/cursos/modelos/CursoModelo.php';
            require_once 'modulos/cursos/modelos/TemaModelo.php';
            if (getUsuarioActual()->idUsuario == getIdUsuarioDeCurso($idCurso)) {
                $tema = getTema($idTema);
                //El curso si pertenece al usuario
                $numClases = numeroDeClasesDelTema($idTema);
                if ($numClases > 0) {
                    //no puedes borrar el tema porque tiene clases asignadas
                    echo "<div> <h3 class='error'>No puedes borrar este tema porque todavía tiene clases.<br> Borra las clases primero</h3></div>";
                } else {
                    if (bajaTema($idTema) <= 0)
                        echo "<div><h3 class='error'> Ocurrió un error al borrar el tema. Intenta de nuevo más tarde.</h3></div>";
                    else {
                        //echo "<div><h3 class='info'></h3></div>";
                        echo "ok"; //Si fue satisfactorio no regresamos ningun resultado
                    }
                }
            } else {
                //Error, el usuario no es dueño de este curso, no puede modificar
                //goToIndex(); //no enviar a ningun lado porque es llamada ajax            
            }
        } else {
            //Error, no hay get['i']
            //goToIndex(); //no enviar a ningun lado porque es llamada ajax
        }
    } else {
        //Error, no hay usuario loggeado para ejecutar acción Ajax, no hacer nada
    }
}

?>
