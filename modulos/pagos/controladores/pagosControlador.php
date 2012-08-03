<?php

function principal() {
    echo 'principal';
}

function pagoSatisfactorio() {
    require_once 'modulos/pagos/vistas/pagoSatisfactorio.php';
}

function manejarMensajePagoSatisfactorio($idOperacion, $cantidad) {
    require_once 'modulos/pagos/modelos/operacionModelo.php';
    $operacion = getOperacion($idOperacion);
    //validamos que el pago sea de la misma cantidad por la que fue procesada
    if ($operacion->cantidad == $cantidad) {
        if (setOperacionCompletada($operacion->idOperacion)) {
            //la operación fue actualizada exitosamente, ahora actualizamos el 
            //saldo del usuario
            require_once 'modulos/usuarios/modelos/usuarioModelo.php';
            if (actualizaSaldoUsuario($operacion->idUsuario, $cantidad)) {
                //Se actualizó correctamente el saldo del usuario
                return "<br>Se actualizó correctamente el saldo del usuario<br>";
            }else{
                return "<br>Se actualizó la operación, pero ocurrió un error al actualizar el saldo<br>";
            }
        }else{
            return "<br>Ocurrió un error al actualizar la operacion. No se actualizó el saldo<br>";
        }
    } else {
        //esto es muy raro y hay que revisarlo a mano.
        //Se enviará un mai con los detalles para su revisión
        return "La cantidad de la transacción no coincide con la cantidad de la 
            operación<br> la cantidad de la operación es de " .
                $operacion->cantidad . " y la cantidad de la transacción es de "
                . $cantidad;
    }
}