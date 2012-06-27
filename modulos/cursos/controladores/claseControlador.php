<?php

function borrarClase() {
    if (validarUsuarioLoggeadoParaAjax()) {
        if (isset($_GET['i']) && isset($_GET['j'])) {
            $idCurso = $_GET['i'];
            $idClase = $_GET['j'];
            require_once 'modulos/cursos/modelos/CursoModelo.php';
            require_once 'modulos/cursos/modelos/ClaseModelo.php';
            if (getUsuarioActual()->idUsuario == getIdUsuarioDeCurso($idCurso) && clasePerteneceACurso($idCurso, $idClase)) {
                $clase = getClase($idClase);
                if (bajaClase($idClase) <= 0) {
                    //Error al dar de baja la clase
                    echo "<div><h3 class='error'> Ocurrió un error al borrar la clase. Intenta de nuevo más tarde.</h3></div>";
                } else {
                    //Si fue satisfactorio, borramos el archivo del cdn
                    require_once 'modulos/cdn/modelos/cdnModelo.php';
                    $splitted = explode("/", $clase->archivo);
                    $fileName = $splitted[sizeof($splitted) - 1];
                    deleteArchivoCdn($fileName, $clase->idTipoClase);
                    if ($clase->idTipoClase == 0) {
                        //si es video borramos el archivo2
                        $splitted = explode("/", $clase->archivo2);
                        $fileName = $splitted[sizeof($splitted) - 1];
                        deleteArchivoCdn($fileName, $clase->idTipoClase);
                    }
                    echo "<div><h3 class='success'>Se borró la clase correctamente</h3></div>";
                }
            } else {
                //Error, el usuario no es dueño de este curso, no puede borrar
                echo "<div><h3>Error. No puedes modificar este curso</h3></div>";
            }
        } else {
            //Error, no hay get['i']
            echo "<div><h3>Error. I</h3></div>";
        }
    } else {
        echo "<div><h3>Error. U</h3></div>";
//Error, no hay usuario loggeado para ejecutar acción Ajax, no hacer nada
    }
}

function editarClase() {
    if (validarUsuarioLoggeado()) {
        if (isset($_GET['i']) && isset($_GET['j'])) {
            $idCurso = $_GET['i'];
            $idClase = $_GET['j'];
            require_once 'modulos/cursos/modelos/ClaseModelo.php';
            require_once 'modulos/cursos/modelos/CursoModelo.php';
            if (getUsuarioActual()->idUsuario == getIdUsuarioDeCurso($idCurso) && clasePerteneceACurso($idCurso, $idClase)) {
                $clase = getClase($idClase);
                $curso = getCurso($idCurso);
                require_once 'modulos/cursos/vistas/editarClase.php';
            } else {
                setSessionMessage('<h4 class="error">No puedes modificar esta clase</h4>');
                redirect("/");
            }
        } else {
            setSessionMessage('<h4 class="error">Los datos enviados no son correctos</h4>');
            redirect("/");
        }
    }
}

function editarClaseSubmit() {
    validarUsuarioLoggeadoMandarIndex();
    if (isset($_POST['titulo']) && isset($_POST['descripcion']) &&
            isset($_POST['idCurso']) && isset($_POST['idClase'])) {

        require_once 'modulos/cursos/modelos/CursoModelo.php';
        require_once 'modulos/cursos/modelos/ClaseModelo.php';

        $idCurso = removeBadHtmlTags($_POST['idCurso']);
        $curso = getCurso($idCurso);
        $idClase = removeBadHtmlTags($_POST['idClase']);

        if (getUsuarioActual()->idUsuario == getIdUsuarioDeCurso($idCurso) && clasePerteneceACurso($idCurso, $idClase)) {

            $titulo = removeBadHtmlTags(trim($_POST['titulo']));
            $descripcion = removeBadHtmlTags(trim($_POST['descripcion']));

            if (strlen($titulo) >= 5 && strlen($titulo) <= 100 && strlen($descripcion) > 10) {
                require_once 'modulos/cursos/clases/Clase.php';
                require_once 'modulos/cursos/modelos/ClaseModelo.php';

                $clase = new Clase();
                $clase->descripcion = $descripcion;
                $clase->titulo = $titulo;
                $clase->idClase = $idClase;

                if (actualizaInformacionClase($clase)) {
                    setSessionMessage("<h4 class='success'>Se modificó correctamente la clase </h4>");
                    redirect("/curso/" . $curso->uniqueUrl);
                } else {
                    //Error al insertar                    
                    setSessionMessage('<h4 class="error">Ocurrió un error al editar la clase. Intenta de nuevo más tarde</h4>');
                    redirect("/clases/clase/editarClase/" . $idCurso . "/" . $idClase);
                }
            } else {
                setSessionMessage('<h4 class="error">Los valores que introduciste no son válidos</h4>');
                redirect("/clases/clase/editarClase/" . $idCurso . "/" . $idClase);
            }
        } else {
            setSessionMessage('<h4 class="error">No puedes modificar esta clase</h4>');
            redirect("/");
        }
    } else {
        setSessionMessage('<h4 class="error">Los valores que introduciste no son válidos</h4>');
        redirect("/clases/clase/editarClase/" . $idCurso . "/" . $idClase);
    }
}

