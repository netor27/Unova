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
            if($ipnMensaje->payment_status == "Completed" || $ipnMensaje->payment_status == "Processed"){
                require_once 'modulos/pagos/controladores/pagosControlador.php';
                return manejarMensajeMassPayment($ipnMensaje);
            }else{
                return "<br>La solicitud de mass payment no se realizo correctamente<br>For Mass Payments, this means that your funds were not sent and the Mass Payment was not initiated. This may have been caused by lack of funds<br>";
            }
            
            break;
        //cualquier otro tipo de mensajes, no los tomamos en cuenta, esos se
        //verificarán manualmente
    }
}

?>