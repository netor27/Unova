<?php

//require_once '';
function principal()
{    
    require_once 'modulos/categorias/modelos/categoriaModelo.php';
    $categorias = getCategorias();
    require_once 'modulos/cursos/modelos/CursoModelo.php';
    $array = getCursosFuncion();
    $numCursos = $array['n'];
    $cursos = $array['cursos'];
    require_once('modulos/principal/vistas/principal.php');
}

?>