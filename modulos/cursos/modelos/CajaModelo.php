<?php

function agregarTarjetas($idCaja, $tarjetas) {
    $res = 1;
    require_once 'bd/conexWrite.php';
    global $conex;
    $stmt = $conex->prepare("INSERT INTO tarjeta (idCaja, ladoA, ladoB, tiempo)
                             VALUES(:idCaja, :ladoA, :ladoB, :tiempo)");
    foreach ($tarjetas as $tarjeta) {
        $stmt->bindParam(':idCaja', $idCaja);
        $stmt->bindParam(':ladoA', $tarjeta[0]);
        $stmt->bindParam(':ladoB', $tarjeta[1]);
        $stmt->bindParam(':tiempo', $tarjeta[2]);
        if (!$stmt->execute()) {
            print_r($stmt->errorInfo());
            $res = -1;
        }
    }
    return $res;
}

?>
