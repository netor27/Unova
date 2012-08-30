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
            } else {
                return "<br>Se actualizó la operación, pero ocurrió un error al actualizar el saldo<br>";
            }
        } else {
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

function getFormaRecargarSaldo() {
    if (isset($_GET['cnt']) && isset($_GET['des'])) {
        $cantidad = removeBadHtmlTags($_GET['cnt']);
        $descripcion = removeBadHtmlTags($_GET['des']);
        $usuario = getUsuarioActual();
        if (isset($usuario)) {
            if ($cantidad >= 50) {
                require_once 'modulos/pagos/modelos/operacionModelo.php';
                require_once 'modulos/pagos/modelos/PayPalModelo.php';

                $operacion = new Operacion();
                $operacion->cantidad = $cantidad;
                $operacion->detalle = $descripcion;
                $operacion->completada = 0;
                $operacion->idUsuario = $usuario->idUsuario;
                $operacion->idTipoOperacion = 1;
                //$operacion->idOperacion = 1;
                $operacion->idOperacion = altaOperacion($operacion);
                $encrypted = encriptarInformacionBotonPago($descripcion, "", $cantidad, $operacion->idOperacion);

                echo '<div style="text-align:center;">';
                echo '<h2 >Pagar con tarjeta de crédito   </h2>';
                echo '<img style="float:left;" src="/layout/imagenes/pagosPorPaypal.gif" style="padding-right:20px;">'; 
                echo '<h3>Serás redirigido al sitio de Paypal donde realizaras el pago de una manera segura</h3>';
                echo '<br><br>';
                echo '<h3><strong>No es necesario tener una cuenta de paypal</strong></h3>';
                echo '<br><br>';
                echo '<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">';
                echo '<input type="hidden" name="cmd" value="_s-xclick">';
                echo '<input type="hidden" name="encrypted" value="';
                echo $encrypted . '">';
                echo '<input type="image" src="https://www.paypalobjects.com/es_XC/MX/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal, la forma más segura y rápida de pagar en línea.">';
                echo '</form>';                
                echo '</div>';
            } else {
                //No es una cantidad valida
                echo 'no es una cantidad válida';
            }
        } else {
            echo 'no hay usuario loggeado';
            //No hay un usuario loggeado
        }
    } else {
        //no hay datos..
    }
}