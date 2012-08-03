<?php

require_once 'modulos/usuarios/clases/Usuario.php';

function getCursosInscrito($idUsuario, $offset, $numRows) {
    require_once 'bd/conex.php';
    global $conex;

    $stmt = $conex->prepare("SELECT c.idCurso, c.titulo, c.uniqueUrl, c.imagen, uc.fechaInscripcion
                                 FROM curso c, usuariocurso uc
                                 WHERE uc.idUsuario = :idUsuario AND c.idCurso = uc.idCurso
                                 ORDER BY uc.fechaInscripcion 
                                 LIMIT $offset, $numRows");
    $stmt->bindParam(':idUsuario', $idUsuario);


    if ($stmt->execute()) {
        $cursos = null;
        $curso = null;
        $rows = $stmt->fetchAll();
        $i = 0;
        foreach ($rows as $row) {
            $curso = new Curso();
            $curso->idCurso = $row['idCurso'];
            $curso->titulo = $row['titulo'];
            $curso->uniqueUrl = $row['uniqueUrl'];
            $curso->imagen = $row['imagen'];
            $cursos[$i] = $curso;
            $i++;
        }
        return $cursos;
    }
    return null;
}

function getCursosInstructor($idUsuario, $offset, $numRows) {
    require_once 'bd/conex.php';
    global $conex;

    $stmt = $conex->prepare("SELECT c.idCurso, c.titulo, c.uniqueUrl, c.imagen, c.fechaPublicacion
                                 FROM curso c
                                 WHERE c.idUsuario = :idUsuario 
                                 ORDER BY c.fechaCreacion
                                 LIMIT $offset, $numRows");
    $stmt->bindParam(':idUsuario', $idUsuario);

    if ($stmt->execute()) {
        $cursos = null;
        $curso = null;
        $rows = $stmt->fetchAll();
        $i = 0;
        foreach ($rows as $row) {
            $curso = new Curso();
            $curso->idCurso = $row['idCurso'];
            $curso->titulo = $row['titulo'];
            $curso->imagen = $row['imagen'];
            $curso->uniqueUrl = $row['uniqueUrl'];
            $cursos[$i] = $curso;
            $i++;
        }
        return $cursos;
    } else {
        return null;
    }
}

function getCursosInscritoDetalles($idUsuario, $orderBy, $orderAscDesc) {
    require_once 'bd/conex.php';
    global $conex;
    $auxOrder = "";
    if ($orderBy == "fechaInscripcion")
        $auxOrder = " uc.fechaInscripcion " . $orderAscDesc . " ";
    else if ($orderBy == "titulo")
        $auxOrder = " c.titulo " . $orderAscDesc . " ";

    $stmt = $conex->prepare("Select u.idUsuario, u.nombreUsuario, u.uniqueUrl as uniqueUrlUsuario, c.imagen, c.descripcionCorta,  c.idCurso, c.titulo, c.uniqueUrl, uc.fechaInscripcion, count(distinct uc.idUsuario) as numAlumnos, count(distinct cl.idClase) as numClases
                            From curso c
                            INNER JOIN usuario u ON c.idUsuario = u.idUsuario
                            LEFT OUTER JOIN tema t ON c.idCurso = t.idCurso
                            LEFT OUTER JOIN clase cl ON t.idTema = cl.idTema
                            LEFT OUTER JOIN usuariocurso uc ON c.idCurso = uc.idCurso
                            where c.idCurso IN (
                                select idCurso
                                from usuariocurso
                                where idUsuario = :idUsuario
                            )
                            group by c.idCurso
                            order by $auxOrder ");
    $stmt->bindParam(':idUsuario', $idUsuario);

    if ($stmt->execute()) {
        $cursos = null;
        $curso = null;
        $rows = $stmt->fetchAll();
        $i = 0;
        foreach ($rows as $row) {
            $curso = new Curso();
            $curso->idCurso = $row['idCurso'];
            $curso->idUsuario = $row['idUsuario'];
            $curso->nombreUsuario = $row['nombreUsuario'];
            $curso->imagen = $row['imagen'];
            $curso->titulo = $row['titulo'];
            $curso->fechaInscripcion = $row['fechaInscripcion'];
            $curso->numeroDeAlumnos = $row['numAlumnos'];
            $curso->numeroDeClases = $row['numClases'];
            $curso->descripcionCorta = $row['descripcionCorta'];
            $curso->uniqueUrl = $row['uniqueUrl'];
            $curso->uniqueUrlUsuario = $row['uniqueUrlUsuario'];
            $cursos[$i] = $curso;
            $i++;
        }
        return $cursos;
    } else {
        //print_r($stmt->errorInfo());
        return null;
    }
}

function getCursosInstructorDetalles($idUsuario, $orderBy, $orderAscDesc) {
    require_once 'bd/conex.php';
    global $conex;
    $auxOrder = "";
    if ($orderBy == "fechaCreacion")
        $auxOrder = " c.fechaCreacion " . $orderAscDesc . " ";
    else if ($orderBy == "titulo")
        $auxOrder = " c.titulo " . $orderAscDesc . " ";

    $stmt = $conex->prepare("Select u.idUsuario, u.nombreUsuario, u.uniqueUrl as uniqueUrlUsuario, c.idCurso, c.descripcionCorta, c.titulo, c.uniqueUrl, c.publicado, c.precio, c.imagen, c.fechaCreacion, count(distinct uc.idUsuario) as numAlumnos, count(distinct cl.idClase) as numClases
                            From curso c
                            INNER JOIN usuario u ON c.idUsuario = u.idUsuario
                            LEFT OUTER JOIN tema t ON c.idCurso = t.idCurso
                            LEFT OUTER JOIN clase cl ON t.idTema = cl.idTema
                            LEFT OUTER JOIN usuariocurso uc ON c.idCurso = uc.idCurso
                            where u.idUsuario = :idUsuario
                            group by c.idCurso
                            order by $auxOrder");
    $stmt->bindParam(':idUsuario', $idUsuario);

    if ($stmt->execute()) {
        $cursos = null;
        $curso = null;
        $rows = $stmt->fetchAll();
        $i = 0;
        foreach ($rows as $row) {
            $curso = new Curso();
            $curso->idCurso = $row['idCurso'];
            $curso->titulo = $row['titulo'];
            $curso->publicado = $row['publicado'];
            $curso->precio = $row['precio'];
            $curso->imagen = $row['imagen'];
            $curso->fechaCreacion = $row['fechaCreacion'];
            $curso->numeroDeAlumnos = $row['numAlumnos'];
            $curso->numeroDeClases = $row['numClases'];
            $curso->descripcionCorta = $row['descripcionCorta'];
            $curso->uniqueUrl = $row['uniqueUrl'];
            $curso->idUsuario = $row['idUsuario'];
            $curso->nombreUsuario = $row['nombreUsuario'];
            $curso->uniqueUrlUsuario = $row['uniqueUrlUsuario'];
            $cursos[$i] = $curso;
            $i++;
        }
        return $cursos;
    } else {
        return null;
    }
}

function getCursosInstructorDetallesPublicados($idUsuario, $orderBy, $orderAscDesc) {
    require_once 'bd/conex.php';
    global $conex;
    $auxOrder = "";
    if ($orderBy == "fechaCreacion")
        $auxOrder = " c.fechaCreacion " . $orderAscDesc . " ";
    else if ($orderBy == "titulo")
        $auxOrder = " c.titulo " . $orderAscDesc . " ";

    $stmt = $conex->prepare("Select c.idCurso, c.descripcionCorta, c.titulo, c.uniqueUrl, c.publicado, c.precio, c.imagen, c.fechaCreacion, count(distinct uc.idUsuario) as numAlumnos, count(distinct cl.idClase) as numClases
                            From curso c
                            INNER JOIN usuario u ON c.idUsuario = u.idUsuario
                            LEFT OUTER JOIN tema t ON c.idCurso = t.idCurso
                            LEFT OUTER JOIN clase cl ON t.idTema = cl.idTema
                            LEFT OUTER JOIN usuariocurso uc ON c.idCurso = uc.idCurso
                            where u.idUsuario = :idUsuario and c.publicado = 1
                            group by c.idCurso
                            order by $auxOrder");
    $stmt->bindParam(':idUsuario', $idUsuario);

    if ($stmt->execute()) {
        $cursos = null;
        $curso = null;
        $rows = $stmt->fetchAll();
        $i = 0;
        foreach ($rows as $row) {
            $curso = new Curso();
            $curso->idCurso = $row['idCurso'];
            $curso->titulo = $row['titulo'];
            $curso->publicado = $row['publicado'];
            $curso->precio = $row['precio'];
            $curso->imagen = $row['imagen'];
            $curso->fechaCreacion = $row['fechaCreacion'];
            $curso->numeroDeAlumnos = $row['numAlumnos'];
            $curso->numeroDeClases = $row['numClases'];
            $curso->descripcionCorta = $row['descripcionCorta'];
            $curso->uniqueUrl = $row['uniqueUrl'];
            $cursos[$i] = $curso;
            $i++;
        }
        return $cursos;
    } else {
        return null;
    }
}

function esUsuarioUnAlumnoDelCurso($idUsuario, $idCurso) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("SELECT idUsuario 
                             FROM usuariocurso
                             WHERE idUsuario = :idUsuario AND idCurso = :idCurso");
    $stmt->bindParam(':idUsuario', $idUsuario);
    $stmt->bindParam(':idCurso', $idCurso);


    $stmt->execute();
    $rows = $stmt->fetchAll();
    if (sizeof($rows) > 0)
        return true;
    else
        return false;
}

function getNumeroCursosCreados($idUsuario) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("SELECT COUNT(*) as cuenta 
                             FROM curso
                             WHERE idUsuario = :idUsuario");
    $stmt->bindParam(':idUsuario', $idUsuario);

    $n = 0;
    if ($stmt->execute()) {
        $row = $stmt->fetch();
        $n = $row['cuenta'];
    }
    return $n;
}

function getNumeroCursosTomados($idUsuario) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("SELECT COUNT(*) as cuenta 
                             FROM usuariocurso
                             WHERE idUsuario = :idUsuario");
    $stmt->bindParam(':idUsuario', $idUsuario);

    $n = 0;
    if ($stmt->execute()) {
        $row = $stmt->fetch();
        $n = $row['cuenta'];
    }
    return $n;
}

function inscribirUsuarioCurso($idUsuario, $idCurso) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("INSERT INTO usuariocurso (idUsuario, idCurso, fechaInscripcion)
                            VALUES(:idUsuario, :idCurso, NOW()) ");
    $stmt->bindParam(':idUsuario', $idUsuario);
    $stmt->bindParam(':idCurso', $idCurso);

    return $stmt->execute();
}

function getRatingUsuario($idUsuario, $idCurso) {
    require_once 'bd/conex.php';
    global $conex;

    $stmt = $conex->prepare("SELECT rating
                             FROM usuariocurso
                             WHERE idUsuario = :idUsuario AND idCurso = :idCurso");
    $stmt->bindParam(':idUsuario', $idUsuario);
    $stmt->bindParam(':idCurso', $idCurso);
    $n = 0;
    if ($stmt->execute()) {
        $row = $stmt->fetch();
        $n = $row['rating'];
    }
    return $n;
}

function setRatingUsuario($idUsuario, $idCurso, $rating) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("UPDATE usuariocurso 
                            SET rating = :rating
                            WHERE idUsuario = :idUsuario AND idCurso = :idCurso");
    $stmt->bindParam(':rating', $rating);
    $stmt->bindParam(':idUsuario', $idUsuario);
    $stmt->bindParam(':idCurso', $idCurso);

    $stmt->execute();

    $stmt = $conex->prepare("SELECT count(rating) as cuenta, sum(rating) as suma
                            FROM usuariocurso
                            WHERE idUsuario = :idUsuario AND idCurso = :idCurso");
    $stmt->bindParam(':idUsuario', $idUsuario);
    $stmt->bindParam(':idCurso', $idCurso);
    $stmt->execute();

    $row = $stmt->fetch();
    $n = $row['cuenta'];
    $sum = $row['suma'];
    $prom = $sum / $n;

    $stmt = $conex->prepare("UPDATE curso 
                            SET rating = :rating
                            WHERE idCurso = :idCurso");
    $stmt->bindParam(':rating', $prom);
    $stmt->bindParam(':idCurso', $idCurso);

    return $stmt->execute();
}

function getNumeroDeNuevosAlumnos($idUsuario, $dias) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("SELECT COUNT(uc.idUsuario) AS cuenta
                             FROM usuario u, curso c, usuariocurso uc
                             WHERE u.idUsuario = c.idUsuario AND c.idCurso = uc.idCurso
                             AND u.idUsuario = :idUsuario
                             AND fechaInscripcion >= DATE_SUB(NOW(), INTERVAL $dias DAY)");
    $stmt->bindParam(':idUsuario', $idUsuario);
    $cuenta = 0;
    if ($stmt->execute()) {
        $row = $stmt->fetch();
        $cuenta = $row['cuenta'];
    }
    return $cuenta;
}

function getNumeroDePreguntasSinResponder($idUsuario) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("SELECT COUNT(p.idPregunta) AS cuenta
                             FROM usuario u, curso c, pregunta p
                             WHERE u.idUsuario = c.idUsuario AND c.idCurso = p.idCurso
                             AND u.idUsuario = :idUsuario
                             AND respuesta IS NULL");
    $stmt->bindParam(':idUsuario', $idUsuario);
    $cuenta = 0;
    if ($stmt->execute()) {
        $row = $stmt->fetch();
        $cuenta = $row['cuenta'];
    }
    return $cuenta;
}

function getPreguntasSinResponder($idUsuario) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("SELECT c.idCurso, c.titulo, c.uniqueUrl, c.imagen, p.idPregunta, p.idUsuario, p.pregunta, p.fecha, uc.nombreUsuario, uc.avatar, uc.uniqueUrl as uniqueUrlUsuario
                            FROM pregunta p	
                            INNER JOIN curso c ON p.idCurso = c.idCurso
                            INNER JOIN usuario u ON c.idUsuario = u.idUsuario
                            INNER JOIN usuario uc ON p.idUsuario = uc.idUsuario
                            WHERE u.idUsuario = :idUsuario
                            AND respuesta IS NULL
                            ORDER BY c.uniqueUrl DESC");
    $stmt->bindParam(':idUsuario', $idUsuario);

    if ($stmt->execute()) {
        require_once 'modulos/cursos/clases/Pregunta.php';
        $preguntas = null;
        $pregunta = null;
        $rows = $stmt->fetchAll();
        $i = 0;
        foreach ($rows as $row) {
            $pregunta = new Pregunta();

            $pregunta->idPregunta = $row['idPregunta'];
            $pregunta->idCurso = $row['idCurso'];
            $pregunta->idUsuario = $row['idUsuario'];
            $pregunta->pregunta = $row['pregunta'];
            $pregunta->fecha = $row['fecha'];
            $pregunta->nombreUsuario = $row['nombreUsuario'];
            $pregunta->avatar = $row['avatar'];
            $pregunta->uniqueUrlUsuario = $row['uniqueUrlUsuario'];
            $pregunta->titulo = $row['titulo'];
            $pregunta->uniqueUrl = $row['uniqueUrl'];
            $pregunta->imagen = $row['imagen'];

            $preguntas[$i] = $pregunta;
            $i++;
        }
        return $preguntas;
    } else {
        //print_r($stmt->errorInfo());
        return null;
    }
}

?>