function tomarClase() {
    $cursoUrl = $_GET['curso'];
    $idClase = $_GET['clase'];
    require_once 'modulos/cursos/clases/Clase.php';
    require_once 'modulos/cursos/modelos/ClaseModelo.php';
    require_once 'modulos/cursos/modelos/CursoModelo.php';
    require_once 'modulos/usuarios/modelos/UsuarioCursosModelo.php';

    $curso = getCursoFromUniqueUrl($cursoUrl);
    $usuario = getUsuarioActual();

//Validar que la clase pertenezca al curso
    if (clasePerteneceACurso($curso->idCurso, $idClase)) {
        //Validar que el usuario este suscrito al curso
        if (esUsuarioUnAlumnoDelCurso($usuario->idUsuario, $curso->idCurso) ||
                $curso->idUsuario == $usuario->idUsuario || 
                tipoUsuario() == "administrador") {
            $clase = getClase($idClase);
            if ($curso->idUsuario != $usuario->idUsuario) {
                //si no es el dueño, contar las views
                sumarVistaClase($idClase);
                sumarTotalView($curso->idCurso);
            }
            switch ($clase->idTipoClase) {
                case 0:
                    if ($clase->transformado == 1) {
                        require_once 'modulos/cursos/vistas/tomarClaseVideo.php';
                    } else {
                        setSessionMessage("<h4 class='error'>Este video aún se está transformando. Espera unos minutos</h4>");
                        redirect('/curso/' . $curso->uniqueUrl);
                    }
                    break;
                case 1:
                case 2:
                    require_once 'modulos/cursos/vistas/tomarClase.php';
                    break;
                case 3:
                    require_once 'modulos/cursos/vistas/tomarClaseTarjetas.php';
                    break;
            }
        } else {
            setSessionMessage("<h4 class='error'>No puedes tomar esa clase, no tienens suscripción en ese curso</h4>");
            redirect("/");
        }
    } else {
        setSessionMessage("<h4 class='error'>Ocurrió un error al mostrar el curso. Intenta de nuevo más tarde</h4>");
        redirect("/");
    }
}

function editorVideo() {
    if (validarUsuarioLoggeado()) {
        if (isset($_GET['i']) && isset($_GET['j'])) {
            $idCurso = $_GET['i'];
            $idClase = $_GET['j'];
            $usuario = getUsuarioActual();
            require_once 'modulos/cursos/modelos/ClaseModelo.php';
            require_once 'modulos/cursos/modelos/CursoModelo.php';
            if ($usuario->idUsuario == getIdUsuarioDeCurso($idCurso) && clasePerteneceACurso($idCurso, $idClase)) {
                $clase = getClase($idClase);
                $curso = getCurso($idCurso);
                require_once 'modulos/editorPopcorn/vistas/editorPopcorn.php';
            } else {
                setSessionMessage('<h4 class="error">No puedes modificar esta clase</h4>');
                redirect("/");
            }
        } else {
            setSessionMessage('<h4 class="error">Los datos enviados no son correctos</h4>');
            redirect("/");
        }
    }
}

function guardarEdicionVideo() {
    $res = array();
    $resultado = "";
    $mensaje = "";
    if (validarUsuarioLoggeado()) {
        if (isset($_POST['u']) && isset($_POST['uuid']) && isset($_POST['cu']) && isset($_POST['cl'])) {
            $idUsuario = $_POST['u'];
            $uuid = $_POST['uuid'];
            $idCurso = $_POST['cu'];
            $idClase = $_POST['cl'];

            $usuario = getUsuarioActual();
            require_once 'modulos/cursos/modelos/ClaseModelo.php';
            require_once 'modulos/cursos/modelos/CursoModelo.php';
            if ($usuario->idUsuario == getIdUsuarioDeCurso($idCurso)
                    && $usuario->idUsuario == $idUsuario
                    && $usuario->uuid == $uuid
                    && clasePerteneceACurso($idCurso, $idClase)) {

                $json = json_encode($_POST);
                $json = str_replace("'", "", $json);

                if (actualizaCodigoClase($idClase, $json)) {
                    $resultado = "ok";
                    $mensaje = "Los cambios han sido guardados correctamente";
                } else {
                    $resultado = "error";
                    $mensaje = "Error al modificar la BD.";
                }
            } else {
                $resultado = "error";
                $mensaje = "No puedes modificar esta clase";
                echo json_encode($res);
            }
        } else {
            $resultado = "error";
            $mensaje = "Los datos recibidos son incorrectos";
            echo json_encode($res);
        }
    } else {
        $resultado = "error";
        $mensaje = "No hay usuario loggeado";
    }

    $res = array(
        "resultado" => $resultado,
        "mensaje" => $mensaje);
    echo json_encode($res);
}

//Funciones para la funcionalidad de la caja

function agregarTarjetas(){    
    if (tipoUsuario() == "administrador") {
        require_once 'modulos/cursos/vistas/agregarTarjetas.php';
    }else{
        goToIndex();
    }
}

function agregarTarjetasSubmit() {
    //recibe un csv con el formato:
    // ladoA, ladoB, tiempo
    $idCaja = $_POST['idCaja'];
    
    if (tipoUsuario() == "administrador") {
        //Por ahora solo agregar este tipo de contenido si es un administrador
        if (isset($_FILES['archivoCsv'])) {
            //Validar que haya un archivo csv
            $archivoCsv = $_FILES["archivoCsv"]["tmp_name"];
            require_once 'modulos/cursos/modelos/CajaModelo.php';
            $res = agregarTarjetasDesdeCSV($idCaja, $archivoCsv);
            if($res['resultado'] == 1){
                //todo bien
                echo 'Se insertaron ' . $res['insertados'] . ' filas.';
            }else{
                //Ocurrió un error al importar las tarjetas
                foreach($res['errores'] as $error){
                    echo $error . '<br>';
                }
            }
        } else {
            //No hay archivo
            echo 'No hay archivo';
        }
    }else{
        goToIndex();
    }
}

?>
