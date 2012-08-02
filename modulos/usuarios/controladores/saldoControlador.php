<?php

function principal() {
    if (validarUsuarioLoggeado()) {
        require_once 'modulos/pagos/modelos/operacionModelo.php';
        $numOperaciones = 20;
        if(isset($_GET['n'])){
            if(is_numeric($_GET['n'])){
                $numOperaciones = $_GET['n'];
            }   
        }
        
        $usuario = getUsuarioActual();
        $operaciones = getUltimasOperacionesPorUsuario($numOperaciones, $usuario->idUsuario);
        $operaciones = array_reverse($operaciones);
        
        require_once 'modulos/usuarios/vistas/saldoUsuario.php';   
    }
}

function recargar(){
    if (validarUsuarioLoggeado()) {
        require_once 'modulos/pagos/vistas/recargarSaldo.php';
    }
}

?>