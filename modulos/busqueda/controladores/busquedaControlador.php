<?php

function principal() {
    if (isset($_GET['q'])) {
        $busqueda = removeBadHtmlTags($_GET['q']);
        require_once 'modulos/busqueda/modelos/busquedaModelo.php';
        $offset = 0;
        $numRows = 10;
        $pagina = 1;
        if (isset($_GET['pagina'])) {
            $pagina = $_GET['pagina'];
            if (is_numeric($pagina) && $pagina > 0) {
                $offset = ($pagina - 1) * $numRows;
            }
        }
        $array = busquedaCurso($busqueda, $offset, $numRows);
        $numCursos = $array["n"];
        $numPaginas = intval(ceil($numCursos / $numRows));
        $cursos = $array["cursos"];
        require_once 'modulos/busqueda/vistas/resultadosDeBusqueda.php';
    }
}

?>