<?php

function principal() {
    if (validarUsuarioAdministrador()) {
        require_once 'modulos/administracion/vistas/principal.php';
    } else {
        goToIndex();
    }
}

?>