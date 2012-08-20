<?php

function detalles() {

    $uniqueUrl = $_GET['i'];
    require_once 'modulos/usuarios/modelos/usuarioModelo.php';
    //$usuarioPerfil = getUsuario($idUsuario);
    $usuarioPerfil = getUsuarioFromUniqueUrl($uniqueUrl);

    if (!is_null($usuarioPerfil)) {
        $tituloPagina = $usuarioPerfil->nombreUsuario;
        $titulo = $usuarioPerfil->nombreUsuario;
        $imageThumbnail = $usuarioPerfil->avatar;
        $descripcion = $usuarioPerfil->tituloPersonal;

        $miPerfil = false;
        if (validarUsuarioLoggeadoParaSubmits()) {
            if (getUsuarioActual()->idUsuario == $usuarioPerfil->idUsuario) {
                $miPerfil = true;
            }
        }
        require_once 'modulos/usuarios/modelos/UsuarioCursosModelo.php';

        if ($miPerfil) {
            $numTomados = getNumeroCursosTomados($usuarioPerfil->idUsuario);
            $cursos = getCursosInstructorDetalles($usuarioPerfil->idUsuario, "titulo", "ASC");
            $numCursos = sizeof($cursos);
        } else {
            $cursos = getCursosInstructorDetallesPublicados($usuarioPerfil->idUsuario, "titulo", "ASC");
            $numTomados = getNumeroCursosTomados($usuarioPerfil->idUsuario);
            $numCursos = sizeof($cursos);
        }
        require_once 'modulos/usuarios/vistas/perfil.php';
    } else {
        setSessionMessage("<h4 class='error'>¡El usuario no existe!</h4>");
        redirect("/");
    }
}

function editarInformacion() {
    if (validarUsuarioLoggeado()) {
        $id = getUsuarioActual()->idUsuario;
        require_once 'modulos/usuarios/modelos/usuarioModelo.php';
        $usuario = getUsuario($id);
        require_once 'modulos/usuarios/vistas/editarPerfil.php';
    }
}

function editarInformacionSubmit() {
    if (validarUsuarioLoggeadoParaSubmits()) {
        $usuarioParaEditar = getUsuarioActual();
        $nombreAnterior = $usuarioParaEditar->nombreUsuario;
        if (isset($_POST['nombre']))
            $usuarioParaEditar->nombreUsuario = strip_tags(trim($_POST['nombre']));
        if (isset($_POST['tituloPersonal']))
            $usuarioParaEditar->tituloPersonal = str_replace('"', '', strip_tags(trim($_POST['tituloPersonal'])));
        if (isset($_POST['bio']))
            $usuarioParaEditar->bio = trim($_POST['bio']);

        require_once 'modulos/usuarios/modelos/usuarioModelo.php';
        if ($nombreAnterior != $usuarioParaEditar->nombreUsuario) {
            require_once 'funcionesPHP/uniqueUrlGenerator.php';
            $usuarioParaEditar->uniqueUrl = getUsuarioUniqueUrl($usuarioParaEditar->nombreUsuario);
        }
        if (actualizaInformacionUsuario($usuarioParaEditar)) {

            setSessionMessage("<h4 class='success'>Se actualizó tu información de perfil</h4>");
            redirect("/usuario/" . $usuarioParaEditar->uniqueUrl);
        } else {
            $error = "Ocurrió un error al actualizar tu información. <br>Intenta de nuevo más tarde";
            $usuario = getUsuario($usuarioParaEditar->idUsuario);
            require_once 'modulos/usuarios/vistas/editarPerfil.php';
        }
    } else {
        goToIndex();
    }
}

function cambiarImagen() {
    if (validarUsuarioLoggeado()) {
        require_once 'modulos/usuarios/modelos/usuarioModelo.php';

        $usuarioCambiar = getUsuario(getUsuarioActual()->idUsuario);
        require_once 'modulos/usuarios/vistas/editarImagen.php';
    }
}

