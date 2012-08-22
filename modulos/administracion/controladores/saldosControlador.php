<?php

function principal() {
    if (validarUsuarioAdministrador()) {
        require_once 'modulos/pagos/modelos/solicitudSaldoModelo.php';
        $solicitudesDeSaldo = getSolicitudesSaldoNoEntregado();
        require_once 'modulos/administracion/vistas/solicitudesSaldo.php';
    } else {
        goToIndex();
    }
}

function solicitudPagada() {
    if (validarUsuarioAdministrador()) {
        $idSolicitud = $_GET['i'];
        require_once 'modulos/pagos/modelos/solicitudSaldoModelo.php';
        if(setSolicitudSaldoEntregado($idSolicitud)){
            setSessionMessage("<h4 class='success'>Se estableció como pagado correctamente</h4>");
        }else{
            setSessionMessage("<h4 class='error'>Ocurrió un error</h4>");
        }
        redirect("/administracion/saldos");
    } else {
        goToIndex();
    }
}

?>