<?php

require_once 'modulos/categorias/modelos/subcategoriaModelo.php';

function subcategorias() {
    if (isset($_GET['i'])) {
        $idCategoria = removeBadHtmlTags($_GET['i']);
        $subcategorias = getSubcategoriasDeCategoria($idCategoria);
        echo json_encode($subcategorias);
    }
}

function detalles() {
    if (isset($_GET['i'])) {
        $categoriaUrl = removeBadHtmlTags($_GET['i']);
        require_once 'modulos/categorias/modelos/categoriaModelo.php';
        $offset = 0;
        $numRows = 10;
        $pagina = 1;
        if (isset($_GET['pagina'])) {
            $pagina = $_GET['pagina'];
            if (is_numeric($pagina) && $pagina > 0) {
                $offset = ($pagina - 1) * $numRows;
            }
        }
        $categoria = getCategoriaPorUniqueUrl($categoriaUrl);
        if ($categoria != null) {
            $array = getCursosPorCategoria($categoria->idCategoria, $offset, $numRows);
            $numCursos = $array["n"];
            $numPaginas = intval(ceil($numCursos / $numRows));
            $cursos = $array["cursos"];
            require_once 'modulos/categorias/vistas/CursosCategoria.php';
        } else {
            setSessionMessage("<h4 class='error'>Categoría inexistente</h4>");
            goToIndex();
        }
    }
}

?>