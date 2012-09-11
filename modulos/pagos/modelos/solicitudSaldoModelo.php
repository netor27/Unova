<?php

require_once 'modulos/pagos/clases/SolicitudSaldo.php';

function altaSolicitudSaldo($solicitud) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("INSERT into solicitudSaldo 
                            (idUsuario, entregado, fechaSolicitud, cantidad) 
                      values(:idUsuario, :entregado, NOW(), :cantidad)");
    $stmt->bindParam(':idUsuario', $solicitud->idUsuario);
    $stmt->bindParam(':entregado', $solicitud->entregado);
    $stmt->bindParam(':cantidad', $solicitud->cantidad);
    $id = -1;
    if ($stmt->execute())
        $id = $conex->lastInsertId();
    else {
        print_r($stmt->errorInfo());
    }
    return $id;
}

function bajaSolicitudSaldo($idSolicitud) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("DELETE FROM solicitudSaldo 
                            WHERE idSolicitudSaldo = :idSolicitudSaldo");
    $stmt->bindParam(':idSolicitudSaldo', $idSolicitud);
    return $stmt->execute();
}

function setSolicitudSaldoEntregado($idSolicitud) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("UPDATE solicitudSaldo 
                            SET fechaEntrega = NOW(), entregado = 1
                            WHERE idSolicitudSaldo = :idSolicitudSaldo");
    $stmt->bindParam(':idSolicitudSaldo', $idSolicitud);
    return $stmt->execute();
}

function getSolicitudSaldo($idSolicitud) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("SELECT * FROM solicitudSaldo WHERE idSolicitudSaldo = :idSolicitudSaldo");
    $stmt->bindParam(':idSolicitudSaldo', $idSolicitud);
    $stmt->execute();
    $solicitudSaldo = NULL;
    if ($stmt->rowCount() == 1) {
        $row = $stmt->fetch();
        $solicitudSaldo = new SolicitudSaldo();
        $solicitudSaldo->idSolicitudSaldo = $row['idSolicitudSaldo'];
        $solicitudSaldo->cantidad = $row['cantidad'];
        $solicitudSaldo->entregado = $row['entregado'];
        $solicitudSaldo->fechaEntrega = $row['fechaEntrega'];
        $solicitudSaldo->fechaSolicitud = $row['fechaSolicitud'];
        $solicitudSaldo->idUsuario = $row['idUsuario'];
    }
    return $solicitudSaldo;
}

function getSolicitudesSaldoNoEntregado() {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->query("SELECT s.idSolicitudSaldo, s.cantidad, s.entregado, 
                        s.fechaEntrega, s.fechaSolicitud, s.idUsuario,
                        u.emailPaypal, u.nombreUsuario, u.uniqueUrl
                        FROM solicitudSaldo s, usuario u
                        WHERE s.idUsuario = u.idUsuario
                        AND entregado = 0");
    $solicitudSaldos = array();
    $solicitudSaldo = null;
    $i = 0;
    foreach ($stmt as $row) {
        $solicitudSaldo = new SolicitudSaldo();
        $solicitudSaldo->idSolicitudSaldo = $row['idSolicitudSaldo'];
        $solicitudSaldo->cantidad = $row['cantidad'];
        $solicitudSaldo->entregado = $row['entregado'];
        $solicitudSaldo->fechaEntrega = $row['fechaEntrega'];
        $solicitudSaldo->fechaSolicitud = $row['fechaSolicitud'];
        $solicitudSaldo->idUsuario = $row['idUsuario'];
        $solicitudSaldo->emailPaypal = $row['emailPaypal'];
        $solicitudSaldo->nombreUsuario = $row['nombreUsuario'];
        $solicitudSaldo->uniqueUrl = $row['uniqueUrl'];
        $solicitudSaldos[$i] = $solicitudSaldo;
        $i++;
    }

    return $solicitudSaldos;
}

function getSolicitudesSaldo($arrayIdSolicitudes) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("SELECT s.idSolicitudSaldo, s.cantidad, s.entregado, 
                        s.fechaEntrega, s.fechaSolicitud, s.idUsuario,
                        u.emailPaypal, u.nombreUsuario, u.uniqueUrl
                        FROM solicitudSaldo s, usuario u
                        WHERE s.idUsuario = u.idUsuario
                        AND s.idSolicitudSaldo = :idSolicitudSaldo
                        AND entregado = 0");
    $solicitudSaldos = array();
    $i = 0;
    foreach ($arrayIdSolicitudes as $id) {
        $stmt->bindParam(':idSolicitudSaldo', $id);
        $stmt->execute();
        $solicitudSaldo = NULL;
        if ($stmt->rowCount() == 1) {
            $row = $stmt->fetch();
            $solicitudSaldo = new SolicitudSaldo();
            $solicitudSaldo->idSolicitudSaldo = $row['idSolicitudSaldo'];
            $solicitudSaldo->cantidad = $row['cantidad'];
            $solicitudSaldo->entregado = $row['entregado'];
            $solicitudSaldo->fechaEntrega = $row['fechaEntrega'];
            $solicitudSaldo->fechaSolicitud = $row['fechaSolicitud'];
            $solicitudSaldo->idUsuario = $row['idUsuario'];
            $solicitudSaldo->emailPaypal = $row['emailPaypal'];
            $solicitudSaldo->nombreUsuario = $row['nombreUsuario'];
            $solicitudSaldo->uniqueUrl = $row['uniqueUrl'];
        }
        $solicitudSaldos[$i] = $solicitudSaldo;
        $i++;
    }
    return $solicitudSaldos;
}
?>