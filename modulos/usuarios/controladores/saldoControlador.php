<?php

function principal() {
    if (validarUsuarioLoggeado()) {
        require_once 'modulos/pagos/modelos/operacionModelo.php';
        $numOperaciones = 20;
        if (isset($_GET['n'])) {
            if (is_numeric($_GET['n'])) {
                $numOperaciones = $_GET['n'];
            }
        }

        $usuario = getUsuarioActual();
        $operaciones = getUltimasOperacionesPorUsuario($numOperaciones, $usuario->idUsuario);
        if (isset($operaciones)) {
            $operaciones = array_reverse($operaciones);
        }

        require_once 'modulos/usuarios/vistas/saldoUsuario.php';
    }
}

function recargar() {
    if (validarUsuarioLoggeado()) {
        require_once 'modulos/pagos/vistas/recargarSaldo.php';
    }
}

function abonarSaldos() {
    $secret = -1;
    if (isset($_GET['llaveSecreta'])) {
        $secret = $_GET['llaveSecreta'];
    }
    //Si esta llave no es igual, no hacer nada
    if ($secret == "87293821") {
        
    } else {
        
    }
}

?>