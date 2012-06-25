<?php

function adminCursos() {
    if (validarUsuarioAdministrador()) {
        
    } else {
        goToIndex();
    }
}
?>
