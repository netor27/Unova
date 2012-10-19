<?php

require_once 'modulos/categorias/clases/Categoria.php';

function altaCategoria($categoria) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("INSERT INTO categoria (nombre, urlNombre) values(:nombre, :urlNombre)");
    $stmt->bindParam(':nombre', $categoria->nombre);
    $stmt->bindParam(':urlNombre', $categoria->urlNombre);
    $id = -1;
    if ($stmt->execute())
        $id = $conex->lastInsertId();
    return $id;
}

function bajaCategoria($idCategoria) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("DELETE FROM categoria WHERE idCategoria = :id");
    $stmt->bindParam(':id', $idCategoria);
    return $stmt->execute();
}

function actualizaCategoria($categoria) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("UPDATE categoria SET nombre = :nombre, urlNombre = :urlNombre WHERE idCategoria = :id");
    $stmt->bindParam(':nombre', $categoria->nombre);
    $stmt->bindParam(':urlNombre', $categoria->urlNombre);
    $stmt->bindParam(':id', $categoria->idCategoria);
    return $stmt->execute();
}

function getCategorias() {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->query("SELECT * FROM categoria ORDER BY nombre");
    $arreglo = null;
    $categoria = null;
    $i = 0;
    foreach ($stmt as $res) {
        $categoria = new Categoria();
        $categoria->idCategoria = $res['idCategoria'];
        $categoria->nombre = $res['nombre'];
        $categoria->urlNombre = $res['urlNombre'];
        $arreglo[$i] = $categoria;
        $i++;
    }
    return $arreglo;
}

function getCategoria($idCategoria) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("SELECT * FROM categoria where idCategoria = :id");
    $stmt->bindParam(':id', $idCategoria);
    $stmt->execute();
    $categoria = NULL;
    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch();
        $categoria = new Categoria();
        $categoria->idCategoria = $row['idCategoria'];
        $categoria->nombre = $row['nombre'];
        $categoria->urlNombre = $row['urlNombre'];
    }
    return $categoria;
}

function getCategoriaPorUniqueUrl($uniqueUrl) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("SELECT * FROM categoria where urlNombre = :id");
    $stmt->bindParam(':id', $uniqueUrl);
    $stmt->execute();
    $categoria = NULL;
    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch();
        $categoria = new Categoria();
        $categoria->idCategoria = $row['idCategoria'];
        $categoria->nombre = $row['nombre'];
        $categoria->urlNombre = $row['urlNombre'];
    }
    return $categoria;
}

function getCursosPorCategoria($idCategoria, $offset, $numRows) {    
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("SELECT SQL_CALC_FOUND_ROWS c.idCurso, c.idUsuario, c.idSubcategoria, c.titulo, c.uniqueUrl, c.precio, c.imagen, u.nombreUsuario, u.uniqueUrl as uniqueUrlUsuario,
                                count(distinct cl.idClase) as numClases, count(distinct uc.idUsuario) as numAlumnos, 
                                c.keywords, c.descripcionCorta
                            FROM curso c
                            INNER JOIN cursobusqueda cb ON c.idCurso = cb.idCurso
                            INNER JOIN subcategoria s ON c.idSubcategoria = s.idSubcategoria
                            LEFT OUTER JOIN tema t ON c.idCurso = t.idCurso
                            LEFT OUTER JOIN clase cl ON t.idTema = cl.idTema
                            LEFT OUTER JOIN usuariocurso uc ON c.idCurso = uc.idCurso
                            LEFT OUTER JOIN usuario u ON c.idUsuario = u.idUsuario
                            WHERE c.publicado = 1 AND s.idCategoria = :idCategoria
                            GROUP BY c.idCurso
                            ORDER BY numAlumnos DESC
                            LIMIT $offset, $numRows");
    $stmt->bindParam(':idCategoria', $idCategoria);
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