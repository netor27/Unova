<?php

function instructor() {
    
    require_once 'modulos/usuarios/modelos/UsuarioCursosModelo.php';
    $usuario = getUsuarioActual();
    if (is_null($usuario)) {   
        $error = "Debes iniciar sesión para ver este contenido.";
        $pagina = getUrl;        
        require_once 'modulos/principal/vistas/login.php';
    } else {
        $cursos = getCursosInstructorDetalles($usuario->idUsuario, "titulo", "ASC");
        require_once 'modulos/usuarios/vistas/cursosInstructor.php';
    }
}

function inscrito() {
    require_once 'modulos/usuarios/modelos/UsuarioCursosModelo.php';
    $usuario = getUsuarioActual();
    if (is_null($usuario)) {
        $error = "Debes iniciar sesión para ver este contenido.";
        $pagina = getUrl();
        require_once 'modulos/principal/vistas/login.php';
    } else {
        $cursos = getCursosInscritoDetalles($usuario->idUsuario, "fechaInscripcion", "DESC");        
        require_once 'modulos/usuarios/vistas/cursosAlumno.php';
    }
}

?>
