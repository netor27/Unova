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

function generarArchivoCsv() {
    if (validarUsuarioAdministrador()) {
        if (isset($_POST['idSolicitud']) && sizeof($_POST['idSolicitud']) > 0) {
            $idSolicitudes = $_POST['idSolicitud'];
            require_once 'modulos/pagos/modelos/solicitudSaldoModelo.php';
            $solicitudes = getSolicitudesSaldo($idSolicitudes);

            if (isset($solicitudes) && sizeof($solicitudes) > 0) {
                header('Content-Type: text/csv; charset=utf-8');
                header('Content-Disposition: attachment; filename=data.csv');
                $output = fopen('php://output', 'w');
                foreach ($solicitudes as $solicitud) {
                    fputcsv($output, array($solicitud->emailPaypal, $solicitud->cantidad, "MXN", $solicitud->idSolicitudSaldo, "Depósito de saldo de la solicitud realizada " . $solicitud->fechaSolicitud));
                }
            } else {
                setSessionMessage("<h4 class='error'>Ocurrió un error al obtener las solicitudes de la base de datos</h4>");
                redirect("/administracion/saldos");
            }
        } else {
            setSessionMessage("<h4 class='error'>No hay ninguna solicitud seleccionada</h4>");
            redirect("/administracion/saldos");
        }
    } else {
        goToIndex();
    }
}

//Se dejo de utilizar esta función ya que ahora se hace desde mensajes IPN de paypal
//function solicitudPagada() {
//    if (validarUsuarioAdministrador()) {
//        $idSolicitud = $_GET['i'];
//        require_once 'modulos/pagos/modelos/solicitudSaldoModelo.php';
//        if (setSolicitudSaldoEntregado($idSolicitud)) {
//            setSessionMessage("<h4 class='success'>Se estableció como pagado correctamente</h4>");
//        } else {
//            setSessionMessage("<h4 class='error'>Ocurrió un error</h4>");
//        }
//        redirect("/administracion/saldos");
//    } else {
//        goToIndex();
//    }
//}

?>