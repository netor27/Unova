<?php

function instructor() {
    require_once 'modulos/usuarios/modelos/UsuarioCursosModelo.php';
    if (validarUsuarioLoggeado()) {
        $usuario = getUsuarioActual();
        $cursos = getCursosInstructorDetalles($usuario->idUsuario, "titulo", "ASC");
        require_once 'modulos/usuarios/vistas/cursosInstructor.php';
    }
}

function inscrito() {
    require_once 'modulos/usuarios/modelos/UsuarioCursosModelo.php';
    if (validarUsuarioLoggeado()) {
        $usuario = getUsuarioActual();
        $cursos = getCursosInscritoDetalles($usuario->idUsuario, "fechaInscripcion", "DESC");
        require_once 'modulos/usuarios/vistas/cursosAlumno.php';
    }
}

?>