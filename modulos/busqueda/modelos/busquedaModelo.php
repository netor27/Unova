<?php

function busquedaCurso($busqueda, $offset, $numRows) {
    require_once 'bd/conexRead.php';
    global $conex;
    $stmt = $conex->prepare("SELECT SQL_CALC_FOUND_ROWS c.idCurso, c.idUsuario, c.idSubcategoria, c.titulo, c.uniqueUrl, c.precio, c.imagen, u.nombreUsuario, u.uniqueUrl as uniqueUrlUsuario,
                                count(distinct cl.idClase) as numClases, count(distinct uc.idUsuario) as numAlumnos, 
                                c.keywords, c.descripcionCorta, MATCH (cb.titulo, cb.keywords, cb.descripcionCorta) AGAINST (:busqueda) as puntuacion
                            FROM curso c
                            INNER JOIN cursobusqueda cb ON c.idCurso = cb.idCurso
                            LEFT OUTER JOIN tema t ON c.idCurso = t.idCurso
                            LEFT OUTER JOIN clase cl ON t.idTema = cl.idTema
                            LEFT OUTER JOIN usuariocurso uc ON c.idCurso = uc.idCurso
                            LEFT OUTER JOIN usuario u ON c.idUsuario = u.idUsuario
                            WHERE c.publicado = 1 AND 
                                MATCH (cb.titulo, cb.keywords, cb.descripcionCorta) AGAINST (:busqueda WITH QUERY EXPANSION)
                            GROUP BY c.idCurso
                            ORDER BY puntuacion DESC
                            LIMIT $offset, $numRows");

    $stmt->bindParam(':busqueda', $busqueda);
    if(!$stmt->execute())
        print_r ($stmt->errorInfo());
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

?>