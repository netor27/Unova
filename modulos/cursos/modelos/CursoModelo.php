<?php

require_once 'modulos/cursos/clases/Curso.php';

function altaCurso($curso) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("INSERT into curso (idUsuario, idSubcategoria, titulo, uniqueUrl, precio, descripcionCorta, fechaCreacion, keywords) 
                             values (:idUsuario, :idSubcategoria, :titulo, :uniqueUrl, 0, :descripcionCorta, NOW(), :keywords)");
    $stmt->bindParam(':idUsuario', $curso->idUsuario);
    $stmt->bindParam(':idSubcategoria', $curso->idSubcategoria);
    $stmt->bindParam(':titulo', $curso->titulo);
    $stmt->bindParam(':uniqueUrl', $curso->uniqueUrl);
    $stmt->bindParam(':descripcionCorta', $curso->descripcionCorta);
    $stmt->bindParam(':keywords', $curso->keywords);
    $id = -1;
    $val = $stmt->execute();
    if ($val) {
        $id = $conex->lastInsertId();
        $curso->idCurso = $id;
        altaCursoBusqueda($curso);
    }
    return $id;
}

function altaCursoBusqueda($curso) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("INSERT into cursobusqueda (idCurso, titulo, keywords, descripcionCorta) 
                             values (:idCurso, :titulo, :keywords, :descripcionCorta)");
    $stmt->bindParam(':idCurso', $curso->idCurso);
    $stmt->bindParam(':titulo', $curso->titulo);
    $stmt->bindParam(':keywords', $curso->keywords);
    $stmt->bindParam(':descripcionCorta', $curso->descripcionCorta);
    $id = -1;
    if (!$stmt->execute())
        print_r($stmt->errorInfo());
}

function bajaCurso($idCurso) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("DELETE FROM curso WHERE idCurso = :id");
    $stmt->bindParam(':id', $idCurso);
    $stmt->execute();
    $n = $stmt->rowCount();
    bajaCursoBusqueda($idCurso);
    return $n;
}

function bajaCursoBusqueda($idCurso) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("DELETE FROM cursobusqueda WHERE idCurso = :id");
    $stmt->bindParam(':id', $idCurso);
    $stmt->execute();
    return $stmt->rowCount();
}

function actualizaInformacionCurso($curso) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("UPDATE curso SET idSubcategoria = :idSubcategoria, titulo = :titulo, uniqueUrl = :uniqueUrl,
                             descripcionCorta = :descripcionCorta, descripcion = :descripcion, keywords = :keywords
                            WHERE idCurso = :idCurso");
    $stmt->bindParam(':idSubcategoria', $curso->idSubcategoria);
    $stmt->bindParam(':titulo', $curso->titulo);
    $stmt->bindParam(':uniqueUrl', $curso->uniqueUrl);
    $stmt->bindParam(':descripcionCorta', $curso->descripcionCorta);
    $stmt->bindParam(':descripcion', $curso->descripcion);
    $stmt->bindParam(':keywords', $curso->keywords);
    $stmt->bindParam(':idCurso', $curso->idCurso);
    if ($stmt->execute()) {
        return acutalizaInformacionCursoBusqueda($curso);
    } else {
        return false;
    }
}

function acutalizaInformacionCursoBusqueda($curso) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("UPDATE cursobusqueda SET titulo = :titulo, 
                             descripcionCorta = :descripcionCorta,
                             keywords = :keywords
                            WHERE idCurso = :idCurso");
    $stmt->bindParam(':titulo', $curso->titulo);
    $stmt->bindParam(':keywords', $curso->keywords);
    $stmt->bindParam(':descripcionCorta', $curso->descripcionCorta);
    $stmt->bindParam(':idCurso', $curso->idCurso);
    return $stmt->execute();
}

function setPublicarCurso($idCurso, $valor) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("UPDATE curso SET publicado = :valor, fechaPublicacion = NOW()
                            WHERE idCurso = :idCurso");
    $stmt->bindParam(':valor', $valor);
    $stmt->bindParam(':idCurso', $idCurso);
    return $stmt->execute();
}

