<?php

require_once 'modulos/cursos/clases/Pregunta.php';

function altaPregunta($pregunta) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("INSERT INTO pregunta (idUsuario, idCurso, pregunta, fecha)
                            VALUES (:idUsuario, :idCurso, :pregunta, NOW())");
    $stmt->bindParam(":idUsuario", $pregunta->idUsuario);
    $stmt->bindParam(":idCurso", $pregunta->idCurso);
    $stmt->bindParam(":pregunta", $pregunta->pregunta);
    $id = -1;
    if ($stmt->execute())
        $id = $conex->lastInsertId();
    return $id;
}

function responderPregunta($idPregunta, $respuesta) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("UPDATE pregunta 
                            SET respuesta = :respuesta, fechaRespuesta = NOW()
                            WHERE idPregunta = :id");
    $stmt->bindParam(":respuesta", $respuesta);
    $stmt->bindParam(":id", $idPregunta);
    return $stmt->execute();
}

function bajaPregunta($idPregunta) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("DELETE FROM pregunta WHERE idPregunta = :id");
    $stmt->bindParam(':id', $idPregunta);
    $stmt->execute();
    return $stmt->rowCount();
}

function getInfoParaMailRespuestaPregunta($idPregunta) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("SELECT u.email, p.pregunta 
                            FROM usuario u, pregunta p 
                            WHERE u.idUsuario = p.idUsuario
                            AND p.idPregunta = :idPregunta");
    $stmt->bindParam(':idPregunta', $idPregunta);

    $stmt->execute();
    $row = $stmt->fetch();
    return $row;
}

?>
