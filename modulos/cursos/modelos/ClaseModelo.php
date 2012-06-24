<?php

require_once 'modulos/cursos/clases/Clase.php';

function altaClase($clase) {
    require_once 'bd/conexWrite.php';
    global $conex;
    $stmt = $conex->prepare("INSERT INTO clase (idTema, titulo, idTipoClase, archivo, transformado)
                             VALUES(:idTema, :titulo, :tipoClase, :archivo, :transformado)");
    $stmt->bindParam(':idTema', $clase->idTema);
    $stmt->bindParam(':titulo', $clase->titulo);
    $stmt->bindParam(':tipoClase', $clase->idTipoClase);
    $stmt->bindParam(':archivo', $clase->archivo);
    $stmt->bindParam(':transformado', $clase->transformado);
    $id = -1;
    if ($stmt->execute())
        $id = $conex->lastInsertId();
    else {
        print_r($stmt->errorInfo());
    }
    return $id;
}

function bajaClase($idClase) {
    require_once 'bd/conexWrite.php';
    global $conex;
    $stmt = $conex->prepare("DELETE FROM clase WHERE idClase = :id");
    $stmt->bindParam(':id', $idClase);
    $stmt->execute();
    return $stmt->rowCount();
}

function actualizaInformacionClase($clase) {
    require_once 'bd/conexWrite.php';
    global $conex;
    $stmt = $conex->prepare("UPDATE clase 
                            SET titulo = :titulo, descripcion = :descripcion
                            WHERE idClase = :idClase");
    $stmt->bindParam(':titulo', $clase->titulo);
    $stmt->bindParam(':descripcion', $clase->descripcion);
    $stmt->bindParam(':idClase', $clase->idClase);
    return $stmt->execute();
}

function actualizaDuracionClase($idClase, $duration) {
    require_once 'bd/conexWrite.php';
    global $conex;
    $stmt = $conex->prepare("UPDATE clase SET duracion = :duracion
                            WHERE idClase = :idClase");
    $stmt->bindParam(':duracion', $duration);
    $stmt->bindParam(':idClase', $idClase);
    return $stmt->execute();
}

function actualizaCodigoClase($idClase,$codigo) {
    require_once 'bd/conexWrite.php';
    global $conex;
    $stmt = $conex->prepare("UPDATE clase SET codigo = :codigo
                            WHERE idClase = :idClase");
    $stmt->bindParam(':codigo', $codigo);
    $stmt->bindParam(':idClase', $idClase);
    return $stmt->execute();
}

function actualizaOrdenClase($idClase, $idTema, $orden) {
    require_once 'bd/conexWrite.php';
    global $conex;
    $stmt = $conex->prepare("UPDATE clase 
                            SET orden = :orden, idTema = :idTema
                            WHERE idClase = :idClase");
    $stmt->bindParam(':orden', $orden);
    $stmt->bindParam(':idTema', $idTema);
    $stmt->bindParam(':idClase', $idClase);
    return $stmt->execute();
}

function actualizaArchivosDespuesTransformacion($idClase, $archivo, $archivo2) {
    require_once 'bd/conexWrite.php';
    global $conex;
    $stmt = $conex->prepare("UPDATE clase 
                            SET transformado = 1, archivo = :archivo , archivo2 = :archivo2
                            WHERE idClase = :idClase");
    $stmt->bindParam(':archivo', $archivo);
    $stmt->bindParam(':archivo2', $archivo2);
    $stmt->bindParam(':idClase', $idClase);
    return $stmt->execute();
}

function getClase($idClase) {
    require_once 'bd/conexRead.php';
    global $conex;
    $stmt = $conex->prepare("SELECT * FROM clase where idClase = :idClase");
    $stmt->bindParam(':idClase', $idClase);
    $stmt->execute();
    $clase = NULL;
    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch();
        $clase = new Clase();
        $clase->idClase = $row['idClase'];
        $clase->idTema = $row['idTema'];
        $clase->idTipoClase = $row['idTipoClase'];
        $clase->titulo = $row['titulo'];
        $clase->orden = $row['orden'];
        $clase->codigo = $row['codigo'];
        $clase->descripcion = $row['descripcion'];
        $clase->archivo = $row['archivo'];
        $clase->archivo2 = $row['archivo2'];
        $clase->transformado = $row['transformado'];
        $clase->view = $row['views'];
        $clase->duracion = $row['duracion'];
    }
    return $clase;
}

function getTiposClase() {
    require_once 'bd/conexRead.php';
    global $conex;
    $stmt = $conex->prepare("SELECT * FROM tipoclase");
    $stmt->execute();
    $rows = $stmt->fetchAll();
    $tiposClase = null;
    $i = 0;
    foreach ($rows as $row) {
        require_once 'modulos/cursos/clases/TipoClase.php';
        $tipoClase = new TipoClase();
        $tipoClase->idTipoClase = $row['idTipoClase'];
        $tipoClase->nombre = $row['nombre'];
        $tipoClase->descripcion = $row['descripcion'];
        $tipoClase->imagen = $row['imagen'];
        $tiposClase[$i] = $tipoClase;
        $i++;
    }
    return $tiposClase;
}

function clasePerteneceACurso($idCurso, $idClase) {
    require_once 'bd/conexRead.php';
    global $conex;
    $stmt = $conex->prepare("Select c.idCurso, cl.idClase
                             FROM curso c, tema t, clase cl
                             WHERE c.idCurso = t.idCurso AND t.idTema = cl.idTema 
                             AND c.idCurso = :idCurso AND cl.idClase = :idClase");
    $stmt->bindParam(":idCurso", $idCurso);
    $stmt->bindParam(":idClase", $idClase);
    $stmt->execute();
    if ($stmt->rowCount() == 1) {
        return true;
    } else {
        return false;
    }
}

function getCursoPerteneciente($idClase) {
    require_once 'bd/conexRead.php';
    global $conex;
    $stmt = $conex->prepare("Select c.idCurso, c.idUsuario, c.idSubcategoria, c.titulo, c.uniqueUrl, c.precio, c.descripcionCorta, c.descripcion, c.imagen, c.rating, c.keywords
                             FROM curso c, tema t, clase cl
                             WHERE c.idCurso = t.idCurso AND t.idTema = cl.idTema 
                             AND cl.idClase = :idClase");
    $stmt->bindParam(":idClase", $idClase);
    $curso = NULL;
    if ($stmt->execute()) {
        $row = $stmt->fetch();
        $curso = new Curso();
        $curso->idCurso = $row['idCurso'];
        $curso->idUsuario = $row['idUsuario'];
        $curso->idSubcategoria = $row['idSubcategoria'];
        $curso->titulo = $row['titulo'];
        $curso->uniqueUrl = $row['uniqueUrl'];
        $curso->precio = $row['precio'];
        $curso->descripcionCorta = $row['descripcionCorta'];
        $curso->descripcion = $row['descripcion'];
        $curso->keywords = $row['keywords'];
        $curso->imagen = $row['imagen'];
        $curso->rating = $row['rating'];
    }
    return $curso;
}

function sumarVistaClase($idClase) {
    require_once 'bd/conexWrite.php';
    global $conex;
    $stmt = $conex->prepare("UPDATE clase 
                            SET views = views + 1
                            WHERE idClase = :idClase");
    $stmt->bindParam(':idClase', $idClase);
    return $stmt->execute();
}

?>