function getIdUsuarioDeCurso($idCurso) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("SELECT idUsuario FROM curso where idCurso = :id");
    $stmt->bindParam(':id', $idCurso);
    $stmt->execute();
    $row = $stmt->fetch();
    $idUsuario = $row['idUsuario'];
    return $idUsuario;
}

function getUsuarioDeCurso($idCurso) {
    require_once 'bd/conex.php';
    require_once 'modulos/usuarios/clases/Usuario.php';

    global $conex;
    $stmt = $conex->prepare("SELECT u.idUsuario, u.nombreUsuario, u.avatar, u.bio, u.tituloPersonal, u.uniqueUrl, u.email
                            FROM curso c, usuario u
                            WHERE c.idUsuario = u.idUsuario AND c.idCurso = :id");
    $stmt->bindParam(':id', $idCurso);
    $stmt->execute();
    $row = $stmt->fetch();
    $usuario = new Usuario();
    $usuario->idUsuario = $row['idUsuario'];
    $usuario->nombreUsuario = $row['nombreUsuario'];
    $usuario->avatar = $row['avatar'];
    $usuario->bio = $row['bio'];
    $usuario->tituloPersonal = $row['tituloPersonal'];
    $usuario->uniqueUrl = $row['uniqueUrl'];
    $usuario->email = $row['email'];
    return $usuario;
}

function actualizaImagenCurso($curso) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("UPDATE curso SET imagen = :imagen
                            WHERE idCurso = :idCurso");
    $stmt->bindParam(':imagen', $curso->imagen);
    $stmt->bindParam(':idCurso', $curso->idCurso);
    return $stmt->execute();
}

function getCurso($idCurso) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("SELECT * FROM curso where idCurso = :id");
    $stmt->bindParam(':id', $idCurso);

    $stmt->execute();
    $curso = NULL;
    if ($stmt->rowCount() == 1) {
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

function getCursoFromUniqueUrl($cursoUrl) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("SELECT * FROM curso where uniqueUrl = :uniqueUrl");
    $stmt->bindParam(':uniqueUrl', $cursoUrl);

    $stmt->execute();
    $curso = NULL;
    if ($stmt->rowCount() == 1) {
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
        $curso->publicado = $row['publicado'];
    }
    return $curso;
}

function getCursos($offset, $numRows) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("SELECT * FROM curso LIMIT :offset, :numRows");
    $stmt->bindParam(':offset', $offset);
    $stmt->bindParam(':numRows', $numRows);
    $stmt->execute();
    $rows = $stmt->fetchAll();
    $cursos = null;
    $curso = null;
    $i = 0;
    foreach ($rows as $row) {
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

        $cursos[$i] = $curso;
        $i++;
    }
    return $cursos;
}

function getAllCursos(){
     require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("SELECT * FROM curso");
    $stmt->execute();
    $rows = $stmt->fetchAll();
    $cursos = null;
    $curso = null;
    $i = 0;
    foreach ($rows as $row) {
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
        $curso->totalViews = $row['totalViews'];
        $curso->fechaCreacion = $row['fechaCreacion'];
        $curso->fechaPublicacion = $row['fechaPublicacion'];
        $curso->publicado = $row['publicado'];
        $curso->rating = $row['rating'];
        $curso->totalReportes = $row['totalReportes'];

        $cursos[$i] = $curso;
        $i++;
    }
    return $cursos;
}

