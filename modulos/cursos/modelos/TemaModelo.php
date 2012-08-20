<?php

require_once 'modulos/cursos/clases/Curso.php';
require_once 'modulos/cursos/clases/Tema.php';

function altaTema($tema) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("INSERT INTO tema (idCurso, nombre) 
                            VALUES (:idCurso, :nombre)");
    $stmt->bindParam(":idCurso", $tema->idCurso);
    $stmt->bindParam(":nombre", $tema->nombre);
    $id = -1;
    if ($stmt->execute()) {
        $id = $conex->lastInsertId();        
    } else {
        print_r($stmt->errorInfo());
    }
    return $id;
}

function bajaTema($idTema) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("DELETE FROM tema WHERE idTema = :id");
    $stmt->bindParam(':id', $idTema);
    $stmt->execute();
    return $stmt->rowCount();
}

function actualizaTema($tema) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("UPDATE tema SET nombre = :nombre
                             WHERE idTema = :idTema");
    $stmt->bindParam(':nombre', $tema->nombre);
    $stmt->bindParam(':idTema', $tema->idTema);
    return $stmt->execute();
}

function getTema($idTema) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("SELECT * FROM tema where idTema = :id");
    $stmt->bindParam(':id', $idTema);
    $stmt->execute();
    $tema = NULL;
    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch();
        $tema = new Tema();
        $tema->idCurso = $row['idCurso'];
        $tema->idTema = $row['idTema'];
        $tema->nombre = $row['nombre'];
    }
    return $tema;
}

function numeroDeClasesDelTema($idTema) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("SELECT count(*) as cuenta
                             FROM clase 
                             WHERE idTema = :id");
    $stmt->bindParam(":id", $idTema);
    $stmt->execute();
    $row = $stmt->fetch();
    return $row['cuenta'];
}

function getIdCursoPerteneciente($idTema) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("SELECT idCurso FROM tema WHERE idTema = :idTema");
    $stmt->bindParam(":idTema", $idTema);
    if ($stmt->execute()) {
        $row = $stmt->fetch();
        return $row['idCurso'];
    } else {
        return -1;
    }
}

?>