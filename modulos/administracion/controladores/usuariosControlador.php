<?php

function principal() {
    if (validarUsuarioAdministrador()) {
        require_once 'modulos/usuarios/modelos/usuarioModelo.php';
        $usuarios = getUsuarios();
        require_once 'modulos/administracion/vistas/adminUsuarios.php';
    } else {
        goToIndex();
    }
}

function cursosInstructor(){
    if (validarUsuarioAdministrador()) {
        $idUsuario = $_GET['i'];
        require_once 'modulos/usuarios/modelos/UsuarioCursosModelo.php';
        $cursos = getCursosInstructorDetalles($idUsuario, "titulo", "ASC");        
        $titulo = "Cursos de los que es instructor";
        require_once 'modulos/administracion/vistas/listaCursos.php';
    } else {
        goToIndex();
    }
}

function cursosAlumno(){
     if (validarUsuarioAdministrador()) {
        $idUsuario = $_GET['i'];
        require_once 'modulos/usuarios/modelos/UsuarioCursosModelo.php';
        $cursos = getCursosInscritoDetalles($idUsuario, "titulo", "ASC");        
        $titulo = "Cursos que esta tomando este usuario";
        require_once 'modulos/administracion/vistas/listaCursos.php';
    } else {
        goToIndex();
    }
}
?>