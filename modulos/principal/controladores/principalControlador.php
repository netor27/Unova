<?php

//require_once '';
function principal() {
    require_once 'modulos/categorias/modelos/categoriaModelo.php';
    $categorias = getCategorias();
    require_once 'modulos/cursos/modelos/CursoModelo.php';
    $array = getCursosFuncion();
    $numCursos = $array['n'];
    $cursos = $array['cursos'];

    //checamos que no tenga preguntas sin responder
    $usuario = getUsuarioActual();
    if (isset($usuario)) {
        $aleatorio = rand(0, 100);
        $numPreguntas = 0;
        if ($aleatorio > 80) {
            require_once 'modulos/usuarios/modelos/UsuarioCursosModelo.php';
            $numPreguntas = getNumeroDePreguntasSinResponder($usuario->idUsuario);
        }
    }

    require_once('modulos/principal/vistas/principal.php');
}

?>