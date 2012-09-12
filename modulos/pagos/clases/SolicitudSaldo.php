<?php

class SolicitudSaldo {

    public $idSolicitudSaldo;
    public $idUsuario;
    
    //valores para entregado
    // 0 
    // no entregado 
    // Este valor no tiene un estado asignado al status de paypal
    // 1   
    // se retiro el saldo de la cuenta pero no se ha depositado en la cuenta del usuario
    // Unclaimed: This is for unilateral payments that are unclaimed .
    // 2
    // Se retiro y se deposito en la cuenta del usuario
    // Completed: The payment has been processed, regardless of whether this was originally a unilateral payment
    // 3
    // Fallo la transacción por no haber suficiente saldo
    // Failed: The payment failed because of insufficient PayPal balance.
    // 4
    // Si ocurrió un error al momento de depositar en la cuenta del usuario,
    // después de 30 días se regreso el dineo a la cuenta de la empresa
    // Returned: Payment has been returned after 30 days.
    // Reversed: This is for unilateral payments that were not claimed after 30 days and have been returned to the sender. 
    // Or the funds have been returned because the Receiver’s account was locked.
    public $entregado = 0;
    public $fechaSolicitud;
    public $fechaEntrega;
    public $cantidad;
    public $txn_id;
    //no son parte de la bd
    public $nombreUsuario;
    public $uniqueUrl;
    public $emailPaypal;

}

?>