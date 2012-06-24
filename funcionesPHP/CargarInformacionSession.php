<?php

function cargarCursosSession() {
    $usuario = getUsuarioActual();

    require_once 'modulos/usuarios/modelos/UsuarioCursosModelo.php';
    //obtener los ultimos 5 cursos a los que se ha 
    //inscrito y guardarlos en la sesión para mostrarlos en el menú        

    $aux = getCursosInscrito($usuario->idUsuario, 0, 4, "fechaInscripcion", "DESC");
    if (!is_null($aux)) {
        $_SESSION['cursos'] = $aux;
        //echo 'no es null';
    }
    //Obtener los ultimos 5 cursos que ha creado el usuario
    //guardarlos en la sesión para mostrarlos en el menú

    $aux = getCursosInstructor($usuario->idUsuario, 0, 4, "fechaCreacion", "DESC");
    if (!is_null($aux))
        $_SESSION['cursosPropios'] = $aux;
}

function cargarUsuarioSession() {
    require_once "modulos/usuarios/modelos/usuarioModelo.php";
    $usuarioSess = getUsuario(getUsuarioActual()->idUsuario);
    $usuario = new Usuario();
    $usuario->idUsuario = $usuarioSess->idUsuario;
    $usuario->activado = $usuarioSess->activado;
    $usuario->avatar = $usuarioSess->avatar;    
    $usuario->email = $usuarioSess->email;
    $usuario->nombreUsuario = $usuarioSess->nombreUsuario;
    $usuario->tipoUsuario = $usuarioSess->tipoUsuario;
    $usuario->uuid = $usuarioSess->uuid;
    $usuario->uniqueUrl = $usuarioSess->uniqueUrl;
    
    $_SESSION['usuario'] = $usuarioSess;
}

?>
