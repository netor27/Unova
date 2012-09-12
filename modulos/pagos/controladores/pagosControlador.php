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

function manejarMensajeMassPayment($ipnMensaje) {
    $payments = $ipnMensaje->masspayArray;
    $date = $ipnMensaje->payment_date;
    require_once 'modulos/pagos/modelos/solicitudSaldoModelo.php';
    $solicitudSaldo = new SolicitudSaldo();
    $solicitudSaldo->fechaEntrega = $date;
    if (isset($payments)) {
        $msg = "<br>Datos de los pagos:<br>";
        foreach ($payments as $payment) {
            //este es el idSolicitudSaldo
            $solicitudSaldo->idSolicitudSaldo = $payment['unique_id'];
            $solicitudSaldo->txn_id = $payment['masspay_txn_id'];
            switch ($payment['status']) {
                case 'Unclaimed':
                    //Se retiró el dinero de la cuenta pero no ha sido depositado en la cuenta 
                    //del usuario
                    $solicitudSaldo->entregado = 1;
                    $msg = $msg . "<br>" . $solicitudSaldo->idSolicitudSaldo . " Se retiro el dinero de la cuenta $" . $payment['mc_gross'] . " con una comisión de $" . $payment['mc_fee'];
                    break;
                case 'Completed':
                    //Todo ocurrió correctamente
                    $solicitudSaldo->entregado = 2;
                    $msg = $msg . "<br>" . $solicitudSaldo->idSolicitudSaldo . " Se retiro y deposito el dinero $" . $payment['mc_gross'] . " con una comisión de $" . $payment['mc_fee'];
                    break;
                case 'Failed':
                    //Ocurrió un error, no hay saldo suficiente
                    //depositar manualmente
                    $solicitudSaldo->entregado = 3;
                    $msg = $msg . "<br>" . $solicitudSaldo->idSolicitudSaldo . " NO HAY SALDO SUFICIENTE PARA REALIZAR LA SIGUIENTE OPERACION: $" . $payment['mc_gross'] . " con una comisión de $" . $payment['mc_fee'];
                    break;
                case 'Returned':
                case 'Reversed':
                    //El usuario no tiene una cuenta de paypal o su cuenta está bloqueada
                    $msg = $msg . "<br>" . $solicitudSaldo->idSolicitudSaldo . " EL DINERO FUE DEPOSITADO DE NUEVO EN NUESTRA CUENTA $" . $payment['mc_gross'] . " con una comisión de $" . $payment['mc_fee'];
                    $solicitudSaldo->entregado = 4;
                    break;
            }
            // En cualquier caso, sólo actualizamos el estado.
            // Si es un caso Failed, Returned o Reversed, se debe de arreglar manualmente
            // para evitar fraudes.
            if (actualizarSolicitudSaldo($solicitud)) {
                $msg = $msg . " ====> Se actualizó correctamente la bd ";
            } else {
                $msg = $msg . " ====> OCURRIO UN ERROR AL ACTUALIZAR LA BD";
            }
        }
        return $msg;
    } else {
        return "<br>No hay datos en el arreglo de mass payments";
    }
}

function getFormaRecargarSaldo() {
    if (isset($_GET['cnt']) && isset($_GET['des']) && isset($_GET['tipo'])) {
        $cantidad = removeBadHtmlTags($_GET['cnt']);
        $descripcion = removeBadHtmlTags($_GET['des']);
        $usuario = getUsuarioActual();
        if (isset($usuario)) {
            if ($cantidad >= 50) {
                require_once 'modulos/pagos/modelos/operacionModelo.php';
                require_once 'modulos/pagos/modelos/PayPalModelo.php';
                require_once 'bd/conex.php';
                beginTransaction();
                $operacion = new Operacion();
                $operacion->cantidad = $cantidad;
                $operacion->detalle = $descripcion;
                $operacion->completada = 0;
                $operacion->idUsuario = $usuario->idUsuario;
                $operacion->idTipoOperacion = 1;
                $operacion->idOperacion = altaOperacion($operacion);
                switch ($_GET['tipo']) {
                    case 'paypal':
                        commitTransaction();
                        $encrypted = encriptarInformacionBotonPago($descripcion, "", $cantidad, $operacion->idOperacion);
                        require_once 'modulos/pagos/vistas/formaRecargarSaldoPaypal.php';
                        break;
                    //not supported yet
//                    case 'mercadopago':
//                        break;
                    default:
                        rollBackTransaction();
                        echo '<div class="center" style="text-align:center"><h3 class="error">No es una opción válida</h3><br><h4>Ocurrió un error en tu solicitud</h4></div>';
                        break;
                }
            } else {
                //No es una cantidad valida
                echo '<div class="center" style="text-align:center"><h3 class="error">No es una cantidad válida</h3><br><h4>La cantidad mínima para recargar es de $50.00</h4></div>';
            }
        } else {
            echo 'no hay usuario loggeado';
            //No hay un usuario loggeado
        }
    } else {
        //no hay datos..
    }
}