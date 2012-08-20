<?php

function agregarTarjetasDesdeCSV($idCaja, $archivoCsv) {
    $res = array();
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("INSERT INTO tarjeta (idCaja, ladoA, ladoB, tiempo)
                             VALUES(:idCaja, :ladoA, :ladoB, :tiempo)");
    $stmt->bindParam(':idCaja', $idCaja);
    $fila = 0;
    $insertados = 0;
    $error = 0;
    $errores = array();
    if (($gestor = fopen($archivoCsv, "r")) !== FALSE) {
        while (($datos = fgetcsv($gestor)) !== FALSE) {
            $fila++;
            if (count($datos) == 3) {
                $stmt->bindParam(':ladoA', $datos[0]);
                $stmt->bindParam(':ladoB', $datos[1]);
                $stmt->bindParam(':tiempo', $datos[2]);
                if (!$stmt->execute()) {
                    print_r($stmt->errorInfo());
                    $errores[$error] = "Error al insertar la fila " . $fila . " en la bd.";
                    $error++;
                }else{
                    $insertados++;
                }
            } else {
                //Error numero de datos en la fila
                $errores[$error] = "Error en la fila " . $fila . " datos no válidos";
                $error++;
            }
        }
        fclose($gestor);
        $res['resultado'] = 1;
        $res['insertados'] = $insertados;
    } else {
        $errores[0] = "Error al leer el archivo " . $archivoCsv;
        $res['resultado'] = -1;
        $res['errores'] = $errores;
    }
    return $res;
}

?>