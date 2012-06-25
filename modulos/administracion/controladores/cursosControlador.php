<?php

function principal() {
    if (validarUsuarioAdministrador()) {
        require_once 'modulos/cursos/modelos/CursoModelo.php';
        $cursos = getAllCursos();
        require_once 'modulos/administracion/vistas/adminCursos.php';
    } else {
        goToIndex();
    }
}
?>
