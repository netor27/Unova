<?php

require_once("modulos/pagos/clases/ipnMensaje.php");

function analizarIpnMensaje($ipnMensaje) {
    //verificamos que tipo de mensaje es
    switch ($ipnMensaje->txn_type) {
        case 'cart':
        case 'express_checkout':
        case 'web_accept':
            //Si es este tipo de mensaje, entonces alguien realizó un pago
            //hay que recargar el saldo
            if($ipnMensaje->payment_status == "Completed"){
                require_once 'modulos/pagos/controladores/pagosControlador.php';
                return manejarMensajePagoSatisfactorio($ipnMensaje->custom, $ipnMensaje->mc_gross);
            }else{
                return "<br>El mensaje no es de un pago completo<br>";
            }
            break;
        case 'masspay':
            //Si es este tipo, significa que se ralizó un pago a un usuario
            //hay que disminuir su saldo

            break;
        //cualquier otro tipo de mensajes, no los tomamos en cuenta, esos se
        //verificarán manualmente
    }
}

?>