function getCursosFuncion() {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("SELECT SQL_CALC_FOUND_ROWS c.idCurso, c.idUsuario, c.idSubcategoria, c.titulo, c.uniqueUrl, c.precio, c.imagen, u.nombreUsuario, u.uniqueUrl as uniqueUrlUsuario,
                                count(distinct cl.idClase) as numClases, count(distinct uc.idUsuario) as numAlumnos, 
                                c.keywords, c.descripcionCorta
                            FROM curso c
                            INNER JOIN cursobusqueda cb ON c.idCurso = cb.idCurso
                            LEFT OUTER JOIN tema t ON c.idCurso = t.idCurso
                            LEFT OUTER JOIN clase cl ON t.idTema = cl.idTema
                            LEFT OUTER JOIN usuariocurso uc ON c.idCurso = uc.idCurso
                            LEFT OUTER JOIN usuario u ON c.idUsuario = u.idUsuario
                            WHERE c.publicado = 1
                            GROUP BY c.idCurso
                            ORDER BY c.rating DESC");

    if (!$stmt->execute())
        print_r($stmt->errorInfo());
    $rows = $stmt->fetchAll();

    $r = $conex->query("SELECT FOUND_ROWS() as numero")->fetch();
    $n = $r['numero'];


    $cursos = null;
    $curso = null;
    $i = 0;
    foreach ($rows as $row) {
        $curso = new Curso();
        $curso->idCurso = $row['idCurso'];
        $curso->idUsuario = $row['idUsuario'];
        $curso->idSubcategoria = $row['idSubcategoria'];
        $curso->titulo = $row['titulo'];
        $curso->uniqueUrl = $row['uniqueUrl'];
        $curso->precio = $row['precio'];
        $curso->imagen = $row['imagen'];
        $curso->nombreUsuario = $row['nombreUsuario'];
        $curso->numeroDeClases = $row['numClases'];
        $curso->numeroDeAlumnos = $row['numAlumnos'];
        $curso->keywords = $row['keywords'];
        $curso->descripcionCorta = $row['descripcionCorta'];
        $curso->uniqueUrlUsuario = $row['uniqueUrlUsuario'];
        $cursos[$i] = $curso;
        $i++;
    }
    $array = array(
        "n" => $n,
        "cursos" => $cursos
    );
    return $array;
}

function getCursosGratis($offset, $numRows) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("SELECT * FROM curso 
                            WHERE precio = 0
                            LIMIT :offset, :numRows");
    $stmt->bindParam(':offset', $offset);
    $stmt->bindParam(':numRows', $numRows);
    $stmt->execute();
    $rows = $stmt->fetchAll();
    $cursos = null;
    $curso = null;
    $i = 0;
    foreach ($rows as $row) {
        $curso = new Curso();
        $curso->idCurso = $row['idCurso'];
        $curso->idUsuario = $row['idUsuario'];
        $curso->idSubcategoria = $row['idSubcategoria'];
        $curso->titulo = $row['titulo'];
        $curso->uniqueUrl = $row['uniqueUrl'];
        $curso->precio = $row['precio'];
        $curso->descripcionCorta = $row['descripcionCorta'];
        $curso->descripcion = $row['descripcion'];
        $curso->fechaPublicacion = $row['fechaPublicacion'];
        $curso->keywords = $row['keywords'];

        $cursos[$i] = $curso;
        $i++;
    }
    return $cursos;
}

function getTemas($idCurso) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("SELECT idTema, idCurso, nombre 
                             FROM tema
                             WHERE idCurso = :idCurso
                             ORDER BY idTema ASC");
    $stmt->bindParam(":idCurso", $idCurso);
    $stmt->execute();
    $rows = $stmt->fetchAll();
    require_once 'modulos/cursos/clases/Tema.php';
    $temas = null;
    $tema = null;
    $i = 0;
    foreach ($rows as $row) {
        $tema = new Tema();
        $tema->idTema = $row['idTema'];
        $tema->idCurso = $row['idCurso'];
        $tema->nombre = $row['nombre'];

        $temas[$i] = $tema;
        $i++;
    }
    return $temas;
}

function getClases($idCurso) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("SELECT c.idClase, c.idTema, c.titulo, c.orden, c.idTipoClase, c.transformado, c.views, c.duracion
                            FROM clase c, tema t
                            WHERE c.idTema = t.idTema AND t.idCurso = :id
                            ORDER BY  t.idTema, orden ASC ");
    $stmt->bindParam(':id', $idCurso);
    if (!$stmt->execute())
        print_r($stmt->errorInfo());
    $rows = $stmt->fetchAll();
    require_once 'modulos/cursos/clases/Clase.php';
    $clases = null;
    $clase = null;
    $i = 0;
    foreach ($rows as $row) {
        $clase = new Clase();
        $clase->idClase = $row['idClase'];
        $clase->idTema = $row['idTema'];
        $clase->titulo = $row['titulo'];
        $clase->idTipoClase = $row['idTipoClase'];
        $clase->orden = $row['orden'];
        $clase->transformado = $row['transformado'];
        $clase->view = $row['views'];
        $clase->duracion = $row['duracion'];

        $clases[$i] = $clase;
        $i++;
    }
    return $clases;
}

function getNumeroDeAlumnos($idCurso) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("SELECT count(idUsuario) as cuenta
                             FROM usuariocurso
                             WHERE idCurso = :id");
    $stmt->bindParam(":id", $idCurso);
    $stmt->execute();
    $row = $stmt->fetch();
    return $row['cuenta'];
}

function getComentarios($idCurso) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("SELECT c.idComentario, c.idUsuario, c.idCurso, c.texto, u.nombreUsuario, u.avatar, u.uniqueUrl, c.fecha
                            FROM comentario c, usuario u
                            WHERE c.idUsuario = u.idUsuario AND c.idCurso = :id
                            ORDER BY c.fecha DESC, c.idComentario DESC");
    $stmt->bindParam(":id", $idCurso);
    $stmt->execute();
    $rows = $stmt->fetchAll();
    require_once 'modulos/cursos/clases/Comentario.php';
    $comentarios = null;
    $comentario = null;
    $i = 0;
    foreach ($rows as $row) {
        $comentario = new Comentario();
        $comentario->idComentario = $row['idComentario'];
        $comentario->idUsuario = $row['idUsuario'];
        $comentario->idCurso = $row['idCurso'];
        $comentario->texto = $row['texto'];
        $comentario->nombreUsuario = $row['nombreUsuario'];
        $comentario->avatar = $row['avatar'];
        $comentario->fecha = $row['fecha'];
        $comentario->uniqueUrlUsuario = $row['uniqueUrl'];
        $comentarios[$i] = $comentario;
        $i++;
    }
    return $comentarios;
}

function getPreguntas($idCurso) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("SELECT p.idPregunta, p.idCurso, p.idUsuario, p.pregunta, p.respuesta, p.fecha, p.fechaRespuesta, u.nombreUsuario, u.uniqueUrl, u.avatar
                            FROM pregunta p, usuario u
                            WHERE p.idUsuario = u.idUsuario AND p.idCurso = :id
                            ORDER BY p.fecha DESC, p.idPregunta DESC");
    $stmt->bindParam(":id", $idCurso);
    $stmt->execute();

    $rows = $stmt->fetchAll();
    require_once 'modulos/cursos/clases/Pregunta.php';
    $preguntas = null;
    $pregunta = null;
    $i = 0;
    foreach ($rows as $row) {
        $pregunta = new Pregunta();
        $pregunta->idPregunta = $row['idPregunta'];
        $pregunta->idUsuario = $row['idUsuario'];
        $pregunta->idCurso = $row['idCurso'];
        $pregunta->pregunta = $row['pregunta'];
        $pregunta->respuesta = $row['respuesta'];
        $pregunta->fechaRespuesta = $row['fechaRespuesta'];
        $pregunta->nombreUsuario = $row['nombreUsuario'];
        $pregunta->avatar = $row['avatar'];
        $pregunta->fecha = $row['fecha'];
        $pregunta->uniqueUrlUsuario = $row['uniqueUrl'];
        $preguntas[$i] = $pregunta;
        $i++;
    }
    return $preguntas;
}

function elTituloEsUnico($uniqueUrl) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("SELECT idCurso FROM curso where uniqueUrl = :uniqueUrl");
    $stmt->bindParam(':uniqueUrl', $uniqueUrl);

    $stmt->execute();
    return ($stmt->rowCount() == 0);
}

function sumarTotalView($idCurso) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("UPDATE curso 
                            SET totalViews = totalViews + 1
                            WHERE idCurso = :idCurso");
    $stmt->bindParam(':idCurso', $idCurso);
    return $stmt->execute();
}

function sumarTotalReportes($idCurso){
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("UPDATE curso 
                            SET totalReportes = totalReportes + 1
                            WHERE idCurso = :idCurso");
    $stmt->bindParam(':idCurso', $idCurso);
    return $stmt->execute();
}

?>