function cambiarImagenSubmit() {
    if (validarUsuarioLoggeadoParaSubmits()) {
        if (isset($_FILES['imagen'])) {
            $anchoImagen = 200;
            $altoImagen = 200;

            require_once 'modulos/usuarios/modelos/usuarioModelo.php';
            $usuarioCambiar = getUsuario(getUsuarioActual()->idUsuario);
            if ((($_FILES["imagen"]["type"] == "image/gif")
                    || ($_FILES["imagen"]["type"] == "image/jpeg")
                    || ($_FILES["imagen"]["type"] == "image/pjpeg")
                    || ($_FILES["imagen"]["type"] == "image/png"))
                    && ($_FILES["imagen"]["size"] < 5000000)) {
                require_once 'funcionesPHP/CropImage.php';
                //guardamos la imagen en el formato original
                $file = "archivos/temporal/" . $_FILES["imagen"]["name"];

                move_uploaded_file($_FILES["imagen"]["tmp_name"], $file);

                $path = pathinfo($file);
                $uniqueCode = getUniqueCode(5);
                $destName = $uniqueCode . "_perfil_" . $usuarioCambiar->idUsuario . "." . $path['extension'];
                $dest = $path['dirname'] . "/" . $destName;

                if (cropImage($file, $dest, $altoImagen, $anchoImagen)) {
                    //Se hizo el crop correctamente
                    //borramos la imagen temporal
                    unlink($file);
                    require_once 'modulos/cdn/modelos/cdnModelo.php';
                    $uri = crearArchivoCDN($dest, $destName, -1);
                    if ($uri != NULL) {
                        $usuarioCambiar->avatar = $uri;
                        //actualizamos la información en la bd                
                        actualizaAvatar($usuarioCambiar);
                        require_once 'funcionesPHP/CargarInformacionSession.php';
                        cargarUsuarioSession();
                        setSessionMessage("<h4 class='success'>Haz cambiado tu imagen correctamente. Espera unos minutos para ver el cambio</h4>");
                        redirect("/usuario/" . $usuarioCambiar->uniqueUrl);
                    } else {
                        //Ocurrió un error al subir al cdn
                        setSessionMessage("<h4 class='error'>Error cdn</h4>");
                        redirect("/usuarios/usuario/cambiarImagen");
                    }
                } else {
                    //Error al hacer el crop
                    //borramos la imagen temporal
                    unlink($file);
                    setSessionMessage("<h4 class='error'>Ocurrió un error al procesar tu imagen. Intenta de nuevo más tarde</h4>");
                    redirect("/usuarios/usuario/cambiarImagen");
                }
            } else {
                //El archivo no es válido o es demasiado grande
                setSessionMessage("<h4 class='error'>No es una imagen válida.</h4>");
                redirect("/usuarios/usuario/cambiarImagen");
            }
        }
    } else {
        goToIndex();
    }
}

function cambiarPassword() {
    if (validarUsuarioLoggeado()) {
        require_once 'modulos/usuarios/vistas/cambiarPassword.php';
    }
}

function cambiarPasswordSubmit() {
    if (validarUsuarioLoggeadoParaSubmits()) {
        if (isset($_POST['pass1']) && isset($_POST['pass2']) && isset($_POST['passAnt'])) {
            $usuario = getUsuarioActual();
            $passAnterior = md5($_POST['passAnt']);
            require_once 'modulos/usuarios/modelos/usuarioModelo.php';
            if (validarPassAnterior($usuario->idUsuario, $passAnterior)) {
                $pass1 = trim($_POST['pass1']);
                $pass2 = trim($_POST['pass2']);
                if (strlen($pass1) >= 5 && strlen($pass1) >= 5 && $pass1 == $pass2) {
                    $usuario->password = md5($pass1);
                    actualizaPassword($usuario);
                    setSessionMessage("<h4 class='success'>Se cambió correctamente tu contraseña</h4>");
                    redirect("/usuario/" . $usuario->uniqueUrl);
                } else {
                    $error = "La contraseña no es válida";
                    require_once 'modulos/usuarios/vistas/cambiarPassword.php';
                }
            } else {
                $error = "La contraseña anterior no es correcta.";
                require_once 'modulos/usuarios/vistas/cambiarPassword.php';
            }
        } else {
            $error = "Los datos no son válidos";
            require_once 'modulos/usuarios/vistas/cambiarPassword.php';
        }
    } else {
        goToIndex();
    }
}

function recuperarPassword() {
    require_once 'modulos/usuarios/vistas/recuperarPassword.php';
}

