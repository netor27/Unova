<?php

function principal() {
    if (validarUsuarioLoggeado()) {
        echo 'saldo de usuario';
    }
}
?>