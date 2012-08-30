<?php

function principal() {
    if (validarUsuarioAdministrador()) {
        // Con esto podemos ver el status de la cola de mensajes
        require_once('lib/php/beanstalkd/ColaMensajes.php');
        $colaMensajes = new ColaMensajes("transformarvideos");
        $colaMensajes->printStats();
    }
}

?>