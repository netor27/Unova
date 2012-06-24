<?php

require_once 'modulos/categorias/clases/Subcategoria.php';

function altaSubcategoria($subcategoria) {
    require_once 'bd/conexWrite.php';
    global $conex;
    $stmt = $conex->prepare("INSERT INTO subcategoria (idCategoria, nombre) values(:idCategoria, :nombre)");
    $stmt->bindParam(':idCategoria', $subcategoria->idCategoria);
    $stmt->bindParam(':nombre', $subcategoria->nombre);
    $id = -1;
    $val = $stmt->execute();
    if ($val)
        $id = $conex->lastInsertId();
    return $id;
}

function bajaSubcategoria($idSubcategoria) {
    require_once 'bd/conexWrite.php';
    global $conex;
    $stmt = $conex->prepare("DELETE FROM subcategoria WHERE idSubcategoria = :id");
    $stmt->bindParam(':id', $idSubcategoria);
    $stmt->execute();
    return $stmt->rowCount();
}

function actualizaSubcategoria($subcategoria) {
    require_once 'bd/conexWrite.php';
    global $conex;
    $stmt = $conex->prepare("UPDATE subcategoria SET nombre = :nombre WHERE idSubcategoria = :id");
    $stmt->bindParam(':nombre', $subcategoria->nombre);
    $stmt->bindParam(':id', $subcategoria->idSubcategoria);
    return $stmt->execute();
}

function getSubcategoriasDeCategoria($idCategoria) {
    require_once 'bd/conexRead.php';
    global $conex;
    $stmt = $conex->prepare("SELECT * FROM subcategoria where idCategoria = :id ORDER BY nombre");
    $stmt->bindParam(':id', $idCategoria);
    $stmt->execute();
    $rows = $stmt->fetchAll();
    $subcategorias = null;
    $subcategoria = null;
    $i = 0;
    
    foreach ($rows as $row) {
        $subcategoria = new Subcategoria();
        $subcategoria->idSubcategoria = $row['idSubcategoria'];
        $subcategoria->idCategoria = $row['idCategoria'];
        $subcategoria->nombre = $row['nombre'];

        $subcategorias[$i] = $subcategoria;
        $i++;
    }
    return $subcategorias;
}

function getSubcategoria($idSubcategoria) {
    require_once 'bd/conexRead.php';
    global $conex;
    $stmt = $conex->prepare("SELECT * FROM subcategoria where idSubcategoria = :id");
    $stmt->bindParam(':id', $idSubcategoria);
    $stmt->execute();
    $subcategoria = NULL;
    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch();
        $subcategoria = new Subcategoria();
        $subcategoria->idSubcategoria = $row['idSubcategoria'];
        $subcategoria->idCategoria = $row['idCategoria'];
        $subcategoria->nombre = $row['nombre'];
    }
    return $subcategoria;
}

function getCategoriaPerteneciente($idSubcategoria) {
    require_once 'bd/conexRead.php';
    require_once 'modulos/categorias/clases/Categoria.php';
    global $conex;
    $stmt = $conex->prepare("SELECT c.idCategoria, c.nombre, c.urlNombre
                             FROM subcategoria s, categoria c
                             WHERE s.idCategoria = c.idCategoria AND s.idSubcategoria = :idSubcategoria");
    $stmt->bindParam(":idSubcategoria", $idSubcategoria);
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

?>
