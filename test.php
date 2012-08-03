<?php

//require_once 'modulos/pagos/controladores/ipnControlador.php';
//$ipnMensaje = new IpnMensaje();
//$ipnMensaje->txn_type = 'cart';
//$ipnMensaje->payment_status = "Completed";
//$ipnMensaje->custom = "13";
//$ipnMensaje->mc_gross = "176";
//
//$msg = analizarIpnMensaje($ipnMensaje);
//
//echo $msg;

require_once 'modulos/pagos/modelos/operacionModelo.php';
$operacion = new Operacion();
$operacion->cantidad = "500";
$operacion->detalle = "Inscripción a curso  Matemáticas 1";
$operacion->idUsuario = 3;
$operacion->completada = 1;
$operacion->idTipoOperacion = 2;
altaOperacion($operacion);
?>
