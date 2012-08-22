<?php

class SolicitudSaldo{
    public $idSolicitudSaldo;
    public $idUsuario;
    public $entregado = 0;
    public $fechaSolicitud;
    public $fechaEntrega;
    public $cantidad;           
    
    //no son parte de la bd
    public $nombreUsuario;
    public $uniqueUrl;
    public $email;
    
}
?>