function recuperarPasswordSubmit() {
    if (isset($_POST['email'])) {
        require_once 'modulos/usuarios/modelos/usuarioModelo.php';
        $email = $_POST['email'];

        $uuid = getUUIDFromEmail($email);
        if (!empty($uuid)) {
            $link = "www.unova.mx/usuarios/usuario/reestablecerPassword/" . $uuid;
            //Enviar el mail //
            require_once 'modulos/email/modelos/envioEmailModelo.php';
            enviarMailOlvidePassword($email, $link);
            setSessionMessage("<h4 class='info'>Te hemos enviado un correo electrónico para que reestablescas tu contraseña.</h4>");
        }else{
            setSessionMessage("<h4 class='error'>No tenemos registrado este correo electrónico.</h4>");
        }
    }
    goToIndex();
}

function reestablecerPassword() {
    $uuid = $_GET['i'];
    require_once 'modulos/usuarios/vistas/reestablecerPassword.php';
}

function reestablecerPasswordSubmit() {
    if (isset($_POST['uuid']) && isset($_POST['pass1']) && isset($_POST['pass2'])) {
        $pass1 = trim($_POST['pass1']);
        $pass2 = trim($_POST['pass2']);
        $uuid = trim($_POST['uuid']);

        if ($pass1 == $pass2 && strlen($pass1) >= 5) {
            require_once 'modulos/usuarios/modelos/usuarioModelo.php';
            if (reestablecerPasswordPorUUID($uuid, md5($pass1)) > 0) {
                setSessionMessage("<h4 class='success'>¡Haz reestablecido tu contraseña!</h4>");
                redirect("/");
            } else {
                $error = "Ocurrió un error al reestablecer tu contraseña. Intenta de nuevo más tarde.";
                require_once 'modulos/usuarios/vistas/reestablecerPassword.php';
            }
        } else {
            $error = "Los datos que introduciste no son válidos.";
            require_once 'modulos/usuarios/vistas/reestablecerPassword.php';
        }
    }
}

function cambiarCorreo() {
    if (validarUsuarioLoggeado()) {
        require_once 'modulos/usuarios/vistas/cambiarCorreo.php';
    }
}

function cambiarCorreoSubmit() {
    if (validarUsuarioLoggeadoParaSubmits()) {
        if (isset($_POST['email'])) {
            $usuario = getUsuarioActual();
            require_once 'modulos/usuarios/modelos/usuarioModelo.php';
            $usuario->email = $_POST['email'];
            if (actualizaEmail($usuario)) {
                setSessionMessage("<h4 class='success'>¡Actualizaste tu correo! Recibirás un correo para confirmarlo</h4>");
                redirect("/usuario/" . $usuario->uniqueUrl);
            } else {
                setSessionMessage("<h4 class='error'>Ocurrió un error al actualizar tu correo. Intenta de nuevo más tarde</h4>");
                redirect("/usuario/" . $usuario->uniqueUrl);
            }
        } else {
            $error = "Los datos no son válidos";
            require_once 'modulos/usuarios/vistas/cambiarPassword.php';
        }
    } else {
        goToIndex();
    }
}

function confirmarCuenta() {
    $uuid = $_GET['i'];
    require_once 'modulos/usuarios/modelos/usuarioModelo.php';
    $idUsuario = getIdUsuarioFromUuid($uuid);
    if (setActivado($idUsuario, 1)) {
        setSessionMessage("<h4 class='success'>Tu cuenta ha sido confirmada. ¡Gracias!</h4>");
        require_once 'funcionesPHP/CargarInformacionSession.php';
        cargarUsuarioSession();
    } else {
        setSessionMessage("<h4 class='error'>Ocurrió un error al confirmar tu cuenta. Intenta de nuevo más tarde</h4>");
    }
    goToIndex();
}

function enviarCorreoConfirmacion() {
    $usuario = getUsuarioActual();
    if (isset($usuario)) {
        require_once 'modulos/email/modelos/envioEmailModelo.php';
        $urlConfirmacion = "www.unova.mx/usuarios/usuario/confirmarCuenta/" . $usuario->uuid;
        enviarMailConfirmacion($usuario->email, $urlConfirmacion);
        setSessionMessage("<h4 class='success'>Te hemos enviado un correo de confirmación</h4>");
        redirect("/usuario/" . $usuario->uniqueUrl);
    } else {
        setSessionMessage("<h4 class='error'>Ocurrió un error, intentalo más tarde</h4>");
        goToIndex();
    }
}

?>