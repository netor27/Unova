<?php

require_once 'modulos/cursos/clases/Comentario.php';

function altaComentario($comentario){
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("INSERT INTO comentario (idUsuario, idCurso, texto, fecha)
                            VALUES (:idUsuario, :idCurso, :texto, NOW())");
    $stmt->bindParam(":idUsuario",$comentario->idUsuario);
    $stmt->bindParam(":idCurso",$comentario->idCurso);
    $stmt->bindParam(":texto",$comentario->texto);
    $id = -1;
    if($stmt->execute())
        $id = $conex->lastInsertId();
    return $id;
}

function bajaComentario($idComentario){
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("DELETE FROM comentario WHERE idComentario = :id");
    $stmt->bindParam(':id',$idComentario);
    $stmt->execute();
    return $stmt->rowCount();
}


?>
