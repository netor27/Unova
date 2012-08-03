<?php

require_once 'modulos/pagos/clases/Operacion.php';

function altaOperacion($operacion) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("INSERT into operacion (idTipoOperacion, idUsuario, detalle, cantidad) values(:idTipoOperacion, :idUsuario,:detalle,:cantidad)");
    $stmt->bindParam(':idTipoOperacion', $operacion->idTipoOperacion);
    $stmt->bindParam(':idUsuario', $operacion->idUsuario);
    $stmt->bindParam(':detalle', $operacion->detalle);
    $stmt->bindParam(':cantidad', $operacion->cantidad);


    $id = -1;

    if ($stmt->execute())
        $id = $conex->lastInsertId();
    else {
        print_r($stmt->errorInfo());
    }
    return $id;
}

function getOperaciones() {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->query("SELECT * FROM operacion");
    $operaciones = null;
    $operacion = null;
    $i = 0;
    foreach ($stmt as $row) {
        $operacion = new Operacion();
        $operacion->idOperacion = $row['idOperacion'];
        $operacion->idTipoOperacion = $row['idTipoOperacion'];
        $operacion->idUsuario = $row['idUsuario'];
        $operacion->fecha = $row['fecha'];
        $operacion->cantidad = $row['cantidad'];
        $operacion->detalle = $row['detalle'];

        $operaciones[$i] = $operacion;
        $i++;
    }
    return $operaciones;
}

function getUltimasOperacionesPorUsuario($n, $idUsuario) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("SELECT * FROM operacion 
                            WHERE idUsuario = :idUsuario
                            ORDER BY fecha DESC
                            LIMIT $n");
    $stmt->bindParam(':idUsuario', $idUsuario);
    $stmt->execute();
    $operaciones = null;
    $operacion = null;
    $i = 0;
    foreach ($stmt as $row) {
        $operacion = new Operacion();
        $operacion->idOperacion = $row['idOperacion'];
        $operacion->idTipoOperacion = $row['idTipoOperacion'];
        $operacion->idUsuario = $row['idUsuario'];
        $operacion->fecha = $row['fecha'];
        $operacion->cantidad = $row['cantidad'];
        $operacion->detalle = $row['detalle'];

        $operaciones[$i] = $operacion;
        $i++;
    }
    return $operaciones;
}

?>
